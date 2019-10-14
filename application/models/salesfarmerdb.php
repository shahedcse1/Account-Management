<?php

class Salesfarmerdb extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

//============================================================add data=================================================================================================//
    function addsales() {
        $count = $this->input->post('count_product');
        //===================1st tbl salesreadystockmaster==============================================================
        for ($i = 1; $i <= $count; $i++) {
            $data1 = array(
                'date' => $this->input->post('invoice_date'),
                'ledgerId' => $this->input->post('farmer'),
                'farmerRate' => $this->input->post('ratepurchase'),
                'kg' => $this->input->post('unit' . $i),
                'pcs' => $this->input->post('qty' . $i),
                'amount' => $this->input->post('amountpurchase' . $i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('salesreadystockmaster', $data1);

            //Query purchaseMasterId
            $query1 = $this->db->query("SELECT MAX(salesReadyStockMasterId) FROM salesreadystockmaster ");
            $row1 = $query1->row_array();
            $salesReadyStockMasterId = $row1['MAX(salesReadyStockMasterId)'];
            $salesReadyStockMasterIdall[] = $salesReadyStockMasterId;
        }
        array_unshift($salesReadyStockMasterIdall, 'item1');
        //===================2nd tbl salesreadystockdetails===========================================================
        for ($i = 1; $i <= $count; $i++) {
            $data2 = array(
                'salesReadyStockMasterId' => $salesReadyStockMasterIdall[$i],
                'ledgerId' => $this->input->post('corparty_account' . $i),
                'productBatchId' => 1,
                'qty' => $this->input->post('unit' . $i), //kg
                'pcs' => $this->input->post('qty' . $i), //pcs
                'rate' => $this->input->post('rate' . $i), //sale rate
                'unitId' => 16,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('salesreadystockdetails', $data2);
        }


        //======================3rd tbl ledgerposting========================================================
        for ($i = 1; $i <= $count; $i++) {
            $data31 = array(
                'voucherNumber' => $salesReadyStockMasterIdall[$i],
                'ledgerId' => 1,
                'voucherType' => "Ready Stock Purchase",
                'debit' => $this->input->post('amountpurchase' . $i),
                'credit' => 0,
                'description' => "By Ready Stock Purchase",
                'date' => $this->input->post('invoice_date'),
                'companyId' => $this->input->post('company_id')
            );
            $data32 = array(
                'voucherNumber' => $salesReadyStockMasterIdall[$i],
                'ledgerId' => $this->input->post('farmer'),
                'voucherType' => "Ready Stock Purchase",
                'debit' => 0,
                'credit' => $this->input->post('amountpurchase' . $i),
                'description' => "By Ready Stock Purchase",
                'date' => $this->input->post('invoice_date'),
                'companyId' => $this->input->post('company_id')
            );
            $data33 = array(
                'voucherNumber' => $salesReadyStockMasterIdall[$i],
                'ledgerId' => $this->input->post('corparty_account' . $i),
                'voucherType' => "Ready Stock Sale",
                'debit' => $this->input->post('amount' . $i),
                'credit' => 0,
                'description' => "By Ready Stock Sale",
                'date' => $this->input->post('invoice_date'),
                'companyId' => $this->input->post('company_id')
            );
            $data34 = array(
                'voucherNumber' => $salesReadyStockMasterIdall[$i],
                'ledgerId' => 3,
                'voucherType' => "Ready Stock Sale",
                'debit' => 0,
                'credit' => $this->input->post('amount' . $i),
                'description' => "By Ready Stock Sale",
                'date' => $this->input->post('invoice_date'),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('ledgerposting', $data31);
            $this->db->insert('ledgerposting', $data32);
            $this->db->insert('ledgerposting', $data33);
            $this->db->insert('ledgerposting', $data34);
        }
    }

//============================================================Edit data=================================================================================================//
    function editsales() {
        $salesReadyStockMasterId = $this->input->post('salesReadyStockMasterId');

        //===================1st tbl salesreadystockmaster==============================================================
        $data1 = array(
            'date' => $this->input->post('invoice_date'),
            'ledgerId' => $this->input->post('farmer'),
            'farmerRate' => $this->input->post('ratepurchase'),
            'kg' => $this->input->post('kg'),
            'pcs' => $this->input->post('qty'),
            'amount' => $this->input->post('amountpurchase'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('salesReadyStockMasterId', $salesReadyStockMasterId);
        $this->db->update('salesreadystockmaster', $data1);

        //===================2nd tbl salesreadystockdetails===========================================================
        $data2 = array(
            'ledgerId' => $this->input->post('ledgerid'),
            'qty' => $this->input->post('kg'), //kg
            'pcs' => $this->input->post('qty'), //pcs
            'rate' => $this->input->post('rate'), //sale rate
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('salesReadyStockMasterId', $salesReadyStockMasterId);
        $this->db->update('salesreadystockdetails', $data2);

        //======================3rd tbl ledgerposting========================================================
        $ledgerPostingId = $this->input->post('ledgerPostingId');

        $data31 = array(
            'voucherNumber' => $salesReadyStockMasterId,
            'ledgerId' => 1,
            'voucherType' => "Ready Stock Purchase",
            'debit' => $this->input->post('amountpurchase'),
            'credit' => 0,
            'description' => "By Ready Stock Purchase",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $salesReadyStockMasterId,
            'ledgerId' => $this->input->post('farmer'),
            'voucherType' => "Ready Stock Purchase",
            'debit' => 0,
            'credit' => $this->input->post('amountpurchase'),
            'description' => "By Ready Stock Purchase",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data33 = array(
            'voucherNumber' => $salesReadyStockMasterId,
            'ledgerId' => $this->input->post('ledgerid'),
            'voucherType' => "Ready Stock Sale",
            'debit' => $this->input->post('amount'),
            'credit' => 0,
            'description' => "By Ready Stock Sale",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data34 = array(
            'voucherNumber' => $salesReadyStockMasterId,
            'ledgerId' => 3,
            'voucherType' => "Ready Stock Sale",
            'debit' => 0,
            'credit' => $this->input->post('amount'),
            'description' => "By Ready Stock Sale",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('ledgerPostingId', $ledgerPostingId - 2);
        $this->db->update('ledgerposting', $data31);

        $this->db->where('ledgerPostingId', $ledgerPostingId - 1);
        $this->db->update('ledgerposting', $data32);

        $this->db->where('ledgerPostingId', $ledgerPostingId);
        $this->db->update('ledgerposting', $data33);

        $this->db->where('ledgerPostingId', $ledgerPostingId + 1);
        $this->db->update('ledgerposting', $data34);
    }

    public function purchaseNameCheck() {
        $purchaseName = $this->input->post('suppname');
        $queryresult = $this->db->query("select * from accountledger where 	acccountLedgerName = '$purchaseName'");
        if ($queryresult->num_rows() > 0):
            return 'false';
        else:
            return 'true';
        endif;
    }

}

?>