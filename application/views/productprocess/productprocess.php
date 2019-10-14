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
                            <a href="<?php echo site_url('productprocess/productprocess/add_view_processProduct'); ?>">
                                <button  class="btn btn-info" id="addproduct">
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>                        
                    </div>                    
                    <table  class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                            <tr>
                                <th></th>  
                                <th>Sl.</th>
                                <th>Product Name</th>
                                <th>Product Qty</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (sizeof($productProcess) > 0):
                                foreach ($productProcess as $rows):
                                    ?>
                                    <tr class="table_hand">
                                        <td><a data-toggle="modal" href="#unitdelete<?php echo $rows->id ?>">
                                                <i class="fa fa-times-circle delete-icon"></i></a>
                                        </td>
                                        <td><?php echo $i++; ?></td>
                                        <td class="">
                                            <?php
                                            $readyProductId = $rows->readyid;
                                            $productNameQry = $this->db->query("SELECT productName from product where productId = '$readyProductId'");
                                            echo $productName = $productNameQry->row()->productName;
                                            ?>
                                        </td>
                                        <td class=""><?php echo $rows->readytqy ?></a></td>                                      
                                        <td class=""><?php echo $rows->date ?></a></td>         
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            if (sizeof($productProcess) > 0):
                foreach ($productProcess as $rows):
                    ?>
                    <div class="modal fade" id="unitdelete<?php echo $rows->id ?>" tabindex="-1" role="dialog" aria-labelledby="unitdelete" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="cmxform form-horizontal tasi-form" id="delaccgroup" method="post" action="<?php echo site_url('productprocess/productprocess/delete_processProduct') ?>">
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
                                                        <p><h4><i class="fa fa-warning"></i>&nbsp; Are you sure want to delete Product:</h4></p>
                                                        <input id="idProductprocess" name="idProductprocess" type="hidden" value="<?php echo $rows->id ?>" />                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="Submit" id="deleteproduct<?php echo $rows->id ?>" class="btn btn-danger">YES</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>            
                    <?php
                endforeach;
            endif;
            ?>
            <!-- ####################################### / Modal Delete Data ########################################## -->
        </section>
    </section>
</section>
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