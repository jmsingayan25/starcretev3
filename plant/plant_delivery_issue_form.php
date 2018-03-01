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

    if(isset($_REQUEST['post_delivery_purchase_id'])){
		$_SESSION['delivery_purchase_id'] = $_REQUEST['post_delivery_purchase_id'];
	}

	$user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
	$user_query->bind_param('s', $_SESSION['login_user']);
	$user_query->execute();
	$result = $user_query->get_result();
	$user = $result->fetch_assoc();

	$office = $user['office'];
	$position = $user['position'];

	$purchase_id = $_SESSION['delivery_purchase_id'];
	$search_sql = "SELECT *, s.site_id, s.site_name, s.site_address, c.site_contact_person_id
					FROM purchase_order p, site s, site_contact_person c 
					WHERE p.site_id = s.site_id 
					AND s.site_id = c.site_id
					AND purchase_id = '$purchase_id'";

	$search_result = mysqli_query($db, $search_sql);
	$purchase_row = mysqli_fetch_assoc($search_result);

	$dr_query = "SELECT delivery_receipt_no
					FROM delivery
					WHERE office = '$office'";

	$array = array();
	$dr_result = mysqli_query($db, $dr_query);
	while ($row = mysqli_fetch_assoc($dr_result)) {
		$array[] = $row['delivery_receipt_no'];
	}

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
        var $input = $form.find( "#quantity" );

        $form.on( "keyup", "#quantity", function( event ) {
            
            
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


	function compareValues(input) {
		
		var number = input.replace(",","");
        number = Number(number);
		var balance = Number(document.getElementById('hidden_quantity').value);
		var submit = document.getElementById('submit');
		// var letters = /^[0-9a-zA-Z]+$/; 

		setTimeout(function () {
			if(number > balance || number <= 0){
				submit.disabled = true;
				// a.style.display = "block";
			}else{
				submit.disabled = false;
				// a.style.display = "none";
			}
		}, 0);
		// alert(ordered);
	}


	function existDRNo(value){

		var array_dr_no = <?php echo json_encode($array); ?>;
		var number = Number(value);
		var submit = document.getElementById('submit');
		var block = document.getElementById('dr_warning');
		var input = document.getElementById('dr_no');

		if(array_dr_no.indexOf(value) >= 0){
			// submit.disabled = true;
			block.style.display = "block";
			input.style.borderColor = "red";

		}else{
			// submit.disabled = false;
			block.style.display = "none";
			input.style.borderColor = '';
		}
	}

</script>
<style>
.page_links a{
    color: inherit;
}
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
	                    <!-- <h3 class="page-header"><i class="fa fa-file"></i><a href="plant_delivery_issue_form.php">Issue Form</a></h3> -->
	                    <ol class="breadcrumb">
	                        <li><i class="fa fa-building"></i>Delivery Order</li>
	                        <li><i class="fa fa-exclamation-circle"></i><a href="plant_delivery_issue.php">Existing P.O.</a></li>	
	                        <li><i class="fa fa-file"></i><a href="plant_delivery_issue_form.php" style="color: blue;">Issue Form</a></li>						  	
	                    </ol>
	                </div>
	            </div>

	            <!-- Basic Forms & Horizontal Forms-->
              
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<section class="panel">
							<header class="panel-heading">
							Issue Form
							</header>
							<div class="panel-body">
								<form class="form-horizontal" role="form" id="form" action="plant_delivery_issue_form.php" method="post" onsubmit="return confirm('Proceed?');">
									<input type="hidden" id="hidden_quantity" value="<?php echo $purchase_row['balance'] ?>">
									<div class="form-group">
										<label for="po_no" class="col-md-3 control-label">P.O. No.</label>
										<div class="col-md-6">
                                            <p class="help-block"><?php echo $purchase_row['purchase_order_no']; ?> </p>
										</div>
									</div>
									<div class="form-group">
										<label for="item_no" class="col-md-3 control-label">Item No.</label>
										<div class="col-md-6">
                                            <p class="help-block">
                                            	<?php 
                                            		if($purchase_row['psi'] != ""){
                                            			echo $purchase_row['item_no'] . " (" . $purchase_row['psi'] . " PSI)"; 
                                            		}else{
                                            			echo $purchase_row['item_no'];
                                            		}
                                            		
                                            	?> </p>
										</div>
									</div>
									<div class="form-group">
										<label for="dr_no" class="col-md-3 control-label">DR No.<span class="required" style="color: red;">*</span></label>
										<div class="col-md-6">
											<input type="text" id="dr_no" name="dr_no" class="form-control" onblur="existDRNo(this.value);" autocomplete="off" required>
											<!-- <p class="help-block" id="dr_warning" style="display: none;">DR No. already exist</p> -->
											<!-- <div class="isa_warning" id="dr_warning" style="color: #9F6000; background-color: #FEEFB3; display: none;">
								     			<i class="fa fa-warning"></i>
								     				DR No. already exist
											</div> -->
											<div id="dr_warning" style="display: none; color: red;">
										    	<strong>Warning!</strong> DR No. already exist
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="dr_no" class="col-md-3 control-label">Quantity<span class="required" style="color: red;">*</span></label>
										<div class="col-md-6">
											<input type="text" id="quantity" name="quantity" class="class_quantity form-control" autocomplete="off" placeholder="Pieces to be delivered" onkeyup="compareValues(this.value)" required>
											<p class="help-block">Balance: <?php echo number_format((float)$purchase_row['balance'])." pcs"; ?></p>
										</div>
									</div>
									<div class="form-group">
										<label for="gate_pass_no" class="col-md-3 control-label">Gate Pass<span class="required" style="color: red;">*</span></label>
										<div class="col-md-6">
											<input type="text" id="gate_pass_no" name="gate_pass_no" class="form-control" autocomplete="off" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2 col-md-10">
											<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
											<a href="plant_delivery_issue.php" class="btn btn-warning">Cancel</a>
										</div>
									</div>
								</form>
							</div>
                            <footer class="panel-footer">
                                <p class="help-block"><span class="required" style="color: red;">*</span> - required</p>
                            </footer>
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

		// $client = getClientInfo($db, $purchase_row['site_name'], $purchase_row['address']);
		$_POST['quantity'] = mysqli_real_escape_string($db, $_POST['quantity']);
		$site_name = $purchase_row['site_name'];
		$delivery_no = mysqli_real_escape_string($db, $_POST['dr_no']);
		$item_no = $purchase_row['item_no'];
        $psi = $purchase_row['psi'];
		$quantity = str_replace( ',', '', $_POST['quantity']);
		$site_id = $purchase_row['site_id'];
		$contact = $purchase_row['site_contact_person_id'];
		$contact_no = $purchase_row['contact_no'];
		$gate_pass_no = mysqli_real_escape_string($db, $_POST['gate_pass_no']);
		$po_no = $purchase_row['purchase_order_no'];
		$datetime = date("Y/m/d H:i:s");
		$plant = ucfirst($purchase_row['office']);

		if($psi != ""){
			$ext = "($psi PSI)";
		}else{
			$ext = "";
		}

		$delivery_insert = "INSERT INTO delivery(delivery_receipt_no, item_no, psi, quantity, site_id, gate_pass, po_no_delivery, date_delivery, office, remarks, fk_po_id) 
							VALUES('$delivery_no','$item_no', '$psi','$quantity','$site_id','$gate_pass_no','$po_no','$datetime','$office','On Delivery','$purchase_id')";

		$history_query = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Delivery','Issued DR No.','Issued DR No. $delivery_no with P.O. No. $po_no and ".$_POST['quantity']." pcs of $item_no $ext and ready to deliver to $site_name','$datetime','$office')";

		$purchase_order_update = "UPDATE purchase_order SET balance = balance - '$quantity'
									WHERE purchase_id = '$purchase_id'";

		// echo $delivery_insert."<br>";
		// echo $history_query."<br>";
		// echo $purchase_order_update."<br>";

		if(!in_array($delivery_no, $array)){
			// echo "NOT EXISTS";
			if(mysqli_query($db, $delivery_insert) && mysqli_query($db, $history_query) && mysqli_query($db, $purchase_order_update)){
				echo "<script> alert('DR No. $delivery_no issued successfully. Transaction can be viewed on Delivery Report Page');
					window.location.href='plant_delivery_order.php'
					</script>";
			}else{
				phpAlert('Something went wrong. Please try again.');
				echo "<meta http-equiv='refresh' content='0'>";
			}
		}else{
			// echo "EXISTS";
			phpAlert("DR No. already exists!!");
			echo "<meta http-equiv='refresh' content='0'>";
		}	

		// $reply = array('post' => $_POST, 'row' => $purchase_row);
		// echo json_encode($reply);
	}

?>