<script>
//Find Company name for Invoice no
    $("#invoive_number").each(function () {
        var invoiceno = $(this).val();
        var dataString = "invoiceno=" + invoiceno;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('salesreturn/salesreturn/findcompanyname'); ?>",
            data: dataString,
            success: function (data) {
                var res = data.split(",");
                $("#ladger_id").val(res[1]);
                $("#corparty_account").val(res[0]);
                  $("#datetimepicker").val(res[2]);
                
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('salesreturn/salesreturn/findproductinfoedit'); ?>",
            data: dataString,
            success: function (data) {
                document.getElementById("addnewrow").innerHTML = data;

                //3rd part calculation
                var countproduct = $("#count_product").val();
                var count = 1;
                var countqtyrate = 0;
                for (count; count <= countproduct; count++) {
                    //3rd part
                    var qty2 = parseFloat($("#returnqty" + count).val());
                    var id = $("#returnqty" + count).data("id");

                    //For hide 0 return row
                    if (qty2 == 0) {
                        $(".row" + count).hide();
                    }

                    var rate2 = parseFloat($("#rate" + count).val());

                    var qtyrate = qty2 * rate2;
                    countqtyrate = countqtyrate + qtyrate;  //Total quantity* qty
                }
                var grandtotal = countqtyrate;  //grand total

                document.getElementById("net_amout").innerHTML = grandtotal;
                $(".net_amout").val(grandtotal);


                //edit table for product
                $(".returnqty").change(function () {
                    //3rd part
                    var k = 1;
                    countqtyrate = 0;
                    for (k; k < count; k++) {

                        var qty3 = parseFloat($("#returnqty" + k).val());
                        var rate3 = parseFloat($("#rate" + k).val());
                        var qtyrate = qty3 * rate3;

                        //Net amount per product
                        var grandtotal = qtyrate;  //total amount

                        $("#product_amount" + k).text(grandtotal);

                        countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate
                    }

                    grandtotal = countqtyrate;  //total amount

                    document.getElementById("net_amout").innerHTML = grandtotal;
                    $(".net_amout").val(grandtotal);
                    return false;
                });
                
                 //edit table for product
                $(".returnrate").change(function () {
                    //3rd part
                    var k = 1;
                    countqtyrate = 0;
                    for (k; k < count; k++) {

                        var qty3 = parseFloat($("#returnqty" + k).val());
                        var rate3 = parseFloat($("#rate" + k).val());
                        var qtyrate = qty3 * rate3;

                        //Net amount per product
                        var grandtotal = qtyrate;  //total amount

                        $("#product_amount" + k).text(grandtotal);

                        countqtyrate = countqtyrate + qtyrate;  //Total quantity * rate
                    }

                    grandtotal = countqtyrate;  //total amount

                    document.getElementById("net_amout").innerHTML = grandtotal;
                    $(".net_amout").val(grandtotal);
                    return false;
                });
            }
        });

    });
</script>