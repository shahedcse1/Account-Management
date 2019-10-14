<?php

class Purchasedb extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    /**
     * Get Last Invoice Number
     * @return mixed
     */
    private function getLastInvNo()
    {
        return $this->db
            ->select('purchaseInvoiceNo')
            ->from('purchasemaster')
            ->like('purchaseInvoiceNo', 'INV-')
            ->order_by('purchaseMasterId', 'DESC')
            ->limit(1)
            ->get()
            ->row();
    }

    public function getSerialSettings()
    {
        return $this->db
            ->select('value')
            ->from('settings')
            ->where('settings_id', 11)
            ->get()
            ->row()
            ->value;
    }

    /**
     * Add Purchase Information
     */
    public function addPurchase()
    {
        /**
         * Insert Data into `purchasemaster` table
         */
        $invoiceStatusId = ($this->input->post('corparty_account') == 2) ? 1 : 3;
        $lastInv = $this->getLastInvNo();
        $invoive_number = '';
        if (count($lastInv)) {
            $invoive_number = (int)explode('-', $lastInv->purchaseInvoiceNo)[1] + 1;
            $invoive_number = 'INV-'.$invoive_number;
        } else {
            $invoive_number = 'INV-1';
        }

        $invoiceDate = date('Y-m-d H:i:s');
        $data1 = [
            'date'              => $invoiceDate,
            'ledgerId'          => $this->input->post('corparty_account'),
            'purchaseInvoiceNo' => $invoive_number,
            'billDiscount'      => $this->input->post('discount'),
            'additionalCost'    => $this->input->post('transport'),
            'description'       => $this->input->post('description'),
            'amount'            => $this->input->post('net_amout'),
            'invoiceStatusId'   => $invoiceStatusId,
            'companyId'         => $this->input->post('company_id')
        ];
        $this->db
            ->insert('purchasemaster', $data1);

        $purchaseMasterId = $this->db
            ->insert_id();

        $purchase = [
            'id'       => $purchaseMasterId,
            'ledgerid' => $this->input->post('corparty_account')
        ];

        /**
         * Insert Data into `productbatch` table
         */
        $count = $this->input->post('count_product');

        for ($i = 1; $i <= $count; $i++) {
            $product_name = $this->input->post('product_name' . $i);
            $data5 = [
                'purchaseRate' => $this->input->post('rate' . $i),
                'salesRate'    => $this->input->post('sale_rate' . $i),
            ];

            $this->db
                ->where('productId', $product_name)
                ->update('productbatch', $data5);

            /**
             * Insert Data into `purchasedetails` table
             */
            $productBatchId = $this->db
                ->select('productBatchId')
                ->from('productbatch')
                ->where('productId', $product_name)
                ->get()
                ->row()
                ->productBatchId;

            $data2 = [
                'purchaseMasterId' => $purchaseMasterId,
                'productBatchId'   => $productBatchId,
                'productserial'    => $this->input->post('serial' . $i) ? $this->input->post('serial' . $i) : '',
                'rate'             => $this->input->post('rate' . $i),
                'qty'              => $this->input->post('qty' . $i),
                'freeQty'          => $this->input->post('freeqty' . $i),
                'taxIncludedOrNot' => 1,
                'companyId'        => $this->input->post('company_id')
            ];
            $this->db
                ->insert('purchasedetails', $data2);

            /**
             * Insert Data into `stockposting` table
             */
            $freeqty = $this->input->post('freeqty' . $i);
            $qty = $this->input->post('qty' . $i);
            $totalqty = $freeqty + $qty;
            $data4 = [
                'voucherNumber'          => $purchaseMasterId,
                'productBatchId'         => $productBatchId,
                'inwardQuantity'         => $totalqty,
                'outwardQuantity'        => 0,
                'voucherType'            => "Purchase Invoice",
                'date'                   => $invoiceDate,
                'unitId'                 => $this->input->post('unit' . $i),
                'rate'                   => $this->input->post('rate' . $i),
                'defaultInwardQuantity'  => $totalqty,
                'defaultOutwardQuantity' => 0,
                'companyId'              => $this->input->post('company_id')
            ];
            $this->db
                ->insert('stockposting', $data4);
        }

        /**
         * Insert Data into `ledgerposting` table
         */
        $data31 = [
            'voucherNumber' => $purchaseMasterId,
            'ledgerId'      => 1,
            'voucherType'   => "Purchase Invoice",
            'debit'         => $this->input->post('net_amout'),
            'credit'        => 0,
            'description'   => "By purchase",
            'date'          => $invoiceDate,
            'companyId'     => $this->input->post('company_id')
        ];
        $ledgerpostingsts1 = $this->db
            ->insert('ledgerposting', $data31);

        $data32 = [
            'voucherNumber' => $purchaseMasterId,
            'ledgerId'      => $this->input->post('corparty_account'),
            'voucherType'   => "Purchase Invoice",
            'debit'         => 0,
            'credit'        => $this->input->post('net_amout'),
            'description'   => "By purchase",
            'date'          => $invoiceDate,
            'companyId'     => $this->input->post('company_id')
        ];
        $ledgerpostingsts2 = $this->db
            ->insert('ledgerposting', $data32);

        ($ledgerpostingsts1 && $ledgerpostingsts2)
            ? $this->session->set_userdata(array('dataaddedpurchase' => 'added'))
            : $this->session->set_userdata(array('dataaddedpurchase' => 'adderror'));

        /**
         * log data
         */
        ccflogdata($this->sessiondata['username'], "accesslog", "Add purchase", "New purchase For Voucher No: " . $purchaseMasterId . "");

        return $purchase;
    }


    //================================================================edit data========================================================================================//
    //edit data
    // single row info
