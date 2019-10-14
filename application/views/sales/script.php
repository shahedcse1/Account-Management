<script>
    var vatassign = 0;  // assign vat 5% for now

    /* //To stop form action by pressing enter key
     $("form").keypress(function (e) {
     //Enter key
     if (e.which == 13) {
     return false;
     }
     }); */

    //customer name check
    function customerNameCheck() {
        var customer_name = $("#customer_name1").val();
        var dataString = "suppname=" + customer_name;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/customerNameCheck'); ?>",
            data: dataString,
            success: function(data) {
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
    $('#submitaddcustomer').click(function() {
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
                success: function(data) {
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
    $("#corparty_account").change(function() {
        var value = $("#corparty_account").val();
        if (value == "3newone") {
            $('#myModalnews').modal();
        }
    });

    //when put value
    /* $("#product_name").change(function () {
     $("#product_name").css('border-color', '#898990');
     }); */

    $("#qty").change(function() {
        $("#qty").css('border-color', '#898990');
    });
    $("#rate").change(function() {
        $("#rate").css('border-color', '#898990');
    });




    //click on reset for products
    $("#product-reset").click(function() {
        $("#product_name").val("");
        $("#qty").val("");
        $("#unit").val("");
        $("#unitshow").val("");
        $("#rate").val("");
    });

    //data append into table from session
    var count = 0;
    var countqtyrate = 0;
    var totalqty = 0;
    var visibleProductCount = 0;
    $("#addpurchase").click(function() {

        var product_name = $("#product_name").val();
        var qty = $("#qty").val();
        var unit = $("#unit").val();
        var rate = $("#rate").val();
        var qtymsg = $("#qtymsg").text();

        if (qtymsg == "Limit exceeds!") {   //Allow Sales if Stock is zero or less than zero!
            return false;
        }
        if (product_name == "") {
            $("#product_name").css('border-color', 'red');
            return false;
        }
        if (qty == "") {
            $("#qty").css('border-color', 'red');
            return false;
        }
        if (rate == "") {
            $("#rate").css('border-color', 'red');
            return false;
        }

        count = count + 1;
        visibleProductCount++;

        //This section for printing purpose
        var ledgerid = $("#acshaccount option:selected").val();
        var datastringbasic = 'ledgerid=' + ledgerid;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/accountBasicInfo'); ?>",
            data: datastringbasic,
            success: function(responseData) {
                var dataarr = JSON.parse(responseData);
                $("#accountno1").text(dataarr.accountno);
                $("#accountaddress1").text(dataarr.address);
                $("#accountno2").text(dataarr.accountno);
                $("#accountaddress2").text(dataarr.address);
                var totalprevAmount = dataarr.totalprevAmount;
                $("#totalprevAmount").val(totalprevAmount);
                $("#totalprevAmount2").val(totalprevAmount);
                $("#totalprevAmount3").val(totalprevAmount);
            }
        });
        //--------------------------------//


        var salesedit = "<?php echo $salesedit; ?>";
        var dataString = "count=" + count + "&product_name=" + product_name + "&qty=" + qty + "&unit=" + unit + "&rate=" + rate + "&salesedit=" + salesedit;

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/add_view_table'); ?>",
            data: dataString,
            success: function(data) {
                var outputdata = JSON.parse(data);
                var rowdata = outputdata.rowdata;
                var printdataoffice = outputdata.printdataoffice;
                var printdatacustomer = outputdata.printdatacustomer;
                $("#addnewrow").append(rowdata);
                $("#addprintrowoffice").append(printdataoffice);
                $("#addprintrowoffice2").append(printdataoffice);
                $("#addprintrowoffice3").append(printdataoffice);
                $("#addprintrowcustomer").append(printdatacustomer);

                //3rd part
                var qty2 = parseFloat($("#qty" + count).val());
                var rate2 = parseFloat($("#rate" + count).val());
                totalqty += qty2;

                var qtyrate = qty2 * rate2;
                var previoustotal = $(".total_amout").val();
                countqtyrate = parseFloat(previoustotal);
                countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate

                var grandtotal = parseFloat(countqtyrate);  //total amount
                var discount = $("#discount").val();
                var transport = parseFloat($("#transport").val());

                var vatamount = (grandtotal - discount) * vatassign;
                $("#vatspan").text(vatamount);
                $("#vat").val(vatamount);
                var previous_amount = $(".previous_amount").val();
                var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount + vatamount + parseFloat(previous_amount);

                var grandtotal = Math.ceil(grandtotal * 2) / 2;
                var net_amout = Math.ceil(net_amout * 2) / 2;

                document.getElementById("total_amout").innerHTML = grandtotal;
                $(".total_amout").val(grandtotal);

                document.getElementById("grandtotal").innerHTML = grandtotal;
                $(".grandtotal").val(grandtotal);

                document.getElementById("net_amout").innerHTML = net_amout;
                $(".net_amout").val(net_amout);

                //On Bill To Cash Account Selected then set cash value
                // var billto = $("#acshaccount option:selected").val();
                //  if (billto == 2) {
                $('#paymentMode').empty();
                $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
                var csPay = "<?php echo $csPay ?>";
                if (csPay == "1") {
                    $("#paidamount").val("0.00");
                } else {
                    $("#paidamount").val(net_amout);
                }
                $("#change_amount").text("0.00");
                $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);
                //}

                //For print
                grandtotal = parseFloat(grandtotal).toFixed(2);
                $("#netvalues1").text(grandtotal);
                $("#netvalues2").text(grandtotal);
                $("#netvalues3").text(grandtotal);
                grandtotal = parseFloat(grandtotal).toFixed(2);


                $("#invoiceamount1").text(grandtotal);
                $("#invoiceamount2").text(grandtotal);
                $("#invoiceamount3").text(grandtotal);

                $("#viewtotalamount").text(grandtotal);
                $("#viewtotalqty").text(totalqty);
                $("#totalqty1").text(totalqty);
                $("#totalqty2").text(totalqty);
                $("#totalqty3").text(totalqty);


                //2nd part click for edit data from table view
                $(".edit-field").click(function() {
                    $(this).find("span").hide();
                    $(this).find("input").prop("type", "text");

                });
                //edit table for product
                $(".edit_input").change(function() {
                    var value = $(this).val();
                    $(this).siblings("span").show();
                    $(this).siblings("span").text(value);
                    $(this).prop("type", "hidden");

                    //3rd part
                    var k = 1;
                    countqtyrate = 0;
                    totalqty = 0;
                    for (k; k <= count; k++) {
                        var qty3 = parseFloat($("#qty" + k).val());
                        var rate3 = parseFloat($("#rate" + k).val());
                        if (isNaN(qty3) || isNaN(rate3)) {
                            var qtyrate = 0;
                        } else {
                            var qtyrate = qty3 * rate3;
                            totalqty += qty3;
                        }
                        //Net amount per product
                        var grandtotal = qtyrate;  //total amount

                        $("#product_amount" + k).text(grandtotal);

                        $("#product_amountoffice" + k).text(grandtotal);
                        $("#product_amountcustomer" + k).text(grandtotal);
                        $("#qtyofc" + k).text(qty3);
                        $("#qtycustomer" + k).text(qty3);
                        $("#rateofc" + k).text(rate3);
                        $("#ratecustomer" + k).text(rate3);

                        countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate

                    }

                    grandtotal = parseFloat(countqtyrate);  //total amount
                    var discount = $("#discount").val();
                    var transport = parseFloat($("#transport").val());
                    var vatamount = (grandtotal - discount) * vatassign;
                    $("#vatspan").text(vatamount);
                    $("#vat").val(vatamount);
                    var previous_amount = $(".previous_amount").val();
                    var net_amout = parseFloat(grandtotal) + parseFloat(transport) - parseFloat(discount) + vatamount + parseFloat(previous_amount);


                    var grandtotal = Math.ceil(grandtotal * 2) / 2;
                    var net_amout = Math.ceil(net_amout * 2) / 2;

                    document.getElementById("total_amout").innerHTML = grandtotal;
                    $(".total_amout").val(grandtotal);
                    $("#viewtotalamount").text(grandtotal);
                    $("#viewtotalqty").text(totalqty);
                    $("#totalqty1").text(totalqty);
                    $("#totalqty2").text(totalqty);
                    $("#totalqty3").text(totalqty);

                    document.getElementById("grandtotal").innerHTML = grandtotal;
                    $(".grandtotal").val(grandtotal);

                    document.getElementById("net_amout").innerHTML = net_amout;
                    $(".net_amout").val(net_amout);

                    //On Bill To Cash Account Selected then set cash value
                    //var billto = $("#acshaccount option:selected").val();
                    //if (billto == 2) {
                    $('#paymentMode').empty();
                    $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
                    var csPay = "<?php echo $csPay ?>";
                    if (csPay == "1") {
                        $("#paidamount").val("0.00");
                    } else {
                        $("#paidamount").val(net_amout);
                    }
                    $("#change_amount").text("0.00");
                    $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);
                    //}

                    return false;
                });

                //count_product
                $(".count_product").val(count);
            }
        });

        //clear value fields
        var product = $("#product_name option:selected").val();
        if (product == product_name) {
            $("#product_name option:selected").hide();
        }
        //$("#product_name").val("");
        $("#qty").val('');
        //$("#unit").val("");
        //$("#unitshow").val("");
        $("#rate").val('');
    });

    /**
     * Product Selection with Barcode
     */
    $('#product_name_barcode').change(function(){
        var prodid = $(this).val(),
            quantity = 1,
            chkreadonly = '';

        var salesedit = "<?= $salesedit; ?>";

        if (salesedit == '0') {
            chkreadonly = 'readonly';
        } else {
            chkreadonly = '';
        }

        count++;
        visibleProductCount++;

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?= site_url('sales/sales/getprodinfo'); ?>",
            data: {
                prodid : prodid
            },
            success: function(data) {
                var amount = parseFloat(data.prod.salesRate) * parseFloat(quantity);

                var rowdata = '<tr id="row'+ count +'">' +
                    '<td><a onclick="deleteRowData('+ count +')" href="#"><i class="fa fa-times-circle delete-icon"></i></a></td>' +
                    '<td><span>'+ data.prod.productName +'</span><input name="product_name'+ count +'" id="product_name'+ count +'" type="hidden" value="'+ prodid +'"/></td>' +
                    '<td id="click" class="edit-field" title="Click for Edit"><span>'+ quantity +'</span><input name="qty'+ count +'" class="edit_input TabOnEnter" id="qty'+ count +'" type="hidden" value="'+ quantity +'" /></td>' +
                    '<td><span>'+ data.prod.unitName +'</span><input name="unit'+ count +'" id="unit'+ count +'" type="hidden" value="'+ data.prod.unitId +'"/></td>' +
                    '<td class="edit-field" title="Click for Edit"><span>'+ data.prod.salesRate +'</span><input name="rate'+ count +'" id="rate'+ count +'" type="hidden" '+ chkreadonly +'  class="edit_input TabOnEnter" value="'+ data.prod.salesRate +'"/></td>' +
                    '<td><span id="product_amount'+ count +'">'+ amount.toFixed(2) +'</span></td>' +
                    '</tr>';

                var printdataoffice = '<tr id="rowoffice'+ count +'">' +
                    '<td><span>'+ data.prod.productName +'</span><input name="product_name'+ count +'" id="product_name'+ count +'" type="hidden" value="'+ prodid +'"/></td>' +
                    '<td style="text-align: center" id="click" class="edit-field" title="Click for Edit"><span id="qtyofc'+ count +'">'+ quantity +'</span><input name="qty'+ count +'" class="edit_input TabOnEnter" id="qtyoffice'+ count +'" type="hidden" value="'+ quantity +'" /></td>' +
                    '<td style="text-align: right" class="edit-field" title="Click for Edit"><span>'+ data.prod.salesRate +'</span><input name="rate'+ count +'" id="rate'+ count +'" type="hidden" '+ chkreadonly +'  class="edit_input TabOnEnter" value="'+ data.prod.salesRate +'"/></td>' +
                    '<td style="text-align: right"><span id="product_amountoffice'+ count +'">'+ amount.toFixed(2) +'</span></td>' +
                    '</tr>';

                var printdatacustomer = '<tr id="rowcustomer'+ count +'">' +
                    '<td><span>'+ data.prod.productName +'</span><input name="product_name'+ count +'" id="product_name'+ count +'" type="hidden" value="'+ prodid +'"/></td>' +
                    '<td style="text-align: center" id="click" class="edit-field" title="Click for Edit"><span id="qtycustomer'+ count +'">'+ quantity +'</span><input name="qty'+ count +'" class="edit_input TabOnEnter" id="qty'+ count +'" type="hidden" value="'+ quantity +'" /></td>' +
                    '<td><span>'+ data.prod.unitName +'</span><input name="unit'+ count +'" id="unit'+ count +'" type="hidden" value="'+ data.prod.unitId +'"/></td>' +
                    '<td class="edit-field" title="Click for Edit"><span id="ratecustomer'+ count +'">'+ data.prod.salesRate +'</span><input name="rate'+ count +'" id="rate'+ count +'" type="hidden" '+ chkreadonly +'  class="edit_input TabOnEnter" value="'+ data.prod.salesRate +'"/></td>' +
                    '<td><span id="product_amountcustomer'+ count +'">'+ amount.toFixed(2) +'</span></td>' +
                    '</tr>';

                $("#addnewrow").append(rowdata);
                $("#addprintrowoffice").append(printdataoffice);
                $("#addprintrowoffice2").append(printdataoffice);
                $("#addprintrowoffice3").append(printdataoffice);
                $("#addprintrowcustomer").append(printdatacustomer);

                var qty2 = parseFloat($("#qty" + count).val());
                var rate2 = parseFloat($("#rate" + count).val());
                totalqty += qty2;

                var qtyrate = qty2 * rate2;
                var previoustotal = $(".total_amout").val();
                countqtyrate = parseFloat(previoustotal);
                countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate

                var grandtotal = parseFloat(countqtyrate);  //total amount
                var discount = $("#discount").val();
                var transport = parseFloat($("#transport").val());

                var vatamount = (grandtotal - discount) * vatassign;
                $("#vatspan").text(vatamount);
                $("#vat").val(vatamount);
                var previous_amount = $(".previous_amount").val();
                var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount + vatamount + parseFloat(previous_amount);

                var grandtotal = Math.ceil(grandtotal * 2) / 2;
                var net_amout = Math.ceil(net_amout * 2) / 2;

                document.getElementById("total_amout").innerHTML = grandtotal;
                $(".total_amout").val(grandtotal);

                document.getElementById("grandtotal").innerHTML = grandtotal;
                $(".grandtotal").val(grandtotal);

                document.getElementById("net_amout").innerHTML = net_amout;
                $(".net_amout").val(net_amout);

                $('#paymentMode').empty();
                $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
                var csPay = "<?= $csPay ?>";
                if (csPay == "1") {
                    $("#paidamount").val("0.00");
                } else {
                    $("#paidamount").val(net_amout);
                }
                $("#change_amount").text("0.00");
                $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);

                /**
                 * For print
                 */
                grandtotal = parseFloat(grandtotal).toFixed(2);
                $("#netvalues1").text(grandtotal);
                $("#netvalues2").text(grandtotal);
                $("#netvalues3").text(grandtotal);
                grandtotal = parseFloat(grandtotal).toFixed(2);


                $("#invoiceamount1").text(grandtotal);
                $("#invoiceamount2").text(grandtotal);
                $("#invoiceamount3").text(grandtotal);

                $("#viewtotalamount").text(grandtotal);
                $("#viewtotalqty").text(totalqty);
                $("#totalqty1").text(totalqty);
                $("#totalqty2").text(totalqty);
                $("#totalqty3").text(totalqty);


                //2nd part click for edit data from table view
                $(".edit-field").click(function() {
                    $(this).find("span").hide();
                    $(this).find("input").prop("type", "text");

                });
                //edit table for product
                $(".edit_input").change(function() {
                    var value = $(this).val();
                    $(this).siblings("span").show();
                    $(this).siblings("span").text(value);
                    $(this).prop("type", "hidden");

                    //3rd part
                    var k = 1;
                    countqtyrate = 0;
                    totalqty = 0;
                    for (k; k <= count; k++) {
                        var qty3 = parseFloat($("#qty" + k).val());
                        var rate3 = parseFloat($("#rate" + k).val());
                        if (isNaN(qty3) || isNaN(rate3)) {
                            var qtyrate = 0;
                        } else {
                            var qtyrate = qty3 * rate3;
                            totalqty += qty3;
                        }
                        //Net amount per product
                        var grandtotal = qtyrate;  //total amount

                        $("#product_amount" + k).text(grandtotal);

                        $("#product_amountoffice" + k).text(grandtotal);
                        $("#product_amountcustomer" + k).text(grandtotal);
                        $("#qtyofc" + k).text(qty3);
                        $("#qtycustomer" + k).text(qty3);
                        $("#rateofc" + k).text(rate3);
                        $("#ratecustomer" + k).text(rate3);

                        countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate

                    }

                    grandtotal = parseFloat(countqtyrate);  //total amount
                    var discount = $("#discount").val();
                    var transport = parseFloat($("#transport").val());
                    var vatamount = (grandtotal - discount) * vatassign;
                    $("#vatspan").text(vatamount);
                    $("#vat").val(vatamount);
                    var previous_amount = $(".previous_amount").val();
                    var net_amout = parseFloat(grandtotal) + parseFloat(transport) - parseFloat(discount) + vatamount + parseFloat(previous_amount);


                    var grandtotal = Math.ceil(grandtotal * 2) / 2;
                    var net_amout = Math.ceil(net_amout * 2) / 2;

                    document.getElementById("total_amout").innerHTML = grandtotal;
                    $(".total_amout").val(grandtotal);
                    $("#viewtotalamount").text(grandtotal);
                    $("#viewtotalqty").text(totalqty);
                    $("#totalqty1").text(totalqty);
                    $("#totalqty2").text(totalqty);
                    $("#totalqty3").text(totalqty);

                    document.getElementById("grandtotal").innerHTML = grandtotal;
                    $(".grandtotal").val(grandtotal);

                    document.getElementById("net_amout").innerHTML = net_amout;
                    $(".net_amout").val(net_amout);

                    $('#paymentMode').empty();
                    $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
                    var csPay = "<?php echo $csPay ?>";
                    if (csPay == "1") {
                        $("#paidamount").val("0.00");
                    } else {
                        $("#paidamount").val(net_amout);
                    }
                    $("#change_amount").text("0.00");
                    $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);

                    return false;
                });

                //count_product
                $(".count_product").val(count);

                $('#product_name_barcode').val('');
            }
        });
    });


    function deleteRowData(rownumber) {
        var idvaldata = "row" + rownumber;
        var idvaldataoffice = "rowoffice" + rownumber;
        var idvaldatacustomer = "rowcustomer" + rownumber;


        //3rd part
        var qty2 = parseFloat($("#qty" + rownumber).val());
        var rate2 = parseFloat($("#rate" + rownumber).val());
        totalqty = totalqty - qty2;

        var previoustotal = $(".total_amout").val();
        //console.log("previoustotal" + previoustotal + "qty2" + qty2 + "rate2" + rate2);

        var qtyrate = qty2 * rate2;
        var countqtyrate = parseFloat(previoustotal) - qtyrate;  //Total quantity * rate

        var grandtotal = parseFloat(countqtyrate);  //total amount
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vatamount = (grandtotal - discount) * vatassign;
        $("#vatspan").text(vatamount);
        $("#vat").val(vatamount);
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - parseFloat(discount) + vatamount + parseFloat(previous_amount);

        var grandtotal = Math.ceil(grandtotal * 2) / 2;
        var net_amout = Math.ceil(net_amout * 2) / 2;

        document.getElementById("total_amout").innerHTML = grandtotal;
        $(".total_amout").val(grandtotal);

        document.getElementById("grandtotal").innerHTML = grandtotal;
        $(".grandtotal").val(grandtotal);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);

        //On Bill To Cash Account Selected then set cash value
        //var billto = $("#acshaccount option:selected").val();
        //if (billto == 2) {
        $('#paymentMode').empty();
        $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
        var csPay = "<?php echo $csPay ?>";
        if (csPay == "1") {
            $("#paidamount").val("0.00");
        } else {
            $("#paidamount").val(net_amout);
        }
        $("#change_amount").text("0.00");
        $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);
        //}

        //For print
        grandtotal = parseFloat(grandtotal).toFixed(2);
        $("#netvalues1").text(grandtotal);
        $("#netvalues2").text(grandtotal);
        $("#netvalues3").text(grandtotal);
        grandtotal = parseFloat(grandtotal).toFixed(2);


        $("#invoiceamount1").text(grandtotal);
        $("#invoiceamount2").text(grandtotal);
        $("#invoiceamount3").text(grandtotal);
        // $("#invoiceamount2").text(grandtotaltext);

        $("#viewtotalamount").text(grandtotal);
        $("#viewtotalqty").text(totalqty);
        $("#totalqty1").text(totalqty);
        $("#totalqty2").text(totalqty);
        $("#totalqty3").text(totalqty);

        document.getElementById(idvaldata).remove();
        document.getElementById(idvaldataoffice).remove();
        document.getElementById(idvaldatacustomer).remove();
        visibleProductCount--;
    }



    //3rd part for discount
    $("#discount").change(function() {
        var grandtotal = $(".grandtotal").val();
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vatamount = (grandtotal - discount) * vatassign;
        $("#vatspan").text(vatamount);
        $("#vat").val(vatamount);
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - parseFloat(discount) + vatamount + parseFloat(previous_amount);
        net_amout = parseFloat(net_amout).toFixed(2);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);

        //On Bill To Cash Account Selected then set cash value
        //var billto = $("#acshaccount option:selected").val();
        //if (billto == 2) {
        $('#paymentMode').empty();
        $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
        var csPay = "<?php echo $csPay ?>";
        if (csPay == "1") {
            $("#paidamount").val("0.00");
        } else {
            $("#paidamount").val(net_amout);
        }
        $("#change_amount").text("0.00");
        $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);
        //}       
    });

    $("#discountpercantage").change(function() {
        var grandtotal = $(".grandtotal").val();
        var discountper = $("#discountpercantage").val();
        var discountamount = ((discountper * grandtotal) / 100);
        $("#discount").val(discountamount);
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vatamount = (grandtotal - discount) * vatassign;
        $("#vatspan").text(vatamount);
        $("#vat").val(vatamount);
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - parseFloat(discount) + vatamount + parseFloat(previous_amount);
        net_amout = parseFloat(net_amout).toFixed(2);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);

        //On Bill To Cash Account Selected then set cash value
        //var billto = $("#acshaccount option:selected").val();
        //if (billto == 2) {
        $('#paymentMode').empty();
        $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
        var csPay = "<?php echo $csPay ?>";
        if (csPay == "1") {
            $("#paidamount").val("0.00");
        } else {
            $("#paidamount").val(net_amout);
        }
        $("#change_amount").text("0.00");
        $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);
        //}       
    });


    $("#vatpercantage").change(function() {
        var net_amount = $(".net_amout").val();
        var vatper = $("#vatpercantage").val();
        var vatamount = ((vatper * net_amount) / 100);
        $("#vat").val(vatamount);

        var grandtotal = $(".grandtotal").val();
        var discount = $("#discount").val();
        var vat = $("#vat").val();
        var transport = parseFloat($("#transport").val());
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - parseFloat(discount) + vatamount + parseFloat(previous_amount);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);

        $('#paymentMode').empty();
        $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
        $("#paidamount").val(net_amout);
        $("#change_amount").text("0.00");
        $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);
    });



    $("#transport").change(function() {
        var grandtotal = $(".grandtotal").val();
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var vatamount = (grandtotal - discount) * vatassign;
        $("#vatspan").text(vatamount);
        $("#vat").val(vatamount);
        var previous_amount = $(".previous_amount").val();
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - parseFloat(discount) + vatamount + parseFloat(previous_amount);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);

        //On Bill To Cash Account Selected then set cash value
        //var billto = $("#acshaccount option:selected").val();
        //if (billto == 2) {
        $('#paymentMode').empty();
        $('#paymentMode').append('<option value="2,11" selected>0 - Cash Account</option>').selectpicker('refresh');
        $("#paidamount").val(net_amout);
        $("#change_amount").text("0.00");
        $('input[name="optionsRadios"][value="By Cash"]').prop('checked', true);
        //}
    });

    //show unit id and rate
    $("#product_name").change(function() {
        var product_id = $(this).val();
        //alert(product_id);
        var dataString = "product_id=" + product_id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/product_description'); ?>",
            data: dataString,
            success: function(data) {
                if (data == "") {
                    $("#show_product_description").text("No Description Available!");
                } else {
                    $("#show_product_description").text(data);
                }

            }
        });

        $("#paidamount").on('input propertychange paste', function() {
            var net_amount = $(".net_amout").val();
            var paid_amount = $("#paidamount").val();
            var change_amount = parseFloat(paid_amount) - parseFloat(net_amount);
            change_amount = parseFloat(change_amount).toFixed(2);
            $("#change_amount").text(change_amount);
        });

        //for unit
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/unit_name'); ?>",
            data: dataString,
            success: function(data) {
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
            success: function(data) {
                $("#rate").val(data);
            }
        });
        //for rate
        var allowstock = "<?php echo $allowstock; ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/product_qty'); ?>",
            data: dataString,
            success: function(data) {
                var range = data;
                if (range == "") {
                    range = 0;
                }
                $("#qtymsg").text("Available qty is " + range);
                $("#qtymsg").css('color', 'green');

                $("#qty").change(function() {
                    var qtyval = parseFloat($("#qty").val());
                    if (qtyval > range) {      //Allow Sales if Stock is zero or less than zero!
                        if (allowstock == "1") {
                            $("#qty").css('border-color', '#898990');
                            $("#qtymsg").text("Available qty is " + range);
                            $("#qtymsg").css('color', 'green');
                        } else {
                            $("#qty").css('border-color', 'red');
                            $("#qtymsg").text("Limit exceeds!");
                            $("#qtymsg").css('color', 'red');
                        }
                    } else {
                        $("#qty").css('border-color', '#898990');
                        $("#qtymsg").text("Available qty is " + range);
                        $("#qtymsg").css('color', 'green');
                    }
                });
            }
        });


        // end for rate
    });
    //Check Invoice Number
    $("#order_no").change(function() {
        var order_no = $(this).val();
        var companyid = $("#company_id").val();
        var dataString = "order_no=" + order_no + "&companyid=" + companyid;

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/sales/checkorderno'); ?>",
            data: dataString,
            success: function(data) {
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
            }
        });
    });

    $("#addpurchase_submit").click(function() {
        var msg = $("#servermsg").text();
        if (msg == "Order No is already exist!") {
            return false;
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
</script>
<?php
if ((isset($data_added)) && ($data_added == "added")) {
    ?>
    <script>
        $(document).ready(function() {
            //show gritter after add data
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Successfull!',
                // (string | mandatory) the text inside the notification
                text: 'Data Added Successfully',
                // (string | optional) the image to display on the left
                // image: 'img/avatar-mini.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: '5000'
            });
        });
    </script>
    <?php
}
?>


<?php
if ((isset($data_added)) && ($data_added == "adderror")) {
    ?>
    <script>
        $(document).ready(function() {
            //show gritter after add data
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Fail',
                // (string | mandatory) the text inside the notification
                text: 'Data Added Error. Check Your Data.',
                // (string | optional) the image to display on the left
                // image: 'img/avatar-mini.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: '5000'
            });
        });
    </script>
    <?php
}
?>   


