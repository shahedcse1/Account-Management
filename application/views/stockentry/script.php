<script>

        //when put value
        $("#product_name").change(function(){
            $("#product_name").css('border-color', '#898990');
        });
        $("#qty").change(function(){
            $("#qty").css('border-color', '#898990');
        });
        $("#rate").change(function(){
            $("#rate").css('border-color', '#898990');
        });

        //click on reset for products
        $("#product-reset").click(function(){
            $("#product_name").val("");
            $("#qty").val("");
            $("#unit").val("");
            $("#unitshow").val("");
            $("#rate").val("");
            $("#sale_rate").val("");
        });

    //data append into table from session
             var count=0;
             var countqtyrate=0;
            $("#addpurchase").click(function(){
                    count=count+1;
                    var product_name = $("#product_name").val();
                    var qty = $("#qty").val();
                    var unit = $("#unit").val();
                    var rate = $("#rate").val();
                    var sale_rate = $("#sale_rate").val();

                    if(sale_rate==""){
                        sale_rate=0.00;
                    }
                    if(product_name==""){
                        $("#product_name").css('border-color', 'red');
                        return false;
                    }
                    if(qty==""){
                        $("#qty").css('border-color', 'red');
                        return false;
                    }
                    if(rate==""){
                        $("#rate").css('border-color', 'red');
                        return false;
                    }

                    var dataString = "count=" + count + "&product_name=" + product_name + "&qty=" + qty + "&unit=" + unit + "&rate=" + rate + "&sale_rate=" + sale_rate;

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('stockentry/stockentry/add_view_table'); ?>",
                    data: dataString,
                    success: function (data) {
                        $("#addnewrow").append(data);

                        //3rd part
                        var qty2=parseInt($("#qty"+count).val());
                        var rate2=parseInt($("#rate"+count).val());

                        var qtyrate=qty2 * rate2;
                        countqtyrate=countqtyrate + qtyrate;  //Total quantity * rate

                        var grandtotal= countqtyrate;  //total amount
                        var net_amout=grandtotal;

                        document.getElementById("net_amout").innerHTML=net_amout;
                        $(".net_amout").val(net_amout);



                        //2nd part click for edit data from table view
                        $(".edit-field").click(function(){
                            $(this).find("span").hide();
                            $(this).find("input").prop("type","text");

                        });
                        //edit table for product
                        $(".edit_input").change(function(){
                            var value=$(this).val();
                            $(this).siblings("span").show();
                            $(this).siblings("span").text(value);
                            $(this).prop("type","hidden");

                            //3rd part
                            var k=1;
                            countqtyrate=0;
                            for(k;k<=count;k++){
                            var qty3=parseInt($("#qty"+k).val());
                            var rate3=parseInt($("#rate"+k).val());
                            var qtyrate= qty3 * rate3;

                                //Net amount per product
                                var grandtotal= qtyrate;  //total amount

                                $("#product_amount"+k).text(grandtotal);

                             countqtyrate= countqtyrate+qtyrate;  //Total quantity * rate
                            }
                             grandtotal= countqtyrate;  //total amount
                             var net_amout=grandtotal;

                            document.getElementById("net_amout").innerHTML=net_amout;
                            $(".net_amout").val(net_amout);
                            return false;
                        });

                        //count_product
                        $(".count_product").val(count);
                    }
                });

                //clear value fields

                    var product=$("#product_name option:selected").val();
                    if(product==product_name){
                        $("#product_name option:selected").hide();
                    }
                    $("#product_name").val("");
                    $("#qty").val("");
                    $("#unit").val("");
                    $("#unitshow").val("");
                    $("#rate").val("");
                    $("#sale_rate").val("");
                });


        //show unit id
        $("#product_name").change(function(){
            var product_id=$(this).val();
            //alert(product_id);
            var dataString = "product_id=" + product_id;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('stockentry/stockentry/unit_name'); ?>",
                data: dataString,
                success: function (data) {
                    var res = data.split(",");
                    $("#unitshow").val(res[1]);
                    $("#unit").val(res[0]);
                }
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
<?php
if((isset($data_added)) && ($data_added=="added")){

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
if((isset($data_added)) && ($data_added=="edited")){

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
if((isset($data_added)) && ($data_added=="deleted")){

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
if((isset($data_added)) && ($data_added=="notdeleted")){

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
if((isset($data_added)) && ($data_added=="add_unit")){

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

