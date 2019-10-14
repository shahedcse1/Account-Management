<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Customer Information Import From Excel
            </header>

            <div class="panel-body">
                <?php
                if ($this->session->userdata('successfull')):
                    echo '<div class="alert alert-success fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Success Message !!! </strong> ' . $this->session->userdata('successfull') . '</div>';
                    $this->session->unset_userdata('successfull');
                endif;
                if ($this->session->userdata('failed')):
                    echo '<div class="alert alert-block alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Failed Meaasge !!! </strong> ' . $this->session->userdata('failed') . '</div>';
                    $this->session->unset_userdata('failed');
                endif;
                ?>
            </div>

            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" enctype="multipart/form-data" action="<?php echo site_url('customer/customerimport/importdatadb'); ?>">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-5 files">   
                                        <label for="program" class="control-label"> Choose a file(format: .xlsx/.xls): </label>
                                        <input class="form-control" required id="data_import" name="data_import" type="file" placeholder="Choose a file"/>
                                    </div>
                                    <div class="col-lg-2 button" style="margin-top:15px">   
                                        <label for="program" class="control-label">  
                                            <button class="form-control btn btn-info" type="submit">Submit</button>  
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->


