
<!-------------------------Add New------------------------------------->
<div class="modal fade" id="myModalnews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Add Supplier Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="cmxform form-horizontal tasi-form" id="supplier_add" method="post" action="">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="supplier_name" class="control-label col-lg-4">Supplier Name</label>

                                    <div class="col-lg-8">
                                        <input class=" form-control" id="supplier_name1" name="supplier_name"
                                               type="text" onchange="return supplierNameCheck()" value=""/>
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="address" class="control-label col-lg-4">Address</label>

                                    <div class="col-lg-8">
                                        <input class=" form-control" id="address1" name="address" type="text"/>
                                        <input  id="company_id1"  name="company_id" type="hidden" value="<?php echo $company_id; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="country" class="control-label col-lg-4">Country</label>

                                    <div class="col-lg-4">
                                        <select class=" form-control" id="country1" name="country">
                                            <?php
                                            if (isset($countries)) {
                                                foreach ($countries as $country) {
                                                    echo "<option value='" . $country->country_name . "'>$country->country_name</option>";
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="phone" class="control-label col-lg-4">Phone</label>

                                    <div class="col-lg-8">
                                        <input class="form-control " id="phone1" name="phone" type="text"/>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="mobile" class="control-label col-lg-4">Mobile</label>

                                    <div class="col-lg-8">
                                        <input class="form-control " id="mobile1" name="mobile" type="text"/>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="email" class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <input class="form-control " id="email1" name="email" type="email"/>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-4 ">Opening Balance</label>
                                    <div class="col-lg-5">
                                        <input class="form-control " type="text" id="opening_balance1"
                                               name="opening_balance"/>

                                    </div>
                                    <div class="col-lg-2 ">
                                        <select name="dr_cr" id="dr_cr1" class="supplier_debit pull-right">
                                            <option value="1">Dr</option>
                                            <option value="0">Cr</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-4">Description</label>

                                    <div class="col-lg-8 col-sm-8">
                                        <textarea class="form-control " id="description1" name="description" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitaddsupplier" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-info">Reset</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>

    //To stop form action by pressing enter key
    $("form").keypress(function (e) {
        //Enter key
        if (e.which == 13) {
            return false;
        }
    });

    $(document).ready(function () {
        //supplier name check
        function supplierNameCheck() {
            var supplier_name = $("#supplier_name1").val();
            var dataString = "suppname=" + supplier_name;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('supplier/suppliernamecheck'); ?>",
                data: dataString,
                success: function (data) {
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

        // Add new data
        $('#submitaddsupplier').click(function () {

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
            } else {

                var address = $("#address1").val();
                var country = $("#country1").val();
                var phone = $("#phone1").val();
                var mobile = $("#mobile1").val();
                var email = $("#email1").val();
                var dr_cr = $("#dr_cr1").val();
                var opening_balance = $("#opening_balance1").val();
                var description = $("#description1").val();
                var company_id = $("#company_id1").val();
                var dataString = "supplier_name=" + supplier_name + "&address=" + address + "&country=" + country + "&phone=" + phone + "&company_id=" + company_id + "&mobile=" + mobile + "&email=" + email + "&dr_cr=" + dr_cr + "&opening_balance=" + opening_balance + "&description=" + description;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('/supplier/add'); ?>",
                    data: dataString,
                    success: function (data) {
                        if (data === 'Added') {
                            $('#myModalnews').modal('hide');
                            $.gritter.add({
                                // (string | mandatory) the heading of the notification
                                title: 'Successfull!',
                                // (string | mandatory) the text inside the notification
                                text: 'Supplier Added Successfully',
                                // (string | optional) the image to display on the left
                                // image: 'img/avatar-mini.jpg',
                                // (bool | optional) if you want it to fade out on its own or just sit there
                                sticky: false,
                                // (int | optional) the time you want it to be alive for before fading out
                                time: '5000'
                            });
                            setTimeout("window.location.reload(1)", 2000);
                            return true;
                        }
                        if (data === 'Notadded') {
                            $('#myModalnews').modal('hide');
                            $.gritter.add({
                                // (string | mandatory) the heading of the notification
                                title: 'Unsuccessfull!',
                                // (string | mandatory) the text inside the notification
                                text: 'Supplier Not Added ',
                                // (string | optional) the image to display on the left
                                // image: 'img/avatar-mini.jpg',
                                // (bool | optional) if you want it to fade out on its own or just sit there
                                sticky: false,
                                // (int | optional) the time you want it to be alive for before fading out
                                time: ''
                            });
                        }
                    }
                });
            }
        });
        // Add new supplier
        $("#corparty_account").change(function () {
            var value = $("#corparty_account").val();
            if (value == "3newone") {
                $('#myModalnews').modal();
            }
        });
        // Add new Unit
        $("#unit").change(function () {
            var value = $("#unit").val();
            if (value == "3newunit") {
                $('#addProductunit').modal();
            }
        });

//Check Invoice Number
        $("#invoive_number").change(function () {
            var invoiceno = $(this).val();
            var companyid = $("#company_id").val();
            var dataString = "invoiceno=" + invoiceno + "&companyid=" + companyid;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('purchase/purchase/checkinvoiceno'); ?>",
                data: dataString,
                success: function (data) {
                    if (data == "found") {
                        $("#invoive_number").css('border-color', 'red');
                        $("#servermsg").text("Invoice Number is already exist!");
                        $("#servermsg").css('color', 'red');
                    }
                    if (data == "notfound") {
                        $("#invoive_number").css('border-color', '#898990');
                        $("#servermsg").text("Invoice Number is Available!");
                        $("#servermsg").css('color', 'green');

                    }
                }
            });
        });

        $("#addpurchase_submit").click(function () {
            var corparty_account = $("#corparty_account").val();
            if (corparty_account == "") {
                $("#partymessage").text("Please select cash/party!");
                $("#partymessage").css('color', 'red');
            }
            var msg = $("#servermsg").text();
            if (msg == "Invoice Number is already exist!") {
                return false;
            }
        });

        //when put value
        $("#corparty_account").change(function () {
            $("#partymessage").text('');
        });
        $("#product_name").change(function () {
            $("#product_name").css('border-color', '#898990');
        });
        $("#qty").change(function () {
            $("#qty").css('border-color', '#898990');
        });
        $("#rate").change(function () {
            $("#rate").css('border-color', '#898990');
        });

        //click on reset for products
        $("#product-reset").click(function () {
            $("#product_name").val("");
            $("#qty").val("");
            $("#freeqty").val("");
            $("#unit").val("");
            $("#unitshow").val("");
            $("#rate").val("");
            $("#sale_rate").val("");
        });

        //data append into table from session
        var count = 0;
        var countqtyrate = 0;
        $("#addpurchase").click(function () {
            var product_name = $("#product_name").val();
            var qty = $("#qty").val();
            var freeqty = $("#freeqty").val();
            var unit = $("#unit").val();
            var rate = $("#rate").val();
            var sale_rate = $("#sale_rate").val(),
                serial = $('#serialnumber').val();

            if (freeqty == "") {
                freeqty = 0.00;
            }
            if (sale_rate == "") {
                sale_rate = 0.00;
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

            var dataString = "count=" + count + "&product_name=" + product_name + "&qty=" + qty + "&freeqty=" + freeqty + "&unit=" + unit + "&rate=" + rate + "&sale_rate=" + sale_rate + "&serial=" + serial;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('purchase/purchase/add_view_table'); ?>",
                data: dataString,
                success: function (data) {
                    $("#addnewrow").append(data);

                    //3rd part
                    var qty2 = parseFloat($("#qty" + count).val());
                    var rate2 = parseFloat($("#rate" + count).val());

                    var qtyrate = qty2 * rate2;
                    countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate

                    var grandtotal = parseFloat(countqtyrate);  //total amount
                    var discount = $("#discount").val();
                    var transport = parseFloat($("#transport").val());
                    //  var net_amout = grandtotal - parseFloat(discount);
                    var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount;
                    var grandtotal = Math.ceil(grandtotal * 2) / 2;
                    var net_amout = Math.ceil(net_amout * 2) / 2;

                    document.getElementById("total_amout").innerHTML = grandtotal;
                    $(".total_amout").val(grandtotal);

                    document.getElementById("grandtotal").innerHTML = grandtotal;
                    $(".grandtotal").val(grandtotal);

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
                        for (k; k <= count; k++) {
                            var qty3 = parseFloat($("#qty" + k).val());
                            var rate3 = parseFloat($("#rate" + k).val());
                            var qtyrate = qty3 * rate3;

                            //Net amount per product
                            var grandtotal = qtyrate;  //total amount

                            $("#product_amount" + k).text(grandtotal);

                            countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate
                        }
                        grandtotal = countqtyrate;  //total amount
                        var discount = $("#discount").val();
                        var net_amout = grandtotal - discount;

                        var grandtotal = Math.ceil(grandtotal * 2) / 2;
                        var net_amout = Math.ceil(net_amout * 2) / 2;

                        document.getElementById("total_amout").innerHTML = grandtotal;
                        $(".total_amout").val(grandtotal);

                        document.getElementById("grandtotal").innerHTML = grandtotal;
                        $(".grandtotal").val(grandtotal);

                        document.getElementById("net_amout").innerHTML = net_amout;
                        $(".net_amout").val(net_amout);
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
            $("#product_name").val('').change();
            $("#qty").val("");
            $("#freeqty").val("");
//            $("#unit").val("");
//            $("#unitshow").val("");
            $("#rate").val("");
            $("#sale_rate").val("");
            $('#serialnumber').val('');
        });


        //3rd part for discount

        $("#discount").change(function () {
            var grandtotal = $(".grandtotal").val();
            var discount = $("#discount").val();
            var transport = parseInt($("#transport").val());
            var net_amout = Number(grandtotal) + Number(transport) - discount;

            document.getElementById("net_amout").innerHTML = net_amout;
            $(".net_amout").val(net_amout);
        });

        $("#transport").change(function () {
            var grandtotal = $(".grandtotal").val();
            var discount = $("#discount").val();
            var transport = parseInt($("#transport").val());
            var net_amout = Number(grandtotal) + Number(transport) - discount;

            document.getElementById("net_amout").innerHTML = net_amout;
            $(".net_amout").val(net_amout);
        });

        //show unit id
        $("#product_name").change(function () {
            var product_id = $(this).val();
            //alert(product_id);
            var dataString = "product_id=" + product_id;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('purchase/purchase/unit_name'); ?>",
                data: dataString,
                success: function (data) {
                    var unitobj = $.parseJSON(data);
                    $("#unitshow").val(unitobj['unitname']);
                    $("#unit").val(unitobj['unitid']);
                    $("#rate").val(unitobj['purchaserate']);
                    $("#sale_rate").val(unitobj['salesrate']);
                }
            });
        });

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


    function deleteRowData(rownumber) {
        var idvaldata = "row" + rownumber;
        //   var idvaldataoffice = "rowoffice" + rownumber;
        //   var idvaldatacustomer = "rowcustomer" + rownumber;

        //3rd part
        var qty2 = parseFloat($("#qty" + rownumber).val());
        var rate2 = parseFloat($("#rate" + rownumber).val());

        var previoustotal = $(".total_amout").val();
        //  console.log("previoustotal :" + previoustotal + "qty2 :" + qty2 + "rate2 :" + rate2);

        var qtyrate = qty2 * rate2;
        var countqtyrate = parseFloat(previoustotal) - qtyrate;  //Total quantity * rate

        var grandtotal = parseFloat(countqtyrate);  //total amount
        var discount = $("#discount").val();
        var transport = parseFloat($("#transport").val());
        var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount;
        // var net_amout = parseFloat(grandtotal) - discount;

        var grandtotal = Math.ceil(grandtotal * 2) / 2;
        var net_amout = Math.ceil(net_amout * 2) / 2;

        document.getElementById("total_amout").innerHTML = grandtotal;
        $(".total_amout").val(grandtotal);

        document.getElementById("grandtotal").innerHTML = grandtotal;
        $(".grandtotal").val(grandtotal);

        document.getElementById("net_amout").innerHTML = net_amout;
        $(".net_amout").val(net_amout);

        //For print
        $("#netvalues1").text(grandtotal);
        $("#invoiceamount1").text(grandtotal);
        $("#netvalues2").text(grandtotal);
        $("#invoiceamount2").text(grandtotal);

        document.getElementById(idvaldata).remove();
        // document.getElementById(idvaldataoffice).remove();
        // document.getElementById(idvaldatacustomer).remove();
    }






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
if ((isset($data_added)) && ($data_added == "adderror")) {
    ?>
    <script>
        $(document).ready(function () {
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

