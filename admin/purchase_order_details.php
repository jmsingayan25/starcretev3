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

    if (isset($_REQUEST['purchase_unique_id']) && isset($_REQUEST['purchase_order_no']) && isset($_REQUEST['office'])) {
        $_SESSION['post_purchase_unique_id'] = $_REQUEST['purchase_unique_id'];
    	$_SESSION['post_purchase_order_no'] = $_REQUEST['purchase_order_no'];
        $_SESSION['post_office'] = $_REQUEST['office'];
    }

    $purchase_unique_id = $_SESSION['post_purchase_unique_id'];
    $purchase_order_no = $_SESSION['post_purchase_order_no'];
    $plant = $_SESSION['post_office'];

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
	$user_query->bind_param('s', $_SESSION['login_user']);
	$user_query->execute();
	$result = $user_query->get_result();
	$user = $result->fetch_assoc();

	$office = $user['office'];
	$position = $user['position'];

	// $po = getPurchaseOrderDetails($db, $purchase_unique_id);
	// $po_no = $po['purchase_order_no'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>P.O. No. Details - Purchase Order</title>

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
                 $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="9" style="min-height: 100%;background: white; text-align:center; vertical-align:middle;"><h4><p class="text-muted">No data found</p></h4></td></tr>'));
            }
        });

        $.ajax({
            url: 'delivery_po_details.php',
            method: get,
            data:{
                var1 : val1
            },
            success: function(response){
                $('#tbody').html(response);     // it will update the html of table body
            }
        });
    });

