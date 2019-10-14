<?php

class Ccfreceiptvou extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function addreceipt($data) {
        $insertstatus = $this->db->insert('receiptmaster', $data);
        $query = $this->db->query("Select MAX(receiptMasterId) from receiptmaster");
        $result = $query->row_array();
        $receiptmasterId = $result['MAX(receiptMasterId)'];
        if ($insertstatus) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Add ReceiptVoucher", "Receipt Voucher No. $receiptmasterId Added");
            return $insertstatus;
        }
    }

    public function findpaymentmsid($ledgerid) {
        $this->db->select('paymentMasterId');
        $this->db->from('paymentmaster');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerId', $ledgerid);
        $query = $this->db->get();
        return $query->result();
    }

    public function adddreceiptetails($payid) {
        $data = array(
            'receiptMasterId ' => $payid,
            'ledgerId' => $_POST['ledgerId'],
            'receiptNo' => $_POST['receiptNo'],
            'voucherNumber' => "",
            'voucherType' => "",
            'amount' => $_POST['amount'],
            'chequeNumber' => $_POST['chequeNumber'],
            'chequeDate' => $_POST['chequeDate'],
            'description' => $_POST['description'],
            'companyId' => $this->sessiondata['companyid']
        );
        $insertstatus = $this->db->insert('receiptdetails', $data);
        return $insertstatus;
    }

    public function addledgerposting1($payid) {
        $data = array(
            'date' => $_POST['date'],
            'ledgerId' => $_POST['paymentMode'],
            'voucherNumber' => $payid,
            'voucherType' => "Receipt Voucher",
            'credit' => "0.00",
            'debit' => $_POST['amount'],
            'description' => "By Receipt",
            'companyId' => $this->sessiondata['companyid']
        );
        $insertstatus = $this->db->insert('ledgerposting', $data);
        return $insertstatus;
    }

    public function addledgerposting2($payid) {
        $data = array(
            'date' => $_POST['date'],
            'ledgerId' => $_POST['ledgerId'],
            'voucherNumber' => $payid,
            'voucherType' => "Receipt Voucher",
            'credit' => $_POST['amount'],
            'debit' => "0.00",
            'description' => "By Receipt",
            'companyId' => $this->sessiondata['companyid']
        );
        $insertstatus = $this->db->insert('ledgerposting', $data);
        return $insertstatus;
    }

    public function addPartyBalance($payid) {
        $neworagainst = $this->input->post('referenceType');
        if ($neworagainst == 'Against') {
            $data = array(
                'date' => $_POST['date'],
                'ledgerId' => $_POST['ledgerId'],
                'voucherNo' => $_POST['voucherNumber'],
                'voucherType' => "Sales Invoice",
                'againstVoucherType' => "Receipt Voucher",
                'againstvoucherNo' => $payid,
                'referenceType' => $_POST['referenceType'],
                'debit' => "0.00",
                'credit' => $_POST['amount'],
                'optional' => "0",
                'creditPeriod' => "0",
                'branchId' => "1",
                'extraDate' => $_POST['date'],
                'extra1' => "",
                'extra2' => "",
                'currecyConversionId' => "1",
                'companyId' => $this->sessiondata['companyid']
            );
            $insertstatus = $this->db->insert('partybalance', $data);
            return $insertstatus;
        } else {
            $data = array(
                'date' => $_POST['date'],
                'ledgerId' => $_POST['ledgerId'],
                'voucherNo' => $payid,
                'voucherType' => "Receipt Voucher",
                'againstVoucherType' => "NA",
                'againstvoucherNo' => "NA",
                'referenceType' => $_POST['referenceType'],
                'debit' => "0.00",
                'credit' => $_POST['amount'],
                'optional' => "0",
                'creditPeriod' => "0",
                'branchId' => "1",
                'extraDate' => $_POST['date'],
                'extra1' => "",
                'extra2' => "",
                'currecyConversionId' => "1",
                'companyId' => $this->sessiondata['companyid']
            );
            $insertstatus = $this->db->insert('partybalance', $data);
            return $insertstatus;
        }
    }

    public function updateSalesMaster($SalesMasterid) {
        $ledgerId = $this->input->post('ledgerId');
        $query = $this->db->select_sum('debit')->select_sum('credit')->where('ledgerId', $ledgerId)->where('voucherNo', $SalesMasterid)->where('voucherType', 'Sales Invoice')->get('partybalance');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = (int) $row->debit;
            $credit = (int) $row->credit;
            if ($debit > $credit) {
                $data = array(
                    'status' => "2"
                );
                $this->db->where('salesMasterId', $SalesMasterid);
                $this->db->update('salesmaster', $data);
            }
            if ($credit == $debit) {
                $data = array(
                    'status' => "1"
                );
                $this->db->where('salesMasterId', $SalesMasterid);
                $this->db->update('salesmaster', $data);
            }
        }
        return false;
    }

    public function paidtoname() {
        $ledgerid = $this->input->post('ledgerid');
        $this->db->select('*');
        $this->db->from('accountledger');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerId !=', $ledgerid);
        $query = $this->db->get();
        return $query->result();
    }

    public function editpaidtoname($id) {
        $this->db->select('*');
        $this->db->from('receiptdetails');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('receiptMasterId', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function ledgerdata() {
        $this->db->select('*');
        $this->db->from('accountledger');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getledgerbycash() {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("Select * from accountledger where (companyId='$cmpid' and accountGroupId='11')");
        return $query->result();
    }

    public function sortalldata() {
        $this->db->select('*');
        $this->db->order_by("receiptDetailsId", "desc");
        $this->db->from('receiptdetails');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function alldata($id) {
        $this->db->select('*');
        $this->db->from('receiptmaster');
        $this->db->where('receiptMasterId', $id);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getledger() {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("Select * from accountledger where (companyId='$cmpid' and accountGroupId='9')or(companyId='$cmpid' and accountGroupId='23')");
        return $query->result();
    }

    public function paidto() {
        $this->db->select('*');
        $this->db->from('accountledger');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('accountGroupId', "9");
        $query = $this->db->get();
        return $query->result();
    }

    public function countrylist() {
        $this->db->select('*');
        $this->db->from('countries');
        $query = $this->db->get();
        return $query->result();
    }

    public function salesinfo() {
        $ledgerId = $this->input->post('ledgerid');
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("Select * from salesmaster where companyId='$cmpid' AND (ledgerId='$ledgerId' AND status='2') or (ledgerId='$ledgerId' AND status='3')");
        return $query->result();
    }

    public function editsalesinfo($id) {
        $this->db->select('*');
        $this->db->from('salesmaster');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerId', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function partpaid($pid) {
        $ledgerId = $this->input->post('ledgerid');
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `partybalance` where ledgerId='$ledgerId' and companyId='$cmpid' AND (voucherType='Sales Invoice'AND voucherNo='$pid')");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = $row->debit;
            $credit = $row->credit;
            $total = $debit - $credit;
            return $total;
        }
        return false;
    }

    public function editpartpaid($pid, $id) {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `partybalance` where ledgerId='$id' AND companyId='$cmpid' AND (voucherType='Sales Invoice'AND voucherNo='$pid')");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = $row->debit;
            $credit = $row->credit;
            $total = $debit - $credit;
            return $total;
        }
        return false;
    }

    public function partydata() {
        $ledgerId = $this->input->post('ledgerid');
        $this->db->select('*');
        $this->db->from('partybalance');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerId', $ledgerId);
        $query = $this->db->get();
        return $query->result();
    }

    public function getpartydata($id, $paidledger) {
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("Select referenceType from partybalance where ledgerId='$paidledger' AND companyId='$companyId' AND (againstvoucherNo='$id'AND againstVoucherType='Receipt Voucher') or (voucherType='Receipt Voucher'AND voucherNo='$id')");
        return $query->row()->referenceType;
    }

    public function getallpartybalance($receiptMasterId, $id) {
        $ref = $this->input->post('ref');
        $cmpid = $this->sessiondata['companyid'];
        if ($ref == "Against") {
            $query = $this->db->query("select * from partybalance where(againstvoucherNo='$receiptMasterId' AND againstVoucherType='Receipt Voucher' AND ledgerId= '$id' AND companyId='$cmpid')");
            return $query->row()->voucherNo;
        } if ($ref == "New") {
            return FALSE;
        }
    }

    public function invoicedata($pid) {
        $this->db->select('*');
        $this->db->from('salesmaster');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('salesMasterId', $pid);
        $query = $this->db->get();
        return $query->result();
    }

    public function updatereceiptdetails() {
        $receiptMasterId = $this->input->post('receiptMasterId');
        $ledgerId = $this->input->post('ledgerId');
        $data = array(
            'ledgerId' => $ledgerId,
            'receiptNo' => $_POST['receiptNo'],
            'amount' => $_POST['amount'],
            'chequeNumber' => $_POST['chequeNumber'],
            'chequeDate' => $_POST['chequeDate']
        );
        //print_r($data);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('receiptMasterId', $receiptMasterId);
        $saveresultRDetail = $this->db->update('receiptdetails', $data);
        $datafoRmaster = array(
            'ledgerId' => $ledgerId = $this->input->post('receiptMode'),
            'date' => $_POST['date'],
            'description' => $_POST['description']
        );
        //print_r($datafoRmaster);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('receiptMasterId', $receiptMasterId);
        $saveresultRMaster = $this->db->update('receiptmaster', $datafoRmaster);
        if ($saveresultRDetail && $saveresultRMaster) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Update ReciptVoucher", "Receipt Voucher No " . $receiptMasterId . " Updated");
            return true;
        } else {
            return FALSE;
        }
    }

    public function updatereceiptmaster() {
        $receiptMasterId = $this->input->post('receiptMasterId');
        $ledgerId = $this->input->post('receiptMode');
        $date = $this->input->post('date');
        $description = $this->input->post('description');
        $paymentMode = $this->input->post('optionsRadios');
        $data = array(
            'ledgerId' => $ledgerId,
            'date' => $date,
            'description' => $description,
            'receiptMode' => $paymentMode
        );
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('receiptMasterId', $receiptMasterId);
        $query = $this->db->update('receiptmaster', $data);
        if ($query) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Update ReciptVoucher", "Receipt Voucher No " . $receiptMasterId . " Updated");
            return $query;
        }
    }

    public function updateledgerposting1($firstid) {
        $ledgerId = $this->input->post('receiptMode');
        $date = $this->input->post('date');
        //$receiptMasterId = $this->input->post('receiptMasterId');
        $amount = $this->input->post('amount');
        $data = array(
            'ledgerId' => $ledgerId,
            'credit' => "0.00",
            'date' => $date,
            'debit' => $amount
        );
        //print_r($data);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerPostingId', $firstid);
        $query = $this->db->update('ledgerposting', $data);
        return $query;
    }

    public function updateledgerposting2($secondid) {
        $ledgerId = $this->input->post('ledgerId');
        $date = $this->input->post('date');
        //$receiptMasterId = $this->input->post('receiptMasterId');
        $amount = $this->input->post('amount');
        $data = array(
            'ledgerId' => $ledgerId,
            'debit' => "0.00",
            'date' => $date,
            'credit' => $amount
        );
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerPostingId', $secondid);
        $query = $this->db->update('ledgerposting', $data);
        return $query;
    }

    public function updatepartybalance() {
        $paidledger = $this->input->post('ledgerId');
        $companyId = $this->sessiondata['companyid'];
        $receiptMasterId = $this->input->post('receiptMasterId');
        $amount = $this->input->post('amount');
        $query = $this->db->query("Update partybalance set credit=$amount where ledgerId='$paidledger' AND companyId='$companyId' AND (againstvoucherNo='$receiptMasterId'AND againstVoucherType='Receipt Voucher') or (voucherType='Receipt Voucher'AND voucherNo='$receiptMasterId')");
        return $query;
    }

    public function deletereceiptmaster($id) {
        ccflogdata($this->sessiondata['username'], "accesslog", "Delete ReceiptVoucher", "Receipt Voucher No " . $id . " Deleted");
        $this->db->where('receiptMasterId', $id);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->delete('receiptmaster');
        return $query;
    }

    public function deletereceiptdetails($id) {
        $this->db->where('receiptMasterId', $id);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->delete('receiptdetails');
        return $query;
    }

    public function deleteladgerposting($id) {
        $this->db->where('voucherNumber', $id);
        $this->db->where('voucherType', 'Receipt Voucher');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->delete('ledgerposting');
        return $query;
    }

    public function deletepartybalance($id, $paidledger) {
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("Delete from partybalance where ledgerId='$paidledger' AND companyId='$companyId' AND (againstvoucherNo='$id' AND againstVoucherType='Receipt Voucher') or (voucherType='Receipt Voucher'AND voucherNo='$id')");
        return $query;
    }

    public function currentbalance($paidid) {
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `ledgerposting` where  companyId='$companyId' AND ledgerId='$paidid'");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = $row->debit;
            $credit = $row->credit;
            if ($credit > $debit) {
                $total = number_format($credit - $debit, 2);
                return $total . ' Cr';
            }
            if ($credit < $debit) {
                $total = number_format($debit - $credit, 2);
                return $total . ' Dr';
            }
        }
        return false;
    }

    public function GetBusinessName() {
        $ledgerid = $this->input->post('ledgerId');
        $query = $this->db->query("Select * from accountledger where ledgerId='$ledgerid'");
        $nameofbusiness = $query->row()->nameOfBusiness;
        echo $nameofbusiness;
    }

}
