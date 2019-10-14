
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
    var grandtotal = parseFloat(countqtyrate);
    var discount = $("#discount").val();
    var transport = parseFloat($("#transport").val());

    var net_amout = parseFloat(grandtotal) + parseFloat(transport) - discount;


    var grandtotal = Math.ceil(grandtotal * 2) / 2;
    var netamount = Math.ceil(netamount * 2) / 2;

    document.getElementById("total_amout").innerHTML = grandtotal;
    $(".total_amout").val(grandtotal);

    document.getElementById("grandtotal").innerHTML = grandtotal;
    $(".grandtotal").val(grandtotal);

    document.getElementById("net_amout").innerHTML = net_amout;
    $(".net_amout").val(net_amout);

    // Add new supplier
    $("#corparty_account").change(function () {
        var value = $("#corparty_account").val();
        if (value == "3newone") {
            $('#myModalnews').modal();
        }
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


    //click on reset for products
    $("#product-reset").click(function () {
        $("#product_name").val("");
        $("#product").val("");
        $("#qtyi").val("");
        $("#freeqtyi").val("");
        $("#unit").val("");
        $("#unitshow").val("");
        $("#ratei").val("");
        $("#sale_ratei").val("");
    });

    //when click on rows
    $(".single_row").click(function () {
        var no = $(this).attr("id");
        var product_id = $("#product_id" + no).val();
        var product_name = $(".product_id" + no).text();
        var qty = $("#qty" + no).val();
        var freeqty = $("#freeqty" + no).val();
        var unit_id = $("#unit_id" + no).val();
        var unit_name = $(".unit_id" + no).text();
        var serial = $('#serial' + no).val();
        var rate = $("#rate" + no).val();
        var salerate = $("#salerate" + no).val();
        //paste values
        $("#product_name").val(product_name);
        $("#product").val(product_id);
        $("#qtyi").val(qty);
        $("#freeqtyi").val(freeqty);
        $("#unit").val(unit_id);
        $("#unitshow").val(unit_name);
        $("#serialnumberedit").val(serial);
        $("#ratei").val(rate);
        $("#sale_ratei").val(salerate);
        $("#count").val(no);

        //when click on edit
        $("#addpurchase").click(function () {
            var product_id = $("#product").val();
            var qtyi = $("#qtyi").val();
            var freeqtyi = $("#freeqtyi").val();
            var unit = $("#unit").val();
            var serial = $('#serialnumberedit').val();
            var ratei = $("#ratei").val();
            var sale_ratei = $("#sale_ratei").val();
            var count = $("#count").val();

            if (sale_ratei == "") {
                sale_ratei = 0.00;
            }
            if (freeqtyi == "") {
                freeqtyi = 0.00;
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
            //$(".product_id"+count).text(product_name);
            $("#qty" + count).val(qtyi);
            $(".qty" + count).text(qtyi);
            $("#freeqty" + count).val(freeqtyi);
            $(".freeqty" + count).text(freeqtyi);
            $("#unit_id" + count).val(unit);

            $('#serial'+ count).val(serial);
            $('#serial_number'+ count).text(serial);

            $("#rate" + count).val(ratei);
            $(".rate" + count).text(ratei);
            $("#salerate" + count).val(sale_ratei);
            $(".salerate" + count).text(sale_ratei);

            var dataString = "product_id=" + product_id + "&unitid=" + unit;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('purchase/purchase/dataqueryedit'); ?>",
                data: dataString,
                success: function (data) {
                    var res = data.split(",");
                    $('.product_id' + count).text(res[0]);
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
                $("#product_amount" + count).text(qtyrate);
                countqtyrate = countqtyrate + qtyrate;  //Total quantity* qty
            }

            var discount = $("#discount").val();
            var grandtotal = parseFloat(countqtyrate);  //grand total
            var transport = parseFloat($("#transport").val());
            var netamount = parseFloat(grandtotal) + parseFloat(transport) - discount;  //net amount

            var grandtotal = Math.ceil(grandtotal * 2) / 2;
            var netamount = Math.ceil(netamount * 2) / 2;

            document.getElementById("total_amout").innerHTML = grandtotal;
            $(".total_amout").val(grandtotal);

            document.getElementById("grandtotal").innerHTML = grandtotal;
            $(".grandtotal").val(grandtotal);

            document.getElementById("net_amout").innerHTML = netamount;
            $(".net_amout").val(netamount);


            $("#product_name").val('');
            $("#product").val("");
            $("#qtyi").val("");
            $("#freeqtyi").val("");
            $("#unit").val("");
            $("#unitshow").val("");
            $("#ratei").val("");
            $("#sale_ratei").val("");
            $('#serialnumberedit').val('')
        });
    });


    //show unit id
    $("#product").each(function () {
        var product_id = $(this).val();
        var dataString = "product_id=" + product_id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('purchase/purchase/unit_name'); ?>",
            data: dataString,
            success: function (data) {
                var unitobj = $.parseJSON(data);
                $("#unitshow").val(unitobj['unitname']);
                $("#unit").val(unitobj['unitid']);
                $("#ratei").val(unitobj['purchaserate']);
                $("#sale_ratei").val(unitobj['salesrate']);
            }
        });
    });

</script>