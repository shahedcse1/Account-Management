<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customerimport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('excel');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['title'] = "Customer Excel Import";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "customer";
        $data['baseurl'] = $this->config->item('base_url');
        //query data to view into table
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('customer/customerimport', $data);
            $this->load->view('footer', $data);
            $this->load->view('customer/script', $data);
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
            $customerdata = array();
            if ($inputFileType == 'xlsx' || $inputFileType == 'xls'):
                move_uploaded_file($temp_name, $target_dir);
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($target_dir);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($target_dir);
                    $file_found = 1;
                } catch (Exception $e) {
                    $logdetails = " Error loading file";
                    ccflogdata($this->sessiondata['username'], "accesslog", "customer", $logdetails);
                    $this->session->set_userdata('failed', 'Error loading file ' . $e->getMessage());
                    redirect('customer/customerimport');
                }
                if ($file_found == 1):
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++):
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $customerdata[$row - 2]['acno'] = $rowData[0][0];  //First col of excel data (acno)
                        $customerdata[$row - 2]['cname'] = $rowData[0][1];
                        $customerdata[$row - 2]['lname'] = $rowData[0][2];
                        $customerdata[$row - 2]['password'] = $rowData[0][3];
                        $customerdata[$row - 2]['business'] = $rowData[0][4];
                        $customerdata[$row - 2]['address'] = $rowData[0][5];
                        $customerdata[$row - 2]['mobile'] = $rowData[0][6];
                        $customerdata[$row - 2]['gender'] = $rowData[0][7];
                        $customerdata[$row - 2]['birthdate'] = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][8], "Y-m-d");
                        $customerdata[$row - 2]['opnbal'] = $rowData[0][9];
                        $customerdata[$row - 2]['debitorcredit'] = $rowData[0][10];
                        $customerdata[$row - 2]['description'] = $rowData[0][11];
                        $customerdata[$row - 2]['status'] = $rowData[0][12];
                    endfor;
                    if (sizeof($customerdata) > 0):
                        for ($i = 0; $i < sizeof($customerdata); $i++):
                            $logindata = array(
                                'username' => $customerdata[$i]['lname'],
                                'password' => $customerdata[$i]['password'],
                                'activeOrNot' => 1,
                                'description' => $customerdata[$i]['description'],
                                'companyId' => $this->sessiondata['companyid'],
                                'role' => "u"
                            );
                            $salesManLoginInfo = $this->db->insert('user', $logindata);
                            $insert_id = $this->db->insert_id();
                            $this->db->trans_complete();
                            $data = array(
                                'accNo' => $customerdata[$i]['acno'],
                                'acccountLedgerName' => $customerdata[$i]['lname'],
                                'accountGroupId' => '28',
                                'openingBalance' => $customerdata[$i]['opnbal'],
                                'debitOrCredit' => $customerdata[$i]['debitorcredit'],
                                'description' => $customerdata[$i]['description'],
                                'address' => $customerdata[$i]['address'],
                                'nameOfBusiness' => $customerdata[$i]['business'],
                                'emailId' => "",
                                'mobileNo' => $customerdata[$i]['mobile'],
                                'gender' => $customerdata[$i]['gender'],
                                'dateofbirth' => $customerdata[$i]['birthdate'],
                                'defaultOrNot' => '0',
                                'billByBill' => '1',
                                'fax' => $customerdata[$i]['lname'],
                                'tin' => $customerdata[$i]['password'],
                                'cst' => $insert_id,
                                'companyId' => $this->sessiondata['companyid'],
                                'status' => $customerdata[$i]['status'],
                            );
                            $saveresult = $this->db->insert('accountledger', $data);
                            $insert_id = $this->db->insert_id();
                            $this->db->trans_complete();
                            if ($customerdata[$i]['debitorcredit'] == 0):
                                $credit = $customerdata[$i]['opnbal'];
                                $debit = 0.00;
                            else:
                                $debit = $customerdata[$i]['opnbal'];
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
                            ccflogdata($this->sessiondata['username'], "accesslog", "customer", "Customer: " . $customerdata[$i]['lname'] . " Added");
                            $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerposting);
                        endfor;
                        $logdetails = " Data load and save successfully.";
                        ccflogdata($this->sessiondata['username'], "accesslog", "customer add", $logdetails);
                        $this->session->set_userdata('successfull', 'Data imported successfully.');
                        redirect('customer/customerimport');
                    else:
                        $logdetails = " No data found in excel file to save.";
                        ccflogdata($this->sessiondata['username'], "accesslog", "customer add", $logdetails);
                        $this->session->set_userdata('failed', 'No data found in excel file to save..');
                        redirect('customer/customerimport');
                    endif;
                else:
                    $logdetails = " Problem of reading excel data";
                    ccflogdata($this->sessiondata['username'], "accesslog", "customer", $logdetails);
                    $this->session->set_userdata('failed', 'There is a problem of reading excel data. Try again!');
                    redirect('customer/customerimport');
                endif;
            else:
                $logdetails = " This type of file is not acceptable to import";
                ccflogdata($this->sessiondata['username'], "accesslog", "customer", $logdetails);
                $this->session->set_userdata('failed', 'This type of file is not acceptable to import. Try another type.');
                redirect('customer/customerimport');
            endif;
        else:
            redirect('login');
        endif;
    }

}
