<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cashstatus extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Cash Status";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "cashstatus";
            $data['baseurl'] = $this->config->item('base_url');
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('report/cashstatus', $data);
            $this->load->view('footer', $data);
        else:
            redirect('login');
        endif;
    }

    public function addcashstatus() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Cash Status";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "cashstatus";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $companyid = $company_data['companyid'];
            $cashinhandQr = $this->db->query("SELECT (SUM(debit) - SUM(credit)) AS cashinhand FROM ledgerposting WHERE ledgerId = '2' AND companyId = '$companyid'");
            $data['cashinhand'] = $cashinhandQr->row()->cashinhand;
             $keyboardQr = $this->db->query("SELECT value FROM settings WHERE settings_id=5");
            $data['keyboard'] = $keyboardQr->row()->value;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('report/addcashstatus', $data);
            $this->load->view('footer', $data);
        else:
            redirect('login');
        endif;
    }

    public function savecashstatusdata() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $company_data = $this->session->userdata('logindata');
            $companyid = $company_data['companyid'];
            $cashdata = array(
                'datetime' => $this->input->post('cashstatusdate'),
                'onethousand' => $this->input->post('onethoustakahide'),
                'fivehundred' => $this->input->post('fivehuntakahide'),
                'onehundred' => $this->input->post('onehuntakahide'),
                'fifty' => $this->input->post('fiftytakahide'),
                'tweenty' => $this->input->post('tweentytakahide'),
                'ten' => $this->input->post('tentakahide'),
                'five' => $this->input->post('fivetakahide'),
                'two' => $this->input->post('twotakahide'),
                'one' => $this->input->post('onetakahide'),
                'totaltaka' => $this->input->post('totaltakahide'),
                'cashinhand' => $this->input->post('cashinhandhide'),
                'difference' => $this->input->post('differencehide'),
                'notes' => $this->input->post('cashstatusnotes'),
                'companyId' => $companyid
            );
            $insertsts = $this->db->insert('cashstatus', $cashdata);
            if ($insertsts):
                $this->session->set_userdata('success', 'Cash Added successfully');
                redirect('report/cashstatus');
            else:
                $this->session->set_userdata('fail', 'Cash Add failed');
                redirect('report/cashstatus');
            endif;
        else:
            redirect('login');
        endif;
    }

    public function getCashStatus() {
        $table = 'cashstatus';    //Table name 
        $primaryKey = 'id';   //Primary key of a table
        // indexes
        $columns = array(
            array('db' => 'datetime', 'dt' => 0),
            array('db' => 'totaltaka', 'dt' => 1),
            array('db' => 'cashinhand', 'dt' => 2),
            array('db' => 'difference', 'dt' => 3),
            array('db' => 'id', 'dt' => 4,
                'formatter' => function ($rowvalue, $row) {
                    return '<a  href="#"  onclick="showDetailsModal(' . $rowvalue . ')">
      <button class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-details">Details</i></button></a>';
                })
        );


        // SQL server connection information
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

    public function getCashDetails() {
        $id = $this->input->post('id');
        $cashQr = $this->db->query("SELECT * FROM cashstatus WHERE id = '$id'");
        echo json_encode($cashQr->row());
    }

}
