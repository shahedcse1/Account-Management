<?php

class Ccfaccountledger extends CI_Model {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function showalldata() {
        $this->db->select('*');
        $this->db->order_by("ledgerId", "desc");
        $this->db->from('accountledger');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    function sortalldata() {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT * FROM accountgroup where companyId = '$cmpid' ORDER BY accountGroupName ASC");
        return $query->result();
    }

    function saveAccLedger() {
        $data = array(
            'acccountLedgerName' => $this->input->post('acccountLedgerName'),
            'accountGroupId' => $this->input->post('accountGroupId'),
            'openingBalance' => $this->input->post('openingBalance'),
            'debitOrCredit' => $this->input->post('debitOrCredit'),
            'address' => '',
            'nameOfBusiness' => '',
            'emailId' => '',
            'creditPeriod' => $this->input->post('creditPeriod'),
            'mobileNo' => '',
            'fax' => '',
            'tin' => '',
            'cst' => '',
            'billByBill' => $this->input->post('billByBill'),
            'description' => $this->input->post('description'),
            'defaultOrNot' => '',
            'companyId' => $this->sessiondata['companyid']
        );
        $insertstatus = $this->db->insert('accountledger', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        if ($_POST['debitOrCredit'] == 0):
            $credit = $_POST['openingBalance'];
            $debit = 0.00;
        else:
            $debit = $_POST['openingBalance'];
            $credit = 0.00;
        endif;
        $mindate = $this->sessiondata['mindate'];
        $formatedate = $mindate . " 00:00:00";
        $newmindate = strtotime($formatedate);
        $minModifiedDate = strtotime("-1 day", $newmindate);
        $finalModifiedDate = date("Y-m-d H:i:s", $minModifiedDate);
        $dataforledgerposting = array(
            'voucherNumber' => $insert_id,
            'ledgerId' => $insert_id,
            'voucherType' => 'Opening Balance',
            'debit' => $debit,
            'credit' => $credit,
            'description' => '',
            'date' => $finalModifiedDate,
            'companyID' => $this->sessiondata['companyid']
        );
        ccflogdata($this->sessiondata['username'], "accesslog", "Add account ledger", "New account ledger: " . $_POST['acccountLedgerName'] . " Added");
        $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerposting);
        return $saveledgerinfo;
    }

    function addvendor2($ledgerId) {
        $data2 = array(
            'vendorName' => $this->input->post('acccountLedgerName'),
            'ledgerId' => $ledgerId,
            'companyId' => $this->sessiondata['companyid']
        );
        $saveresult = $this->db->insert('vendor', $data2);
        return $saveresult;
    }

    function AccLedgerEdit() {
        $ledgerId = $this->input->post('ledgerid');
        $data = array(
            'acccountLedgerName' => $this->input->post('ledgername'),
            'accountGroupId' => $this->input->post('accountgroupid'),
            'openingBalance' => $this->input->post('openingbalance'),
            'debitOrCredit' => $this->input->post('debitorcredit'),
            'billByBill' => $this->input->post('billbybill'),
            'description' => $this->input->post('description'),
            'companyId' => $this->sessiondata['companyid']
        );
        $this->db->where('ledgerId', $ledgerId);
        $updatestatus = $this->db->update('accountledger', $data);
        if ($_POST['debitorcredit'] == 0):
            $credit = $_POST['openingbalance'];
            $debit = 0.00;
        else:
            $debit = $_POST['openingbalance'];
            $credit = 0.00;
        endif;
        $mindate = $this->sessiondata['mindate'];
        $newmindate = strtotime($mindate);
        $minModifiedDate = strtotime("-1 day", $newmindate);
        $finalModifiedDate = date("Y-m-d H:i:s", $minModifiedDate);
        $dataforledgerpostingInsert = array(
            'voucherNumber' => $ledgerId,
            'ledgerId' => $ledgerId,
            'voucherType' => 'Opening Balance',
            'debit' => $debit,
            'credit' => $credit,
            'description' => '',
            'date' => $finalModifiedDate,
            'companyID' => $this->sessiondata['companyid']
        );

        //check if exit or not 
        $searchId = $this->db->query("select * from ledgerposting where ledgerId = '$ledgerId' AND voucherType = 'Opening Balance'");
        ccflogdata($this->sessiondata['username'], "accesslog", "edit account ledger", "account ledger: " . $_POST['ledgername'] . " Updated");
        if ($searchId->num_rows() > 0):
            $saveledgerinfo = $this->db->query("update ledgerposting set debit = '$debit',credit = '$credit' where ledgerId = '$ledgerId' AND voucherType = 'Opening Balance'");
        else:
            $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerpostingInsert);
        endif;
        if ($saveledgerinfo && $updatestatus):
            return true;
        else:
            return false;
        endif;
    }

