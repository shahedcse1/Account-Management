<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stockentryimport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('excel');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['title'] = "Stock Entry Excel Import";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "stockentry";
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('stockentry/stockentryimport', $data);
            $this->load->view('footer', $data);
        else:
            redirect('login');
        endif;
    }

    public function importdatadb() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $inputFileName = $_FILES['data_import']['name'];
            $temp_name = $_FILES["data_import"]["tmp_name"];
            $inputFileType = pathinfo($inputFileName, PATHINFO_EXTENSION);
            $target_dir = "assets/uploads/temp_excel_file/" . $inputFileName;
            $file_found = 0;
            $stockdata = array();
            if ($inputFileType == 'xlsx' || $inputFileType == 'xls'):
                move_uploaded_file($temp_name, $target_dir);
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($target_dir);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($target_dir);
                    $file_found = 1;
                } catch (Exception $e) {
                    $logdetails = " Error loading file";
                    ccflogdata($this->sessiondata['username'], "accesslog", "stock entry", $logdetails);
                    $this->session->set_userdata('failed', 'Error loading file ' . $e->getMessage());
                    redirect('stockentry/stockentryimport');
                }
                if ($file_found == 1):
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++):
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $stockdata[$row - 2]['date'] = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][0], "Y-m-d");  //First col of excel data (acno)
                        $stockdata[$row - 2]['description'] = $rowData[0][1];
                        $stockdata[$row - 2]['pname'] = $rowData[0][2];
                        $stockdata[$row - 2]['purchaserate'] = $rowData[0][3];
                        $stockdata[$row - 2]['salerate'] = $rowData[0][4];
                        $stockdata[$row - 2]['quantity'] = $rowData[0][5];
                        $stockdata[$row - 2]['unit'] = $rowData[0][6];
                    endfor;
                    if (sizeof($stockdata) > 0):
                        $data1 = array(
                            'date' => $stockdata[0]['date'],
                            'description' => $stockdata[0]['description'],
                            'companyId' => $this->sessiondata['companyid']
                        );
                        $this->db->insert('stockmaster', $data1);
                        $query1 = $this->db->query("SELECT MAX(stockMasterId) FROM stockmaster");
                        $row1 = $query1->row_array();
                        $stockMasterId = $row1['MAX(stockMasterId)'];
                        for ($i = 0; $i < sizeof($stockdata); $i++):
                            $product_name = $stockdata[$i]['pname'];
                            $data5 = array(
                                'batchName' => "NA",
                                'expiryDate' => "1753-01-01 00:00:00.000",
                                'MRP' => 0,
                                'companyId' => $this->sessiondata['companyid'],
                                'purchaseRate' => $stockdata[$i]['purchaserate'],
                                'salesRate' => $stockdata[$i]['salerate']
                            );
                            $salerate = $stockdata[$i]['salerate'];
                            if (!empty($salerate) || $salerate != 0) {
                                $this->db->where('productId', $product_name);
                                $this->db->update('productbatch', $data5);
                            }
                            $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
                            $row2 = $query2->row_array();
                            $productBatchId = $row2['productBatchId'];
                            $productBatchIdall[] = $productBatchId;
                        endfor;
                        //===================2nd tbl stockdetails
                        for ($i = 0; $i < sizeof($stockdata); $i++) {
                            $data2 = array(
                                'stockMasterId' => $stockMasterId,
                                'productBatchId' => $productBatchIdall[$i],
                                'rate' => $stockdata[$i]['purchaserate'],
                                'qty' => $stockdata[$i]['quantity'],
                                'companyId' => $this->sessiondata['companyid']
                            );
                            $this->db->insert('stockdetails', $data2);
                        }
                        //==================4th table stockposting
                        for ($i = 0; $i < sizeof($stockdata); $i++) {
                            $this->sessiondata = $this->session->userdata('logindata');
                            $data = $this->sessiondata['mindate'];
                            $before_date = date('Y-m-d H:i:s', strtotime($data . ' - 1 day'));
                            $data4 = array(
                                'voucherNumber' => $stockMasterId,
                                'productBatchId' => $productBatchIdall[$i],
                                'inwardQuantity' => $stockdata[$i]['quantity'],
                                'outwardQuantity' => 0,
                                'voucherType' => "Stock Entry",
                                'date' => $before_date,
                                'unitId' => $stockdata[$i]['unit'],
                                'rate' => $stockdata[$i]['salerate'],
                                'defaultInwardQuantity' => $stockdata[$i]['quantity'],
                                'defaultOutwardQuantity' => 0,
                                'companyId' => $this->sessiondata['companyid']
                            );
                            $this->db->insert('stockposting', $data4);
                        }
                        $logdetails = " Data load and save successfully.";
                        ccflogdata($this->sessiondata['username'], "accesslog", "stock entry", $logdetails);
                        $this->session->set_userdata('successfull', 'Data imported successfully.');
                        redirect('stockentry/stockentryimport');
                    else:
                        $logdetails = " No data found in excel file to save.";
                        ccflogdata($this->sessiondata['username'], "accesslog", "stock entry", $logdetails);
                        $this->session->set_userdata('failed', 'No data found in excel file to save..');
                        redirect('stockentry/stockentryimport');
                    endif;
                else:
                    $logdetails = " Problem of reading excel data";
                    ccflogdata($this->sessiondata['username'], "accesslog", "stock entry", $logdetails);
                    $this->session->set_userdata('failed', 'There is a problem of reading excel data. Try again!');
                    redirect('stockentry/stockentryimport');
                endif;
            else:
                $logdetails = " This type of file is not acceptable to import";
                ccflogdata($this->sessiondata['username'], "accesslog", "stock entry", $logdetails);
                $this->session->set_userdata('failed', 'This type of file is not acceptable to import. Try another type.');
                redirect('stockentry/stockentryimport');
            endif;
        else:
            redirect('login');
        endif;
    }

}
