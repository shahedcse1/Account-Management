<?php

class Ccfcontravoucher extends CI_Model {

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
        $this->db->where('accountGroupId', '9');
        $query = $this->db->get();
        return $query->result();
    }

    public function allledgerdata() {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("Select * from accountledger where (companyId='$cmpid' AND accountGroupId='9')or(companyId='$cmpid' AND accountGroupId='11')");
        return $query->result();
    }

    public function sortalldata() {
        $this->db->select('*');
        $this->db->order_by("contraMasterId", "desc");
        $this->db->from('contramaster');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function addcontramaster() {
        $dataforcontramaster = array(
            'date' => $this->input->post('date'),
            'ledgerId' => $this->input->post('ledgerId'),
            'type' => $this->input->post('optionsRadios'),
            'optional' => '0',
            'userId' => '1',
            'branchId' => '1',
            'extraDate' => $this->input->post('date'),
            'companyId' => $this->sessiondata['companyid']
        );
        $insert = $this->db->insert('contramaster', $dataforcontramaster);
        $query = $this->db->query("Select MAX(contraMasterId) from contramaster");
        $result = $query->row_array();
        $contraMasterId = $result['MAX(contraMasterId)'];
        if ($insert) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Add ContraVoucher", "Contra Voucher No. $contraMasterId Added");
            return $insert;
        }
    }

    public function addcontradetails($contraMasterId) {
        $type = $_POST['optionsRadios'];
        $ledgerId = $_POST['ledgerId'];
        $new_ledgerid = $_POST['new_ledgerId'];
        $newamount = $_POST['amount'];
        $dataforcontradetail = array(
            'contraMasterId' => $contraMasterId,
            'ledgerId' => $new_ledgerid,
            'amount' => $newamount,
            'chequeNo' => $this->input->post('chequeNo'),
            'chequeDate' => $this->input->post('chequeDate'),
            'extraDate' => $this->input->post('date'),
            'companyId' => $this->sessiondata['companyid']
        );
        $saveresultContdetails = $this->db->insert('contradetails', $dataforcontradetail);
        if ($type == "Deposit") {
            $dataforLedgerpostDebit = array(
                'voucherNumber' => $contraMasterId,
                'ledgerId' => $ledgerId,
                'voucherType' => "Contra Voucher",
                'debit' => $newamount,
                'credit' => '0',
                'description' => "Contra Voucher",
                'date' => $this->input->post('date'),
                'companyId' => $this->sessiondata['companyid']
            );
            $saveresultlpostingDebit = $this->db->insert('ledgerposting', $dataforLedgerpostDebit);
            $dataforLedgerpostCredit = array(
                'voucherNumber' => $contraMasterId,
                'ledgerId' => $new_ledgerid,
                'voucherType' => "Contra Voucher",
                'debit' => '0',
                'credit' => $newamount,
                'description' => "Contra Voucher",
                'date' => $this->input->post('date'),
                'companyId' => $this->sessiondata['companyid']
            );
            $saveresultlpostingCredit = $this->db->insert('ledgerposting', $dataforLedgerpostCredit);
        }
        if ($type == "Withdraw") {
            $dataforLedgerpostDebit = array(
                'voucherNumber' => $contraMasterId,
                'ledgerId' => $ledgerId,
                'voucherType' => "Contra Voucher",
                'debit' => '0',
                'credit' => $newamount,
                'description' => "Contra Voucher",
                'date' => $this->input->post('date'),
                'companyId' => $this->sessiondata['companyid']
            );
            $savelpostingDebit = $this->db->insert('ledgerposting', $dataforLedgerpostDebit);
            $dataforLedgerpostCredit = array(
                'voucherNumber' => $contraMasterId,
                'ledgerId' => $new_ledgerid,
                'voucherType' => "Contra Voucher",
                'debit' => $newamount,
                'credit' => '0',
                'description' => "Contra Voucher",
                'date' => $this->input->post('date'),
                'companyId' => $this->sessiondata['companyid']
            );
            $savelpostingCredit = $this->db->insert('ledgerposting', $dataforLedgerpostCredit);
        }

        if ($saveresultContdetails && $saveresultlpostingDebit && $saveresultlpostingCredit):           
            return true;
        endif;
        if ($saveresultContdetails && $savelpostingDebit && $savelpostingCredit):           
            return TRUE;
        endif;
    }

    public function updatedcontravoucher() {
        $contramasterid = $_POST['editcontramasterid'];
        $updatedataConMaster = array(
            'date' => $this->input->post('editdate'),
            'ledgerId' => $this->input->post('editledgerId'),
            'type' => $this->input->post('optionsRadios'),
            'optional' => '0',
            'userId' => '1',
            'branchId' => '1',
            'extraDate' => $this->input->post('editdate'),
            'companyId' => $this->sessiondata['companyid']
        );
        $this->db->where('contraMasterId', $contramasterid);
        $saveConMaster = $this->db->update('contramaster', $updatedataConMaster);
        $ledgerpostledgeridfirst = $_POST['ledgerpostledgeridfirst'];
        $ledgerpostledgeridsecond = $_POST['ledgerpostledgeridsecond'];
        $type = $_POST['optionsRadios'];
        $ledgerId = $_POST['editledgerId'];
        $new_ledgerid = $_POST['editnew_ledgerId'];
        $newamount = $_POST['editamount'];
        $dataforcontradetail = array(
            'contraMasterId' => $contramasterid,
            'ledgerId' => $new_ledgerid,
            'amount' => $newamount,
            'chequeNo' => $this->input->post('editchequeNo'),
            'chequeDate' => $this->input->post('editchequeDate'),
            'extraDate' => $this->input->post('editdate'),
            'companyId' => $this->sessiondata['companyid']
        );
        $this->db->where('contraMasterId', $contramasterid);
        $saveresultContdetails = $this->db->update('contradetails', $dataforcontradetail);
        if ($type == "Deposit") {
            $dataforLedgerpostDebit = array(
                'voucherNumber' => $contramasterid,
                'ledgerId' => $ledgerId,
                'voucherType' => "Contra Voucher",
                'debit' => $newamount,
                'credit' => '0',
                'description' => "Contra Voucher",
                'date' => $this->input->post('editdate'),
                'companyId' => $this->sessiondata['companyid']
            );
            $this->db->where('voucherType', 'Contra Voucher');
            $this->db->where('ledgerPostingId', $ledgerpostledgeridfirst);
            $saveresultlpostingDebit = $this->db->update('ledgerposting', $dataforLedgerpostDebit);
            $dataforLedgerpostCredit = array(
                'voucherNumber' => $contramasterid,
                'ledgerId' => $new_ledgerid,
                'voucherType' => "Contra Voucher",
                'debit' => '0',
                'credit' => $newamount,
                'description' => "Contra Voucher",
                'date' => $this->input->post('editdate'),
                'companyId' => $this->sessiondata['companyid']
            );
            $this->db->where('voucherType', 'Contra Voucher');
            $this->db->where('ledgerPostingId', $ledgerpostledgeridsecond);
            $saveresultlpostingCredit = $this->db->update('ledgerposting', $dataforLedgerpostCredit);
        }
        if ($type == "Withdraw") {
            $dataforLedgerpostDebit = array(
                'voucherNumber' => $contramasterid,
                'ledgerId' => $ledgerId,
                'voucherType' => "Contra Voucher",
                'debit' => '0',
                'credit' => $newamount,
                'description' => "Contra Voucher",
                'date' => $this->input->post('date'),
                'companyId' => $this->sessiondata['companyid']
            );
            $this->db->where('voucherType', 'Contra Voucher');
            $this->db->where('ledgerPostingId', $ledgerpostledgeridfirst);
            $savelpostingDebit = $this->db->update('ledgerposting', $dataforLedgerpostDebit);
            $dataforLedgerpostCredit = array(
                'voucherNumber' => $contramasterid,
                'ledgerId' => $new_ledgerid,
                'voucherType' => "Contra Voucher",
                'debit' => $newamount,
                'credit' => '0',
                'description' => "Contra Voucher",
                'date' => $this->input->post('editdate'),
                'companyId' => $this->sessiondata['companyid']
            );
            $this->db->where('voucherType', 'Contra Voucher');
            $this->db->where('ledgerPostingId', $ledgerpostledgeridsecond);
            $savelpostingCredit = $this->db->update('ledgerposting', $dataforLedgerpostCredit);
        }
        if ($saveConMaster && $saveresultContdetails && $saveresultlpostingDebit && $saveresultlpostingCredit): 
            ccflogdata($this->sessiondata['username'], "accesslog", "Update ContraVoucher", "Contra Voucher No. $contramasterid Updated");            
            return true;
        endif;
        if ($saveConMaster && $saveresultContdetails && $savelpostingDebit && $savelpostingCredit):            
            return TRUE;
        endif;
    }

    public function deletecontraMaster() {
        $contraMasterId = $this->input->post('contraMasterId');
        $companyId = $this->sessiondata['companyid'];
        $queryformaster = $this->db->query("Delete from contramaster where contraMasterId='$contraMasterId' AND companyId='$companyId'");
        $queryfordetail = $this->db->query("Delete from contradetails where contraMasterId='$contraMasterId' AND companyId='$companyId'");
        $queryforledger = $this->db->query("Delete from ledgerposting where companyId='$companyId' AND (voucherNumber='$contraMasterId' AND voucherType='Contra Voucher')");
        if ($queryformaster && $queryfordetail && $queryforledger):
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete ContraVoucher", "Contra Voucher No. $contraMasterId Deleted");            
            return TRUE;
        else :
            return FALSE;
        endif;
    }

}
