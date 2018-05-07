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

    <title>Backload Order - Delivery Page</title>

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

    var timer = null;

    function goAway() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            window.location.reload(true);
        }, 60000);
    }

    window.addEventListener('mousemove', goAway, true);
    window.addEventListener('keypress', goAway, true);

    goAway();


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
.table_page{
    /*margin: auto;*/
    margin-top: -40px;
    /*width: 100%;*/
    text-align: center;
}

.table_row_count{
    margin-top: -15px;
}

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

.grow {
  /*padding: 5px 5px 5px 5px;*/
  /*border-radius: 10px;*/
  height: 49px;
  /*width: 22%;*/
  /*margin: 5px 1% 5px 1%;*/
  /*float: left;*/
  position: relative;
  transition: height 0.5s;
  -webkit-transition: height 0.5s;
  /*text-align: center;*/
  overflow: hidden;
}
.grow:hover {
  height: auto;
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

                    <!-- alert notification start-->
                    <li id="alert_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="icon-bell-l"></i>
<?php

    $badge_count_sql = "SELECT notif_id
                        FROM notification
                        WHERE to_office = '$office' 
                        AND isNotif_view = 0";

    $badge_count_sql_result = mysqli_query($db, $badge_count_sql);
    $badge_count = mysqli_num_rows($badge_count_sql_result);
    if($badge_count > 0){
?>
                            <span class="badge bg-important"><?php echo $badge_count; ?></span>
<?php
    }
?>
                           
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-blue"></div>
                            <li>
                                <p class="blue">You have <?php echo $badge_count ?> new notifications</p>
                            </li>
<?php 

    $notif_sql = "SELECT notif_id, table_name, content, from_office, notif_date
                    FROM notification 
                    WHERE to_office = '$office'
                    AND isNotif_view = '0'
                    ORDER BY notif_date DESC LIMIT 0,10";
           // echo $notif_sql;
    $notif_sql_result = mysqli_query($db, $notif_sql);
    if(mysqli_num_rows($notif_sql_result) > 0){
        $notif_count = 1;
        while ($notif_sql_row =mysqli_fetch_assoc($notif_sql_result)) {

            $datetime1 = strtotime($notif_sql_row['notif_date']);
            $datetime2 = strtotime(date('Y-m-d H:i:s'));
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);
            $hours = round($interval / 3600);
            
            $dStart = new DateTime();
            $dEnd  = new DateTime($notif_sql_row['notif_date']);
            $dDiff = $dStart->diff($dEnd);

            if($minutes < 60){
                $time_elapse = $minutes . " minute(s) ago";
            }else if($minutes > 60 && $hours < 24){
                $time_elapse = $hours . " hour(s) ago";
            }else if($minutes > 60 && $hours > 24){
                $time_elapse = $dDiff->days . " day(s) ago";
            }


            if($notif_sql_row['table_name'] == 'Ongoing Delivery'){
                $detail = ucfirst($notif_sql_row['from_office']) . " issued DR No. <strong>" . $notif_sql_row['content'] . "</strong><span style='float: right;'>" . $time_elapse . "</span>";
            }else if($notif_sql_row['table_name'] == 'Delivered Delivery'){
                $detail = ucfirst($notif_sql_row['from_office']) . " delivered DR No. <strong>" . $notif_sql_row['content'] . "</strong><span style='float: right;'>" . $time_elapse . "</span>";
            }else if($notif_sql_row['table_name'] == 'Backloaded Delivery'){
                $detail = ucfirst($notif_sql_row['from_office']) . " backloaded DR No. <strong>" . $notif_sql_row['content'] . "</strong><span style='float: right;'>" . $time_elapse . "</span>";
            }
?>
                            <li class="notif">
                                <a href="delivery_backload.php?table_name=<?php echo $notif_sql_row['table_name']; ?>&from_office=<?php echo $notif_sql_row['from_office']; ?>&post_dr_no=<?php echo $notif_sql_row['content']; ?>"><?php echo $detail; ?></a>
                            </li>
<?php
            $notif_count++;
        }                            
    }else{
?>
                            <li>
                                <a href="#">No new notifications</a>
                            </li>
<?php
    }
