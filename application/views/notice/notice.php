<style>
    .col-lg-3{
        padding-top: 3px;
    }
    .clickable a{
        width:100%;
        display:block;
    }   
</style>
<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Notice
            </header>
            <div class="panel-body">
                <?php if ($this->session->userdata('success') != ""): ?>
                    <div class="alert alert-block alert-success fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
                        <strong>Success !</strong> <?php echo $this->session->userdata('success'); ?>
                    </div> 
                <?php endif; ?>
                <?php if ($this->session->userdata('fail') != ""): ?>
                    <div class="alert alert-block alert-success fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
                        <strong>Success !</strong> <?php echo $this->session->userdata('fail'); ?>
                    </div> 
                <?php endif; ?>

                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">                           
                            <button  class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                Add New <i class="fa fa-plus"></i>
                            </button>                          
                        </div>                        
                    </div>      

                    <table class="display table table-bordered table-striped" id="notice-tab">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Date</th>
                                <th>Message</th>                                
                                <th>Order</th>
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
            <form class="cmxform form-horizontal tasi-form" id="delpaymentvou" method="post" action="<?php echo site_url('notice/notice/deletenotice') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <h5><i class="fa fa-warning"></i>&nbsp; Are You Sure You Want To Delete The Notice No: &nbsp;&nbsp; <b id="noticeidshow"> </b></h5>
                                    <input id="noticeid" name="noticeid" type="hidden"/>                                                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" >YES</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--- Add New Notice Modal -->

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <form class="cmxform form-horizontal tasi-form" id="" method="post" action="<?php echo site_url('notice/notice/addnotice') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Add Notice</h4>
                </div>
                <div class="modal-body">  
                    <div class="row">   
                        <div class="col-lg-12"> 
                            <div class="panel-body">
                                <div class="form-group">                                                                 
                                    <div class="col-lg-8">
                                        <label  for="noticemessage">Notice</label>
                                        <textarea class="form-control " id="noticemessage" name="noticemessage" cols="30" rows="3"></textarea>
                                    </div>                                    
                                    <div class="col-lg-3">
                                        <label  for="noticeorder">Order</label>
                                        <input type="number" id="noticeorder" name="noticeorder" class="form-control" onkeypress="return isNumberKey(event)">
                                    </div>                                                                    
                                </div>                           
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary" onclick="return addamountCheck()">Save</button>
                    <button type="reset" class="btn btn-info">Clear</button>
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--End Of Add Journal MOdal -->


<script>
    $(document).ready(function () {
        var oTable = $('#notice-tab').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('notice/notice/getnoticetable'); ?>',
            "order": [[1, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]
        });
    });

    function deleteModalFun(noticeid) {
        $("#noticeidshow").text(noticeid);
        $("#noticeid").val(noticeid);
        $("#myModaldelete").modal('show');
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>

