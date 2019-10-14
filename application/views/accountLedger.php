<section id="main-content" >
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading">
                Account Ledger
            </header>
            <style>
                #myModalLabel{
                    font-weight: bold
                }
            </style>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">                         
                            <button  class="btn btn-info" id="addaccountledger" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>                  
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                               
                                <th>Account Ledger Name</th>
                                <th>Group Under</th>
                                <th>Description</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php foreach ($alldata as $row): ?>                          
                                <tr>
                                    <td >
                                        <?php if ($row->defaultOrNot == 1) { ?>
                                            <a href="#" data-toggle="modal" data-target="#myModaldelete00"<i class="fa fa-times-circle delete-icon" ></i></a>
                                        <?php } else { ?>
                                            <a href="#" onclick="showdeletemodal(<?php echo $row->ledgerId; ?>)"><i class="fa fa-times-circle delete-icon" ></i></a>
                                        <?php }
                                        ?>                                        
                                    </td>                                                           
                                    <td>
                                        <?php if ($row->defaultOrNot == 1) { ?>
                                            <a href="#" onclick="getledgerinfobyidfordefault(<?php echo $row->ledgerId; ?>)"><?php echo $row->acccountLedgerName; ?> </a>
                                        <?php } else { ?>
                                            <a href="#" onclick="getledgerinfobyid(<?php echo $row->ledgerId; ?>)"><?php echo $row->acccountLedgerName; ?></a>
                                        <?php } ?>
                                    </td>                                          
                                    <td>
                                        <?php
                                        foreach ($sortalldata as $acgrp):
                                            if ($row->accountGroupId == $acgrp->accountGroupId):
                                                echo $acgrp->accountGroupName;
                                            endif;
                                        endforeach;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row->description; ?>
                                    </td>                           
                                </tr>    
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </section>
    </section>
</section>
<!--Start Modal Delete Data -->
<div class="modal fade" id="myModaldelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="#">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <h5><i class="fa fa-warning"></i>&nbsp; Are you sure want to delete this account ledger</h5>
                                    <input id="deleteledgerid" name="ledgerId" type=hidden value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="deleteledger" class="btn btn-danger" onclick="deleteAccLedger()">YES</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end delete modal-->
<!-- Modal Edit Start Here-->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="editaccgroup" method="post" action="<?php echo site_url('accountLedger/editAccLedger'); ?>" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Edit Account Ledger</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">                                                                                                           
                            <div class="form">
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="editacccountLedgerName" class="control-label col-lg-4">Account Ledger Name :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="editledgerId" name="ledgerid" type="hidden" value="">
                                            <input class=" form-control" id="oldaccountledgername" name="oldledgername" type="hidden" value="">
                                            <input class=" form-control" id="editacccountLedgerName" name="ledgername" type="text" value="" onchange="return editaccountNameCheck()" required/>
                                            <span id="editservermsg"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="editaccountGroupId" class="control-label col-lg-4">Account Group Name :</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="editaccountGroupId" data-live-search="true" name="accountgroupid" type="text" onchange="return checkgroup(this.value)">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="openingBalance" class="control-label col-lg-4">Opening Balance :</label>
                                        <div class="col-lg-5">
                                            <input  class="form-control "  type="text" id="editopeningBalance" name="openingbalance" value="" />
                                        </div>
                                        <div class="col-lg-2 col-sm-2">
                                            <div id="debitcreditselect"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="description" class="control-label col-lg-4">Description :</label>
                                        <div class="col-lg-8">
                                            <textarea class=" form-control" id="editdescription" name="description"  type="text" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="creditPeriod" class="control-label col-lg-4">Credit Period :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="editcreditPeriod" name="creditperiod"  type="text" value="" />                                                                                                                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="billByBill" class="control-label col-lg-4">Bill by Bill  :</label>
                                        <div class="col-lg-8">                                                                       
                                            <div id="billbyyesno"></div>
                                        </div>                                    

                                    </div>
                                </div>  
                            </div>                                                       
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateaccountledgeronAdd" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>                                      
        </form>                                 
    </div>
