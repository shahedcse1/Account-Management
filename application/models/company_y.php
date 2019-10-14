<?php

class Company_y extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function getcomapnylist() {
        $companyquery = $this->db->query("select * from company");
        return $companyquery->result();
    }

    public function getfinancialyear($id) {
        $companyquery = $this->db->query("select * from finacialyear where companyId = '$id'");
        return $companyquery->result();
    }

    public function checkuserinfoForLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $companyid = $_POST['compantid'];
        $financialyear = $_POST['fyearstatus'];
        $yeardata = explode(",", $financialyear);
        $datedata = explode(":", $yeardata[0]);
        $Checkquery = $this->db->query("select * from user where username = '$username' AND password = '$password'");
        $result = $Checkquery->result();
        if ($Checkquery->num_rows() > 0):
            if ($Checkquery->row()->password == $password && $Checkquery->row()->username == $username && $Checkquery->row()->companyId == $companyid):
                if ($Checkquery->row()->activeOrNot == '1'):
                    $this->session->set_userdata('loginsuccess', 'Login successfull');
                    if ($Checkquery->row()->role == 'r'):
                        $edit = 0;
                    else:
                        $edit = $yeardata[1];
                    endif;
                    $edit = $yeardata[1];
                    $modifydate = $datedata[1] . " 23:59:59";
                    $strtotime_today = strtotime($modifydate);
                    $previous_dateadd1 = strtotime("+1 day", $strtotime_today);
                    $newmindate = date('Y-m-d', $previous_dateadd1);
                    $previous_dateadd365 = strtotime("+365 day", $strtotime_today);
                    $newmaxdate = date('Y-m-d', $previous_dateadd365);
                    $loginData = array(
                        'userid' => $Checkquery->row()->userId,
                        'companyid' => $companyid,
                        'newmindate' => $newmindate,
                        'newmaxdate' => $newmaxdate,
                        'fyear_status' => $edit,
                        'mindate' => $datedata[0],
                        'maxdate' => $datedata[1],
                        'username' => $username,
                        'status' => 'login',
                        'userrole' => $Checkquery->row()->role
                    );
                    $this->session->set_userdata('logindata', $loginData);
                    return 1;
                else:
                    $this->session->set_userdata('loginerror', 'Your account is blocked');
                    return 0;
                endif;
            else:
                $this->session->set_userdata('loginerror', 'Invalid username or password');
                return 0;
            endif;
        else:
            $this->session->set_userdata('loginerror', 'Invalid user or password');
            return 0;
        endif;
    }

}
