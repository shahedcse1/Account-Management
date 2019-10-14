<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Weeklyreport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Weekly Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "weekly_report";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $date_from = $this->input->post('date_from');
            //$date_to = $this->input->post('date_to');
            $acledgerid = $this->input->post('acledgername');
            if (($date_from == "")) {
                $today_date = date('Y-m-d');
                $strtotime_today = strtotime($today_date);
                $previous_dateadd = strtotime("-1 day", $strtotime_today);
                $previous_date = date('Y-m-d', $previous_dateadd);
                $date_from = $previous_date;
                //$date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            
            $date_form_strtotime = strtotime($date_from);
            $seven_daynext = strtotime("+7 day", $date_form_strtotime);
            $date_to = date('Y-m-d', $seven_daynext);
            
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";
            $dailyQr = $this->db->query("SELECT al.accNo, al.acccountLedgerName, sum(lp.debit) as debitsum, sum(lp.credit) as creditsum, (sum(lp.debit) - sum(credit)) as balance, (SELECT (sum(debit) - sum(credit)) FROM ledgerposting WHERE companyId = '$company_id' AND ledgerId = lp.ledgerId AND (date BETWEEN '$initialdate' AND '$date_from')) as openingbal FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId WHERE lp.companyId = '$company_id' AND al.companyId = '$company_id' AND (lp.date BETWEEN '$date_from' AND '$date_to')  GROUP BY lp.ledgerId");
            $data['dailydata'] = $dailyQr->result();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('report/weeklyreport', $data);
            $this->load->view('footer', $data);
            $this->load->view('report/script_weekly', $data);
        //$this->load->view('ledgerbalance/lb_script', $data);
        else:
            redirect('login');
        endif;
    }

}

?>