</div>

<!-- Modal for default balance update-->
<div class="modal fade" id="myModaleditdefault" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="editaccgroup" method="post" action="<?php echo site_url('accountLedger/editAccLedgerDefault'); ?>" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Edit Account Ledger</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">                                                                                                           
                            <div class="form">
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="editacccountLedgerName" class="control-label col-lg-4">Account Ledger Name :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="defaulteditledgerId" name="defaultledgerid" type="hidden" value="">                                            
                                            <input class=" form-control" id="defaulteditacccountLedgerName" name="ledgername" type="text" value="" readonly required/>
                                            <span id="editservermsg"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="defaultgroupnamestop">
                                    <div class="form-group">
                                        <label for="editaccountGroupId" class="control-label col-lg-4">Account Group Name :</label>
                                        <div class="col-lg-8">                                           
                                            <!--  <div id="accgrouplist"></div>-->
                                            <select class="form-control" id="defaulteditaccountGroupId" data-live-search="true" name="accountgroupid" type="text" onchange="return checkgroup(this.value)">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="openingBalance" class="control-label col-lg-4">Opening Balance :</label>
                                        <div class="col-lg-5">
                                            <input class="form-control" type="text" id="defaulteditopeningBalance" name="openingbalance" value="" />
                                        </div>
                                        <div class="col-lg-2 col-sm-2">
                                            <div id="debitcreditselectdefault"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="description" class="control-label col-lg-4">Description :</label>
                                        <div class="col-lg-8">
                                            <textarea class=" form-control" id="defaulteditdescription" name="description"  type="text" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="creditPeriod" class="control-label col-lg-4">Credit Period :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="defaulteditcreditPeriod" name="creditperiod"  type="text" value="" readonly/>                                                                                                                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body" id="billbybillstop">
                                    <div class="form-group ">
                                        <label for="billByBill" class="control-label col-lg-4">Bill by Bill  :</label>
                                        <div class="col-lg-8">                                                                       
                                            <select class="form-control" id="editbillByBill" name="billbybill">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>                                                                                
                                            </select>  
                                        </div> 
                                    </div>
                                </div>  
                            </div>                                                       
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateaccountledger" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>                                      
        </form>                                 
    </div>
</div>
<!-- end default ledger update-->
<!-- Warning Delete modal-->
<div class="modal fade" id="myModaldelete00" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Delete message</h4>
            </div>
            <div class="modal-body">    
                <p><h4><i class="fa fa-warning"></i>&nbsp;You can not delete a built-in Account Ledger </h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- end warning delete modal-->
<!-- Warning Delete modal for accessed-->
<div class="modal fade" id="deletedinaccessed" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete message</h4>
            </div>
            <div class="modal-body">    
                <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this account ledger!! This account ledger is in used</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- end warning delete modal-->
