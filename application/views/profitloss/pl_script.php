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

    function Clickheretoprint()
    {
        var comname = "<?php echo $comname; ?>";
        var comaddress = "<?php echo $comaddress; ?>";
        var comemail = "<?php echo $comemail; ?>";
        var selected_val = document.querySelector('input[name="profit_loss_radio"]:checked').value;
        var from_date = $("#datetimepickerfrom").val();
        from_date = from_date.substring(0, 10);
        var to_date = $("#datetimepickerto").val();
        to_date = to_date.substring(0, 10);
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
        docprint.document.write('table {border-collapse:collapse; background-color: #C0C0C0;}');
        docprint.document.write('table thead, tr, th, table tbody, tr, td { border: 1px solid gray; text-align:center;}');
        docprint.document.write('table thead, tr, th{ background-colo: #000;}');
        docprint.document.write('</style></head>');
        docprint.document.write('<body><center>');
        docprint.document.write('<p><span style="margin-top:50px; margin-left:-300px"><img height="50" weidth="50" src="<?php echo base_url("assets/img/avatar1_small_1.jpg"); ?>"/></span></p><p style="margin-top:-60px; margin-left:80px; color: red"><b><u>' + companyname + '</u></b></p>');
        docprint.document.write('<p style="margin-top:-15px; margin-left:80px">' + comaddress + '</p>');
        docprint.document.write('<p style="margin-top:-15px; margin-left:80px">E-mail: ' + comemail + '<hr style="width:700px; margin: -12px 0 -12px 0">');
        docprint.document.write('<p style="margin-left:80px">Details Report for Profit and Loss</p>');
        docprint.document.write('<p style="margin:-15px 0 0 82px">Statement (' + from_date + ' to ' + to_date + ')</p>');
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