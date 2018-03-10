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
    	$_GET['date_view'] = '';
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

    <title>Starcrete Manufacturing Corporation</title>

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

	$(document).ready(function(){
        $('.filterable .btn-filter').click(function(){
            var $panel = $(this).parents('.filterable'),
            $filters = $panel.find('.filters input'),
            $tbody = $panel.find('.table tbody');
            if ($filters.prop('disabled') == true) {
                $filters.prop('disabled', false);
                $filters.first().focus();
            } else {
                $filters.val('').prop('disabled', true);
                $tbody.find('.no-result').remove();
                $tbody.find('tr').show();
            }
        });

        $('.filterable .filters input').keyup(function(e){
            /* Ignore tab key */
            var code = e.keyCode || e.which;
            if (code == '9') return;
            /* Useful DOM data and selectors */
            var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');
            /* Dirtiest filter function ever ;) */
            var $filteredRows = $rows.filter(function(){
                var value = $(this).find('td').eq(column).text().toLowerCase();
                return value.indexOf(inputContent) === -1;
            });
            /* Clean previous no-result if exist */
            $table.find('tbody .no-result').remove();
            /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
            $rows.show();
            $filteredRows.hide();
            /* Prepend no-result row if all rows are filtered */
            if ($filteredRows.length === $rows.length) {
                 $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="10" style="min-height: 100%;background: white; text-align:center; vertical-align:middle;"><h4><p class="text-muted">No data found</p></h4></td></tr>'));
            }
        });
    });

</script>

<style>

.filterable .panel-heading .pull-right {
    margin-top: -20px;
}
.filterable .filters input[disabled] {
    background-color: transparent;
    text-align: center;
    border: none;
    cursor: auto;
    box-shadow: none;
    padding: 0;
    height: auto;
}
.filterable .filters input[disabled]::-webkit-input-placeholder {
    color: gray;
    text-align: left;
    font-weight: bold;
}
.filterable .filters input[disabled]::-moz-placeholder {
     color: gray;
     text-align: left;
     font-weight: bold;
}
.filterable .filters input[disabled]:-ms-input-placeholder {
     color: gray;
     text-align: left;
     font-weight: bold;
}

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
                    <li class="">
                        <a class="" href="index.php">
                            <i class="icon_house"></i>
                            <span>History</span>
                        </a>
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

        <section id="main-content">
            <section class="wrapper">            
                <!--overview start-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- <h3 class="page-header"><i class="fa fa-home"></i> History</h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo $plant; ?></li>
                            <li><i class="icon_document"></i><a href="diesel.php?office=<?php echo $search_plant; ?>" style="color: blue;">Diesel</a></li>             
                        </ol>
                    </div>
                </div>	

                <div class="row">
                	<!-- <div class="col-lg-2">
                		<section class="panel">
                			<header class="panel-heading">
                				Diesel Stock
                			</header>
                			<div class="panel-body">
                				<div class="table-responsive">
                					<table class="table table-striped table-bordered">
                						<thead>
                							<tr>
                								<th class="col-md-1">Plant</th>
                								<th class="col-md-1">Stock</th>
                							</tr>
                						</thead>
                						<tbody>
<?php

	$sql = "SELECT CONCAT(FORMAT(stock,0), ' liter') as stock, office 
			FROM item_stock 
			WHERE office = '$search_plant'
			AND item_no = 'Diesel'
			ORDER BY office ASC";
	$result = mysqli_query($db, $sql);
	while($row = mysqli_fetch_assoc($result)){
?>
							<tr align="center">
								<td><strong><?php echo ucfirst($row['office']); ?></strong></td>
								<td><strong><?php echo $row['stock']; ?></strong></td>
							</tr>
<?php
	}
?>
                						</tbody>
                					</table>
                				</div>
                			</div>
                		</section>
                	</div> -->
                    <div class="col-lg-12">
                        <section class="panel">
                        	<form action="plant_diesel.php" method="get" class="form-inline">
                            <header class="panel-heading">
                                <div class="row" style="margin-bottom: 5px;">
                                	<div class="col-md-12" style="margin-bottom: 5px;">
										<div class="col-md-3">
											Select Date:
                                			<input type="date" name="date_view" class="form-control" value="<?php if(isset($_GET['date_view'])) { echo htmlentities ($_GET['date_view']); }?>" onblur="this.form.submit();">	
										</div>
                                	</div>
                                </div>
                            </header>
                        </form>
                            <div class="panel-body">
                            	<div class="table-responsive filterable">
                            		<table class="table table-striped table-bordered">
                            			<thead>
                            				<tr class="filterable">
                            					<th colspan="7">
                            						<?php 
	                            						$date_view = date_create($_GET['date_view']); 
                            							$today = date('Y-m-d');
                            							$today = date_create($today);

                            							echo "Available stock as of today, " . date_format($today,"F d, Y") . ": " . number_format(getDieselStock($db, $search_plant)) . " liters <br>"; 
                            							echo "Search Date: " . date_format($date_view,"F d, Y");
                            							
                            						?>
                            						<button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="fa fa-filter"></span> Filter</button>
                            					</th>
                            				</tr>
                            				<tr class="filters">
												<th class="col-md-1"><input type="text" class="form-control" placeholder="Truck No." disabled></th>
												<th class="col-md-1">Driver / Optr.</th>
												<th class="col-md-1">Quantity (IN)</th>
												<th class="col-md-1">Quantity (OUT)</th>
												<th class="col-md-1">Current Stock</th>
												<th class="col-md-1"><input type="text" class="form-control" placeholder="Address" disabled></th>
												<th class="col-md-1">Time</th>
											</tr>
                            			</thead>
                            			<tbody>
<?php

	if($_GET['date_view'] == ''){
        $date_view = date('Y-m-d');
    }else{
        $date_view = $_GET['date_view'];
    }

	$query = "SELECT CONCAT(FORMAT(quantity_in,0), ' liters') as quantity_in, CONCAT(FORMAT(quantity_out,0), ' liters') as quantity_out, CONCAT(FORMAT(balance,0), ' liters') as balance, destination, truck_no, operator, delivery_date, office
		  		FROM diesel
		  		WHERE office = '$search_plant'
		  		AND DATE_FORMAT(delivery_date,'%Y-%m-%d') = '$date_view'
		  		ORDER BY delivery_date DESC";
// echo $query;
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$date = date_create($row['delivery_date']);
?>
							<tr>
								<td><strong><?php echo $row['truck_no']; ?></strong></td>
								<td><strong><?php echo $row['operator']; ?></strong></td>
								<td><strong><?php echo $row['quantity_in']; ?></strong></td>
								<td><strong><?php echo $row['quantity_out']; ?></strong></td>
								<td><strong><?php echo $row['balance']; ?></strong></td>
								<td><strong><?php echo $row['destination']; ?></strong></td>
								<td><strong><?php echo date_format($date,'g:i A'); ?></strong></td>
							</tr>

<?php
		}
	}else{
?>
							<tr>
                                <td colspan="7" style='height: 100%; background: white; text-align:center; 
                            vertical-align:middle;'><h4><p class='text-muted'>No data found</p></h4></td>
                            </tr>
<?php
	}

?>
                            			</tbody>
                            		</table>
                            	</div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>
</body>
</html>