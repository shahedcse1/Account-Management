<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Farmer 
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
                            <button  class="btn btn-info" id="addfarmer" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                               
                                <th>Account No</th>
                                <th>Farmer Name</th>
                                <th>User Name</th>
                                <th>Password</th>
                                <th>Name Of Business</th>
                                <th>Address</th>
                                <th>Mobile No</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php
                            if (sizeof($alldata) > 0):
                                $totalbalance = 0;
                                $action = '';
                                foreach ($alldata as $row):
                                    $flag = 0;
                                    foreach ($ledgerposting as $balance):
                                        if ($row->ledgerId == $balance->ledgerId):
                                            if ($balance->debit > $balance->credit):
                                                $totalbalance = $balance->debit - $balance->credit;
                                                $action = 'Dr';
                                            else:
                                                $totalbalance = $balance->credit - $balance->debit;
                                                $action = 'Cr';
                                            endif;
                                            $flag = 1;
                                        endif;
                                        if ($flag == 0):
                                            $totalbalance = 0.00;
                                            $action = '';
                                        endif;
                                    endforeach;
                                    ?>                          
                                    <tr>                                    
                                        <td>
                                            <a data-toggle="modal" href="#myModaldelete<?php
                                            if ($row->defaultOrNot == 1) {
                                                echo '00';
                                            } else {
                                                echo $row->ledgerId;
                                            }
                                            ?>"><i class="fa fa-times-circle delete-icon" ></i></a>
                                        </td>
                                        <td><?php echo $row->accNo; ?></td>
                                        <td><?php
                                            if ($row->defaultOrNot == 1) {
                                                echo'<a href="#" data-toggle="modal" data-target="#myModaledit00"></a>';
                                            } else {
                                                echo '<a href="#" onclick="getfarmerinfo(' . $row->ledgerId . ')">' . $row->acccountLedgerName . '</a>';
                                            }
                                            ?>                                             
                                        </td>
                                        <td><?php echo $row->fax; ?></td>
                                        <td><?php echo $row->tin; ?></td>
                                        <td><?php echo $row->nameOfBusiness; ?></td>
                                        <td><?php echo $row->address; ?></td>
                                        <td><?php echo $row->mobileNo; ?></td>
                                        <td><?php echo number_format($totalbalance, 2) . '  ' . $action; ?></td> 
                                        <?php
                                        if ($row->status == 1):
                                            echo "<td>" . "Active" . " </td>";
                                        else:
                                            echo "<td>" . "Inactive" . " </td>";
                                        endif;
                                        ?>
                                    </tr>    
                                    <!-- start modal for edit data-->

                                    <!--End of edit -->
                                    <!--Start Modal Delete Data -->
                                <div class="modal fade" id="myModaldelete<?php echo $row->ledgerId; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h3 class="modal-title" id="myModalLabel" align="Center">Delete message</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <h5><i class="fa fa-warning"></i>&nbsp; Are You Sure You Want To Delete Farmer :&nbsp;&nbsp;<?php echo $row->acccountLedgerName ?></h5>
                                                    <input id="ledgerId" name="ledgerId" type=hidden value="<?php echo $row->ledgerId; ?>" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="deletefarmer<?php echo $row->ledgerId; ?>" class="btn btn-danger" onclick="return deleteFarmer(<?php echo $row->ledgerId; ?>)">YES</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--end delete modal-->
                                <?php
                            endforeach;
                        endif;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
</section>
<!---------------------------------------------------- edit modal start---------------------------------------------------------------->

<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="cmxform form-horizontal tasi-form" id="editaccgroup" method="post" action="<?php echo site_url('farmer/farmer/editfarmer'); ?>" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Edit Farmer Account</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">                                                                                                           
                            <div class="form">
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="accountno" class="control-label col-lg-4">Account No :</label>
                                        <div class="col-lg-8">
                                            <input type="hidden" name="editledgerId" id="editledgerId"/>                                         
                                            <input class=" form-control" id="editaccountno" name="accountno"  type="text" value="" onchange="return checkuniqueAccNoForEdit()" required />                                       
                                            <span id="editaccountnomsg"></span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="editacccountLedgerName" class="control-label col-lg-4">Farmer Name :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="edituserid" name="cst" type="hidden" value="" />
                                            <input class=" form-control" id="editacccountLedgerName" name="editacccountLedgerName" type="text" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="editusername" class="control-label col-lg-4">Login Name:</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="editusername" name="fax" type="text"  value=""/>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="editpassword" class="control-label col-lg-4">Password:</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="editpassword" name="tin" type="text"  value=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="nameofbusiness" class="control-label col-lg-4">Name Of Business :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="editnameofbusiness" name="nameofbusiness"  type="text" value=""  />                                       
                                        </div>
                                    </div>
                                </div> 
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="Address" class="control-label col-lg-4">Address :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="editaddress" name="editaddress"  type="text" value="" />                                       
                                        </div>
                                    </div>
                                </div> 

                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="Mobile" class="control-label col-lg-4">Mobile :</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="editmobileNo" name="editmobileNo"  type="text" value=""/>                                       
                                        </div>
                                    </div>
                                </div> 

                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="openingBalance" class="control-label col-lg-4">Opening Balance :</label>
                                        <div class="col-lg-5">
                                            <input  class="form-control "  type="text" id="editopeningBalance" name="editopeningBalance" value="" />
                                        </div>
                                        <div class="col-lg-2 col-sm-2">
                                            <div id="putdebitorcredit"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="description" class="control-label col-lg-4">Description :</label>
                                        <div class="col-lg-8">
                                            <textarea class=" form-control" id="editdescription" name="editdescription"  type="text"></textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="status_edit" class="control-label col-lg-4">Status</label>
                                        <div class="col-lg-8 col-sm-8">
                                            <select name="status_edit" id="status_edit" class="customer_debit pull-right form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>  
                        </div>                                                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updatefarmer" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>                                      
    </form>                                 
