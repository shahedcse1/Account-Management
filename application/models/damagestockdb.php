<?php

class Damagestockdb extends CI_Model
{

    public function __construct()
    {
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
//        $this->input->post('sale_rate');
      //common  data
//        $this->input->post('company_id');
//        $this->input->post('invoice_date');
//        //net info
//        $this->input->post('net_amout');
//        $this->input->post('description');
//============================================================add data=================================================================================================//
    function adddamagestock(){
        $count=$this->input->post('count_product');
        //===================1st tbl PurchaseMaster
        $data1 = array(
            'date' => $this->input->post('invoice_date'),
            'description' =>$this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->insert('damagestcokmaster', $data1);

        //Query purchaseMasterId
        $query1=$this->db->query("SELECT MAX(damageStockMasterId) FROM damagestcokmaster");
        $row1 = $query1->row_array();
        $damageStockMasterId=$row1['MAX(damageStockMasterId)'];

        //====================5th tbl ProductBatch update only
        for($i=1;$i<=$count;$i++){
            $product_name=$this->input->post('product_name'.$i);
            //Query productBatchId
            $query2=$this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
            $row2 = $query2->row_array();
            $productBatchId=$row2['productBatchId'];
            $productBatchIdall[]=$productBatchId;
        }
        array_unshift($productBatchIdall , 'item1');

        //===================2nd tbl stockdetails
        for($i=1;$i<=$count;$i++){
            $data2 = array(
                'damageStockMasterId' =>$damageStockMasterId ,
                'productBatchId' => $productBatchIdall[$i],
                'unitId' => $this->input->post('unit'.$i),
                'qty' => $this->input->post('qty'.$i),
                'description' => $this->input->post('description'.$i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('damagestockdetails', $data2);
         }

        //==================4th table stockposting
        for($i=1;$i<=$count;$i++){
        $data4 = array(
            'voucherNumber' => $damageStockMasterId,
            'productBatchId' => $productBatchIdall[$i],
            'inwardQuantity' => 0,
            'outwardQuantity' => $this->input->post('qty'.$i),
            'voucherType' =>"Damage Stock",
            'date' => $this->input->post('invoice_date'),
            'unitId' => $this->input->post('unit'.$i),
            'rate' => $this->input->post('rate'.$i),
            'defaultInwardQuantity' => 0,
            'defaultOutwardQuantity' => $this->input->post('qty'.$i),
            'companyId' => $this->input->post('company_id')
        );
       $this->db->insert('stockposting', $data4);
        }

    }

    //================================================================edit data========================================================================================//

    function editdamagestock(){

        $count=$this->input->post('count_product');
        $damageStockMasterId=$this->input->post('damageStockMasterId');

        //===================1st tbl PurchaseMaster
        $data1 = array(
            'date' => $this->input->post('invoice_date'),
            'description' =>$this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('damageStockMasterId', $damageStockMasterId);
        $this->db->update('damagestcokmaster', $data1);

        //====================5th tbl ProductBatch update only
        for($i=1;$i<=$count;$i++){
            $product_name=$this->input->post('product_id'.$i);
            //Query productBatchId
            $query2=$this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
            $row2 = $query2->row_array();
            $productBatchId=$row2['productBatchId'];
            $productBatchIdall[]=$productBatchId;
        }
        array_unshift($productBatchIdall,'item1');

        //===================2nd tbl PurchaseDetails

        for($i=1;$i<=$count;$i++){
            $damageStockDetailsId[$i]=$this->input->post('damageStockDetailsId'.$i);
            $data2 = array(
                'damageStockMasterId' =>$damageStockMasterId ,
                'productBatchId' => $productBatchIdall[$i],
                'unitId' => $this->input->post('unit_id'.$i),
                'qty' => $this->input->post('qty'.$i),
                'description' => $this->input->post('qty'.$i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('damageStockDetailsId', $damageStockDetailsId[$i]);
            $this->db->update('damagestockdetails', $data2);
        }

        //4th table stockposting
        for($i=1;$i<=$count;$i++){
            $serialNumber[$i]=$this->input->post('serialNumber'.$i);
            $data4 = array(
                'voucherNumber' => $damageStockMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => 0,
                'outwardQuantity' => $this->input->post('qty'.$i),
                'voucherType' =>"Damage Stock",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit_id'.$i),
                'rate' => $this->input->post('rate'.$i),
                'defaultInwardQuantity' => 0,
                'defaultOutwardQuantity' => $this->input->post('qty'.$i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('serialNumber', $serialNumber[$i]);
            $this->db->where('voucherType',"Damage Stock");
            $this->db->update('stockposting', $data4);
        }
    }


    public function purchaseNameCheck()
    {
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