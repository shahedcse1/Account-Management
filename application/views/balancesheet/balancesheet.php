<!--main content start-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Balance Sheet
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('balancesheet/balancesheet'); ?>">
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

                                <div class="col-md-1">   

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
                                <div class="col-md-1">   
                                    <label>
                                        <button class="btn btn-info" type="submit">Submit</button>
                                    </label>   
                                </div>

                                <div class="col-md-2">   
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
                        <div>
                            <div role="tabpanel" id="condensed"  class="tab-pane active">
                                <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                    <thead>
                                        <tr>
                                            <th>Liability</th>
                                            <th></th>
                                            <th>Asset</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>                               
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php
                                        $liabilitysum = 0;
                                        if (sizeof($liabilitycondenseddata)):
                                            ?>
                                            <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                                <?php foreach ($liabilitycondenseddata as $datarow): ?>
                                                    <tr>
                                                        <td style="text-align: left"><?php echo $datarow->accountGroupName; ?></td>
                                                        <td style="text-align: right"><?php
                                                            echo $datarow->balance;
                                                            $liabilitysum += $datarow->balance;
                                                            ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                            <tbody>
                                                <?php
                                                $assetsum = 0;
                                                if (sizeof($assetcondenseddata)):
                                                    ?>                                  
                                                    <?php foreach ($assetcondenseddata as $datarow): ?>
                                                        <tr>
                                                            <td style="text-align: left"><?php echo $datarow->accountGroupName; ?></td>
                                                            <td style="text-align: right"><?php
                                                                echo $datarow->balance;
                                                                $assetsum += $datarow->balance;
                                                                ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                <?php endif; ?>
                                                <tr>
                                                    <td style="text-align: left">Closing Stock</td>
                                                    <td style="text-align: right"><?php
                                                        echo $closingstockvalue;
                                                        $assetsum += $closingstockvalue;
                                                        ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">       
                                        <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                            <tbody>
                                                <tr>
                                                    <td><b>Net Profit</b></td>
                                                    <td><b><?php echo number_format($netprofit, 2); ?></b></td>
                                                </tr> 
                                                <?php
                                                $diff = $assetsum - ($liabilitysum + $netprofit);
                                                if ($diff != 0):
                                                    ?>
                                                    <tr>
                                                        <td>Difference</td>
                                                        <td><b><?php echo number_format($diff, 2); ?></b></td>
                                                    </tr> 
                                                <?php endif;
                                                ?>
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td><b><?php echo number_format(($liabilitysum + $netprofit + $diff), 2); ?></b></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                            <tbody>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <?php
                                                if ($diff != 0):
                                                    ?>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <?php
                                                endif;
                                                ?>
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td><b><?php echo number_format($assetsum, 2); ?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                        <div role="tabpanel" id="detailed"  class="tab-pane">
                            <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Liability</th>
                                        <th></th>
                                        <th>Asset</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>                       

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php
                                    $liabilitysum = 0;
                                    if (sizeof($liabilitydetaildata)):
                                        ?>
                                        <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                            <?php foreach ($liabilitydetaildata as $datarow): ?>
                                                <tr>
                                                    <td style="text-align: left"><?php echo $datarow->acccountLedgerName; ?></td>
                                                    <td style="text-align: right"><?php
                                                        echo $datarow->balance;
                                                        $liabilitysum += $datarow->balance;
                                                        ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                        <?php
                                        $assetsum = 0;
                                        if (sizeof($assetdetaildata)):
                                            ?>                                      
                                            <?php foreach ($assetdetaildata as $datarow): ?>
                                                <tr>
                                                    <td style="text-align: left"><?php echo $datarow->acccountLedgerName; ?></td>
                                                    <td style="text-align: right"><?php
                                                        echo $datarow->balance;
                                                        $assetsum += $datarow->balance;
                                                        ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                        <?php endif; ?>
                                        <tr>
                                            <td style="text-align: left">Closing Stock</td>
                                            <td style="text-align: right"><?php
                                                echo $closingstockvalue;
                                                $assetsum += $closingstockvalue;
                                                ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">       
                                    <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                        <tbody>
                                            <tr>
                                                <td><b>Net Profit</b></td>
                                                <td><b><?php echo number_format($netprofit, 2); ?></b></td>
                                            </tr> 
                                            <?php
                                            $diff = $assetsum - ($liabilitysum + $netprofit);
                                            if ($diff != 0):
                                                ?>
                                                <tr>
                                                    <td>Difference</td>
                                                    <td><b><?php echo number_format($diff, 2); ?></b></td>
                                                </tr> 
                                            <?php endif;
                                            ?>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b><?php echo number_format(($liabilitysum + $netprofit + $diff), 2); ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                                <div class="col-lg-6">
                                    <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                        <tbody>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                            if ($diff != 0):
                                                ?>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <?php
                                            endif;
                                            ?>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b><?php echo number_format($assetsum, 2); ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>         
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--main content end-->
<!--modal-->