</div>
<!--Add Farmer modal Start-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="addfarmer" method="post" action="#">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Add Farmer Information</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="accountno" class="control-label col-lg-4">Account No:</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="accountno" name="accountno"  type="text" required  onchange="return checkuniqueAccNo()" />
                                        <span id="accountnomsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="acccountLedgerName" class="control-label col-lg-4">Farmer Name :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="acccountLedgerName" name="acccountLedgerName"  type="text" required  onchange="return accountNameCheck()" />
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="username" class="control-label col-lg-4">Login name</label>

                                    <div class="col-lg-8">
                                        <input class="form-control " id="username" name="username" type="text"/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="password" class="control-label col-lg-4">Password</label>

                                    <div class="col-lg-8">
                                        <input class="form-control " id="password" name="password" type="text"/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="nameofbusiness" class="control-label col-lg-4">Name Of Business :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="nameofbusiness" name="nameofbusiness"  type="text" required />                                       
                                    </div>
                                </div>
                            </div> 
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="Address" class="control-label col-lg-4">Address :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="address" name="address"  type="text" required />                                       
                                    </div>
                                </div>
                            </div> 

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="Mobile" class="control-label col-lg-4">Mobile :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="mobileNo" name="mobileNo"  type="text" required />                                       
                                    </div>
                                </div>
                            </div> 

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="openingBalance" class="control-label col-lg-4">Opening Balance :</label>
                                    <div class="col-lg-5">
                                        <input  class="form-control "  type="text" id="openingBalance" name="openingBalance" value="0.00" />
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
                                    <label for="status" class="control-label col-lg-4">Status</label>
                                    <div class="col-lg-8 col-sm-8">
                                        <select name="status" id="status" class="customer_debit pull-right form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>



                            <input class=" form-control" id="accountGroupId" name="accountGroupId" value="13" type="hidden" required  />
                            <input class=" form-control" id="creditPeriod" name="creditPeriod" value="0" type="hidden" required  />
                            <input class=" form-control" id="billByBill" name="billByBill" value="1" type="hidden" required  />
                            <input class=" form-control" id="cst" name="cst"  type="hidden"  />
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" id="submitnewfarmer"  class="btn btn-primary" onclick="return addledger();">Save</button>
                    <button type="reset" class="btn btn-info">Clear</button>
                    <button type="button" class="btn btn-default " data-dismiss="modal" id="addfarmercancle">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div> 
<!-----------------------Delete builtin farmer--------------->
<div class="modal fade" id="myModaldelete00" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete message</h4>
            </div>
            <div class="modal-body">    
                <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete builtin farmer!!</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- Warning Delete modal for accessed-->
<div class="modal fade" id="deletedinaccessed" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete message</h4>
            </div>
            <div class="modal-body">    
                <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this farmer!! This farmer is in used</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" id="deletefarmer_account" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- end warning delete modal-->
<!---------End of Add New Farmer------------------------>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#addfarmer").prop("disabled", true);
            $("#deletefarmer_account").prop("disabled", true);
            $("#updatefarmer").prop("disabled", true);
        }
    });
</script>
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Farmer Updated Successfully',
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
                text: 'Farmer Updated Fail',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>
