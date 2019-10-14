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

    function Clickheretoprint()
    {
        var comname = "<?php echo $comname; ?>";
        var comaddress = "<?php echo $comaddress; ?>";
        var comemail = "<?php echo $comemail; ?>";
        var from_date = $("#datetimepickerfrom").val();
        from_date = from_date.substring(0, 10);
        from_date = formatDate(from_date);
        var to_date = $("#datetimepickerto").val();
        to_date = to_date.substring(0, 10);
        to_date = formatDate(to_date);
        var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
        disp_setting += "scrollbars=yes,width=1140, height=780, left=100, top=25";
        var docprint = window.open("about:blank", "_blank", disp_setting);
        var oTable
        oTable = document.getElementById("incomestatement");
        docprint.document.open();
        docprint.document.write('<html><title>Income Statement</title>');
        docprint.document.write('<head><style>');
        docprint.document.write('table {border-collapse:collapse; background-color: #000000;}');
        docprint.document.write('table thead, tr, th, table tbody, tr, td { border: 0px solid gray; }');
        docprint.document.write('table thead, tr, th{ background-colo: #000;}');
        docprint.document.write('</style></head>');
        docprint.document.write('<body><center>');
        docprint.document.write('<p style="margin-top:20px; font-size:20px;"><b>' + companyname + '</b></p>');
        docprint.document.write('<p style="margin-top:-14px;font-size:18px;"><b>Income Statement</b></p>');
        docprint.document.write('<p style="margin-top:-14px"><b>Date: ' + from_date + ' to ' + to_date + '</b></p>');
        docprint.document.write(oTable.parentNode.innerHTML);
        docprint.document.write('</center></body></html>');
        docprint.document.close();
        docprint.print();
        docprint.close();
    }

    function formatDate(inputdate) {
        var datestr = inputdate.split("-");
        var day = datestr[2];
        var mn = datestr[1];
        var yr = datestr[0];
        var formateddate = day + "-" + mn + "-" + yr;
        return formateddate;
    }

</script>