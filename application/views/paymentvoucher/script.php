<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function() {
            $.gritter.add({
                title: 'Successfull!',
                text: '<?php echo $this->session->userdata('success'); ?>',
                sticky: false,
                time: '3000'
            });
        });
    </script>    
    <?php
    $this->session->unset_userdata('success');
endif;
?>
<?php if ($this->session->userdata('fail')): ?>
    <script>
        $(document).ready(function() {
            $.gritter.add({
                title: 'Successfull!',
                text: '<?php echo $this->session->userdata('success'); ?>',
                sticky: false,
                time: '3000'
            });
        });
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>
<script type="text/javascript">
    $(document).ready(function() {
        window.onload = function() {
            $('#paymentMode').empty();
            var value = "By Cash";
            var dataString = 'value=' + value;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('paymentvoucher/paymentvoucher/getledger'); ?>",
                data: dataString,
                cache: false,
                success: function(data) {
                    $('#paymentMode').append(data).selectpicker('refresh');
                }
            });
            //$('#chequeNumber').prop('readonly', true);
            //$('#chequeDate').prop('readonly', true);
        };
        $('.radiobutton').click(function() {
            $('#paymentMode').empty();
            $('#currentbalance').val("");
            var value = $(this).val();
            if (value === "By Cheque") {
                
              
                //$('#chequeNumber').prop('readonly', false);
                //$('#chequeDate').prop('readonly', false);
                $('#paymentMode').prop('disabled', false);
                var dataString = 'value=' + value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('paymentvoucher/paymentvoucher/getledger'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(data) {
                         console.log("if-ByCheque"+data);
                        $('#paymentMode').append(data).selectpicker('refresh');
                    }
                });
            }
            else {
                $('#paymentMode').empty();
               
                var dataString = 'value=' + value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('paymentvoucher/paymentvoucher/getledger'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(data) {
                          console.log("else-ByCheque"+data);
                        $('#paymentMode').append(data).selectpicker('refresh');
                    }
                });
                //$('#chequeNumber').prop('readonly', true);
                //$('#chequeDate').prop('readonly', true);
            }
        });
        
        
        //For edit payment voucher
        $('.radiobutton').click(function() {
            $('#editpaymentMode').empty();
            $('#currentbalance').val("");
            var value = $(this).val();
            if (value === "By Cheque") {
                //$('#chequeNumber').prop('readonly', false);
                //$('#chequeDate').prop('readonly', false);
                $('#editpaymentMode').prop('disabled', false);
                var dataString = 'value=' + value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('paymentvoucher/paymentvoucher/getledger'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(data) {
                         console.log("if-ByCash"+data);
                        $('#editpaymentMode').append(data).selectpicker('refresh');
                    }
                });
            }
            else {
                $('#editpaymentMode').empty();
                var dataString = 'value=' + value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('paymentvoucher/paymentvoucher/getledger'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(data) {
                          console.log("else-ByCash"+data);
                        $('#editpaymentMode').append(data).selectpicker('refresh');
                    }
                });
            }
        });
        
        
        $('.hidefields').hide();
        $('#voucherType').change(function() {
            var purid = $("#voucherType").val();
            var ledgerid = $('#ledgerId').val();
            var dataString = 'purid=' + purid + '&ledgerid=' + ledgerid;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('paymentvoucher/paymentvoucher/invoicedata'); ?>",
                data: dataString,
                dataType: 'json',
                success: function(data) {
                    $('#fullamount').val(data.amountvalue);
                    $('#purchaseid').val(data.purchaseid);
                    $('#voucherNumber').val(data.purchaseid);
                }
            });
            $('.hidefields').show();
        });
    });
    $('#paymentMode').change(function() {
        var ledgerid = $('#paymentMode').val();
        if (ledgerid === "addsuplr") {
            $('#myModalsup').modal();
        }
    });
    $('#ledgerId').change(function() {
        var value = $('#ledgerId').val();
        var dataString = 'ledgerid=' + value;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('paymentvoucher/paymentvoucher/currentbalance'); ?>",
            data: dataString,
            success: function(data) {
                $('#currentbalance').val(data);
            }
        });
        if (value === "addpsuplr") {
            $('#myModalsup').modal();
        }
    });

    $('#submitaddsupplier').click(function() {
        var accountGrName = $("#servermsg").html();
        var supplier_name = $("#supplier_name1").val();
        if (accountGrName === "Supplier Name not Available. Please try another") {
            $("#supplier_name1").focus();
            return false;
        }
        else if (supplier_name == "") {
            $("#supplier_name1").css('border-color', 'red');
            $("#servermsg").text("This field is required!");
            $("#servermsg").css('color', 'red');
            return false;
        }
    });

    function setpaidto()
    {
        $('#ledgerId').empty();
        var paymentMode = $('#paymentMode').val();
        //var ledgerid = $('#ledgerid')
        var curr = paymentMode.split(',');
        var ledgerid = curr[0];
        $("#ledgeridpaymentMode").val(curr[0]);
        $("#accountGroupId").val(curr[1]);
        var dataString = 'ledgerid=' + ledgerid;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('paymentvoucher/paymentvoucher/paidtoname'); ?>",
            data: dataString,
            cache: false,
            success: function(data) {
                $('#ledgerId').append(data).selectpicker('refresh');
            }
        });
    }
    function vouinfo()
    {
        var valag = $("#agnstornew").val();
        $('#referenceType').val(valag);
        var ledgerid = $('#ledgerId').val();
        var dataString = 'ledgerid=' + ledgerid;
        if (valag === "Against") {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('paymentvoucher/paymentvoucher/vouinfo'); ?>",
                data: dataString,
                success: function(data) {
                    $('#voucherType').append(data);
                }
            });
        }
        if (valag === "New") {
            $('.hidefields').show();
            $('#voucherType').empty();
            $('#purchaseid').val("");
            $('#fullamount').val("");
        }
        else
        {
            $('#voucherType').empty();
        }
    }
    function editvouinfo(id)
    {
        var paymentmasid = $('#paymentmasid').val();
        var dataString = "id=" + id + "&paymentmasid=" + paymentmasid;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('paymentvoucher/paymentvoucher/editvouinfo'); ?>",
            data: dataString,
            success: function(data) {
                document.getElementById("editvoutype").innerHTML = data;
            }
        });
    }
    function excuteall()
    {
        againstclick1();
        editmodalinfo();
    }
    function editmodalinfo()
    {
        var purid = $("#voucherType").val();
        var ledgerid = $('#ledgerId').val();
        var dataString = 'purid=' + purid + '&ledgerid=' + ledgerid;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('paymentvoucher/paymentvoucher/invoicedata'); ?>",
            data: dataString,
            dataType: 'json',
            success: function(data) {
                $('#fullamount').val(data.amountvalue);
                $('#purchaseid').val(data.purchaseid);
                $('#voucherNumber').val(data.purchaseid);
            }
        });
    }
    function againstclick1() {
        var id = $('#ledgerId').val();
        var ref = $('#referenceType').val();
        var paymentmasid = $('#paymentmasid').val();
        var dataString = "id=" + id + "&paymentmasid=" + paymentmasid + "&ref=" + ref;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('paymentvoucher/paymentvoucher/editvouinfo'); ?>",
            data: dataString,
            success: function(data) {
                document.getElementById("editvoutype").innerHTML = data;
            }
        });
    }

    function amountbalance()
    {
        var fullamount = parseFloat($('#fullamount').val()) || 0;
        var paidamount = parseFloat($('#paidamount').val()) || 0;
        var type = $('#agnstornew').val();
        if (type === 'Against') {
            if (paidamount <= fullamount) {
                $('#amount').val(paidamount);
                $('#pservermsg').html("Valid Paid Amount");
                $('#pservermsg').css('color', 'green');
                $('#myModalagnst').modal('hide');
            }
            else {
                $('#pservermsg').html("Paid Amount Cannot Large Than Due Amount !");
                $('#pservermsg').css('color', 'red');
                return false;
            }
        }
        if (type === 'New') {
            $('#amount').val(paidamount);
            $('#pservermsg').html("Valid Paid Amount");
            $('#pservermsg').css('color', 'green');
            $('#myModalagnst').modal('hide');
        }
    }

    function editamountbalance()
    {
        var editfullamount = parseFloat($('#fullamount').val()) || 0;
        var editpaidamount = parseFloat($('#editpaidamount').val()) || 0;
        var referenceType = $('#referenceType').val();
        if (referenceType === 'Against') {
            if (editpaidamount <= editfullamount) {
                $('#amount').val(editpaidamount);
                $('#balancemsg').html("Valid Paid Amount");
                $('#balancemsg').css('color', 'green');
                $('#editmyModalagnst').modal('hide');
            }
            else {
                $('#balancemsg').html("Paid Amount Cannot Large Than Due Amount !");
                $('#balancemsg').css('color', 'red');
                return false;
            }
        }
        if (referenceType === 'New') {
            $('#amount').val(editpaidamount);
            $('#balancemsg').html("Valid Paid Amount");
            $('#balancemsg').css('color', 'green');
            $('#editmyModalagnst').modal('hide');
        }
    }
    function supplierNameCheck() {
        var supplier_name = $("#supplier_name1").val();
        var dataString = "suppname=" + supplier_name;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('supplier/suppliernamecheck'); ?>",
            data: dataString,
            success: function(data) {
                if (data == 'free') {
                    $("#supplier_name1").css('border-color', 'green');
                    $("#servermsg").text("Supplier name available");
                    $("#servermsg").css('color', 'green');
                    //return true;
                }
                if (data == 'booked') {
                    $("#supplier_name1").css('border-color', 'red');
                    $("#servermsg").text("Supplier Name not Available. Please try another");
                    $("#servermsg").css('color', 'red');
                    //return true;
                }
            }
        });
    }
    function GetBusinessName() {
        var ledgerId = $("#ledgerId").val();       
        var dataString = "ledgerId=" + ledgerId;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('paymentvoucher/paymentvoucher/GetBusinessName'); ?>",
            data: dataString,
            success: function(data) {              
               $('#businessname').val(data);
            }
        });
    }

<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    var current_date = "<?php echo date('Y-m-d H:i:s'); ?>";
    $('#datetimepicker').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: current_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: true
    });
    $('#datetimepickercheque').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: current_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: true
    });
    $('#datetimepickerchequeelse').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: current_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: true
    });
    $('#chequeDate').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: current_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: true
    });
</script>

