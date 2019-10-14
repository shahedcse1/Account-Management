<?php

class Ccfjournalentry extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function ledgerdata() {
        $this->db->select('*');
        $this->db->from('accountledger');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function sortalldata() {
        $this->db->select('*');
        $this->db->order_by("journalMasterId", "desc");
        $this->db->from('journalmaster');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function sortalldataedit($masterid) {
        $this->db->select('*');
        $this->db->where('journalMasterId', $masterid);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get('journalmaster');   
        //$query = $this->db->get();
        return $query->result();
    }

    public function addjournal() {
        $data = array(
            'date' => $this->input->post('date'),
            'description' => $this->input->post('description'),
            'companyId' => $this->sessiondata['companyid']
        );
        $insert = $this->db->insert('journalmaster', $data);
        $query = $this->db->query("Select MAX(journalMasterId) from journalmaster");
        $result = $query->row_array();
        $journalMasterId = $result['MAX(journalMasterId)'];
        if ($insert) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Add JournalVoucher", "Journal Entry No. $journalMasterId Added");
            return $insert;
        }
    }

    public function addjournaldetails1($journalMasterId) {
        $data = array(
            'journalMasterId' => $journalMasterId,
            'ledgerId' => $this->input->post('first_ledgerId'),
            'debit' => $this->input->post('first_debit'),
            'credit' => $this->input->post('first_credit'),
            'description' => $this->input->post('description'),
            'companyId' => $this->sessiondata['companyid']
        );
        $query = $this->db->insert('journaldetails', $data);
        return $query;
    }

    public function addjournaldetails2($journalMasterId) {
        $data = array(
            'journalMasterId' => $journalMasterId,
            'ledgerId' => $this->input->post('second_ledgerId'),
            'debit' => $this->input->post('second_debit'),
            'credit' => $this->input->post('second_credit'),
            'description' => $this->input->post('description'),
            'companyId' => $this->sessiondata['companyid']
        );
        $query = $this->db->insert('journaldetails', $data);
        return $query;
    }

    public function addjournaldetails3($journalMasterId) {
        $ledgerids = array();
        $newcredit = array();
        $newdebit = array();
        $ledgerId = $_POST['new_ledgerId'];
        $newcredit = $_POST['credit'];
        $newdebit = $_POST['debit'];
        $sizeofpostdata = count($ledgerId);
        for ($i = 0; $i < count($ledgerId); $i++) {
            $dataarrayforjurnal = array(
                'journalMasterId' => $journalMasterId,
                'ledgerId' => $ledgerId[$i],
                'debit' => $newdebit[$i],
                'credit' => $newcredit[$i],
                'description' => $this->input->post('description'),
                'companyId' => $this->sessiondata['companyid']
            );
            $saveresultjdetails = $this->db->insert('journaldetails', $dataarrayforjurnal);
            $dataarrayforledger = array(
                'voucherNumber' => $journalMasterId,
                'ledgerId' => $ledgerId[$i],
                'voucherType' => "Journal Entry",
                'debit' => $newdebit[$i],
                'credit' => $newcredit[$i],
                'description' => "From journal",
                'companyId' => $this->sessiondata['companyid'],
                'date' => $this->input->post('date')
            );
            $saveresultlposting = $this->db->insert('ledgerposting', $dataarrayforledger);
        }
        if ($saveresultjdetails && $saveresultlposting):
            return true;
        else:
            return false;
        endif;
    }

    public function updatedjounal() {
        $JournalMasterID = $_POST['JournalMasterID'];
        $updatedataJMaster = array(
            'date' => $this->input->post('editdate'),
            'description' => $this->input->post('editdescription'),
            'companyId' => $this->sessiondata['companyid']
        );
        $this->db->where('journalMasterId', $JournalMasterID);
        $this->db->update('journalmaster', $updatedataJMaster);

        $journalDetailsId = array();
        $ledgerId = array();
        $newcredit = array();
        $newdebit = array();
        $ledgerId = $_POST['edit_ledgerId'];
        $newcredit = $_POST['editcredit'];
        $newdebit = $_POST['editdebit'];
        $journalDetailsId = $_POST['journalDetailsId'];
        $updateJournalDetail = array();
        for ($i = 0; $i < count($ledgerId); $i++) {
            $updateJournalDetail[] = array(
                'journalDetailsId' => $journalDetailsId[$i],
                'journalMasterId' => $JournalMasterID,
                'ledgerId' => $ledgerId[$i],
                'debit' => $newdebit[$i],
                'credit' => $newcredit[$i],
                'description' => $this->input->post('editdescription'),
                'companyId' => $this->sessiondata['companyid']
            );
        }
        $ledgerPostingId = array();
        $date = $_POST['editdate'];
        $ledgerPostingId = $_POST['ledgerPostingId'];
        $updateLedgerPost = array();
        for ($i = 0; $i < count($ledgerId); $i++) {
            $updateLedgerPost[] = array(
                'ledgerPostingId' => $ledgerPostingId[$i],
                'voucherNumber' => $JournalMasterID,
                'ledgerId' => $ledgerId[$i],
                'voucherType' => "Journal Entry",
                'debit' => $newdebit[$i],
                'credit' => $newcredit[$i],
                'description' => "From journal",
                'date' => $date,
                'companyId' => $this->sessiondata['companyid']
            );
        }
        $this->db->trans_start();
        $this->db->update_batch('journaldetails', $updateJournalDetail, 'journalDetailsId');
        $this->db->update_batch('ledgerposting', $updateLedgerPost, 'ledgerPostingId');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            ccflogdata($this->sessiondata['username'], "accesslog", "Update JournalEntry", "Journal Entry No. $JournalMasterID updated");
            return TRUE;
        }
        //return ($this->db->trans_status() === FALSE) ? FALSE : TRUE;
    }

    public function deletejournalMaster() {
        $journalMasterId = $this->input->post('journalMasterId');
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("Delete from journalmaster where journalMasterId='$journalMasterId' AND companyId='$companyId'");
        if ($query) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete JournalEntry", "Journal Entry No. $journalMasterId Deleted ");
            return $query;
        }
    }

    public function deletejournalDetails() {
        $journalMasterId = $this->input->post('journalMasterId');
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("Delete from journaldetails where journalMasterId='$journalMasterId' AND companyId='$companyId'");
        return $query;
    }

    public function deletejournalLedger() {
        $journalMasterId = $this->input->post('journalMasterId');
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("Delete from ledgerposting where companyId='$companyId' AND (voucherNumber='$journalMasterId' AND voucherType='Journal Entry')");
        return $query;
    }

}
