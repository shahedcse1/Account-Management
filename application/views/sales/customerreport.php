<style type="text/css">
    .btn-group>.btn:first-child {
        margin-left: 0;
        margin-top: 0px;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading">
                Customer Report
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('sales/salesreport/customerreport'); ?>">
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

                                <div class="col-md-2 myselect" style="padding-top: 5px;">
                                    <?php
                                    if ($this->sessiondata['userrole'] == 'u'):
                                        echo '<select name="customername"  disabled class="form-control m-bot15 selectpicker" data-live-search="true">';
                                    else :
                                        echo '<select name="customername"  class="form-control m-bot15 selectpicker" data-live-search="true">';
                                    endif;
                                    ?>
                                    <option value="">-- Select Customer Name --</option>
                                    <?php
                                    if (sizeof($customerlist) > 0):
                                        $this->sessiondata = $this->session->userdata('logindata');
                                        foreach ($customerlist as $customerrow):
                                            if ($this->sessiondata['userrole'] == 'u' && $this->sessiondata['userid'] == $customerrow->cst):
                                                ?>
                                                <option <?php
                                                if ($selectedledgerid == $customerrow->ledgerId) {
                                                    echo 'selected';
                                                }
                                                ?> value="<?php echo $customerrow->ledgerId; ?>"><?php echo $customerrow->accNo . '-' . $customerrow->acccountLedgerName; ?></option>
                                                    <?php
                                                endif;
                                                if ($this->sessiondata['userrole'] == 'a' || $this->sessiondata['userrole'] == 's' || $this->sessiondata['userrole'] == 'r'):
                                                    ?>        

                                                <option <?php
                                                if ($selectedledgerid == $customerrow->ledgerId) {
                                                    echo 'selected';
                                                }
                                                ?> value="<?php echo $customerrow->ledgerId; ?>"><?php echo $customerrow->accNo . '-' . $customerrow->acccountLedgerName; ?></option>
                                                    <?php
                                                endif;
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>  

                                <div class="col-md-2">   
                                    <label>
                                        <button class="btn btn-info" type="submit">Submit</button>
                                    </label>   
                                </div>

                                <div class="col-md-3">   
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

                    <div class="tab-content">
                        <div role="tabpanel" id="ledger"  class="tab-pane active">
                            <table  class="table table-striped table-hover table-bordered tab-pane active editable-sample1" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th style="width: 12%">Date</th>
                                        <th style="width: 6%"> Bill No </th>
                                        <th style="width: 24%"> Description </th>
                                        <th style="width: 6%"> Pcs </th>
                                        <th style="width: 6%"> Qty </th>
                                        <th style="width: 6%"> Unit </th>
                                        <th style="width: 6%"> Rate </th>
                                        <th style="width: 10%"> Amount (Dr.) </th>                                                                              
                                        <th style="width: 10%"> Amount (Cr.)</th>
                                        <th style="width: 14%"> Balance </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($selectedledgerid != ""): ?>
                                        <tr class="">
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: left"><?php echo "Opening Balance"; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right;font-weight:bold;"><?php
                                                if ($openingbal < 0):
                                                    echo number_format(abs($openingbal), 2) . " Cr.";
                                                elseif ($openingbal == 0):
                                                    echo "0.00";
                                                else:
                                                    echo number_format($openingbal, 2) . " Dr.";
                                                endif;
                                                ?>
                                            </td>    
                                        </tr>
                                    <?php else: ?>
                                        <tr class=""> <td colspan="10"> No data found to display </td>
                                        <?php endif; ?>
                                        <?php
                                        $alldebit = 0;
                                        $allcredit = 0;
                                        $currbalance = $openingbal;
                                        $prebalance = $openingbal;
                                        $invoicepre = "";
                                        if (sizeof($allcustomerdata) > 0):
                                            foreach ($allcustomerdata as $datarow):
                                                $debit = $datarow->debit;
                                                $credit = $datarow->credit;
                                                if ($datarow->invoiceno != $invoicepre) {
                                                    $debit = $datarow->debit + $datarow->trans;
                                                } else {
                                                    $debit = $datarow->debit;
                                                }
                                                $invoicepre = $datarow->invoiceno;
                                                $alldebit += $debit;
                                                $allcredit += $credit;
                                                $currbalance = $debit - $credit + $prebalance;
                                                #echo $currbalance;                                                exit();
                                                $prebalance = $currbalance;
                                                ?>
                                            <tr class="">
                                                <td><?php
                                                    $datevalue = date_create($datarow->date);
                                                    $dayvalue = date_format($datevalue, 'd');
                                                    $monvalue = date_format($datevalue, 'F');
                                                    $yrval = date_format($datevalue, 'Y');
                                                    echo $dayvalue . ' ' . substr($monvalue, 0, 3) . '  ' . $yrval;
                                                    ?></td>
                                                <td>
                                                    <?php
                                                    $chk = $datarow->atitle;
                                                    if ($chk == "Receipt Voucher"):
                                                        ?>
                                                        <a href="#"  onclick="getReceiptVoucher(<?php echo $datarow->invoiceno; ?>);"><?php echo $datarow->invoiceno; ?></a>         
                                                        <?php
                                                    elseif ($chk == "Payment Voucher") :
                                                        ?>
                                                        <a href="#"  onclick="getPaymentVoucher(<?php echo $datarow->invoiceno; ?>);"><?php echo $datarow->invoiceno; ?></a>                                                                                                            
                                                        <?php
                                                    elseif ($chk == "Journal Entry") :                                                     
                                                        ?>                                                      
                                                        <a href="#"  onclick="getJournalEntry(<?php echo $datarow->invoiceno; ?>);"><?php echo $datarow->invoiceno; ?></a>                                                       
                                                        <?php
                                                    else:
                                                        echo $datarow->invoiceno;
                                                    endif;
                                                    ?>
                                                </td>
                                                <td style="text-align: left"><?php
                                                    if ($datarow->atitle == "Ready Hen" || $datarow->pcs > 0):
                                                        if ($credit > $debit):  // if credit > debit then a customer behave like a farmer.. 
                                                            $queryledger = $this->db->query("SELECT al.acccountLedgerName FROM accountledger al JOIN salesreadystockdetails srsd ON al.ledgerId = srsd.ledgerId WHERE srsd.salesReadyStockMasterId = '$datarow->invoiceno' AND al.companyId = '$company_id' AND srsd.companyId = '$company_id'");
                                                        else:
                                                            $queryledger = $this->db->query("SELECT al.acccountLedgerName FROM accountledger al JOIN salesreadystockmaster srsm ON al.ledgerId = srsm.ledgerId WHERE srsm.salesReadyStockMasterId = '$datarow->invoiceno' AND al.companyId = '$company_id' AND srsm.companyId = '$company_id'");
                                                        endif;
                                                        if ($queryledger->num_rows() > 0 && $debit > $credit):
                                                            echo $datarow->atitle . ' from ' . $queryledger->row()->acccountLedgerName;
                                                        elseif ($queryledger->num_rows() > 0 && $credit > $debit):
                                                            echo $datarow->atitle . ' to ' . $queryledger->row()->acccountLedgerName;
                                                        else:
                                                            echo $datarow->atitle;
                                                        endif;
                                                    elseif ($datarow->receiptno == "returnsales"):
                                                        echo $datarow->atitle . ' - Return';
                                                    else:
                                                        echo $datarow->atitle;
                                                    endif;
                                                    ?></td>                                              
                                                <td><?php echo floor($datarow->pcs) == $datarow->pcs ? number_format($datarow->pcs) : number_format($datarow->pcs, 3); ?></td>
                                                <td><?php
                                                    echo floor($datarow->qty) == $datarow->qty ? number_format($datarow->qty) : number_format($datarow->qty, 3);
                                                    ;
                                                    ?></td>
                                                <td><?php echo $datarow->unit; ?></td>
                                                <td><?php echo $datarow->rate; ?></td>
                                                <td style="text-align: right"><?php echo number_format($datarow->debit, 2); ?></td>
                                                <td style="text-align: right"><?php echo number_format($datarow->credit, 2); ?></td>
                                                <td style="text-align: right"><?php
                                                    if ($currbalance < 0):
                                                        echo number_format(abs($currbalance), 2) . " Cr.";
                                                    elseif ($currbalance == 0):
                                                        echo "0.00";
                                                    else:
                                                        echo number_format($currbalance, 2) . " Dr.";
                                                    endif;
                                                    ?>
                                                </td>    

                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>

                                <tr class="">
                                    <td></td>
                                    <td></td>
                                    <td style="font-weight:bold;"> Net Balance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>                                     
                                    <td style="text-align: right;font-weight:bold;"><?php echo number_format($alldebit, 2); ?></td>
                                    <td style="text-align: right;font-weight:bold;"><?php echo number_format($allcredit, 2); ?></td>
                                    <td style="text-align: right;font-weight:bold;"><?php
                                        if ($currbalance < 0):
                                            echo number_format(abs($currbalance), 2) . " Cr.";
                                        elseif ($currbalance == 0):
                                            echo "0.00";
                                        else:
                                            echo number_format($currbalance, 2) . " Dr.";
                                        endif;
                                        ?></td>   
                                </tr>
                            </table>                           
                        </div>                      
                    </div>
                </div>
            </div>                   </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->

<!-------------------------Recieve Vauchar------------------------------------->
<div class="modal fade" id="myModalRecieve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Receipt Voucher</h4>
            </div>
            <div class="modal-body">                       
                <div class="row">
                    <div class="col-lg-12">
                        <form class="form-horizontal" role="form" method="post" action="#">
                            <div class="row">
                                <div class="col-lg-12">
                                    <section class="panel">                    
                                        <div class="panel-body">
                                            <div class="col-lg-6">
                                                <span>
                                                    <div class="radio">
                                                        <label>
                                                            Cash Receipt
                                                            <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="By Cash" disabled/>
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="By Cheque" checked disabled/>                                                        
                                                            Bank Receipt
                                                        </label>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </section>                    
                                </div>
                            </div>   
                            <div class="col-lg-6">                                
                                <div class="form-group">
                                    <label for="receiptMode" class="col-lg-4 col-sm-2 control-label">Cash/Bank Account</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="cash_bank_acc"  disabled/>                                                                                                                                                                                                        
                                    </div>                                   
                                </div>
                                <div class="form-group">
                                    <label for="paidto" class="col-lg-4 col-sm-2 control-label">Received From </label>
                                    <div class="col-lg-8">                                        
                                        <input type="text" class="form-control" id="received_from" disabled/>                                                                                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="voucherNumber" class="col-lg-4 col-sm-2 control-label">Receipt No</label>
                                    <div class="col-lg-8">                                     
                                        <input type="text" class="form-control" id="receipt_no" name="receipt_no"  disabled/>                                        
                                    </div>
                                </div>
<!--                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-4 col-sm-2 control-label">Current Balance</label>
                                    <div class="col-lg-8" > 
                                        <input type="text" class="form-control" id="current_balance" name="current_balance"  disabled>
                                    </div>

                                </div>-->
                                <div class="form-group">
                                    <label for="amount" class="col-lg-4 col-sm-2 control-label">Amount</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="amount" name="amount"   disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-lg-4 col-sm-2 control-label"> Date</label>
                                    <div class="col-lg-8">                                        
                                        <input type="text" id="date" name="date" class="form-control"  disabled/>                                                                                  
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-4 col-sm-2 control-label">Description</label>
                                    <div class="col-lg-8">
                                        <textarea type="text" class="form-control" id="description" name="description" disabled></textarea>                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="chequeNumber" class="col-lg-4 col-sm-2 control-label">Cheque Number</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="cheque_number" name="cheque_number"  disabled/>                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="chequeDate" class="col-lg-4 col-sm-2 control-label">Cheque Date</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form_datetime form-control" id="cheque_date"  name="cheque_date"  disabled/>                                    
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">            
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-------------------------End Recieve Vauchar------------------------------------->


<!-------------------------Payment Vauchar------------------------------------->
<div class="modal fade" id="myModalPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Payment Voucher</h4>
            </div>
            <div class="modal-body">              

                <div class="row">
                    <div class="col-lg-12">
                        <form class="form-horizontal" role="form" method="post" action="#">
                            <div class="row">
                                <div class="col-lg-12">
                                    <section class="panel">                    
                                        <div class="panel-body">
                                            <div class="col-lg-6">
                                                <span>
                                                    <div class="radio">
                                                        <label>
                                                            By Cash 
                                                            <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios3" value="By Cash" disabled/>
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios4" value="By Cheque" checked disabled/>                                                        
                                                            By Cheque
                                                        </label>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </section>                    
                                </div>
                            </div>   
                            <div class="col-lg-6">                                
                                <div class="form-group">
                                    <label for="receiptMode" class="col-lg-4 col-sm-2 control-label">Cash/Bank Account</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="cash_bank_acc_p"  disabled/>                                                                                                                                                                                                        
                                    </div>                                   
                                </div>
                                <div class="form-group">
                                    <label for="paidto" class="col-lg-4 col-sm-2 control-label">Paid To</label>
                                    <div class="col-lg-8">                                        
                                        <input type="text" class="form-control" id="received_from_p" disabled/>                                                                                                       
                                    </div>
                                </div>

<!--                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-4 col-sm-2 control-label">Current Balance</label>
                                    <div class="col-lg-8" > 
                                        <input type="text" class="form-control" id="current_balance_p" name="current_balance_p"  disabled>
                                    </div>

                                </div>-->
                                <div class="form-group">
                                    <label for="amount" class="col-lg-4 col-sm-2 control-label">Amount</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="amount_p" name="amount_p"   disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-lg-4 col-sm-2 control-label"> Date</label>
                                    <div class="col-lg-8">                                        
                                        <input type="text" id="date_p" name="date_p" class="form-control"  disabled/>                                                                                  
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-4 col-sm-2 control-label">Description</label>
                                    <div class="col-lg-8">
                                        <textarea type="text" class="form-control" id="description_p" name="description_p" disabled></textarea>                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="chequeNumber" class="col-lg-4 col-sm-2 control-label">Cheque Number</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="cheque_number_p" name="cheque_number_p"  disabled/>                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="chequeDate" class="col-lg-4 col-sm-2 control-label">Cheque Date</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form_datetime form-control" id="cheque_date_p"  name="cheque_date_p"  disabled/>                                    
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="modal-footer">            

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-------------------------End Payment Vauchar------------------------------------->


<!-------------------------Journal Entry------------------------------------->
<div class="modal fade" id="myModalJournal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Journal Entry</h4>
            </div>
            <div class="modal-body">              
              
                <div class="row">
                    <div class="col-lg-12">
                        <form class="form-horizontal"  method="post" action="#">
                            <div class="form-group">                                                                         
                                <label class="col-lg-6" for="accountledger" style="text-align: center;">Account Ledger</label>                          
                                <label class="col-lg-3" for="debit" style="text-align: center;"> &nbsp; Debit</label>
                                <label class="col-lg-3" for="credit" style="text-align: center;"> &nbsp;&nbsp; Credit</label>
                            </div>                                                             
                            <div class="form-group">                                 
                                <div class="col-lg-6" id="editaccdiv">
                                                                  
                                </div>  
                                 <div  id="editdcdiv">
                                                                  
                                </div>  
                            </div>                           

                            <div class="form-group ">
                                <label for="opening_balance" style="padding-top: 8px;font-weight:700;"class="control-label col-lg-6 ">Total</label>
                                <div class="col-lg-3">
                                    <input style="border:1px solid #0A0101" class="form-control " type="text" id="edittotal_debit" placeholder="0.00"
                                           name="edittotal_debit" disabled required/> 
                                </div>                                                                
                                <div class="col-lg-3 ">
                                    <input style="border:1px solid #0A0101" class="form-control " type="text" id="edittotal_credit" placeholder="0.00"
                                           name="edittotal_credit" disabled required/>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="opening_balance" class="control-label col-lg-6">Description</label>
                                <div class="col-lg-6">
                                    <textarea class="form-control " id="editdescription" name="editdescription" cols="30" rows="3" disabled></textarea>
                                </div>                               
                            </div>

                            <div class="form-group ">
                                <label for="opening_balance" class="control-label col-lg-6">Date</label>
                                <div class="col-lg-6">                           
                                    <input class="form-control" id="editdate" name="editdate"   disabled/>
                                </div> 
                            </div>                                          
                        </form> 
                    </div> 
                </div>
            </div>
            <div class="modal-footer">            

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-------------------------End Journal Entry------------------------------------->