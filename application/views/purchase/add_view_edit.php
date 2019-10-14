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
    .panel-heading{
        background-color:#da952e;
    }
    .adv-table table.display thead th, table.display tfoot th{
        background-color:#da952e;
    }
</style>
<form action="<?php echo site_url('purchase/purchase/edit'); ?>" method="post" class="form-horizontal custom-form" role="form">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <section class="panel">
                <header class="panel-heading">
                    Edit  Purchase Information
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <div class="clearfix">
                            <div class="btn-group pull-right">
                                <br/>                   
                            </div>
                        </div>
                        <?php
                        if (isset($purchasemasterinfo)):
                            foreach ($purchasemasterinfo as $purchasemaster):
                                ?>
                                <div class="row purchase-top">

                                    <div class="form-group col-sm-4">
                                        <label for="corparty_account" class="col-sm-4 control-label custom">Cash/Party </label>
                                        <div class="col-sm-8 myselect">
                                            <select class="form-control selectpicker" data-live-search="true" name="corparty_account" id="corparty_account">
                                                <?php
                                                if (isset($supplierinfo1)) {
                                                    foreach ($supplierinfo1 as $supplier) {
                                                        if ($supplier->ledgerId == $purchasemaster->ledgerId) {
                                                            echo '<option value="' . $supplier->ledgerId . '" selected>' . $supplier->accNo . ' - ' . $supplier->acccountLedgerName . '</option>';
                                                        }
                                                    }
                                                }
                                                if ($purchasemaster->ledgerId == 2) {
                                                    echo '<option value="2" selected>Cash Account</option>';
                                                }
                                                if ($purchasemaster->ledgerId != 2) {
                                                    echo '<option value="2">Cash Account</option>';
                                                }
                                                ?>
                                                <?php
                                                if (isset($supplierinfo1)) {
                                                    foreach ($supplierinfo1 as $supplier) {
                                                        if ($supplier->ledgerId != $purchasemaster->ledgerId) {
                                                            echo '<option value="' . $supplier->ledgerId . '">' . $supplier->accNo . ' - ' . $supplier->acccountLedgerName . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                                <option value="3newone" id="newsupplier">Add New Supplier</option>
                                            </select>
                                            <input id="company_id" name="company_id" type="hidden" value="<?= $company_id; ?>"/>
                                            <input id="purchaseMasterId"  name="purchaseMasterId" type="hidden" value="<?= $this->input->get('id'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="invoice_data" class="col-sm-4 control-label text-left"> Date</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="invoice_date" value="<?php echo $purchasemaster->date; ?>" id="dailysearchfrom"/>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label for="invoive_number" class="col-sm-4 control-label text-left">Invoice Number</label>
                                        <div class="col-sm-8">
                                            <input type="text"
                                                   class="form-control"
                                                   name="invoive_number"
                                                   id="invoive_number"
                                                   placeholder="Invoice Number"
                                                   required
                                                   disabled
                                                   value="<?= $purchasemaster->purchaseInvoiceNo; ?>">
                                        </div>
                                    </div>

                                <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <hr/>
                        <!--       ============================ PART 2====================================================-->
                        <div class="row">
                            <div class="form-group col-sm-3 clear">
                                <label for="product_name" class="col-sm-4 control-label custom">Product </label>
                                <div class="col-sm-8">
                                    <input type="hidden" class="form-control" id="product" >
                                    <input type="text" class="form-control"  id="product_name" placeholder="Product Name" readonly>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="unit" class="col-sm-4 control-label text-left">Unit</label>
                                <div class="col-sm-8">
                                    <input name="count" id="count" value="" type="hidden"/>
                                    <input type="hidden" class="form-control" name="unit" id="unit" placeholder="Unit">
                                    <input type="text" class="form-control"  id="unitshow" placeholder="Unit" readonly>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="qtyi" class="col-sm-4 control-label text-left">Qty</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="qtyi" id="qtyi" placeholder="Qty">
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="freeqtyi" class="col-sm-4 control-label text-left">Free Qty</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="freeqtyi" id="freeqtyi" placeholder="Free Qty">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label for="ratei" class="col-sm-4 control-label text-left custom">Rate</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="ratei" id="ratei" placeholder="Rate">
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="sale_ratei" class="col-sm-4 control-label ">Sale Rate</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="sale_ratei" id="sale_ratei" placeholder="Sale Rate">
                                </div>
                            </div>

                            <?php if ($serial == '1'): ?>
                            <!-- Serial Number -->
                            <div class="form-group col-md-3">
                                <label for="serialnumberedit" class="col-md-4 control-label ">Serial</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="serialnumberedit" id="serialnumberedit" placeholder="Serial">
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-sm-3">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-sm-10">
                                    <button type="button" id="addpurchase" class="btn btn-default">Edit</button>
                                    <button type="button" id="product-reset"  class="btn btn-default">Clear</button>
                                </div>
                            </div>
                            <!--     ================================   END 2nd part input=========================-->
                        </div>


                        <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Free Qty</th>
                                    <th>Unit</th>
                                    <?php if ($serial == '1'): ?>
                                        <th>Serial</th>
                                    <?php endif; ?>
                                    <th>Rate</th>
                                    <th>Sale Rate</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="addnewrowedit">
                                <?php
                                if (isset($ratequalityvat)):
                                    $count = 0;
                                    foreach ($ratequalityvat as $rqv):
                                        $count = $count + 1;
                                        ?>

                                        <tr class="single_row" id="<?= $count; ?>">
                                            <td>
                                                <input type="checkbox" checked name="productno<?= $rqv->productId ?>" id="productno<?= $rqv->productId ?>" value="<?= $rqv->productId ?>" />
                                            </td>
                                            <td>
                                                <?php
                                                //product name
                                                echo '<input type="hidden" name="serialnumber[]" value="' . $rqv->serialNumber . '">';
                                                echo '<input type="hidden" name="ledgerPostingId" value="' . $rqv->ledgerPostingId . '">';
                                                echo '<input name="purchaseDetailsId[]" id="purchaseDetailsId' . $count . '" value="' . $rqv->purchaseDetailsId . '" type="hidden"/>';
                                                echo '<input name="count_product" id="count_product" value="' . $count_product . '" type="hidden"/>';

                                                echo '<input name="product_id' . $count . '" id="product_id' . $count . '" value="' . $rqv->productId . '" type="hidden"/> '; //Input field
                                                echo '<span class="product_id' . $count . '">' . $rqv->productName . '</span>';

                                                ?>
                                            </td>
                                            <td><?php
                                                //qty
                                                echo '<input type="hidden" name="qty' . $count . '" id="qty' . $count . '" value="' . $rqv->qty . '"/>' . '<span class="qty' . $count . '">' . $rqv->qty . '</span>';  //Input field
                                                ?>
                                            </td>
                                            <td><?php
                                                //free qty
                                                echo '<input type="hidden" name="freeqty' . $count . '" id="freeqty'.$count.'" value="' . $rqv->freeQty . '" />' . '<span class="freeqty' . $count . '">' . $rqv->freeQty . '</span>';  //Input field
                                                ?>
                                            </td>
                                            <td><?php
                                                //Unit name
                                                echo '<input type="hidden" name="unit_id' . $count . '" id="unit_id' . $count . '" value="' . $rqv->unitId . '" />';  //Input field
                                                echo '<span class="unit_id' . $count . '">' . $rqv->unitName . '</span>';
                                                ?>
                                            </td>
                                            <?php if ($serial == '1'): ?>
                                            <td>
                                                <input type="hidden" name="serial<?= $count ?>" id="serial<?= $count ?>" value="<?= $rqv->productserial; ?>" />
                                                <span id="serial_number<?= $count ?>"><?= $rqv->productserial; ?></span>
                                            </td>
                                            <?php endif; ?>
                                            <td><?php
                                                //rate
                                                echo '<input type="hidden" name="rate' . $count . '" id="rate' . $count . '" value="' . $rqv->rate . '" />' . '<span class="rate' . $count . '">' . $rqv->rate . '</span>'; //Input field
                                                ?>
                                            </td>
                                            <td><?php
                                                //salerate
                                                 echo '<input type="hidden" name="salerate[]" id="salerate' . $count . '" value="' . $rqv->salesRate . '"/>' . '<span class="salerate' . $count . '">' . $rqv->salesRate  . '</span>'; //Input field

                                                ?>
                                            </td>
                                            <td><?php
                                                //Net amount per product
                                                $qtyrate = $rqv->qty * $rqv->rate;
                                                $grandtotal = $qtyrate;  //total amount
                                                echo '<span id="product_amount' . $count . '">' . number_format($grandtotal,2) . '</span>'; //Input field
                                                ?>
                                            </td>
                                        </tr>

                                        <?php
                                    endforeach;
                                endif;
                                ?>


                            </tbody>
                        </table>

                        <div class="title elipsis pull-right topnegativemargin8">
                            <button type="button"
                                    onclick="printSticker()"
                                    class="btn btn-3d btn-sm btn-reveal btn-warning">
                                <i class="fa fa-bank"></i>
                                <span>Print Sticker</span>
                            </button>
                        </div>

                        <br /><br />

                        <div class="panel-body">
                            <div class="row">
                                <?php
                                if (isset($purchasemasterinfo)):
                                    foreach ($purchasemasterinfo as $purchasemaster):
                                        ?>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="description" class="col-sm-3 control-label">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea name="description"
                                                              class="form-control"
                                                              id="description"
                                                              cols="30"
                                                              rows="5"><?= $purchasemaster->description; ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                                <div class="col-sm-6 col-sm-offset-2">
                                    <ul class="unstyled amounts">
                                        <li class="text-center"><strong>Total Amount : </strong><span id="total_amout" class="align-right "> 0.00 </span> <input name="total_amout" class="total_amout" type="hidden"/></li>
                                        <li style="display: none" class="text-center"><strong>Grand Total :</strong> <span  id="grandtotal" class="align-right ">0.00</span><input name="grandtotal" class="grandtotal" type="hidden"/></li>
                                        <?php
                                        if (isset($purchasemasterinfo)):
                                            foreach ($purchasemasterinfo as $purchasemaster):
                                                ?>
                                                <li class="text-center"><strong>Discount :</strong> <span class="align-right ">
                                                        <input type="text" name="discount" id="discount" style="width: 40px" value="<?php echo $purchasemaster->billDiscount; ?>"/></span></li>
                                                         <li class="text-center"><strong>Other Cost :</strong> <span class="align-right ">
                                                    <input type="text" name="transport" id="transport" style="width: 40px" value="<?php echo $purchasemaster->additionalCost; ?>"/></span></li>
                                                <li class="text-center"><strong>Net Amount :</strong> <span id="net_amout" class="align-right "><?php echo $purchasemaster->amount; ?></span><input name="net_amout" class="net_amout" value="<?php echo $purchasemaster->amount; ?>" type="hidden"/></li>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </ul>
                                    <div class="final-submit pull-right">
                                        <button type="submit" id="updatepurchase" class="btn btn-default">Update</button>
                                        <a href="<?= site_url('purchase/purchase'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
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
                $("#updatepurchase").prop("disabled", true);
                $("#addpurchase").prop("disabled", true);
            }
        });

    function printSticker() {
        var mywindow = window.open('', 'mydiv', ''); //height=842,width=1340
        mywindow.document.write('<html>' +
            '<head>' +
            '<title></title>' +
             '<link rel="stylesheet" href="<?= base_url("assets/css/bootstrap.min.css"); ?>" type="text/css" />' +
        '<style type="text/css">' +
            'body{ font-size:11px; width: 320px;}' +
            '</style>' +
            '</head>' +
            '<body>' +
            '<center>');

        <?php if (sizeof($ratequalityvat)): ?>
        <?php foreach ($ratequalityvat as $i => $rqv): ?>
        if ($('#productno<?= $rqv->productId ?>').is(':checked')) {
            <?php for ($i = 0; $i < ($rqv->qty + $rqv->freeQty + 2); ++$i): ?>
            <?php if ($i % 2 == 0): ?>
            mywindow.document.write('<div class="sticker_div">');
            <?php endif; ?>

            <?php if (($i + 1) % 2 != 0): ?>
            mywindow.document.write('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
            <?php endif; ?>

            mywindow.document.write('<img alt="<?= $rqv->productName; ?>" src="<?= base_url("barcode.php?text=" . $rqv->productName . "&print=true&codetype=Code25&sizefactor=2") ?>" />');

            <?php if (($i + 1) % 2 == 0): ?>
            mywindow.document.write('</div><div class="page-break" style="page-break-after: always;"></div>');
            <?php endif; ?>

            <?php endfor; ?>
        }
        mywindow.document.write('<div class="page-break" style="page-break-after: always;"></div>');
        <?php endforeach; ?>
        mywindow.document.write('</div><div class="page-break" style="page-break-after: always;"></div>');
        <?php endif; ?>

        mywindow.document.write('</center>' +
            '</body>' +
            '</html>');
        mywindow.document.close();

        setTimeout(function () {
            mywindow.print();
        }, 100);
    }
</script>
