<script>
    //Find Company name for Invoice no
    $("#invoive_number").change(function () {
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
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('salesreturn/salesreturn/findproductinfo'); ?>",
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
                    var rate2 = parseFloat($("#rate" + count).val());
                    var qtyrate = qty2 * rate2;
                    countqtyrate = countqtyrate + qtyrate;  //Total quantity* qty
                }
                var grandtotal = countqtyrate;  //grand total

                document.getElementById("net_amout").innerHTML = grandtotal;
                $(".net_amout").val(grandtotal);

                //edit returnqty for product
                $(".returnqty").change(function () {
                    var returnqty = $(this).val();
                    console.log("returnqty");
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


                //edit rate for product

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


    $("#product_name").change(function () {
        var productid = $(this).val();
        var dataString = "productid=" + productid;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('salesreturn/salesreturn/getinvoiceidset'); ?>",
            data: dataString,
            success: function (data) {
                document.getElementById("addnewrow").innerHTML = "";
                document.getElementById("invoive_number").innerHTML = data;
            }
        });
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
        });</script>
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
