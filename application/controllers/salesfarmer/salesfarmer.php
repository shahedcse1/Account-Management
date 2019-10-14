<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salesfarmer extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('salesfarmerdb');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {

        $data['title'] = "Sales Farmer";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesfarmer";     
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
            //$query2 = $this->db->query("SELECT salesreadystockmaster.salesReadyStockMasterId AS salesReadyStockMasterId,a2.acccountLedgerName AS farmername,accountledger.acccountLedgerName AS customername,salesreadystockdetails.pcs AS Pcs,salesreadystockdetails.qty AS kg,ledgerposting.debit AS amount,salesreadystockmaster.date AS date  FROM  salesreadystockmaster JOIN salesreadystockdetails ON salesreadystockdetails.salesReadyStockMasterId=salesreadystockmaster.salesReadyStockMasterId JOIN ledgerposting ON salesreadystockdetails.salesReadyStockMasterId=ledgerposting.voucherNumber  LEFT JOIN accountledger a2 ON a2.ledgerId=salesreadystockmaster.ledgerId JOIN accountledger ON accountledger.ledgerId=ledgerposting.ledgerId WHERE ledgerposting.voucherType='Ready Stock Sale' AND ledgerposting.credit=0 GROUP BY salesreadystockmaster.salesReadyStockMasterId DESC");
            //$data['salesmasterinfo'] = $query2->result();


            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('salesfarmer/sales', $data);
            $this->load->view('footer', $data);
            $this->load->view('salesfarmer/script', $data);
        else:
            redirect('login');
        endif;
    }

    public function getSalesReadyStockTable() {
        $table = 'salesreadystockmaster';
        $primaryKey = 'salesReadyStockMasterId';
        $columns = array(
            array('db' => '`m`.`salesReadyStockMasterId`', 'dt' => 0, 'field' => 'salesReadyStockMasterId','AS' => 'salesReadyStockMasterId'),
            array('db' => '`a2`.`acccountLedgerName`', 'dt' => 1, 'field' => 'acccountLedgerName', 'AS' => 'farmername'),
            array('db' => '`d`.`pcs`', 'dt' => 2, 'field' => 'pcs', 'AS' => 'pcs'),
            array('db' => '`d`.`qty`', 'dt' => 3, 'field' => 'qty', 'AS' => 'kg'),
            array('db' => '`l`.`debit`', 'dt' => 4, 'field' => 'debit', 'AS' => 'amount'),
            array('db' => '`m`.`date`', 'dt' => 5, 'field' => 'date', 'AS' => 'date')
        );
        $this->load->database();
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $this->load->library('ssp');
        $joinQuery = "FROM  `salesreadystockmaster` AS `m`
                      JOIN `salesreadystockdetails` AS `d`
                      ON 
                     `d`.`salesReadyStockMasterId`=`m`.`salesReadyStockMasterId`
                      JOIN `ledgerposting` AS `l`
                      ON `d`.`salesReadyStockMasterId`=`l`.`voucherNumber` 
                      LEFT JOIN `accountledger` AS `a2`
                      ON `a2`.`ledgerId`=`m`.`ledgerId` 
                      JOIN `accountledger`
                      ON `accountledger`.`ledgerId`=`l`.`ledgerId` ";
            $extraWhere = "`l`.`voucherType`='Ready Stock Sale' AND `l`.`credit`=0 ";
            $groupBy = "GROUP BY `m`.`salesReadyStockMasterId` ";
        //       $order = "DESC";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
        );
    }

