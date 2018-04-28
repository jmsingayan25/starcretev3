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
    // $search_plant = 'bravo';
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

    <title>Pending P.O. - Purchase Order</title>

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
    <!-- <link href="css/css_ext.css" rel="stylesheet"> -->

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

    function disableTextArea(value){
        // alert(value);
        var textareafield = document.getElementsByClassName("inputArea");
        // alert(textareafield.length)
        for(var i=0; i<textareafield.length; i++){
            if(value == "closed_only"){
                textareafield[i].disabled = false;
            }else{
                textareafield[i].disabled = true;
            }    
        }
    }

</script>
<style>
/*table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }*/
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
/*.page_links a{
    color: inherit;
}*/
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
                        <h3 class="page-header"><a href="purchase_order.php?office=<?php echo $search_plant; ?>" style="color: inherit;"><?php echo $plant; ?> Pending Purchase Order</a></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo ucfirst($plant); ?></li>
                            <li><i class="icon_document"></i>Pending P.O.</li>                            
                            <li><i class="icon_document"></i><a href="purchase_closed_order.php?office=<?php echo $search_plant; ?>">Closed P.O.</a></li>                          
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <ol class="breadcrumb">
                            <li>As of <strong><?php $date = date("Y-m-d H:i:s"); $date_create = date_create($date); echo date_format($date_create, "M d, Y h:i A"); ?></strong></li>  

                            <!-- <li>Last Entry: <strong><?php $date = lastPurchaseOrderEntry($db, $plant); $date_create = date_create($date); echo date_format($date_create, "M d, Y h:i A"); ?></strong></li> -->
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <form action="purchase_order.php" method="get" class="form-inline">
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
                                            <div class="tooltips" data-original-title="Search P.O. No., Item, Project Name, Address or Contact" data-placement="top">
                                                <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>" autocomplete="off">
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
                                            <th class="col-md-1"><input type="text" class="form-control" placeholder="P.O. No." disabled></th>
                                            <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                            <th class="col-md-1">Quantity</th>
                                            <th class="col-md-1">Balance</th>
                                            <th class="col-md-2"><input type="text" class="form-control" placeholder="Project Name" disabled></th>
                                            <th class="col-md-2"><input type="text" class="form-control" placeholder="Address" disabled></th>
                                            <th class="col-md-1"><input type="text" class="form-control" placeholder="Contact" disabled></th>
                                            <th class="col-md-1">Date Order</th>
                                            <!-- <th class="col-md-1">Action</th> -->
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
        $string_ext = " AND (o.purchase_order_no LIKE '%".$search_word."%' 
                            OR o.item_no LIKE '%".$search_word."%' 
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
        $string_date = "AND DATE_FORMAT(date_purchase,'%Y-%m-%d') <= '$end_date'";
    }else if($_GET['start_date'] != '' && $_GET['end_date'] == ''){
        $string_date = "AND DATE_FORMAT(date_purchase,'%Y-%m-%d') >= '$start_date'";        
    }else{
        $string_date = "AND DATE_FORMAT(date_purchase,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
    }

    $string = " WHERE office = '$search_plant'";

    $sql = "SELECT * FROM purchase_order o, site s, site_contact_person p, purchase_order_contact c ".$string." 
            AND o.site_id = s.site_id 
            AND o.purchase_id = c.purchase_id
            AND c.site_contact_id = p.site_contact_person_id
            AND s.site_id = p.site_id ".$string_ext." ".$string_date." 
            AND balance != 0
            GROUP BY o.purchase_id";
    // echo $sql;

    $sql_result = mysqli_query($db, $sql); 
    $total = mysqli_num_rows($sql_result);

    $adjacents = 3;
    $targetpage = "purchase_order.php"; //your file name
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
        $pagination .= "<div class='pagination'> <ul class='pagination'>";
        if ($page > $counter+1) {
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&search=$search_word&start_date=$start_date&end_date=$end_date\">Previous</a></li>"; 
        }

        if ($lastpage < 7 + ($adjacents * 2)) { 
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                else
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&search=$search_word&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&search=$search_word&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&search=$search_word&start_date=$start_date&end_date=$end_date\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&search=$search_word&start_date=$start_date&end_date=$end_date\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&search=$search_word&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&search=$search_word&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
            }
            //close to end; only hide early pages
            else{
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&search=$search_word&start_date=$start_date&end_date=$end_date\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&search=$search_word&start_date=$start_date&end_date=$end_date\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
            }
        }

        //next button
        if ($page < $counter - 1) 
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&search=$search_word&start_date=$start_date&end_date=$end_date\">Next</a></li>";
        else
            $pagination.= "";
        $pagination.= "</ul></div>\n"; 
    }
                
    $query = "SELECT o.purchase_id, o.purchase_order_no, o.item_no, o.quantity, o.delivered, o.backload, o.balance, o.office, o.remarks, l.unit, s.site_name, s.site_address, GROUP_CONCAT(DISTINCT p.site_contact_name ORDER BY p.site_contact_name ASC SEPARATOR ', ') as site_contact_name, DATE_FORMAT(o.date_purchase,'%m/%d/%y') as date_purchase, o.psi, o.purchase_unique_id
                FROM purchase_order o, purchase_order_contact c, batch_list l, site_contact_person p, site s
                ".$string." ".$string_date."
                AND o.site_id = s.site_id
                AND o.purchase_id = c.purchase_id
                AND c.site_contact_id = p.site_contact_person_id
                AND o.item_no = l.item_no ".$string_ext."
                AND o.balance != 0  
                AND DATE_FORMAT(date_purchase,'%Y-%m-%d') != ''
                GROUP BY o.purchase_id
                ORDER BY o.purchase_id DESC LIMIT $start, $limit";

    // echo $query;
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0){
        $hash = $start + 1;
        while($row = mysqli_fetch_assoc($result)){

            if($row['psi'] != ""){
                $row['psi'] = "(" . number_format($row['psi']) . " PSI)";
            }else{
                $row['psi'] = "";
            }
?>  
            <tr>
                <td><?php echo $hash; ?></td>
<?php
            $sql_delivery = "SELECT * FROM delivery
                                WHERE fk_po_id = '".$row['purchase_id']."'
                                AND remarks = 'Delivered'";

            $count = mysqli_query($db, $sql_delivery);
            if(mysqli_num_rows($count) > 0){
                if($row['balance'] <= 1350){
?>
                    <td style="cursor: pointer; color: red;">
                        <div class="tooltips" data-original-title="Click for more details about P.O. No. <?php echo $row['purchase_order_no'] ?>" data-placement="top" onclick="window.location='purchase_order_details.php?purchase_order_no=<?php echo $row['purchase_order_no']; ?>&office=<?php echo $search_plant; ?>&purchase_unique_id=<?php echo $row['purchase_unique_id']; ?>'">
                            <strong><?php echo $row['purchase_order_no']; ?></strong>
                        </div>
                    </td>
                    <td style="color: red;"><strong><?php echo $row['item_no'] . " " . $row['psi']?></strong></td>
<?php
                }else{
?>
                    <td style="cursor: pointer;">
                        <div class="tooltips" data-original-title="Click for more details about P.O. No. <?php echo $row['purchase_order_no'] ?>" data-placement="top" onclick="window.location='purchase_order_details.php?purchase_order_no=<?php echo $row['purchase_order_no']; ?>&office=<?php echo $search_plant; ?>&purchase_unique_id=<?php echo $row['purchase_unique_id']; ?>'">
                            <strong><?php echo $row['purchase_order_no']; ?></strong>
                        </div>
                    </td>
                    <td><strong><?php echo $row['item_no'] . " " . $row['psi']?></strong></td>
<?php
                }
            }else{
?>
                <td style="cursor: pointer;">
                    <div class="tooltips" data-original-title="Click for more details about P.O. No. <?php echo $row['purchase_order_no'] ?>" data-placement="top" onclick="window.location='purchase_order_details.php?purchase_order_no=<?php echo $row['purchase_order_no']; ?>&office=<?php echo $search_plant; ?>&purchase_unique_id=<?php echo $row['purchase_unique_id']; ?>'">
                        <strong><?php echo $row['purchase_order_no']; ?></strong>
                    </div>
                </td>
                <td><strong><?php echo $row['item_no'] . " " . $row['psi']?></strong></td>
<?php
            }
?>
                <td><strong><?php echo number_format((float)$row['quantity'])." pcs"; ?></strong></td>
<?php
            if(mysqli_num_rows($count) > 0){
                if($row['balance'] <= 1350){
                    echo "<td style='color: red;'><strong>" . number_format((float)$row['balance']) . " pcs </strong></td>";
                }else{
                    echo "<td><strong>" . number_format((float)$row['balance']) . " pcs </strong></td>";
                }
            }else{
                echo "<td><strong>" . number_format((float)$row['balance']) . " pcs </strong></td>";
            }
?>
                <td><strong><?php echo $row['site_name']; ?></strong></td>
                <td><strong><?php echo $row['site_address']; ?></strong></td>
                <td>
                    <a data-toggle="collapse" data-target="#contacts<?php echo $hash; ?>" style="cursor: default; color: inherit;">Click to view</a>
                    <div id="contacts<?php echo $hash; ?>" class="collapse">
                        <!-- <div class="grow"> -->
                
<?php

            $contact_sql = "SELECT DISTINCT p.site_contact_id, c.site_contact_name
                            FROM purchase_order_contact p, purchase_order d, site_contact_person c
                            WHERE d.purchase_id = p.purchase_id
                            AND p.site_contact_id = c.site_contact_person_id
                            AND d.purchase_id = '".$row['purchase_id']."'
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
                    <div class="row" style="margin-bottom: 2px;">
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
                <td><strong><?php echo $row['date_purchase']; ?></strong></td>
                <!-- <td>
                    <form action="purchase_order.php" method="post">
                        <button type="button" class="btn btn-sm btn-block" style="margin-bottom: 5px; background-color: #ffa000; color: white;" data-toggle='modal' data-target='#purchaseOrderUpdateRow<?php echo $hash; ?>'><span class="fa fa-edit"></span> <strong>Update</strong></button>

                        <div class="modal fade" id="purchaseOrderUpdateRow<?php echo $hash;?>" role="dialog">
                            <div class="modal-dialog modal-sm" style="max-width: 300px;">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="row" style="text-align: center;">
                                            <div class="col-md-12">
                                                <img src="images/starcrete.png" width="150" height="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body" style="text-align: left;">
                                        <h4 class="modal-title" style="text-align: center">Confirmation</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="confirm_password">Password</label>
                                                    <input type="password" name="confirm_password" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update" id="update" value="<?php echo $row['purchase_id']; ?>" class="btn btn-primary"><strong>Submit</strong></button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><strong>Close</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
<?php

    $sql_select = "SELECT * FROM delivery
                    WHERE po_no_delivery = '". $row['purchase_order_no']."'
                    AND fk_unique_po_id = '".$row['purchase_unique_id']."'
                    AND remarks = 'Ongoing Delivery'";

    $sql_select_result = mysqli_query($db, $sql_select);
    if(mysqli_num_rows($sql_select_result) <= 0){
?>

                    <form action="purchase_order.php" method="post">
                        <button type="button" class="btn btn-sm btn-block" style="margin-bottom: 5px; background-color: #d32f2f; color: white;" data-toggle='modal' data-target='#purchaseOrderClosedRow<?php echo $hash; ?>'><span class="fa fa-edit"></span> <strong>Close</strong></button>

                        <div class="modal fade" id="purchaseOrderClosedRow<?php echo $hash;?>" role="dialog">
                            <div class="modal-dialog modal-sm">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="row" style="text-align: center;">
                                            <div class="col-md-12">
                                                <img src="images/starcrete.png" width="150" height="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body" style="text-align: left;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="radiooption">Reason for closing P.O. No. <strong><?php echo $row['purchase_order_no'] . " " . $row['item_no'] . " " . $row['psi'] . " (Balance: " . number_format((float)$row['balance']) . " pcs)"; ?></strong></label>
                                                    <textarea name="reason" id="reason" rows="5" class="form-control inputArea" placeholder="Type here..." required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="closed" id="closed" value="<?php echo $row['purchase_id']; ?>" class="btn btn-primary"><strong>Submit</strong></button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><strong>Close</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
<?php
    }
?>
                </td> -->
            </tr>
<?php
            $hash++;
        }
    }else{
?>
                <tr>
                    <td colspan="10" style='min-height: 100%; background: white; text-align: center; 
vertical-align: middle;'><h4><p class='text-muted'>No data found</p></h4></td>
                </tr>
<?php
    }
