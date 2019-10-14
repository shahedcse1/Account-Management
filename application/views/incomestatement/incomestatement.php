<!--main content start-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Income Statement
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('incomestatement/incomestatement'); ?>">
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
                                            <li><a href="#" onclick="Clickheretoprint()">Print Report</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>     
                            <p> &nbsp; </p>
                        </form>                       
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" id="incomestatement"  class="tab-pane active">
                            <style type="text/css">
                                @media print {  
                                    table {
                                        width: 80%;
                                        margin: 50px 50px 0px 100px;
                                    }
                                    #padding15px {
                                        padding-left: 15px;
                                    }
                                    .bottomline {
                                        border-bottom: 1px solid #000000;
                                        width: 22%;
                                    }
                                    .topline {
                                        border-top: 1px solid #000000;
                                    }
                                    .tdrightalign {
                                        text-align: right;
                                    }
                                    .padding30top {
                                        padding-top: 30px;
                                        font-weight: bold;
                                    }
                                    @page { size: portrait; margin: 0; }
                                }  
                            </style>
                            <table class="table" id="editable-sample">
                                <tbody>
                                    <tr> <td> Sales </td>  <td class="tdrightalign"> <?php
                                            echo number_format($totalsalesaccount, 2);
                                            $grossprofit = $totalsalesaccount - $goodsoldcost;
                                            ?></td></tr>
                                    <tr> <td> Cost of goods sold </td>  <td class="tdrightalign">(<?php echo number_format($goodsoldcost, 2); ?>)</td></tr>
                                    <?php
                                    if ((sizeof($directincomedetails))):
                                        foreach ($directincomedetails as $dincomerow):
                                            $grossprofit += abs($dincomerow->purchasevalue);
                                            ?>
                                            <tr> <td><?php echo $dincomerow->acntLName; ?></td> <td class="tdrightalign"><?php
                                                    if ($dincomerow->purchasevalue == 0):
                                                        echo "0.00";
                                                    else:
                                                        echo number_format(abs($dincomerow->purchasevalue), 2);
                                                    endif;
                                                    ?></td>  </tr> 
                                            <?php
                                        endforeach;
                                    endif;

                                    if (sizeof($directexpensedetails) > 0):
                                        foreach ($directexpensedetails as $dexpenserow):
                                            $grossprofit -= abs($dexpenserow->purchasevalue);
                                            ?>
                                            <tr> <td><?php echo $dexpenserow->acntLName; ?></td> <td class="tdrightalign"><?php
                                                    if ($dexpenserow->purchasevalue == 0):
                                                        echo "0.00";
                                                    else:
                                                        echo "(" . number_format(abs($dexpenserow->purchasevalue), 2) . ")";
                                                    endif;
                                                    ?></td>  </tr> 
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>    
                                    <tr> <td>  </td>  <td class="topline">  </td></tr>
                                    <tr> <td id="padding15px"> <b> Gross Profit </b> </td>  <td class="bottomline tdrightalign"><b> <?php
                                            echo number_format($grossprofit, 2);
                                            ?> </b></td></tr>

                                    <tr> <td class="padding30top"> Operating Expense </td>  <td> </td></tr>

                                    <?php
                                    $totalinexp = 0;
                                    if (sizeof($indirectexpensedetails) > 0):
                                        foreach ($indirectexpensedetails as $iexpenserow):
                                            $totalinexp += abs($iexpenserow->purchasevalue);
                                            ?>
                                            <tr> <td id="padding15px"><?php echo $iexpenserow->acntLName; ?></td> <td class="tdrightalign"><?php
                                                    if ($iexpenserow->purchasevalue == 0):
                                                        echo "0.00";
                                                    else:
                                                        echo number_format(abs($iexpenserow->purchasevalue), 2);
                                                    endif;
                                                    ?></td>  </tr> 
                                        <?php endforeach; ?>
                                        <tr> <td>  </td>  <td class="topline">  </td></tr>
                                        <?php
                                    endif;
                                    ?>

                                    <tr> <td id="padding15px">  Total Operating Expense </td>  <td class="bottomline tdrightalign"> <?php
                                            echo number_format($totalinexp, 2);
                                            ?> </td></tr>

                                    <tr> <td class="padding30top"> Operating Income </td>  <td class="bottomline tdrightalign padding30top"> <?php
                                            $operatingincome = $grossprofit - $totalinexp;
                                            echo number_format($operatingincome, 2);
                                            ?> </td></tr>

                                    <tr> <td class="padding30top"> Non-Operating or other </td>  <td> </td></tr>
                                    <?php
                                    $totalinincome = 0;
                                    if (sizeof($indirectincomedetails) > 0):
                                        foreach ($indirectincomedetails as $iincomerow):
                                            $totalinincome += abs($iincomerow->purchasevalue);
                                            ?>
                                            <tr> <td id="padding15px"><?php echo $iincomerow->acntLName; ?></td> <td class="tdrightalign"><?php
                                                    if ($iincomerow->purchasevalue == 0):
                                                        echo "0.00";
                                                    else:
                                                        echo number_format(abs($iincomerow->purchasevalue), 2);
                                                    endif;
                                                    ?></td>  </tr> 
                                        <?php endforeach; ?>
                                        <tr> <td>  </td>  <td class="topline">  </td></tr>
                                    <?php endif;
                                    ?>

                                    <tr> <td id="padding15px">  Total Non-Operating </td>  <td class="bottomline tdrightalign"> <?php
                                            echo number_format($totalinincome, 2);
                                            ?> </td></tr>

                                    <tr> <td class="padding30top"> Net Income </td>  <td class="bottomline tdrightalign padding30top">  <?php
                                            $netincome = $operatingincome + $totalinincome;
                                            echo number_format($netincome, 2);
                                            ?> </td></tr>

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


<style type="text/css">
    .table > tbody > tr > td {
        border-top: 0px solid #ddd;
        line-height: 1.42857;
        padding: 2px;
    }

    .table {
        margin-left: 20%;
        width:60%;
    }

    #padding15px {
        padding-left: 30px;
    }
    .bottomline {
        border-bottom: 1px solid #000000;     
        width: 22%;
    }
    .topline {
        border-top: 1px solid #000000;
    }
    table.table tr td {
        text-align: left;
    }
    .tdrightalign {
        text-align: right !important;       
    }
    .padding30top {
        padding-top: 20px !important;
        font-weight: bold;
    }


</style>


