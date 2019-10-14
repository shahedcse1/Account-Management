<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="<?php echo $baseurl; ?>assets/img/favicon2.ico">

        <title><?php echo $title ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo $baseurl; ?>assets/media/css/demo_table.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/DT_bootstrap.css" />        
        <link href="<?php echo $baseurl; ?>assets/css/bootstrap.min.css" rel="stylesheet">


        <!-- custom search start here-->
        <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>assets/customsearch/css/bootstrap-select.css">
        <script type="text/javascript" src="<?php echo $baseurl; ?>assets/js/jquery-1.8.3.min.js"></script>   
        <script type="text/javascript" src="<?php echo $baseurl; ?>assets/customsearch/js/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo $baseurl; ?>assets/customsearch/js/bootstrap-min.js"></script>
        <!-- custom search endhere here-->

        <link href="<?php echo $baseurl; ?>assets/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="<?php echo $baseurl; ?>assets/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $baseurl; ?>assets/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/owl.carousel.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/datepicker.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/jquery.datetimepicker.css" type="text/css">
        <!-- Custom styles for this template -->
        <link href="<?php echo $baseurl; ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo $baseurl; ?>assets/css/style-responsive.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>assets/assets/gritter/css/jquery.gritter.css" />  

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <?php
        $company_data = $this->session->userdata('logindata');
        $company_id = $company_data['companyid'];
        $company_name_result = $this->db->query("SELECT companyName, address, logo from company WHERE companyId='$company_id'");
        $company_name = $company_name_result->row()->companyName;
        $company_address = $company_name_result->row()->address;
        $companylogo = $company_name_result->row()->logo;
        ?>

        <section id="container" >
            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <img style="float: left" height="40" width="80" src="<?php echo $baseurl ?>assets/uploads/<?php echo $companylogo; ?>"  /> 
                    <a style="margin-top: 0px; margin-left: 10px;" href="<?php echo site_url('home'); ?>" class="logo"><?php echo $company_name; ?></a>
                </div>

                <!--logo start-->
                
                <!--logo end-->
                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->

                    <!--  notification end -->
                </div>
                <div class="top-nav ">
                    <!--search & user info start-->
                    <ul class="nav pull-right top-menu" style="text-align: right;">
                        <li>
                            <span>User:&nbsp;<?php echo $company_data['username']; ?> </span> <br>
                            <span> <?php echo $company_address; ?> </span>
                        </li>
                        <!--                        <li>
                                                    <input type="text" class="form-control search" placeholder="Search">
                                                </li>
                                                 user login dropdown start
                                                <li class="dropdown">
                                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                        <img style="border-radius: 4px" alt="" src="<?php //echo $baseurl;     ?>assets/img/ccflogo.png">
                                                        <span class="username"><?php
                        $username = $this->session->userdata('logindata');
                        //echo $username['username'];
                        ?></span>
                                                        <b class="caret"></b>
                                                    </a>
                                                    <ul class="dropdown-menu extended logout">
                                                        <div class="log-arrow-up"></div>
                                                        <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                                                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                                                        <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                                                        <li><a href="<?php //echo site_url('login/logout');     ?>"><i class="fa fa-key"></i> Log Out</a></li>
                                                    </ul>
                                                </li>
                                                 user login dropdown end -->
                    </ul>
                    <!--search & user info end-->
                </div>
            </header>
            <!--header end-->
