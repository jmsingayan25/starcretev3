<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<?php

    include("../includes/config.php");
    include("../includes/function.php");

    if(!isset($_SESSION['login_user']) && !isset($_SESSION['login_office']) || $_SESSION['login_office'] == 'head') {
        header("location: ../login.php");
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

    $search_plant = $office;
    $plant = ucfirst($office);

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
<?php
    if($office == 'delta'){
        echo "<a href='index.php' class='logo'>Quality Star <span class='lite'>Concrete Products, Inc.</span></a>";
    }else{
        echo "<a href='index.php' class='logo'>Starcrete <span class='lite'>Manufacturing Corporation</span></a>";
    }
?>
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
        <!--sidebar start-->
	    <aside>
	        <div id="sidebar"  class="nav-collapse ">
	            <!-- sidebar menu start-->
	            <ul class="sidebar-menu">                
	                <li class="">
	                    <a class="" href="index.php">
	                        <i class="icon_house"></i>
	                        <span>History</span>
	                    </a>
	                </li>
	                <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-building"></i>
                            <span>Batch Report</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="plant_batch_daily_report.php">Daily Report</a></li>
                            <li><a class="" href="plant_batch_summary_report.php">Summary Report</a></li>   
                        </ul>
                    </li>  
	                <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-building"></i>
                            <span>Purchase Order</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="plant_purchase_order.php">Pending P.O.</a></li>
                            <li><a class="" href="plant_purchase_deliver_order.php">Delivered P.O.</a></li>                          
                            <li><a class="" href="plant_cancelled_order.php">Cancelled P.O.</a></li>
                        </ul>
                    </li>  
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-building"></i>
                            <span>Delivery Order</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="plant_delivery_issue.php">Existing P.O. <span class='badge'><?php echo getCountPlantPo($db, $office); ?></span></a></li>    
                            <li><a class="" href="plant_delivery_order.php">On Delivery Order <span class="badge"><?php echo getDeliveryCountOnDeliveryOffice($db, $office); ?></span></a></li>                      
                            <li><a class="" href="plant_delivery_delivered.php">Delivered Order</a></li>
                            <li><a class="" href="plant_delivery_backloaded.php">Backloaded Order</a></li>
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
                        <!-- <h3 class="page-header"><a href="plant_batch_daily_report.php?office=<?php echo $search_plant; ?>"><?php echo $plant; ?> Batch Daily Report</a></h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo $plant; ?></li>
                            <li><i class="fa fa-building"></i><a href="plant_batch_daily_report.php?office=<?php echo $search_plant; ?>" style="color: blue;">Batch Daily Report</a></li>                     
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <form action="plant_batch_daily_report.php" method="get" id="batch_form">
                                <header class="panel-heading">
                                    <div class="row" style="margin-bottom: 5px;">
										<div class="form-group">
											<div class="col-md-10" style="margin-top: 5px;">
												<label for="date_view" class="col-md-2 control-label" style="margin-right: -70px;"><strong>Select Date:</strong></label>
												<div class="col-md-3">
												<input type="date" name="date_view" class="form-control" value="<?php if(isset($_GET['date_view'])) { echo htmlentities ($_GET['date_view']); }?>" onblur="this.form.submit();">
																										
												</div>
											</div>
											<div class="col-md-2" style="margin-top: 5px;">
												<button name="add_production" class="btn btn-primary btn-md" style="float: right;"><span class="fa fa-plus"></span> <strong>Add Production</strong></button>
											</div>
											<!-- <div class="col-md-1">
												<input type="submit" name="submit" id="submit" value="Search" class="btn btn-primary">
											</div> -->
										</div>
                                    </div>
                                </header>
                            </form>
                            <div class="table-responsive">
                            	<form method="post" action="plant_batch_daily_report.php" onsubmit="return confirm('Submit form?');">
                            		<table class="table table-striped table-bordered">
<?php
	
	if($_GET['date_view'] == ''){
		$date = date("Y-m-d");
	}else{
		$date = $_GET['date_view'];
	}
	
	$date_view = date_create($date);

	$rows = array();
	$select_sql = "SELECT item_no FROM batch_list
					ORDER BY item_no ASC";
	$select_result = mysqli_query($db, $select_sql);
	while($row = mysqli_fetch_assoc($select_result)){
		$rows[] = $row;
	}
?>
										<thead>
											<tr>
												<th colspan="7" style="text-align: left;">
													Date: <?php echo date_format($date_view,"F d, Y"); ?>
													<input type="hidden" name="hidden_date_view" value="<?php echo $date; ?>">		
												</th>					
											</tr>
											<tr>
												<th colspan="1" rowspan="3" style="vertical-align: middle; text-align: center;">Time</th>
												<th colspan="2">Machine No. M-1</th>
												<th colspan="2">Machine No. M-3a</th>
												<th colspan="2">Machine No. M-3b</th>
											</tr>
											<tr>
												<th colspan="2">Cement (kg): 
<?php 
	if(getBatchCement($db,$office,'M-1',$date) != ""){
							echo getBatchCement($db,$office,'M-1',$date); 
	}else{
?>
													<input type="text" autocomplete="off" name="cement1" id="cement1" size="5" required>
<?php
	}
?>
												</th>
												<th colspan="2">Cement (kg): 
<?php
	if(getBatchCement($db,$office,'M-3a',$date) != ""){
							echo getBatchCement($db,$office,'M-3a',$date); 
	}else{
?>
													<input type="text" autocomplete="off" name="cement2" id="cement2" size="5" required>
<?php
	}
?>								
												</th>
												<th colspan="2">Cement (kg): 
<?php
	if(getBatchCement($db,$office,'M-3b',$date) != ""){
							echo getBatchCement($db,$office,'M-3b',$date); 
	}else{
?>
													<input type="text" autocomplete="off" name="cement3" id="cement3" size="5" required>
<?php
	}
?>	
												</th>
											</tr>
											<tr>
												<th colspan="2">Type: 
<?php
	if(getBatchType($db,$office,'M-1',$date) != ""){
							echo getBatchType($db,$office,'M-1',$date); 
	}else{
?>
													<select name="type1" id="type1">
														<option value="">Select</option>
<?php
		foreach($rows as $row) {
									echo "<option value='".$row['item_no']."'>".$row['item_no']."</option>";
		}

?>
													</select>
<?php
	}
?>								
												</th>
												<th colspan="2">Type: 
<?php
	if(getBatchType($db,$office,'M-3a',$date) != ""){
							echo getBatchType($db,$office,'M-3a',$date); 
	}else{
?>
													<select name="type2" id="type2">
														<option value="">Select</option>
<?php
		foreach($rows as $row) {
									echo "<option value='".$row['item_no']."'>".$row['item_no']."</option>";
		}

?>
													</select>
<?php
	}
?>								
												</th>
												<th colspan="2">Type: 
<?php
	if(getBatchType($db,$office,'M-3b',$date) != ""){
							echo getBatchType($db,$office,'M-3b',$date); 
	}else{
?>
													<select name="type3" id="type3">
														<option value="">Select</option>
<?php
		foreach($rows as $row) {
									echo "<option value='".$row['item_no']."'>".$row['item_no']."</option>";
		}

?>
													</select>
<?php
	}
?>								
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
										<tbody style="overflow-y: hidden; width: 97%">
							<tr>
								<td class="col-md-1">6:00 - 7:00</td>
								<input type="hidden" name="time1[]" value="06:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'6') != ""){
									echo getBatch($db,$office,'M-1',$date,'6');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'6') != ""){
									echo getComment($db,$office,'M-1',$date,'6');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'6') != ""){
									echo getBatch($db,$office,'M-3a',$date,'6');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'6') != ""){
									echo getComment($db,$office,'M-3a',$date,'6');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'6') != ""){
									echo getBatch($db,$office,'M-3b',$date,'6');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'6') != ""){
									echo getComment($db,$office,'M-3b',$date,'6');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">7:00 - 8:00</td>
								<input type="hidden" name="time1[]" value="07:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'7') != ""){
									echo getBatch($db,$office,'M-1',$date,'7');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'7') != ""){
									echo getComment($db,$office,'M-1',$date,'7');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'7') != ""){
									echo getBatch($db,$office,'M-3a',$date,'7');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'7') != ""){
									echo getComment($db,$office,'M-3a',$date,'7');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'7') != ""){
									echo getBatch($db,$office,'M-3b',$date,'7');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'7') != ""){
									echo getComment($db,$office,'M-3b',$date,'7');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">8:00 - 9:00</td>
								<input type="hidden" name="time1[]" value="08:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'8') != ""){
									echo getBatch($db,$office,'M-1',$date,'8');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'8') != ""){
									echo getComment($db,$office,'M-1',$date,'8');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'8') != ""){
									echo getBatch($db,$office,'M-3a',$date,'8');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'8') != ""){
									echo getComment($db,$office,'M-3a',$date,'8');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'8') != ""){
									echo getBatch($db,$office,'M-3b',$date,'8');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'8') != ""){
									echo getComment($db,$office,'M-3b',$date,'8');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">9:00 - 10:00</td>
								<input type="hidden" name="time1[]" value="09:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'9') != ""){
									echo getBatch($db,$office,'M-1',$date,'9');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'9') != ""){
									echo getComment($db,$office,'M-1',$date,'9');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'9') != ""){
									echo getBatch($db,$office,'M-3a',$date,'9');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'9') != ""){
									echo getComment($db,$office,'M-3a',$date,'9');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'9') != ""){
									echo getBatch($db,$office,'M-3b',$date,'9');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'9') != ""){
									echo getComment($db,$office,'M-3b',$date,'9');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">10:00 - 11:00</td>
								<input type="hidden" name="time1[]" value="10:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'10') != ""){
									echo getBatch($db,$office,'M-1',$date,'10');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'10') != ""){
									echo getComment($db,$office,'M-1',$date,'10');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'10') != ""){
									echo getBatch($db,$office,'M-3a',$date,'10');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'10') != ""){
									echo getComment($db,$office,'M-3a',$date,'10');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'10') != ""){
									echo getBatch($db,$office,'M-3b',$date,'10');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'10') != ""){
									echo getComment($db,$office,'M-3b',$date,'10');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">11:00 - 12:00</td>
								<input type="hidden" name="time1[]" value="11:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'11') != ""){
									echo getBatch($db,$office,'M-1',$date,'11');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'11') != ""){
									echo getComment($db,$office,'M-1',$date,'11');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'11') != ""){
									echo getBatch($db,$office,'M-3a',$date,'11');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'11') != ""){
									echo getComment($db,$office,'M-3a',$date,'11');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'11') != ""){
									echo getBatch($db,$office,'M-3b',$date,'11');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'11') != ""){
									echo getComment($db,$office,'M-3b',$date,'11');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<th class="col-md-1">PM</th>
								<th class="col-md-1">Batch</th>
								<th class="col-md-1">Comment</th>
								<th class="col-md-1">Batch</th>
								<th class="col-md-1">Comment</th>
								<th class="col-md-1">Batch</th>
								<th class="col-md-1">Comment</th>
							</tr>
							<tr>
								<td class="col-md-1">12:00 - 1:00</td>
								<input type="hidden" name="time1[]" value="12:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'12') != ""){
									echo getBatch($db,$office,'M-1',$date,'12');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'12') != ""){
									echo getComment($db,$office,'M-1',$date,'12');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'12') != ""){
									echo getBatch($db,$office,'M-3a',$date,'12');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'12') != ""){
									echo getComment($db,$office,'M-3a',$date,'12');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'12') != ""){
									echo getBatch($db,$office,'M-3b',$date,'12');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'12') != ""){
									echo getComment($db,$office,'M-3b',$date,'12');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">1:00 - 2:00</td>
								<input type="hidden" name="time1[]" value="13:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'13') != ""){
									echo getBatch($db,$office,'M-1',$date,'13');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'13') != ""){
									echo getComment($db,$office,'M-1',$date,'13');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'13') != ""){
									echo getBatch($db,$office,'M-3a',$date,'13');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'13') != ""){
									echo getComment($db,$office,'M-3a',$date,'13');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'13') != ""){
									echo getBatch($db,$office,'M-3b',$date,'13');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'13') != ""){
									echo getComment($db,$office,'M-3b',$date,'13');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">2:00 - 3:00</td>
								<input type="hidden" name="time1[]" value="14:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'14') != ""){
									echo getBatch($db,$office,'M-1',$date,'14');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'14') != ""){
									echo getComment($db,$office,'M-1',$date,'14');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'14') != ""){
									echo getBatch($db,$office,'M-3a',$date,'14');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'14') != ""){
									echo getComment($db,$office,'M-3a',$date,'14');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'14') != ""){
									echo getBatch($db,$office,'M-3b',$date,'14');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'14') != ""){
									echo getComment($db,$office,'M-3b',$date,'14');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">3:00 - 4:00</td>
								<input type="hidden" name="time1[]" value="15:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'15') != ""){
									echo getBatch($db,$office,'M-1',$date,'15');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'15') != ""){
									echo getComment($db,$office,'M-1',$date,'15');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'15') != ""){
									echo getBatch($db,$office,'M-3a',$date,'15');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'15') != ""){
									echo getComment($db,$office,'M-3a',$date,'15');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'15') != ""){
									echo getBatch($db,$office,'M-3b',$date,'15');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'15') != ""){
									echo getComment($db,$office,'M-3b',$date,'15');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">4:00 - 5:00</td>
								<input type="hidden" name="time1[]" value="16:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'16') != ""){
									echo getBatch($db,$office,'M-1',$date,'16');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'16') != ""){
									echo getComment($db,$office,'M-1',$date,'16');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'16') != ""){
									echo getBatch($db,$office,'M-3a',$date,'16');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'16') != ""){
									echo getComment($db,$office,'M-3a',$date,'16');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'16') != ""){
									echo getBatch($db,$office,'M-3b',$date,'16');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'16') != ""){
									echo getComment($db,$office,'M-3b',$date,'16');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">5:00 - 6:00</td>
								<input type="hidden" name="time1[]" value="17:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'17') != ""){
									echo getBatch($db,$office,'M-1',$date,'17');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'17') != ""){
									echo getComment($db,$office,'M-1',$date,'17');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'17') != ""){
									echo getBatch($db,$office,'M-3a',$date,'17');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'17') != ""){
									echo getComment($db,$office,'M-3a',$date,'17');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'17') != ""){
									echo getBatch($db,$office,'M-3b',$date,'17');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'17') != ""){
									echo getComment($db,$office,'M-3b',$date,'17');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">6:00 - 7:00</td>
								<input type="hidden" name="time1[]" value="18:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'18') != ""){
									echo getBatch($db,$office,'M-1',$date,'18');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'18') != ""){
									echo getComment($db,$office,'M-1',$date,'18');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'18') != ""){
									echo getBatch($db,$office,'M-3a',$date,'18');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'18') != ""){
									echo getComment($db,$office,'M-3a',$date,'18');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'18') != ""){
									echo getBatch($db,$office,'M-3b',$date,'18');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'18') != ""){
									echo getComment($db,$office,'M-3b',$date,'18');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">7:00 - 8:00</td>
								<input type="hidden" name="time1[]" value="19:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'19') != ""){
									echo getBatch($db,$office,'M-1',$date,'19');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'19') != ""){
									echo getComment($db,$office,'M-1',$date,'19');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'19') != ""){
									echo getBatch($db,$office,'M-3a',$date,'19');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'19') != ""){
									echo getComment($db,$office,'M-3a',$date,'19');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'19') != ""){
									echo getBatch($db,$office,'M-3b',$date,'19');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'19') != ""){
									echo getComment($db,$office,'M-3b',$date,'19');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">8:00 - 9:00</td>
								<input type="hidden" name="time1[]" value="20:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'20') != ""){
									echo getBatch($db,$office,'M-1',$date,'20');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'20') != ""){
									echo getComment($db,$office,'M-1',$date,'20');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'20') != ""){
									echo getBatch($db,$office,'M-3a',$date,'20');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'20') != ""){
									echo getComment($db,$office,'M-3a',$date,'20');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'20') != ""){
									echo getBatch($db,$office,'M-3b',$date,'20');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'20') != ""){
									echo getComment($db,$office,'M-3b',$date,'20');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">9:00 - 10:00</td>
								<input type="hidden" name="time1[]" value="21:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'21') != ""){
									echo getBatch($db,$office,'M-1',$date,'21');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'21') != ""){
									echo getComment($db,$office,'M-1',$date,'21');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'21') != ""){
									echo getBatch($db,$office,'M-3a',$date,'21');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'21') != ""){
									echo getComment($db,$office,'M-3a',$date,'21');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'21') != ""){
									echo getBatch($db,$office,'M-3b',$date,'21');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'21') != ""){
									echo getComment($db,$office,'M-3b',$date,'21');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">10:00 - 11:00</td>
								<input type="hidden" name="time1[]" value="22:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'22') != ""){
									echo getBatch($db,$office,'M-1',$date,'22');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'22') != ""){
									echo getComment($db,$office,'M-1',$date,'22');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'22') != ""){
									echo getBatch($db,$office,'M-3a',$date,'22');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'22') != ""){
									echo getComment($db,$office,'M-3a',$date,'22');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'22') != ""){
									echo getBatch($db,$office,'M-3b',$date,'22');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'22') != ""){
									echo getComment($db,$office,'M-3b',$date,'22');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
								</td>
							</tr>
							<tr>
								<td class="col-md-1">11:00 - 12:00</td>
								<input type="hidden" name="time1[]" value="23:00:00">
								<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-1',$date,'23') != ""){
									echo getBatch($db,$office,'M-1',$date,'23');
	}else{
?>
												<input type="text" autocomplete="off" name="batch1[]" id="batch1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-1',$date,'23') != ""){
									echo getComment($db,$office,'M-1',$date,'23');
	}else{
?>
												<input type="text" autocomplete="off" name="comment1[]" id="comment1" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3a',$date,'23') != ""){
									echo getBatch($db,$office,'M-3a',$date,'23');
	}else{
?>
												<input type="text" autocomplete="off" name="batch2[]" id="batch2" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3a',$date,'23') != ""){
									echo getComment($db,$office,'M-3a',$date,'23');
	}else{
?>
												<input type="text" autocomplete="off" name="comment2[]" id="comment2" class="form-control">
<?php		
	}
