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

    if(isset($_SESSION['post_delivery_id'])){
		$_SESSION['delivery_id'] = $_SESSION['post_delivery_id'];
	}

	$user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
	$user_query->bind_param('s', $_SESSION['login_user']);
	$user_query->execute();
	$result = $user_query->get_result();
	$user = $result->fetch_assoc();

	$office = $user['office'];
	$position = $user['position'];

	$delivery_id = $_SESSION['delivery_id'];
	$search_sql = "SELECT * FROM delivery WHERE delivery_id = '$delivery_id'";
	$search_result = mysqli_query($db, $search_sql);
	$delivery_row = mysqli_fetch_assoc($search_result);

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Waiting - Delivery Order</title>

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
<script>

	$(function() {
        
        // var $form = $( "#form" );
        // var $input = $form.find( "#quantity" );

        // $input.on( "keyup", function( event ) {

	 	var $form = $( "#form" );
        var $input = $form.find( "#update_quantity" );

        $form.on( "keyup", "#update_quantity", function( event ) {
            
            
            // When user select text in the document, also abort.
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }
            
            // When the arrow keys are pressed, abort.
            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            
            
            var $this = $( this );
            
            // Get the value.
            var input = $this.val();
            
            var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt( input, 10 ) : 0;

                    $this.val( function() {
                        return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                    } );
        } );      
    });

</script>
<style>
/*.page_links a{
    color: inherit;
}*/
</style>
</head>
<body onload="compareValues('');">
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
	                        <span>Purchase Order</span>
	                        <span class="menu-arrow arrow_carrot-down"></span>
	                    </a>
	                    <ul class="sub">
	                        <li><a class="" href="plant_purchase_order.php">Pending P.O.</a></li>  
	                        <li><a class="" href="plant_purchase_closed_order.php">Closed P.O.</a></li>
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
	                        <li><a class="" href="plant_delivery_order.php">Ongoing Delivery <span class="badge"><?php echo getDeliveryCountOnDeliveryOffice($db, $office); ?></span></a></li>          
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
	                    <!-- <h3 class="page-header"><i class="fa fa-file"></i><a href="plant_delivery_issue_form.php">Update Form</a></h3> -->
	                    <ol class="breadcrumb">
	                        <li><i class="fa fa-building"></i>Delivery Order</li>
	                        <li><i class="fa fa-truck"></i><a href="plant_delivery_order.php">Ongoing Delivery</a></li>			
	                        <li><i class="fa fa-file"></i>Update Form</li>						  	
	                    </ol>
	                </div>
	            </div>

	            <!-- Basic Forms & Horizontal Forms-->
              
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<section class="panel">
							<header class="panel-heading">
							Update Form
							</header>
							<div class="panel-body">
								<form class="form-horizontal" role="form" id="form" action="plant_delivery_order_update.php" method="post" onsubmit="return confirm('Proceed?');">
									<div class="form-group">
										<label for="po_no" class="col-md-3 control-label">P.O. No.</label>
										<div class="col-md-6">
											<input type="hidden" name="update_delivery_receipt_no" value="<?php echo $delivery_row['po_no_delivery'] ?>" class="form-control" readonly>
											<p class="help-block"><strong><?php echo $delivery_row['po_no_delivery']; ?></strong></p>
										</div>
									</div>
									<div class="form-group">
										<label for="update_delivery_receipt_no" class="col-md-3 control-label">DR No.</label>
										<div class="col-md-6">
											<input type="text" name="update_delivery_receipt_no" value="<?php echo $delivery_row['delivery_receipt_no'] ?>" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label for="update_gate_pass" class="col-md-3 control-label">Gate Pass</label>
										<div class="col-md-6">
											<input type="text" name="update_gate_pass" value="<?php echo $delivery_row['gate_pass'] ?>" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label for="item_no" class="col-md-3 control-label">Current Item</label>
										<div class="col-md-6">
											<input type="hidden" name="item_no" value="<?php echo $delivery_row['item_no']; ?>">
											<p class="help-block"><strong>
												<?php 
													if($delivery_row['psi'] != ''){
														echo $delivery_row['item_no'] . " (" . $delivery_row['psi'] . " PSI)";
													}else{
														echo $delivery_row['item_no'];
													}
													?>
											</strong></p>
										</div>
									</div>
									<div class="form-group">
										<label for="update_item" class="col-md-3 control-label">New Item</label>
										<div class="col-md-3">
											<select id="update_item" name="update_item" class="form-control" style="width: 150px;">
												<option value="">Select</option>
<?php
	$item_sql = "SELECT item_no FROM batch_list
					WHERE item_no != '".$delivery_row['item_no']."' ORDER BY item_no ASC";
	$result1 = mysqli_query($db, $item_sql);
	foreach($result1 as $row1){
									echo "<option value='" . $row1['item_no'] . "'>" . $row1['item_no'] . "</option>";
	}
