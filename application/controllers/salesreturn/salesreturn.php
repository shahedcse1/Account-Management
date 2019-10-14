<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salesreturn extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('salesreturndb');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['title'] = "Sales Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesreturn";
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
            //$query2 = $this->db->query("SELECT  salesreturnmaster.salesReturnMasterId as salesReturnMasterId,salesmaster.orderNo as orderNo,salesreturnmaster.date as date  FROM  salesreturnmaster JOIN salesmaster ON salesmaster.salesMasterId=salesreturnmaster.salesMasterId ORDER BY salesReturnMasterId DESC");
            //$data['salesreturninfo'] = $query2->result();


            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('salesreturn/salesreturn', $data);
            $this->load->view('footer', $data);
            $this->load->view('salesreturn/script', $data);
        else:
            redirect('login');
        endif;
    }

//  ==================================  Add View==========================================
    public function add_view() {
        $data['title'] = "Sales Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesreturn";
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):

            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];

            $productlistQr = $this->db->query("SELECT productId, productName FROM product WHERE companyId = '$company_id'");
            $data['productdata'] = $productlistQr->result();

            $querypurchasemaster = $this->db->query("SELECT * FROM salesmaster WHERE companyId = '$company_id'");
            $data['purchaseinfo'] = $querypurchasemaster->result();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('salesreturn/add_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('salesreturn/script', $data);
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
            $salesdetailsQr = $this->db->query("SELECT DISTINCT(salesMasterId) FROM salesdetails WHERE productBatchId IN ($batchidset)");
            $salesmasteridata = $salesdetailsQr->result();
            if (sizeof($salesmasteridata) > 0):
                echo '<option value="">--Select Invoice--</option>';
                foreach ($salesmasteridata as $datarow):
                    echo '<option value="' . $datarow->salesMasterId . '">' . $datarow->salesMasterId . '</option>';
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
            $querypurchasemaster = $this->db->query("SELECT  *  FROM  salesmaster WHERE salesMasterId='$invoiceno'");
            $row2 = $querypurchasemaster->row_array();
            $ledgerId = $row2['ledgerId'];
            $salesMasterId = $row2['salesMasterId'];

            $query = $this->db->query("SELECT date FROM salesreturnmaster WHERE salesMasterId='$salesMasterId'");
            if ($query->num_rows() > 0):
                $date = $query->row()->date;
            else:
                $date = "";
            endif;

//query  Company Name name from table
            $queryaccountladger = $this->db->query("SELECT  *  FROM  accountledger WHERE ledgerId='$ledgerId'");
            $row3 = $queryaccountladger->row_array();
            $acccountLedgerName = $row3['acccountLedgerName'];
            echo "$acccountLedgerName,$ledgerId, $date";
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
            $querypurchasemaster = $this->db->query("SELECT  *  FROM  salesmaster WHERE salesMasterId='$invoiceno'");
            $purchasemaster = $querypurchasemaster->row_array();
            $purchaseMasterId = $purchasemaster['salesMasterId'];
            $salesmasteramount = $purchasemaster['amount'];
            $salesdiscount = $purchasemaster['billDiscount'];

//for product
//from purchasedetails
            $queryratequalityvat = $this->db->query("SELECT * FROM salesdetails INNER JOIN stockposting ON salesdetails.salesMasterId = stockposting.voucherNumber AND salesdetails.productBatchId = stockposting.productBatchId WHERE salesdetails.salesMasterId='$purchaseMasterId'group by salesDetailsId");
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
                   <input name="salesDetailsId' . $count . '" id="salesDetailsId' . $count . '" value="' . $rqvd->salesDetailsId . '" type="hidden"/>
                   <input name="salesMasterId" id="salesMasterId" value="' . $purchaseMasterId . '" type="hidden"/>';
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
                $discountedrate = (($salesmasteramount * $rqvd->rate) / ($salesmasteramount + $salesdiscount));
                $discountedrate = round($discountedrate, 2);
                echo '<input name="rate' . $count . '" class="returnrate" id="rate' . $count . '" value="' . $discountedrate . '" type="text"/>'; // . '<span class="rate' . $count . '">' . $rqvd->rate . '</span>'; //Input field
                echo '</td>';

//                 echo '<td>';
////salerate
//                foreach ($products as $product) {
//                    $batchid = $product->productBatchId;
//                    $salesRate = $product->salesRate;
//                    $productId = $product->productId;
//                    if ($batchid == $rqvd->productBatchId) {
//                        echo '<input name="salerate' . $count . '" id="salerate' . $count . '" value="' . $salesRate . '" type="text"/>' . '<span class="salerate' . $count . '" >' . $salesRate . '</span>'; //Input field
//                    }
//                }
//                echo '</td>';
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
            $querypurchasemaster = $this->db->query("SELECT  *  FROM  salesmaster WHERE salesMasterId='$invoiceno'");
            $purchasemaster = $querypurchasemaster->row_array();
            $purchaseMasterId = $purchasemaster['salesMasterId'];

//for product
//from purchasedetails
            $queryratequalityvat = $this->db->query("SELECT * FROM salesdetails INNER JOIN stockposting ON salesdetails.salesMasterId = stockposting.voucherNumber AND salesdetails.productBatchId = stockposting.productBatchId WHERE salesdetails.salesMasterId='$purchaseMasterId' group by salesDetailsId");
            $ratequalityvatdisc = $queryratequalityvat->result();
            $querysalesDetailsId = $queryratequalityvat->row_array();
            $salesDetailsId = $querysalesDetailsId['salesDetailsId'];
            $count_product = $queryratequalityvat->num_rows();
            
//from productbatch
            $queryproducts = $this->db->query("SELECT  *  FROM  productbatch");
            $products = $queryproducts->result();

//query from salesreturndetails data
            //$querysalesreturndetails = $this->db->query("SELECT ledgerposting.ledgerPostingId,returnedQty FROM  salesreturndetails JOIN ledgerposting ON ledgerposting.voucherNumber=salesreturndetails.salesReturnMasterId WHERE salesreturndetails.salesDetailsId='$salesDetailsId' AND ledgerposting.credit=0 AND ledgerposting.voucherType='Sales Return'");
            //$salesreturninfo = $querysalesreturndetails->result();

            $count = 0;
            foreach ($ratequalityvatdisc as $rqvd) {
                $querysalesreturndetails = $this->db->query("SELECT ledgerposting.ledgerPostingId,returnedQty, returnRate FROM  salesreturndetails JOIN ledgerposting ON ledgerposting.voucherNumber=salesreturndetails.salesReturnMasterId WHERE salesreturndetails.salesDetailsId='$rqvd->salesDetailsId' AND ledgerposting.credit=0 AND ledgerposting.voucherType='Sales Return'");
                $salesreturn = $querysalesreturndetails->row();
                
                $querysalesreturndetailsslno = $this->db->query("SELECT stockposting.serialNumber AS serialNumber FROM stockposting JOIN salesreturnmaster ON stockposting.voucherNumber=salesreturnmaster.salesReturnMasterId WHERE salesreturnmaster.salesMasterId='$invoiceno' AND stockposting.productBatchId = '$rqvd->productBatchId' AND stockposting.voucherType='Sales Return'");
                $salesreturnslno = $querysalesreturndetailsslno->row();
                
                $count = $count + 1;
                echo '<tr>';
//Product Name
                echo '<td>
                   <input name="salesDetailsId' . $count . '" id="salesDetailsId' . $count . '" value="' . $rqvd->salesDetailsId . '" type="hidden"/>
                   <input name="serialNumber' . $count . '" id="serialNumber' . $count . '" value="' . $salesreturnslno->serialNumber . '" type="hidden"/>    
                   <input name="salesMasterId" id="salesMasterId" value="' . $purchaseMasterId . '" type="hidden"/>';
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
                //    foreach ($salesreturninfo as $salesreturn) {
                if (sizeof($salesreturn) > 0):
                    echo '<input name="returnqty' . $count . '" class="returnqty" data-id="' . $count . '" id="returnqty' . $count . '" value="' . $salesreturn->returnedQty . '" type="text"/>';
                    echo '<input name="ledgerPostingId"  id="ledgerPostingId" value="' . $salesreturn->ledgerPostingId . '" type="hidden"/>';
                endif;
                //   }               
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
                if (sizeof($salesreturn) > 0):
                    echo '<input name="rate' . $count . '" class="returnrate" id="rate' . $count . '" value="' . $salesreturn->returnRate . '" type="text"/>' . '<span class="rate' . $count . '"></span>'; //Input field
                endif;
                echo '</td>';

                echo '<td>';
//Net amount per product
                //  foreach ($salesreturninfo as $salesreturn) {
                if (sizeof($salesreturn) > 0):
                    if ($salesreturn->returnedQty > 0):
                        $return_qty = $salesreturn->returnedQty;
                        $rerate = $salesreturn->returnRate;
                    else:
                        $return_qty = 0;
                        $rerate = $rqvd->rate;
                    endif;
                    $qtyrate = $return_qty * $rerate;
                    $grandtotal = $qtyrate;  //total amount
                    echo '<span id="product_amount' . $count . '">' . number_format($grandtotal, 2) . '</span>'; //Input field
                // } 
                endif;
                echo '</td>';
                echo '</tr>';
            }
        }
    }

