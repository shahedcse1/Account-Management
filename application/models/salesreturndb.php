<?php

class Salesreturndb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function salesreturnadd(){
        // single row info
//        $this->input->post('count_product');
//        $this->input->post('purchaseDetailsId1');
//        $this->input->post('product_id1');
//        $this->input->post('qty1');
//        $this->input->post('returnqty1');
//        $this->input->post('unit_id1');
//        $this->input->post('rate1');
//        $this->input->post('salerate1');
//        $this->input->post('vat1');
//        $this->input->post('discountsingle1');
        //common  data
//        $this->input->post('ladger_id');
//        $this->input->post('company_id');
//        $this->input->post('invoice_date');
//        $this->input->post('invoive_number');
//        $this->input->post('corparty_account');
//        $this->input->post('purchasemasterid');
//        //net info
//        $this->input->post('total_amout');
//        $this->input->post('total_vat');
//        $this->input->post('grandtotal');
//        $this->input->post('discount');
//        $this->input->post('net_amout');
//        $this->input->post('description');

        $count=$this->input->post('count_product');
        //===================1st tbl PurchaseMaster
        $data1 = array(
            'salesMasterId' => $this->input->post('salesMasterId'),
            'date' => $this->input->post('invoice_date'),
            'description' => $this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->insert('salesreturnmaster', $data1);

        //Query purchaseMasterId
        $query1=$this->db->query("SELECT MAX(salesReturnMasterId) FROM salesreturnmaster ");
        $row1 = $query1->row_array();
        $salesReturnMasterId=$row1['MAX(salesReturnMasterId)'];

        //===================2nd tbl PurchaseDetails
        for($i=1;$i<=$count;$i++){
            $returnqty=$this->input->post('returnqty'.$i);
            if($returnqty==""){
                $qtyreturn= 0;
            }else{
                $qtyreturn=$this->input->post('returnqty'.$i);
            }
            $data2 = array(
                'salesReturnMasterId' =>$salesReturnMasterId ,
                'salesDetailsId' => $this->input->post('salesDetailsId'.$i),
                'returnedQty' =>$qtyreturn,
                'returnedFreeQty' => $this->input->post('net_amout'),
                'returnRate' => $this->input->post('rate' . $i),
                'description' => $this->input->post('description'),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('salesreturndetails', $data2);
        }

        //3rd tbl ledgerposting
        $data31 = array(
            'voucherNumber' => $salesReturnMasterId,
            'ledgerId' => 3,
            'voucherType' => "Sales Return",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' =>"By Sales return",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $salesReturnMasterId,
            'ledgerId' => $this->input->post('ladger_id'),
            'voucherType' => "Sales Return",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' =>"By Sales return",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->insert('ledgerposting', $data31);
        $this->db->insert('ledgerposting', $data32);

        //4th table stockposting
        //Product batch id
        for($i=1;$i<=$count;$i++){
            $product_id=$this->input->post('product_id'.$i);
            //Query productBatchId
            $query2=$this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_id'");
            $row2 = $query2->row_array();
            $productBatchId=$row2['productBatchId'];
            $productBatchIdall[]=$productBatchId;
        }
        array_unshift($productBatchIdall , 'item1');

        for($i=1;$i<=$count;$i++){
            if($returnqty==""){
                $qtyreturn= 0;
            }else{
                $qtyreturn=$this->input->post('returnqty'.$i);
            }
            $data4 = array(
                'voucherNumber' => $salesReturnMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => $this->input->post('returnqty'.$i),
                'outwardQuantity' => 0,
                'voucherType' =>"Sales Return",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit'.$i),
                'rate' => $this->input->post('rate'.$i),
                'defaultInwardQuantity' =>$qtyreturn,
                'defaultOutwardQuantity' =>0,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('stockposting', $data4);
        }

    }


    public function salesreturnedit(){

        $count=$this->input->post('count_product');
        $salesMasterId=$this->input->post('salesMasterId');
        //===================1st tbl PurchaseMaster
        $data1 = array(
            'salesMasterId' => $this->input->post('salesMasterId'),
            'date' => $this->input->post('invoice_date'),
            'description' => $this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('salesMasterId',$salesMasterId );
        $this->db->update('salesreturnmaster', $data1);

        //Query purchaseMasterId
        $query1=$this->db->query("SELECT salesReturnMasterId FROM salesreturnmaster  WHERE salesMasterId='$salesMasterId'");
        $row1 = $query1->row_array();
        $salesReturnMasterId=$row1['salesReturnMasterId'];

        //===================2nd tbl PurchaseDetails
        for($i=1;$i<=$count;$i++){
            $returnqty=$this->input->post('returnqty'.$i);
            if($returnqty==""){
                $qtyreturn= 0;
            }else{
                $qtyreturn=$this->input->post('returnqty'.$i);
            }
            
            $salesDetailsId=$this->input->post('salesDetailsId'.$i);
            $data2 = array(
                //'salesReturnDetailsId' =>$salesReturnMasterId ,
                'salesDetailsId' => $this->input->post('salesDetailsId'.$i),
                'returnedQty' =>$qtyreturn,
                'returnedFreeQty' => $this->input->post('net_amout'),
                'returnRate' => $this->input->post('rate' . $i),
                'description' => $this->input->post('description'),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('salesDetailsId',$salesDetailsId );
            $this->db->update('salesreturndetails', $data2);
        }

        //3rd tbl ledgerposting
        $ledgerPostingId=$this->input->post('ledgerPostingId');
        $data31 = array(
            'voucherNumber' => $salesReturnMasterId,
            'ledgerId' => 3,
            'voucherType' => "Sales Return",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' =>"By Sales return",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $salesReturnMasterId,
            'ledgerId' => $this->input->post('ladger_id'),
            'voucherType' => "Sales Return",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' =>"By Sales return",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->where('ledgerPostingId', $ledgerPostingId);
        $this->db->update('ledgerposting', $data31);

        $this->db->where('ledgerPostingId', $ledgerPostingId+1);
        $this->db->update('ledgerposting', $data32);

        //4th table stockposting
        //Product batch id
        for($i=1;$i<=$count;$i++){
            $product_id=$this->input->post('product_id'.$i);
            //Query productBatchId
            $query2=$this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_id'");
            $row2 = $query2->row_array();
            $productBatchId=$row2['productBatchId'];
            $productBatchIdall[]=$productBatchId;
        }
        array_unshift($productBatchIdall , 'item1');

        for($i=1;$i<=$count;$i++){
            $serialNumber[$i]=$this->input->post('serialNumber'.$i);
            if($returnqty==""){
                $qtyreturn= 0;
            }else{
                $qtyreturn=$this->input->post('returnqty'.$i);
            }
            $data4 = array(
                'voucherNumber' => $salesReturnMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => $this->input->post('returnqty'.$i),
                'outwardQuantity' => 0,
                'voucherType' =>"Sales Return",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit'.$i),
                'rate' => $this->input->post('rate'.$i),
                'defaultInwardQuantity' =>$qtyreturn,
                'defaultOutwardQuantity' =>0,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('serialNumber', $serialNumber[$i]);
            $this->db->where('voucherType',"Sales Return");
            $status = $this->db->update('stockposting', $data4);
            print_r($status);
        }

    }

}