<script type="text/javascript">
    function getfarmerinfo(id) {
        var dataString = "acccountLedgerid=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('farmer/farmer/editdebitorcredit'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#putdebitorcredit").html(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/getcustomerinfo'); ?>",
            data: dataString,
            success: function (data)
            {
                var jobj = $.parseJSON(data);
                $.each(jobj, function () {
                    $("#editledgerId").val(id);
                    $("#editacccountLedgerName").val(this['acccountLedgerName']);
                    $("#editaccountno").val(this['accNo']);
                    $("#editusername").val(this['fax']);
                    $("#editpassword").val(this['tin']);
                    $("#edituserid").val(this['cst']);
                    $("#editaccountnoOld").val(this['accNo']);
                    $("#editnameofbusiness").val(this['nameOfBusiness']);
                    $("#editaddress").val(this['address']);
                    $("#editmobileNo").val(this['mobileNo']);
                    $("#editopeningBalance").val(this['openingBalance']);
                    $("#editdescription").val(this['description']);
                    $("#status_edit").val(this['status']);
                    $("#myModaledit").modal('show');
                });
            }
        });
    }

    function checkuniqueAccNo() {
        var dataString = "accountno=" + $("#accountno").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/checkuniqueaccountno'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data == 'free') {
                    $("#accountnomsg").text("");
                    $("#accountnomsg").text("Valid account No");
                    $("#accountnomsg").css('color', 'green');
                    $("#submitnewfarmer").prop('disabled', false);
                }
                if (data == 'booked') {
                    $("#accountnomsg").text("");
                    $("#accountnomsg").text("This number already used !!");
                    $("#accountnomsg").css('color', 'red');
                    $("#submitnewfarmer").prop('disabled', true);
                }
            }
        });
    }

    function checkuniqueAccNoForEdit(id) {
        var dataString = "accountno=" + $("#editaccountno").val() + "&accountnoOld=" + $("#editaccountnoOld").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/checkuniqueaccountnoForedit'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data == 'free') {
                    $("#editaccountnomsg").text("");
                    $("#editaccountnomsg").text("Valid account No");
                    $("#editaccountnomsg").css('color', 'green');
                    $("#updatefarmer").prop('disabled', false);
                }
                if (data == 'booked') {
                    $("#editaccountnomsg").text("");
                    $("#editaccountnomsg").text("This number already used !!");
                    $("#editaccountnomsg").css('color', 'red');
                    $("#updatefarmer").prop('disabled', true);
                }
            }
        });
    }
    function accountNameCheck() {
        var acccountLedgerName = $("#acccountLedgerName").val();
        var dataString = "acccountLedgerName=" + acccountLedgerName;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('farmer/farmer/accountNameCheck'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'free') {
                    $("#acccountLedgerName").css('border-color', 'green');
                    $("#servermsg").text("Farmer name available");
                    $("#servermsg").css('color', 'green');
                    return true;
                }
                if (data === 'booked') {
                    $("#acccountLedgerName").css('border-color', 'red');
                    $("#servermsg").text("Farmer Name not Available. Please try another");
                    $("#servermsg").css('color', 'red');
                }
            }
        });
    }
    function addledger() {
        var accountLedgerName = $("#servermsg").html();
        if (accountLedgerName === "Farmer Name not Available. Please try another") {
            $("#acccountLedgerName").focus();
            return false;
        } else {
            var acccountLedgerName = $("#acccountLedgerName").val();
            var accountGroupId = $("#accountGroupId").val();
            var openingBalance = $("#openingBalance").val();
            var debitOrCredit = $("#debitOrCredit").val();
            var address = $("#address").val();
            var nameofbusiness = $("#nameofbusiness").val();
            var accno = $("#accountno").val();
            var creditPeriod = $("#creditPeriod").val();
            var mobileNo = $("#mobileNo").val();
            var fax = $("#username").val();
            var tin = $("#password").val();
            var cst = $("#cst").val();
            var defaultOrNot = $("#defaultOrNot").val();
            var description = $("#description").val();
            var billByBill = $("#billByBill").val();
            var status = $("#status").val();
            if (acccountLedgerName.length < 1) {
                $("#servermsg").css({"display": "block", "color": "red"});
                $("#servermsg").text("Please Enter Farmer Name ");
                return false;
            } else {
                $("#servermsg").css({"display": "none"});
                var dataString = "acccountLedgerName=" + acccountLedgerName + "&accountGroupId=" + accountGroupId + "&openingBalance=" + openingBalance + "&debitOrCredit=" + debitOrCredit + "&address=" + address + "&nameofbusiness=" + nameofbusiness + "&creditPeriod=" + creditPeriod + "&mobileNo=" + mobileNo + "&fax=" + fax + "&tin=" + tin + "&cst=" + cst + "&defaultOrNot=" + defaultOrNot + "&description=" + description + "&billByBill=" + billByBill + "&accountno=" + accno + "&status=" + status;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('farmer/farmer/addAccLedger'); ?>",
                    data: dataString,
                    success: function (data)
                    {
                        if (data == 'Added') {
                            $('#myModal').modal('hide');
                            $.gritter.add({
                                title: 'Successfull!',
                                text: 'Farmer Added Successfully',
                                sticky: false,
                                time: '5000'
                            });
                            setTimeout("window.location.reload(1)", 2000);
                            return true;
                        }
                        if (data == 'Notadded') {
                            $('#myModal').modal('hide');
                            $.gritter.add({
                                title: 'Unsuccessfull!',
                                text: 'Farmer Added Failed',
                                sticky: false,
                                time: '2000'
                            });
                        }
                    }
                });
            }
        }
    }

    function deleteFarmer(id)
    {
        var dataString = "ledgerId=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('farmer/farmer/deleteFarmer'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data == 'Deleted') {
                    $('#myModaldelete' + id).modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Farmer Deleted Successfully',
                        sticky: false,
                        time: '5000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                }
                if (data == 'Notdeleted') {
                    $('#myModaldelete' + id).modal('hide');
                    $("#deletedinaccessed").modal('show');
                }
            }
        });
    }
</script>