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
                            <button  class="btn btn-info" id="addsalesman" data-toggle="modal" data-target="#addsalesmanmodal"><i class="fa fa-plus"></i>&nbsp;Add New Salesman</button>
                        </div>
                    </div>                  
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th> 
                                <th>S.N</th> 
                                <th>Login name</th> 
                                <th>Password</th> 
                                <th>Sales Man Name</th>
                                <th>Address</th>
                                <th>Mobile</th>
                                <th>Status</th>                                
                            </tr>
                        </thead>   
                        <tbody>
                            <?php
                            if (sizeof($salesmandata) > 0):
                                $i = 0;
                                foreach ($salesmandata as $rowdata):
                                    ?>                          
                                    <tr>
                                        <td> <a data-toggle="modal" href="#" data-target="#deletesalesman<?php echo $rowdata->salesManId; ?>">
                                                <i class="fa fa-times-circle delete-icon"></i></a>
                                        </td> 
                                        <td><?php echo $i++; ?></td> 
                                        <td><?php echo $rowdata->username; ?></td> 
                                        <td><?php echo $rowdata->password; ?></td> 
                                        <td><a href="#" onclick="return getsalesmaninfo(<?php echo $rowdata->salesManId; ?>)"><?php echo $rowdata->salesManName; ?></a></td> 
                                        <td><?php echo $rowdata->address; ?></td> 
                                        <td><?php echo $rowdata->mobile; ?></td> 
                                        <td><?php
                                            if ($rowdata->activeOrNot == '1'):
                                                echo 'Active';
                                            else:
                                                echo 'InActive';
                                            endif;
                                            ?>
                                        </td> 
                                    </tr>    
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
<!-- addsalesmanmodal start here-->
<div class="modal fade" id="addsalesmanmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="addaccledger" method="post" action="<?php echo site_url('salesman/salesman/addsalesman'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Add Sales Man Information</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="salesmanname" class="control-label col-lg-4">Sales Man Name :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="salesmanname" name="salesmanname"  type="text" onchange="return accountNameCheck()" />
                                        <span id="salesmannamemsg"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="username" class="control-label col-lg-4">Login Name :</label>
                                    <div class="col-lg-8">                                            
                                        <input class=" form-control" id="username" name="username"  type="text"  />
                                    </div>
                                </div>
                            </div> 

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="password" class="control-label col-lg-4">Password :</label>
                                    <div class="col-lg-8">                                            
                                        <input class=" form-control" id="password" name="password"  type="text"  />
                                    </div>
                                </div>
                            </div> 

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="address" class="control-label col-lg-4">Address :</label>
                                    <div class="col-lg-8">
                                        <textarea class=" form-control" id="address" name="address"  type="text" ></textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="mobile" class="control-label col-lg-4">Mobile :</label>
                                    <div class="col-lg-8">                                            
                                        <input class=" form-control" id="mobile" name="mobile"  type="text"  />
                                    </div>
                                </div>
                            </div> 
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="email" class="control-label col-lg-4">Status :</label>
                                    <div class="col-lg-8">
                                        <div class="radio">
                                            <label>
                                                Active
                                                <input type="radio" class="radiobutton" name="status" id="status" value="1" checked>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                InActive
                                                <input type="radio" class="radiobutton" name="status" id="status" value="0">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="savesalesmaninfo" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-info">Clear</button>
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>    
</div>
<!-- end add sales man modal-->
<!-- Edit modal start-->
<div class="modal fade" id="salesmanedit" tabindex="-1" role="dialog" aria-labelledby="unitdelete" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('salesman/salesman/updatesalesmaninfo') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center"><b>Update Sales Man Information </b></h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="editsalesmanname" class="control-label col-lg-3">Salesman Name:</label>
                            <div class="col-lg-8">
                                <input id="editsalesmanid" name="editsalesmanid" type="hidden" value="" /> 
                                <input class=" form-control" id="editsalesmanname" name="editsalesmanname" value="" type="text" />
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="editusername" class="control-label col-lg-3">Login Name :</label>
                            <div class="col-lg-8">                                            
                                <input class=" form-control" id="editusername" name="editusername"  type="text"  />
                                <input id="edituserid" name="edituserid" type="hidden" value="" />
                            </div>
                        </div>
                    </div> 

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="editpassword" class="control-label col-lg-3">Password :</label>
                            <div class="col-lg-8">                                            
                                <input class=" form-control" id="editpassword" name="editpassword"  type="text"  />
                            </div>
                        </div>
                    </div> 




                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="editaddress" class="control-label col-lg-3">Address:</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" type="text" id="editaddress" name="editaddress"></textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="editmobile" class="control-label col-lg-3">Mobile :</label>
                            <div class="col-lg-8">                                            
                                <input class=" form-control" id="editmobile" name="editmobile"  type="text"  />
                            </div>
                        </div>
                    </div> 
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-3">Status :</label>
                            <div class="col-lg-8">
                                <div class="radio">
                                    <label>
                                        Active
                                        <input type="radio" class="radiobutton" name="editstatus" id="editstatusactive" value="1">
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        InActive
                                        <input type="radio" class="radiobutton" name="editstatus" id="editstatusinactive" value="0">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" id="salesmanupdate" class="btn btn-danger">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end edit modal-->

<!-- start delete and edit salesman modal-->
<?php
if (sizeof($salesmandata) > 0):
    foreach ($salesmandata as $salesdata):
        ?>
        <div class="modal fade" id="deletesalesman<?php echo $salesdata->salesManId ?>" tabindex="-1" role="dialog" aria-labelledby="unitdelete" aria-hidden="true">
            <div class="modal-dialog">
                <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('salesman/salesman/deletesalesman'); ?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel" align="Center"><b>Delete message</b></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <p><h4><i class="fa fa-warning"></i>&nbsp;Are you sure want to delete salesman:&nbsp;&nbsp;<?php echo '<span style="color: blue">' . $salesdata->salesManName . '</span>'; ?></h4></p>
                                            <input id="salesmanid" name="salesmanid" type="hidden" value="<?php echo $salesdata->salesManId ?>" /> 
                                            <input id="loginid" name="loginid" type="hidden" value="<?php echo $salesdata->ledgerId ?>" /> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="deletebutton" class="btn btn-primary">YES</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
        <?php
    endforeach;
endif;
?>
<script>
    $("#savesalesmaninfo").click(function () {
        if ($("#salesmanname").val() == '') {
            $("#salesmannamemsg").text("Salesman name can't be empty !!");
            $("#salesmannamemsg").css('color', 'red');
            return false;
        }
    });
    function getsalesmaninfo(id) {
        var dataString = "salesmanid=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('salesman/salesman/getsalesmaninfo'); ?>",
            data: dataString,
            success: function (data) {
                var jobj = $.parseJSON(data);
                $.each(jobj, function () {
                    $("#editsalesmanid").val(id);
                    var lagerId = this['ledgerId'];
                     $("#edituserid").val(lagerId);
                    getNamePassword(lagerId);
                    $("#editsalesmanname").val(this['salesManName']);
                    $("#editaddress").val(this['address']);
                    $("#editmobile").val(this['mobile']);
                    var status = this['activeOrNot'];
                    if (status == '1') {
                        $("#editstatusactive").prop('checked', true);
                    }
                    if (status == '0') {
                        $("#editstatusinactive").prop('checked', true);
                    }
                    $("#salesmanedit").modal('show');
                });
            }
        });
    }


    function getNamePassword(lagerId) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('salesman/salesman/getuserinfo'); ?>",
            data: "lagerId=" + lagerId,
            success: function (data) {
                var jobj = JSON.parse(data);
                 $.each(jobj, function () {             
                    $("#editusername").val(this['username']);
                    $("#editpassword").val(this['password']);
                });
            }
        });

    }





</script>
<?php if ($this->session->userdata('success')): ?>
    <script>

        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Sales Man Added Successfully',
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
                title: 'Failed!',
                text: 'Sales Man Added Fail',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>
<?php if ($this->session->userdata('success_delete')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Sales Man Deleted Successfully',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('success_delete');
endif;
?>
<?php if ($this->session->userdata('fail_delete')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Failed!',
                text: 'Sales Man Delete Fail',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail_delete');
endif;
?>

<?php if ($this->session->userdata('success_update')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Salesman update Successfully',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('success_update');
endif;
?>
<?php if ($this->session->userdata('fail_update')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Failed!',
                text: 'Salesman update Fail',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail_update');
endif;
?>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
<?php foreach ($supplierinfo1 as $unitvalue): ?>
            var id = "<?php echo $unitvalue->ledgerId; ?>"
            if (fyearstatus == '0') {
                $("#updatesalesman" + id).prop("disabled", true);
            }
<?php endforeach; ?>
        if (fyearstatus == '0') {
            $("#addsalesman").prop("disabled", true);
            $("#deletebutton").prop("disabled", true);
        }
    });
</script>