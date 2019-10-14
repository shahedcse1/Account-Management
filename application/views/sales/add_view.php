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
        padding: 10px;
        width: 98%;
    
      .panel-heading{
        background-color:#3ab932;
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
     
    .purchase-top .form-group{
        margin-bottom: -5px;
    }

    .edit-field{
        cursor: pointer;
    }
    .label_radio {
        margin-right: 10px;
        position: relative;
        top: -10px;
    }
</style>

<form action="<?= site_url('sales/sales/add'); ?>"
      method="post"
      id="frm"
      class="form-horizontal custom-form"
      role="form" >

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">

            <!-- page start-->
            <section class="panel">
                <header class="panel-heading">
                    Add  Sales Information
                </header>

                <div class="panel-body">
                    <div class="adv-table">

                        <div class="row">
                            <div class="col-md-4 col-md-offset-8">
                                <ul class="amounts">
                                    <li><strong class="col-lg-5">Total Amount: </strong><span id="total_amout" class="align-right"> 0.00 </span> <input name="total_amout" class="total_amout" value="0" type="hidden"/></li>
                                    <li style="display: none" class="text-center"><strong>Grand Total :</strong> <span  id="grandtotal" class="align-right ">0.00</span><input name="grandtotal" class="grandtotal" type="hidden"/></li>
                                    <li><strong class="col-lg-5">Discount:</strong><span class="align-right">
                                            <input type="text" name="discountpercantage" id="discountpercantage" onkeyup="maxValue(this.value);"  style="width: 40px" value="00"/>% &nbsp;
                                            <input type="text" name="discount" id="discount" style="width: 40px" value="00"/></span><span id="discountlimit" class="col-lg-offset-5"></span> </li>
                                    <li><strong class="col-lg-5">VAT 5%(+):</strong> <span id="vatspan" class="align-right"> 0.00 </span>
                                        <!--                                                <input type="text" name="vatpercantage" id="vatpercantage" style="width: 40px" value="00"/>% &nbsp;-->
                                        <input type="hidden" name="vat" id="vat" style="width: 40px" value="00"/></li>
                                    <!--    <li><strong class="col-lg-5">Transport Cost:</strong> <span class="align-right "> -->
                                    <input type="hidden" name="transport" id="transport" style="width: 40px" value="00"/> <!-- </span></li> -->
                                    <li><strong class="col-lg-5">Previous Amount: </strong><span id="previous_amountspan" class="align-right"> 0.00 </span> <input name="previous_amount" class="previous_amount" value="0.00" type="hidden"/></li>
                                    <li><strong class="col-lg-5">Net Amount:</strong> <span id="net_amout" class="align-right ">0.00</span><input name="net_amout" class="net_amout" type="hidden"/><input name="count_product" class="count_product" type="hidden"/></li>
                                    <li><strong class="col-lg-5">Customer Pay:</strong> <span class="align-right "><input type="text"
                                                                                                                          onkeypress="return pressenter(event)"
                                                                                                                          style="width: 100px"
                                                                                                                          class="form-control"
                                                                                                                          id="paidamount"
                                                                                                                          name="paidamount"> </span></li>
                                    <li><strong class="col-lg-5">Change Amount:</strong> <span id="change_amount">0.00</span></li>
                                </ul>
                            </div>
                        </div>

                        <!--tab nav start-->
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs" id="addsalestab">
                                    <li class="active">
                                        <a data-toggle="tab" href="#step1">Step 1</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#step2" id="steptwo">Step 2</a>
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
                                            <div class="row purchase-top" style="padding: 25px 0;">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <div class="col-md-2 col-md-offset-2">
                                                            Bill to
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="radio">
                                                                <label><input type="radio" name="membertype" value="1" checked>General</label>
                                                            </div>
                                                            <div class="radio">
                                                                <label><input type="radio" name="membertype" value="2" >Member</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 myselect" id="memberNameDiv" style="display: none">
                                                            <select class="form-control selectpicker"
                                                                    data-live-search="true"
                                                                    name=""
                                                                    id="acshaccount"
                                                                    onchange="getCurrentBalance(this.value)">
                                                                <option value="">select</option>
                                                            </select>
                                                            <input  id="company_id"  name="company_id" type="hidden" value="<?= $company_id; ?>"/>
                                                            <input  id="corparty_account" value="2"  name="corparty_account" type="hidden"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if ($SoldBy == 1): ?>
                                                    <div class="form-group col-md-3">
                                                        <label for="sales_man" class="col-md-4 control-label text-left custom">Sold By</label>
                                                        <?php if ($userrole != 's'): ?>
                                                            <div class="col-md-8 myselect">
                                                                <select class="form-control selectpicker" required="" data-live-search="true" name="salesMan" id="salesMan" >
                                                                    <option value="salesmanname">select</option>
                                                                    <?php
                                                                    if (isset($salesmaninfo)) {
                                                                        foreach ($salesmaninfo as $datarow) {
                                                                            echo '<option value="' . $datarow->username . '">' . $datarow->username . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="salesManshow" id="salesManshow" value="<?php echo $username; ?>" readonly>
                                                                <input type="hidden" name="salesMan" id="salesMan" value="<?php echo $username; ?>">
                                                            </div>
                                                        <?php endif;
                                                        ?>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="hidden" name="salesMan" id="salesMan" value="<?php echo $username; ?>">
                                                <?php endif; ?>


                                                <div class="form-group col-md-1">
                                                    <div class="col-md-8">
                                                        <input type="hidden" name="dbinvoiceno" id="dbinvoiceno" value="<?php echo $dbinvoiceno; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-2 col-md-offset-8">
                                                            <div class="pull-right">
                                                                <button class="btn btn-primary gotosecond"
                                                                   id="secondtab">Next <i class="fa fa-hand-o-right" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div id="step2" class="tab-pane">
                                        <div class="row" style="padding: 25px 0;">

                                            <?php if (!$barcodeOnSales): ?>
                                            <div class="form-group col-md-3 clear">
                                                <label for="product_name" class="col-md-4 control-label custom">Product </label>
                                                <div class="col-md-8 myselect">
                                                    <select class="form-control TabOnEnter <?= $enablesearch ? 'selectpicker' : '' ?>"
                                                            data-live-search="true"
                                                            name="product_name"
                                                            tabindex="1"
                                                            id="product_name"
                                                            autofocus>
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="unit" class="col-md-4 control-label text-left">Unit</label>
                                                <div class="col-md-8">
                                                    <input type="hidden" class="form-control" name="unit" id="unit" placeholder="Unit">
                                                    <input type="text" onkeypress="return pressenter(event)" class="form-control"  id="unitshow" placeholder="Unit" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="qty" class="col-md-4 control-label text-left">Qty</label>
                                                <div class="col-md-8">
                                                    <input type="text"
                                                           class="form-control TabOnEnter"
                                                           onkeypress="return pressenter(event)"
                                                           name="qty"
                                                           id="qty"
                                                           placeholder="Qty"
                                                           tabindex="2">
                                                    <span id="qtymsg"></span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="rate" class="col-md-4 control-label">Sale Rate</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" onkeypress="return presAddButton(event)" name="rate" id="rate" placeholder="Sale Rate" tabindex="3" <?php
                                                    if ($salesedit == "0"):
                                                        echo "disabled";
                                                    endif;
                                                    ?>>

                                                </div>
                                            </div>
                                            <div class="form-group  col-md-2 pull-right">
                                                <div class="col-md-12">
                                                    <button type="button" id="addpurchase" class="btn btn-default">Add</button>
                                                    <button type="button" id="product-reset" class="btn btn-default">Clear</button>
                                                </div>
                                            </div>
                                            <?php else: ?>

                                                <div class="form-group col-md-3 clear">
                                                    <label for="product_name" class="col-md-4 control-label custom">Product </label>
                                                    <div class="col-md-8 myselect">
                                                        <select class="form-control TabOnEnter <?php
                                                        if ($enablesearch): echo 'selectpicker';
                                                        endif;
                                                        ?>" data-live-search="true"
                                                                name="product_name"
                                                                tabindex="1"
                                                                id="product_name_barcode"
                                                                autofocus>
                                                            <option value="">Select One</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            <?php endif; ?>
                                        </div>

                                        <table class="display table table-bordered table-striped " id="cloudAccounting1">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product Name</th>
                                                <th>Qty</th>
                                                <th>Unit</th>
                                                <th>Sale Rate</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody id="addnewrow">
                                            </tbody>
                                            <tr>
                                                <th></th>
                                                <th>Total</th>
                                                <th id="viewtotalqty">  </th>
                                                <th></th>
                                                <th></th>
                                                <th id="viewtotalamount">  </th>
                                            </tr>
                                        </table>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <div class="pull-left">
                                                        <button class="btn btn-primary gotofirst"
                                                           style="margin-top: 25px;"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Prev</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="pull-right">
                                                        <button class="btn btn-primary gotothird"
                                                           style="margin-top: 25px;">Next <i class="fa fa-hand-o-right" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 3 -->
                                    <div id="step3" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <div class="col-lg-4 col-lg-offset-2">
                                                            <label for="optionsRadios1">
                                                                <input type="radio"
                                                                       class="radiobutton"
                                                                       name="optionsRadios"
                                                                       id="optionsRadios1"
                                                                       value="By Cash"/> &nbsp; Cash Receipt
                                                            </label>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-lg-4 col-lg-offset-2">
                                                            <label for="optionsRadios2">
                                                                <input type="radio"
                                                                       class="radiobutton"
                                                                       name="optionsRadios"
                                                                       id="optionsRadios2"
                                                                       value="By Cheque"/> &nbsp;  Bank Receipt
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="bankaccdiv" style="display: none">
                                                        <label for="paymentMode" class="col-sm-2 control-label">Cash/Bank Account</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control"
                                                                    id="paymentMode"
                                                                    name="paymentMode"
                                                                    data-live-search="true"></select>
                                                            <span id="grpmsg"></span>
                                                        </div>

                                                    </div>

                                                    <div class="form-group" id="chequenodiv" style="display: none">
                                                        <label for="chequeNumber" class="col-sm-2 control-label">Cheque/Card/Mobile Number</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                   onkeypress="return pressenter(event)"
                                                                   class="form-control"
                                                                   id="chequeNumber"
                                                                   name="chequeNumber" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="chequedatediv" style="display: none">
                                                        <label for="chequeDate" class="col-sm-2 control-label">Cheque Date</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                   onkeypress="return pressenter(event)"
                                                                   class="form-control"
                                                                   id="chequeDate"
                                                                   name="chequeDate" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="descriptiondiv" style="display: none">
                                                        <label for="description" class="col-sm-2 control-label">Description</label>
                                                        <div class="col-lg-4">
                                                            <textarea maxlength="100"
                                                                      class="form-control"
                                                                      name="description"
                                                                      id="description"
                                                                      cols="30"
                                                                      rows="5"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="final-submit pull-right">
                                                        <?php
                                                        if ($print == "1"):
                                                            $printType = '#PrintsalesinvoicedivA4';
                                                        else:
                                                            $printType = '#PrintsalesinvoicedivPos';
                                                        endif;
                                                        ?>
                                                        <button type="submit" id="addpurchase_submit_print"  onclick="return  PrintElem('<?= $printType; ?>')" class="btn btn-default">Save & Print</button>
                                                        <button  type="submit" id="addpurchase_submit" class="btn btn-default">Save</button>
                                                        <div id="showpaymentvoutersubmit" class="btn btn-default">Save</div>

                                                        <a href="<?= site_url('sales/sales'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <div class="pull-left">
                                                            <button class="btn btn-primary gotosecond"
                                                               style="margin-top: 25px;"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Prev</button>
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
<!--main content end-->

<link href="<?php echo $baseurl; ?>assets/css/bootstrap_print.min.css" rel="stylesheet">


<section class="panel" style="display: none; font-size: 10px; width: 100%;" id="PrintsalesinvoicedivPos">   
    <div class="col-lg-12">
        <div class="panel-body"> 
            <table style="font-size: 10px;  width: 100%;">
                <tr>
                    <td>
                        <div class="col-lg-6">                    
                            <div class="col-lg-12">
                                <div class="col-sm-2" style="text-align: center">
                                    <img src="<?php echo $baseurl ?>assets/uploads/<?php echo $companyinfo->logo; ?>" />
                                </div>
                                <div class="col-sm-10">
                                    <div style="text-align: center">                        
                                        <p><span style="font-size: 20px"><b><?php echo $companyinfo->companyName; ?></b></span><br/><?php echo $companyinfo->address; ?>
                                            <br/> <?php if ($companyinfo->mobile1 != ""): ?>Contact: <?php echo $companyinfo->mobile1; ?>,<?php echo $companyinfo->mobile2; ?>. <?php endif;
                                        ?> </p>
                                        <?php if ($companyinfo->email != ""): ?> <p style="text-align: center"> E-mail:<?php echo $companyinfo->email; ?></p> <?php endif; ?>
                                    </div>
                                    <div style="border: 1px solid gray; height: 1px;"> </div>
                                    <div style="text-align: center">
                                        <h5>
                                            COPY OF RECEIPT
                                        </h5>                                
                                    </div> 
                                </div>                                
                            </div>
                            <div class="col-lg-12">
                                <div style="float: left">
                                    Invoice No: <?php echo $companyinfo->invoice_prefix; ?><span id="invoiceno1"> </span><br/>
                                    Customer Name: <span id="customername"> </span><br/>
                                    Sold By: <span id="salesmanname1"></span><br/>
                                    Date: <span id="salesdate1"> <?php echo date("F j, Y, g:i a"); ?> </span><br/><br/>
                                    <input type="hidden" name="totalprevAmount" id="totalprevAmount" />
                                </div>                                                       
                            </div>
                            <div class="col-lg-12">
                                <div class="adv-table">                                   
                                    <table class="display table table-bordered table-striped edit-table" id="cloudAccounting1" style="font-size: 9px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Item Description</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Rate</th>
                                                <th class="text-center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addprintrowoffice">                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th style="text-align: center" id="totalqty1"> </th>
                                                <th></th>
                                                <th id="netvalues1" style="text-align: right"> 0.00 </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table style="float: right; text-align:right; width:100%; font-size: 12px; font-weight: bold">                                       
                                        <tr>
                                            <td>Sub Total: </td>
                                            <td id="invoiceamount1" style="text-align:right">0.00</td>
                                        </tr>                                      
                                        <tr>
                                            <td>Discount(-):</td>
                                            <td id="discount1" style="text-align:right">0.00</td>
                                        </tr>    

                                        <tr id="previous_amountrow">
                                            <td>Previous Amount:</td>
                                            <td id="previous_amount1" style="text-align:right">0.00</td>
                                        </tr>   
                                        <tr>
                                            <td>Net Amount:</td>
                                            <td id="netpayableamount1">0.00</td>
                                        </tr>  
                                        <tr>
                                            <td id="paidamount1text">Customer Pay: </td>
                                            <td id="paidamount1" style="text-align:right"> </td>
                                        </tr>    
                                        <tr>
                                            <td>Change:</td>
                                            <td id="returnableamount1">0.00</td>
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

<section class="panel" style="display: none; font-size: 10px; width: 100%;" id="PrintsalesinvoicedivA4">   
    <div class="col-lg-12">
        <div class="panel-body"> 
            <table style="font-size: 10px;  width: 100%;">
                <tr>
                    <td>
                        <div class="col-lg-6">                    
                            <div class="col-lg-12">
                                <div class="col-sm-2" style="text-align: center">
                                    <img src="<?php echo $baseurl ?>assets/uploads/<?php echo $companyinfo->logo; ?>" />
                                </div>
                                <div class="col-sm-10">
                                    <div style="text-align: center">                        
                                        <p><span style="font-size: 20px"><b><?php echo $companyinfo->companyName; ?></b></span><br/><?php echo $companyinfo->address; ?>
                                            <br/> <?php if ($companyinfo->mobile1 != ""): ?>Contact: <?php echo $companyinfo->mobile1; ?>,<?php echo $companyinfo->mobile2; ?>. <?php endif;
                                        ?> </p>
                                        <?php if ($companyinfo->email != ""): ?> <p style="text-align: center"> E-mail:<?php echo $companyinfo->email; ?></p> <?php endif; ?>
                                    </div>
                                    <div style="border: 1px solid gray; height: 1px;"> </div>
                                    <div style="text-align: center">
                                        <h5>
                                            COPY OF RECEIPT
                                        </h5>                                
                                    </div> 
                                </div>                                
                            </div>
                            <div class="col-lg-12">
                                <div style="float: left">
                                    Invoice No: <?php echo $companyinfo->invoice_prefix; ?><span id="invoiceno2"> </span><br/>
                                    Customer Name: <span id="customername2"> </span><br/>
                                    Sold By: <span id="salesmanname2"></span><br/>
                                    Date: <span id="salesdate2"> <?php echo date("F j, Y, g:i a"); ?> </span><br/><br/>
                                    <input type="hidden" name="totalprevAmount" id="totalprevAmount2" />
                                </div>                                                       
                            </div>
                            <div class="col-lg-12">
                                <div class="adv-table">                                   
                                    <table class="display table table-bordered table-striped edit-table" id="cloudAccounting2" style="font-size: 9px">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Item Description</th>
                                                <th style="text-align: center">Qty</th>
                                                <th style="text-align: center">Rate</th>
                                                <th style="text-align: center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addprintrowoffice2">                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th style="text-align: center" id="totalqty2"> </th>
                                                <th></th>
                                                <th id="netvalues2" style="text-align: right"> 0.00 </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table style="float: right; text-align:right; width:100%; font-size: 12px; font-weight: bold">                                       
                                        <tr>
                                            <td>Sub Total: </td>
                                            <td id="invoiceamount2" style="text-align:right">0.00</td>
                                        </tr>                                      
                                        <tr>
                                            <td>Discount(-):</td>
                                            <td id="discount2" style="text-align:right">0.00</td>
                                        </tr>
                                        <tr id="previous_amountrow">
                                            <td>Previous Amount:</td>
                                            <td id="previous_amount2" style="text-align:right">0.00</td>
                                        </tr>   
                                        <tr>
                                            <td>Net Amount:</td>
                                            <td id="netpayableamount2">0.00</td>
                                        </tr>  
                                        <tr>
                                            <td id="paidamount2text">Customer Pay: </td>
                                            <td id="paidamount2" style="text-align:right"> </td>
                                        </tr>    
                                        <tr>
                                            <td>Change:</td>
                                            <td id="returnableamount2">0.00</td>
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
                    <!--                    2nd div start-->
                    <td>
                        <div class="col-lg-6">                    
                            <div class="col-lg-12">
                                <div class="col-sm-2" style="text-align: center">
                                    <img src="<?php echo $baseurl ?>assets/uploads/<?php echo $companyinfo->logo; ?>" />
                                </div>
                                <div class="col-sm-10">
                                    <div style="text-align: center">                        
                                        <p><span style="font-size: 20px"><b><?php echo $companyinfo->companyName; ?></b></span><br/><?php echo $companyinfo->address; ?>
                                            <br/> <?php if ($companyinfo->mobile1 != ""): ?>Contact: <?php echo $companyinfo->mobile1; ?>,<?php echo $companyinfo->mobile2; ?>. <?php endif;
                                        ?> </p>
                                        <?php if ($companyinfo->email != ""): ?> <p style="text-align: center"> E-mail:<?php echo $companyinfo->email; ?></p> <?php endif; ?>
                                    </div>
                                    <div style="border: 1px solid gray; height: 1px;"> </div>
                                    <div style="text-align: center">
                                        <h5>
                                            COPY OF RECEIPT
                                        </h5>                                
                                    </div> 
                                </div>                                
                            </div>
                            <div class="col-lg-12">
                                <div style="float: left">
                                    Invoice No: <?php echo $companyinfo->invoice_prefix; ?><span id="invoiceno3"> </span><br/>
                                    Customer Name: <span id="customername3"> </span><br/>
                                    Sold By: <span id="salesmanname3"></span><br/>
                                    Date: <span id="salesdate3"> <?php echo date("F j, Y, g:i a"); ?> </span><br/><br/>
                                    <input type="hidden" name="totalprevAmount" id="totalprevAmount3" />
                                </div>                                                       
                            </div>
                            <div class="col-lg-12">
                                <div class="adv-table">                                   
                                    <table class="display table table-bordered table-striped edit-table" id="cloudAccounting3" style="font-size: 9px">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Item Description</th>
                                                <th style="text-align: center">Qty</th>
                                                <th style="text-align: center">Rate</th>
                                                <th style="text-align: center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addprintrowoffice3">                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th style="text-align: center" id="totalqty3"> </th>
                                                <th></th>
                                                <th id="netvalues3" style="text-align: right"> 0.00 </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table style="float: right; text-align:right; width:100%; font-size: 12px; font-weight: bold">                                       
                                        <tr>
                                            <td>Sub Total: </td>
                                            <td id="invoiceamount3" style="text-align:right">0.00</td>
                                        </tr>                                      
                                        <tr>
                                            <td>Discount(-):</td>
                                            <td id="discount3" style="text-align:right">0.00</td>
                                        </tr>    
<!--                                        <tr>
                                            <td>VAT 5%(+):</td>
                                            <td id="vat1" style="text-align:right">0.00</td>
                                        </tr>   -->
                                        <tr id="previous_amountrow">
                                            <td>Previous Amount:</td>
                                            <td id="previous_amount3" style="text-align:right">0.00</td>
                                        </tr>   
                                        <tr>
                                            <td>Net Amount:</td>
                                            <td id="netpayableamount3">0.00</td>
                                        </tr>  
                                        <tr>
                                            <td id="paidamount3text">Customer Pay: </td>
                                            <td id="paidamount3" style="text-align:right"> </td>
                                        </tr>    
                                        <tr>
                                            <td>Change:</td>
                                            <td id="returnableamount3">0.00</td>
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
                    <!--                2nd div end    -->
                </tr>
            </table> 
        </div>
    </div> 
</section>



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
    var discountval = "<?php echo $discount; ?>";
    function maxValue(val) {
        var inputval = parseInt(val);
        if (inputval > discountval) {
            $("#discountpercantage").val("");
            $("#discountlimit").text("discount limit exceeds");
            $("#discountlimit").css("color", "red");
        } else {
            $("#discountlimit").text("");
        }
    }

    $(document).ready(function() {
        var userrole = "<?php echo $this->sessiondata['userrole']; ?>";
        /*  if (userrole == 's') {
         $("#submitaddcustomer").prop("disabled", true);
         $("#addpurchase").prop("disabled", true);
         $("#addpurchase_submit").prop("disabled", true);
         } */
    });

    $(document).ready(function() {
        $("#showpaymentvoutersubmit").hide();
        $("#addpurchase_submit").click(function() {
            if (visibleProductCount > 0) {
                var total_amout = $("#total_amout").text();
                var total_amout_chk = (parseInt(total_amout) * discountval) / 100;
                var discount_chk = parseInt($("#discount").val());
                if (total_amout_chk < discount_chk) {
                    $("#discountlimit").text("discount limit exceeds");
                    $("#discountlimit").css("color", "red");
                    return false;
                } else {
                    $("#discountlimit").text("");
                    $("#addpurchase_submit").hide();
                    $("#showpaymentvoutersubmit").show();
                    return true;
                }
            } else {
                alert("Please add product.");
                return false;
            }
        });
    });


    function validForm() {

        var total_amout = $("#total_amout").text();
        var total_amout_chk = (parseInt(total_amout) * discountval) / 100;
        var discount_chk = parseInt($("#discount").val());
        if (total_amout_chk < discount_chk) {
            $("#discountlimit").text("discount limit exceeds");
            $("#discountlimit").css("color", "red");
            return false;
        } else {
            $("#discountlimit").text("");
            $("#addpurchase_submit").hide();
            $("#showpaymentvoutersubmit").show();
            return true;
        }
    }

    function getName(op) {
        var curr = op.split(',');
        $("#corparty_account").val(curr[0]);
        $("#nameOfBusiness").val(curr[1]);
    }

    function getCurrentBalance(formval) {
        var curr = formval.split(',');
        var id = curr[0];
        $("#corparty_account").val(id);
    }

    var print = "<?= $print; ?>";
    function PrintElem(elem) {
        if (visibleProductCount > 0) {
            var total_amout = $("#total_amout").text();
            var total_amout_chk = (parseInt(total_amout) * discountval) / 100;
            var discount_chk = parseInt($("#discount").val());
            if (total_amout_chk < discount_chk) {
                $("#discountlimit").text("discount limit exceeds");
                $("#discountlimit").css("color", "red");
                return false;
            } else {

                var invoiceno = $("#dbinvoiceno").val();
                var soldby = $("#salesMan").val();

                var billto = $("#acshaccount option:selected").text();
                var transport = $("#transport").val();
                var discount = $("#discount").val();
                var ledgerid = $("#acshaccount option:selected").val();
                var description = $("#description").val();
                var paidamount = $("#paidamount").val();
                var vat = $("#vat").val();
                var previous_amount = $(".previous_amount").val();
                var change_amount = $("#change_amount").text();
                var customername = "";
                if (billto == 'select') {
                    customername = "Cash Account";
                    $("#previous_amountrow").hide();
                } else {
                    customername = billto;
                    $("#previous_amountrow").show();
                }
                $("#customername").text(customername);
                $("#customername2").text(customername);
                $("#customername3").text(customername);
                transport = parseFloat(transport).toFixed(2);
                discount = parseFloat(discount).toFixed(2);
                if (paidamount == '') {
                    paidamount = "0.00";
                } else {
                    paidamount = parseFloat(paidamount).toFixed(2);
                }


                $("#invoiceno1").text(invoiceno);
                $("#invoiceno2").text(invoiceno);
                $("#invoiceno3").text(invoiceno);
                $("#salesmanname1").text(soldby);
                $("#salesmanname2").text(soldby);
                $("#salesmanname3").text(soldby);
                $("#discount1").text(discount);
                $("#discount2").text(discount);
                $("#discount3").text(discount);
                $("#paidamount1").text(paidamount);
                $("#paidamount2").text(paidamount);
                $("#paidamount3").text(paidamount);
                $("#vat1").text(vat);
                $("#previous_amount1").text(previous_amount);
                $("#previous_amount2").text(previous_amount);
                $("#previous_amount3").text(previous_amount);
                var total = $(".total_amout").val();
                netpayable = total - discount + parseFloat(vat) + parseFloat(previous_amount);
                netpayable = parseFloat(netpayable).toFixed(2);
                $("#netpayableamount1").text(netpayable);
                $("#netpayableamount2").text(netpayable);
                $("#netpayableamount3").text(netpayable);
                /* if (paidamount > netpayable) {
                 var returnableamount = paidamount - netpayable;
                 returnableamount = parseFloat(returnableamount).toFixed(2);
                 $("#returnableamount1").text(returnableamount);
                 } else {
                 $("#returnableamount1").text("0.00");
                 } */
                $("#returnableamount1").text(change_amount);
                $("#returnableamount2").text(change_amount);
                $("#returnableamount3").text(change_amount);
                //var netpayableinword = convert_number(netpayable);
                //$("#inwords1").text(netpayableinword + " Only");

                Popup(jQuery(elem).html());

                return true;
            }
        }
        else {
            alert("Please add product.");
            return false;
        }
    }

    function Popup(data) {

        var mywindow = window.open('', 'my div', '');
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
        setTimeout(function() {
            mywindow.print();
        }, 20);
    }


    function numberToEnglish(n) {

        var string = n.toString(), units, tens, scales, start, end, chunks, chunksLen, chunk, ints, i, word, words, and = 'and';

        /* Is number zero? */
        if (parseInt(string) === 0) {
            return 'zero';
        }

        /* Array of units as words */
        units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

        /* Array of tens as words */
        tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        /* Array of scales as words */
        scales = ['', 'Thousand', 'Million', 'Billion', 'Trillion', 'Quadrillion', 'Quintillion', 'Sextillion', 'Septillion', 'Octillion', 'Nonillion', 'Decillion', 'Undecillion', 'Duodecillion', 'Tredecillion', 'Quatttuor-decillion', 'Quindecillion', 'Sexdecillion', 'Septen-decillion', 'Octodecillion', 'Novemdecillion', 'Vigintillion', 'Centillion'];

        /* Split user arguemnt into 3 digit chunks from right to left */
        start = string.length;
        chunks = [];
        while (start > 0) {
            end = start;
            chunks.push(string.slice((start = Math.max(0, start - 3)), end));
        }

        /* Check if function has enough scale words to be able to stringify the user argument */
        chunksLen = chunks.length;
        if (chunksLen > scales.length) {
            return '';
        }

        /* Stringify each integer in each chunk */
        words = [];
        for (i = 0; i < chunksLen; i++) {

            chunk = parseInt(chunks[i]);

            if (chunk) {

                /* Split chunk into array of individual integers */
                ints = chunks[i].split('').reverse().map(parseFloat);

                /* If tens integer is 1, i.e. 10, then add 10 to units integer */
                if (ints[1] === 1) {
                    ints[0] += 10;
                }

                /* Add scale word if chunk is not zero and array item exists */
                if ((word = scales[i])) {
                    words.push(word);
                }

                /* Add unit word if array item exists */
                if ((word = units[ ints[0] ])) {
                    words.push(word);
                }

                /* Add tens word if array item exists */
                if ((word = tens[ ints[1] ])) {
                    words.push(word);
                }

                /* Add 'and' string after units or tens integer if: */
                if (ints[0] || ints[1]) {

                    /* Chunk has a hundreds integer or chunk is the first of multiple chunks */
                    if (ints[2] || !i && chunksLen) {
                        words.push(and);
                    }

                }

                /* Add hundreds word if array item exists */
                if ((word = units[ ints[2] ])) {
                    words.push(word + ' hundred');
                }

            }

        }

        return words.reverse().join(' ');

    }

    // convert number to bangla format

    function convert_number(n) {

        var num = n.toString();
        var number, my_number, pointnumber;
        var res3 = "";
        if (num.indexOf(".") > 0) {
            my_number = num.split(".");
            number = my_number[0];
            pointnumber = my_number[1];
        }
        else {
            number = num;
            pointnumber = 0;
        }

        if (pointnumber > 0) {
            var pointlength = pointnumber.length;

            var Dn3 = Math.floor(pointnumber / 10); /* Tens (deca) */

            var n3 = pointnumber % 10;

            var ones3 = new Array("", "One", "Two", "Three", "Four", "Five", "Six",
                    "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                    "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                    "Nineteen");
            var tens3 = new Array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                    "Seventy", "Eigthy", "Ninety");


            if (Dn3 || n3) {
                if (res3) {
                    res3 += " and ";
                }
                if (Dn3 < 2) {

                    if (Dn3 == 0 && pointlength != 1) {
                        res3 += "Zero ";
                        res3 += ones3[Dn3 * 10 + n3];
                    } else if (Dn3 == 0 && pointlength == 1) {
                        res3 += ones3[Dn3 * 10 + n3];
                        res3 += " Zero ";
                    } else {
                        res3 += ones3[Dn3 * 10 + n3];
                    }

                } else {
                    res3 += tens3[Dn3];
                    if (n3) {
                        res3 += "-" + ones3[n3];
                    }
                }
            }

        } else {
            res3 = "Zero";
        }



        if ((number < 0) || (number > 999999999)) {

            var length = number.length;
            var prefix = number.substr(0, length - 7);
            var postfix = number.substr(length - 7);
//            for prefix
            var Gn = Math.floor(prefix / 100000); /* lakh  */
            prefix -= Gn * 100000;
            var kn = Math.floor(prefix / 1000); /* Thousands (kilo) */
            prefix -= kn * 1000;
            var Hn = Math.floor(prefix / 100); /* Hundreds (hecto) */
            prefix -= Hn * 100;
            var Dn = Math.floor(prefix / 10); /* Tens (deca) */
            var n = prefix % 10;
// for postfix
            var Gn2 = Math.floor(postfix / 100000); /* lakh  */
            postfix -= Gn2 * 100000;
            var kn2 = Math.floor(postfix / 1000); /* Thousands (kilo) */
            postfix -= kn2 * 1000;
            var Hn2 = Math.floor(postfix / 100); /* Hundreds (hecto) */
            postfix -= Hn2 * 100;
            var Dn2 = Math.floor(postfix / 10); /* Tens (deca) */
            var n2 = postfix % 10;
// for prefix
            var res = "";
            if (Gn) {
                res += convert_number(Gn) + " Lakh";
            }

            if (kn) {
                res += ((res == "") ? "" : " ") +
                        convert_number(kn) + " Thousand";
            }

            if (Hn) {
                res += ((res == "") ? "" : " ") +
                        convert_number(Hn) + " Hundred";
            }

            var ones = new Array("", "One", "Two", "Three", "Four", "Five", "Six",
                    "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                    "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                    "Nineteen");
            var tens = new Array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                    "Seventy", "Eigthy", "Ninety");
            if (Dn || n) {
                if (res) {
                    res += " And ";
                }

                if (Dn < 2) {
                    res += ones[Dn * 10 + n];
                } else {
                    res += tens[Dn];
                    if (n) {
                        res += "-" + ones[n];
                    }
                }
            }

//    if (empty(res)) {
//    res = "Zero";
//    }


// for postfix
            var res2 = "";
            if (Gn2) {
                res2 += convert_number(Gn2) + " Lakh";
            }

            if (kn2) {
                res2 += ((res2 == "") ? "" : " ") +
                        convert_number(kn2) + " Thousand";
            }

            if (Hn2) {
                res2 += ((res2 == "") ? "" : " ") +
                        convert_number(Hn2) + " Hundred";
            }

            var ones2 = new Array("", "One", "Two", "Three", "Four", "Five", "Six",
                    "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                    "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                    "Nineteen");
            var tens2 = new Array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                    "Seventy", "Eigthy", "Ninety");
            if (Dn2 || n2) {
                if (res2) {
                    res2 += " And ";
                }

                if (Dn2 < 2) {
                    res2 += ones2[Dn2 * 10 + n2];
                } else {
                    res2 += tens2[Dn2];
                    if (n2) {
                        res2 += "-" + ones2[n2];
                    }
                }
            }




            return (res + " Crore " + res2 + " Taka And " + res3 + " Paisa");
//    alert ("Number is out of range");
        } else {


            var Kt = Math.floor(number / 10000000); /* Crore */

            number -= Kt * 10000000;
            var Gn = Math.floor(number / 100000); /* lakh  */
            number -= Gn * 100000;
            var kn = Math.floor(number / 1000); /* Thousands (kilo) */
            number -= kn * 1000;
            var Hn = Math.floor(number / 100); /* Hundreds (hecto) */
            number -= Hn * 100;
            var Dn = Math.floor(number / 10); /* Tens (deca) */
            var n = number % 10; /* Ones */

            var res4 = "";
            var a = "";
            if (Kt) {
                res4 += convert_number(Kt) + " Crore ";
            }

            if (Gn) {
                res4 += convert_number(Gn) + " Lakh ";
            }


            if (kn) {
                res4 += ((res4 == "") ? "" : " ") +
                        convert_number(kn) + " Thousand";
            }



            if (Hn) {
                res4 += ((res4 == "") ? "" : " ") +
                        convert_number(Hn) + " Hundred";
                a = "last";
            }



            var ones = new Array("", "One", "Two", "Three", "Four", "Five", "Six",
                    "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                    "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                    "Nineteen");
            var tens = new Array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                    "Seventy", "Eigthy", "Ninety");
            if (Dn || n) {
                if (res4) {
                    res4 += " And ";
                }

                if (Dn < 2) {
                    res4 += ones[Dn * 10 + n];
                } else {
                    res4 += tens[Dn];
                    if (n) {
                        res4 += "-" + ones[n];
                    }
                }
            }

            if (res4 == "") {
                res4 = "Zero";
            }



            if (a == "last") {
                return (res4 + " Taka And " + res3 + " Paisa");
            }

            return res4;
        }
    }


    // Enter key change input filed


    function pressenter(e) {
        var code = e.keyCode ? e.keyCode : e.which;
        return code !== 13;
    }

    function presAddButton(e) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code === 13) {
            $("#addpurchase").click();
            return false;
        }
        return true;
    }

    /**
     * Convert the enter into tab
     * Only do something when the user presses enter
     */
    $(document).on("keypress", ".TabOnEnter", function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var nextElement = $('[tabindex="' + (this.tabIndex + 1) + '"]');

            if (nextElement.length) {
                nextElement.focus();
            } else {
                $('[tabindex="1"]').focus();
            }

        }
    });