?>												
											</select>
										</div>
										<label for="psi" class="col-md-2 control-label">PSI</label>
										<div class="col-md-3">
											<input type="text" name="update_psi" value="<?php echo $delivery_row['psi']; ?>" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="update_quantity" class="col-md-3 control-label">Quantity</label>
										<div class="col-md-6">
											<!-- <input type="text" id="update_quantity" name="update_quantity" value="<?php echo number_format($delivery_row['quantity']); ?>" class="form-control" onkeyup="compareValues(this.value)" required> -->
											<input type="hidden" id="update_quantity" name="update_quantity" value="<?php echo number_format($delivery_row['quantity']); ?>">
											<p class="help-block"><strong><?php echo number_format($delivery_row['quantity']) . " pcs"; ?></strong></p>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2 col-md-10">
											<input type="submit" name="submit" id="submit" value="Done" class="btn btn-primary" style="font-weight: bold;">
											<a href="plant_delivery_order.php" class="btn btn-default"><strong>Cancel</strong></a>
										</div>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
				<div class="text-right">
		            <div class="credits">
		                <!-- 
		                All the links in the footer should remain intact. 
		                You can delete the links only if you purchased the pro version.
		                Licensing information: https://bootstrapmade.com/license/
		                Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
		                -->
		                <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
		            </div>
		        </div>
			</section>
		</section>
	</section>
