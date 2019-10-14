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
                Day Bases Cash Status
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <a href="<?php echo site_url('report/cashstatus/addcashstatus'); ?>">
                                <button  class="btn btn-info">
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </div>                        
                    </div>                                       

                    <table class="display table table-bordered table-striped" id="cashstatus-datatable">
                        <thead>
                            <tr>
                                <th>Date</th>                                
                                <th>Total Taka</th>
                                <th>Cash In Hand</th>
                                <th>Difference</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                    </table>


                    <!--Start Modal Show Details Data -->
                    <div class="modal fade" id="myModaldetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">                                
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Cash Status Details</h4>
                                </div>

                                <div class="modal-body" style="overflow-y: scroll; max-height: 480px;">
                                    <div class="row">
                                        <div class="clearfix">                                          
                                            <div class="form-group">
                                                <div class="col-lg-8 col-sm-offset-1">
                                                    <div class="input-group input-sm" >
                                                        <span class="input-group-addon"> Date </span>
                                                        <div class="iconic-input right">
                                                            <i class="fa fa-calendar"></i>
                                                            <input type="text" id="cashstatusdateview" class="form-control" name="cashstatusdateview" readonly>
                                                        </div>                                       
                                                    </div>
                                                </div>                                  
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-offset-1">
                                                    <div class="form-group" style="padding-top: 15px;">
                                                        <label for="onethoustaka" class="col-lg-2 control-label">1000&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" id="onethoustaka" value="" name="onethoustaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="onethoustakanet">  </span> <input type="hidden" value="0" name="onethoustakahide" id="onethoustakahide"> </div>
                                                    </div>


                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="fivehuntaka" class="col-lg-2 control-label">500&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="fivehuntaka" name="fivehuntaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="fivehuntakanet">   </span> <input type="hidden" value="0" name="fivehuntakahide" id="fivehuntakahide"> </div>
                                                    </div>


                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="onehuntaka" class="col-lg-2 control-label">100&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="onehuntaka" name="onehuntaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="onehuntakanet">  </span> <input type="hidden" value="0" name="onehuntakahide" id="onehuntakahide"> </div>
                                                    </div>


                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="fiftytaka" class="col-lg-2 control-label">50&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="fiftytaka" name="fiftytaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="fiftytakanet">  </span> <input type="hidden"  value="0" name="fiftytakahide" id="fiftytakahide"> </div>
                                                    </div>

                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="tweentytaka" class="col-lg-2 control-label">20&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="tweentytaka" name="tweentytaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="tweentytakanet">  </span> <input type="hidden" value="0" name="tweentytakahide" id="tweentytakahide"> </div>
                                                    </div>

                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="tentaka" class="col-lg-2 control-label">10&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="tentaka" name="tentaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="tentakanet">  </span> <input type="hidden" value="0" name="tentakahide" id="tentakahide"> </div>
                                                    </div>

                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="fivetaka" class="col-lg-2 control-label">5&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="fivetaka" name="fivetaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="fivetakanet">  </span> <input type="hidden" value="0" name="fivetakahide" id="fivetakahide"> </div>
                                                    </div>

                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="twotaka" class="col-lg-2 control-label">2&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="twotaka" name="twotaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="twotakanet">  </span> <input type="hidden" value="0" name="twotakahide" id="twotakahide"> </div>
                                                    </div>

                                                    <div class="form-group" style="padding-top: 30px;">
                                                        <label for="onetaka" class="col-lg-2 control-label">1&nbsp&nbsp; &times;</label>
                                                        <div class="col-lg-4">
                                                            <input type="text"  class="form-control" value="" id="onetaka" name="onetaka" readonly>                                  
                                                        </div>          
                                                        <div class="col-lg-4"> <span class="onetakanet">  </span> <input type="hidden" value="0" name="onetakahide" id="onetakahide"> </div>
                                                    </div>


                                                    <div class="form-group" style="margin-top: 40px; font-weight:bold;  border-top: 2px solid;">    
                                                        <label for="totaltaka" class="col-lg-2 control-label"> </label>
                                                        <div class="col-lg-4"> Total Taka = </div>
                                                        <div class="col-lg-4"> <span class="totaltaka">   </span> <input type="hidden" value="0" name="totaltakahide" id="totaltakahide"> </div>
                                                    </div>

                                                    <div class="form-group" style="font-weight:bold; padding-top: 30px;">    
                                                        <label for="cashinhand" class="col-lg-2 control-label"></label>
                                                        <div class="col-lg-4">Cash In Hand =</div>
                                                        <div class="col-lg-4"> <span class="cashinhand">  </span> <input type="hidden" value="" name="cashinhandhide" id="cashinhand"> </div>
                                                    </div>

                                                    <div class="form-group" style="margin-top: 40px; font-weight:bold;  border-top: 2px solid;">    
                                                        <label for="difference" class="col-lg-2 control-label"> </label>
                                                        <div class="col-lg-4"> Difference = </div>
                                                        <div class="col-lg-4"> <span class="difference">   </span> <input type="hidden" value="0" name="differencehide" id="differencehide"> </div>
                                                    </div>

                                                    <div class="form-group" style="margin-top: 40px;">    
                                                        <label for="cashstatusnotes" class="col-lg-2 control-label"> Notes: </label>
                                                        <div class="col-lg-5"> <span class="notes">  </span></div>
                                                        <div class="col-lg-3">  </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <!--End Modal Show Details Data -->



                </div>
            </div>
        </section>
    </section>