//  ==================================  Add new==========================================
    public function add_view() {
        $data['title'] = "Sales Farmer";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesfarmer";
        ;
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
            $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId IN (28) AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['supplierinfo1'] = $query2->result();

            //query  Farmerlist
            $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId IN (13,28) AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['farmers'] = $query2->result();

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
            $this->load->view('salesfarmer/add_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('salesfarmer/script', $data);
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

    //query qty range for product
    public function product_qty() {
        $product_id = $this->input->post("product_id");

        $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_id'");
        $row2 = $query2->row_array();
        $productBatchId = $row2['productBatchId'];


        //query  unit  name from table
        $queryunit = $this->db->query("SELECT  *  FROM  stockposting WHERE productBatchId='$productBatchId'");
        $row1 = $queryunit->row_array();
        if ($row1) {
            $inwardQuantity = $row1['inwardQuantity'];
            $outwardQuantity = $row1['outwardQuantity'];
            $qty_range = $inwardQuantity - $outwardQuantity;

            echo $qty_range;
        }
    }

    //query unit id for product
    public function product_salerate() {
        $product_id = $this->input->post("product_id");

        //query  unit  name from table
        $queryproductbatch = $this->db->query("SELECT  salesRate  FROM  productbatch  WHERE productId='$product_id'");
        $row = $queryproductbatch->row_array();
        $salesRate = $row['salesRate'];
        echo $salesRate;
    }

    public function add_view_table() {
        $corparty_account = $this->input->post('corparty_account');
        $unit = $this->input->post('unit');
        $count = $this->input->post('count');

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  accountledger WHERE ledgerId='$corparty_account'");
            $row1 = $queryp->row_array();
            $acccountLedgerName = $row1['acccountLedgerName'];

            echo '<tr id="row' . $count . '"><td> <a onclick=deleteRowData(' . $count . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a> </td>
                    <td>' . $acccountLedgerName . '<input name="corparty_account' . $count . '" id="corparty_account' . $count . '" type="hidden" value="' . $this->input->post('corparty_account') . '"/></td>
                    <td class="edit-field" title="Click for Edit"><span>' . $this->input->post('unit') . '</span><input name="unit' . $count . '" id="unit' . $count . '" type="hidden" class="edit_input" value="' . $this->input->post('unit') . '"/></td>
                    <td id="click" class="edit-field" title="Click for Edit"><span>' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qty' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>
                    <td class="edit-field" title="Click for Edit"><span>' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden"  class="edit_input"value="' . $this->input->post('rate') . '"/></td>';
            //Net amount per product
            $kg = $this->input->post('unit');
            $rate = $this->input->post('rate');
            $ratepurchase = $this->input->post('ratepurchase');
            $qtyrate = $kg * $rate;
            $qtyratepurchase = $kg * $ratepurchase;
            $grandtotal = $qtyrate;  //total amount

            echo '<td><span id="product_amount' . $count . '">' . $grandtotal . '</span><input name="amount' . $count . '" id="amount' . $count . '" type="hidden" value="' . $grandtotal . '"/>
                        <input name="amountpurchase' . $count . '" id="amountpurchase' . $count . '" type="hidden" value="' . $qtyratepurchase . '"/></td>
               </tr>';

        else:
            redirect('login');
        endif;
    }

    public function add() {
        $data['title'] = "Sales Farmer";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesfarmer";
        $data['baseurl'] = $this->config->item('base_url');
        $isadded = $this->salesfarmerdb->addsales();
        sleep(2);
        $this->session->set_userdata(array('dataaddedpurchase' => 'added'));
        //log data
        $query1 = $this->db->query("SELECT MAX(salesReadyStockMasterId) FROM salesreadystockmaster ");
        $row1 = $query1->row_array();
        $salesReadyStockMasterId = $row1['MAX(salesReadyStockMasterId)'];
        ccflogdata($this->sessiondata['username'], "accesslog", "Add Sales ReadyStock", "Add Sales ReadyStock For Farmer Invoice No: " . $salesReadyStockMasterId . "");
        redirect('salesfarmer/salesfarmer');
    }

//  =============================================  Edit page======================================================
    public function add_view_edit() {
        $data['title'] = "Sales Farmer";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesfarmer";
        ;
        $data['baseurl'] = $this->config->item('base_url');

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];
            //query  supplier name from table
            $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId IN (28)  AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['supplierinfo1'] = $query2->result();

            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId IN (28,13) AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['farmerinfo'] = $queryp->result();

            /* ======================= query data from inserted tables=========================== */
            $id = $this->input->get('id');

            //from productbatch
            $queryproducts = $this->db->query("SELECT  salesreadystockmaster.salesReadyStockMasterId AS salesReadyStockMasterId,salesreadystockmaster.farmerRate AS farmerRate,a2.acccountLedgerName AS farmername,a2.ledgerId AS farmerId,accountledger.acccountLedgerName AS customername,accountledger.ledgerId AS customerId,salesreadystockdetails.pcs AS Pcs,salesreadystockdetails.qty AS kg,salesreadystockdetails.rate AS rate,ledgerposting.debit AS amount,salesreadystockmaster.amount AS amountpurchase,salesreadystockmaster.date AS date,ledgerposting.ledgerPostingId as ledgerPostingId  FROM  salesreadystockmaster JOIN salesreadystockdetails ON salesreadystockdetails.salesReadyStockMasterId=salesreadystockmaster.salesReadyStockMasterId JOIN ledgerposting ON salesreadystockdetails.salesReadyStockMasterId=ledgerposting.voucherNumber  LEFT JOIN accountledger a2 ON a2.ledgerId=salesreadystockmaster.ledgerId JOIN accountledger ON accountledger.ledgerId=ledgerposting.ledgerId WHERE salesreadystockmaster.salesReadyStockMasterId='$id' AND  ledgerposting.voucherType='Ready Stock Sale' AND ledgerposting.credit=0 GROUP BY salesreadystockmaster.salesReadyStockMasterId DESC");
            $data['salesmasterinfo'] = $queryproducts->result();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('salesfarmer/edit_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('salesfarmer/script-edit', $data);
        else:
            redirect('login');
        endif;
    }

    public function dataqueryedit() {
        $ledger_id = $this->input->post("ledger_id");
        //query  product  name from table
        $queryp = $this->db->query("SELECT  *  FROM  accountledger WHERE ledgerId='$ledger_id'");
        $productinfo = $queryp->row_array();
        echo $productinfo['acccountLedgerName'];
    }

    //===========================edit submit=========================================
    public function edit() {
        $data['title'] = "Sales Farmer";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "salesfarmer";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->salesfarmerdb->editsales();

        $this->session->set_userdata(array('dataaddedpurchase' => 'edited'));
        ccflogdata($this->sessiondata['username'], "accesslog", "Edit Sales ReadyStock", "Edit Sales ReadyStock For Farmer Invoice No: " . $_POST['salesReadyStockMasterId'] . "");
        redirect('salesfarmer/salesfarmer');
    }

    //================================================================================Delete data=================================================
    public function delete() {
        $salesReadyStockMasterId = $this->input->post('salesReadyStockMasterId');

        $delete1 = $this->db->query("DELETE FROM salesreadystockmaster WHERE salesReadyStockMasterId='$salesReadyStockMasterId'");
        $delete2 = $this->db->query("DELETE FROM salesreadystockdetails  WHERE salesReadyStockMasterId='$salesReadyStockMasterId'");
        $delete3 = $this->db->query("DELETE FROM ledgerposting  WHERE (voucherType='Ready Stock Sale' OR voucherType='Ready Stock Purchase')  AND voucherNumber='$salesReadyStockMasterId'");

        if ($delete1 && $delete2 && $delete3) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
            ccflogdata($this->sessiondata['username'], "accesslog", "Delete Sales ReadyStock", "Delete Sales ReadyStock For Invoice No: " . $salesReadyStockMasterId . "");
            redirect('salesfarmer/salesfarmer');
        }
    }

    //====================================================add new unit==========================================================================

    function addunit() {
        // $Modalname = $this->input->post('modalname');
        $this->load->model('productunit_model');
        $saveresult = $this->productunit_model->saveproductunit();

        if ($saveresult) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'add_unit'));
            redirect('salesfarmer/salesfarmer/add_view');
        }
    }

    //=======================================check OrderNo====================================================================================
    function checkorderno() {
        $order_no = $this->input->post('order_no');
        $companyid = $this->input->post('companyid');

        $queryinvoice = $this->db->query("SELECT * FROM salesmaster WHERE companyId='$companyid' AND orderNo='$order_no'");
        $row = $queryinvoice->row();
        if ($row) {
            echo "found";
        } else {
            echo "notfound";
        }
    }

    public function getSalesreadystockDetailsTable() {
        // DB table to use
        $table = 'salesreadystockmaster';
        $primaryKey = 'salesReadyStockMasterId';
        $columns = array(
            array('db' => '`m`.`salesReadyStockMasterId`', 'dt' => 0, 'field' => 'salesReadyStockMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`m`.`salesReadyStockMasterId`', 'dt' => 1, 'field' => 'salesReadyStockMasterId',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('salesfarmer/salesfarmer/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`a`.`acccountLedgerName`', 'dt' => 2, 'field' => 'acccountLedgerName',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('salesfarmer/salesfarmer/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                }),
          
            array('db' => '`d`.`pcs`', 'dt' => 3, 'field' => 'pcs',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('salesfarmer/salesfarmer/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`d`.`qty`', 'dt' => 4, 'field' => 'qty',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('salesfarmer/salesfarmer/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`l`.`debit`', 'dt' => 5, 'field' => 'debit',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('salesfarmer/salesfarmer/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`m`.`date`', 'dt' => 6, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('salesfarmer/salesfarmer/add_view_edit?id=' . $row[0]) . '">' . date('d M Y', strtotime($rowvalue)) . '</a>';
                }),
                     
                        
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
        $joinQuery = "FROM `salesreadystockmaster` AS `m` JOIN `salesreadystockdetails` AS `d` ON (`d`.`salesReadyStockMasterId` = `m`.`salesReadyStockMasterId`) JOIN `ledgerposting` AS `l` ON (`l`.`voucherNumber` = `m`.`salesReadyStockMasterId`)  LEFT JOIN `accountledger` AS `a` ON (`a`.`ledgerId` = `m`.`ledgerId` )";
        $extraWhere = "`m`.`companyId` = '$companyid' AND `a`.`companyId` = '$companyid' AND `d`.`companyId` = '$companyid' AND `l`.`companyId` = '$companyid' AND `l`.`voucherType` = 'Ready Stock Sale' AND `l`.`credit` = '0'";
        $groupBy = "GROUP BY `m`.`salesReadyStockMasterId`";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
        );
    }

}
