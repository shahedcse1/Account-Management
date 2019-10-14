<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_return extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('purchasereturndb');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['title'] = "Purchase Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchasereturn";
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
            //$query2 = $this->db->query("SELECT  *  FROM  purchasereturnmaster ORDER BY purchaseReturnMasterId DESC ");
            //$data['purchasereturninfo'] = $query2->result();
            //query from invoicestatus data to view into table
            //$queryinvoicestatus = $this->db->query("SELECT  *  FROM  purchasemaster ");
            //$data['purchaseinfo'] = $queryinvoicestatus->result();

            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();


            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('purchasereturn/purchasereturn', $data);
            $this->load->view('footer', $data);
            $this->load->view('purchasereturn/script', $data);
        else:
            redirect('login');
        endif;
    }

//  ==================================  Add View==========================================
    public function add_view() {
        $data['title'] = "Purchase Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchasereturn";
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):

            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];
            
            $productlistQr = $this->db->query("SELECT productId, productName FROM product WHERE companyId = '$company_id'");
            $data['productdata'] = $productlistQr->result();

            $querypurchasemaster = $this->db->query("SELECT * FROM purchasemaster LEFT JOIN purchasereturnmaster ON purchasemaster.purchaseMasterId = purchasereturnmaster.purchaseMasterId WHERE purchasereturnmaster.purchaseMasterId IS NULL");
            $data['purchaseinfo'] = $querypurchasemaster->result();


            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('purchasereturn/add_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('purchasereturn/script', $data);
        else:
            redirect('login');
        endif;
    }
     public function getinvoiceidset() {
        $productid = $this->input->post('productid');
        $getProductBQr = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId = '$productid'");
        $productiddata = $getProductBQr->result();
        $batchidset = "";
        $invoicedata = "";
        if (sizeof($productiddata)):
            foreach ($productiddata as $datarow):
                $batchidset = ',' . $datarow->productBatchId;
            endforeach;
            $batchidset = substr($batchidset, 1);
            $purchasedetailsQr = $this->db->query("SELECT DISTINCT(purchaseMasterId) FROM purchasedetails WHERE productBatchId IN ($batchidset)");
            $purchaseMasterIddata = $purchasedetailsQr->result();
            if (sizeof($purchaseMasterIddata) > 0):
                echo '<option value="">--Select Invoice--</option>';
                foreach ($purchasesMasterIddata as $datarow):
                    echo '<option value="' . $datarow->purchaseMasterId . '">' . $datarow->purchaseMasterId . '</option>';
                endforeach;
            else:
                echo '<option value="">No entry found!</option>';
            endif;
        else:
            echo '<option value="">No entry found!</option>';
        endif;
    }

    //=======================find company name==============================
    public function findcompanyname() {
        $invoiceno = $this->input->post('invoiceno');

        if ($invoiceno !== "") {
            $querypurchasemaster = $this->db->query("SELECT  *  FROM  purchasemaster WHERE purchaseInvoiceNo='$invoiceno'");
            $row2 = $querypurchasemaster->row_array();
            $ledgerId = $row2['ledgerId'];

            //query  Company Name name from table
            $queryaccountladger = $this->db->query("SELECT  *  FROM  accountledger WHERE ledgerId='$ledgerId'");
            $row3 = $queryaccountladger->row_array();
            $acccountLedgerName = $row3['acccountLedgerName'];

            echo "$acccountLedgerName,$ledgerId";
        }
    }

