<style>
    #myModalLabel{
        font-weight: bold
    }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Customer Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <button class="btn btn-info" id="addcustomer">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <table class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Account No</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th>Balance</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (sizeof($customerinfo) > 0) {
                                $totalbalance = 0;
                                $action = '';
                                foreach ($customerinfo as $customer) {
                                    $flag = 0;
                                    foreach ($ledgerposting as $balance) {
                                        if ($customer->ledgerId == $balance->ledgerId) {
                                            if ($balance->debit > $balance->credit) {
                                                $totalbalance = $balance->debit - $balance->credit;
                                                $action = 'Dr';
                                            } elseif ($balance->debit == $balance->credit) {
                                                $totalbalance = 0.00;
                                                $action = '';
                                            } else {
                                                $totalbalance = $balance->credit - $balance->debit;
                                                $action = 'Cr';
                                            }
                                            $flag = 1;
                                        }
                                        if ($flag == 0) {
                                            $totalbalance = 0.00;
                                            $action = '';
                                        }
                                    }
                                    ?>
                            <tr>
                                <td><a href="#" onclick="showdeletemodal(<?= $customer->ledgerId; ?>,<?= $customer->cst; ?>)"><i  class="fa fa-times-circle delete-icon"></i> </a></td>
                                <td> <?= $customer->accNo; ?> </td>
                                <td><a href="#" onclick="getcustomerinfo(<?= $customer->ledgerId; ?>)"><?= $customer->acccountLedgerName; ?> </a></td>
                                <td><?= $customer->mobileNo ?></td>
                                <td><?= number_format($totalbalance, 2) . ' ' . $action; ?></td>
                                <td><?= $customer->status == 1 ? 'Active' : 'Inactive'; ?></td>
                            </tr>
                            <?php
                                }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->


<!----------------------------
        Edit Customer
 ---------------------------->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Edit Customer Information</h4>
            </div>
            <form class="cmxform form-horizontal tasi-form" id="supplier_add" method="post" action="<?= site_url('customer/customer/edit') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Account Number -->
                            <div class="panel-body" id="editAccNoDiv" style="display: none;">
                                <div class="form-group ">
                                    <label for="editaccountno" class="control-label col-lg-4">Account No:</label>
                                    <div class="col-lg-8">
                                        <input type="hidden" name="accountnoOld" id="editaccountnoOld"/>
                                        <input class="form-control num-only"
                                               id="editaccountno"
                                               name="accountno"
                                               type="text"
                                               required
                                               maxlength="16"
                                               onchange="return checkuniqueAccNoForEdit()"/>
                                        <span id="editaccountnomsg"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="supplier_name" class="control-label col-lg-4">Customer Name:</label>
                                    <div class="col-lg-8">
                                        <input type="hidden" id="editcustomerid" name="editcustomerid" value=""/>
                                        <input type="hidden" id="edituserid" name="userid" value=""/>
                                        <input class="form-control" id="editcustomername" name="customer_name" type="text" onchange="return customerNameCheckedit()" value=""/>
                                        <span id="servermsg2"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="editpassword" class="control-label col-lg-4">Password:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="editpassword" name="password" type="text" value=""/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="mobile" class="control-label col-lg-4">Mobile:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="editmobile" name="mobile" type="text"  value=""/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="editgender" class="control-label col-lg-4">Gender</label>
                                    <div class="col-lg-8">                             
                                        <input name="editgender" id="editgenderm" value="Male" type="radio" /> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input name="editgender" id="editgenderf" value="Female" type="radio"/> Female                           
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="updatecustomer">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-------------------------
     Add New Customer
-------------------------->
<div class="modal fade" id="addcustomerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Add Customer Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="cmxform form-horizontal tasi-form" id="customer_add" method="post" action="#">
                            <!-- Customer Type -->
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="gender" class="control-label col-lg-4">Member Type</label>
                                    <div class="col-lg-8">
                                        <?php foreach ($membertypes as $membertype): ?>
                                            <label for="type<?= $membertype->id; ?>">
                                                <input name="customertype"
                                                       id="type<?= $membertype->id; ?>"
                                                       value="<?= $membertype->id; ?>"
                                                       <?= $membertype->id == '1' ? 'checked' : ''; ?>
                                                       type="radio" /> <?= $membertype->name; ?>
                                            </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Number -->
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="accountno" class="control-label col-lg-4">Account No</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"
                                               id="accountno"
                                               name="accountno"
                                               type="text"
                                               required
                                               value="<?= $accountno; ?>"
                                               disabled/>

                                        <input class="form-control num-only"
                                               id="accountnomanual"
                                               name="accountno"
                                               type="text"
                                               required
                                               style="display: none;"
                                               maxlength="16"/>
                                        <span id="accountnomsg"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Number -->
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="mobile" class="control-label col-lg-4">Mobile</label>
                                    <div class="col-lg-8">
                                        <input class="form-control num-only"
                                               id="mobile1"
                                               name="mobile"
                                               maxlength="11"
                                               minlength="11"
                                               type="text" />
                                        <span id="mobilenomsg"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Name -->
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="customer_name" class="control-label col-lg-4">Customer Name</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control"
                                               id="customer_name1"
                                               name="customer_name"
                                               type="text"
                                               required/>
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="password" class="control-label col-lg-4">Password</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"
                                               id="password"
                                               name="password"
                                               type="text"/>
                                    </div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="gender" class="control-label col-lg-4">Gender</label>
                                    <div class="col-lg-8">
                                        <label for="genderm">
                                            <input name="gender"
                                                   id="genderm"
                                                   value="Male"
                                                   type="radio"
                                                   checked /> Male
                                        </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label for="genderf">
                                            <input name="gender"
                                                   id="genderf"
                                                   value="Female"
                                                   type="radio" /> Female
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="status" class="control-label col-lg-4">Status</label>
                                    <div class="col-lg-8 col-sm-8">
                                        <select name="status" id="status" class="customer_debit pull-right form-control">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitaddcustomer" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-info">Reset</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="modalcloseforaddcustomer()">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--..............................Delete.........................-->

<div class="modal fade" id="myModaldeleteforcustomer" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="#">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Delete message</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="form">
                                        <h4><i class="fa fa-warning"></i>&nbsp;Are you sure want to delete the Customer</h4>
                                        <input type="hidden" name="deletecustomerid" id="deletecustomerid" value="">
                                        <input type="hidden" name="userid" id="deleteuserid" value="">
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="deletecustomer" onclick="return deletecustomerinfo()" class="btn btn-danger">YES</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>                    
                </div>
            </div>
        </form>
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
                <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this customer!! This customer is in used</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>

<!-- end warning delete modal-->
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Customer Updated Successfully',
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
                text: 'Customer Updated Fail',
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
    function checkuniqueAccNoForEdit() {
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
                    $("#updatecustomer").prop('disabled', false);
                }
                if (data == 'booked') {
                    $("#editaccountnomsg").text("");
                    $("#editaccountnomsg").text("This number already used !!");
                    $("#editaccountnomsg").css('color', 'red');
                    $("#updatecustomer").prop('disabled', true);
                }
            }
        });
    }
    function getcustomerinfo(id) {
        var dataString = "acccountLedgerid=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/customerdebitorcredit'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#showdebitorcredit").html(data);
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

                    if (this['membertype'] != 1) {
                        $('#editAccNoDiv').show();
                    }

                    $("#editcustomerid").val(id);
                    $("#editcustomername").val(this['acccountLedgerName']);
                    $("#editpassword").val(this['tin']);
                    $("#editaccountno").val(this['accNo']);
                    $("#editaccountnoOld").val(this['accNo']);
                    $("#editmobile").val(this['mobileNo']);
                    var gender = this['gender'];
                    if (gender == "Male") {
                        $("#editgenderm").prop("checked", true);
                    } else if (gender == "Female") {
                        $("#editgenderf").prop("checked", true);
                    }
                    $("#status_edit").val(this['status']);
                    $("#myModaledit").modal('show');
                });
            }
        });
    }


