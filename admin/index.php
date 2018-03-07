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

    if(!isset($_GET['radioOffice'])){
        $_GET['radioOffice'] = 'bravo';
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
    

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Starcrete Manufacturing Corporation</title>

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
                 $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="3" style="height: 100%;background: white; text-align:center; vertical-align:middle;"><h4><p class="text-muted">No data found</p></h4></td></tr>'));
            }
        });
    });

    function filterTable() {
        // Declare variables 
        var input, filter, table, tr, td, td1, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        // $table = $panel.find('.table'),;
        
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            td1 = tr[i].getElementsByTagName("td")[1];
            if (td || td1) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                    // $table.find('tbody').prepend($('<tr class="no-result text-center"><td  style="height: 100%;background: white; text-align:center; vertical-align:middle;"><h4><p class="text-muted">No data found</p></h4></td></tr>'));
                }
            } 
        }
    }

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
                    <li class="active">
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
                            <span class="menu-arrow arrow_carrot-right"></span>
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
                            <span class="menu-arrow arrow_carrot-right"></span>
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
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="purchase_order_form.php">Purchase Order Form</a></li>
                            <!-- <li><a class="" href="purchase_aggregates_order_form.php">P.O. Aggregates Form</a></li>                           -->
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
                        <!-- <h3 class="page-header"><i class="fa fa-home"></i> History</h3> -->
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i>History</li>						  	
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <form action="index.php" method="get" class="form-inline">
                                <header class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="search">Plant:</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="radioOffice" value="bravo" <?php if(isset($_GET['radioOffice']) && $_GET['radioOffice'] == 'bravo') { echo "checked"; }?> onchange="this.form.submit()" checked>Bravo
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="radioOffice" value="delta" <?php if(isset($_GET['radioOffice']) && $_GET['radioOffice'] == 'delta') { echo "checked"; }?> onchange="this.form.submit()" >Delta
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="start_date">Start Date:</label><input type="date" name="start_date" class="form-control" value="<?php if(isset($_GET['start_date'])) { echo htmlentities ($_GET['start_date']); }?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="end_date">End Date:</label><input type="date" name="end_date" class="form-control" value="<?php if(isset($_GET['end_date'])) { echo htmlentities ($_GET['end_date']); }?>">
                                            </div>
                                        </div>  
                                        <div class="input-group col-md-5" style="margin: 38px 0px 0px 0px;">
                                            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info" type="submit" name="search_table">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group col-md-12" style="margin: 5px 0px 0px 0px;">
                                            <label for="view_count" class="col-md-2 control-label" style="margin-right: -80px;">Number of rows:</label>
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
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead>
                                        <tr class="filterable">
                                            <th colspan="3">
                                                <p style="float: left;">Plant: <?php echo ucfirst($_GET['radioOffice']); ?></p>
                                                <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="fa fa-filter"></span> Filter</button>
                                            </th>
                                            <!-- <th colspan="3">
                                                <input type="text" id="myInput" onkeyup="filterTable()" class="form-control" placeholder="Search for names.." title="Type in a name">
                                            </th> -->
                                        </tr>
                                        <tr class="filters">
                                            <th class="col-md-1"><input type="text" class="form-control" placeholder="Transaction" disabled>
                                            </th>
                                            <th class="col-md-7"><input type="text" class="form-control" placeholder="Description" disabled></th>
                                            <th class="col-md-1">Date</th>
                                            <!-- <th class="col-md-1">Transaction</th>
                                            <th class="col-md-7">Description</th>
                                            <th class="col-md-1">Date</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
<?php

    if(isset($_GET['radioOffice'])){
        $search_plant = $_GET['radioOffice'];
    }else{
        $search_plant = 'bravo';
    }
    
    if($_GET['search'] == ''){
        $search_word = "";
    }else{
        $search_word = $_GET['search'];
    }

    if($_GET['search'] != ''){
        $string_ext = " AND (transaction_type LIKE '%".$search_word."%' OR detail LIKE '%".$search_word."%') ";
    }else{
        $string_ext = "";
    }

    if($_GET['end_date'] == ''){
        $end_date = '';
    }else{
        $end_date = $_GET['end_date'];
    }

    if($_GET['start_date'] == ''){
        $start_date = '';
    }else{
        $start_date = $_GET['start_date'];
    }

    if($_GET['start_date'] == '' && $_GET['end_date'] == ''){
        $string_date = "";
    }else if($_GET['start_date'] == '' && $_GET['end_date'] != ''){
        $string_date = "AND DATE_FORMAT(history_date,'%Y-%m-%d') <= '$end_date'";
    }else if($_GET['start_date'] != '' && $_GET['end_date'] == ''){
        $string_date = "AND DATE_FORMAT(history_date,'%Y-%m-%d') >= '$start_date'";     
    }else{
        $string_date = "AND DATE_FORMAT(history_date,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
    }

    $string = " WHERE office = '$search_plant'";

    $sql = "SELECT * FROM history".$string." ".$string_date." ".$string_ext;

    $result = mysqli_query($db, $sql); 
    $total = mysqli_num_rows($result);

    $adjacents = 3;
    $targetpage = "index.php"; //your file name
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
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">Previous</a></li>"; 
        }

        if ($lastpage < 7 + ($adjacents * 2)) { 
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                else
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$counter</a></li>"; 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$lastpage</a></li>"; 
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$lastpage</a></li>"; 
            }
            //close to end; only hide early pages
            else{
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">$counter</a></li>"; 
                }
            }
        }

        //next button
        if ($page < $counter - 1) 
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&radioOffice=$search_plant&search=$search_word&start_date=$start_date&end_date=$end_date&view_count=$limit\">Next</a></li>";
        else
            $pagination.= "";
        $pagination.= "</ul></div>\n"; 
    }

    $sql1 = "SELECT table_report, transaction_type, detail, office, DATE_FORMAT(history_date,'%m/%d/%y')  as history_date1 
            FROM history ".$string." ".$string_date." ".$string_ext." 
            ORDER BY history_date DESC LIMIT $start, $limit";

    // echo $sql1;
    $result = mysqli_query($db,$sql1);
    $count = mysqli_num_rows($result);
    if($count > 0){
        $hash = 1;
        while($row = mysqli_fetch_array($result)){
?>
                                        <tr>
                                            <td><strong><?php echo $row['transaction_type']; ?></strong></td>
                                            <td style='text-align: justify;'><strong><?php echo $row['detail']; ?></strong></td>
                                            <td><strong><?php echo $row['history_date1']; ?></strong></td>
                                        </tr>
<?php
            $hash++;
        }
    }else{
?>
                                        <tr>
                                            <td colspan="3" style='height: 100%; background: white; text-align:center; 
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
                </div><!--/.row-->  
                <div class="row">
                    <div class="col-md-4">
                        <div class="table_row_count">
<?php
                        if(isset($hash)){
                            echo "Showing " . ($start+1)  . " to " . ($start + $hash - 1) . " of " . $total . " entries"; 
                        }
?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="table_page">
<?php
                        echo $pagination; 
?>      
                        </div>
                    </div>
                </div>   
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
    <!--main content end-->
    </section>
</body>
</html>