<?php
if ((isset($data_added)) && ($data_added == "edited")) {
    ?>
    <script>
        $(document).ready(function() {
            //show gritter after add data
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Successfull!',
                // (string | mandatory) the text inside the notification
                text: 'Data Edited Successfully',
                // (string | optional) the image to display on the left
                // image: 'img/avatar-mini.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: '5000'
            });
        });
    </script>
    <?php
}
?>

<?php
if ((isset($data_added)) && ($data_added == "deleted")) {
    ?>
    <script>
        $(document).ready(function() {
            //show gritter after add data
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Successfull!',
                // (string | mandatory) the text inside the notification
                text: 'Data Deleted Successfully',
                // (string | optional) the image to display on the left
                // image: 'img/avatar-mini.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: '5000'
            });
        });
    </script>
    <?php
}
?>


<?php
if ((isset($data_added)) && ($data_added == "notdeleted")) {
    ?>
    <script>
        $(document).ready(function() {
            //show gritter after add data
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Failed Deleted!',
                // (string | mandatory) the text inside the notification
                text: 'Data is not Deleted',
                // (string | optional) the image to display on the left
                // image: 'img/avatar-mini.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: '5000'
            });
        });
    </script>
    <?php
}
?>


<?php
if ((isset($data_added)) && ($data_added == "add_unit")) {
    ?>
    <script>
        $(document).ready(function() {
            //show gritter after add data
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Successfull!',
                // (string | mandatory) the text inside the notification
                text: 'New Unit created  Successfully',
                // (string | optional) the image to display on the left
                // image: 'img/avatar-mini.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: '5000'
            });
        });
    </script>
    <?php
}
?>



