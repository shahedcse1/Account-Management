<?php

class Productunit_model extends CI_Model {
    private $sessiondata;
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $table = 'unit';
        $this->sessiondata = $this->session->userdata('logindata'); 
    }

    public function saveproductunit() {       
        $savedata = array(
            'unitName' => $_POST['unitname'],
            'description' => $_POST['description'],
            'companyId' => $this->sessiondata['companyid']
        );       
        $savequery = $this->db->insert('unit', $savedata);
        ccflogdata($this->sessiondata['username'], "accesslog", "product unit", "Product unit: " . $_POST['unitname'] . " Added successfully");
        return $savequery;
    }
    
    public function readAll(){
        $companyid = $this->sessiondata['companyid'];
        $getunit = $this->db->query("select * from unit where companyId = '$companyid' order by unitId DESC");
        $unitlist = $getunit->result();
        return $unitlist;
    }
    
    public function deletebyId(){
        $unitdeleteId = $_POST['accountGroupId'];            
        $checkfarmer = $this->db->query("select ledgerId from ledgerposting where ledgerId = '$unitdeleteId'");
        if ($checkfarmer->num_rows() > 0):            
            return 'Notdeleted';
        else:
            ccflogdata($this->sessiondata['username'], "accesslog", "product unit", "Product unit: " . $_POST['accountGroupId'] . " deleted successfully");
            $deleteResult = $this->db->query("delete from unit where unitId = '$unitdeleteId'");             
            return 'Deleted';
        endif;
    }
    
     public function updateUnit(){
        $unitdeleteId = $_POST['accountGroupId'];
        $unitname = $_POST['unitname'];
        $description = $_POST['description'];
        $updateResult = $this->db->query("update unit set unitName = '$unitname',description = '$description' where unitId = '$unitdeleteId'");
        ccflogdata($this->sessiondata['username'], "accesslog", "product unit", "Product unit: " . $_POST['unitname'] . " update successfully");
        return $updateResult;
    }

}
