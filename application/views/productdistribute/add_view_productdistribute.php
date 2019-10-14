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
<form action="<?php echo site_url('productdistribute/productdistribute/add_productdistribute'); ?>" method="post" class="form-horizontal custom-form" role="form">
    <section id="main-content">
        <section class="wrapper site-min-height">
            <section class="panel">
                <header class="panel-heading">
                    Product Distribute
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
                                <label for="corparty_account" class="col-md-3 control-label text-left custom">To</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="corparty_account_Name" id="corparty_account_Name" value="<?php echo 'Vicky Hardwares' ?>" onchange="getCurrentBalance(this.value)" readonly>
<!--                                    <select class="form-control selectpicker" required="" data-live-search="true" name="" id="acshaccount" onchange="getCurrentBalance(this.value)">
                                        <option value="">select</option>
                                        <option value="2" selected>Cash Account</option>
                                        <?php
                                        if (isset($supplierinfo1)) {
                                            foreach ($supplierinfo1 as $supplier) {
                                                echo '<option value="' . $supplier->ledgerId . ',' . $supplier->nameOfBusiness . '">' . $supplier->accNo . ' - ' . $supplier->acccountLedgerName . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>-->
                                    <input  id="company_id"  name="company_id" type="hidden" value="<?php echo $company_id; ?>"/>
                                    <input  id="corparty_account" value="7"  name="corparty_account" type="hidden"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4" hidden="hidden">
                                <label for="qty" class="col-md-3 control-label text-left">Current Balance</label>
                                <div class="col-md-9">
                                    <input type="text" onkeypress="return pressenter(event)" class="form-control" name="currentbalance" id="currentbalance" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="invoice_data" class="col-md-4 control-label text-left"> Date</label>
                                <div class="col-md-8">
                                    <input type="text" onkeypress="return pressenter(event)" class="form-control" name="invoice_date" value="<?php echo date('Y-m-d H:i:s'); ?>" id="dailysearchfrom"/>
                                </div>
                            </div>
                            <div class="form-group col-md-1">                               
                                <div class="col-md-8">
                                    <input type="hidden" name="dbinvoiceno" id="dbinvoiceno" value="<?php echo $dbinvoiceno; ?>">
                                    <input type="hidden" name="salesMan" id="salesMan" value="<?php echo $username; ?>">
                                </div>
                            </div>                          
                        </div>
                        <hr/>
                        <!--       ============================ PART 2====================================================-->
                        <div class="row">
                            <div class="form-group col-md-3 clear">
                                <label for="product_name" class="col-md-4 control-label custom">Product </label>
                                <div class="col-md-8 myselect">
                                    <select class="form-control TabOnEnter selectpicker" data-live-search="true" name="product_name" tabindex="1" id="product_name" autofocus>
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
                            <div class="form-group col-md-2">
                                <label for="unit" class="col-md-4 control-label text-left">Unit</label>
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control" name="unit" id="unit" placeholder="Unit">
                                    <input type="text" onkeypress="return pressenter(event)" class="form-control"  id="unitshow" placeholder="Unit" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="qty" class="col-md-4 control-label text-left">Qty</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control TabOnEnter" onkeypress="return pressenter(event)" name="qty" id="qty" placeholder="Qty" tabindex="2">
                                    <span id="qtymsg"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="rate" class="col-md-4 control-label">Sale Rate</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" onkeypress="return presAddButton(event)" name="rate" id="rate" placeholder="Sale Rate" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group  col-md-2 pull-center">
                                <div class="col-md-12">
                                    <button type="button" id="addpurchase" class="btn btn-default">Add</button>
                                    <button type="button" id="product-reset" class="btn btn-default">Clear</button>                                    
                                </div>
                            </div>
                        </div>
                        <!--     ================================   END 2nd part input=========================-->


                        <table class="display table table-bordered table-striped " id="cloudAccounting1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody id="addnewrow">
                            </tbody>                            
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th id="viewtotalqty">  </th>
                                <th>  </th>
                                <th>  </th>
                            </tr>
                        </table>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5">

                                </div>

                                <div class="col-md-2">

                                </div>

                                <div class="col-md-4">
                                    <ul class="amounts" hidden="">
                                        <li><strong class="col-lg-5">Total Amount: </strong><span id="total_amout" class="align-right"> 0.00 </span> <input name="total_amout" class="total_amout" value="0" type="hidden"/></li>
                                        <li style="display: none" class="text-center"><strong>Grand Total :</strong> <span  id="grandtotal" class="align-right ">0.00</span><input name="grandtotal" class="grandtotal" type="hidden"/></li>
                                        <li><strong class="col-lg-5">Discount:</strong> <span class="align-right">
                                                <input type="text" name="discountpercantage" id="discountpercantage" style="width: 40px" value="00"/>% &nbsp;
                                                <input type="text" name="discount" id="discount" style="width: 40px" value="00"/></span></li>
                                        <li><strong class="col-lg-5">VAT 5%(+):</strong> <span id="vatspan" class="align-right"> 0.00 </span>      
                                            <input type="hidden" name="vat" id="vat" style="width: 40px" value="00"/></li>        
                                        <input type="hidden" name="transport" id="transport" style="width: 40px" value="00"/>
                                        <li><strong class="col-lg-5">Previous Amount: </strong><span id="previous_amountspan" class="align-right"> 0.00 </span> <input name="previous_amount" class="previous_amount" value="0" type="hidden"/></li>
                                        <li><strong class="col-lg-5">Net Amount:</strong> <span id="net_amout" class="align-right ">0.00</span><input name="net_amout" class="net_amout" type="text"/><input name="count_product" class="count_product" type="hidden"/></li>
                                        <li><strong class="col-lg-5">Customer Pay:</strong> <span class="align-right "><input type="text" onkeypress="return pressenter(event)" style="width: 100px"  class="form-control" id="paidamount" name="paidamount"> </span></li>
                                        <li><strong class="col-lg-5">Change Amount:</strong> <span id="change_amount">0.00</span></li>
                                    </ul>
                                    <p> &nbsp; </p>
                                    <div class="final-submit">
                                        <button type="submit" id="addpurchase_submit_print" onclick="PrintElem('#Printsalesinvoicediv')" class="btn btn-default">Save & Print</button>
                                        <button type="submit" id="addpurchase_submit" class="btn btn-default">Save</button>
                                        <div id="showpaymentvoutersubmit" class="btn btn-default">Save</div>
                                        <a href="<?php echo site_url('sales/sales'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
</form>

<link href="<?php echo $baseurl; ?>assets/css/bootstrap_print.min.css" rel="stylesheet">

<section class="panel" style="display: none; font-size: 8px;" id="Printsalesinvoicediv">   
    <div class="col-lg-12">
        <div class="panel-body"> 
            <table style="font-size: 10px; margin-top: 10px">
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
                                                <th style="text-align: center">Item Description</th>
                                                <th style="text-align: center">Qty</th>
                                                <th style="text-align: center">Rate</th>
                                                <th style="text-align: center">Amount</th>
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
                                    <table style="float:left; text-align: center; margin: 10px 30px 0px 30px; font-size: 10px">                                    
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
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
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
            $("#addpurchase_submit").hide();
            $("#showpaymentvoutersubmit").show();
        });
    });

    function getName(op) {
        var curr = op.split(',');
        $("#corparty_account").val(curr[0]);
        $("#nameOfBusiness").val(curr[1]);
    }

    function getCurrentBalance(formval) {
        var curr = formval.split(',');
        var id = curr[0];
        $("#corparty_account").val(id);
        $("#currentbalance").val("0.00");
        $("#previous_amountspan").text("0.00");
        $(".previous_amount").val(0.00);
        if (id != 2) {
            var dataString = "customerid=" + id;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/sales/getCurrentBalance'); ?>",
                data: dataString,
                success: function(data) {
                    $("#currentbalance").val(data);
                    $("#previous_amountspan").text(data);
                    $(".previous_amount").val(data);
                }
            });
        }
    }

    function PrintElem(elem) {
        var invoiceno = $("#dbinvoiceno").val();
        var soldby = $("#salesMan").val();
        var datevaltext = $("#dailysearchfrom").val();
        var dateval = datevaltext.substring(0, 10);
        var billto = $("#acshaccount option:selected").text();
        var nameofbusiness = $("#nameOfBusiness").val();
        var transport = $("#transport").val();
        var discount = $("#discount").val();
        var ledgerid = $("#acshaccount option:selected").val();
        var driver_name = $("#driver_name").val();
        var description = $("#description").val();
        var paidamount = $("#paidamount").val();
        var vat = $("#vat").val();
        var previous_amount = $(".previous_amount").val();
        var change_amount = $("#change_amount").text();

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
        transport = parseFloat(transport).toFixed(2);
        discount = parseFloat(discount).toFixed(2);
        paidamount = parseFloat(paidamount).toFixed(2);

        $("#invoiceno1").text(invoiceno);
        $("#salesmanname1").text(soldby);
        $("#discount1").text(discount);
        $("#paidamount1").text(paidamount);
        $("#vat1").text(vat);
        $("#previous_amount1").text(previous_amount);

        var total = $(".total_amout").val();
        netpayable = total - discount + parseFloat(vat) + parseFloat(previous_amount);
        netpayable = parseFloat(netpayable).toFixed(2);
        $("#netpayableamount1").text(netpayable);
        $("#returnableamount1").text(change_amount);
        if (billto != "select") {
            Popup(jQuery(elem).html());
        }
    }

    function Popup(data) {
        var mywindow = window.open('', 'my div', 'height=842,width=1340');
        mywindow.document.write('<html><head><title></title>');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/bootstrap_print.min.css" type="text/css" />');
        mywindow.document.write('<style type="text/css">body{ font-size:12px; } </style></head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.print();
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
        if (code === 13)
        {
            return false;
        }
        return true;
    }

    function presAddButton(e) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code === 13)
        {
            $("#addpurchase").click();
            return false;
        }
        return true;
    }

    $(document).on("keypress", ".TabOnEnter", function(e)
    {
        //Only do something when the user presses enter
        if (e.keyCode == 13)
        {
            var nextElement = $('[tabindex="' + (this.tabIndex + 1) + '"]');
            console.log(this, nextElement);
            if (nextElement.length)
                nextElement.focus()
            else
                $('[tabindex="1"]').focus();
        }
    });





</script>


