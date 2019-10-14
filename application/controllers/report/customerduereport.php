<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CustomerDueReport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Customer's Due Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "customer_report";
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
            $date_to = $date_to . " 23:59:59";
            
            //            Opening balance for customer
            $strtotime_form = strtotime($date_from);
            $previous_dateadd = strtotime("-1 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);
            $beforefromdate = $beforefromdate . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";

            $IdSet = $this->input->post('acledgername');
            $acntldgrQr = $this->db->query("SELECT ledgerId,accNo,acccountLedgerName,nameOfBusiness FROM accountledger WHERE accountGroupId = '$IdSet' AND companyId = '$company_id'");
            $ledgeridarray = $acntldgrQr->result();

            if ($IdSet != ""):
                $ledgerbalanceQr = $this->db->query("SELECT accountledger.ledgerId as ledgerid, SUM(ledgerposting.debit) AS debit, SUM(ledgerposting.credit) AS credit, '0' AS openingbal, accountledger.accNo,accountledger.acccountLedgerName,accountledger.nameOfBusiness FROM ledgerposting JOIN accountledger ON ledgerposting.ledgerId = accountledger.ledgerId WHERE accountledger.accountGroupId = '$IdSet' AND (date BETWEEN '$date_from' AND '$date_to') AND accountledger.companyId = '$company_id' AND ledgerposting.companyId = '$company_id' AND accountledger.status = '1' GROUP BY accountledger.ledgerId");
                $ledgerbalancedata = $ledgerbalanceQr->result();                  
                $allcustomerQr = $this->db->query("SELECT accountledger.ledgerId as ledgerid, '0' AS debit, '0' AS credit, (SUM(ledgerposting.debit) - SUM(ledgerposting.credit)) AS openingbal, accountledger.accNo,accountledger.acccountLedgerName,accountledger.nameOfBusiness FROM ledgerposting JOIN accountledger ON ledgerposting.ledgerId = accountledger.ledgerId WHERE accountledger.accountGroupId = '$IdSet' AND (date BETWEEN '$initialdate' AND '$beforefromdate') AND accountledger.companyId = '$company_id' AND ledgerposting.companyId = '$company_id' AND accountledger.status = '1' GROUP BY accountledger.ledgerId");
                $allcustomerdata = $allcustomerQr->result();
            else:
                $ledgerbalancedata = array();
                $allcustomerdata = array();
            endif;
            
            $alldataarr = array_merge($ledgerbalancedata, $allcustomerdata);
                       
            if (sizeof($alldataarr) > 0):
                function sortdataarray($a, $b) {
                    $t1 = $a->ledgerid;
                    $t2 = $b->ledgerid;
                    if ($t1 == $t2):
                        return 1;
                    else:
                        return $t1 - $t2;
                    endif;
                }
                usort($alldataarr, 'sortdataarray');
            endif;  
            
            $data['alldataarr'] = $alldataarr;
                                

            $accountgroup = $this->db->query("SELECT accountGroupId, accountGroupName FROM accountgroup WHERE (companyId = '$company_id' AND accountGroupName = 'Supplier') OR (companyId = '$company_id' AND accountGroupName = 'Customer')");
            $data['accountGroupArray'] = $accountgroup->result();


            ##take data for print##
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
            ##take data for print##


            $data['company_id'] = $company_id;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['initialdate'] = $initialdate;
            $data['beforefromdate'] = $beforefromdate;
            $data['ledgeridarray'] = $ledgeridarray;
            $data['selectedledgerid'] = $IdSet;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('report/customerduereport', $data);
            $this->load->view('footer', $data);
            $this->load->view('report/cdr_script', $data);
        else:
            redirect('login');
        endif;
    }

}

?>