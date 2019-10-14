<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stockentry extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('stockentrydb');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['title'] = "Stock Entry";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "stockentry";
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
            $querystockmaster = $this->db->query("SELECT  *  FROM  stockmaster ORDER BY stockMasterId DESC");
            $data['stockmasterinfo'] = $querystockmaster->result();


            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();


            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('stockentry/stockentry', $data);
            $this->load->view('footer', $data);
            $this->load->view('stockentry/script', $data);
        else:
            redirect('login');
        endif;
    }

//  ==================================  Add new==========================================
    public function add_view() {
        $data['title'] = "Stock Entry";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "stockentry";
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
            //query  supplier name from table
            $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId=27 AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['supplierinfo1'] = $query2->result();

            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product");
            $data['productinfo'] = $queryp->result();

            //query  unit  name from table
            $queryunit = $this->db->query("SELECT  *  FROM  unit");
            $data['unitinfo'] = $queryunit->result();


            $query2 = $this->db->query("SELECT  *  FROM  countries");
            $data['countries'] = $query2->result();
            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('stockentry/add_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('stockentry/script', $data);
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
                    <td class="edit-field" title="Click for Edit"><span>' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden"  class="edit_input"value="' . $this->input->post('rate') . '"/></td>
                    <td class="edit-field" title="Click for Edit"><span>' . $this->input->post('sale_rate') . '</span><input name="sale_rate' . $count . '" id="sale_rate' . $count . '"  class="edit_input"type="hidden" value="' . $this->input->post('sale_rate') . '"/></td>';
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

        $data['title'] = "Stock Entry";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "stockentry";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->stockentrydb->addpurchase();

        $this->session->set_userdata(array('dataaddedpurchase' => 'added'));
        //For log
        $query1 = $this->db->query("SELECT MAX(stockMasterId) FROM stockmaster");
        $row1 = $query1->row_array();
        $stockMasterId = $row1['MAX(stockMasterId)'];
        ccflogdata($this->sessiondata['username'], "accesslog", "Add Stock Entry", "Add Stock Entry For Voucher No: " . $stockMasterId . "");
        redirect('stockentry/stockentry');
    }

//  =============================================  Edit page======================================================
    public function add_view_edit() {
        $data['title'] = "Stock Entry";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "stockentry";
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
            $querystockmaster = $this->db->query("SELECT  *  FROM  stockmaster WHERE stockMasterId='$id'");
            $data['stockmasterinfo'] = $querystockmaster->result();

            //for product
            $queryproduct = $this->db->query("SELECT stockposting.serialNumber AS serialNumber,stockdetails.stockDetailsId as stockDetailsId,stockposting.inwardQuantity AS qty,stockposting.unitId AS unit,stockposting.rate AS rate,product.productName AS productName,product.productId AS productId,productbatch.salesRate AS salesRate,unit.unitName AS unitName FROM stockposting  JOIN productbatch ON productbatch.productBatchId = stockposting.productBatchId LEFT JOIN product ON product.productId=productbatch.productId LEFT JOIN unit ON unit.unitId=stockposting.unitId  JOIN stockdetails ON stockdetails.stockMasterId=stockposting.voucherNumber AND stockdetails.productBatchId=stockposting.productBatchId WHERE stockposting.voucherNumber='$id' AND stockposting.voucherType='Stock Entry' GROUP BY stockdetails.stockDetailsId DESC");
            $data['productinfo'] = $queryproduct->result();
            $data['count_product'] = $queryproduct->num_rows();

            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('stockentry/add_view_edit', $data);
            $this->load->view('footer', $data);
            $this->load->view('stockentry/script-edit', $data);
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
        $data['title'] = "Stock Entry";
        $data['active_menu'] = "inventory";
        $data['active_sub_menu'] = "stockentry";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->stockentrydb->editPurchase();

        $this->session->set_userdata(array('dataaddedpurchase' => 'edited'));
        ccflogdata($this->sessiondata['username'], "accesslog", "Edit Stock Entry", "Edit Stock Entry For Voucher No: " . $_POST['stockMasterId'] . "");
        redirect('stockentry/stockentry');
    }

    //================================================================================Delete data=================================================
    public function delete() {
        $stockMasterId = $this->input->post('stockMasterId');

        $delete1 = $this->db->query("DELETE FROM stockmaster WHERE stockMasterId='$stockMasterId'");
        $delete2 = $this->db->query("DELETE FROM stockdetails  WHERE stockMasterId='$stockMasterId'");
        $delete3 = $this->db->query("DELETE FROM stockposting  WHERE voucherNumber='$stockMasterId' AND voucherType='Stock Entry'");

        if ($delete1 && $delete2 && $delete3) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete Stock Entry", "Delete Stock Entry For Voucher No: " . $stockMasterId . "");
            redirect('stockentry/stockentry');
        }
    }

    //====================================================add new unit==========================================================================

    public function addunit() {
        // $Modalname = $this->input->post('modalname');
        $this->load->model('productunit_model');
        $saveresult = $this->productunit_model->saveproductunit();

        if ($saveresult) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'add_unit'));
            redirect('stockentry/stockentry/add_view');
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
