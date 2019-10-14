<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->       
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Contra Voucher 
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <section class="panel">                    
                                    <div class="panel-body">

                                    </div>
                                </section>                    
                            </div>
                        </div>   
                        <form class="cmxform form-horizontal tasi-form" id="edit<?php echo $rows->contraMasterId ?>" method="post" action="<?php echo site_url('contravoucher/contravoucher/editcontravoucher2') ?>">
                            <div class="modal-content">

                                <div class="modal-body">  
                                    <div class="row">  
                                        <div class="col-lg-12">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="col-lg-4"></div>
                                                    <div class="col-lg-6" style="padding-left: 0px">                                                                         
                                                        <?php if ($rows->type == "Deposit") { ?>
                                                            <div class="radio">
                                                                <label >
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="Deposit" checked>
                                                                    Deposit
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="Withdraw">
                                                                    Withdraw
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($rows->type == "Withdraw") { ?>
                                                            <div class="radio">
                                                                <label >
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios1" value="Deposit">
                                                                    Deposit
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" class="radiobutton" name="optionsRadios" id="optionsRadios2" value="Withdraw" checked>
                                                                    Withdraw
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="padding-left: 0px;">
                                            <div class="panel-body">
                                                <div class="form-group" style="padding-top: 3px">
                                                    <label for="opening_balance" class="control-label col-lg-4">Bank Account</label>
                                                    <div class="col-lg-6">
                                                        <select class=" form-control selectpicker" data-live-search="true" id="editledgerId" name="editledgerId" required>
                                                            <option value="">Select</option>                                            
                                                            <?php
                                                            foreach ($ledger as $value) {
                                                                $accNo = $value->accNo;
                                                                ?>
                                                                <option<?php
                                                                if ($rows->ledgerId == $value->ledgerId) {
                                                                    echo ' selected';
                                                                }
                                                                ?> value="<?php echo $value->ledgerId; ?>"><?php echo $accNo . ' - ' . $value->acccountLedgerName; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>                               
                                                </div>                           
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="padding-left: 0px"> 
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="opening_balance" class="control-label col-lg-4">Cash/Bank Account</label>
                                                    <div class="col-lg-6">
                                                        <select class=" form-control selectpicker" data-live-search="true" id="editnew_ledgerId" name="editnew_ledgerId" required>
                                                            <option value="">Select</option>
                                                            <?php
                                                            $this->sessiondata = $this->session->userdata('logindata');
                                                            $cmpnyid = $this->sessiondata['companyid'];
                                                            $contraMasterId = $rows->contraMasterId;
                                                            $ledgeridfordebit = $rows->ledgerId;
                                                            $queryfordetail = $this->db->query("Select * from contradetails where contraMasterId='$contraMasterId' AND companyId='$cmpnyid'");
                                                            $ledgerid = $queryfordetail->row()->ledgerId;
                                                            $amount = $queryfordetail->row()->amount;
                                                            $chequeNo = $queryfordetail->row()->chequeNo;


                                                            $chequeDate = $queryfordetail->row()->chequeDate;
                                                            $queryforledgeridfirst = $this->db->query("Select * from ledgerposting where companyId='$cmpnyid' AND voucherNumber='$contraMasterId' AND (ledgerId='$ledgeridfordebit' AND voucherType='Contra Voucher')");
                                                            $ledgerpostledgeridfirst = $queryforledgeridfirst->row()->ledgerPostingId;
                                                            $queryforledgeridsecond = $this->db->query("Select * from ledgerposting where companyId='$cmpnyid' AND voucherNumber='$contraMasterId' AND (ledgerId='$ledgerid' AND voucherType='Contra Voucher')");
                                                            $ledgerpostledgeridsecond = $queryforledgeridsecond->row()->ledgerPostingId;
                                                            foreach ($allledgerdata as $value) {
                                                                $accNo = $value->accNo;
                                                                ?>
                                                                <option<?php
                                                                if ($ledgerid == $value->ledgerId) {
                                                                    echo ' selected';
                                                                }
                                                                ?> value="<?php echo $value->ledgerId; ?>"><?php echo $accNo . ' - ' . $value->acccountLedgerName; ?></option>
                                                                <?php }
                                                                ?>                                                  
                                                        </select>
                                                    </div>                                  
                                                </div>
                                            </div>                             
                                        </div>  
                                        <div class="col-lg-12" style="padding-left: 0px;"> 
                                            <div class="panel-body">
                                                <div class="form-group ">                                   
                                                    <label for="opening_balance"class="control-label col-lg-4">Total Amount</label>
                                                    <div class="col-lg-6 ">
                                                        <input class="form-control " type="text" id="editamount<?php echo $rows->contraMasterId ?>" placeholder="0.00"
                                                               name="editamount" value="<?php echo $amount ?>"required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group">  
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-6">
                                                    <span id="valuecheckiddiv<?php echo $rows->contraMasterId ?>"> </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="padding-left: 0px">
                                            <div class="panel-body">
                                                <div class="form-group ">
                                                    <label for="opening_balance" class="control-label col-lg-4">Date</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control "  name="editdate" id="editdatetimepicker<?php echo $rows->contraMasterId ?>" value="<?php echo $rows->date ?>" onclick="getid(<?php echo $rows->contraMasterId; ?>)"/>
                                                    </div>                               
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="padding-left: 0px">
                                            <div class="panel-body">
                                                <div class="form-group ">
                                                    <label for="opening_balance" class="control-label col-lg-4">Cheque No</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control " id="editchequeNo" name="editchequeNo" value="<?php echo $chequeNo; ?>"/>
                                                    </div>                               
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12" style="padding-left: 0px">
                                            <div class="panel-body">
                                                <div class="form-group ">
                                                    <label for="opening_balance" class="control-label col-lg-4">Cheque Date</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control "  name="editchequeDate" id="editchequedatetimepicker<?php echo $rows->contraMasterId; ?>" value="<?php echo $chequeDate; ?>" onclick="getid(<?php echo $rows->contraMasterId; ?>)"/>
                                                        <input type="hidden" name="editcontramasterid" id="editcontramasterid" value="<?php echo $rows->contraMasterId; ?>">
                                                        <input type="hidden" name="ledgerpostledgeridfirst" id="ledgerpostledgeridfirst" value="<?php echo $ledgerpostledgeridfirst ?>">
                                                        <input type="hidden" name="ledgerpostledgeridsecond" id="ledgerpostledgeridsecond" value="<?php echo $ledgerpostledgeridsecond ?>">
                                                    </div>                               
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="updatecontra"  class="btn btn-primary" onclick="return amountCheck(<?php echo $rows->contraMasterId ?>)">Save</button>
                                        <button type="reset" class="btn btn-info">Clear</button>
                                        <a href="<?php echo site_url('contravoucher/contravoucher'); ?>"><button type="button" class="btn btn-default">Cancel</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<!-------------------------Add New supplier------------------------------------->

<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#updatecontra").prop("disabled", true);
        }
    });
</script>