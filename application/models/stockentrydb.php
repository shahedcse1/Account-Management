<?php

class Stockentrydb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

//============================================================add data=================================================================================================//
    function addpurchase(){
        $count=$this->input->post('count_product');
        //===================1st tbl PurchaseMaster
        $data1 = array(
            'date' => $this->input->post('invoice_date'),
            'description' =>$this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->insert('stockmaster', $data1);

        //Query purchaseMasterId
        $query1=$this->db->query("SELECT MAX(stockMasterId) FROM stockmaster");
        $row1 = $query1->row_array();
        $stockMasterId=$row1['MAX(stockMasterId)'];

        //====================5th tbl ProductBatch update only
        for($i=1;$i<=$count;$i++){
            $product_name=$this->input->post('product_name'.$i);
            $data5 = array(
                'batchName' => "NA",
                'expiryDate' => "1753-01-01 00:00:00.000",
                'MRP' => 0,
                'companyId' =>$this->input->post('company_id'),
                'purchaseRate' => $this->input->post('rate'.$i),
                'salesRate' => $this->input->post('sale_rate'.$i),
            );
            $salerate=$this->input->post('sale_rate'.$i);

            if(!empty($salerate) || $salerate!=0){
                $this->db->where('productId', $product_name);
                $this->db->update('productbatch', $data5);
              }

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
                'stockMasterId' =>$stockMasterId ,
                'productBatchId' => $productBatchIdall[$i],
                'rate' => $this->input->post('rate'.$i),
                'qty' => $this->input->post('qty'.$i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->insert('stockdetails', $data2);
         }

        //==================4th table stockposting
        for($i=1;$i<=$count;$i++){

        $this->sessiondata = $this->session->userdata('logindata');
        $data=$this->sessiondata['mindate'];
        $before_date = date('Y-m-d H:i:s', strtotime($data . ' - 1 day'));
         $data4 = array(
            'voucherNumber' => $stockMasterId,
            'productBatchId' => $productBatchIdall[$i],
            'inwardQuantity' => $this->input->post('qty'.$i),
            'outwardQuantity' => 0,
            'voucherType' =>"Stock Entry",
            'date' => $before_date,
            'unitId' => $this->input->post('unit'.$i),
            'rate' => $this->input->post('rate'.$i),
            'defaultInwardQuantity' => $this->input->post('qty'.$i),
            'defaultOutwardQuantity' => 0,
            'companyId' => $this->input->post('company_id')
        );
       $this->db->insert('stockposting', $data4);
        }

    }

    //================================================================edit data========================================================================================//

    function editPurchase(){

        $count=$this->input->post('count_product');
        $stockMasterId=$this->input->post('stockMasterId');

        //===================1st tbl PurchaseMaster
        $data1 = array(
            'date' => $this->input->post('invoice_date'),
            'description' =>$this->input->post('description'),
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('stockMasterId', $stockMasterId);
        $this->db->update('stockmaster', $data1);

        //====================5th tbl ProductBatch update only
        for($i=1;$i<=$count;$i++){
            $product_name=$this->input->post('product_id'.$i);

            $salerate=$this->input->post('salerate'.$i);

            if(!empty($salerate) || $salerate!=0){
            $data5 = array(
                'batchName' => "NA",
                'expiryDate' => "1753-01-01 00:00:00.000",
                'MRP' => 0,
                'companyId' =>$this->input->post('company_id'),
                'purchaseRate' => $this->input->post('rate'.$i),
                'salesRate' => $this->input->post('salerate'.$i),
            );
            $this->db->where('productId', $product_name);
            $this->db->update('productbatch', $data5);
            }

            //Query productBatchId
            $query2=$this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
            $row2 = $query2->row_array();
            $productBatchId=$row2['productBatchId'];
            $productBatchIdall[]=$productBatchId;
        }
        array_unshift($productBatchIdall,'item1');

        //===================2nd tbl PurchaseDetails

        for($i=1;$i<=$count;$i++){
            $stockDetailsId[$i]=$this->input->post('stockDetailsId'.$i);
            $data2 = array(
                'stockMasterId' =>$stockMasterId ,
                'productBatchId' => $productBatchIdall[$i],
                'rate' => $this->input->post('rate'.$i),
                'qty' => $this->input->post('qty'.$i),
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('stockDetailsId', $stockDetailsId[$i]);
            $this->db->update('stockdetails', $data2);
        }

        //4th table stockposting
        for($i=1;$i<=$count;$i++){
            $serialNumber[$i]=$this->input->post('serialNumber'.$i);
            $data42 = array(
                'voucherNumber' => $stockMasterId,
                'productBatchId' => $productBatchIdall[$i],
                'inwardQuantity' => $this->input->post('qty'.$i),
                'outwardQuantity' => 0,
                'voucherType' =>"Stock Entry",
                'unitId' => $this->input->post('unit_id'.$i),
                'rate' => $this->input->post('rate'.$i),
                'defaultInwardQuantity' => $this->input->post('qty'.$i),
                'defaultOutwardQuantity' => 0,
                'companyId' => $this->input->post('company_id')
            );

            $this->db->where('serialNumber', $serialNumber[$i]);
            $this->db->where('voucherType', "Stock Entry");
            $this->db->update('stockposting', $data42);
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