<style>
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
                            <button id="addcontra"  class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>                          
                        </div>                        
                    </div>                      

                    <table class="display table table-bordered table-striped" id="payment-voucher-datatable">
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
                    </table>   


                    <!--Start Modal Delete Data -->
                    <div class="modal fade" id="myModaldelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form class="cmxform form-horizontal tasi-form" method="post" action="<?php echo site_url('contravoucher/contravoucher/deletecontravoucher') ?>">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Delete message</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="panel-body">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <h5><i class="fa fa-warning"></i>&nbsp; Are You Sure You Want To Delete The Payment Voucher :&nbsp;&nbsp;<b id="contraVoucherNo"></h5>
                                                        <input name="contraMasterId" id="contraMasterId" type=hidden />                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="deletecontra" type="submit" class="btn btn-danger" >YES</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>  
                    <!--end delete modal-->

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
    $(document).ready(function () {
        var oTable = $('#payment-voucher-datatable').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('contravoucher/contravoucher/getContraDetailsTable'); ?>',
            "order": [[2, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]
        });
    });


    function deleteModalFun(masterId) {
        $("#contraVoucherNo").text(masterId);
        $("#contraMasterId").val(masterId);
        $("#myModaldelete").modal('show');
    }
</script>

<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#addcontra").prop("disabled", true);
            $("#deletecontra").prop("disabled", true);
        }
    });
</script>