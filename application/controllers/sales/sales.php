<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('salesdb');
        $this->load->model('ccfreceiptvou');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['title'] = "Sales";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "sales";

        $data['baseurl'] = $this->config->item('base_url');


        if (($this->sessiondata['username'] != NULL) && ($this->sessiondata['status'] == 'login') && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'u' || $this->sessiondata['userrole'] == 'r')):

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

            $discountQr = $this->db->query("SELECT value FROM settings WHERE settings_id=1");
            $data['discount'] = $discountQr->row()->value;
            $saleseditQr = $this->db->query("SELECT value FROM settings WHERE settings_id=2");
            $data['salesedit'] = $saleseditQr->row()->value;
            $printQr = $this->db->query("SELECT value FROM settings WHERE settings_id=3");
            $data['print'] = $printQr->row()->value;
            $allowstockQr = $this->db->query("SELECT value FROM settings WHERE settings_id=4");
            $data['allowstock'] = $allowstockQr->row()->value;
            $keyboardQr = $this->db->query("SELECT value FROM settings WHERE settings_id=5");
            $data['keyboard'] = $keyboardQr->row()->value;
            $csPayQr = $this->db->query("SELECT value FROM settings WHERE settings_id=6");
            $data['csPay'] = $csPayQr->row()->value;
            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('sales/sales', $data);
            $this->load->view('footer', $data);
            $this->load->view('sales/script', $data);
        else:

            redirect('login');
        endif;
    }

//  ==================================  Add new==========================================
    public function add_view() {
        $data['title'] = "Add Sales";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "sales";
        $data['baseurl'] = $this->config->item('base_url');
        $data['userrole'] = $this->sessiondata['userrole'];
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'u' || $this->sessiondata['userrole'] == 'r')):

            // add new unit
            if (isset($this->session->userdata['dataaddedpurchase'])) {
                if ($this->session->userdata['dataaddedpurchase'] != NULL && $this->session->userdata['dataaddedpurchase'] == 'add_unit') {
                    $data['data_added'] = $this->session->userdata('dataaddedpurchase');
                    $this->session->unset_userdata('dataaddedpurchase');
                }
            }
            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];
            $data['username'] = $this->sessiondata['username'];


            //query  salesman from table
            $queryp = $this->db->query("SELECT  *  FROM user where role='s'");
            $data['salesmaninfo'] = $queryp->result();

            $user_role = $this->sessiondata['userrole'];
            $user_id = $this->sessiondata['userid'];

            if ($user_role == 's'):
                $resultQuery = $this->db->query("SELECT  *  FROM  user WHERE userId='$user_id'");
                if ($resultQuery->num_rows() > 0):
                    $data['selectedSalesmanId'] = $resultQuery->row()->userId;
                else:
                    $data['selectedSalesmanId'] = "";
                endif;
            else:
                $data['selectedSalesmanId'] = "";
            endif;
            /*
              if ($user_role == 's'):
              $resultQuery = $this->db->query("SELECT  salesManId  FROM  salesman WHERE ledgerId='$user_id'");
              if ($resultQuery->num_rows() > 0):
              $data['selectedSalesmanId'] = $resultQuery->row()->salesManId;
              else:
              $data['selectedSalesmanId'] = "";
              endif; */


            //For printing the report
            $querycom = $this->db->query("SELECT  *  FROM  company where companyId = '$company_id'");
            $data['companyinfo'] = $querycom->row();


            //Get database sales invoice id
            $invoiceQr = $this->db->query("SELECT MAX(salesMasterId) as dbinvoice FROM salesmaster");
            $data['dbinvoiceno'] = $invoiceQr->row()->dbinvoice + 1;

