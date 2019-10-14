<?php

class Contravoucher extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
        $this->load->model('ccfcontravoucher');
        if ($this->sessiondata['status'] == 'login'):
            $accessFlag = 1;
        else:
            $accessFlag = 0;
            redirect('home');
        endif;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Contra Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "contravoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['ledger'] = $this->ccfcontravoucher->ledgerdata();
            $data['sortalldata'] = $this->ccfcontravoucher->sortalldata();
            $data['allledgerdata'] = $this->ccfcontravoucher->allledgerdata();
            #print_r($data['allledgerdata']);
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('contravoucher/contravoucherfirst', $data);
            $this->load->view('footer', $data);
            $this->load->view('contravoucher/script', $data);
        else:
            redirect('home');
        endif;
    }

    public function ledgerdata() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $c = $this->input->post('c');
            $ledger = $this->ccfcontravoucher->ledgerdata();
            echo '<input type="hidden" id="count" name="count" value="' . $c . '" />';
            echo '<select class = "form-control" id = "new_ledgerId' . $c . '" name = "new_ledgerId[]">';
            echo '<option value = "">Select</option>';
            foreach ($ledger as $value) {
                echo "<option value='" . $value->ledgerId . "'>$value->acccountLedgerName</option>";
            }
            echo '</select>';
        else:
            redirect('home');
        endif;
    }

    public function addcontravoucher() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $cmpid = $this->sessiondata['companyid'];
            $isaddedCntMaster = $this->ccfcontravoucher->addcontramaster();
            $query1 = $this->db->query("SELECT MAX( contraMasterId ) FROM contramaster where companyId=$cmpid");
            $row1 = $query1->row_array();
            $contraMasterId = $row1['MAX( contraMasterId )'];
            $isaddedCntDetail = $this->ccfcontravoucher->addcontradetails($contraMasterId);
            if ($isaddedCntMaster && $isaddedCntDetail) {
                $this->session->set_userdata('success', 'Contra Voucher added successfully');
                redirect('contravoucher/contravoucher');
            } else {
                $this->session->set_userdata('fail', 'Contra Voucher add failed');
                redirect('contravoucher/contravoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function editcontravoucher() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Contra Voucher";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "contravoucher";
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['ledger'] = $this->ccfcontravoucher->ledgerdata();
            $data['sortalldata'] = $this->ccfcontravoucher->sortalldata();
            $data['allledgerdata'] = $this->ccfcontravoucher->allledgerdata();
            $id = $this->uri->segment(4);
            $query = $this->db->query("Select * from contramaster where contraMasterId='$id'");
            $IdAvailable = $query->row()->contraMasterId;
            if ($IdAvailable == "") {
                redirect('contravoucher/contravoucher');
            } else {
                $data['rows'] = $query->row();
                $this->load->view('header', $data);
                $this->load->view('sidebar', $data);
                $this->load->view('contravoucher/editcontravoucher', $data);
                $this->load->view('footer', $data);
                $this->load->view('contravoucher/script', $data);
            }

        else:
            redirect('home');
        endif;
    }

    public function editcontravoucher2() {

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isupdatedConMaster = $this->ccfcontravoucher->updatedcontravoucher();

            if ($isupdatedConMaster) {
                $this->session->set_userdata('success', 'Contra Voucher Updated successfully');
                redirect('contravoucher/contravoucher');
            } else {
                $this->session->set_userdata('fail', 'Contra Voucher update failed');
                redirect('contravoucher/contravoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function deletecontravoucher() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $isdeleted = $this->ccfcontravoucher->deletecontraMaster();
            if ($isdeleted) {
                $this->session->set_userdata('success', 'Contra Voucher deleted successfully');
                redirect('contravoucher/contravoucher');
            } else {
                $this->session->set_userdata('fail', 'Contra Voucher delete failed');
                redirect('contravoucher/contravoucher');
            }
        else:
            redirect('home');
        endif;
    }

    public function getContraDetailsTable() {

        // DB table to use

        $table = 'contramaster';
        $primaryKey = 'contraMasterId';
        $columns = array(
            array('db' => '`cm`.`contraMasterId`', 'dt' => 0, 'field' => 'contraMasterId',
                'formatter' => function ($rowvalue, $row) {
                    return '<a onclick=deleteModalFun(' . $row[0] . ');  href="#"><i class="fa fa-times-circle delete-icon"></i></a>';
                }),
            array('db' => '`cm`.`contraMasterId`', 'dt' => 1, 'field' => 'contraMasterId',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('contravoucher/contravoucher/editcontravoucher/' . $rowvalue) . '">' . $rowvalue
                            . '</a>';
                }),
            array('db' => '`cm`.`date`', 'dt' => 2, 'field' => 'date',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('contravoucher/contravoucher/editcontravoucher/' . $row[1]) . '">' . date('d M 
Y', strtotime($rowvalue)) . '</a>';
                }),
            array('db' => '`al`.`acccountLedgerName`', 'dt' => 3, 'field' => 'acccountLedgerName',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('contravoucher/contravoucher/editcontravoucher/' . $row[1]) . '">' . $rowvalue .
                            '</a>';
                }),
            array('db' => '`cd`.`amount`', 'dt' => 4, 'field' => 'amount',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('contravoucher/contravoucher/editcontravoucher/' . $row[1]) . '">' . $rowvalue .
                            '</a>';
                }),
            array('db' => '`cm`.`type`', 'dt' => 5, 'field' => 'type',
                'formatter' => function($rowvalue, $row) {
                    return '<a href="' . site_url('contravoucher/contravoucher/editcontravoucher/' . $row[1]) . '">' . $rowvalue .
                            '</a>';
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
        $joinQuery = "FROM `contramaster` `cm` JOIN `contradetails` `cd` ON 
`cm`.`contraMasterId` = `cd`.`contraMasterId` JOIN `accountledger` `al` ON `al`.`ledgerId` = `cm`.`ledgerId`";
        $extraWhere = "`cm`.`companyId` = '$companyid' AND `cd`.`companyId` = '$companyid'
AND `al`.`companyId` = '$companyid'";
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
