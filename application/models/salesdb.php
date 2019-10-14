<?php

class Salesdb extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    //add data
    // single row info
//        $this->input->post('count_product');
//        $this->input->post('product_name');
//        $this->input->post('qty');
//        $this->input->post('unit');
//        $this->input->post('rate');
    //common  data
//        $this->input->post('company_id');
//        $this->input->post('invoice_date');
//        $this->input->post('order_no');
//        $this->input->post('corparty_account');
//        //net info
//        $this->input->post('total_amout');
//        $this->input->post('grandtotal');
//        $this->input->post('discount');
//        $this->input->post('paid_amount');
//        $this->input->post('net_amout');
//        $this->input->post('description');
//============================================================add data=================================================================================================//
    function addsales() {
        $count = $this->input->post('count_product');
//        $discount = $this->input->post('discount');
//        if ($discount>0):
//            $discount = $this->input->post('discount');
//        else:
//            $discount = '';
//        endif;
        //===================1st tbl salesmaster==============================================================
        if ($this->input->post('corparty_account') == 2) {
            $invoiceStatusId = 1;
        } else {
            $invoiceStatusId = 3;
        }
        $data1 = array(
            'salesInvoiceNo' => "",
            'date' => $this->input->post('invoice_date'),
            'ledgerId' => $this->input->post('corparty_account'),
            'salesManId' => $this->input->post('salesMan'),
            'doctorId' => 0,
            'salesManId' => 1,
            'patientId' => 1,
            'billDiscount' => $this->input->post('discount'),
            'tranportation' => $this->input->post('transport'),
            'description' => $this->input->post('description'),
            'driver_name' => $this->input->post('driver_name'),
            'voucherNo' => "",
            'suffixPrefixId' => "NA",
            'discountPer' => 0,
            'type' => "Sales",
            'status' => $invoiceStatusId,
            'amount' => $this->input->post('net_amout'),
            'bankCharges' => 0,
            'pricingLevelId' => 1,
            'orderNo' => $this->input->post('order_no'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->insert('salesmaster', $data1);

        //Query purchaseMasterId
        $query1 = $this->db->query("SELECT MAX(salesMasterId) FROM salesmaster ");
        $row1 = $query1->row_array();
        $salesMasterId = $row1['MAX(salesMasterId)'];
        $this->db->query("UPDATE salesmaster SET salesInvoiceNo='$salesMasterId',voucherNo='$salesMasterId' WHERE salesMasterId='$salesMasterId'");



        //======================Query  ProductBatch Id From productbatch==================================================================
        for ($i = 1; $i <= $count; $i++) {
            $product_name = $this->input->post('product_name' . $i);
            //Query productBatchId
            $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
            if ($query2->num_rows() > 0) {
                $row2 = $query2->row_array();
                $productBatchId = $row2['productBatchId'];
            } else {
                $productBatchId = "";
            }
            $productBatchIdall[] = $productBatchId;
        }
        array_unshift($productBatchIdall, 'item1');

        //===================2nd tbl Salesdetails===========================================================
        for ($i = 1; $i <= $count; $i++) {
            $data2 = array(
                'salesMasterId' => $salesMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'rate' => $this->input->post('rate' . $i),
                'qty' => $this->input->post('qty' . $i),
                'taxIncludedOrNot' => 1,
                'unitId' => $this->input->post('unit' . $i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('salesdetails', $data2);
        }

        //======================3rd tbl ledgerposting========================================================
        $data31 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => $this->input->post('corparty_account'),
            'voucherType' => "Sales Invoice",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' => "By Sales",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => 3,
            'voucherType' => "Sales Invoice",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' => "By Sales",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->insert('ledgerposting', $data31);
        $this->db->insert('ledgerposting', $data32);


        //==================================4th table stockposting==============================================================
        for ($i = 1; $i <= $count; $i++) {
            $data4 = array(
                'voucherNumber' => $salesMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => 0,
                'outwardQuantity' => $this->input->post('qty' . $i),
                'voucherType' => "Sales Invoice",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit' . $i),
                'rate' => $this->input->post('rate' . $i),
                'defaultInwardQuantity' => 0,
                'defaultOutwardQuantity' => $this->input->post('qty' . $i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('stockposting', $data4);
        }

        //6th PartyBalance
        /*      if ($this->input->post('corparty_account') != 2) {
          $data6 = array(
          'date' => $this->input->post('invoice_date'),
          'ledgerId' => $this->input->post('corparty_account'),
          'voucherType' => "Sales Invoice",
          'voucherNo' => $salesMasterId,
          'againstVoucherType' => "NA",
          'againstvoucherNo' => "NA",
          'referenceType' => "New",
          'debit' => $this->input->post('net_amout'),
          'credit' => 0,
          'optional' => 0,
          'branchId' => 1,
          'extraDate' => date('m-d-Y h:i:s a', time()),
          'currecyConversionId' => 1,
          'companyId' => $this->input->post('company_id')
          );
          $this->db->insert('partybalance', $data6);
          } */
    }

//============================================================Edit data=================================================================================================//
    function editsales() {

        $count = $this->input->post('count_product');
        $salesMasterId = $this->input->post('salesMasterId');
        //===================1st tbl salesmaster==============================================================
        if ($this->input->post('corparty_account') == 2) {
            $invoiceStatusId = 1;
        } else {
            $invoiceStatusId = 3;
        }
        $data1 = array(
            'salesInvoiceNo' => $salesMasterId,
            'date' => $this->input->post('invoice_date'),
            'ledgerId' => $this->input->post('corparty_account'),
            'salesManId' => $this->input->post('salesMan'),
            'doctorId' => 0,
            'salesManId' => 1,
            'patientId' => 1,
            'billDiscount' => $this->input->post('discount'),
            'tranportation' => $this->input->post('transport'),
            'description' => $this->input->post('description'),
            'voucherNo' => $salesMasterId,
            'suffixPrefixId' => "NA",
            'discountPer' => 0,
            'type' => "Sales",
            'status' => $invoiceStatusId,
            'amount' => $this->input->post('net_amout'),
            'bankCharges' => 0,
            'pricingLevelId' => 1,
            'orderNo' => $this->input->post('order_no'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->where('salesMasterId', $salesMasterId);
        $this->db->update('salesmaster', $data1);

        //======================Query  ProductBatch Id From productbatch==================================================================
        for ($i = 1; $i <= $count; $i++) {
            $product_id = $this->input->post('product_id' . $i);
            //Query productBatchId
            $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_id'");
           if ($query2->num_rows() > 0) {
                $row2 = $query2->row_array();
                $productBatchId = $row2['productBatchId'];
            } else {
                $productBatchId = "";
            }
            $productBatchIdall[] = $productBatchId;
        }
        array_unshift($productBatchIdall, 'item1');

        //===================2nd tbl Salesdetails===========================================================
        $purchasedetials[] = $_POST["purchaseDetailsId"];
        for ($i = 1; $i <= $count; $i++) {
            $data2 = array(
                'salesMasterId' => $salesMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'rate' => $this->input->post('rate' . $i),
                'qty' => $this->input->post('qty' . $i),
                'taxIncludedOrNot' => 1,
                'unitId' => $this->input->post('unit_id' . $i),
                'companyId' => $this->input->post('company_id')
            );
            # print_r($data2);            print_r($_POST["purchaseDetailsId"][$i - 1]); exit();
            $this->db->where('salesDetailsId', $_POST["purchaseDetailsId"][$i - 1]);
            $this->db->update('salesdetails', $data2);
        }

        //======================3rd tbl ledgerposting========================================================
        $ledgerPostingId = $this->input->post('ledgerPostingId');
        $data31 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => $this->input->post('corparty_account'),
            'voucherType' => "Sales Invoice",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' => "By Sales",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => 3,
            'voucherType' => "Sales Invoice",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' => "By Sales",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('ledgerPostingId', $ledgerPostingId);
        $this->db->update('ledgerposting', $data31);

        $this->db->where('ledgerPostingId', $ledgerPostingId + 1);
        $this->db->update('ledgerposting', $data32);


        //==================================4th table stockposting==============================================================
        for ($i = 1; $i <= $count; $i++) {
            $data4 = array(
                'voucherNumber' => $salesMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => 0,
                'outwardQuantity' => $this->input->post('qty' . $i),
                'voucherType' => "Sales Invoice",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit_id' . $i),
                'rate' => $this->input->post('rate' . $i),
                'defaultInwardQuantity' => 0,
                'defaultOutwardQuantity' => $this->input->post('qty' . $i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('serialNumber', $_POST['serialnumber'][$i - 1]);
            $this->db->where('voucherType', "Sales Invoice");
            $this->db->update('stockposting', $data4);
        }

        //6th PartyBalance
        /*    if ($this->input->post('corparty_account') != 2) {
          $data6 = array(
          'date' => $this->input->post('invoice_date'),
          'ledgerId' => $this->input->post('corparty_account'),
          'voucherType' => "Sales Invoice",
          'voucherNo' => $salesMasterId,
          'againstVoucherType' => "NA",
          'againstvoucherNo' => "NA",
          'referenceType' => "New",
          'debit' => $this->input->post('net_amout'),
          'credit' => 0,
          'optional' => 0,
          'branchId' => 1,
          'extraDate' => date('m-d-Y h:i:s a', time()),
          'currecyConversionId' => 1,
          'companyId' => $this->input->post('company_id')
          );
          $this->db->where('voucherNo', $salesMasterId);
          $this->db->where('voucherType', "Sales Invoice");
          $this->db->update('partybalance', $data6);
          } */
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