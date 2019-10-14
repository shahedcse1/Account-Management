<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ledgerbalance extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Ledger Balance";
            $data['active_menu'] = "account_statement";
            $data['active_sub_menu'] = "ladger_balance";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $acledgernameQr = $this->db->query("SELECT ledgerId, accNo, acccountLedgerName FROM accountledger WHERE companyId = '$company_id'");
            $data['acledgerdata'] = $acledgernameQr->result();
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $acledgerid = $this->input->post('acledgername');
            
            
           
                        
            #echo $acledgerid;
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";

            /*if ($acledgerid != "" && $acledgerid != "all"):
                $ledgerbalanceQr = $this->db->query("SELECT ledgerposting.*, accountledger.acccountLedgerName FROM ledgerposting JOIN accountledger ON ledgerposting.ledgerId = accountledger.ledgerId WHERE ledgerposting.ledgerId = '$acledgerid' AND ledgerposting.companyId = '$company_id' AND (date BETWEEN '$date_from' AND '$date_to') ORDER BY date ASC");
                $data['ledgerbalancedata'] = $ledgerbalanceQr->result();*/
            $acledgernameQr = $this->db->query("SELECT ledgerId, accNo, acccountLedgerName FROM accountledger WHERE  companyId = '$company_id'");
            $data['acledgerdata'] = $acledgernameQr->result();
            $acntldgrQr = $this->db->query("SELECT ledgerId FROM accountledger WHERE accountGroupId = '11' AND companyId = '$company_id'");
            $ledgeridarray = $acntldgrQr->result();
            if ($acledgerid != NULL):
                $ledgerbalanceQr = $this->db->query("SELECT voucherNumber,voucherType,date,debit,credit,ledgerId FROM ledgerposting WHERE ledgerId = '$acledgerid' AND companyId = '$company_id' AND (date BETWEEN '$date_from' AND '$date_to') ORDER BY date DESC");
                $ledgerbalanceQrResult = $ledgerbalanceQr->result();
                $data['ledgerbalancedata'] = $ledgerbalanceQrResult;
                $ledgerarr = array();
                if (sizeof($ledgerbalanceQrResult) > 0):
                    foreach ($ledgerbalanceQrResult as $datarow):
                        $vnumber = $datarow->voucherNumber;
                        $vtype = $datarow->voucherType;
                        $lid = $datarow->ledgerId;
                        $ledgernameQr = $this->db->query("SELECT al.acccountLedgerName FROM accountledger al JOIN ledgerposting lp ON al.ledgerId = lp.ledgerId WHERE (lp.ledgerId != '$lid' AND lp.voucherNumber = '$vnumber' AND lp.voucherType = '$vtype')");
                        if (sizeof($ledgernameQr->row()) > 0):
                            $ledgername = $ledgernameQr->row()->acccountLedgerName;
                            $ledgerarr[] = $ledgername;
                        else:
                            $ledgerarr[] = $vtype;
                        endif;
                    endforeach;
                endif;
                $data['ledgernamearr'] = $ledgerarr;
            else:
                $data['ledgerbalancedata'] = array();
            endif;
            

            //Opening balance for customer
            $strtotime_form = strtotime($date_from);
            $previous_dateadd = strtotime("-1 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);
            $beforefromdate = $beforefromdate . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";
            $openingQr = $this->db->query("SELECT (sum(debit) - sum(credit)) as openingbal FROM ledgerposting WHERE ledgerId = '$acledgerid' AND companyId = '$company_id' AND (date BETWEEN '$initialdate' AND '$beforefromdate')");
            $data['openingbal'] = $openingQr->row()->openingbal;
            ##take data for print##
            if ($acledgerid != "" && $acledgerid != "all"):
                $ledgerinfoQr = $this->db->query("SELECT accNo, acccountLedgerName, address, nameOfBusiness FROM accountledger WHERE ledgerId = '$acledgerid'");
                $data['accountno'] = $ledgerinfoQr->row()->accNo;
                $data['ledgername'] = $ledgerinfoQr->row()->acccountLedgerName;
                $data['address'] = $ledgerinfoQr->row()->address;
                $data['businessname'] = $ledgerinfoQr->row()->nameOfBusiness;
            else:
                $data['accountno'] = "";
                $data['ledgername'] = "";
                $data['address'] = "";
                $data['businessname'] = "";
            endif;

            if ($acledgerid == "all"):
                $leaserQuery = $this->db->query("SELECT SUM(lp.debit) as debitsum, SUM(lp.credit) as creditsum, al.acccountLedgerName, ag.accountGroupName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE (lp.date BETWEEN '$date_from' AND '$date_to') AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' GROUP BY al.accountGroupId,lp.ledgerId");
                $data['ledgerwisedata'] = $leaserQuery->result();
            endif;

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
            $data['selectedledgerid'] = $acledgerid;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('ledgerbalance/ledger_balance', $data);
            $this->load->view('footer', $data);
            $this->load->view('ledgerbalance/lb_script', $data);
        else:
            redirect('login');
        endif;
    }

}

?>