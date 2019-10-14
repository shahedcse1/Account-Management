<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Balancesheet extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' && $this->sessiondata['userrole'] != 'u' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Balance Sheet";
            $data['active_menu'] = "account_statement";
            $data['active_sub_menu'] = "balance_sheet";
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
            $initialdate = "2000-01-01 00:00:00";

            //2 For Liabilities
            $liabilityid = 2;
            $accountgrpIdQr = $this->db->query("SELECT accountGroupId FROM accountgroup WHERE groupUnder = '$liabilityid' AND companyId = '$company_id'");
            $idResult = $accountgrpIdQr->result();
            $IdSet = $liabilityid;
            $idset1st = "";
            if (sizeof($idResult) > 0):
                foreach ($idResult as $acntgrpdata):
                    $IdSet = $IdSet . "," . $acntgrpdata->accountGroupId;
                    if ($idset1st == ""):
                        $idset1st = $acntgrpdata->accountGroupId;
                    else:
                        $idset1st = $idset1st . "," . $acntgrpdata->accountGroupId;
                    endif;
                endforeach;
                $accountgrpIdQr2nd = $this->db->query("SELECT accountGroupId FROM accountgroup WHERE groupUnder IN($idset1st) AND companyId = '$company_id'");
                $idResult2nd = $accountgrpIdQr2nd->result();
                if (sizeof($idResult2nd) > 0):
                    foreach ($idResult2nd as $acntgrpdata):
                        $IdSet = $IdSet . "," . $acntgrpdata->accountGroupId;
                    endforeach;
                endif;
            endif;
            $liabilityQr = $this->db->query("SELECT SUM(lp.credit - lp.debit) as balance, ag.accountGroupName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE ag.groupUnder IN($IdSet) AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' AND (lp.date BETWEEN '$initialdate' AND '$date_to') GROUP BY ag.accountGroupName");
            $data['liabilitycondenseddata'] = $liabilityQr->result();
            $liabilitydetQr = $this->db->query("SELECT SUM(lp.credit - lp.debit) as balance, ag.accountGroupName, al.acccountLedgerName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE ag.groupUnder IN($IdSet) AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' AND (lp.date BETWEEN '$initialdate' AND '$date_to') GROUP BY al.acccountLedgerName");
            $data['liabilitydetaildata'] = $liabilitydetQr->result();



            //3 For Asset
            $assetid = 3;
            $accountgrpIdQr = $this->db->query("SELECT accountGroupId FROM accountgroup WHERE groupUnder = '$assetid' AND companyId = '$company_id'");
            $idResult = $accountgrpIdQr->result();
            $IdSet = $assetid;
            $idset1st = "";
            if (sizeof($idResult) > 0):
                foreach ($idResult as $acntgrpdata):
                    $IdSet = $IdSet . "," . $acntgrpdata->accountGroupId;
                    if ($idset1st == ""):
                        $idset1st = $acntgrpdata->accountGroupId;
                    else:
                        $idset1st = $idset1st . "," . $acntgrpdata->accountGroupId;
                    endif;
                endforeach;
                $accountgrpIdQr2nd = $this->db->query("SELECT accountGroupId FROM accountgroup WHERE groupUnder IN($idset1st) AND companyId = '$company_id'");
                $idResult2nd = $accountgrpIdQr2nd->result();
                if (sizeof($idResult2nd) > 0):
                    foreach ($idResult2nd as $acntgrpdata):
                        $IdSet = $IdSet . "," . $acntgrpdata->accountGroupId;
                    endforeach;
                endif;
            endif;
            $assetQr = $this->db->query("SELECT SUM(lp.debit - lp.credit) as balance, ag.accountGroupName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE ag.groupUnder IN($IdSet) AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' AND (lp.date BETWEEN '$initialdate' AND '$date_to') GROUP BY ag.accountGroupName");
            $data['assetcondenseddata'] = $assetQr->result();
            $liabilitydetQr = $this->db->query("SELECT SUM(lp.debit - lp.credit) as balance, ag.accountGroupName, al.acccountLedgerName FROM ledgerposting lp JOIN accountledger al ON lp.ledgerId = al.ledgerId JOIN accountgroup ag ON ag.accountGroupId = al.accountGroupId WHERE ag.groupUnder IN($IdSet) AND lp.companyId = '$company_id' AND al.companyId = '$company_id' AND ag.companyId = '$company_id' AND (lp.date BETWEEN '$initialdate' AND '$date_to') GROUP BY al.acccountLedgerName");
            $data['assetdetaildata'] = $liabilitydetQr->result();

            //Closing stock calculation
            ###$closingstockQr = $this->db->query("SELECT (SUM(S.inwardQuantity) - SUM(S.outwardQuantity))* B.purchaseRate AS ClosingStock	FROM product AS P INNER JOIN productbatch AS B ON P.productId = B.productId INNER JOIN productgroup AS G ON P.productGroupId = G.productGroupId LEFT OUTER JOIN stockposting AS S ON B.productBatchId = S.productBatchId AND (S.date BETWEEN '$initialdate' AND  '$date_to') AND (S.companyId = '$company_id' AND B.companyId = '$company_id' AND P.companyId = '$company_id') GROUP BY B.productId, P.productName,B.purchaseRate");
