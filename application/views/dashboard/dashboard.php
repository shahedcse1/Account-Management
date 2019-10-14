<style type="text/css">
    #dashbordsymbol{
        width: 20%;
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <!--state overview start-->
        <div class="row state-overview">
            <!-- Total Customer -->
            <div id="t_cus">
                <div id="dashbordsymbol" class="col-lg-2 col-sm-6">
                    <section class="panel">
                        <div class="symbol terques">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="value">
                            <h4>
                                <?php
                                $totaluser = $totalcustomer;
                                echo $totaluser ? $totaluser : '0.00';
                                ?>
                            </h4>
                            <p>Total Customer</p>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Total Supplier -->
            <div id="t_sup">
                <div id="dashbordsymbol" class="col-lg-2 col-sm-6">
                    <section class="panel">
                        <div class="symbol terques">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="value">
                            <h4>
                                <?php
                                $totaluser = $totalsupplier;
                                echo $totaluser ? $totaluser : '0.00';
                                ?>
                            </h4>
                            <p>Total Supplier</p>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Total Customer Due -->
            <div id="c_due">
                <div id="dashbordsymbol" class="col-lg-2 col-sm-6">
                    <section class="panel">
                        <div class="symbol red">
                            <i class="fa fa-tags"></i>
                        </div>
                        <div class="value">
                            <h4>
                                <?php echo $totalcustomerdue ? number_format($totalcustomerdue) : '0.00'; ?>
                            </h4>
                            <p>Total Customer Due</p>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Total Supplier Due -->
            <div id="s_due">
                <div id="dashbordsymbol" class="col-lg-2 col-sm-6">
                    <section class="panel">
                        <div class="symbol red">
                            <i class="fa fa-tags"></i>
                        </div>
                        <div class="value">
                            <h4>
                                <?php echo ($totalsupplierdue) ? number_format($totalsupplierdue) : '0.00'; ?>
                            </h4>
                            <p>Total Supplier Due</p>
                        </div>
                    </section>
                </div>
            </div>

            <div id="profit">
                <div id="dashbordsymbol" class="col-lg-2 col-sm-6">
                    <section class="panel">
                        <div class="symbol blue">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="value">
                            <h4>
                                <?php $profitorloss = (($grossprofitcd + $totalindirectincome) - $totalindirectexpense);
                                echo number_format(abs($profitorloss)); ?>
                            </h4>
                            <p>Total <?= $profitorloss < 0 ? 'Loss' : 'Profit'; ?></p>
                        </div>
                    </section>
                </div>
            </div>

            <div id="dashbordclosingbal" class="col-lg-2 col-sm-6">
                <section class="panel">
                    <div class="symbol terques">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="value">
                        <h4>
                            <?php echo $closingstockvalue ? number_format($closingstockvalue) : '0.00'; ?>
                        </h4>
                        <p>Closing Balance</p>
                    </div>
                </section>
            </div>
        </div>



        <div class="row">
            <div id="net" class="col-lg-12">
                <!-- Graph -1 -->
                <div class="col-lg-6" hidden="hidden">  
                    <header class="panel-heading">
                        Monthly Net profit
                    </header>  
                    <div  class="panel">                    
                        <div id="chart_div" style="height: 400px; margin: 0 auto"></div>
                    </div>   
                </div>
                <!-- /Graph -1 -->
                <!-- Graph -2 -->
                <div id="due" class="col-lg-12" >  
                    <header class="panel-heading">
                        Current Month Sales
                    </header>  
                    <div  class="panel">                    
                        <div id="chart_div_due" style="height: 400px; margin: 0 auto"></div>
                    </div>   
                </div>
                <!-- /Graph -2 -->
            </div>

        </div>

        <div class="row" hidden="hidden">
            <div  class="col-lg-12">
                <header class="panel-heading">
                    Current Month Sales
                </header>  
                <div  class="panel-body">                    
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped" id="editable-sample">
                            <thead >
                                <tr>
                                    <th>Date</th>
                                    <th>Quantity</th>   
                                    <th>Amount</th>   
                                <tr>
                            </thead>
                            <tbody>
                                <?php
                                if (sizeof($datearr) > 0):
                                    for ($i = 0; $i < sizeof($datearr); $i++):
                                        ?>
                                        <tr>
                                            <td><?php echo $datearr[$i]; ?></td>
                                            <td><?php
                                                if ($qtyarr[$i] == ""):
                                                    echo "0.00";
                                                else:
                                                    echo $qtyarr[$i];
                                                endif;
                                                ?></td>
                                            <td><?php
                                                if ($amountarr[$i] == ""):
                                                    echo "0.00";
                                                else:
                                                    echo $amountarr[$i];
                                                endif;
                                                ?></td>                                          
                                        </tr>
                                        <?php
                                    endfor;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>  

            </div>
        </div>
        <br/> <br/>
    </section>