?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div><!--/.row-->      
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
    </section>
    <!--main content end-->
    </section>
    <!-- container section start -->

</body>
</html>
<?php

    if(isset($_POST['closed'])){

        $purchase_id = $_POST['closed'];
        $reason = $_POST['reason'];
        $sql = "SELECT *, s.site_name, c.client_name 
                    FROM purchase_order p, site s, client c 
                    WHERE p.site_id = s.site_id 
                    AND s.client_id = c.client_id 
                    AND purchase_id = '$purchase_id'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);

        $po_no = $row['purchase_order_no'];
        $item_no = $row['item_no'];
        // $psi = "(" . $row['psi'] . " PSI)";
        $client = $row['client_name'];
        $datetime = date("Y-m-d H:i:s");
        $plant = $row['office'];
        $balance = $row['balance'];

        if($row['psi'] != ""){
            $psi = "(" . $row['psi'] . " PSI)";
        }else{
            $psi = "";
        }

        //     $status = " served";
        //     $remarks = "Closed";
        //     $reason = '';

        $update = "UPDATE purchase_order 
                    SET cancelled = cancelled + '$balance', balance = 0, remarks = 'Closed', date_cancelled = '$datetime'
                    WHERE purchase_id = '$purchase_id'";

        $insert_closed = "INSERT INTO purchase_order_deliveries(purchase_order_id, purchase_order_no, quantity, reason, status, date_closed) VALUES ('$purchase_id','$po_no','$balance','$reason','Closed', '$datetime')";
        
        $history = "INSERT INTO history(table_report,transaction_type,item_no,detail,history_date,office) 
                        VALUES('Purchase Order','Closed P.O. No.','$item_no','P.O. No. $po_no with balance of ".number_format($balance)." pcs of $item_no $psi order by $client has been closed with a reason of $reason','$datetime','$plant')";

        $sql_po_id = "SELECT * FROM purchase_order_deliveries WHERE purchase_order_id = '$purchase_id'";
        $sql_po_id_result = mysqli_query($db, $sql_po_id);

        if(mysqli_num_rows($sql_po_id_result) > 0){
            $update_deliveries = "UPDATE purchase_order_deliveries SET status = 'Closed' WHERE purchase_order_id = '$purchase_id'";

            mysqli_query($db, $update_deliveries);
        }

        // echo $update . "<br>";
        // echo $insert_closed . "<br>";
        // echo $history . "<br>";
        // echo $update_deliveries . "<br>";

        if(mysqli_query($db, $insert_closed) && mysqli_query($db, $update) && mysqli_query($db, $history)){
            phpAlert("P.O. No. $po_no with item $item_no has been closed");
            echo "<meta http-equiv='refresh' content='0'>";
        }else{
            phpAlert(mysqli_error($db));
        }

        // $reply = array('post' => $_POST);
        // echo json_encode($reply);

    }else if(isset($_POST['cancel'])){

        // $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
        // $password = mysqli_real_escape_string($db, $_POST['confirm_password']);

        // $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

        // $result = mysqli_query($db, $sql);

        // if(mysqli_num_rows($result) > 0){

            $purchase_id = $_POST['cancel'];

            $sql = "SELECT *, s.site_name, c.client_name 
                    FROM purchase_order p, site s, client c 
                    WHERE p.site_id = s.site_id 
                    AND s.client_id = c.client_id 
                    AND purchase_id = '$purchase_id'";
            $result = mysqli_query($db, $sql);
            $row = mysqli_fetch_assoc($result);

            $po_no = $row['purchase_order_no'];
            $item_no = $row['item_no'];
            // $psi = "(" . $row['psi'] . " PSI)";
            $client = $row['client_name'];
            $datetime = date("Y-m-d H:i:s");
            $plant = $row['office'];
            $balance = $row['balance'];

            if($row['psi'] != ""){
                $psi = "(" . $row['psi'] . " PSI)";
            }else{
                $psi = "";
            }

            $update = "UPDATE purchase_order 
                        SET cancelled = cancelled + '$balance', balance = 0, remarks = 'Cancelled', date_cancelled = '$datetime'
                        WHERE purchase_id = '$purchase_id'";

            $history = "INSERT INTO history(table_report,transaction_type,item_no,detail,history_date,office) 
                        VALUES('Purchase Order','Cancelled P.O. No.','$item_no','P.O. No. $po_no with balance of ".number_format($balance)." pcs of $item_no $psi order by $client has been cancelled','$datetime','$plant')";

            // echo $update;
            // echo $history;
            if(mysqli_query($db, $history) && mysqli_query($db, $update)){
                phpAlert("P.O. No. $po_no with item $item_no has been cancelled!!!");
                echo "<meta http-equiv='refresh' content='0'>";
            }else{
                phpAlert('Something went wrong!!!');
            }
        // }else{
        //     phpAlert("Invalid password. Try again.");
        //     echo "<meta http-equiv='refresh' content='0'>";
        // }
    }else if(isset($_POST['update'])){

        $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
        $password = mysqli_real_escape_string($db, crypt($_POST['confirm_password'], '$1$' . $_POST['confirm_password']));

        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        echo $sql;
        $result = mysqli_query($db, $sql);

        if(mysqli_num_rows($result) > 0){
            $_SESSION['post_purchase_id'] = $_POST['update'];
            $_SESSION['post_office'] = $search_plant;
            header("location: purchase_order_update.php");
            // echo $purchase_id;
        }else{
            phpAlert("Invalid username or password of Admin");
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
?>