<!-- Add Account Group Ledger -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="addaccledger" method="post" action="#">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Add Account Ledger</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="acccountLedgerName" class="control-label col-lg-4">Account Ledger Name :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="acccountLedgerName" name="acccountLedgerName"  type="text" onchange="return accountNameCheck()" />
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="accountGroupId" class="control-label col-lg-4">Account Group Name :</label>
                                    <div class="col-lg-8 myselect">
                                        <select class="form-control col-lg-6 selectpicker" id="accountGroupId" data-live-search="true" name="accountGroupId" type="text"  onchange="return checkgroup();">
                                            <option value="">-- Group Under --</option>
                                            <?php foreach ($sortalldata as $row): ?>
                                                <option value="<?php echo $row->accountGroupId; ?>"><?php echo $row->accountGroupName; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="grpmsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="openingBalance" class="control-label col-lg-4">Opening Balance :</label>
                                    <div class="col-lg-5">
                                        <input  class="form-control "  type="text" id="openingBalance" name="openingBalance" value="" />
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <select class="supplier_debit pull-right" id="debitOrCredit">
                                            <option value="1">Dr</option>
                                            <option value="0">Cr</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-4">Description :</label>
                                    <div class="col-lg-8">
                                        <textarea class=" form-control" id="description" name="description"  type="text" ></textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="creditPeriod" class="control-label col-lg-4">Credit Period :</label>
                                    <div class="col-lg-8">                                            
                                        <input class=" form-control" id="creditPeriod" name="creditPeriod"  type="text"  />
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="billByBill" class="control-label col-lg-4">Bill by Bill  :</label>
                                    <div class="col-lg-8">
                                        <select id="billByBill" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>  
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" onclick="return addledger();">Save</button>
                    <button type="reset" class="btn btn-info">Clear</button>
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>    
</div>
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Account Ledger Updated Successfully',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('success');
endif;
?>
<?php if ($this->session->userdata('fail')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Account Ledger Updated Fail',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>
<script>
    function getledgerinfobyid(id) {
        var dataString = "acccountLedgerid=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/getaccountgrouplist'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#editaccountGroupId").append(data).selectpicker();
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/selectdebitorcredit'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#debitcreditselect").html(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/billbyyesorno'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#billbyyesno").html(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/getledgerinfo'); ?>",
            data: dataString,
            success: function (data)
            {
                var jobj = $.parseJSON(data);
                $.each(jobj, function () {
                    $("#editledgerId").val(id);
                    $("#editacccountLedgerName").val(this['acccountLedgerName']);
                    $("#oldaccountledgername").val(this['acccountLedgerName']);
                    $("#editopeningBalance").val(this['openingBalance']);
                    $("#editdescription").val(this['description']);
                    $("#editcreditPeriod").val(this['creditPeriod']);
                    $("#myModaledit").modal('show');
                });
            }
        });
    }

    function getledgerinfobyidfordefault(id) {
        var dataString = "acccountLedgerid=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/getaccountgrouplist'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#defaulteditaccountGroupId").append(data).selectpicker();
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/selectdebitorcredit'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#debitcreditselectdefault").html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/getledgerinfo'); ?>",
            data: dataString,
            success: function (data)
            {
                var jobj = $.parseJSON(data);
                $.each(jobj, function () {
                    $("#defaulteditledgerId").val(id);
                    $("#defaulteditacccountLedgerName").val(this['acccountLedgerName']);
                    $("#defaulteditopeningBalance").val(this['openingBalance']);
                    $("#defaulteditdescription").val(this['description']);
                    $("#defaulteditcreditPeriod").val(this['creditPeriod']);
                    if (this['defaultOrNot'] === '1') {
                        $("#defaultgroupnamestop").find('select').attr('disabled', 'disabled');
                        $("#billbybillstop").find('select').attr('disabled', 'disabled');
                    }
                    $("#myModaleditdefault").modal('show');
                });
            }
        });
    }

    function showdeletemodal(deleteid) {
        $("#deleteledgerid").val(deleteid);
        $("#myModaldelete").modal('show')
    }
</script>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#updateaccountledger").prop("disabled", true);
            $("#updateaccountledgeronAdd").prop("disabled", true);
            $("#editledger").prop("disabled", true);
            $("#deleteledger").prop("disabled", true);
            $("#addaccountledger").prop("disabled", true);
        }
    });