//            //query  unit  name from table
//            $queryunit = $this->db->query("SELECT  *  FROM  unit");
//            $data['unitinfo'] = $queryunit->result();

            $discountQr = $this->db->query("SELECT value FROM settings WHERE settings_id=1");
            $data['discount'] = $discountQr->row()->value;
            $saleseditQr = $this->db->query("SELECT value FROM settings WHERE settings_id=2");
            $data['salesedit'] = $saleseditQr->row()->value;
            $printQr = $this->db->query("SELECT value FROM settings WHERE settings_id=3");
            $data['print'] = $printQr->row()->value;
            $allowstockQr = $this->db->query("SELECT value FROM settings WHERE settings_id=4");
            $data['allowstock'] = $allowstockQr->row()->value;
            $keyboardQr = $this->db->query("SELECT value FROM settings WHERE settings_id=5");
            $data['keyboard'] = $keyboardQr->row()->value;
            $csPayQr = $this->db->query("SELECT value FROM settings WHERE settings_id=6");
            $data['csPay'] = $csPayQr->row()->value;
            $enableSearchQr = $this->db->query("SELECT value FROM settings WHERE settings_id=8");
            $data['enablesearch'] = $enableSearchQr->row()->value;

            $data['SoldBy'] = $this->db
                            ->select('value')
                            ->from('settings')
                            ->where('settings_id', 9)
                            ->get()
                            ->row()
                    ->value;

            $data['barcodeOnSales'] = $this->db
                            ->select('value')
                            ->from('settings')
                            ->where('settings_id', 12)
                            ->get()
                            ->row()
                    ->value;

            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('sales/add_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('sales/script', $data);
        else:
            redirect('login');
        endif;
    }

    /**
     * Get Supplier Information
     */
    public function getSupplier() {
        $supplier = $this->db
                ->select('ledgerId')
                ->select('nameOfBusiness')
                ->select('acccountLedgerName')
                ->from('accountledger')
                ->where_in('accountGroupId', [28, 13])
                ->where('companyId', $this->sessiondata['companyid'])
                ->order_by('ledgerId', 'DESC')
                ->get()
                ->result();

        echo json_encode($supplier);
    }

    /**
     * Get Product Information
     */
    public function getProduct() {
        $productinfo = $this->db
                ->select('productId')
                ->select('productName')
                ->from('product')
                ->get()
                ->result();

        echo json_encode($productinfo);
    }

    /**
     * Get Unit Id and Unit Name
     */
    public function getProdInfo() {
        $prodId = $this->input->post('prodid');

        $data['prod'] = $this->db
                ->select('unit.unitId')
                ->select('unit.unitName')
                ->select('product.productName')
                ->select('productbatch.salesRate')
                ->join('product', 'unit.unitId = product.unitId')
                ->join('productbatch', 'product.productId = productbatch.productId')
                ->from('unit')
                ->where('product.productId', $prodId)
                ->get()
                ->row();

        echo json_encode($data);
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

    //query unit id for product
    public function product_description() {
        $product_id = $this->input->post("product_id");
        //query  unit  name from table
        $queryunit = $this->db->query("SELECT description FROM  product WHERE productId='$product_id'");
        $row1 = $queryunit->row_array();
        $description = $row1['description'];
        echo $description;
    }

    public function getBusinessofName() {
        $ledgerId = $this->input->post("ledgerId");

        //query  unit  name from table
        $queryunit = $this->db->query("SELECT  nameOfBusiness  FROM  accountledger WHERE ledgerId='$ledgerId'");
        // $data['unitinfo'] = $queryunit->result();
        $row1 = $queryunit->row_array();
        $unitId = $row1['nameOfBusiness'];

        echo $unitId;
    }

    public function getCurrentBalance() {
        $company_id = $this->sessiondata['companyid'];
        $customerid = $this->input->post('customerid');
        $balanceQr = $this->db->query("SELECT (SUM(debit) - SUM(credit)) AS currentbal FROM ledgerposting WHERE ledgerId = '$customerid' AND companyId = '$company_id'");
        $currentbal = $balanceQr->row()->currentbal;
        echo $currentbal;
    }

    //query qty range for product
    public function product_qty() {
        $product_id = $this->input->post("product_id");
        $sdate = "2000-01-01 00:00:00"; #$this->sessiondata['mindate'];
        $edate = $this->sessiondata['maxdate'];
        if (!empty($product_id)) {
            $quantity = $this->db->query("select sum(stockposting.inwardQuantity-stockposting.outwardQuantity) as totalqty from stockposting join productbatch on productbatch.productBatchId = stockposting.productBatchId AND (stockposting.date between '$sdate%' AND '$edate%') where productbatch.productId = '$product_id'");
            echo $quantity->row()->totalqty;
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
        $product_name = $this->input->post('product_name');
        $unit = $this->input->post('unit');
        $count = $this->input->post('count');
        $salesedit = $this->input->post('salesedit');
        if ($salesedit == "0"):
            $chkreadonly = "readonly";
        else:
            $chkreadonly = "";
        endif;


        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'u' || $this->sessiondata['userrole'] == 'r')):
            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product WHERE productId='$product_name'");
            $row1 = $queryp->row_array();
            $productName = $row1['productName'];

            //query  unit  name from table
            $queryunit = $this->db->query("SELECT  *  FROM  unit WHERE unitId='$unit'");
            $row2 = $queryunit->row_array();
            $unitName = $row2['unitName'];

            //Net amount per product
            $qty = $this->input->post('qty');
            $rate = $this->input->post('rate');

            $qtyrate = $qty * $rate;
            $grandtotal = $qtyrate;  //total amount

            $rowdata = '<tr id="row' . $count . '"> <td> <a onclick=deleteRowData(' . $count . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a> </td>
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td id="click" class="edit-field" title="Click for Edit"><span>' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qty' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>
                    <td>' . $unitName . '<input name="unit' . $count . '" id="unit' . $count . '" type="hidden" value="' . $this->input->post('unit') . '"/></td>
                    <td class="edit-field" title="Click for Edit" ><span>' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden" ' . $chkreadonly . '  class="edit_input" value="' . $this->input->post('rate') . '"/></td>'
                    . '<td><span id="product_amount' . $count . '">' . $grandtotal . '</span></td>
               </tr>';

            $printdataoffice = '<tr id="rowoffice' . $count . '">
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td style="text-align: center" id="click" class="edit-field" title="Click for Edit"><span id="qtyofc' . $count . '">' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qtyoffice' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>                  
                    <td style="text-align: right" class="edit-field" title="Click for Edit"><span id="rateofc' . $count . '">' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rateoffice' . $count . '" type="hidden"  class="edit_input" value="' . $this->input->post('rate') . '"/></td>
                    <td style="text-align: right"><span id="product_amountoffice' . $count . '">' . number_format($grandtotal, 2) . '</span></td>
               </tr>';
            $printdatacustomer = '<tr id="rowcustomer' . $count . '">
                    <td>' . $productName . '<input name="product_name' . $count . '" id="product_name' . $count . '" type="hidden" value="' . $this->input->post('product_name') . '"/></td>
                    <td style="text-align: center" id="click" class="edit-field" title="Click for Edit"><span id="qtycustomer' . $count . '">' . $this->input->post('qty') . '</span><input name="qty' . $count . '"  class="edit_input" id="qty' . $count . '" type="hidden" value="' . $this->input->post('qty') . '"/></td>
                    <td style="text-align: center">' . $unitName . '<input name="unit' . $count . '" id="unit' . $count . '" type="hidden" value="' . $this->input->post('unit') . '"/></td>
                    <td style="text-align: right" class="edit-field" title="Click for Edit"><span id="ratecustomer' . $count . '">' . $this->input->post('rate') . '</span><input name="rate' . $count . '" id="rate' . $count . '" type="hidden"  class="edit_input" value="' . $this->input->post('rate') . '"/></td>
                    <td style="text-align: right"><span id="product_amountcustomer' . $count . '">' . $grandtotal . '</span></td>
               </tr>';


            $outputdata = array(
                'rowdata' => $rowdata,
                'printdataoffice' => $printdataoffice,
                'printdatacustomer' => $printdatacustomer
            );

            echo json_encode($outputdata);

        //echo '<td><span id="product_amount' . $count . '">' . $grandtotal . '</span></td>
        // </tr>';

        else:
            $this->load->view('masterlogin', $data);
        endif;
    }

    /**
     * Add Sales
     */
    public function add() {
        $data['title'] = "Sales";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "sales";
        $data['baseurl'] = $this->config->item('base_url');
        $cmpid = $this->sessiondata['companyid'];
        $data['username'] = $this->sessiondata['username'];

        $netamount = $this->input->post('net_amout') - $this->input->post('previous_amount');

        if ($netamount > 0):
            $saledate = date('Y-m-d H:i:s');
            $count = $this->input->post('count_product');

            //===================1st tbl salesmaster==============================================================
            $billtoid = $this->input->post('corparty_account');

            $invoiceStatusId = ($billtoid == 2) ? 1 : 3;

            $data1 = [
                'salesInvoiceNo' => '',
                'date' => $saledate,
                'ledgerId' => $billtoid,
                'salesManId' => $this->input->post('salesMan'),
                'doctorId' => 0,
                'patientId' => 1,
                'billDiscount' => $this->input->post('discount'),
                'vat' => $this->input->post('vat'),
                'tranportation' => $this->input->post('transport'),
                'description' => $this->input->post('description'),
                'voucherNo' => "",
                'suffixPrefixId' => "NA",
                'discountPer' => 0,
                'type' => "Sales",
                'status' => $invoiceStatusId,
                'amount' => $netamount,
                'previousdue' => $this->input->post('previous_amount'),
                'bankCharges' => 0,
                'pricingLevelId' => 1,
                'companyId' => $this->input->post('company_id')
            ];

            $this->db
                    ->insert('salesmaster', $data1);

            $salesMasterId = $this->db
                    ->insert_id();

            $this->db
                    ->set('salesInvoiceNo', $salesMasterId)
                    ->set('voucherNo', $salesMasterId)
                    ->where('salesMasterId', $salesMasterId)
                    ->update('salesmaster');

            //======================Query  ProductBatch Id From productbatch==================================================================
            for ($i = 1; $i <= $count; $i++) {
                $product_name = $this->input->post('product_name' . $i);

                if ($product_name != ''):
                    //Query productBatchId
                    $query2 = $this->db->query("SELECT productBatchId, purchaseRate FROM productbatch WHERE productId='$product_name'");
                    if ($query2->num_rows() > 0) {
                        $row2 = $query2->row_array();
                        $productBatchId = $row2['productBatchId'];
                        $purchaseRate = $row2['purchaseRate'];
                    } else {
                        $productBatchId = "";
                        $purchaseRate = 0.00;
                    }

                    $data2[] = [
                        'salesMasterId' => $salesMasterId,
                        'productBatchId' => $productBatchId,
                        'rate' => $this->input->post('rate' . $i),
                        'purchaserate' => $purchaseRate,
                        'qty' => $this->input->post('qty' . $i),
                        'taxIncludedOrNot' => 1,
                        'unitId' => $this->input->post('unit' . $i),
                        'companyId' => $this->input->post('company_id')
                    ];


                    $data4[] = [
                        'voucherNumber' => $salesMasterId,
                        'productBatchId' => $productBatchId,
                        'inwardQuantity' => 0,
                        'outwardQuantity' => $this->input->post('qty' . $i),
                        'voucherType' => "Sales Invoice",
                        'date' => $saledate,
                        'unitId' => $this->input->post('unit' . $i),
                        'rate' => $this->input->post('rate' . $i),
                        'defaultInwardQuantity' => 0,
                        'defaultOutwardQuantity' => $this->input->post('qty' . $i),
                        'companyId' => $this->input->post('company_id')
                    ];
                endif;
            }

            $salesdetailssts = $this->db
                    ->insert_batch('salesdetails', $data2);
            $stockpostingsts = $this->db
                    ->insert_batch('stockposting', $data4);

            //======================3rd tbl ledgerposting========================================================
            $data31 = [
                'voucherNumber' => $salesMasterId,
                'ledgerId' => $billtoid,
                'voucherType' => "Sales Invoice",
                'debit' => $netamount,
                'credit' => 0,
                'description' => "By Sales",
                'date' => $saledate,
                'companyId' => $this->input->post('company_id')
            ];
            $data32 = [
                'voucherNumber' => $salesMasterId,
                'ledgerId' => 3,
                'voucherType' => "Sales Invoice",
                'debit' => 0,
                'credit' => $netamount,
                'description' => "By Sales",
                'date' => $saledate,
                'companyId' => $this->input->post('company_id')
            ];
            $ledgerpostingsts1 = $this->db
                    ->insert('ledgerposting', $data31);
            $ledgerpostingsts2 = $this->db
                    ->insert('ledgerposting', $data32);

            //Add Receipt details
            $receiptsts = TRUE;
            if ($billtoid != 2):
                $paymentmode = $this->input->post('paymentMode');
                $modedata = explode(',', $paymentmode);
                $ledgerid = $modedata[0];
                $paidamount = $this->input->post('paidamount');
                $netamount = $this->input->post('net_amout');

                if ($paidamount > $netamount) {
                    $paidamount = $netamount;
                }

                if ($ledgerid > 0 && $paidamount > 0):
                    $paymentdata = [
                        'date' => $saledate,
                        'ledgerId' => $ledgerid,
                        'receiptMode' => $this->input->post('optionsRadios'),
                        'description' => 'Cash Received by Sales #' . $salesMasterId,
                        'salesMasterId' => $salesMasterId,
                        'companyId' => $cmpid
                    ];
                    $insertpaymentstatus = $this->db
                            ->insert('receiptmaster', $paymentdata);

                    $payid = $this->db
                            ->insert_id();

                    if ($insertpaymentstatus) {
                        ccflogdata($this->sessiondata['username'], "accesslog", "Add ReceiptVoucher", "Receipt Voucher No. $payid Added");
                    }

                    $datapaymentdetails = array(
                        'receiptMasterId ' => $payid,
                        'ledgerId' => $billtoid,
                        'voucherNumber' => "",
                        'voucherType' => "",
                        'amount' => $paidamount,
                        'chequeNumber' => $this->input->post('chequeNumber'),
                        'chequeDate' => $this->input->post('chequeDate'),
                        'description' => 'Cash Received by Sales #' . $salesMasterId,
                        'companyId' => $this->sessiondata['companyid']
                    );
                    $insertpaydetailsstatus = $this->db
                            ->insert('receiptdetails', $datapaymentdetails);

                    $datal1 = array(
                        'date' => $saledate,
                        'ledgerId' => $ledgerid,
                        'voucherNumber' => $payid,
                        'voucherType' => "Receipt Voucher",
                        'credit' => "0.00",
                        'debit' => $paidamount,
                        'description' => "By Receipt",
                        'companyId' => $this->sessiondata['companyid']
                    );
                    $insertstatusl1 = $this->db
                            ->insert('ledgerposting', $datal1);

                    $datal2 = array(
                        'date' => $saledate,
                        'ledgerId' => $billtoid,
                        'voucherNumber' => $payid,
                        'voucherType' => "Receipt Voucher",
                        'credit' => $paidamount,
                        'debit' => "0.00",
                        'description' => "By Receipt",
                        'companyId' => $this->sessiondata['companyid']
                    );
                    $insertstatusl2 = $this->db
                            ->insert('ledgerposting', $datal2);

                    $receiptsts = ($insertpaymentstatus && $insertpaydetailsstatus && $insertstatusl1 && $insertstatusl2) ? TRUE : FALSE;

                else:
                    $receiptsts = TRUE;
                endif;
            endif;


            if ($salesdetailssts && $stockpostingsts && $ledgerpostingsts1 && $ledgerpostingsts2 && $receiptsts):
                $this->session->set_userdata(array('dataaddedpurchase' => 'added'));
            else:
                $this->session->set_userdata(array('dataaddedpurchase' => 'adderror'));
            endif;

            //log data
            ccflogdata($this->sessiondata['username'], "accesslog", "Add Sales", "Add Sales For Invoice No: " . $salesMasterId . "");
        else:
            $this->session->set_userdata(array('dataaddedpurchase' => 'adderror'));
        endif;
        redirect('sales/sales');
    }

