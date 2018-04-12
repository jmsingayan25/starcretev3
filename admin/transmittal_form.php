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

    <title>Transfer Form - Transmittal</title>

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

    function add_row(){
        // $count = $count + 1;                      
        $rowno=$("#item_table tr").length;
        $rowno=$rowno+1;
        $("#item_table tr:last").after("<tr id='row"+$rowno+"' style='text-align: center;'><td class='col-md-1'><div class='form-group'><input type='text' id='item_no' name='item_no[]' class='form-control' autocomplete='off' placeholder='Item'></div></td><td class='col-md-1'> <div class='form-group'> <input type='text' id='quantity' name='quantity[]' class='form-control' autocomplete='off' placeholder='Quantity' required></div> </td><td class='col-md-1'><div class='form-group'><input type='text' id='purpose' name='purpose[]' class='form-control' autocomplete='off' placeholder='Purpose'> </div></td><td class='col-md-1'><div class='form-group'><input type='button' value='Remove' class='btn btn-danger btn-md' onclick=delete_row('row"+$rowno+"') style='font-weight: bold;'></div></td></tr>");
    }

    function delete_row(rowno){
     $('#'+rowno).remove();
    }
</script>
<style>
.page_links a{
    color: inherit;
}    
</style>
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
                            <i class="fa fa-building"></i>
                            <span>Transmittal</span>
                            <span class="menu-arrow arrow_carrot-down"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="transmittal.php">Received Item</a></li>                          
                            <li><a class="" href="transmittal_transfer.php">Transferred Item</a></li>
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
                    <div class="col-md-12 page_links">
                        <!-- <h3 class="page-header"><i class="icon_document"></i> Purchase Order Form</h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><a href="transmittal.php">Transmittal</a></li>
                            <li><i class="icon_document"></i><a href="transmittal_form.php" style="color: blue;">Transfer Form</a></li>                           
                        </ol>
                    </div>
                </div>
                <!-- Basic Forms & Horizontal Forms-->
                <form class="form-horizontal" role="form" action="transmittal_form.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
                    <div class="row">
                        <div class="col-md-6">
                            <section class="panel">
                                <header class="panel-heading">
                                Transfer Form
                                </header>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="plant" class="col-md-4 control-label">Plant<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <label class="radio-inline">
                                                <input type="radio" id="plant" name="plant" value="bravo" required> Bravo
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" id="plant" name="plant" value="delta"> Delta
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="transmittal_no" class="col-md-4 control-label">Transmittal No.<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="transmittal_no" name="transmittal_no" class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="delivered_by" class="col-md-4 control-label">Delivered by<span class="required" style="color: red;">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="delivered_by" name="delivered_by" class="form-control" autocomplete="off" required>
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
                                                    <label for="purpose">Purpose<span class="required" style="color: red;">*</span></label>
                                                </td>
                                            </tr>
                                            <tr id="row1" style="text-align: center;">
                                                <td class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="text" id="item_no" name="item_no[]" class="form-control" autocomplete="off" placeholder="Item">
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="text" id="quantity" name="quantity[]" class="form-control" autocomplete="off" placeholder="Quantity" required>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="text" id="purpose" name="purpose[]" class="form-control" autocomplete="off" placeholder="Purpose">
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="button" onclick="add_row();" class='btn btn-primary btn-md' autocomplete="off" value="Add" style="font-weight: bold;">
                                                    </div>
                                                </td>
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


        $max = "SELECT MAX(transmittal_unique_id) as id
                FROM transmittal";

        $max_result = mysqli_query($db, $max);
        if(mysqli_num_rows($max_result) > 0){
            $row = mysqli_fetch_assoc($max_result);
            $transmittal_unique_id = $row['id'] + 1;
        }else{
            $transmittal_unique_id = 1;
        }
        $transmittal_no = mysqli_real_escape_string($db, $_POST['transmittal_no']);
        $plant = mysqli_real_escape_string($db, $_POST['plant']);
        $from_office = $office;
        $item = $_POST['item_no'];
        $quantity = str_replace(",", "", $_POST['quantity']);
        $purpose = $_POST['purpose'];
        $delivered_by = mysqli_real_escape_string($db, $_POST['delivered_by']);
        $datetime = date("Y/m/d H:i:s");

        $count = 0;
        for($i = 0; $i < count($item); $i++){
            if($item[$i] != "" && $quantity[$i] != ""){
                $sql = "INSERT INTO transmittal(transmittal_no, transmittal_unique_id, office, from_office, item_no, quantity, purpose, delivered_by, transmittal_date, remarks) VALUES('$transmittal_no','$transmittal_unique_id','$plant','$from_office','$item[$i]','$quantity[$i]','$purpose[$i]','$delivered_by','$datetime','Pending')";

                
                if(mysqli_query($db, $sql)){
                    $count++;
                }
            }

            if($i == 0){
                $item_ext = number_format($quantity[$i])." of $item[$i]";
            }else if($i == (count($item) - 1)){
                $item_ext .= " and ".number_format($quantity[$i])." of $item[$i]";
            }else{
                $item_ext .= ", ".number_format($quantity[$i])." of $item[$i]";
            }
        }

        if($from_office == "head"){
            $from_office = "Head Office";
        }

        $history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office)
                            VALUES('Transmittal','Transfer Item','$delivered_by from ".ucfirst($from_office)." delivered $item_ext to ".ucfirst($plant)."','$datetime','$plant')";

        // echo $history . "<br>";

        if($count == count($item)){
            mysqli_query($db, $history);
            phpAlert("Transaction complete. You can view the items on Transmittal page.");
            echo "<meta http-equiv='refresh' content='0'>";
        }else{
            phpAlert('Something went wrong. Please try again.');
        }
    }



?>