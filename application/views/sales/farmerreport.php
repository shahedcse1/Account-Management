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
                Poultry Farm Statement
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('sales/salesreport/farmerreport'); ?>">
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
                                    <select name="customername" required="" class="form-control m-bot15 selectpicker" data-live-search="true">
                                        <option value="">-- Select Customer Name --</option>
                                        <?php
                                        if (sizeof($customerlist) > 0):
                                            foreach ($customerlist as $customerrow):
                                                if ($selectedledgerid == $customerrow->ledgerId):
                                                    ?>
                                                    <option value="<?php echo $customerrow->ledgerId; ?>" selected="selected"><?php echo $customerrow->accNo . '-' . $customerrow->acccountLedgerName; ?></option>
                                                    <?php
                                                else:
                                                    ?>
                                                    <option value="<?php echo $customerrow->ledgerId; ?>"><?php echo $customerrow->accNo . '-' . $customerrow->acccountLedgerName; ?></option>
                                                <?php
                                                endif;
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>  

                                <div class="col-md-2">   
                                    <label>
                                        <button class="btn btn-info" id="farmersubmit" type="submit">Submit</button>
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
                                        <th>Date</th>
                                        <th>Bill No </th>
                                        <th>Account Titles</th>
                                        <th> Qty. </th>
                                        <th>Unit</th>
                                        <th> Rate </th>
                                        <th> Debit </th>                                        
                                        <th>Pcs.</th>
                                        <th> Weight </th> 
                                        <th>Rate</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
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
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right;font-weight: bold;"><?php
                                                    if ($openingbal<0):
                                                        echo number_format(abs($openingbal),2) . " Cr.";
                                                    elseif ($openingbal == 0):
                                                        echo "0.00";
                                                    else:
                                                        echo number_format($openingbal, 2) . " Dr.";
                                                    endif;
                                                    ?></td>    
                                        </tr>
                                    <?php else: ?>
                                        <tr class=""> <td colspan="13"> No data found to display </td>
                                        <?php endif; ?>
                                        <?php
                                        $alldebit = 0;
                                        $allcredit = 0;
                                        $currbalance = $openingbal;
                                        $prebalance = $openingbal;
                                        $readyhenpcs = 0;
                                        $weightsum = 0;
                                        $invoicepre = "";
                                        if (sizeof($allfarmerdata) > 0):
                                            foreach ($allfarmerdata as $datarow):
                                                $debit = $datarow->debit;
                                                $credit = $datarow->credit;
                                                if ($datarow->invoiceno != $invoicepre) {
                                                    $debit = $datarow->debit + $datarow->trans - $datarow->discount;
                                                } else {
                                                    $debit = $datarow->debit;
                                                }
                                                $invoicepre = $datarow->invoiceno;
                                                /* if ($datarow->atitle != "Payment Voucher"):
                                                  $alldebit += $debit;
                                                  endif; */
                                                $alldebit += $debit;
                                                if ($datarow->atitle == "Ready Hen"):
                                                    $allcredit += $credit;
                                                endif;
                                                $prebalance = $currbalance;
                                                $currbalance = $debit - $credit + $prebalance;
                                                $readyhenpcs += $datarow->pcs2;
                                                $weightsum += $datarow->weight;
                                                ?>
                                            <tr class="">
                                                <td><?php
                                                    $datevalue = date_create($datarow->date);
                                                    $dayvalue = date_format($datevalue, 'd');
                                                    $monvalue = date_format($datevalue, 'F');
                                                    $yrval = date_format($datevalue, 'Y');
                                                    echo $dayvalue . ' ' . substr($monvalue, 0, 3) . '  ' . $yrval;
                                                    ?></td>
                                                <td><?php echo $datarow->invoiceno; ?></td> 
                                                <td style="text-align: left"><?php
                                                    if ($datarow->atitle == "Ready Hen" || $datarow->pcs2 > 0):
                                                        $queryledger = $this->db->query("SELECT al.acccountLedgerName FROM accountledger al JOIN salesreadystockdetails srsd ON al.ledgerId = srsd.ledgerId WHERE srsd.salesReadyStockMasterId = '$datarow->invoiceno' AND al.companyId = '$company_id' AND srsd.companyId = '$company_id'");
                                                        if ($queryledger->num_rows() > 0):
                                                            echo $datarow->atitle . ' to ' . $queryledger->row()->acccountLedgerName;
                                                        else:
                                                            echo $datarow->atitle;
                                                        endif;
                                                    elseif($datarow->trans == "returnsales"):
                                                         echo $datarow->atitle . ' - Return';
                                                    else:
                                                        echo $datarow->atitle;
                                                    endif;
                                                    ?></td> 
                                                <td><?php echo $datarow->qty1; ?></td>
                                                <td><?php echo $datarow->unit; ?></td>
                                                <td><?php echo $datarow->rate1; ?></td>
                                                <td style="text-align: right"><?php echo number_format($debit, 2); ?></td>
                                                <td><?php echo $datarow->pcs2; ?></td>
                                                <td><?php echo $datarow->weight; ?></td>
                                                <td><?php echo $datarow->rate2; ?></td>                                             
                                                <td style="text-align: right"><?php echo number_format($credit, 2); ?></td>
                                                <td style="text-align: right"><?php
                                                    if ($currbalance<0):
                                                        echo number_format(abs($currbalance),2) . " Cr.";
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
                                        <td style="font-weight: bold;">Net Balance</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td style="font-weight: bold;"><?php echo number_format($allcredit,2); ?></td>
                                        <td style="text-align: right;font-weight: bold;"><?php
                                                $finalbalance = $currbalance;
                                                if ($finalbalance<0):
                                                    echo number_format(abs($finalbalance),2) . " Cr.";
                                                elseif ($finalbalance == 0):
                                                    echo "0.00";
                                                else:
                                                    echo number_format($finalbalance, 2) . " Dr.";
                                                endif;
                                                ?>
                                        </td>   
                                    </tr>                               
                                </tbody>
                            </table>
                            <table class="table table-striped table-hover table-bordered tab-pane" id="farmer-summary">
                                <tbody>
                                    <tr class="" style="text-align: right">
                                        <td style="text-align: right">Opening Balance =</td>
                                        <td style="text-align: right"><?php
                                            if ($openingbal<0):
                                                echo number_format(abs($openingbal),2) . " Cr.";
                                            elseif ($openingbal == 0):
                                                echo "0.00";
                                            else:
                                                echo number_format($openingbal, 2) . " Dr.";
                                            endif;
                                            ?>
                                        </td>
                                        <td style="text-align: right">Ready Hen (pcs.) = </td>
                                        <td style="text-align: right"><?php echo $readyhenpcs; ?></td>
                                    </tr>
                                    <tr class="" style="text-align: right">
                                        <td style="text-align: right">By Cash =</td>
                                        <td style="text-align: right"><?php echo number_format($receiptval, 2); ?></td>
                                        <td style="text-align: right">Unit = </td>
                                        <td style="text-align: right"><?php echo $weightsum; ?></td>
                                    </tr>
                                    <tr class="" style="text-align: right">
                                        <td style="text-align: right">Withdrawals =</td>
                                        <td style="text-align: right"><?php echo number_format($bycashval, 2); ?></td>
                                        <td style="text-align: right">Feed = </td>
                                        <td style="text-align: right"><?php echo $totalfeed; ?></td>
                                    </tr>
                                    <tr class="" style="text-align: right">
                                        <td style="text-align: right">Closing Balance =</td>
                                        <td style="text-align: right"><?php
                                            if ($currbalance<0):
                                                echo number_format(abs($currbalance)) . " Cr.";
                                            elseif ($currbalance == 0):
                                                echo "0.00";
                                            else:
                                                echo number_format($currbalance, 2) . " Dr.";
                                            endif;
                                            ?></td>
                                        <td style="text-align: right">Medicine = </td>
                                        <td style="text-align: right"><?php echo number_format($totalmedicine, 2); ?></td>                                    
                                    </tr>
                                    <tr class="" style="text-align: right">
                                        <td style="text-align: right">Total Cost =</td>
                                        <td style="text-align: right"><?php echo number_format($alldebit - $bycashval - $feedamountret - $totalmedicineret, 2); ?></td>
                                        <td style="text-align: right">Farmer's Profit Value = </td>
                                        <td style="text-align: right"><?php
                                            $profitval = $allcredit - ($alldebit - $bycashval - $feedamountret - $totalmedicineret);
                                            if ($profitval<0):
                                                echo number_format(abs($profitval),2) . " Dr";
                                            else:
                                                echo number_format($profitval, 2) . " Cr";
                                            endif;
                                            /* if ($alldebit > $allcredit):
                                              echo number_format((($alldebit - $allcredit) - $bycashval), 2) . " Dr";
                                              elseif ($allcredit > $alldebit):
                                              echo number_format((($allcredit - $alldebit) - $bycashval), 2) . " Cr";
                                              else:
                                              echo number_format((($allcredit - $alldebit) - $bycashval), 2);
                                              endif; */
                                            ?></td>
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


<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var userrole = "<?php echo $this->sessiondata['userrole']; ?>";
        if (userrole == 's') {
            //$("#farmersubmit").prop("disabled", true);
            //$("#addpurchase_submit").prop("disabled", true);
            //$("#addpurchase").prop("disabled", true);
        }
    });
</script>

