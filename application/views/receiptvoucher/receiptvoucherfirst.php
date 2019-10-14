<style>
    .clickable a{
        width:100%;
        display:block;
    }   
     .panel-heading{
        background-color:#305cc5;
    }
    .adv-table table.display thead th, table.display tfoot th{
        background-color:#305cc5;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Receipt Voucher
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <a href="<?php echo site_url('receiptvoucher/receiptvoucher/addreceiptvoucher'); ?>">
                                <button  class="btn btn-info" id="addreceive">
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>                        
                    </div>                                       

                    <table class="display table table-bordered table-striped" id="receipt-voucher-datatable">
                        <thead>
                            <tr>
                                <th></th>                                
                                <th>Voucher No</th>
                                <th>Receipt No</th>
                                <th>Received From</th>
                                <th>Business Name</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>   


                    <!--Start Modal Delete Data -->
                    <div class="modal fade" id="myModaldelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form class="cmxform form-horizontal tasi-form" method="post" action="<?php echo site_url('receiptvoucher/receiptvoucher/deletereceiptvou') ?>">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Delete message</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="panel-body">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <h5><i class="fa fa-warning"></i>&nbsp; Are You Sure You Want To Delete The Payment Voucher :&nbsp;&nbsp;<b id="receiptVoucherNo"></h5>
                                                        <input name="receiptMasterId" id="receiptMasterId" type=hidden />                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="deletereceive" class="btn btn-danger" >YES</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>  
                    <!--end delete modal-->

                </div>
            </div>
        </section>
    </section>
</section>

<script>
    $(document).ready(function () {
        var oTable = $('#receipt-voucher-datatable').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('receiptvoucher/receiptvoucher/getReceiptDetailsTable'); ?>',
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
        $("#receiptVoucherNo").text(masterId);
        $("#receiptMasterId").val(masterId);
        $("#myModaldelete").modal('show');
    }
</script>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#addreceive").prop("disabled", true);
            $("#deletereceive").prop("disabled", true);

        }
    });
</script>