</script>
<style>
.table_page{
    margin: auto;
    margin-top: -30px;
    width: 50%;
    text-align: center;
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
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i><?php echo ucfirst($plant); ?></li>
                            <li><i class="icon_document"></i><a href="purchase_order.php?office=<?php echo $plant; ?>">Pending P.O.</a></li>                            
                            <li><i class="icon_document"></i>P.O. Details</li>                          
                        </ol>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-9">
                         <div class="row">
                            <div class="col-md-12">
                                <header class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6" style="text-align: left;">
                                            <span>Order Details of P.O. No. <strong><?php echo $purchase_order_no; ?></strong></span>
                                        </div>
                                        <div class="col-md-6" style="text-align: right;">
                                            <span>
<?php

    $sql_select = "SELECT * FROM delivery
                    WHERE po_no_delivery = '$purchase_order_no'
                    AND fk_unique_po_id = '$purchase_unique_id'
                    AND remarks = 'Ongoing Delivery'";
    // echo $sql_select;
    $sql_select_result = mysqli_query($db, $sql_select);
    if(mysqli_num_rows($sql_select_result) <= 0){
        $disabled = "";
        $info = " <span data-original-title='Button not disable. No Item(s) in ONGOING DELIVERY Status' class='fa fa-info-circle fa-lg tooltips' data-placement='top' style='color: #d32f2f;'></span>";
    }else{
        $disabled = "disabled";
        $info = " <span data-original-title='Button disable. An Item(s) is in ONGOING DELIVERY Status' class='fa fa-info-circle fa-lg tooltips' data-placement='top' style='color: #d32f2f;'></span>";
    }
?>

                    <form action="purchase_order_details.php" method="post">
                        <?php echo $info; ?> <button type="button" class="btn btn-sm" style="background-color: #d32f2f; color: white;" data-toggle='modal' data-target='#purchaseOrderClosedRow' <?php echo $disabled; ?>><span class="fa fa-edit"></span> <strong>Click to Close P.O. No. <?php echo $purchase_order_no; ?></strong></button>

                        <div class="modal fade" id="purchaseOrderClosedRow" role="dialog">
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
                                        <!-- <h4 class="modal-title" style="text-align: center">Closed P.O. No. <?php echo $row['purchase_order_no'] . " " . $row['item_no'] . " " . $row['psi']; ?></h4> -->
                                        <!-- <hr> -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <!-- <label for="radiooption">
                                                        <input type="radio" name="radiooption" id="radiooption" value="served_only" onchange="disableTextArea(this.value)" checked> Served Only
                                                    </label>
                                                    <br>
                                                    <label for="radiooption">
                                                        <input type="radio" name="radiooption" id="radiooption" value="closed_only" onchange="disableTextArea(this.value)"> Reason for closing P.O. No. <strong><?php echo $row['purchase_order_no'] . " " . $row['item_no'] . " " . $row['psi']; ?></strong>
                                                    </label> -->
                                                    <label for="radiooption">Reason for closing P.O. No. <strong><?php echo $purchase_order_no; ?></strong></label>
                                                    <textarea name="reason" id="reason" rows="5" class="form-control inputArea" placeholder="Type here..." style="resize: none;" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="closed" id="closed" class="btn btn-primary"><strong>Submit</strong></button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><strong>Close</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                                            </span>     
                                        </div>
                                    </div>
                                </header>
                                <section class="panel">
                                    <div class="table-responsive filterable">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr class="filterable">
                                                    <th colspan="8">
                                                        <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="fa fa-filter"></span> Filter</button>
                                                    </th>
                                                </tr>
                                                <tr class="filters">
                                                    <th class="col-md-1">#</th>
                                                    <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                                    <th class="col-md-1">Quantity</th>
                                                    <th class="col-md-1">Balance</th>
                                                    <th class="col-md-2"><input type="text" class="form-control" placeholder="Project Name" disabled></th>
                                                    <th class="col-md-2"><input type="text" class="form-control" placeholder="Address" disabled></th>
                                                    <th class="col-md-1">Date Order</th>
                                                    <th class="col-md-1">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php

    $sql = "SELECT *, DATE_FORMAT(date_purchase,'%m/%d/%y') as date_purchase, s.site_name, s.site_address FROM purchase_order p, site s 
            WHERE p.site_id = s.site_id
            AND purchase_order_no = '$purchase_order_no' 
            AND purchase_unique_id = '$purchase_unique_id'
            AND office = '$plant'
            ORDER BY item_no";
            // echo $sql;
    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result) > 0){

        $hash = 1;
        while ($row = mysqli_fetch_assoc($result)) {

            if($row['psi'] != ""){
                $row['psi'] = "(" . $row['psi'] . " PSI)";
            }else{
                $row['psi'] = "";
            }
?>
            <tr>
                <td><?php echo $hash; ?></td>
                <td><strong><?php echo $row['item_no'] . " " . $row['psi']; ?></strong></td>
                <td><strong><?php echo number_format($row['quantity']); ?></strong></td>
                <td><strong><?php echo number_format($row['balance']); ?></strong></td>
                <td><strong><?php echo $row['site_name']; ?></strong></td>
                <td><strong><?php echo $row['site_address']; ?></strong></td>
                <td><strong><?php echo $row['date_purchase']; ?></strong></td>
                <td>
<?php
            if($row['balance'] > 0){
?>

                    <form action="purchase_order_details.php" method="post">
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
            }
?>
                    
                </td>
            </tr>
<?php
            $hash++;
        }
    }else{
?>
        <tr>
            <td colspan="8" style='min-height: 100%; background: white; text-align:center; vertical-align: middle;'><h4><p class='text-muted'>No data found</p></h4>
            </td>
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
                    </div>
                    <div class="col-md-3">
                        <section class="panel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Contact No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php

    $contact_sql = "SELECT DISTINCT p.site_contact_id, c.site_contact_name
                FROM purchase_order_contact p, purchase_order d, site_contact_person c
                WHERE d.purchase_id = p.purchase_id
                AND p.site_contact_id = c.site_contact_person_id
                AND d.purchase_unique_id = '$purchase_unique_id'
                ORDER BY c.site_contact_name";
                // echo $contact_sql;
    $contact_sql_result = mysqli_query($db, $contact_sql);
    if(mysqli_num_rows($contact_sql_result) > 0){
        while ($contact_sql_row = mysqli_fetch_assoc($contact_sql_result)) {
?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $contact_sql_row['site_contact_name']; ?></strong>
                                            </td>
<?php
    
                $no_sql = "SELECT GROUP_CONCAT(site_contact_no SEPARATOR ', ') as site_contact_no 
                            FROM site_contact_number
                            WHERE site_contact_person_id = '".$contact_sql_row['site_contact_id']."'";

                $no_sql_result = mysqli_query($db, $no_sql);
                while ($no_sql_row = mysqli_fetch_assoc($no_sql_result)) {
?> 
                                            <td>
                                                <strong><?php echo $no_sql_row['site_contact_no']; ?></strong>
                                            </td>
                                        </tr>
<?php
            }
        }
    }else{
?>
                                        <tr>
                                            <td colspan="2" style='min-height: 100%; background: white; text-align:center; vertical-align: middle;'><h4><p class='text-muted'>No data found</p></h4>
                                            </td>
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

    if(isset($_POST['update'])){

        $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
        $password = mysqli_real_escape_string($db, crypt($_POST['confirm_password'], '$1$' . $_POST['confirm_password']));

        $sql_update = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result_update = mysqli_query($db, $sql_update);

        if(mysqli_num_rows($result_update) > 0){
            $_SESSION['post_purchase_id'] = $_POST['update'];
            $_SESSION['post_purchase_unique_id'] = $purchase_unique_id;
            // $_SESSION['post_office'] = $_GET;
            header("location: purchase_order_update.php");
            // echo $purchase_id;
            // echo json_encode($_SESSION);
        }else{
            phpAlert("Invalid username or password of Admin");
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }else if(isset($_POST['closed'])){

        // echo $purchase_order_no;
        $datetime = date("Y-m-d H:i:s");
        $reason = $_POST['reason'];
        $item_array = array();

        $sql = "SELECT *, s.site_name, c.client_name 
                FROM purchase_order p, site s, client c 
                WHERE p.site_id = s.site_id 
                AND s.client_id = c.client_id 
                AND purchase_unique_id = '$purchase_unique_id'";

        $result = mysqli_query($db, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            
             
            
            $purchase_id = $row['purchase_id'];
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

            if($balance != 0){

                if(!in_array($row['item_no'], $item_array)){
                    $item_array[] = array('item_no' => $row['item_no'], 'balance' => $row['balance'], 'psi' => $row['psi']); 
                }

                $update = "UPDATE purchase_order 
                    SET cancelled = cancelled + '$balance', balance = 0, remarks = 'Closed', date_cancelled = '$datetime'
                    WHERE purchase_id = '$purchase_id'";

                $insert_closed = "INSERT INTO purchase_order_deliveries(purchase_order_id, purchase_order_no, quantity, reason, status, date_closed) VALUES ('$purchase_id','$po_no','$balance','$reason','Closed', '$datetime')";  

                // echo $insert_closed . "<br>";
                // echo $update . "<br>";

                mysqli_query($db, $update);
                mysqli_query($db, $insert_closed);
            }
            
            $sql_po_id = "SELECT * FROM purchase_order_deliveries WHERE purchase_order_id = '$purchase_id'";
            $sql_po_id_result = mysqli_query($db, $sql_po_id);

            if(mysqli_num_rows($sql_po_id_result) > 0){
                $update_deliveries = "UPDATE purchase_order_deliveries SET status = 'Closed' WHERE purchase_order_id = '$purchase_id'";

                // echo $update_deliveries . "<br>";
                mysqli_query($db, $update_deliveries);
            }
        }

        $item = json_encode($item_array);
        $item_decode = json_decode($item);

        for ($i=0; $i < count($item_decode); $i++) { 
            
            $item_no_obj = $item_decode[$i]->item_no;
            $balance_obj = $item_decode[$i]->balance;
            $psi_obj = $item_decode[$i]->psi;

            if($psi_obj != ""){
                $psi_ext = "(" . $psi_obj . " PSI)";
            }else{
                $psi_ext = "";
            }

            // if($balance_obj != 0){
                if($i == 0){
                    $item_ext = number_format($balance_obj)." pcs of $item_no_obj $psi_ext";
                }else if($i == (count($item_decode) - 1)){
                    $item_ext .= " and ".number_format($balance_obj)." pcs of $item_no_obj $psi_ext";
                }else{
                    $item_ext .= ", ".number_format($balance_obj)." pcs of $item_no_obj $psi_ext";
                }
            // }
        }

        $history = "INSERT INTO history(table_report,transaction_type,item_no,detail,history_date,office) 
                    VALUES('Purchase Order','Closed P.O. No.','$item_no','P.O. No. $po_no with remaining balance of $item_ext order by $client has been closed with a reason of $reason','$datetime','$plant')";

        // echo $history . "<br>";

        if(mysqli_query($db, $history)){
            echo "<script> alert('P.O. No. $po_no has been closed'); window.location.href='purchase_order.php?office=$plant' </script>";            
        }
    }

?>