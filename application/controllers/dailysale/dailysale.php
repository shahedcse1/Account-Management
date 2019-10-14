<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dailysale extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Daily Sale";
        $data['active_menu'] = "report";
        $data['active_sub_menu'] = "dailysale";
        $startdate = $this->input->post('date_from');
        $enddate = $this->input->post('date_to');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $companyid = $this->sessiondata['companyid'];
            if ($startdate == NULL && $enddate == NULL):
//                $sdate = $this->sessiondata['mindate'];
//                $sdate = $sdate . " 00:00:00";
//                $edate = date('Y-m-d');
//                $edate = $edate . " 23:59:59";
                $sdate = date('Y-m-d') . " 00:00:00";
                $edate = date('Y-m-d') . " 23:59:59";
            else:
                $startdate = substr($startdate, 0, 10);
                $enddate = substr($enddate, 0, 10);
                $sdate = $startdate . " 00:00:00";
                $edate = $enddate . " 23:59:59";
            endif;


            $data['fdate'] = $sdate;
            $data['edate'] = $edate;


            $productGroup = $this->db->query("SELECT * FROM productgroup WHERE companyId = '$companyid'");
            $salesManGroup = $this->db->query("SELECT salesManId,salesManName FROM salesman WHERE companyId = '$companyid'");
            $IdSet = $this->input->post('productname');
            $IdSetSalesMan = $this->input->post('salesmanname');

            if ($IdSet == "" && $IdSetSalesMan == ""):
                $productname = $this->db->query("select accountledger.acccountLedgerName,salesmaster.salesMasterId,salesdetails.salesMasterId as detailsMasterId,product.productName,product.unitId,product.productGroupId,salesmaster.billDiscount,salesmaster.tranportation,salesmaster.date,salesmaster.salesInvoiceNo,salesmaster.ledgerId,salesdetails.rate*salesdetails.qty as amount,salesdetails.rate,salesdetails.qty from salesmaster inner join salesdetails on salesmaster.salesMasterId = salesdetails.salesMasterId join productbatch ON productbatch.productBatchId = salesdetails.productBatchId JOIN product on product.productId = productbatch.productId join accountledger ON accountledger.ledgerId = salesmaster.ledgerId where salesmaster.date between '$sdate%' AND '$edate%' AND accountledger.companyId ='$companyid' AND salesmaster.companyId ='$companyid' AND salesdetails.companyId ='$companyid' ORDER BY salesmaster.date ASC");
                $data['saleinfo'] = $productname->result();
                $IdSet = "all";
                $IdSetSalesMan = "all";
            endif;

            if ($IdSet == "all" && $IdSetSalesMan == "all"):               
                $productname = $this->db->query("select productbatch.purchaseRate, accountledger.acccountLedgerName,salesmaster.salesMasterId,salesdetails.salesMasterId as detailsMasterId,product.productName,product.unitId,product.productGroupId,salesmaster.billDiscount,salesmaster.tranportation,salesmaster.date,salesmaster.salesInvoiceNo,salesmaster.ledgerId,salesdetails.rate*salesdetails.qty as amount,salesdetails.rate,salesdetails.qty from salesmaster inner join salesdetails on salesmaster.salesMasterId = salesdetails.salesMasterId join productbatch on productbatch.productBatchId = salesdetails.productBatchId JOIN accountledger ON accountledger.ledgerId = salesmaster.ledgerId JOIN product ON productbatch.productId = product.productId where salesmaster.date between '$sdate' AND '$edate' AND accountledger.companyId ='$companyid' AND salesmaster.companyId ='$companyid' AND salesdetails.companyId ='$companyid' AND productbatch.companyId ='$companyid' ORDER BY salesmaster.date ASC");
                $data['saleinfo'] = $productname->result();
            elseif ($IdSet == "all" && $IdSetSalesMan != "all") :
                $productname = $this->db->query("select productbatch.purchaseRate, accountledger.acccountLedgerName,salesmaster.salesMasterId,salesdetails.salesMasterId as detailsMasterId,product.productName,product.unitId,product.productGroupId,salesmaster.billDiscount,salesmaster.tranportation,salesmaster.date,salesmaster.salesInvoiceNo,salesmaster.ledgerId,salesdetails.rate*salesdetails.qty as amount,salesdetails.rate,salesdetails.qty from salesmaster inner join salesdetails on salesmaster.salesMasterId = salesdetails.salesMasterId join productbatch on productbatch.productBatchId = salesdetails.productBatchId JOIN accountledger ON accountledger.ledgerId = salesmaster.ledgerId JOIN product ON productbatch.productId = product.productId where salesmaster.date between '$sdate' AND '$edate' AND accountledger.companyId ='$companyid' AND salesmaster.companyId ='$companyid' AND salesdetails.companyId ='$companyid' AND salesmaster.salesManId ='$IdSetSalesMan' AND productbatch.companyId ='$companyid' ORDER BY salesmaster.date ASC");
                $data['saleinfo'] = $productname->result();
            elseif ($IdSet != "all" && $IdSetSalesMan == "all") :
                $productname = $this->db->query("select productbatch.purchaseRate, accountledger.acccountLedgerName,salesmaster.salesMasterId,salesdetails.salesMasterId as detailsMasterId,product.productName,product.unitId,product.productGroupId,salesmaster.billDiscount,salesmaster.tranportation,salesmaster.date,salesmaster.salesInvoiceNo,salesmaster.ledgerId,salesdetails.rate*salesdetails.qty as amount,salesdetails.rate,salesdetails.qty from salesmaster inner join salesdetails on salesmaster.salesMasterId = salesdetails.salesMasterId join productbatch on productbatch.productBatchId = salesdetails.productBatchId JOIN accountledger ON accountledger.ledgerId = salesmaster.ledgerId JOIN product ON productbatch.productId = product.productId where salesmaster.date between '$sdate' AND '$edate' AND accountledger.companyId ='$companyid' AND salesmaster.companyId ='$companyid' AND salesdetails.companyId ='$companyid' AND product.productGroupId = '$IdSet' AND productbatch.companyId ='$companyid' ORDER BY salesmaster.date ASC");
                $data['saleinfo'] = $productname->result();
            else:
                $productname = $this->db->query("select productbatch.purchaseRate, accountledger.acccountLedgerName,salesmaster.salesMasterId,salesdetails.salesMasterId as detailsMasterId,product.productName,product.unitId,product.productGroupId,salesmaster.billDiscount,salesmaster.tranportation,salesmaster.date,salesmaster.salesInvoiceNo,salesmaster.ledgerId,salesdetails.rate*salesdetails.qty as amount,salesdetails.rate,salesdetails.qty from salesmaster inner join salesdetails on salesmaster.salesMasterId = salesdetails.salesMasterId join productbatch on productbatch.productBatchId = salesdetails.productBatchId JOIN accountledger ON accountledger.ledgerId = salesmaster.ledgerId JOIN product ON productbatch.productId = product.productId where salesmaster.date between '$sdate' AND '$edate' AND accountledger.companyId ='$companyid' AND salesmaster.companyId ='$companyid' AND salesdetails.companyId ='$companyid' AND product.productGroupId='$IdSet'  AND salesmaster.salesManId ='$IdSetSalesMan' AND productbatch.companyId ='$companyid' ORDER BY salesmaster.date ASC");
                $data['saleinfo'] = $productname->result();
            endif;


            $data['productGroupArray'] = $productGroup->result();
            $data['salesManGroupArray'] = $salesManGroup->result();
            $data['selectedledgerid'] = $IdSet;

            $data['selectedSalesManId'] = $IdSetSalesMan;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('dailysale/dailysale', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

}
