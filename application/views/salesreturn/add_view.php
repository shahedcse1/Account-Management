<style>
    .form-control {
        margin-left: 0px;

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
        background-color:#ba41a3;
    }
    .adv-table table.display thead th, table.display tfoot th{
        background-color:#ba41a3;
    }

</style>
<form action="<?php echo site_url('salesreturn/salesreturn/add'); ?>" method="post" class="form-horizontal custom-form" role="form">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <section class="panel">
                <header class="panel-heading">
                    Add  Sales Return Information
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <div class="clearfix">
                            <div class="btn-group pull-right">
                                <br/>
                            </div>
                        </div>

                        <div class="row purchase-top">
                            <div class="form-group col-md-3">
                                <label for="invoive_number" class="col-md-4 control-label text-left custom">Product Name</label>
                                <div class="col-md-8 myselect">
                                    <select class="form-control selectpicker" data-live-search="true"  name="product_name" id="product_name">
                                        <option value="">Select</option>
                                        <?php
                                        if(isset($productdata)){
                                            foreach($productdata as $product){
                                                if(!empty($product->productId)){
                                                    echo '<option value="'.$product->productId.'">'.$product->productName.'</option>';
                                                }
                                            }
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="invoive_number" class="col-md-4 control-label text-left custom">Invoice Number</label>
                                <div class="col-md-8 myselect">
                                    <select class="form-control" data-live-search="true"  name="invoive_number" id="invoive_number" required>
                                        <option value="">Select</option>
                                        <?php
                                        if(isset($purchaseinfo)){
                                            foreach($purchaseinfo as $purchase){
                                                if(!empty($purchase->salesMasterId)){
                                                    echo '<option value="'.$purchase->salesMasterId.'">'.$purchase->salesMasterId.'</option>';
                                                }
                                            }
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="corparty_account" class="col-md-4 control-label text-left ">Cash/Party</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="corparty_account" id="corparty_account" value="" readonly/>
                                    <input type="hidden" name="ladger_id" id="ladger_id" value=""/>
                                    <input  id="company_id"  name="company_id" type="hidden" value="<?php echo $company_id;?>"/>
                                </div>
                            </div>
                            <div class="form-group col-md-3">


                                <label for="invoice_data" class="col-md-4 control-label text-left"> Date</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="invoice_date" value="<?php echo date('Y-m-d')." 00:00:00";?>" id="datetimepicker" readonly/>
                                </div>
                            </div>


                        </div>
                        <hr/>


                        <table class="display table table-bordered table-striped " id="cloudAccounting1">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Returned Qty</th>
                                <th>Unit</th>
                                <th>Rate(Discounted)</th>
<!--                                <th>Sale Rate</th>-->
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
                                            <textarea name="description" id="description" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 col-md-offset-2">
                                    <ul class="unstyled amounts">
                                        <li class="text-center"><strong>Net Amount :</strong> <span id="net_amout" class="align-right ">0.00</span><input name="net_amout" class="net_amout" type="hidden"/></li>
                                    </ul>
                                    <div class="final-submit pull-right">
                                        <button type="submit" class="btn btn-default">submit</button>
                                        <a href="<?php echo site_url('sales/sales'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
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