</section>


<script>
    $(document).ready(function () {

        document.getElementById('dashbordclosingbal').style.display = "none";
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>

        var role = "<?php echo $this->sessiondata['userrole']; ?>";
        if (role == 's' || role == 'u' || role == 'r' || role == 'f') {
            document.getElementById('due').style.display = "none";
            document.getElementById('net').style.display = "none";
            document.getElementById('c_due').style.display = "none";
            document.getElementById('s_due').style.display = "none";
            document.getElementById('profit').style.display = "none";
            document.getElementById('dashbordclosingbal').style.display = "block";
            if (role == 'f' || role == 'u') {
                document.getElementById('lasttendayssale').style.display = "none";
                document.getElementById('total_customer').style.display = "none";
                document.getElementById('total_supplier').style.display = "none";
            }
               
               if (role == 's' ) {               
                document.getElementById('t_cus').style.display = "none";
                document.getElementById('t_sup').style.display = "none";
                document.getElementById('dashbordclosingbal').style.display = "none";
            }
        }



    });
</script>



<script type="text/javascript">
    $(function () {
        $('#chart_div').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [
                    '<?php echo date_format(date_create($monthname[12]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[11]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[10]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[9]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[8]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[7]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[6]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[5]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[4]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[3]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[2]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[1]), "M-y"); ?>',
                    '<?php echo date_format(date_create($monthname[0]), "M-y"); ?>'
                ],
                labels: {
                    rotation: -45
                }
            },
            yAxis: {
                title: {
                    text: 'Net Profit (BDT)'
                }
            },
            legend: {
                enabled: false,
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                    name: 'Profit',
                    colorByPoint: true,
                    data: [<?php echo $monthvalue[12]; ?>,<?php echo $monthvalue[11]; ?>,<?php echo $monthvalue[10]; ?>,<?php echo $monthvalue[9]; ?>,<?php echo $monthvalue[8]; ?>,<?php echo $monthvalue[7]; ?>,<?php echo $monthvalue[6]; ?>,<?php echo $monthvalue[5]; ?>,<?php echo $monthvalue[4]; ?>,<?php echo $monthvalue[3]; ?>,<?php echo $monthvalue[2]; ?>,<?php echo $monthvalue[1]; ?>,<?php echo $monthvalue[0]; ?>]
                }]
        });
    });

<?php
$strAm = "";
$strDate = "";
$strQty = "";
if (sizeof($datearr) > 0):
    $len = sizeof($datearr);
    for ($i = $len - 1; $i >= 0; $i--):
        $strDate .= "'" . $datearr[$i] . "'" . ",";
        if ($amountarr[$i] == ""):
            $strAm .= "0.00,";
        else:
            $strAm .= $amountarr[$i] . ",";
        endif;

        if ($qtyarr[$i] == ""):
            $strQty .= "0.00,";
        else:
            $strQty .= $qtyarr[$i] . ",";
        endif;

    endfor;
endif;
?>

    $(function () {
//        console.log("<?php //echo $strAm;   ?>");
//        console.log("<?php //echo $strQty;   ?>");
//        console.log("<?php //echo $strDate;   ?>");
        var graphtype = "<?php echo $graph; ?>";
        var type;
        if (graphtype == "1") {
            type = 'column';
        } else {
            type = 'line';
        }

        $('#chart_div_due').highcharts({
            chart: {
                type: type,
            },
            title: {
                text: 'Current Month Sales'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [<?php echo $strDate; ?>],
                labels: {
                    rotation: -45
                },
                crosshair: true
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: true,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:,.0f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    minPointLength: 0
                }
            },
            series: [
                {
//                    type: 'column',
                    name: 'Amount',
//                    colorByPoint: true,
                    data: [<?php echo $strAm ?>]

                },
                {
//                    type: 'column',
                    name: 'Qty',
//                    colorByPoint: true,
                    data: [<?php echo $strQty ?>]
                }

            ]


        });
    });
</script>
