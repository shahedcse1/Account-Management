<style>
.panel-heading{
        background-color:#305cc5;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->       
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Receipt Voucher 
                    </header>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('receiptvoucher/receiptvoucher/updatereceiptvoucher') ?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <section class="panel">                    
                                    <div class="panel-body">
                                        <div class="col-lg-6">
                                            <span>
                                                <?php
                                                foreach ($alldata as $value) {
                                                    if ($value->receiptMode == "By Cheque"):
                                                        ?>
                                                        <div class="radio">
                                                            <label>
                                                                Cash Receipt
                                                                <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="By Cash"/>
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="By Cheque" checked/>                                                        
                                                                Bank Receipt
                                                            </label>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="radio">
                                                            <label>
                                                                Cash Receipt
                                                                <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="By Cash" checked/>
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="By Cheque"/>                                                        
                                                                Bank Receipt
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </section>                    
                                </div>
                            </div>   
                            
                                <div class="col-lg-6">                                
                                    <div class="form-group">
                                        <label for="receiptMode" class="col-lg-5 col-sm-2 control-label">Cash/Bank Account</label>
                                        <div class="col-lg-6">
                                            <select class="form-control selectpicker" data-live-search="true" id="editpaymentMode" name="receiptMode" type="text">
                                                <?php
                                                if ($value->receiptMode == "By Cheque"):
                                                    foreach ($ledgerdata as $ledlist):
                                                        $accNo = $ledlist->accNo;
                                                        if ($value->ledgerId == $ledlist->ledgerId):
                                                            ?>                                                    
                                                            <option selected value="<?php echo $ledlist->ledgerId; ?>"><?php echo $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>                                                    
                                                        <?php else:
                                                            ?>
                                                            <option value="<?php echo $ledlist->ledgerId; ?>"><?php echo $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?> 
                                                <?php
                                                if ($value->receiptMode == "By Cash"):
                                                    foreach ($ledgerdatabycash as $ledlist):
                                                        $accNo = $ledlist->accNo;
                                                        if ($value->ledgerId == $ledlist->ledgerId):
                                                            ?>                                                    
                                                            <option selected value="<?php echo $ledlist->ledgerId; ?>"><?php echo $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>                                                    
                                                        <?php else:
                                                            ?>
                                                            <option value="<?php echo $ledlist->ledgerId; ?>"><?php echo $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
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
                                        <label for="paidto" class="col-lg-5 col-sm-2 control-label">Received From </label>
                                        <div class="col-lg-6">
                                            <select class="form-control selectpicker" data-live-search="true" id="ledgerId" name="ledgerId" type="text">
                                                <?php
                                                foreach ($ledger as $ledlist):
                                                    $accNo = $ledlist->accNo;
                                                    if ($ledlist->ledgerId == $paidid):
                                                        ?>                                                    
                                                        <option selected value="<?php echo $ledlist->ledgerId; ?>"><?php echo $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>                                                    
                                                    <?php else:
                                                        ?>
                                                        <option value="<?php echo $ledlist->ledgerId; ?>"><?php echo $accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                                ?>  
                                                <option value="addsuplr">Add new Supplier</option>
                                            </select>                           
                                        </div>                                   
                                    </div>
                                    <div class="form-group">
                                        <label for="voucherNumber" class="col-lg-5 col-sm-2 control-label">Receipt No</label>
                                        <div class="col-lg-6">                                     
                                            <input type="text" class="form-control" id="receiptNo" name="receiptNo" value="<?php echo $receiptNo; ?>"/>                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-5 col-sm-2 control-label">Current Balance</label>
                                        <div class="col-lg-6" > 
                                            <input type="text" class="form-control" id="currentbalance" name="currentbalance" value="<?php echo $currentbalance; ?>" readonly>
                                        </div>
                                        <input type="hidden" class="form-control" id="receiptMasterId" name="receiptMasterId" value="<?php echo $paymsid ?>" >
                                    <!--    <div class="col-lg-2"> 
                                           
                                            <button type="button" id="againstid" name="againstid" class="btn btn-info pull-right" data-toggle="modal" data-target="#editmyModalagnst" onclick="excuteall()">Against</button>

                                        </div>  -->
                                    </div>

                                    <div class="form-group">
                                        <label for="amount" class="col-lg-5 col-sm-2 control-label">Amount</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="amount" name="amount"  value="<?php echo $amount ?>">
                                            <input type="hidden" class="form-control" id="receiptMasterId" name="receiptMasterId" value="<?php echo $value->receiptMasterId; ?>">
                                            <input type="hidden" class="form-control" id="voucherNumber" name="voucherNumber" >
                                            <input type="hidden" class="form-control" id="referenceType" name="referenceType" value="<?php //cho $preferenceType ?>" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-lg-5 col-sm-2 control-label"> Date</label>
                                        <div class="col-lg-6">                                        
                                            <input type="text" id="datetimepicker" name="date" class="form-control" value="<?php echo $value->date ?>"/>                                                                                  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-5 col-sm-2 control-label">Description</label>
                                        <div class="col-lg-6">
                                            <textarea type="text" class="form-control" id="description" name="description" ><?php echo $value->description ?></textarea>                                    
                                        </div>
                                    </div>

                                        <div class="form-group">
                                            <label for="chequeNumber" class="col-lg-5 col-sm-2 control-label">Cheque Number</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="chequeNumber" name="chequeNumber" value="<?php echo $chequeNumber; ?>" />                                    
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="chequeDate" class="col-lg-5 col-sm-2 control-label">Cheque Date</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form_datetime form-control" id="datetimepickercheque"  name="chequeDate" value="<?php echo $chequeDate; ?>" />                                    
                                            </div>
                                        </div>
                                  
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-4">
                                        <button type="submit" id="paymentvoutersubmit" class="btn btn-primary">Update</button>  
                                        <div id="showpaymentvoutersubmit" class="btn btn-primary">Update</div>
                                        <button type="button" class="btn btn-default">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<!-------------------------Add New supplier------------------------------------->
<div class="modal fade" id="myModalsup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Add Supplier Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="cmxform form-horizontal tasi-form" id="supplier_add" method="post" action="">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="supplier_name" class="control-label col-lg-4">Supplier Name</label>

                                    <div class="col-lg-8">
                                        <input class=" form-control" id="supplier_name1" name="supplier_name"
                                               type="text" onchange="return supplierNameCheck()" value=""/>
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="address" class="control-label col-lg-4">Address</label>

                                    <div class="col-lg-8">
                                        <input class=" form-control" id="address1" name="address" type="text"/>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="country" class="control-label col-lg-4">Country</label>

                                    <div class="col-lg-4">
                                        <select class=" form-control" id="country1" name="country">
                                            <?php
                                            if (isset($countries)) {
                                                foreach ($countries as $country) {
                                                    echo "<option value='" . $country->country_name . "'>$country->country_name</option>";
                                                }
                                            }
                                            ?>

                                        </select>
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
                                        <select name="dr_cr" id="dr_cr1" class="supplier_debit pull-right">
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
                                        <textarea class="form-control " id="description1" name="description" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitaddsupplier" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-info">Reset</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--End of supplier-->
<!--Add against -->
<div class="modal fade" id="editmyModalagnst" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Party balance</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="cmxform form-horizontal tasi-form" id="aganstfrm" name="aganstfrm" method="post" action="">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="supplier_name" class="control-label col-lg-4">Reference </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="agnstornew" name="agnstornew" disabled>                                                                                     

                                            <?php if ($preferenceType == 'Against'): ?>
                                                <option value="Against" selected> Against</option>
                                                <option value="New"> New</option>
                                                <?php
                                            endif;
                                            if ($preferenceType == 'New'):
                                                ?>
                                                <option value="New" selected> New</option>
                                                <option value="Against"> Against</option>                                          
                                                <?php
                                            endif;
                                            ?>
                                        </select>
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="address" class="control-label col-lg-4">Voucher Type</label>
                                    <div class="col-lg-8">
                                        <div id="editvoutype">
                                            <select class="form-control">                                          
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>                      
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="country" class="control-label col-lg-4">Amount</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="editpaidamount" name="editpaidamount" value="<?php echo $amount ?>" type="text"/>
                                        <span id="balancemsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="phone" class="control-label col-lg-4">Dr/Cr</label>
                                    <div class="col-lg-8">
                                        <input class="form-control " id="drorcr" name="drorcr" type="text" value="Dr." readonly/>
                                    </div>
                                </div>  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="editamountbalance();">Done</button>
                                <button type="reset" class="btn btn-info">Reset</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#showpaymentvoutersubmit").hide();
        $("#paymentvoutersubmit").click(function() {
            $("#paymentvoutersubmit").hide();
            $("#showpaymentvoutersubmit").show();
        });
    });
</script>

<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#paymentvoutersubmit").prop("disabled", true);         
        }
    });
</script>