//==================================find product info ===============================================
    public function findproductinfo() {
        $invoiceno = $this->input->post('invoiceno');

        if ($invoiceno !== "") {
            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product");
            $productinfo = $queryp->result();

            //query  unit  name from table
            $queryunit = $this->db->query("SELECT  *  FROM  unit");
            $unitinfo = $queryunit->result();

            /* ======================= query data from inserted tables=========================== */
            //query  from PurchaseMaster
            $querypurchasemaster = $this->db->query("SELECT  *  FROM  purchasemaster WHERE purchaseInvoiceNo='$invoiceno'");
            $purchasemaster = $querypurchasemaster->row_array();
            $purchaseMasterId = $purchasemaster['purchaseMasterId'];

            //for product
            //from purchasedetails
            $queryratequalityvat = $this->db->query("SELECT * FROM purchasedetails INNER JOIN stockposting ON purchasedetails.purchaseMasterId = stockposting.voucherNumber AND purchasedetails.productBatchId = stockposting.productBatchId WHERE purchasedetails.purchaseMasterId='$purchaseMasterId'group by purchaseDetailsId");
            $ratequalityvatdisc = $queryratequalityvat->result();
            $count_product = $queryratequalityvat->num_rows();

            //from productbatch
            $queryproducts = $this->db->query("SELECT  *  FROM  productbatch");
            $products = $queryproducts->result();

            $count = 0;
            foreach ($ratequalityvatdisc as $rqvd) {
                $count = $count + 1;
                echo '<tr>';
                //Product Name
                echo '<td>
                   <input name="purchaseDetailsId' . $count . '" id="purchaseDetailsId' . $count . '" value="' . $rqvd->purchaseDetailsId . '" type="hidden"/>
                   <input name="purchasemasterid" id="purchasemasterid" value="' . $purchaseMasterId . '" type="hidden"/>';
                echo '<input name="count_product" id="count_product" value="' . $count_product . '" type="hidden"/>';
                foreach ($products as $product) {
                    $batchid = $product->productBatchId;
                    $salesRate = $product->salesRate;
                    $productId = $product->productId;
                    if ($batchid == $rqvd->productBatchId) {
                        echo '<input name="product_id' . $count . '" id="product_id' . $count . '" value="' . $productId . '" type="hidden"/> '; //Input field
                        foreach ($productinfo as $productname) {
                            $prodid = $productname->productId;
                            $productName = $productname->productName;
                            if ($prodid == $productId) {
                                echo '<span class="product_id' . $count . '">' . $productName . '</span>';
                            }
                        }
                    }
                }
                echo '</td><td>';
                //Qty
                echo '<input name="qty' . $count . '" id="qty' . $count . '" value="' . $rqvd->qty . '" type="hidden"/>' . '<span class="qty' . $count . '">' . $rqvd->qty . '</span>';
                echo '</td><td>';
                //Return Qty
                echo '<input name="returnqty' . $count . '" class="returnqty" data-id="' . $count . '" id="returnqty' . $count . '" value="00" type="text"/>';
                echo '</td><td>';
                //Unit name
                echo '<input name="unit_id' . $count . '" id="unit_id' . $count . '" value="' . $rqvd->unitId . '" type="hidden"/>';  //Input field
                foreach ($unitinfo as $unit) {
                    $unitid = $unit->unitId;
                    $unitName = $unit->unitName;
                    if ($unitid == $rqvd->unitId) {
                        echo '<span class="unit_id' . $count . '">' . $unitName . '</span>';
                    }
                }
                echo '</td><td>';
                //rate
                echo '<input name="rate' . $count . '" id="rate' . $count . '" value="' . $rqvd->rate . '" type="hidden"/>' . '<span class="rate' . $count . '">' . $rqvd->rate . '</span>'; //Input field
                echo '</td><td>';
                //salerate
                foreach ($products as $product) {
                    $batchid = $product->productBatchId;
                    $salesRate = $product->salesRate;
                    $productId = $product->productId;
                    if ($batchid == $rqvd->productBatchId) {
                        echo '<input name="salerate' . $count . '" id="salerate' . $count . '" value="' . $salesRate . '" type="hidden"/>' . '<span class="salerate' . $count . '">' . $salesRate . '</span>'; //Input field
                    }
                }
                echo '</td>';
                echo '<td>';
                //Net amount per product
                $zero = 0;
                echo '<span id="product_amount' . $count . '">' . $zero . '</span>'; //Input field
                echo '</td>';
                echo '</tr>';
            }
        }
    }

    public function findproductinfoedit() {
        $invoiceno = $this->input->post('invoiceno');

        if ($invoiceno !== "") {
            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product");
            $productinfo = $queryp->result();

            //query  unit  name from table
            $queryunit = $this->db->query("SELECT  *  FROM  unit");
            $unitinfo = $queryunit->result();

            /* ======================= query data from inserted tables=========================== */
            //query  from PurchaseMaster
            $querypurchasemaster = $this->db->query("SELECT  *  FROM  purchasemaster WHERE purchaseInvoiceNo='$invoiceno'");
            $purchasemaster = $querypurchasemaster->row_array();
            $purchaseMasterId = $purchasemaster['purchaseMasterId'];

            //for product
            //from purchasedetails
            $queryratequalityvat = $this->db->query("SELECT * FROM purchasedetails INNER JOIN stockposting ON purchasedetails.purchaseMasterId = stockposting.voucherNumber AND purchasedetails.productBatchId = stockposting.productBatchId WHERE purchasedetails.purchaseMasterId='$purchaseMasterId' group by purchaseDetailsId");
            $ratequalityvatdisc = $queryratequalityvat->result();
            $querypurchaseDetailsId = $queryratequalityvat->row_array();
            $purchaseDetailsId = $querypurchaseDetailsId['purchaseDetailsId'];
            $count_product = $queryratequalityvat->num_rows();

            //from productbatch
            $queryproducts = $this->db->query("SELECT  *  FROM  productbatch");
            $products = $queryproducts->result();

            //query from purchasereturndetails data
            //$querypurchasereturndetails = $this->db->query("SELECT  ledgerposting.ledgerPostingId,returnedQty FROM  purchasereturndetails JOIN ledgerposting ON ledgerposting.voucherNumber=purchasereturndetails.purchaseReturnMasterId WHERE purchasereturndetails.purchaseDetailsId='$purchaseDetailsId'  AND ledgerposting.debit=0 AND ledgerposting.voucherType='Purchase Return'");
            //$purchasereturninfo = $querypurchasereturndetails->result();

            $count = 0;
            foreach ($ratequalityvatdisc as $rqvd) {

                $querypurchasereturndetails = $this->db->query("SELECT  ledgerposting.ledgerPostingId,returnedQty FROM  purchasereturndetails JOIN ledgerposting ON ledgerposting.voucherNumber=purchasereturndetails.purchaseReturnMasterId WHERE purchasereturndetails.purchaseDetailsId='$rqvd->purchaseDetailsId'  AND ledgerposting.debit=0 AND ledgerposting.voucherType='Purchase Return'");
                $purchasereturninfo = $querypurchasereturndetails->result();
                
                $querypurchasereturndetailsslno = $this->db->query("SELECT stockposting.serialNumber AS serialNumber FROM stockposting JOIN purchasereturnmaster ON stockposting.voucherNumber=purchasereturnmaster.purchaseReturnMasterId WHERE purchasereturnmaster.purchaseMasterId='$purchaseMasterId' AND stockposting.productBatchId = '$rqvd->productBatchId' AND stockposting.voucherType='Purchase Return'");
                $purchasereturnslno = $querypurchasereturndetailsslno->row();
               
                $count = $count + 1;
                echo '<tr class="row' . $count . '">';
                //Product Name
                echo '<td>
                    <input name="serialNumber' . $count . '" id="serialNumber' . $count . '" value="' . $purchasereturnslno->serialNumber . '" type="hidden"/>  
                   <input name="purchaseDetailsId' . $count . '" id="purchaseDetailsId' . $count . '" value="' . $rqvd->purchaseDetailsId . '" type="hidden"/>
                   <input name="purchasemasterid" id="purchasemasterid" value="' . $purchaseMasterId . '" type="hidden"/>';
                echo '<input name="count_product" id="count_product" value="' . $count_product . '" type="hidden"/>';
                foreach ($products as $product) {
                    $batchid = $product->productBatchId;
                    $salesRate = $product->salesRate;
                    $productId = $product->productId;
                    if ($batchid == $rqvd->productBatchId) {
                        echo '<input name="product_id' . $count . '" id="product_id' . $count . '" value="' . $productId . '" type="hidden"/> '; //Input field
                        foreach ($productinfo as $productname) {
                            $prodid = $productname->productId;
                            $productName = $productname->productName;
                            if ($prodid == $productId) {
                                echo '<span class="product_id' . $count . '">' . $productName . '</span>';
                            }
                        }
                    }
                }
                echo '</td><td>';
                //Qty

                echo '<input name="qty' . $count . '" id="qty' . $count . '" value="' . $rqvd->qty . '" type="hidden"/>' . '<span class="qty' . $count . '">' . $rqvd->qty . '</span>';
                echo '</td><td>';
                //Return Qty
                foreach ($purchasereturninfo as $purchasereturn) {
                    echo '<input name="returnqty' . $count . '" class="returnqty" data-id="' . $count . '" id="returnqty' . $count . '" value="' . $purchasereturn->returnedQty . '" type="text"/>';
                    echo '<input name="ledgerPostingId"  id="ledgerPostingId" value="' . $purchasereturn->ledgerPostingId . '" type="hidden"/>';
                }
                echo '</td><td>';
                //Unit name
                echo '<input name="unit_id' . $count . '" id="unit_id' . $count . '" value="' . $rqvd->unitId . '" type="hidden"/>';  //Input field
                foreach ($unitinfo as $unit) {
                    $unitid = $unit->unitId;
                    $unitName = $unit->unitName;
                    if ($unitid == $rqvd->unitId) {
                        echo '<span class="unit_id' . $count . '">' . $unitName . '</span>';
                    }
                }
                echo '</td><td>';
                //rate
                echo '<input name="rate' . $count . '" id="rate' . $count . '" value="' . $rqvd->rate . '" type="hidden"/>' . '<span class="rate' . $count . '">' . $rqvd->rate . '</span>'; //Input field
                echo '</td><td>';
                //salerate
                foreach ($products as $product) {
                    $batchid = $product->productBatchId;
                    $salesRate = $product->salesRate;
                    $productId = $product->productId;
                    if ($batchid == $rqvd->productBatchId) {
                        echo '<input name="salerate' . $count . '" id="salerate' . $count . '" value="' . $salesRate . '" type="hidden"/>' . '<span class="salerate' . $count . '">' . $salesRate . '</span>'; //Input field
                    }
                }
                echo '</td>';
                echo '<td>';
                //Net amount per product
                foreach ($purchasereturninfo as $purchasereturn) {
                    $qtyrate = $purchasereturn->returnedQty * $rqvd->rate;
                    $grandtotal = $qtyrate;  //total amount
                    echo '<span id="product_amount' . $count . '">' . number_format($grandtotal, 2) . '</span>'; //Input field
                }
                echo '</td>';
                echo '</tr>';
            }
        }
    }

    //=======================================================add data=======================================================

    public function add() {

        $data['title'] = "Purchase Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchasereturn";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->purchasereturndb->purchasereturnadd();

        $this->session->set_userdata(array('dataaddedpurchase' => 'added'));
        //log data
        $query1 = $this->db->query("SELECT MAX(purchaseReturnMasterId) FROM purchasereturnmaster ");
        $row1 = $query1->row_array();
        $purchaseReturnMasterId = $row1['MAX(purchaseReturnMasterId)'];
        ccflogdata($this->sessiondata['username'], "accesslog", "Add purchasereturn", "Add purchasereturn For Voucher No: " . $purchaseReturnMasterId . "");
        redirect('purchasereturn/purchase_return');
    }

