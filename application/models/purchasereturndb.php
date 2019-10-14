<?php

class Purchasereturndb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function purchasereturnadd(){
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
            'purchaseMasterId' => $this->input->post('purchasemasterid'),
            'date' => $this->input->post('invoice_date'),
            'description' => $this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->insert('purchasereturnmaster', $data1);

        //Query purchaseMasterId
        $query1=$this->db->query("SELECT MAX(purchaseReturnMasterId) FROM purchasereturnmaster ");
        $row1 = $query1->row_array();
        $purchaseReturnMasterId=$row1['MAX(purchaseReturnMasterId)'];

        //===================2nd tbl PurchaseDetails
        for($i=1;$i<=$count;$i++){
            $returnqty=$this->input->post('returnqty'.$i);
            if($returnqty==""){
                $qtyreturn= 0;
            }else{
                $qtyreturn=$this->input->post('returnqty'.$i);
            }
            $data2 = array(
                'purchaseReturnMasterId' =>$purchaseReturnMasterId ,
                'purchaseDetailsId' => $this->input->post('purchaseDetailsId'.$i),
                'returnedQty' =>$qtyreturn,
                'returnedFreeQty' => $this->input->post('net_amout'),
                'description' => $this->input->post('description'),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('purchasereturndetails', $data2);
        }

        //3rd tbl ledgerposting
        $data31 = array(
            'voucherNumber' => $purchaseReturnMasterId,
            'ledgerId' => 1,
            'voucherType' => "Purchase Return",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' =>"By purchase return",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $purchaseReturnMasterId,
            'ledgerId' => $this->input->post('ladger_id'),
            'voucherType' => "Purchase Return",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' =>"By purchase return",
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
                'voucherNumber' => $purchaseReturnMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => 0,
                'outwardQuantity' => $this->input->post('returnqty'.$i),
                'voucherType' =>"Purchase Return",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit'.$i),
                'rate' => $this->input->post('rate'.$i),
                'defaultInwardQuantity' =>0,
                'defaultOutwardQuantity' =>$qtyreturn,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('stockposting', $data4);
        }

    }


    public function purchasereturnedit(){

        $count=$this->input->post('count_product');
        $purchasemasterid=$this->input->post('purchasemasterid');
        //===================1st tbl PurchaseMaster
        $data1 = array(
            'purchaseMasterId' => $this->input->post('purchasemasterid'),
            'date' => $this->input->post('invoice_date'),
            'description' => $this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('purchaseMasterId',$purchasemasterid );
        $this->db->update('purchasereturnmaster', $data1);

        //Query purchaseMasterId
        $query1=$this->db->query("SELECT purchaseReturnMasterId FROM purchasereturnmaster  WHERE purchaseMasterId='$purchasemasterid'");
        $row1 = $query1->row_array();
        $purchaseReturnMasterId=$row1['purchaseReturnMasterId'];

        //===================2nd tbl PurchaseDetails
        for($i=1;$i<=$count;$i++){
            $returnqty=$this->input->post('returnqty'.$i);
            if($returnqty==""){
                $qtyreturn= 0;
            }else{
                $qtyreturn=$this->input->post('returnqty'.$i);
            }

            $purchaseDetailsId=$this->input->post('purchaseDetailsId'.$i);
            $data2 = array(
                'purchaseReturnMasterId' =>$purchaseReturnMasterId ,
                'purchaseDetailsId' => $purchaseDetailsId,
                'returnedQty' =>$qtyreturn,
                'returnedFreeQty' => $this->input->post('net_amout'),
                'description' => $this->input->post('description'),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('purchaseDetailsId',$purchaseDetailsId );
            $this->db->update('purchasereturndetails', $data2);
        }

        //3rd tbl ledgerposting
        $ledgerPostingId=$this->input->post('ledgerPostingId');
        $data31 = array(
            'voucherNumber' => $purchaseReturnMasterId,
            'ledgerId' => 1,
            'voucherType' => "Purchase Return",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' =>"By purchase return",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $purchaseReturnMasterId,
            'ledgerId' => $this->input->post('ladger_id'),
            'voucherType' => "Purchase Return",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' =>"By purchase return",
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
                'voucherNumber' => $purchaseReturnMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => 0,
                'outwardQuantity' =>$qtyreturn,
                'voucherType' =>"Purchase Return",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit'.$i),
                'rate' => $this->input->post('rate'.$i),
                'defaultInwardQuantity' =>0,
                'defaultOutwardQuantity' =>$this->input->post('returnqty'.$i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('serialNumber', $serialNumber[$i]);
            $this->db->where('voucherType', "Purchase Return");
            $this->db->update('stockposting', $data4);
        }

    }

}