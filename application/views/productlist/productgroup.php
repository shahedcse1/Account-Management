<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <style>
            table tbody tr{
                cursor: pointer
            }
        </style>
        <section class="panel">
            <header class="panel-heading">
                Product Group
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <button  class="btn btn-info" id="addproductgroup" data-toggle="modal" data-target="#addProductunit">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>                        
                    </div>                    
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>                                
                                <th>Product Group name</th>
                                <th>Description</th>                                 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (sizeof($unitdata) > 0):
                                foreach ($unitdata as $unitvalue):
                                    ?>
                                    <tr class="">
                                        <td><a data-toggle="modal" href="#unitdelete<?php echo $unitvalue->productGroupId ?>">
                                                <i class="fa fa-times-circle delete-icon"></i></a>
                                        </td>
                                        <td data-toggle="modal" data-target="#unitedit<?php echo $unitvalue->productGroupId ?>"><?php echo $unitvalue->productGroupName ?></td>
                                        <td data-toggle="modal" data-target="#unitedit<?php echo $unitvalue->productGroupId ?>"><?php echo $unitvalue->description ?></td>                                                                         
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
                    <div class="modal fade" id="unitdelete<?php echo $unitvalue->productGroupId ?>" tabindex="-1" role="dialog" aria-labelledby="unitdelete" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('productlist/productGroup/deleteproductGroup') ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="myModalLabel" align="Center"><b>Delete message</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><h4><i class="fa fa-warning"></i>&nbsp;Are you sure want to delete Unit:&nbsp;&nbsp;<?php echo '<span style="color: blue">' . $unitvalue->productGroupName . '</span>'; ?></h4></p>
                                        <input id="productGroupId" name="productGroupId" type="hidden" value="<?php echo $unitvalue->productGroupId ?>" />                                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="Submit" id="deleteproductgroup<?php echo $unitvalue->productGroupId ?>" class="btn btn-danger">YES</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>            
                    <!-- Edit modal start-->
                    <div class="modal fade" id="unitedit<?php echo $unitvalue->productGroupId ?>" tabindex="-1" role="dialog" aria-labelledby="unitdelete" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('productlist/productGroup/editproductGroup') ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="myModalLabel" align="Center"><b>Edit product group</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="panel-body">
                                            <div class="form-group ">
                                                <label for="unitname" class="control-label col-lg-3">Unit Name:</label>
                                                <div class="col-sm-8">
                                                    <input id="productGroupId" name="productGroupId" type="hidden" value="<?php echo $unitvalue->productGroupId ?>" /> 
                                                    <input class=" form-control" id="productGroupName" name="productGroupName" value="<?php echo $unitvalue->productGroupName; ?>" type="text" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group ">
                                                <label for="description" class="control-label col-lg-3 col-sm-3">Description:</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" type="text" id="description" name="description"><?php echo $unitvalue->description; ?></textarea>
                                                </div>
                                            </div>   
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="Submit" id="updateproductgroup<?php echo $unitvalue->productGroupId ?>" class="btn btn-danger">Update</button>
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
                            <p><h4><i class="fa fa-warning"></i>&nbsp;Sorry !! You can not delete this product group!! This product group is in used</h4></p>
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
                        <form class="cmxform form-horizontal" id="unitgroupadd" method="post" action="<?php echo site_url('productlist/productGroup/addproductGroup'); ?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Product Group Information</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group ">
                                    <label for="unitname" class="control-label col-lg-4">Product Group Name:</label>
                                    <div class="col-lg-8">
                                        <input class=" form-control" id="productGroupName" name="productGroupName" type="text" />
                                        <input class=" form-control" id="unitmodalname" name="unitmodalname" type="hidden" value="addProductUnit" />
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label for="description" class="control-label col-lg-4">Description:</label>
                                    <div class="col-lg-8 col-sm-8">
                                        <textarea class="form-control" type="text" id="description" name="description"></textarea>
                                    </div>
                                </div>                                  
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Save"/>
                                <input type="reset" class="btn btn-info" value="Clear"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                                
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
<?php if ($this->session->userdata('deleted') == 'Deleted'): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Product group deleted Successfully',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('deleted');
endif;
?>
<?php if ($this->session->userdata('deleted') == 'Notdeleted'): ?>
    <script>
        $(document).ready(function () {
            $("#deletedinaccessed").modal('show');
        })
    </script>    
    <?php
    $this->session->unset_userdata('deleted');
endif;
?>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
<?php foreach ($unitdata as $unitvalue): ?>
            var id = "<?php echo $unitvalue->productGroupId; ?>"
            if (fyearstatus == '0') {
                $("#updateproductgroup" + id).prop("disabled", true);
                $("#deleteproductgroup" + id).prop("disabled", true);
            }
<?php endforeach; ?>
        if (fyearstatus == '0') {
            $("#addproductgroup").prop("disabled", true);
        }
    });
</script>
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Successfull!',
                // (string | mandatory) the text inside the notification
                text: 'Action Completed Successfully',
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
    $this->session->unset_userdata('success');
endif;
?>
<?php if ($this->session->userdata('fail')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Successfull!',
                // (string | mandatory) the text inside the notification
                text: 'Failed to complete your action',
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
    $this->session->unset_userdata('success');
endif;
?>