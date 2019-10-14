<?php

if (!defined('BASEPATH'))
    exit('No direct Script access allowed');

class Paymentvoucher extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
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
        $data['title'] = "Payment Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "paymentvoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            //$data['countries'] = $this->ccfpaymentvou->countrylist();
            //$data['ledger'] = $this->ccfpaymentvou->ledgerdata();
            //$data['sortalldata'] = $this->ccfpaymentvou->sortalldata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('paymentvoucher/paymentvoucherfirst', $data);
            $this->load->view('footer', $data);
            $this->load->view('paymentvoucher/script', $data);
        else:
            redirect('home');
        endif;
    }

    public function addpaymentvoucher() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Payment Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "paymentvoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['countries'] = $this->ccfpaymentvou->countrylist();
            $data['ledger'] = $this->ccfpaymentvou->ledgerdata();
            $data['sortalldata'] = $this->ccfpaymentvou->sortalldata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('paymentvoucher/paymentvoucher', $data);
            $this->load->view('footer', $data);
            $this->load->view('paymentvoucher/script', $data);
        else:
            redirect('home');
        endif;
    }

    public function editpaymentvoucher() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Payment Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "paymentvoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['countries'] = $this->ccfpaymentvou->countrylist();
            $data['ledgerdata'] = $this->ccfpaymentvou->getledger();
            $data['ledgerdatabycash'] = $this->ccfpaymentvou->getledgerbycash();
            ###print_r($data['ledgerdata']);
            $data['ledger'] = $this->ccfpaymentvou->ledgerdata();
            $id = $this->uri->segment(4);
            $query = $this->db->query("Select * from paymentmaster where paymentMasterId='$id'");
            $IdAvailable = $query->row()->paymentMasterId;
            if ($IdAvailable == "") {
                redirect('paymentvoucher/paymentvoucher');
            } else {
                $data['alldata'] = $this->ccfpaymentvou->alldata($id);
                $data['paidtoname'] = $this->ccfpaymentvou->editpaidtoname($id);
                $temp = $data['paidtoname'];
                foreach ($temp as $value) {
                    $data['paymsid'] = $value->paymentMasterId;
                    $data['paidid'] = $value->ledgerId;
                    $data['amount'] = $value->amount;
                    $data['chequeNumber'] = $value->chequeNumber;
                    $data['chequeDate'] = $value->chequeDate;
                }
                $data['currentbalance'] = $this->ccfpaymentvou->currentbalance($data['paidid']);
                //$data['preferenceType'] = $this->ccfpaymentvou->getpartydata($id, $data['paidid']);
                $this->load->view('header', $data);
                $this->load->view('sidebar', $data);
                $this->load->view('paymentvoucher/editpaymentvoucher', $data);
                $this->load->view('footer', $data);
                $this->load->view('paymentvoucher/script', $data);
            }
        else:
            redirect('home');
        endif;
    }

    public function getledger() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
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

            echo '<option value="">Select Paid To</option>';
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

    public function addpayment() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $ledgerid = $this->input->post('paymentMode');
            $accountGroupId = $this->input->post('accountGroupId');
            ###echo $ledgerid.','.$accountGroupId;            exit();
            $cmpid = $this->sessiondata['companyid'];
            if ($accountGroupId == "11") {
                $data = array(
                    'date' => $_POST['date'],
                    'ledgerId' => $_POST['paymentMode'],
                    'paymentMode' => "By Cash",
                    'description' => $_POST['description'],
                    'companyId' => $this->sessiondata['companyid']
                );
                $isadded = $this->ccfpaymentvou->addpayment($data);
            } else {
                $data = array(
                    'date' => $_POST['date'],
                    'ledgerId' => $_POST['paymentMode'],
                    'paymentMode' => "By Cheque",
                    'description' => $_POST['description'],
                    'companyId' => $this->sessiondata['companyid']
                );
                $isadded = $this->ccfpaymentvou->addpayment($data);
            }
            $query1 = $this->db->query("SELECT MAX( paymentMasterId ) FROM paymentmaster where ledgerId=$ledgerid AND companyId=$cmpid");
            $row1 = $query1->row_array();
            $payid = $row1['MAX( paymentMasterId )'];
            $purchaseid = $this->input->post('voucherNumber');
            $isaddpaydet = $this->ccfpaymentvou->adddpaymentetails($payid);
            $isadded3 = $this->ccfpaymentvou->addledgerposting1($payid);
            $isadded4 = $this->ccfpaymentvou->addledgerposting2($payid);
            $isupdated = $this->ccfpaymentvou->updatePurchaseMaster($purchaseid);
            if ($isadded && $isaddpaydet && $isadded3 && $isadded4) {
                $this->session->set_userdata('success', 'Payment Voucher added successfully');
                redirect('paymentvoucher/paymentvoucher');
            } else {
                $this->session->set_userdata('fail', 'Payment Voucher add failed');
                redirect('paymentvoucher/paymentvoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function vouinfo() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $puchasedata = $this->ccfpaymentvou->purchaseinfo();
            echo '<option> Select Purchase Invoice </option>';
            foreach ($puchasedata as $value) {
                $pid = $value->purchaseMasterId;
                $partvalue = $this->ccfpaymentvou->partpaid($pid);
                echo '<option value="' . $pid . '">' . "Purchase Invoice" . " - " . $pid . " ---> " . $partvalue . '</option>';
            }
        else:
            redirect('home');
        endif;
    }

    public function editvouinfo() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $paymsid = $this->input->post('paymentmasid');
            $id = $this->input->post('id');
            $temp = $this->ccfpaymentvou->getallpartybalance($paymsid, $id);
            $puchasedata = $this->ccfpaymentvou->editpurchaseinfo($id);
            echo ' <select class="form-control" id="voucherType" name="voucherType" type="text" disabled>';
            foreach ($puchasedata as $value) {
                $pid = $value->purchaseMasterId;
                $invoid = $value->invoiceStatusId;
                if ($invoid == "2" || "3") {
                    $partvalue = $this->ccfpaymentvou->editpartpaid($pid, $id);
                    if ($pid == $temp) {
                        echo '<option value="' . $pid . '">' . "Purchase Invoice" . " - " . $pid . " ---> " . $partvalue . '</option>';
                        echo '<input type="hidden" id=fullamount name=fullamount value="' . $partvalue . '">';
                    }
                }
            }
            echo '</select>';
        else:
            redirect('home');
        endif;
    }

    public function updatepayment() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            #$ledgerId = $this->input->post('paymentMode');
            #echo $ledgerId;            exit();
            #update accountledgerName from accountledger for cash account and paid to
            #$isupdated6 = $this->ccfpaymentvou->update_accountledger();
            $paymentMasterId = $this->input->post('paymentMasterId');
            $query = $this->db->query("Select ledgerPostingId from ledgerposting where voucherNumber='$paymentMasterId' AND voucherType = 'Payment Voucher'");
            $IdAvailable = $query->result();
            foreach ($IdAvailable as $value) {
                $myarray[] = $value->ledgerPostingId;
            }
            $firstid = $myarray[0];
            $secondid = $myarray[1];
            #echo $secondid;            exit();
            $isupdated5 = $this->ccfpaymentvou->updatepaymentmaster();
            $isupdated1 = $this->ccfpaymentvou->updatepaymentdetails();
            $isupdated2 = $this->ccfpaymentvou->updateledgerposting1($firstid);
            $isupdated3 = $this->ccfpaymentvou->updateledgerposting2($secondid);
            if ($isupdated1 && $isupdated2 && $isupdated5 && $isupdated3) {
                $this->session->set_userdata('success', 'Payment Voucher Updated successfully');
                redirect('paymentvoucher/paymentvoucher');
            } else {
                $this->session->set_userdata('fail', 'Payment Voucher Update failed');
                redirect('paymentvoucher/paymentvoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function invoicedata() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $pid = $this->input->post('purid');
            $purchasedata = $this->ccfpaymentvou->invoicedata($pid);
            foreach ($purchasedata as $value) {
                $invoid = $value->invoiceStatusId;
                if ($invoid == "3") {
                    $amount = number_format($value->amount, 2);
                    $amountvalue = floatval(str_replace(',', '', $amount));
                    $purchaseid = $value->purchaseMasterId;
                    echo json_encode(array(
                        'purchaseid' => $purchaseid,
                        'amountvalue' => $amountvalue
                    ));
                }
                if ($invoid == "2") {
                    $pid = $this->input->post('purid');
                    $partvalue = $this->ccfpaymentvou->partpaid($pid);
                    echo json_encode(array(
                        'purchaseid' => $pid,
                        'amountvalue' => $partvalue
                    ));
                }
            }
        else:
            redirect('home');
        endif;
    }

    public function deletepaymentvou() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $id = $this->input->post('paymentMasterId');
            //$ledgerId = $this->input->post('ledgerId');
            $isdeleted = $this->ccfpaymentvou->deletepaymentmaster($id);
            $isdeleteddetails = $this->ccfpaymentvou->deletepaymentdetails($id);
            //$isdeleteparty = $this->ccfpaymentvou->deletepartybalance($id, $ledgerId);
            $isdeletedledgerposting = $this->ccfpaymentvou->deleteladgerposting($id);
            if ($isdeleted) {
                $this->session->set_userdata('success', 'Payment Voucher Deleted successfully');
                redirect('paymentvoucher/paymentvoucher');
            } else {
                $this->session->set_userdata('fail', 'Payment Voucher Delete failed');
                redirect('paymentvoucher/paymentvoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function currentbalance() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $paidid = $this->input->post('ledgerid');
            $currentbalance = $this->ccfpaymentvou->currentbalance($paidid);
            echo $currentbalance;
        else:
            redirect('home');
        endif;
    }

    public function GetBusinessName() {
        $businessname = $this->ccfpaymentvou->GetBusinessName();
        return $businessname;
    }

    public function getPaymentDetailsTable() {
        /*    $table = 'paymentdetails';
          $primaryKey = 'paymentDetailsId';
          $columns = array(
          array('db' => 'paymentMasterId', 'dt' => 0,
          'formatter' => function ($rowvalue, $row) {
          return '<a data-toggle="modal" href="#myModaldelete' . $rowvalue . '">
          <i class="fa fa-times-circle delete-icon"></i></a>';
          }),
          array('db' => 'paymentMasterId', 'dt' => 1,
          'formatter' => function($rowvalue, $row) {
          return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $rowvalue) . '">' . $rowvalue . '</a>';
          }),
          array('db' => 'ledgerId', 'dt' => 2,
          'formatter' => function($rowvalue, $row) {

          return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $row[1]) . '">' . $rowvalue
          . '</a>';
          }),
          array('db' => 'ledgerId', 'dt' => 3,
          'formatter' => function($rowvalue, $row) {
          return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $row[1]) . '">' . $rowvalue . '</a>';
          }),
          array('db' => 'amount', 'dt' => 4,
          'formatter' => function($rowvalue, $row) {
          return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $row[1]) . '">' . $rowvalue . '</a>';
          }),
          array('db' => 'paymentMasterId', 'dt' => 5,
          'formatter' => function($rowvalue, $row) {
          return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $rowvalue) . '">' . $rowvalue . '</a>';
          })
          );

          // SQL server connection information
          $sql_details = array(
          'user' => 'root',
          'pass' => '',
          'db' => 'ccf',
          'host' => 'localhost'
          );
          $this->load->library('ssp');
          echo json_encode(
          SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
          ); */


        // DB table to use
        $table = 'paymentdetails';
        $primaryKey = 'paymentDetailsId';
        $columns = array(
            array('db' => '`u`.`paymentMasterId`', 'dt' => 0, 'field' => 'paymentMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`u`.`paymentMasterId`', 'dt' => 1, 'field' => 'paymentMasterId',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $rowvalue) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`ud`.`acccountLedgerName`', 'dt' => 2, 'field' => 'acccountLedgerName',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $row[1]) . '">' . $rowvalue
                            . '</a>';
                }),
            array('db' => '`ud`.`nameOfBusiness`', 'dt' => 3, 'field' => 'nameOfBusiness',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`u`.`amount`', 'dt' => 4, 'field' => 'amount',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`udd`.`date`', 'dt' => 5, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('paymentvoucher/paymentvoucher/editpaymentvoucher/' . $row[1]) . '">' . date('d M Y', strtotime($rowvalue)) . '</a>';
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
        $joinQuery = "FROM `paymentdetails` AS `u` JOIN `accountledger` AS `ud` ON (`ud`.`ledgerId` = `u`.`ledgerId`) JOIN `paymentmaster` AS `udd` ON (`udd`.`paymentMasterId` = `u`.`paymentMasterId`)";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid' AND `udd`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
