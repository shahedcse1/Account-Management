<?php

class Customerdb extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    /**
     * Fetch Customer Types
     * @return mixed
     */
    public function getMemberTypes()
    {
        return $this->db
            ->select('id')
            ->select('name')
            ->from('membertype')
            ->get()
            ->result();
    }

    /**
     * Fetch Maximum Account Number for Auto Generated Account Number
     * @return mixed
     */
    public function getMaxAccountNumber()
    {
        return $this->db
            ->select("MAX(CAST(`accNo` AS UNSIGNED)) as maxacc")
            ->from('accountledger')
            ->where("CHAR_LENGTH(accNo) = 6")
            ->get();
    }

    /**
     * Check Unique Mobile Number
     * @param $mobile
     * @return bool
     */
    public function checkUniqueMobileNo($mobile)
    {
        $count = $this->db
            ->select('COUNT(1) as count')
            ->from('user')
            ->where('username', $mobile)
            ->get()
            ->row()
            ->count;

        return !$count ? true : false;
    }

    /**
     * Check Unique Account Number
     * @param $acc
     * @return bool
     */
    public function checkUniqueAccNo($acc)
    {
        $count = $this->db
            ->select('COUNT(1) as count')
            ->from('accountledger')
            ->where('accNo', $acc)
            ->get()
            ->row()
            ->count;

        return !$count ? true : false;
    }

    /**
     * Add Customer
     * @return mixed
     */
    public function addcustomer()
    {
        $username = $this->input->post('mobile');
        $password = $this->input->post('password');
        $companyId = $this->sessiondata['companyid'];

        $logindata = [
            'username'  => $username,
            'password'  => $password,
            'companyId' => $companyId,
            'role'      => "u"
        ];
        $this->db
            ->insert('user', $logindata);

        $insert_id = $this->db
            ->insert_id();

        $this->db
            ->trans_complete();

        $data = [
            'accNo'              => $this->input->post('accountno'),
            'acccountLedgerName' => $this->input->post('customer_name'),
            'membertype'         => $this->input->post('membertype'),
            'accountGroupId'     => '28',
            'mobileNo'           => $username,
            'gender'             => $this->input->post('gender'),
            'tin'                => $password,
            'cst'                => $insert_id,
            'companyId'          => $companyId,
            'status'             => $this->input->post('status'),
        ];

        $saveresult = $this->db
            ->insert('accountledger', $data);

        $insert_id = $this->db
            ->insert_id();

        $this->db
            ->trans_complete();

        $mindate           = $this->sessiondata['mindate'];
        $newmindate        = strtotime($mindate);
        $minModifiedDate   = strtotime("-1 day", $newmindate);
        $finalModifiedDate = date("Y-m-d H:i:s", $minModifiedDate);

        $dataforledgerposting = [
            'voucherNumber' => $insert_id,
            'ledgerId'      => $insert_id,
            'voucherType'   => 'Opening Balance',
            'date'          => $finalModifiedDate,
            'companyID'     => $this->sessiondata['companyid']
        ];
        ccflogdata($this->sessiondata['username'], "accesslog", "customer", "Customer: " . $_POST['customer_name'] . " Added");
        $this->db
            ->insert('ledgerposting', $dataforledgerposting);
        return $saveresult;
    }

    /**
     * edit Customer Data
     * @param $ledgerId
     * @return bool
     */
    public function editCustomer($ledgerId)
    {
        $comid = $this->sessiondata['companyid'];
        $user = $this->input->post('mobile');
        $pass = $this->input->post('password');
        $userid = $_POST['userid'];
        $checkusertable = $this->db->query("select userId from user where username= '$user' AND companyId = '$comid'");
        if ($checkusertable->num_rows() == 0):
            $logindata = [
                'username'  => $this->input->post('mobile'),
                'password'  => $pass,
                'companyId' => $this->sessiondata['companyid'],
                'role'      => "u"
            ];
            $salesManLoginInfo = $this->db->insert('user', $logindata);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $data = array(
                'accNo' => $this->input->post('accountno'),
                'acccountLedgerName' => $this->input->post('customer_name'),
                'openingBalance' => $this->input->post('opening_balance'),
                'debitOrCredit' => $this->input->post('dr_cr'),
                'address' => $this->input->post('address'),
                'district' => $this->input->post('districtname'),
                'description' => $this->input->post('description'),
                'nameOfBusiness' => $this->input->post('nameofbusiness'),
                'emailId' => "",
                'fax' => $_POST['username'],
                'tin' => $pass,
                'cst' => $insert_id,
                'mobileNo' => $this->input->post('mobile'),
                'gender' => $this->input->post('editgender'),
                'dateofbirth' => $this->input->post('editdateofbirth'),
                'status' => $this->input->post('status_edit')
            );
            $this->db->where('ledgerId', $ledgerId);
            $update = $this->db->update('accountledger', $data);
        else:
            $logindata = array(
                'username' => $_POST['username'],
                'password' => $_POST['password']
            );
            $this->db->where('userId', $userid);
            $salesManLoginInfo = $this->db->update('user', $logindata);
            $data = array(
                'accNo' => $this->input->post('accountno'),
                'acccountLedgerName' => $this->input->post('customer_name'),
                'openingBalance' => $this->input->post('opening_balance'),
                'debitOrCredit' => $this->input->post('dr_cr'),
                'address' => $this->input->post('address'),
                'district' => $this->input->post('districtname'),
                'description' => $this->input->post('description'),
                'nameOfBusiness' => $this->input->post('nameofbusiness'),
                'emailId' => "",
                'fax' => $_POST['username'],
                'tin' => $_POST['password'],
                'mobileNo' => $this->input->post('mobile'),
                'gender' => $this->input->post('editgender'),
                'dateofbirth' => $this->input->post('editdateofbirth'),
                'status' => $this->input->post('status_edit')
            );
            $this->db->where('ledgerId', $ledgerId);
            $update = $this->db->update('accountledger', $data);
        endif;

        if ($_POST['dr_cr'] == 0):
            $credit = $_POST['opening_balance'];
            $debit = 0.00;
        else:
            $debit = $_POST['opening_balance'];
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

        ccflogdata($this->sessiondata['username'], "accesslog", "customer", "Customer: " . $_POST['customer_name'] . " updated");
        $searchId = $this->db->query("select * from ledgerposting where ledgerId = '$ledgerId' AND voucherType = 'Opening Balance'");
        if ($searchId->num_rows() > 0):
            $this->db->where('ledgerId', $ledgerId);
            $this->db->where('voucherType', 'Opening Balance');
            $saveledgerinfo = $this->db->update('ledgerposting', $dataforledgerposting);
        else:
            $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerpostingInsert);
        endif;
        if ($saveledgerinfo && $update):
            return true;
        else:
            return false;
        endif;
    }

    public function customerNameCheck() {
        $customerName = $this->input->post('suppname');
        $queryresult = $this->db->query("select * from accountledger where 	acccountLedgerName = '$customerName'");
        if ($queryresult->num_rows() > 0):
            return 'false';
        else:
            return 'true';
        endif;
    }

}

?>