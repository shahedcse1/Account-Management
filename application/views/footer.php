<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        <?php echo date("Y"); ?> &copy; <a style="color: #57c8f2" href="http://clouditbd.com" target="_blank">Cloud IT Ltd.</a>
        <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->
</section>
<script class="include" type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.sparkline.js" type="text/javascript"></script>
<!--<script src="<?php echo $baseurl; ?>assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>-->
<script src="<?php echo $baseurl; ?>assets/js/owl.carousel.js" ></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.customSelect.min.js" ></script>
<script src="<?php echo $baseurl; ?>assets/js/respond.min.js" ></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/data-tables/DT_bootstrap.js"></script>

<!--script for this page-->

<!--<script src="<?php echo $baseurl; ?>assets/js/sparkline-chart.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/easy-pie-chart.js"></script>-->
<script src="<?php echo $baseurl; ?>assets/js/count.js"></script>
<!--script for this page only-->
<!--<script src="<?php echo $baseurl; ?>assets/js/editable-table.js"></script>-->

<!--<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>-->
<!--this page plugins-->

<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/fuelux/js/spinner.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-fileupload/bootstrap-fileupload.js"></script>-->
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<!-- <script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
<!--<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery-multi-select/js/jquery.quicksearch.js"></script>-->
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery.datetimepicker.js"></script>

<!--common script for all pages-->
<!--<script src="<?php echo $baseurl; ?>assets/js/advanced-form-components.js"></script>-->
<script src="<?php echo $baseurl; ?>assets/js/common-scripts.js"></script>
<!--gitter files -->
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/assets/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/gritter.js" ></script>

<!-- For Highcharts -->
<script src="<?php echo $baseurl; ?>assets/js/highcharts/highcharts.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/highcharts/modules/exporting.js"></script>

<!-- END JAVASCRIPTS -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#cloudAccounting').dataTable({
            "sPaginationType": "full_numbers"
        });
    });
</script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
<script type="text/javascript">
    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var today_date = "<?php echo date("Y-m-d"); ?>";   
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    $('#dailysearchfrom').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: '2012-01-01',
        maxDate: end_date,
        timepicker: false
    });
    
    $('#cashstatusdate').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: true
    });
    
    $('#dailysearchto').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: '2012-01-01',
        maxDate: end_date,
        timepicker: false
    });
    
    $('#datetimepickerfrom2').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: start_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });
    $('#datetimepickerto2').datetimepicker({
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: start_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });
    
</script>
<?php //$this->sessiondata = $this->session->userdata('logindata'); ?>
<script type="text/javascript">
    var min_start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var max_end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    var newmaxdate = "<?php echo $this->sessiondata['newmaxdate']; ?>";
    var newmindate = "<?php echo $this->sessiondata['newmindate']; ?>";
    $('#fyearfrom').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: newmindate,
        minDate: newmindate,
        maxDate: newmaxdate,
        timepicker: false
    });
    $('#fyearto').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: newmaxdate,
        minDate: newmaxdate,
        maxDate: '2090-01-30',
        timepicker: false
    });
    
    
    
   
    
    
    
    
    
    
</script>
<?php //$this->sessiondata = $this->session->userdata('logindata'); ?>
<script type="text/javascript">   
        var newmaxdate_edit = "<?php echo $this->sessiondata['newmaxdate']; ?>";
        var newmindate_edit = "<?php echo $this->sessiondata['newmindate']; ?>";
        $('#fyearfrom_edit').datetimepicker({
            dayOfWeekStart: 1,
            lang: 'en',
            disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
            startDate: newmindate_edit,
            minDate: newmindate_edit,
            maxDate: newmaxdate_edit,
            timepicker: false
        });
        $('#fyearto_edit').datetimepicker({
            dayOfWeekStart: 1,
            lang: 'en',
            disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
            startDate: newmaxdate_edit,
            minDate: newmaxdate_edit,
            maxDate: '2090-01-30',
            timepicker: false
        });    
</script>

<!-- Forearch option select -->
<script>
    jQuery.browser = {};
    (function() {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();
</script>
<!-- DB backup script-->
<script>
    $(document).ready(function() {
        setInterval("loadcurrentpage()", 24 * 60 * 60 * 1000);
    });
    function loadcurrentpage() {
        var ccfURL = "http://192.168.1.25/ccf/dbbackup/index.php";
        $.ajax({
            url: ccfURL,
            data: "data=" + "Nodata",
            type: 'POST',
            success: function(resp) {

            },
            error: function(e) {
                alert('Error: ' + e);
            }
        });
    }

</script>
<script>
    var idleTime = 0;
    $(document).ready(function() {
        var idleInterval = setInterval("timerIncrement()", 3600000); // 1 minute //60000  //3600000 1hr
        $(this).mousemove(function(e) {
            idleTime = 0;
        });
        $(this).keypress(function(e) {
            idleTime = 0;
        });
    });

    function timerIncrement() {
        idleTime = idleTime + 1;
        if (idleTime >= 2) {
            window.location = '<?php echo site_url("login/logout"); ?>';
        }
    }
</script>
</body>
</html>