<?php

if (!defined('BASEPATH'))
    exit('No Direct Script access allowed');

class Notice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        //$this->load->model('ccfmanufacture');
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
        $data['title'] = "Notice";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "notice";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('notice/notice', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function getnoticetable() {
        $table = 'notices';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'id', 'dt' => 0,
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => 'created_at', 'dt' => 1,
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_notice" href="' . site_url('notice/notice/edit_notice?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => 'message', 'dt' => 2,
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_notice" href="' . site_url('notice/notice/edit_notice?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                }),
            array('db' => 'order_id', 'dt' => 3, 'field' => 'debit',
                'formatter' => function($rowvalue, $row) {
                    return '<a class="edit_notice" href="' . site_url('notice/notice/edit_notice?id=' . $row[0]) . '">' . $rowvalue . '</a>';
                })
        );

        $this->load->database();
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $this->load->library('ssp');
        $companyid = $this->sessiondata['companyid'];
        $extraWhere = "companyId = '1'";

        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, '', $extraWhere)
        );
    }

    public function addnotice() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $noticemessage = $this->input->post('noticemessage');
            $noticeorder = $this->input->post('noticeorder');
            $companyid = $this->sessiondata['companyid'];
            $noticedata = array(
                'message' => $noticemessage,
                'order_id' => $noticeorder,
                'companyId' => $companyid
            );
            $addnotice = $this->db->insert('notices', $noticedata);
            if ($addnotice) {
                $this->session->set_userdata('success', 'Notice added successfully');
                redirect('notice/notice');
            } else {
                $this->session->set_userdata('fail', 'Notice add failed');
                redirect('notice/notice');
            }
        else:
            redirect('home');
        endif;
    }

    public function deletenotice() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $noticeid = $this->input->post('noticeid');
            $isdeleted = $this->db->query("DELETE FROM notices WHERE id = '$noticeid'");
            if ($isdeleted) {
                $this->session->set_userdata('success', 'Notice deleted successfully');
                redirect('notice/notice');
            } else {
                $this->session->set_userdata('fail', 'Notice delete failed');
                redirect('notice/notice');
            }
        else:
            redirect('home');
        endif;
    }

    public function edit_notice() {
        $data['title'] = "Notice Edit";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "notice";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['baseurl'] = $this->config->item('base_url');
            $noticeid = $this->input->get('id');
            $noticeQr = $this->db->query("SELECT * FROM notices WHERE id = '$noticeid'");
            $data['noticedata'] = $noticeQr->row();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('notice/edit_notice', $data);
            $this->load->view('footer', $data);
        else:
            redirect('home');
        endif;
    }

    public function update_notice() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $noticemessage = $this->input->post('noticemessage');
            $noticeorder = $this->input->post('noticeorder');
            $noticeid = $this->input->post('noticeid');
            $updatedata = array(
                'message' => $noticemessage,
                'order_id' => $noticeorder
            );
            $this->db->where('id', $noticeid);
            $updatenotice = $this->db->update('notices', $updatedata);
            if ($updatenotice) {
                $this->session->set_userdata('success', 'Notice updated successfully');
                redirect('notice/notice');
            } else {
                $this->session->set_userdata('fail', 'Notice update failed');
                redirect('notice/notice');
            }
        else:
            redirect('home');
        endif;
    }

}
