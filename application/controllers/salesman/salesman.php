<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salesman extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->load->model('salesdb');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function index() {
        $data['title'] = "Add new sales man";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "salesman";
        $data['baseurl'] = $this->config->item('base_url');
        $companyid = $this->sessiondata['companyid'];
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $getsalesmaninfo = $this->db->query("select salesman.salesManName,salesman.ledgerId,salesman.salesManId,salesman.address,salesman.mobile,salesman.activeOrNot,user.username,user.password from salesman inner join user on salesman.ledgerId = user.userId where salesman.companyId = '$companyid'");
            $data['salesmandata'] = $getsalesmaninfo->result();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('salesman/salesman', $data);
            $this->load->view('footer', $data);
        else:
            redirect('login');
        endif;
    }

    function addsalesman() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):

            $logindata = array(
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'activeOrNot' => $_POST['status'],
                'description' => $_POST['address'],
                'companyId' => $this->sessiondata['companyid'],
                'role' => "s"
            );
            $salesManLoginInfo = $this->db->insert('user', $logindata);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            $salesdata = array(
                'ledgerId' => $insert_id,
                'salesManName' => $_POST['salesmanname'],
                'address' => $_POST['address'],
                'mobile' => $_POST['mobile'],
                'activeOrNot' => $_POST['status'],
                'companyId' => $this->sessiondata['companyid']
            );
            $savesalesman = $this->db->insert('salesman', $salesdata);
            if ($savesalesman && $salesManLoginInfo):
                ccflogdata($this->sessiondata['username'], "accesslog", "salesman", "Salesman: " . $_POST['salesmanname'] . " Added");
                $this->session->set_userdata('success', 'Sales man Information saved successfully');
                redirect('salesman/salesman');
            else:
                ccflogdata($this->sessiondata['username'], "accesslog", "salesman", "Salesman: " . $_POST['salesmanname'] . " Added failed");
                $this->session->set_userdata('fail', 'Sales man Information added failed');
                redirect('salesman/salesman');
            endif;
        else:
            redirect('login');
        endif;
    }

    function deletesalesman() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $deleteid = $_POST['salesmanid'];
            $loginid = $_POST['loginid'];
            $deletequery = $this->db->query("delete from salesman where salesManId = '$deleteid'");
            $deleteUser = $this->db->query("delete from user where ledgerId = '$loginid'");
            if ($deletequery && $deleteUser):
                ccflogdata($this->sessiondata['username'], "accesslog", "salesman", "Salesman: " . $_POST['salesmanid'] . " deleted");
                $this->session->set_userdata('success_delete', 'Sales man Information Deleted successfully');
                redirect('salesman/salesman');
            else:
                ccflogdata($this->sessiondata['username'], "accesslog", "salesman", "Salesman: " . $_POST['salesmanid'] . " deleted failed");
                $this->session->set_userdata('fail_delete', 'Sales man Information Delete failed');
                redirect('salesman/salesman');
            endif;
        else:
            redirect('login');
        endif;
    }

    function getsalesmaninfo() {
        $salesmanid = $_POST['salesmanid'];
        $queryforsalesmanid = $this->db->query("select * from salesman where salesManId = '$salesmanid'");
        $salesmanresult = $queryforsalesmanid->result();
        echo json_encode($salesmanresult);
    }

    function getuserinfo() {
        $userid = $_POST['lagerId'];
       
        $queryforuserid = $this->db->query("select * from user where userId = '$userid'");
        $userresult = $queryforuserid->result();
        echo json_encode($userresult);
    }

    function updatesalesmaninfo() {
        
        $edituserid=$_POST['edituserid'];
        $salesmanid = $_POST['editsalesmanid'];
        $updateinfo = array(
            'salesManName' => $_POST['editsalesmanname'],
            'address' => $_POST['editaddress'],
            'mobile' => $_POST['editmobile'],
            'activeOrNot' => $_POST['editstatus']
        );
        $this->db->where('salesManId', $salesmanid);
        $updateresult = $this->db->update('salesman', $updateinfo);
        
        
         $updateinfo2 = array(
            'username' => $_POST['editusername'],
            'password' => $_POST['editpassword']
          
        );
        $this->db->where('userId', $edituserid);
        $updateresult = $this->db->update('user', $updateinfo2);
        
        
        
        
        
        if ($updateresult):
            ccflogdata($this->sessiondata['username'], "accesslog", "salesman", "Salesman: " . $_POST['editsalesmanname'] . "  updated ");
            $this->session->set_userdata('success_update', 'Sales man Information update successfully');
            redirect('salesman/salesman');
        else:
            ccflogdata($this->sessiondata['username'], "accesslog", "salesman", "Salesman: " . $_POST['editsalesmanname'] . " updated failed");
            $this->session->set_userdata('fail_update', 'Sales man Information update failed');
            redirect('salesman/salesman');
        endif;
    }

}
