<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Damagestock extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('damagestockdb');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['title'] = "Damage Stock";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "damagestock";
        $data['baseurl'] = $this->config->item('base_url');

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):

            //Session for add data
            if (isset($this->session->userdata['dataaddedpurchase'])) {
                if ($this->session->userdata['dataaddedpurchase'] != NULL && $this->session->userdata['dataaddedpurchase'] == 'added') {
                    $data['data_added'] = $this->session->userdata('dataaddedpurchase');
                    $this->session->unset_userdata('dataaddedpurchase');
                }
            }
            //Session for edited
            if (isset($this->session->userdata['dataaddedpurchase'])) {
                if ($this->session->userdata['dataaddedpurchase'] != NULL && $this->session->userdata['dataaddedpurchase'] == 'edited') {
                    $data['data_added'] = $this->session->userdata('dataaddedpurchase');
                    $this->session->unset_userdata('dataaddedpurchase');
                }
            }
            //Session for deleted
            if (isset($this->session->userdata['dataaddedpurchase'])) {
                if ($this->session->userdata['dataaddedpurchase'] != NULL && $this->session->userdata['dataaddedpurchase'] == 'deleted') {
                    $data['data_added'] = $this->session->userdata('dataaddedpurchase');
                    $this->session->unset_userdata('dataaddedpurchase');
                }
            }
            //Session for notdeleted
            if (isset($this->session->userdata['dataaddedpurchase'])) {
                if ($this->session->userdata['dataaddedpurchase'] != NULL && $this->session->userdata['dataaddedpurchase'] == 'notdeleted') {
                    $data['data_added'] = $this->session->userdata('dataaddedpurchase');
                    $this->session->unset_userdata('dataaddedpurchase');
                }
            }


            //query data to view into table
            $querydamagestcokmaster = $this->db->query("SELECT  *  FROM  damagestcokmaster ORDER BY damageStockMasterId DESC");
            $data['stockmasterinfo'] = $querydamagestcokmaster->result();

            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('damagestock/damagestock', $data);
            $this->load->view('footer', $data);
            $this->load->view('damagestock/script', $data);
        else:
            redirect('login');
        endif;
    }

//  ==================================  Add new==========================================
    public function add_view() {
        $data['title'] = "Damage Stock";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "damagestock";
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):


            // add new unit
            if (isset($this->session->userdata['dataaddedpurchase'])) {
                if ($this->session->userdata['dataaddedpurchase'] != NULL && $this->session->userdata['dataaddedpurchase'] == 'add_unit') {
                    $data['data_added'] = $this->session->userdata('dataaddedpurchase');
                    $this->session->unset_userdata('dataaddedpurchase');
                }
            }
            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];

            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product");
            $data['productinfo'] = $queryp->result();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('damagestock/add_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('damagestock/script', $data);
        else:
            redirect('login');
        endif;
    }

    //query unit id for product
    public function unit_name() {
        $product_id = $this->input->post("product_id");

        //query  unit  name from table
        $queryunit = $this->db->query("SELECT  unitId  FROM  product WHERE productId='$product_id'");
        // $data['unitinfo'] = $queryunit->result();
        $row1 = $queryunit->row_array();
        $unitId = $row1['unitId'];

        //query  unit  name from table
        $queryunitname = $this->db->query("SELECT  unitName  FROM  unit WHERE unitId='$unitId'");
        $row2 = $queryunitname->row_array();
        $unitName = $row2['unitName'];
        echo $unitId . "," . $unitName;
    }

    public function add_view_table() {
        $product_name = $this->input->post('product_name');
        $unit = $this->input->post('unit');
        $count = $this->input->post('count');

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product WHERE productId='$product_name'");
            $row1 = $queryp->row_array();
            $productName = $row1['productName'];

            //query  unit  name from table
            $queryunit = $this->db->query("SELECT  *  FROM  unit WHERE unitId='$unit'");
            $row2 = $queryunit->row_array();
            $unitName = $row2['unitName'];

            echo '<tr id="row' . $count . '">
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td id="click" class="edit-field" title="Click for Edit"><span>' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qty' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>
                    <td>' . $unitName . '<input name="unit' . $count . '" id="unit' . $count . '" type="hidden" value="' . $this->input->post('unit') . '"/></td>
                    <td class="edit-field" title="Click for Edit"><span>' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden"  class="edit_input"value="' . $this->input->post('rate') . '"/></td>';
            //Net amount per product
            $qty = $this->input->post('qty');
            $rate = $this->input->post('rate');
            $qtyrate = $qty * $rate;
            $grandtotal = $qtyrate;  //total amount

            echo '<td><span id="product_amount' . $count . '">' . $grandtotal . '</span></td>
               </tr>';

        else:
            redirect('login');
        endif;
    }

    public function add() {
        $data['title'] = "Damage Stock";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "damagestock";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->damagestockdb->adddamagestock();

        $this->session->set_userdata(array('dataaddedpurchase' => 'added'));
        //for log data
        $query1 = $this->db->query("SELECT MAX(damageStockMasterId) FROM damagestcokmaster");
        $row1 = $query1->row_array();
        $damageStockMasterId = $row1['MAX(damageStockMasterId)'];
        ccflogdata($this->sessiondata['username'], "accesslog", "Add Damage Stock", "Add Damage Stock For Voucher No: " . $damageStockMasterId . "");
        redirect('damagestock/damagestock');
    }

