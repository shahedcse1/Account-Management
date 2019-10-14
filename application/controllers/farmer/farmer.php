<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Farmer extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('ccffarmer');
        $this->sessiondata = $this->session->userdata('logindata');
        if ($this->sessiondata['status'] = 'login'):
            $accessFlag = 1;
        else:
            $accessFlag = 0;
            redirect('home');
        endif;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Farmer";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "farmer";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['sortalldata'] = $this->ccffarmer->sortalldata();
            $data['alldata'] = $this->ccffarmer->showalldata();
            $firstdate = "2000-01-01 00:00:00";
            $enddate = $this->sessiondata['maxdate'];
            $comId = $this->sessiondata['companyid'];
            $ledgerpostingQuery = $this->db->query("SELECT sum(debit) as debit,sum(credit) as credit,ledgerId FROM ledgerposting where date between '$firstdate%' AND '$enddate%' AND companyId = '$comId' group by ledgerId");
            #$ledgerpostingQuery = $this->db->query("SELECT sum(debit) as debit,sum(credit) as credit,ledgerId FROM ledgerposting group by ledgerId");
            $data['ledgerposting'] = $ledgerpostingQuery->result();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('farmer/farmer', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function addAccLedger() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isadded = $this->ccffarmer->addAccLedger();
            if ($isadded) {
                echo 'Added';
            } else {
                echo 'Notadded';
            }
        else:
            redirect('home');
        endif;
    }

    public function editfarmer() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isupdated = $this->ccffarmer->editAccLedger();
            if ($isupdated):
                $this->session->set_userdata('success', 'Customer information updated successfully!!');
                redirect('farmer/farmer/index');
            else:
                $this->session->set_userdata('fail', 'Customer information updated failed!!');
                redirect('farmer/farmer/index');
            endif;
        else:
            redirect('home');
        endif;
    }

    public function accountNameCheck() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isExist = $this->ccffarmer->accountNameCheck();
            if ($isExist) {
                die('free');
            } else {
                die('booked');
            }
        else:
            redirect('home');
        endif;
    }

    public function deleteFarmer() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isdeleted = $this->ccffarmer->deleteFarmer();
            echo $isdeleted;
        else:
            redirect('home');
        endif;
    }

    function editdebitorcredit() {
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
        echo '<select class="supplier_debit pull-right form-control" id="dr_cr" name="editdebitOrCredit">
                                                <option ' . $credit . ' value="0">Cr</option>
                                                <option ' . $debit . ' value="1">Dr</option>                                                                            
                                            </select>';
    }

}
