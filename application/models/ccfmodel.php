<?php

class ccfmodel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function addAccGroup() {
        $compantid = $this->sessiondata['companyid'];
        $getmaxaccountGroupId = $this->db->query("select max(accountGroupId) as maxaccid from accountgroup where companyId = '$compantid'");
        $AGID = $getmaxaccountGroupId->row()->maxaccid;
        $data = array(
            'accountGroupId' => $AGID + 1,
            'accountGroupName' => $this->input->post('accountGroupName'),
            'groupUnder' => $this->input->post('groupUnder'),
            'description' => $this->input->post('description'),
            'defaultOrNot' => $this->input->post('defaultOrNot'),
            'companyId' => $this->sessiondata['companyid']
        );
        $insertStatus = $this->db->insert('accountgroup', $data);
        return $insertStatus;
    }

    public function editAccGroup() {
        $accountGroupId = $this->input->post('editaccountGroupId');
        $data = array(
            'accountGroupName' => $this->input->post('editaccountGroupName'),
            'groupUnder' => $this->input->post('editgroupUnder'),
            'description' => $this->input->post('editdescription'),
            'defaultOrNot' => $this->input->post('editdefaultOrNot'),
            'companyId' => $this->sessiondata['companyid']
        );
        $this->db->where('accountGroupId', $accountGroupId);
        $updatestatus = $this->db->update('accountgroup', $data);
        return $updatestatus;
    }

    public function deleteAccGroup() {
        $accountGroupId = $this->input->post('accountGroupId');
        $checkid = $this->db->query("select accountGroupId from accountledger where accountGroupId = '$accountGroupId'");
        if ($checkid->num_rows() > 0):
            return "notdeleted";
        else:
            $this->db->where('accountGroupId', $accountGroupId);
            $response = $this->db->delete('accountgroup');
            return "deleted";
        endif;
    }

    function showalldata() {
        $this->db->select('*');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->order_by("accountGroupId", "desc");
        $this->db->from('accountgroup');
        $query = $this->db->get();
        return $query->result();
    }

    function sortalldata() {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT * FROM accountgroup where companyId = '$cmpid' ORDER BY accountGroupName ASC");
        return $query->result();
    }

    public function accountNameCheck() {

        $accountGroupName = $this->input->post('accgname');
        $qqueryresult = $this->db->query("select * from accountgroup where accountGroupName = '$accountGroupName'");
        if ($qqueryresult->num_rows() > 0):
            return false;
        else:
            return true;
        endif;
    }

}
