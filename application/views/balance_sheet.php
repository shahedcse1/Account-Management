<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>
<style>
    .col-lg-2 {
        width: 10.666667%;
    }

    .align-right {
        float: right;
        font-weight: 500;
    }
</style>
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
                    <div class="clearfix" style="margin: 10px 0;">
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
                            <label>
                                <button class="btn btn-info" type="submit">Submit</button>
                            </label>
                        </div>
                        <div class="col-md-3 col-md-offset-1" style="margin-bottom: 15px;padding-top: 7px;">
                            <label>
                                <input type="radio" checked="true" onclick="togglebankdiv()"  value="Condensed"  name="bank_book_radio">
                                Group Wise &nbsp;&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="radio"  value="Detailed" onclick="togglebankdiv()"   name="bank_book_radio">
                                Ledger Wise
                            </label>
                        </div>
                        <div class="btn-group pull-right">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">Export <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#">Print</a></li>
                                <li><a href="#">Save as PDF</a></li>
                                <li><a href="#">Export to Excel</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" id="Condensed"  class="tab-pane active">
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
                                <tr>
                                    <td>Supplier</td>
                                    <td><?php echo $liabilitytotal; ?></td>
                                    <td>Cash In Hand</td>
                                    <td><?php echo $totalcashinhand; ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Customer</td>
                                    <td><?php echo $customer; ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Bank Account</td>
                                    <td><?php echo $bankaccount; ?></td>
                                </tr>
                                <tr class="">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Closing-Stock</td>
                                    <td><?= (isset($closingstockstotal)) ? $closingstockstotal : 0; ?></td>
                                </tr>

                                <tr>
                                    <td>Net Profit;</td>
                                    <td><?php echo $liabilitytotal - $customer; ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Difference;</td>
                                    <td><?php echo $liabilitytotal - $customer; ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="font-weight: bold">
                                    <td>Total;</td>
                                    <td><?php echo $liabilitytotal; ?></td>
                                    <td>Total</td>
                                    <td><?php echo $totalcashinhand + $customer + $closingstockstotal + $bankaccount; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" id="Detailed"  class="tab-pane">
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
                                <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                    <tr>
                                        <td style="font-weight: bold">Supplier</td>
                                        <td><?php echo $liabilitytotal; ?></td>
                                    </tr>
                                    <?php
                                    if (sizeof($liabilitydetails) > 0):
                                        foreach ($liabilitydetails as $details):
                                            ?>
                                            <tr>
                                                <td><?php echo $details->ledgername; ?></td>
                                                <td><?php echo $details->totalpurchase; ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-striped table-hover table-bordered editable-sample1" id="editable-sample">
                                    <tr>
                                        <td style="font-weight: bold">Cash In Hand</td>
                                        <td><?php echo $totalcashinhand; ?></td>
                                    </tr>
                                    <?php
                                    if (sizeof($cashinhanddetails) > 0):
                                        foreach ($cashinhanddetails as $cashdetails):
                                            ?>
                                            <tr>
                                                <td><?php echo $cashdetails->ledgername; ?></td>
                                                <td><?php echo $cashdetails->totalpurchase; ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    if (sizeof($customerdetails) > 0):
                                        foreach ($customerdetails as $cusdetails):
                                            ?>
                                            <tr>
                                                <td><?php echo $cusdetails->ledgername; ?></td>
                                                <td><?php echo $cusdetails->totalpurchase; ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    if (sizeof($bankdetails) > 0):
                                        foreach ($bankdetails as $bdetails):
                                            ?>
                                            <tr>
                                                <td><?php echo $bdetails->ledgername; ?></td>
                                                <td><?php echo $bdetails->totalpurchase; ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="row" style=" padding-top: 10px">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <section class="panel summary">
                        <header class="panel-heading">
                            Summary
                        </header>
                        <div class="panel-body">
                            <div class="row">
                                <ul class="unstyled amounts">
                                    <li><strong>Total profit :</strong><span class="align-right ">1924</span></li>
                                    <li><strong>Total Liability :</strong><span class="align-right ">64424</span></li>
                                    <li><strong>Total Asset :</strong> <span class="align-right ">64424</span></li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--main content end-->
<!--modal-->

<?php include_once('footer.php'); ?>
<script>
    function togglebankdiv() {
        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
        if (selected_val == "Detailed") {
            $("#Condensed").hide();
            $("#Detailed").show();
        } else {
            $("#Condensed").show();
            $("#Detailed").hide();
        }
    }

    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    $('#datetimepickerfrom').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: start_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });
    $('#datetimepickerto').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: start_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });
</script>