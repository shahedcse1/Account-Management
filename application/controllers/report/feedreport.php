<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedreport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Product Group Report";
            $data['baseurl'] = $this->config->item('base_url');
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "feed_report";
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];

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

            $getProductGroup = $this->db->query("SELECT * from productgroup");
            $data['getProductGroupData'] = $getProductGroup->result();


            $getCustomer = $this->db->query("SELECT ledgerId, acccountLedgerName from accountledger where accountGroupId =28");
            $data['getCustomer'] = $getCustomer->result();
            $getSupplier = $this->db->query("SELECT ledgerId, acccountLedgerName from accountledger where accountGroupId =27");
            $data['getSupplier'] = $getSupplier->result();

            $idSelect = $this->input->post('manufacturename');
            $idSelectCustomer = $this->input->post('customername');
            $idSelectSupplier = $this->input->post('suppliername');
            $idSelectProductGroup = $this->input->post('productgroupname');

            $productGroupId = $this->input->post('productgroupname');
            $manufactureId = $this->input->post('manufacturename');
            $manufactureType = $this->input->post('feed_report_radio');

            $getManufactureId = $this->db->query("SELECT DISTINCT  manufacturer.manufactureId, manufacturer.manufactureName from manufacturer JOIN product ON manufacturer.manufactureId=product.manufactureId where product.productGroupId='$productGroupId' AND product.companyId = '$company_id' AND manufacturer.companyId = '$company_id' ");
            $data['getManufactureData'] = $getManufactureId->result();

            if ($manufactureType == "customer"):
                $customerId = $this->input->post('customername');
                $getProduct = $this->db->query("SELECT p.productId,p.productName,p.unitId,sum(sd.qty) as qty FROM salesmaster AS sm JOIN salesdetails AS sd ON sm.salesMasterId=sd.salesMasterId JOIN productbatch AS pb ON sd.productBatchId=pb.productBatchId  Join product AS p ON pb.productId=p.productId AND p.manufactureId='$manufactureId' WHERE  sm.ledgerId = '$customerId' and (sm.date BETWEEN '$date_from' AND '$date_to') group by  p.productId");
                $data['getProductData'] = $getProduct->result();
            else :
                $supplierId = $this->input->post('suppliername');
                $getProduct = $this->db->query("SELECT p.productId,p.productName,p.unitId,sum(pd.qty) as qty FROM purchasemaster AS pm JOIN purchasedetails AS pd ON pm.purchaseMasterId=pd.purchaseMasterId JOIN productbatch AS pb ON pd.productBatchId=pb.productBatchId Join product AS p ON pb.productId=p.productId AND p.manufactureId='$manufactureId' WHERE  pm.ledgerId = '$supplierId' and (pm.date BETWEEN '$date_from' AND '$date_to') group by  p.productId");
                $data['getProductData'] = $getProduct->result();
            endif;

            $data['selectedId'] = $idSelect;
            $data['idSelectCustomer'] = $idSelectCustomer;
            $data['idSelectSupplier'] = $idSelectSupplier;
            $data['idSelectProductGroup'] = $idSelectProductGroup;
            $data['selectedIdCheck'] = $manufactureType;
            $data['productGroupIdCol'] = $productGroupId;

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
            $this->load->view('report/feedreport', $data);
            $this->load->view('footer', $data);
            $this->load->view('report/fr_script', $data);
        else:
            redirect('login');
        endif;
    }

    function getManufacturerName() {
        $company_data = $this->session->userdata('logindata');
        $company_id = $company_data['companyid'];
        $productGroupId = $this->input->post('productGroupId');
        $getManufactureId = $this->db->query("SELECT DISTINCT  manufacturer.manufactureId, manufacturer.manufactureName from manufacturer JOIN product ON manufacturer.manufactureId=product.manufactureId where product.productGroupId='$productGroupId' AND product.companyId = '$company_id' AND manufacturer.companyId = '$company_id' ");

        if ($getManufactureId->num_rows() > 0) {
            echo '<option value="">-- Select Manufacturer Name --</option>';
            foreach ($getManufactureId->result() as $data_row) {
                echo '<option value="' . $data_row->manufactureId . '">' . $data_row->manufactureName . '</option>';
            }
        } else {
            echo '<option value="0">-- Select Manufacturer Name --</option>';
        }
    }

}

?>