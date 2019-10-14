<?php

class Ccffarmer extends CI_Model {

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
        $this->db->where('accountGroupId', "13");
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    function sortalldata() {
        $query = $this->db->query('SELECT * FROM `accountgroup` ORDER BY `accountgroup`.`accountGroupName` ASC');
        return $query->result();
    }

    function addAccLedger() {

        $logindata = array(
            'username' => $_POST['fax'],
            'password' => $_POST['tin'],
            'activeOrNot' => 1,
            'description' => $_POST['address'],
            'companyId' => $this->sessiondata['companyid'],
            'role' => "f"
        );
        $salesManLoginInfo = $this->db->insert('user', $logindata);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        $data = array(
            'acccountLedgerName' => $this->input->post('acccountLedgerName'),
            'accNo' => $this->input->post('accountno'),
            'accountGroupId' => 13,
            'openingBalance' => $this->input->post('openingBalance'),
            'debitOrCredit' => $this->input->post('debitOrCredit'),
            'address' => $this->input->post('address'),
            'nameOfBusiness' => $this->input->post('nameofbusiness'),
            'emailId' => '',
            'creditPeriod' => 0,
            'mobileNo' => $this->input->post('mobileNo'),
            'fax' => $_POST['fax'],
            'tin' => $_POST['tin'],
            'cst' => $insert_id,
            'billByBill' => 1,
            'description' => $this->input->post('description'),
            'defaultOrNot' => 0,
            'companyId' => $this->sessiondata['companyid'],
            'status' => $this->input->post('status')
        );
        $insertStatus = $this->db->insert('accountledger', $data);
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
        $newmindate = strtotime($mindate);
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
        ccflogdata($this->sessiondata['username'], "accesslog", "farmer", "Farmer: " . $_POST['acccountLedgerName'] . " Added");
        $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerposting);
        return $insertStatus;
    }

    function editAccLedger() {
        $ledgerId = $this->input->post('editledgerId');
        $comid = $this->sessiondata['companyid'];
        $user = $_POST['fax'];
        $pass = $_POST['tin'];
        $userid = $_POST['cst'];
        $checkusertable = $this->db->query("select userId from user where username= '$user' AND password = '$pass' AND companyId = '$comid'");
        if ($checkusertable->num_rows() == 0):
            $logindata = array(
                'username' => $_POST['fax'],
                'password' => $_POST['tin'],
                'activeOrNot' => 1,
                'description' => $_POST['editaddress'],
                'companyId' => $this->sessiondata['companyid'],
                'role' => "u"
            );
            $salesManLoginInfo = $this->db->insert('user', $logindata);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $data = array(
                'accNo' => $this->input->post('accountno'),
                'acccountLedgerName' => $this->input->post('editacccountLedgerName'),
                'openingBalance' => $this->input->post('opening_balance'),
                'debitOrCredit' => $this->input->post('dr_cr'),
                'address' => $this->input->post('editaddress'),
                'description' => $this->input->post('description'),
                'nameOfBusiness' => $this->input->post('nameofbusiness'),
                'emailId' => "",
                'fax' => $_POST['fax'],
                'tin' => $_POST['tin'],
                'cst' => $insert_id,
                'mobileNo' => $this->input->post('mobile'),
                 'status' => $this->input->post('status_edit')
            );
            $this->db->where('ledgerId', $ledgerId);
            $update = $this->db->update('accountledger', $data);
        else:
            $logindata = array(
                'username' => $_POST['fax'],
                'password' => $_POST['tin']
            );
            $this->db->where('userId', $userid);
            $salesManLoginInfo = $this->db->update('user', $logindata);
            $data = array(
                'accNo' => $this->input->post('accountno'),
                'acccountLedgerName' => $this->input->post('editacccountLedgerName'),
                'accountGroupId' => 13,
                'openingBalance' => $this->input->post('editopeningBalance'),
                'debitOrCredit' => $this->input->post('editdebitOrCredit'),
                'address' => $this->input->post('editaddress'),
                'nameOfBusiness' => $this->input->post('nameofbusiness'),
                'emailId' => '',
                'creditPeriod' => 0,
                'mobileNo' => $this->input->post('editmobileNo'),
                'fax' => $_POST['fax'],
                'tin' => $_POST['tin'],
                'billByBill' => 1,
                'description' => $this->input->post('editdescription'),
                'defaultOrNot' => 0,
                'companyId' => $this->sessiondata['companyid'],
                 'status' => $this->input->post('status_edit')
            );
            $this->db->where('ledgerId', $ledgerId);
            $updatestatus = $this->db->update('accountledger', $data);
        endif;
        if ($_POST['editdebitOrCredit'] == 0):
            $credit = $_POST['editopeningBalance'];
            $debit = 0.00;
        else:
            $debit = $_POST['editopeningBalance'];
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

        //check if exit or not 
        ccflogdata($this->sessiondata['username'], "accesslog", "farmer", "Farmer: " . $_POST['editacccountLedgerName'] . " updated");
        $searchId = $this->db->query("select * from ledgerposting where ledgerId = '$ledgerId' AND voucherType = 'Opening Balance'");
        if ($searchId->num_rows() > 0):
            $this->db->where('ledgerId', $ledgerId);
            $this->db->where('voucherType', 'Opening Balance');
            $saveledgerinfo = $this->db->update('ledgerposting', $dataforledgerposting);
        else:
            $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerpostingInsert);
        endif;
        if ($saveledgerinfo && $updatestatus):
            return true;
        else:
            return false;
        endif;
    }

    public function deleteFarmer() {
        $ledgerId = $this->input->post('ledgerId');
        $checkfarmer = $this->db->query("select ledgerId from ledgerposting where ledgerId = '$ledgerId'");
        if ($checkfarmer->num_rows() > 1):
            return 'Notdeleted';
        else:
            $this->db->where('ledgerId', $ledgerId);
            $deletestatus = $this->db->delete('accountledger');
            return 'Deleted';
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

}
