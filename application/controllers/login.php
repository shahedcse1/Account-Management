<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
        $this->load->helper('common_helper');
    }

    public function loginAccess()
    {
        $data['baseurl'] = $this->config->item('base_url');
        $company_data = $this->session->userdata('logindata');
        $this->sessiondata = $this->session->userdata('logindata');
        if ($company_data['status'] != 'login' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['compantid']) && isset($_POST['fyearstatus'])):
            $Checklogin = $this->load->model('company_y');
            $resultlogin = $this->company_y->checkuserinfoForLogin();
            if ($resultlogin):
                $data['title'] = "Login success";
                ccflogdata($_POST['username'], "accesslog", "Login", "Successfull Login");
                redirect('home');
            else:
                $data['page_title'] = "Fail login";
                $data['passwordupdatemessage'] = '';
                ccflogdata("Wrong user", "accesslog", "Login", "Failed Login");
                $getcompanylist = $this->load->model('company_y');
                $data['companylist'] = $this->company_y->getcomapnylist();
                $this->load->view('masterlogin', $data);
            endif;
        else:
            $data['title'] = "Login success";
            ccflogdata($_POST['username'], "accesslog", "Login", "Successfull Login");
            redirect('home');
        endif;
    }

    function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $company_data = $this->session->userdata('logindata');
        $this->sessiondata = $this->session->userdata('logindata');
        $company_id = $this->sessiondata['companyid'];
        if ($company_data['status'] != 'login' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['compantid']) && isset($_POST['fyearstatus'])):
            $Checklogin = $this->load->model('company_y');
            $resultlogin = $this->company_y->checkuserinfoForLogin();
            if ($resultlogin):
                $data['title'] = "Login success";
                ccflogdata($_POST['username'], "accesslog", "Login", "Successfull Login");
                $totalcustomer = $this->db->query("select count(accountGroupId) as totalcustomer from accountledger where accountGroupId = '28'");
                $totalFarmer = $this->db->query("select count(accountGroupId) as totalfarmer from accountledger where accountGroupId = '13'  AND status='1'");
                $totalSupplier = $this->db->query("select count(accountGroupId) as totalsupplier from accountledger where accountGroupId = '27'  AND status='1'");
                $company_id = $this->sessiondata['companyid'];
                $today_date = date('Y-m-d');
                $strtotime_form = strtotime($today_date);
                $previous_dateadd = strtotime("-11 day", $strtotime_form);
                $beforefromdate = date('Y-m-d', $previous_dateadd);

                $tenDaysSale = $this->db->query("SELECT date, SUM(`amount` - `billDiscount` + `tranportation`) AS `saleamount` FROM salesmaster WHERE date > '$beforefromdate' AND companyId = '$company_id' GROUP BY date(date)");
                $data['tenDaysSale'] = $tenDaysSale->result();
                if (sizeof($totalcustomer) > 0):
                    $data['totalcustomer'] = $totalcustomer->row()->totalcustomer;
                else:
                    $data['totalcustomer'] = 0;
                endif;

                if (sizeof($totalFarmer) > 0):
                    $data['totalfarmer'] = $totalFarmer->row()->totalfarmer;
                else:
                    $data['totalfarmer'] = 0;
                endif;

                if (sizeof($totalSupplier) > 0):
                    $data['totalsupplier'] = $totalSupplier->row()->totalsupplier;
                else:
                    $data['totalsupplier'] = 0;
                endif;



                //calculate total customer due
                $totalcustomerdue = $this->db->query("SELECT SUM(l.debit)-SUM(l.credit) as totalcustomerdue FROM ledgerposting AS l JOIN accountledger AS a ON l.ledgerId = a.ledgerId where a.accountGroupId = '28' AND a.status='1'");
                if (sizeof($totalcustomerdue) > 0):
                    $data['totalcustomerdue'] = $totalcustomerdue->row()->totalcustomerdue;
                else:
                    $data['totalcustomerdue'] = 0;
                endif;

                //calculate total supplier due
                $totalsupplierdue = $this->db->query("SELECT SUM(l.debit)-SUM(l.credit) as totalsupplierdue FROM ledgerposting AS l JOIN accountledger AS a ON l.ledgerId = a.ledgerId where a.accountGroupId = '27' AND a.status='1'");
                if (sizeof($totalsupplierdue) > 0):
                    $data['totalsupplierdue'] = $totalsupplierdue->row()->totalsupplierdue;
                else:
                    $data['totalsupplierdue'] = 0;
                endif;
                //calculate total sales table salesmaster
                $sdate = date("Y-m-d 00:00:00");
                $totalSales = $this->db->query("select sum(salesdetails.rate) as totalsales from salesdetails inner join salesmaster on salesmaster.salesMasterId = salesdetails.salesMasterId where salesmaster.date like '$sdate%'");
                $data['totalsales'] = $totalSales->row()->totalsales;

                $totalSales = $this->db->query("select sum(salesreadystockmaster.amount) as totalsalesReadyStock from salesreadystockmaster where date like '$sdate%'");
                $data['totalsalesreadyStock'] = $totalSales->row()->totalsalesReadyStock;
                //profit loss calculation
                $initialdate = "2000-01-01 00:00:00";
                $date_from = $initialdate; //substr($date_from, 0, 10);
                $company_data = $this->session->userdata('logindata');
                $company_id = $company_data['companyid'];
                $openingstockQr = $this->db->query("SELECT (SUM(S1.inwardQuantity) - SUM(S1.outwardQuantity))* B1.purchaseRate AS OpeningStock FROM productbatch B1 INNER JOIN product ON B1.productId = product.productId LEFT OUTER JOIN stockposting S1 ON B1.productBatchId = S1.productBatchId WHERE (S1.date < '$date_from') AND (S1.companyId = '$company_id' AND B1.companyId = '$company_id' AND product.companyId = '$company_id') GROUP BY B1.purchaseRate");
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
                $closingstockQr = $this->db->query("SELECT (SUM(S.inwardQuantity) - SUM(S.outwardQuantity))* B.purchaseRate AS ClosingStock	FROM product AS P INNER JOIN productbatch AS B ON P.productId = B.productId INNER JOIN productgroup AS G ON P.productGroupId = G.productGroupId LEFT OUTER JOIN stockposting AS S ON B.productBatchId = S.productBatchId AND (S.date BETWEEN '$initialdate' AND  '$date_to') AND (S.companyId = '$company_id' AND B.companyId = '$company_id' AND P.companyId = '$company_id') GROUP BY B.productId, P.productName,B.purchaseRate");
                $closingstockResult = $closingstockQr->result();
                $closingstockvalue = 0;
                if (sizeof($closingstockResult) > 0):
                    foreach ($closingstockResult as $closingdata):
                        $closingstockvalue += $closingdata->ClosingStock;
                    endforeach;
                endif;
                //$data['closingstockvalue'] = $closingstockvalue;
                //           ##################### monthly net profit line graph ################
                $data['monthname'] = array();
                $data['monthvalue'] = array();
                $dateArray = array();
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
//                     //           ##################### monthly customer due line graph ################
                $data['duemonthname'] = array();
                $data['duemonthvalue'] = array();
                $dateArray = array();
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
                        endforeach;
                    else:
                        $totalCustomerDue = 0;
                    endif;

                    array_push($data['duemonthname'], $dateArray[$i]);
                    array_push($data['duemonthvalue'], $totalCustomerDue);
                }
                //           ##################### end monthly customer due line graph ################
