<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Add Cash Status
            </header>
            <div class="panel-body">

                <div class="row">
                    <div class="clearfix">
                        <form class="tasi-form" method="post" action="<?php echo site_url('report/cashstatus/savecashstatusdata'); ?>">
                            <div class="form-group">
                                <div class="col-lg-3 col-sm-offset-3">
                                    <div class="input-group input-sm" >
                                        <span class="input-group-addon"> Date </span>
                                        <div class="iconic-input right">
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" id="cashstatusdate" class="form-control" name="cashstatusdate" required="">
                                        </div>                                       
                                    </div>
                                </div>                                  
                            </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-5 col-sm-offset-3">
                        <div class="form-group" style="padding-top: 15px;">
                            <label for="onethoustaka" class="col-lg-2 control-label">1000&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" id="onethoustaka" value="" name="onethoustaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="onethoustakanet">  </span> <input type="hidden" value="0" name="onethoustakahide" id="onethoustakahide"> </div>
                        </div>


                        <div class="form-group" style="padding-top: 30px;">
                            <label for="fivehuntaka" class="col-lg-2 control-label">500&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="fivehuntaka" name="fivehuntaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="fivehuntakanet">   </span> <input type="hidden" value="0" name="fivehuntakahide" id="fivehuntakahide"> </div>
                        </div>


                        <div class="form-group" style="padding-top: 30px;">
                            <label for="onehuntaka" class="col-lg-2 control-label">100&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="onehuntaka" name="onehuntaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="onehuntakanet">  </span> <input type="hidden" value="0" name="onehuntakahide" id="onehuntakahide"> </div>
                        </div>


                        <div class="form-group" style="padding-top: 30px;">
                            <label for="fiftytaka" class="col-lg-2 control-label">50&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="fiftytaka" name="fiftytaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="fiftytakanet">  </span> <input type="hidden"  value="0" name="fiftytakahide" id="fiftytakahide"> </div>
                        </div>

                        <div class="form-group" style="padding-top: 30px;">
                            <label for="tweentytaka" class="col-lg-2 control-label">20&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="tweentytaka" name="tweentytaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="tweentytakanet">  </span> <input type="hidden" value="0" name="tweentytakahide" id="tweentytakahide"> </div>
                        </div>

                        <div class="form-group" style="padding-top: 30px;">
                            <label for="tentaka" class="col-lg-2 control-label">10&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="tentaka" name="tentaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="tentakanet">  </span> <input type="hidden" value="0" name="tentakahide" id="tentakahide"> </div>
                        </div>

                        <div class="form-group" style="padding-top: 30px;">
                            <label for="fivetaka" class="col-lg-2 control-label">5&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="fivetaka" name="fivetaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="fivetakanet">  </span> <input type="hidden" value="0" name="fivetakahide" id="fivetakahide"> </div>
                        </div>

                        <div class="form-group" style="padding-top: 30px;">
                            <label for="twotaka" class="col-lg-2 control-label">2&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="twotaka" name="twotaka">                                  
                            </div>          
                            <div class="col-lg-4"> <span class="twotakanet">  </span> <input type="hidden" value="0" name="twotakahide" id="twotakahide"> </div>
                        </div>

                        <div class="form-group" style="padding-top: 30px;">
                            <label for="onetaka" class="col-lg-2 control-label">1&nbsp&nbsp; &times;</label>
                            <div class="col-lg-4">
                                <input type="text"  class="form-control" value="" id="onetaka" name="onetaka">                                  
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
                            <div class="col-lg-4"> <span class="cashinhand"> <?php echo intval($cashinhand); ?> </span> <input type="hidden" value="<?php echo intval($cashinhand); ?>" name="cashinhandhide" id="cashinhand"> </div>
                        </div>

                        <div class="form-group" style="margin-top: 40px; font-weight:bold;  border-top: 2px solid;">    
                            <label for="difference" class="col-lg-2 control-label"> </label>
                            <div class="col-lg-4"> Difference = </div>
                            <div class="col-lg-4"> <span class="difference">   </span> <input type="hidden" value="0" name="differencehide" id="differencehide"> </div>
                        </div>


                        <div class="form-group" style="margin-top: 40px;">    
                            <label for="cashstatusnotes" class="col-lg-2 control-label"> Notes: </label>
                            <div class="col-lg-5"> <textarea name="cashstatusnotes" id="cashstatusnotes" rows="4" cols="25"> </textarea></div>
                            <div class="col-lg-3"> <button class="btn btn-info" type="submit">Submit</button>  </div>
                        </div>

                    </div>
                </div>
                </form>
            </div> 
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->


