<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AboutUs extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "About Us";
        
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
           
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('aboutus/aboutus',$data);
            $this->load->view('footer',$data);
        else:
            redirect('home');
        endif;
    }
}