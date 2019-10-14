<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller
{
    private $sessiondata;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index()
    {
        $data['baseurl'] = $this->config->item('base_url');
        $getcompanylist = $this->load->model('company_y');
        $data['companylist'] = $this->company_y->getcomapnylist();
        $data['title'] = "Dashboard";
        $company_id = $this->sessiondata['companyid'];

        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && $this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 'r' || $this->sessiondata['userrole'] == 'u' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'f'):
            //calculate total farmer
            $totalFarmer = $this->db->query("select count(accountGroupId) as totalfarmer from accountledger where accountGroupId = '13'  AND status='1'");

            /**
             * Calculate Total Customer
             */
            $totalcustomer = $this->db
                ->select('COUNT(1) AS totalcustomer')
                ->from('accountledger')
                ->where('accountGroupId', 28)
                ->where('status', 1)
                ->get();

            $data['totalcustomer'] = sizeof($totalcustomer) > 0
                ? $totalcustomer
                    ->row()
                    ->totalcustomer
                : 0;

            /**
             * Calculate Total Supplier
             */
            $totalSupplier = $this->db
                ->select('COUNT(1) AS totalsupplier')
                ->from('accountledger')
                ->where('accountGroupId', 27)
                ->where('status', 1)
                ->get();

            $data['totalsupplier'] = sizeof($totalSupplier) > 0
                ? $totalSupplier
                    ->row()
                    ->totalsupplier
                : 0;

            /**
             * Calculate total customer due
             */
            $totalcustomerdue = $this->db
                ->select("SUM(ledgerposting.debit)-SUM(ledgerposting.credit) as totalcustomerdue")
                ->from('ledgerposting')
                ->join('accountledger', 'ledgerposting.ledgerId = accountledger.ledgerId')
                ->where('accountledger.accountGroupId', 28)
                ->where('accountledger.status', 1)
                ->get();

            $data['totalcustomerdue'] = sizeof($totalcustomerdue) > 0
                ? $totalcustomerdue
                    ->row()
                    ->totalcustomerdue
                : 0;

            /**
             * Calculate total supplier due
             */
            $totalsupplierdue = $this->db
                ->select("SUM(ledgerposting.credit) - SUM(ledgerposting.debit) as totalsupplierdue")
                ->from('ledgerposting')
                ->join('accountledger', 'ledgerposting.ledgerId = accountledger.ledgerId')
                ->where('accountledger.accountGroupId', 27)
                ->where('accountledger.status', 1)
                ->get();

            $data['totalsupplierdue'] = sizeof($totalsupplierdue) > 0
                ? $totalsupplierdue
                    ->row()
                    ->totalsupplierdue
                : 0;

            $datearr = $qtyarr = $amountarr = [];

            $last_date = date('Y-m-t');
            for ($i = 0; $i < date("t"); $i++):
                $strtotime_form = strtotime($last_date);
                $minusday = "-" . $i . " day";
                $previous_dateadd = strtotime($minusday, $strtotime_form);
                $beforefromdate = date('Y-m-d', $previous_dateadd);
                $formatdate = date_format(date_create($beforefromdate), "d-M");
                $dataQr = $this->db->query("SELECT SUM(salesdetails.qty) as qty FROM salesmaster JOIN salesdetails ON salesmaster.salesMasterId = salesdetails.salesMasterId WHERE date like '$beforefromdate%' AND salesmaster.companyId = '$company_id' AND salesdetails.companyId = '$company_id'");
                $amountQr = $this->db->query("SELECT SUM(amount) AS saleamount FROM salesmaster WHERE date like '$beforefromdate%' AND companyId = '$company_id'");
                if ($dataQr->num_rows() > 0):
                    $datearr[] = $formatdate;
                    $qtyarr[] = $dataQr->row()->qty;
                    $amountarr[] = $amountQr->row()->saleamount;
                else:
                    $datearr[] = $formatdate;
                    $qtyarr[] = $amountarr[] = 0;
                endif;
            endfor;

            $data['datearr'] = $datearr;
            $data['qtyarr'] = $qtyarr;
            $data['amountarr'] = $amountarr;

            if (sizeof($totalFarmer) > 0):
                $data['totalfarmer'] = $totalFarmer->row()->totalfarmer;
            else:
                $data['totalfarmer'] = 0;
            endif;



            //calculate total sales table salesmaster
            $sdate = date("Y-m-d 00:00:00");
            $totalSales = $this->db->query("select sum(salesdetails.rate) as totalsales from salesdetails inner join salesmaster on salesmaster.salesMasterId = salesdetails.salesMasterId where salesmaster.date like '$sdate%'");
            $data['totalsales'] = $totalSales->row()->totalsales;

            $sdate = date("Y-m-d 00:00:00");
            $totalSales = $this->db->query("select sum(salesreadystockmaster.amount) as totalsalesReadyStock from salesreadystockmaster where date like '$sdate%'");
            $data['totalsalesreadyStock'] = $totalSales->row()->totalsalesReadyStock;
            //profit loss calculation
            $initialdate = "2000-01-01 00:00:00";
            $date_from = $this->sessiondata['mindate']; //substr($date_from, 0, 10);
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];

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
            #$date_to = substr($date_to, 0, 10);
            #$date_from = $date_from . " 00:00:00";
            $date = date('Y-m-d');
            $date_to = $date . " 23:59:59";
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

            //           ##################### monthly net profit line graph ################
            $data['monthname'] = $data['monthvalue'] = $dateArray = [];
            $date = new DateTime();
            $date->add(new DateInterval('P1M'));
            for ($i = 0; $i <= 12; $i++) {
                $date->sub(new DateInterval('P1M'));
                $dt = $date->format('Y-m');
                $dateArray[$i] = $dt;
//            $dt = $date->format('Y-m-d');
//            echo date("Y-m-01", strtotime($dt)) . " ";
//            echo date("Y-m-t", strtotime($dt)) . " ";
                $closingstockQrMonth = $this->db->query("SELECT (SUM(S.inwardQuantity) - SUM(S.outwardQuantity))* B.purchaseRate AS ClosingStock FROM product AS P INNER JOIN productbatch AS B ON P.productId = B.productId INNER JOIN productgroup AS G ON P.productGroupId = G.productGroupId LEFT OUTER JOIN stockposting AS S ON B.productBatchId = S.productBatchId  AND (S.companyId = '$company_id' AND B.companyId = '$company_id' AND P.companyId = '$company_id')  WHERE  S.date LIKE '$dateArray[$i]%' GROUP BY B.productId, P.productName,B.purchaseRate");
                $closingstockResultMonth = $closingstockQrMonth->result();
                $closingstockvaluemonth = 0;
                if (sizeof($closingstockResultMonth) > 0):
                    foreach ($closingstockResultMonth as $closingdataMonth):
                        $closingstockvaluemonth += $closingdataMonth->ClosingStock;
                    endforeach;
                endif;

                $data['closingstockvaluemonth'] = $closingstockvaluemonth;
                $data['totalpurchasemonth'] = $this->profitlossCalcMonth(25, $dateArray[$i]);
                //Sales Account
                $data['totalsalesaccountmonth'] = $this->profitlossCalcMonth(26, $dateArray[$i]);
                //Direct Expense
                $data['totaldirectexpensemonth'] = $this->profitlossCalcMonth(16, $dateArray[$i]);
                //Direct Income
                $data['totaldirectincomemonth'] = $this->profitlossCalcMonth(17, $dateArray[$i]);
                //InDirect Expense
                $data['totalindirectexpensemonth'] = $this->profitlossCalcMonth(20, $dateArray[$i]);
                //Direct Income
                $data['totalindirectincomemonth'] = $this->profitlossCalcMonth(21, $dateArray[$i]);
                $data[$i] = ($closingstockvaluemonth + $data['totalsalesaccountmonth'] + $data['totaldirectincomemonth']) - ($openingstockvalue + $data['totalpurchasemonth'] + $data['totaldirectexpensemonth']);
                array_push($data['monthname'], $dateArray[$i]);
                array_push($data['monthvalue'], $data[$i]);
            }
