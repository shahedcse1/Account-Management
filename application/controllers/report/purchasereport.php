<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchasereport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Purchase Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "purchase_report";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $productnameQr = $this->db->query("SELECT productName, productId FROM product WHERE companyId = '$company_id'");
            $data['productdata'] = $productnameQr->result();
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $productid = $this->input->post('productname');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";

            if ($productid != ""):
                $productBaQr = $this->db->query("SELECT productBatchId FROM productbatch WHERE productId = '$productid' AND companyId = '$company_id'");
                $productbatchid = $productBaQr->row()->productBatchId;
            else:
                $productbatchid = "";
            endif;

            $strtotime_form = strtotime($date_from);
            $previous_dateadd = strtotime("-1 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);
            $beforefromdate = $beforefromdate . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";

            if ($productid == 1):
                $openingQr = $this->db->query("SELECT SUM(pcs) as totalnumber FROM salesreadystockmaster WHERE companyId = '$company_id' AND (date BETWEEN '$initialdate' AND '$beforefromdate')");
                $data['openingstock'] = $openingQr->row()->totalnumber;
                $readyhenQr = $this->db->query("SELECT date, salesReadyStockMasterId, farmerRate, kg, pcs, amount FROM salesreadystockmaster WHERE companyId = '$company_id' AND (date BETWEEN '$date_from' AND '$date_to') ORDER BY date ASC");
                $data['readyhendata'] = $readyhenQr->result();
            else:
                $openingQr = $this->db->query("SELECT SUM(pd.qty) as totalnumber FROM purchasedetails pd JOIN purchasemaster pm ON pd.purchaseMasterId = pm.purchaseMasterId  WHERE pd.productBatchId = '$productbatchid' AND pd.companyId = '$company_id' AND pm.companyId = '$company_id' AND (date BETWEEN '$initialdate' AND '$beforefromdate')");
                $data['openingstock'] = $openingQr->row()->totalnumber;
                $purchasedataQr = $this->db->query("SELECT pm.date as date, pd.purchaseMasterId as invoiceno, pd.rate as rate, pd.qty as qty FROM purchasedetails pd JOIN purchasemaster pm ON pd.purchaseMasterId = pm.purchaseMasterId WHERE pd.productBatchId = '$productbatchid' AND pd.companyId = '$company_id' AND pm.companyId = '$company_id' AND (pm.date BETWEEN '$date_from' AND '$date_to') ORDER BY pm.date ASC");
                $data['purchasedata'] = $purchasedataQr->result();
            endif;
            $companyQr = $this->db->query("SELECT companyName, address, email FROM company WHERE companyId = '$company_id'");
            if ($companyQr->num_rows() > 0):
                $data['comname'] = $companyQr->row()->companyName;
                $data['comaddress'] = $companyQr->row()->address;
                $data['comemail'] = $companyQr->row()->email;
            else:
                $data['comname'] = "";
                $data['comaddress'] = "";
                $data['comemail'] = "";
            endif;
            $data['selectproductid'] = $productid;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('report/purchasereport', $data);
            $this->load->view('footer', $data);
            $this->load->view('report/pr_script', $data);
        else:
            redirect('login');
        endif;
    }

}

?>