//        $this->input->post('count_product');
//        $this->input->post('purchaseDetailsId1');
//        $this->input->post('product_id1');
//        $this->input->post('qty1');
//        $this->input->post('unit_id1');
//        $this->input->post('rate1');
//        $this->input->post('salerate1');
    //common  data
//        $this->input->post('purchaseMasterId');
//        $this->input->post('company_id');
//        $this->input->post('invoice_date');
//        $this->input->post('invoive_number');
//        $this->input->post('corparty_account');
//        //net info
//        $this->input->post('total_amout');
//        $this->input->post('grandtotal');
//        $this->input->post('discount');
//        $this->input->post('net_amout');
//        $this->input->post('description');
    function editPurchase() {

        $count = $this->input->post('count_product');
        $purchaseMasterId = $this->input->post('purchaseMasterId');

        //===================1st tbl PurchaseMaster
        if ($this->input->post('corparty_account') == 2) {
            $invoiceStatusId = 1;
        } else {
            $invoiceStatusId = 3;
        }
        $invoive_number = $this->input->post('invoive_number');
        $data1 = array(
            'date' => $this->input->post('invoice_date'),
            'ledgerId' => $this->input->post('corparty_account'),
            'purchaseInvoiceNo' => $invoive_number,
            'billDiscount' => $this->input->post('discount'),
             'additionalCost' => $this->input->post('transport'),
            'description' => $this->input->post('description'),
            'amount' => $this->input->post('net_amout'),
            'invoiceStatusId' => $invoiceStatusId,
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('purchaseMasterId', $purchaseMasterId);
        $this->db->update('purchasemaster', $data1);

        //====================5th tbl ProductBatch update only
        for ($i = 1; $i <= $count; $i++) {
            $product_name = $this->input->post('product_id' . $i);
            $data5 = array(
                'purchaseRate' => $this->input->post('rate' . $i),
                'salesRate' => $_POST['salerate'][$i - 1]
            );
            $this->db->where('productId', $product_name);
            $this->db->update('productbatch', $data5);

            //Query productBatchId
            $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
            $row2 = $query2->row_array();
            $productBatchId = $row2['productBatchId'];
            $productBatchIdall[] = $productBatchId;
        }
        array_unshift($productBatchIdall, 'item1');

        //===================2nd tbl PurchaseDetails

        for ($i = 1; $i <= $count; $i++) {
            #$purchaseDetailsId[$i]=$this->input->post('purchaseDetailsId'.$i);
            $data2 = array(
                'purchaseMasterId' => $purchaseMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'rate' => $this->input->post('rate' . $i),
                'qty' => $this->input->post('qty' . $i),
                'freeQty' => $this->input->post('freeqty' . $i),
                'taxIncludedOrNot' => 1,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('purchaseDetailsId', $_POST['purchaseDetailsId'][$i - 1]);
            $this->db->update('purchasedetails', $data2);
        }

        //3rd tbl ledgerposting
        $ledgerPostingId = $this->input->post('ledgerPostingId');
        $data31 = array(
            'voucherNumber' => $purchaseMasterId,
            'ledgerId' => 1,
            'voucherType' => "Purchase Invoice",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' => "By purchase",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $purchaseMasterId,
            'ledgerId' => $this->input->post('corparty_account'),
            'voucherType' => "Purchase Invoice",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' => "By purchase",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->where('ledgerPostingId', $ledgerPostingId);
        $this->db->update('ledgerposting', $data31);

        $this->db->where('ledgerPostingId', $ledgerPostingId + 1);
        $this->db->update('ledgerposting', $data32);


        //4th table stockposting
        for ($i = 1; $i <= $count; $i++) {
            #$purchaseDetailsId[$i]=$this->input->post('purchaseDetailsId'.$i);
            $freeqty = $this->input->post('freeqty' . $i);
            $qty = $this->input->post('qty' . $i);
            $totalqty = $freeqty + $qty;
            $data4 = array(
                'voucherNumber' => $purchaseMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => $totalqty,
                'outwardQuantity' => 0,
                'voucherType' => "Purchase Invoice",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit_id' . $i),
                'rate' => $this->input->post('rate' . $i),
                'defaultInwardQuantity' => $totalqty,
                'defaultOutwardQuantity' => 0,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('serialNumber', $_POST['serialnumber'][$i - 1]);
            $this->db->where('voucherType', "Purchase Invoice");
            $this->db->update('stockposting', $data4);
        }

        //6th PartyBalance
        if ($this->input->post('corparty_account') != 2) {
            $data6 = array(
                'date' => $this->input->post('invoice_date'),
                'ledgerId' => $this->input->post('corparty_account'),
                'voucherType' => "Purchase Invoice",
                'voucherNo' => $purchaseMasterId,
                'againstVoucherType' => "NA",
                'againstvoucherNo' => "NA",
                'referenceType' => "New",
                'debit' => 0,
                'credit' => $this->input->post('net_amout'),
                'optional' => 0,
                'creditPeriod' => 0,
                'branchId' => 1,
                'extraDate' => date('m-d-Y h:i:s a', time()),
                'currecyConversionId' => 1,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('voucherNo', $purchaseMasterId);
            $this->db->where('voucherType', "Purchase Invoice");
            $this->db->update('partybalance', $data6);
        }
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