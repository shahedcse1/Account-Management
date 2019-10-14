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
                Sales Report
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('sales/salesreport/salesReportSales'); ?>">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5" style="padding-left: 0">
                                        <div class="input-group input-sm" >
                                            <span class="input-group-addon">From </span>
                                            <div class="iconic-input right">
                                                <i class="fa fa-calendar"></i>
                                                <input type="text" id="datetimepickerfrom" class="form-control" name="date_from" value="<?php echo $date_from; ?>">
                                            </div>
                                            <span class="input-group-addon">To</span>
                                            <div class="iconic-input right">
                                                <i class="fa fa-calendar"></i>
                                                <input type="text" id="datetimepickerto" class="form-control" name="date_to" value="<?php echo $date_to; ?>">
                                            </div>
                                        </div>
                                    </div>                           
                                    <div class="col-md-3 myselect" style="padding-top: 5px;">
                                        <select class="form-control selectpicker" id="productname" name="productname" data-live-search="true">
                                            <option value="">-- Product Name --</option>
                                            <?php
                                            foreach ($productList as $pList):
                                                if ($pList->productId == $productname):
                                                    ?>
                                                    <option value="<?php echo $pList->productId; ?>" selected="selected"><?php echo $pList->productName; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $pList->productId ?>"><?php echo $pList->productName ?></option>
                                                <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="padding-top: 10px;">
                                        <label>
                                            <?php if ($checkCusOrDis == 'customer'): ?>
                                                <input type="radio"  onclick="togglebankdiv()" checked="true" value="customer" id="customername" name="feed_report_radio">
                                                Customer Name
                                            <?php else: ?>
                                                <input type="radio"  onclick="togglebankdiv()" value="customer" id="customername" name="feed_report_radio">
                                                Customer Name
                                            <?php endif; ?>
                                        </label>
                                        <label>
                                            <?php if ($checkCusOrDis == 'district'): ?>
                                                <input type="radio" checked="true"  value="district" onclick="togglebankdiv()"  id="destrictname" name="feed_report_radio">
                                                District Name
                                            <?php else: ?>
                                                <input type="radio" value="district" onclick="togglebankdiv()"  id="destrictname" name="feed_report_radio">
                                                District Name
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-3">   

                                    </div>

                                    <div id="customerDiv" class="col-md-3 myselect" style="padding-top: 5px;">
                                        <?php
                                        if ($this->sessiondata['userrole'] == 'u'):
                                            echo '<select name="customername" id="customernameselect"  disabled class="form-control m-bot15" data-live-search="true">';
                                        else :
                                            echo '<select name="customername" id="customernameselect" class="form-control m-bot15" data-live-search="true">';
                                        endif;
                                        ?>
                                        <option value="">-- Customer Name --</option>
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
                                    <div id="districtDiv" class="col-md-3 myselect" style="padding-top: 5px;">
                                        <select class="form-control" id="districtname" name="districtname" data-live-search="true">
                                            <option value="">-- District Name --</option>
                                            <?php
                                            foreach ($districtList as $dList):
                                                if ($dList->districtname == $districtname):
                                                    ?>
                                                    <option value="<?php echo $dList->districtname ?>" selected="selected"><?php echo $dList->districtname ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $dList->districtname ?>"><?php echo $dList->districtname ?></option>
                                                <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>                              
                                    <div class="col-md-1">   
                                        <label>
                                            <button class="btn btn-info" type="submit">Submit</button>
                                        </label>   
                                    </div>
                                    <div class="col-md-1">   
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
                                        <?php if ($noCustomername != 'customernamehide'): ?>
                                            <th style="width: 6%"> Customer Name </th>
                                        <?php endif; ?>
                                        <th style="width: 24%"> Product Name </th>
                                        <th style="width: 6%"> District </th>
                                        <th style="width: 6%"> Qty </th>
                                        <th style="width: 6%"> Rate </th>
                                        <th style="width: 14%"> Balance </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if (sizeof($salesdetailsdata) > 0):
                                        foreach ($salesdetailsdata as $datarow):
                                            ?>
                                            <tr class="">
                                                <td>
                                                    <?php
                                                    $datevalue = date_create($datarow->date);
                                                    $dayvalue = date_format($datevalue, 'd');
                                                    $monvalue = date_format($datevalue, 'F');
                                                    $yrval = date_format($datevalue, 'Y');
                                                    echo $dayvalue . ' ' . substr($monvalue, 0, 3) . '  ' . $yrval;
                                                    ?>
                                                </td>
                                                <?php if ($noCustomername != 'customernamehide'): ?>
                                                    <td>
                                                        <?php echo $datarow->customername; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <?php echo $datarow->productname; ?>
                                                </td>
                                                <td>
                                                    <?php echo $datarow->districtname; ?>
                                                </td>
                                                <td>
                                                    <?php echo floor($datarow->qty) == $datarow->qty ? number_format($datarow->qty) : number_format($datarow->qty, 3); ?>
                                                </td>
                                                <td>
                                                    <?php echo $datarow->rate; ?>
                                                </td>
                                                <td>
                                                    <?php echo $datarow->amount; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
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
    document.getElementById("districtname").disabled = true;
    document.getElementById("customernameselect").disabled = true;
    function togglebankdiv() {
        var selected_val = document.querySelector('input[name="feed_report_radio"]:checked').value;
        //alert(selected_val);
        if (selected_val == "customer") {
            document.getElementById("customernameselect").disabled = false;
            document.getElementById("districtname").disabled = true;
            $("#districtname").val("").change();
        } else {
            document.getElementById("districtname").disabled = false;
            document.getElementById("customernameselect").disabled = true;            
            $("#customernameselect").val("").change();
        }
    }
    
</script>