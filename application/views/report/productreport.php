<style type="text/css">
    .btn-group>.btn:first-child {
        margin-left: 0;
        margin-top: 0px;
    }
</style>

<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Product Report
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('report/productreport'); ?>">
                            <div class="form-group">
                                <div class="col-md-5" style="padding-left: 0">
                                    <div class="input-group input-sm" >
                                        <span class="input-group-addon">From </span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" id="datetimepickerfrom" class="form-control" name="date_from"
                                                   value="<?php echo $date_from; ?>">
                                        </div>
                                        <span class="input-group-addon">To</span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" id="datetimepickerto" class="form-control" name="date_to" 
                                                   value="<?php echo $date_to; ?>">
                                        </div>
                                    </div>
                                </div>                             

                                <div class="col-md-3 myselect" style="padding-top: 5px;">
                                    <select name="productname" required="" class="form-control m-bot15 selectpicker" data-live-search="true">
                                        <option value="">-- Select Product Name --</option>
                                        <?php
                                        if (sizeof($productInfo) > 0):
                                            foreach ($productInfo as $row):
                                                if ($selectedproductid == $row->productId):
                                                    ?>
                                                    <option value="<?php echo $row->productId; ?>" selected="selected"><?php echo $row->productName; ?></option>
                                                    <?php
                                                else:
                                                    ?>
                                                    <option value="<?php echo $row->productId; ?>"><?php echo $row->productName; ?></option>
                                                <?php
                                                endif;
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>  

                                <div class="col-md-2">   
                                    <label>
                                        <button class="btn btn-info" id="productsubmit" type="submit">Submit</button>
                                    </label>   
                                </div>

                                <div class="col-md-2">   
                                    <div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Export <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="#" id="btnExport"> Save as CSV</a></li>
                                            <li><a href="#" onclick="generatePdf()" >Save as PDF</a></li>
                                            <li><a href="#" onclick="Clickheretoprint()">Print Report</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>     
                            <p>  </p>
                        </form>                       
                    </div>

                    <br/>
                    <div>
                        <table  class="table table-striped table-hover table-bordered tab-pane active editable-sample1" id="editable-sample">
                            <thead>
                                <tr>
                                    <th> Date </th>
                                    <th> Voucher Number </th>
                                    <th> Voucher Type </th>
                                    <th> Account Name </th>
                                    <th> Purchase/Sales Return </th>
                                    <th> Sales/Purchase Return </th>
                                    <th> Balance </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>  
                                    <td style="text-align: left;font-weight:bold;"><?php echo "Opening Balance"; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;font-weight:bold;"><?php
                                        if ($openingbal == 0):
                                            echo "0";
                                        else:
                                            echo number_format($openingbal);
                                        endif;
                                        ?>
                                    </td> 
                                </tr>

                                <?php
                                $alldebit = 0;
                                $allcredit = 0;
                                $currbalance = 0;
                                $prebalance = $openingbal;

                                if (sizeof($productData) > 0):
                                    foreach ($productData as $row):
                                        #####################  balance column #############################
                                        $debit = $row->debit;
                                        $credit = $row->credit;

                                        $alldebit += $row->debit;
                                        $allcredit += $row->credit;
                                        $currbalance = $debit - $credit + $prebalance;
                                        #echo $currbalance;                                                exit();
                                        $prebalance = $currbalance;
                                        ?>
                                        <tr>
                                            <td><?php echo $row->date ?></td>
                                            <td>
                                                <?php
                                                $chk = $row->voucherType;
                                                if ($chk == "Purchase Invoice"):
                                                    ?>
                                                    <a href="#" onclick="getPurchaseInvoice(<?php echo $row->voucherNumber ?>);" ><?php echo $row->voucherNumber ?></a>
                                                    <?php
                                                elseif ($chk == "Sales Invoice"):
                                                    ?>

                                                    <a href="#" onclick="getSalesInvoice(<?php echo $row->voucherNumber ?>);" ><?php echo $row->voucherNumber ?></a>
                                                    <?php
                                                else :
//                                                    ${'pid' . $counter} = "";
//                                                    ${'sid' . $counter} = "";
                                                    echo $row->voucherNumber;
                                                endif;
                                                ?>

                                            </td>
                                            <td><?php echo $row->voucherType ?></td>
                                            <td><?php
                                        if ($row->voucherType == "Purchase Invoice"):
                                            $purchaseMasterId = $row->voucherNumber;
                                            $ledgerIdQuery = $this->db->query("SELECT ledgerId FROM purchasemaster WHERE purchaseMasterId='$purchaseMasterId' AND companyId='$companyId'");
                                            $ledgerId = $ledgerIdQuery->row()->ledgerId;
                                            $customerNameQuery = $this->db->query("SELECT acccountLedgerName FROM accountledger WHERE ledgerId='$ledgerId'  AND companyId='$companyId'");
                                            if ($customerNameQuery->num_rows() > 0):
                                                echo $customerNameQuery->row()->acccountLedgerName;
                                            else:
                                                echo "N/A";
                                            endif;

                                        elseif ($row->voucherType == "Sales Invoice") :
                                            $salesMasterId = $row->voucherNumber;
                                            $ledgerIdQuery = $this->db->query("SELECT ledgerId FROM salesmaster WHERE salesMasterId='$salesMasterId' AND companyId='$companyId'");
                                            $ledgerId = $ledgerIdQuery->row()->ledgerId;
                                            $customerNameQuery = $this->db->query("SELECT acccountLedgerName FROM accountledger WHERE ledgerId='$ledgerId'  AND companyId='$companyId'");
                                            if ($customerNameQuery->num_rows() > 0):
                                                echo $customerNameQuery->row()->acccountLedgerName;
                                            else:
                                                echo "N/A";
                                            endif;
                                        endif;
                                                ?></td>
                                            <td style="text-align: right;"><?php echo floor($row->debit) == $row->debit ? number_format($row->debit) : number_format($row->debit, 3); ?></td>
                                            <td style="text-align: right;"><?php echo floor($row->credit) == $row->credit ? number_format($row->credit) : number_format($row->credit, 3); ?></td>
                                            <td style="text-align: right"><?php
                                        if ($currbalance == 0):
                                            echo "0";
                                        else:
                                            echo floor($currbalance) == $currbalance ? number_format($currbalance) : number_format($currbalance, 3);
                                            ;
                                        endif;
                                                ?>
                                            </td>
                                        </tr>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>                              
                            </tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="font-weight:bold;"> Net Balance</td>                                     
                                <td style="text-align: right;font-weight:bold;"><?php echo floor($alldebit) == $alldebit ? number_format($alldebit) : number_format($alldebit, 3); ?></td>
                                <td style="text-align: right;font-weight:bold;"><?php echo floor($allcredit) == $allcredit ? number_format($allcredit) : number_format($allcredit, 3); ?></td>
                                <td style="text-align: right;font-weight:bold;"><?php
                                if ($currbalance == 0):
                                    echo "0";
                                else:
                                    echo floor($currbalance) == $currbalance ? number_format($currbalance) : number_format($currbalance, 3);
                                endif;
                                        ?></td>   
                            </tr>                  
                        </table>
                    </div>
                </div>
            </div>   
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->




