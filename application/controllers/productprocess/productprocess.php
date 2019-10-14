<?php

class Productprocess extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
        $this->load->model('productprocessmodel');
        if ($this->sessiondata['status'] == 'login'):
            $accessFlag = 1;
        else:
            $accessFlag = 0;
            redirect('home');
        endif;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Proces A Product";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "productprocess";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $productProcessQry = $this->db->query("SELECT * from productprocess");
            $data['productProcess'] = $productProcessQry->result();
            #$data['ledger'] = $this->ccfcontravoucher->ledgerdata();
            #$data['sortalldata'] = $this->ccfcontravoucher->sortalldata();
            #$data['allledgerdata'] = $this->ccfcontravoucher->allledgerdata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('productprocess/productprocess', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    function add_view_processProduct() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Proces A Product";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "productprocess";
        $companyid = $this->sessiondata['companyid'];
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $rawProductQry = $this->db->query("Select * from product where rawmaterial = '1' AND companyId = '$companyid'");
            $data['rawProductList'] = $rawProductQry->result();
            $rawProductQry = $this->db->query("Select * from product where rawmaterial = '0' AND companyId = '$companyid'");
            $data['productList'] = $rawProductQry->result();
            #$data['sortalldata'] = $this->ccfcontravoucher->sortalldata();
            #$data['allledgerdata'] = $this->ccfcontravoucher->allledgerdata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('productprocess/add_view_processProduct', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function add_processProduct() {
        $radyProductName = $this->input->post('productname');
        $radyProductqty = $this->input->post('radyProductqty');
        $productName = $this->input->post('rawproductId');
        $qty = $this->input->post('qty');

        $cmpid = $this->sessiondata['companyid'];
        $query1 = $this->db->query("SELECT MAX( id ) as pid FROM productprocess");
        $productProcessId = $query1->row()->pid + 1;

        $productlen = sizeof($productName);
        $diffoflen = 10 - $productlen;
        for ($in = 0; $in < $productlen; $in++):
            $productName[$in] = $productName[$in];
            $qty[$in] = $qty[$in];
        endfor;
        for ($ind = $productlen; $ind < ($productlen + $diffoflen); $ind++):
            $productName[$ind] = '';
            $qty[$ind] = '';
        endfor;



        $dataProductprocess = array(
            'rawid1' => $productName[0],
            'rawqty1' => $qty[0],
            'rawid2' => $productName[1],
            'rawqty2' => $qty[1],
            'rawid3' => $productName[2],
            'rawqty3' => $qty[2],
            'rawid4' => $productName[3],
            'rawqty4' => $qty[3],
            'rawid5' => $productName[4],
            'rawqty5' => $qty[4],
            'rawid6' => $productName[5],
            'rawqty6' => $qty[5],
            'rawid7' => $productName[6],
            'rawqty7' => $qty[6],
            'rawid8' => $productName[7],
            'rawqty8' => $qty[7],
            'rawid9' => $productName[8],
            'rawqty9' => $qty[8],
            'rawid10' => $productName[9],
            'rawqty10' => $qty[9],
            'readyid' => $radyProductName,
            'readytqy' => $radyProductqty,
            'date' => date('Y-m-d')
        );
        $saveresult = $this->db->insert('productprocess', $dataProductprocess);
        for ($i = 0; $i < $productlen; $i++):
            $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$productName[$i]'");
            if ($query2->num_rows() > 0):
                $productBatchId = $query2->row()->productBatchId;
            else:
                $productBatchId = '';
            endif;
            $query3 = $this->db->query("SELECT unitId FROM product WHERE productId='$productName[$i]'");
            if ($query3->num_rows() > 0):
                $unitId = $query3->row()->unitId;
            else:
                $unitId = '';
            endif;
            $dataStockposting = array(
                'voucherNumber' => $productProcessId,
                'productBatchId' => $productBatchId,
                'inwardQuantity' => '',
                'outwardQuantity' => $qty[$i],
                'voucherType' => "Process A Product",
                'date' => date('Y-m-d'),
                'unitId' => $unitId,
                'rate' => '',
                'defaultInwardQuantity' => '',
                'defaultOutwardQuantity' => $qty[$i],
                'companyId' => $cmpid
            );
            $saveresult = $this->db->insert('stockposting', $dataStockposting);
        endfor;
        $dataStockposting = array(
            'voucherNumber' => $productProcessId,
            'productBatchId' => $radyProductName,
            'inwardQuantity' => $radyProductqty,
            'outwardQuantity' => '',
            'voucherType' => "Process A Product",
            'date' => date('Y-m-d'),
            'unitId' => $unitId,
            'rate' => '',
            'defaultInwardQuantity' => $radyProductqty,
            'defaultOutwardQuantity' => '',
            'companyId' => $cmpid
        );
        $saveresult = $this->db->insert('stockposting', $dataStockposting);
        if ($saveresult):
            $this->session->set_userdata('success', 'Product information saved successfully');
            redirect('productprocess/productprocess');
        else:
            $this->session->set_userdata('fail', 'Product information save failed');
            redirect('productprocess/productprocess');
        endif;
    }

    public function delete_processProduct() {
        $idproductProcess = $this->input->post('idProductprocess');
        $delete3 = $this->db->query("DELETE FROM productprocess  WHERE id='$idproductProcess'");
        $delete4 = $this->db->query("DELETE FROM stockposting  WHERE voucherType='Process A Product' AND voucherNumber='$idproductProcess'");

        if ($delete3 && $delete4) {
            $this->session->set_userdata('success', 'Product information saved successfully');
            redirect('productprocess/productprocess');
        } else {
            $this->session->set_userdata('fail', 'Product information save failed');
            redirect('productprocess/productprocess');
        }
    }

}
