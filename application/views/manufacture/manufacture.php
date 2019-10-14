<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Manufacturer
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
                            <button  class="btn btn-info" id="addmanuf" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                               
                                <th>Manufacturer Name</th>
                                <th>Address</th>
                                <th>Phone No</th>
                                <th>Email Address</th>                            
                            </tr>
                        </thead>   
                        <tbody>
                            <?php foreach ($alldata as $row): ?>                          
                                <tr class="table_hand">
                                    <td >
                                        <a data-toggle="modal" href="#myModaldelete<?php
                                        echo $row->manufactureId;
                                        ?>"><i class="fa fa-times-circle delete-icon" ></i></a>
                                    </td>
                            <a data-toggle="modal" href="#myModaledit<?php
                            echo $row->manufactureId;
                            ?>">                                   
                                <td data-toggle="modal" href="#myModaledit<?php
                                echo $row->manufactureId;
                                ?>">
                                    <?php echo $row->manufactureName; ?></td>

                                <td data-toggle="modal" href="#myModaledit<?php
                                echo $row->manufactureId;
                                ?>">
                                    <?php echo $row->address; ?></td>

                                <td data-toggle="modal" href="#myModaledit<?php
                                echo $row->manufactureId;
                                ?>">
                                    <?php echo $row->phone; ?></td>

                                <td data-toggle="modal" href="#myModaledit<?php
                                echo $row->manufactureId;
                                ?>">
                                    <?php echo $row->email; ?></td>
                            </a>
                            </tr>
                            <!-- start modal for edit data-->

                            <div class="modal fade" id="myModaledit<?php echo $row->manufactureId ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form class="cmxform form-horizontal tasi-form" id="editaccgroup" method="post" action="" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel" align="Center">Edit Manufacturer Information</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">                                                                                                           
                                                        <div class="form">
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="editacccountLedgerName" class="control-label col-lg-4">Manufacturer Name :</label>
                                                                    <div class="col-lg-8">
                                                                        <input class=" form-control" id="editmanufactureId<?php echo $row->manufactureId; ?>" name="editmanufactureId" type="hidden" value="<?php echo $row->manufactureId; ?>" />
                                                                        <input class=" form-control" id="editmanufactureName<?php echo $row->manufactureId; ?>" name="editmanufactureName" type="text" value="<?php echo $row->manufactureName; ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="Address" class="control-label col-lg-4">Address :</label>
                                                                    <div class="col-lg-8">
                                                                        <input class=" form-control" id="editaddress<?php echo $row->manufactureId; ?>" name="editaddress"  type="text" value="<?php echo $row->address; ?>" required />                                       
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="phoneNo" class="control-label col-lg-4">Phone No :</label>
                                                                    <div class="col-lg-8">
                                                                        <input class=" form-control" id="editphone<?php echo $row->manufactureId; ?>" name="editphone"  type="text" value="<?php echo $row->phone; ?>" required />                                       
                                                                    </div>
                                                                </div>
                                                            </div>                                                              
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="emailId" class="control-label col-lg-4">E-mail Id :</label>
                                                                    <div class="col-lg-8">
                                                                        <input class=" form-control" id="editemail<?php echo $row->manufactureId; ?>" name="editemail"  type="email" value="<?php echo $row->email; ?>" required />                                     
                                                                    </div>
                                                                </div>
                                                            </div>                                                             
                                                            <div class="panel-body">
                                                                <div class="form-group ">
                                                                    <label for="description" class="control-label col-lg-4">Description :</label>
                                                                    <div class="col-lg-8">
                                                                        <textarea class=" form-control" id="editdescription<?php echo $row->manufactureId; ?>" name="editdescription"><?php echo $row->description; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>                                                       
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="updatemanuf<?php echo $row->manufactureId; ?>" onclick="return editManufacture(<?php echo $row->manufactureId; ?>);">Update</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                </div>                                      
                                </form>                                 
                            </div>
                            <!--End of edit -->
                            <!-- Start Of Delete Modal -->
                            <div class="modal fade" id="myModaldelete<?php echo $row->manufactureId; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('farmer/farmer/deleteAccLedger') ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h3 class="modal-title" id="myModalLabel" align="Center">Delete message</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="panel-body">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h5><i class="fa fa-warning"></i>&nbsp;Are You Sure You Want To Delete The Manufacturer : &nbsp;&nbsp;<?php echo $row->manufactureName ?></h5>
                                                                <input id="ledgerId" name="manufactureId" type=hidden value="<?php echo $row->manufactureId; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" id="deletemanuf<?php echo $row->manufactureId; ?>" onclick="return deleteManufacturer(<?php echo $row->manufactureId; ?>)">YES</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--End Of Delete Modal -->
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
</section>
<!--Add Manufacture modal Start-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="addfarmer" method="post" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Add Manufacturer Information</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="manufactureName" class="control-label col-lg-4">Manufacturer Name :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="manufactureName" name="manufactureName"  type="text" required  onchange="return accountNameCheck()"/>
                                        <span id="servermsg"></span>
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
                                    <label for="phone" class="control-label col-lg-4">Phone No :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="phone" name="phone"  type="text" required />                                       
                                    </div>
                                </div>
                            </div> 
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="email" class="control-label col-lg-4">E-mail Id :</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="email" name="email"  type="email" required />                                     
                                    </div>
                                </div>
                            </div>                           
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-4">Description :</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control " id="description" name="description" type="text"></textarea>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" onclick="return addManufacture();">Save</button>
                    <button type="reset" class="btn btn-info">Clear</button>
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
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
                <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this manufecturer!! This manufecturer is in used</h4></p>
            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div> 
    </div>
