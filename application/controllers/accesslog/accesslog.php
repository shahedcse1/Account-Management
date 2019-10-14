<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accesslog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
        $this->load->helper('common_helper');
    }

    function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login'):
            $data['baseurl'] = $this->config->item('base_url');
            $data['title'] = "Access log";
            $data['active_menu'] = "setting";
            $data['active_sub_menu'] = "accesslog";
            $companyid = $this->sessiondata['companyid'];
            $accesslogQuery = $this->db->query("select * from accesslog where companyid = '$companyid' order by id desc");
            $data['logdata'] = $accesslogQuery->result();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('accesslog/accesslog', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    function getAccessLogTable() {

        $table = 'accesslog';
        $primaryKey = 'id';

        $columns = array(
          
            array('db' => 'time', 'dt' => 0, 'field' => 'time'),
            array('db' => 'username', 'dt' => 1, 'field' => 'username'),
            array('db' => 'action', 'dt' => 2, 'field' => 'action'),
            array('db' => 'device', 'dt' => 3, 'field' => 'device'),
            array('db' => 'browser', 'dt' => 4, 'field' => 'browser'),
            array('db' => 'ip', 'dt' => 5, 'field' => 'ip'), 
            array('db' => 'location', 'dt' => 6, 'field' => 'location'),
            array('db' => 'details', 'dt' => 7, 'field' => 'details')
        );


        $this->load->database();
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $this->load->library('ssp');
        
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

}