//  =============================================  Edit page======================================================
    public function add_view_edit() {
        $data['title'] = "Sales...edit";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "sales";
        $data['baseurl'] = $this->config->item('base_url');

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['company_id'] = $this->sessiondata['companyid'];
            $company_id = $data['company_id'];
            $data['username'] = $this->sessiondata['username'];
            $data['userrole'] = $this->sessiondata['userrole'];
            //query  supplier name from table
            $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId IN (28,13)  AND  companyId='$company_id' ORDER BY ledgerId DESC");
            $data['supplierinfo1'] = $query2->result();

            //query  product  name from table
            $queryp = $this->db->query("SELECT  *  FROM  product");
            $data['productinfo'] = $queryp->result();

            //query  unit  name from table
            $queryunit = $this->db->query("SELECT  *  FROM  unit");
            $data['unitinfo'] = $queryunit->result();

            /* ======================= query data from inserted tables=========================== */
            $id = $this->input->get('id');
            // $ledger=$this->input->get('ledger');
            //query  from PurchaseMaster
            $comId = $this->sessiondata['companyid'];
            $querysalesmaster = $this->db->query("SELECT  *  FROM  salesmaster WHERE salesMasterId='$id'");
            $data['salesmasterinfo'] = $querysalesmaster->result();
            $data['transportcost'] = $querysalesmaster->row()->tranportation;
            $data['discount'] = $querysalesmaster->row()->billDiscount;
            $data['vat'] = $querysalesmaster->row()->vat;
            $data['driver_name'] = $querysalesmaster->row()->driver_name;
            $ledgerid = $querysalesmaster->row()->ledgerId;
            $data['invoice'] = $querysalesmaster->row()->salesInvoiceNo;
            $data['description'] = $querysalesmaster->row()->description;
            $newdate = new DateTime($querysalesmaster->row()->date);
            $data['date'] = $newdate->format("F j, Y, g:i a");
            $salesmanid = $querysalesmaster->row()->salesManId;
            $data['totalprevAmount'] = $querysalesmaster->row()->previousdue;

            if (is_numeric($salesmanid)):
                $getsalesman = $this->db->query("select salesManName from salesman where salesManId = '$salesmanid'");
                if ($getsalesman->num_rows() > 0) {
                    $data['salesmanname'] = $getsalesman->row()->salesManName;
                } else {
                    $data['salesmanname'] = "";
                }
            else:
                $data['salesmanname'] = $salesmanid;
            endif;

            $data['accntledgerid'] = $ledgerid;

            $supplierinfo = $this->db->query("select * from accountledger where ledgerId = '$ledgerid'");
            $data['supplierinfo'] = $supplierinfo->row();
            $sdate = "2000-01-01 00:00:00";
            $edate = $querysalesmaster->row()->date;

            //$ledgerpostingQuery = $this->db->query("SELECT sum(debit) as debit,sum(credit) as credit FROM ledgerposting where companyId = '$comId' AND ledgerId = '$ledgerid'");
            // if ($ledgerpostingQuery->row()->debit > $ledgerpostingQuery->row()->credit):
            //$totalbalance = $ledgerpostingQuery->row()->debit - $ledgerpostingQuery->row()->credit;
            // else:
            //      $totalbalance = $ledgerpostingQuery->row()->credit - $ledgerpostingQuery->row()->debit;
            // endif;

            /*   if ($ledgerid != 2):
              $balanceQr = $this->db->query("SELECT (SUM(debit) - SUM(credit)) AS currentbal FROM ledgerposting WHERE ledgerId = '$ledgerid' AND companyId = '$comId'");
              $totalbalance = $balanceQr->row()->currentbal;
              else:
              $totalbalance = 0;
              endif; */

            $querycom = $this->db->query("SELECT  *  FROM  company where companyId = '$company_id'");
            $data['companyinfo'] = $querycom->row();
            //$data['totalprevAmount'] = $totalbalance;
            //for product
            //from purchasedetails
            $queryratequalityvat = $this->db->query("SELECT ledgerposting.ledgerPostingId,salesdetails.salesDetailsId,salesdetails.salesMasterId,salesdetails.productBatchId,salesdetails.rate,salesdetails.qty,salesdetails.unitId,stockposting.serialNumber,stockposting.voucherNumber,stockposting.inwardQuantity,stockposting.outwardQuantity,stockposting.voucherType,stockposting.companyId from salesdetails inner JOIN stockposting ON salesdetails.salesMasterId = stockposting.voucherNumber AND salesdetails.productBatchId = stockposting.productBatchId JOIN ledgerposting ON ledgerposting.voucherNumber=salesdetails.salesMasterId WHERE salesdetails.salesMasterId='$id' AND ledgerposting.credit=0 AND ledgerposting.voucherType='Sales Invoice'group by salesdetails.salesDetailsId DESC");
            $data['ratequalityvat'] = $queryratequalityvat->result();
            $data['count_product'] = $queryratequalityvat->num_rows();

            //from productbatch
            $queryproducts = $this->db->query("SELECT  *  FROM  productbatch");
            $data['products'] = $queryproducts->result();

            //query  salesman from table
            $queryp = $this->db->query("SELECT  *  FROM  user");
            $data['salesmaninfo'] = $queryp->result();

            $discountQr = $this->db->query("SELECT value FROM settings WHERE settings_id=1");
            $data['discountsett'] = $discountQr->row()->value;

            $saleseditQr = $this->db->query("SELECT value FROM settings WHERE settings_id=2");
            $data['salesedit'] = $saleseditQr->row()->value;

            $printQr = $this->db->query("SELECT value FROM settings WHERE settings_id=3");
            $data['print'] = $printQr->row()->value;

            //For sales payment edit
            $paymentinfoQr = $this->db->query("SELECT rm.ledgerId as payledger, rm.receiptMode as paymentMode, rd.amount as paidamount, rd.chequeNumber as chequeNumber, rd.chequeDate as chequeDate FROM receiptmaster rm JOIN receiptdetails rd ON rm.receiptMasterId = rd.receiptMasterId WHERE rm.salesMasterId = '$id'");
            if ($paymentinfoQr->num_rows() > 0):
                $data['paymentinfo'] = $paymentinfoQr->row();
            else:
                $paymentinfo = new stdClass;
                $paymentinfo->payledger = "";
                $paymentinfo->paymentMode = "";
                $paymentinfo->paidamount = 0;
                $paymentinfo->chequeNumber = "";
                $paymentinfo->chequeDate = "";
                $data['paymentinfo'] = $paymentinfo;
            endif;
            $data['ledgerdata'] = $this->ccfreceiptvou->getledger();
            $data['ledgerdatabycash'] = $this->ccfreceiptvou->getledgerbycash();

            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('sales/edit_view', $data);
            $this->load->view('footer', $data);
            $this->load->view('sales/script-edit', $data);
        else:
            redirect('login');
        endif;
    }

    public function accountBasicInfo() {
        $ledgeridval = $this->input->post('ledgerid');
        $explodeidarr = explode(',', $ledgeridval);
        $ledgerid = $explodeidarr[0];
        $sdate = "2000-01-01 00:00:00";
        $edate = date('d-m-Y H:i:s');
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

    public function dataqueryedit() {
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

    /**
     * Update Sales Information
     */
    public function edit() {
        $data['title'] = "Sales";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "sales";
        $data['baseurl'] = $this->config->item('base_url');

        $count = $this->input->post('count_product');
        $salesMasterId = $this->input->post('salesMasterId');

        /**
         * Update `salesmaster` table
         */
        $invoiceStatusId = ($this->input->post('corparty_account') == 2) ? 1 : 3;
        $netamount = $this->input->post('net_amout') - $this->input->post('previous_amount');

        $data1 = [
            'salesInvoiceNo' => $salesMasterId,
            'ledgerId' => $this->input->post('corparty_account'),
            'salesManId' => $this->input->post('salesMan'),
            'doctorId' => 0,
            'patientId' => 1,
            'billDiscount' => $this->input->post('discount'),
            'vat' => $this->input->post('vat'),
            'tranportation' => $this->input->post('transport'),
            'description' => $this->input->post('description'),
            'voucherNo' => $salesMasterId,
            'suffixPrefixId' => "NA",
            'discountPer' => 0,
            'type' => "Sales",
            'status' => $invoiceStatusId,
            'amount' => $netamount,
            'bankCharges' => 0,
            'pricingLevelId' => 1,
            'companyId' => $this->input->post('company_id')
        ];
        $this->db
                ->where('salesMasterId', $salesMasterId)
                ->update('salesmaster', $data1);

        //======================Query  ProductBatch Id From productbatch==================================================================
        for ($i = 1; $i <= $count; $i++) {
            $product_id = $this->input->post('product_id' . $i);
            //Query productBatchId
            $query2 = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId='$product_id'");
            if ($query2->num_rows() > 0) {
                $row2 = $query2->row_array();
                $productBatchId = $row2['productBatchId'];
            } else {
                $productBatchId = "";
            }

            /**
             * Update `salesdetails` table
             */
            $data2 = [
                'salesMasterId' => $salesMasterId,
                'productBatchId' => $productBatchId,
                'rate' => $this->input->post('rate' . $i),
                'qty' => $this->input->post('qty' . $i),
                'taxIncludedOrNot' => 1,
                'unitId' => $this->input->post('unit_id' . $i),
                'companyId' => $this->input->post('company_id')
            ];
            $this->db
                    ->where('salesDetailsId', $_POST["purchaseDetailsId"][$i - 1])
                    ->update('salesdetails', $data2);

            /**
             * Update `stockposting` table
             */
            $data4 = [
                'voucherNumber' => $salesMasterId,
                'productBatchId' => $productBatchId,
                'inwardQuantity' => 0,
                'outwardQuantity' => $this->input->post('qty' . $i),
                'voucherType' => "Sales Invoice",
                'unitId' => $this->input->post('unit_id' . $i),
                'rate' => $this->input->post('rate' . $i),
                'defaultInwardQuantity' => 0,
                'defaultOutwardQuantity' => $this->input->post('qty' . $i),
                'companyId' => $this->input->post('company_id')
            ];
            $this->db
                    ->where('serialNumber', $_POST['serialnumber'][$i - 1])
                    ->where('voucherType', "Sales Invoice")
                    ->update('stockposting', $data4);
        }
        //======================3rd tbl ledgerposting========================================================
        $ledgerPostingId = $this->input->post('ledgerPostingId');
        $data31 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => $this->input->post('corparty_account'),
            'voucherType' => "Sales Invoice",
            'debit' => $netamount,
            'credit' => 0,
            'description' => "By Sales",
            'companyId' => $this->input->post('company_id')
        );
        $data32 = array(
            'voucherNumber' => $salesMasterId,
            'ledgerId' => 3,
            'voucherType' => "Sales Invoice",
            'debit' => 0,
            'credit' => $netamount,
            'description' => "By Sales",
            'companyId' => $this->input->post('company_id')
        );

        $this->db->where('ledgerPostingId', $ledgerPostingId);
        $ledgerpostingsts1 = $this->db->update('ledgerposting', $data31);
        $this->db->where('ledgerPostingId', $ledgerPostingId + 1);
        $ledgerpostingsts2 = $this->db->update('ledgerposting', $data32);


        //For payment edit..
        $paymentinfoQr = $this->db->query("SELECT receiptMasterId FROM receiptmaster WHERE salesMasterId = '$salesMasterId'");
        if ($paymentinfoQr->num_rows() > 0):
            $receiptMasterId = $paymentinfoQr->row()->receiptMasterId;
            $query = $this->db->query("Select ledgerPostingId from ledgerposting where voucherNumber='$receiptMasterId' AND voucherType = 'Receipt Voucher'");
            $IdAvailable = $query->result();
            foreach ($IdAvailable as $value) {
                $myarray[] = $value->ledgerPostingId;
            }
            $firstid = $myarray[0];
            $secondid = $myarray[1];

            $paymentmode = $this->input->post('paymentMode');
            $modedata = explode(',', $paymentmode);
            $ledgerId = $modedata[0];
            $paymentMode = $this->input->post('optionsRadios');
            $datamaster = array(
                'ledgerId' => $ledgerId,
                'description' => 'Cash Received by Sales #' . $salesMasterId,
                'receiptMode' => $paymentMode
            );
            $this->db->where('receiptMasterId', $receiptMasterId);
            $updatepaymaster = $this->db->update('receiptmaster', $datamaster);
            if ($updatepaymaster) {
                ccflogdata($this->sessiondata['username'], "accesslog", "Update ReciptVoucher", "Receipt Voucher No " . $receiptMasterId . " Updated");
            }

            $datadetails = array(
                'ledgerId' => $this->input->post('corparty_account'),
                'amount' => $this->input->post('paidamount'),
                'description' => 'Cash Received by Sales #' . $salesMasterId,
            );
            $this->db->where('receiptMasterId', $receiptMasterId);
            $updatepaymentdetails = $this->db->update('receiptdetails', $datadetails);

            $datal1 = array(
                'ledgerId' => $ledgerId,
                'debit' => $amount,
                'credit' => '0.00'
            );
            $this->db->where('ledgerPostingId', $firstid);
            $updatel1 = $this->db->update('ledgerposting', $datal1);

            $datal2 = array(
                'ledgerId' => $this->input->post('corparty_account'),
                'credit' => $amount,
                'debit' => '0.00'
            );
            $this->db->where('ledgerPostingId', $secondid);
            $updatel2 = $this->db->update('ledgerposting', $datal2);
            if ($updatepaymaster && $updatepaymentdetails && $updatel1 && $updatel2):
                $updatepaymentsts = TRUE;
            else:
                $updatepaymentsts = FALSE;
            endif;
        else:
            $updatepaymentsts = TRUE;
        endif;

        ($ledgerpostingsts1 && $ledgerpostingsts2 && $updatepaymentsts) ? $this->session->set_userdata(array('dataaddedpurchase' => 'edited')) : $this->session->set_userdata(array('dataaddedpurchase' => 'adderror'));

        ccflogdata($this->sessiondata['username'], "accesslog", "Edit Sales", "Edit Sales For Invoice No: " . $_POST['salesMasterId'] . "");
        redirect('sales/sales', $data);
    }

    //================================================================================Delete data=================================================
    public function delete() {
        $salesMasterId = $this->input->post('salesMasterId');
        //$query1 = $this->db->query("SELECT  *  FROM  partybalance WHERE voucherNo='$salesMasterId' AND voucherType='Receipt Voucher'");
        //$row1 = $query1->row();
        $query2 = $this->db->query("SELECT  salesDetailsId  FROM  salesdetails WHERE salesMasterId='$salesMasterId'");
        $row2 = $query2->row_array();
        $salesDetailsId = $row2['salesDetailsId'];
        $query3 = $this->db->query("SELECT  *  FROM  salesreturndetails WHERE salesDetailsId='$salesDetailsId'");
        $row3 = $query3->row();
        if ($row3) {
            $this->session->set_userdata(array('dataaddedpurchase' => 'notdeleted'));
            redirect('sales/sales');
        } else {
            $delete1 = $this->db->query("DELETE FROM salesmaster WHERE salesMasterId='$salesMasterId'");
            $delete2 = $this->db->query("DELETE FROM salesdetails  WHERE salesMasterId='$salesMasterId'");
            $delete3 = $this->db->query("DELETE FROM ledgerposting  WHERE voucherType='Sales Invoice' AND voucherNumber='$salesMasterId'");
            $delete4 = $this->db->query("DELETE FROM stockposting  WHERE voucherType='Sales Invoice' AND voucherNumber='$salesMasterId'");
            //Delete from receipt details if any
            $paymentinfoQr = $this->db->query("SELECT receiptMasterId FROM receiptmaster WHERE salesMasterId = '$salesMasterId'");
            if ($paymentinfoQr->num_rows() > 0):
                $receiptMasterId = $paymentinfoQr->row()->receiptMasterId;
                $delete1 = $this->db->query("DELETE FROM receiptmaster WHERE salesMasterId = '$salesMasterId' AND receiptMasterId = '$receiptMasterId'");
                $delete2 = $this->db->query("DELETE FROM receiptdetails WHERE receiptMasterId = '$receiptMasterId'");
                $delete3 = $this->db->query("DELETE FROM ledgerposting WHERE voucherNumber = '$receiptMasterId' AND voucherType = 'Receipt Voucher'");
            endif;

            if ($delete1 && $delete2 && $delete3 && $delete4) {
                $this->session->set_userdata(array('dataaddedpurchase' => 'deleted'));
                ccflogdata($this->sessiondata['username'], "accesslog", "Delete Sales", "Delete Sales For Invoice No: " . $salesMasterId . "");
                redirect('sales/sales');
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
            redirect('sales/sales/add_view');
        }
    }

    //=======================================check OrderNo====================================================================================
    public function checkorderno() {
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

    public function getSalesDetailsTable() {
        // DB table to use
        $table = 'salesmaster';
        $primaryKey = 'salesMasterId';
        $columns = array(
            array('db' => '`u`.`salesMasterId`', 'dt' => 0, 'field' => 'salesMasterId',
                'formatter' => function ($rowvalue, $row) {
            return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
        }),
            array('db' => '`u`.`salesInvoiceNo`', 'dt' => 1, 'field' => 'salesInvoiceNo',
                'formatter' => function($rowvalue, $row) {
            return '<a class="edit_purchase" href="' . site_url('sales/sales/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
        }),
            array('db' => '`ud`.`acccountLedgerName`', 'dt' => 2, 'field' => 'acccountLedgerName',
                'formatter' => function($rowvalue, $row) {
            return '<a class="edit_purchase" href="' . site_url('sales/sales/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
        }),
            array('db' => '`ud`.`nameOfBusiness`', 'dt' => 3, 'field' => 'nameOfBusiness',
                'formatter' => function($rowvalue, $row) {
            return '<a class="edit_purchase" href="' . site_url('sales/sales/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
        }),
            array('db' => '`u`.`amount`', 'dt' => 4, 'field' => 'amount',
                'formatter' => function($rowvalue, $row) {
            return '<a class="edit_purchase" href="' . site_url('sales/sales/add_view_edit?id=' . $row[0]) . '">' . $rowvalue . '</a>';
        }),
            array('db' => '`u`.`date`', 'dt' => 5, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
            return '<a class="edit_purchase" href="' . site_url('sales/sales/add_view_edit?id=' . $row[0]) . '">' . date('d M Y', strtotime($rowvalue)) . '</a>';
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
        $joinQuery = "FROM `salesmaster` AS `u` JOIN `accountledger` AS `ud` ON (`ud`.`ledgerId` = `u`.`ledgerId`)";
        $extraWhere = "`u`.`companyId` = '$companyid' AND `ud`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
