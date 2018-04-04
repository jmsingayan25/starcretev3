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

    if(isset($_REQUEST['office'])){
        $_SESSION['plant'] = $_REQUEST['office'];
    }

    if(!isset($_GET['radio_report'])){
        $_GET['radio_report'] = "total_cement";
    }
    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];
    $search_plant = $_SESSION['plant'];
    $plant = ucfirst($_SESSION['plant']);
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

    function reportOption(str) {
        if (str == "") {
            
            var hide_office = document.getElementById("hidden_office").value;

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("report_result").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","ajax/list_batch_report.php?radio_option=total_cement&office="+hide_office,true);
            xmlhttp.send();

        } else { 

            var hide_office = document.getElementById("hidden_office").value;

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("report_result").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","ajax/list_batch_report.php?radio_option="+str+"&office="+hide_office,true);
            xmlhttp.send();
        }
    }

    // $(document).ready(function(){

    //     var option = $('#radio_report').val();
    //     $.ajax({
    //         url: 'ajax/list_batch_report.php',
    //         method: get,
    //         data:{
    //             'radio_option' : option
    //         },
    //         success: function(response){
    //             $('#report_result').html(response);     // it will update the html of table body
    //         }
    //     });
    // });

</script>
<style>
.page_links a{
    color: inherit;
}
</style>
</head>
<body onload="reportOption('');">

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
                            <li><a class="" href="batch_daily_report.php?office=bravo">Batch Report</a></li>
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
                            <li><a class="" href="batch_daily_report.php?office=delta">Batch Report</a></li>
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
                    <div class="col-md-12 page_links">
                        <!-- <h3 class="page-header"><a href="batch_daily_report.php?office=<?php echo $search_plant; ?>"><?php echo $plant; ?> Batch Daily Report</a></h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo $plant; ?></li>
                            <li><i class="fa fa-building"></i><a href="batch_daily_report.php?office=<?php echo $search_plant; ?>">Batch Daily Report</a></li>
                            <li><i class="fa fa-building"></i><a href="batch_summary_report.php?office=<?php echo $search_plant; ?>" style="color: blue;">Batch Summary Report</a></li>
                                                   
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <section class="panel">
                            <header class="panel-heading">

                            </header>
                            <div class="panel-body">
                                <div id="report_result"></div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-3">
                        <section class="panel">
                            <header class="panel-heading">
                                Reports
                            </header>
                            <div class="panel-body">
                                <form action="batch_summary_report.php" method="get">
                                    <input type="hidden" name="hidden_office" id="hidden_office" value="<?php echo $search_plant; ?>">
                                    <div class="radios">
                                        <label class="label_radio" for="radio-01">
                                            <input name="radio_report" id="radio_report" value="total_cement" type="radio" <?php if(isset($_GET['radio_report']) && $_GET['radio_report'] == 'total_cement') { echo "checked"; }?> onclick="reportOption(this.value)" checked /> <strong>Total cement used per day</strong>
                                        </label>
                                        <label class="label_radio" for="radio-02">
                                            <input name="radio_report" id="radio_report" value="total_batch_cement" type="radio" <?php if(isset($_GET['radio_report']) && $_GET['radio_report'] == 'total_batch_cement') { echo "checked"; }?> onclick="reportOption(this.value)" /> <strong>Total batch and cement used</strong>
                                        </label>
                                        <label class="label_radio" for="radio-03">
                                            <input name="radio_report" id="radio_report" value="total_output" type="radio" <?php if(isset($_GET['radio_report']) && $_GET['radio_report'] == 'total_output') { echo "checked"; }?> onclick="reportOption(this.value)" /> <strong>Output per batch</strong>
                                        </label>
                                        <label class="label_radio" for="radio-04">
                                            <input name="radio_report" id="radio_report" value="total_production" type="radio" <?php if(isset($_GET['radio_report']) && $_GET['radio_report'] == 'total_production') { echo "checked"; }?> onclick="reportOption(this.value)" /> <strong>Monthly production output</strong>
                                        </label>
                                        <label class="label_radio" for="radio-05">
                                            <input name="radio_report" id="radio_report" value="total_delivered" type="radio" <?php if(isset($_GET['radio_report']) && $_GET['radio_report'] == 'total_delivered') { echo "checked"; }?> onclick="reportOption(this.value)" /> <strong>Monthly delivered CHB</strong>
                                        </label>
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