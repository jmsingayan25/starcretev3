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

    if(!isset($_GET['search'])){
        $_GET['search'] = '';
    }

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];
    $limit = 25;
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Clients</title>

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
        var input, filter, table, tr, td, i;
        input = document.getElementById("select_status");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        // $table = $panel.find('.table'),;
        
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
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
                <li class="">
                    <a class="" href="index.php">
                        <i class="icon_house"></i>
                        <span>History</span>
                    </a>
                </li>
                <li class="active">
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
                    <h3 class="page-header">Client</h3>
                    <ol class="breadcrumb">
                        <!-- <li><i class="fa fa-home"></i>Home</li> -->
                        <li><i class="fa fa-address-book"></i><a href="clients.php" style="color: inherit;">Clients</a></li>                            
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                             <form method="get" action="clients.php">
                                <div class="row">
                                    <div class="input-group col-md-8" style="margin: 5px 0px 5px 0px;">
                                         <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info" type="submit" name="search_client">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="pull-right" style="margin-top: 5px; margin-right: 5px;">
                                         <a href="add_client.php" class="btn btn-info"><span class="fa fa-plus"></span> Add Client</a>
                                    </div>
                                </div>
                            </form>
                        </header>
                        <div class="table-responsive filterable">
                            <table class="table table-striped table-bordered" id="myTable">
                                <thead>
                                    <tr class="filters">
                                        <th class="col-md-4"><input type="text" class="form-control" placeholder="Client" disabled></th>
                                        <th class="col-md-3"><input type="text" class="form-control" placeholder="Address" disabled></th>
                                        <th class="col-md-4">Contacts</th>
                                        <th class="col-md-1"></th>
                                    </tr>
                                </thead>
                                <tbody>                                
