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
                Ledger Balance Information
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('ledgerbalance/ledgerbalance'); ?>">
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
                                    <select name="acledgername" required="" class="form-control m-bot15 selectpicker" data-live-search="true">
                                        <option value="">-- Select Ledger Name --</option>
                                        <option value="all">-- Select All --</option>
                                        <?php
                                        if (sizeof($acledgerdata) > 0):
                                            foreach ($acledgerdata as $ledgerrow):
                                                if ($selectedledgerid == $ledgerrow->ledgerId):
                                                    ?>
                                                    <option value="<?php echo $ledgerrow->ledgerId; ?>" selected="selected"><?php echo $ledgerrow->accNo . '-' . $ledgerrow->acccountLedgerName; ?></option>
                                                    <?php
                                                else:
                                                    ?>
                                                    <option value="<?php echo $ledgerrow->ledgerId; ?>"><?php echo $ledgerrow->accNo . '-' . $ledgerrow->acccountLedgerName; ?></option>
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
                            <p> &nbsp; </p>
                        </form>                       
                    </div>

                    <div class="tab-content">
                        <div role="tabpanel" id="ledger"  class="tab-pane active">
                            <table  class="table table-striped table-hover table-bordered tab-pane active editable-sample1" id="editable-sample">

                                <?php if ($selectedledgerid == 'all'): ?>
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Account Ledger</th>
                                            <th>Account Group</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $lageralldebit = 0;
                                        $lagerallcredit = 0;
                                        $ledgerdatasize = sizeof($ledgerwisedata);
                                        if ($ledgerdatasize > 0):
                                            $sl = 0;
                                            foreach ($ledgerwisedata as $datarow):
                                                $sl++;
                                                ?>
                                                <tr class="">
                                                    <td><?php echo $sl; ?></td>
                                                    <td style="text-align: left"><?php echo $datarow->acccountLedgerName; ?></td>
                                                    <td style="text-align: left"><?php echo $datarow->accountGroupName; ?></td>
                                                    <?php if ($datarow->debitsum > $datarow->creditsum): ?>
                                                        <td style="text-align: right"><?php echo number_format(($datarow->debitsum - $datarow->creditsum), 2); ?></td>
                                                        <td style="text-align: right"> 0.00 </td>
                                                        <?php
                                                        $debitval = $datarow->debitsum - $datarow->creditsum;
                                                        $creditval = 0;
                                                    else:
                                                        ?>
                                                        <td style="text-align: right"> 0.00 </td>
                                                        <td style="text-align: right"><?php echo number_format(($datarow->creditsum - $datarow->debitsum), 2); ?></td>
                                                        <?php
                                                        $debitval = 0;
                                                        $creditval = $datarow->creditsum - $datarow->debitsum;
                                                    endif;
                                                    $lageralldebit += $debitval;
                                                    $lagerallcredit += $creditval;
                                                    ?>
                                                </tr>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                        <tr class="">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right; font-weight:bold"><?php echo number_format($lageralldebit, 2); ?></td>
                                            <td style="text-align: right; font-weight:bold"><?php echo number_format($lagerallcredit, 2); ?></td>
                                        </tr>
                                        <tr class="">
                                            <td></td>
                                            <td style="font-weight:bold">Total Balance</td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight:bold"> <?php
                                                if ($lageralldebit > $lagerallcredit):
                                                    echo number_format(($lageralldebit - $lagerallcredit), 2) . " Dr";
                                                elseif ($lagerallcredit > $lageralldebit):
                                                    echo number_format(($lagerallcredit - $lageralldebit), 2) . " Cr";
                                                else:
                                                    echo number_format(($lagerallcredit - $lageralldebit), 2);
                                                endif;
                                                ?> </td>                                       
                                        </tr>
                                    </tbody>

                                <?php else: ?>

                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Voucher No</th>
                                            <th>Voucher Type</th>
                                            <th>Ledger Name</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $openingdebit = 0;
                                        $openingcredit = 0;
                                        if ($selectedledgerid != ""):
                                            ?>
                                            <tr class="">
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                               <td style="text-align: left"><?php echo "Opening Balance"; ?></td>

                                                <?php
                                                if (substr($openingbal, 0, 1) == "-"):
                                                    echo '<td> </td>';
                                                    echo '<td> </td>';
                                                     
                                                    
                                                    echo "<td style='text-align: right; font-weight:bold'>" . substr($openingbal, 1) . " Cr</td>";
                                                    $openingcredit = substr($openingbal, 1);
                                                elseif ($openingbal == 0):
                                                    
                                                    echo '<td style="text-align: right"> 0.00 </td>';
                                                    echo '<td style="text-align: right"> 0.00 </td>';
                                                    echo '<td style="text-align: right"> 0.00 </td>';
                                                else:
                                                   // echo '<td>  </td>';
                                                    echo '<td>  </td>';
                                                    
                                                    echo "<td style='text-align: right; font-weight:bold'>" . $openingbal . " Dr</b></td>";
                                                    $openingdebit = $openingbal;
                                                endif;
                                                ?>    
                                            </tr>
                                            <?php
                                        endif;
                                        $lageralldebit = 0;
                                        $lagerallcredit = 0;
                                        $ledgerdatasize = sizeof($ledgerbalancedata);
                                        #####################  balance column #############################     
                                        $currbalance = $openingbal;
                                        $prebalance = $openingbal;

                                        if ($ledgerdatasize > 0):
                                             $in = 0;
                                            foreach ($ledgerbalancedata as $datarow):
                                                #####################  balance column #############################
                                                $debit = $datarow->debit;
                                                $credit = $datarow->credit;
                                                $prebalance = $currbalance;
                                                $currbalance = $debit - $credit + $prebalance;
                                                $lageralldebit += $datarow->debit;
                                                $lagerallcredit += $datarow->credit;
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
                                                    $chk = $datarow->voucherType;
                                                    if ($chk == "Receipt Voucher"):
                                                        ?>
                                                        <a href="#"  onclick="getReceiptVoucher(<?php echo $datarow->voucherNumber; ?>);"><?php echo $datarow->voucherNumber; ?></a>         
                                                        <?php
                                                    elseif ($chk == "Payment Voucher"): 
                                                        ?>
                                                        <a href="#"  onclick="getPaymentVoucher(<?php echo $datarow->voucherNumber; ?>);"><?php echo $datarow->voucherNumber; ?></a>                                                                                                            
                                                        <?php
                                                    elseif ($chk == "Journal Entry" || $chk == "Journal entry"):                                                     
                                                        ?>                                                      
                                                        <a href="#"  onclick="getJournalEntry(<?php echo $datarow->voucherNumber; ?>);"><?php echo $datarow->voucherNumber; ?></a>                                                       
                                                        <?php
                                                    else:
                                                        echo $datarow->voucherNumber;
                                                    endif;
                                                    ?>
                                                    </td>
                                                    <td style="text-align: left"><?php echo $datarow->voucherType; ?></td>  
                                                    <td style="text-align: left"><?php
                                                    echo $ledgernamearr[$in];
                                                    $in++;
                                                    ?></td> 
                                                    <td style="text-align: right"><?php echo number_format($datarow->debit, 2); ?></td>
                                                    <td style="text-align: right"><?php echo number_format($datarow->credit, 2); ?></td>
                                                    <td style="text-align: right"><?php
                                                        if ($currbalance < 0):
                                                            echo number_format(abs($currbalance)) . " Cr.";
                                                        elseif ($currbalance == 0):
                                                            echo "0.00";
                                                        else:
                                                            echo number_format($currbalance, 2) . " Dr.";
                                                        endif;
                                                        ?></td> 
                                                </tr>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                        <tr class="">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right; font-weight:bold"><?php echo number_format($lageralldebit, 2); ?></td>
                                            <td style="text-align: right; font-weight:bold"><?php echo number_format($lagerallcredit, 2); ?></td>
                                            <td></td>
                                        </tr>
                                        <tr class="">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight:bold">Total Balance</td>
                                            <td style="text-align: right; font-weight:bold"> <?php
                                                $lageralldebit = $lageralldebit + $openingdebit;
                                                $lagerallcredit = $lagerallcredit + $openingcredit;
                                                if ($lageralldebit > $lagerallcredit):
                                                    echo number_format(($lageralldebit - $lagerallcredit), 2) . " Dr";
                                                elseif ($lagerallcredit > $lageralldebit):
                                                    echo number_format(($lagerallcredit - $lageralldebit), 2) . " Cr";
                                                else:
                                                    echo number_format(($lagerallcredit - $lageralldebit), 2);
                                                endif;
                                                ?></td>                                       
                                        </tr>
                                    </tbody>
                                <?php endif; ?>                               
                            </table>                           
                        </div>                      
                    </div>
                </div>
            </div>           
        </section>
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