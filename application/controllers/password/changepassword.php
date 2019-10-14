<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Changepassword extends CI_Controller {

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
        $data['title'] = "Change Password";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "changepassword";
        $data['baseurl'] = $this->config->item('base_url');
         if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r' || $this->sessiondata['userrole'] == 'u'|| $this->sessiondata['userrole'] == 'f')):
            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('password/changepassword', $data);
            $this->load->view('footer', $data);
        else:
            redirect('login');
        endif;
    }

    function checkcurrentpassword() {

        $currentpass = $_POST['currentpass'];
        $random_salt = bin2hex(openssl_random_pseudo_bytes(16));
        $prependwithpass = $random_salt . $currentpass;
        $hass_password = hash('sha256', $prependwithpass);

        $username = $this->sessiondata['username'];
        $getuserpass = $this->db->query("select username,password from user where username = '$username' AND password = '$hass_password'");
        if (($getuserpass->num_rows() > 0) && ($getuserpass->row()->password == $hass_password)):
            echo 'matched';
        else:
            echo 'notmatched';
        endif;
    }

    function updatepassword() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r' || $this->sessiondata['userrole'] == 'u')):
            $newpassword = $_POST['newpassword'];
            $username = $this->sessiondata['username'];
            $userid = $this->sessiondata['userid'];
// prepare random salt
            $password_edit = $newpassword;
            $random_salt = bin2hex(openssl_random_pseudo_bytes(16));
            $prependwithpass = $random_salt . $password_edit;
            $hass_password = hash('sha256', $prependwithpass);

            $updatequery = $this->db->query("update user set password = '$hass_password',random_salt='$random_salt' where userId = '$userid' AND username = '$username'");

            if ($updatequery):
                ccflogdata($this->sessiondata['username'], "accesslog", "password change", "password updated for : " . $username . " successfully");
                $this->session->set_userdata('success', 'Password Update Successfully. Login with new password');
                redirect('login/logout?id='.'logout');
            else:
                ccflogdata($this->sessiondata['username'], "accesslog", "password change", "password updated for : " . $username . " failed");
                $this->session->set_userdata('fail', 'failed');
                redirect('password/changepassword');
            endif;
        else:
            redirect('login');
        endif;
    }

}
