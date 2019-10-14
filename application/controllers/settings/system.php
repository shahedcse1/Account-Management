<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Settings
 *
 * @author Tushar
 */
class System extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "System Information";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "system";


        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $settingsQuery = $this->db->query("select * from settings");
            $data['settings'] = $settingsQuery->result();


            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('settings/system', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function update_system() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $system1 = $this->input->post('1');
            $system2 = $this->input->post('2');
            $system3 = $this->input->post('3');
            $system4 = $this->input->post('4');
            $system5 = $this->input->post('5');
            $system6 = $this->input->post('6');
            $system7 = $this->input->post('7');
            $system8 = $this->input->post('8');
            $system9 = $this->input->post('9');
            $system11 = $this->input->post('11');
            $system12 = $this->input->post('12');

            $updatedata = array(
                'value' => $system1
            );
            $this->db->where('settings_id', 1);
            $updatenotice = $this->db->update('settings', $updatedata);

            $updatedata = array(
                'value' => $system2
            );
            $this->db->where('settings_id', 2);
            $updatenotice = $this->db->update('settings', $updatedata);

            $updatedata = array(
                'value' => $system3
            );
            $this->db->where('settings_id', 3);
            $updatenotice = $this->db->update('settings', $updatedata);

            $updatedata = array(
                'value' => $system4
            );
            $this->db->where('settings_id', 4);
            $updatenotice = $this->db->update('settings', $updatedata);

            $updatedata = array(
                'value' => $system5
            );
            $this->db->where('settings_id', 5);
            $updatenotice = $this->db->update('settings', $updatedata);

            $updatedata = array(
                'value' => $system6
            );
            $this->db->where('settings_id', 6);
            $updatenotice = $this->db->update('settings', $updatedata);

             $updatedata = array(
                'value' => $system7
            );
            $this->db->where('settings_id', 7);
            $updatenotice = $this->db->update('settings', $updatedata);
            
             $updatedata = array(
                'value' => $system8
            );
              $this->db->where('settings_id', 8);
            $updatenotice = $this->db->update('settings', $updatedata);
            
             $updatedata = array(
                'value' => $system9
            );
             
            $this->db->where('settings_id', 9);
            $updatenotice = $this->db->update('settings', $updatedata);

            /**
             * Update Product Serial
             */
            $updatedata = [
                'value' => $system11
            ];

            $this->db
                ->where('settings_id', 11)
                ->update('settings', $updatedata);

            /**
             * Update Barcode Scan on Sales
             */
            $updatedata = [
                'value' => $system12
            ];

            $this->db
                ->where('settings_id', 12)
                ->update('settings', $updatedata);
            
            redirect('settings/system');

        else:
            redirect('home');
        endif;
    }

}
