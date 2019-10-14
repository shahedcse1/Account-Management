<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplierimport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
        $this->load->library('excel');
        $this->load->helper('common_helper');
    }

    public function index() {
        $data['title'] = "Supplier Excel Import";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "supplier";
        $data['baseurl'] = $this->config->item('base_url');
        //query data to view into table
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('supplier/supplierimport', $data);
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
            $supplierdata = array();
            if ($inputFileType == 'xlsx' || $inputFileType == 'xls'):
                move_uploaded_file($temp_name, $target_dir);
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($target_dir);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($target_dir);
                    $file_found = 1;
                } catch (Exception $e) {
                    $logdetails = " Error loading file";
                    ccflogdata($this->sessiondata['username'], "accesslog", "supplier", $logdetails);
                    $this->session->set_userdata('failed', 'Error loading file ' . $e->getMessage());
                    redirect('supplier/supplierimport');
                }
                if ($file_found == 1):
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++):
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $supplierdata[$row - 2]['acno'] = $rowData[0][0];
                        $supplierdata[$row - 2]['sname'] = $rowData[0][1];
                        $supplierdata[$row - 2]['business'] = $rowData[0][2];
                        $supplierdata[$row - 2]['address'] = $rowData[0][3];
                        $supplierdata[$row - 2]['country'] = $rowData[0][4];
                        $supplierdata[$row - 2]['mobile'] = $rowData[0][5];
                        $supplierdata[$row - 2]['opnbal'] = $rowData[0][6];
                        $supplierdata[$row - 2]['debitorcredit'] = $rowData[0][7];
                        $supplierdata[$row - 2]['description'] = $rowData[0][8];
                        $supplierdata[$row - 2]['status'] = $rowData[0][9];
                    endfor;
                    if (sizeof($supplierdata) > 0):
                        for ($i = 0; $i < sizeof($supplierdata); $i++):
                            $data1 = array(
                                'accNo' => $supplierdata[$i]['acno'],
                                'acccountLedgerName' => $supplierdata[$i]['sname'],
                                'accountGroupId' => '27',
                                'openingBalance' => $supplierdata[$i]['opnbal'],
                                'debitOrCredit' => $supplierdata[$i]['debitorcredit'],
                                'defaultOrNot' => '0',
                                'billByBill' => '1',
                                'description' => $customerdata[$i]['description'],
                                'address' => $customerdata[$i]['address'],
                                'nameOfBusiness' => $customerdata[$i]['business'],
                                'emailId' => "",
                                'mobileNo' => $customerdata[$i]['mobile'],
                                'companyId' => $this->sessiondata['companyid'],
                                'status' => $supplierdata[$i]['status']
                            );

                            $saveresult = $this->db->insert('accountledger', $data1);
                            $insert_id = $this->db->insert_id();
                            $this->db->trans_complete();
                            if ($supplierdata[$i]['debitorcredit'] == 0):
                                $credit = $supplierdata[$i]['opnbal'];
                                $debit = 0.00;
                            else:
                                $debit = $supplierdata[$i]['opnbal'];
                                $credit = 0.00;
                            endif;
                            $mindate = $this->sessiondata['mindate'];
                            $newmindate = strtotime($mindate);
                            $minModifiedDate = strtotime("-1 day", $newmindate);
                            $finalModifiedDate = date("Y-m-d H:i:s", $minModifiedDate);
                            $dataforledgerposting = array(
                                'voucherNumber' => $insert_id,
                                'ledgerId' => $insert_id,
                                'voucherType' => 'Opening Balance',
                                'debit' => $debit,
                                'credit' => $credit,
                                'description' => '',
                                'date' => $finalModifiedDate,
                                'companyID' => $this->sessiondata['companyid']
                            );
                            ccflogdata($this->sessiondata['username'], "accesslog", "supplier", "Supplier: " . $supplierdata[$i]['sname'] . " Added");
                            $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerposting);
                            $supplier_name = $supplierdata[$i]['sname'];
                            $query = $this->db->query("SELECT ledgerId FROM accountledger WHERE acccountLedgerName = '$supplier_name'");
                            $ledgerId = $query->row()->ledgerId;
                            $data2 = array(
                                'vendorName' => $supplierdata[$i]['sname'],
                                'address' => $supplierdata[$i]['address'],
                                'country' => $supplierdata[$i]['country'],
                                'nameOfBusiness' => $supplierdata[$i]['business'],
                                'emailId' => '',
                                'mobileNumber' => $supplierdata[$i]['mobile'],
                                'description' => $supplierdata[$i]['description'],
                                'ledgerId' => $ledgerId,
                                'companyId' => $this->sessiondata['companyid']
                            );
                            $saveresult = $this->db->insert('vendor', $data2);

                        endfor;
                        $logdetails = " Data load and save successfully.";
                        ccflogdata($this->sessiondata['username'], "accesslog", "supplier add", $logdetails);
                        $this->session->set_userdata('successfull', 'Data imported successfully.');
                        redirect('supplier/supplierimport');
                    else:
                        $logdetails = " No data found in excel file to save.";
                        ccflogdata($this->sessiondata['username'], "accesslog", "supplier add", $logdetails);
                        $this->session->set_userdata('failed', 'No data found in excel file to save..');
                        redirect('supplier/supplierimport');
                    endif;
                else:
                    $logdetails = " Problem of reading excel data";
                    ccflogdata($this->sessiondata['username'], "accesslog", "supplier", $logdetails);
                    $this->session->set_userdata('failed', 'There is a problem of reading excel data. Try again!');
                    redirect('supplier/supplierimport');
                endif;
            else:
                $logdetails = " This type of file is not acceptable to import";
                ccflogdata($this->sessiondata['username'], "accesslog", "supplier", $logdetails);
                $this->session->set_userdata('failed', 'This type of file is not acceptable to import. Try another type.');
                redirect('supplier/supplierimport');
            endif;
        else:
            redirect('login');
        endif;
    }

}
