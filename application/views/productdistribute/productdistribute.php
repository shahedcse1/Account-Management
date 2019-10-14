<style>
    .clickable a{
        width:100%;
        display:block;
    }   
</style>
<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Raw Product
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <a href="<?php echo site_url('productdistribute/productdistribute/add_view_productdistribute'); ?>">
                                <button  class="btn btn-info" id="addproduct">
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>                        
                    </div>                    
                    <table  class="display table table-bordered table-striped" id="sales-datatable">
                        <thead>
                            <tr>
                                <th></th>  
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>Product Qty</th>
                                <th>Rate</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="myModaldelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel" align="Center">Alert</h4>
                        </div>
                        <form method="POST" action="<?php echo site_url('productdistribute/productdistribute/delete_productdistribute'); ?>">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <section class="panel">
                                            <div class="panel-body">
                                                <div class="form">
                                                    <h4>Are you sure you want to Delete Distribute :
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
            <!-- ####################################### / Modal Delete Data ########################################## -->
        </section>
    </section>
</section>
<script>
    $(document).ready(function() {
        var oTable = $('#sales-datatable').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('productdistribute/productdistribute/getSalesDetailsTable'); ?>',
            "order": [[4, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]
        });
//        oTable.on('order.dt search.dt', function() {
//            oTable.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
//                cell.innerHTML = i + 1;
//            });
//        }).draw();
    });
    function deleteModalFun(masterId) {
        $("#salesMasterIdview").text(masterId);
        $("#salesMasterId").val(masterId);
        $("#myModaldelete").modal('show');
    }

</script>
<?php if ($this->session->userdata('deleted') == 'Deleted'): ?>
    <script>
        $(document).ready(function() {
            $.gritter.add({
                title: 'Successfull!',
                text: 'Product deleted Successfully',
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
        $(document).ready(function() {
            $("#deletedinaccessed").modal('show');
        })
    </script>    
    <?php
    $this->session->unset_userdata('deleted');
endif;
?>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function() {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
<?php foreach ($alldata as $unitvalue): ?>
            var id = "<?php echo $unitvalue->productId; ?>"
            if (fyearstatus == '0') {
                $("#updateproduct" + id).prop("disabled", true);
                $("#deleteproduct" + id).prop("disabled", true);
            }
<?php endforeach; ?>
        if (fyearstatus == '0') {
            $("#addproduct").prop("disabled", true);
        }
    });
</script>
<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function() {
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
        $(document).ready(function() {
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
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".clickableRow").click(function() {
            window.document.location = $(this).attr("href");
        });
    });
</script>