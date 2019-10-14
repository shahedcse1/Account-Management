<style>
    .panel-heading{
        background-color:#57864b;
    }
</style>

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->       
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Payment Voucher 
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('paymentvoucher/paymentvoucher/updatepayment') ?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <section class="panel">                    
                                        <div class="panel-body">
                                            <div class="col-lg-6">
                                                <span>
                                                    <?php
                                                    foreach ($alldata as $value) {
                                                        if ($value->paymentMode == "By Cheque"):
                                                            ?>
                                                            <div class="radio">
                                                                <label>
                                                                    By Cash
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="By Cash"/>
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="By Cheque" checked/>                                                        
                                                                    By Cheque
                                                                </label>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="radio">
                                                                <label>
                                                                    By Cash
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="By Cash" checked/>
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="By Cheque" />                                                        
                                                                    By Cheque
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
                                        <label for="paymentMode" class="col-lg-5 col-sm-2 control-label">Cash/Bank Account</label>
                                        <div class="col-lg-6">
                                            <select class="form-control selectpicker" data-live-search="true" id="editpaymentMode" name="paymentMode" type="text">
                                                <?php
                                                if ($value->paymentMode == "By Cheque"):
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
                                                if ($value->paymentMode == "By Cash"):
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
                                        <label for="paidto" class="col-lg-5 col-sm-2 control-label">Paid To</label>
                                        <div class="col-lg-6">
                                            <select class="form-control selectpicker" data-live-search="true"  id="editledgerId" name="ledgerId" type="text">
                                                <?php
                                                foreach ($ledger as $ledlist):
                                                    if ($paidid == $ledlist->ledgerId):
                                                        ?>                                                    
                                                        <option selected value="<?php echo $ledlist->ledgerId; ?>"><?php echo $ledlist->accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>                                                    
                                                    <?php else:
                                                        ?>
                                                        <option value="<?php echo $ledlist->ledgerId; ?>"><?php echo $ledlist->accNo . ' - ' . $ledlist->acccountLedgerName; ?></option>
                                                    <?php
                                                    endif;
                                                endforeach;
                                                ?>  
                                                <option value="addsuplr">Add new Supplier</option>
                                            </select>                           
                                        </div>                                   
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-5 col-sm-2 control-label">Current Balance</label>
                                        <div class="col-lg-6" > 
                                            <input type="text" class="form-control" id="currentbalance" name="currentbalance" value="<?php echo $currentbalance; ?>" readonly>
                                        </div>
                                        <input type="hidden" class="form-control" id="paymentmasid" name="paymentmasid" value="<?php echo $paymsid ?>" >
                                        <!--    <div class="col-lg-2"> 
                                                
                                                <button type="button" id="againstid" name="againstid" class="btn btn-info pull-right" data-toggle="modal" data-target="#editmyModalagnst" onclick="excuteall()">Against</button>
                                            </div>  -->
                                    </div>

                                    <div class="form-group">
                                        <label for="amount" class="col-lg-5 col-sm-2 control-label">Amount</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="amount" name="amount"  value="<?php echo $amount ?>">
                                            <input type="hidden" class="form-control" id="paymentMasterId" name="paymentMasterId" value="<?php echo $value->paymentMasterId; ?>">
                                            <input type="hidden" class="form-control" id="voucherNumber" name="voucherNumber" >
                                            <input type="hidden" class="form-control" id="referenceType" name="referenceType" value="<?php //echo $preferenceType  ?>">
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
                                                <input type="text" class="form-control" id="datetimepickercheque"  name="chequeDate" value="<?php echo $chequeDate; ?>" />                                    
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-4">
                                        <button type="submit" id="paymentvoutersubmit" class="btn btn-primary">Update</button> 
                                        <div id="showpaymentvoutersubmit" class="btn btn-primary">Update</div>
                                        <a href="<?php echo site_url('paymentvoucher/paymentvoucher'); ?>"><button type="button" class="btn btn-default">Cancel</button></a>
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

<!--End of supplier-->
<!--Add against -->

<script>
    $(document).ready(function () {
        $("#showpaymentvoutersubmit").hide();
        $("#paymentvoutersubmit").click(function () {
            $("#paymentvoutersubmit").hide();
            $("#showpaymentvoutersubmit").show();
        });
    });
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var userrole = "<?php echo $this->sessiondata['userrole']; ?>";
        if (userrole == 'r') {
            $("#paymentvoutersubmit").prop("disabled", true);
            $("#showpaymentvoutersubmit").prop("disabled", true);
        }
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