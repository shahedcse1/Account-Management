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
        background-color:#ec3d20;
    }
 .adv-table table.display thead th, table.display tfoot th{
        background-color:#ec3d20;
    }
</style>
<form action="<?php echo site_url('purchasereturn/purchase_return/edit'); ?>" method="post" class="form-horizontal custom-form" role="form">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <section class="panel">
                <header class="panel-heading">
                    Edit  Purchase  Return Information
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
                                <label for="invoive_number" class="col-md-4 control-label text-left custom">Invoice Number</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="invoive_number" id="invoive_number" readonly value="<?php echo (isset($invoiceno))?$invoiceno :"";?>"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
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
                                <th>Rate</th>
                                <th>Sale Rate</th>
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
                                        <li class="text-center"><strong>Total Amount : </strong><span id="total_amout" class="align-right "> 0.00 </span> <input name="total_amout" class="total_amout" type="hidden"/></li>
                                        <li style="display: none" class="text-center"><strong>Grand Total :</strong> <span  id="grandtotal" class="align-right ">0.00</span><input name="grandtotal" class="grandtotal" type="hidden"/></li>
                                        <li class="text-center"><strong>Discount :</strong>
                                            <span id="discount" class="align-right ">0.00</span></li>
                                        <li class="text-center"><strong>Net Amount :</strong> <span id="net_amout" class="align-right ">0.00</span><input name="net_amout" class="net_amout" type="hidden"/></li>
                                    </ul>
                                    <div class="final-submit pull-right">
                                        <button type="submit" id="deletepurchase" class="btn btn-default">Update</button>
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
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";

        if (fyearstatus == '0') {
            $("#deletepurchase").prop("disabled", true);        
        }
    });
</script>