<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AccountLedger extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ccfaccountledger');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Account Ledger";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "accountLedger";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['sortalldata'] = $this->ccfaccountledger->sortalldata();
            $data['alldata'] = $this->ccfaccountledger->showalldata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('accountLedger', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function addAccLedger() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $acclednam = $this->input->post('acccountLedgerName');
            $accgrp = $this->input->post('accountGroupId');
            if ($accgrp == "27") {
                $cmpid = $this->sessiondata['companyid'];
                $added = $this->ccfaccountledger->saveAccLedger();
                $query = $this->db->query("SELECT  ledgerId  FROM  accountledger WHERE acccountLedgerName='$acclednam' AND companyId = '$cmpid'");
                $ledgerId = $query->row()->ledgerId;
                $isadded2 = $this->ccfaccountledger->addvendor2($ledgerId);
                if ($added && $isadded2) {
                    echo 'Added';
                } else {
                    echo 'Notadded';
                }
            } else {
                $isadded = $this->ccfaccountledger->saveAccLedger();
                if ($isadded) {
                    echo 'Added';
                } else {
                    echo 'Notadded';
                }
            }
        else:
            redirect('home');
        endif;
    }

    public function editAccLedger() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isupdated = $this->ccfaccountledger->AccLedgerEdit();
            if ($isupdated):
                $this->session->set_userdata('success', 'Accountledger updated successfully!!');
                redirect('accountLedger/index');
            else:
                $this->session->set_userdata('fail', 'Accountledger updated failed!!');
                redirect('accountLedger/index');
            endif;
        else:
            redirect('accountledger/index');
        endif;
    }

    public function deleteAccLedger() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $deleted = $this->ccfaccountledger->AccLedgerdelete();
            echo $deleted;
        else:
            redirect('home');
        endif;
    }

    public function editAccLedgerDefault() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isupdated = $this->ccfaccountledger->editAccLedgerDefault();
            if ($isupdated):
                $this->session->set_userdata('success', 'Accountledger updated successfully!!');
                redirect('accountLedger/index');
            else:
                $this->session->set_userdata('fail', 'Accountledger updated failed!!');
                redirect('accountLedger/index');
            endif;
        else:
            redirect('home');
        endif;
    }

    public function accountNameCheck() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isExist = $this->ccfaccountledger->accountNameCheck();
            if ($isExist) {
                die('free');
            } else {
                die('booked');
            }
        else:
            redirect('home');
        endif;
    }

    public function accountNameCheckdefault() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isExist = $this->ccfaccountledger->accountNameCheckedit();
            if ($isExist) {
                die('free');
            } else {
                die('booked');
            }
        else:
            redirect('home');
        endif;
    }

    function getledgerinfo() {
        $ledgerid = $_POST['acccountLedgerid'];
        $query = $this->db->query("select * from accountledger where ledgerId = '$ledgerid'");
        $result = $query->result_array();
        echo json_encode($result);
    }

    function getaccountgrouplist() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $getaccountgroupid = $this->db->query("select accountGroupId from accountledger where ledgerid = '$ledgerid'");
        $accountgroupId = $getaccountgroupid->row()->accountGroupId;
        $query = $this->db->query("SELECT * FROM accountgroup where companyId = '$cmpid' ORDER BY accountGroupName ASC");
        $allgroupData = $query->result();
        #echo '<select class="form-control selectpicker" id="defaulteditaccountGroupId" data-live-search="true" name="accountgroupid" type="text" onchange="return checkgroup(this.value)">';
        foreach ($allgroupData as $groupdata):
            if ($accountgroupId == $groupdata->accountGroupId):
                $selected = 'selected';
            else:
                $selected = '';
            endif;
            echo '<option  ' . $selected . ' value="' . $groupdata->accountGroupId . '">' . $groupdata->accountGroupName . '</option>';
        endforeach;
        #echo '</select>';
    }

    function selectdebitorcredit() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $selectdebitotcredit = $this->db->query("select debitOrCredit from accountledger where ledgerId = '$ledgerid'");
        if ($selectdebitotcredit->row()->debitOrCredit == 1):
            $debit = 'selected';
            $credit = '';
        else:
            $credit = 'selected';
            $debit = '';
        endif;
        echo '<select class="supplier_debit pull-right form-control" id="editdebitOrCredit" name="debitorcredit">
                                                <option ' . $credit . ' value="0">Cr</option>
                                                <option ' . $debit . ' value="1">Dr</option>                                                                            
                                            </select>';
    }

    function billbyyesorno() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $selectdebitotcredit = $this->db->query("select billByBill from accountledger where ledgerId = '$ledgerid'");
        if ($selectdebitotcredit->row()->billByBill == 1):
            $yes = 'selected';
            $no = '';
        else:
            $no = 'selected';
            $yes = '';
        endif;
        echo '<select class="form-control" id="editbillByBill" name="billbybill">
                                                <option ' . $no . ' value="0">No</option>
                                                <option ' . $yes . ' value="1">Yes</option>                                                                                
                                            </select>  ';
    }

}
