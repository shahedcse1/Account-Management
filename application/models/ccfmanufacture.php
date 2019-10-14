<?php

class Ccfmanufacture extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function showalldata() {
        $this->db->select('*');
        $this->db->order_by("manufactureId", "desc");
        $this->db->from('manufacturer');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    function sortalldata() {
        $query = $this->db->query('SELECT * FROM `accountgroup` ORDER BY `accountgroup`.`accountGroupName` ASC');
        return $query->result();
    }

    function addManufacture() {
        $data = array(
            'manufactureName' => $this->input->post('manufactureName'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'description' => $this->input->post('description'),
            'companyId' => $this->sessiondata['companyid']
        );
        $insertStatus = $this->db->insert('manufacturer', $data);
        return $insertStatus;
    }

    function editManufacture() {
        $manufactureId = $this->input->post('editmanufactureId');
        $data = array(
            'manufactureName' => $this->input->post('editmanufactureName'),
            'address' => $this->input->post('editaddress'),
            'phone' => $this->input->post('editphone'),
            'email' => $this->input->post('editemail'),
            'description' => $this->input->post('editdescription'),
            'companyId' => $this->sessiondata['companyid']
        );
        $this->db->where('manufactureId', $manufactureId);
        $updatestatus = $this->db->update('manufacturer', $data);
        return $updatestatus;
    }

    public function deleteManufacturer() {
        $manufactureId = $this->input->post('manufactureId');
        $checkfarmer = $this->db->query("select manufactureId from product where manufactureId = '$manufactureId'");
        if ($checkfarmer->num_rows() > 0):
            return 'Notdeleted';
        else:
            $this->db->where('manufactureId', $manufactureId);
            $deletestatus = $this->db->delete('manufacturer');
            return 'Deleted';
        endif;
    }

    public function accountNameCheck() {
        $manufactureName = $this->input->post('manufactureName');
        $this->db->select('*');
        $this->db->from('manufacturer');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('manufactureName', $manufactureName);
        $queryresult = $this->db->get();
        if ($queryresult->num_rows() > 0):
            return false;
        else:
            return true;
        endif;
    }

}