?>                                
                        </ul>
                    </li>
                    <!-- alert notification end--> 
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
                    <h3 class="page-header"><a href="delivery_backload.php?office=<?php echo $search_plant; ?>" style="color: inherit;"><?php echo $plant; ?> Delivery Order</a></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><i class="fa fa-building"></i><?php echo $plant; ?></li>
                        <li><i class="icon_document"></i><a href="delivery_order.php?office=<?php echo $search_plant; ?>">Ongoing Delivery <span class="badge"><?php echo getDeliveryCountOnDeliveryOffice($db, $search_plant); ?></span></a></li>
                        <li><i class="fa fa-info-circle"></i><a href="delivery_issue.php?office=<?php echo $search_plant; ?>">Existing P.O. <span class='badge'><?php echo countPendingPo($db, $search_plant); ?></span></a></li>
                        <li><i class="fa fa-truck"></i><a href="delivery_success.php?office=<?php echo $search_plant; ?>">Delivered</a></li>
                        <li><i class="fa fa-reply"></i>Backload</li>                             
                    </ol>
                </div>
                <div class="col-md-4">
                    <ol class="breadcrumb">
                        <li>As of <strong><?php $date = date("Y-m-d H:i:s"); $date_create = date_create($date); echo date_format($date_create, "M d, Y h:i A"); ?></strong></li>  
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <form action="delivery_backload.php" method="get" class="form-inline">
                            <header class="panel-heading">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="start_date">From:</label>
                                            <div class="tooltips" data-original-title="Start date of transaction" data-placement="top">
                                                <input type="date" name="start_date" class="form-control" value="<?php if(isset($_GET['start_date'])) { echo htmlentities ($_GET['start_date']); }?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="end_date">To:</label>
                                            <div class="tooltips" data-original-title="End date of transaction" data-placement="top">
                                                <input type="date" name="end_date" class="form-control" value="<?php if(isset($_GET['end_date'])) { echo htmlentities ($_GET['end_date']); }?>">
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="input-group col-md-5" style="margin: 38px 0px 0px 0px;">
                                        <div class="tooltips" data-original-title="Search DR No., P.O. No., Item, Project Name, Address or Contact" data-placement="top">
                                            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>">
                                        </div>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info" type="submit" name="search_table">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="input-group col-md-2" style="white-space: nowrap; margin: 38px 0px 0px 60px;">
                                        <label for="view_count" class="col-md-8 control-label">Number of rows:</label>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id="view_count" name="view_count" class="form-control" onchange="this.form.submit()">
                                                    <option value="25" <?php if(isset($_GET['view_count']) && $_GET['view_count'] == "25") echo 'selected="selected"';?>>25</option>
                                                    <option value="50"<?php if(isset($_GET['view_count']) && $_GET['view_count'] == "50") echo 'selected="selected"';?>>50</option>
                                                    <option value="75"<?php if(isset($_GET['view_count']) && $_GET['view_count'] == "75") echo 'selected="selected"';?>>75</option>
                                                    <option value="100"<?php if(isset($_GET['view_count']) && $_GET['view_count'] == "100") echo 'selected="selected"';?>>100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </header>
                        </form>
                        <div class="table-responsive filterable">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="filterable">
                                        <th colspan="10">
                                            <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="fa fa-filter"></span> Filter</button>
                                        </th>
                                    </tr>
                                    <tr class="filters">
                                        <th class="col-md-1">#</th>
                                        <th class="col-md-1"><input type="text" class="form-control" placeholder="DR No." disabled></th>
                                        <th class="col-md-1"><input type="text" class="form-control" placeholder="P.O. No." disabled></th>
                                        <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                        <th class="col-md-1">Quantity</th>
                                        <th class="col-md-2"><input type="text" class="form-control" placeholder="Project Name" disabled></th>
                                        <th class="col-md-2"><input type="text" class="form-control" placeholder="Address" disabled></th>
                                        <th class="col-md-1"><input type="text" class="form-control" placeholder="Contact" disabled></th>
                                        <th class="col-md-1">Date</th>
                                        <th class="col-md-1">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php

    if($_GET['search'] == ''){
        $search_word = "";
    }else{
        $search_word = $_GET['search'];
    }

    if($_GET['search'] != ''){
        $string_ext = " AND (d.delivery_receipt_no LIKE '%".$search_word."%' 
                            OR d.item_no LIKE '%".$search_word."%' 
                            OR d.po_no_delivery LIKE '%".$search_word."%' 
                            OR s.site_name LIKE '%".$search_word."%' 
                            OR s.site_address LIKE '%".$search_word."%'
                            OR p.site_contact_name LIKE '%".$search_word."%') ";
    }else{
        $string_ext = "";
    }

    if($_GET['end_date'] == ''){
        $end_date = "";
    }else{
        $end_date = $_GET['end_date'];
    }

    if($_GET['start_date'] == ''){
        $start_date = "";
    }else{
        $start_date = $_GET['start_date'];
    }

    if($_GET['start_date'] == '' && $_GET['end_date'] == ''){
        $string_date = "";
    }else if($_GET['start_date'] == '' && $_GET['end_date'] != ''){
        $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') <= '$end_date'";
    }else if($_GET['start_date'] != '' && $_GET['end_date'] == ''){
        $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') >= '$start_date'";        
    }else{
        $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
    }

    $string = " WHERE office = '$search_plant'";

    $sql = "SELECT * FROM delivery d, site s, site_contact_person p, purchase_order_contact poc ".$string." 
            AND d.fk_po_id = poc.purchase_id
            AND poc.site_contact_id = p.site_contact_person_id
            AND d.site_id = s.site_id 
            AND s.site_id = p.site_id ".$string_date." ".$string_ext." 
            AND remarks = 'Backload'
            GROUP BY d.delivery_id";
    // echo $sql;
    $sql_result = mysqli_query($db, $sql); 
    $total = mysqli_num_rows($sql_result);

    $adjacents = 3;
    $targetpage = "delivery_backload.php"; //your file name
    $page = $_GET['page'];

    if($page){ 
        $start = ($page - 1) * $limit; //first item to display on this page
    }else{
        $start = 0;
    }

    /* Setup page vars for display. */
    if ($page == 0) $page = 1; //if no page var is given, default to 1.
    $prev = $page - 1; //previous page is current page - 1
    $next = $page + 1; //next page is current page + 1
    $lastpage = ceil($total/$limit); //lastpage.
    $lpm1 = $lastpage - 1; //last page minus 1

    /* CREATE THE PAGINATION */
    $counter = 0;
    $pagination = "";
    if($lastpage > 1){ 
        $pagination .= "<div class='pagination1'> <ul class='pagination'>";
        if ($page > $counter+1) {
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">Previous</a></li>"; 
        }

        if ($lastpage < 7 + ($adjacents * 2)) { 
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                else
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$counter</a></li>"; 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$lastpage</a></li>"; 
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$lastpage</a></li>"; 
            }
            //close to end; only hide early pages
            else{
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">$counter</a></li>"; 
                }
            }
        }

        //next button
        if ($page < $counter - 1) 
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&start_date=$start_date&end_date=$end_date&search=$search_word&view_count=$limit\">Next</a></li>";
        else
            $pagination.= "";
        $pagination.= "</ul></div>\n"; 
    }

    $query = "SELECT d.delivery_id, d.delivery_receipt_no, d.item_no, d.quantity, d.gate_pass, d.po_no_delivery, DATE_FORMAT(d.date_delivery,'%m/%d/%y') as date_delivery , d.office, d.remarks, d.fk_po_id, s.site_name, s.site_address, p.site_contact_name, c.client_name, GROUP_CONCAT(DISTINCT p.site_contact_name ORDER BY p.site_contact_name SEPARATOR ', ') as site_contact_name, d.psi, d.fk_unique_po_id
                FROM delivery d, site s, site_contact_person p, client c, site_contact_number sc, purchase_order_contact poc
                ".$string." ".$string_date."
                AND s.client_id = c.client_id
                AND d.fk_po_id = poc.purchase_id
                AND poc.site_contact_id = p.site_contact_person_id
                AND d.site_id = s.site_id ".$string_ext."
                AND remarks = 'Backload' 
                GROUP BY delivery_id 
                ORDER BY delivery_id DESC
                LIMIT $start, $limit";
                // echo $query;
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0){
        $hash = $start + 1;
        while($row = mysqli_fetch_assoc($result)){

            if($row['psi'] != ""){
                $row['psi'] = "(" . $row['psi'] . " PSI)";
            }else{
                $row['psi'] = "";
            }
?>
            <tr>
                <td><?php echo $hash; ?></td>
                <td><strong><?php echo $row['delivery_receipt_no']; ?></strong></td>
                <td style="cursor: pointer;" id="<?php echo $row['delivery_receipt_no']; ?>">
                    <div class="tooltips" data-original-title="Click for more details about P.O. No. <?php echo $row['po_no_delivery'] ?>" data-placement="top" onclick="window.location='delivery_po_details.php?fk_po_id=<?php echo base64_encode($row['fk_po_id']); ?>&po_no_delivery=<?php echo $row['po_no_delivery']; ?>&office=<?php echo $search_plant; ?>&fk_unique_po_id=<?php echo base64_encode($row['fk_unique_po_id']); ?>'">
                        <strong><?php echo $row['po_no_delivery']; ?></strong>
                    </div>
                </td>
                <td><strong><?php echo $row['item_no'] . " " . $row['psi']; ?></strong></td>
                <td><strong><?php echo number_format((float)$row['quantity'])." pcs"; ?></strong></td>
                <td><strong><?php echo $row['site_name']; ?></strong></td>
                <td><strong><?php echo $row['site_address']; ?></strong></td>
                <td>
                    <a data-toggle="collapse" data-target="#contacts<?php echo $hash; ?>" style="cursor: default; color: inherit;">Click to view</a>
                    <div id="contacts<?php echo $hash; ?>" class="collapse">
<?php

            $contact_sql = "SELECT DISTINCT p.site_contact_id, c.site_contact_name
                            FROM purchase_order_contact p, delivery d, site_contact_person c
                            WHERE d.fk_po_id = p.purchase_id
                            AND p.site_contact_id = c.site_contact_person_id
                            AND d.fk_po_id = '".$row['fk_po_id']."'
                            ORDER BY c.site_contact_name";
                            // echo $contact_sql;
            $contact_sql_result = mysqli_query($db, $contact_sql);
            while ($contact_sql_row = mysqli_fetch_assoc($contact_sql_result)) {

                $no_sql = "SELECT GROUP_CONCAT(site_contact_no SEPARATOR ', ') as site_contact_no 
                            FROM site_contact_number
                            WHERE site_contact_person_id = '".$contact_sql_row['site_contact_id']."'";

                $no_sql_result = mysqli_query($db, $no_sql);
                while ($no_sql_row = mysqli_fetch_assoc($no_sql_result)) {

                    $contact_sql_row['site_contact_no'] = $no_sql_row['site_contact_no'];
?>
                    <div class="row">
                        <div class="col-md-12">
                            <strong><?php echo $contact_sql_row['site_contact_name'] . "<br> (" . $contact_sql_row['site_contact_no'] . ") <br><br>"; ?></strong>
                        </div>
                    </div>
<?php
                } 
            }
?>
                    </div>
                </td>
                <td><strong><?php echo $row['date_delivery']; ?></strong></td>
                <td style="color: #d32f2f;"><strong><?php echo $row['remarks']; ?></strong></td>
            </tr>
<?php
        $hash++;
        }
    }else{
?>
            <tr>        
                <td colspan="10" style='min-height: 100%; background: white;text-align:center; 
vertical-align:middle;'><h4><p class='text-muted'>No data found</p></h4></td>
            </tr>
<?php
    }
