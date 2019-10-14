<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bankbook extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Bank Book";
            $data['active_menu'] = "account_statement";
            $data['active_sub_menu'] = "bank_book";
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



            //$leaserQuery = $this->db->query("SELECT SUM(lp.debit) as debitsum, SUM(lp.credit) as creditsum, al.acccountLedgerName, ag.accountGroupName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE (lp.date BETWEEN '$date_from%' AND '$date_to%') AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' AND ag.accountGroupId = '9' GROUP BY lp.ledgerId");
            //$groupQuery = $this->db->query("SELECT SUM(lp.debit) as debitsum, SUM(lp.credit) as creditsum, ag.accountGroupName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE (lp.date BETWEEN '$date_from%' AND '$date_to%') AND lp.companyId = '$company_id' AND ag.accountGroupId = '9'");
            //$data['ledgerwisedata'] = $leaserQuery->result();
            //$data['groupwisedata'] = $groupQuery->result();
            $acntldgrQr = $this->db->query("SELECT ledgerId,accNo,acccountLedgerName FROM accountledger WHERE accountGroupId = '9' AND companyId = '$company_id'");
            $ledgeridarray = $acntldgrQr->result();

//            $IdSet = "";
//            if (sizeof($ledgeridarray) > 0):
//                foreach ($ledgeridarray as $aid):
//                    if ($IdSet == ""):
//                        $IdSet = $aid->ledgerId;
//                    else:
//                        $IdSet = $IdSet . "," . $aid->ledgerId;
//                    endif;
//                endforeach;
//            endif;

            $IdSet = $this->input->post('acledgername');

            if ($IdSet != ""):
                $ledgerbalanceQr = $this->db->query("SELECT voucherNumber,voucherType,date,debit,credit,ledgerId FROM ledgerposting   WHERE ledgerId IN ($IdSet) AND companyId = '$company_id' AND (date BETWEEN '$date_from' AND '$date_to') ORDER BY date ASC");
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
            if ($IdSet != ""):
                $openingQr = $this->db->query("SELECT (sum(debit) - sum(credit)) as openingbal FROM ledgerposting WHERE ledgerId IN ($IdSet) AND companyId = '$company_id' AND (date BETWEEN '$initialdate' AND '$beforefromdate')");
                $data['openingbal'] = $openingQr->row()->openingbal;
            else:
                $data['openingbal'] = 0;
            endif;
            
            // for report
            if ($IdSet != ""):
                $ledgerinfoQr = $this->db->query("SELECT accNo, acccountLedgerName, address, nameOfBusiness FROM accountledger WHERE ledgerId = '$IdSet'");
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

            if ($IdSet != ""):
                $companyQr = $this->db->query("SELECT companyName, address, email FROM company WHERE companyId = '$company_id'");
                $data['comname'] = $companyQr->row()->companyName;
                $data['comaddress'] = $companyQr->row()->address;
                $data['comemail'] = $companyQr->row()->email;
            else:
                $data['comname'] = "";
                $data['comaddress'] = "";
                $data['comemail'] = "";
            endif;

            
            
            
            
            
            $data['company_id'] = $company_id;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['ledgeridarray'] = $ledgeridarray;
            $data['selectedledgerid'] = $IdSet;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('bankbook/bank_book', $data);
            $this->load->view('footer', $data);
         //   $this->load->view('bankbook/customerscript', $data);
             $this->load->view('bankbook/bb_script', $data);
        else:
            redirect('login');
        endif;
    }

}

?>