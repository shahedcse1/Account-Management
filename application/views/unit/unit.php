<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <style>
            table tbody tr{
                cursor: pointer
            }
            #myModalLabel{
                font-weight: bold
            }
        </style>

        <section class="panel">
            <header class="panel-heading">
                Product Unit
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <button  class="btn btn-info" data-toggle="modal" id="addnewunit" data-target="#addProductunit">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>                        
                    </div>                   
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                                
                                <th>Unit name</th>
                                <th>Description</th>                                 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (sizeof($unitdata) > 0):
                                foreach ($unitdata as $unitvalue):
                                    ?>
                                    <tr class="">
                                        <td> <a data-toggle="modal" href="#unitdelete<?php echo $unitvalue->unitId ?>">
                                                <i class="fa fa-times-circle delete-icon"></i></a>
                                        </td>
                                        <td data-toggle="modal" data-target="#unitedit<?php echo $unitvalue->unitId ?>"><?php echo $unitvalue->unitName ?></td>
                                        <td data-toggle="modal" data-target="#unitedit<?php echo $unitvalue->unitId ?>"><?php echo $unitvalue->description ?></td>                                                                         
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- delete unit start-->

            <!--Start Modal Delete Data -->
            <?php
            if (sizeof($unitdata) > 0):
                foreach ($unitdata as $unitvalue):
                    ?>
                    <div class="modal fade" id="unitdelete<?php echo $unitvalue->unitId ?>" tabindex="-1" role="dialog" aria-labelledby="unitdelete" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="#">
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
                                                        <p><h4><i class="fa fa-warning"></i>&nbsp;Are you sure want to delete Unit:&nbsp;&nbsp;<?php echo '<span style="color: blue">' . $unitvalue->unitName . '</span>'; ?></h4></p>
                                                        <input id="accountGroupId" name="accountGroupId" type="hidden" value="<?php echo $unitvalue->unitId ?>" />                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="deleteunit<?php echo $unitvalue->unitId ?>" onclick="return deleteunit(<?php echo $unitvalue->unitId ?>)">YES</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>            
                    <!-- Edit modal start-->
                    <div class="modal fade" id="unitedit<?php echo $unitvalue->unitId ?>" tabindex="-1" role="dialog" aria-labelledby="unitdelete" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('productunit/unit/undateunit') ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="myModalLabel" align="Center"><b>Edit unit </b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="panel-body">
                                            <div class="form-group ">
                                                <label for="unitname" class="control-label col-lg-3">Unit Name:</label>
                                                <div class="col-lg-8">
                                                    <input id="accountGroupId" name="accountGroupId" type="hidden" value="<?php echo $unitvalue->unitId ?>" /> 
                                                    <input class=" form-control" id="unitname" name="unitname" value="<?php echo $unitvalue->unitName; ?>" type="text" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group ">
                                                <label for="description" class="control-label col-lg-3 col-sm-3">Description:</label>
                                                <div class="col-lg-8 col-sm-8">
                                                    <textarea class="form-control" type="text" id="description" name="description"><?php echo $unitvalue->description; ?></textarea>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="Submit" class="btn btn-danger" id="updateunit<?php echo $unitvalue->unitId ?>">Update</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end edit modal-->
                    <?php
                endforeach;
            endif;
            ?>
            <!--end delete modal-->
            <!-- Warning Delete modal for accessed-->
            <div class="modal fade" id="deletedinaccessed" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Delete message</h4>
                        </div>
                        <div class="modal-body">    
                            <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this unit!! This unit is in used</h4></p>
                        </div>
                        <div class="modal-footer">                 
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div> 
                </div>
            </div>
            <!-- end warning delete modal-->
            <!-- end delete unit-->
            <!-- Add unit-->
            <div class="modal fade" id="addProductunit" tabindex="-1" role="dialog" aria-labelledby="addProductunit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="cmxform form-horizontal" id="unitgroupadd" method="post" action="#">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Unit Information</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group ">
                                    <label for="unitname" class="control-label col-lg-3">Unit Name:</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="newunitname" name="unitname" type="text" required onchange="return checkuniqueunit();"/>
                                        <input type="hidden" name="modalname" id="modalname" value="addunitmodal">
                                        <span id="needunitname"></span>
                                    </div>                                    
                                </div>

                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-3 col-sm-3">Description:</label>
                                    <div class="col-lg-8 col-sm-8">
                                        <textarea class="form-control" type="text" id="unitdes" name="description" onsubmit="return stopform()"></textarea>
                                    </div>
                                </div>                                  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="saveunitgroup">Save unit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                               
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section> 
<script type="text/javascript">
    function stopform() {
        // Retrieve the code
        var code = document.getElementById('unitdes').value;
        // Return false to prevent the form to submit
        return false;
    }
</script>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
<?php foreach ($unitdata as $unitvalue): ?>
            var id = "<?php echo $unitvalue->unitId; ?>"
            if (fyearstatus == '0') {
                $("#deleteunit" + id).prop("disabled", true);
                $("#updateunit" + id).prop("disabled", true);
            }
<?php endforeach; ?>
        if (fyearstatus == '0') {
            $("#saveunitgroup").prop("disabled", true);
            $("#addnewunit").prop("disabled", true);
        }
    });
</script>
<?php if ($this->session->userdata('success')): ?>
    <script>

        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Unit update Successfully',
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
                text: 'Unit update Fail',
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
    $("#saveunitgroup").click(function () {
        var dataString = "unitname=" + $("#newunitname").val() + "&description=" + $("#unitdes").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('productunit/unit/addunit'); ?>",
            data: dataString,
            success: function (data) {
                if (data === 'added') {
                    $('#addProductunit').modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Unit Added Successfully',
                        sticky: false,
                        time: '3000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                    return true;
                }
                if (data === 'failed') {
                    $('#addProductunit').modal('hide');
                    $.gritter.add({
                        title: 'Failed!',
                        text: 'Unit Added failed',
                        sticky: false,
                        time: '3000'
                    });
                }
            }
        });
    });

    function deleteunit(id) {
        var dataString = "accountGroupId=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('productunit/unit/deleteunit') ?>",
            data: dataString,
            success: function (data) {
                if (data == "Deleted") {
                    $("#unitdelete" + id).modal('hide');
                    $.gritter.add({
                        title: 'Successfull!',
                        text: 'Unit deleted Successfully',
                        sticky: false,
                        time: '3000'
                    });
                    setTimeout("window.location.reload(1)", 2000);
                    return true;
                }
                if (data == 'fail') {
                    $("#unitdelete" + id).modal('hide');
                    $("#deletedinaccessed").modal('show');
                }
            }
        });
    }
    function checkuniqueunit() {
        var dataString = "unitname=" + $("#newunitname").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('productunit/unit/checkunitname'); ?>",
            data: dataString,
            success: function (data) {
                if (data == 'booked') {
                    $("#newunitname").focus();
                    $("#newunitname").css('border-color', 'red');
                    $("#needunitname").text("Unit name not available");
                    $("#needunitname").css('color', 'red');
                    $("#saveunitgroup").prop("disabled", true);
                }
                if (data == 'free') {
                    $("#needunitname").text('');
                    $("#newunitname").css('border-color', 'gray');
                    $("#saveunitgroup").prop("disabled", false);
                }
            }
        });
    }
</script>
