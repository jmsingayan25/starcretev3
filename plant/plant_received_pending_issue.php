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

    if(isset($_REQUEST['post_purchase_order_aggregates_id'])){
        $_SESSION['post_purchase_order_aggregates_id'] = $_REQUEST['post_purchase_order_aggregates_id'];
    }

    if(!isset($_GET['page']) || $_GET['page'] == ''){
        $_GET['page'] = 0;
    }

    if(!isset($_GET['view_count'])){
        $limit = 25;
    }else{
        $limit = $_GET['view_count'];
    }

    if(!isset($_GET['search'])){
        $_GET['search'] = '';
    }

    if(!isset($_GET['start_date'])){
        $_GET['start_date'] = '';
    }

    if(!isset($_GET['end_date'])){
        $_GET['end_date'] = '';
    }

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];
    // $limit = 20; //how many items to show per page
    $search_plant = $office;
    $po_aggregates_id = $_SESSION['post_purchase_order_aggregates_id'];

    $agg = getPurchaseOrderAggDetails($db, $po_aggregates_id);
    $item = $agg['item_no'];
    $quantity = $agg['quantity'];
    $price = $agg['price'];
    $date = $agg['date_po_aggregates'];
    $supplier = $agg['supplier_name'];
    $purchase_order_aggregates_no = $agg['purchase_order_aggregates_no'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Received Deliveries</title>

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
        var $input = $form.find( "#volume" );

        $form.on( "keyup", "#volume", function( event ) {
            
            
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
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="fa fa-building"></i>
                            <span>Received</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="plant_received_pending.php">Pending Deliveries</a></li>
                            <li><a class="" href="plant_received.php">Received Deliveries</a></li>                        
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
                        <!-- <h3 class="page-header"><i class="icon_document"></i><a href="plant_purchase_order.php"> Purchase Order</a></h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i>Received</li>
                            <li><i class="icon_document"></i><a href="plant_received_pending.php">Pending Deliveries</a></li>            
                            <li><i class="icon_document"></i><a href="plant_received_pending_issue.php" style="color: blue;"> Issue DR. No.</a></li>              
                        </ol>
                    </div>
                </div>

                <form class="form-horizontal" role="form" action="plant_received_pending_issue.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <section class="panel">
                                <header class="panel-heading">
                                Form
                                </header>
                                <div class="panel-body">
                                    <input type="hidden" id="hidden_quantity" value="<?php echo $quantity; ?>">
                                    <div class="form-group">
                                        <label for="po_no" class="col-md-3 control-label">P.O. No.</label>
                                        <div class="col-md-6">
                                            <!-- <input type="text" name="update_delivery_receipt_no" value="<?php echo $delivery_row['po_no_delivery'] ?>" class="form-control" readonly> -->
                                            <p class="help-block"><?php echo $purchase_order_aggregates_no; ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="item_no" class="col-md-3 control-label">Item</label>
                                        <div class="col-md-6">
                                            <!-- <input type="text" name="update_delivery_receipt_no" value="<?php echo $delivery_row['po_no_delivery'] ?>" class="form-control" readonly> -->
                                            <p class="help-block"><?php echo $item; ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="dr_no" class="col-md-3 control-label">Delivery No.</label>
                                        <div class="col-md-6">
                                            <input type="text" name="dr_no" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="volume" class="col-md-3 control-label">
                                            Received quantity (<?php 
                                                        if(getUnit($db, $item) == 'm3'){
                                                            echo "m&sup3;";
                                                        }else{
                                                            echo getUnit($db, $item);
                                                        }
                            
                                                        if(getTruck($db, $item) == 'liter'){
                                                            echo "";
                                                        }else{
                                                            echo " per ". getTruck($db, $item); 
                                                        } 
                                                        ?>)</label>
                                        <div class="col-md-6">
                                            <input type="text" id="volume" name="volume" class="form-control" onkeyup="compareValues(this.value);">
                                            <span class="help-block">
                                                Balance: 
                                                <?php echo number_format($quantity) . " "; 
                            
                                                    if(getTruck($db, $item) == 'liter'){
                                                        echo "";
                                                    }else{
                                                        echo getTruck($db, $item); 
                                                    } 
                                                ?>
                                                    
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="truck_no" class="col-md-3 control-label">Truck No.</label>
                                        <div class="col-md-6">
                                            <input type="text" name="truck_no" class="form-control">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="supplier_name" class="col-md-3 control-label">Supplier Name</label>
                                        <div class="col-md-6">
                                            <!-- <input type="text" name="truck_no" class="form-control"> -->
                                            <p class="help-block"><?php echo $supplier; ?></p>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-md-offset-2">
                                            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
                                            <a href="plant_delivery_order.php" class="btn btn-warning">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </form>
            </section>
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
</body>
</html>
<?php 

    if(isset($_POST['submit'])){

        $dr_no = mysqli_real_escape_string($db, $_POST['dr_no']);
        $truck_no = mysqli_real_escape_string($db, $_POST['truck_no']);

        if($item == 'Diesel'){
            $balance = mysqli_real_escape_string($db, $_POST['volume']);
        }else{
            $balance = 1;
        }
        $volume = mysqli_real_escape_string($db, $_POST['volume']);
        $datetime = date("Y-m-d H:i:s");

        $query_received = "INSERT INTO received(po_aggregates_no_received, item_no, delivery_no_received, truck_no, volume, office, supplier_name, date_po_aggregates, remarks)
                            VALUES ('$purchase_order_aggregates_no','$item','$dr_no','$truck_no','$volume','$office','$supplier','$datetime','Received')";

        if($item == 'Diesel'){
            if(getPurchaseAggQuantity($db, $purchase_order_aggregates_no, $item, $office, $po_aggregates_id) > 0){
                $po_aggregates_query = "UPDATE purchase_order_aggregates 
                                        SET received = received + '$balance', quantity = quantity - $balance
                                        WHERE purchase_order_aggregates_id = '".$po_aggregates_id."'";
                echo $po_aggregates_query . "<br>";
                // mysqli_query($db, $po_aggregates_query);
            }

            if(getPurchaseAggQuantity($db, $purchase_order_aggregates_no, $item, $office, $po_aggregates_id) == 0){
                $success = "UPDATE purchase_order_aggregates 
                            SET remarks = 'Success'
                            WHERE item_no = '$item' 
                            AND office = '$office'
                            AND purchase_order_aggregates_no = '$purchase_order_aggregates_no' 
                            AND purchase_order_aggregates_id = '".$po_aggregates_id."'";
                echo $success . "<br>";
                // mysqli_query($db, $success);
            }

            $diesel_query = "SELECT item_no FROM item_stock WHERE item_no = '$item' AND office = '$office'";
            if(mysqli_num_rows($result) > 0){
                $stock = "UPDATE item_stock SET stock = stock + '$balance', last_update = '$datetime' 
                            WHERE item_no = '$item' AND office = '$office'";
            }else{
                $stock = "INSERT INTO item_stock(item_no, stock, office, last_update) 
                            VALUES('$item','$balance','$office','$datetime')";
            }
            // mysqli_query($db, $stock);

            $insert_diesel = "INSERT INTO diesel(office, quantity_in, balance, truck_no, operator, delivery_date)
                                VALUES('$office','$balance','".getStock($db, $item, $office)."','$truck_no','$supplier','$datetime')";

            $history_query = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) 
                        VALUES('Received','Received ','$item','".ucfirst($office)." received $balance ".getTruck($db, $item)." of $item from $supplier with P.O no. $purchase_order_aggregates_no and DR. no. $dr_no','$datetime','$office')";

            echo $stock . "<br>";
            echo $query_received . "<br>";
            echo $insert_diesel . "<br>";
            echo $history_query . "<br>";

            // if(mysqli_query($db, $query_received) && mysqli_query($db, $insert_diesel) && mysqli_query($db, $history_query)){
            //     phpAlert("Item received successfully!!");
            //     echo "<meta http-equiv='refresh' content='0'>";
            // }else{
            //     phpAlert("Something went wrong!!");
            // }
        }else{

            $po_aggregates_query = "UPDATE purchase_order_aggregates 
                                    SET received = received + '$balance', quantity = quantity - '$balance' 
                                    WHERE purchase_order_aggregates_id = '$po_aggregates_id'
                                    AND office = '$office'";
            // mysqli_query($db, $po_aggregates_query);

            if(getPurchaseAggQuantity($db, $purchase_order_aggregates_no, $item, $office, $po_aggregates_id) == 0){
                $po_aggregates_status = "UPDATE purchase_order_aggregates 
                                        SET remarks = 'Success'
                                        WHERE item_no = '$item' 
                                        AND purchase_order_aggregates_no = '$purchase_order_aggregates_no'
                                        AND purchase_order_aggregates_id = '$po_aggregates_id'
                                        AND office = '$office'";
                                        echo $po_aggregates_status;
                // mysqli_query($db, $po_aggregates_status);
            }

            if($item == 'Cement'){

                $sql = "SELECT item_no, stock FROM item_stock
                        WHERE item_no = 'Cement' AND office = '$office'";
                $cement = $volume * 40;
                $result = mysqli_query($db, $sql);
                if(mysqli_num_rows($result) > 0){
                    $stock_update = "UPDATE item_stock SET stock = stock + '$cement', last_update = '$datetime' 
                                        WHERE item_no = 'Cement' AND office = '$office'";
                }else{
                    $stock_update = "INSERT INTO item_stock(item_no, stock, office, last_update) 
                                    VALUES('Cement','$cement','$office','$datetime')";
                }
                echo $stock_update;
                // mysqli_query($db, $stock_update);   
            }

            $history_query = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) 
                            VALUES('Received','Received DR No.','$item','".ucfirst($office)." received $balance ".getTruck($db, $item)." of $item from $supplier with P.O no. $purchase_order_aggregates_no and DR. no. $dr_no','$datetime','$office')";

            echo $query_received ."<br>";                
            echo $po_aggregates_query ."<br>";
            echo $stock_update ."<br>";
            echo $history_query ."<br>";


            // if(mysqli_query($db, $query_received) && mysqli_query($db, $history_query)){
            //     phpAlert("Item received successfully!!");
            //     echo "<meta http-equiv='refresh' content='0'>";
            // }else{
            //     phpAlert("Something went wrong!!");
            // }
        }
    }


?>