<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProductReport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Product Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "product_report";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];

            $idSelect = $this->input->post('productname');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";




            //Opening balance for customer
            $strtotime_form = strtotime($date_from);
            $previous_dateadd = strtotime("-1 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);
            $beforefromdate = $beforefromdate . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";
            $openingQr = $this->db->query("SELECT  sum(`inwardQuantity`-`outwardQuantity`) as `openingbal` FROM `stockposting` WHERE`productBatchId` IN ('$idSelect') AND `companyId` = '$company_id'  AND (date BETWEEN '$initialdate' AND '$beforefromdate')");
            $data['openingbal'] = $openingQr->row()->openingbal;



            $productList = $this->db->query("SELECT productId,productName FROM product WHERE companyId='$company_id'");

            $productBatchQr = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId = '$idSelect' AND companyId = '$company_id'");
            $productBatchArray = $productBatchQr->result();
            $IdSet = "";
            if (sizeof($productBatchArray) > 0):
                foreach ($productBatchArray as $productBatchArrayId):
                    if ($IdSet == ""):
                        $IdSet = $productBatchArrayId->productBatchId;
                    else:
                        $IdSet = $IdSet . "," . $productBatchArrayId->productBatchId;
                    endif;
                endforeach;
            endif;

            if ($IdSet != ""):
                $productData = $this->db->query("SELECT date,voucherNumber,voucherType,(`inwardQuantity`) as `debit`,(`outwardQuantity`) as `credit` FROM `stockposting` WHERE `productBatchId` IN ('$IdSet') AND (date BETWEEN '$date_from' AND '$date_to') AND companyId = '$company_id' ORDER BY date,voucherType");
                $data['productData'] = $productData->result();
            else:
                $data['productData'] = array();
            endif;

            $companyQr = $this->db->query("SELECT companyName, address, email FROM company WHERE companyId = '$company_id'");
            $data['comname'] = $companyQr->row()->companyName;
            $data['comaddress'] = $companyQr->row()->address;
            $data['comemail'] = $companyQr->row()->email;
            $data['productInfo'] = $productList->result();
            $data['selectedproductid'] = $idSelect;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['companyId'] = $company_id;
            $data['username'] = $this->sessiondata['username'];
            $data['userrole'] = $this->sessiondata['userrole'];

            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('report/productreport', $data);
            $this->load->view('footer', $data);
            $this->load->view('report/productscript', $data);
        else:
            redirect('login');
        endif;
    }

    function getPurchaseInvoice() {

        $id = $_POST['id'];
        $companyId = $_POST['company_id'];
        $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId=27  AND  companyId='$companyId' ORDER BY ledgerId DESC");
        $supplierinfo1 = $query2->result();
        $querypurchasemaster = $this->db->query("SELECT  *  FROM  purchasemaster WHERE purchaseMasterId='$id'");
        $purchasemasterinfo = $querypurchasemaster->result();

        $queryratequalityvat = $this->db->query("SELECT productbatch.productId,productbatch.salesRate,product.productName,unit.unitName,ledgerposting.ledgerPostingId,purchasedetails.purchaseDetailsId,purchasedetails.purchaseMasterId,purchasedetails.productBatchId,purchasedetails.rate,purchasedetails.qty,purchasedetails.freeQty,stockposting.serialNumber,stockposting.voucherNumber,stockposting.unitId,stockposting.inwardQuantity,stockposting.outwardQuantity,stockposting.voucherType,stockposting.companyId from purchasedetails inner JOIN stockposting ON purchasedetails.purchaseMasterId = stockposting.voucherNumber AND purchasedetails.productBatchId = stockposting.productBatchId JOIN ledgerposting ON ledgerposting.voucherNumber=purchasedetails.purchaseMasterId JOIN productbatch ON productbatch.productBatchId=purchasedetails.productBatchId JOIN product ON product.productId=productbatch.productId JOIN unit ON unit.unitId=stockposting.unitId WHERE purchasedetails.purchaseMasterId='$id' AND ledgerposting.credit=0 AND ledgerposting.voucherType='Purchase Invoice' AND stockposting.voucherType='Purchase Invoice' group by purchasedetails.purchaseDetailsId");
        $ratequalityvat = $queryratequalityvat->result();
        $count_product = $queryratequalityvat->num_rows();

        $productarr = array(
            'supplierinfo1' => $supplierinfo1,
            'purchasemasterinfo' => $purchasemasterinfo,
            'ratequalityvat' => $ratequalityvat,
            'count_product' => $count_product
        );

        echo json_encode($productarr);
    }

    function getSalesInvoice() {

        $id = $_POST['id'];
        $company_id = $_POST['company_id'];
        $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId IN (28,13)  AND  companyId='$company_id' ORDER BY ledgerId DESC");
        $supplierinfo1 = $query2->result();
        $querysalesmaster = $this->db->query("SELECT  *  FROM  salesmaster WHERE salesMasterId='$id'");
        $salesmasterinfo = $querysalesmaster->result();
        $queryproducts = $this->db->query("SELECT  *  FROM  productbatch");
        $products = $queryproducts->result();
        $queryratequalityvat = $this->db->query("SELECT ledgerposting.ledgerPostingId,salesdetails.salesDetailsId,salesdetails.salesMasterId,salesdetails.productBatchId,salesdetails.rate,salesdetails.qty,salesdetails.unitId,stockposting.serialNumber,stockposting.voucherNumber,stockposting.inwardQuantity,stockposting.outwardQuantity,stockposting.voucherType,stockposting.companyId from salesdetails inner JOIN stockposting ON salesdetails.salesMasterId = stockposting.voucherNumber AND salesdetails.productBatchId = stockposting.productBatchId JOIN ledgerposting ON ledgerposting.voucherNumber=salesdetails.salesMasterId WHERE salesdetails.salesMasterId='$id' AND ledgerposting.credit=0 AND ledgerposting.voucherType='Sales Invoice'group by salesdetails.salesDetailsId DESC");
        $ratequalityvat = $queryratequalityvat->result();
        $queryp = $this->db->query("SELECT  *  FROM  product");
        $productinfo = $queryp->result();
        $queryunit = $this->db->query("SELECT  *  FROM  unit");
        $unitinfo = $queryunit->result();
        $totalprevAmount = $querysalesmaster->row()->previousdue;

        $productarr = array(
            'supplierinfo1' => $supplierinfo1,
            'salesmasterinfo' => $salesmasterinfo,
            'products' => $products,
            'ratequalityvat' => $ratequalityvat,
            'productinfo' => $productinfo,
            'unitinfo' => $unitinfo,
            'totalprevAmount' => $totalprevAmount
        );

        echo json_encode($productarr);
    }

}

?>