    public function editAccLedgerDefault() {
        $ledgerId = $this->input->post('defaultledgerid');
        if ($_POST['debitorcredit'] == 0):
            $credit = $_POST['openingbalance'];
            $debit = 0.00;
        else:
            $debit = $_POST['openingbalance'];
            $credit = 0.00;
        endif;
        $dataforledgerposting = array(
            'debit' => $debit,
            'credit' => $credit
        );
        $mindate = $this->sessiondata['mindate'];
        $newmindate = strtotime($mindate);
        $minModifiedDate = strtotime("-1 day", $newmindate);
        $finalModifiedDate = date("Y-m-d H:i:s", $minModifiedDate);
        $dataforledgerpostingInsert = array(
            'voucherNumber' => $ledgerId,
            'ledgerId' => $ledgerId,
            'voucherType' => 'Opening Balance',
            'debit' => $debit,
            'credit' => $credit,
            'description' => '',
            'date' => $finalModifiedDate,
            'companyID' => $this->sessiondata['companyid']
        );
        $data = array(
            'openingBalance' => $this->input->post('openingbalance')
        );
        $this->db->where('ledgerId', $ledgerId);
        $updatestatusAccountLedger = $this->db->update('accountledger', $data);
        //check if exit or not 
        $searchId = $this->db->query("select * from ledgerposting where ledgerId = '$ledgerId' AND voucherType = 'Opening Balance'");
        if ($searchId->num_rows() > 0):
            $this->db->where('ledgerId', $ledgerId);
            $this->db->where('voucherType', 'Opening Balance');
            $saveledgerinfo = $this->db->update('ledgerposting', $dataforledgerposting);
        else:
            $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerpostingInsert);
        endif;
        if ($updatestatusAccountLedger && $saveledgerinfo):
            return true;
        else:
            return false;
        endif;
    }

    public function AccLedgerdelete() {
        $ledgerId = $this->input->post('ledgerId');
        $checkinused = $this->db->query("select ledgerId from ledgerposting where ledgerId = '$ledgerId'");
        ccflogdata($this->sessiondata['username'], "accesslog", "delete account ledger", "account ledger: " . $_POST['ledgerId'] . " deleted");
        if ($checkinused->num_rows() > 1):
            return 'notdeleted';
        else:
            $this->db->where('ledgerId', $ledgerId);
            $deletestatus = $this->db->delete('accountledger');
            return 'deleted';
        endif;
    }

    public function accountNameCheck() {
        $acccountLedgerName = $this->input->post('acccountLedgerName');
        $this->db->select('*');
        $this->db->from('accountledger');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('acccountLedgerName', $acccountLedgerName);
        $queryresult = $this->db->get();
        if ($queryresult->num_rows() > 0):
            return false;
        else:
            return true;
        endif;
    }

    public function accountNameCheckedit() {
        $acccountLedgerName = $this->input->post('acccountLedgerName');
        $oldledgername = $this->input->post('oldledgername');
        $queryForgetunique = $this->db->query("select * from accountledger where acccountLedgerName = '$acccountLedgerName' AND acccountLedgerName NOT IN ( '$oldledgername' )");
        if ($queryForgetunique->num_rows() > 0):
            return false;
        else:
            return true;
        endif;
    }

}
