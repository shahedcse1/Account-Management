<style>
    .form-control {
        margin-left: 0px;
    }
    .edit_purchase{
        display: block;
        color: #111;
    }

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
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Sales ReadyStock Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <br/>
                            <a href="<?php echo site_url('salesfarmer/salesfarmer/add_view'); ?>">
                                <button class="btn btn-info" >
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <!--                   Ssp datatable            -->

                    <table class="display table table-bordered table-striped" id="branchtable-sample">
                        <thead>
                            <tr>
                                <th style="text-align:center"></th> 
                                <th style="text-align:center">Invoice No</th> 
                                <th style="text-align:center">Farmer Name</th>          
                                <th style="text-align:center">Pcs</th>                      
                                <th style="text-align:center">KG</th>
                                <th style="text-align:center">Amount</th>
                                <th style="text-align:center">Date</th>
                           
                            </tr>
                        </thead>
                    </table> 

                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--=======================================================Modal for Delete data ===================================-->
<div class="modal fade" id="myModaldelete" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel" align="Center">Alert</h4>
            </div>
            <form method="POST" action="<?php echo site_url('salesfarmer/salesfarmer/delete'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="form">
                                        <h4>Are you sure you want to void the Sales invoice :
                                            <b id="masteridshow"> </b>
                                            ?</h4>
                                        <input type="hidden" name="salesReadyStockMasterId" id="salesReadyStockMasterId">

                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>
        </div>
    </div>
</div>
</div>


<script>

    $(document).ready(function () {
        var oTable = $('#branchtable-sample').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('salesfarmer/salesfarmer/getSalesreadystockDetailsTable'); ?>',
            "order": [[6, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
              
                {"sClass": "center"}]
        });
    });

    function deleteModalFun(masterId) {
        $("#masteridshow").text(masterId);
        $("#salesReadyStockMasterId").val(masterId);
        $("#myModaldelete").modal('show');
    }

</script>


