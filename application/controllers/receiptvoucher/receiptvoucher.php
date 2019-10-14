<?php

if (!defined('BASEPATH'))
    exit('No direct Script access allowed');

class Receiptvoucher extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
        $this->load->model('ccfreceiptvou');
        $this->load->model('ccfpaymentvou');
        if ($this->sessiondata['status'] == 'login'):
            $accessFlag = 1;
        else:
            $accessFlag = 0;
            redirect('home');
        endif;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Receipt Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "receiptvoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['countries'] = $this->ccfreceiptvou->countrylist();
            $data['ledger'] = $this->ccfreceiptvou->ledgerdata();
            $data['sortalldata'] = $this->ccfreceiptvou->sortalldata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('receiptvoucher/receiptvoucherfirst', $data);
            $this->load->view('footer', $data);
            $this->load->view('receiptvoucher/script', $data);
        else:
            redirect('home');
        endif;
    }

    public function addreceiptvoucher() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Receipt Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "receiptvoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['countries'] = $this->ccfreceiptvou->countrylist();
            $data['ledger'] = $this->ccfreceiptvou->ledgerdata();
            $data['sortalldata'] = $this->ccfreceiptvou->sortalldata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('receiptvoucher/receiptvoucher', $data);
            $this->load->view('footer', $data);
            $this->load->view('receiptvoucher/script', $data);
        else:
            redirect('home');
        endif;
    }

    public function editreceiptvoucher() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Receipt Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "receiptvoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['countries'] = $this->ccfreceiptvou->countrylist();
            $data['ledger'] = $this->ccfreceiptvou->ledgerdata();
            $data['ledgerdata'] = $this->ccfreceiptvou->getledger();
            $data['ledgerdatabycash'] = $this->ccfreceiptvou->getledgerbycash();
            $id = $this->uri->segment(4);
            $query = $this->db->query("Select * from receiptmaster where receiptMasterId='$id'");
            $IdAvailable = $query->row()->receiptMasterId;
            if ($IdAvailable == "") {
                redirect('receiptvoucher/receiptvoucher');
            } else {
                $data['alldata'] = $this->ccfreceiptvou->alldata($id);
                $data['paidtoname'] = $this->ccfreceiptvou->editpaidtoname($id);
                $temp = $data['paidtoname'];
                foreach ($temp as $value) {
                    $data['paymsid'] = $value->receiptMasterId;
                    $data['paidid'] = $value->ledgerId;
                    $data['receiptNo'] = $value->receiptNo;
                    $data['amount'] = $value->amount;
                    $data['chequeNumber'] = $value->chequeNumber;
                    $data['chequeDate'] = $value->chequeDate;
                }
                $data['currentbalance'] = $this->ccfreceiptvou->currentbalance($data['paidid']);
                //$data['preferenceType'] = $this->ccfreceiptvou->getpartydata($id, $data['paidid']);
                $this->load->view('header', $data);
                $this->load->view('sidebar', $data);
                $this->load->view('receiptvoucher/editreceiptvoucher', $data);
                $this->load->view('footer', $data);
                $this->load->view('receiptvoucher/script', $data);
            }
        else:
            redirect('home');
        endif;
    }

    public function getledger() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] != 's' || $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $value = $this->input->post('value');
            if ($value == "By Cheque") {
                $data = $this->ccfpaymentvou->getledger();
                echo '<option value="">Select Account</option>';
                foreach ($data as $row) {
                    $id = $row->ledgerId;
                    $name = $row->acccountLedgerName;
                    $accNo = $row->accNo;
                    echo '<option value="' . $id . '">' . $accNo . " - " . $name . '</option>';
                }
            } else {
                $company_id = $this->sessiondata['companyid'];
                $acledgernameQr = $this->db->query("SELECT ledgerId, accNo, acccountLedgerName FROM accountledger WHERE accountGroupId = '11' AND companyId = '$company_id'");
                $paidtoname = $acledgernameQr->result();
                echo '<option value="">Select Account</option>';
                foreach ($paidtoname as $value) {
                    $pid = $value->ledgerId;
                    $pname = $value->acccountLedgerName;
                    $accNo = $value->accNo;
                    echo '<option value="' . $pid . ',' . '11' . '">' . $accNo . " - " . $pname . '</option>';
                }
            }
        else:
            redirect('home');
        endif;
    }

    public function paidtoname() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $ledgerid = $this->input->post('ledgerid');
            $paidtoname = $this->ccfpaymentvou->paidtoname();
            echo '<option value="">Select Received From</option>';
            foreach ($paidtoname as $value) {
                $pid = $value->ledgerId;
                $pname = $value->acccountLedgerName;
                $accNo = $value->accNo;
                echo '<option value="' . $pid . '">' . $accNo . " - " . $pname . '</option>';
            }
        else:
            redirect('home');
        endif;
    }

    public function addreceiptmaster() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $ledgerid = $this->input->post('paymentMode');
            $accountGroupId = $this->input->post('accountGroupId');
            $paidtoid = $this->input->post('ledgerId');
            $cmpid = $this->sessiondata['companyid'];
            if ($accountGroupId == "11") {
                $data = array(
                    'date' => $_POST['date'],
                    'ledgerId' => $_POST['paymentMode'],
                    'receiptMode' => "By Cash",
                    'description' => $_POST['description'],
                    'companyId' => $this->sessiondata['companyid']
                );
                $isadded = $this->ccfreceiptvou->addreceipt($data);
            } else {
                $data = array(
                    'date' => $_POST['date'],
                    'ledgerId' => $_POST['paymentMode'],
                    'receiptMode' => "By Cheque",
                    'description' => $_POST['description'],
                    'companyId' => $this->sessiondata['companyid']
                );
                $isadded = $this->ccfreceiptvou->addreceipt($data);
            }
            $query1 = $this->db->query("SELECT MAX( receiptMasterId ) FROM receiptmaster where ledgerId=$ledgerid AND companyId=$cmpid");
            $row1 = $query1->row_array();
            $payid = $row1['MAX( receiptMasterId )'];
            $SalesMasterid = $this->input->post('voucherNumber');
            $isaddpaydet = $this->ccfreceiptvou->adddreceiptetails($payid);
            $isadded3 = $this->ccfreceiptvou->addledgerposting1($payid);
            $isadded4 = $this->ccfreceiptvou->addledgerposting2($payid);
            $isadded5 = $this->ccfreceiptvou->addPartyBalance($payid);
            $isupdated = $this->ccfreceiptvou->updateSalesMaster($SalesMasterid);
            if ($isadded && $isaddpaydet && $isadded3 && $isadded4 && $isadded5) {
                $this->session->set_userdata('success', 'Receipt Voucher added successfully');
                redirect('receiptvoucher/receiptvoucher');
            } else {
                $this->session->set_userdata('fail', 'Receipt Voucher add failed');
                redirect('receiptvoucher/receiptvoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function vouinfo() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $salesdata = $this->ccfreceiptvou->salesinfo();
            echo ' <select class="form-control" id="voucherType" name="voucherType" type="text">';
            echo '<option> Select Purchase Invoice </option>';
            foreach ($salesdata as $value) {
                $pid = $value->salesMasterId;
                $partvalue = $this->ccfreceiptvou->partpaid($pid);
                echo '<option value="' . $pid . '">' . "Sales Invoice" . " - " . $pid . " ---> " . $partvalue . '</option>';
            }
            echo '</select>';
        else:
            redirect('home');
        endif;
    }

    public function editvouinfo() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $receiptMasterId = $this->input->post('receiptMasterId');
            $id = $this->input->post('id');
            $temp = $this->ccfreceiptvou->getallpartybalance($receiptMasterId, $id);
            $salesdata = $this->ccfreceiptvou->editsalesinfo($id);
            echo ' <select class="form-control" id="voucherType" name="voucherType" type="text" disabled>';
            foreach ($salesdata as $value) {
                $pid = $value->salesMasterId;
                $invoid = $value->status;
                if ($invoid == "2" || "3") {
                    $amount = $this->ccfreceiptvou->editpartpaid($pid, $id);
                    $partvalue = floatval(str_replace(',', '', $amount));
                    if ($pid == $temp) {
                        echo '<option value="' . $pid . '">' . "Sales Invoice" . " - " . $pid . " ---> " . $partvalue . '</option>';
                        echo '<input type="hidden" id=fullamount name=fullamount value="' . $partvalue . '">';
                    }
                }
            }
            echo '</select>';
        else:
            redirect('home');
        endif;
    }

    public function updatereceiptvoucher() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $paymentMasterId = $this->input->post('receiptMasterId');
            $query = $this->db->query("Select ledgerPostingId from ledgerposting where voucherNumber='$paymentMasterId' AND voucherType = 'Receipt Voucher'");
            $IdAvailable = $query->result();
            foreach ($IdAvailable as $value) {
                $myarray[] = $value->ledgerPostingId;
            }
            $firstid = $myarray[0];
            $secondid = $myarray[1];
            $isupdated1 = $this->ccfreceiptvou->updatereceiptdetails();
            $isupdated2 = $this->ccfreceiptvou->updatereceiptmaster();
            $isupdated3 = $this->ccfreceiptvou->updateledgerposting1($firstid);
            $isupdated4 = $this->ccfreceiptvou->updateledgerposting2($secondid);
            //$isupdated4 = $this->ccfreceiptvou->updatepartybalance();
            if ($isupdated1 && $isupdated2 && $isupdated3 && $isupdated4) {
                $this->session->set_userdata('success', 'Receipt Voucher Updated successfully');
                redirect('receiptvoucher/receiptvoucher');
            } else {
                $this->session->set_userdata('fail', 'Receipt Voucher Update failed');
                redirect('receiptvoucher/receiptvoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function invoicedata() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $pid = $this->input->post('purid');
            $salesdata = $this->ccfreceiptvou->invoicedata($pid);
            foreach ($salesdata as $value) {
                $invoid = $value->status;
                if ($invoid == "3") {
                    $amount = number_format($value->amount, 2);
                    $amountvalue = floatval(str_replace(',', '', $amount));
                    $salesMasterId = $value->salesMasterId;
                    echo json_encode(array(
                        'salesMasterId' => $salesMasterId,
                        'amountvalue' => $amountvalue
                    ));
                }
                if ($invoid == "2") {
                    $pid = $this->input->post('purid');
                    $partvalue = $this->ccfreceiptvou->partpaid($pid);
                    echo json_encode(array(
                        'salesMasterId' => $pid,
                        'amountvalue' => $partvalue
                    ));
                }
            }
        else:
            redirect('home');
        endif;
    }

    public function deletereceiptvou() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $id = $this->input->post('receiptMasterId');
            //$ledgerId = $this->input->post('ledgerId');
            $isdeleted = $this->ccfreceiptvou->deletereceiptmaster($id);
            $isdeleteddetails = $this->ccfreceiptvou->deletereceiptdetails($id);
            //$isdeleteparty = $this->ccfreceiptvou->deletepartybalance($id, $ledgerId);
            $isdeletedledgerposting = $this->ccfreceiptvou->deleteladgerposting($id);
            if ($isdeleted && $isdeleteddetails && $isdeletedledgerposting) {
                $this->session->set_userdata('success', 'Receipt Voucher Deleted successfully');
                redirect('receiptvoucher/receiptvoucher');
            } else {
                $this->session->set_userdata('fail', 'Receipt Voucher Delete failed');
                redirect('receiptvoucher/receiptvoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function currentbalance() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $paidid = $this->input->post('ledgerid');
            $result = $this->ccfreceiptvou->currentbalance($paidid);
            echo $result;
        else:
            redirect('home');
        endif;
    }

    public function GetBusinessName() {
        $businessname = $this->ccfreceiptvou->GetBusinessName();
        return $businessname;
    }

    public function getReceiptDetailsTable() {
        // DB table to use
        $table = 'receiptdetails';
        $primaryKey = 'receiptDetailsId';
        $columns = array(
            array('db' => '`u`.`receiptMasterId`', 'dt' => 0, 'field' => 'receiptMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`u`.`receiptMasterId`', 'dt' => 1, 'field' => 'receiptMasterId',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('receiptvoucher/receiptvoucher/editreceiptvoucher/' . $rowvalue) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`u`.`receiptNo`', 'dt' => 2, 'field' => 'receiptNo',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('receiptvoucher/receiptvoucher/editreceiptvoucher/' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`ud`.`acccountLedgerName`', 'dt' => 3, 'field' => 'acccountLedgerName',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('receiptvoucher/receiptvoucher/editreceiptvoucher/' . $row[1]) . '">' . $rowvalue
                            . '</a>';
                }),
            array('db' => '`ud`.`nameOfBusiness`', 'dt' => 4, 'field' => 'nameOfBusiness',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('receiptvoucher/receiptvoucher/editreceiptvoucher/' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`u`.`amount`', 'dt' => 5, 'field' => 'amount',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('receiptvoucher/receiptvoucher/editreceiptvoucher/' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`udd`.`date`', 'dt' => 6, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('receiptvoucher/receiptvoucher/editreceiptvoucher/' . $row[1]) . '">' . date('d M Y', strtotime($rowvalue)) . '</a>';
                })
        );

        $this->load->database();
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $this->load->library('ssp');
        $companyid = $this->sessiondata['companyid'];
        $joinQuery = "FROM `receiptdetails` AS `u` JOIN `accountledger` AS `ud` ON (`ud`.`ledgerId` = `u`.`ledgerId`) JOIN `receiptmaster` AS `udd` ON (`udd`.`receiptMasterId` = `u`.`receiptMasterId`)";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid' AND `udd`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
