<?php

class Journalentry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
        $this->load->model('ccfjournalentry');
        if ($this->sessiondata['status'] == 'login'):
            $accessFlag = 1;
        else:
            $accessFlag = 0;
            redirect('home');
        endif;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Journal Entry";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "journalentry";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['ledger'] = $this->ccfjournalentry->ledgerdata();
            $data['sortalldata'] = $this->ccfjournalentry->sortalldata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('journalentry/journalentry', $data);
            $this->load->view('footer', $data);
            $this->load->view('journalentry/script', $data);
        else:
            redirect('home');
        endif;
    }

    public function getJournalentryDetails() {
        // DB table to use
        $table = 'journalmaster';
        $primaryKey = 'journalMasterId';
        $columns = array(
            array('db' => '`u`.`journalMasterId`', 'dt' => 0, 'field' => 'journalMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`ud`.`credit`', 'dt' => 1, 'field' => 'credit',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('journalentry/journalentry/edit_view?id=' . $row[0]) . '">' . $row[0] . '</a>';
                }),
            array('db' => '`u`.`date`', 'dt' => 2, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('journalentry/journalentry/edit_view?id=' . $row[0]) . '">' . date('d M Y', strtotime($rowvalue)) . '</a>';
                })
                /*
            array('db' => '`ud`.`debit`', 'dt' => 3, 'field' => 'debit',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('journalentry/journalentry/edit_view?id=' . $row[0]) . '">' . number_format(($rowvalue + $row[1]), 2)  . '</a>';
                })      */      
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
        $joinQuery = "FROM `journalmaster` AS `u` JOIN `ledgerposting` AS `ud` ON (`ud`.`voucherNumber` = `u`.`journalMasterId`)";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid' AND `ud`.`voucherType` = 'Journal entry'";
        $groupBy = "GROUP BY `u`.`journalMasterId`";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
        );
    }
    
    
    public function addjournalentry(){
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Add Journal Entry";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "journalentry";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['ledger'] = $this->ccfjournalentry->ledgerdata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('journalentry/add_journal', $data);
            $this->load->view('footer', $data);
            $this->load->view('journalentry/script', $data);
        else:
            redirect('home');
        endif;
    }

    
    public function edit_view() {
        $data['title'] = "Journal Entry Edit";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "journalentry";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['baseurl'] = $this->config->item('base_url');
            $data['ledger'] = $this->ccfjournalentry->ledgerdata();
            $masterid = $this->input->get('id');
            $data['sortalldata'] = $this->ccfjournalentry->sortalldataedit($masterid);
            $jmasterId = $masterid;
            $data['jmasterId'] = $jmasterId;
            $this->sessiondata = $this->session->userdata('logindata');
            $companyid = $this->sessiondata['companyid'];
            $getidData = $this->db->query("select * from journaldetails where journalMasterId = '$jmasterId' AND companyId = '$companyid'");
            $getLedgerData = $this->db->query("select * from ledgerposting where voucherNumber = '$jmasterId' AND voucherType='Journal entry' AND companyId = '$companyid'");
            $getLedgerDataValues = $getLedgerData->result();
            $getidValues = $getidData->result();
            $data['getLedgerDataValues'] = $getLedgerDataValues;
            $data['getidValues'] = $getidValues;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('journalentry/edit_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('journalentry/script', $data);
        else:
            redirect('home');
        endif;
    }

   

    public function ledgerdata() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $c = $this->input->post('c');
            $ledger = $this->ccfjournalentry->ledgerdata();
            echo '<input type="hidden" id="count" name="count" value="' . $c . '" />';
            echo '<select class="form-control selectpicker" data-live-search="true" id = "new_ledgerId' . $c . '" name = "new_ledgerId[]" required>';
            echo '<option value = "">Select</option>';
            foreach ($ledger as $value) {
                $accNo = $value->accNo;
                echo "<option value='" . $value->ledgerId . "'>$accNo - $value->acccountLedgerName</option>";
            }
            echo '</select>';
        else:
            redirect('home');
        endif;
    }

    public function addjournal() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $cmpid = $this->sessiondata['companyid'];
            $isadded1 = $this->ccfjournalentry->addjournal();
            $query1 = $this->db->query("SELECT MAX( journalMasterId ) FROM journalmaster where companyId=$cmpid");
            $row1 = $query1->row_array();
            $journalMasterId = $row1['MAX( journalMasterId )'];
            $isadded4 = $this->ccfjournalentry->addjournaldetails3($journalMasterId);
            if ($isadded1 && $isadded4) {
                $this->session->set_userdata('success', 'Journal entry added successfully');
                redirect('journalentry/journalentry');
            } else {
                $this->session->set_userdata('fail', 'Journal entry add failed');
                redirect('journalentry/journalentry');
            }
        else:
            redirect('home');
        endif;
    }

    public function editjournal() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isupdatedJMaster = $this->ccfjournalentry->updatedjounal();
            if ($isupdatedJMaster) {
                $this->session->set_userdata('success', 'Journal entry Updated successfully');
                redirect('journalentry/journalentry');
            } else {
                $this->session->set_userdata('fail', 'Journal entry update failed');
                redirect('journalentry/journalentry');
            }
        else:
            redirect('home');
        endif;
    }

    public function deletejournalentry() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isdeleted1 = $this->ccfjournalentry->deletejournalMaster();
            $isdeleted2 = $this->ccfjournalentry->deletejournalDetails();
            $isdeleted3 = $this->ccfjournalentry->deletejournalLedger();
            if ($isdeleted1 && $isdeleted2 && $isdeleted3) {
                $this->session->set_userdata('success', 'Journal entry deleted successfully');
                redirect('journalentry/journalentry');
            } else {
                $this->session->set_userdata('fail', 'Journal entry delete failed');
                redirect('journalentry/journalentry');
            }
        else:
            redirect('home');
        endif;
    }

}
