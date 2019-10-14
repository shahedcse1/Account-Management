<script>
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
    $('#submitaddcustomer').click(function (){
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
    $("#corparty_account").change(function(){
        var value=$("#corparty_account").val();
        if(value=="3newone"){
            $('#myModalnews').modal();
        }
    });

    //==============================for edit page=========================

    //when click on purchase rate only
    $("#ratepurchase").change(function (){
        var kg3=parseFloat($("#kg").val());
        var ratepurchase3=parseFloat($(this).val());
      //  alert("u");
        var qtyratepurchase3=kg3 * ratepurchase3;
        //Net amount per product
        $("#amountpurchase").val(qtyratepurchase3); //Input field

    });

    //click on reset for products
    $("#product-reset").click(function(){
        $("#corparty_accounti").val("");
        $("#kgi").val("");
        $("#qtyi").val("");
        $("#ratei").val("");
    });

    //when click on rows
    $(".single_row").click(function(){
        var no=$(this).attr("id");
        var ledgerid=$("#ledgerid").val();
        var qty=$("#qty").val();
        var unit_id=$("#kg").val();
        var rate=$("#rate").val();

        //paste values
        $("#corparty_accounti").val(ledgerid);
        $("#qtyi").val(qty);
        $("#kgi").val(unit_id);
        $("#ratei").val(rate);
        $("#count").val(no);

        //when click on edit
        $("#addpurchase").click(function(){
            var corparty_account_name=$("#corparty_accounti").val();
            var qtyi=$("#qtyi").val();
            var unit=$("#kgi").val();
            var ratei=$("#ratei").val();
            var count=$("#count").val();
            var ratepurchase = $("#ratepurchase").val();

            if(ratepurchase==""){
                $("#ratepurchase").css('border-color', 'red');
                return false;
            }else{
                $("#ratepurchase").css('border-color', '#898990');
            }
            if(corparty_account_name==""){
                $("#corparty_accounti").css('border-color', 'red');
                return false;
            }else{
                $("#corparty_accounti").css('border-color', '#898990');
            }
            if(qtyi==""){
                $("#qtyi").css('border-color', 'red');
                return false;
            }else{
                $("#qtyi").css('border-color', '#898990');
            }
            if(ratei==""){
                $("#ratei").css('border-color', 'red');
                return false;
            }else{
                $("#ratei").css('border-color', '#898990');
            }
            if(unit==""){
                $("#kgi").css('border-color', 'red');
                return false;
            }else{
                $("#kgi").css('border-color', '#898990');
            }

            $("#ledgerid").val(corparty_account_name);

            $("#qty").val(qtyi);
            $(".qty").text(qtyi);
            $("#kg").val(unit);
            $(".kg").text(unit);

            $("#rate").val(ratei);
            $(".rate").text(ratei);

            var dataString = "ledger_id=" + corparty_account_name;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('salesfarmer/salesfarmer/dataqueryedit'); ?>",
                data: dataString,
                success: function (data) {
                    $('.ledgerid').text(data);
                }
            });


            //3rd part calculation after click on edit
                //3rd part
                var kg2=parseFloat($("#kg").val());
                var rate2=parseFloat($("#rate").val());
                var ratepurchase2=parseFloat($("#ratepurchase").val());

                var qtyrate=kg2 * rate2;
                var qtyratepurchase=kg2 * ratepurchase2;
                //Net amount per product
                $("#product_amount").text(qtyrate); //Input field
                $("#amount").val(qtyrate); //Input field
                $("#amountpurchase").val(qtyratepurchase); //Input field



            $("#corparty_accounti").val("");
            $("#qtyi").val("");
            $("#kgi").val("");
            $("#ratei").val("");
        });
    });



    //Date time picker
    <?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    var start_date = "<?php echo $this->sessiondata['mindate']; ?>";
    var end_date = "<?php echo $this->sessiondata['maxdate']; ?>";
    $('#datetimepicker').datetimepicker({
        dayOfWeekStart : 1,
        lang:'en',
        disabledDates:['1986-01-08','1986-01-09','1986-01-10'],
        startDate:'2014-12-01',
        minDate:start_date,
        maxDate:end_date,
        timepicker:false
    });
</script>