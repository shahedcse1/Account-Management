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





    $("#btnExport ").on('click', function(event) {
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
        //doc.text(50, height + 20, 'hi yousuf');
        doc.save("Details_report_" + currentdate + ".pdf");
    }


    function Clickheretoprint()
    {
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
        oTable = document.getElementById("editable-sample");
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
