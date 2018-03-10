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

    <title>Diesel Form</title>

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
        var $input = $form.find( "#quantity_out" );

        $form.on( "keyup", "#quantity_out", function( event ) {
            
            
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
        var balance = Number(document.getElementById('stock').value);
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
                    <div class="col-md-12 page_links">
                        <!-- <h3 class="page-header"><i class="fa fa-home"></i> History</h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo $plant; ?></li>
                            <li><i class="icon_document"></i><a href="plant_diesel.php">Diesel</a></li>             
                            <li><i class="icon_document"></i><a href="plant_diesel_form.php" style="color: blue;">Diesel Form</a></li>             
                        </ol>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6 col-md-offset-3">
                		<form action="plant_diesel_form.php" method="post" id="form" name="form" class="form-horizontal" onsubmit="return confirm('Proceed?')">
                			<section class="panel">
	                			<header class="panel-heading">
	                				Details
	                			</header>
	                			<div class="panel-body">
                					<input type="hidden" id="stock" name="stock" value="<?php echo getStock($db, 'Diesel', $search_plant); ?>">
	                				<div class="form-group">
	                					<label for="quantity_out" class="col-md-4 control-label">Quantity (OUT)<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="quantity_out" name="quantity_out" class="form-control" onkeyup="compareValues(this.value);" required>
                                            <span class="help-block">Available Stock: <?php echo number_format(getStock($db, 'Diesel', $search_plant)) . " liters"; ?></span>
                                        </div>

	                				</div>
                                    <div class="form-group">
                                        <label for="destination" class="col-md-4 control-label">Destination<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="destination" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="truck_no" class="col-md-4 control-label">Truck No.<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="truck_no" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="operator" class="col-md-4 control-label">Operator / Driver<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="operator" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-10">
                                            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" style="font-weight: bold;">
                                            <a href="plant_diesel.php" class="btn btn-warning"><strong>Cancel</strong></a>
                                        </div>
                                    </div>
	                			</div>
                                <footer class="panel-footer">
                                    <p class="help-block"><span class="required" style="color: red;">*</span> - required</p>
                                </footer>
	                		</section>
                		</form>
                	</div>
                </div>	
            </section>
        </section>
    </section>
</body>
</html>
<?php

    if(isset($_POST['submit'])){

        $liter = mysqli_real_escape_string($db, $_POST['quantity_out']);
        $destination = mysqli_real_escape_string($db, $_POST['destination']);
        $truck = mysqli_real_escape_string($db, $_POST['truck_no']);
        $operator = mysqli_real_escape_string($db, $_POST['operator']);
        $datetime = date("Y-m-d H:i:s");
        
        // $stock = "SELECT stock FROM item_stock WHERE item_no = 'Diesel' AND office = '$office'";
        // $result = mysqli_query($db, $stock);
        // $row = mysqli_fetch_assoc($result);  

        $diesel_update = "UPDATE item_stock SET stock = stock - '$liter', last_update = '$datetime' WHERE item_no = 'Diesel' AND office = '$office'";
        
        if(mysqli_query($db, $diesel_update)){  

            $stock = getStock($db, 'Diesel', $office);

            $query = "INSERT INTO diesel(office, quantity_out, balance, destination, truck_no, operator, delivery_date)
                    VALUES ('$office','$liter','".$stock."','$destination','$truck','$operator','$datetime')";

            $history = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Diesel','Delivered','Diesel','Truck no. $truck operated by $operator delivered $liter liters of diesel to $destination','$datetime', '".ucfirst($office)."')";

            if(mysqli_query($db, $query) && mysqli_query($db, $history)){
                phpAlert("Transaction complete!!");
                echo "<meta http-equiv='refresh' content='0'>";
            }else{
                phpAlert('Something went wrong. Please try again.');
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }else{
            phpAlert('Something went wrong. Please try again.');
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
?>