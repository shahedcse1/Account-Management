<style>
    .right{
        align: right;
    }

    .left{
        align: left;
    }

    .center{
        align: center;
        font-size: 13px;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading">
                Users Information
            </header>            
            <div class="panel-body">
                <?php
                if ($this->session->userdata('successfull')):
                    echo '<div class="alert alert-success fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Success Message !!! </strong> ' . $this->session->userdata('successfull') . '</div>';
                    $this->session->unset_userdata('successfull');
                endif;
                if ($this->session->userdata('failed')):
                    echo '<div class="alert alert-block alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Failed Meaasge !!! </strong> ' . $this->session->userdata('failed') . '</div>';
                    $this->session->unset_userdata('failed');
                endif;
                ?>
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModal" id="add_user" onclick="resetBeforeAdd()" >
                                Add User <i class="fa fa-plus"></i>
                            </button>

                        </div>
                    </div>
                    <table class="display table table-bordered table-striped" id="editable-sample">
                        <thead style="background: rgb(209, 0, 116)">
                            <tr>   

                                <th style="text-align:center">User Name</th>
                                <th style="text-align:center">Address</th>
                                <th style="text-align:center">Role</th>                                                            
                                <th style="text-align:center">Status</th> 
                                <th style="text-align:center">Action</th> 
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </section>
</section>

<!------------------------------------------------------------------------Add New User Modal----------------------------------------------------------------------------------------->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"style="text-align: center">Add User Information&nbsp;</h4>
            </div>
            <form class="cmxform form-horizontal tasi-form" id="addUserForm" method="post" action="<?php echo site_url('user/user/addUser'); ?>">
                <div class="modal-body">
                    <!--                    <div class="row">
                                            <div class="col-lg-12">                        -->

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="name_add" class="control-label col-lg-4">Name&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="name_add" name="name_add" type="text" placeholder="Name" onchange="checkUniqueUser();"  required="required"/>
                                <span id="nameMsgAdd"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="password_add" class="control-label col-lg-4">Password&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8">
                                <input class="form-control " id="password_add" name="password_add" type="password" placeholder="password" required="required" />
                                <span id="passMsgAdd"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="address_add" class="control-label col-lg-4">Address</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="address_add" name="address_add" type="text"  placeholder="Address" />
                                <span id="emailMsgAdd"></span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="role_add" class="control-label col-lg-4 ">Role&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8 ">
                                <select name="role_add" id="role_add"  class="form-control selectpicker" data-live-search="true" required="required">
                                    <option value="0">Select Role</option>
                                    <?php
                                    if (sizeof($userrole) > 0):
                                        foreach ($userrole as $data):
                                            ?>                                            
                                            <option value="<?php echo $data->rolename; ?>"><?php echo $data->details; ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>  
                                </select>
                                <span id="roleMsgAdd"></span>
                            </div>

                        </div>
                    </div>


                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="status_add" class="control-label col-lg-4 ">Status&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8 ">
                                <select name="status_add" id="status_add" class="form-control selectpicker" data-live-search="true" required="required"> 
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span id="statusMsgAdd"></span>
                            </div>
                        </div>
                    </div>
                    <!--                        </div>
                                        </div>-->
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="submit" class="btn btn-info">Save</button>                  
                    <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!------------------------------------------------------------------------/ End Add New User Modal----------------------------------------------------------------------------------------->


<!------------------------------------------------------------------------Edit User Modal------------------------------------------------->

<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"style="text-align: center">Edit User Information&nbsp;</h4>
            </div>
            <form class="cmxform form-horizontal tasi-form" id="editUserForm" method="post" action="<?php echo site_url('user/user/editUser'); ?>">
                <div class="modal-body">
                    <!--                    <div class="row">
                                            <div class="col-lg-12">                        -->

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="name_edit" class="control-label col-lg-4">Name&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8">
                                <input class=" form-control" id="name_edit" name="name_edit" type="text" readonly="readonly" placeholder="Name" onchange="checkUniqueUserEdit();" required="required" />
                                <input class=" form-control" id="id_edit" name="id_edit" type="hidden" />
                                <span id="nameMsgEdit"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="password_edit" class="control-label col-lg-4">Password&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8">
                                <input class="form-control " id="password_edit" name="password_edit" type="password" placeholder="password" required="required" />
                                <span id="passMsgEdit"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="address_edit" class="control-label col-lg-4">Address</label>
                            <div class="col-lg-8">
                                <input class="form-control " id="address_edit" name="address_edit" type="text"  placeholder="Address" />
                                <span id="emailMsgEdit"></span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="role_edit" class="control-label col-lg-4 ">Role&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8 ">
                                <select name="role_edit" id="role_edit"  class="form-control selectpicker" data-live-search="true" required="required">
                                    <option value="0">Select Role</option>
                                    <?php
                                    if (sizeof($userrole) > 0):
                                        foreach ($userrole as $data):
                                            ?>                                            
                                            <option value="<?php echo $data->rolename; ?>"><?php echo $data->details; ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>  
                                </select>
                                <span id="roleMsgEdit"></span>
                            </div>

                        </div>
                    </div>


                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="status_edit" class="control-label col-lg-4 ">Status&nbsp;<span style="color: red">*</span></label>
                            <div class="col-lg-8 ">
                                <select name="status_edit" id="status_edit" class="form-control selectpicker" data-live-search="true" required="required"> 
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span id="statusMsgEdit"></span>
                            </div>
                        </div>
                    </div>
                    <!--                        </div>
                                        </div>-->
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="submit" class="btn btn-info"  >Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!------------------------------------------------------------------------/End Edit User Modal------------------------------------------------------->



<!-----------------------------------------------------------------Start Modal Delete Data ------------------------------------------------------------------>


<div class="modal fade" id="deleteUserData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="cmxform form-horizontal tasi-form" id="deleteUserForm" method="post" action="<?php echo site_url('user/user/deleteUser') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete User&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <h5><i class="fa fa-warning"></i>&nbsp;&nbsp; Are You  Want To Delete User Information</h5>
                                    <input id="id_delete" name="id_delete" type="hidden" value="" />

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
<!----------------------------------------------------------------end delete modal----------------------------------------------------------->



<script>


    $(document).ready(function () {
        var oTable = $('#editable-sample').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?= site_url('user/user/getTable'); ?>',
            "order": [[4, "asc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]

        });
    });


    function showEditModal(userId) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/user/showUserData'); ?>",
            data: 'userId=' + userId,
            success: function (data) {
                var viewModalData = JSON.parse(data);
                $("#id_edit").val(viewModalData.userId);
                $("#name_edit").val(viewModalData.username);
                $("#password_edit").val(viewModalData.password);
                $("#address_edit").val(viewModalData.description);
                $("#role_edit").val(viewModalData.role).change();
                $("#status_edit").val(viewModalData.activeOrNot).change();
                $('#myModalEdit').modal('show');
            }
        });
    }

   
    function showDeleteModal(user_id) {
        $("#id_delete").val(user_id);
        $('#deleteUserData').modal('show');
    }

  
  function checkUniqueUser() {
        var username = $("#name_add").val();
        var dataString = 'username=' + username;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/user/checkUniqueUser'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'booked') {
                 
                    $("#nameMsgAdd").text("This Username Is Already Used !!");
                    $("#nameMsgAdd").css('color', 'red');
                    document.getElementById('addUserForm').onsubmit = function () {
                        return false;
                    }
                } else if (data === 'disallowed') {

                    $("#nameMsgAdd").text("Disallowed Key Characters !!");
                    $("#nameMsgAdd").css('color', 'red');
                      document.getElementById('addUserForm').onsubmit = function () {
                        return false;
                    }
                } else if (data === 'free') {
                    $("#nameMsgAdd").text("Valid Username");
                    $("#nameMsgAdd").css('color', 'green');
                    document.getElementById('addUserForm').onsubmit = function () {
                    return true;
                }
            }
            }
        });
    }


function checkUniqueUserEdit() {
        var username = $("#name_edit").val();
        var dataString = 'username=' + username;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('user/user/checkUniqueUserEdit'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data == 'free') {                
                    $("#nameMsgEdit").text("Valid Username");
                    $("#nameMsgEdit").css('color', 'green');
//                      document.getElementById('editUserForm').onsubmit = function () {
//                        return true;
//                    }
                }
                if (data == 'booked') {           
                    $("#nameMsgEdit").text("This Username Is Already Used !!");
                    $("#nameMsgEdit").css('color', 'red');
//                      document.getElementById('editUserForm').onsubmit = function () {
//                        return false;
//                    }
                }
            }
        });
    }

</script>
