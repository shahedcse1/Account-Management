<?php

class Ccfproduct extends CI_Model {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    function sortalldata() {
        $this->db->select('*');
        $this->db->order_by("productId", "DESC");
        $this->db->from('product');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('rawmaterial', '0');
        $query = $this->db->get();
        return $query->result();
    }

    function costdata() {
        $this->db->select('*');
        $this->db->from('productbatch');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    function editview($data) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('productId', $data);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    function productlist() {
        $this->db->select('*');
        $this->db->order_by("productGroupName", "asc");
        $this->db->from('productgroup');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    function manufaclist() {
        $this->db->select('*');
        $this->db->order_by("manufactureName", "asc");
        $this->db->from('manufacturer');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    function unitlist() {
        $this->db->select('*');
        $this->db->order_by("unitName", "asc");
        $this->db->from('unit');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    private function getLastProductCode()
    {
        return $this->db
            ->select('productcode')
            ->from('product')
            ->order_by('productId', 'DESC')
            ->limit(1)
            ->get()
            ->row();
    }

    /**
     * Add a Product
     * @return mixed
     */
    public function addproduct()
    {
        $lastproductcode = $this->getLastProductCode();

        $productcode = '';
        if ($this->input->post('productCode')) {
            $productcode = $this->input->post('productCode');
        } else {
            if (count($lastproductcode)) {
                $productcode = (int)explode('-', $lastproductcode->productcode)[1] + 1;
                $productcode = 'P-'.str_pad($productcode, 6, '0', STR_PAD_LEFT);
            } else {
                $productcode = 'P-'.str_pad(1, 6, '0', STR_PAD_LEFT);
            }
        }

        $randnum = rand(0, 99);
        $uploadfile = $_FILES['picture']['name'];
        $picname    = explode('.', $uploadfile);
        $picname[0] = $productcode;
        if ($uploadfile == ''):
            $file = 'default.png';
        else:
            $file = $picname[0] . '_' . $randnum . '.' . $picname[1];
        endif;
        $savedata = [
            'productcode'       => $productcode,
            'productName'       => $productcode,
            'productGroupId'    => $this->input->post('productGroupId'),
            'manufactureId'     => $this->input->post('manufactureId'),
            'stockMinimumLevel' => $this->input->post('stockMinimumLevel'),
            'stockMaximumLevel' => $this->input->post('stockMaximumLevel'),
            'unitId'            => $this->input->post('unitId'),
            'taxType'           => $this->input->post('taxType'),
            'tax'               => $this->input->post('tax'),
            'description'       => $this->input->post('description'),
            'companyId'         => $this->sessiondata['companyid'],
            'images'            => $file
        ];
        $savequery = $this->db
            ->insert('product', $savedata);

        if ($file != '')  {
            $updatestatus = $this->UploadImage('picture', "assets/uploads/product/", $file);
            ccflogdata($this->sessiondata['username'], "accesslog", "product", "product : " . $productcode . " added successfully");
            return $savequery;
        }
    }

    public function add_rawProduct() {

        $randnum = rand(0, 99);
        $uploadfile = $_FILES['picture']['name'];
        $picname = explode('.', $uploadfile);
        $picname[0] = $_POST['productName'];
        $picname[1] = 'png';
        #$file = $picname[0] . '_' . $randnum . '.' . $picname[1];
        if ($uploadfile == ''):
            $file = 'default.png';
        else:
            $file = $picname[0] . '_' . $randnum . '.' . $picname[1];
        endif;
        $savedata = array(
            'productName' => $_POST['productName'],
            'productGroupId' => $_POST['productGroupId'],
            'manufactureId' => $_POST['manufactureId'],
            'stockMinimumLevel' => $_POST['stockMinimumLevel'],
            'stockMaximumLevel' => $_POST['stockMaximumLevel'],
            'unitId' => $_POST['unitId'],
            'taxType' => $_POST['taxType'],
            'tax' => $_POST['tax'],
            'description' => $_POST['description'],
            'companyId' => $this->sessiondata['companyid'],
            'rawmaterial' => 1,
            'images' => $file
        );
        $savequery = $this->db->insert('product', $savedata);
        if ($file != "") :
            $updatestatus = $this->UploadImage('picture', "assets/uploads/product/", $file);
            ccflogdata($this->sessiondata['username'], "accesslog", "product", "product : " . $_POST['productName'] . " added successfully");
            return $savequery;
        endif;
    }

    public function UploadImage($field, $url, $name) {
        $config['upload_path'] = $url;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        $config['max_size'] = '10000';
        $config['max_width'] = '1524';
        $config['max_height'] = '1524';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        $this->upload->do_upload($field);
    }

    /**
     * @param $productId
     * @return mixed
     */
    public function addproductbtch($productId)
    {
        $data2 = array(
            'productId' => $productId,
            'companyId' => $this->sessiondata['companyid']
        );
        $saveresult = $this->db->insert('productbatch', $data2);
        return $saveresult;
    }

    public function deleteproduct() {
        $productId = $_POST['productId'];
        $checkfarmer = $this->db->query("select ledgerId from ledgerposting where ledgerId = '$productId'");
        if ($checkfarmer->num_rows() > 0):
            return 'Notdeleted';
        else:
            $this->db->where('productId', $productId);
            $this->db->where('companyId', $this->sessiondata['companyid']);
            $deleteResult = $this->db->delete('product');
            $comid = $this->sessiondata['companyid'];
            $removeBatch = $this->db->query("DELETE FROM productbatch WHERE productId = '$productId' AND companyId = '$comid'");
            ccflogdata($this->sessiondata['username'], "accesslog", "product", "product : " . $_POST['productId'] . " delete successfully");
            return 'Deleted';
        endif;
    }

    public function editproduct() {

        $randnum = rand(0, 99);
        $uploadfile = $_FILES['picture']['name'];
        $picname = explode('.', $uploadfile);
        $picname[0] = $_POST['editproductName'];
        $picname[1] = 'png';
        #$file = $picname[0] . '_' . $randnum . '.' . $picname[1];
        $productId = $_POST['editproductId'];
        if ($uploadfile == ''):
            $file = "";
            $data = array(
                'productName' => $_POST['editproductName'],
                'productcode' => $_POST['editproductName'],
                'productGroupId' => $_POST['editproductGroupId'],
                'manufactureId' => $_POST['editmanufactureId'],
                'stockMinimumLevel' => $_POST['editstockMinimumLevel'],
                'stockMaximumLevel' => $_POST['editstockMaximumLevel'],
                'unitId' => $_POST['editunitId'],
                'taxType' => $_POST['edittaxType'],
                'tax' => $_POST['edittax'],
                'description' => $_POST['editdescription']
            );
        else:
            $file = $picname[0] . '_' . $randnum . '.' . $picname[1];
            $data = array(
                'productName' => $_POST['editproductName'],
                'productGroupId' => $_POST['editproductGroupId'],
                'manufactureId' => $_POST['editmanufactureId'],
                'stockMinimumLevel' => $_POST['editstockMinimumLevel'],
                'stockMaximumLevel' => $_POST['editstockMaximumLevel'],
                'unitId' => $_POST['editunitId'],
                'taxType' => $_POST['edittaxType'],
                'tax' => $_POST['edittax'],
                'description' => $_POST['editdescription'],
                'images' => $file
            );
        endif;
        $this->db->where('productId', $productId);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $updateResult = $this->db->update('product', $data);
        if ($file != "") :
            $updatestatus = $this->UploadImage('picture', "assets/uploads/product/", $file);
        endif;
        $psalesrate = $this->input->post('psalesrate');
        $pbatchid = $this->input->post('pbatchid');
        $datapb = array(
            'salesRate' => $psalesrate
        );
        $this->db->where('productId', $productId);
        $this->db->where('productBatchId', $pbatchid);
        $this->db->update('productbatch', $datapb);
        ccflogdata($this->sessiondata['username'], "accesslog", "product", "product : " . $_POST['editproductName'] . " update successfully");
        return $updateResult;
    }

}
