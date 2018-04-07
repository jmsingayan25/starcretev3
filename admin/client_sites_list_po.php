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

    if(isset($_REQUEST['post_site_id'])){
    	$_SESSION['post_site_id'] = $_REQUEST['post_site_id'];
    }

    $site_id = $_SESSION['post_site_id'];

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];
    $limit = 25;

    $client = getClientInfoBySiteId($db, $site_id);
    $client_id = $client['client_id'];
    $client_name = $client['client_name'];
    $client_address = $client['address'];

    $project = getSiteInfo($db, $site_id);
    $project_name = $project['site_name'];
    $project_address = $project['site_address'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>List of P.O. No.</title>

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
                 $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="7" style="height: 100%;background: white; text-align:center; vertical-align:middle;"><h4><p class="text-muted">No data found</p></h4></td></tr>'));
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
.page_links a{
    color: inherit;
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
	                <div class="col-md-12 page_links">
	                    <ol class="breadcrumb">
	                        <li><i class="fa fa-address-book"></i><a href="clients.php">Clients</a></li>
	                        <li><i class="fa fa-building"></i><?php echo $client_name; ?></li>    
	                        <li><i class="fa fa-address-card"></i><a href="client_sites.php"><?php echo $project_name; ?></a></li>                         
	                        <li><i class="fa fa-file"></i><a href="client_sites_list_po.php" style="color: blue;">List of P.O. No.</a></li>
	                    </ol>
	                </div>
	            </div>

	            <div class="row">
	            	<div class="col-md-9">
	                    <section class="panel">
	                         <header class="panel-heading">
	                         	<div class="row">
	                                <div class="col-md-12">
		                                <span>Project Name: <strong><?php echo $project_name; ?></strong></span><br>
		                                <span>Project Address: <strong><?php echo $project_address; ?></strong></span>
	                                </div>
	                            </div>
	                        </header>
	                        <div class="table-responsive filterable">
	                            <table class="table table-striped table-bordered">
	                                <thead>
	                                	<tr class="filterable">
                                            <th colspan="7"><button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="fa fa-filter"></span> Filter</button></th>
                                        </tr>
	                                	<tr class="filters">
	                                		<th class="col-md-1">#</th>
	                                		<th class="col-md-1"><input class="form-control" placeholder="P.O. No." disabled></th>
	                                		<th class="col-md-1"><input class="form-control" placeholder="Item" disabled></th>
	                                		<th class="col-md-1">Quantity</th>
	                                		<th class="col-md-1">Date Order</th>
	                                		<th class="col-md-1">Date Close</th>
	                                		<th class="col-md-1">Status</th>
	                                	</tr>
	                                </thead>
	                                <tbody>
<?php

	$sql = "SELECT *, DATE_FORMAT(date_purchase,'%m/%d/%y') as date_purchase
			FROM purchase_order 
			WHERE site_id = '$site_id'
			ORDER BY date_purchase DESC";

	$result = mysqli_query($db, $sql);
	if(mysqli_num_rows($result) > 0){
		
		$hash = 1;
		while ($row = mysqli_fetch_assoc($result)) {
?>
			<tr>
				<td><?php echo $hash; ?></td>
				<td><strong><?php echo $row['purchase_order_no']; ?></strong></td>
				<td><strong><?php echo $row['item_no']; ?></strong></td>
				<td><strong><?php echo number_format($row['quantity']); ?></strong></td>
				<td><strong><?php echo $row['date_purchase']; ?></strong></td>
				<td>
<?php

			$sql_closed = "SELECT DATE_FORMAT(date_closed,'%m/%d/%y') as date_closed FROM purchase_order_deliveries
							WHERE purchase_order_id = '".$row['purchase_id']."' AND status != ''";

			$sql_closed_result = mysqli_query($db, $sql_closed);
			if(mysqli_num_rows($sql_closed_result) > 0){
				$sql_closed_row = mysqli_fetch_assoc($sql_closed_result);
?>
				<strong><?php echo $sql_closed_row['date_closed']; ?></strong>
<?php
			}
?>
				</td>
				<td><strong><?php echo $row['remarks']; ?></strong></td>
			</tr>
<?php
			$hash++;
		}
	}else{
?>
		<tr>        
            <td colspan="7" style='height: 100%; background: white; border: none; text-align:center; 
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
	                 <div class="col-md-3">
	                 	<section class="panel">
                            <!-- <header class="panel-heading">
                                Contact Details
                            </header> -->
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

	$sql_contact = "SELECT * FROM site_contact_person
					WHERE site_id = '$site_id'";

	$sql_contact_result = mysqli_query($db, $sql_contact);
	if(mysqli_num_rows($sql_contact_result) > 0){

		while ($sql_contact_row = mysqli_fetch_assoc($sql_contact_result)) {
?>
			<tr>
				<td><strong><?php echo $sql_contact_row['site_contact_name']; ?></strong></td>
<?php
	
			$sql_contact_no = "SELECT *, GROUP_CONCAT(site_contact_no SEPARATOR ', ') as site_contact_no  
								FROM site_contact_number
								WHERE site_contact_person_id = '".$sql_contact_row['site_contact_person_id']."'";
								// echo $sql_contact_no;
			$sql_contact_no_result = mysqli_query($db, $sql_contact_no);
			while ($sql_contact_no_row = mysqli_fetch_assoc($sql_contact_no_result)) {
?>
				<td><strong><?php echo $sql_contact_no_row['site_contact_no']; ?></strong></td>
<?php
			}
?>
			</tr>
<?php
		}
	}else{
?>
		<tr>        
            <td colspan="2" style='height: 100%; background: white; border: none; text-align:center; 
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
	        </section>
	    </section>
	</section>
</body>
</html>