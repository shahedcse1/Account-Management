<?php include_once 'header.php'; ?>
<?php include_once 'sidebar.php'; ?>
<!-- Main Content -->
<style>
    #myModalLabel{
        font-weight: bold
    }
</style>

<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading">
                Account Group
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <button  class="btn btn-info" id="addaccountgroup" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>                  
                    </div>
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                               
                                <th>Account Group Name</th>
                                <th>Group Under</th>
                                <th>Description</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php foreach ($alldata as $row): ?>                          
                                <tr class="table_hand">
                                    <td >
                                        <a data-toggle="modal" href="#myModaldelete<?php
                                        if ($row->defaultOrNot == 1) {
                                            echo '00';
                                        } else {
                                            echo $row->accountGroupId;
                                        }
                                        ?>"><i class="fa fa-times-circle delete-icon" ></i></a>
                                    </td>                           
                                    <td data-toggle="modal" href="#myModaledit<?php
                                    if ($row->defaultOrNot == 1) {
                                        echo '00';
                                    } else {
                                        echo $row->accountGroupId;
                                    }
                                    ?>"><?php echo $row->accountGroupName; ?>
                                    </td>
                                    <td data-toggle="modal" href="#myModaledit<?php
                                    if ($row->defaultOrNot == 1) {
                                        echo '00';
                                    } else {
                                        echo $row->accountGroupId;
                                    }
                                    ?>">
                                            <?php
                                            foreach ($alldata as $rows):
                                                if ($row->groupUnder == $rows->accountGroupId):
                                                    echo $rows->accountGroupName;
                                                endif;
                                            endforeach;
                                            ?>
                                    </td>
                                    <td data-toggle="modal" href="#myModaledit<?php
                                    if ($row->defaultOrNot == 1) {
                                        echo '00';
                                    } else {
                                        echo $row->accountGroupId;
                                    }
                                    ?>"><?php echo $row->description; ?></td>                         
                                </tr>
                                <!-- start modal for edit data-->
                            <div class="modal fade" id="myModaledit<?php echo $row->accountGroupId ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form class="cmxform form-horizontal tasi-form" id="editaccgroup" method="post" action="" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel" align="Center">Edit Account Group</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">                                                                                                           
                                                        <div class="form">
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="editaccountGroupName" class="control-label col-lg-4">Account Group Name :</label>
                                                                    <div class="col-lg-8">
                                                                        <input class=" form-control" id="editaccountGroupId<?php echo $row->accountGroupId; ?>" name="editaccountGroupId" type="hidden" value="<?php echo $row->accountGroupId; ?>" />
                                                                        <input class=" form-control" id="editaccountGroupName<?php echo $row->accountGroupId; ?>" name="editaccountGroupName" type="text"  value="<?php echo $row->accountGroupName; ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="editgroupUnder" class="control-label col-lg-4">Group Under :</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="form-control selectpicker" data-live-search="true" id="editgroupUnder<?php echo $row->accountGroupId; ?>" name="editgroupUnder" type="text">
                                                                            <?php
                                                                            foreach ($sortalldata as $group):
                                                                                ?>                                                                                
                                                                                <option <?php
                                                                                if ($group->accountGroupId == $row->groupUnder) {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?> value="<?php echo $group->accountGroupId; ?>"><?php echo $group->accountGroupName; ?></option>
                                                                                <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="editdescription" class="control-label col-lg-4">Description :</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control " id="editdefaultOrNot<?php echo $row->accountGroupId; ?>" type="hidden" name="editdefaultOrNot" value="0" />
                                                                        <input class="form-control " id="editcompanyId<?php echo $row->accountGroupId; ?>" type="hidden" name="editcompanyId" value="1" />
                                                                        <textarea class="form-control " id="editdescription<?php echo $row->accountGroupId; ?>" name="editdescription" type="text"><?php echo $row->description; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="updateaccountgroup<?php echo $row->accountGroupId ?>" class="btn btn-primary" onclick="return editcheck(<?php echo $row->accountGroupId; ?>);">Update</button>
                                                <button type="button" class="btn btn-inverse" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>                                      
                                    </form>                                 
                                </div>
                            </div>
                            <!-- end edit modal-->  
                            <!--Start Modal Delete Data -->
                            <div class="modal fade" id="myModaldelete<?php echo $row->accountGroupId ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('home/deleteAccGroup') ?>">
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
                                                                <p><h4><i class="fa fa-warning"></i>&nbsp;Are you sure want to delete account group:&nbsp;&nbsp;<?php echo '<span style="color: blue">' . $row->accountGroupName . '</span>'; ?></h4></p>
                                                                <input id="accountGroupId" name="accountGroupId" type="hidden" value="<?php echo $row->accountGroupId ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="Submit" id="deleteaccountgroup<?php echo $row->accountGroupId ?>" class="btn btn-danger">YES</button>
                                                <button type="button" class="btn btn-inverse" data-dismiss="modal">NO</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--end delete modal-->
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>  
            </div>           
        </section>
    </section>
</section>

<!-- Warning Edit modal-->
<div class="modal fade" id="myModaledit00" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> Edit message</h4>
            </div>
            <div class="modal-body">    
                <p><h4><i class="fa fa-warning"></i>&nbsp;You can not edit builtin group under</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- end warning edit modal-->
<!-- Warning Delete modal-->
<div class="modal fade" id="myModaldelete00" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete message</h4>
            </div>
            <div class="modal-body">    
                <p><h4><i class="fa fa-warning"></i>&nbsp;You can not delete a built-in account group </h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
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
                <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this account group!! This account group is in used</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- end warning delete modal-->
<!-- add account modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">       
        <form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="#" novalidate="novalidate">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Account Group</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="accountGroupName" class="control-label col-lg-4">Account Group Name :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="accountGroupName" name="accountGroupName" type="text" onchange="return accountNameCheck()" required/>
                                        <span id="servermsg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="groupUnder" class="control-label col-lg-4">Group Under :</label>
                                    <div class="col-lg-8">
                                        <select class="form-control selectpicker" id="groupUnder" name="groupUnder" type="text" data-live-search="true" required >
                                            <option value="">-- Group Under --</option>
                                            <?php foreach ($sortalldata as $row): ?>
                                                <option value="<?php echo $row->accountGroupId; ?>"><?php echo $row->accountGroupName; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-4">Description :</label>
                                    <div class="col-lg-8">
                                        <input class="form-control " id="defaultOrNot" type="hidden" name="defaultOrNot" value="0" />
                                        <input class="form-control " id="companyId" type="hidden" name="companyId" value="1" />
                                        <textarea class="form-control " id="description" name="description" type="text"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="savebutton"  class="btn btn-primary" onclick="return addcheck();">Save</button>
                    <button type="reset" class="btn btn-info">Clear</button>
                    <button type="button" class="btn btn-inverse " data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>        
    </div>    
</div> 
<?php include_once 'footer.php'; ?>
<?php if ($this->session->userdata('deletemessage') == 'deleted'): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Successfull!',
                // (string | mandatory) the text inside the notification
                text: 'Account Group Deleted Successfully',
                // (string | optional) the image to display on the left
                // image: 'img/avatar-mini.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('deletemessage');
endif;
if ($this->session->userdata('deletemessage') == 'notdeleted'):
    ?>
    <script>
        $(document).ready(function () {
            $("#deletedinaccessed").modal('show');
        })
    </script>  
    <?php
    $this->session->unset_userdata('deletemessage');
endif;
?>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
<?php foreach ($alldata as $unitvalue): ?>
            var id = "<?php echo $unitvalue->accountGroupId; ?>"
            if (fyearstatus == '0') {
                $("#updateaccountgroup" + id).prop("disabled", true);
                $("#deleteaccountgroup" + id).prop("disabled", true);
            }
<?php endforeach; ?>
        if (fyearstatus == '0') {
            $("#addaccountgroup").prop("disabled", true);
        }
    });