//                    ##################end monthly net profit line graph######################### 
            //           ##################### monthly customer due line graph ################
            $data['duemonthname'] = $data['duemonthvalue'] = $dateArray = [];
            $date = new DateTime();
            $date->add(new DateInterval('P1M'));
            for ($i = 0; $i <= 12; $i++) {
                $date->sub(new DateInterval('P1M'));
                $dt = $date->format('Y-m');
                $dateArray[$i] = $dt;
//            $dt = $date->format('Y-m-d');
//            echo date("Y-m-01", strtotime($dt)) . " ";
//            echo date("Y-m-t", strtotime($dt)) . " ";
                $customerDuePerMonth = $this->db->query("SELECT SUM(l.debit)-SUM(l.credit) as totalcustomerdue FROM ledgerposting AS l JOIN accountledger AS a ON l.ledgerId = a.ledgerId where a.accountGroupId = '28' AND l.date LIKE '$dateArray[$i]%' AND a.status='1'");
                $customerDuePerMonthResult = $customerDuePerMonth->result();
                $totalCustomerDue = 0;
                if (sizeof($customerDuePerMonthResult) > 0):
                    foreach ($customerDuePerMonthResult as $row):
                        $totalCustomerDue = $row->totalcustomerdue;
                        if ($totalCustomerDue == NULL):
                            $totalCustomerDue = 0;
                        endif;
                    endforeach;
                else:
                    $totalCustomerDue = 0;
                endif;
                array_push($data['duemonthname'], $dateArray[$i]);
                array_push($data['duemonthvalue'], $totalCustomerDue);
            }
            //           ##################### end monthly customer due line graph ################
            $this->sessiondata = $this->session->userdata('logindata');
            $date_form = $this->sessiondata['mindate'];
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

            $noticeQr = $this->db->query("SELECT * FROM `notices` ORDER BY `order_id` DESC, `created_at` DESC");
            $data['newsdata'] = $noticeQr->result();

            $keyboardQr = $this->db->query("SELECT value FROM settings WHERE settings_id=5");
            $data['keyboard'] = $keyboardQr->row()->value;
            
            $graphQr = $this->db->query("SELECT value FROM settings WHERE settings_id=7");
            $data['graph'] = $graphQr->row()->value;
            
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('footer', $data);

        else:
            $keyboardQr = $this->db->query("SELECT value FROM settings WHERE settings_id=5");

            $data['keyboard'] = $keyboardQr->row()->value;
            $data['passwordupdatemessage'] = '';
            $data['title'] = "Login | Confidence chicks and feeds";
            $this->load->view('masterlogin', $data);
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
        $purchaseAntQr = $this->db->query("SELECT A.accountGroupId AS ID, A.accountGroupName AS Name, SUM(C.debit)- SUM(C.credit) AS purchasevalue FROM accountledger AS B INNER JOIN accountgroup AS A ON B.accountGroupId = A.accountGroupId LEFT OUTER JOIN ledgerposting AS C ON B.ledgerId = C.ledgerId AND (C.date BETWEEN '$date_from%' AND '$date_to%') WHERE A.companyId = '$company_id' AND B.companyId = '$company_id' AND C.companyId = '$company_id'  AND A.accountGroupId IN ($IdSet)  group by A.accountGroupId ,A.accountGroupName");
        $purchaseAntRslt = $purchaseAntQr->result();
        if (sizeof($purchaseAntRslt) > 0):
            foreach ($purchaseAntRslt as $purchasedata):
                $totalpurchase += $purchasedata->purchasevalue;
            endforeach;
        endif;
        $firstletter = substr($totalpurchase, 0, 1);
        if ($firstletter == "-"):
            $totalpurchase = substr($totalpurchase, 1);
            $totalpurchase = $totalpurchase;
        elseif ($totalpurchase == 0):
            $totalpurchase = $totalpurchase;
        else:
            $totalpurchase = $totalpurchase;
        endif;
        return $totalpurchase;
    }

    public function profitlossCalcMonth($grpunderId, $date_month) {
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
        $purchaseAntQr = $this->db->query("SELECT A.accountGroupId AS ID, A.accountGroupName AS Name, SUM(C.debit)- SUM(C.credit) AS purchasevalue FROM accountledger AS B INNER JOIN accountgroup AS A ON B.accountGroupId = A.accountGroupId LEFT OUTER JOIN ledgerposting AS C ON B.ledgerId = C.ledgerId  WHERE A.companyId = '$company_id' AND B.companyId = '$company_id' AND C.companyId = '$company_id'  AND A.accountGroupId IN ($IdSet) AND C.date LIKE '$date_month%'  group by A.accountGroupId ,A.accountGroupName");
        $purchaseAntRslt = $purchaseAntQr->result();
        if (sizeof($purchaseAntRslt) > 0):
            foreach ($purchaseAntRslt as $purchasedata):
                $totalpurchase += $purchasedata->purchasevalue;
            endforeach;
        endif;
        $firstletter = substr($totalpurchase, 0, 1);
        if ($firstletter == "-"):
            $totalpurchase = substr($totalpurchase, 1);
            $totalpurchase = $totalpurchase;
        elseif ($totalpurchase == 0):
            $totalpurchase = $totalpurchase;
        else:
            $totalpurchase = $totalpurchase;
        endif;
        return $totalpurchase;
    }

    public function getcompanyyear() {
        $getcompanylist = $this->load->model('company_y');
        $id = $this->input->post('cid');
        $financialyear = $this->company_y->getfinancialyear($id);
        echo '<select class="form-control m-bot15" style="padding: 5px" name="fyearstatus">';
        if (count($financialyear) > 0):
            foreach ($financialyear as $year):
                if ($year->activeOrNot == "1"):
                    $selected = "selected";
                else:
                    $selected = "";
                endif;
                echo '<option ' . $selected . ' value="' . substr($year->fromDate, 0, 10) . ':' . substr($year->toDate, 0, 10) . ',' . $year->activeOrNot . '">' . substr($year->fromDate, 0, 10) . ' &nbsp; To&nbsp;  ' . substr($year->toDate, 0, 10) . '</option>';
            endforeach;
        endif;
        echo '</select>';
    }

    public function accountGroup() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' && $this->sessiondata['userrole'] != 's' || $this->sessiondata['userrole'] == 'r')):
            $data['baseurl'] = $this->config->item('base_url');
            $data['title'] = "Account Group";
            $data['active_menu'] = "master";
            $data['active_sub_menu'] = "accountGroup";
            $this->load->model('ccfmodel');
            $data['sortalldata'] = $this->ccfmodel->sortalldata();
            $data['alldata'] = $this->ccfmodel->showalldata();
            $this->load->view('accountGroup', $data);
        else:
            redirect('home');
        endif;
    }

    public function sales() {
        $data['title'] = "Sales";
        $data['active_menu'] = "transaction";
        $data['active_sub_menu'] = "sales";
        $data['baseurl'] = $this->config->item('base_url');
        $this->load->view('sales', $data);
    }

    public function day_book() {
        $data['title'] = "Day Book";
        $data['active_menu'] = "account_statement";
        $data['active_sub_menu'] = "day_book";
        $data['baseurl'] = $this->config->item('base_url');
        $this->load->view('day_book', $data);
    }

    public function transection() {
        $data['title'] = "Transaction";
        $data['active_menu'] = "report";
        $data['active_sub_menu'] = "transection";
        $data['baseurl'] = $this->config->item('base_url');
        $this->load->view('transection', $data);
    }

    public function stock_sale() {
        $data['title'] = "Stock Sale";
        $data['active_menu'] = "report";
        $data['active_sub_menu'] = "stock_sale";
        $data['baseurl'] = $this->config->item('base_url');
        $this->load->view('stock_sale', $data);
    }

    public function daily_sale() {
        $data['title'] = "Daily Sale";
        $data['active_menu'] = "report";
        $data['active_sub_menu'] = "daily_sale";
        $data['baseurl'] = $this->config->item('base_url');
        $this->load->view('daily_sale', $data);
    }

    public function addAccGroup() {
        $this->load->model('ccfmodel');
        $isadded = $this->ccfmodel->addAccGroup();
        if ($isadded) {
            die('Added');
        } else {
            die('Notadded');
        }
    }

    public function editAccGroup() {
        $this->load->model('ccfmodel');
        $isupdated = $this->ccfmodel->editAccGroup();
        if ($isupdated) {
            echo 'Updated';
        } else {
            echo 'Notupdated';
        }
    }

    public function deleteAccGroup() {
        $this->load->model('ccfmodel');
        $response = $this->ccfmodel->deleteAccGroup();
        $this->session->set_userdata('deletemessage', $response);
        redirect('home/accountGroup');
    }

    public function accountNameCheck() {
        $this->load->model('ccfmodel');
        $isExist = $this->ccfmodel->accountNameCheck();
        if ($isExist) {
            die('free');
        } else {
            die('booked');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */