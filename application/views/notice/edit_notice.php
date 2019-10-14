<section id="main-content">
    <section class="wrapper site-min-height">    
        <section class="panel">
            <header class="panel-heading">
                Notice
            </header>         
            <div class="panel-body">
                <form class="cmxform form-horizontal tasi-form" id="" method="post" action="<?php echo site_url('notice/notice/update_notice') ?>">
                    <div class="row">   
                        <div class="col-lg-12"> 
                            <div class="panel-body">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2"> </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">      
                                            <label  for="noticemessage">Notice</label>
                                            <textarea class="form-control" id="noticemessage" name="noticemessage" cols="30" rows="3"> <?php echo $noticedata->message; ?> </textarea>
                                        </div> 
                                        <div class="clear"> </div>
                                    </div>
                                    <div class="col-lg-1"> </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">      
                                            <label  for="noticeorder">Order</label>
                                            <input type="number" id="noticeorder" value="<?php echo $noticedata->order_id; ?>" name="noticeorder" class="form-control" onkeypress="return isNumberKey(event)">
                                            <input type="hidden" id="noticeid" value="<?php echo $noticedata->id; ?>" name="noticeid" >
                                        </div>   
                                    </div>
                                    <div class="col-lg-2"> </div>

                                </div>
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2"> </div>
                                    <div class="col-lg-5">
                                        <button type="submit"  class="btn btn-primary">Update</button>
                                        <button type="reset" class="btn btn-info">Clear</button>
                                    </div>
                                    <div class="col-lg-5"> </div>                                   
                                </div>
                            </div>                           
                        </div>
                    </div>
                </form>
            </div> 
        </section>
    </section>
</section>

<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>