</body>
</html>
<?php

	if(isset($_POST['submit'])){

		$new_delivery_receipt_no = mysqli_real_escape_string($db, $_POST['update_delivery_receipt_no']);
		$new_quantity = mysqli_real_escape_string($db, str_replace(',','',$_POST['update_quantity']));
		$new_gate_pass = mysqli_real_escape_string($db, $_POST['update_gate_pass']);
		$new_psi = mysqli_real_escape_string($db, $_POST['update_psi']);
		
		$datetime = date("Y/m/d H:i:s");

		if(isset($_POST['update_item']) && $_POST['update_item'] != ''){
			$new_item_no = mysqli_real_escape_string($db, $_POST['update_item']);
		}else{
			$new_item_no = mysqli_real_escape_string($db, $_POST['item_no']);
		}

		if($_POST['update_psi'] != ''){
			$new_psi_ext = "(" . $new_psi . " PSI)";
		}else{
			$new_psi_ext = '';
		}

		if($delivery_row['psi'] != ''){
			$item_psi_ext = $delivery_row['item_no'] . " (" . $delivery_row['psi'] . " PSI)";
		}else{
			$item_psi_ext = $delivery_row['item_no'];
		}

        if($new_item_no != $delivery_row['item_no']){
            $change_item_insert = "INSERT INTO delivery_change_item (new_item_no, prev_item_no, delivery_id)
                                    VALUES ('$new_item_no','".$delivery_row['item_no']."','$delivery_id')";

            mysqli_query($db, $change_item_insert);
        }

		$sql = "UPDATE delivery 
				SET item_no = '$new_item_no', delivery_receipt_no = '$new_delivery_receipt_no', quantity = '$new_quantity', gate_pass = '$new_gate_pass', psi = '$new_psi' 
				WHERE delivery_id = '$delivery_id' AND office = '$office'";

		// $sql = "UPDATE delivery SET item_no = '$new_item_no' WHERE delivery_id = '$delivery_id' AND delivery_receipt_no = '$delivery_receipt_no' AND fk_po_id = '$fk_po_id' AND office = '$office'";

		if($new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_item_no == $delivery_row['item_no'] && $new_gate_pass == $delivery_row['gate_pass'] && $new_quantity == $delivery_row['quantity']){
			// update DR No. only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no','$datetime','$office')";

		}else if($new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no == $delivery_row['delivery_receipt_no'] && $new_gate_pass == $delivery_row['gate_pass'] && $new_quantity == $delivery_row['quantity']){
			// update item only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update item ".$item_psi_ext." to $new_item_no $new_psi_ext under DR No. ".$delivery_row['delivery_receipt_no']."','$datetime','$office')";

		}else if($new_quantity == $delivery_row['quantity'] && $new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no == $delivery_row['delivery_receipt_no'] && $new_gate_pass == $delivery_row['gate_pass']){
			// update item quantity only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update ".$item_psi_ext." quantity of ".$delivery_row['quantity']." to $new_quantity pcs under DR No. ".$delivery_row['delivery_receipt_no']."','$datetime','$office')";

		}else if($new_gate_pass != $delivery_row['gate_pass'] && $new_delivery_receipt_no == $delivery_row['delivery_receipt_no'] && $new_item_no == $delivery_row['item_no'] && $new_quantity == $delivery_row['quantity']){
			// update gatepass only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass under DR No. ".$delivery_row['delivery_receipt_no']."','$datetime','$office')";

		}else if($new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_item_no != $delivery_row['item_no'] && $new_gate_pass == $delivery_row['gate_pass'] && $new_quantity == $delivery_row['quantity']){
			// update dr no and item only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no and item ".$item_psi_ext." to $new_item_no $new_psi_ext','$datetime','$office')";

		}else if($new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_item_no == $delivery_row['item_no'] && $new_gate_pass == $delivery_row['gate_pass'] && $new_quantity != $delivery_row['quantity']){
			// update dr no and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no and quantity to $new_quantity pcs','$datetime','$office')"; 

		}else if($new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_item_no == $delivery_row['item_no'] && $new_gate_pass != $delivery_row['gate_pass'] && $new_quantity == $delivery_row['quantity']){
			// update dr no and gate pass only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no and gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass','$datetime','$office')"; 

		}else if($new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no == $delivery_row['delivery_receipt_no'] && $new_gate_pass == $delivery_row['gate_pass'] && $new_quantity != $delivery_row['quantity']){
			// update item and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update ".$item_psi_ext." to $new_item_no $new_psi_ext and quantity to $new_quantity pcs under DR No. ".$delivery_row['delivery_receipt_no']."','$datetime','$office')";

		}else if($new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no == $delivery_row['delivery_receipt_no'] && $new_gate_pass != $delivery_row['gate_pass'] && $new_quantity == $delivery_row['quantity']){
			// update item and gate pass only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update ".$item_psi_ext." to $new_item_no $new_psi_ext and gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass under DR No. ".$delivery_row['delivery_receipt_no']."','$datetime','$office')";

		}else if($new_item_no == $delivery_row['item_no'] && $new_delivery_receipt_no == $delivery_row['delivery_receipt_no'] && $new_gate_pass != $delivery_row['gate_pass'] && $new_quantity != $delivery_row['quantity']){
			// update gatepass and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass and quantity of ".$item_psi_ext." to $new_quantity pcs under DR No. ".$delivery_row['delivery_receipt_no']."','$datetime','$office')";

		}else if($new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_gate_pass == $delivery_row['gate_pass'] && $new_quantity != $delivery_row['quantity']){
			// update dr no, item and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no, item ".$item_psi_ext." to $new_item_no $new_psi_ext and quantity to $new_quantity pcs','$datetime','$office')";

		}else if($new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_gate_pass != $delivery_row['gate_pass'] && $new_quantity == $delivery_row['quantity']){
			// update dr no, item and gate pass only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no, item ".$item_psi_ext." to $new_item_no $new_psi_ext and gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass','$datetime','$office')";

		}else if($new_item_no == $delivery_row['item_no'] && $new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_gate_pass != $delivery_row['gate_pass'] && $new_quantity != $delivery_row['quantity']){
			// update dr. quantity and gate pass only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no, quantity to $new_quantity pcs and gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass','$datetime','$office')";

		}else if($new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no == $delivery_row['delivery_receipt_no'] && $new_gate_pass != $delivery_row['gate_pass'] && $new_quantity != $delivery_row['quantity']){
			// update item, quantity and gate pass only
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update item ".$item_psi_ext." to $new_item_no $new_psi_ext, quantity to $new_quantity pcs and gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass under DR No. ".$delivery_row['delivery_receipt_no']."','$datetime','$office')";

		}else if($new_item_no != $delivery_row['item_no'] && $new_delivery_receipt_no != $delivery_row['delivery_receipt_no'] && $new_gate_pass != $delivery_row['gate_pass'] && $new_quantity != $delivery_row['quantity']){
			// update all fields
			$history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Delivery','Update Delivery Order' ,'$new_item_no','Update DR No. ".$delivery_row['delivery_receipt_no']." to $new_delivery_receipt_no, item ".$item_psi_ext." to $new_item_no $new_psi_ext, quantity to $new_quantity pcs and gate pass no. ".$delivery_row['gate_pass']." to $new_gate_pass','$datetime','$office')";

		}
		
		if(mysqli_query($db, $sql)){
			if(isset($history)){
				// echo $history;
				mysqli_query($db, $history);
				echo "<script>alert('Delivery No. has been updated'); window.location.href='plant_delivery_order.php'</script>";
				unset($_SESSION['post_delivery_id']);
			}else{
				echo "<script> alert('No changes has been made');window.location.href='plant_delivery_order.php'</script>";
				unset($_SESSION['post_delivery_id']);
			}
		}else{
			phpAlert('Something went wrong. Please try again.');
			echo "<meta http-equiv='refresh' content='0'>";
		}
	}


?>