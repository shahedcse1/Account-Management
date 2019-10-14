
<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>

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
                        <form class="tasi-form" method="post" action="<?php echo site_url('profitloss/profitloss'); ?>">
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
                                        <td><?php echo $openingstockvalue; ?></td>
                                        <td>Closing Stock</td>
                                        <td><?php echo $closingstockvalue; ?></td>
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
                                        <td style="color:#009900"><?php echo $grossprofitcd; ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="table_row" >
                                        <td><b>Total</b></td>
                                        <td><b><?php echo ($openingstockvalue + $totalpurchase + $totaldirectexpense + $grossprofitcd); ?></b></td>
                                        <td><b>Total</b></td>
                                        <td><b><?php echo ($closingstockvalue + $totalsalesaccount + $totaldirectincome); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:30px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="" >
                                        <td>Indirect Expense</td>
                                        <td><?php echo $totalindirectexpense; ?></td>
                                        <td>Gross Profit c/d</td>
                                        <td><?php echo $grossprofitcd; ?></td>
                                    </tr>
                                    <tr class="" >
                                        <td style="color:#009900"><b>Net Profit</b></td>
                                        <td style="color:#009900"><b><?php echo (($grossprofitcd + $totalindirectincome) - $totalindirectexpense); ?></b></td>
                                        <td>Indirect Income</td>
                                        <td><?php echo $totalindirectincome; ?></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="" >
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo ($grossprofitcd + $totalindirectincome); ?></b></td>
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo ($grossprofitcd + $totalindirectincome); ?></b></td>
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
                                        <td><?php echo $openingstockvalue; ?></td>
                                        <td>Closing Stock</td>
                                        <td><?php echo $closingstockvalue; ?></td>
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
                                                            <tr> <td><?php echo $purchaserow->acntLName; ?></td> <td><?php echo $purchaserow->purchasevalue; ?></td>  </tr> 
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
                                                            <tr> <td><?php echo $salesrow->acntLName; ?></td> <td><?php echo $salesrow->purchasevalue; ?></td>  </tr> 
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
                                                            <tr> <td><?php echo $dexpenserow->acntLName; ?></td> <td><?php echo $dexpenserow->purchasevalue; ?></td>  </tr> 
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
                                                            <tr> <td><?php echo $dincomerow->acntLName; ?></td> <td><?php echo $dincomerow->purchasevalue; ?></td>  </tr> 
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
                                        <td style="color:#009900"><?php echo $grossprofitcd; ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="table_row" >
                                        <td><b>Total</b></td>
                                        <td><b><?php echo ($openingstockvalue + $totalpurchase + $totaldirectexpense + $grossprofitcd); ?></b></td>
                                        <td><b>Total</b></td>
                                        <td><b><?php echo ($closingstockvalue + $totalsalesaccount + $totaldirectincome); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>

                                    <tr class="table_row" >
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>Gross Profit c/d</td>
                                        <td><?php echo $grossprofitcd; ?></td>
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
                                                            <tr> <td><?php echo $iexpenserow->acntLName; ?></td> <td><?php echo $iexpenserow->purchasevalue; ?></td>  </tr> 
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
                                                            <tr> <td><?php echo $iincomerow->acntLName; ?></td> <td><?php echo $iincomerow->purchasevalue; ?></td>  </tr> 
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
                                        <td style="color:#009900"><b><?php echo (($grossprofitcd + $totalindirectincome) - $totalindirectexpense); ?></b></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#FFFFFF" style="line-height:10px;" colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr class="" >
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo ($grossprofitcd + $totalindirectincome); ?></b></td>
                                        <td><b>Grand Total</b></td>
                                        <td><b><?php echo ($grossprofitcd + $totalindirectincome); ?></b></td>
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
<!--main content end-->
<!--modal-->

<?php include_once('footer.php'); ?>

<?php $this->sessiondata = $this->session->userdata('logindata'); ?>