//=======================================================add data=======================================================

    public function add() {

        $data['title'] = "Sales Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesreturn";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->salesreturndb->salesreturnadd();

        $this->session->set_userdata(array('dataaddedpurchase' => 'added'));
//log data
        $query1 = $this->db->query("SELECT MAX(salesReturnMasterId) FROM salesreturnmaster ");
        $row1 = $query1->row_array();
        $salesReturnMasterId = $row1['MAX(salesReturnMasterId)'];
        ccflogdata($this->sessiondata['username'], "accesslog", "Add Sales Return", "Add Sales Return For Voucher No : " . $salesReturnMasterId . "");
        redirect('salesreturn/salesreturn');
    }

//  ==================================  Edit View==========================================
    public function edit_view() {
        $data['title'] = "Sales Return";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesreturn";
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):

            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];
            $invoiceno = $this->input->get('id');
            $data['invoiceno'] = $invoiceno;


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('salesreturn/edit_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('salesreturn/script-edit', $data);
        else:
            redirect('login');
        endif;
    }

//=======================================================Edit data=======================================================

    public function edit() {
        $data['title'] = "Purchase Return Edit";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesreturn";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->salesreturndb->salesreturnedit();
        $this->session->set_userdata(array('dataaddedpurchase' => 'edited'));
        //log data
        $salesMasterId = $_POST['salesMasterId'];
        $query1 = $this->db->query("SELECT salesReturnMasterId FROM salesreturnmaster  WHERE salesMasterId='$salesMasterId'");
        $row1 = $query1->row_array();
        $salesReturnMasterId = $row1['salesReturnMasterId'];
        ccflogdata($this->sessiondata['username'], "accesslog", "Edit Sales Return", "Edit Sales Return For Voucher No : " . $salesReturnMasterId . "");
        redirect('salesreturn/salesreturn');
    }

    //=====================================================Delete Data=============================================================
    public function delete() {
        $salesReturnMasterId = $this->input->post('salesReturnMasterId');

        $delete1 = $this->db->query("DELETE FROM salesreturnmaster WHERE salesReturnMasterId='$salesReturnMasterId'");
        $delete2 = $this->db->query("DELETE FROM salesreturndetails  WHERE salesReturnMasterId='$salesReturnMasterId'");
        $delete3 = $this->db->query("DELETE FROM ledgerposting  WHERE voucherType='Sales Return' AND voucherNumber='$salesReturnMasterId'");
        $delete4 = $this->db->query("DELETE FROM stockposting WHERE voucherType='Sales Return' AND voucherNumber='$salesReturnMasterId'");

        if ($delete1 && $delete2 && $delete3 && $delete4) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete Sales Return", "Delete Sales Return For Voucher No: " . $salesReturnMasterId . "");
            redirect('salesreturn/salesreturn');
        }

        if ($delete1 && $delete2 && $delete3 && $delete4) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete Sales Return", "Delete Sales Return For salesReturnMasterId: " . $salesReturnMasterId . "");
            redirect('salesreturn/salesreturn');
        }
    }

    public function getSalesReturnDetailsTable() {
        // DB table to use
        $table = 'salesreturnmaster';
        $primaryKey = 'salesReturnMasterId';
        $columns = array(
            array('db' => '`u`.`salesReturnMasterId`', 'dt' => 0, 'field' => 'salesReturnMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`ud`.`salesMasterId`', 'dt' => 1, 'field' => 'salesMasterId',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('salesreturn/salesreturn/edit_view?id=' . $row[1]) . '">' . $row[0] . '</a>';
                }),
            array('db' => '`ud`.`salesMasterId`', 'dt' => 2, 'field' => 'salesMasterId',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('salesreturn/salesreturn/edit_view?id=' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`udd`.`acccountLedgerName`', 'dt' => 3, 'field' => 'acccountLedgerName',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_sales" href="' . site_url('salesreturn/salesreturn/edit_view?id=' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`u`.`date`', 'dt' => 4, 'field' => 'date',
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
        $joinQuery = "FROM `salesreturnmaster` AS `u` JOIN `salesmaster` AS `ud` ON (`ud`.`salesMasterId` = `u`.`salesMasterId`) JOIN `accountledger` AS `udd` ON (`ud`.`ledgerId` = `udd`.`ledgerId`)";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid' AND `udd`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