</script>

<!--<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
--><link href="<?= $baseurl; ?>assets/assets/keyboard/jquery.ml-keyboard.css" rel="stylesheet" type="text/css">
<script src="<?= $baseurl; ?>assets/assets/keyboard/jquery.ml-keyboard.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        var keyboard = "<?php echo $keyboard; ?>";
        if (keyboard == "1") {
            $('input').mlKeyboard({
                active_shift: false
            });
        } else {

        }

        $('#secondtab').focus();
    });

    /**
     * Go To Step 2
     */
    $('.gotosecond').click(function(e) {
        e.preventDefault();

        <?php if (!$barcodeOnSales): ?>
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?= base_url('sales/sales/getproduct'); ?>",
            success: function(response) {
                $("select#product_name option")
                    .not(":eq(0)")
                    .remove();
                $.each(response, function(key, value) {
                    $('select#product_name')
                        .append($("<option></option>")
                            .attr("value", value.productId)
                            .text(value.productName));
                });

                $('select#product_name').selectpicker('refresh');
            }
        });
        <?php else: ?>
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?= base_url('sales/sales/getproduct'); ?>",
            success: function(response) {
                $("select#product_name_barcode option")
                    .not(":eq(0)")
                    .remove();
                $.each(response, function(key, value) {
                    $('select#product_name_barcode')
                        .append($("<option></option>")
                            .attr("value", value.productId)
                            .text(value.productName));
                });

                $('select#product_name_barcode').selectpicker('refresh');
            }
        });
        <?php endif; ?>

        $('#addsalestab a[href="#step2"]').tab('show');
    });

    /**
     * Go To Step 2
     */
    $('#steptwo').click(function(e){
        e.preventDefault();

        <?php if (!$barcodeOnSales): ?>
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?= base_url('sales/sales/getproduct'); ?>",
            success: function(response) {
                $("select#product_name option")
                    .not(":eq(0)")
                    .remove();
                $.each(response, function(key, value) {
                    $('select#product_name')
                        .append($("<option></option>")
                            .attr("value", value.productId)
                            .text(value.productName));
                });

                $('select#product_name').selectpicker('refresh');
            }
        });
        <?php else: ?>
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?= base_url('sales/sales/getproduct'); ?>",
            success: function(response) {
                $("select#product_name_barcode option")
                    .not(":eq(0)")
                    .remove();
                $.each(response, function(key, value) {
                    $('select#product_name_barcode')
                        .append($("<option></option>")
                            .attr("value", value.productId)
                            .text(value.productName));
                });

                $('select#product_name_barcode').selectpicker('refresh');
            }
        });
        <?php endif; ?>

        $('#addsalestab a[href="#step2"]').tab('show');
    });

    $('.gotofirst').click(function(e) {
        e.preventDefault();
        $('#addsalestab a[href="#step1"]').tab('show');
    });

    $('.gotothird').click(function(e) {
        e.preventDefault();
        $('#addsalestab a[href="#step3"]').tab('show');
    });

    /**
     * Bill To
     */
    $('input[name=membertype]').on('change', function () {
        if ($('input[name=membertype]:checked').val() == 1) {
            $('#memberNameDiv').hide();
        } else {
            $('#memberNameDiv').show();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: "<?= base_url('sales/sales/getsupplier'); ?>",
                success: function(response) {
                    $("select#acshaccount option")
                        .not(":eq(0)")
                        .remove();
                    $.each(response, function(key, value) {
                        $('select#acshaccount')
                            .append($("<option></option>")
                                .attr("value", value.ledgerId + ',' +value.nameOfBusiness)
                                .text(value.acccountLedgerName));
                    });

                    $('.selectpicker').selectpicker('refresh');
                }
            });
        }
    });

    /**
     * After selecting Member
     */
    $('select#acshaccount').change(function(){
        $('#secondtab').focus();
    });

    /**
     * Receipt
     */
    $('input[name=optionsRadios]').on('change', function () {
        if ($('input[name=optionsRadios]:checked').val() === 'By Cash') {
            $('#bankaccdiv').hide();
            $('#chequenodiv').hide();
            $('#chequedatediv').hide();
            $('#descriptiondiv').hide();
        } else {
            $('#bankaccdiv').show();
            $('#chequenodiv').show();
            $('#chequedatediv').show();
            $('#descriptiondiv').show();
        }
    });
</script>