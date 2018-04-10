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

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Purchase Order Aggregates Form</title>

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
        var $input = $form.find( "#quantity, #price" );

        $form.on( "keyup", "#quantity, #price", function( event ) {
            
            
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
</head>
<body>
    
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
                            <li><a class="" href="purchase_aggregates_order.php?office=bravo">P.O. Aggregates</a></li>                          
                            <li><a class="" href="delivery_order.php?office=bravo">Delivery Page</a></li>
                            <li><a class="" href="received.php?office=bravo">Received Aggregates</a></li>
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
                            <li><a class="" href="purchase_aggregates_order.php?office=delta">P.O. Aggregates</a></li>                          
                            <li><a class="" href="delivery_order.php?office=delta">Delivery Page</a></li>
                            <li><a class="" href="received.php?office=delta">Received Aggregates</a></li>
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
                            <li><a class="" href="purchase_aggregates_order_form.php">Add New P.O. Aggregates</a></li>                        
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
                    <div class="col-md-12">
                        <!-- <h3 class="page-header"><i class="icon_document"></i> Purchase Order Form</h3> -->
                        <ol class="breadcrumb">
                            <!-- <li><i class="fa fa-building"></i>Home</a></li> -->
                            <li><i class="icon_document"></i>P.O. Aggregates Form</li>                           
                        </ol>
                    </div>
                </div>
                <!-- Basic Forms & Horizontal Forms-->
                <form class="form-horizontal" role="form" action="purchase_aggregates_order_form.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
                    <div class="row">
                        <div class="col-md-6">
                            <section class="panel">
                                <header class="panel-heading">
                                Issue Form
                                </header>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="plant" class="col-md-4 control-label">Plant<span class="required" style="color: red;">*</span></label>
                                        <div class="col-lg-8">
                                            <label class="radio-inline">
                                                <input type="radio" id="plant" name="plant" value="bravo" required> Bravo
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="plant" name="plant" value="delta"> Delta
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="po_no" class="col-md-4 control-label">P.O. No.<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="po_no" name="po_no" class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="client" class="col-md-4 control-label">Supplier Name<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="supplier" name="supplier" class="form-control" autocomplete="off" required>
                                            <!-- <select id="client" name="client" class="form-control" style="width: 100%;" onchange="siteName(this.value);" required>
                                                <option value="">Select</option>
<?php
    $sql = "SELECT client_name, client_id FROM client GROUP BY client_name ORDER BY client_name ASC";
    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='".$row['client_id']."'>".$row['client_name']."</option>";
    }
?>
                                            </select> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-8 col-md-4">
                                            <input type="submit" name="submit" id="submit" value="Done" class="btn btn-primary" style="font-weight: bold;">
                                            <!-- <a href="delivery_transaction.php" class="btn btn-warning">Cancel</a> -->
                                            <input type="reset" name="reset" id="reset" value="Reset" onclick="window.location.reload(true);" class="btn btn-default" style="font-weight: bold;">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-6">
                            <section class="panel">
                                <header class="panel-heading">
                                Items
                                </header>
                                <div class="panel-body">
                                    <div class="row" style="margin: 5px;">
                                        <table id="item_table" align="center">
                                            <tr>
                                                <td class="col-md-1">
                                                    <label for="item_no">Item<span class="required" style="color: red;">*</span></label>
                                                </td>
                                                <td class="col-md-1">
                                                    <label for="quantity">Quantity<span class="required" style="color: red;">*</span></label>
                                                </td>
                                                <td class="col-md-1">
                                                    <label for="Price">Price<span class="required" style="color: red;">*</span></label>
                                                </td>
                                            </tr>
                                            <tr id="row1" style="text-align: center;">
                                                <td class="col-md-1">
                                                    <div class="form-group">
                                                        <select id="item_no" name="item_no" class="form-control" required>
                                                            <option value="">Select</option>
<?php 
    $sql = "SELECT DISTINCT item_no FROM item_list WHERE item_no NOT IN (SELECT item_no FROM batch_list)";
    $result = mysqli_query($db, $sql);
?>
                                                            <?php foreach($result as $row){
                                                                echo "<option value='" . $row['item_no'] . "'>" . $row['item_no'] . "</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="text" id="quantity" name="quantity" class="form-control" autocomplete="off" placeholder="Quantity" required>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="text" id="price" name="price" class="form-control" autocomplete="off" placeholder="Price">
                                                    </div>
                                                </td>
                                                <!-- <td class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="button" onclick="add_row();" class='btn btn-primary btn-md' autocomplete="off" value="Add">
                                                    </div>
                                                </td> -->
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <footer class="panel-footer">
                                    <p class="help-block"><span class="required" style="color: red;">*</span> - required</p>
                                </footer>
                            </section>
                        </div>
                    </div>
                </form>
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

        $po_no = mysqli_real_escape_string($db, $_POST['po_no']);
        $item = mysqli_real_escape_string($db, $_POST['item_no']);
        $quantity = str_replace( ',', '', mysqli_real_escape_string($db, $_POST['quantity']) );
        $price = str_replace( ',', '', mysqli_real_escape_string($db, $_POST['price']) );
        $received = 0;
        $plant = mysqli_real_escape_string($db, $_POST['plant']);
        $supplier = mysqli_real_escape_string($db, $_POST['supplier']);
        $datetime = date("Y/m/d H:i:s");
        // $pending = "Pending";
        // $table = "Purchase Order Aggregates";
        // $transaction = "Issued P.O. No.";
        // $sentence = "Head Office ordered $quantity ".getTruck($db,$item)." of $item to $supplier with P.O no. $po_no for $plant";

        $query = "INSERT INTO purchase_order_aggregates(item_no, quantity, received, price, office, date_po_aggregates, supplier_name, purchase_order_aggregates_no, remarks)
                    VALUES ('$item','$quantity','0','$price','$plant','$datetime','$supplier','$po_no','Pending')";

        $history_query = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) 
                            VALUES('Purchase Order Aggregates','Issued P.O. No.','$item','Head Office ordered ".number_format($quantity)." ".getTruck($db,$item)." of $item to $supplier with P.O No. $po_no','$datetime','$plant')";
        // echo $query . "<br>";
        // echo $history_query . "<br>";

        // $query = $db->prepare("INSERT INTO purchase_order_aggregates(item_no, quantity, received, price, office, date_po_aggregates, supplier_name, purchase_order_aggregates_no, remarks) VALUES(?,?,?,?,?,?,?,?,?)");
        // $query->bind_param('ssissssss',$item,$quantity,$received,$price,$plant,$datetime,$supplier,$po_no,$pending);
        // $query->execute();

        // $history_query = $db->prepare("INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES(?,?,?,?,?,?)");
        // $history_query->bind_param('ssssss',$table,$transaction,$item,$sentence,$datetime,$plant);
        // $history_query->execute();

        if(mysqli_query($db,$query) && mysqli_query($db,$history_query)){
            phpAlert("Order completed!!");
            echo "<meta http-equiv='refresh' content='0'>";
        }else{
            phpAlert("Something went wrong!!");
        }
    }

?>