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
                Update Company Information
            </header>
            <form action="<?php echo site_url('company/company/updatecompanyinfo'); ?>" method="post" class="form-horizontal custom-form" role="form" enctype="multipart/form-data">
                <div class="panel-body">

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-3">Company Name:</label>
                            <div class="col-lg-8">
                                <input id="accountGroupId" name="companyid" type="hidden" value="<?php echo $cdata->companyId ?>" /> 
                                <input class=" form-control" id="companyname" name="companyname" value="<?php echo $cdata->companyName; ?>" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="description" class="control-label col-lg-3 col-sm-3">Address:</label>
                            <div class="col-lg-8 col-sm-8">
                                <textarea class="form-control" type="text" id="address" name="address"><?php echo $cdata->address; ?></textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-3">Email:</label>
                            <div class="col-lg-8">                                                    
                                <input class=" form-control" id="email" name="email" value="<?php echo $cdata->email; ?>" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="phone" class="control-label col-lg-3">Phone:</label>
                            <div class="col-lg-8">                                                    
                                <input class=" form-control" id="fax" name="fax" value="<?php echo $cdata->fax; ?>" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <!--                            <div class="col-lg-1"> </div>-->
                            <label for="mobile1" class="control-label col-lg-3">Mobile-1:</label>
                            <div class="col-lg-3">                                                    
                                <input class=" form-control" id="mobile1" name="mobile1" value="<?php echo $cdata->mobile1; ?>" type="text" />
                            </div> 
                            <label for="position1" class="control-label col-lg-2">Position-1:</label>
                            <div class="col-lg-2">                                                    
                                <input class="form-control" id="position1" name="position1" value="<?php echo str_replace(array('(', ')'), '', $cdata->position1); ?>" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="mobile2" class="control-label col-lg-3">Mobile-2:</label>
                            <div class="col-lg-3">                                                    
                                <input class=" form-control" id="companyname" name="mobile2" value="<?php echo $cdata->mobile2; ?>" type="text" />
                            </div>
                            <label for="position2" class="control-label col-lg-2">Position-2:</label>
                            <div class="col-lg-2">                                                    
                                <input class="form-control" id="position2" name="position2" value="<?php echo str_replace(array('(', ')'), '', $cdata->position2); ?>" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="mobile3" class="control-label col-lg-3">Mobile-3:</label>
                            <div class="col-lg-3">                                                   
                                <input class=" form-control" id="companyname" name="mobile3" value="<?php echo $cdata->mobile3; ?>" type="text" />
                            </div>
                            <label for="position3" class="control-label col-lg-2">Position-3:</label>
                            <div class="col-lg-2">                                                    
                                <input class="form-control" id="position3" name="position3" value="<?php echo str_replace(array('(', ')'), '', $cdata->position3); ?>" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="mobile4" class="control-label col-lg-3">Mobile-4:</label>
                            <div class="col-lg-3">                                                    
                                <input class=" form-control" id="mobile4" name="mobile4" value="<?php echo $cdata->mobile4; ?>" type="text" />
                            </div>
                            <label for="position4" class="control-label col-lg-2">Position-4:</label>
                            <div class="col-lg-2">                                                    
                                <input class="form-control" id="position4" name="position4" value="<?php echo str_replace(array('(', ')'), '', $cdata->position4); ?>" type="text" />
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="city" class="control-label col-lg-3">City:</label>
                            <div class="col-lg-3">                                                   
                                <input class=" form-control" id="city" name="city" value="<?php echo $cdata->city; ?>" type="text" />
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="city" class="control-label col-lg-3">Invoice Serial Prefix</label>
                            <div class="col-lg-3">                                                   
                                <input class=" form-control" id="invoice_prefix" name="invoice_prefix" value="<?php echo $cdata->invoice_prefix; ?>" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="userfile" class="control-label col-lg-3">Upload Logo<br>Max (200&#10005;200)px</label>
                            <div class="col-lg-3">                                                   
                                <input class=" form-control" id="userfile" name="userfile"  type="file" />
                                <span style="color:blue" id="file_msg"><?php
                                    echo $this->session->userdata('error_msg');
                                    $this->session->unset_userdata('error_msg');
                                    ?></span>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4 right"> </div>
                    <div class="col-lg-4"> 
                        <button type="Submit" class="btn btn-danger">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>

                </div>
            </form>
            <!-- delete unit start-->            
        </section>
    </section>
</section> 

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
        }
    });
</script>
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Company Information Update Successfully',
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
                title: 'Fail!',
                text: 'Company Information Update Fail',
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
    function deletecompany(id) {
        var dataString = "accountGroupId=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('company/company/deletecompany') ?>",
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
</script>
