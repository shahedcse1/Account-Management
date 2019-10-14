<?php

class Ccfpaymentvou extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function addpayment($data) {
        $insertstatus = $this->db->insert('paymentmaster', $data);
        $query = $this->db->query("Select MAX(paymentMasterId) from paymentmaster");
        $result = $query->row_array();
        $paymentMasterId = $result['MAX(paymentMasterId)'];
        if ($insertstatus) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Add PaymentVoucher", "Payment Voucher No $paymentMasterId Added");
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

    public function adddpaymentetails($payid) {
        $data = array(
            'paymentMasterId ' => $payid,
            'ledgerId' => $_POST['ledgerId'],
            'voucherNumber' => "",
            'voucherType' => "",
            'amount' => $_POST['amount'],
            'chequeNumber' => $_POST['chequeNumber'],
            'chequeDate' => $_POST['chequeDate'],
            'description' => $_POST['description'],
            'companyId' => $this->sessiondata['companyid']
        );
        $insertstatus = $this->db->insert('paymentdetails', $data);
        return $insertstatus;
    }

    public function addledgerposting1($payid) {
        $data = array(
            'date' => $_POST['date'],
            'ledgerId' => $_POST['paymentMode'],
            'voucherNumber' => $payid,
            'voucherType' => "Payment Voucher",
            'debit' => "0.00",
            'credit' => $_POST['amount'],
            'description' => "By Payment",
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
            'voucherType' => "Payment Voucher",
            'debit' => $_POST['amount'],
            'credit' => "0.00",
            'description' => "By Payment",
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
                'voucherType' => "Purchase Invoice",
                'againstVoucherType' => "Payment Voucher",
                'againstvoucherNo' => $payid,
                'referenceType' => $_POST['referenceType'],
                'debit' => $_POST['amount'],
                'credit' => "0.00",
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
                'voucherType' => "Payment Voucher",
                'againstVoucherType' => "NA",
                'againstvoucherNo' => "NA",
                'referenceType' => $_POST['referenceType'],
                'debit' => $_POST['amount'],
                'credit' => "0.00",
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

    public function updatePurchaseMaster($purchaseid) {
        $ledgerId = $this->input->post('ledgerId');
        $query = $this->db->select_sum('debit')->select_sum('credit')->where('ledgerId', $ledgerId)->where('voucherNo', $purchaseid)->get('partybalance');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = (int) $row->debit;
            $credit = (int) $row->credit;
            if ($credit > $debit) {
                $data = array(
                    'invoiceStatusId' => "2"
                );
                $this->db->where('purchaseMasterId', $purchaseid);
                $this->db->update('purchasemaster', $data);
            }
            if ($credit == $debit) {
                $data = array(
                    'invoiceStatusId' => "1"
                );
                $this->db->where('purchaseMasterId', $purchaseid);
                $this->db->update('purchasemaster', $data);
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
        $this->db->from('paymentdetails');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('paymentMasterId', $id);
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

    public function ledgerName($ledgerId) {
        $this->db->select('acccountLedgerName');
        $this->db->from('accountledger');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerId', $ledgerId);
        $query = $this->db->get();
        //return $query->row()->nameOfBusiness;
        echo $query->row()->acccountLedgerName;
    }

    public function sortalldata() {
        $this->db->select('*');
        $this->db->order_by("paymentDetailsId", "desc");
        $this->db->from('paymentdetails');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function alldata($id) {
        $this->db->select('*');
        $this->db->from('paymentmaster');
        $this->db->where('paymentMasterId', $id);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getledger() {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("Select * from accountledger where (companyId='$cmpid' and accountGroupId='9')or(companyId='$cmpid' and accountGroupId='23')");
        return $query->result();
    }

    public function getledgerbycash() {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("Select * from accountledger where (companyId='$cmpid' and accountGroupId='11')");
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

    public function purchaseinfo() {
        $ledgerId = $this->input->post('ledgerid');
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("Select * from purchasemaster where companyId='$cmpid' AND (ledgerId='$ledgerId' AND invoiceStatusId='2') or (ledgerId='$ledgerId' AND invoiceStatusId='3')");
        return $query->result();
    }

    public function editpurchaseinfo($id) {
        $this->db->select('*');
        $this->db->from('purchasemaster');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerId', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function partpaid($pid) {
        $ledgerId = $this->input->post('ledgerid');
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `partybalance` where ledgerId='$ledgerId' AND companyId='$cmpid' AND (voucherType='Purchase Invoice'AND voucherNo='$pid')");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = $row->debit;
            $credit = $row->credit;
            $total = $credit - $debit;
            return $total;
        }
        return false;
    }

    public function editpartpaid($pid, $id) {
        $cmpid = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `partybalance` where ledgerId='$id' AND companyId='$cmpid' AND (voucherType='Purchase Invoice'AND voucherNo='$pid')");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = $row->debit;
            $credit = $row->credit;
            $total = $credit - $debit;
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
        $query = $this->db->query("Select referenceType from partybalance where ledgerId='$paidledger' AND companyId='$companyId' AND (againstvoucherNo='$id'AND againstVoucherType='Payment Voucher') or (voucherType='Payment Voucher'AND voucherNo='$id')");
        return $query->row()->referenceType;
    }

    public function getallpartybalance($paymsid, $id) {
        $ref = $this->input->post('ref');
        if ($ref == "Against") {
            $this->db->select('*');
            $this->db->from('partybalance');
            $this->db->where('againstvoucherNo', $paymsid);
            $this->db->where('againstVoucherType', 'Payment Voucher');
            $this->db->where('ledgerId', $id);
            $this->db->where('companyId', $this->sessiondata['companyid']);
            $query = $this->db->get();
            return $query->row()->voucherNo;
        } if ($ref == "New") {
            return FALSE;
        }
    }

    public function invoicedata($pid) {
        $this->db->select('*');
        $this->db->from('purchasemaster');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('purchaseMasterId', $pid);
        $query = $this->db->get();
        return $query->result();
    }

    public function updatepaymentmaster() {
        $paymentMasterId = $this->input->post('paymentMasterId');
        $ledgerId = $this->input->post('paymentMode');
        $date = $this->input->post('date');
        $description = $this->input->post('description');
        $paymentMode = $this->input->post('optionsRadios');
        $data = array(
            'ledgerId' => $ledgerId,
            'date' => $date,
            'description' => $description,
            'paymentMode' => $paymentMode
        );
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('paymentMasterId', $paymentMasterId);
        $query = $this->db->update('paymentmaster', $data);
        if ($query) {
            ccflogdata($this->sessiondata['username'], "accesslog", "Update PaymentVoucher", "Payment Voucher No " . $paymentMasterId . " Updated");
            return $query;
        }
    }

    public function updatepaymentdetails() {
        $ledgerId = $this->input->post('ledgerId');
        $paymentMasterId = $this->input->post('paymentMasterId');
        $amount = $this->input->post('amount');
        $data = array(
            'ledgerId' => $ledgerId,
            'amount' => $amount,
            'chequeNumber' => $_POST['chequeNumber'],
            'chequeDate' => $_POST['chequeDate']
        );
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('paymentMasterId', $paymentMasterId);
        $query = $this->db->update('paymentdetails', $data);
        return $query;
    }

    public function updateledgerposting1($firstid) {
        $ledgerId = $this->input->post('paymentMode');
        $date = $this->input->post('date');
        $paymentMasterId = $this->input->post('paymentMasterId');
        $amount = $this->input->post('amount');
        $data = array(
            'ledgerId' => $ledgerId,
            'debit' => "0.00",
            'date' => $date,
            'credit' => $amount
        );
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerPostingId', $firstid);
        $query = $this->db->update('ledgerposting', $data);
        return $query;
    }

    public function updateledgerposting2($secondid) {
        $ledgerId = $this->input->post('ledgerId');
        $date = $this->input->post('date');
        $paymentMasterId = $this->input->post('paymentMasterId');
        $amount = $this->input->post('amount');
        $data = array(
            'ledgerId' => $ledgerId,
            'credit' => "0.00",
            'date' => $date,
            'debit' => $amount
        );
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $this->db->where('ledgerPostingId', $secondid);
        $query = $this->db->update('ledgerposting', $data);
        return $query;
    }

    public function updatepartybalance() {
        $paymentMasterId = $this->input->post('paymentMasterId');
        $paidledger = $this->input->post('ledgerId');
        $companyId = $this->sessiondata['companyid'];
        $amount = $this->input->post('amount');
        $query = $this->db->query("Update partybalance set debit=$amount where ledgerId='$paidledger' AND companyId='$companyId' AND (againstvoucherNo='$paymentMasterId'AND againstVoucherType='Payment Voucher') or (voucherType='Payment Voucher'AND voucherNo='$paymentMasterId')");
        return $query;
    }

    public function deletepaymentmaster($id) {
        ccflogdata($this->sessiondata['username'], "accesslog", "Delete PaymentVoucher", "Payment Voucher No " . $id . " Deleted");
        $this->db->where('paymentMasterId', $id);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->delete('paymentmaster');
        return $query;
    }

    public function deletepaymentdetails($id) {
        $this->db->where('paymentMasterId', $id);
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->delete('paymentdetails');
        return $query;
    }

    public function deleteladgerposting($id) {
        $this->db->where('voucherNumber', $id);
        $this->db->where('voucherType', 'Payment Voucher');
        $this->db->where('companyId', $this->sessiondata['companyid']);
        $query = $this->db->delete('ledgerposting');
        return $query;
    }

    public function deletepartybalance($id, $paidledger) {
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("Delete from partybalance where ledgerId='$paidledger' AND companyId='$companyId' AND (againstvoucherNo='$id'AND againstVoucherType='Payment Voucher') or (voucherType='Payment Voucher'AND voucherNo='$id')");
        return $query;
    }

    public function currentbalance($paidid) {
        $companyId = $this->sessiondata['companyid'];
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `ledgerposting` where companyId='$companyId' AND ledgerId='$paidid'");
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
