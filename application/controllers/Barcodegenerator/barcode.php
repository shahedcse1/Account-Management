<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barcodegenerator extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->model('customerdb');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function index() {
        $data['title'] = "barcode";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "Barcodegenerator";
        $data['baseurl'] = $this->config->item('base_url');
         
            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
         
            $this->load->view('sidebar', $data);
            $this->load->view('Barcodegenerator/barcode', $data);
            $this->load->view('footer');
            redirect('login');
      
    }

    

}
