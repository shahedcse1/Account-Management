<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('purchasedb');
        $this->sessiondata = $this->session->userdata('logindata');

        // ccflogdata($this->sessiondata['username'], "accesslog", "Add account ledger", "New account ledger: " . $_POST['acccountLedgerName'] . " Added");
        // ccflogdata("username","tablename","logtype","details cause for add edit delete");
    }

    public function index()
    {
        $data['title'] = "Purchase";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchase";
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


            /*  //query data to view into table
              $query2 = $this->db->query("SELECT  *  FROM  purchasemaster JOIN accountledger ON accountledger.ledgerId=purchasemaster.ledgerId GROUP BY purchasemaster.purchaseMasterId DESC");
              $data['purchaseinfo'] = $query2->result();

              //query from invoicestatus data to view into table
              $queryinvoicestatus = $this->db->query("SELECT  *  FROM  invoicestatus ");
              $data['invoicestatus'] = $queryinvoicestatus->result(); */

            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();

            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('purchase/purchase', $data);
            $this->load->view('footer', $data);
            $this->load->view('purchase/script', $data);
        else:
            redirect('login');
        endif;
    }

//  ==================================  Add new==========================================
    public function add_view() {
        $data['title'] = "Purchase";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchase";
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
            $query2 = $this->db->query("SELECT * FROM  accountledger WHERE accountGroupId=27 AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['supplierinfo1'] = $query2->result();

            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product");
            $data['productinfo'] = $queryp->result();

            //query  unit  name from table
            $queryunit = $this->db->query("SELECT  *  FROM  unit");
            $data['unitinfo'] = $queryunit->result();


            $query2 = $this->db->query("SELECT  *  FROM  countries");
            $data['countries'] = $query2->result();

            $data['serial'] = $this->purchasedb->getSerialSettings();

            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('purchase/add_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('purchase/script', $data);
        else:
            redirect('login');
        endif;
    }

    //query unit id for productdataqueryedit
    public function unit_name() {
        $product_id = $this->input->post("product_id");
        $getproductsale_buy_price = $this->db->query("select purchaseRate,salesRate from productbatch where productId = '$product_id'");
        $queryforunit = $this->db->query("select unit.unitId,unit.unitName from unit inner join product on unit.unitId = product.unitId where product.productId = '$product_id'");
        $dataofunnit = array(
            'unitname' => $queryforunit->row()->unitName,
            'unitid' => $queryforunit->row()->unitId,
            'purchaserate' => $getproductsale_buy_price->row()->purchaseRate,
            'salesrate' => $getproductsale_buy_price->row()->salesRate
        );
        echo json_encode($dataofunnit);
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

            $tbody = '<tr id="row' . $count . '">
                    <td> <a onclick=deleteRowData(' . $count . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a> </td>
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td id="click" class="edit-field" title="Click for Edit"><span>' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qty' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>
                    <td id="click" class="edit-field" title="Click for Edit"><span>' . $this->input->post('freeqty') . '</span><input name="freeqty' . $count . '"  class="edit_input" id="freeqty' . $count . '" type="hidden" value="' . $this->input->post('freeqty') . '"/></td>
                    <td>' . $unitName . '<input name="unit' . $count . '" id="unit' . $count . '" type="hidden" value="' . $this->input->post('unit') . '"/></td>
                    <td class="edit-field" title="Click for Edit"><span>' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden"  class="edit_input" value="' . $this->input->post('rate') . '"/></td>';

            $data['serial'] = $this->purchasedb->getSerialSettings();

            if ($data['serial'] == '1') {
                $tbody .= '<td>'. $this->input->post('serial') .'<input type="hidden" name="serial' . $count . '" id="serial' . $count . '" value="'. $this->input->post('serial') .'" /></td>';
            }

            $tbody .= '<td class="edit-field" title="Click for Edit"><span>' . $this->input->post('sale_rate') . '</span><input name="sale_rate' . $count . '" id="sale_rate' . $count . '"  class="edit_input"type="hidden" value="' . $this->input->post('sale_rate') . '"/></td>';

            echo $tbody;

            //Net amount per product
            $qty = $this->input->post('qty');
            $rate = $this->input->post('rate');
            $qtyrate = $qty * $rate;
            #$grandtotal = $qtyrate;  //total amount
            echo '<td><span id="product_amount' . $count . '">' . number_format($qtyrate, 2) . '</span></td>
               </tr>';

        else:
            redirect('login');
        endif;
    }

    /**
     * Add Purchase
     */
    public function add()
    {
        $data['title'] = "Purchase";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchase";
        $data['baseurl'] = $this->config->item('base_url');

        $purchase = $this->purchasedb->addPurchase();

        $purchaseId = $purchase['id'];
        $ledgerId = $purchase['ledgerid'];

        redirect('purchase/purchase/add_view_edit?id='. $purchaseId .'&ledger='. $ledgerId);
    }

//  =============================================  Edit page======================================================
    public function add_view_edit() {
        $data['title'] = "Purchase";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchase";
        ;
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];
            //query  supplier name from table
            $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId=27  AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['supplierinfo1'] = $query2->result();
            /* ======================= query data from inserted tables=========================== */
            $id = $this->input->get('id');
            $ledger = $this->input->get('ledger');
            //query  from PurchaseMaster
            $querypurchasemaster = $this->db->query("SELECT * FROM  purchasemaster WHERE purchaseMasterId='$id'");
            $data['purchasemasterinfo'] = $querypurchasemaster->result();

            $data['serial'] = $this->purchasedb->getSerialSettings();

            //for product
            //from purchasedetails
            $queryratequalityvat = $this->db->query("SELECT productbatch.productId,productbatch.salesRate,product.productName,
unit.unitName,ledgerposting.ledgerPostingId,purchasedetails.purchaseDetailsId,purchasedetails.purchaseMasterId,purchasedetails.productBatchId,
purchasedetails.productserial,purchasedetails.rate,purchasedetails.qty,purchasedetails.freeQty,stockposting.serialNumber,stockposting.voucherNumber,
stockposting.unitId,stockposting.inwardQuantity,stockposting.outwardQuantity,stockposting.voucherType,stockposting.companyId 
FROM purchasedetails 
inner JOIN stockposting ON purchasedetails.purchaseMasterId = stockposting.voucherNumber 
AND purchasedetails.productBatchId = stockposting.productBatchId 
JOIN ledgerposting ON ledgerposting.voucherNumber=purchasedetails.purchaseMasterId 
JOIN productbatch ON productbatch.productBatchId=purchasedetails.productBatchId 
JOIN product ON product.productId=productbatch.productId 
JOIN unit ON unit.unitId=stockposting.unitId 
WHERE purchasedetails.purchaseMasterId='$id' 
AND ledgerposting.credit=0 
AND ledgerposting.voucherType='Purchase Invoice' 
AND stockposting.voucherType='Purchase Invoice' 
GROUP BY purchasedetails.purchaseDetailsId");
            $data['ratequalityvat'] = $queryratequalityvat->result();
            $data['count_product'] = $queryratequalityvat->num_rows();
            $data['serial'] = $this->purchasedb->getSerialSettings();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('purchase/add_view_edit', $data);
            $this->load->view('footer', $data);
            $this->load->view('purchase/script-edit', $data);
        else:
            redirect('login');
        endif;
    }

    public function dataqueryedit()
    {
        $product_id = $this->input->post("product_id");
        $unitid = $this->input->post("unitid");

        //query  product  name from table
        $queryp = $this->db->query("SELECT  productName  FROM  product WHERE productId='$product_id'");
        // $productinfo = $queryp->result();
        $productinfo = $queryp->row();
        echo $productinfo->productName . ",";

        //query  unit  name from table
        $queryunit = $this->db->query("SELECT  unitName  FROM  unit WHERE unitId='$unitid'");
        $unitinfo = $queryunit->row();
        echo $unitinfo->unitName;
    }

    //===========================edit submit=========================================
    public function edit()
    {
        $data['title'] = "Purchase";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "purchase";
        $data['baseurl'] = $this->config->item('base_url');

        $count = $this->input->post('count_product');
        $purchaseMasterId = $this->input->post('purchaseMasterId');

        //===================1st tbl PurchaseMaster
        if ($this->input->post('corparty_account') == 2) {
            $invoiceStatusId = 1;
        } else {
            $invoiceStatusId = 3;
        }
        $invoive_number = $this->input->post('invoive_number');
        $data1 = array(
            'ledgerId' => $this->input->post('corparty_account'),
            'billDiscount' => $this->input->post('discount'),
            'additionalCost' => $this->input->post('transport'),
            'description' => $this->input->post('description'),
            'amount' => $this->input->post('net_amout'),
            'invoiceStatusId' => $invoiceStatusId,
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('purchaseMasterId', $purchaseMasterId);
        $this->db->update('purchasemaster', $data1);

        //====================5th tbl ProductBatch update only
        for ($i = 1; $i <= $count; $i++) {
            $product_name = $this->input->post('product_id' . $i);
            $data5 = array(
                'purchaseRate' => $this->input->post('rate' . $i),
                'salesRate' => $_POST['salerate'][$i - 1]
            );
            $this->db->where('productId', $product_name);
            $this->db->update('productbatch', $data5);

            //Query productBatchId
            $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
            $row2 = $query2->row_array();
            $productBatchId = $row2['productBatchId'];

            $data2 = [
                'purchaseMasterId' => $purchaseMasterId,
                'productBatchId'   => $productBatchId,
                'productserial'    => $this->input->post('serial' . $i) ? $this->input->post('serial' . $i) : '',
                'rate'             => $this->input->post('rate' . $i),
                'qty'              => $this->input->post('qty' . $i),
                'freeQty'          => $this->input->post('freeqty' . $i),
                'taxIncludedOrNot' => 1,
                'companyId'        => $this->input->post('company_id')
            ];
            $this->db->where('purchaseDetailsId', $_POST['purchaseDetailsId'][$i - 1]);
            $this->db->update('purchasedetails', $data2);

            $freeqty = $this->input->post('freeqty' . $i);
            $qty = $this->input->post('qty' . $i);
            $totalqty = $freeqty + $qty;
            $data4 = array(
                'voucherNumber' => $purchaseMasterId,
                'productBatchId' => $productBatchId,
                'inwardQuantity' => $totalqty,
                'outwardQuantity' => 0,
                'voucherType' => "Purchase Invoice",
                'date' => $this->input->post('invoice_date'),
                'unitId' => $this->input->post('unit_id' . $i),
                'rate' => $this->input->post('rate' . $i),
                'defaultInwardQuantity' => $totalqty,
                'defaultOutwardQuantity' => 0,
                'companyId' => $this->input->post('company_id')
            );
            $this->db->where('serialNumber', $_POST['serialnumber'][$i - 1]);
            $this->db->where('voucherType', "Purchase Invoice");
            $this->db->update('stockposting', $data4);
        }

        //3rd tbl ledgerposting
        $ledgerPostingId = $this->input->post('ledgerPostingId');
        $data31 = array(
            'voucherNumber' => $purchaseMasterId,
            'ledgerId' => 1,
            'voucherType' => "Purchase Invoice",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' => "By purchase",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $purchaseMasterId,
            'ledgerId' => $this->input->post('corparty_account'),
            'voucherType' => "Purchase Invoice",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' => "By purchase",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $this->db->where('ledgerPostingId', $ledgerPostingId);
        $ledgerpostingsts1 = $this->db->update('ledgerposting', $data31);
        $this->db->where('ledgerPostingId', $ledgerPostingId + 1);
        $ledgerpostingsts2 = $this->db->update('ledgerposting', $data32);

        //$isadded = $this->purchasedb->editPurchase();

        if ($ledgerpostingsts1 && $ledgerpostingsts2):
            $this->session->set_userdata(array('dataaddedpurchase' => 'edited'));
        else:
            $this->session->set_userdata(array('dataaddedpurchase' => 'adderror'));
        endif;
        ccflogdata($this->sessiondata['username'], "accesslog", "Edit purchase", "Edit purchase For Voucher No: " . $_POST['purchaseMasterId'] . "");
        redirect('purchase/purchase');
    }

    //================================================================================Delete data=================================================
    public function delete() {
        $purchaseMasterId = $this->input->post('purchaseMasterId');
        $query1 = $this->db->query("SELECT  *  FROM  partybalance WHERE againstvoucherNo='$purchaseMasterId' AND voucherType='Payment Voucher' AND referenceType='Against'");
        $row1 = $query1->row();
        $query2 = $this->db->query("SELECT  purchaseDetailsId  FROM  purchasedetails WHERE purchaseDetailsId='$purchaseMasterId'");
        $row2 = $query2->row_array();
        $purchaseDetailsId = $row2['purchaseDetailsId'];
        $query3 = $this->db->query("SELECT  *  FROM  purchasereturndetails WHERE purchaseDetailsId='$purchaseDetailsId'");
        $row3 = $query3->row();

        if ($row1 || $row3) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'notdeleted'));
            redirect('purchase/purchase');
        } else {
            $delete1 = $this->db->query("DELETE FROM purchasemaster WHERE purchaseMasterId='$purchaseMasterId'");
            $delete2 = $this->db->query("DELETE FROM purchasedetails  WHERE purchaseMasterId='$purchaseMasterId'");
            $delete3 = $this->db->query("DELETE FROM ledgerposting  WHERE voucherType='Purchase Invoice' AND voucherNumber='$purchaseMasterId'");
            $delete4 = $this->db->query("DELETE FROM stockposting WHERE voucherType='Purchase Invoice' AND voucherNumber='$purchaseMasterId'");
           
            if ($delete1 && $delete2 && $delete3 && $delete4) {
                $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
                ccflogdata($this->sessiondata['username'], "accesslog", "Delete purchase", "Delete purchase For Voucher No: " . $purchaseMasterId . "");
                redirect('purchase/purchase');
            }
        }
    }

    //====================================================add new unit==========================================================================

    public function addunit() {
        // $Modalname = $this->input->post('modalname');
        $this->load->model('productunit_model');
        $saveresult = $this->productunit_model->saveproductunit();

        if ($saveresult) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'add_unit'));
            redirect('purchase/purchase/add_view');
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

    public function getPurchaseDetailsTable() {
        // DB table to use
        $table = 'purchasemaster';
        $primaryKey = 'purchaseMasterId';
        $columns = array(
            array('db' => '`u`.`purchaseMasterId`', 'dt' => 0, 'field' => 'purchaseMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ',' . '"' . base64_encode($row[3]) . '"' . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`u`.`ledgerId`', 'dt' => 1, 'field' => 'ledgerId',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('purchase/purchase/add_view_edit?id=' . $row[0] . '&ledger=' . $row[1]) . '">' . $row[0] . '</a>';
                }),
            array('db' => '`u`.`purchaseInvoiceNo`', 'dt' => 2, 'field' => 'purchaseInvoiceNo',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('purchase/purchase/add_view_edit?id=' . $row[0] . '&ledger=' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`ud`.`acccountLedgerName`', 'dt' => 3, 'field' => 'acccountLedgerName',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('purchase/purchase/add_view_edit?id=' . $row[0] . '&ledger=' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`u`.`amount`', 'dt' => 4, 'field' => 'amount',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('purchase/purchase/add_view_edit?id=' . $row[0] . '&ledger=' . $row[1]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => '`u`.`date`', 'dt' => 5, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_purchase" href="' . site_url('purchase/purchase/add_view_edit?id=' . $row[0] . '&ledger=' . $row[1]) . '">' . date('d M Y', strtotime($rowvalue)) . '</a>';
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
        $joinQuery = "FROM `purchasemaster` AS `u` JOIN `accountledger` AS `ud` ON (`ud`.`ledgerId` = `u`.`ledgerId`)";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
