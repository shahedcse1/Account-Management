<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->       
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Payment Voucher
                    </header>
                    <div class="panel-body" style="margin-top: 15px">                      
                        <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('productprocess/productprocess/add_processProduct') ?>">
                            <div class="col-lg-6">                                
                                <!--                                                                <div class="form-group">
                                                                                                    <div class="col-lg-2"></div>
                                                                                                    <div style="margin-top: 7px" class="col-lg-4">                                        
                                                                                                        <select class="form-control selectpicker" id="productname1" name="productname1" data-live-search="true">
                                                                                                            <option value="">-- Select Raw Product1 --</option>
                                <?php foreach ($rawProductList as $row): ?>
                                                                                                                                                                                                                    <option value="<?php echo $row->productId; ?>"><?php echo $row->productName; ?></option>
                                <?php endforeach; ?>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div style="margin-top: 7px" class="col-lg-4">                                        
                                                                                                        <input class="form-control" type="text" name="qty1" id="qty1" placeholder="Qunatity">
                                                                                                    </div>  
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <div class="col-lg-2"></div>
                                                                                                    <div style="margin-top: 7px" class="col-lg-4">                                        
                                                                                                        <select class="form-control selectpicker" id="productname2" name="productname2" data-live-search="true">
                                                                                                            <option value="">-- Select Raw Product2 --</option>
                                <?php foreach ($rawProductList as $row): ?>
                                                                                                                                                                                                                    <option value="<?php echo $row->productId; ?>"><?php echo $row->productName; ?></option>
                                <?php endforeach; ?>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div style="margin-top: 7px" class="col-lg-4">                                        
                                                                                                        <input class="form-control" type="text" name="qty2" id="qty2" placeholder="Qunatity">
                                                                                                    </div> 
                                                                                                </div>
                                -->
                                <div class="form-group">
                                    <div class="multi-field-wrapper">
                                        <div class="multi-fields">
                                            <div class="multi-field">
                                                <div class="col-lg-2"></div>
                                                <div style="margin-top: 7px" class="col-lg-4">
                                                    <select class="form-control" id="productname" autofocus name="rawproductId[]" required="required">
                                                        <option value="">-- Select Raw Product --</option>
                                                        <?php foreach ($rawProductList as $row): ?>
                                                            <option value="<?php echo $row->productId; ?>"><?php echo $row->productName; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div style="margin-top: 7px" class="col-lg-4">
                                                    <input class="form-control" type="text" name="qty[]" id="qty2" required="required">
                                                    <span id="qtymsg"></span>
                                                </div>
                                                <button style="margin-top: 9px; padding: 2px 2px;" type="button" class="btn btn-danger remove-field">Remove</button>
                                            </div>
                                        </div>
                                        <button style="margin-left: 0px; margin-top: 10px;" type="button" class="btn btn-success add-field">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="col-lg-2"></div>
                                    <div style="margin-top: 7px" class="col-lg-4">                                        
                                        <select class="form-control selectpicker" id="productname" name="productname" required="required">
                                            <option value="">-- Select Product --</option>
                                            <?php foreach ($productList as $row): ?>
                                                <option value="<?php echo $row->productId; ?>"><?php echo $row->productName; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div style="margin-top: 7px" class="col-lg-4">                                        
                                        <input class="form-control" type="text" name="radyProductqty" id="radyProductqty" placeholder="Qunatity" required="required">
                                    </div>                                     
                                </div>                          
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-6"></div>
                                <div class="form-group">
                                    <div class="col-lg-offset-4">
                                        <button type="submit" id="paymentvoutersubmit2" class="btn btn-primary">Process</button>
                                        <div id="showpaymentvoutersubmit" class="btn btn-primary">Save</div>
                                        <button type="reset" class="btn btn-info">Reset</button>
                                        <a href="<?php echo site_url('paymentvoucher/paymentvoucher'); ?>"><button type="button" class="btn btn-default">Close</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<script>
    $(document).ready(function() {
        $("#showpaymentvoutersubmit").hide();
        $("#paymentvoutersubmit").click(function() {
            $("#paymentvoutersubmit").hide();
            $("#showpaymentvoutersubmit2").show();
        });
    });
</script>
<script>
    $('.multi-field-wrapper').each(function() {
        var $wrapper = $('.multi-fields', this);
        $(".add-field", $(this)).click(function(e) {
            var lenth = $('.multi-field', $wrapper).length;
            if (lenth < 10) {
                $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input', 'select').val('').focus();
                //$('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('select').val('').focus();
            }
        });
        $('.multi-field .remove-field', $wrapper).click(function() {
            if ($('.multi-field', $wrapper).length > 1)
                $(this).parent('.multi-field').remove();
        });
    });
    $("#productname").change(function() {
        var product_id = $(this).val();
        var dataString = "product_id=" + product_id;
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
                        $("#qty").css('border-color', 'red');
                        $("#qtymsg").text("Limit exceeds!");
                        $("#qtymsg").css('color', 'red');
                        return false;
                    } else {
                        $("#qty").css('border-color', '#898990');
                        $("#qtymsg").text("Available qty is " + range);
                        $("#qtymsg").css('color', 'green');
                    }
                });
            }
        });
    });
</script>