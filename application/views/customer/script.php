<script type="text/javascript">
    function customerNameCheck() {
        var customer_name = $("#customer_name1").val();
        var dataString = "suppname=" + customer_name;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/customerNameCheck'); ?>",
            data: dataString,
            success: function (data) {
                if (data == 'free') {
                    $("#customer_name1").css('border-color', 'green');
                    $("#servermsg").text("Customer name available");
                    $("#servermsg").css('color', 'green');
                    //return true;
                }
                if (data == 'booked') {
                    $("#customer_name1").css('border-color', 'red');
                    $("#servermsg").text("Customer Name not Available. Please try another");
                    $("#servermsg").css('color', 'red');
                    //return true;
                }

            }
        });
    }
    function customerNameCheckedit(id) {
        var customer_name = $("#customer_name2" + id).val();
        var dataString = "suppname=" + customer_name;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/customerNameCheck'); ?>",
            data: dataString,
            success: function (data) {
                if (data == 'free') {
                    $("#customer_name2" + id).css('border-color', 'green');
                    $("#servermsg2" + id).text("Customer name available");
                    $("#servermsg2" + id).css('color', 'green');
                    return true;
                }
                if (data == 'booked') {
                    $("#customer_name2" + id).css('border-color', 'red');
                    $("#servermsg2" + id).text("Customer Name not Available. Please try another");
                    $("#servermsg2" + id).css('color', 'red');
                    //return true;
                }
            }
        });
    }



    var today_date = "<?php echo date("Y-m-d"); ?>";
    $('#dateofbirth').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: '1900-01-01',
        maxDate: today_date,
        minView: 2,
        format: 'Y-m-d',
        timepicker: false
    });

    $('#editdateofbirth').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: '1900-01-01',
        maxDate: end_date,
        minView: 2,
        format: 'Y-m-d',
        timepicker: false
    });



</script>



