<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salesreport extends CI_Controller {

    private $sessiondata;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->sessiondata = $this->session->userdata('logindata');
    }

    public function index() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r')):
            $data['title'] = "Sales Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "salesreport_customer";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $acledgernameQr = $this->db->query("SELECT ledgerId, accNo, acccountLedgerName FROM accountledger WHERE companyId = '$company_id' AND (accountGroupId = '28' OR accountGroupId = '13')");
            $data['customerlist'] = $acledgernameQr->result();
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $acledgerid = $this->input->post('customername');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $salesmasterQr = $this->db->query("SELECT salesMasterId FROM salesmaster WHERE ledgerId = '$acledgerid' AND companyId = '$company_id'");
            $salesmasteridarray = $salesmasterQr->result();
            $IdSet = "";
            if (sizeof($salesmasteridarray) > 0):
                foreach ($salesmasteridarray as $salesmasterid):
                    if ($IdSet == ""):
                        $IdSet = $salesmasterid->salesMasterId;
                    else:
                        $IdSet = $IdSet . "," . $salesmasterid->salesMasterId;
                    endif;
                endforeach;
            endif;
            if ($IdSet != ""):
                $salesdetailsQr = $this->db->query("SELECT sm.date, p.productName, sd.salesMasterId, sd.qty, sd.pcs, un.unitName, sd.rate FROM salesdetails sd JOIN unit un ON sd.unitId = un.unitId JOIN productbatch pb JOIN product p JOIN salesmaster sm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND sm.salesMasterId = sd.salesMasterId AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND sm.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to')");
                $data['salesdetailsdata'] = $salesdetailsQr->result();
            else:
                $data['salesdetailsdata'] = array();
            endif;
            $data['selectedledgerid'] = $acledgerid;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('sales/customerreport', $data);
            $this->load->view('footer', $data);
            $this->load->view('sales/cr_script', $data);
        else:
            redirect('login');
        endif;
    }

    public function farmerreport() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r' || $this->sessiondata['userrole'] == 'f')):
            $data['title'] = "Farmer Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "salesreport_farmer";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $data['company_id'] = $company_id;
            $data['feedamountret'] = 0;
            $data['totalmedicineret'] = 0;
            //13 for farmer and 28 for customer
            $acledgernameQr = $this->db->query("SELECT ledgerId, accNo, acccountLedgerName FROM accountledger WHERE companyId = '$company_id' AND accountGroupId = '13'");
            $data['customerlist'] = $acledgernameQr->result();
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $acledgerid = $this->input->post('customername');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";

            //Opening balance for customer
            $strtotime_form = strtotime($date_from);
            $previous_dateadd = strtotime("-1 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);
            $beforefromdate = $beforefromdate . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";
            $openingQr = $this->db->query("SELECT sum(debit - credit) as openingbal FROM ledgerposting WHERE companyId = '$company_id' AND ledgerId = '$acledgerid' AND (date BETWEEN '$initialdate' AND '$beforefromdate')");
            $data['openingbal'] = $openingQr->row()->openingbal;

            //Sales details from salesdetails table
            $salesmasterQr = $this->db->query("SELECT salesMasterId FROM salesmaster WHERE ledgerId = '$acledgerid' AND companyId = '$company_id'");
            $salesmasteridarray = $salesmasterQr->result();
            $IdSet = "";
            if (sizeof($salesmasteridarray) > 0):
                foreach ($salesmasteridarray as $salesmasterid):
                    if ($IdSet == ""):
                        $IdSet = $salesmasterid->salesMasterId;
                    else:
                        $IdSet = $IdSet . "," . $salesmasterid->salesMasterId;
                    endif;
                endforeach;
            endif;
            $totalfeed = 0;
            $totalmedicine = 0;
            if ($IdSet != ""):
                $salesdetailsQr = $this->db->query("SELECT sm.tranportation as trans, sm.billDiscount as discount, p.productGroupId as pgroup, sm.date as date, sd.salesMasterId as invoiceno, p.productName as atitle,sd.qty as qty1,sd.pcs as pcs1, un.unitName as unit, sd.rate as rate1,(qty*rate) as debit, NULL as pcs2, NULL as weight, NULL as rate2, NULL as credit FROM salesdetails sd JOIN unit un ON sd.unitId = un.unitId JOIN productbatch pb JOIN product p JOIN salesmaster sm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND sm.salesMasterId = sd.salesMasterId AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND sm.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to') ORDER BY sd.salesMasterId ASC");
                $salesdetailsdata = $salesdetailsQr->result();

                //For sales return
                $salesreturndetailsQr = $this->db->query("SELECT 'returnsales' as trans, NULL as discount, p.productGroupId as pgroup, srm.date as date, srm.salesMasterId as invoiceno, p.productName as atitle,srd.returnedQty as qty1,sd.pcs as pcs1, un.unitName as unit, sd.rate as rate1,NULL as debit, NULL as pcs2, NULL as weight, NULL as rate2, (srd.returnedQty*sd.rate) as credit FROM salesdetails sd JOIN unit un ON sd.unitId = un.unitId JOIN productbatch pb JOIN product p JOIN salesreturnmaster srm JOIN salesreturndetails srd WHERE srm.salesMasterId IN ($IdSet) AND srm.salesReturnMasterId = srd.salesReturnMasterId AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND srd.salesDetailsId = sd.salesDetailsId AND (srd.returnedQty > 0) AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND srm.companyId = '$company_id' AND srd.companyId = '$company_id' AND (srm.date BETWEEN '$date_from' AND '$date_to') ORDER BY srm.salesMasterId ASC");
                $salereturnsdetailsdata = $salesreturndetailsQr->result();
                //Total feed qty
                $feedQr = $this->db->query("SELECT SUM(sd.qty) as totalqty FROM salesdetails sd JOIN productbatch pb JOIN product p JOIN salesmaster sm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND sm.salesMasterId = sd.salesMasterId AND p.productGroupId = '3' AND p.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND sm.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to')");
                $totalfeed = $feedQr->row()->totalqty;

                //Total feed qty return
                $feedQrRet = $this->db->query("SELECT SUM(srd.returnedQty) as totalqty, SUM(srd.returnedQty*sd.rate) as feedamountret FROM salesdetails sd JOIN productbatch pb JOIN product p JOIN salesreturnmaster srm JOIN salesreturndetails srd WHERE srm.salesMasterId IN ($IdSet) AND srm.salesReturnMasterId = srd.salesReturnMasterId AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND srd.salesDetailsId = sd.salesDetailsId AND p.productGroupId = '3' AND p.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND srm.companyId = '$company_id' AND srd.companyId = '$company_id' AND (srm.date BETWEEN '$date_from' AND '$date_to')");
                $totalfeedret = $feedQrRet->row()->totalqty;
                $totalfeed = $totalfeed - $totalfeedret;
                $data['feedamountret'] = $feedQrRet->row()->feedamountret;

                //Total medicine qty
                $mediQr = $this->db->query("SELECT sd.salesMasterId, SUM(sd.qty*sd.rate) as amount FROM salesdetails sd JOIN productbatch pb JOIN product p JOIN salesmaster sm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND sm.salesMasterId = sd.salesMasterId AND p.productGroupId = '4' AND p.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND sm.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to')");
                $totalmedicine = $mediQr->row()->amount;


                //Total medicine qty return
                $mediQrRet = $this->db->query("SELECT SUM(srd.returnedQty*sd.rate) as amount FROM salesdetails sd JOIN productbatch pb JOIN product p JOIN salesreturnmaster srm JOIN salesreturndetails srd WHERE srm.salesMasterId IN ($IdSet) AND srm.salesReturnMasterId = srd.salesReturnMasterId AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND srd.salesDetailsId = sd.salesDetailsId AND p.productGroupId = '4' AND p.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND srm.companyId = '$company_id' AND srd.companyId = '$company_id' AND (srm.date BETWEEN '$date_from' AND '$date_to')");
                $totalmedicineret = $mediQrRet->row()->amount;
                $data['totalmedicineret'] = $totalmedicineret;
                $totalmedicine = $totalmedicine - $totalmedicineret;
            else:
                //$transportdata = array();
                // $discountdata = array();
                $salesdetailsdata = array();
                $salereturnsdetailsdata = array();
            endif;
            $data['totalfeed'] = $totalfeed;
            $data['totalmedicine'] = $totalmedicine;

            //Sales details from salesreadystockdetails
            $salesreadystockdetailsQr = $this->db->query("SELECT NULL as trans, NULL as discount, NULL as pgroup,srsm.date as date,srsd.salesReadyStockMasterId as invoiceno, p.productName as atitle,srsd.qty as qty1,srsd.pcs as pcs1,un.unitName as unit,srsd.rate as rate1,(qty*rate) as debit, NULL as pcs2, NULL as weight, NULL as rate2, NULL as credit FROM salesreadystockdetails srsd JOIN salesreadystockmaster srsm ON srsd.salesReadyStockMasterId = srsm.salesReadyStockMasterId JOIN unit un ON un.unitId = '16' JOIN product p WHERE srsd.ledgerId = '$acledgerid' AND p.productId = '1' AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND srsm.companyId = '$company_id' AND srsd.companyId = '$company_id' AND (srsm.date BETWEEN '$date_from' AND '$date_to') ORDER BY srsd.salesReadyStockMasterId ASC");
            $salesreadydetailsdata = $salesreadystockdetailsQr->result();

            //Payment sales details from paymentdetails
            $paymentQr = $this->db->query("SELECT NULL as trans, NULL as discount, NULL as pgroup, pm.date as date, pay.paymentMasterId as invoiceno,'Payment Voucher' as atitle,NULL as qty1, NULL as pcs1, NULL as unit, NULL as rate1, pay.amount as debit,NULL as pcs2, NULL as weight, NULL as rate2, NULL as credit FROM paymentdetails pay JOIN paymentmaster pm ON (pm.paymentMasterId = pay.paymentMasterId) WHERE pay.ledgerId = '$acledgerid' AND pay.companyId = '$company_id' AND pm.companyId = '$company_id' AND (pm.date BETWEEN '$date_from' AND '$date_to') ORDER BY pay.paymentMasterId ASC");
            $paymentdetails = $paymentQr->result();
            $bycashQr = $this->db->query("SELECT sum(pay.amount) as debit FROM paymentdetails pay JOIN paymentmaster pm ON (pm.paymentMasterId = pay.paymentMasterId) WHERE pay.ledgerId = '$acledgerid' AND pay.companyId = '$company_id' AND pm.companyId = '$company_id' AND (pm.date BETWEEN '$date_from' AND '$date_to')");
            if (sizeof($bycashQr->num_rows() > 0)):
                $bycashval = $bycashQr->row()->debit;
            else:
                $bycashval = 0;
            endif;
            $data['bycashval'] = $bycashval;

            //Purchase details from salesreadystockmaster
            $salesreadystockmasterQr = $this->db->query("SELECT NULL as trans, NULL as discount, NULL as pgroup, srsm.date as date,srsm.salesReadyStockMasterId as invoiceno, p.productName as atitle,NULL as qty1,NULL as pcs1, un.unitName as unit, NULL as rate1,NULL as debit,srsm.pcs as pcs2,srsm.kg as weight,srsm.farmerRate as rate2,srsm.amount as credit FROM salesreadystockmaster srsm JOIN unit un ON un.unitId = '16' JOIN product p WHERE srsm.ledgerId = '$acledgerid' AND p.productId = '1' AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND srsm.companyId = '$company_id' AND (srsm.date BETWEEN '$date_from' AND '$date_to') ORDER BY srsm.salesReadyStockMasterId ASC");
            $salesreadystockmasterdata = $salesreadystockmasterQr->result();

            //Purchase details from receiptdetails
            $receiptdetailsQr = $this->db->query("SELECT NULL as trans, NULL as discount, NULL as pgroup, rm.date as date, rd.receiptMasterId as invoiceno, 'Receipt Voucher' as atitle,NULL as qty1,NULL as pcs1, NULL as unit, NULL as rate1,NULL as debit,NULL as pcs2,NULL as weight,NULL as rate2,rd.amount as credit FROM receiptdetails rd JOIN receiptmaster rm ON rd.receiptDetailsId = rm.receiptMasterId WHERE rd.ledgerId = '$acledgerid' AND rm.companyId = '$company_id' AND rd.companyId = '$company_id' AND (rm.date BETWEEN '$date_from' AND '$date_to') ORDER BY rd.receiptMasterId ASC");
            $receiptdetailsdata = $receiptdetailsQr->result();
            $receiptpayQr = $this->db->query("SELECT sum(rd.amount) as credit FROM receiptdetails rd JOIN receiptmaster rm ON rd.receiptDetailsId = rm.receiptMasterId WHERE rd.ledgerId = '$acledgerid' AND rm.companyId = '$company_id' AND rd.companyId = '$company_id' AND (rm.date BETWEEN '$date_from' AND '$date_to')");
            if (sizeof($receiptpayQr->num_rows() > 0)):
                $receiptval = $receiptpayQr->row()->credit;
            else:
                $receiptval = 0;
            endif;
            $data['receiptval'] = $receiptval;

            //Journey Entry from journaldetails table                    
            $journaldetailsQr = $this->db->query("SELECT NULL as trans, NULL as discount, NULL as pgroup, jm.date as date, jd.journalMasterId as invoiceno, 'Journal Entry' as atitle,NULL as qty1,NULL as pcs1, NULL as unit, NULL as rate1,jd.debit as debit,NULL as pcs2,NULL as weight,NULL as rate2,jd.credit as credit FROM journaldetails jd JOIN journalmaster jm ON jd.journalMasterId = jm.journalMasterId WHERE jd.ledgerId = '$acledgerid' AND jm.companyId = '$company_id' AND jd.companyId = '$company_id' AND (jm.date BETWEEN '$date_from' AND '$date_to') ORDER BY jd.journalMasterId ASC");
            $journaldetailsdata = $journaldetailsQr->result();

            //Purchase return
            $purchasemasterQr = $this->db->query("SELECT purchaseMasterId FROM purchasemaster WHERE ledgerId = '$acledgerid' AND companyId = '$company_id'");
            $purchasemasteridarray = $purchasemasterQr->result();
            $IdSetPurchase = "";
            if (sizeof($purchasemasteridarray) > 0):
                foreach ($purchasemasteridarray as $purchasemasterid):
                    if ($IdSetPurchase == ""):
                        $IdSetPurchase = $purchasemasterid->purchaseMasterId;
                    else:
                        $IdSetPurchase = $IdSetPurchase . "," . $purchasemasterid->purchaseMasterId;
                    endif;
                endforeach;
            endif;
            if ($IdSetPurchase != ""):
                $purchasereturndetailsQr = $this->db->query("SELECT 'returnsales' as trans, NULL as discount, p.productGroupId as pgroup, prm.date as date, prm.purchaseMasterId as invoiceno, p.productName as atitle,prd.returnedQty as qty1,pd.pcs as pcs1, NULL as unit, pd.rate as rate1,NULL as debit, NULL as pcs2, NULL as weight, NULL as rate2, (prd.returnedQty*pd.rate) as credit FROM purchasedetails pd JOIN productbatch pb JOIN product p JOIN purchasereturnmaster prm JOIN purchasereturndetails prd WHERE prm.purchaseMasterId IN ($IdSetPurchase) AND prm.purchaseReturnMasterId = prd.purchaseReturnMasterId AND pd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND prd.purchaseDetailsId = pd.purchaseDetailsId AND p.companyId = '$company_id' AND pb.companyId = '$company_id' AND pd.companyId = '$company_id' AND prm.companyId = '$company_id' AND prd.companyId = '$company_id' AND (prm.date BETWEEN '$date_from' AND '$date_to') ORDER BY prm.purchaseMasterId ASC");
                $purchasereturnsdetailsdata = $purchasereturndetailsQr->result();
            else:
                $purchasereturnsdetailsdata = array();
            endif;
            $alldataarr = array();
            $alldataarr = array_merge($salesdetailsdata, $salesreadydetailsdata, $paymentdetails, $salesreadystockmasterdata, $receiptdetailsdata, $journaldetailsdata, $salereturnsdetailsdata, $purchasereturnsdetailsdata);

            if (sizeof($alldataarr) > 0):

                function sortdataarray($a, $b) {
                    $t1 = strtotime($a->date);
                    $t2 = strtotime($b->date);
                    if ($t1 == $t2):
                        return 1;
                    else:
                        return $t1 - $t2;
                    endif;
                }

                usort($alldataarr, 'sortdataarray');
            endif;
            $data['allfarmerdata'] = $alldataarr;


            if ($acledgerid != ""):
                $ledgerinfoQr = $this->db->query("SELECT accNo, acccountLedgerName, address, nameOfBusiness FROM accountledger WHERE ledgerId = '$acledgerid' AND companyId = '$company_id'");
                $data['accountno'] = $ledgerinfoQr->row()->accNo;
                $data['ledgername'] = $ledgerinfoQr->row()->acccountLedgerName;
                $data['address'] = $ledgerinfoQr->row()->address;
                $data['businessname'] = $ledgerinfoQr->row()->nameOfBusiness;
            else:
                $data['accountno'] = "";
                $data['ledgername'] = "";
                $data['address'] = "";
                $data['businessname'] = "";
                $data['allfarmerdata'] = array();
            endif;

            if ($acledgerid != ""):
                $companyQr = $this->db->query("SELECT companyName, address, email, logo FROM company WHERE companyId = '$company_id'");
                $data['comname'] = $companyQr->row()->companyName;
                $data['comaddress'] = $companyQr->row()->address;
                $data['comemail'] = $companyQr->row()->email;
                $data['logoname'] = $companyQr->row()->logo;
            else:
                $data['comname'] = "";
                $data['comaddress'] = "";
                $data['comemail'] = "";
                $data['logoname'] = "";
            endif;

            $data['selectedledgerid'] = $acledgerid;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('sales/farmerreport', $data);
            $this->load->view('footer', $data);
            $this->load->view('sales/farmerscript', $data);
        else:
            redirect('login');
        endif;
    }

    public function customerreport() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r' || $this->sessiondata['userrole'] == 'u')):
            $data['title'] = "Customer Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "salesreport_customer";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $data['company_id'] = $company_id;

            $cst = $this->sessiondata['userid'];
            $resultRole = $this->db->query("SELECT `role` FROM `user` WHERE companyId = '$company_id'  AND userId='$cst'");
            if ($resultRole->row()->role == 'u') {
                $resultLedgerId = $this->db->query("SELECT ledgerId FROM accountledger WHERE companyId = '$company_id' AND accountGroupId = '28' AND cst='$cst'");
                $acledgerid = $resultLedgerId->row()->ledgerId;
            } else {
                $acledgerid = $this->input->post('customername');
            }
            //13 for farmer and 28 for customer
            $acledgernameQr = $this->db->query("SELECT ledgerId, accNo, acccountLedgerName,cst FROM accountledger WHERE companyId = '$company_id' AND accountGroupId = '28'");
            $data['customerlist'] = $acledgernameQr->result();
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            // $acledgerid = $this->input->post('customername');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";

            //Opening balance for customer
            $strtotime_form = strtotime($date_from);
            $previous_dateadd = strtotime("-1 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);
            $beforefromdate = $beforefromdate . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";
            $openingQr = $this->db->query("SELECT SUM(debit - credit) as openingbal FROM ledgerposting WHERE companyId = '$company_id' AND ledgerId = '$acledgerid' AND (date BETWEEN '$initialdate' AND '$beforefromdate')");
            $data['openingbal'] = $openingQr->row()->openingbal;

            //Sales details from salesdetails table
            $salesmasterQr = $this->db->query("SELECT salesMasterId FROM salesmaster WHERE ledgerId = '$acledgerid' AND companyId = '$company_id'");
            $salesmasteridarray = $salesmasterQr->result();
            $IdSet = "";
            if (sizeof($salesmasteridarray) > 0):
                foreach ($salesmasteridarray as $salesmasterid):
                    if ($IdSet == ""):
                        $IdSet = $salesmasterid->salesMasterId;
                    else:
                        $IdSet = $IdSet . "," . $salesmasterid->salesMasterId;
                    endif;
                endforeach;
            endif;
            $totalfeed = 0;
            if ($IdSet != ""):
                $salesdetailsQr = $this->db->query("SELECT sm.tranportation as trans, sm.date as date, p.productName as atitle,sd.salesMasterId as invoiceno, sm.orderNo as receiptno, sd.pcs as pcs, sd.qty as qty, un.unitName as unit, sd.rate as rate, (sd.qty*sd.rate) as debit, NULL as credit FROM salesdetails sd JOIN unit un ON sd.unitId = un.unitId JOIN productbatch pb JOIN product p JOIN salesmaster sm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND sm.salesMasterId = sd.salesMasterId AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND sm.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to')");
                $salesdetailsdata = $salesdetailsQr->result();

                //For sales return
                //$salesreturndetailsQr = $this->db->query("SELECT srm.date as date,p.productName as atitle,srm.salesMasterId as invoiceno, NULL as receiptno,sd.pcs as pcs,srd.returnedQty as qty, un.unitName as unit, sd.rate as rate,NULL as debit,(srd.returnedQty*sd.rate) as credit FROM salesdetails sd JOIN unit un ON sd.unitId = un.unitId JOIN productbatch pb JOIN product p JOIN salesreturnmaster srm JOIN salesreturndetails srd WHERE srm.salesMasterId IN ($IdSet) AND srm.salesReturnMasterId = srd.salesReturnMasterId AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND srd.salesDetailsId = sd.salesDetailsId AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND srm.companyId = '$company_id' AND srd.companyId = '$company_id' AND (srm.date BETWEEN '$date_from' AND '$date_to')");
                //$salereturnsdetailsdata = $salesreturndetailsQr->result();

                $salesDiscountQr = $this->db->query("SELECT NULL AS trans, sm.date as date, 'Sales Discount' as atitle, sd.salesMasterId as invoiceno, sm.orderNo as receiptno, sm.billDiscount as discount, sd.pcs as pcs, NULL as qty, NULL as unit, NULL as rate, NULL as debit, sm.billDiscount as credit  FROM salesdetails sd JOIN unit un ON sd.unitId = un.unitId JOIN productbatch pb JOIN product p JOIN salesmaster sm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND sm.salesMasterId = sd.salesMasterId AND sm.billDiscount NOT IN ('0') AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND sm.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to') GROUP BY sm.salesMasterId");
                $salesDiscountdata = $salesDiscountQr->result();

                //For sales return
                $salesreturndetailsQr = $this->db->query("SELECT NULL AS trans,srm.date as date, p.productName as atitle,srm.salesReturnMasterId as invoiceno, 'returnsales' as receiptno, sd.pcs as pcs, srd.returnedQty as qty, un.unitName as unit, srd.returnRate as rate, NULL as debit, (srd.returnedQty*srd.returnRate) as credit FROM salesdetails sd JOIN unit un ON sd.unitId = un.unitId JOIN salesreturndetails srd ON srd.salesDetailsId = sd.salesDetailsId JOIN productbatch pb JOIN product p JOIN salesreturnmaster srm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND srm.salesMasterId = sd.salesMasterId AND (srd.returnedQty > 0) AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND srm.companyId = '$company_id' AND srd.companyId = '$company_id' AND (srm.date BETWEEN '$date_from' AND '$date_to')");
                $salesreturndetailsdata = $salesreturndetailsQr->result();


                //Total feed qty
                $feedQr = $this->db->query("SELECT sd.qty FROM salesdetails sd JOIN productbatch pb JOIN product p JOIN salesmaster sm WHERE sd.salesMasterId IN ($IdSet) AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND sm.salesMasterId = sd.salesMasterId AND p.productGroupId = '3' AND p.companyId = '$company_id' AND pb.companyId = '$company_id' AND sd.companyId = '$company_id' AND sm.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to')");
                $feedresult = $feedQr->result();
                if (sizeof($feedresult) > 0):
                    foreach ($feedresult as $feedrow):
                        $totalfeed += $feedrow->qty;
                    endforeach;
                endif;
            else:
                $salesdetailsdata = array();
                $salesDiscountdata = array();
                $salesreturndetailsdata = array();
            endif;
            $data['totalfeed'] = $totalfeed;

            //Sales details from salesreadystockdetails
            $salesreadystockdetailsQr = $this->db->query("SELECT NULL AS trans, srsm.date as date, p.productName as atitle, srsd.salesReadyStockMasterId as invoiceno, NULL as receiptno, srsd.pcs as pcs,srsd.qty as qty, un.unitName as unit, srsd.rate as rate, (qty*rate) as debit, NULL as credit FROM salesreadystockdetails srsd JOIN salesreadystockmaster srsm ON srsd.salesReadyStockMasterId = srsm.salesReadyStockMasterId JOIN unit un ON un.unitId = '16' JOIN product p WHERE srsd.ledgerId = '$acledgerid' AND p.productId = '1' AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND srsm.companyId = '$company_id' AND srsd.companyId = '$company_id' AND (srsm.date BETWEEN '$date_from' AND '$date_to')");
            $salesreadydetailsdata = $salesreadystockdetailsQr->result();

            //Payment sales details from paymentdetails
            $paymentQr = $this->db->query("SELECT NULL AS trans, pm.date as date, 'Payment Voucher' as atitle, pay.paymentMasterId as invoiceno, NULL as receiptno, NULL as pcs, NULL as qty, NULL as unit, NULL as rate,pay.amount as debit, NULL as credit FROM paymentdetails pay JOIN paymentmaster pm ON (pm.paymentMasterId = pay.paymentMasterId) WHERE pay.ledgerId = '$acledgerid' AND pay.companyId = '$company_id' AND pm.companyId = '$company_id' AND (pm.date BETWEEN '$date_from' AND '$date_to')");
            $paymentdetails = $paymentQr->result();

            //Purchase details from salesreadystockmaster
            $salesreadystockmasterQr = $this->db->query("SELECT NULL AS trans, srsm.date as date, p.productName as atitle, srsm.salesReadyStockMasterId as invoiceno,NULL as receiptno,NULL as pcs,NULL as qty,NULL as unit,NULL as rate, NULL as debit, srsm.amount as credit FROM salesreadystockmaster srsm JOIN unit un ON un.unitId = '16' JOIN product p WHERE srsm.ledgerId = '$acledgerid' AND p.productId = '1' AND p.companyId = '$company_id' AND un.companyId = '$company_id' AND srsm.companyId = '$company_id' AND (srsm.date BETWEEN '$date_from' AND '$date_to')");
            $salesreadystockmasterdata = $salesreadystockmasterQr->result();

            //Purchase details from receiptdetails
            $receiptdetailsQr = $this->db->query("SELECT NULL AS trans, rm.date as date, 'Receipt Voucher' as atitle, rd.receiptMasterId as invoiceno, rd.receiptNo as receiptno, NULL as pcs,NULL as qty,NULL as unit,NULL as rate, NULL as debit,rd.amount as credit FROM receiptdetails rd JOIN receiptmaster rm ON rd.receiptMasterId = rm.receiptMasterId WHERE rd.ledgerId = '$acledgerid' AND rm.companyId = '$company_id' AND rd.companyId = '$company_id' AND (rm.date BETWEEN '$date_from' AND '$date_to')");
            $receiptdetailsdata = $receiptdetailsQr->result();

            //Journal details from journaldetails
            $journaldetailsQr = $this->db->query("SELECT NULL AS trans, jm.date as date, 'Journal Entry' as atitle, jd.journalMasterId as invoiceno, NULL as receiptno, NULL as pcs,NULL as qty,NULL as unit,NULL as rate, jd.debit as debit,jd.credit as credit FROM journaldetails jd JOIN journalmaster jm ON jd.journalMasterId = jm.journalMasterId WHERE jd.ledgerId = '$acledgerid' AND jm.companyId = '$company_id' AND jd.companyId = '$company_id' AND (jm.date BETWEEN '$date_from' AND '$date_to')");
            $journaldetailsdata = $journaldetailsQr->result();


            //Purchase return
            $purchasemasterQr = $this->db->query("SELECT purchaseMasterId FROM purchasemaster WHERE ledgerId = '$acledgerid' AND companyId = '$company_id'");
            $purchasemasteridarray = $purchasemasterQr->result();
            $IdSetPurchase = "";
            if (sizeof($purchasemasteridarray) > 0):
                foreach ($purchasemasteridarray as $purchasemasterid):
                    if ($IdSetPurchase == ""):
                        $IdSetPurchase = $purchasemasterid->purchaseMasterId;
                    else:
                        $IdSetPurchase = $IdSetPurchase . "," . $purchasemasterid->purchaseMasterId;
                    endif;
                endforeach;
            endif;
            if ($IdSetPurchase != ""):
                $purchasereturndetailsQr = $this->db->query("SELECT NULL AS trans, prm.date as date,p.productName as atitle,prm.purchaseMasterId as invoiceno, 'returnsales' as receiptno, pd.pcs as pcs, prd.returnedQty as qty, NULL as unit, pd.rate as rate,NULL as debit,(prd.returnedQty*pd.rate) as credit FROM purchasedetails pd JOIN productbatch pb JOIN product p JOIN purchasereturnmaster prm JOIN purchasereturndetails prd WHERE prm.purchaseMasterId IN ($IdSetPurchase) AND prm.purchaseReturnMasterId = prd.purchaseReturnMasterId AND pd.productBatchId = pb.productBatchId AND pb.productId = p.productId AND prd.purchaseDetailsId = pd.purchaseDetailsId AND p.companyId = '$company_id' AND pb.companyId = '$company_id' AND pd.companyId = '$company_id' AND prm.companyId = '$company_id' AND prd.companyId = '$company_id' AND (prm.date BETWEEN '$date_from' AND '$date_to')");
                $purchasereturnsdetailsdata = $purchasereturndetailsQr->result();
            else:
                $purchasereturnsdetailsdata = array();
            endif;

            $alldataarr = array();
            $alldataarr = array_merge($salesdetailsdata, $salesDiscountdata, $salesreturndetailsdata, $salesreadydetailsdata, $paymentdetails, $salesreadystockmasterdata, $receiptdetailsdata, $journaldetailsdata, $purchasereturnsdetailsdata);

            if (sizeof($alldataarr) > 0):

                function sortdataarray($a, $b) {
                    $t1 = strtotime($a->date);
                    $t2 = strtotime($b->date);
                    return $t1 - $t2;
                }

                usort($alldataarr, 'sortdataarray');
            endif;
            $data['allcustomerdata'] = $alldataarr;
            //print_r($salesreadydetailsdata);            exit();
            //print_r($data['allcustomerdata']);            exit();

            if ($acledgerid != ""):
                $ledgerinfoQr = $this->db->query("SELECT accNo, acccountLedgerName, address, nameOfBusiness FROM accountledger WHERE ledgerId = '$acledgerid'");
                $data['accountno'] = $ledgerinfoQr->row()->accNo;
                $data['ledgername'] = $ledgerinfoQr->row()->acccountLedgerName;
                $data['address'] = $ledgerinfoQr->row()->address;
                $data['businessname'] = $ledgerinfoQr->row()->nameOfBusiness;
            else:
                $data['accountno'] = "";
                $data['ledgername'] = "";
                $data['address'] = "";
                $data['businessname'] = "";
                $data['allcustomerdata'] = array();
            endif;

            if ($acledgerid != ""):
                $companyQr = $this->db->query("SELECT companyName, address, email,logo FROM company WHERE companyId = '$company_id'");
                $data['comname'] = $companyQr->row()->companyName;
                $data['comaddress'] = $companyQr->row()->address;
                $data['comemail'] = $companyQr->row()->email;
                $data['logoname'] = $companyQr->row()->logo;
            else:
                $data['comname'] = "";
                $data['comaddress'] = "";
                $data['comemail'] = "";
                $data['logoname'] = "";
            endif;


            $data['selectedledgerid'] = $acledgerid;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('sales/customerreport', $data);
            $this->load->view('footer', $data);
            $this->load->view('sales/customerscript', $data);
        else:
            redirect('login');
        endif;
    }

    public function salesReportSales() {
        if ($this->sessiondata['username'] != NULL && $this->sessiondata['status'] == 'login' && ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r' || $this->sessiondata['userrole'] == 'u')):
            $data['title'] = "Sales Report";
            $data['active_menu'] = "report";
            $data['active_sub_menu'] = "salesreport_sales";
            $data['baseurl'] = $this->config->item('base_url');
            $company_data = $this->session->userdata('logindata');
            $company_id = $company_data['companyid'];
            $data['company_id'] = $company_id;
            $cst = $this->sessiondata['userid'];
            $resultRole = $this->db->query("SELECT `role` FROM `user` WHERE companyId = '$company_id'  AND userId='$cst'");
            if ($resultRole->row()->role == 'u') {
                $resultLedgerId = $this->db->query("SELECT ledgerId FROM accountledger WHERE companyId = '$company_id' AND accountGroupId = '28' AND cst='$cst'");
                $acledgerid = $resultLedgerId->row()->ledgerId;
            } else {
                $acledgerid = $this->input->post('customername');
            }
            //13 for farmer and 28 for customer
            $districtQry = $this->db->query("SELECT * FROM district");
            $data['districtList'] = $districtQry->result();
            $productnameQr = $this->db->query("SELECT productName, productId FROM product WHERE companyId = '$company_id'");
            $data['productList'] = $productnameQr->result();
            $acledgernameQr = $this->db->query("SELECT ledgerId, accNo, acccountLedgerName,cst FROM accountledger WHERE companyId = '$company_id' AND accountGroupId = '28'");
            $data['customerlist'] = $acledgernameQr->result();
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $districtname = $this->input->post('districtname');
            $productname = $this->input->post('productname');
            $data['checkCusOrDis'] = $this->input->post('feed_report_radio');
            if (($date_from == "") && ($date_to == "")) {
                $today_date = date('Y-m-d');
                $date_from = $this->sessiondata['mindate'];
                $date_to = $today_date;
            }
            $date_from = substr($date_from, 0, 10);
            $date_to = substr($date_to, 0, 10);
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";
            $strtotime_form = strtotime($date_from);
            $previous_dateadd = strtotime("-1 day", $strtotime_form);
            $beforefromdate = date('Y-m-d', $previous_dateadd);
            $beforefromdate = $beforefromdate . " 23:59:59";
            $initialdate = "2000-01-01 00:00:00";
            $data['districtname'] = $districtname;
            $data['productname'] = $productname;
            $data['selectedledgerid'] = $acledgerid;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            if ($acledgerid != "" && $productname == "" && $districtname == ""):
                $salesQry = $this->db->query("SELECT
                sm.date as date,
                ac.acccountLedgerName as customername,
                ac.district as districtname,
                p.productName as productname,
                sd.rate as rate,
                SUM(sd.qty) as qty,
                SUM(sd.qty*sd.rate) as amount
                FROM salesdetails sd
                JOIN salesmaster sm ON sd.salesMasterId = sm.salesMasterId              
                JOIN productbatch pb JOIN product p 
                JOIN accountledger ac ON ac.ledgerId = sm.ledgerId  
                where sm.ledgerId = '$acledgerid'
                AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId
                AND sm.companyId = '$company_id' AND sd.companyId = '$company_id' AND p.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to') GROUP BY p.productName");
                $data['salesdetailsdata'] = $salesQry->result();
                $data['noCustomername'] = '';
            elseif ($districtname != "" && $productname == "" && $acledgerid == ""):
                $salesQry = $this->db->query("SELECT
                sm.date as date,
                ac.acccountLedgerName as customername,
                ac.district as districtname,
                p.productName as productname,
                sd.rate as rate,
                SUM(sd.qty) as qty,
                SUM(sd.qty*sd.rate) as amount
                FROM salesdetails sd
                JOIN salesmaster sm ON sd.salesMasterId = sm.salesMasterId              
                JOIN productbatch pb JOIN product p 
                JOIN accountledger ac ON ac.ledgerId = sm.ledgerId 
                where ac.district = '$districtname'
                AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId
                AND sm.companyId = '$company_id' AND sd.companyId = '$company_id' AND p.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to') GROUP BY ac.acccountLedgerName");
                $data['salesdetailsdata'] = $salesQry->result();
                $data['noCustomername'] = '';
            elseif ($productname != "" && $acledgerid == "" && $districtname == ""):
                $salesQry = $this->db->query("SELECT
                sm.date as date,
                ac.acccountLedgerName as customername,
                ac.district as districtname,
                p.productName as productname,
                sd.rate as rate,
                SUM(sd.qty) as qty,
                SUM(sd.qty*sd.rate) as amount
                FROM salesdetails sd
                JOIN salesmaster sm ON sd.salesMasterId = sm.salesMasterId              
                JOIN productbatch pb JOIN product p 
                JOIN accountledger ac ON ac.ledgerId = sm.ledgerId 
                where p.productId = '$productname'
                AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId
                AND sm.companyId = '$company_id' AND sd.companyId = '$company_id' AND p.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to') GROUP BY ac.acccountLedgerName");
                $data['salesdetailsdata'] = $salesQry->result();
                $data['noCustomername'] = 'customernamehide';
            elseif ($acledgerid != "" && $productname != ""):
                $salesQry = $this->db->query("SELECT
                sm.date as date,
                ac.acccountLedgerName as customername,
                ac.district as districtname,
                p.productName as productname,
                sd.rate as rate,
                SUM(sd.qty) as qty,
                SUM(sd.qty*sd.rate) as amount
                FROM salesdetails sd
                JOIN salesmaster sm ON sd.salesMasterId = sm.salesMasterId              
                JOIN productbatch pb JOIN product p 
                JOIN accountledger ac ON ac.ledgerId = sm.ledgerId 
                where p.productId = '$productname' AND sm.ledgerId = '$acledgerid'
                AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId
                AND sm.companyId = '$company_id' AND sd.companyId = '$company_id' AND p.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to') GROUP BY ac.acccountLedgerName");
                $data['salesdetailsdata'] = $salesQry->result();
                $data['noCustomername'] = '';
            elseif ($productname != "" && $districtname != ""):
                $salesQry = $this->db->query("SELECT
                sm.date as date,
                ac.acccountLedgerName as customername,
                ac.district as districtname,
                p.productName as productname,
                sd.rate as rate,
                SUM(sd.qty) as qty,
                SUM(sd.qty*sd.rate) as amount
                FROM salesdetails sd
                JOIN salesmaster sm ON sd.salesMasterId = sm.salesMasterId              
                JOIN productbatch pb JOIN product p 
                JOIN accountledger ac ON ac.ledgerId = sm.ledgerId 
                where p.productId = '$productname' AND ac.district = '$districtname'
                AND sd.productBatchId = pb.productBatchId AND pb.productId = p.productId
                AND sm.companyId = '$company_id' AND sd.companyId = '$company_id' AND p.companyId = '$company_id' AND (sm.date BETWEEN '$date_from' AND '$date_to') GROUP BY ac.acccountLedgerName");
                $data['salesdetailsdata'] = $salesQry->result();
                $data['noCustomername'] = '';
            else:
                $data['salesdetailsdata'] = array();
                $data['noCustomername'] = '';
            endif;
            $this->load->view('header', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('sales/salesreport', $data);
            $this->load->view('footer', $data);
            $this->load->view('sales/salesreportscript', $data);
        else:
            redirect('login');
        endif;
    }

    function getReceiptVoucher() {

        $id = $_POST['id'];
        $company_id = $_POST['company_id'];
        $data['countries'] = $this->db->query("SELECT * FROM countries");
        $countries = $data['countries']->result();
        $data['ledger'] = $this->db->query("SELECT * FROM accountledger WHERE companyId='$company_id'");
        $ledger = $data['ledger']->result();
        $data['ledgerdata'] = $this->db->query("Select * from accountledger where (companyId='$company_id' and accountGroupId='9')or(companyId='$company_id' and accountGroupId='23')");
        $ledgerdata = $data['ledgerdata']->result();
        $data['ledgerdatabycash'] = $this->db->query("Select * from accountledger where (companyId='$company_id' and accountGroupId='11')");
        $ledgerdatabycash = $data['ledgerdatabycash']->result();

        $data['alldata'] = $this->db->query("SELECT * FROM receiptmaster WHERE receiptMasterId='$id' AND companyId='$company_id'");
        $alldata = $data['alldata']->result();
        $data['paidtoname'] = $this->db->query("SELECT * FROM receiptdetails WHERE receiptMasterId='$id' AND companyId='$company_id'");
        $paidtoname = $data['paidtoname']->result();
        $temp = $paidtoname;
        foreach ($temp as $value) {
            $paymsid = $value->receiptMasterId;
            $paidid = $value->ledgerId;
            $receiptNo = $value->receiptNo;
            $amount = $value->amount;
            $chequeNumber = $value->chequeNumber;
            $chequeDate = $value->chequeDate;
        }

        $currentbalance = "";
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `ledgerposting` where  companyId='$company_id' AND ledgerId='$paidid'");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = $row->debit;
            $credit = $row->credit;
            if ($credit > $debit) {
                $total = number_format($credit - $debit, 2);
                $currentbalance = $total . ' Cr';
            }
            if ($credit < $debit) {
                $total = number_format($debit - $credit, 2);
                $currentbalance = $total . ' Dr';
            }
        }

        $receiptarr = array(
            'countries' => $countries,
            'ledger' => $ledger,
            'ledgerdata' => $ledgerdata,
            'ledgerdatabycash' => $ledgerdatabycash,
            'alldata' => $alldata,
            'paymsid' => $paymsid,
            'paidid' => $paidid,
            'receiptNo' => $receiptNo,
            'amount' => $amount,
            'chequeNumber' => $chequeNumber,
            'chequeDate' => $chequeDate,
            'amount' => $amount,
            'chequeNumber' => $chequeNumber,
            'currentbalance' => $currentbalance
        );

        echo json_encode($receiptarr);
    }

    function getPaymentVoucher() {

        $id = $_POST['id'];
        $company_id = $_POST['company_id'];
        $data['countries'] = $this->db->query("SELECT * FROM countries");
        $countries = $data['countries']->result();
        $data['ledger'] = $this->db->query("SELECT * FROM accountledger WHERE companyId='$company_id'");
        $ledger = $data['ledger']->result();
        $data['ledgerdata'] = $this->db->query("Select * from accountledger where (companyId='$company_id' and accountGroupId='9')or(companyId='$company_id' and accountGroupId='23')");
        $ledgerdata = $data['ledgerdata']->result();
        $data['ledgerdatabycash'] = $this->db->query("Select * from accountledger where (companyId='$company_id' and accountGroupId='11')");
        $ledgerdatabycash = $data['ledgerdatabycash']->result();

        $data['alldata'] = $this->db->query("SELECT * FROM paymentmaster WHERE paymentMasterId='$id' AND companyId='$company_id'");
        $alldata = $data['alldata']->result();
        $data['paidtoname'] = $this->db->query("SELECT * FROM paymentdetails WHERE paymentMasterId='$id' AND companyId='$company_id'");
        $paidtoname = $data['paidtoname']->result();
        $temp = $paidtoname;
        foreach ($temp as $value) {
            $paymsid = $value->paymentMasterId;
            $paidid = $value->ledgerId;
//                    $receiptNo = $value->receiptNo;
            $amount = $value->amount;
            $chequeNumber = $value->chequeNumber;
            $chequeDate = $value->chequeDate;
        }
        $currentbalance = "";
        $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `ledgerposting` where  companyId='$company_id' AND ledgerId='$paidid'");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $debit = $row->debit;
            $credit = $row->credit;
            if ($credit > $debit) {
                $total = number_format($credit - $debit, 2);
                $currentbalance = $total . ' Cr';
            }
            if ($credit < $debit) {
                $total = number_format($debit - $credit, 2);
                $currentbalance = $total . ' Dr';
            }
        }

        $receiptarr = array(
            'countries' => $countries,
            'ledger' => $ledger,
            'ledgerdata' => $ledgerdata,
            'ledgerdatabycash' => $ledgerdatabycash,
            'alldata' => $alldata,
            'paymsid' => $paymsid,
            'paidid' => $paidid,
//            'receiptNo' => $receiptNo,
            'amount' => $amount,
            'chequeNumber' => $chequeNumber,
            'chequeDate' => $chequeDate,
            'amount' => $amount,
            'chequeNumber' => $chequeNumber,
            'currentbalance' => $currentbalance
        );

        echo json_encode($receiptarr);
    }

    function getJournalEntry() {

        $id = $_POST['id'];
        $company_id = $_POST['company_id'];
        $data['ledger'] = $this->db->query("SELECT * FROM accountledger WHERE companyId='$company_id'");
        $ledger = $data['ledger']->result();
        $masterid = $id;
        $data['sortalldata'] = $this->db->query("SELECT * FROM journalmaster WHERE journalMasterId='$masterid' AND companyId='$company_id'");
        $sortalldata = $data['sortalldata']->result();
        $jmasterId = $masterid;

        $getidData = $this->db->query("select * from journaldetails where journalMasterId = '$jmasterId' AND companyId = '$company_id'");
        $getLedgerData = $this->db->query("select * from ledgerposting where voucherNumber = '$jmasterId' AND voucherType='Journal entry' AND companyId = '$company_id'");
        $getLedgerDataValues = $getLedgerData->result();
        $getidValues = $getidData->result();

        foreach ($sortalldata as $rows):
            $cmpid = $this->sessiondata['companyid'];
            $id = $rows->journalMasterId;
            $date = $rows->date;
            $description = $rows->description;

            $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `ledgerposting` where companyId='$cmpid' AND (voucherType='Journal entry'AND voucherNumber='$id')");
            if ($query->num_rows() > 0) {
                $value = $query->row();
                $debit = $value->debit;
                $credit = $value->credit;
            }
        endforeach;

        $receiptarr = array(
            'ledger' => $ledger,
            'sortalldata' => $sortalldata,
            'jmasterId' => $jmasterId,
            'getLedgerDataValues' => $getLedgerDataValues,
            'getidValues' => $getidValues,
            'date' => $date,
            'description' => $description,
            'debit' => $debit,
            'credit' => $credit
        );

        echo json_encode($receiptarr);
    }

}

?>