//                    
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

                $this->load->view('header', $data);
                $this->load->view('sidebar', $data);
                $this->load->view('dashboard/dashboard', $data);
                $this->load->view('footer', $data);
            else:
                $data['page_title'] = "Fail login";
                $data['passwordupdatemessage'] = '';

                ccflogdata("Wrong user", "accesslog", "Login", "Failed Login");
                $getcompanylist = $this->load->model('company_y');
                $data['companylist'] = $this->company_y->getcomapnylist();
                $this->load->view('masterlogin', $data);
            endif;
        elseif ($company_data['status'] == 'login'):
            $data['title'] = "Login success";
            $totalcustomer = $this->db->query("select count(accountGroupId) as totalcustomer from accountledger where accountGroupId = '28'");
            $totalFarmer = $this->db->query("select count(accountGroupId) as totalfarmer from accountledger where accountGroupId = '13'  AND status='1'");
            $totalSupplier = $this->db->query("select count(accountGroupId) as totalsupplier from accountledger where accountGroupId = '27'  AND status='1'");

            $company_id = $this->sessiondata['companyid'];
            $today_date = date('Y-m-d');
            $strtotime_form = strtotime($today_date);
            $previous_dateadd = strtotime("-11 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);

            $tenDaysSale = $this->db->query("SELECT date, SUM(`amount` - `billDiscount` + `tranportation`) AS `saleamount` FROM salesmaster WHERE date > '$beforefromdate' AND companyId = '$company_id' GROUP BY date(date)");
            $data['tenDaysSale'] = $tenDaysSale->result();

            if (sizeof($totalcustomer) > 0):
                $data['totalcustomer'] = $totalcustomer->row()->totalcustomer;
            else:
                $data['totalcustomer'] = 0;
            endif;

            if (sizeof($totalFarmer) > 0):
                $data['totalfarmer'] = $totalFarmer->row()->totalfarmer;
            else:
                $data['totalfarmer'] = 0;
            endif;

            if (sizeof($totalSupplier) > 0):
                $data['totalsupplier'] = $totalSupplier->row()->totalsupplier;
            else:
                $data['totalsupplier'] = 0;
            endif;



            //calculate total customer due
            $totalcustomerdue = $this->db->query("SELECT SUM(l.debit)-SUM(l.credit) as totalcustomerdue FROM ledgerposting AS l JOIN accountledger AS a ON l.ledgerId = a.ledgerId where a.accountGroupId = '28' AND a.status='1'");
            if (sizeof($totalcustomerdue) > 0):
                $data['totalcustomerdue'] = $totalcustomerdue->row()->totalcustomerdue;
            else:
                $data['totalcustomerdue'] = 0;
            endif;

            //calculate total supplier due
            $totalsupplierdue = $this->db->query("SELECT SUM(l.debit)-SUM(l.credit) as totalsupplierdue FROM ledgerposting AS l JOIN accountledger AS a ON l.ledgerId = a.ledgerId where a.accountGroupId = '27' AND a.status='1'");
            if (sizeof($totalsupplierdue) > 0):
                $data['totalsupplierdue'] = $totalsupplierdue->row()->totalsupplierdue;
            else:
                $data['totalsupplierdue'] = 0;
            endif;
            //calculate total sales table salesmaster
            $sdate = date("Y-m-d 00:00:00");
            $totalSales = $this->db->query("select sum(salesdetails.rate) as totalsales from salesdetails inner join salesmaster on salesmaster.salesMasterId = salesdetails.salesMasterId where salesmaster.date like '$sdate%'");
            $data['totalsales'] = $totalSales->row()->totalsales;

            $totalSales = $this->db->query("select sum(salesreadystockmaster.amount) as totalsalesReadyStock from salesreadystockmaster where date like '$sdate%'");
            $data['totalsalesreadyStock'] = $totalSales->row()->totalsalesReadyStock;
            //profit loss calculation
            $initialdate = "2000-01-01 00:00:00";
            $date_from = $initialdate; //substr($date_from, 0, 10);
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $openingstockQr = $this->db->query("SELECT (SUM(S1.inwardQuantity) - SUM(S1.outwardQuantity))* B1.purchaseRate AS OpeningStock FROM productbatch B1 INNER JOIN product ON B1.productId = product.productId LEFT OUTER JOIN stockposting S1 ON B1.productBatchId = S1.productBatchId WHERE (S1.date < '$date_from') AND (S1.companyId = '$company_id' AND B1.companyId = '$company_id' AND product.companyId = '$company_id') GROUP BY B1.purchaseRate");
            $openingstockResult = $openingstockQr->result();
            $openingstockvalue = 0;
            if (sizeof($openingstockResult) > 0):
                foreach ($openingstockResult as $openingdata):
                    $openingstockvalue += $openingdata->OpeningStock;
                endforeach;
            endif;
            $data['openingstockvalue'] = $openingstockvalue;

            //           ##################### monthly net profit line graph ################
            $data['monthname'] = array();
            $data['monthvalue'] = array();
            $dateArray = array();
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
            $data['duemonthname'] = array();
            $data['duemonthvalue'] = array();
            $dateArray = array();
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
                    endforeach;
                else:
                    $totalCustomerDue = 0;
                endif;

                array_push($data['duemonthname'], $dateArray[$i]);
                array_push($data['duemonthvalue'], $totalCustomerDue);
            }
            //           ##################### end monthly customer due line graph ################
            //Closing stock calculation            
            #$date_to = substr($date_to, 0, 10);
            #$date_from = $date_from . " 00:00:00";
            $date = date('Y-m-d');
            $date_to = $date . " 23:59:59";
            $closingstockQr = $this->db->query("SELECT (SUM(S.inwardQuantity) - SUM(S.outwardQuantity))* B.purchaseRate AS ClosingStock	FROM product AS P INNER JOIN productbatch AS B ON P.productId = B.productId INNER JOIN productgroup AS G ON P.productGroupId = G.productGroupId LEFT OUTER JOIN stockposting AS S ON B.productBatchId = S.productBatchId AND (S.date BETWEEN '$initialdate' AND  '$date_to') AND (S.companyId = '$company_id' AND B.companyId = '$company_id' AND P.companyId = '$company_id') GROUP BY B.productId, P.productName,B.purchaseRate");
            $closingstockResult = $closingstockQr->result();
            $closingstockvalue = 0;
            if (sizeof($closingstockResult) > 0):
                foreach ($closingstockResult as $closingdata):
                    $closingstockvalue += $closingdata->ClosingStock;
                endforeach;
            endif;




            //$data['closingstockvalue'] = $closingstockvalue;
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

            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('footer', $data);
        else:
            $data['page_title'] = "Fail login";
            $data['passwordupdatemessage'] = '';

            ccflogdata("Wrong user", "accesslog", "Login", "Failed Login");
            $getcompanylist = $this->load->model('company_y');
            $this->session->set_userdata("loginerror", "Invalid Username or Password");
            $data['companylist'] = $this->company_y->getcomapnylist();
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
            $totalpurchase = $totalpurchase;
        elseif ($totalpurchase == 0):
            $totalpurchase = $totalpurchase;
        else:
            $totalpurchase = $totalpurchase;
        endif;
        return $totalpurchase;
    }

    function logout() {
        $loginData = array(
            'userid' => "",
            'companyid' => "",
            'fyear_status' => "",
            'mindate' => "",
            'maxdate' => "",
            'username' => "",
            'status' => "",
            'userrole' => ""
        );
        ccflogdata("logout user", "accesslog", "Logout", "Successfull Logout");
        $this->session->set_userdata('logindata', $loginData);
        $this->session->unset_userdata($loginData);
        if (isset($_GET['id']) && $_GET['id'] == 'logout'):
            $data['baseurl'] = $this->config->item('base_url');
            $data['passwordupdatemessage'] = 'Password Update Successfully. Login with new password';
            $getcompanylist = $this->load->model('company_y');
            $data['companylist'] = $this->company_y->getcomapnylist();

            $this->load->view('masterlogin', $data);
        else:
            $data['passwordupdatemessage'] = '';
            redirect('home');
        endif;
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

}
