<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">


            <?php
            $this->sessiondata = $this->session->userdata('logindata');
            if ($this->sessiondata['userrole'] == 'a'):
                ?>
                <li class=" sub-menu " >
                    <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'master')) ? 'active' : ''; ?>" >
                        <i class="fa fa-laptop"></i>
                        <span>Master</span>
                    </a>
                    <ul class="sub">
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'accountGroup')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('home/accountGroup'); ?>">Account Group</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'accountLedger')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('accountLedger'); ?>">Account Ledger</a></li>                    
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'supplier')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('supplier/supplier'); ?>">Supplier</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'customer')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('customer/customer'); ?>">Customer</a></li>

                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'manufacture')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('manufacture/manufacture'); ?>">Manufacturer</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'unit')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('productunit/unit'); ?>">Unit</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'productGroup')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('productlist/productGroup'); ?>">Product Group</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'product')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('productlist/product'); ?>">Product</a></li>
    <!--                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'raw_product')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('productlist/rawproduct'); ?>">Raw Material</a></li>-->
    <!--                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesman')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('salesman/salesman'); ?>">Sales Man</a></li>-->

                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'transaction')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Transaction</span>
                    </a>
                    <ul class="sub">
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'purchase')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('purchase/purchase'); ?>">Purchase</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'purchasereturn')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('purchasereturn/purchase_return'); ?>">Purchase Return</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'sales')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('sales/sales'); ?>">Sales</a></li> 
    <!--                <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'productprocess')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('productprocess/productprocess'); ?>">Process a product</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'productdistribute')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('productdistribute/productdistribute'); ?>">Product Distribution</a></li>-->
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreturn')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('salesreturn/salesreturn'); ?>">Sales Return</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'paymentvoucher')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('paymentvoucher/paymentvoucher'); ?>">Payment Voucher</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'receiptvoucher')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('receiptvoucher/receiptvoucher'); ?>">Receipt Voucher</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'journalentry')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('journalentry/journalentry'); ?>">Journal Entry</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'contravoucher')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('contravoucher/contravoucher'); ?>">Contra Voucher</a></li>                     
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'inventory')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Inventory</span>
                    </a>
                    <ul class="sub">
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'stockentry')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('stockentry/stockentry'); ?>">Stock Entry</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'damagestock')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('damagestock/damagestock'); ?>">Damage stock</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;"  class="<?php echo (isset($active_menu) && ($active_menu == 'account_statement')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Accounts</span>
                    </a>
                    <ul class="sub">
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'cash_book')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('cashbook/cashbook'); ?>">Cash Book</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bank_book')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('bankbook/bankbook'); ?>">Bank Book</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'trail_balance')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('trialbalance/trialbalance'); ?>">Trial Balance</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ladger_balance')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('ledgerbalance/ledgerbalance'); ?>">Ledger Balance</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'income_statement')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incomestatement/incomestatement'); ?>">Income Statement</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'profit_loss')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('profitloss/profitlossanalysis'); ?>">Profit and Loss Analysis</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'balance_sheet')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('balancesheet/balancesheet'); ?>">Balance Sheet</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;"  class="<?php echo (isset($active_menu) && ($active_menu == 'report')) ? 'active' : ''; ?>" >
                        <i class="fa fa-laptop"></i>
                        <span>Report</span>
                    </a>
                    <ul class="sub">
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dailysale')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('dailysale/dailysale'); ?>">Daily Sale</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreport_customer')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('sales/salesreport/customerreport'); ?>">Customer Report</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreport_sales')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('sales/salesreport/salesReportSales'); ?>">Sales Report</a></li> 

                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'customer_report')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/customerduereport'); ?>">Customer's Due Report</a></li> 

                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'stock')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('stockentry/stock'); ?>">Stock</a></li>   
    <!--                        <li class="<?php // echo (isset($active_sub_menu) && ($active_sub_menu == 'daily_report')) ? 'active' : '';             ?>"><a  href="<?php // echo site_url('report/dailyreport');             ?>">Daily Report</a></li> 
                        <li class="<?php // echo (isset($active_sub_menu) && ($active_sub_menu == 'weekly_report')) ? 'active' : '';             ?>"><a  href="<?php // echo site_url('report/weeklyreport');             ?>">Weekly Report</a></li> -->
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'purchase_report')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/purchasereport'); ?>">Purchase Report</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'feed_report')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/feedreport'); ?>">Product Group Report</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'product_report')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/productreport'); ?>">Product Report</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'product_analysis_report')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/productanalysis'); ?>">Product Analysis Report</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'cashstatus')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/cashstatus'); ?>">Cash Status</a></li> 
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;"  class="<?php echo (isset($active_menu) && ($active_menu == 'setting')) ? 'active' : ''; ?>" >
                        <i class="fa fa-laptop"></i>
                        <span>Setting</span>
                    </a>
                    <ul class="sub">
                            <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'changepassword')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('password/changepassword'); ?>">Change Password</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'financialyear')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('financialyear/financialyear'); ?>">Financial Year</a></li>                     
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'accesslog')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('accesslog/accesslog'); ?>">Log</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'company')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('company/company'); ?>">Company</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'users')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('user/user'); ?>">Users</a></li>
                         <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'system')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('settings/system'); ?>">System</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'notice')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('notice/notice'); ?>">Notice</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'barcode')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('Barcodegenerator/barcode'); ?>">Barcode Generator</a></li>
                        <li><a href="<?php echo $baseurl; ?>/dbbackup/">Database Backup</a></li> 
                    </ul>
                </li>
                <?php
            endif;

            if ($this->sessiondata['userrole'] == 'r'):
                ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'master')) ? 'active' : ''; ?>" >
                        <i class="fa fa-laptop"></i>
                        <span>Master</span>
                    </a>
                    <ul class="sub">                      
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'customer')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('customer/customer'); ?>">Customer</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'transaction')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Transaction</span>
                    </a>
                    <ul class="sub">                      
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'sales')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('sales/sales'); ?>">Sales</a></li>                      
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreturn')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('salesreturn/salesreturn'); ?>">Sales Return</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'paymentvoucher')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('paymentvoucher/paymentvoucher'); ?>">Payment Voucher</a></li>                       
                    </ul>
                </li>                             
                <li class="sub-menu">
                    <a href="javascript:;"  class="<?php echo (isset($active_menu) && ($active_menu == 'report')) ? 'active' : ''; ?>" >
                        <i class="fa fa-laptop"></i>
                        <span>Report</span>
                    </a>
                    <ul class="sub">
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreport_customer')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('sales/salesreport/customerreport'); ?>">Customer Report</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'customer_report')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/customerduereport'); ?>">Customer's Due Report</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'stock')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('stockentry/stock'); ?>">Stock</a></li>   
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'cashstatus')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('report/cashstatus'); ?>">Cash Status</a></li> 
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;"  class="<?php echo (isset($active_menu) && ($active_menu == 'setting')) ? 'active' : ''; ?>" >
                        <i class="fa fa-laptop"></i>
                        <span>Setting</span>
                    </a>
                    <ul class="sub">
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'changepassword')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('password/changepassword'); ?>">Change Password</a></li>
                    </ul>
                </li>
                <?php
            endif;


            if ($this->sessiondata['userrole'] == 's'):
                ?>
                <li class="sub-menu">
                    <a href="<?php echo site_url('sales/sales'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'sales')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Sales</span>
                    </a>                    
                </li>
                <li class="sub-menu">
                    <a href="<?php echo site_url('sales/salesreport/customerreport'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreport_customer')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Customer Report</span>
                    </a>                    
                </li>
                <li class="sub-menu">
                    <a href="<?php echo site_url('stockentry/stock'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'stock')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Stock</span>
                    </a>                    
                </li>
                <li class="sub-menu">
                    <a href="<?php echo site_url('password/changepassword'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'changepassword')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Change Password</span>
                    </a>                    
                </li>                                                         
                <?php
            endif;
            ?>
            <?php
            $this->sessiondata = $this->session->userdata('logindata');
            if ($this->sessiondata['userrole'] == 'u'):
                ?>
                <li class="sub-menu">
                    <a  href="<?php echo site_url('sales/salesreport/customerreport'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreport_customer')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Customer Report</span>
                    </a>                    
                </li>
              
                <li class="sub-menu">
                    <a  href="<?php echo site_url('Barcodegenerator/barcode'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'barcodeganerator')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Barcode generator</span>
                    </a>                    
                </li> 
                
                
                <li class="sub-menu">
                    <a  href="<?php echo site_url('password/changepassword'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'changepassword')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Change Password</span>
                    </a>                    
                </li>
                <?php
            endif;
            ?>

            <?php
            $this->sessiondata = $this->session->userdata('logindata');
            if ($this->sessiondata['userrole'] == 'f'):
                ?>
                <li class="sub-menu">
                    <a  href="<?php echo site_url('sales/salesreport/farmerreport'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'salesreport_farmer')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Farmer Report</span>
                    </a>                    
                </li>
                <li class="sub-menu">
                    <a  href="<?php echo site_url('password/changepassword'); ?>" class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'changepassword')) ? 'active' : ''; ?>">
                        <i class="fa fa-laptop"></i>
                        <span>Change Password</span>
                    </a>                    
                </li>
                <?php
            endif;
            ?>
            <li class="sub-menu">
                <a  href="<?php echo site_url('aboutus/AboutUs'); ?>"><i class="fa fa-laptop"></i>About Us</a>
            </li> 
            <li class="sub-menu">
                <a  href="<?php echo site_url('login/logout'); ?>"><i class="fa fa-laptop"></i>Log Out</a>
            </li>           
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->