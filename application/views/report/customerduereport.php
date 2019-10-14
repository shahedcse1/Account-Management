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
                Customer's Due Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('report/customerduereport'); ?>">
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
                                        <option value="">-- Select Name --</option>
                                        <!--                                        <option value="28">Customer</option>
                                                                                <option value="13">Farmer</option>
                                                                                <option value="27">Supplier</option>-->
                                        <?php
                                        if (sizeof($accountGroupArray) > 0):
                                            foreach ($accountGroupArray as $ledgerrow):
                                                if ($selectedledgerid == $ledgerrow->accountGroupId):
                                                    ?>                                                                                                      
                                                    <option value="<?php echo $ledgerrow->accountGroupId; ?>"selected="selected" ><?php echo $ledgerrow->accountGroupName; ?></option>
                                                    <?php
                                                elseif ($selectedledgerid != $ledgerrow->accountGroupId):
                                                    ?>
                                                    <option value="<?php echo $ledgerrow->accountGroupId; ?>" ><?php echo $ledgerrow->accountGroupName; ?></option>
                                                    <?php
                                                else:
                                                    ?>
                                                    <option value="<?php echo $ledgerrow->accountGroupId; ?>" ><?php echo 'All  Data' ?></option>
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
                                    <th>Acc. No</th>
                                    <th>Client Name</th>
                                    <th>Business Name</th>
                                    <th>Opening Balance</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Unpaid</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $lageralldebit = 0;
                                $lagerallcredit = 0;
                                $totalunpaid = 0;
                                $totalcustbalance = 0;
                                $displayLedgeidarr = array();
                                $alldataarrsize = sizeof($alldataarr);
                                if ($alldataarrsize > 0):
                                    foreach ($alldataarr as $datarow):
                                        $openingQr = $this->db->query("SELECT (sum(debit) - sum(credit)) AS openingbal FROM ledgerposting WHERE ledgerId = '$datarow->ledgerid' AND (date BETWEEN '$initialdate' AND '$beforefromdate') AND companyId = '$company_id'");
                                        if ($openingQr->num_rows() > 0):
                                            $openingbal = $openingQr->row()->openingbal;
                                        else:
                                            $openingbal = 0;
                                        endif;
                                        $custbalance = $openingbal + $datarow->debit - $datarow->credit;
                                        if ((!in_array($datarow->ledgerid, $displayLedgeidarr)) && $custbalance != 0):
                                            $displayLedgeidarr[] = $datarow->ledgerid;
                                            $debit = $datarow->debit;
                                            $credit = $datarow->credit;
                                            $lageralldebit += $datarow->debit;
                                            $lagerallcredit += $datarow->credit;
                                            ?>
                                            <tr class="">
                                                <td><?php echo $datarow->accNo ?></td>
                                                <td><?php echo $datarow->acccountLedgerName ?></td>
                                                <td><?php echo $datarow->nameOfBusiness ?></td>
                                                <td><?php
                                                    if ($openingbal > 0):
                                                        echo number_format($openingbal, 2) . " Dr";
                                                    elseif ($openingbal < 0):
                                                        echo number_format(abs($openingbal), 2) . " Cr";
                                                    else:
                                                        echo number_format($openingbal, 2);
                                                    endif;
                                                    ?></td>                                       
                                                <td style="text-align: right"><?php echo number_format($datarow->debit, 2); ?></td>           
                                                <td style="text-align: right"><?php echo number_format($datarow->credit, 2); ?></td>
                                                <td style="text-align: right"><?php
                                                    $unpaidamount = $datarow->debit - $datarow->credit;
                                                    $totalunpaid += $unpaidamount;
                                                    if ($unpaidamount > 0):
                                                        echo number_format($unpaidamount, 2) . " Dr";
                                                    elseif ($unpaidamount < 0):
                                                        echo number_format(abs($unpaidamount), 2) . " Cr";
                                                    else:
                                                        echo number_format($unpaidamount, 2);
                                                    endif;
                                                    ?></td>
                                                <td style="text-align: right"><?php
                                                    $custbalance = $openingbal + $datarow->debit - $datarow->credit;
                                                    $totalcustbalance += $custbalance;
                                                    if ($custbalance > 0):
                                                        echo number_format($custbalance, 2) . " Dr";
                                                    elseif ($custbalance < 0):
                                                        echo number_format(abs($custbalance), 2) . " Cr";
                                                    else:
                                                        echo number_format($custbalance, 2);
                                                    endif;
                                                    ?>
                                                </td> 
                                            </tr>
                                            <?php
                                        endif;
                                    endforeach;
                                else:
                                    ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php endif;
                                ?>

                            </tbody>
                            <tr class="">
                                <td></td>
                                <td></td>     
                                <td></td>
                                <td></td>
                                <td style="text-align: right;font-weight: bold;"><?php echo number_format($lageralldebit, 2); ?></td>
                                <td style="text-align: right;font-weight: bold;"><?php echo number_format($lagerallcredit, 2); ?></td>
                                <td style="text-align: right;font-weight: bold;"><?php
                                    if ($totalunpaid > 0):
                                        echo number_format($totalunpaid, 2) . " Dr";
                                    elseif ($totalunpaid < 0):
                                        echo number_format(abs($totalunpaid), 2) . " Cr";
                                    else:
                                        echo number_format($totalunpaid, 2);
                                    endif;
                                    ?> </td>
                                <td style="text-align: right;font-weight: bold;"><?php
                                    if ($totalcustbalance > 0):
                                        echo number_format($totalcustbalance, 2) . " Dr";
                                    elseif ($totalcustbalance < 0):
                                        echo number_format(abs($totalcustbalance), 2) . " Cr";
                                    else:
                                        echo number_format($totalcustbalance, 2);
                                    endif;
                                    ?> </td>
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





