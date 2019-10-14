 <style>
.panel-heading{
        background-color:#e979a0;
    }

</style>
<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Edit Journal Entry
            </header>
            <div class="panel-body"> 
                <!--Edit Journal Entry Modal Start -->
                <?php
                foreach ($sortalldata as $rows):
                    $cmpid = $this->sessiondata['companyid'];
                    $id = $rows->journalMasterId;
                    $query = $this->db->query("SELECT sum(debit) as debit ,sum(credit) as credit FROM `ledgerposting` where companyId='$cmpid' AND (voucherType='Journal entry'AND voucherNumber='$id')");
                    if ($query->num_rows() > 0) {
                        $value = $query->row();
                        $debit = $value->debit;
                        $credit = $value->credit;
                    }
                    ?>
                    <form class="cmxform form-horizontal tasi-form" id="edit<?php echo $rows->journalMasterId ?>" method="post" action="<?php echo site_url('journalentry/journalentry/editjournal') ?>">
                        <div class="row">  
                            <div class="col-lg-12"> 
                                <div class="panel-body">
                                    <div class="form-group">                                          
                                        <div class="col-lg-6">
                                            <div class="col-lg-3"> </div>
                                            <div class="col-lg-9">
                                                <label  for="accountledger">Account Ledger</label>
                                            </div>
                                        </div>                                    
                                        <div class="col-lg-3">
                                            <label  for="debit"> &nbsp; Debit</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label  for="credit"> &nbsp;&nbsp; Credit</label>
                                        </div>                                  
                                    </div>                           
                                </div>
                            </div>
                            <div class="col-lg-12" style="padding-left: 0px;">
                                <div class="panel-body">
                                    <div class="form-group" style="padding-top: 3px">   

                                        <?php
                                        foreach ($getidValues as $idrows):
                                            ?>

                                            <div class="col-lg-6">
                                                <div class="col-lg-3"> </div>
                                                <div class="col-lg-6">
                                                    <select class=" form-control selectpicker" data-live-search="true" id="edit_ledgerId" name="edit_ledgerId[]" required>
                                                        <option value="">Select</option>
                                                        <?php
                                                        foreach ($ledger as $value) {
                                                            $accNo = $value->accNo;
                                                            ?>                                                                                
                                                            <option <?php
                                                            if ($idrows->ledgerId == $value->ledgerId) {
                                                                echo ' selected';
                                                            }
                                                            ?> value="<?php echo $value->ledgerId; ?>"><?php echo $accNo . ' - ' . $value->acccountLedgerName; ?></option>;
                                                                <?php
                                                            }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3"> </div>
                                            </div>                                    
                                            <div class="col-lg-3">
                                                <div class="col-lg-8">
                                                    <input type="text" id="editdebit"  name="editdebit[]" value="<?php echo $idrows->debit; ?>" class="form-control editdebit<?php echo $jmasterId; ?>"  placeholder="0.00" onchange="return adddebitedit(<?php echo $jmasterId; ?>)">
                                                </div>
                                                <div class="col-lg-4"> </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="col-lg-8">
                                                    <input type="text" id="editcredit"  name="editcredit[]" value="<?php echo $idrows->credit; ?>"class="form-control editcredit<?php echo $jmasterId; ?>"  placeholder="0.00" onchange="return addcreditedit(<?php echo $jmasterId; ?>)">
                                                </div>
                                                <div class="col-lg-4"> </div>
                                            </div> 
                                            <input type="hidden" name="JournalMasterID" id="JournalMasterID" value="<?php echo $jmasterId ?>">
                                            <input type="hidden" name="journalDetailsId[]" id="journalDetailsId" value="<?php echo $idrows->journalDetailsId; ?>">                                                                    
                                            <?php
                                        endforeach;
                                        foreach ($getLedgerDataValues as $gledger) {
                                            ?>
                                            <input type="hidden" name="ledgerPostingId[]" id="ledgerPostingId" value="<?php echo $gledger->ledgerPostingId; ?>">
                                        <?php } ?>
                                    </div>                           
                                </div>
                            </div>                                                   
                            <div class="col-lg-12" style="padding-left: 0px;font-weight:700;"> 
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="opening_balance" style="padding-top: 8px;font-weight:700;"class="control-label col-lg-6 ">Total</label>
                                        <div class="col-lg-3">
                                            <div class="col-lg-8">
                                                <input style="border:1px solid #0A0101" class="form-control " type="text" id="edittotal_debit<?php echo $rows->journalMasterId ?>" placeholder="0.00" value="<?php echo $debit ?>"
                                                       name="edittotal_debit" readonly required/> 
                                            </div>
                                            <div class="col-lg-4"> </div>
                                        </div>                                                                
                                        <div class="col-lg-3 ">
                                            <div class="col-lg-8">
                                                <input style="border:1px solid #0A0101" class="form-control " type="text" id="edittotal_credit<?php echo $rows->journalMasterId ?>" placeholder="0.00" value="<?php echo $credit ?>"
                                                       name="edittotal_credit" readonly required/>
                                            </div>
                                            <div class="col-lg-4"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12"> 
                                <div class="form-group">  
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <span id="valuecheckiddiv<?php echo $rows->journalMasterId ?>">  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style="padding-left: 0px">
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="opening_balance" class="control-label col-lg-6">Description</label>
                                        <div class="col-lg-6">
                                            <div class="col-lg-10">
                                                <textarea class="form-control " id="editdescription<?php echo $rows->journalMasterId ?>" name="editdescription" cols="30" rows="3"><?php echo $rows->description; ?></textarea>
                                            </div>
                                            <div class="col-lg-2"> </div>
                                        </div>                               
                                    </div>
                                </div>
                            </div>
                            &nbsp;
                            <div class="col-lg-12" style="padding-left: 0px"> 
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-6">Date</label>
                                    <div class="col-lg-6">
                                        <div class="col-lg-10">
                                            <input class="form-control " id="editdatetimepicker<?php echo $rows->journalMasterId ?>" name="editdate" value="<?php echo $rows->date; ?>" onclick="getid(<?php echo $rows->journalMasterId ?>)"/>
                                        </div>
                                        <div class="col-lg-2"> </div>
                                    </div>
                                    <p> &nbsp; </p>
                                </div>
                            </div>
                            <div class="col-lg-12" style="padding-left: 0px"> 
                                <div class="col-lg-6"> &nbsp; </div>
                                <div class="col-lg-6">
                                    <div class="col-lg-1"> </div>
                                    <div class="col-lg-9">
                                        <div class="form-group ">
                                            <button type="submit" id="updatejournal"  class="btn btn-primary" onclick="return amountCheck(<?php echo $rows->journalMasterId ?>)">Save</button>
                                            <button type="reset" class="btn btn-info">Clear</button>
                                            <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                                            <p> &nbsp; </p>
                                        </div>  
                                    </div>
                                    <div class="col-lg-2"> </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
                <!--End of edit Modal -->
            </div>
        </section>
    </section>
</section>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#updatejournal").prop("disabled", true);           
        }
    });
</script>