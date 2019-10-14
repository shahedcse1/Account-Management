  <style>
.panel-heading{
        background-color:#e979a0;
    }

</style>
<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Journal Entry
            </header>
            <div class="panel-body">
                <form class="cmxform form-horizontal tasi-form" id="" method="post" action="<?php echo site_url('journalentry/journalentry/addjournal') ?>">                                                                  
                    <div class="row">   
                        <div class="col-lg-12"> 
                            <div class="panel-body">
                                <div class="form-group">                                                                 
                                    <div class="col-lg-4">
                                        <label  for="accountledger">Account Ledger</label>
                                    </div>                                    
                                    <div class="col-lg-3">
                                        <label  for="debit">Debit</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label  for="credit">Credit</label>
                                    </div>                                  
                                </div>                           
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px;">
                            <div class="panel-body">
                                <div class="form-group" style="padding-top: 3px">                                                                 
                                    <div class="col-lg-4">
                                        <select class=" form-control selectpicker" data-live-search="true" id="first_ledgerId" name="new_ledgerId[]"  required>
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($ledger as $value) {
                                                $accNo = $value->accNo;
                                                echo "<option value='" . $value->ledgerId . "'>$accNo - $value->acccountLedgerName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-lg-3">
                                        <input type="text" id="debit" name="debit[]" class="form-control debit"  placeholder="0.00" onchange="adddebit()">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" id="first_credit" name="credit[]" class="form-control credit"  placeholder="0.00" onchange="addcredit()">
                                    </div>                                  
                                </div>                           
                            </div>
                        </div>
                        <div id='TextBoxesGroup'>
                            <div id="TextBoxDiv1">
                                <div class="col-lg-12" style="padding-left: 0px"> 
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <select class=" form-control selectpicker" data-live-search="true" id="second_ledgerId" name="new_ledgerId[]" required>
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($ledger as $value) {
                                                        $accNo = $value->accNo;
                                                        echo "<option value='" . $value->ledgerId . "'>$accNo - $value->acccountLedgerName</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>                                    
                                            <div class="col-lg-3">
                                                <input id="second_debit" type="text" name="debit[]" class="form-control debit"  placeholder="0.00" onchange="adddebit()">
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="col-lg-3" style="width:62%;padding-left: 0px;">                                          
                                                    <input id="second_credit" type="text" name="credit[]" class="form-control credit"data-live-search="true"  placeholder="0.00" onchange="addcredit()">                                       
                                                </div>
                                               <button type="button" id='addButton' value='Add Button' class="btn btn-success pull-right">Add <i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>  
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px"> 
                            <div class="form-group">
                                &nbsp;
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px;font-weight:700;"> 
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" style="font-weight:700;"class="control-label col-lg-4 ">Total</label>
                                    <div class="col-lg-3">
                                        <input style="border:1px solid #0A0101" class="form-control " type="text" id="total_debit" placeholder="0.00"
                                               name="total_debit" readonly required/>
                                    </div>                               
                                    <div class="col-lg-3 ">
                                        <input style="border:1px solid #0A0101" class="form-control " type="text" id="total_credit" placeholder="0.00"
                                               name="total_credit" readonly required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"> 
                            <div class="form-group">  
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <span id="valuecheck"> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-4">Description</label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control " id="description" name="description" cols="30" rows="3"></textarea>
                                    </div>                               
                                </div>
                            </div>
                        </div>
                        &nbsp;
                        <div class="col-lg-12" style="padding-left: 0px"> 
                            <div class="form-group ">
                                <label for="opening_balance" class="control-label col-lg-4">Date</label>
                                <div class="col-lg-6">
                                    <input class="form-control " id="datetimepicker" name="date" value="<?php echo Date('Y-m-d 00:00:00'); ?>"/>
                                </div>                               
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="col-lg-8 col-lg-offset-4" style="padding-left: 0px"> 
                        <div class="form-group ">
                            <button type="submit"  class="btn btn-primary" onclick="return addamountCheck()">Save</button>
                            <button type="reset" class="btn btn-info">Clear</button>
                            <a href="<?php echo site_url('journalentry/journalentry/addjournal'); ?>"><button type="button" id="newrow" class="btn btn-default">Cancel</button></a>
                        </div>
                    </div>                       
                    </div>                  
                </form>
            </div>
        </section>
    </section>
</section>