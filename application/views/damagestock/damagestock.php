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
                Stock Entry Information
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <br/>
                            <a href="<?php echo site_url('damagestock/damagestock/add_view'); ?>">
                                <button class="btn btn-info" id="addstock">
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                    <table class="display table table-bordered table-striped" id="cloudAccounting">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Voucher No</th>
                            <th>Date</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php if (isset($stockmasterinfo)) {
                            foreach ($stockmasterinfo as $stockmaster) {
                                $datevalue = date_create($stockmaster->date);
                                $dayvalue = date_format($datevalue, 'd');
                                $monvalue = date_format($datevalue, 'F');
                                $yrval = date_format($datevalue, 'Y');
                                $date=$dayvalue . ' ' . substr($monvalue, 0, 3) . '  ' . $yrval;
                                ?>

                                <tr>
                                <td>
                                <a  data-toggle="modal" href="#myModaldelete<?php echo $stockmaster->damageStockMasterId;?>">
                                <i  class="fa fa-times-circle delete-icon"></i> </a>
                                </td>
                                <td><a class='edit_purchase' href='<?php echo site_url('damagestock/damagestock/add_view_edit');?>?id=<?php echo $stockmaster->damageStockMasterId;?>'> <?php echo $stockmaster->damageStockMasterId;?></a></td>
                                <td><a class='edit_purchase' href='<?php echo site_url('damagestock/damagestock/add_view_edit');?>?id=<?php echo $stockmaster->damageStockMasterId;?>'><?php echo $date;?></a> </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--=======================================================Modal for Delete data ===================================-->
<?php  if (isset($stockmasterinfo)) {
        foreach ($stockmasterinfo as $stockmaster) {
        ?>
        <div class="modal fade" id="myModaldelete<?php echo $stockmaster->damageStockMasterId; ?>" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel" align="Center">Alert</h4>
                    </div>
                    <form method="POST" action="<?php echo site_url('damagestock/damagestock/delete'); ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <section class="panel">
                                        <div class="panel-body">
                                            <div class="form">
                                                <h4>Are you sure you want to delete voucher no :
                                                    <b><?php echo $stockmaster->damageStockMasterId;?></b>!</h4>
                                                <input type="hidden" name="damageStockMasterId"
                                                       value="<?php echo $stockmaster->damageStockMasterId;?>">
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="deletestock" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    <?php
    }
}?>


<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";

        if (fyearstatus == '0') {
            $("#addstock").prop("disabled", true);
            $("#deletestock").prop("disabled", true);
        }
    });
</script>