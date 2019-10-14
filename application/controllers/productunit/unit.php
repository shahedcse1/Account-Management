<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unit extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('productunit_model');
        $this->sessiondata = $this->session->userdata('logindata');
        if ($this->sessiondata['status'] == 'login'):
            $accessFlag = 1;
        else:
            $accessFlag = 0;
            redirect('home');
        endif;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Product unit";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "unit";
        $data['unitdata'] = $this->productunit_model->readAll();
        $this->load->view('header', $data);
        $this->load->view('sidebar', $data);
        $this->load->view('unit/unit', $data);
        $this->load->view('footer', $data);
    }

    public function addunit() {
        $modalname = $this->input->post('modalname');
        $saveresult = $this->productunit_model->saveproductunit();       
        if ($modalname == "fromproduct"):
            redirect('productlist/product/addproductview');
        else:
            if ($saveresult):
                echo 'added';
            else:
                echo 'failed';
            endif;
        endif;
    }

    public function deleteunit() {
        $deleteResult = $this->productunit_model->deletebyId();
        echo $deleteResult;
    }

    public function undateunit() {
        $updateResult = $this->productunit_model->updateUnit();
        if ($updateResult):
            $this->session->set_userdata('success', 'Unit update successfully');
            redirect('productunit/unit');
        else:
            $this->session->set_userdata('fail', 'Unit update failed');
            redirect('productunit/unit');
        endif;
    }

    public function checkunitname() {
        $unitname = $_POST['unitname'];
        $checkquery = $this->db->query("select unitName from unit where unitName = '$unitname'");
        if ($checkquery->num_rows() > 0):
            echo 'booked';
        else:
            echo 'free';
        endif;
    }

}

?>