<?php //include_once('header.php'); ?>
<?php //include_once('sidebar.php'); ?>
<!--main content start-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Supplier Information
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
                            <button class="btn btn-info" id="addsupplier" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <table class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                                
                                <th>Supplier Name</th>                                
                                <th>Address</th>
                                <th>Mobile No</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (sizeof($supplierinfo1) > 0) {
                                $address = 'Undefined';
                                $nameofbusiness = 'Undefined';
                                $mobile = 'Undefined';
                                $totalbalance = 0;
                                $action = '';
                                foreach ($supplierinfo1 as $supplier1) {
                                    $flag = 0;
                                    foreach ($ledgerposting as $balance):
                                        if ($supplier1->ledgerId == $balance->ledgerId):
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
                                    echo '<tr><td><a  data-toggle="modal" href="#myModaldelete' . $supplier1->ledgerId . '"><i  class="fa fa-times-circle delete-icon"></i> </a></td>';
                                    echo '<td><a href="#" onclick="getsupplierinfo(' . $supplier1->ledgerId . ')">' . $supplier1->acccountLedgerName . '</a></td>';
                                    foreach ($supplierinfo2 as $vendordata):
                                        if ($vendordata->ledgerId == $supplier1->ledgerId) {
                                            $address = $vendordata->address;
                                            $nameofbusiness = $vendordata->nameOfBusiness;
                                            $mobile = $vendordata->mobileNumber;
                                        }
                                    endforeach;
                                    echo "<td>" . $address . "  </td>";
                                    echo "<td>" . $mobile . "</td>";
                                    echo "<td>" . number_format($totalbalance, 2) . '  ' . $action . "</td>";
                                    if ($supplier1->status == 1):
                                        echo "<td>" . "Active" . " </td>";
                                    else:
                                        echo "<td>" . "Inactive" . " </td>";
                                    endif;
                                    echo "</tr>";
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
<!--main content end-->
<!--Edit-->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Update Supplier Information</h4>
            </div>
            <form class="cmxform form-horizontal tasi-form" id="supplier_add" method="post" action="<?php echo site_url('supplier/supplier/edit'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">                        
                            <div class="panel-body" style="display: none">
                                <div class="form-group ">
                                    <label for="accountno" class="control-label col-lg-4">Account No:</label>                                                   
                                    <div class="col-lg-8">                                      
                                        <input class=" form-control"
                                               id="editaccountno"
                                               name="accountno"
                                               type="text"
                                               value=""
                                               onchange="return checkuniqueAccNoForEdit()"
                                               required />
                                        <span id="editaccountnomsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="supplier_name" class="control-label col-lg-4">Supplier Name:</label>
                                    <div class="col-lg-8">
                                        <input type="hidden" name="accountnoOld" id="editaccountnoOld"/>  
                                        <input type="hidden" name="supplierid" id="editsupplierid"/>                                     
                                        <input type="hidden" id="realunername" value=""/>
                                        <input class="form-control" id="editsuppliername" name="supplier_name" type="text" value=""/>
                                        <span id="servermsg2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="nameofbusiness" class="control-label col-lg-4">Name Of Business:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"
                                               id="editnameofbusiness"
                                               name="nameofbusiness"
                                               type="text"
                                               value=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="address" class="control-label col-lg-4">Address:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"
                                               id="editaddress"
                                               name="address"
                                               type="text"
                                               value=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="country" class="control-label col-lg-4">Country:</label>
                                    <div class="col-lg-8">
                                        <!--                                        <div id="putcountry"></div>-->
                                        <select class="form-control"
                                                data-live-search="true"
                                                id="editcountry"
                                                name="country">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="mobile" class="control-label col-lg-4">Mobile:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"
                                               id="editmobile"
                                               name="mobile"
                                               type="text"
                                               value=""/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-4 ">Opening Balance:</label>
                                    <div class="col-lg-5">
                                        <input class="form-control"
                                               id="editopeningbalance"
                                               type="text"
                                               name="opening_balance"
                                               value=""/>
                                    </div>
                                    <div class="col-lg-2 ">
                                        <div id="putdebitorcredit"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-4">Description:</label>
                                    <div class="col-lg-8 col-sm-8">
                                        <textarea class="form-control"
                                                  id="editdescription"
                                                  name="description"
                                                  cols="30"
                                                  rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="status_edit" class="control-label col-lg-4">Status</label>
                                    <div class="col-lg-8 col-sm-8">
                                        <select name="status_edit"
                                                id="status_edit"
                                                class="customer_debit pull-right form-control">
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
                    <button type="submit" class="btn btn-primary" id="updatesupplier">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>               

<!-------------------------Add New------------------------------------->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <form class="cmxform form-horizontal tasi-form" id="supplier_add" method="post" action="#">

                            <!-- Supplier Name -->
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="supplier_name" class="control-label col-lg-4">Supplier Name</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control"
                                               id="supplier_name1"
                                               name="supplier_name"
                                               type="text"
                                               onchange="return supplierNameCheck()" value=""/>
                                        <input class=" form-control"
                                               id="paymentvouModal"
                                               name="paymentvouModal"
                                               type="hidden"
                                               value="addsuppliermodal"/>
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Name Of Business -->
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="nameofbusiness" class="control-label col-lg-4">Name Of Business</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"
                                               id="nameofbusiness"
                                               name="nameofbusiness"
                                               type="text"/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="address1" class="control-label col-lg-4">Address</label>

                                    <div class="col-lg-8">
                                        <input class="form-control"
                                               id="address1"
                                               name="address"
                                               type="text"/>
                                        <input id="company_id1"
                                               name="company_id"
                                               type="hidden"
                                               value="<?= $company_id; ?>"/>
                                    </div>
                                </div>
                            </div>


                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="country" class="control-label col-lg-4">Country</label>
                                    <div class="col-lg-8">
                                        <select class="form-control selectpicker"
                                                data-live-search="true"
                                                id="country1"
                                                name="country">
                                            <?php
                                            foreach ($countries as $country) {
                                                echo "<option value='" . $country->country_name . "'>$country->country_name</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="mobile1" class="control-label col-lg-4">Mobile</label>
                                    <div class="col-lg-8">
                                        <input class="form-control num-only"
                                               id="mobile1"
                                               name="mobile"
                                               maxlength="11"
                                               minlength="11"
                                               type="text"/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="opening_balance" class="control-label col-lg-4 ">Opening Balance</label>

                                    <div class="col-lg-5">
                                        <input class="form-control"
                                               type="text"
                                               id="opening_balance1"
                                               placeholder="0.00"
                                               name="opening_balance"/>

                                    </div>
                                    <div class="col-lg-2 ">
                                        <select name="dr_cr"
                                                id="dr_cr1"
                                                class="supplier_debit pull-right form-control">
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
                                        <textarea class="form-control"
                                                  id="description1"
                                                  name="description"
                                                  cols="30"
                                                  rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="status" class="control-label col-lg-4">Status</label>
                                    <div class="col-lg-8 col-sm-8">
                                        <select name="status"
                                                id="status"
                                                class="customer_debit pull-right form-control">
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
                <button type="button" id="submitaddsupplier" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-info">Reset</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
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
                <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this supplier!! This supplier is in used</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- end warning delete modal-->
<!--..............................Delete.........................-->
<?php
if (isset($supplierinfo1)) {
    foreach ($supplierinfo1 as $supplier) {
        ?>
        <div class="modal fade" id="myModaldelete<?php echo $supplier->ledgerId; ?>" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel" align="Center">Delete message</h4>
                    </div>
                    <form method="POST" action="#">
                        <div class="modal-body">
                            <h4><i class="fa fa-warning"></i>&nbsp;Are you sure you want to delete the Supplier :
                                <b><?php echo $supplier->acccountLedgerName; ?> </b> !</h4>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="deletesupplier<?php echo $supplier->ledgerId; ?>" class="btn btn-danger" onclick="return deletesupplier(<?php echo $supplier->ledgerId; ?>);">YES</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
<?php foreach ($supplierinfo1 as $unitvalue): ?>
            var id = "<?php echo $unitvalue->ledgerId; ?>"
            if (fyearstatus == '0') {
                $("#deletesupplier" + id).prop("disabled", true);
            }
<?php endforeach; ?>
        if (fyearstatus == '0') {
            $("#addsupplier").prop("disabled", true);
            $("#updatesupplier").prop("disabled", true);
        }
    });
</script>
<?php //include_once('footer.php'); ?>
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Supplier Updated Successfully',
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
                text: 'Supplier Updated Fail',
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
    function getsupplierinfo(id) {
        var dataString = "acccountLedgerid=" + id;
        $.ajax({
            type: "POST",
            url: "<?= site_url('customer/customer/customerdebitorcredit'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#putdebitorcredit").html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?= site_url('supplier/supplier/suppliercountry'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#editcountry").append(data).selectpicker();
            }
        });
        $.ajax({
            type: "POST",
            url: "<?= site_url('supplier/supplier/getsupplierinfo'); ?>",
            data: dataString,
            success: function (data)
            {
                var jobj = $.parseJSON(data);
                $.each(jobj, function () {
                    $("#editsupplierid").val(id);
                    $("#editsuppliername").val(this['acccountLedgerName']);
                    $("#editaccountno").val(this['accNo']);
                    $("#editaccountnoOld").val(this['accNo']);
                    $("#editnameofbusiness").val(this['nameOfBusiness']);
                    $("#editaddress").val(this['address']);
                    $("#editmobile").val(this['mobileNumber']);
                    $("#editopeningbalance").val(this['openingBalance']);
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
            url: "<?= site_url('customer/customer/checkuniqueaccountno'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data == 'free') {
                    $("#accountnomsg").text("");
                    $("#accountnomsg").text("Valid account No");
                    $("#accountnomsg").css('color', 'green');
                    $("#submitaddsupplier").prop('disabled', false);
                }
                if (data == 'booked') {
                    $("#accountnomsg").text("");
                    $("#accountnomsg").text("This number already used !!");
                    $("#accountnomsg").css('color', 'red');
                    $("#submitaddsupplier").prop('disabled', true);
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
                    $("#updatesupplier").prop('disabled', false);
                    return true;
                }
                if (data == 'booked') {
                    $("#editaccountnomsg").text("");
                    $("#editaccountnomsg").text("This number already used !!");
                    $("#editaccountnomsg").css('color', 'red');
                    $("#updatesupplier").prop('disabled', true);
                    return false;
                }
            }
        });
    }
    function supplierNameCheck() {
        var supplier_name = $("#supplier_name1").val();
        var dataString = "suppname=" + supplier_name;
        $.ajax({
            type: "POST",
            url: "<?= site_url('supplier/supplier/suppliernamecheck'); ?>",
            data: dataString,
            success: function (data) {
                if (data == 'free') {
                    $("#supplier_name1").css('border-color', 'green');
                    $("#servermsg").text("Supplier name available");
                    $("#servermsg").css('color', 'green');
                    //return true;
                }
                if (data == 'booked') {
                    $("#supplier_name1").css('border-color', 'red');
                    $("#servermsg").text("Supplier Name not Available. Please try another");
                    $("#servermsg").css('color', 'red');
                    //return true;
                }
            }
        });
    }

    /**
     * Add new Supplier
     */
    $('#submitaddsupplier').click(function () {
        var accountGrName = $("#servermsg").html();
        var supplier_name = $("#supplier_name1").val();
        if (accountGrName === "Supplier Name not Available. Please try another") {
            $("#supplier_name1").focus();
            return false;
        }
        else if (supplier_name == "") {
            $("#supplier_name1").css('border-color', 'red');
            $("#servermsg").text("This field is required!");
            $("#servermsg").css('color', 'red');
            return false;
        } else {
            var address = $("#address1").val();
            var country = $("#country1").val();
            var nameofbusiness = $("#nameofbusiness").val();
            var mobile = $("#mobile1").val();
            var dr_cr = $("#dr_cr1").val();
            var opening_balance = $("#opening_balance1").val();
            var description = $("#description1").val();
            var company_id = $("#company_id1").val();
            var status = $("#status").val();
            var dataString = "supplier_name=" + supplier_name + "&address=" + address + "&country=" + country + "&nameofbusiness=" + nameofbusiness + "&company_id=" + company_id + "&mobile=" + mobile + "&dr_cr=" + dr_cr + "&opening_balance=" + opening_balance + "&description=" + description + "&status=" + status;
            $.ajax({
                type: "POST",
                url: "<?= site_url('supplier/supplier/add'); ?>",
                data: dataString,
                success: function (data) {
                    if (data == 'Added') {
                        $('#myModal').modal('hide');
                        $.gritter.add({
                            title: 'Successfull!',
                            text: 'Supplier Added Successfully',
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
                            text: 'Supplier Not Added ',
                            sticky: false,
                            time: '2000'
                        });
                    }
                }
            });
        }
    });

    //submit delete data
    function deletesupplier(id) {
        var dataString = "ledgerid=" + id;
        $.ajax({
            type: "POST",
            url: "<?= site_url('supplier/supplier/delete'); ?>",
            data: dataString,
            success: function (data) {
                if (data === 'deleted') {
                    $('#myModaldelete' + id).modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Supplier Deleted Successfully',
                        sticky: false,
                        time: '5000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                    return true;
                }
                if (data === 'Notdeleted') {
                    $('#myModaldelete' + id).modal('hide');
                    $("#deletedinaccessed").modal('show');
                }
            }
        });
    }

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
</script>