</section>

<script>
    $(document).ready(function () {
        var oTable = $('#cashstatus-datatable').dataTable({
            "processing": true,
            "pagingType": "full_numbers",
            "serverSide": true,
            "ajax": '<?php echo site_url('report/cashstatus/getCashStatus'); ?>',
            "order": [[4, "desc"]],
            "aoColumns": [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}]
        });
    });

    function showDetailsModal(id) {
        $("#onethoustaka").val("");
        $(".onethoustakanet").text("");
        $("#fivehuntaka").val("");
        $(".fivehuntakanet").text("");
        $("#onehuntaka").val("");
        $(".onehuntakanet").text("");
        $("#fiftytaka").val("");
        $(".fiftytakanet").text("");
        $("#tweentytaka").val("");
        $(".tweentytakanet").text("");
        $("#tentaka").val("");
        $(".tentakanet").text("");
        $("#fivetaka").val("");
        $(".fivetakanet").text("");
        $("#twotaka").val("");
        $(".twotakanet").text("");
        $("#onetaka").val("");
        $(".onetakanet").text("");
        $(".totaltaka").text("");
        $(".cashinhand").text("");
        $(".difference").text("");
        $(".notes").text("");
        $("#cashstatusdateview").val("");

        var dataString = "id=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('report/cashstatus/getCashDetails'); ?>",
            data: dataString,
            success: function (data) {
                var reponseData = JSON.parse(data);
                if (parseInt(reponseData.onethousand) > 0) {
                    $("#onethoustaka").val(reponseData.onethousand / 1000);
                    $(".onethoustakanet").text(reponseData.onethousand);
                }
                if (parseInt(reponseData.fivehundred) > 0) {
                    $("#fivehuntaka").val(reponseData.fivehundred / 500);
                    $(".fivehuntakanet").text(reponseData.fivehundred);
                }
                if (parseInt(reponseData.onehundred) > 0) {
                    $("#onehuntaka").val(reponseData.onehundred / 100);
                    $(".onehuntakanet").text(reponseData.onehundred);
                }
                if (parseInt(reponseData.fifty) > 0) {
                    $("#fiftytaka").val(reponseData.fifty / 50);
                    $(".fiftytakanet").text(reponseData.fifty);
                }
                if (parseInt(reponseData.tweenty) > 0) {
                    $("#tweentytaka").val(reponseData.tweenty / 20);
                    $(".tweentytakanet").text(reponseData.tweenty);
                }
                if (parseInt(reponseData.ten) > 0) {
                    $("#tentaka").val(reponseData.ten / 10);
                    $(".tentakanet").text(reponseData.ten);
                }
                if (parseInt(reponseData.five) > 0) {
                    $("#fivetaka").val(reponseData.five / 5);
                    $(".fivetakanet").text(reponseData.five);
                }
                if (parseInt(reponseData.two) > 0) {
                    $("#twotaka").val(reponseData.two / 2);
                    $(".twotakanet").text(reponseData.two);
                }
                if (parseInt(reponseData.one) > 0) {
                    $("#onetaka").val(reponseData.one);
                    $(".onetakanet").text(reponseData.one);
                }
                $(".totaltaka").text(reponseData.totaltaka);
                $(".cashinhand").text(reponseData.cashinhand);
                $(".difference").text(reponseData.difference);
                $(".notes").text(reponseData.notes);
                $("#cashstatusdateview").val(reponseData.datetime);
                $("#myModaldetails").modal('show');
            }
        });
    }
</script>

<?php if ($this->session->userdata('success')): ?>
    <script>
        $(document).ready(function () {
            $.gritter.add({
                title: 'Successfull!',
                text: '<?php echo $this->session->userdata('success'); ?>',
                sticky: false,
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
        $(document).ready(function () {
            $.gritter.add({
                title: 'Fail!',
                text: '<?php echo $this->session->userdata('fail'); ?>',
                sticky: false,
                time: '3000'
            });
        })
    </script>    
    <?php
    $this->session->unset_userdata('fail');
endif;
?>