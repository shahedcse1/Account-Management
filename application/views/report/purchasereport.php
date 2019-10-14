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
                Purchase Report
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('report/purchasereport'); ?>">
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
                                    <select name="productname" required="" class="form-control m-bot15 selectpicker" data-live-search="true">
                                        <option value="">-- Select Product Name --</option>
                                        <?php
                                        if (sizeof($productdata) > 0):
                                            foreach ($productdata as $datarow):
                                                if ($selectproductid == $datarow->productId):
                                                    ?>
                                                    <option value="<?php echo $datarow->productId; ?>" selected="selected"><?php echo $datarow->productName; ?></option>
                                                    <?php
                                                else:
                                                    ?>
                                                    <option value="<?php echo $datarow->productId; ?>"><?php echo $datarow->productName; ?></option>
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
                                <thead>
                                    <?php
                                    $totalstock = $openingstock;
                                    if ($selectproductid == 1):
                                        ?>
                                        <tr>
                                            <th style="width: 15%">Date</th>
                                            <th style="width: 15%">Invoice No</th>
                                            <th style="width: 15%">Rate</th>
                                            <th style="width: 15%">Kgs</th>
                                            <th style="width: 15%">Pcs</th>
                                            <th style="width: 15%">Amount</th>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <th style="width: 25%">Date</th>
                                            <th style="width: 25%">Invoice No</th>
                                            <th style="width: 25%">Rate</th>
                                            <th style="width: 25%">Qty</th>
                                        </tr>
                                    <?php endif; ?>
                                </thead>
                                <tbody>
                                    <?php if ($selectproductid == ""): ?>
                                        <tr>
                                            <td colspan="4">No Data Found to Display</td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($selectproductid == 1): ?>
                                        <tr class="">
                                            <td></td>
                                            <td> Opening Stock </td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $openingstock; ?></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                        if (sizeof($readyhendata) > 0):
                                            foreach ($readyhendata as $datarow):
                                                $totalstock += $datarow->pcs;
                                                ?>
                                                <tr class="">
                                                    <td><?php echo $datarow->date; ?></td>
                                                    <td><?php echo $datarow->salesReadyStockMasterId; ?></td>
                                                    <td><?php echo $datarow->farmerRate; ?></td>
                                                    <td><?php echo $datarow->kg; ?></td>
                                                    <td><?php echo floor($datarow->pcs) == $datarow->pcs ? number_format($datarow->pcs):number_format($datarow->pcs,3); ?></td>
                                                    <td><?php echo $datarow->amount; ?></td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        endif;
                                    else:
                                        if ($selectproductid != ""):
                                            ?>
                                            <tr class="">
                                                <td></td>
                                                <td> Opening Stock </td>
                                                <td></td>
                                                <td><?php echo $openingstock; ?></td>
                                            </tr>
                                            <?php
                                        endif;
                                        if (sizeof($purchasedata) > 0):
                                            foreach ($purchasedata as $datarow):
                                                $totalstock += $datarow->qty;
                                                ?>
                                                <tr class="">
                                                    <td><?php echo $datarow->date; ?></td>
                                                    <td><?php echo $datarow->invoiceno; ?></td>
                                                    <td><?php echo $datarow->rate; ?></td>
                                                    <td><?php echo floor($datarow->qty) == $datarow->qty ? number_format($datarow->qty):number_format($datarow->qty,3); ?></td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        endif;
                                    endif;
                                    ?>

                                </tbody>
                                    <?php if ($selectproductid == 1): ?>
                                        <tr class="">
                                            <td></td>
                                            <td style="font-weight:bold;"> Total </td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight:bold;"><?php echo $totalstock; ?></td>
                                            <td></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr class="">
                                            <td></td>
                                            <td style="font-weight:bold;"> Total</td>
                                            <td></td>
                                            <td style="font-weight:bold;"><?php echo floor($totalstock) == $totalstock ? number_format($totalstock):number_format($totalstock,3); ?></td>
                                        </tr>
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
