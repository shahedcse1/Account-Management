<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Financialyear extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->library('session');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function index() {
        $data['title'] = "Add financial year";
        $data['active_menu'] = "setting";
        $data['active_sub_menu'] = "financialyear";
        $data['baseurl'] = $this->config->item('base_url');
        $companyid = $this->sessiondata['companyid'];
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $getFinancialYearInfo = $this->db->query("select * from finacialyear where companyId = '$companyid'");
            $data['financialyeardata'] = $getFinancialYearInfo->result();
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('financialyear/financialyear', $data);
            $this->load->view('footer', $data);
        else:
            redirect('login');
        endif;
    }

    function addfinancialyear() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $companyId = $this->sessiondata['companyid'];
            $checkcompanyFinancialYear = $this->db->query("select activeOrNot from finacialyear where companyId = '$companyId'");
            $status = $checkcompanyFinancialYear->row()->activeOrNot;
            if ($status == 0):
                $fyeardata = array(
                    'fromDate' => $_POST['fromdate'],
                    'toDate' => $_POST['todate'],
                    'activeOrNot' => $_POST['status'],
                    'companyId' => $this->sessiondata['companyid']
                );
                $savesalesman = $this->db->insert('finacialyear', $fyeardata);
                if ($savesalesman):
                    ccflogdata($this->sessiondata['username'], "accesslog", "financial year", "Financial year: " . $_POST['fromdate'] . " Added");
                    $this->session->set_userdata('success', 'successfully');
                    redirect('financialyear/financialyear');
                else:
                    ccflogdata($this->sessiondata['username'], "accesslog", "financial year", "Financial year: " . $_POST['fromdate'] . " Added failed");
                    $this->session->set_userdata('fail', 'failed');
                    redirect('financialyear/financialyear');
                endif;
            else:
                ccflogdata($this->sessiondata['username'], "accesslog", "financial year", "Financial year: " . $_POST['fromdate'] . " Added failed");
                $this->session->set_userdata('fail_add', 'failed');
                redirect('financialyear/financialyear');
            endif;

        else:
            redirect('login');
        endif;
    }

    function getfinacialYearStatus() {
        $cmpid = $this->sessiondata['companyid'];
        $fyearId = $_POST['fyearid'];
        $selectyarstatus = $this->db->query("select activeOrNot from finacialyear where finacialYearId = '$fyearId'");
        if ($selectyarstatus->row()->activeOrNot == 1):
            $check = 'checked';
            $uncheck = '';
        else:
            $uncheck = 'checked';
            $check = '';
        endif;
        echo ' <div class="radio">
                                            <label>
                                                Active
                                                <input ' . $check . ' type="radio" class="radiobutton" name="status" id="status" value="1">
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                InActive
                                                <input ' . $uncheck . ' type="radio" class="radiobutton" name="status" id="status" value="0">
                                            </label>
                                        </div>';
    }

    function getfyeardata() {
        $cmpid = $this->sessiondata['companyid'];
        $fyearId = $_POST['fyearid'];
        $fyeardata = $this->db->query("select * from finacialyear where finacialYearId = '$fyearId'");
        $fyearresult = $fyeardata->result();
        echo json_encode($fyearresult);
    }

    function deletesalesman() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $deleteid = $_POST['salesmanid'];
            $deletequery = $this->db->query("delete from salesman where salesManId = '$deleteid'");
            if ($deletequery):
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

    function updatefinancialyear() {
        $fyearupdateId = $_POST['fyearupdateid'];
        $updateinfo = array(
            'fromDate' => $_POST['fromdate'],
            'toDate' => $_POST['todate'],
            'activeOrNot' => $_POST['status']
        );
        $this->db->where('finacialYearId', $fyearupdateId);
        $updateresult = $this->db->update('finacialyear', $updateinfo);
        if ($updateresult):
            ccflogdata($this->sessiondata['username'], "accesslog", "financial year", "financial Year: " . $_POST['fromdate'] . "  updated ");
            $this->session->set_userdata('success_update', 'financial year update successfully');
            redirect('financialyear/financialyear');
        else:
            ccflogdata($this->sessiondata['username'], "accesslog", "salesman", "Salesman: " . $_POST['fromdate'] . " updated failed");
            $this->session->set_userdata('fail_update', 'financial year update failed');
            redirect('financialyear/financialyear');
        endif;
    }

}
