<!--main content start-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Profit And Loss Analysis
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('profitloss/profitlossanalysis'); ?>">
                            <div class="form-group">
                                <div class="col-md-5" style="padding-left: 0">
                                    <div class="input-group input-sm" >
                                        <span class="input-group-addon">From </span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" readonly="true" class="form-control" name="date_from"
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

                                <div class="col-md-1">   
                                    <label>
                                        <button class="btn btn-info" type="submit">Submit</button>
                                    </label>   
                                </div>

                                <div class="col-md-3" style="padding-top: 10px;">
                                    <label>
                                        <input type="radio" checked="true" onclick="togglebankdiv()"  value="condensed"  name="profit_loss_radio">
                                        Condensed &nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input type="radio"  value="detailed" onclick="togglebankdiv()"   name="profit_loss_radio">
                                        Detailed
                                    </label>
                                </div>  

                                <div class="col-md-3">   
                                    <div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Export <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
<!--                                            <li><a href="#" id="btnExport"> Save as CSV</a></li>
                                            <li><a href="#" onclick="generatePdf()" >Save as PDF</a></li>-->
                                            <li><a href="#" onclick="Clickheretoprint()">Print Report</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>     
                            <p> &nbsp; </p>
                        </form>                       
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" id="condensed"  class="tab-pane active">
                            <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Expense</th>
                                        <th></th>
                                        <th>Income</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td>Opening Stock</td>
                                        <td><?php echo number_format($openingstockvalue, 2); ?></td>
                                        <td>Closing Stock</td>
                                        <td><?php echo number_format($closingstockvalue, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="">
                                        <td>Purchase Account</td>
                                        <td><?php echo $totalpurchase; ?></td>
                                        <td>Sales Account</td>
                                        <td><?php echo $totalsalesaccount; ?></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="">
                                        <td>Direct Expense</td> 
                                        <td><?php echo $totaldirectexpense; ?></td>
                                        <td>Direct Income</td>
                                        <td><?php echo $totaldirectincome; ?></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="">
                                        <td style="color:#009900">Gross Profit c/d</td>
                                        <td style="color:#009900"><?php echo number_format($grossprofitcd, 2); ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="table_row" >
                                        <td><b>Total</b></td>
                                        <td><b><?php echo number_format(($openingstockvalue + $totalpurchase + $totaldirectexpense + $grossprofitcd), 2); ?></b></td>
                                        <td><b>Total</b></td>
                                        <td><b><?php echo number_format(($closingstockvalue + $totalsalesaccount + $totaldirectincome), 2); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:30px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="" >
                                        <td>Indirect Expense</td>
                                        <td><?php echo $totalindirectexpense; ?></td>
                                        <td>Gross Profit c/d</td>
                                        <td><?php echo number_format($grossprofitcd,2); ?></td>
                                    </tr>
                                    <tr class="" >
                                        <td style="color:#009900"><b>Net Profit</b></td>
                                        <td style="color:#009900"><b><?php echo number_format((($grossprofitcd + $totalindirectincome) - $totalindirectexpense), 2); ?></b></td>
                                        <td>Indirect Income</td>
                                        <td><?php echo number_format((float)$totalindirectincome,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="" >
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo number_format(($grossprofitcd + $totalindirectincome), 2); ?></b></td>
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo number_format(($grossprofitcd + $totalindirectincome), 2); ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" id="detailed"  class="tab-pane">
                            <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Expense</th>
                                        <th></th>
                                        <th>Income</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="" style="font-weight: bold">
                                        <td>Opening Stock</td>
                                        <td><?php echo number_format($openingstockvalue, 2); ?></td>
                                        <td>Closing Stock</td>
                                        <td><?php echo number_format($closingstockvalue, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="table_row" style="font-weight: bold">
                                        <td>Purchase Account</td>
                                        <td><?php echo $totalpurchase; ?></td>
                                        <td>Sales Account</td>
                                        <td><?php echo $totalsalesaccount; ?></td>
                                    </tr>
                                    <?php if ((sizeof($purchasedetails) > 0) || (sizeof($salesdetails))): ?>
                                        <tr class="">
                                            <td colspan="2"><table class="table">
                                                    <?php
                                                    if (sizeof($purchasedetails) > 0):
                                                        foreach ($purchasedetails as $purchaserow):
                                                            ?>
                                                            <tr> <td><?php echo $purchaserow->acntLName; ?></td> <td><?php
                                                                    if ($purchaserow->purchasevalue<0):
                                                                        echo number_format(abs($purchaserow->purchasevalue),2) . " Cr.";
                                                                    elseif ($purchaserow->purchasevalue == 0):
                                                                        echo "0.00";
                                                                    else:
                                                                        echo number_format($purchaserow->purchasevalue,2) . " Dr.";
                                                                    endif;
                                                                    ?></td>  </tr> 
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </table></td>
                                            <td colspan="2"><table class="table">
                                                    <?php
                                                    if (sizeof($salesdetails) > 0):
                                                        foreach ($salesdetails as $salesrow):
                                                            ?>
                                                            <tr> <td><?php echo $salesrow->acntLName; ?></td> <td><?php
                                                                    if ($salesrow->purchasevalue<0):
                                                                        echo number_format(abs($salesrow->purchasevalue),2) . " Cr.";
                                                                    elseif ($salesrow->purchasevalue == 0):
                                                                        echo "0.00";
                                                                    else:
                                                                        echo number_format($salesrow->purchasevalue,2) . " Dr.";
                                                                    endif;
                                                                    ?></td>  </tr> 
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </table></td>                                       
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="" style="font-weight: bold">
                                        <td>Direct Expense</td> 
                                        <td><?php echo $totaldirectexpense; ?></td>
                                        <td>Direct Income</td>
                                        <td><?php echo $totaldirectincome; ?></td>
                                    </tr>

                                    <?php if ((sizeof($directexpensedetails) > 0) || (sizeof($directincomedetails))): ?>
                                        <tr class="">
                                            <td colspan="2"><table class="table">
                                                    <?php
                                                    if (sizeof($directexpensedetails) > 0):
                                                        foreach ($directexpensedetails as $dexpenserow):
                                                            ?>
                                                            <tr> <td><?php echo $dexpenserow->acntLName; ?></td> <td><?php
                                                                    if ($dexpenserow->purchasevalue<0):
                                                                        echo number_format(abs($dexpenserow->purchasevalue),2) . " Cr.";
                                                                    elseif ($dexpenserow->purchasevalue == 0):
                                                                        echo "0.00";
                                                                    else:
                                                                        echo number_format($dexpenserow->purchasevalue,2) . " Dr.";
                                                                    endif;
                                                                    ?></td>  </tr> 
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </table></td>
                                            <td colspan="2"><table class="table">
                                                    <?php
                                                    if (sizeof($directincomedetails) > 0):
                                                        foreach ($directincomedetails as $dincomerow):
                                                            ?>
                                                            <tr> <td><?php echo $dincomerow->acntLName; ?></td> <td><?php
                                                                    if ($dincomerow->purchasevalue<0):
                                                                        echo number_format(abs($dincomerow->purchasevalue),2) . " Cr.";
                                                                    elseif ($dincomerow->purchasevalue == 0):
                                                                        echo "0.00";
                                                                    else:
                                                                        echo number_format($dincomerow->purchasevalue,2) . " Dr.";
                                                                    endif;
                                                                    ?></td>  </tr> 
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </table></td>                                       
                                        </tr>
                                    <?php endif; ?>

                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="">
                                        <td style="color:#009900">Gross Profit c/d</td>
                                        <td style="color:#009900"><?php echo number_format($grossprofitcd, 2); ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="table_row" >
                                        <td><b>Total</b></td>
                                        <td><b><?php echo number_format(($openingstockvalue + $totalpurchase + $totaldirectexpense + $grossprofitcd), 2); ?></b></td>
                                        <td><b>Total</b></td>
                                        <td><b><?php echo number_format(($closingstockvalue + $totalsalesaccount + $totaldirectincome), 2); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>

                                    <tr class="table_row" >
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>Gross Profit c/d</td>
                                        <td><?php echo number_format($grossprofitcd, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:30px;" colspan="2">&nbsp;</td>
                                    </tr>

                                    <tr class="table_row" >
                                        <td><b>Indirect Expense</b></td>
                                        <td><b><?php echo $totalindirectexpense; ?></b></td>
                                        <td><b>Indirect Income</b></td>
                                        <td><b><?php echo $totalindirectincome; ?></b></td>
                                    </tr>

                                    <?php if ((sizeof($indirectexpensedetails) > 0) || (sizeof($indirectincomedetails))): ?>
                                        <tr class="table_row">
                                            <td colspan="2"><table class="table">
                                                    <?php
                                                    if (sizeof($indirectexpensedetails) > 0):
                                                        foreach ($indirectexpensedetails as $iexpenserow):
                                                            ?>
                                                            <tr> <td><?php echo $iexpenserow->acntLName; ?></td> <td><?php
                                                                    if ($iexpenserow->purchasevalue<0):
                                                                        echo number_format(abs($iexpenserow->purchasevalue),2) . " Cr.";
                                                                    elseif ($iexpenserow->purchasevalue == 0):
                                                                        echo "0.00";
                                                                    else:
                                                                        echo number_format($iexpenserow->purchasevalue,2) . " Dr.";
                                                                    endif;
                                                                    ?></td>  </tr> 
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </table></td>
                                            <td colspan="2"><table class="table">
                                                    <?php
                                                    if (sizeof($indirectincomedetails) > 0):
                                                        foreach ($indirectincomedetails as $iincomerow):
                                                            ?>
                                                            <tr> <td><?php echo $iincomerow->acntLName; ?></td> <td><?php
                                                                    if ($iincomerow->purchasevalue<0):
                                                                        echo number_format(abs($iincomerow->purchasevalue),2) . " Cr.";
                                                                    elseif ($iincomerow->purchasevalue == 0):
                                                                        echo "0.00";
                                                                    else:
                                                                        echo number_format($iexpenserow->purchasevalue,2) . " Dr.";
                                                                    endif;
                                                                    ?></td>  </tr> 
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </table></td>                                       
                                        </tr>
                                    <?php endif; ?>


                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="table_row" >
                                        <td style="color:#009900"><b>Net Profit</b></td>
                                        <td style="color:#009900"><b><?php echo number_format((($grossprofitcd + $totalindirectincome) - $totalindirectexpense), 2); ?></b></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="" >
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo number_format(($grossprofitcd + $totalindirectincome), 2); ?></b></td>
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo number_format(($grossprofitcd + $totalindirectincome), 2); ?></b></td>
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