<!-------------------------Purchase Invoice------------------------------------->
<div class="modal fade" id="myModalPurchase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Purchase Invoice</h4>
            </div>
            <div class="modal-body">              

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-body">
                            <div class="adv-table">                                    
                                <div class="row">
                                    <div class="form-group col-sm-5">
                                        <label for="corparty_account" class="col-sm-4 control-label">Cash/Party </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"  id="cashparty" disabled/>

                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="invoice_data" class="col-sm-4 control-label text-left"> Date</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="date"  id="date" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="invoive_number" class="col-sm-5 control-label text-left">Invoice Number</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="invoive_number" id="invoive_number" placeholder="Invoice Number" required  disabled>
                                        </div>
                                    </div>                                        
                                </div>

                                <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                            <th>Free Qty</th>
                                            <th>Unit</th>
                                            <th>Rate</th>
                                            <th>Sale Rate</th>
                                            <th>Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody id="addnewrowedit">


                                    </tbody>
                                </table>
                                <div class="panel-body">
                                    <div class="row">                                            
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="description" class="col-sm-4 control-label">Description</label>
                                                <div class="col-sm-8">
                                                    <textarea name="description" id="description" cols="30" rows="5" disabled></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-sm-offset-2">
                                            <ul class="unstyled amounts">                                                     
                                                <li class="text-center"><strong>Total Amount : </strong><span id="total_amout" class="align-right ">                                                                   
                                                    </span></li>
                                                <li class="text-center"><strong>Discount :</strong> <span class="align-right ">
                                                        <input type="text" name="discount" id="discount" style="width: 40px"  disabled/></span></li>
                                                <li class="text-center"><strong>Other Cost :</strong> <span class="align-right ">
                                                        <input type="text" name="transport" id="transport" style="width: 40px"  disabled/></span></li>
                                                <li class="text-center"><strong>Net Amount :</strong> <span id="net_amout" class="align-right "></span></li>                                                      
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">            
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-------------------------End Purchase Invoice------------------------------------->



<!-------------------------Sales Invoice------------------------------------->
<div class="modal fade" id="myModalSales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Sales Invoice</h4>
            </div>
            <div class="modal-body">              

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-body">
                            <div class="adv-table">                                                           
                                <div class="row">
                                    <div class="form-group col-sm-5">
                                        <label for="corparty_account" class="col-sm-3 control-label custom">Bill to </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="billto"  id="billto" disabled/>   
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label for="invoice_data" class="col-sm-4 control-label text-left">Date</label>
                                        <div class="col-sm-8">                                                                      
                                            <input type="text" class="form-control" name="datesales"  id="datesales" disabled/>                                       

                                        </div>
                                    </div>                                  
                                </div>
                                                          
                            </div>
                            <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="addnewroweditsales">

                                </tbody>

                            </table>
                            <div class="panel-body">
                                <div class="row">
                                      <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description" class="col-sm-4">Description</label>
                                        <div class="col-sm-8">
                                            <textarea name="descriptionsales" maxlength="100"  id="descriptionsales" cols="30" rows="5" disabled></textarea>
                                        </div>
                                    </div>
   </div>
                                    <div class="col-sm-6 col-sm-offset-2">
                                        <ul class="unstyled amounts">
                                            <li class="text-center"><strong>Total Amount : </strong><span id="total_amout_sales" class="align-right "> 0.00 </span></li>
                                            <li class="text-center"><strong>Discount :</strong><span class="align-right">
                                                    <input type="text" name="discount_sales" id="discount_sales" style="width: 40px" disabled/></span></li>
                                            <li class="text-center"><strong >VAT 5%(+):</strong>     
                                                    <span id="vatspansales" class="align-right"></span>     
                                                     
                                          <!--  <li><strong class="col-lg-5">Transport Cost :</strong> <span class="align-right "> -->
                                             <!-- </span></li> -->
                                            <li class="text-center"><strong>Previous Amount: </strong><span id="previous_amount_sales" class="align-right"> </span> </li>
                                            <li class="text-center"><strong>Net Amount:</strong> <span id="net_amout_sales" class="align-right "></span></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">            
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-------------------------End Sales Invoice------------------------------------->