//  ==================================  Edit View==========================================
    public function edit_view() {
        $data['title'] = "Purchase Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchasereturn";
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):

            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];

            $data['invoiceno'] = $this->input->get('id');

            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('purchasereturn/edit_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('purchasereturn/script-edit', $data);
        else:
            redirect('login');
        endif;
    }

    //=======================================================Edit data=======================================================

    public function edit() {

        $data['title'] = "Purchase Return Edit";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchasereturn";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->purchasereturndb->purchasereturnedit();

        $this->session->set_userdata(array('dataaddedpurchase' => 'edited'));
        //log data
        $purchasemasterid = $_POST['purchasemasterid'];
        $query1 = $this->db->query("SELECT purchaseReturnMasterId FROM purchasereturnmaster  WHERE purchaseMasterId='$purchasemasterid'");
        $row1 = $query1->row_array();
        $purchaseReturnMasterId = $row1['purchaseReturnMasterId'];
        ccflogdata($this->sessiondata['username'], "accesslog", "Edit purchasereturn", "Edit purchasereturn For Voucher No: " . $purchaseReturnMasterId . "");
        redirect('purchasereturn/purchase_return');
    }

    //=====================================================Delete Data=============================================================
    public function delete() {
        $purchasereturnMasterId = $this->input->post('purchasereturnMasterId');

        $delete1 = $this->db->query("DELETE FROM purchasereturnmaster WHERE purchaseReturnMasterId='$purchasereturnMasterId'");
        $delete2 = $this->db->query("DELETE FROM purchasereturndetails  WHERE purchaseReturnMasterId='$purchasereturnMasterId'");
        $delete3 = $this->db->query("DELETE FROM ledgerposting  WHERE voucherType='Purchase Return' AND voucherNumber='$purchasereturnMasterId'");
        $delete4 = $this->db->query("DELETE FROM stockposting  WHERE voucherType='Purchase Return' AND voucherNumber='$purchasereturnMasterId'");

        if ($delete1 && $delete2 && $delete3 && $delete4) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete purchasereturn", "Delete purchasereturn For Voucher No: " . $purchasereturnMasterId . "");
            redirect('purchasereturn/purchase_return');
        }
    }

    public function getPurchaseReturnDetailsTable() {
        // DB table to use
        $table = 'purchasereturnmaster';
        $primaryKey = 'purchaseReturnMasterId';
        $columns = array(
            array('db' => '`u`.`purchaseReturnMasterId`', 'dt' => 0, 'field' => 'purchaseReturnMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`ud`.`purchaseInvoiceNo`', 'dt' => 1, 'field' => 'purchaseInvoiceNo',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('purchasereturn/purchase_return/edit_view?id=' . $row[1]) . '">' . $row[0] . '</a>';
                }),
            array('db' => '`ud`.`purchaseInvoiceNo`', 'dt' => 2, 'field' => 'purchaseInvoiceNo',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('purchasereturn/purchase_return/edit_view?id=' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`u`.`date`', 'dt' => 3, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('salesreturn/salesreturn/edit_view?id=' . $row[1]) . '">' . date('d M Y', strtotime($rowvalue)) . '</a>';
                })
        );

        $this->load->database();
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $this->load->library('ssp');
        $companyid = $this->sessiondata['companyid'];
        $joinQuery = "FROM `purchasereturnmaster` AS `u` JOIN `purchasemaster` AS `ud` ON (`ud`.`purchaseMasterId` = `u`.`purchaseMasterId`)";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
