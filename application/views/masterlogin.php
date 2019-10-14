<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="cloudit limited">    
        <link rel="shortcut icon" href="<?php echo $baseurl; ?>assets/img/favicon3.ico">
        <title>System login</title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="<?php echo $baseurl; ?>assets/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="<?php echo $baseurl; ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/style-responsive.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <style>
            .form-control{
                margin-left: 0
            }
        </style>
    </head>
    <body class="login-body">
        <div class="container">            
            <form class="form-signin" action="<?php echo site_url('login/loginAccess'); ?>" method="post">
                <h2 class="form-signin-heading">sign in now</h2>
                <center><img height="80px;" width="110px;"src="<?php echo $baseurl; ?>assets/img/logo.png"></center>
                <div class="login-wrap"> 
                    <?php if ($this->session->userdata('loginerror')): ?>
                        <div class="alert alert-block alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
                            <strong>Opps!</strong> <?php
                            echo $this->session->userdata('loginerror');
                            $this->session->unset_userdata('loginerror');
                            ?>
                        </div> 
                    <?php endif; ?>
                    <?php if ($passwordupdatemessage != ''): ?>
                        <div class="alert alert-block alert-success fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
                            <strong>Success !</strong> <?php echo $passwordupdatemessage; ?>
                        </div> 
                    <?php endif; ?>
                    <input type="text" class="form-control" placeholder="User ID" autofocus name="username" required>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <?php
                    if (sizeof($companylist) > 0):
                        foreach ($companylist as $cpanydata):
                            ?>
                            <input type="text" class="form-control" name="companynameshow" id="companynameshow" value="<?php echo $cpanydata->companyName; ?>" disabled>
                            <input type="hidden" class="form-control" name="compantid" id="compantid"  value="<?php echo $cpanydata->companyId; ?>">
                            <?php
                        endforeach;
                    endif;
                    ?>
                    <div id='fyear'></div>
                    <label class="checkbox">
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                    <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>                            
                </div>
            </form>
        </div>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo $baseurl; ?>assets/js/jquery.js"></script>
        <script src="<?php echo $baseurl; ?>assets/js/bootstrap.min.js"></script>
        <!--<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        --><link href="<?php echo $baseurl; ?>assets/assets/keyboard/jquery.ml-keyboard.css" rel="stylesheet" type="text/css">
        <script src="<?php echo $baseurl; ?>assets/assets/keyboard/jquery.ml-keyboard.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                var companyid = $("#compantid").val();
                var dataString = "cid=" + companyid;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('home/getcompanyyear'); ?>",
                    data: dataString,
                    success: function(data) {
                        $("#fyear").html(data);
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var keyboard = "<?php echo $keyboard; ?>";
                if (keyboard == "1") {
                    $('input').mlKeyboard({
                        active_shift: false
                    });
                } else {

                }
            });
        </script>
    </body>
</html>