</div>
<!-- end warning delete modal-->
<!---------End of Add New Farmer------------------------>
<!--<script type="text/javascript" src="<?php echo $baseurl; ?>assets/assets/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/gritter.js" ></script>-->
<script type="text/javascript">
    function accountNameCheck() {
        var manufactureName = $("#manufactureName").val();
        var dataString = "manufactureName=" + manufactureName;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('manufacture/manufacture/accountNameCheck'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'free') {
                    $("#manufactureName").css('border-color', 'green');
                    $("#servermsg").text("Manufacturer name available");
                    $("#servermsg").css('color', 'green');
                    return true;
                }
                if (data === 'booked') {
                    $("#manufactureName").css('border-color', 'red');
                    $("#servermsg").text("Manufacturer Name not Available. Please try another");
                    $("#servermsg").css('color', 'red');
                }
            }
        });
    }
    function addManufacture() {
        var manufactureName = $("#servermsg").html();
        if (manufactureName === "Manufacturer Name not Available. Please try another") {
            $("#manufactureName").focus();
            return false;
        } else {
            var manufactureName = $("#manufactureName").val();
            var address = $("#address").val();
            var phone = $("#phone").val();
            var email = $("#email").val();
            var description = $("#description").val();
            if (manufactureName.length < 1) {
                $("#servermsg").css({"display": "block", "color": "red"});
                $("#servermsg").text("Please Enter Manufacturer Name ");
                return false;
            } else {
                $("#servermsg").css({"display": "none"});
                var dataString = "manufactureName=" + manufactureName + "&address=" + address + "&phone=" + phone + "&email=" + email + "&description=" + description;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('manufacture/manufacture/addManufacture'); ?>",
                    data: dataString,
                    success: function (data)
                    {
                        if (data === 'Added') {
                            $('#myModal').modal('hide');
                            $.gritter.add({
                                title: 'Successfull!',
                                text: 'Manufacturer  Added Successfully',
                                sticky: false,
                                time: '5000'
                            });
                            setTimeout("window.location.reload(1)", 2000);
                            return true;
                        }
                        if (data === 'Notadded') {
                            $('#myModal').modal('hide');
                            $.gritter.add({
                                title: 'Unsuccessfull!',
                                text: 'Manufacturer Not Added ',
                                sticky: false,
                                time: '5000'
                            });
                            setTimeout("window.location.reload(1)", 2000);
                        }
                    }
                });
            }
        }
    }
    function editManufacture(id)
    {
        var editmanufactureName = "#editmanufactureName" + id;
        var editaddress = "#editaddress" + id;
        var editphone = "#editphone" + id;
        var editemail = "#editemail" + id;
        var editdescription = "#editdescription" + id;
        var editmanufactureName = $(editmanufactureName).val();
        var editaddress = $(editaddress).val();
        var editphone = $(editphone).val();
        var editemail = $(editemail).val();
        var editdescription = $(editdescription).val();
        var dataString = "editmanufactureId=" + id + "&editmanufactureName=" + editmanufactureName + "&editaddress=" + editaddress + "&editphone=" + editphone + "&editemail=" + editemail + "&editdescription=" + editdescription;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('manufacture/manufacture/editManufacture'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'Updated') {
                    $('#myModaledit' + id).modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Manufacturer Updated Successfully',
                        sticky: false,
                        time: '5000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                }
                if (data === 'Notupdated') {
                    $('#myModaledit' + id).modal('hide');
                    $.gritter.add({
                        title: 'Unsuccessfull!',
                        text: 'Manufacturer Not Updated ',
                        sticky: false,
                        time: '5000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                }
            }
        });
    }
    function deleteManufacturer(id)
    {
        var dataString = "manufactureId=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('manufacture/manufacture/deleteManufacturer'); ?>",
            data: dataString,
            success: function (data)
            {
                if (data === 'Deleted') {
                    $('#myModaldelete' + id).modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Manufacturer Deleted Successfully',
                        sticky: false,
                        time: '5000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                }
                if (data === 'Notdeleted') {
                    $('#myModaldelete' + id).modal('hide');
                    $("#deletedinaccessed").modal('show');
                }
            }
        });
    }
</script>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
<?php foreach ($alldata as $unitvalue): ?>
            var id = "<?php echo $unitvalue->manufactureId; ?>"
            if (fyearstatus == '0') {
                $("#updatemanuf" + id).prop("disabled", true);
                $("#deletemanuf" + id).prop("disabled", true);
            }
<?php endforeach; ?>
        if (fyearstatus == '0') {
            $("#addmanuf").prop("disabled", true);
        }
    });
</script>
