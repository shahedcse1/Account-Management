<style>
    .col-lg-3{
        padding-top: 3px;
    }
    .clickable a{
        width:100%;
        display:block;
    }   
     .panel-heading{
        background-color:#e979a0;
    }
    .adv-table table.display thead th, table.display tfoot th{
        background-color:#e979a0;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Journal Entry
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">                           
                            <a href="<?php echo site_url('/journalentry/journalentry/addjournalentry'); ?>">
                                <button class="btn btn-info" id="addpurchase" >
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>              
                        </div>                        
                    </div>               

                    <table class="display table table-bordered table-striped" id="journal-entry-tab">
                        <thead>
                            <tr>
                                <th></th>                                
                                <th>Voucher No</th>
                                <th>Date</th>
                           <!--     <th>Amount</th>  -->
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </section>
    </section>
</section>

<!-- Delete model -->
<div class="modal fade" id="myModaldelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="cmxform form-horizontal tasi-form" id="delpaymentvou" method="post" action="<?php echo site_url('journalentry/journalentry/deletejournalentry') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <h5><i class="fa fa-warning"></i>&nbsp; Are You Sure You Want To Delete The Journal Entry :&nbsp;&nbsp; <b id="masteridshow"> </b></h5>
                                    <input id="journalMasterId" name="journalMasterId" type="hidden"/>                                                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deletejournal" type="submit" class="btn btn-danger" >YES</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var oTable = $('#journal-entry-tab').dataTable({
            "processing": true,
             "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('journalentry/journalentry/getJournalentryDetails'); ?>',
            "order": [[2, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
              //  {"sClass": "center"},
                {"sClass": "center"}]
        });
    });

    function deleteModalFun(masterId) {
        $("#masteridshow").text(masterId);
        $("#journalMasterId").val(masterId);
        $("#myModaldelete").modal('show');
    }

</script>
<script>
<?php $this->sessiondata = $this->session->userdata('logindata'); ?>
    $(document).ready(function () {
        var fyearstatus = "<?php echo $this->sessiondata['fyear_status']; ?>";
        if (fyearstatus == '0') {
            $("#addjournal").prop("disabled", true);
             $("#deletejournal").prop("disabled", true);
            
        }
    });
</script>
