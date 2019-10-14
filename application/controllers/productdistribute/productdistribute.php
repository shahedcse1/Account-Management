<?php

class Productdistribute extends CI_Controller {

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
        $data['title'] = "Product Distribute";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "productdistribute";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $productProcessQry = $this->db->query("SELECT * from productprocess");
            $data['productProcess'] = $productProcessQry->result();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('productdistribute/productdistribute', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    function add_view_productdistribute() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Product Distribute";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "productdistribute";
        $company_id = $this->sessiondata['companyid'];
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['username'] = $this->sessiondata['username'];
            $data['company_id'] = $this->sessiondata['companyid'];
            $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId IN (28,13) AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['supplierinfo1'] = $query2->result();
            $queryp = $this->db->query("SELECT  *  FROM  product where rawmaterial = '0'");
            $data['productinfo'] = $queryp->result();
            $invoiceQr = $this->db->query("SELECT MAX(salesMasterId) as dbinvoice FROM salesmaster");
            $data['dbinvoiceno'] = $invoiceQr->row()->dbinvoice + 1;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('productdistribute/add_view_productdistribute', $data);
            $this->load->view('footer', $data);
            $this->load->view('productdistribute/script', $data);
        else:
            redirect('home');
        endif;
    }

    public function getCurrentBalance() {
        $company_id = $this->sessiondata['companyid'];
        $customerid = $this->input->post('customerid');
        $balanceQr = $this->db->query("SELECT (SUM(debit) - SUM(credit)) AS currentbal FROM ledgerposting WHERE ledgerId = '$customerid' AND companyId = '$company_id'");
        $currentbal = $balanceQr->row()->currentbal;
        echo $currentbal;
    }

    public function product_qty() {
        $product_id = $this->input->post("product_id");
        $sdate = "2000-01-01 00:00:00"; #$this->sessiondata['mindate'];
        $edate = $this->sessiondata['maxdate'];
        if (!empty($product_id)) {
            $quantity = $this->db->query("select sum(stockposting.inwardQuantity-stockposting.outwardQuantity) as totalqty from stockposting join productbatch on productbatch.productBatchId = stockposting.productBatchId AND (stockposting.date between '$sdate%' AND '$edate%') where productbatch.productId = '$product_id'");
            echo $quantity->row()->totalqty;
        }
    }

    public function product_salerate() {
        $product_id = $this->input->post("product_id");
        $queryproductbatch = $this->db->query("SELECT  salesRate  FROM  productbatch  WHERE productId='$product_id'");
        $row = $queryproductbatch->row_array();
        $salesRate = $row['salesRate'];
        echo $salesRate;
    }

    public function unit_name() {
        $product_id = $this->input->post("product_id");
        $queryunit = $this->db->query("SELECT  unitId  FROM  product WHERE productId='$product_id'");
        $row1 = $queryunit->row_array();
        $unitId = $row1['unitId'];
        $queryunitname = $this->db->query("SELECT  unitName  FROM  unit WHERE unitId='$unitId'");
        $row2 = $queryunitname->row_array();
        $unitName = $row2['unitName'];
        echo $unitId . "," . $unitName;
    }

    public function product_description() {
        $product_id = $this->input->post("product_id");
        $queryunit = $this->db->query("SELECT description FROM  product WHERE productId='$product_id'");
        $row1 = $queryunit->row_array();
        $description = $row1['description'];
        echo $description;
    }

    public function accountBasicInfo() {
        $ledgeridval = $this->input->post('ledgerid');
        $explodeidarr = explode(',', $ledgeridval);
        $ledgerid = $explodeidarr[0];
        $sdate = "2000-01-01 00:00:00";
        $edate = $this->input->post('edate');
        $edate = $edate . " 23:59:59";
        $comId = $this->sessiondata['companyid'];
        $supplierinfoQr = $this->db->query("select * from accountledger where ledgerId = '$ledgerid'");
        $supplierinfo = $supplierinfoQr->row();
        $accountno = $supplierinfoQr->row()->accNo;
        $address = $supplierinfoQr->row()->address;
        $totalbalance = 0;
        $ledgerpostingQuery = $this->db->query("SELECT sum(debit) as debit,sum(credit) as credit FROM ledgerposting where date between '$sdate' AND '$edate' AND companyId = '$comId' AND ledgerId = '$ledgerid'");
        //if ($ledgerpostingQuery->row()->debit > $ledgerpostingQuery->row()->credit):
        $totalbalance = $ledgerpostingQuery->row()->debit - $ledgerpostingQuery->row()->credit;
        //else:
        //  $totalbalance = $ledgerpostingQuery->row()->credit - $ledgerpostingQuery->row()->debit;
        //  endif;
        $totalprevAmount = $totalbalance;
        $outputdata = array(
            'accountno' => $accountno,
            'address' => $address,
            'totalprevAmount' => $totalprevAmount
        );
        echo json_encode($outputdata);
    }