?>
                                 </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>     
            <div class="row">
                <div class="col-md-3">
                    <div class="table_row_count">
<?php
                    if(isset($hash)){
                        echo "Showing " . ($start+1)  . " to " . ($start + $hash - $start - 1) . " of " . $total . " entries"; 
                    }
?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table_page">
<?php
                    echo $pagination; 
?>      
                    </div>
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
    <!--main content end-->
    </section>
    <!-- container section start -->

</body>
</html>
<?php

    if(isset($_GET['table_name']) && isset($_GET['from_office']) && isset($_GET['post_dr_no'])){

        $table_name = $_GET['table_name'];
        $from_office = $_GET['from_office'];
        $post_dr_no = $_GET['post_dr_no'];

        if($table_name == 'Delivered Delivery'){
            $location = "delivery_success.php?office=" . $from_office;
        }else if($table_name == 'Backloaded Delivery'){
            $location = "delivery_backload.php?office=" . $from_office;
        }else if($table_name == 'Ongoing Delivery'){
            $location = "delivery_order.php?office=" . $from_office;
        }

        $update_notif = "UPDATE notification SET isNotif_view = '1'
                            WHERE isNotif_view = 0 
                            AND table_name = '$table_name'
                            AND to_office = '$office'
                            AND from_office = '$from_office'";

        // echo $update_notif;
        if(mysqli_query($db, $update_notif)){
            header("location:" .$location. "#".$post_dr_no);
        }
    }
?>