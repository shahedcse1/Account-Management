<?php

if (!defined('BASEPATH'))
    exit('No Direct Script access allowed');

class Manufacture extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('ccfmanufacture');
        $this->sessiondata = $this->session->userdata('logindata');
        if ($this->sessiondata['status'] = 'login'):
            $accessFlag = 1;
        else:
            $accessFlag = 0;
            redirect('home');
        endif;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Manufacturer";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "manufacture";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['sortalldata'] = $this->ccfmanufacture->sortalldata();
            $data['alldata'] = $this->ccfmanufacture->showalldata();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('manufacture/manufacture', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function addManufacture() {
        $Modalname = $this->input->post('modalname');
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isadded = $this->ccfmanufacture->addManufacture();
            if ($Modalname == "fromproduct"):
                redirect('productlist/product/addproductview');
            else:
                if ($isadded):
                    die('Added');
                else:
                    die('Notadded');
                endif;
            endif;
        else:
            redirect('home');
        endif;
    }

    public function editManufacture() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isupdated = $this->ccfmanufacture->editManufacture();
            if ($isupdated) {
                die('Updated');
            } else {
                die('Notupdated');
            }
        else:
            redirect('home');
        endif;
    }

    public function deleteManufacturer() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $deleted = $this->ccfmanufacture->deleteManufacturer();
            echo $deleted;
        else:
            redirect('home');
        endif;
    }

    public function accountNameCheck() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isExist = $this->ccfmanufacture->accountNameCheck();
            if ($isExist) {
                die('free');
            } else {
                die('booked');
            }
        else:
            redirect('home');
        endif;
    }

}
