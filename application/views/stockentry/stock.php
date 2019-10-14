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
                Stock Entry Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('stockentry/stock'); ?>">
                            <div class="form-group">

                                <div class="col-md-5" style="padding-left: 0">
                                    <div class="input-group input-sm" >
                                        <span class="input-group-addon">From </span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text"  id="" class="form-control" name="date_from"
                                                   value="<?php echo $date_from; ?>" readonly>
                                        </div>
                                        <span class="input-group-addon">To</span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" id="datetimepickerto2" class="form-control" name="date_to" 
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
                        </form>       
                    </div>
                    <div>
                        <table  class="display table table-bordered table-striped" id="editable-sample">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Product Name</th>
                                    <th>Current Stock</th>
                                    <th>Product Group </th>
                                    <th>Manufacturer</th>
                                    <?php if ($userrole == 'a'): ?>
                                        <th>Purchase Rate</th>
                                    <?php endif; ?>
                                    <th>Sales Rate</th>
                                    <?php if ($userrole == 'a'): ?>
                                        <th>Value</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align:right">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <?php if ($userrole == 'a'): ?>
                                        <th colspan="2" style="text-align:right">Total:</th>   
                                        <?php endif; ?>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $total_current_stock = 0;
                                if (sizeof($stockdata) > 0):
                                    $sl = 0;
                                    foreach ($stockdata as $datarow):
                                        $sl++;
                                        $total_current_stock += $datarow->currentstock;
                                        ?>
                                        <tr>
                                            <td> <?php echo $sl; ?> </td>
                                            <td><?php echo $datarow->productName; ?></td>
                                            <td><?php echo $datarow->currentstock; ?></td>
                                            <td><?php echo $datarow->productGroupName; ?></td>
                                            <td><?php echo $datarow->manufactureName; ?></td>
                                            <?php if ($userrole == 'a'): ?>
                                                <td><?php echo $datarow->purchaseRate; ?></td>
                                            <?php endif; ?>                                        
                                            <td><?php echo $datarow->salesRate; ?></td>
                                            <?php if ($userrole == 'a'): ?>
                                                <td><?php echo number_format(($datarow->currentstock * $datarow->purchaseRate), 2); ?></td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
<!--                            <tr>
                                <td></td>
                                <td><b> Total </b></td>
                                <td> <b> <?php //echo $total_current_stock;       ?> </b></td>                                                                   
                                <td></td>
                                <td></td>
                            <?php if ($userrole == 'a'): ?>
                                                            <td></td>
                            <?php endif; ?>   
                                <td></td>
                                <td></td>
                            </tr>  -->
                        </table>     
                    </div>

                </div>
            </div> 
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->


<!--<link rel="stylesheet" href="http://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">-->
<!-- jQuery library -->
<!--<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>-->

<script type="text/javascript" src="<?php echo $baseurl; ?>assets/assets/dt-column-sum/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/assets/dt-column-sum/jquery.dataTables.min.js"></script>

<script>
                                                $(document).ready(function () {
                                                    var userrole = "<?php echo $userrole; ?>";
                                                    if (userrole == 'a') {
                                                        $('#editable-sample').DataTable({
                                                            "footerCallback": function (row, data, start, end, display) {
                                                                var api = this.api(), data;
                                                                // Remove the formatting to get integer data for summation
                                                                var intVal = function (i) {
                                                                    return typeof i === 'string' ?
                                                                            i.replace(/[\$,]/g, '') * 1 :
                                                                            typeof i === 'number' ?
                                                                            i : 0;
                                                                };
                                                                // Total over all pages
                                                                total = api
                                                                        .column(2)
                                                                        .data()
                                                                        .reduce(function (a, b) {
                                                                            return intVal(a) + intVal(b);
                                                                        }, 0);
                                                                // Total over this page
                                                                pageTotal = api
                                                                        .column(2, {page: 'current'})
                                                                        .data()
                                                                        .reduce(function (a, b) {
                                                                            return intVal(a) + intVal(b);
                                                                        }, 0);
                                                                // Update footer
                                                                $(api.column(2).footer()).html(
                                                                        pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' ( ' + total.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' total)'
                                                                        );
                                                                //another column
                                                                // Total over all pages
                                                                total = api
                                                                        .column(7)
                                                                        .data()
                                                                        .reduce(function (a, b) {
                                                                            return intVal(a) + intVal(b);
                                                                        }, 0);
                                                                // Total over this page
                                                                pageTotal = api
                                                                        .column(7, {page: 'current'})
                                                                        .data()
                                                                        .reduce(function (a, b) {
                                                                            return intVal(a) + intVal(b);
                                                                        }, 0);
                                                                // Update footer
                                                                $(api.column(7).footer()).html(
                                                                        pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' ( ' + total.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' total)'
                                                                        );
                                                            }
                                                        });

                                                    } else {
                                                     $('#editable-sample').DataTable({
                                                            "footerCallback": function (row, data, start, end, display) {
                                                                var api = this.api(), data;
                                                                // Remove the formatting to get integer data for summation
                                                                var intVal = function (i) {
                                                                    return typeof i === 'string' ?
                                                                            i.replace(/[\$,]/g, '') * 1 :
                                                                            typeof i === 'number' ?
                                                                            i : 0;
                                                                };
                                                                // Total over all pages
                                                                total = api
                                                                        .column(2)
                                                                        .data()
                                                                        .reduce(function (a, b) {
                                                                            return intVal(a) + intVal(b);
                                                                        }, 0);
                                                                // Total over this page
                                                                pageTotal = api
                                                                        .column(2, {page: 'current'})
                                                                        .data()
                                                                        .reduce(function (a, b) {
                                                                            return intVal(a) + intVal(b);
                                                                        }, 0);
                                                                // Update footer
                                                                $(api.column(2).footer()).html(
                                                                        pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' ( ' + total.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' total)'
                                                                        );
                                                               
                                                            }
                                                        });
                                                    }
                                                    //end if statement
                                                });

</script>
<!--<script>

    $(document).ready(function () {
        $('#editable-sample').dataTable();
    });

</script>-->