</script>
<script type="text/javascript">
    function editreload(id) {
        $("#editaccgroup" + id)[0].reset();
    }
    function editaccountNameCheck() {
        var dataString = "acccountLedgerName=" + $("#editacccountLedgerName").val() + "&oldledgername=" + $("#oldaccountledgername").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/accountNameCheckdefault'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'free') {
                    $("#editacccountLedgerName").css('border-color', 'green');
                    $("#editservermsg").text("Account Ledger name available");
                    $("#editservermsg").css('color', 'green');
                    $("#updateaccountledgeronAdd").prop('diabled', false);
                    return true;
                }
                if (data === 'booked') {
                    $("#editacccountLedgerName").css('border-color', 'red');
                    $("#editservermsg").text("Account Ledger Name not Available. Please try another");
                    $("#editservermsg").css('color', 'red');
                    $("#updateaccountledgeronAdd").prop('diabled', true);
                    return false;
                }
            }
        });
    }
    function accountNameCheck() {
        var dataString = "acccountLedgerName=" + $("#acccountLedgerName").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/accountNameCheck'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'free') {
                    $("#acccountLedgerName").css('border-color', 'green');
                    $("#servermsg").text("Account Ledger name available");
                    $("#servermsg").css('color', 'green');
                    return true;
                }
                if (data === 'booked') {
                    $("#acccountLedgerName").css('border-color', 'red');
                    $("#servermsg").text("Account Ledger Name not Available. Please try another");
                    $("#servermsg").css('color', 'red');
                }
            }
        });
    }

    function addledger() {
        var accountLedgerName = $("#servermsg").html();
        if (accountLedgerName === "Account Ledger Name not Available. Please try another") {
            $("#acccountLedgerName").focus();
            return false;
        } else {
            var acccountLedgerName = $("#acccountLedgerName").val();
            var accountGroupId = $("#accountGroupId").val();
            var openingBalance = $("#openingBalance").val();
            var debitOrCredit = $("#debitOrCredit").val();
            var creditPeriod = $("#creditPeriod").val();
            var description = $("#description").val();
            var billByBill = $("#billByBill").val();
            if (acccountLedgerName.length < 1) {
                $("#servermsg").css({"display": "block", "color": "red"});
                $("#servermsg").text("Please Enter Account Ledger Name ");
                return false;
            }
            if (accountGroupId.length < 1) {
                $("#grpmsg").css({"display": "block", "color": "red"});
                $("#grpmsg").text("Please Enter Account Group ");
                return false;
            }
            else {
                var dataString = "acccountLedgerName=" + acccountLedgerName + "&accountGroupId=" + accountGroupId + "&openingBalance=" + openingBalance + "&debitOrCredit=" + debitOrCredit + "&creditPeriod=" + creditPeriod + "&description=" + description + "&billByBill=" + billByBill;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('accountLedger/addAccLedger'); ?>",
                    data: dataString,
                    success: function (data)
                    {
                        if (data == 'Added') {
                            $('#myModal').modal('hide');
                            $.gritter.add({
                                title: 'Successfull!',
                                text: 'Account Ledger  Added Successfully',
                                sticky: false,
                                time: '5000'
                            });
                            $("#addaccledger")[0].reset();
                            setTimeout("window.location.reload(1)", 2000);
                        }
                        if (data == 'Notadded') {
                            $('#myModal').modal('hide');
                            $.gritter.add({
                                title: 'Unsuccessfull!',
                                text: 'Account Ledger Not Added ',
                                sticky: false,
                                time: '5000'
                            });
                            $("#addaccledger")[0].reset();
                        }
                    }
                });
            }
        }
    }

    function checkgroup(id)
    {
        var editaccountGroupId = "#editaccountGroupId" + id;
        var editaccountGroupId = $(editaccountGroupId).val();
        if (editaccountGroupId === '27' || editaccountGroupId === '28') {
            $('#editcreditPeriod' + id).prop('readonly', false);
            $('#editbillByBill' + id).prop('disabled', false);
        }
        else
        {
            $('#editcreditPeriod' + id).prop('readonly', true);
            $('#editbillByBill' + id).prop('disabled', true);
        }
        var accountGroupId = $('#accountGroupId').val();
        if (accountGroupId === '27' || accountGroupId === '28') {
            $('#creditPeriod').prop('readonly', false);
            $('#billByBill').prop('disabled', false);
        }
        else
        {
            $('#creditPeriod').prop('readonly', true);
            $('#billByBill').prop('disabled', true);
        }
    }
    function deleteAccLedger()
    {
        var dataString = "ledgerId=" + $("#deleteledgerid").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('accountLedger/deleteAccLedger'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data == 'deleted') {
                    $('#myModaldelete').modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Account Ledger Deleted Successfully',
                        sticky: false,
                        time: '5000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                }
                if (data == 'notdeleted') {
                    $('#myModaldelete').modal('hide');
                    $("#deletedinaccessed").modal('show');
                }
            }
        });
    }
</script>
