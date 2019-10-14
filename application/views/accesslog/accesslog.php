<style>
    #myModalLabel{
        font-weight: bold
    }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Log Data
            </header>
            <div class="panel-body">
                <div class="adv-table">                   
   

                    <table class="display table table-bordered table-striped" id="accesslog-datatable">
                        <thead>
                            <tr>
                            
                                <th>Date</th>
                                <th>Login</th>
                                <th>Action</th>
                                <th>Device</th>
                                <th>Browser</th>
                                <th>IP</th>
                                <th>Location</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                    </table>



                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>


<script>
    $(document).ready(function () {
        var oTable = $('#accesslog-datatable').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo site_url('accesslog/accesslog/getAccessLogTable'); ?>',
            "order": [[0, "desc"]],
            "aoColumns": [
              
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]
        });
    });

</script>