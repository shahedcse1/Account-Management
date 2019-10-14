<?php

class productGroup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->model('productunit_model');
        $this->load->model('ccfproductGroup');
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
        $data['title'] = "Product Group";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "productGroup";
        if ($this->sessiondata['status'] == 'login'):
            $this->load->model('ccfproductgroup');
            $data['unitdata'] = $this->ccfproductgroup->readAll();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('productlist/productgroup', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function addproductGroup() {
        $Modalname = $this->input->post('modalname');
        $saveresult = $this->ccfproductGroup->addproductGroup();
        if ($Modalname == "fromproduct"):
            redirect('productlist/product/addproductview');
        else:
            if ($saveresult):
                $this->session->set_userdata('success', 'Product Group information saved successfully');
                redirect('productlist/productGroup');
            else:
                $this->session->set_userdata('fail', 'Product Group information save failed');
                redirect('productlist/productGroup');
            endif;
        endif;
    }

    public function deleteproductGroup() {
        $deleteResult = $this->ccfproductGroup->deleteproductGroup();
        $this->session->set_userdata('deleted', $deleteResult);
        redirect('productlist/productGroup');
    }

    public function editproductGroup() {
        $updateResult = $this->ccfproductGroup->editproductGroup();
        if ($updateResult):
            $this->session->set_userdata('success', 'Product Group update successfully');
            redirect('productlist/productGroup');
        else:
            $this->session->set_userdata('fail', 'Product Group update failed');
            redirect('productlist/productGroup');
        endif;
    }

}
