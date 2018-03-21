<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<?php

    include("../includes/config.php");
    include("../includes/function.php");

    if(!isset($_SESSION['login_user']) && !isset($_SESSION['login_office']) || $_SESSION['login_office'] != 'head') {
        header("location: ../login.php");
    }

    if(isset($_REQUEST['office'])){
        $_SESSION['plant'] = $_REQUEST['office'];
    }

    if(!isset($_GET['date_view'])){
    	$_GET['date_view'] = "";
    }

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];
    $search_plant = $_SESSION['plant'];
    $plant = ucfirst($_SESSION['plant']);
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Batch Daily Report</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/fullcalendar.css">
    <link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/xcharts.min.css" rel=" stylesheet"> 
    <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">

     <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui-1.10.4.min.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <!-- jQuery full calendar -->
    <script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
    <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js" ></script>
    <script src="assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>  
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>    
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <!-- =======================================================
    Theme Name: NiceAdmin
    Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
    ======================================================= -->
<script>

	// function submitForm(){
	// 	document.getElementById("batch_form").submit();
	// }
</script>
<style>
.page_links a{
    color: inherit;
}
</style>
</head>
<body>
	<!-- container section start -->
    <section id="container" class="">
        <header class="header dark-bg">
            <div class="toggle-nav">
            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <!--logo start-->

            <!--logo end-->
            <a href='index.php' class='logo'>Starcrete <span class='lite'>Manufacturing Corporation</span></a>
            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <!--  <span class="profile-ava">
                        <img alt="" src="img/avatar1_small.jpg">
                        </span> -->
                            <span class="username"><?php echo ucfirst($user['firstname']); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li>
                                <a href="logout.php"><i class="icon_key_alt"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
        </header>      
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu">                
                    <li>
                        <a class="" href="index.php">
                            <i class="icon_house"></i>
                            <span>History</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="clients.php">
                            <i class="fa fa-address-book"></i>
                            <span>Clients</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-building"></i>
                            <span>Bravo</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="batch_daily_report.php?office=bravo">Batch Report</a></li>
                            <li><a class="" href="purchase_order.php?office=bravo">Purchase Order</a></li>                          
                            <li><a class="" href="delivery_order.php?office=bravo">Delivery Page</a></li>
                        </ul>
                    </li>  
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-building"></i>
                            <span>Delta</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="batch_daily_report.php?office=delta">Batch Report</a></li>
                            <li><a class="" href="purchase_order.php?office=delta">Purchase Order</a></li>                          
                            <li><a class="" href="delivery_order.php?office=delta">Delivery Page</a></li>
                        </ul>
                    </li>      
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-file"></i>
                            <span>Forms</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="purchase_order_form.php">Add New P.O.</a></li>
                            <!-- <li><a class="" href="purchase_aggregates_order_form.php">P.O. Aggregates Form</a></li>                         -->
                        </ul>
                    </li>
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">            
                <!--overview start-->
                <div class="row">
                    <div class="col-md-12 page_links">
                        <!-- <h3 class="page-header"><a href="batch_daily_report.php?office=<?php echo $search_plant; ?>"><?php echo $plant; ?> Batch Daily Report</a></h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo $plant; ?></li>
                            <li><i class="fa fa-building"></i><a href="batch_daily_report.php?office=<?php echo $search_plant; ?>" style="color: blue;">Batch Daily Report</a></li>
                            <li><i class="fa fa-building"></i><a href="batch_summary_report.php?office=<?php echo $search_plant; ?>">Batch Summary Report</a></li>
                                                   
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <form action="batch_daily_report.php" method="get" id="batch_form">
                                <header class="panel-heading">
                                    <div class="row" style="margin-bottom: 5px;">
										<div class="form-group">
											<div class="col-md-12" style="margin-top: 5px;">
												<label for="date_view" class="col-md-2 control-label" style="margin-right: -80px;"><strong>Select Date:</strong></label>
												<div class="col-md-2">
												<input type="date" name="date_view" class="form-control" value="<?php if(isset($_GET['date_view'])) { echo htmlentities ($_GET['date_view']); }?>" onblur="this.form.submit();">
																										
												</div>
											</div>
											<!-- <div class="col-md-1">
												<input type="submit" name="submit" id="submit" value="Search" class="btn btn-primary">
											</div> -->
										</div>
                                    </div>
                                </header>
                            </form>
                            <div class="table-responsive">
                            	<table class="table table-striped table-bordered">
