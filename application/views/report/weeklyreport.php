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
                Weekly Report
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('report/weeklyreport'); ?>">
                            <div class="form-group">
                                <div class="col-md-5" style="padding-left: 0">
                                    <div class="input-group input-sm" >
                                        <span class="input-group-addon">Select Date </span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" id="datetimepickerweekly" class="week-picker form-control" name="date_from"
                                                   value="<?php echo $date_from; ?>">
                                        </div>                                                                        
                                    </div>
                                </div>                             
                                <div class="col-md-2">   
                                    <label>
                                        <button class="btn btn-info" type="submit">Submit</button>
                                    </label>   
                                </div>
                                <div class="col-md-2 myselect" style="padding-top: 5px;">
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
                                        <th>Account No.</th>
                                        <th>Client Name</th>
                                        <th>Opening Balance</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (sizeof($dailydata) > 0):
                                        foreach ($dailydata as $datarow):
                                            ?>
                                            <tr class=""><td><?php echo $datarow->accNo; ?></td>
                                                <td><?php echo $datarow->acccountLedgerName; ?></td>
                                                <td><?php
                                                    if (substr($datarow->openingbal, 0, 1) == "-"):
                                                        echo substr($datarow->openingbal, 1) . " Cr.";
                                                    elseif ($datarow->openingbal == "0.00"):
                                                        echo $datarow->openingbal;
                                                    elseif ((substr($datarow->openingbal, 0, 1) != NULL)):
                                                        echo $datarow->openingbal . " Dr.";
                                                    else:
                                                        echo $datarow->openingbal;
                                                    endif;
                                                    ?></td>
                                                <td><?php echo $datarow->debitsum; ?></td>
                                                <td><?php echo $datarow->creditsum; ?></td>
                                                <td><?php
                                                    if (substr($datarow->balance, 0, 1) == "-"):
                                                        echo substr($datarow->balance, 1) . " Cr.";
                                                    elseif ($datarow->balance == "0.00"):
                                                        echo $datarow->balance;
                                                    elseif ((substr($datarow->balance, 0, 1) != NULL)):
                                                        echo $datarow->balance . " Dr.";
                                                    else:
                                                        echo $datarow->balance;
                                                    endif;
                                                    ?></td>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Account No.</th>
                                        <th>Client Name</th>
                                        <th>Opening Balance</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                </tfoot>
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