//  =============================================  Edit page======================================================
    public function add_view_edit() {
        $data['title'] = "Damage Stock";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "damagestock";
        $data['baseurl'] = $this->config->item('base_url');

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];

            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product");
            $data['products'] = $queryp->result();


            /* ======================= query data from inserted tables=========================== */
            $id = $this->input->get('id');
            //query  from stockmaster
            $querydamagestcok = $this->db->query("SELECT  *  FROM  damagestcokmaster WHERE damageStockMasterId='$id'");
            $data['damagestcokinfo'] = $querydamagestcok->result();

            //for product
            $queryproduct = $this->db->query("SELECT stockposting.serialNumber AS serialNumber,damagestockdetails.damageStockDetailsId as damageStockDetailsId,stockposting.outwardQuantity AS qty,stockposting.unitId AS unit,stockposting.rate AS rate,product.productName AS productName,product.productId AS productId,productbatch.salesRate AS salesRate,unit.unitName AS unitName FROM stockposting  JOIN productbatch ON productbatch.productBatchId = stockposting.productBatchId LEFT JOIN product ON product.productId=productbatch.productId LEFT JOIN unit ON unit.unitId=stockposting.unitId  JOIN damagestockdetails ON damagestockdetails.damageStockMasterId=stockposting.voucherNumber AND damagestockdetails.productBatchId=stockposting.productBatchId WHERE stockposting.voucherNumber='$id' AND stockposting.voucherType='Damage Stock' GROUP BY damagestockdetails.damageStockDetailsId DESC");
            $data['productinfo'] = $queryproduct->result();
            $data['count_product'] = $queryproduct->num_rows();

            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('damagestock/add_view_edit', $data);
            $this->load->view('footer', $data);
            $this->load->view('damagestock/script-edit', $data);
        else:
            redirect('login');
        endif;
    }

    public function dataqueryedit() {
        $product_id = $this->input->post("product_id");
        $unitid = $this->input->post("unitid");

        //query  product  name from table
        $queryp = $this->db->query("SELECT  productName  FROM  product WHERE productId='$product_id'");
        $productinfo = $queryp->row();
        echo $productinfo->productName . ",";

        //query  unit  name from table
        $queryunit = $this->db->query("SELECT  unitName  FROM  unit WHERE unitId='$unitid'");
        $unitinfo = $queryunit->row();
        echo $unitinfo->unitName;
    }

    //===========================edit submit=========================================
    public function edit() {
        $data['title'] = "Damage Stock";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "damagestock";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->damagestockdb->editdamagestock();

        $this->session->set_userdata(array('dataaddedpurchase' => 'edited'));
        ccflogdata($this->sessiondata['username'], "accesslog", "Edit Damage Stock", "Edit Damage Stock For Voucher No: " . $_POST['damageStockMasterId'] . "");
        redirect('damagestock/damagestock');
    }

    //================================================================================Delete data=================================================
    public function delete() {
        $damageStockMasterId = $this->input->post('damageStockMasterId');

        $delete1 = $this->db->query("DELETE FROM damagestcokmaster WHERE damageStockMasterId='$damageStockMasterId'");
        $delete2 = $this->db->query("DELETE FROM damagestockdetails  WHERE damageStockMasterId='$damageStockMasterId'");
        $delete3 = $this->db->query("DELETE FROM stockposting  WHERE voucherNumber='$damageStockMasterId' AND voucherType='Damage Stock'");

        if ($delete1 && $delete2 && $delete3) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete Damage Stock", "Delete Damage Stock For Voucher No: " . $damageStockMasterId . "");
            redirect('damagestock/damagestock');
        }
    }

    //====================================================add new unit==========================================================================

    public function addunit() {
        // $Modalname = $this->input->post('modalname');
        $this->load->model('productunit_model');
        $saveresult = $this->productunit_model->saveproductunit();

        if ($saveresult) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'add_unit'));
            redirect('damagestock/damagestock/add_view');
        }
    }

    //=======================================check checkinvoiceno====================================================================================
    public function checkinvoiceno() {
        $invoiceno = $this->input->post('invoiceno');
        $companyid = $this->input->post('companyid');

        $queryinvoice = $this->db->query("SELECT * FROM purchasemaster WHERE companyId='$companyid' AND purchaseInvoiceNo='$invoiceno'");
        $row = $queryinvoice->row();
        if ($row) {
            echo "found";
        } else {
            echo "notfound";
        }
    }

}