<script type="text/javascript">
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


    function togglebankdiv() {
        var selected_val = document.querySelector('input[name="profit_loss_radio"]:checked').value;
        if (selected_val == "detailed") {
            $("#condensed").hide();
            $("#detailed").show();
        } else {
            $("#condensed").show();
            $("#detailed").hide();
        }
    }


    $("#btnExport ").on('click', function(event) {
        //Get table
        var selected_val = document.querySelector('input[name="profit_loss_radio"]:checked').value;
        if (selected_val == "detailed") {
            var table = $("#detailed")[0];
        } else {
            var table = $("#condensed")[0];
        }


        //Get number of rows/columns
        var rowLength = table.rows.length;
        var colLength = table.rows[0].cells.length;
        //Declare string to fill with table data
        var tableString = "";
        //Get column headers
        for (var i = 0; i < colLength; i++) {
            tableString += table.rows[0].cells[i].innerHTML.split(",").join("") + ",";
        }


        tableString = tableString.substring(0, tableString.length - 1);
        tableString += "\r\n";
        //Get row data
        for (var j = 1; j < rowLength; j++) {
            for (var k = 0; k < colLength; k++) {
                tableString += table.rows[j].cells[k].innerHTML.split(",").join("") + ",";
            }
            tableString += "\r\n";
        }


        //Save file
        if (navigator.appName == "Microsoft Internet Explorer") {
            //Optional: If you run into delimiter issues (where the commas are not interpreted and all data is one cell), then use this line to manually specify the delimeter
            tableString = 'sep=,\r\n' + tableString;

            myFrame.document.open("text/html", "replace");
            myFrame.document.write(tableString);
            myFrame.document.close();
            myFrame.focus();
            myFrame.document.execCommand('SaveAs', true, 'data.csv');
        }
        else {
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var currentdate = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;
            var outputFile = "Bank_book_report" + "_" + currentdate;
            outputFile = outputFile.replace('.csv', '') + '.csv'
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(tableString);
            $(event.target).attr({
                'href': csvData,
                'target': '_blank',
                'download': outputFile
            });
        }
    });


    function generatePdf() {
        var selected_val = document.querySelector('input[name="profit_loss_radio"]:checked').value;
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var currentdate = d.getFullYear() + '-' +
                (('' + month).length < 2 ? '0' : '') + month + '-' +
                (('' + day).length < 2 ? '0' : '') + day;
        var data = [], fontSize = 9, height = 0, doc;
        doc = new jsPDF('p', 'pt', 'a4', true);
        doc.setFont("times", "normal");
        doc.setFontSize(fontSize);
        //var imgData = 'http://whitecall.ca/payme/assets/image/call.jpg';
        //doc.addImage(imgData, 100, 200, 280, 210, undefined);
        doc.text(200, 20, "Details Report For Bank Book");
        //doc.text(190, 35, "From:" + sdate);
        //doc.text(260, 35, "To:" + edate);
        doc.text(200, 32, "Create Date:" + currentdate);
        doc.text(190, 44, "Company Name: Cloud It Limited");
        data = [];
        if (selected_val == "detailed") {
            data = doc.tableToJson('detailed');
        } else {
            data = doc.tableToJson('condensed');
        }
        doc.setFontSize(5.5);
        height = doc.drawTable(data, {
            xstart: 10,
            ystart: 10,
            tablestart: 80,
            marginleft: 10,
            xOffset: 2,
            yOffset: 7
        });
        //doc.text(50, height + 20, 'hi yousuf');
        doc.save("Details_report_" + currentdate + ".pdf");
    }


    function Clickheretoprint()
    {
        var selected_val = document.querySelector('input[name="profit_loss_radio"]:checked').value;
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var currentdate = d.getFullYear() + '-' +
                (('' + month).length < 2 ? '0' : '') + month + '-' +
                (('' + day).length < 2 ? '0' : '') + day;
        var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
        disp_setting += "scrollbars=yes,width=1140, height=780, left=100, top=25";
        var docprint = window.open("about:blank", "_blank", disp_setting);
        var oTable
        if (selected_val == "detailed") {
            oTable = document.getElementById("detailed");
        } else {
            oTable = document.getElementById("condensed");
        }
        docprint.document.open();
        docprint.document.write('<html><title>Details Report Of Bank Book</title>');
        docprint.document.write('<head><style>');
        docprint.document.write('table {border-collapse:collapse;}');
        docprint.document.write('table thead, tr, th, table tbody, tr, td { border: 1px solid #000; text-align:center;}');
        docprint.document.write('table thead, tr, th{ background-colo: #000;}');
        docprint.document.write('</style></head>');
        docprint.document.write('<body><center>');
        docprint.document.write('<p><h2>Details Report for Bank Book</h2></p>');
        docprint.document.write('<h3>Create Date: ' + currentdate + '</h3>');
        docprint.document.write(oTable.parentNode.innerHTML);
        docprint.document.write('</center></body></html>');
        docprint.document.close();
        docprint.print();
        docprint.close();
    }

</script>


<!-- For pdf export this js included-->
<script src="<?php echo $baseurl; ?>assets/pdfcreate/jspdf.js"></script>
<script src="<?php echo $baseurl; ?>assets/pdfcreate/libs/FileSaver.js/FileSaver.js"></script>
<script src="<?php echo $baseurl; ?>assets/pdfcreate/jspdf.plugin.table.js"></script>     
<script src='<?php echo $baseurl; ?>assets/pdfcreate/libs/png_support/zlib.js' type='text/javascript'></script>
<script src='<?php echo $baseurl; ?>assets/pdfcreate/libs/png_support/png.js' type='text/javascript'></script>
<script src='<?php echo $baseurl; ?>assets/pdfcreate/jspdf.plugin.addimage.js' type='text/javascript'></script>
<script src='<?php echo $baseurl; ?>assets/pdfcreate/jspdf.plugin.png_support.js' type='text/javascript'></script>