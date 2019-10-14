<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Stock Product";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "stock";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $data['userrole'] = $company_data['userrole'];
            $company_id = $company_data['companyid'];
            //  $date_from = "2000-01-01 00:00:00";
            //  $date_to = $this->sessiondata['maxdate'];
            //$date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            if (($date_to == "")) {
                //$today_date = date('Y-m-d');
                // $date_from = $this->sessiondata['mindate'];
                // $date_to = $today_date;
                //$date_from = "2000-01-01 00:00:00";
                $date_to = $this->sessiondata['maxdate'];
            }
            //$date_from = substr($date_from, 0, 10);
            $date_from = $company_data['mindate'];
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";

            $stockQr = $this->db->query("SELECT pb.purchaseRate,pb.salesRate,p.productName, SUM(sp.inwardQuantity - sp.outwardQuantity) as currentstock, pg.productGroupName, m.manufactureName, p.stockMinimumLevel, p.stockMaximumLevel, un.unitName FROM stockposting sp JOIN productbatch pb ON sp.productBatchId = pb.productBatchId JOIN product p ON p.productId = pb.productId JOIN productgroup pg ON pg.productGroupId = p.productGroupId JOIN manufacturer m ON m.manufactureId = p.manufactureId JOIN unit un ON un.unitId = p.unitId WHERE (sp.date BETWEEN '$initialdate' AND '$date_to') AND (sp.companyId = '$company_id' AND p.companyId = '$company_id' AND pg.companyId = '$company_id' AND m.companyId = '$company_id' AND un.companyId = '$company_id') GROUP BY sp.productBatchId");
            $data['stockdata'] = $stockQr->result();
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
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('stockentry/stock', $data);
            $this->load->view('footer', $data);
            $this->load->view('stockentry/sr_script', $data);
        else:
            redirect('login');
        endif;
    }

}

?>