<?php 

		if($_GET['date_view'] == ''){
			$date = date("Y-m-d");
		}else{
			$date = $_GET['date_view'];
		}
		
		$date_view = date_create($date);
?>
									<thead>
										<tr>
											<th colspan="7" style="text-align: left;">Date: <?php echo date_format($date_view,"F d, Y"); ?></th>					
										</tr>
										<tr>
											<th colspan="1" rowspan="3" style="vertical-align: middle; text-align: center;">Time</th>
											<th colspan="2">Machine No. M-1</th>
											<th colspan="2">Machine No. M-3a</th>
											<th colspan="2">Machine No. M-3b</th>
										</tr>
										<tr>
											<th colspan="2">Cement (kg): <?php echo getBatchCement($db,$search_plant,'M-1',$date); ?></th>
											<th colspan="2">Cement (kg): <?php echo getBatchCement($db,$search_plant,'M-3a',$date); ?></th>
											<th colspan="2">Cement (kg): <?php echo getBatchCement($db,$search_plant,'M-3b',$date); ?></th>
										</tr>
										<tr>
											<th colspan="2">
												Type: <?php echo getBatchType($db,$search_plant,'M-1',$date); ?>
											</th>
											<th colspan="2">
												Type: <?php echo getBatchType($db,$search_plant,'M-3a',$date); ?>
											</th>
											<th colspan="2">
												Type: <?php echo getBatchType($db,$search_plant,'M-3b',$date); ?>
											</th>
										</tr>
										<tr>
											<th class="col-md-1">AM</th>
											<th class="col-md-1">Batch</th>
											<th class="col-md-1">Comment</th>
											<th class="col-md-1">Batch</th>
											<th class="col-md-1">Comment</th>
											<th class="col-md-1">Batch</th>
											<th class="col-md-1">Comment</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="col-md-1">6:00 - 7:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'6'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'6'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'6'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'6'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'6'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'6'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">7:00 - 8:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'7'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'7'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'7'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'7'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'7'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'7'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">8:00 - 9:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'8'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'8'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'8'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'8'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'8'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'8'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">9:00 - 10:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'9'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'9'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'9'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'9'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'9'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'9'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">10:00 - 11:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'10'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'10'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'10'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'10'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'10'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'10'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">11:00 - 12:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'11'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'11'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'11'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'11'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'11'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'11'); ?></td>
										</tr>
<!-- 									</tbody>
									<thead> -->
										<tr>
											<th class="col-md-1">PM</th>
											<th class="col-md-1">Batch</th>
											<th class="col-md-1">Comment</th>
											<th class="col-md-1">Batch</th>
											<th class="col-md-1">Comment</th>
											<th class="col-md-1">Batch</th>
											<th class="col-md-1">Comment</th>
										</tr>
		<!-- 							</thead>
									<tbody> -->
										<tr>
											<td class="col-md-1">12:00 - 1:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'12'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'12'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'12'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'12'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'12'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'12'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">1:00 - 2:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'13'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'13'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'13'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'13'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'13'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'13'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">2:00 - 3:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'14'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'14'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'14'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'14'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'14'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'14'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">3:00 - 4:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'15'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'15'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'15'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'15'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'15'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'15'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">4:00 - 5:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'16'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'16'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'16'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'16'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'16'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'16'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">5:00 - 6:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'17'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'17'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'17'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'17'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'17'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'17'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">6:00 - 7:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'18'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'18'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'18'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'18'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'18'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'18'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">7:00 - 8:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'19'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'19'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'19'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'19'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'19'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'19'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">8:00 - 9:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'20'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'20'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'20'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'20'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'20'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'20'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">9:00 - 10:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'21'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'21'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'21'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'21'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'21'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'21'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">10:00 - 11:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'22'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'22'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'22'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'22'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'22'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'22'); ?></td>
										</tr>
										<tr>
											<td class="col-md-1">11:00 - 12:00</td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-1',$date,'23'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-1',$date,'23'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3a',$date,'23'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3a',$date,'23'); ?></td>
											<td class="col-md-1"><?php echo getBatch($db,$search_plant,'M-3b',$date,'23'); ?></td>
											<td class="col-md-1"><?php echo getComment($db,$search_plant,'M-3b',$date,'23'); ?></td>
										</tr>
										<tr>
											<th class="col-md-1">Total</th>
											<th colspan="2">
