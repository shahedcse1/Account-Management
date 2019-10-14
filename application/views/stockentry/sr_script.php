<?php
$this->sessiondata = $this->session->userdata('logindata');
$companyid = $this->sessiondata['companyid'];
$comapanyQr = $this->db->query("SELECT companyName FROM company WHERE companyId = '$companyid'");
if ($comapanyQr->num_rows() > 0):
    $companyname = $comapanyQr->row()->companyName;
else:
    $companyname = "N/A";
endif;
?>

<script type="text/javascript">
    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    var today_date = "<?php echo date('Y-m-d'); ?>";
    var companyname = "<?php echo $companyname; ?>";
    $('#datetimepickerfrom').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: start_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });
    $('#datetimepickerto').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });


    function togglebankdiv() {
        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
        if (selected_val == "customer") {
            $("#supplierDiv").hide();
            $("#customerDiv").show();
        } else {
            $("#supplierDiv").show();
            $("#customerDiv").hide();
        }
    }


    $("#btnExport ").on('click', function(event) {
        //Get table
//        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
//        if (selected_val == "group_wise") {
//            var table = $("#editable-sample1")[0];
//        } else {
//            var table = $("#editable-sample")[0];
//        }

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
            var outputFile = "stock_report" + "_" + currentdate;
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
//        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
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
        doc.text(200, 20, "Details Report For Stock");
        //doc.text(190, 35, "From:" + sdate);
        //doc.text(260, 35, "To:" + edate);
        doc.text(200, 32, "Create Date:" + currentdate);
        doc.text(190, 44, "Company Name: " + companyname);
        data = [];
//        if (selected_val == "group_wise") {
//            data = doc.tableToJson('editable-sample1');
//        } else {
//            data = doc.tableToJson('editable-sample');
//        }

        data = doc.tableToJson('editable-sample');
        doc.setFontSize(5.5);
        height = doc.drawTable(data, {
            xstart: 10,
            ystart: 10,
            tablestart: 60,
            marginleft: 10,
            xOffset: 2,
            yOffset: 7
        });
        //doc.text(50, height + 20, 'hi yousuf');
        doc.save("Details_report_" + currentdate + ".pdf");
    }


    function Clickheretoprint()
    {
//        var selected_val = document.querySelector('input[name="bank_book_radio"]:checked').value;
        var comname = "<?php echo $comname; ?>";
        var comaddress = "<?php echo $comaddress; ?>";
        var comemail = "<?php echo $comemail; ?>";
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var currentdate = d.getFullYear() + '-' +
                (('' + month).length < 2 ? '0' : '') + month + '-' +
                (('' + day).length < 2 ? '0' : '') + day;
        var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
        disp_setting += "scrollbars=yes,width=1140, height=780, left=100, top=25";
        var docprint = window.open("about:blank", "_blank", disp_setting);

        var oTable = document.getElementById("editable-sample");
        docprint.document.open();
        docprint.document.write('<html><title>Details Report Of Stock</title>');
        docprint.document.write('<head><style>');
        docprint.document.write('table {border-collapse:collapse; background-color: #C0C0C0;}');
        docprint.document.write('table thead, tr, th, table tbody, tr, td { border: 1px solid gray; text-align:center;}');
        docprint.document.write('table thead, tr, th{ background-colo: #000;}');
        docprint.document.write('</style></head>');
        docprint.document.write('<body><center>');
        docprint.document.write('<p><span style="margin-top:30px; margin-right:220px"><img height="50" weidth="50" src="<?php echo base_url("assets/img/avatar1_small_1.jpg"); ?>"/></span></p><p style="margin-top:-40px; margin-left:80px; color: red"><b><u>' + companyname + '</u></b></p>');
        docprint.document.write('<p style="margin-top:-15px; margin-left:80px">' + comaddress + '</p>');
        docprint.document.write('<p style="margin-top:-15px; margin-left:80px">E-mail: ' + comemail + '<hr style="width:700px; margin: -12px 0 -12px 0">');
        docprint.document.write('<p style="margin-left:80px">Details Report for Stock</p>');
        docprint.document.write('<p style="margin-top:-15px; margin-bottom: 10px; margin-left:82px">Create Date (' + currentdate + ')</p>');
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

