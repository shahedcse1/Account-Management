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
    .edit-table td {
        cursor: pointer;
    }
    .purchase-top .form-group{
        margin-bottom: -5px;
    }
</style>
<form action="<?php echo site_url('stockentry/stockentry/edit'); ?>" method="post" class="form-horizontal custom-form" role="form">
<!--main content start-->
<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->
<section class="panel">
    <header class="panel-heading">
        Edit  Stock Entry Information
    </header>
    <div class="panel-body">
        <div class="adv-table">
            <div class="clearfix">
                <div class="btn-group pull-right">
                    <br/>
                </div>
            </div>
            <?php if(isset($stockmasterinfo)):
            foreach($stockmasterinfo as $stockmaster):?>
            <div class="row purchase-top">
                <input  id="company_id"  name="company_id" type="hidden" value="<?php echo $company_id;?>"/>
                <input  id="stockMasterId"  name="stockMasterId" type="hidden" value="<?php echo $this->input->get('id');?>"/>
                <div class="form-group col-sm-4">
                    <label for="invoice_data" class="col-sm-4 control-label text-left"> Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="invoice_date" value="<?php echo $stockmaster->date;?>" id="datetimepicker" readonly/>
                    </div>
                </div>

                <?php endforeach;endif;?>
                </div>
                <hr/>
                <!--       ============================ PART 2====================================================-->
                <div class="row">
                <div class="form-group col-sm-4 clear">
                    <label for="product_name" class="col-sm-4 control-label custom">Product </label>
                    <div class="col-sm-8 myselect">
                        <select class="form-control selectpicker" data-live-search="true"  name="product_name" id="product_name">
                            <option value="">Select One</option>
                            <?php
                            if(isset($products)){
                                foreach($products as $product){
                                    echo '<option value="'.$product->productId.'">'.$product->productName.'</option>';
                                }
                            }?>
                            <input name="count" id="count" value="" type="hidden"/>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="unit" class="col-sm-4 control-label text-left">Unit</label>
                    <div class="col-sm-8">
                        <input type="hidden" class="form-control" name="unit" id="unit" placeholder="Unit">
                        <input type="text" class="form-control"  id="unitshow" placeholder="Unit" readonly>
                    </div>
                </div>
                <div class="form-group col-sm-2">
                    <label for="qtyi" class="col-sm-4 control-label text-left">Qty</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="qtyi" id="qtyi" placeholder="Qty">
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="ratei" class="col-sm-4 control-label text-left ">Rate</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="ratei" id="ratei" placeholder="Rate">
                    </div>
                </div>
                </div>
                 <div class="row">

                <div class="form-group col-sm-4">
                    <label for="sale_ratei" class="col-sm-4 control-label custom">Sale Rate</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sale_ratei" id="sale_ratei" placeholder="Sale Rate">
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <div class="col-sm-12">
                        <button type="button" id="addpurchase" class="btn btn-default">Edit</button>
                        <button type="button" id="product-reset"  class="btn btn-default">Clear</button>
                    </div>
                </div>
                <!--     ================================   END 2nd part input=========================-->
            </div>


            <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Sale Rate</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody id="addnewrowedit">
                    <?php if(isset($productinfo)):
                        $count=0;
                        foreach($productinfo as $rqv):
                            $count=$count+1;
                            ?>

                        <tr class="single_row" id="<?php echo $count;?>">
                            <td>
                                <?php  //product name
                                echo  '<input name="stockDetailsId'.$count.'" id="stockDetailsId'.$count.'" value="'.$rqv->stockDetailsId.'" type="hidden"/>';
                                echo  '<input name="serialNumber'.$count.'" id="serialNumber'.$count.'" value="'.$rqv->serialNumber.'" type="hidden"/>';
                                echo  '<input name="count_product" id="count_product" value="'.$count_product.'" type="hidden"/>';
                                echo '<input name="product_id'.$count.'" id="product_id'.$count.'" value="'.$rqv->productId.'" type="hidden"/><span class="product_id'.$count.'">'.$rqv->productName.'</span> ';//Input field
                                ?>
                            </td>
                            <td><?php //qty
                                echo '<input name="qty'.$count.'" id="qty'.$count.'" value="'.$rqv->qty.'" type="hidden"/>'.'<span class="qty'.$count.'">'.$rqv->qty.'</span>';  //Input field
                                ?>
                            </td>
                            <td><?php //Unit name
                                echo '<input name="unit_id'.$count.'" id="unit_id'.$count.'" value="'.$rqv->unit.'" type="hidden"/>';  //Input field
                                echo '<span class="unit_id'.$count.'">'.$rqv->unitName.'</span>';
                                ?>
                            </td>
                            <td><?php //rate
                                echo '<input name="rate'.$count.'" id="rate'.$count.'" value="'.$rqv->rate.'" type="hidden"/>'.'<span class="rate'.$count.'">'.$rqv->rate.'</span>'; //Input field
                                ?>
                            </td>
                            <td><?php //salerate
                                echo '<input name="salerate'.$count.'" id="salerate'.$count.'" value="'.$rqv->salesRate.'" type="hidden"/>'.'<span class="salerate'.$count.'">'.$rqv->salesRate.'</span>'; //Input field
                                ?>
                            </td>
                            <td><?php
                                //Net amount per product
                                $qtyrate=$rqv->qty * $rqv->rate;
                                $grandtotal= $qtyrate;  //total amount
                                echo '<span id="product_amount'.$count.'">'. number_format($grandtotal, 2).'</span>'; //Input field
                                ?>
                            </td>
                        </tr>

                    <?php

                        endforeach;
                    endif;?>


                </tbody>
            </table>

            <div class="panel-body">
                <div class="row">
                    <?php if(isset($stockmasterinfo)):
                    foreach($stockmasterinfo as $stockmaster):?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" cols="30" rows="5"><?php echo $stockmaster->description;?></textarea>
                            </div>
                        </div>

                    </div>
                    <?php endforeach;endif;?>
                    <div class="col-sm-6 col-sm-offset-2">
                        <ul class="unstyled amounts">
                            <li class="text-center"><strong>Net Amount :</strong> <span id="net_amout" class="align-right "></span><input name="net_amout" class="net_amout" value="" type="hidden"/></li>
                        </ul>
                        <div class="final-submit pull-right">
                            <button type="submit" id="updatestock" class="btn btn-default">Update</button>
                            <a href="<?php echo site_url('stockentry/stockentry'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
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
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";

        if (fyearstatus == '0') {
            $("#updatestock").prop("disabled", true);
            $("#addpurchase").prop("disabled", true);
        }
    });
</script>