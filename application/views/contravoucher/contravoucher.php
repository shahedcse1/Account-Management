<style>
    .col-lg-3{
        padding-top: 3px;
    }
    .clickable a{
        width:100%;
        display:block;
    }   
</style>
<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Contra Voucher
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">                           
                            <button  class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>                          
                        </div>                        
                    </div>           
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                                                               
                                <th>Voucher No</th>
                                <th>Date</th>
                                <th>Bank Account</th>
                                <th>Amount</th>
                                <th>Type</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($sortalldata as $rows):
                                ?>
                                <tr class="table_hand">
                                    <td><a data-toggle="modal" href="#myModaldelete<?php echo $rows->contraMasterId ?>">
                                            <i class="fa fa-times-circle delete-icon"></i></a>
                                    </td>
                                    <td data-toggle="modal" href="#myModaledit<?php echo $rows->contraMasterId ?>"><?php echo $rows->contraMasterId ?></td>
                                    <td data-toggle="modal" href="#myModaledit<?php echo $rows->contraMasterId ?>"><?php
                                        $datevalue = date_create($rows->date);
                                        $dayvalue = date_format($datevalue, 'd');
                                        $monvalue = date_format($datevalue, 'F');
                                        $yrval = date_format($datevalue, 'Y');
                                        echo $dayvalue . ' ' . substr($monvalue, 0, 3) . '  ' . $yrval;
                                        ?></td>
                                    <td data-toggle="modal" href="#myModaledit<?php echo $rows->contraMasterId ?>">
                                        <?php
                                        foreach ($ledger as $value) {
                                            if ($rows->ledgerId == $value->ledgerId) {
                                                echo $value->acccountLedgerName;
                                            }
                                        }
                                        ?>
                                    </td>                                 
                                    <td data-toggle="modal" href="#myModaledit<?php echo $rows->contraMasterId ?>">
                                        <?php
                                        $cmpid = $this->sessiondata['companyid'];
                                        $id = $rows->contraMasterId;
                                        $query = $this->db->query("SELECT * FROM contradetails where companyId='$cmpid' AND contraMasterId='$id'");
                                        if ($query->num_rows() > 0) {
                                            $value = $query->row();
                                            $amount = $value->amount;
                                        }
                                        ?><?php echo $amount ?></td>
                                    <td data-toggle = "modal" href = "#myModaledit<?php echo $rows->contraMasterId ?>"><?php echo $rows->type ?></td>

                                </tr>
                                <!--Start Modal Delete Data -->
                            <div class="modal fade" id="myModaldelete<?php echo $rows->contraMasterId; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="cmxform form-horizontal tasi-form" id="delpaymentvou<?php echo $rows->contraMasterId; ?>" method="post" action="<?php echo site_url('contravoucher/contravoucher/deletecontravoucher') ?>">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Delete message</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="panel-body">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h5><i class="fa fa-warning"></i>&nbsp; Are You Sure You Want To Delete The Contra Voucher :&nbsp;&nbsp;<?php echo $rows->contraMasterId; ?></h5>
                                                                <input id="contraMasterId" name="contraMasterId" type=hidden value="<?php echo $rows->contraMasterId; ?>" />                                                                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" >YES</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
<!--                            end delete modal-->
<!--                            Edit Journal Entry Modal Start -->
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModaledit<?php echo $rows->contraMasterId ?>" class="modal fade">
                                <div class="modal-dialog">
                                    <form class="cmxform form-horizontal tasi-form" id="edit<?php echo $rows->contraMasterId ?>" method="post" action="<?php echo site_url('contravoucher/contravoucher/editcontravoucher') ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">Edit Contravoucher Entry</h4>
                                            </div>
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
                                                    <button type="submit"  class="btn btn-primary" onclick="return amountCheck(<?php echo $rows->contraMasterId ?>)">Save</button>
                                                    <button type="reset" class="btn btn-info">Clear</button>
                                                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                             </div>
                                    </form>
                               
                            </div>
                                 </div>
                            <!--End of edit Modal -->
                            <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
</section>

<!--- Add New Journal Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Add Contra Voucher</h4>
            </div>
            <div class="modal-body">  
                <form class="cmxform form-horizontal tasi-form" id="" method="post" action="<?php echo site_url('contravoucher/contravoucher/addcontravoucher') ?>">
                    <div class="row">  
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-6" style="padding-left: 0px">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px;">
                            <div class="panel-body">
                                <div class="form-group" style="padding-top: 3px">
                                    <label for="opening_balance" class="control-label col-lg-4">Bank Account</label>
                                    <div class="col-lg-6">
                                        <select class=" form-control selectpicker" data-live-search="true" id="ledgerId" name="ledgerId" required>
                                            <option value="">Select</option>                                            
                                            <?php
                                            foreach ($ledger as $value) {
                                                $accNo = $value->accNo;
                                                echo "<option value='" . $value->ledgerId . "'>$accNo - $value->acccountLedgerName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>                               
                                </div>                           
                            </div>
                        </div>
                        <div id='TextBoxesGroup'>
                            <div id="TextBoxDiv1">
                                <div class="col-lg-12" style="padding-left: 0px"> 
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="opening_balance" class="control-label col-lg-4">Cash/Bank Account</label>
                                            <div class="col-lg-6">
                                                <select class=" form-control selectpicker" data-live-search="true" id="second_ledgerId" name="new_ledgerId" required>
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($allledgerdata as $value) {
                                                        $accNo = $value->accNo;
                                                        echo "<option value='" . $value->ledgerId . "'>$accNo - $value->acccountLedgerName</option>";
                                                    }
                                                    ?>                                                   
                                                </select>
                                            </div>                                  
                                        </div>
                                    </div>                             
                                </div>  
                            </div>
                        </div>                        
                        <div class="col-lg-12" style="padding-left: 0px;"> 
                            <div class="panel-body">
                                <div class="form-group ">                                   
                                    <label for="opening_balance"class="control-label col-lg-4">Total Amount</label>
                                    <div class="col-lg-6 ">
                                        <input class="form-control " type="text" id="amount" placeholder="0.00"
                                               name="amount" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"> 
                            <div class="form-group">  
                                <div class="col-lg-4"></div>
                                <div class="col-lg-6">
                                    <span id="valuecheck"> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-4">Date</label>
                                    <div class="col-lg-6">
                                        <input class="form-control " id="datetimepicker" name="date" value="<?php echo Date('Y-m-d 00:00:00'); ?>"/>
                                    </div>                               
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-4">Cheque No</label>
                                    <div class="col-lg-6">
                                        <input class="form-control " id="chequeNo" name="chequeNo"/>
                                    </div>                               
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0px">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-4">Cheque Date</label>
                                    <div class="col-lg-6">
                                        <input class="form-control " id="chequedatetimepicker" name="chequeDate" />
                                    </div>                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="return addamountCheck()">Save</button>
                        <button type="reset" class="btn btn-info">Clear</button>
                        <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     </div>
    <!--End Of Add Journal MOdal -->
                                      
    <script>
    $(document).ready(function() {
        $("#addpurchase_submit").click(function() {
            $("#addpurchase_submit").prop("disabled", true);
        });
    });
</script>



