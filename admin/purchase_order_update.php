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

	if(isset($_SESSION['post_purchase_id']) && isset($_SESSION['post_purchase_unique_id'])){
		$_SESSION['purchase_id'] = $_SESSION['post_purchase_id'];
        $_SESSION['purchase_unique_id'] = $_SESSION['post_purchase_unique_id'];
        // $_SESSION['office'] = $_SESSION['post_office'];
	}

	$user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
	$user_query->bind_param('s', $_SESSION['login_user']);
	$user_query->execute();
	$result = $user_query->get_result();
	$user = $result->fetch_assoc();

	$office = $user['office'];
	$position = $user['position'];

	$purchase_id = $_SESSION['purchase_id'];
    $purchase_unique_id = $_SESSION['purchase_unique_id'];

	$search_sql = "SELECT *, s.site_id, s.site_address FROM purchase_order p, site s 
					WHERE p.site_id = s.site_id
					AND p.purchase_id = '$purchase_id'";
	$search_result = mysqli_query($db, $search_sql);
	$purchase_row = mysqli_fetch_assoc($search_result);
    $search_plant = $purchase_row['office'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Purchase Order Update</title>

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

    // $(document).ready(function() {
        
    //     var button = document.getElementById('submit');
    //     var po_no = document.getElementById('update_po_no').value;
    //     var item_no = document.getElementById('update_item_no').value;
    //     var psi = document.getElementById('update_psi').value;
    //     var quantity = document.getElementById('update_quantity').value;
    //     alert(po_no + " " + item_no + " " + psi + " " + quantity);
    //     if(po_no == '' && item_no == '' && psi == '' && quantity == ''){
    //         button.disabled = 'true';
    //     }else{
    //         button.disabled = '';
    //     }
        
    // });

    function checkBalance(val){

        var balance = document.getElementById('hidden_balance').value;
        var quantity = document.getElementById('hidden_update_quantity').value;
        var button = document.getElementById('submit');
        var input = document.getElementById('update_quantity');
        var remaining = document.getElementById('balance');

        val = val.replace(",","");
        val = Number(val);

        quantity = quantity.replace(",","");
        quantity = Number(quantity);

        balance = balance.replace(",","");
        balance = Number(balance);

        new_quantity = quantity - val;
        new_value = balance - new_quantity;

        if(val == ''){
            new_value = balance;
        }

        if(new_value < 0 && val != ''){
            button.disabled = 'true';
            input.style.borderColor = 'red';
        }else if(new_value < 0 && val == ''){
            button.disabled = 'false';
            input.style.borderColor = '';
        }else{
            button.disabled = '';
            input.style.borderColor = '';
        }

        string_new_value = new_value.toLocaleString('en') + " pcs";
        if(new_value < 1350){
            remaining.innerHTML = string_new_value.bold().fontcolor("red");
                    
        }else{
            remaining.innerHTML = string_new_value.bold();
        }


    }

</script>
</head>
<body onload="checkBalance('<?php echo $purchase_row['quantity']; ?>');">
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
                            <span class="menu-arrow arrow_carrot-down"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="purchase_order.php?office=bravo">Purchase Order</a></li>                          
                            <li><a class="" href="delivery_order.php?office=bravo">Delivery Page</a></li>
                        </ul>
                    </li>  
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-building"></i>
                            <span>Delta</span>
                            <span class="menu-arrow arrow_carrot-down"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="purchase_order.php?office=delta">Purchase Order</a></li>                          
                         	<li><a class="" href="delivery_order.php?office=delta">Delivery Page</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-file"></i>
                            <span>Forms</span>
                            <span class="menu-arrow arrow_carrot-down"></span>
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
                    <div class="col-lg-12 page_links">
                        <!-- <h3 class="page-header"><i class="fa fa-building"></i> Purchase Order Update</h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo ucfirst($search_plant); ?></a></li>
                            <li><i class="icon_document"></i><a href="purchase_order.php">Pending P.O.</a></li>
                            <li><i class="icon_document"></i><a href="purchase_order_details.php">P.O. Details</a></li>
                            <li><i class="fa fa-file-text"></i>Update</li>					  	
                        </ol>
                    </div>
                </div>

                <!-- Basic Forms & Horizontal Forms-->
              
				<div class="row">
					<div class="col-md-6">
						<section class="panel">
							<header class="panel-heading">
							Purchase Order Details
							</header>
							<div class="panel-body">
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label for="update_po_no" class="col-md-3 control-label">P.O. No.</label>
										<div class="col-md-6">
                                            <p class="help-block"><strong><?php echo $purchase_row['purchase_order_no']; ?></strong></p>
										</div>
									</div>
                                    <div class="form-group">
                                        <label for="update_address" class="col-md-3 control-label">Site Name</label>
                                        <div class="col-md-8">
                                            <p class="help-block"><strong><?php echo $purchase_row['site_name']; ?></strong></p>
                                        </div>
                                    </div>
									<div class="form-group">
										<label for="update_address" class="col-md-3 control-label">Site Address</label>
										<div class="col-md-8">
                                            <p class="help-block"><strong><?php echo $purchase_row['site_address']; ?></strong></p>
										</div>
									</div>
									<div class="form-group">
										<label for="item_no" class="col-md-3 control-label">Current Item</label>
										<div class="col-md-6">
                                            <p class="help-block"><strong>
                                                <?php 
                                                    if($purchase_row['psi'] != ""){
                                                        echo $purchase_row['item_no'] . " (" . number_format($purchase_row['psi']) . " PSI)"; 
                                                    }else{
                                                        echo $purchase_row['item_no'];
                                                    }
                                                ?>
                                            </strong></p>
										</div>
									</div>
									<div class="form-group">
										<label for="quantity" class="col-md-3 control-label">Ordered Quantity</label>
										<div class="col-md-6">
                                            <p class="help-block"><strong><?php echo number_format($purchase_row['quantity']) . " pcs"; ?></strong></p>
										</div>
									</div>
								</form>
							</div>
						</section>
					</div>
                    <div class="col-md-6">
                        <section class="panel">
                            <header class="panel-heading">
                                Update
                            </header>
                            <form class="form-horizontal" role="form" id="form" action="purchase_order_update.php" method="post" onsubmit="return confirm('Proceed?');">
                                <div class="panel-body">

                                    <input type="hidden" id="hidden_po_no" name="hidden_po_no" value="<?php echo $purchase_row['purchase_order_no']; ?>">
                                    <input type="hidden" id="hidden_item_no" name="hidden_item_no" value="<?php echo $purchase_row['item_no']; ?>">
                                    <input type="hidden" id="hidden_psi" name="hidden_psi" value="<?php echo $purchase_row['psi']; ?>" >
                                    <input type="hidden" id="hidden_update_quantity" name="hidden_update_quantity" value="<?php echo number_format($purchase_row['quantity']); ?>">
                                    <input type="hidden" id="hidden_balance" name="hidden_balance" value="<?php echo number_format($purchase_row['balance']); ?>">

                                    <div class="form-group">
                                        <label for="update_po_no" class="col-md-4 control-label">New P.O. No.</label>
                                        <div class="col-md-4">
                                            <input type="text" id="update_po_no" name="update_po_no" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="update_item_no" class="col-md-4 control-label">New Item</label>
                                        <div class="col-md-4">
                                            <select id="update_item_no" name="update_item_no" class="form-control" style="width: 150px;">
                                                <option value="">Select</option>
<?php
    $sql = "SELECT item_no 
            FROM batch_list
            WHERE item_no NOT IN (SELECT item_no FROM purchase_order 
                                WHERE purchase_unique_id = '$purchase_unique_id')
            ORDER BY item_no ASC";
            echo $sql;
    $result = mysqli_query($db, $sql);
    foreach($result as $row){
                                    echo "<option value='" . $row['item_no'] . "'>" . $row['item_no'] . "</option>";
    }
?>                          
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="update_item_no" class="col-md-4 control-label">New PSI<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-4">
                                            <input type="text" id="update_psi" name="update_psi" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="update_quantity" class="col-md-4 control-label">New Ordered Quantity</label>
                                        <div class="col-md-4">
                                            <input type="text" id="update_quantity" name="update_quantity" class="form-control" autocomplete="off" onkeyup="checkBalance(this.value);">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="balance" class="col-md-4 control-label">New Remaining Balance</label>
                                        <div class="col-md-6">
                                            <!-- <p class="help-block"><strong><?php echo number_format($purchase_row['balance']) . " pcs" ?></strong></p> -->
                                            <p class="help-block" id="balance"></p> 

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-8 col-md-4">
                                            <input type="submit" name="submit" id="submit" value="Done" class="btn btn-primary" style="font-weight: bold;">
                                            <a href="purchase_order_details.php" class="btn btn-default"><strong>Cancel</strong></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <footer class="panel-footer">
                                Note: Leave input field blank if no changes.<br>
                                <span class="required" style="color: red;">*</span> - Put number '0' on PSI field to remove PSI value 
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

		$site_id = $purchase_row['site_id'];
        $datetime = date("Y/m/d H:i:s");
        $plant = ucfirst($purchase_row['office']);

        if($_POST['update_po_no'] != ''){
            $update_purchase_order_no = mysqli_real_escape_string($db, $_POST['update_po_no']);
        }else{
            $update_purchase_order_no = mysqli_real_escape_string($db, $_POST['hidden_po_no']);
        }

        if($_POST['update_psi'] != ''){
            if($_POST['update_psi'] == "0"){
                $update_psi = '';
            }else{
                $update_psi = mysqli_real_escape_string($db, $_POST['update_psi']);

            }
        }else{
            $update_psi = mysqli_real_escape_string($db, $_POST['hidden_psi']); 
        }

        if($_POST['update_quantity'] != ''){
            $_POST['update_quantity'] = mysqli_real_escape_string($db, $_POST['update_quantity']);
            $update_quantity = str_replace(",", "", $_POST['update_quantity']);
        }else{
            $_POST['hidden_update_quantity'] = mysqli_real_escape_string($db, $_POST['hidden_update_quantity']);
            $update_quantity = str_replace(",", "", $_POST['hidden_update_quantity']);
        }

		if($_POST['update_item_no'] != ''){
			$update_item_no = mysqli_real_escape_string($db, $_POST['update_item_no']);
		}else{
			$update_item_no = mysqli_real_escape_string($db, $_POST['hidden_item_no']);
		}

        if($update_psi != ''){
            if($_POST['update_psi'] != "0"){
                $psi_ext = "(".number_format($update_psi)." PSI)";
            }else{
                $psi_ext = "";
            }
        }else{
            $psi_ext = "";
        }

        if($purchase_row['psi'] != ''){
            $item_psi_ext = $purchase_row['item_no'] . " (" . number_format($purchase_row['psi']) . " PSI)";
        }else{
            $item_psi_ext = $purchase_row['item_no'];
        }

		if($update_quantity < $purchase_row['quantity']){

            if($update_quantity < $purchase_row['balance']){

                $update_quantity_balance = "UPDATE purchase_order 
                                            SET quantity = '$update_quantity', balance = '$update_quantity'
                                            WHERE purchase_id = '$purchase_id'";
            }else{

                $deducted_quantity = $purchase_row['quantity'] - $update_quantity;
                $new_balance = $purchase_row['balance'] - $deducted_quantity;
                $update_quantity_balance = "UPDATE purchase_order 
                                            SET quantity = '$update_quantity', balance = '$new_balance'
                                            WHERE purchase_id = '$purchase_id'";
            }
		}else{

            $deducted_quantity = $update_quantity - $purchase_row['quantity'];
            $new_balance = $deducted_quantity + $purchase_row['balance'];

			$update_quantity_balance = "UPDATE purchase_order 
                                        SET quantity = '$update_quantity', balance = '$new_balance'
										WHERE purchase_id = '$purchase_id'";
		} 

        $sql_po_update = "UPDATE purchase_order SET purchase_order_no = '$update_purchase_order_no' 
                            WHERE purchase_unique_id = '$purchase_unique_id'";

		$sql_update = "UPDATE purchase_order SET item_no = '$update_item_no', psi = '$update_psi'  
                        WHERE purchase_id = '$purchase_id'";

        $delivery_update = "UPDATE delivery SET po_no_delivery = '$update_purchase_order_no' WHERE fk_po_id = '$purchase_id'";

		if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no == $purchase_row['item_no'] && $update_quantity == $purchase_row['quantity']){
			// update po no only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 				VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no == $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity == $purchase_row['quantity']){
			// update item only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 				VALUES('Purchase Order','Update Purchase Order','Update $item_psi_ext to $update_item_no $psi_ext under P.O. No. ".$purchase_row['purchase_order_no']."','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no == $purchase_row['purchase_order_no'] && $update_item_no == $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update quantity only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 				VALUES('Purchase Order','Update Purchase Order','Update $item_psi_ext quantity from ".number_format($purchase_row['quantity'])." pcs to ".number_format($update_quantity)." pcs under P.O. No. ".$purchase_row['purchase_order_no']."','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity == $purchase_row['quantity']){
			// update po no and item only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 				VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no and item $item_psi_ext to $update_item_no $psi_ext','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no == $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update po no and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 				VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no and quantity for ".$purchase_row['item_no']." to ".number_format($update_quantity)." pcs','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no == $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update item and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 				VALUES('Purchase Order','Update Purchase Order','Update $item_psi_ext to $update_item_no $psi_ext and its quantity from ".number_format($purchase_row['quantity'])." pcs to ".number_format($update_quantity)." pcs under P.O. No. ".$purchase_row['purchase_order_no']."','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update all fields
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 				VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no, $item_psi_ext to $update_item_no $psi_ext and its quantity from ".number_format($purchase_row['quantity'])." pcs to ".number_format($update_quantity)." pcs','$datetime','".$purchase_row['office']."')";

		}
        // else if($update_purchase_order_no == $purchase_row['purchase_order_no'] && $update_item_no == $purchase_row['item_no'] && $update_quantity == $purchase_row['quantity'] && $update_psi == $purchase_row['psi']){
        //     echo "<script>alert('No changes has been made.'); window.location.href='purchase_order_details.php'</script>";
        // }

		// echo $sql_update."<br>";
		// echo $update_quantity_balance."<br>";
		// echo $history;
		if($_POST['update_po_no'] == '' && $_POST['update_item_no'] == '' && $_POST['update_psi'] == '' && $_POST['update_quantity'] == ''){
            
            echo "<script> alert('No changes has been made'); window.location.href='purchase_order_details.php?purchase_order_no=$update_purchase_order_no&office=$search_plant&purchase_unique_id=$purchase_unique_id'</script>";

        }else{

            if(mysqli_query($db, $sql_po_update) && mysqli_query($db, $sql_update) && mysqli_query($db, $update_quantity_balance) && mysqli_query($db, $delivery_update)){

                if(isset($history)){

                    mysqli_query($db, $history);
                    echo "<script>alert('P.O. No. $update_purchase_order_no details has been updated'); window.location.href='purchase_order_details.php?purchase_order_no=$update_purchase_order_no&office=$search_plant&purchase_unique_id=$purchase_unique_id'</script>";
                    unset($_SESSION['post_purchase_id']);
                }else{
                    // echo "<script> alert('No changes has been made');window.location.href='purchase_order.php'</script>";
                    echo "<script>alert('P.O. No. $update_purchase_order_no details has been updated'); window.location.href='purchase_order_details.php?purchase_order_no=$update_purchase_order_no&office=$search_plant&purchase_unique_id=$purchase_unique_id'</script>";
                    unset($_SESSION['post_purchase_id']);
                }
            }else{
                phpAlert('Something went wrong. Please try again.');
                // phpAlert("Error description: " . mysqli_error($db));
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
	}

?>