    public function add_view_table() {
        $product_name = $this->input->post('product_name');
        $unit = $this->input->post('unit');
        $count = $this->input->post('count');

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'u' || $this->sessiondata['userrole'] == 'r')):
            $queryp = $this->db->query("SELECT  *  FROM  product WHERE productId='$product_name'");
            $row1 = $queryp->row_array();
            $productName = $row1['productName'];
            $queryunit = $this->db->query("SELECT  *  FROM  unit WHERE unitId='$unit'");
            $row2 = $queryunit->row_array();
            $unitName = $row2['unitName'];
            $qty = $this->input->post('qty');
            $rate = $this->input->post('rate');

            $qtyrate = $qty * $rate;
            $grandtotal = $qtyrate;

            $rowdata = '<tr id="row' . $count . '"> <td> <a onclick=deleteRowData(' . $count . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a> </td>
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td id="click" class="edit-field" title="Click for Edit"><span>' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qty' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>
                    <td>' . $unitName . '<input name="unit' . $count . '" id="unit' . $count . '" type="hidden" value="' . $this->input->post('unit') . '"/></td>
                    <td class="edit-field" title="Click for Edit"><span>' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden"  class="edit_input"value="' . $this->input->post('rate') . '"/></td>
               </tr>';

            $printdataoffice = '<tr id="rowoffice' . $count . '">
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td style="text-align: center" id="click" class="edit-field" title="Click for Edit"><span id="qtyofc' . $count . '">' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qtyoffice' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>                  
                    <td style="text-align: right" class="edit-field" title="Click for Edit"><span id="rateofc' . $count . '">' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rateoffice' . $count . '" type="hidden"  class="edit_input"value="' . $this->input->post('rate') . '"/></td><td style="text-align: right"><span id="product_amountoffice' . $count . '">' . number_format($grandtotal, 2) . '</span></td>
               </tr>';
            $printdatacustomer = '<tr id="rowcustomer' . $count . '">
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td style="text-align: center" id="click" class="edit-field" title="Click for Edit"><span id="qtycustomer' . $count . '">' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qty' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>
                    <td style="text-align: center">' . $unitName . '<input name="unit' . $count . '" id="unit' . $count . '" type="hidden" value="' . $this->input->post('unit') . '"/></td>
                    <td style="text-align: right" class="edit-field" title="Click for Edit"><span id="ratecustomer' . $count . '">' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden"  class="edit_input"value="' . $this->input->post('rate') . '"/></td><td style="text-align: right"><span id="product_amountcustomer' . $count . '">' . $grandtotal . '</span></td>
               </tr>';


            $outputdata = array(
                'rowdata' => $rowdata,
                'printdataoffice' => $printdataoffice,
                'printdatacustomer' => $printdatacustomer
            );

            echo json_encode($outputdata);

        else:
            $this->load->view('masterlogin', $data);
        endif;
    }

    public function add_productdistribute() {

        $data['title'] = "Product Distribute";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "productdistribute";
        $data['baseurl'] = $this->config->item('base_url');
        $cmpid = $this->sessiondata['companyid'];
        $data['username'] = $this->sessiondata['username'];
        $netamount = $this->input->post('net_amout');
        #echo $netamount;        exit();
        $count = $this->input->post('count_product');
        $data1Salesmaster = array(
            'salesInvoiceNo' => "",
            'date' => $this->input->post('invoice_date'),
            'ledgerId' => $this->input->post('corparty_account'),
            'salesManId' => $this->input->post('salesMan'),
            'doctorId' => 0,
            'patientId' => 1,
            'billDiscount' => "",
            'vat' => "",
            'tranportation' => "",
            'description' => $this->input->post('description'),
            'voucherNo' => "",
            'suffixPrefixId' => "NA",
            'discountPer' => 0,
            'type' => "Sales",
            'status' => 7,
            'amount' => $netamount,
            'bankCharges' => 0,
            'pricingLevelId' => 1,
            'companyId' => $this->input->post('company_id')
        );
        $this->db->insert('salesmaster', $data1Salesmaster);

        $query1 = $this->db->query("SELECT MAX(salesMasterId) as maxsId FROM salesmaster ");
        $salesMasterId = $query1->row()->maxsId;
        $this->db->query("UPDATE salesmaster SET salesInvoiceNo='$salesMasterId',voucherNo='$salesMasterId' WHERE salesMasterId='$salesMasterId'");
        # Query  ProductBatch Id From productbatch
        for ($i = 1; $i <= $count; $i++) :
            $product_name = $this->input->post('product_name' . $i);
            if ($product_name != ""):
                $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
                if ($query2->num_rows() > 0):
                    $productBatchId = $query2->row()->productBatchId;
                else :
                    $productBatchId = "";
                endif;
                $data2 = array(
                    'salesMasterId' => $salesMasterId,
                    'productBatchId' => $productBatchId,
                    'rate' => $this->input->post('rate' . $i),
                    'qty' => $this->input->post('qty' . $i),
                    'taxIncludedOrNot' => 1,
                    'unitId' => $this->input->post('unit' . $i),
                    'companyId' => $this->input->post('company_id')
                );
                $this->db->insert('salesdetails', $data2);
                $data4 = array(
                    'voucherNumber' => $salesMasterId,
                    'productBatchId' => $productBatchId,
                    'inwardQuantity' => 0,
                    'outwardQuantity' => $this->input->post('qty' . $i),
                    'voucherType' => "Sales Invoice",
                    'date' => $this->input->post('invoice_date'),
                    'unitId' => $this->input->post('unit' . $i),
                    'rate' => $this->input->post('rate' . $i),
                    'defaultInwardQuantity' => 0,
                    'defaultOutwardQuantity' => $this->input->post('qty' . $i),
                    'companyId' => $this->input->post('company_id')
                );
                $this->db->insert('stockposting', $data4);
            endif;
        endfor;
        $data31 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => $this->input->post('corparty_account'),
            'voucherType' => "Product Distribute",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' => "Product Distribute",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => 3,
            'voucherType' => "Product Distribute",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' => "Product Distribute",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $ledgerpostingsts1 = $this->db->insert('ledgerposting', $data31);
        $ledgerpostingsts2 = $this->db->insert('ledgerposting', $data32);

        /*         * **************************************************** ADD To Save New Database ********************************************************** */
        #$shopledgerid = $this->input->post('corparty_account');
        #$shopledgeridQr = $this->db->query("SELECT id FROM shopdetails WHERE accountLedgerId = '$shopledgerid'");
        #$remoteledgerid = $shopledgeridQr->row()->shopledgerid;
        #$shopid = $shopledgeridQr->row()->id;
        #echo $shopid;        exit();
        $shopid = 1;
        $this->load->model('manualdbconfig');
        $dbconfig = $this->manualdbconfig->getconfigval($shopid);
        //print_r($dbconfig);        exit();
        $remotedb = $this->load->database($dbconfig, TRUE);

        $count = $this->input->post('count_product');

        $purid = rand(9, 999999999);
        $invoive_number = $this->input->post('invoive_number');
        $data1Purchasemaster = array(
            'date' => $this->input->post('invoice_date'),
            'ledgerId' => 6,
            'purchaseInvoiceNo' => $salesMasterId,
            'billDiscount' => "",
            'additionalCost' => "",
            'description' => "Purchase Invoice",
            'amount' => $netamount,
            'invoiceStatusId' => 3,
            'companyId' => 1
        );
        $remotedb->insert('purchasemaster', $data1Purchasemaster);

        #print_r($data1Purchasemaster);        exit();
        $query1 = $remotedb->query("SELECT MAX( purchaseMasterId ) FROM purchasemaster ");
        $row1 = $query1->row_array();
        $purchaseMasterId = $row1['MAX( purchaseMasterId )'];

        for ($i = 1; $i <= $count; $i++) :
            $product_name = $this->input->post('product_name' . $i);
            $data5 = array(
                'purchaseRate' => $this->input->post('rate' . $i),
                'salesRate' => $this->input->post('rate' . $i),
            );
            $remotedb->where('productId', $product_name);
            $remotedb->update('productbatch', $data5);
            $query2 = $remotedb->query("SELECT productBatchId FROM productbatch WHERE productId='$product_name'");
            $row2 = $query2->row_array();
            $productBatchId = $row2['productBatchId'];
            $data2 = array(
                'purchaseMasterId' => $purchaseMasterId,
                'productBatchId' => $productBatchId,
                'rate' => $this->input->post('rate' . $i),
                'qty' => $this->input->post('qty' . $i),
                'freeQty' => $this->input->post('freeqty' . $i),
                'taxIncludedOrNot' => 1,
                'companyId' => $this->input->post('company_id')
            );
            $remotedb->insert('purchasedetails', $data2);
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
                'unitId' => $this->input->post('unit' . $i),
                'rate' => $this->input->post('rate' . $i),
                'defaultInwardQuantity' => $totalqty,
                'defaultOutwardQuantity' => 0,
                'companyId' => $this->input->post('company_id')
            );
            $remotedb->insert('stockposting', $data4);
        endfor;

        $data31 = array(
            'voucherNumber' => $purchaseMasterId,
            'ledgerId' => 1,
            'voucherType' => "Purchase Invoice",
            'debit' => $this->input->post('net_amout'),
            'credit' => 0,
            'description' => "Purchase Invoice",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $purchaseMasterId,
            'ledgerId' => 6,
            'voucherType' => "Purchase Invoice",
            'debit' => 0,
            'credit' => $this->input->post('net_amout'),
            'description' => "Product Receive",
            'date' => $this->input->post('invoice_date'),
            'companyId' => $this->input->post('company_id')
        );
        $ledgerpostingsts1 = $remotedb->insert('ledgerposting', $data31);
        $ledgerpostingsts2 = $remotedb->insert('ledgerposting', $data32);
        if ($ledgerpostingsts1 && $ledgerpostingsts2):
            $this->session->set_userdata('success', 'Receipt Voucher added successfully');
            redirect('productdistribute/productdistribute');
        else:
            $this->session->set_userdata('fail', 'Receipt Voucher add failed');
            redirect('productdistribute/productdistribute');
        endif;
    }

    public function getSalesDetailsTable() {
        // DB table to use
        $table = 'salesmaster';
        $primaryKey = 'salesMasterId';
        $columns = array(
            array('db' => '`u`.`salesMasterId`', 'dt' => 0, 'field' => 'salesMasterId',
                'formatter' => function ($rowvalue, $row) {
            return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
        }),
            array('db' => '`u`.`salesMasterId`', 'dt' => 1, 'field' => 'salesMasterId'),
            array('db' => '`p`.`productname`', 'dt' => 2, 'field' => 'productname'),
            array('db' => '`sd`.`qty`', 'dt' => 3, 'field' => 'qty'),
            array('db' => '`sd`.`rate`', 'dt' => 4, 'field' => 'rate'),
            array('db' => '`u`.`date`', 'dt' => 5, 'field' => 'date')
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
        $joinQuery = "FROM `salesmaster` AS `u` JOIN `accountledger` AS `ud` ON `ud`.`ledgerId` = `u`.`ledgerId` JOIN `salesdetails` AS `sd` ON `sd`.`salesMasterId` = `u`.`salesMasterId` JOIN productbatch AS pb JOIN product AS p ON sd.productBatchId = pb.productBatchId AND pb.productId = p.productId";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

    public function delete_productdistribute() {
        $salesMasterId = $this->input->post('salesMasterId');
        $delete1 = $this->db->query("DELETE FROM salesmaster WHERE salesMasterId='$salesMasterId'");
        $delete2 = $this->db->query("DELETE FROM salesdetails  WHERE salesMasterId='$salesMasterId'");
        $delete3 = $this->db->query("DELETE FROM ledgerposting  WHERE voucherType='Product Distribute' AND voucherNumber='$salesMasterId'");
        $delete4 = $this->db->query("DELETE FROM stockposting  WHERE voucherType='Sales Invoice' AND voucherNumber='$salesMasterId'");

        if ($delete1 && $delete2 && $delete3 && $delete4) {
            $this->session->set_userdata('success', 'Distribute Product Deleted successfully');
            redirect('productdistribute/productdistribute');
        }
    }

}
