<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profitlossanalysis extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Profit And Loss Analysis";
            $data['active_menu'] = "account_statement";
            $data['active_sub_menu'] = "profit_loss";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";

            //$strtotime_today = strtotime($date_from);
            //$previous_dateadd = strtotime("-1 day", $strtotime_today);
            //$previous_date = date('Y-m-d', $previous_dateadd);
            //$opening_date_to = $date_from;
            //$opening_date_from = $previous_date;
            //$date_from = substr($date_from, 0, 10);
            //$date_to = substr($date_to, 0, 10);
            //Opening stock calculation
            ###$openingstockQr = $this->db->query("SELECT (SUM(S1.inwardQuantity) - SUM(S1.outwardQuantity))* B1.purchaseRate AS OpeningStock FROM productbatch B1 INNER JOIN product ON B1.productId = product.productId LEFT OUTER JOIN stockposting S1 ON B1.productBatchId = S1.productBatchId WHERE (S1.date < '$date_from') AND (S1.companyId = '$company_id' AND B1.companyId = '$company_id' AND product.companyId = '$company_id') GROUP BY B1.purchaseRate");
            $openingstockQr = $this->db->query("SELECT (SUM(inwardQuantity) - SUM(outwardQuantity))* rate as OpeningStock FROM stockposting WHERE (date < '$date_from') AND (companyId = '$company_id') GROUP BY serialNumber");
            $openingstockResult = $openingstockQr->result();
            $openingstockvalue = 0;
            if (sizeof($openingstockResult) > 0):
                foreach ($openingstockResult as $openingdata):
                    $openingstockvalue += $openingdata->OpeningStock;
                endforeach;
            endif;
            $data['openingstockvalue'] = $openingstockvalue;

            //Closing stock calculation
            $initialdate = "2000-01-01 00:00:00";
            ###$closingstockQr = $this->db->query("SELECT (SUM(S.inwardQuantity) - SUM(S.outwardQuantity))* B.purchaseRate AS ClosingStock	FROM product AS P INNER JOIN productbatch AS B ON P.productId = B.productId INNER JOIN productgroup AS G ON P.productGroupId = G.productGroupId LEFT OUTER JOIN stockposting AS S ON B.productBatchId = S.productBatchId AND (S.date BETWEEN '$initialdate' AND  '$date_to') AND (S.companyId = '$company_id' AND B.companyId = '$company_id' AND P.companyId = '$company_id') GROUP BY B.productId, P.productName,B.purchaseRate");
            $closingstockQr = $this->db->query("SELECT SUM(inwardQuantity - outwardQuantity) AS closingqty,productBatchId, rate FROM stockposting WHERE (date BETWEEN '$initialdate' AND  '$date_to') AND (companyId = '$company_id') GROUP BY productBatchId");
            $closingstockResult = $closingstockQr->result();
            $closingstockvalue = 0;
            if (sizeof($closingstockResult) > 0):
                foreach ($closingstockResult as $closingdata):
                    if ($closingdata->productBatchId != '' || $closingdata->productBatchId != NULL):
                        $getSerialQr = $this->db->query("SELECT MAX(serialNumber) AS slno FROM stockposting WHERE productBatchId = '$closingdata->productBatchId' AND (voucherType = 'Purchase Invoice' || voucherType = 'Stock Entry')");
                        if ($getSerialQr->num_rows() > 0):
                            $slno = $getSerialQr->row()->slno;
                            $getrateQr = $this->db->query("SELECT rate FROM stockposting WHERE serialNumber = '$slno'");
                            if ($getrateQr->num_rows() > 0):
                                $rateval = $getrateQr->row()->rate;
                            else:
                                $rateval = $closingdata->rate;
                            endif;
                        else:
                            $rateval = $closingdata->rate;
                        endif;
                    else:
                        $rateval = $closingdata->rate;
                    endif;
                    $closingstockvalue += $closingdata->closingqty * $rateval;
                endforeach;
            endif;
            $data['closingstockvalue'] = $closingstockvalue;

            //Purchase account
            $data['totalpurchase'] = $this->profitlossCalc(25, $date_from, $date_to);
            //Sales Account
            $data['totalsalesaccount'] = $this->profitlossCalc(26, $date_from, $date_to);
            //Direct Expense
            $data['totaldirectexpense'] = $this->profitlossCalc(16, $date_from, $date_to);
            //Direct Income
            $data['totaldirectincome'] = $this->profitlossCalc(17, $date_from, $date_to);
            //InDirect Expense
            $data['totalindirectexpense'] = $this->profitlossCalc(20, $date_from, $date_to);
            //Direct Income
            $data['totalindirectincome'] = $this->profitlossCalc(21, $date_from, $date_to);

            $data['grossprofitcd'] = ($closingstockvalue + $data['totalsalesaccount'] + $data['totaldirectincome']) - ($openingstockvalue + $data['totalpurchase'] + $data['totaldirectexpense']);

            //Purchase account details
            $data['purchasedetails'] = $this->profitlossResult(25, $date_from, $date_to);
            //Sales account details
            $data['salesdetails'] = $this->profitlossResult(26, $date_from, $date_to);
            //Direct expense details
            $data['directexpensedetails'] = $this->profitlossResult(16, $date_from, $date_to);
            //Direct income details
            $data['directincomedetails'] = $this->profitlossResult(17, $date_from, $date_to);
            //Direct expense details
            $data['indirectexpensedetails'] = $this->profitlossResult(20, $date_from, $date_to);
            //Direct income details
            $data['indirectincomedetails'] = $this->profitlossResult(21, $date_from, $date_to);
            ##take data for print##
            $companyQr = $this->db->query("SELECT companyName, address, email FROM company WHERE companyId = '$company_id'");
            if ($companyQr->num_rows() > 0):
                $data['comname'] = $companyQr->row()->companyName;
                $data['comaddress'] = $companyQr->row()->address;
                $data['comemail'] = $companyQr->row()->email;
            else:
                $data['comname'] = "";
                $data['comaddress'] = "";
                $data['comemail'] = "";
            endif;
            ##take data for print##
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('profitloss/profit_loss2', $data);
            $this->load->view('footer', $data);
            $this->load->view('profitloss/pl_script', $data);
        else:
            redirect('login');
        endif;
    }

    public function profitlossResult($grpunderId, $date_from, $date_to) {
        $company_data = $this->session->userdata('logindata');
        $company_id = $company_data['companyid'];
        $acntgrpIdQr = $this->db->query("select DISTINCT(accountGroupId) FROM accountgroup WHERE groupUnder = '$grpunderId' AND companyId = '$company_id'");
        $acntgrpIdResult = $acntgrpIdQr->result();
        $IdSet = $grpunderId;
        if (sizeof($acntgrpIdResult) > 0):
            foreach ($acntgrpIdResult as $acntgrpdata):
                if ($grpunderId != $acntgrpdata->accountGroupId):
                    $IdSet = $IdSet . "," . $acntgrpdata->accountGroupId;
                endif;
            endforeach;
        endif;
        $purchaseAntQr = $this->db->query("SELECT B.acccountLedgerName as acntLName, SUM(C.debit)- SUM(C.credit) AS purchasevalue FROM accountledger AS B INNER JOIN accountgroup AS A ON B.accountGroupId = A.accountGroupId LEFT OUTER JOIN ledgerposting AS C ON B.ledgerId = C.ledgerId AND (C.date BETWEEN '$date_from' AND '$date_to') WHERE A.companyId = '$company_id' AND B.companyId = '$company_id' AND C.companyId = '$company_id' AND A.accountGroupId IN ($IdSet)  group by B.acccountLedgerName");
        $purchaseAntRslt = $purchaseAntQr->result();
        return $purchaseAntRslt;
    }

    public function profitlossCalc($grpunderId, $date_from, $date_to) {
        $company_data = $this->session->userdata('logindata');
        $company_id = $company_data['companyid'];
        $acntgrpIdQr = $this->db->query("select DISTINCT(accountGroupId) FROM accountgroup WHERE groupUnder = '$grpunderId' AND companyId = '$company_id'");
        $acntgrpIdResult = $acntgrpIdQr->result();
        $IdSet = $grpunderId;
        if (sizeof($acntgrpIdResult) > 0):
            foreach ($acntgrpIdResult as $acntgrpdata):
                if ($grpunderId != $acntgrpdata->accountGroupId):
                    $IdSet = $IdSet . "," . $acntgrpdata->accountGroupId;
                endif;
            endforeach;
        endif;
        $totalpurchase = 0;
        $purchaseAntQr = $this->db->query("SELECT A.accountGroupId AS ID, A.accountGroupName AS Name, SUM(C.debit)- SUM(C.credit) AS purchasevalue FROM accountledger AS B INNER JOIN accountgroup AS A ON B.accountGroupId = A.accountGroupId LEFT OUTER JOIN ledgerposting AS C ON B.ledgerId = C.ledgerId AND (C.date BETWEEN '$date_from' AND '$date_to') WHERE A.companyId = '$company_id' AND B.companyId = '$company_id' AND C.companyId = '$company_id'  AND A.accountGroupId IN ($IdSet)  group by A.accountGroupId ,A.accountGroupName");
        $purchaseAntRslt = $purchaseAntQr->result();
        if (sizeof($purchaseAntRslt) > 0):
            foreach ($purchaseAntRslt as $purchasedata):
                $totalpurchase += $purchasedata->purchasevalue;
            endforeach;
        endif;
        $firstletter = substr($totalpurchase, 0, 1);
        if ($firstletter == "-"):
            $totalpurchase = substr($totalpurchase, 1);
            $totalpurchase = $totalpurchase . " Cr";
        elseif ($totalpurchase == 0):
            $totalpurchase = $totalpurchase;
        else:
            $totalpurchase = $totalpurchase . " Dr";
        endif;
        return $totalpurchase;
    }

}

?>