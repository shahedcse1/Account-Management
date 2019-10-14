<style>
    .form-control {
        margin-left: 0px;
    }
    .edit_purchase{
        display: block;
        color: #111;
    }
    
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Sales Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <br/>
                            <a href="<?php echo site_url('sales/sales/add_view'); ?>">
                                <button id="addselesbtn" class="btn btn-info" >
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>
                    </div>


                    <table class="display table table-bordered table-striped" id="sales-datatable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Invoice No</th>
                                <th>Ledger</th>
                                <th>Name Of Business</th>
                                <th>Amount</th>
                                <th>Date</th>
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
            <form method="POST" action="<?php echo site_url('sales/sales/delete'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="form">
                                        <h4>Are you sure you want to void the Sales invoice :
                                            <b id="salesMasterIdview"> </b>
                                            ?</h4>
                                        <input type="hidden" name="salesMasterId" id="salesMasterId">
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <button type="submit" id="deletesales" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    var userrole = "<?php echo $this->sessiondata['userrole']; ?>";
    $(document).ready(function () {
        if (userrole == 's') {
            $("#addsalesbtn").prop("disabled", true);
            $("#deletesales").prop("disabled", true);
            //$("#addpurchase").prop("disabled", true);
        }
    });
</script>

<script>
    $(document).ready(function () {
        var oTable = $('#sales-datatable').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('sales/sales/getSalesDetailsTable'); ?>',
            "order": [[5, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]
        });
    });

    function deleteModalFun(masterId) {
        if (userrole == 's' || userrole == 'r') {
            $("#myModaldelete").modal('hide');
        } else {
            $("#salesMasterIdview").text(masterId);
            $("#salesMasterId").val(masterId);
            $("#myModaldelete").modal('show');
        }
    }
</script>

<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";

        if (fyearstatus == '0') {
            $("#deletesales").prop("disabled", true);
            $("#addselesbtn").prop("disabled", true);
        }
    });
</script>