<!-- For sales payment -->   

<script type="text/javascript">
    $(document).ready(function() {
        window.onload = function() {
            $('#paymentMode').empty();
            var value = "By Cash";
            var dataString = 'value=' + value;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('receiptvoucher/receiptvoucher/getledger'); ?>",
                data: dataString,
                cache: false,
                success: function(data) {
                    $('#paymentMode').append(data).selectpicker('refresh');
                }
            });
            //$('#chequeNumber').prop('readonly', true);
            // $('#chequeDate').prop('readonly', true);
        };
        $('.radiobutton').click(function() {
            $('#paymentMode').empty();
            $('#currentbalance').val(" ");
            var value = $(this).val();
            if (value === "By Cheque") {
                // $('#chequeNumber').prop('readonly', false);
                //$('#chequeDate').prop('readonly', false);
                $('#paymentMode').prop('disabled', false);
                var dataString = 'value=' + value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('receiptvoucher/receiptvoucher/getledger'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(data) {
                        $('#paymentMode').append(data).selectpicker('refresh');
                    }
                });
            }
            else {
                $('#paymentMode').empty();
                var dataString = 'value=' + value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('receiptvoucher/receiptvoucher/getledger'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(data) {
                        $('#paymentMode').append(data).selectpicker('refresh');
                    }
                });
                //$('#chequeNumber').prop('readonly', true);
                //$('#chequeDate').prop('readonly', true);
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






