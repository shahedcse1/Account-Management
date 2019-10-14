<script>
    //customer name check
    var count = 0;
    var countqtyrate = 0;
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

    function deleteRowData(rownumber) {

        var idvaldata = "row" + rownumber;

        var qty2 = parseInt($("#unit" + rownumber).val());
        var rate2 = parseInt($("#rate" + rownumber).val());
        var net_amout2 = $(".net_amout").val();
     


        var qtyrate = qty2 * rate2;

        //Total quantity * rate
        countqtyrate = countqtyrate - qtyrate;
//        count = count - 1;
        var grandtotal = qtyrate;  //total amount
        var net_amout = net_amout2 - grandtotal;


        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);

        document.getElementById(idvaldata).remove();
        //        

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

    //when put value
    $("#corparty_account").change(function () {
        $("#corparty_account").css('border-color', '#898990');
    });
    $("#qty").change(function () {
        $("#qty").css('border-color', '#898990');
    });
    $("#unit").change(function () {
        $("#unit").css('border-color', '#898990');
    });
    $("#rate").change(function () {
        $("#rate").css('border-color', '#898990');
    });

    //click on reset for products
    $("#product-reset").click(function () {
        $("#corparty_account").val("");
        $("#qty").val("");
        $("#unit").val("");
        $("#rate").val("");
    });

    //data append into table from session

    $("#addpurchase").click(function () {
        count = count + 1;
        var corparty_account = $("#corparty_account").val();
        var qty = $("#qty").val();
        var unit = $("#unit").val();
        var rate = $("#rate").val();
        var ratepurchase = $("#ratepurchase").val();
        var qtymsg = $("#qtymsg").text();

        if (qtymsg == "Limit exceeds!") {
            return false;
        }
        if (corparty_account == "") {
            $("#corparty_account").css('border-color', 'red');
            return false;
        }
        if (ratepurchase == "") {
            $("#ratepurchase").css('border-color', 'red');
            return false;
        }
        if (unit == "") {
            $("#unit").css('border-color', 'red');
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

        var dataString = "count=" + count + "&corparty_account=" + corparty_account + "&qty=" + qty + "&unit=" + unit + "&rate=" + rate + "&ratepurchase=" + ratepurchase;

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('salesfarmer/salesfarmer/add_view_table'); ?>",
            data: dataString,
            success: function (data) {
                $("#addnewrow").append(data);

                //3rd part
                var qty2 = parseInt($("#unit" + count).val());
                var rate2 = parseInt($("#rate" + count).val());
              
                var qtyrate = qty2 * rate2;
              
                countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate
             
                var grandtotal = countqtyrate;  //total amount
                var net_amout = grandtotal;
               

                document.getElementById("net_amout").innerHTML = net_amout;
                $(".net_amout").val(net_amout);



                //2nd part click for edit data from table view
                $(".edit-field").click(function () {
                    $(this).find("span").hide();
                    $(this).find("input").prop("type", "text");

                });
                //edit table for product
                $(".edit_input").change(function () {
                    var value = $(this).val();
                    $(this).siblings("span").show();
                    $(this).siblings("span").text(value);
                    $(this).prop("type", "hidden");

                    //3rd part
                    var k = 1;
                    countqtyrate = 0;
                    console.log("edit count "+count);
                    for (k; k <= count; k++) {
                        var qty3 = parseInt($("#unit" + k).val());
                          console.log("edit qty "+qty3);
                        var rate3 = parseInt($("#rate" + k).val());
                        var ratepurchase3 = parseInt($("#ratepurchase" + k).val());
                        
                         if (isNaN(qty3) || isNaN(rate3)) {
                            var qtyrate = 0;
                        } else {
                            var qtyrate = qty3 * rate3;
                        }
                        
                        var qtyratepurchase = qty3 * ratepurchase3;

                        //Net amount per product
                        var grandtotal = qtyrate;  //total amount

                        $("#product_amount" + k).text(grandtotal);
                        $("#amount" + k).val(grandtotal);
                        $("#amountpurchase" + k).val(qtyratepurchase);

                        countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate
                    }

                    grandtotal = countqtyrate;  //total amount
                    var net_amout = grandtotal;

                    document.getElementById("net_amout").innerHTML = net_amout;
                    $(".net_amout").val(net_amout);
                    return false;
                });

                //count_product
                $(".count_product").val(count);
            }
        });

        //clear value fields

        $("#corparty_account").val("");
        $("#qty").val("");
        $("#unit").val("");
        $("#rate").val("");
    });

//    //when click on purchase rate only
//    $("#ratepurchase").change(function (){
//        var kg3=parseFloat($("#kg").val());
//        var ratepurchase3=parseFloat($(this).val());
//        //  alert("u");
//        var qtyratepurchase3=kg3 * ratepurchase3;
//        //Net amount per product
//        $("#amountpurchase").val(qtyratepurchase3); //Input field
//
//    });


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
        $(document).ready(function () {
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
if ((isset($data_added)) && ($data_added == "edited")) {
    ?>
    <script>
        $(document).ready(function () {
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
        $(document).ready(function () {
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
        $(document).ready(function () {
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
        $(document).ready(function () {
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

