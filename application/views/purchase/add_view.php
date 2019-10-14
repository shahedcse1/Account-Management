<style>
    .form-control {
        margin-left: 0;

    }
    .custom{
        padding-left: 35px;
    }
    .custom-form label{
        margin-top: -5px !important;
    }
    ul.amounts li {
        background: none repeat scroll 0 0 #f5f5f5;
        border-radius: 4px;
        float: left;
        font-weight: 300;
        margin-bottom: 5px;
        margin-right: 2%;
        padding: 8px;
        width: 48%;
    }
    #discount {
        height: 19px;
        padding: 1px 6px;
        width: 80px !important;
    }
    .final-submit {
        margin-right: 15px;
    }
    .purchase-top .form-group{
        margin-bottom: -5px;
    }
    .edit-field{
        cursor: pointer;
    }
  .panel-heading{
        background-color:#da952e;
    }
    table.table thead{
    background-color: #da952e;
    }
    .adv-table table.display thead th, table.display tfoot th{
        background-color:#da952e;
    }
</style>
<form action="<?= site_url('purchase/purchase/add'); ?>" method="post" class="form-horizontal custom-form" role="form">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <section class="panel">
                <header class="panel-heading">
                    Add  Purchase Information
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <div class="clearfix">
                            <div class="btn-group pull-right">
                                <br/>
                            </div>
                        </div>

                        <div class="row purchase-top">
                            <div class="form-group col-md-4">
                                <label for="corparty_account" class="col-md-4 control-label text-left custom">Cash/Party</label>
                                <div class="col-md-8 myselect">
                                    <select class="form-control selectpicker" data-live-search="true" name="corparty_account" id="corparty_account" required>
                                        <option value="">Select</option>
                                        <option value="2">Cash Account</option>
                                        <?php
                                        if (isset($supplierinfo1)) {
                                            foreach ($supplierinfo1 as $supplier) {
                                                echo '<option value="' . $supplier->ledgerId . '">' . $supplier->acccountLedgerName . '</option>';
                                            }
                                        }
                                        ?>
                                        <option value="3newone" id="newsupplier">Add New Supplier</option>
                                    </select>
                                    <input  id="company_id"  name="company_id" type="hidden" value="<?= $company_id; ?>"/>
                                    <span id="partymessage"> </span>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <!-- ============================ PART 2==================================================== -->

                        <div class="row">
                            <div class="form-group col-md-3 clear">
                                <label for="product_name" class="col-md-4 control-label custom">Product </label>
                                <div class="col-md-8  myselect">
                                    <select class="form-control selectpicker" data-live-search="true" name="product_name" id="product_name">
                                        <option value="">Select One</option>
                                        <?php
                                        if (isset($productinfo)) {
                                            foreach ($productinfo as $product) {
                                                echo '<option value="' . $product->productId . '">' . $product->productName . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="unit" class="col-md-4 control-label text-left">Unit</label>
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control" name="unit" id="unit" placeholder="Unit">
                                    <input type="text" class="form-control"  id="unitshow" placeholder="Unit" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="qty" class="col-md-4 control-label text-left">Qty</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="freeqty" class="col-md-4 control-label text-left">Free Qty</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="freeqty" id="freeqty" placeholder="Free Qty">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Rate -->
                            <div class="form-group col-md-3">
                                <label for="rate" class="col-md-4 control-label text-left custom">Rate</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="rate" id="rate" placeholder="Rate">
                                </div>
                            </div>

                            <!-- Sale Rate -->
                            <div class="form-group col-md-3">
                                <label for="sale_rate" class="col-md-4 control-label ">Sale Rate</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="sale_rate" id="sale_rate" placeholder="Sale Rate">
                                </div>
                            </div>

                            <?php if ($serial == '1'): ?>
                            <!-- Serial Number -->
                            <div class="form-group col-md-3">
                                <label for="serialnumber" class="col-md-4 control-label ">Serial</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="serialnumber" id="serialnumber" placeholder="Serial">
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-md-3">
                                <label class="col-md-2 control-label "></label>
                                <div class="col-md-10">
                                    <button type="button" id="addpurchase" class="btn btn-default">Add</button>
                                    <button type="button" id="product-reset" class="btn btn-default">Clear</button>  
                                </div>
                            </div>
                            <!--     ================================   END 2nd part input=========================-->
                        </div>

                        <table class="display table table-bordered table-striped " id="cloudAccounting1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>FreeQty</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Sale Rate</th>
                                    <?php if ($serial == '1'): ?>
                                        <th>Serial</th>
                                    <?php endif; ?>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="addnewrow">
                            </tbody>
                        </table>

                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="description" class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 col-md-offset-2">
                                    <ul class="unstyled amounts">
                                        <li class="text-center"><strong>Total Amount : </strong><span id="total_amout" class="align-right "> 0.00 </span> <input name="total_amout" class="total_amout" type="hidden"/></li>
                                        <li style="display: none" class="text-center"><strong>Grand Total :</strong> <span  id="grandtotal" class="align-right ">0.00</span><input name="grandtotal" class="grandtotal" type="hidden"/></li>
                                        <li class="text-center"><strong>Discount :</strong> <span class="align-right "><input type="text" name="discount" id="discount" style="width: 40px" value="00"/></span></li> 
                                        <li class="text-center"><strong>Other Cost :</strong> <span class="align-right ">
                                                <input type="text" name="transport" id="transport" style="width: 40px" value="00"/></span></li>
                                        <li class="text-center"><strong>Net Amount :</strong> <span id="net_amout" class="align-right ">0.00</span><input name="net_amout" class="net_amout" type="hidden"/><input name="count_product" class="count_product" type="hidden"/></li>
                                    </ul>
                                    <div class="final-submit pull-right">
                                        <button type="submit" id="addpurchase_submit" class="btn btn-default">submit</button>
                                        <div id="showpaymentvoutersubmit" class="btn btn-default">submit</div>
                                        <a href="<?php echo site_url('purchase/purchase'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </section>
            <!-- page end-->
        </section>
    </section>
</form>
<!--main content end-->
<script>

    $(document).ready(function () {
        $("#showpaymentvoutersubmit").hide();
        /*    $("#addpurchase_submit").click(function () {
         $("#addpurchase_submit").hide();
         $("#showpaymentvoutersubmit").show();
         });  */
    });

</script>