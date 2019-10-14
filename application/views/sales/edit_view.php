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
        padding: 10px;
        width: 98%;
    }
    #discount {
        height: 25px;
        padding: 1px 6px;
        width: 80px !important;
    }

    #transport {
        height: 25px;
        padding: 1px 6px;
        width: 80px !important;
    }
    #vat {
        height: 25px;
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
<style type="text/css" media="print">
    @page { size: portrait; }
</style>
<form action="<?php echo site_url('sales/sales/edit'); ?>" method="post" class="form-horizontal custom-form" role="form">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <section class="panel">
                <header class="panel-heading">
                    Edit  Sales Information
                </header>
                <div class="panel-body">
                    <div class="adv-table">

                        <div class="row">
                            <div class="col-md-4 col-md-offset-8">
                                <ul class="unstyled amounts">
                                    <li><strong class="col-lg-5">Total Amount : </strong><span id="total_amout" class="align-right "> 0.00 </span> <input name="total_amout" class="total_amout" type="hidden"/></li>
                                    <li style="display: none" class="text-center"><strong>Grand Total :</strong> <span  id="grandtotal" class="align-right ">0.00</span><input name="grandtotal" class="grandtotal" type="hidden"/></li>
                                    <?php
                                    if (isset($salesmasterinfo)):
                                        foreach ($salesmasterinfo as $salesmaster):
                                            ?>
                                            <li><strong class="col-lg-5">Discount :</strong> <span class="align-right ">
                                                            <input type="text" name="discount" id="discount" style="width: 40px" value="<?php echo $salesmaster->billDiscount; ?>"/></span><span id="discountlimit" class="col-lg-offset-5"></span></li>
                                            <li><strong class="col-lg-5">VAT 5%(+):</strong> <span class="align-right">
                                                            <span id="vatspan" class="align-right"> <?php echo $salesmaster->vat; ?> </span>
                                                            <input type="hidden" name="vat" id="vat" style="width: 40px" value="<?php echo $salesmaster->vat; ?>"/></span></li>
                                            <!--  <li><strong class="col-lg-5">Transport Cost :</strong> <span class="align-right "> -->
                                            <input type="hidden" name="transport" id="transport" style="width: 40px" value="<?php echo $salesmaster->tranportation; ?>"/> <!-- </span></li> -->
                                            <li><strong class="col-lg-5">Previous Amount: </strong><span id="previous_amountspan" class="align-right"> <?php echo ($totalprevAmount); ?> </span> <input name="previous_amount" class="previous_amount" value="<?php echo ($totalprevAmount); ?>" type="hidden"/></li>
                                            <li><strong class="col-lg-5">Net Amount:</strong> <span id="net_amout" class="align-right "><?php echo ($totalprevAmount + $salesmaster->amount + $salesmaster->tranportation - $salesmaster->billDiscount + $salesmaster->vat); ?></span><input name="net_amout" class="net_amout" value="<?php echo ($totalprevAmount + $salesmaster->amount + $salesmaster->tranportation - $salesmaster->billDiscount + $salesmaster->vat); ?>" type="hidden"/></li>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <!--tab nav start-->
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs" id="editsalestab">
                                    <li class="active">
                                        <a data-toggle="tab" href="#step1">Step 1</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#step2">Step 2</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#step3">Step 3</a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">

                                    <!-- Step 1 -->
                                    <div id="step1" class="tab-pane active">
                                        <div class="panel-body">
                                            <?php
                                            if (isset($salesmasterinfo)):
                                            foreach ($salesmasterinfo as $salesmaster):
                                            ?>
                                            <div class="row purchase-top">

                                                <div class="form-group col-sm-4">
                                                    <label for="corparty_account" class="col-sm-3 control-label custom">Bill to </label>
                                                    <div class="col-sm-9 myselect">
                                                        <select class="form-control selectpicker" data-live-search="true" name="corparty_account" id="corparty_account">
                                                            <?php
                                                            if (isset($supplierinfo1)) {
                                                                foreach ($supplierinfo1 as $supplier) {
                                                                    if ($supplier->ledgerId == $salesmaster->ledgerId) {
                                                                        echo '<option value="' . $supplier->ledgerId . '" selected>' . $supplier->accNo . ' - ' . $supplier->acccountLedgerName . '</option>';
                                                                    }
                                                                }
                                                            }
                                                            if ($salesmaster->ledgerId == 2) {
                                                                echo '<option value="2" selected>Cash Account</option>';
                                                            }
                                                            if ($salesmaster->ledgerId != 2) {
                                                                echo '<option value="2">Cash Account</option>';
                                                            }
                                                            ?>
                                                            <?php
                                                            if (isset($supplierinfo1)) {
                                                                foreach ($supplierinfo1 as $supplier) {
                                                                    if ($supplier->ledgerId != $salesmaster->ledgerId) {
                                                                        echo '<option value="' . $supplier->ledgerId . '">' . $supplier->accNo . ' - ' . $supplier->acccountLedgerName . '</option>';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <option value="3newone" id="newsupplier">Add New Customer</option>
                                                        </select>
                                                        <input  id="company_id"  name="company_id" type="hidden" value="<?= $company_id; ?>"/>
                                                        <input  id="salesMasterId"  name="salesMasterId" type="hidden" value="<?= $this->input->get('id'); ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <div class="col-sm-4 control-label"> Date: </div>
                                                    <div class="col-sm-8 control-label" style="text-align: left">
                                                        <?= date("d-m-Y H:i:s", strtotime($salesmaster->date)) ?>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="order_no" class="col-md-4 control-label text-left">Sold By: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" value="<?= $salesmanname; ?>" readonly="" name="salesManshow" id="salesManshow">
                                                        <input type="hidden" name="salesMan" id="salesMan" value="<?= $salesmanname; ?>">
                                                    </div>
                                                </div>

                                                <?php
                                                endforeach;
                                                endif;
                                                ?>
                                            </div>

                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-2 col-md-offset-8">
                                                            <div class="pull-right">
                                                                <a class="btn btn-primary gotosecond"
                                                                   data-toggle="tab"
                                                                   href="#step2">Next <i class="fa fa-hand-o-right" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div id="step2" class="tab-pane">
                                        <div class="row">
                                            <div class="form-group col-sm-3 clear">
                                                <label for="product_name" class="col-sm-4 control-label custom">Product </label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" class="form-control" id="product">
                                                    <input type="text" class="form-control"  id="product_name" placeholder="Product Name" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <label for="unit" class="col-sm-4 control-label text-left">Unit</label>
                                                <div class="col-sm-8">
                                                    <input name="count" id="count" value="" type="hidden"/>
                                                    <input type="hidden" class="form-control" name="unit" id="unit" placeholder="Unit">
                                                    <input type="text" class="form-control"  id="unitshow" placeholder="Unit" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <label for="qtyi" class="col-sm-4 control-label text-left">Qty</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="qtyi" id="qtyi" placeholder="Qty">
                                                    <span id="qtymsg"></span>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="ratei" class="col-sm-4 control-label text-left">Sale Rate</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="ratei" id="ratei" placeholder="Rate" <?php
                                                    if ($salesedit == "0"):
                                                        echo "readonly";
                                                    endif;
                                                    ?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <div class="col-sm-12">
                                                    <?php
                                                    if ($print == "1"):
                                                        $printType = '#PrintsalesinvoicedivA4';
                                                    else:
                                                        $printType = '#PrintsalesinvoicedivPos';
                                                    endif;
                                                    ?>
                                                    <input type="hidden" name="countrowvalue" id="ccountrowvalue"/>
                                                    <button type="button" id="addpurchase" class="btn btn-default">Edit</button>
                                                    <button type="button" id="product-reset"  class="btn btn-default">Clear</button>&nbsp;
                                                    <a href="#" onclick="PrintElem('<?php echo $printType; ?>')"><button class="btn dropdown-toggle" data-toggle="dropdown">Print</button> </a>
                                                </div>
                                            </div>
                                        </div>

                                        <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Qty</th>
                                                <th>Unit</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody id="addnewrowedit">
                                            <?php
                                            if (isset($ratequalityvat) && isset($products)):
                                                $count = 0;
                                                $qtysum = 0;
                                                $finaltotalsum = 0;
                                                foreach ($ratequalityvat as $rqv):
                                                    $count = $count + 1;
                                                    ?>

                                                    <tr class="single_row" id="<?php echo $count; ?>">
                                                        <td>
                                                            <?php
                                                            //product name
                                                            echo '<input type="hidden" name="serialnumber[]" value="' . $rqv->serialNumber . '">';
                                                            echo '<input name="purchaseDetailsId[]" id="purchaseDetailsId' . $count . '" value="' . $rqv->salesDetailsId . '" type="hidden"/>';
                                                            echo '<input name="ledgerPostingId" id="ledgerPostingId" value="' . $rqv->ledgerPostingId . '" type="hidden"/>';
                                                            echo '<input name="count_product" id="count_product" value="' . $count_product . '" type="hidden"/>';
                                                            foreach ($products as $product) {
                                                                $batchid = $product->productBatchId;
                                                                $salesRate = $product->salesRate;
                                                                $productId = $product->productId;
                                                                if ($batchid == $rqv->productBatchId) {
                                                                    echo '<input name="product_id' . $count . '" id="product_id' . $count . '" value="' . $productId . '" type="hidden"/> '; //Input field
                                                                    foreach ($productinfo as $productname) {
                                                                        $prodid = $productname->productId;
                                                                        $productName = $productname->productName;
                                                                        if ($prodid == $productId) {
                                                                            echo '<span class="product_id' . $count . '">' . $productName . '</span>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            //qty
                                                            $qtysum += $rqv->qty;
                                                            echo '<input name="qty' . $count . '" id="qty' . $count . '" value="' . $rqv->qty . '" type="hidden"/>' . '<span class="qty' . $count . '">' . $rqv->qty . '</span>';  //Input field
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            //Unit name
                                                            echo '<input name="unit_id' . $count . '" id="unit_id' . $count . '" value="' . $rqv->unitId . '" type="hidden"/>';  //Input field
                                                            foreach ($unitinfo as $unit) {
                                                                $unitid = $unit->unitId;
                                                                $unitName = $unit->unitName;
                                                                if ($unitid == $rqv->unitId) {
                                                                    echo '<span class="unit_id' . $count . '">' . $unitName . '</span>';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            //rate
                                                            echo '<input name="rate' . $count . '" id="rate' . $count . '" value="' . $rqv->rate . '" type="hidden"/>' . '<span class="rate' . $count . '">' . $rqv->rate . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                        <td><?php
                                                            //Net amount per product
                                                            $qtyrate = $rqv->qty * $rqv->rate;
                                                            $grandtotal = $qtyrate;  //total amount
                                                            $finaltotalsum += $grandtotal;
                                                            echo '<span id="product_amount' . $count . '">' . number_format($grandtotal, 2) . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                    </tr>

                                                <?php
                                                endforeach;
                                            endif;
                                            ?>
                                            </tbody>
                                            <tr>
                                                <th>Total</th>
                                                <th><?php echo $qtysum; ?></th>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo $finaltotalsum; ?></th>
                                            </tr>
                                        </table>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <div class="pull-left">
                                                        <a class="btn btn-primary gotofirst"
                                                           style="margin-top: 25px;"
                                                           data-toggle="tab"
                                                           href="#step1"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Prev</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="pull-right">
                                                        <a class="btn btn-primary gotothird"
                                                           style="margin-top: 25px;"
                                                           data-toggle="tab"
                                                           href="#step3">Next <i class="fa fa-hand-o-right" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 3 -->
                                    <div id="step3" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <?php
                                                if (isset($salesmasterinfo)):
                                                    foreach ($salesmasterinfo as $salesmaster):
                                                        ?>
                                                        <div class="col-md-4">
                                                            <?php
                                                            if ($paymentinfo->paymentMode == "By Cheque"):
                                                                ?>
                                                                <div class="form-group">
                                                                    <div class="col-lg-5">  </div>
                                                                    <div class="col-lg-5">
                                                                        <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="By Cash"/> &nbsp; Cash Receipt
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-lg-5">  </div>
                                                                    <div class="col-lg-5">
                                                                        <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="By Cheque" checked/> &nbsp;  Bank
                                                                        Receipt
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="form-group">
                                                                    <div class="col-lg-5">  </div>
                                                                    <div class="col-lg-5">
                                                                        <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="By Cash" checked/> &nbsp; Cash
                                                                        Receipt
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-lg-5">  </div>
                                                                    <div class="col-lg-5">
                                                                        <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="By Cheque"/> &nbsp;  Bank Receipt
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>

                                                            <div class="form-group">
                                                                <label for="paymentMode" class="col-lg-5 col-sm-2 control-label">Cash/Bank Account</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control selectpicker" data-live-search="true" id="editpaymentMode" name="paymentMode">
                                                                        <?php
                                                                        if ($paymentinfo->paymentMode == "By Cheque"):
                                                                            foreach ($ledgerdata as $ledlist):
                                                                                $accNo = $ledlist->accNo;
                                                                                if ($paymentinfo->payledger == $ledlist->ledgerId):
                                                                                    ?>
                                                                                    <option selected value="<?= $ledlist->ledgerId; ?>"><?= $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
                                                                                <?php else:
                                                                                    ?>
                                                                                    <option value="<?= $ledlist->ledgerId; ?>"><?= $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
                                                                                <?php
                                                                                endif;
                                                                            endforeach;
                                                                            ?>
                                                                        <?php
                                                                        elseif ($paymentinfo->paymentMode == "By Cash"):
                                                                            foreach ($ledgerdatabycash as $ledlist):
                                                                                $accNo = $ledlist->accNo;
                                                                                if ($paymentinfo->payledger == $ledlist->ledgerId):
                                                                                    ?>
                                                                                    <option selected value="<?= $ledlist->ledgerId; ?>"><?= $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
                                                                                <?php else:
                                                                                    ?>
                                                                                    <option value="<?= $ledlist->ledgerId; ?>"><?= $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
                                                                                <?php
                                                                                endif;
                                                                            endforeach;
                                                                        endif;
                                                                        ?>
                                                                    </select>
                                                                    <span id="grpmsg"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="amount" class="col-lg-5 col-sm-2 control-label">Amount</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text"
                                                                           value="<?= $paymentinfo->paidamount; ?>"
                                                                           class="form-control"
                                                                           id="paidamount"
                                                                           name="paidamount"
                                                                           required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="chequeNumber" class="col-lg-5 col-sm-2 control-label">Cheque Number</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" value="<?= $paymentinfo->chequeNumber; ?>" id="chequeNumber" name="chequeNumber" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="chequeDate" class="col-lg-5 col-sm-2 control-label">Cheque Date</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text" value="<?= $paymentinfo->chequeDate; ?>" class="form-control" id="chequeDate"  name="chequeDate" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="description" class="col-lg-5 col-sm-2 control-label">Description</label>
                                                                <div class="col-lg-6">
                                                <textarea name="description"
                                                          class="form-control"
                                                          maxlength="100"
                                                          id="description"
                                                          cols="30"
                                                          rows="5"><?= $salesmaster->description; ?></textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                                <div class="col-md-2">   </div>

                                                <div class="col-md-4">
                                                    <div class="final-submit">
                                                        <button type="submit" id="addpurchase_submit"  class="btn btn-default">Update</button>
                                                        <a href="<?php echo site_url('sales/sales'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <div class="pull-left">
                                                            <a class="btn btn-primary gotosecond"
                                                               style="margin-top: 25px;"
                                                               data-toggle="tab"
                                                               href="#step2"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Prev</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                        <!--tab nav start-->
                </div>
                </div>
            </section>
            <!-- page end-->
        </section>
    </section>
</form>
<!--######################################################################## print start ###################################################################-->

<link href="<?php echo $baseurl; ?>assets/css/bootstrap_print.min.css" rel="stylesheet">

<section class="panel" style="display: none; width: 100%; font-size: 10px;" id="PrintsalesinvoicedivPos">
    <div class="col-lg-12">
        <div class="panel-body">
            <table style="font-size: 10px; width: 100%;">
                <tr>
                    <td>
                        <div class="col-lg-6">                                 
                            <div class="col-lg-12">
                                <div class="col-sm-2">
                                    <div style="text-align: center">     
                                        <img src="<?php echo $baseurl ?>assets/uploads/<?php echo $companyinfo->logo; ?>"  />
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div style="text-align:center">                        
                                        <p style="width: 100%;"><span style="font-size: 16px"><b><?php echo $companyinfo->companyName; ?></b></span><br/><?php echo $companyinfo->address; ?>
                                            <br/> <?php if ($companyinfo->mobile1 != ""): ?>Contact: <?php echo $companyinfo->mobile1; ?>, <?php
                                                echo $companyinfo->mobile2;
                                            endif;
                                            ?></p> 
                                        <?php if ($companyinfo->email != ""): ?> <p style="text-align: center"> E-mail:<?php echo $companyinfo->email; ?></p> <?php endif; ?>
                                        <div style="border: 1px solid gray; height: 1px; width: 100%"> </div>
                                        <h5>
                                            COPY OF RECEIPT
                                        </h5> 
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-sm-12">
                                <div style="text-align:left; margin-bottom: 10px;">
                                    Invoice No: <?php echo $companyinfo->invoice_prefix . $invoice; ?><br/>
                                    Customer Name: <span id="customername"> </span><br/>
                                    Sold By: <?php echo $salesmanname; ?>.<br/>
                                    Date: <?php echo $date; ?><br/>   
                                </div>                                                                                
                            </div>
                            <div class="col-sm-12">
                                <div class="adv-table">                                   
                                    <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1" style="font-size: 9px; width: 100%;">
                                        <thead>
                                            <tr>
<!--                                                <th style="text-align: center">Sl.</th>-->
                                                <th style="text-align: center">Item Description</th>
                                                <th style="text-align: center">Qty</th>                                              
                                                <th style="text-align: center">Rate</th>
                                                <th style="text-align: center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <?php
                                            if (isset($ratequalityvat) && isset($products)):
                                                $count = 0;
                                                $total = 0;
                                                foreach ($ratequalityvat as $rqv):
                                                    $count = $count + 1;
                                                    ?>
                                                    <tr class="" id="<?php echo $count; ?>">
        <!--                                                        <td style="text-align: center"><?php echo $count; ?></td>-->
                                                        <td>
                                                            <?php
                                                            //product name 
                                                            echo '<input type="hidden" name="serialnumber[]" value="' . $rqv->serialNumber . '">';
                                                            echo '<input name="purchaseDetailsId[]" id="purchaseDetailsId' . $count . '" value="' . $rqv->salesDetailsId . '" type="hidden"/>';
                                                            echo '<input name="ledgerPostingId" id="ledgerPostingId" value="' . $rqv->ledgerPostingId . '" type="hidden"/>';
                                                            echo '<input name="count_product" id="count_product" value="' . $count_product . '" type="hidden"/>';
                                                            foreach ($products as $product) {
                                                                $batchid = $product->productBatchId;
                                                                $salesRate = $product->salesRate;
                                                                $productId = $product->productId;
                                                                if ($batchid == $rqv->productBatchId) {
                                                                    echo '<input name="product_id' . $count . '" id="product_id' . $count . '" value="' . $productId . '" type="hidden"/> '; //Input field
                                                                    foreach ($productinfo as $productname) {
                                                                        $prodid = $productname->productId;
                                                                        $productName = $productname->productName;
                                                                        if ($prodid == $productId) {
                                                                            echo '<span class="product_id' . $count . '" id="product_namedata' . $count . '">' . $productName . '</span>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="text-align: center"><?php
                                                            //qty
                                                            echo '<input name="qty' . $count . '" id="qty' . $count . '" value="' . $rqv->qty . '" type="hidden"/>' . '<span class="qty' . $count . '">' . number_format($rqv->qty, 3) . '</span>';  //Input field
                                                            ?>
                                                        </td>                                                       
                                                        <td style="text-align: right"><?php
                                                            //rate
                                                            echo '<input name="rate' . $count . '" id="rate' . $count . '" value="' . $rqv->rate . '" type="hidden"/>' . '<span class="rate' . $count . '">' . $rqv->rate . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                        <td style="text-align: right"><?php
                                                            //Net amount per product
                                                            $qtyrate = $rqv->qty * $rqv->rate;
                                                            $total = $total + $qtyrate;
                                                            echo '<span id="product_amount' . $count . '">' . number_format($qtyrate, 2) . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
<!--                                                <th></th>-->
                                                <th>Total</th>
                                                <th style="text-align: center"><?php echo $qtysum; ?></th>
                                                <th></th>
                                                <th style="text-align: right"><?php echo number_format($total, 2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table style="float:right; width: 100%; font-size: 12px; font-weight: bold">     
                                        <tr>
                                            <td style="text-align:right">Sub Total: </td>
                                            <td style="text-align:right"><?php echo number_format($total, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right">Discount(-): </td>
                                            <td style="text-align:right"><?php echo number_format($discount, 2); ?></td>
                                        </tr>   
<!--                                        <tr>
                                            <td style="text-align:right">VAT 5%(+):</td>
                                            <td id="vat1" style="text-align:right"><?php //echo number_format($vat, 2);           ?></td>
                                        </tr>   -->

                                        <tr id="previous_amountrow" style="text-align:right">
                                            <td>Previous Amount:</td>
                                            <td id="previous_amount1" style="text-align:right"><?php echo $totalprevAmount; ?></td>
                                        </tr>  

                                        <?php
                                        $netamount = $totalprevAmount + $total - $discount + $vat;
                                        ?>
                                        <tr>
                                            <td style="text-align:right">Net Amount: </td>
                                            <td style="text-align:right"><?php echo number_format($netamount, 2); ?></td>
                                        </tr>  
                                        <tr>
                                            <td style="text-align:right">Customer Pay: </td>
                                            <td style="text-align:right"><?php echo number_format($netamount, 2); ?></td>
                                        </tr>  
                                        <tr>
                                            <td style="text-align:right">Returnable Amount: </td>
                                            <td style="text-align:right">0.00<td>
                                        </tr>  
                                    </table>  
                                    <table style="float:left; text-align: center; margin: 10px 5px 0px 5px; font-size: 10px">
                                        <tr>
                                            <td><?php echo $companyinfo->footer; ?></td>                                           
                                        </tr>
                                    </table>                                 
                                </div>                       
                            </div>                                           
                        </div>
                    </td>                  
                </tr>
            </table>
        </div>
    </div>
</section>

<section class="panel" style="display: none; width: 100%; font-size: 10px;" id="PrintsalesinvoicedivA4">
    <div class="col-lg-12">
        <div class="panel-body">
            <table style="font-size: 10px; width: 100%;">
                <tr>
                    <td>
                        <div class="col-lg-6">                                 
                            <div class="col-lg-12">
                                <div class="col-sm-2">
                                    <div style="text-align: center">     
                                        <img src="<?php echo $baseurl ?>assets/uploads/<?php echo $companyinfo->logo; ?>"  />
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div style="text-align:center">                        
                                        <p style="width: 100%;"><span style="font-size: 16px"><b><?php echo $companyinfo->companyName; ?></b></span><br/><?php echo $companyinfo->address; ?>
                                            <br/> <?php if ($companyinfo->mobile1 != ""): ?>Contact: <?php echo $companyinfo->mobile1; ?>, <?php
                                                echo $companyinfo->mobile2;
                                            endif;
                                            ?></p> 
                                        <?php if ($companyinfo->email != ""): ?> <p style="text-align: center"> E-mail:<?php echo $companyinfo->email; ?></p> <?php endif; ?>
                                        <div style="border: 1px solid gray; height: 1px; width: 100%"> </div>
                                        <h5>
                                            COPY OF RECEIPT
                                        </h5> 
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-sm-12">
                                <div style="text-align:left; margin-bottom: 10px;">
                                    Invoice No: <?php echo $companyinfo->invoice_prefix . $invoice; ?><br/>
                                    Customer Name: <span id="customername2"> </span><br/>
                                    Sold By: <?php echo $salesmanname; ?>.<br/>
                                    Date: <?php echo $date; ?><br/>   
                                </div>                                                                                
                            </div>
                            <div class="col-sm-12">
                                <div class="adv-table">                                   
                                    <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1" style="font-size: 9px; width: 100%;">
                                        <thead>
                                            <tr>
<!--                                                <th style="text-align: center">Sl.</th>-->
                                                <th style="text-align: center">Item Description</th>
                                                <th style="text-align: center">Qty</th>                                              
                                                <th style="text-align: center">Rate</th>
                                                <th style="text-align: center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <?php
                                            if (isset($ratequalityvat) && isset($products)):
                                                $count = 0;
                                                $total = 0;
                                                foreach ($ratequalityvat as $rqv):
                                                    $count = $count + 1;
                                                    ?>
                                                    <tr class="" id="<?php echo $count; ?>">
        <!--                                                        <td style="text-align: center"><?php echo $count; ?></td>-->
                                                        <td>
                                                            <?php
                                                            //product name 
                                                            echo '<input type="hidden" name="serialnumber[]" value="' . $rqv->serialNumber . '">';
                                                            echo '<input name="purchaseDetailsId[]" id="purchaseDetailsId' . $count . '" value="' . $rqv->salesDetailsId . '" type="hidden"/>';
                                                            echo '<input name="ledgerPostingId" id="ledgerPostingId" value="' . $rqv->ledgerPostingId . '" type="hidden"/>';
                                                            echo '<input name="count_product" id="count_product" value="' . $count_product . '" type="hidden"/>';
                                                            foreach ($products as $product) {
                                                                $batchid = $product->productBatchId;
                                                                $salesRate = $product->salesRate;
                                                                $productId = $product->productId;
                                                                if ($batchid == $rqv->productBatchId) {
                                                                    echo '<input name="product_id' . $count . '" id="product_id' . $count . '" value="' . $productId . '" type="hidden"/> '; //Input field
                                                                    foreach ($productinfo as $productname) {
                                                                        $prodid = $productname->productId;
                                                                        $productName = $productname->productName;
                                                                        if ($prodid == $productId) {
                                                                            echo '<span class="product_id' . $count . '" id="product_namedata' . $count . '">' . $productName . '</span>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="text-align: center"><?php
                                                            //qty
                                                            echo '<input name="qty' . $count . '" id="qty' . $count . '" value="' . $rqv->qty . '" type="hidden"/>' . '<span class="qty' . $count . '">' . number_format($rqv->qty, 3) . '</span>';  //Input field
                                                            ?>
                                                        </td>                                                       
                                                        <td style="text-align: right"><?php
                                                            //rate
                                                            echo '<input name="rate' . $count . '" id="rate' . $count . '" value="' . $rqv->rate . '" type="hidden"/>' . '<span class="rate' . $count . '">' . $rqv->rate . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                        <td style="text-align: right"><?php
                                                            //Net amount per product
                                                            $qtyrate = $rqv->qty * $rqv->rate;
                                                            $total = $total + $qtyrate;
                                                            echo '<span id="product_amount' . $count . '">' . number_format($qtyrate, 2) . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
<!--                                                <th></th>-->
                                                <th>Total</th>
                                                <th style="text-align: center"><?php echo $qtysum; ?></th>
                                                <th></th>
                                                <th style="text-align: right"><?php echo number_format($total, 2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table style="float:right; width: 100%; font-size: 12px; font-weight: bold">     
                                        <tr>
                                            <td style="text-align:right">Sub Total: </td>
                                            <td style="text-align:right"><?php echo number_format($total, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right">Discount(-): </td>
                                            <td style="text-align:right"><?php echo number_format($discount, 2); ?></td>
                                        </tr>   
<!--                                        <tr>
                                            <td style="text-align:right">VAT 5%(+):</td>
                                            <td id="vat1" style="text-align:right"><?php //echo number_format($vat, 2);           ?></td>
                                        </tr>   -->

                                        <tr id="previous_amountrow" style="text-align:right">
                                            <td>Previous Amount:</td>
                                            <td id="previous_amount1" style="text-align:right"><?php echo $totalprevAmount; ?></td>
                                        </tr>  

                                        <?php
                                        $netamount = $totalprevAmount + $total - $discount + $vat;
                                        ?>
                                        <tr>
                                            <td style="text-align:right">Net Amount: </td>
                                            <td style="text-align:right"><?php echo number_format($netamount, 2); ?></td>
                                        </tr>  
                                        <tr>
                                            <td style="text-align:right">Customer Pay: </td>
                                            <td style="text-align:right"><?php echo number_format($netamount, 2); ?></td>
                                        </tr>  
                                        <tr>
                                            <td style="text-align:right">Returnable Amount: </td>
                                            <td style="text-align:right">0.00<td>
                                        </tr>  
                                    </table>  
                                    <table style="float:left; text-align: center; margin: 10px 5px 0px 5px; font-size: 10px">
                                        <tr>
                                            <td><?php echo $companyinfo->footer; ?></td>                                           
                                        </tr>
                                    </table>                                 
                                </div>                       
                            </div>                                           
                        </div>
                    </td>  

                    <td>
                        <div class="col-lg-6">                                 
                            <div class="col-lg-12">
                                <div class="col-sm-2">
                                    <div style="text-align: center">     
                                        <img src="<?php echo $baseurl ?>assets/uploads/<?php echo $companyinfo->logo; ?>"  />
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div style="text-align:center">                        
                                        <p style="width: 100%;"><span style="font-size: 16px"><b><?php echo $companyinfo->companyName; ?></b></span><br/><?php echo $companyinfo->address; ?>
                                            <br/> <?php if ($companyinfo->mobile1 != ""): ?>Contact: <?php echo $companyinfo->mobile1; ?>, <?php
                                                echo $companyinfo->mobile2;
                                            endif;
                                            ?></p> 
                                        <?php if ($companyinfo->email != ""): ?> <p style="text-align: center"> E-mail:<?php echo $companyinfo->email; ?></p> <?php endif; ?>
                                        <div style="border: 1px solid gray; height: 1px; width: 100%"> </div>
                                        <h5>
                                            COPY OF RECEIPT
                                        </h5> 
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-sm-12">
                                <div style="text-align:left; margin-bottom: 10px;">
                                    Invoice No: <?php echo $companyinfo->invoice_prefix . $invoice; ?><br/>
                                    Customer Name: <span id="customername3"> </span><br/>
                                    Sold By: <?php echo $salesmanname; ?>.<br/>
                                    Date: <?php echo $date; ?><br/>   
                                </div>                                                                                
                            </div>
                            <div class="col-sm-12">
                                <div class="adv-table">                                   
                                    <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1" style="font-size: 9px; width: 100%;">
                                        <thead>
                                            <tr>
<!--                                                <th style="text-align: center">Sl.</th>-->
                                                <th style="text-align: center">Item Description</th>
                                                <th style="text-align: center">Qty</th>                                              
                                                <th style="text-align: center">Rate</th>
                                                <th style="text-align: center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="">
                                            <?php
                                            if (isset($ratequalityvat) && isset($products)):
                                                $count = 0;
                                                $total = 0;
                                                foreach ($ratequalityvat as $rqv):
                                                    $count = $count + 1;
                                                    ?>
                                                    <tr class="" id="<?php echo $count; ?>">
        <!--                                                        <td style="text-align: center"><?php echo $count; ?></td>-->
                                                        <td>
                                                            <?php
                                                            //product name 
                                                            echo '<input type="hidden" name="serialnumber[]" value="' . $rqv->serialNumber . '">';
                                                            echo '<input name="purchaseDetailsId[]" id="purchaseDetailsId' . $count . '" value="' . $rqv->salesDetailsId . '" type="hidden"/>';
                                                            echo '<input name="ledgerPostingId" id="ledgerPostingId" value="' . $rqv->ledgerPostingId . '" type="hidden"/>';
                                                            echo '<input name="count_product" id="count_product" value="' . $count_product . '" type="hidden"/>';
                                                            foreach ($products as $product) {
                                                                $batchid = $product->productBatchId;
                                                                $salesRate = $product->salesRate;
                                                                $productId = $product->productId;
                                                                if ($batchid == $rqv->productBatchId) {
                                                                    echo '<input name="product_id' . $count . '" id="product_id' . $count . '" value="' . $productId . '" type="hidden"/> '; //Input field
                                                                    foreach ($productinfo as $productname) {
                                                                        $prodid = $productname->productId;
                                                                        $productName = $productname->productName;
                                                                        if ($prodid == $productId) {
                                                                            echo '<span class="product_id' . $count . '" id="product_namedata' . $count . '">' . $productName . '</span>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="text-align: center"><?php
                                                            //qty
                                                            echo '<input name="qty' . $count . '" id="qty' . $count . '" value="' . $rqv->qty . '" type="hidden"/>' . '<span class="qty' . $count . '">' . number_format($rqv->qty, 3) . '</span>';  //Input field
                                                            ?>
                                                        </td>                                                       
                                                        <td style="text-align: right"><?php
                                                            //rate
                                                            echo '<input name="rate' . $count . '" id="rate' . $count . '" value="' . $rqv->rate . '" type="hidden"/>' . '<span class="rate' . $count . '">' . $rqv->rate . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                        <td style="text-align: right"><?php
                                                            //Net amount per product
                                                            $qtyrate = $rqv->qty * $rqv->rate;
                                                            $total = $total + $qtyrate;
                                                            echo '<span id="product_amount' . $count . '">' . number_format($qtyrate, 2) . '</span>'; //Input field
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
<!--                                                <th></th>-->
                                                <th>Total</th>
                                                <th style="text-align: center"><?php echo $qtysum; ?></th>
                                                <th></th>
                                                <th style="text-align: right"><?php echo number_format($total, 2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table style="float:right; width: 100%; font-size: 12px; font-weight: bold">     
                                        <tr>
                                            <td style="text-align:right">Sub Total: </td>
                                            <td style="text-align:right"><?php echo number_format($total, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right">Discount(-): </td>
                                            <td style="text-align:right"><?php echo number_format($discount, 2); ?></td>
                                        </tr>   
<!--                                        <tr>
                                            <td style="text-align:right">VAT 5%(+):</td>
                                            <td id="vat1" style="text-align:right"><?php //echo number_format($vat, 2);           ?></td>
                                        </tr>   -->

                                        <tr id="previous_amountrow" style="text-align:right">
                                            <td>Previous Amount:</td>
                                            <td id="previous_amount1" style="text-align:right"><?php echo $totalprevAmount; ?></td>
                                        </tr>  

                                        <?php
                                        $netamount = $totalprevAmount + $total - $discount + $vat;
                                        ?>
                                        <tr>
                                            <td style="text-align:right">Net Amount: </td>
                                            <td style="text-align:right"><?php echo number_format($netamount, 2); ?></td>
                                        </tr>  
                                        <tr>
                                            <td style="text-align:right">Customer Pay: </td>
                                            <td style="text-align:right"><?php echo number_format($netamount, 2); ?></td>
                                        </tr>  
                                        <tr>
                                            <td style="text-align:right">Returnable Amount: </td>
                                            <td style="text-align:right">0.00<td>
                                        </tr>  
                                    </table>  
                                    <table style="float:left; text-align: center; margin: 10px 5px 0px 5px; font-size: 10px">
                                        <tr>
                                            <td><?php echo $companyinfo->footer; ?></td>                                           
                                        </tr>
                                    </table>                                 
                                </div>                       
                            </div>                                           
                        </div>
                    </td> 
                </tr>
            </table>
        </div>
    </div>
</section>

<!--################################################################### /end print #####################################################################-->

<script>
    var print = "<?php echo $print; ?>";
    function PrintElem(elem) {
        var billto = $("#corparty_account option:selected").text();
        var customername = "";
        if (billto == "Cash Account") {
            customername = "Cash Account";
            $("#previous_amountrow").hide();
        } else {
            var billtosplit = billto.split('-');
            customername = billtosplit[1];
            $("#previous_amountrow").show();
        }
        $("#customername").text(customername);
        $("#customername2").text(customername);
        $("#customername3").text(customername);

        Popup(jQuery(elem).html());
    }

    function Popup(data) {
        var mywindow = window.open('', 'my div', ''); //height=842,width=1340
        mywindow.document.write('<html><head><title></title>');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/bootstrap_print.min.css" type="text/css" />');
        if (print == "1") {
            mywindow.document.write('<style type="text/css">body{ font-size:12px;} </style></head><body>');
        } else {
            mywindow.document.write('<style type="text/css">@page {size:portrait;} body{ font-size:12px;} </style></head><body>');
        }

        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
      setTimeout(function () {
            mywindow.print();
        }, 10);
    }
</script>

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
                                        <select name="dr_cr" id="dr_cr1" class="customer_debit pull-right selectpicker" data-live-search="true">
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

<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var userrole = "<?php echo $this->sessiondata['userrole']; ?>";
        if (userrole == 's' || userrole == 'r') {
            $("#submitaddcustomer").prop("disabled", true);
            $("#addpurchase_submit").prop("disabled", true);
            $("#addpurchase").prop("disabled", true);
        }
    });
</script>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";

        if (fyearstatus == '0') {
            $("#addpurchase").prop("disabled", true);
            $("#addpurchase_submit").prop("disabled", true);
            
        }
    });

$('.gotofirst').click(function(e) {
    e.preventDefault();
    $('#editsalestab a[href="#step1"]').tab('show');
});

$('.gotothird').click(function(e) {
    e.preventDefault();
    $('#editsalestab a[href="#step3"]').tab('show');
});

$('.gotosecond').click(function(e) {
    e.preventDefault();
    $('#editsalestab a[href="#step2"]').tab('show');
});
</script>