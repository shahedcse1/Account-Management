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
                Bank Book Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <form  class="tasi-form" method="post" action="<?php echo site_url('bankbook/bankbook'); ?>">
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
                                    <select name="acledgername" required="" class="form-control m-bot15 selectpicker" data-live-search="true">
                                        <option value="">-- Select Account Name --</option>
                                        <?php
                                        if (sizeof($ledgeridarray) > 0):
                                            foreach ($ledgeridarray as $ledgerrow):
                                                if ($selectedledgerid == $ledgerrow->ledgerId):
                                                    ?>                                                                                                      
                                                    <option value="<?php echo $ledgerrow->ledgerId; ?>"selected="selected" ><?php echo $ledgerrow->acccountLedgerName; ?></option>
                                                    <?php
                                                elseif ($selectedledgerid != $ledgerrow->ledgerId):
                                                    ?>
                                                    <option value="<?php echo $ledgerrow->ledgerId; ?>" ><?php echo $ledgerrow->acccountLedgerName; ?></option>
                                                    <?php
                                                else:
                                                    ?>
                                                    <option value="<?php echo $ledgerrow->ledgerId; ?>" ><?php echo 'All  Data' ?></option>
                                                <?php
                                                endif;
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div> 

                                <div class="col-md-1">   
                                    <label>
                                        <button class="btn btn-info" type="submit">Submit</button>
                                    </label>   
                                </div>

                                <div class="col-md-3" style="padding-top: 10px;">                                   
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
                    <div>
                    <table  class="table table-striped table-hover table-bordered tab-pane active editable-sample1" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Voucher No</th>
                                <th>Check No</th>
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
                            ?>
                            <tr class="">
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td style="text-align: left"><?php echo "Opening Balance"; ?></td>
                                <?php
                                if (substr($openingbal, 0, 1) == "-"):
                                    echo '<td>  </td>';
                                    echo "<td style='text-align: right; font-weight:bold'>" . substr($openingbal, 1) . "</td>";
                                    $openingcredit = substr($openingbal, 1);
                                elseif ($openingbal == 0):
                                    echo '<td>  </td>';
                                    echo '<td style="text-align: right"> 0.00 </td>';
                                    echo '<td style="text-align: right"> 0.00 </td>';
                                    echo '<td style="text-align: right"> 0.00 </td>';
                                else:
                                    echo '<td>  </td>';
                                    echo '<td>  </td>';
                                    echo '<td>  </td>';
                                    echo "<td style='text-align: right; font-weight:bold'>" . $openingbal . "</td>";

                                    $openingdebit = $openingbal;
                                endif;
                                ?>    
                            </tr>
                            <?php
                            $lageralldebit = $openingdebit;
                            $lagerallcredit = $openingcredit;
                            $ledgerdatasize = sizeof($ledgerbalancedata);
                            if ($ledgerdatasize > 0):
                                $sl = 0;
                                $in = 0;
#####################  balance column #############################     
                                $currbalance = $openingbal;
                                $prebalance = $openingbal;



                                foreach ($ledgerbalancedata as $datarow):
                                    #####################  balance column #############################
                                    $debit = $datarow->debit;
                                    $credit = $datarow->credit;

                                    $prebalance = $currbalance;
                                    $currbalance = $debit - $credit + $prebalance;


                                    $sl++;
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
                                        <td><?php echo $datarow->voucherNumber; ?></td>
                                        <?php
                                        if ($datarow->voucherType == "Payment Voucher") {
                                            $sqlQuery = $this->db->query("SELECT chequeNumber FROM paymentdetails WHERE paymentMasterId='$datarow->voucherNumber' and companyId='$company_id'");
                                        } else {
                                            $sqlQuery = $this->db->query("SELECT chequeNumber FROM receiptdetails WHERE receiptMasterId='$datarow->voucherNumber' and companyId='$company_id'");
                                        }
                                        if ($sqlQuery->num_rows > 0) {
                                            $checkNo = $sqlQuery->row()->chequeNumber;
                                        } else {
                                            $checkNo = "";
                                        }
                                        ?>
                                        <td><?php echo $checkNo; ?></td>
                                        <td><?php echo $datarow->voucherType; ?></td>
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

                        </tbody>
                      
                            <tr class="">
                                <td></td>
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
                                <td></td>
                                <td style="font-weight:bold">Total Balance</td>
                                <td style="text-align: right; font-weight:bold"><?php
                                        if ($lageralldebit > $lagerallcredit):
                                            echo number_format(($lageralldebit - $lagerallcredit), 2) . "Dr";
                                        elseif ($lagerallcredit > $lageralldebit):
                                            echo number_format(($lagerallcredit - $lageralldebit), 2) . "Cr";
                                        else:
                                            echo number_format(($lagerallcredit - $lageralldebit), 2);
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

<script type="text/javascript" charset="utf-8">
//    $(document).ready(function () {
//        $('#editable-sample').dataTable({
//            "sPaginationType": "full_numbers",
//            'iDisplayLength': 50
//        });
//    });
</script>