<?php
	if($search_plant == 'bravo'){
		$string_office = " AND office = 'bravo'";
	}else if($search_plant == 'delta'){
		$string_office = " AND office = 'delta'";
	}else{
		$string_office = "";
	}

	$sql_machine1 = "SELECT DATE_FORMAT(batch_date,'%m/%d/%Y') as prod_date, SUM(batch_count) as total 
						FROM batch 
						WHERE DATE_FORMAT(batch_date,'%m/%d/%Y') = DATE_FORMAT('$date','%m/%d/%Y') AND machine_no = 'M-1'".$string_office."
						GROUP BY machine_no, item_no, prod_date 
						ORDER BY prod_date DESC, machine_no";

	$result = mysqli_query($db,$sql_machine1);
	$row = mysqli_fetch_assoc($result);

		if($row['total'] == "0" || $row['total'] == ""){
			echo "0";
		}else{
			echo $row['total'] . " Batches";
		}
?>
											</th>
											<th colspan="2">
<?php
	if($search_plant == 'bravo'){
		$string_office = " AND office = 'bravo'";
	}else if($search_plant == 'delta'){
		$string_office = " AND office = 'delta'";
	}else{
		$string_office = "";
	}

	$sql_machine1 = "SELECT DATE_FORMAT(batch_date,'%m/%d/%Y') as prod_date, SUM(batch_count) as total 
						FROM batch 
						WHERE DATE_FORMAT(batch_date,'%m/%d/%Y') = DATE_FORMAT('$date','%m/%d/%Y') AND machine_no = 'M-3a'".$string_office."
						GROUP BY machine_no, item_no, prod_date 
						ORDER BY prod_date DESC, machine_no";

	$result = mysqli_query($db,$sql_machine1);
	$row = mysqli_fetch_assoc($result);

		if($row['total'] == "0" || $row['total'] == ""){
			echo "0";
		}else{
			echo $row['total'] . " Batches";
		}
?>
											</th>
											<th colspan="2">
<?php
	if($search_plant == 'bravo'){
		$string_office = " AND office = 'bravo'";
	}else if($search_plant == 'delta'){
		$string_office = " AND office = 'delta'";
	}else{
		$string_office = "";
	}

	$sql_machine1 = "SELECT DATE_FORMAT(batch_date,'%m/%d/%Y') as prod_date, SUM(batch_count) as total 
						FROM batch 
						WHERE DATE_FORMAT(batch_date,'%m/%d/%Y') = DATE_FORMAT('$date','%m/%d/%Y') AND machine_no = 'M-3b'".$string_office."
						GROUP BY machine_no, item_no, prod_date 
						ORDER BY prod_date DESC, machine_no";

	$result = mysqli_query($db,$sql_machine1);
	$row = mysqli_fetch_assoc($result);

		if($row['total'] == "0" || $row['total'] == ""){
			echo "0";
		}else{
			echo $row['total'] . " Batches";
		}
?>
											</th>
										</tr>
									</tbody>
                            	</table>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>
</body>
</html>