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
    ul.amounts li.last {

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
    .label_radio {
        margin-right: 10px;
        position: relative;
        top: -10px;
    }
</style>
<form action="<?php echo site_url('salesfarmer/salesfarmer/edit'); ?>" method="post" class="form-horizontal custom-form" role="form">
<!--main content start-->
<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->
<section class="panel">
    <header class="panel-heading">
        Edit  Sales ReadyStock Information
    </header>
    <div class="panel-body">
        <div class="adv-table">
            <div class="clearfix">
                <div class="btn-group pull-right">
                    <br/>
                </div>
            </div>
            <?php if(isset($salesmasterinfo)):
            foreach($salesmasterinfo as $salesmaster):?>
            <div class="row purchase-top">
                <div class="form-group col-sm-4">
                    <label for="product_name selectpicker" data-live-search="true" class="col-sm-4 control-label ">Farmer/Customer </label>
                    <div class="col-sm-8 myselect">
                        <select class="form-control" name="farmer" id="farmer">
                            <option value="">Select One</option>
                            <?php
                            if(isset($farmerinfo)){
                                foreach($farmerinfo as $farmer){
                                    if($farmer->ledgerId==$salesmaster->farmerId){
                                        echo '<option value="'.$farmer->ledgerId.'" selected>'.$farmer->acccountLedgerName.'</option>';
                                    }
                                }
                            }
                            if($salesmaster->farmerId==2){
                                echo '<option value="2" selected>Cash Account</option>';
                            }
                            if($salesmaster->farmerId!=2){
                                echo '<option value="2">Cash Account</option>';
                            }?>
                            <?php
                            if(isset($farmerinfo)){
                                foreach($farmerinfo as $farmer){
                                    if($farmer->ledgerId!=$salesmaster->farmerId){
                                        echo '<option value="'.$farmer->ledgerId.'">'.$farmer->acccountLedgerName.'</option>';
                                    }
                                }
                            }?>
                            <input name="count" id="count" value="" type="hidden"/>
                            <input name="ledgerPostingId" id="ledgerPostingId" value="<?php echo $salesmaster->ledgerPostingId;?>" type="hidden"/>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="ratepurchase" class="col-sm-4 control-label text-left"> Rate</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="ratepurchase" value="<?php echo $salesmaster->farmerRate;?>" id="ratepurchase"/>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="invoice_data" class="col-sm-4 control-label text-left"> Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="invoice_date" value="<?php echo $salesmaster->date;?>" id="datetimepicker" readonly/>
                    </div>
                </div>
                <?php endforeach;endif;?>
                </div>
                <hr/>
                <!--       ============================ PART 2====================================================-->
                <div class="row">
                <div class="form-group col-md-3 ">
                    <label for="product_name" class="col-md-4 control-label custom">Product </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control"  value="Ready Stock" id="" name="" placeholder="" readonly>
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label for="corparty_account" class="col-sm-3 control-label">Party </label>
                    <div class="col-sm-8 myselect">
                        <select class="form-control selectpicker" data-live-search="true"  name="corparty_accounti" id="corparty_accounti">
                            <option value="">Select One</option>
                            <?php
                            if(isset($supplierinfo1)){
                                foreach($supplierinfo1 as $supplier){
                                    echo '<option value="'.$supplier->ledgerId.'">'.$supplier->accNo.' - '.$supplier->acccountLedgerName.'</option>';
                                }

                            }?>
                            <option value="3newone" id="newsupplier">Add New Customer</option>
                        </select>
                        <input  id="company_id"  name="company_id" type="hidden" value="<?php echo $company_id;?>"/>
                        <input  id="salesMasterId"  name="salesMasterId" type="hidden" value="<?php echo $this->input->get('id');?>"/>
                    </div>
                </div>

                <div class="form-group col-sm-2">
                    <label for="unit" class="col-sm-4 control-label text-left">KG</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"  id="kgi" placeholder="KG">
                    </div>
                </div>
                <div class="form-group col-sm-2">
                    <label for="qtyi" class="col-sm-4 control-label text-left">Pcs</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="qtyi" id="qtyi" placeholder="Pcs">
                        <span id="qtymsg"></span>
                    </div>
                </div>
                <div class="form-group col-sm-2">
                    <label for="ratei" class="col-sm-4 control-label text-left">Sale Rate</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="ratei" id="ratei" placeholder="Rate">
                    </div>
                </div>
                </div>
                 <div class="row">
                     <div class="col-md-1"></div>
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
                    <th>Customer Name</th>
                    <th>KG</th>
                    <th>Pcs</th>
                    <th> Rate</th>
                    <th>Amount</th>

                </tr>
                </thead>
                <tbody id="addnewrowedit">
                    <?php if(isset($salesmasterinfo)):
                        $count=0;
                        foreach($salesmasterinfo as $rqv):
                            $count=$count+1;
                            ?>

                        <tr class="single_row" id="<?php echo $count;?>">
                            <td>
                                <?php  //farmer name
                                echo  '<input name="salesReadyStockMasterId" id="salesReadyStockMasterId" value="'.$rqv->salesReadyStockMasterId.'" type="hidden"/>';
//                                echo  '<input name="count_product" id="count_product" value="'.$count_product.'" type="hidden"/>';
                                echo '<input name="ledgerid" id="ledgerid" value="'.$rqv->customerId.'" type="hidden"/> ';//Input field
                                echo '<span class="ledgerid">'.$rqv->customername.'</span>';
                                ?>
                            </td>
                            <td>
                                <?php //qty=kg
                                echo '<input name="kg" id="kg" value="'.$rqv->kg.'" type="hidden"/>'.'<span class="kg">'.$rqv->kg.'</span>';  //Input field
                                ?>
                            </td>
                            <td><?php //qty=Pcs
                                echo '<input name="qty" id="qty" value="'.$rqv->Pcs.'" type="hidden"/>'.'<span class="qty">'.$rqv->Pcs.'</span>';  //Input field
                                ?>
                            </td>
                            <td><?php //rate
                                echo '<input name="rate" id="rate" value="'.$rqv->rate.'" type="hidden"/>'.'<span class="rate">'.$rqv->rate.'</span>'; //Input field
                                ?>
                            </td>
                            <td><?php
                                //Net amount per product
                                $qtyrate=$rqv->kg * $rqv->rate;
                                $qtyratepurchase=$rqv->kg * $rqv->farmerRate;
                                $grandtotal= $qtyrate;  //total amount
                                echo '<span id="product_amount">'.$grandtotal.'</span><input name="amount" id="amount" type="hidden" value="'.$grandtotal.'"/>'; //Input field
                                echo '<input name="amountpurchase" id="amountpurchase" type="hidden" value="'.$qtyratepurchase.'"/>'; //Input field
                                ?>
                            </td>
                        </tr>

                    <?php

                        endforeach;
                      //  }
                    endif;?>


                </tbody>
            </table>

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6">
                        <div class="final-submit pull-right">
                                <button type="submit" id="addpurchase_submit"  class="btn btn-default">Update</button>
                            <a href="<?php echo site_url('salesfarmer/salesfarmer'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
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



<!-------------------------Add New Customer------------------------------------->
<div class="modal fade" id="myModalnews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Add Customer Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="cmxform form-horizontal tasi-form" id="customer_add" method="post" action="#">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="customer_name" class="control-label col-lg-4">Customer Name</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="customer_name1" name="customer_name"
                                               type="text" onchange="return customerNameCheck()" value="" required/>
                                        <span id="servermsg2"></span>
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
                                        <input class="form-control " type="text" id="opening_balance1" placeholder="0.00"
                                               name="opening_balance"/>

                                    </div>
                                    <div class="col-lg-2 ">
                                        <select name="dr_cr" id="dr_cr1" class="customer_debit pull-right">
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
                                        <textarea class="form-control" id="description1" name="description" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitaddcustomer" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-info">Reset</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="modalcloseforaddcustomer()">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>