<?php
    
    if(isset($_GET['search_client'])){

        if($_GET['search'] == ''){
            $search_word = "";
        }else{
            $search_word = $_GET['search'];
        }

        if($_GET['search'] != ''){
            $string = " WHERE (client_name LIKE '%".$search_word."%' OR address LIKE '%".$search_word."%') ";
        }else{
            $string = "";
        }

        $sql = "SELECT * FROM client ".$string;

        $result = mysqli_query($db, $sql); 
        $total = mysqli_num_rows($result);

        $adjacents = 3;
        $targetpage = "clients.php"; //your file name
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
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&search=$search_word\">Previous</a></li>"; 
            }

            if ($lastpage < 7 + ($adjacents * 2)) { 
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&search=$search_word\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&search=$search_word\">$lastpage</a></li>"; 
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&search=$search_word\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&search=$search_word\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&search=$search_word\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&search=$search_word\">$lastpage</a></li>"; 
                }
                //close to end; only hide early pages
                else{
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&search=$search_word\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&search=$search_word\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                    }
                }
            }

            //next button
            if ($page < $counter - 1) 
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&search=$search_word\">Next</a></li>";
            else
                $pagination.= "";
            $pagination.= "</ul></div>\n"; 
        }

        $sql_client = "SELECT * FROM client ".$string." ORDER BY client_name ASC LIMIT $start, $limit";
        $result_client = mysqli_query($db, $sql_client);
        // echo $sql_client;
        $hash = 1;
        while ($row = mysqli_fetch_assoc($result_client)) {
            
            $sql_contact = "SELECT p.client_contact_id, GROUP_CONCAT(DISTINCT p.client_contact_name ORDER BY p.client_contact_name ASC SEPARATOR ', ') as client_contact_name, p.client_id, n.client_contact_no 
                            FROM client_contact_person p, client_contact_number n
                            WHERE p.client_contact_id = n.client_contact_id
                            AND p.client_id = '".$row['client_id']."'";

            $result_contact = mysqli_query($db, $sql_contact);
            $row_contact = mysqli_fetch_assoc($result_contact);

            $row['client_contact_name'] = $row_contact['client_contact_name'];
?>
                                    <tr>
                                        <td><strong><?php echo $row['client_name']; ?></strong></td>
                                        <td><strong><?php echo $row['address']; ?></strong></td>
                                        <td>
                                            
<?php

    $name_sql = "SELECT DISTINCT client_contact_id, client_contact_name
                    FROM client_contact_person
                    WHERE client_id = '".$row['client_id']."'";

    $name_sql_result = mysqli_query($db, $name_sql);
    while ($row_name_sql = mysqli_fetch_assoc($name_sql_result)) {
        
        $no_sql = "SELECT GROUP_CONCAT(DISTINCT client_contact_no SEPARATOR ', ') as client_contact_no
                    FROM client_contact_number
                    WHERE client_contact_id = '".$row_name_sql['client_contact_id']."'";

        $no_sql_result = mysqli_query($db, $no_sql);
        while ($row_no_sql = mysqli_fetch_assoc($no_sql_result)) {
            
            $row_name_sql['client_contact_no'] = $row_no_sql['client_contact_no'];
?>
                                                <!-- <tr style="border: none;">
                                                    <td style="border: none;">
                                                        <strong><?php echo $row_name_sql['client_contact_name'] . "<br> (" . $row_name_sql['client_contact_no'] . ")"; ?></strong>
                                                    </td>
                                                </tr> -->
                                                <div class="row" style="margin-bottom: 2px;">
                                                    <div class="col-md-12">
                                                        <strong><?php echo $row_name_sql['client_contact_name'] . "<br> (" . $row_name_sql['client_contact_no'] . ")"; ?></strong>
                                                    </div>
                                                </div>
<?php
        }
    }

?>                       
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1">
                                                     <form action="add_client_contact.php" method="post">
                                                        <input type="hidden" name="post_client_id" value="<?php echo $row['client_id']; ?>">
                                                        <button class="btn btn-primary btn-xs">Add Contact</button>
                                                        <!-- <div class="tooltips" data-original-title="Add Contact">
                                                            <button class="btn btn-primary btn-xs"><span class="fa fa-plus-square"></span></button>
                                                        </div> -->
                                                    </form>
                                                </div>
                                                <div class="col-md-1">
                                                    <form action="clients_update_info.php" method="post">
                                                        <input type="hidden" name="post_client_id" value="<?php echo $row['client_id']; ?>">
                                                        <button class="btn btn-warning btn-xs">Edit</button>

                                                        <!-- <div class="tooltips" data-original-title="Edit">
                                                            <button class="btn btn-danger btn-xs" style="margin-bottom: 5px;"><span class="fa fa-edit"></span></button>
                                                        </div> -->
                                                    </form>
                                                </div>
                                                <div class="col-md-1">
                                                     <form action="client_sites.php" method="post">
                                                        <input type="hidden" name="post_client_id" value="<?php echo $row['client_id']; ?>">
                                                        <button class="btn btn-success btn-xs">View Sites</button>
                                                        <!-- <div class="tooltips" data-original-title="View Sites">
                                                            <button class="btn btn-default btn-xs" style="margin-bottom: 5px;"><span class="fa fa-eye"></span></button>
                                                        </div> -->
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- <a href="client_sites.php">View Sites <span class="fa fa-chevron-right"></span></a> -->
                                        </td>
                                    </tr>
<?php
            $hash++;
        }
    }else{
        
        if($_GET['search'] == ''){
            $search_word = "";
        }else{
            $search_word = $_GET['search'];
        }

        if($_GET['search'] != ''){
            $string = " WHERE (client_name LIKE '%".$search_word."%' OR address LIKE '%".$search_word."%') ";
        }else{
            $string = "";
        }

        $sql = "SELECT * FROM client ".$string;

        $result = mysqli_query($db, $sql); 
        $total = mysqli_num_rows($result);

        $adjacents = 3;
        $targetpage = "clients.php"; //your file name
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
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&search=$search_word\">Previous</a></li>"; 
            }

            if ($lastpage < 7 + ($adjacents * 2)) { 
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&search=$search_word\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&search=$search_word\">$lastpage</a></li>"; 
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&search=$search_word\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&search=$search_word\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&search=$search_word\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&search=$search_word\">$lastpage</a></li>"; 
                }
                //close to end; only hide early pages
                else{
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&search=$search_word\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&search=$search_word\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&search=$search_word\">$counter</a></li>"; 
                    }
                }
            }

            //next button
            if ($page < $counter - 1) 
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&search=$search_word\">Next</a></li>";
            else
                $pagination.= "";
            $pagination.= "</ul></div>\n"; 
        }

        $sql_client = "SELECT * FROM client ".$string." ORDER BY client_name ASC LIMIT $start, $limit";
        $result_client = mysqli_query($db, $sql_client);
        // echo $sql_client;
        $hash = 1;
        while ($row = mysqli_fetch_assoc($result_client)) {
            
            $sql_contact = "SELECT p.client_contact_id, GROUP_CONCAT(DISTINCT p.client_contact_name ORDER BY p.client_contact_name ASC SEPARATOR ', ') as client_contact_name, p.client_id, n.client_contact_no 
                            FROM client_contact_person p, client_contact_number n
                            WHERE p.client_contact_id = n.client_contact_id
                            AND p.client_id = '".$row['client_id']."'";

            $result_contact = mysqli_query($db, $sql_contact);
            $row_contact = mysqli_fetch_assoc($result_contact);

            $row['client_contact_name'] = $row_contact['client_contact_name'];
?>
                                    <tr>
                                        <td><strong><?php echo $row['client_name']; ?></strong></td>
                                        <td><strong><?php echo $row['address']; ?></strong></td>
                                        <!-- <td><strong><?php echo $row['client_contact_name']; ?></strong></td> -->
                                        <td>
                                            
<?php

    $name_sql = "SELECT DISTINCT client_contact_id, client_contact_name
                    FROM client_contact_person
                    WHERE client_id = '".$row['client_id']."'";

    $name_sql_result = mysqli_query($db, $name_sql);
    while ($row_name_sql = mysqli_fetch_assoc($name_sql_result)) {
        
        $no_sql = "SELECT GROUP_CONCAT(DISTINCT client_contact_no SEPARATOR ', ') as client_contact_no
                    FROM client_contact_number
                    WHERE client_contact_id = '".$row_name_sql['client_contact_id']."'";

        $no_sql_result = mysqli_query($db, $no_sql);
        while ($row_no_sql = mysqli_fetch_assoc($no_sql_result)) {
            
            $row_name_sql['client_contact_no'] = $row_no_sql['client_contact_no'];
?>
                                                <div class="row" style="margin-bottom: 2px;">
                                                    <div class="col-md-12">
                                                        <strong><?php echo $row_name_sql['client_contact_name'] . "<br> (" . $row_name_sql['client_contact_no'] . ")"; ?></strong>
                                                    </div>
                                                </div>
<?php
        }
    }

?>                       
                                        </td>
                                        <td>
                                            <div class="row" style="margin-bottom: 2px;">
                                                <div class="col-md-1">
                                                     <form action="add_client_contact.php" method="post">
                                                        <input type="hidden" name="post_client_id" value="<?php echo $row['client_id']; ?>">
                                                        <button class="btn btn-primary btn-xs">Add Contact</button>
                                                        <!-- <div class="tooltips" data-original-title="Add Contact">
                                                            <button class="btn btn-primary btn-xs"><span class="fa fa-plus-square"></span></button>
                                                        </div> -->
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 2px;">
                                                <div class="col-md-1">
                                                    <form action="clients_update_info.php" method="post">
                                                        <input type="hidden" name="post_client_id" value="<?php echo $row['client_id']; ?>">
                                                        <button class="btn btn-warning btn-xs">Edit</button>

                                                        <!-- <div class="tooltips" data-original-title="Edit">
                                                            <button class="btn btn-danger btn-xs" style="margin-bottom: 5px;"><span class="fa fa-edit"></span></button>
                                                        </div> -->
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: 2px;">
                                                <div class="col-md-1">
                                                     <form action="client_sites.php" method="post">
                                                        <input type="hidden" name="post_client_id" value="<?php echo $row['client_id']; ?>">
                                                        <button class="btn btn-success btn-xs">View Sites</button>
                                                        <!-- <div class="tooltips" data-original-title="View Sites">
                                                            <button class="btn btn-default btn-xs" style="margin-bottom: 5px;"><span class="fa fa-eye"></span></button>
                                                        </div> -->
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- <a href="client_sites.php">View Sites <span class="fa fa-chevron-right"></span></a> -->
                                        </td>
                                    </tr>
<?php
            $hash++;
        }
    }
?>

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
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
</section>
</body>
</html>
