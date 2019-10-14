
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function() {
            $.gritter.add({
                title: 'Successfull!',
                text: '<?php echo $this->session->userdata('success'); ?>',
                sticky: false,
                time: '3000'
            });
        })
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
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>
<script type="text/javascript">
    function amountCheck(id) {
        var editamount = parseFloat($('#editamount' + id).val()) || 0;
        if (editamount === 0)
        {
            $('#valuecheckiddiv' + id).html("Please Enter Amount");
            $('#valuecheckiddiv' + id).css('color', 'red');
            return false;
        }
    }
    function addamountCheck() {
        var amount = parseFloat($('#amount').val()) || 0;
        if (amount === 0)
        {
            $('#valuecheck').html("Please Enter Amount");
            $('#valuecheck').css('color', 'red');
            return false;
        }
    }

    function adddebit() {
        var inputs = document.getElementsByClassName('debit'),
                names = [].map.call(inputs, function(input) {
            return input.value;
        });
        var sll = names.length;
        var i, total = 0;
        for (i = 0; i < sll; i++) {
            total = total + (parseFloat(names[i]) || 0);
        }
        $('#total_debit').val(total);
    }
    function addamount() {
        var inputs = document.getElementsByClassName('amount'),
                names = [].map.call(inputs, function(input) {
            return input.value;
        });
        var sll = names.length;
        var i, total = 0;
        for (i = 0; i < sll; i++) {
            total = total + (parseFloat(names[i]) || 0);
        }
        $('#total_amount').val(total);
    }
    function adddebitedit(id) {
        var inputs = document.getElementsByClassName('editdebit' + id),
                names = [].map.call(inputs, function(input) {
            alert(input.value);
            return input.value;
        });

        var sll = names.length;
        var i, total = 0;
        for (i = 0; i < sll; i++) {
            total = total + (parseFloat(names[i]) || 0);
        }

        $('#edittotal_debit' + id).val(total);
    }
    function addcreditedit(id) {
        var inputs = document.getElementsByClassName('editcredit' + id),
                names = [].map.call(inputs, function(input) {
            alert(input.value);
            return input.value;
        });
        var sll = names.length;
        var i, total = 0;
        for (i = 0; i < sll; i++) {
            total = total + (parseFloat(names[i]) || 0);
        }
        $('#edittotal_credit' + id).val(total);
    }
    $(document).ready(function() {
        var divCounter = 2;
        $("#addButton").click(function() {
            var newTextBoxDiv = $(document.createElement('div'))
                    .attr("id", 'TextBoxDiv' + divCounter);
            newTextBoxDiv.after().html('<div class="col-lg-12" style="padding-left: 0px"><div class="panel-body"><div class="form-group"> <div class="col-lg-3"></div><div class="col-lg-4" id="addnewoption' + divCounter + '"></div>\n\
            <div class="col-lg-5"><div class="col-lg-3" style="width:62%;padding-left:0px"><input onchange="addamount()" id="amount' + divCounter + '" type="text" name="amount[]" class="form-control amount" placeholder="0.00" required></div><button type="button" class="btn btn-default pull-right" value="Remove" onclick="removeButton(' + divCounter + ')"><i class="fa fa-minus"></i></button></div></div></div></div>');
            newTextBoxDiv.appendTo("#TextBoxesGroup");
            var c = divCounter;
            var dataString = 'c=' + c;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('journalentry/journalentry/ledgerdata'); ?>",
                data: dataString,
                success: function(data) {
                    $("#addnewoption" + c).html(data);
                }
            });
            divCounter = divCounter + 1;
        });
    });
    function removeButton(divCounter) {
        var newdebit_value = parseFloat($("#debit" + divCounter).val()) || 0;
        var newcredit_value = parseFloat($("#credit" + divCounter).val()) || 0;
        var total_debit = parseFloat($('#total_debit').val()) || 0;
        var total_credit = parseFloat($('#total_credit').val()) || 0;
        var new_total_debit = total_debit - newdebit_value;
        var new_total_credit = total_credit - newcredit_value;
        $("#total_debit").val(new_total_debit);
        $("#total_credit").val(new_total_credit);
        $("#TextBoxDiv" + divCounter).remove();
    }
    function getid(id) {
        $('#editchequedatetimepicker' + id).datetimepicker({
            dayOfWeekStart: 1,
            lang: 'en',
            disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
            startDate: '2014-12-01',
            minDate: start_date,
            maxDate: end_date,
            timepicker: true
        });
        $('#editdatetimepicker' + id).datetimepicker({
            dayOfWeekStart: 1,
            lang: 'en',
            disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
            startDate: '2014-12-01',
            minDate: start_date,
            maxDate: end_date,
            timepicker: true
        });

    }
    //Date time picker
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
    $('#chequedatetimepicker').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: current_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: true
    });


</script>
