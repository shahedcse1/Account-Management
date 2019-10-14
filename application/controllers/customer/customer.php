<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Controller
{

    private $sessiondata;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('customerdb');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index()
    {
        $data['title'] = "Customer";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "customer";
        $data['baseurl'] = $this->config->item('base_url');

        $cmpid = $this->sessiondata['companyid'];
        $query2 = $this->db->query("SELECT * FROM  accountledger WHERE accountGroupId = 28 and companyId = '$cmpid' ORDER BY ledgerId DESC ");
        $data['customerinfo'] = $query2->result();

        $firstdate = "2000-01-01 00:00:00";
        $enddate = $this->sessiondata['maxdate'];
        $comId = $this->sessiondata['companyid'];
        $ledgerpostingQuery = $this->db->query("SELECT SUM(debit) as debit, SUM(credit) as credit, ledgerId 
FROM ledgerposting 
where date between '$firstdate%' AND '$enddate%' 
AND companyId = '$comId' 
group by ledgerId");
        $data['ledgerposting'] = $ledgerpostingQuery->result();

        $data['membertypes'] = $this->customerdb->getMemberTypes();

        $maxAccQr = $this->customerdb->getMaxAccountNumber();

        if ($maxAccQr->num_rows() > 0) {
            $newacc = (int)$maxAccQr->row()->maxacc + 1;
            $data['accountno'] = str_pad($newacc, 6, '0', STR_PAD_LEFT);
        } else {
            $data['accountno'] = str_pad(1, 6, '0', STR_PAD_LEFT);
        }



        $getcompanylist = $this->load->model('company_y');
        $data['companylist'] = $this->company_y->getcomapnylist();
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):

            $data['company_id'] = $this->sessiondata['companyid'];
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('customer/customer', $data);
            $this->load->view('footer', $data);
            $this->load->view('customer/script', $data);
        else:
            redirect('login');
        endif;
    }

    function customerNameCheck() {
        $isExist = $this->customerdb->customerNameCheck();
        if ($isExist == 'true') {
            die('free');
        } else {
            die('booked');
        }
    }

    public function add()
    {
        $data['title'] = "Customer";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "home";
        $data['baseurl'] = $this->config->item('base_url');

        $isadded = $this->customerdb->addcustomer();
        if ($isadded) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Add new customer", "New customer: " . $_POST['customer_name'] . " Added Successfully");
            echo 'Added';
        } else {
            echo 'Notadded';
        }
    }

    public function edit()
    {
        $data['title'] = "customer edit";
        $data['active_menu'] = "master";
        $data['active_sub_menu'] = "home";
        $data['baseurl'] = $this->config->item('base_url');
        $customerid = $this->input->post('editcustomerid');
        $isadded = $this->customerdb->editCustomer($customerid);
        if ($isadded):
            ccflogdata($this->sessiondata['username'], "accesslog", "Edit customer", "Customer: " . $customerid . " updated Successfully");
            $this->session->set_userdata('success', 'Customer information updated successfully!!');
            redirect('customer/customer/index');
        else:
            $this->session->set_userdata('fail', 'Customer information updated failed!!');
            redirect('customer/customer/index');
        endif;
    }

    public function delete() {
        $ledger_id = $this->input->post('ledgerid');
        $userid = $this->input->post('userid');
        $checkifused = $this->db->query("select ledgerId from ledgerposting where ledgerId = '$ledger_id'");
        if ($checkifused->num_rows() > 1) {
            echo 'Notdeleted';
        } else {
            $delete = $this->db->query("DELETE FROM accountledger WHERE ledgerId = '$ledger_id'");
            $deleteuser = $this->db->query("DELETE FROM user WHERE userId = '$userid'");
            echo 'deleted';
        }
    }

    function customerdebitorcredit() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $selectdebitotcredit = $this->db->query("select debitOrCredit from accountledger where ledgerId = '$ledgerid'");
        if ($selectdebitotcredit->row()->debitOrCredit == 1):
            $debit = 'selected';
            $credit = '';
        else:
            $credit = 'selected';
            $debit = '';
        endif;
        echo '<select class="supplier_debit pull-right form-control" id="dr_cr" name="dr_cr">
                                                <option ' . $credit . ' value="0">Cr</option>
                                                <option ' . $debit . ' value="1">Dr</option>                                                                            
                                            </select>';
    }

    function getcustomerinfo() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $customerquery = $this->db->query("SELECT  *  FROM  accountledger WHERE ledgerId = '$ledgerid' AND companyId='$cmpid'");
        $customerinfo = $customerquery->result_array();
        echo json_encode($customerinfo);
    }

    function getCustomerDestrict() {
        $cmpid = $this->sessiondata['companyid'];
        $ledgerid = $_POST['acccountLedgerid'];
        $getDistrict = $this->db->query("select * from district");
        $districtList = $getDistrict->result();
        $vendorquery = $this->db->query("select * from accountledger where ledgerId = '$ledgerid' AND companyId = '$cmpid'");
        $vendordata = $vendorquery->result();
        echo '<option value="">---District Name---</option>';
        foreach ($districtList as $groupdata):
            foreach ($vendordata as $vrow):
                if ($vrow->district == $groupdata->districtname):
                    $selected = 'selected';
                else:
                    $selected = '';
                endif;
            endforeach;
            echo '<option  ' . $selected . ' value="' . $groupdata->districtname . '">' . $groupdata->districtname . '</option>';
        endforeach;
        #echo '</select>';
    }

    function checkuniqueaccountno() {
        $cmpid = $this->sessiondata['companyid'];
        $accno = $_POST['accountno'];
        $customerquery = $this->db->query("SELECT accNo FROM accountledger WHERE accNo = '$accno' AND companyId='$cmpid'");
        if ($customerquery->num_rows() > 0):
            echo 'booked';
        else:
            echo 'free';
        endif;
    }

    function checkuniqueaccountnoForedit() {
        $cmpid = $this->sessiondata['companyid'];
        $accno = $_POST['accountno'];
        $accnoOld = $_POST['accountnoOld'];
        $customerquery = $this->db->query("SELECT accNo FROM accountledger WHERE accNo = '$accno' AND companyId='$cmpid' AND accNo NOT IN ('$accnoOld')");
        if ($customerquery->num_rows() > 0):
            echo 'booked';
        else:
            echo 'free';
        endif;
    }

    /**
     * Check Unique Account Number
     */
    public function checkUniqueAccNo()
    {
        $accno = $this->input->post('accno');
        echo $this->customerdb->checkUniqueAccNo($accno);
    }

    /**
     * Check Unique Mobile Number
     */
    public function checkUniqueMobile()
    {
        $mobile = $this->input->post('mobile');
        echo $this->customerdb->checkUniqueMobileNo($mobile);
    }

}