//            $closingstockQr = $this->db->query("SELECT (SUM(inwardQuantity) - SUM(outwardQuantity))* rate as ClosingStock FROM stockposting WHERE (date BETWEEN '$initialdate' AND  '$date_to') AND (companyId = '$company_id') GROUP BY productBatchId");
//            $closingstockResult = $closingstockQr->result();
//            $closingstockvalue = 0;
//            if (sizeof($closingstockResult) > 0):
//                foreach ($closingstockResult as $closingdata):
//                    $closingstockvalue += $closingdata->ClosingStock;
//                endforeach;
//            endif;
//            $data['closingstockvalue'] = $closingstockvalue;
            //Net profit Calculation      
            $openingstockQr = $this->db->query("SELECT (SUM(S1.inwardQuantity) - SUM(S1.outwardQuantity))* B1.purchaseRate AS OpeningStock FROM productbatch B1 INNER JOIN product ON B1.productId = product.productId LEFT OUTER JOIN stockposting S1 ON B1.productBatchId = S1.productBatchId WHERE (S1.date < '$date_from') AND (S1.companyId = '$company_id' AND B1.companyId = '$company_id' AND product.companyId = '$company_id') GROUP BY B1.purchaseRate");
            $openingstockResult = $openingstockQr->result();
            $openingstockvalue = 0;
            if (sizeof($openingstockResult) > 0):
                foreach ($openingstockResult as $openingdata):
                    $openingstockvalue += $openingdata->OpeningStock;
                endforeach;
            endif;

###################################################################

            $goodssoldQr = $this->db->query("SELECT SUM(sal.purchaserate * sal.qty) AS totalpurchase FROM salesdetails sal JOIN salesmaster sm ON sm.salesMasterId = sal.salesMasterId WHERE (sm.date BETWEEN '$initialdate' AND  '$date_to') AND (sal.companyId = '$company_id') AND (sm.companyId = '$company_id')");
            $goodsoldcost = $goodssoldQr->row()->totalpurchase;

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


            $totalsalesaccount = $this->profitlossCalc(26, $initialdate, $date_to);
            $grossprofit = $totalsalesaccount - $goodsoldcost;
            //Direct expense details array
            $directexpensedetails = $this->profitlossResult(16, $initialdate, $date_to);
            //Direct income details array
            $directincomedetails = $this->profitlossResult(17, $initialdate, $date_to);
            //Direct expense details array
            $indirectexpensedetails = $this->profitlossResult(20, $initialdate, $date_to);
            //Direct income details array
            $indirectincomedetails = $this->profitlossResult(21, $initialdate, $date_to);

            if (sizeof($directexpensedetails) > 0):
                foreach ($directexpensedetails as $dexpenserow):
                    $grossprofit -= abs($dexpenserow->purchasevalue);
                endforeach;
            endif;

            if ((sizeof($directincomedetails))):
                foreach ($directincomedetails as $dincomerow):
                    $grossprofit += abs($dincomerow->purchasevalue);
                endforeach;
            endif;

            $totalinexp = 0;
            if (sizeof($indirectexpensedetails) > 0):
                foreach ($indirectexpensedetails as $iexpenserow):
                    $totalinexp += abs($iexpenserow->purchasevalue);
                endforeach;
            endif;

            $totalinincome = 0;
            if (sizeof($indirectincomedetails) > 0):
                foreach ($indirectincomedetails as $iincomerow):
                    $totalinincome += abs($iincomerow->purchasevalue);
                endforeach;
            endif;

            $operatingincome = $grossprofit - $totalinexp;
            $netincome = $operatingincome + $totalinincome;
            $data['netprofit'] = $netincome;

###################################################################
            $data['openingstockvalue'] = $openingstockvalue;
            //Purchase account
            $data['totalpurchase'] = $this->profitlossCalc(25, $initialdate, $date_to);
            //Sales Account
            $data['totalsalesaccount'] = $this->profitlossCalc(26, $initialdate, $date_to);
            //Direct Expense
            $data['totaldirectexpense'] = $this->profitlossCalc(16, $initialdate, $date_to);
            //Direct Income
            $data['totaldirectincome'] = $this->profitlossCalc(17, $initialdate, $date_to);
            //InDirect Expense
            $data['totalindirectexpense'] = $this->profitlossCalc(20, $initialdate, $date_to);
            //Direct Income
            $data['totalindirectincome'] = $this->profitlossCalc(21, $initialdate, $date_to);

            $data['grossprofitcd'] = ($closingstockvalue + $data['totalsalesaccount'] + $data['totaldirectincome']) - ($openingstockvalue + $data['totalpurchase'] + $data['totaldirectexpense']);
