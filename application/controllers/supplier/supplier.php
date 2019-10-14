<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index()
    {
        $data['title'] = "Supplier";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "supplier";
        $data['baseurl'] = $this->config->item('base_url');
        //query data to view into table
        $cmpid = $this->sessiondata['companyid'];
        $query2 = $this->db->query("SELECT  *  FROM  accountledger WHERE accountGroupId=27 and companyId='$cmpid' ORDER BY ledgerId DESC");
        $data['supplierinfo1'] = $query2->result();

        $query = $this->db->query("SELECT * FROM vendor where companyId = '$cmpid' ORDER BY vendorId DESC");
        $data['supplierinfo2'] = $query->result();

        $query2 = $this->db->query("SELECT  *  FROM  countries");
        $data['countries'] = $query2->result();
        $firstdate = "2000-01-01 00:00:00";
        $enddate = $this->sessiondata['maxdate'];
        $comId = $this->sessiondata['companyid'];
        $ledgerpostingQuery = $this->db->query("SELECT sum(debit) as debit,sum(credit) as credit,ledgerId FROM ledgerposting where date between '$firstdate%' AND '$enddate%' AND companyId = '$comId' group by ledgerId");

        $data['ledgerposting'] = $ledgerpostingQuery->result();

        $getcompanylist = $this->load->model('company_y');
        $data['companylist'] = $this->company_y->getcomapnylist();
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login'):
            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('supplier/supplier', $data);
             $this->load->view('footer', $data);
        else:
            redirect('login');
        endif;
    }

    function suppliernamecheck() {
        $this->load->model('supplierdb');
        $isExist = $this->supplierdb->supplierNameCheck();
        if ($isExist == 'true') {
            die('free');
        } else {
            die('booked');
        }
    }

    /**
     * Add New Supplier
     */
    public function add()
    {
        $data['title'] = "Supplier";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "supplier";
        $data['baseurl'] = $this->config->item('base_url');

        $supplier_name   = $this->input->post('supplier_name');
        $paymentvouModal = $this->input->post('paymentvouModal');
        $receiptvouModal = $this->input->post('receiptvouModal');

        $this->load->model('supplierdb');
        $isadded1 = $this->supplierdb->addSupplier1();

        /**
         * Find ledger id for supplier name
         */
        $ledgerId = $this->db
            ->select('ledgerId')
            ->from('accountledger')
            ->where('acccountLedgerName', $supplier_name)
            ->get()
            ->row()
            ->ledgerId;

        $isadded2 = $this->supplierdb->addSupplier2($ledgerId);
        if ($paymentvouModal == "addpaymentvouModal") {
            ($isadded1 && $isadded2)
                ? redirect('paymentvoucher/paymentvoucher/addpaymentvoucher')
                : redirect('paymentvoucher/paymentvoucher/addpaymentvoucher');

        } else {
            echo ($isadded1 && $isadded2)
                ? 'Added'
                : 'Notadded';
        }
        if ($receiptvouModal == "addreceiptvouModal") {
            ($isadded1 && $isadded2)
                ? redirect('receiptvoucher/receiptvoucher/addreceiptvoucher')
                : redirect('receiptvoucher/receiptvoucher/addreceiptvoucher');
        }
    }

    public function edit() {
        $data['title'] = "Supplier";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "supplier";
        $data['baseurl'] = $this->config->item('base_url');
        if ($this->sessiondata['username'] != NULL
            && $this->sessiondata['status'] == 'login'
            && ($this->sessiondata['userrole'] == 'a'
                && $this->sessiondata['userrole'] != 's'
                && $this->sessiondata['userrole'] != 'u'
                || $this->sessiondata['userrole'] == 'r')):
            $this->load->model('supplierdb');
            $ledgerid = $_POST['supplierid'];
            $isadded1 = $this->supplierdb->editSupplier1($ledgerid);
            $isadded2 = $this->supplierdb->editSupplier2($ledgerid);
            if ($isadded2 && $isadded1):
                $this->session->set_userdata('success', 'Supplier updated successfully!!');
                redirect('supplier/supplier');
            else:
                $this->session->set_userdata('fail', 'Supplier updated failed!!');
                redirect('supplier/supplier');
            endif;
        else:
            redirect('home');
        endif;
    }

    public function delete() {
        $ledger_id = $this->input->post('ledgerid');
        $checkifused = $this->db->query("select ledgerId from ledgerposting where ledgerId = '$ledger_id'");
        if ($checkifused->num_rows() > 1) {
            echo 'Notdeleted';
        } else {
            $delete1 = $this->db->query("DELETE FROM vendor WHERE ledgerId='$ledger_id'");
            $delete2 = $this->db->query("DELETE FROM accountledger WHERE ledgerId='$ledger_id'");
            echo 'deleted';
        }
    }

    function suppliercountry() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $getcountry = $this->db->query("select * from countries");
        $countylist = $getcountry->result();
        $vendorquery = $this->db->query("select * from vendor where ledgerId = '$ledgerid' AND companyId = '$cmpid'");
        $vendordata = $vendorquery->result();
        #echo json_encode($vendordata);
        #echo '<select class="form-control" id="editcountry" name="country" type="text">';
        foreach ($countylist as $groupdata):
            foreach ($vendordata as $vrow):
                if ($vrow->country == $groupdata->country_name):
                    $selected = 'selected';
                else:
                    $selected = '';
                endif;
            endforeach;
            echo '<option  ' . $selected . ' value="' . $groupdata->country_name . '">' . $groupdata->country_name . '</option>';
        endforeach;
        #echo '</select>';
    }

    function getsupplierinfo() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $customerquery = $this->db->query("SELECT accountledger.status,accountledger.accNo,accountledger.acccountLedgerName,accountledger.openingBalance,accountledger.debitOrCredit,vendor.address,vendor.vendorName,vendor.country,vendor.nameOfBusiness,vendor.mobileNumber,vendor.description FROM accountledger inner join vendor on accountledger.ledgerId = vendor.ledgerId WHERE accountledger.ledgerId = '$ledgerid' AND vendor.ledgerId = '$ledgerid' AND vendor.companyId='$cmpid'");
        $customerinfo = $customerquery->result_array();
        echo json_encode($customerinfo);
    }

}