<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    var userrole = "<?php echo $this->sessiondata['userrole']; ?>";
    function showdeletemodal(deleteid, userid) {
        if (userrole != 'r') {
            $("#deletecustomerid").val(deleteid);
            $("#deleteuserid").val(userid);
            $("#myModaldeleteforcustomer").modal('show')
        }
    }

    //submit delete data
    function deletecustomerinfo() {
        var dataString = "ledgerid=" + $("#deletecustomerid").val() + "&userid=" + $("#deleteuserid").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('customer/customer/delete'); ?>",
            data: dataString,
            success: function (data) {
                if (data == 'deleted') {
                    $('#myModaldeleteforcustomer').modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Customer Deleted Successfully',
                        sticky: false,
                        time: '5000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                    return true;
                }
                if (data == 'Notdeleted') {
                    $('#myModaldeleteforcustomer').modal('hide');
                    $("#deletedinaccessed").modal('show');
                }
            }
        });
    }
    function modalcloseforaddcustomer() {
        $("#customer_add")[0].reset();
    }

    /**
     * Add New Customer
     */
    $('#submitaddcustomer').click(function () {
        $('#accountnomanual').css('border-color', '#898990');
        $('#mobile1').css('border-color', '#898990');
        $("#customer_name1").css('border-color', '#898990');

        $("#accountnomsg").text('');
        $("#mobilenomsg").text('');
        $("#servermsg").text('');

        var accountGrName = $("#servermsg").html(),
            customer_name = $("#customer_name1").val(),
            mobileno = $('#mobile1').val();

        if ($('input[name=customertype]:checked').val() == 2 && $('#accountnomanual').val() === '') {
            $("#accountnomsg").text("This field is required!");
            $('#accountnomanual').css('border-color', 'red');
            $("#accountnomsg").css('color', 'red');
        } else if (mobileno === '') {
            $("#mobilenomsg").text("This field is required!");
            $('#mobile1').css('border-color', 'red');
            $("#mobilenomsg").css('color', 'red');
        } else if (customer_name === '') {
            $("#customer_name1").css('border-color', 'red');
            $("#servermsg").text("This field is required!");
            $("#servermsg").css('color', 'red');
            return false;
        } else {
            if ($('input[name=customertype]:checked').val() == 1 && $('#accountno').val() == '') {
                $('#accountno').val('<?= $accountno; ?>');
            }


            var mobile = $("#mobile1").val();
            var accno = $('input[name=customertype]:checked').val() == 1
                ? $('#accountno').val()
                : $("#accountnomanual").val();
            var password = $("#password").val();
            var status = $("#status").val();
            var membertype = $("input[name=customertype]:checked").val();
            var gender = $("input[name=gender]:checked").val();

            $.ajax({
                type: "POST",
                url: "<?= site_url('customer/customer/add'); ?>",
                data: {
                    accountno : accno,
                    mobile : mobile,
                    customer_name : customer_name,
                    password : password,
                    membertype : membertype,
                    gender : gender,
                    status : status
                },
                success: function (data) {
                    if (data == 'Added') {
                        $('#addcustomerModal').modal('hide');
                        $.gritter.add({
                            title: 'Successful!',
                            text: 'Customer Added Successfully',
                            sticky: false,
                            time: '5000'
                        });
                        setTimeout("window.location.reload(1)", 2000);
                        return true;
                    }
                    if (data === 'Notadded') {
                        $('#myModal').modal('hide');
                        $.gritter.add({
                            title: 'Unsuccessful!',
                            text: 'Customer Not Added ',
                            sticky: false,
                            time: '2000'
                        });
                    }
                }
            });
        }
    });

    <?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#addcustomer").prop("disabled", true);
            $("#updatecustomer").prop("disabled", true);
            $("#deletecustomer").prop("disabled", true);
        }
    });

    /**
     * Fire Add Customer Modal
     */
    $('#addcustomer').click(function(){
        $('form#customer_add')[0].reset();

        $('#accountnomanual').css('border-color', '#898990');
        $('#mobile1').css('border-color', '#898990');
        $("#customer_name1").css('border-color', '#898990');

        $("#accountnomsg").text('');
        $("#mobilenomsg").text('');
        $("#servermsg").text('');

        $('#addcustomerModal').modal("show");
    });

    /**
     * Only Number will be valid
     * ASCII Codes
     * 48-57  ->  0-9
     * 8   ->  Backspace
     * 46  ->  Delete
     * 37  ->  Left Arrow
     * 39  ->  Right Arrow
     */
    $(".num-only").each(function () {
        $(this).keypress(function (e) {
            var code = e.keyCode || e.charCode;
            return (((code >= 48) && (code <= 57)) || code === 8 || code === 46 || code === 37 || code === 39);
        });
    });

    /**
     * Account Type on customer add
     */
    $('input[name=customertype]').on('change', function () {
        if ($('input[name=customertype]:checked').val() == 1) {
            $('#accountnomanual').hide();
            $('#accountno').show();
            $('#accountnomsg').html('');
        } else {
            $('#accountnomanual').show();
            $('#accountno').hide();
        }
    });

    /**
     * Check Unique Account Number
     */
    $('#accountnomanual').change(function(){
        var accno = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?= site_url('customer/customer/checkuniqueaccno'); ?>",
            data: {
                accno : accno
            },
            success: function (data) {
                var accountnomsg = $("#accountnomsg");
                if (data) {
                    accountnomsg.text("");
                    accountnomsg.text("Valid account No");
                    accountnomsg.css('color', 'green');
                    $("#submitaddcustomer").prop('disabled', false);
                } else {
                    accountnomsg.text("");
                    accountnomsg.text("This number already used !!");
                    accountnomsg.css('color', 'red');
                    $("#submitaddcustomer").prop('disabled', true);
                }
            }
        });
    });

    /**
     * Check Unique Mobile Number
     */
    $('#mobile1').change(function(){
        var mobile = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?= site_url('customer/customer/checkuniquemobile'); ?>",
            data: {
                mobile : mobile
            },
            success: function (data) {
                var mobilenocheck = $("#mobilenomsg");
                if (data) {
                    mobilenocheck.text('');
                    mobilenocheck.text("Valid Mobile No");
                    mobilenocheck.css('color', 'green');
                    $("#submitaddcustomer").prop('disabled', false);
                } else {
                    mobilenocheck.text('');
                    mobilenocheck.text("Mobile number already used !!");
                    mobilenocheck.css('color', 'red');
                    $("#submitaddcustomer").prop('disabled', true);
                }
            }
        });
    });
</script>

