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
                Trial Balance Information
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('trialbalance/trialbalance'); ?>">
                            <div class="form-group">
                                <div class="col-md-5" style="padding-left: 0">
                                    <div class="input-group input-sm" >
                                        <span class="input-group-addon">From </span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input readonly="readonly" type="text" id="datetimepickerfrom" class="form-control" name="date_from"
                                                   value="<?php echo $date_from; ?>">
                                        </div>
                                        <span class="input-group-addon">To</span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input readonly="readonly" type="text" id="datetimepickerto" class="form-control" name="date_to" 
                                                   value="<?php echo $date_to; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">   

                                </div>

                                <div class="col-md-3" style="padding-top: 10px;">
                                    <label>
                                        <input type="radio" checked="true" onclick="togglebankdiv()"  value="ledger_wise" id="ledger_wise" name="bank_book_radio">
                                        Ledger Wise &nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input type="radio"  value="group_wise" onclick="togglebankdiv()"  id="group_wise" name="bank_book_radio">
                                        Group Wise
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
                            </table>                           
                        </div>
                        <div role="tabpanel" class="tab-pane" id="group">
                            <table  class="table table-striped table-hover table-bordered tab-pane active" id="editable-sample1">
                                <thead>
                                    <tr>
                                        <th>Sl No </th>
                                        <th>Account Group</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $lageralldebit = 0;
                                    $lagerallcredit = 0;
                                    $groupdatasize = sizeof($groupwisedata);
                                    if ($groupdatasize > 0):
                                        $sl = 0;
                                        foreach ($groupwisedata as $datarow):
                                            if (($datarow->debitsum > 0) || ($datarow->creditsum > 0)):
                                                $sl++;
                                                ?>
                                                <tr class="">
                                                    <td><?php echo $sl; ?></td>
                                                    <td style="text-align: right"><?php echo $datarow->accountGroupName; ?></td>
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
                                            endif;
                                        endforeach;
                                    endif;
                                    ?>   
                                    <tr class="">
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right"><b><?php echo number_format($lageralldebit, 2); ?></b></td>
                                        <td style="text-align: right"><b><?php echo number_format($lagerallcredit, 2); ?></b></td>
                                    </tr>
                                    <tr class="">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    
                                        <td><b>Total Balance</b></td>
                                        <td style="text-align: right"><b><?php
                                                if ($lageralldebit > $lagerallcredit):
                                                    echo number_format(($lageralldebit - $lagerallcredit), 2) . " Dr";
                                                elseif ($lagerallcredit > $lageralldebit):
                                                    echo number_format(($lagerallcredit - $lageralldebit), 2) . " Cr";
                                                else:
                                                    echo number_format(($lagerallcredit - $lageralldebit), 2);
                                                endif;
                                                ?></b></td>                                       
                                    </tr>
                                </tbody>
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