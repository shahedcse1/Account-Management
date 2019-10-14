<section id="main-content" >
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading">
                Financial Year List
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
                            <button  class="btn btn-info" id="addaccountledger" data-toggle="modal" data-target="#addfinancialyear"><i class="fa fa-plus"></i>&nbsp;Add Financial Year</button>
                        </div>
                    </div>                  
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>                                
                                <th>No.</th> 
                                <th>From Date</th>
                                <th>To Date</th>                               
                                <th>Status</th>                                
                            </tr>
                        </thead>   
                        <tbody>
                            <?php
                            if (sizeof($financialyeardata) > 0):
                                $i = 0;
                                foreach ($financialyeardata as $rowdata):
                                    ?>                          
                                    <tr>                                       
                                        <td><?php echo ++$i; ?></td> 
                                        <td><a href="#" onclick="getyearinfo(<?php echo $rowdata->finacialYearId; ?>)"><?php echo $rowdata->fromDate; ?></a></td> 
                                        <td><?php echo $rowdata->toDate; ?></td>                                      
                                        <td>
                                            <?php
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
<!-- add  start here-->
<div class="modal fade" id="addfinancialyear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="addaccledger" method="post" action="<?php echo site_url('financialyear/financialyear/addfinancialyear'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center">Add Financial Year</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="fromdate" class="control-label col-lg-4">Date From :</label>                                  
                                    <div class="iconic-input right col-lg-8">
                                        <i class="fa fa-calendar"></i>
                                        <input type="text" id="fyearfrom" class="form-control" name="fromdate" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="todate" class="control-label col-lg-4">Date To :</label>
                                    <div class="iconic-input right col-lg-8">
                                        <i class="fa fa-calendar"></i>
                                        <input type="text" id="fyearto" class="form-control" name="todate" value="">
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

<div class="modal fade" id="updatefinancialyear" tabindex="-1" role="dialog" aria-labelledby="updatefinanacialyear" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('financialyear/financialyear/updatefinancialyear') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center"><b>Update Financial Year  </b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="fromdate" class="control-label col-lg-4">Date From :</label>                                  
                                    <div class="iconic-input right col-lg-8">
                                        <i class="fa fa-calendar"></i>
                                        <input type="hidden" name="fyearupdateid" value="" id="fyearupdateid"/>
                                        <input type="text" id="fyearfrom_edit" class="form-control" name="fromdate" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="todate" class="control-label col-lg-4">Date To :</label>
                                    <div class="iconic-input right col-lg-8">
                                        <i class="fa fa-calendar"></i>
                                        <input type="text" id="fyearto_edit" class="form-control" name="todate" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group ">
                                    <label for="email" class="control-label col-lg-4">Status :</label>
                                    <div class="col-lg-8">                                      
                                        <div id="showajaxdiv"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-danger">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- alert modal for close financial year-->
<div class="modal fade" id="closeModalFinancial" tabindex="-1" role="dialog" aria-labelledby="updatefinanacialyear" aria-hidden="true">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="#">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel" align="Center"><b>Financial year add notice!!</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h4>&nbsp;&nbsp;<i class="fa fa-warning"></i>&nbsp;Close active financial year before creating new financial year</h4> 
                    </div>
                </div>
                <div class="modal-footer">                 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- end edit modal-->

<!-- start delete and edit salesman modal-->

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
</script>
<?php if ($this->session->userdata('success')): ?>
    <script>

        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Financial Year Added Successfully',
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
                text: 'Financial Year Added Fail',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>

<?php if ($this->session->userdata('fail_add')): ?>
    <script>
        $(document).ready(function () {
            $("#closeModalFinancial").modal("show");
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail_add');
endif;
?>

<?php if ($this->session->userdata('success_update')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Financial Year Update Successfully',
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
                text: 'Financial Year Update Fail',
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
    function getyearinfo(id) {
        var dataString = "fyearid=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('financialyear/financialyear/getfinacialYearStatus'); ?>",
            data: dataString,
            success: function (data)
            {
                $("#showajaxdiv").html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('financialyear/financialyear/getfyeardata'); ?>",
            data: dataString,
            success: function (data)
            {
                var jobj = $.parseJSON(data);
                $.each(jobj, function () {
                    $("#fyearupdateid").val(id);
                    $("#fyearfrom_edit").val(this['fromDate']);
                    $("#fyearto_edit").val(this['toDate']);
                    $("#updatefinancialyear").modal('show');
                });
            }
        });
    }
</script>

