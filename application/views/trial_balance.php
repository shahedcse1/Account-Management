<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?> 

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
                Trial Balance Information
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('trialbalance/trialbalance'); ?>">
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
                                        <input type="radio" checked="true" onclick="togglebankdiv()"  value="ledger_wise" id="ledger_wise" name="bank_book_radio">
                                        Ledger Wise &nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input type="radio"  value="group_wise" onclick="togglebankdiv()"  id="group_wise" name="bank_book_radio">
                                        Group Wise
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
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Account Ledger</th>
                                        <th>Account Group</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $lageralldebit = 0;
                                    $lagerallcredit = 0;
                                    $ledgerdatasize = sizeof($ledgerwisedata);
                                    if ($ledgerdatasize > 0):
                                        $sl = 0;
                                        foreach ($ledgerwisedata as $datarow):
                                            $sl++;
                                            $lageralldebit += $datarow->debitsum;
                                            $lagerallcredit += $datarow->creditsum;
                                            ?>
                                            <tr class="">
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $datarow->acccountLedgerName; ?></td>
                                                <td><?php echo $datarow->accountGroupName; ?></td>
                                                <td class="center"><?php echo $datarow->debitsum; ?></td>
                                                <td class="center"><?php echo $datarow->creditsum; ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                    <tr class="">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="center"><b><?php echo $lageralldebit; ?></b></td>
                                        <td class="center"><b><?php echo $lagerallcredit; ?></b></td>
                                    </tr>
                                    <tr class="">
                                        <td colspan="3"><b>Total Balance</b></td>
                                        <td colspan="2"><b> <?php
                                                if ($lageralldebit > $lagerallcredit):
                                                    echo ($lageralldebit - $lagerallcredit) . "Dr";
                                                elseif ($lagerallcredit > $lageralldebit):
                                                    echo ($lagerallcredit - $lageralldebit) . "Cr";
                                                else:
                                                    echo ($lagerallcredit - $lageralldebit);
                                                endif;
                                                ?> </b></td>                                       
                                    </tr>
                                </tbody>
                            </table>                           
                        </div>
                        <div role="tabpanel" class="tab-pane" id="group">
                            <table  class="table table-striped table-hover table-bordered tab-pane active" id="editable-sample1">
                                <thead>
                                    <tr>
                                        <th>Sl No </th>
                                        <th>Account Group</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $lageralldebit = 0;
                                    $lagerallcredit = 0;
                                    $groupdatasize = sizeof($groupwisedata);
                                    if ($groupdatasize > 0):
                                        $sl = 0;
                                        foreach ($groupwisedata as $datarow):
                                            if (($datarow->debitsum > 0) || ($datarow->creditsum > 0)):
                                                $sl++;
                                                $lageralldebit += $datarow->debitsum;
                                                $lagerallcredit += $datarow->creditsum;
                                                ?>
                                                <tr class="">
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $datarow->accountGroupName; ?></td>
                                                    <td class="center"><?php echo $datarow->debitsum; ?></td>
                                                    <td class="center"><?php echo $datarow->creditsum; ?></td>
                                                </tr>
                                                <?php
                                            endif;
                                        endforeach;
                                    endif;
                                    ?>   
                                    <tr class="">
                                        <td></td>
                                        <td></td>
                                        <td class="center"><b><?php echo $lageralldebit; ?></b></td>
                                        <td class="center"><b><?php echo $lagerallcredit; ?></b></td>
                                    </tr>
                                    <tr class="">
                                        <td colspan="2"><b>Total Balance</b></td>
                                        <td colspan="2"><b> <?php
                                                if ($lageralldebit > $lagerallcredit):
                                                    echo ($lageralldebit - $lagerallcredit) . "Dr";
                                                elseif ($lagerallcredit > $lageralldebit):
                                                    echo ($lagerallcredit - $lageralldebit) . "Cr";
                                                else:
                                                    echo ($lagerallcredit - $lageralldebit);
                                                endif;
                                                ?></b> </td>                                       
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
<!--modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="form">
                    <form class="cmxform form-horizontal tasi-form" id="signupForm" method="get" action="">
                        <div class="form-group ">
                            <label for="supplier_name" class="control-label col-lg-3">Supplier Name</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="supplier_name" name="supplier_name" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="address" class="control-label col-lg-3">Address</label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="address" name="address" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="control-label col-lg-3">Phone</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="phone" name="phone" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="mobile" class="control-label col-lg-3">Mobile</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="mobile" name="mobile" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="fax" class="control-label col-lg-3">Fax</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="fax" name="fax" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-3">Email</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="email" name="email" type="email" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="opening_balance" class="control-label col-lg-3 col-sm-3">Opening Balance</label>
                            <div class="col-lg-8 col-sm-8">
                                <input  class="form-control "  type="text" id="opening_balance" name="opening_balance" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="dr_cr" class="control-label col-lg-3 col-sm-3">[Dr] / [Cr]</label>
                            <div class="col-lg-8 col-sm-8">
                                <input   class="form-control "  type="text" id="dr_cr" name="dr_cr" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="description" class="control-label col-lg-3 col-sm-3">Description</label>
                            <div class="col-lg-8 col-sm-8">
                                <input   class="form-control "  type="text" id="description" name="description" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
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
        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
        if (selected_val == "group_wise") {
            $("#ledger").hide();
            $("#group").show();
        } else {
            $("#ledger").show();
            $("#group").hide();
        }
    }


    $("#btnExport ").on('click', function(event) {
        //Get table
        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
        if (selected_val == "group_wise") {
            var table = $("#editable-sample1")[0];
        } else {
            var table = $("#editable-sample")[0];
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
        } else {
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
        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
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
        if (selected_val == "group_wise") {
            data = doc.tableToJson('editable-sample1');
        } else {
            data = doc.tableToJson('editable-sample');
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
        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
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
        if (selected_val == "group_wise") {
            oTable = document.getElementById("editable-sample1");
        } else {
            oTable = document.getElementById("editable-sample");
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