</script>
<script type="text/javascript">
    function accountNameCheck() {
        var accountGroupName = $("#accountGroupName").val();
        var dataString = "accgname=" + accountGroupName;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/accountNameCheck'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'free') {
                    $("#accountGroupName").css('border-color', 'green');
                    $("#servermsg").text("Account Group name available");
                    $("#servermsg").css('color', 'green');
                    return true;
                }
                if (data === 'booked') {
                    $("#accountGroupName").css('border-color', 'red');
                    $("#servermsg").text("Account Name not Available. Please try another");
                    $("#servermsg").css('color', 'red');
                }
            }
        });
    }

    function addcheck() {
        var accountGrName = $("#servermsg").html();
        if ($("#accountGroupName").val() == '') {
            $("#accountGroupName").focus();
            $("#servermsg").text("Account group name can not be empty!!");
            $("#servermsg").css('color', 'red');
            return false;
        }
        if (accountGrName === "Account Name not Available. Please try another") {
            $("#accountGroupName").focus();
            $("#savebutton").prop('disabled', true);
            return false;
        } else {
            var accountGroupName = $("#accountGroupName").val();
            var groupUnder = $("#groupUnder").val();
            var defaultOrNot = $("#defaultOrNot").val();
            var companyId = $("#companyId").val();
            var description = $("#description").val();
            var dataString = "accountGroupName=" + accountGroupName + "&groupUnder=" + groupUnder + "&defaultOrNot=" + defaultOrNot + "&companyId=" + companyId + "&description=" + description;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('home/addAccGroup'); ?>",
                data: dataString,
                success: function (data)
                {
                    if (data == 'Added') {
                        $('#myModal').modal('hide');
                        $.gritter.add({
                            title: 'Successfull!',
                            text: 'Account Group Added Successfully',
                            sticky: false,
                            time: ''
                        });
                        setTimeout("window.location.reload(1)", 2000);
                        return true;
                    }
                    if (data == 'Notadded') {
                        $('#myModal').modal('hide');
                        $.gritter.add({
                            title: 'Unsuccessfull!',
                            text: 'Account Group Not Added ',
                            sticky: false,
                            time: ''
                        });
                    }
                }
            });
        }
    }

    function editcheck(id)
    {
        //alert(id);
        var editgroupUnder = "#editgroupUnder" + id;
        var editdefaultOrNot = "#editdefaultOrNot" + id;
        var editaccountGroupName = "#editaccountGroupName" + id;
        var editcompanyId = "#editcompanyId" + id;
        var editdescription = "#editdescription" + id;
        var editaccountGroupName = $(editaccountGroupName).val();
        var editgroupUnder = $(editgroupUnder).val();
        var editdefaultOrNot = $(editdefaultOrNot).val();
        var editcompanyId = $(editcompanyId).val();
        var editdescription = $(editdescription).val();
        var dataString = "editaccountGroupId=" + id + "&editaccountGroupName=" + editaccountGroupName + "&editgroupUnder=" + editgroupUnder + "&editdefaultOrNot=" + editdefaultOrNot + "&editcompanyId=" + editcompanyId + "&editdescription=" + editdescription;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/editAccGroup'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data == 'Updated') {
                    $('#myModaledit' + id).modal('hide');
                    $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: 'Successfull!',
                        // (string | mandatory) the text inside the notification
                        text: 'Account Group Updated Successfully',
                        // (string | optional) the image to display on the left
                        // image: 'img/avatar-mini.jpg',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: false,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: ''
                    });
                    location.reload();
                    return true;
                }
                if (data == 'Notupdated') {
                    $('#myModaledit' + editaccountGroupId).modal('hide');
                    $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: 'Unsuccessfull!',
                        // (string | mandatory) the text inside the notification
                        text: 'Account Group Not Updated ',
                        // (string | optional) the image to display on the left
                        // image: 'img/avatar-mini.jpg',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: false,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: ''
                    });
                }
            }
        });
    }
</script>



