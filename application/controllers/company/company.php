<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Comapny Information";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "company";
        $comid = $this->sessiondata['companyid'];

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $companyQuery = $this->db->query("select * from company where companyId = '$comid'");
            $data['cdata'] = $companyQuery->row();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('company/company', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function updatecompanyinfo() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $id = $_POST['companyid'];
            $position1 = $this->input->post('position1');
            $position2 = $this->input->post('position2');
            $position3 = $this->input->post('position3');
            $position4 = $this->input->post('position4');
            $invoice_prefix = $this->input->post('invoice_prefix');
            if ($position1 != ""):
                $position1 = '(' . $position1 . ')';
            endif;
            if ($position2 != ""):
                $position2 = '(' . $position2 . ')';
            endif;
            if ($position3 != ""):
                $position3 = '(' . $position3 . ')';
            endif;
            if ($position4 != ""):
                $position4 = '(' . $position4 . ')';
            endif;

            $config['upload_path'] = './assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '1024';
            $config['max_width'] = '220';
            $config['max_height'] = '220';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // $this->upload->set_allowed_types('*');
            $data['upload_data'] = '';

            if (!$this->upload->do_upload('userfile')) {
                $error = $this->upload->display_errors();
                $this->session->set_userdata("error_msg", "Upload Failed. " . $error);

                $comdata = array(
                    'companyName' => $_POST['companyname'],
                    'email' => $_POST['email'],
                    'city' => $_POST['city'],
                    'address' => $_POST['address'],
                    'fax' => $_POST['fax'],
                    'mobile1' => $_POST['mobile1'],
                    'mobile2' => $_POST['mobile2'],
                    'mobile3' => $_POST['mobile3'],
                    'mobile4' => $_POST['mobile4'],
                    'position1' => $position1,
                    'position2' => $position2,
                    'position3' => $position3,
                    'position4' => $position4,
                    'invoice_prefix' => $invoice_prefix

                );
                $this->db->where('companyId', $id);
                $result = $this->db->update('company', $comdata);
                if ($result):
                    $this->session->set_userdata("success", "Comapny Information Updated Successfully");
                    redirect('company/company');
                else:
                    $this->session->set_userdata("fail", "Comapny Information Update Failed");
                    redirect('company/company');
                endif;
            } else {
                $data['upload_data'] = $this->upload->data();
                $upload_data = $data['upload_data'];
                $this->session->set_userdata("error_msg", "Uploaded Successfully.");

                $comdata = array(
                    'companyName' => $_POST['companyname'],
                    'email' => $_POST['email'],
                    'city' => $_POST['city'],
                    'address' => $_POST['address'],
                    'fax' => $_POST['fax'],
                    'mobile1' => $_POST['mobile1'],
                    'mobile2' => $_POST['mobile2'],
                    'mobile3' => $_POST['mobile3'],
                    'mobile4' => $_POST['mobile4'],
                    'position1' => $position1,
                    'position2' => $position2,
                    'position3' => $position3,
                    'position4' => $position4,
                    'invoice_prefix' => $invoice_prefix,
                    'logo' => $upload_data['file_name']
                );
                $this->db->where('companyId', $id);
                $result = $this->db->update('company', $comdata);
                if ($result):
                    $this->session->set_userdata("success", "Comapny Information Updated Successfully");
                    redirect('company/company');
                else:
                    $this->session->set_userdata("fail", "Comapny Information Update Failed");
                    redirect('company/company');
                endif;
            }

        else:
            redirect('home');
        endif;
    }

}
