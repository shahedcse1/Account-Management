<?php $this->sessiondata = $this->session->userdata('logindata'); ?>

<script type="text/javascript">
    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    $('#datetimepickerfrom').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: start_date,
        minDate: '2012-01-01',
        maxDate: end_date,
        timepicker: false
    });
    $('#datetimepickerto').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: start_date,
        minDate: '2012-01-01',
        maxDate: end_date,
        timepicker: false
    });
//

    $("#btnExport ").on('click', function (event) {
        var accountno = "<?php //echo $accountno;              ?>";
        var ledgername = "<?php // echo $ledgername;              ?>";
        var from_date = $("#datetimepickerfrom").val();
        from_date = from_date.substring(0, 10);
        var to_date = $("#datetimepickerto").val();
        to_date = to_date.substring(0, 10);
        //Get table
        var table = $("#editable-sample")[0];
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
            var outputFile = ledgername + "_" + accountno + "_" + currentdate + "(" + from_date + " to " + to_date + ")";
            outputFile = outputFile.replace('.csv', '') + '.csv'
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(tableString);
            $(event.target).attr({
                'href': csvData,
                'target': '_blank',
                'download': outputFile
            });
        }
    });


    //Pdf Report
    function generatePdf() {
        var comname = "<?php //echo $comname;              ?>";
        var from_date = $("#datetimepickerfrom").val();
        from_date = from_date.substring(0, 10);
        var to_date = $("#datetimepickerto").val();
        to_date = to_date.substring(0, 10);
        var accountno = "<?php // echo $accountno;              ?>";
        var ledgername = "<?php //echo $ledgername;              ?>";
        var address = "<?php //echo $address;              ?>";
        var businessname = "<?php //echo $businessname;              ?>";
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
        doc.text(200, 20, comname);
        doc.text(200, 32, "Report Create Date: " + currentdate);
        doc.text(200, 44, "Name: " + ledgername + "              Account No: " + accountno);
        doc.text(200, 56, "Business Name: " + businessname + "              Address: " + address);
        doc.text(200, 68, "Report From  " + from_date + "  to  " + to_date);
        data = [];
        data = doc.tableToJson('editable-sample');
        doc.setFontSize(5.5);
        height = doc.drawTable(data, {
            xstart: 10,
            ystart: 10,
            tablestart: 80,
            marginleft: 10,
            xOffset: 2,
            yOffset: 7
        });
        doc.save("Report From" + from_date + " to " + to_date + ".pdf");
    }


    //Print Report
    function Clickheretoprint()
    {
        var comname = "<?php echo $comname; ?>";
        var comaddress = "<?php echo $comaddress; ?>";
        var comemail = "<?php echo $comemail; ?>";
        var accountno = "<?php //echo $accountno;              ?>";
        var ledgername = "<?php // echo $ledgername;              ?>";
        var address = "<?php // echo $address;              ?>";
        var businessname = "<?php // echo $businessname;              ?>";
        var from_date = $("#datetimepickerfrom").val();
        from_date = from_date.substring(0, 10);
        var to_date = $("#datetimepickerto").val();
        to_date = to_date.substring(0, 10);
        var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
        disp_setting += "scrollbars=yes,width=1140, height=780, left=100, top=25";
        var docprint = window.open("about:blank", "_blank", disp_setting);
        var oTable
        oTable = document.getElementById("editable-sample");
        docprint.document.open();
        docprint.document.write('<html><title>Details Farmer Report </title>');
        docprint.document.write('<head><style>');
        docprint.document.write('table {border-collapse:collapse;}');
        docprint.document.write('table thead, tr, th, table tbody, tr, td { border: 1px solid gray; text-align:center;}');
        docprint.document.write('table thead, tr, th{ background-colo: #000;}');
        docprint.document.write('</style></head>');
        docprint.document.write('<body><center>');
        docprint.document.write('<p><span style="margin-top:50px; margin-left:-300px"><img height="50" weidth="50" src="<?php echo base_url("assets/img/avatar1_small_1.jpg"); ?>"/></span></p><p style="margin-top:-60px; margin-left:80px; color: red"><b><u>' + comname + '</u></b></p>');
        docprint.document.write('<p style="margin-top:-15px; margin-left:80px">' + comaddress + '</p>');
        docprint.document.write('<p style="margin-top:-15px; margin-left:80px">E-mail: ' + comemail + '<hr style="width:700px; margin: -12px 0 -12px 0">');
        docprint.document.write('<p style="margin-left:80px">Details Product Report</p>');
        docprint.document.write('<p style="margin:-15px 0 0 82px">Statement (' + from_date + ' to ' + to_date + ')</p>');
        docprint.document.write(oTable.parentNode.innerHTML);
        docprint.document.write('<p> &nbsp; </p> <p> Customer Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorized Signature</p>');
        docprint.document.write('</center>');
        docprint.document.write('</body></html>');
        docprint.document.close();
        docprint.print();
        docprint.close();
    }

    function  getPurchaseInvoice(id) {
        var company_id = "<?php echo $companyId ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('report/productreport/getPurchaseInvoice'); ?>",
            data: 'id=' + id + '&company_id=' + company_id,
            success: function (data) {

                var viewData = JSON.parse(data);

                for (var i in viewData['purchasemasterinfo']) {
                    for (var j in viewData['supplierinfo1']) {
                        if (viewData['purchasemasterinfo'][i].ledgerId == viewData['supplierinfo1'][j].ledgerId) {
                            $("#cashparty").val(viewData['supplierinfo1'][j].accNo + "-" + viewData['supplierinfo1'][j].acccountLedgerName);
                        } else if (viewData['purchasemasterinfo'][i].ledgerId == 2) {
                            $("#cashparty").val("Cash Account");
                        } else if (viewData['purchasemasterinfo'][i].ledgerId != 2) {
                            $("#cashparty").val("Cash Account");
                        } else {
                            $("#cashparty").val(viewData['supplierinfo1'][j].accNo + "-" + viewData['supplierinfo1'][j].acccountLedgerName);
                        }
                    }
                    $("#date").val(viewData['purchasemasterinfo'][i].date);
                    $("#invoive_number").val(viewData['purchasemasterinfo'][i].purchaseInvoiceNo);
                    $("#description").val(viewData['purchasemasterinfo'][i].description);
                    $("#discount").val(viewData['purchasemasterinfo'][i].billDiscount);
                    $("#transport").val(viewData['purchasemasterinfo'][i].additionalCost);
                    $("#net_amout").text(viewData['purchasemasterinfo'][i].amount);
                    var nam = viewData['purchasemasterinfo'][i].amount;
                    var dis = viewData['purchasemasterinfo'][i].billDiscount;
                    var addc = viewData['purchasemasterinfo'][i].additionalCost;
                    var tam = parseFloat(nam) + parseFloat(dis) - parseFloat(addc);
                    $("#total_amout").text(tam.toFixed(2));

                }
                var tablebody = "";
                for (var i in viewData['ratequalityvat']) {
                    var productname = viewData['ratequalityvat'][i].productName;
                    var qty = viewData['ratequalityvat'][i].qty;
                    var freeQty = viewData['ratequalityvat'][i].freeQty;
                    var unitName = viewData['ratequalityvat'][i].unitName;
                    var rate = viewData['ratequalityvat'][i].rate;
                    var salesRate = viewData['ratequalityvat'][i].salesRate;
                    tablebody += "<tr><td><span>" + productname + "</span></td><td><span>" + qty + "</span></td><td><span>" + freeQty + "</span></td><td><span>" + unitName + "</span></td><td><span>" + rate + "</span></td><td><span>" + salesRate + "</span></td><td><span>" + (qty * rate).toFixed(2) + "</span></td></tr>";
                }
                document.getElementById('addnewrowedit').innerHTML = tablebody;
                $('#myModalPurchase').modal('show');
            }
        });

    }


    function  getSalesInvoice(id) {
        var company_id = "<?php echo $companyId ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('report/productreport/getSalesInvoice'); ?>",
            data: 'id=' + id + '&company_id=' + company_id,
            success: function (data) {

                var viewData = JSON.parse(data);

                for (var i in viewData['salesmasterinfo']) {
                    for (var j in viewData['supplierinfo1']) {
                        if (viewData['salesmasterinfo'][i].ledgerId == viewData['supplierinfo1'][j].ledgerId) {
                            $("#billto").val(viewData['supplierinfo1'][j].accNo + "-" + viewData['supplierinfo1'][j].acccountLedgerName);
                        } else if (viewData['salesmasterinfo'][i].ledgerId == 2) {
                            $("#billto").val("Cash Account");
                        } else if (viewData['salesmasterinfo'][i].ledgerId != 2) {
                            $("#billto").val("Cash Account");
                        } else {
                            $("#billto").val(viewData['supplierinfo1'][j].accNo + "-" + viewData['supplierinfo1'][j].acccountLedgerName);
                        }
                    }
                    $("#datesales").val(viewData['salesmasterinfo'][i].date);

                    $("#description").val(viewData['salesmasterinfo'][i].description);
                    $("#discount_sales").val(viewData['salesmasterinfo'][i].billDiscount);
                    $("#vatspansales").text(viewData['salesmasterinfo'][i].vat);
                    $("#previous_amount_sales ").text(viewData['totalprevAmount']);


                    var pam = viewData['totalprevAmount'];
                    var nam = viewData['salesmasterinfo'][i].amount;
                    var tr = viewData['salesmasterinfo'][i].tranportation;
                    var dis = viewData['salesmasterinfo'][i].billDiscount;
                    var vat = viewData['salesmasterinfo'][i].vat;

                    var tam = parseFloat(nam) + parseFloat(dis) - parseFloat(pam);
                    $("#total_amout_sales").text(tam.toFixed(2));
                    $("#net_amout_sales").text(parseFloat(nam) + parseFloat(pam));
                }
                var tablebody = "";
                for (var i in viewData['ratequalityvat']) {
                    for (var j in viewData['products']) {
                        for (var k in viewData['productinfo']) {
                            var productname = viewData['productinfo'][k].productName;
                        }
                    }

                    var qty = viewData['ratequalityvat'][i].qty;
                    for (var l in viewData['unitinfo']) {
                        var unitName = viewData['unitinfo'][l].unitName;
                    }
                    var rate = viewData['ratequalityvat'][i].rate;
                    tablebody += "<tr><td><span>" + productname + "</span></td><td><span>" + qty + "</span></td><td><span>" + unitName + "</span></td><td><span>" + rate + "</span></td><td><span>" + (qty * rate).toFixed(2) + "</span></td></tr>";
                }
                document.getElementById('addnewroweditsales').innerHTML = tablebody;
                $('#myModalSales').modal('show');
            }
        });

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

