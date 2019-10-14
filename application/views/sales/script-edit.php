<script>

    var vatassign = 0;  // assign vat 5% for now

    /*  //To stop form action by pressing enter key
     $("form").keypress(function (e) {
     //Enter key
     if (e.which == 13) {
     return false;
     }
     });  */

    //customer name check
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
                    $("#servermsg2").text("Customer name available");
                    $("#servermsg2").css('color', 'green');
                    //return true;
                }
                if (data == 'booked') {
                    $("#customer_name1").css('border-color', 'red');
                    $("#servermsg2").text("Customer Name not Available. Please try another");
                    $("#servermsg2").css('color', 'red');
                    //return true;
                }

            }
        });
    }



    // Add new customer
    $('#submitaddcustomer').click(function () {
        var accountGrName = $("#servermsg2").html();
        var customer_name = $("#customer_name1").val();
        if (accountGrName === "Customer Name not Available. Please try another") {
            $("#customer_name1").focus();
            return false;
        } else if (customer_name == "") {
            $("#customer_name1").css('border-color', 'red');
            $("#servermsg2").text("This field is required!");
            $("#servermsg2").css('color', 'red');
            return false;
        } else {
            var address = $("#address1").val();
            var phone = $("#phone1").val();
            var mobile = $("#mobile1").val();
            var email = $("#email1").val();
            var dr_cr = $("#dr_cr1").val();
            var opening_balance = $("#opening_balance1").val();
            var description = $("#description1").val();
            var company_id = $("#company_id1").val();
            var dataString = "customer_name=" + customer_name + "&address=" + address + "&phone=" + phone + "&company_id=" + company_id + "&mobile=" + mobile + "&email=" + email + "&dr_cr=" + dr_cr + "&opening_balance=" + opening_balance + "&description=" + description;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('customer/customer/add'); ?>",
                data: dataString,
                success: function (data) {
                    if (data == 'Added') {
                        $('#myModalnews').modal('hide');
                        $.gritter.add({
                            title: 'Successfull!',
                            text: 'Customer Added Successfully',
                            sticky: false,
                            time: '5000'
                        });
                        return true;
                        location.reload(4000);
                    }
                    if (data === 'Notadded') {
                        $('#myModalnews').modal('hide');
                        $.gritter.add({
                            title: 'Unsuccessfull!',
                            text: 'Customer Not Added ',
                            sticky: false,
                            time: '2000'
                        });
                    }
                }
            });
        }
    });
    // Add new customer
    $("#corparty_account").change(function () {
        var value = $("#corparty_account").val();
        if (value == "3newone") {
            $('#myModalnews').modal();
        }
    });

    //==============================for edit page=========================

    //3rd part calculation
    var countproduct = $("#count_product").val();
    var count = 1;
    var countqtyrate = 0;
    for (count; count <= countproduct; count++) {
        //3rd part
        var qty2 = parseFloat($("#qty" + count).val());
        var rate2 = parseFloat($("#rate" + count).val());
        var qtyrate = qty2 * rate2;
        countqtyrate = countqtyrate + qtyrate;  //Total quantity* qty
    }
    var grandtotal = countqtyrate;  //grand total
    var discount = $("#discount").val();
    var transport = parseFloat($("#transport").val());
    var vat = parseFloat($("#vat").val());
    var previous_amount = $(".previous_amount").val();
    var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount + vat + parseFloat(previous_amount);

    var grandtotal = Math.ceil(grandtotal * 2) / 2;
    var net_amout = Math.ceil(net_amout * 2) / 2;

    document.getElementById("total_amout").innerHTML = grandtotal;
    $(".total_amout").val(grandtotal);

    document.getElementById("grandtotal").innerHTML = grandtotal;
    $(".grandtotal").val(grandtotal);

    document.getElementById("net_amout").innerHTML = net_amout;
    $(".net_amout").val(net_amout);

    //3rd part for discount
    $("#discount").change(function () {
        var grandtotal = $(".grandtotal").val();
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vatamount = (grandtotal - discount) * vatassign;
        $("#vatspan").text(vatamount);
        $("#vat").val(vatamount);
        var vat = parseFloat($("#vat").val());
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount + vat + parseFloat(previous_amount);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);
        $("#paidamount").val(net_amout);
    });
    $("#transport").change(function () {
        var grandtotal = $(".grandtotal").val();
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vat = parseFloat($("#vat").val());
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount + vat + parseFloat(previous_amount);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);
        $("#paidamount").val(net_amout);
    });

    $("#vat").change(function () {
        var grandtotal = $(".grandtotal").val();
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vat = parseFloat($("#vat").val());
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount + vat + parseFloat(previous_amount);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);
    });

    //click on reset for products
    $("#product-reset").click(function () {
        $("#product_name").val("");
        $("#product").val("");
        $("#qtyi").val("");
        $("#unit").val("");
        $("#unitshow").val("");
        $("#ratei").val("");
    });


    //when click on rows
    $(".single_row").click(function () {
        var no = $(this).attr("id");
        var product_id = $("#product_id" + no).val();
        var qty = $("#qty" + no).val();
        var unit_id = $("#unit_id" + no).val();
        var unit_name = $("#product_unitdata" + no).text();
        var product_name = $("#product_namedata" + no).text();
        var rate = $("#rate" + no).val();
        console.log("product_name" + product_name);
        console.log("unit_name" + unit_name);
        //paste values
        $("#product_name").val(product_name);
        $("#product").val(product_id);
        $("#qtyi").val(qty);
        $("#unit").val(unit_id);
        $("#unitshow").val(unit_name);
        $("#ratei").val(rate);
        $("#count").val(no);
    });
    //when click on edit
    $("#addpurchase").click(function () {
        var product_id = $("#product").val();
        var qtyi = $("#qtyi").val();
        var unit = $("#unit").val();
        var ratei = $("#ratei").val();
        var count = $("#count").val();
        var qtymsg = $("#qtymsg").text();

        if (qtymsg == "Limit exceeds!") {
            return false;
        }

        if (product_id == "") {
            $("#product_name").css('border-color', 'red');
            return false;
        } else {
            $("#product_name").css('border-color', '#898990');
        }
        if (qtyi == "") {
            $("#qtyi").css('border-color', 'red');
            return false;
        } else {
            $("#qtyi").css('border-color', '#898990');
        }
        if (ratei == "") {
            $("#ratei").css('border-color', 'red');
            return false;
        } else {
            $("#ratei").css('border-color', '#898990');
        }

        $("#product_id" + count).val(product_id);
        $("#qty" + count).val(qtyi);
        $(".qty" + count).text(qtyi);
        $("#unit_id" + count).val(unit);
        $("#rate" + count).val(ratei);
        $(".rate" + count).text(ratei);
        var dataString = "product_id=" + product_id + "&unitid=" + unit;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/dataqueryedit'); ?>",
            data: dataString,
            success: function (data) {
                var res = data.split(",");
                $(".product_id" + count).text(res[0]);
                $(".unit_id" + count).text(res[1]);
            }
        });


        //3rd part calculation after click on edit
        var countproduct = $("#count_product").val();
        var count = 1;
        var countqtyrate = 0;
        for (count; count <= countproduct; count++) {
            //3rd part
            var qty2 = parseFloat($("#qty" + count).val());
            var rate2 = parseFloat($("#rate" + count).val());

            var qtyrate = qty2 * rate2;
            //Net amount per product
            var grandtotalproduct = qtyrate;  //total amount
            $("#product_amount" + count).text(grandtotalproduct); //Input field

            countqtyrate = countqtyrate + qtyrate;  //Total quantity* qty
        }

        var grandtotal = countqtyrate;  //grand total
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vatamount = (grandtotal - discount) * vatassign;
        $("#vatspan").text(vatamount);
        $("#vat").val(vatamount);
        var vat = parseFloat($("#vat").val());
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount + vat + parseFloat(previous_amount);

        var grandtotal = Math.ceil(grandtotal * 2) / 2;
        var net_amout = Math.ceil(net_amout * 2) / 2;

        document.getElementById("total_amout").innerHTML = grandtotal;
        $(".total_amout").val(grandtotal);

        document.getElementById("grandtotal").innerHTML = grandtotal;
        $(".grandtotal").val(grandtotal);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);
        $("#paidamount").val(net_amout);


        $("#product_name").val("");
        $("#product").val("");
        $("#qtyi").val("");
        $("#unit").val("");
        $("#unitshow").val("");
        $("#ratei").val("");
        $("#sale_ratei").val("");
    });



    //show unit id,qty,rate
    $("#product").each(function () {
        var product_id = $(this).val();
        if (product_id > 0) {
            var dataString = "product_id=" + product_id;
            //for unit id
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/sales/unit_name'); ?>",
                data: dataString,
                success: function (data) {
                    var res = data.split(",");
                    $("#unitshow").val(res[1]);
                    $("#unit").val(res[0]);
                }
            });
            //for rate
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/sales/product_salerate'); ?>",
                data: dataString,
                success: function (data) {
                    $("#ratei").val(data);
                }
            });
            //for rate
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/sales/product_qty'); ?>",
                data: dataString,
                success: function (data) {
                    var range = data;

                    if (range == "") {
                        range = 0;
                    }
                    $("#qtymsg").text("Available qty is " + range);
                    $("#qtymsg").css('color', 'green');
                    $("#qtyi").change(function () {
                        var qtyval = parseFloat($("#qtyi").val());
                        if (qtyval > range) {
                            $("#qtyi").css('border-color', 'red');
                            $("#qtymsg").text("Limit exceeds!");
                            $("#qtymsg").css('color', 'red');
                        } else {
                            $("#qtyi").css('border-color', '#898990');
                            $("#qtymsg").text("Available qty is " + range);
                            $("#qtymsg").css('color', 'green');
                        }
                    });
                }
            });
        }
    });

    //=====================When click on credit===================



    //Check Invoice Number
    var ordernoprev = $("#order_no").val();
    $("#order_no").change(function () {
        var order_no = $(this).val();
        var companyid = $("#company_id").val();
        var dataString = "order_no=" + order_no + "&companyid=" + companyid;

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/checkorderno'); ?>",
            data: dataString,
            success: function (data) {
                if (data == "found") {
                    $("#order_no").css('border-color', 'red');
                    $("#servermsg").text("Order No is already exist!");
                    $("#servermsg").css('color', 'red');
                }
                if (data == "notfound") {
                    $("#order_no").css('border-color', '#898990');
                    $("#servermsg").text("Order No is Available!");
                    $("#servermsg").css('color', 'green');

                }
                if (order_no == ordernoprev) {
                    $("#order_no").css('border-color', '#898990');
                    $("#servermsg").text("Order No is Available!");
                    $("#servermsg").css('color', 'green');

                }
            }
        });
    });


    var discountval = "<?php echo $discountsett; ?>";
    $("#addpurchase_submit").click(function () {
        var msg = $("#servermsg").text();
        var total_amout = $("#total_amout").text();
        var total_amout_chk = (parseInt(total_amout) * discountval) / 100;
        var discount_chk = parseInt($("#discount").val());
        if (msg == "Order No is already exist!") {
            return false;
        } else if (total_amout_chk < discount_chk) {
            $("#discountlimit").text("discount limit exceeds");
            $("#discountlimit").css("color", "red");
            return false;
        } else {
            $("#discountlimit").text("");
            return true;
        }

    });


    //Date time picker
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    $('#datetimepicker').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: '2014-12-01',
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });




    //For edit payment voucher
    //For edit payment voucher
    $(document).ready(function () {
        window.onload = function () {
            $('#paymentMode').empty();
            var value = "By Cash";
            var dataString = 'value=' + value;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('paymentvoucher/paymentvoucher/getledger'); ?>",
                data: dataString,
                cache: false,
                success: function (data) {
                    $('#paymentMode').append(data).selectpicker('refresh');
                }
            });
        };
        $('.radiobutton').click(function () {
            $('#editpaymentMode').empty();
            $('#currentbalance').val("");
            var value = $(this).val();
            if (value === "By Cheque") {
                $('#editpaymentMode').prop('disabled', false);
                var dataString = 'value=' + value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('paymentvoucher/paymentvoucher/getledger'); ?>",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        console.log("if-ByCash" + data);
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
                    success: function (data) {
                        console.log("else-ByCash" + data);
                        $('#editpaymentMode').append(data).selectpicker('refresh');
                    }
                });
            }
        });

    });


    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    var current_date = "<?php echo date('Y-m-d H:i:s'); ?>";
    $('#chequeDate').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: current_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: true
    });

     var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var today_date = "<?php echo date("d-m-Y"); ?>";   
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    $('#dailysearchfromsell').datetimepicker({
        format: 'd-m-Y H:i:s',
        dayOfWeekStart: 1,
        lang: 'en',
        disabledDates: ['1986-01-08', '1986-01-09', '1986-01-10'],
        startDate: today_date,
        minDate: start_date,
        maxDate: end_date,
        timepicker: false
    });

</script>