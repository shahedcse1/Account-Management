<style>
    .form-control {
        margin-left: 0px;
    }
    .edit_purchase{
        display: block;
        color: #111;
    }
      .panel-heading{
        background-color:#ba41a3;
    }
    .adv-table table.display thead th, table.display tfoot th{
        background-color:#ba41a3;
    }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Sales Return Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <br/>
                            <a href="<?php echo site_url('salesreturn/salesreturn/add_view'); ?>">
                                <button class="btn btn-info" id="addsalesreturn">
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>
                    </div>

                    <table class="display table table-bordered table-striped" id="sales-return-tab">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Voucher No</th>
                                <th>Sales Voucher No  </th>
                                <th>Customer Name </th>
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
            <form method="POST" action="<?php echo site_url('salesreturn/salesreturn/delete'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="form">
                                        <h4>Are you sure you want to delete the Sales Return Voucher No:
                                            <b id="orderNoid"> </b>
                                            !</h4>
                                        <input type="hidden" name="salesReturnMasterId" id="salesReturnMasterId">                                                     
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="deletesalesreturn" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        var oTable = $('#sales-return-tab').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('salesreturn/salesreturn/getSalesReturnDetailsTable'); ?>',
            "order": [[4, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]
        });
    });

<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    var userrole = "<?php echo $this->sessiondata['userrole']; ?>";
    function deleteModalFun(masterId) {
        if (userrole != 'r') {
            $("#orderNoid").text(masterId);
            $("#salesReturnMasterId").val(masterId);
            $("#myModaldelete").modal('show');
        }
    }
</script>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";

        if (fyearstatus == '0') {
            $("#addsalesreturn").prop("disabled", true);
            $("#deletesalesreturn").prop("disabled", true);
        }
    });
</script>

