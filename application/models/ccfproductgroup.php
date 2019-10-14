<?php

class CcfproductGroup extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function addproductGroup() {
        $savedata = array(
            'productGroupName' => $_POST['productGroupName'],
            'description' => $_POST['description'],
            'companyId' => $this->sessiondata['companyid']
        );
        $savequery = $this->db->insert('productgroup', $savedata);
        return $savequery;
    }

    public function deleteproductGroup() {
        $productGroupId = $_POST['productGroupId'];
        $checkfarmer = $this->db->query("select ledgerId from ledgerposting where ledgerId = '$productGroupId'");
        if ($checkfarmer->num_rows() > 0):
            return 'Notdeleted';
        else:
            $this->db->where('productGroupId', $productGroupId);
            $this->db->where('companyId', $this->sessiondata['companyid']);
            $deleteResult = $this->db->delete('productgroup');
            ccflogdata($this->sessiondata['username'], "accesslog", "product group", "product group : " . $_POST['productGroupId'] . " delete successfully");
            return 'Deleted';
        endif;
    }

    public function editproductGroup() {
        $productGroupId = $_POST['productGroupId'];
        $data = array(
            'productGroupName' => $_POST['productGroupName'],
            'description' => $_POST['description']
        );
        $this->db->where('productGroupId', $productGroupId);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $updateResult = $this->db->update('productgroup', $data);
        ccflogdata($this->sessiondata['username'], "accesslog", "product group", "product group : " . $_POST['productGroupName'] . " delete successfully");
        return $updateResult;
    }

    public function readAll() {
        $this->db->select('*');
        $this->db->from('productgroup');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

}
