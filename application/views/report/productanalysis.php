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
                Product Report
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('report/productanalysis'); ?>">
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



                                <div class="col-md-2">   
                                    <label>
                                        <button class="btn btn-info" id="productsubmit" type="submit">Submit</button>
                                    </label>   
                                </div>


                            </div>     
                            <p>  </p>
                        </form>                       
                    </div>

                    <br/>
                    <div>
                        <table  class="table table-striped table-hover table-bordered tab-pane active editable-sample1" id="editable-sample">
                            <thead>
                                <tr>
                                    <th> Product Name </th>
                                    <th> Inward Quantity </th>
                                    <th> Outward Quantity </th>
                                    <th> Balance </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalIn = 0;
                                $totalOut = 0;
                                $totalBal = 0;
                                if (sizeof($productAnalysisData) > 0):
                                    foreach ($productAnalysisData as $datarow):
                                        $in = $datarow->inwardQuantity;
                                        $out = $datarow->outwardQuantity;
                                        $bal = $datarow->productbalance;
                                        
                                        $totalIn +=$in;
                                        $totalOut +=$out;
                                        $totalBal +=$bal;
                                        ?>
                                        <tr>
                                            <td><?php echo $datarow->productName; ?></td>
                                            <td><?php echo floor($datarow->inwardQuantity) == $datarow->inwardQuantity ? number_format($datarow->inwardQuantity):number_format($datarow->inwardQuantity,3); ?></td>
                                            <td><?php echo floor($datarow->outwardQuantity) == $datarow->outwardQuantity? number_format($datarow->outwardQuantity):number_format($datarow->outwardQuantity,3); ?></td>                                
                                            <td><?php echo floor($datarow->productbalance) == $datarow->productbalance ? number_format($datarow->productbalance):number_format($datarow->productbalance,3); ?></td>                                 
                                        </tr>
                                        <?php
                                    endforeach;
                                else:
                                    ?>
                                    <tr>
                                        <td colspan="4"> No data found to display </td>
                                    </tr>
                                <?php endif;
                                ?>
                            </tbody>

                            <tr>
                                <td style="font-weight: bold;"> Total </td>
                                <td style="font-weight:bold;"><?php echo floor($totalIn) == $totalIn ? number_format($totalIn):number_format($totalIn,3); ?> </td>
                                <td style="font-weight:bold;"><?php echo floor($totalOut) == $totalOut ? number_format($totalOut):number_format($totalOut,3); ?>  </td>
                                <td style="font-weight:bold;"><?php echo  floor($totalBal) == $totalBal ? number_format($totalBal):number_format($totalBal,3); ?>  </td>

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