<script type="text/javascript">
    var cashinhand = "<?php echo intval($cashinhand); ?>";
    $("#onethoustaka").change(function () {
        var previoustaka = $("#onethoustakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#onethoustaka").val();
        var rowtotal = value * 1000;
        $(".onethoustakanet").text(rowtotal);
        $("#onethoustakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });


    $("#fivehuntaka").change(function () {
        var previoustaka = $("#fivehuntakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#fivehuntaka").val();
        var rowtotal = value * 500;
        $(".fivehuntakanet").text(rowtotal);
        $("#fivehuntakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });

    $("#onehuntaka").change(function () {
        var previoustaka = $("#onehuntakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#onehuntaka").val();
        var rowtotal = value * 100;
        $(".onehuntakanet").text(rowtotal);
        $("#onehuntakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });

    $("#fiftytaka").change(function () {
        var previoustaka = $("#fiftytakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#fiftytaka").val();
        var rowtotal = value * 50;
        $(".fiftytakanet").text(rowtotal);
        $("#fiftytakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });

    $("#tweentytaka").change(function () {
        var previoustaka = $("#tweentytakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#tweentytaka").val();
        var rowtotal = value * 20;
        $(".tweentytakanet").text(rowtotal);
        $("#tweentytakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });

    $("#tentaka").change(function () {
        var previoustaka = $("#tentakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#tentaka").val();
        var rowtotal = value * 10;
        $(".tentakanet").text(rowtotal);
        $("#tentakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });


    $("#fivetaka").change(function () {
        var previoustaka = $("#fivetakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#fivetaka").val();
        var rowtotal = value * 5;
        $(".fivetakanet").text(rowtotal);
        $("#fivetakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });


    $("#twotaka").change(function () {
        var previoustaka = $("#twotakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#twotaka").val();
        var rowtotal = value * 2;
        $(".twotakanet").text(rowtotal);
        $("#twotakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });


    $("#onetaka").change(function () {
        var previoustaka = $("#onetakahide").val();
        var totaltaka = $("#totaltakahide").val();
        totaltaka = parseInt(totaltaka) - parseInt(previoustaka);
        var value = $("#onetaka").val();
        var rowtotal = value * 1;
        $(".onetakanet").text(rowtotal);
        $("#onetakahide").val(rowtotal);
        totaltaka = parseInt(totaltaka) + parseInt(rowtotal);
        $(".totaltaka").text(totaltaka);
        $("#totaltakahide").val(totaltaka);
        var difference = parseInt(totaltaka) - parseInt(cashinhand);
        $(".difference").text(difference);
        $("#differencehide").val(difference);
    });

</script>

<!--<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
--><link href="<?php echo $baseurl; ?>assets/assets/keyboard/jquery.ml-keyboard.css" rel="stylesheet" type="text/css">
<script src="<?php echo $baseurl; ?>assets/assets/keyboard/jquery.ml-keyboard.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        var keyboard = "<?php echo $keyboard; ?>";
        if (keyboard == "1") {
            $('input').mlKeyboard({
                active_shift: false
            });

            $('textarea').mlKeyboard({
                active_shift: false
            });
        } else {

        }
    });
</script>