//            $data['netprofit'] = $data['grossprofitcd'] + $data['totalindirectincome'] - $data['totalindirectexpense'];
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
            $this->load->view('balancesheet/balancesheet', $data);
            $this->load->view('footer', $data);
            $this->load->view('balancesheet/br_script', $data);
        else:
            redirect('login');
        endif;
    }

####################################################################################################

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
        $purchaseAntQr = $this->db->query("SELECT B.acccountLedgerName as acntLName, SUM(C.credit)- SUM(C.debit) AS purchasevalue FROM accountledger AS B INNER JOIN accountgroup AS A ON B.accountGroupId = A.accountGroupId LEFT OUTER JOIN ledgerposting AS C ON B.ledgerId = C.ledgerId AND (C.date BETWEEN '$date_from' AND '$date_to') WHERE A.companyId = '$company_id' AND B.companyId = '$company_id' AND C.companyId = '$company_id' AND A.accountGroupId IN ($IdSet)  group by B.acccountLedgerName");
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
        $purchaseAntQr = $this->db->query("SELECT A.accountGroupId AS ID, A.accountGroupName AS Name, SUM(C.credit)- SUM(C.debit) AS purchasevalue FROM accountledger AS B INNER JOIN accountgroup AS A ON B.accountGroupId = A.accountGroupId LEFT OUTER JOIN ledgerposting AS C ON B.ledgerId = C.ledgerId AND (C.date BETWEEN '$date_from' AND '$date_to') WHERE A.companyId = '$company_id' AND B.companyId = '$company_id' AND C.companyId = '$company_id'  AND A.accountGroupId IN ($IdSet)  group by A.accountGroupId ,A.accountGroupName");
        $purchaseAntRslt = $purchaseAntQr->result();
        if (sizeof($purchaseAntRslt) > 0):
            foreach ($purchaseAntRslt as $purchasedata):
                $totalpurchase += $purchasedata->purchasevalue;
            endforeach;
        endif;
        return $totalpurchase;
    }

##################################################################################################
// old profitlosscalc
//    public function profitlossCalc($grpunderId, $date_from, $date_to) {
//        $company_data = $this->session->userdata('logindata');
//        $company_id = $company_data['companyid'];
//        $acntgrpIdQr = $this->db->query("select DISTINCT(accountGroupId) FROM accountgroup WHERE groupUnder = '$grpunderId' AND companyId = '$company_id'");
//        $acntgrpIdResult = $acntgrpIdQr->result();
//        $IdSet = $grpunderId;
//        if (sizeof($acntgrpIdResult) > 0):
//            foreach ($acntgrpIdResult as $acntgrpdata):
//                if ($grpunderId != $acntgrpdata->accountGroupId):
//                    $IdSet = $IdSet . "," . $acntgrpdata->accountGroupId;
//                endif;
//            endforeach;
//        endif;
//        $totalpurchase = 0;
//        $purchaseAntQr = $this->db->query("SELECT A.accountGroupId AS ID, A.accountGroupName AS Name, SUM(C.debit)- SUM(C.credit) AS purchasevalue FROM accountledger AS B INNER JOIN accountgroup AS A ON B.accountGroupId = A.accountGroupId LEFT OUTER JOIN ledgerposting AS C ON B.ledgerId = C.ledgerId AND (C.date BETWEEN '$date_from' AND '$date_to') WHERE A.companyId = '$company_id' AND B.companyId = '$company_id' AND C.companyId = '$company_id'  AND A.accountGroupId IN ($IdSet)  group by A.accountGroupId ,A.accountGroupName");
//        $purchaseAntRslt = $purchaseAntQr->result();
//        if (sizeof($purchaseAntRslt) > 0):
//            foreach ($purchaseAntRslt as $purchasedata):
//                $totalpurchase += $purchasedata->purchasevalue;
//            endforeach;
//        endif;
//        $firstletter = substr($totalpurchase, 0, 1);
//        if ($firstletter == "-"):
//            $totalpurchase = substr($totalpurchase, 1);
//            $totalpurchase = $totalpurchase . "Cr";
//        elseif ($totalpurchase == 0):
//            $totalpurchase = $totalpurchase;
//        else:
//            $totalpurchase = $totalpurchase . "Dr";
//        endif;
//        return $totalpurchase;
//    }
}

?>