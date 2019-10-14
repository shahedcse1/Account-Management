<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trialbalance extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Trial Balance";
            $data['active_menu'] = "account_statement";
            $data['active_sub_menu'] = "trail_balance";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $intialdate = "2000-01-01 00:00:00";
            $date_to = $date_to . " 23:59:59";
            $leaserQuery = $this->db->query("SELECT SUM(lp.debit) as debitsum, SUM(lp.credit) as creditsum, al.acccountLedgerName, ag.accountGroupName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE (lp.date BETWEEN '$intialdate' AND '$date_to') AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' GROUP BY al.accountGroupId,lp.ledgerId");
            $groupQuery = $this->db->query("SELECT SUM(lp.debit) as debitsum, SUM(lp.credit) as creditsum, ag.accountGroupName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE (lp.date BETWEEN '$intialdate' AND '$date_to') AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' GROUP BY al.accountGroupId");
            $data['ledgerwisedata'] = $leaserQuery->result();
            $data['groupwisedata'] = $groupQuery->result();
            $companyQr = $this->db->query("SELECT companyName, address, email FROM company WHERE companyId = '$company_id'");
            if ($companyQr->num_rows() > 0):
                $data['comname'] = $companyQr->row()->companyName;
                $data['comaddress'] = $companyQr->row()->address;
                $data['comemail'] = $companyQr->row()->email;
            else:
                $data['comname'] = "";
                $data['comaddress'] = "";
                $data['comemail'] = "";
            endif;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('trialbalance/trial_balance', $data);
            $this->load->view('footer', $data);
            $this->load->view('trialbalance/tb_script', $data);
        else:
            redirect('login');
        endif;
    }

}

?>