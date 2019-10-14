<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Users Information";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "users";
        $comid = $this->sessiondata['companyid'];

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $roleQuery = $this->db->query("select * from userrole");
            $data['userrole'] = $roleQuery->result();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('user/user', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function addUser() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $name_add = $this->input->post('name_add');

            $password_add = $this->input->post('password_add');
//            $random_salt = bin2hex(openssl_random_pseudo_bytes(16));
//            $prependwithpass = $random_salt . $password_add;
//            $hass_password = hash('sha256', $prependwithpass);


            $status_add = $this->input->post('status_add');
            if ($status_add == 1):
                $status_name = 'active';
            else:
                $status_name = 'inactive';
            endif;
            $role_add = $this->input->post('role_add');
            $address_add = $this->input->post('address_add');
            $comid = $this->sessiondata['companyid'];
            $date = date('Y-m-d H:i:s');

            $userData = [
                'username' => $name_add,
                'password' => $password_add,
                // 'random_salt' => $random_salt,
                'activeOrNot' => $status_add,
                'statusname' => $status_name,
                'description' => $address_add,
                'companyId' => $comid,
                'role' => $role_add
               // 'date' => $date
            ];
            $saveData = $this->db->insert('user', $userData); #tablename, tabledata#
            if ($saveData == TRUE):
                $this->session->set_userdata('successful', ' User Information Add Successfully for ' . $name_add);
            else :
                $this->session->set_userdata('failed', ' User Information Add Failed for ' . $name_add);
            endif;
            redirect('user/user');
        else:
            redirect('home');
        endif;
    }

    public function editUser() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $id_edit = $this->input->post('id_edit');
            $name_edit = $this->input->post('name_edit');

            /**
             * Hash Password
             */
            $password_edit = $this->input->post('password_edit');
//            $random_salt = bin2hex(openssl_random_pseudo_bytes(16));
//            $prependwithpass = $random_salt . $password_edit;
//            $hass_password = hash('sha256', $prependwithpass);


            $status_edit = $this->input->post('status_edit');
            if ($status_edit == 1):
                $status_name = 'active';
            else:
                $status_name = 'inactive';
            endif;
            $role_edit = $this->input->post('role_edit');
            $address_edit = $this->input->post('address_edit');
//        $comid = $this->sessiondata['companyid'];
//        $date = date('Y-m-d H:i:s');
            $userData = [
                'username' => $name_edit,
                'password' => $password_edit,
                // 'random_salt' => $random_salt,
                'activeOrNot' => $status_edit,
                'statusname' => $status_name,
                'description' => $address_edit,
                'role' => $role_edit,
            ];
            $this->db->where('userId', $id_edit);
            $saveData = $this->db->update('user', $userData);
            if ($saveData == TRUE):
                $this->session->set_userdata('successfull', ' User Information Update Successfully for ' . $name_edit);
            else :
                $this->session->set_userdata('failed', ' User Information Update Failed for ' . $name_edit);
            endif;
            redirect('user/user');
        else:
            redirect('home');
        endif;
    }

    public function getTable() {
        $table = 'user';
        $primaryKey = 'userId';

        $columns = [
            ['db' => '`u`.`username`', 'dt' => 0, 'field' => 'username'],
            ['db' => '`u`.`description`', 'dt' => 1, 'field' => 'description'],
            ['db' => '`r`.`details`', 'dt' => 2, 'field' => 'details'],
            ['db' => '`u`.`statusname`', 'dt' => 3, 'field' => 'statusname'],
            ['db' => '`u`.`userId`', 'dt' => 4, 'field' => 'userId',
                'formatter' => function ($rowvalue, $row) {
            return '<a  href="#"  onclick="showDeleteModal(' . $rowvalue . ')">
      <button class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove">Delete</i></button></a>&nbsp;<a href="#" onclick="showEditModal(' . $rowvalue . ')">
         <button class="btn btn-primary btn-xs"><i class="fa fa-pencil">Edit</i></button></a>';
        }]
        ];

        $this->load->database();
        $sql_details = [
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        ];
        $comid = $this->sessiondata['companyid'];
        $this->load->library('ssp');

        $join = "FROM `user` AS `u` JOIN `userrole` AS `r` ON (`u`.`role` = `r`.`rolename`)";
        $where = "`u`.`companyId`=" . $comid;
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $join, $where)
        );
    }

    public function deleteUser() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $id = $this->input->post('id_delete');
            $this->db->where('userId', $id);
            $deleteData = $this->db->delete('user'); #tablename, table Id, deleted Id#
            if ($deleteData == TRUE):
                $this->session->set_userdata('successfull', ' User Information Delete Successfully');
            else :
                $this->session->set_userdata('failed', ' User Information Delete Failed');
            endif;
            redirect('user/user');
        else:
            redirect('home');
        endif;
    }

    function showUserData() {
        $user_id = $_POST['userId'];
        $user_data = $this->db->query("SELECT * FROM user WHERE userId='$user_id'");
        echo json_encode($user_data->row());
    }

    function checkUniqueUser() {
        $username = $_POST['username'];

        if (!preg_match("/^[A-Za-z0-9]+$/i", $username)) {
            echo 'disallowed';
            return;
        }

        $userQuery = $this->db->query("SELECT username FROM user WHERE username = '$username'");
        if ($userQuery->num_rows() > 0) {
            echo 'booked';
        } else {
            echo 'free';
        }
    }

    function checkUniqueUserEdit() {
        $username = $_POST['username'];
        $userQuery = $this->db->query("SELECT username FROM user WHERE username = '$username'");
        if ($userQuery->num_rows() > 0):
            echo 'booked';
        else:
            echo 'free';
        endif;
    }

}
