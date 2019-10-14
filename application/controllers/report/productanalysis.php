<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProductAnalysis extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Product Analysis Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "product_analysis_report";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];

            $idSelect = $this->input->post('productname');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $today_date . " 00:00:00";
                $date_to = $today_date . " 23:59:59";
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";


            $queryProductAnalysisData = $this->db->query("SELECT p.productName, SUM(sp.inwardQuantity) as inwardQuantity, SUM(sp.outwardQuantity) as outwardQuantity, (SUM(sp.inwardQuantity) - SUM(sp.outwardQuantity)) as productbalance FROM stockposting sp JOIN productbatch pb ON sp.productBatchId = pb.productBatchId JOIN product p ON p.productId = pb.productId WHERE (sp.date BETWEEN '$date_from' AND '$date_to') AND sp.companyId = '$company_id' AND pb.companyId = '$company_id' AND p.companyId = '$company_id' GROUP BY sp.productBatchId");
            $data['productAnalysisData'] = $queryProductAnalysisData->result();
          
                  
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('report/productanalysis', $data);
            $this->load->view('footer', $data);
            $this->load->view('report/productanalysisscript', $data);
        else:
            redirect('login');
        endif;
    }

}

?>
