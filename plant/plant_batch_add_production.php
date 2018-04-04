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

    <title>Daily Batch Production</title>

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

	function getMachine(str){
        var date_prev = $('#date_prev').val();
        var office = $('#office').val();
	    var dataString = "date_prev="+date_prev+"&office="+office;
	    $.ajax({
	        type: "POST",
	        url: "plant_batch_result.php", // Name of the php files
	        data: dataString,
	        success: function(html)
	        {
	            $("#item_no_prod").html(html);
	        }
	    });
	}

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
                            <span class="menu-arrow arrow_carrot-down"></span>
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
                            <span class="menu-arrow arrow_carrot-down"></span>
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
                            <span class="menu-arrow arrow_carrot-down"></span>
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
                            <li><i class="fa fa-building"></i><a href="plant_batch_daily_report.php?office=<?php echo $search_plant; ?>">Batch Daily Report</a></li>  
                            <li><i class="fa fa-building"></i><a href="plant_batch_add_production.php" style="color: blue;">Batch Production</a></li>  

                        </ol>
                    </div>
	            </div>

	            <!-- Basic Forms & Horizontal Forms-->
              
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<section class="panel">
							<header class="panel-heading">
							Production Form
							</header>
							<div class="panel-body">
								<form class="form-horizontal" role="form" id="form" action="plant_batch_add_production.php" method="post" onsubmit="return confirm('Proceed?');">
									<input type="hidden" name="office" id="office" value="<?php echo $office; ?>">
									<div class="form-group">
										<label for="date" class="col-md-3 control-label">Date</label>
										<div class="col-md-8">
<?php
	$sql = "SELECT DATE_FORMAT(batch_date,'%m/%d/%y') as prod_date 
			FROM batch 
			WHERE office = '$search_plant' 
			AND (item_no,DATE_FORMAT(batch_date,'%m/%d/%y')) NOT IN (SELECT item_no, DATE_FORMAT(date_production,'%m/%d/%y') 
																	FROM batch_prod WHERE office = '$search_plant') 
			GROUP BY prod_date 
			ORDER BY batch_date DESC";
			
	$result = mysqli_query($db,$sql);
?>
											<select id="date_prev" name="date_prev" class="form-control" onchange="getMachine(this.value);" required>
											 	<option value="">Select</option>
										          <?php foreach($result as $row){
										              echo "<option value='" . $row['prod_date'] . "'>" . $row['prod_date'] . "</option>";
										            }
										          ?>
										    </select>
										</div>
									</div>
									<div class="form-group">
										<label for="item_no_prod" class="col-md-3 control-label">Type</label>
										<div class="col-md-8">
											<select id="item_no_prod" name="item_no_prod" class="form-control" required>";
												<option value=''>Select</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="actual_prod" class="col-md-3 control-label">Actual Production</label>
										<div class="col-md-8">
											<input type="text" name="actual_prod" class="form-control" autocomplete="off" required>
										</div>
									</div>
									<div class="form-group">
										<label for="reject" class="col-md-3 control-label">Rejected</label>
										<div class="col-md-8">
											<input type="text" name="reject" class="form-control" autocomplete>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-10 col-md-offset-6">
											<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" style="font-weight: bold;">
											<a href="plant_batch_daily_report.php" class="btn btn-warning"><strong>Cancel</strong></a>
										</div>
									</div>
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
	if(isset($_POST['submit'])){ //input for actual production

		$item_prod = mysqli_real_escape_string($db, $_POST['item_no_prod']);
		$actual = str_replace(",", "", mysqli_real_escape_string($db, $_POST['actual_prod']));
		$date=date_create(mysqli_real_escape_string($db, $_POST['date_prev']));
		$datetime = date_format($date,"Y-m-d");
		$now_datetime = date("Y-m-d H:i:s");
		// $search_plant = ucfirst(mysqli_real_escape_string($db, $_POST['add_production']));
		if($_POST['reject'] != ''){
			$reject = mysqli_real_escape_string($db, $_POST['reject']);
		}else{
			$reject = 0;
		}
		//query for batches produce by $type within the day
		$prod_sql = "SELECT SUM(batch_count) as count FROM batch 
						WHERE DATE_FORMAT(batch_date,'%Y-%m-%d') = '$datetime'
						AND item_no = '$item_prod' AND office = '$search_plant'";
		// echo $prod_sql;
		$prod_result = mysqli_query($db, $prod_sql);
		$row5 = mysqli_fetch_assoc($prod_result);

		$output = number_format($actual / $row5['count'],2);
		// echo $output . "<br>";
		$prod_insert = "INSERT INTO batch_prod(item_no, actual_prod, batch_prod, output, reject, date_production, office) 
						VALUES ('$item_prod','$actual','".$row5['count']."','$output','$reject','$datetime','$search_plant')";

		// echo $prod_insert . "<br>";
		$sql = "SELECT item_no FROM item_stock WHERE item_no = '$item_prod' AND office = '$search_plant'";
		$result = mysqli_query($db, $sql);

		if(mysqli_num_rows($result) > 0){
			//update data in item_stock if item_no is equal to $type
			$stock_query = "UPDATE item_stock SET stock = stock + '$actual', last_update = '$now_datetime' 
							WHERE item_no = '$item_prod' AND office = '$search_plant'";
		}else{
			//insert to item_stock if not exist
			$stock_query = "INSERT INTO item_stock(item_no, stock, office, last_update) 
							VALUES('$item_prod', '$actual', '$search_plant', '$now_datetime')";
		}

		$batch_stock = "INSERT INTO batch_prod_stock(item_no, production, office, date_production) 
						VALUES('$item_prod','$actual','$search_plant','$datetime')";

		$history_query = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) 
							VALUES('Batch','Production','$item_prod','Produced ".number_format($actual)." pcs of $item_prod',NOW(),'$search_plant')";

		// echo $batch_stock . "<br>";
		// echo $history_query . "<br>";
		if(mysqli_query($db, $prod_insert) && mysqli_query($db, $stock_query) && mysqli_query($db, $batch_stock) && mysqli_query($db, $history_query)){
			phpAlert("Production successfully added!!");
			echo "<meta http-equiv='refresh' content='0'>";
		}else{
			phpAlert("Something went wrong!!");
			echo "<meta http-equiv='refresh' content='0'>";
		}		
	}

?>