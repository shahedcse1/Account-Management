<?php

class Supplierdb extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function getLastAccNo()
    {
        return $this->db
            ->select('accNo')
            ->from('accountledger')
            ->where("CHAR_LENGTH(accNo) = 8")
            ->like('accNo', 'S-')
            ->order_by('ledgerId', 'DESC')
            ->limit(1)
            ->get()
            ->row();
    }

    /**
     * @return mixed
     */
    public function addSupplier1()
    {
        $lastSupplierAccNo = $this->getLastAccNo();

        $accNo = '';
        if (count($lastSupplierAccNo)) {
            $accNo = (int)explode('-', $lastSupplierAccNo->accNo)[1] + 1;
            $accNo = 'S-'.str_pad($accNo, 6, '0', STR_PAD_LEFT);
        } else {
            $accNo = 'S-'.str_pad(1, 6, '0', STR_PAD_LEFT);
        }

        $opening_balance = $this->input->post('opening_balance');
        if ($opening_balance == '') {
            $opening_balance = 0.00;
        }
        $data1 = [
            'accNo'              => $accNo,
            'acccountLedgerName' => $this->input->post('supplier_name'),
            'accountGroupId'     => '27',
            'openingBalance'     => $opening_balance,
            'debitOrCredit'      => $this->input->post('dr_cr'),
            'companyId'          => $this->sessiondata['companyid'],
            'status'             => $this->input->post('status')
        ];

        $saveresult = $this->db->insert('accountledger', $data1);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        if ($_POST['dr_cr'] == 0):
            $credit = $_POST['opening_balance'];
            $debit = 0.00;
        else:
            $debit = $_POST['opening_balance'];
            $credit = 0.00;
        endif;

        $mindate = $this->sessiondata['mindate'];
        $newmindate = strtotime($mindate);
        $minModifiedDate = strtotime("-1 day", $newmindate);
        $finalModifiedDate = date("Y-m-d H:i:s", $minModifiedDate);
        $dataforledgerposting = [
            'voucherNumber' => $insert_id,
            'ledgerId'      => $insert_id,
            'voucherType'   => 'Opening Balance',
            'debit'         => $debit,
            'credit'        => $credit,
            'date'          => $finalModifiedDate,
            'companyID'     => $this->sessiondata['companyid']
        ];
        ccflogdata($this->sessiondata['username'], "accesslog", "supplier", "Supplier: " . $this->input->post('supplier_name') . " Added");
        $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerposting);
        return $saveresult;
    }

    /**
     * @param $ledgerId
     * @return mixed
     */
    public function addSupplier2($ledgerId)
    {
        $data2 = [
            'vendorName'     => $this->input->post('supplier_name'),
            'address'        => $this->input->post('address'),
            'country'        => $this->input->post('country'),
            'nameOfBusiness' => $this->input->post('nameofbusiness'),
            'mobileNumber'   => $this->input->post('mobile'),
            'description'    => $this->input->post('description'),
            'ledgerId'       => $ledgerId,
            'companyId'      => $this->sessiondata['companyid']
        ];
        $saveresult = $this->db
            ->insert('vendor', $data2);
        return $saveresult;
    }

    //edit data
    function editSupplier1($ledgerId) {
        $data = array(
            'accNo' => $this->input->post('accountno'),
            'acccountLedgerName' => $this->input->post('supplier_name'),
            'accountGroupId' => '27',
            'openingBalance' => $this->input->post('opening_balance'),
            'debitOrCredit' => $this->input->post('dr_cr'),
            'defaultOrNot' => '0',
            'billByBill' => '1',
             'status' => $this->input->post('status_edit')
        );
        $this->db->where('ledgerId', $ledgerId);
        $update = $this->db->update('accountledger', $data);
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
            'date' => $finalModifiedDate,
            'companyID' => $this->sessiondata['companyid']
        );

        //check if exit or not         
        $searchId = $this->db->query("select * from ledgerposting where ledgerId = '$ledgerId' AND voucherType = 'Opening Balance'");
        if ($searchId->num_rows() > 0):
            $this->db->where('ledgerId', $ledgerId);
            $this->db->where('voucherType', 'Opening Balance');
            $saveledgerinfo = $this->db->update('ledgerposting', $dataforledgerposting);
        else:
            $saveledgerinfo = $this->db->insert('ledgerposting', $dataforledgerpostingInsert);
        endif;
        if ($saveledgerinfo && $update):
            ccflogdata($this->sessiondata['username'], "accesslog", "supplier", "Supplier: " . $_POST['supplier_name'] . " updated");
            return true;
        else:
            return false;
        endif;
    }

    function editSupplier2($ledgerId) {
        $data = array(
            'vendorName' => $this->input->post('supplier_name'),
            'address' => $this->input->post('address'),
            'country' => $this->input->post('country'),
            'nameOfBusiness' => $this->input->post('nameofbusiness'),
            'emailId' => '',
            'mobileNumber' => $this->input->post('mobile'),
            'description' => $this->input->post('description'),
            'ledgerId' => $ledgerId
        );

        $this->db->where('ledgerId', $ledgerId);
        return $this->db->update('vendor', $data);
    }

    public function supplierNameCheck() {
        $supplierName = $this->input->post('suppname');
        $queryresult = $this->db->query("select * from accountledger where 	acccountLedgerName = '$supplierName'");
        if ($queryresult->num_rows() > 0):
            return 'false';
        else:
            return 'true';
        endif;
    }

}

?>