?>									
												</td>
												<td class="col-md-1">
<?php
	if(getBatch($db,$office,'M-3b',$date,'23') != ""){
									echo getBatch($db,$office,'M-3b',$date,'23');
	}else{
?>
												<input type="text" autocomplete="off" name="batch3[]" id="batch3" class="form-control">
<?php		
	}
?>
												</td>
												<td class="col-md-1">
<?php
	if(getComment($db,$office,'M-3b',$date,'23') != ""){
									echo getComment($db,$office,'M-3b',$date,'23');
	}else{
?>
												<input type="text" autocomplete="off" name="comment3[]" id="comment3" class="form-control">
<?php		
	}
?>									
												</td>
											</tr>
											<tr>
												<th class="col-md-1">Total</th>
												<th colspan="2">
<?php
	if($office == 'bravo'){
		$string_office = " AND office = 'bravo'";
	}else if($office == 'delta'){
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
	if($office == 'bravo'){
		$string_office = " AND office = 'bravo'";
	}else if($office == 'delta'){
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
	if($office == 'bravo'){
		$string_office = " AND office = 'bravo'";
	}else if($office == 'delta'){
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
<?php
	if($office == 'bravo'){
		$string_office = " AND office = 'bravo'";
	}else if($office == 'delta'){
		$string_office = " AND office = 'delta'";
	}else{
		$string_office = "";
	}

	$button_sql = "SELECT DATE_FORMAT(batch_date,'%m/%d/%Y') as prod_date
					FROM batch 
					WHERE DATE_FORMAT(batch_date,'%m/%d/%Y') = DATE_FORMAT('$date','%m/%d/%Y')".$string_office;

	$button_result = mysqli_query($db,$button_sql);
	if(mysqli_num_rows($button_result) == 0){
?>
											<tr>
												<td colspan="7" style="text-align: center;">
													<input type="submit" name="add_batch" value="Submit" class="btn btn-success" style="font-weight: bold; width: 400px;">
												</td>
											</tr>
<?php
	}
?>
										</tbody>
	                            	</table>
	                            </form>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>
</body>
</html>
<?php
	if(isset($_POST['add_batch'])){	//input for batches per hour

		$count = 0;
		$machine1 = "M-1";
		$machine2 = "M-3a";
		$machine3 = "M-3b";
		$item1 = $_POST['type1'];
		$item2 = $_POST['type2'];
		$item3 = $_POST['type3'];
		$cement1 = $_POST['cement1'];
		$cement2 = $_POST['cement2'];
		$cement3 = $_POST['cement3'];
		$batches1 = $_POST['batch1'];
		$batches2 = $_POST['batch2'];
		$batches3 = $_POST['batch3'];
		$comment1 = $_POST['comment1'];
		$comment2 = $_POST['comment2'];
		$comment3 = $_POST['comment3'];
		$date = date_create($_POST['hidden_date_view']);
		$datetime = date_format($date,"Y-m-d");
		$time = $_POST['time1'];

		for($i = 0; $i < count($batches1); $i++){
			if($batches1[$i] == ""){
				$batches1[$i] = "0";
			}
			if($comment1[$i] == ""){
				$comment1[$i] = "No comment";
			}

			$fulldate = $datetime." ".$time[$i]; 
			$batch_query1 = "INSERT INTO batch(machine_no, item_no, cement, batch_count, batch_date, comment, office)
							VALUES('$machine1','$item1','$cement1','$batches1[$i]','$fulldate','$comment1[$i]','$office')";

			$cement_total1 = $batches1[$i] * $cement1;
			$cement_update1 = "UPDATE item_stock SET stock = stock - '$cement_total1', last_update = '$fulldate'
								WHERE office = '$office' AND item_no = 'Cement'";

			// echo $batch_query1 . "<br>";
			// echo $cement_update1 . "<br>";				
			if(mysqli_query($db, $batch_query1) && mysqli_query($db, $cement_update1)){
				// phpAlert("Batch successfully added!!");
				// echo "<meta http-equiv='refresh' content='0'>";
				$count++;
			}else{
				phpAlert("Something went wrong!!");
			}
		}

		for($i = 0; $i < count($batches2); $i++){
			if($batches2[$i] == ""){
				$batches2[$i] = "0";
			}
			if($comment2[$i] == ""){
				$comment2[$i] = "No comment";
			}
			$fulldate = $datetime." ".$time[$i]; 
			$batch_query2 = "INSERT INTO batch(machine_no, item_no, cement, batch_count, batch_date, comment, office)
							VALUES('$machine2','$item2','$cement2','$batches2[$i]','$fulldate','$comment2[$i]','$office')";

			$cement_total2 = $batches2[$i] * $cement2;
			$cement_update2 = "UPDATE item_stock SET stock = stock - '$cement_total2', last_update = '$fulldate'
								WHERE office = '$office' AND item_no = 'Cement'";

			// echo $batch_query2 . "<br>";
			// echo $cement_update2 . "<br>";				
			if(mysqli_query($db, $batch_query2) && mysqli_query($db, $cement_update2)){
				// phpAlert("Batch successfully added!!");
				// echo "<meta http-equiv='refresh' content='0'>";
				$count++;
			}else{
				phpAlert("Something went wrong!!");
			}
		}

		for($i = 0; $i < count($batches3); $i++){
			if($batches3[$i] == ""){
				$batches3[$i] = "0";
			}
			if($comment3[$i] == ""){
				$comment3[$i] = "No comment";
			}
			$fulldate = $datetime." ".$time[$i]; 
			$batch_query3 = "INSERT INTO batch(machine_no, item_no, cement, batch_count, batch_date, comment, office)
							VALUES('$machine3','$item3','$cement3','$batches3[$i]','$fulldate','$comment3[$i]','$office')";

			$cement_total3 = $batches3[$i] * $cement3;
			$cement_update3 = "UPDATE item_stock SET stock = stock - '$cement_total3', last_update = '$fulldate'
								WHERE office = '$office' AND item_no = 'Cement'";

			// echo $batch_query3 . "<br>";
			// echo $cement_update3 . "<br>";				
			if(mysqli_query($db, $batch_query3) && mysqli_query($db, $cement_update3)){
				// phpAlert("Batch successfully added!!");
				// echo "<meta http-equiv='refresh' content='0'>";
				$count++;
			}else{
				phpAlert("Something went wrong!!");
			}
		}

		if($count > 0){
			phpAlert("Batch successfully added!!");
			echo "<meta http-equiv='refresh' content='0'>";
		}
	}else if(isset($_GET['add_production'])){
		header("location: plant_batch_add_production.php");
	}

?>