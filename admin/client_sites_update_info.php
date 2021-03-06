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
		$_SESSION['site_id'] = $_REQUEST['post_site_id'];
	}

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];

    $info = getSiteInfo($db, $_SESSION['site_id']);
    $site_id = $info['site_id'];
    $site_name = $info['site_name'];
    $site_address = $info['site_address'];

    $client = getClientInfoBySiteId($db, $site_id);
    $client_id = $client['client_id'];
    $client_name = $client['client_name'];
    $client_address = $client['address'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Update Details - <?php echo $site_name; ?></title>

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
</script>
<style>
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
                    <!-- <h3 class="page-header"><i class="fa fa-laptop"></i> <?php echo $site_name; ?></h3> -->
                    <ol class="breadcrumb">
                        <!-- <li><i class="fa fa-home"></i>Home</li> -->
                        <li><i class="fa fa-address-book"></i><a href="clients.php">Clients</a></li>
                        <li><i class="fa fa-building"></i><a href="client_sites.php"><?php echo $client_name; ?></a></li>
                        <li><i class="fa fa-building"></i><a href="client_sites_update_info.php"><?php echo $site_name; ?></a></li>
                        <li><i class="fa fa-file-text"></i>Update Info</li>                            
                    </ol>
                </div>
            </div>

            <form class="form-horizontal" role="form" action="client_sites_update_info.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
				<div class="row">
					<div class="col-md-6">
						<section class="panel">
							<header class="panel-heading">
							Project Info
							</header>
							<div class="panel-body">
								<div class="form-group">
									<label for="update_site_name" class="col-md-4 control-label">Project Name</label>
									<div class="col-md-8">
										<!-- <input type="text" id="update_site_name" name="update_site_name" class="form-control" autocomplete="off" value="<?php echo $site_name; ?>" required> -->
                                        <textarea name="update_site_name" class="form-control" style="resize: none;" required><?php echo $site_name; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="update_site_address" class="col-md-4 control-label">Project Address</label>
									<div class="col-md-8">
										<!-- <input type="text" id="update_site_address" name="update_site_address" class="form-control" autocomplete="off" value="<?php echo $site_address; ?>" required> -->
                                        <textarea name="update_site_address" class="form-control" rows="5" style="resize: none;" required><?php echo $site_address; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-8 col-md-4">
										<input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary" style="font-weight: bold;">
                                        <a href="client_sites.php" class="btn btn-default"><strong>Cancel</strong></a>

										<!-- <input type="reset" name="reset" id="reset" value="Reset" class="btn btn-default" style="font-weight: bold;"> -->
									</div>
								</div>
							</div>
						</section>
					</div>
					<div class="col-md-6">
						<section class="panel">
							<header class="panel-heading">
							Contact
							</header>
							<div class="panel-body">
								<div class="row">
									<table id="item_table" align="center">								
<?php

    $sql_contact = "SELECT site_contact_person_id, site_contact_name
                    FROM site_contact_person
                    WHERE site_id = '$site_id'";
                    // echo $sql_contact;
    $result_sql_contact = mysqli_query($db, $sql_contact);
    if (mysqli_num_rows($result_sql_contact) > 0) {
        $hash = 1;
?>
                                        <tr>
                                            <td class="col-md-4">
                                                <label for="item_no">Name</label>
                                            </td>
                                            <td class="col-md-4">
                                                <label for="quantity">Number</label>
                                            </td>
                                            <td class="col-md-4">
                                                <!-- <label for="button"></label> -->
                                            </td>
                                        </tr>
<?php
        while ($sql_row = mysqli_fetch_assoc($result_sql_contact)) {
?>
                                        <tr id="row<?php echo $hash; ?>" style="text-align: center; vertical-align: top;">
                                            <td class="col-md-6">
                                                <div class="row" style="margin-bottom: 5px;">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="contact_person_id[]" value="<?php echo $sql_row['site_contact_person_id']; ?>">
                                                        <input type="text" name="update_contact_name[]" class="form-control" autocomplete="off" value="<?php echo $sql_row['site_contact_name']; ?>" required>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-md-6">
<?php

    $sql_no = "SELECT site_contact_no_id, site_contact_no
                FROM site_contact_number
                WHERE site_contact_person_id = '".$sql_row['site_contact_person_id']."'";

    $result_sql_no = mysqli_query($db, $sql_no);
    while ($sql_no_row = mysqli_fetch_assoc($result_sql_no)) {

        $array_contact['contact'][] = array(
                                        'site' => array(
                                            'site_contact_id' => $sql_row['site_contact_person_id'], 
                                            'contact_no_id' => $sql_no_row['site_contact_no_id']
                                        )
                                    );
?>
                                            <div class="row" style="margin-bottom: 5px;">
                                                <input type="hidden" name="site_contact_no_id[]" value="<?php echo $sql_no_row['site_contact_no_id']; ?>">
                                                <div class="col-md-7">
                                                    <input type="text" name="update_contact_no[]" class="form-control" autocomplete="off" value="<?php echo $sql_no_row['site_contact_no']; ?>" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <form action="client_sites_update_info.php" method="post" onsubmit="return confirm('Proceed?');">
                                                        <input type="hidden" name="hidden_contact_id" value="<?php echo $sql_row['site_contact_person_id']; ?>">
                                                        <input type="hidden" name="hidden_contact_no_id" value="<?php echo $sql_no_row['site_contact_no_id']; ?>">
                                                        <button type="submit" name="delete_id" class='btn btn-danger btn-sm btn-block' autocomplete="off" style="font-weight: bold;">Remove</button>
                                                    </form>
                                                </div>
                                            </div>


<?php
    }
?>
                                            <div class="row" style="margin-bottom: 5px;">
                                                    <div class="col-md-5 col-md-offset-7">
                                                        <button type="submit" name="add_new_no" value="<?php echo $sql_row['site_contact_person_id']; ?>" class='btn btn-sm btn-block' style="float: left; font-weight: bold; background-color: #1976d2; color: white;">Add New No.</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
<?php
            $hash++;
        }
    }else{
?>
                                        <div class="row" style="text-align: center;">
                                            <strong><h4><p class='text-muted'>No data found</p></h4></strong>
                                        </div>
    }
<?php
    }
?>
									</table>
								</div>
							</div>
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

	// if (isset($_POST['submit'])) {
		
	// 	$count = 0;
	// 	$update_site_name = mysqli_real_escape_string($db, $_POST['update_site_name']);
	// 	$update_site_address = mysqli_real_escape_string($db, $_POST['update_site_address']);
	// 	$update_contact_name = $_POST['contact_name'];
	// 	$update_contact_no = $_POST['contact_no'];
	// 	$hidden_contact_id = $_POST['contact_id'];

	// 	$update_site = "UPDATE site 
	// 					SET site_name = '$update_site_name', site_address = '$update_site_address'
	// 					WHERE site_id = '$site_id'";

	// 	echo $update_site."<br>";
	// 	// mysqli_query($db, $update_site);

	// 	for ($i=0; $i < count($update_contact_name); $i++) { 
			
	// 		$update_contact = "UPDATE site_contact_person p, site_contact_number n 
	// 							SET p.site_contact_name = '$update_contact_name[$i]', n.site_contact_no = '$update_contact_no[$i]'
	// 							WHERE p.site_id = $site_id 
	// 							AND p.site_contact_person_id = '$hidden_contact_id[$i]'
	// 							AND n.site_contact_person_id = '$hidden_contact_id[$i]'";

	// 		echo $update_contact."<br>";
	// 		// mysqli_query($db, $update_contact);
	// 		$count++;
	// 	}

	// 	if($count == count($update_contact_name)){
	// 		echo "<script> alert('Data updated successfully...');
	// 				window.location.href='client_sites.php'
	// 				</script>";
	// 	}

	// }

    if(isset($_POST['submit'])){

        $count = 0;
        $update_site_name = mysqli_real_escape_string($db, $_POST['update_site_name']);
        $update_site_address = mysqli_real_escape_string($db, $_POST['update_site_address']);
        
        $update_site = "UPDATE site 
                         SET site_name = '$update_site_name', site_address = '$update_site_address'
                         WHERE site_id = '$site_id'";

        mysqli_query($db, $update_site);

        if(isset($_POST['contact_person_id'])){

            $contact_person_id = $_POST['contact_person_id'];
            $update_contact_name = $_POST['update_contact_name'];
            $update_contact_no = $_POST['update_contact_no'];
            $contact_encode = json_encode($array_contact);
            $contact_decode = json_decode($contact_encode);

            // echo $contact_encode;

            if(count($contact_decode->contact) > 0){

                for ($i=0; $i < count($contact_decode->contact); $i++) { 

                    $site_contact_id = $contact_decode->contact[$i]->site->site_contact_id;
                    $site_contact_no_id = $contact_decode->contact[$i]->site->contact_no_id;

                    $escape_update_contact_no = mysqli_real_escape_string($db, $update_contact_no[$i]);
                    $update_contact_info = "UPDATE site_contact_number 
                                            SET site_contact_no = '$escape_update_contact_no' 
                                            WHERE site_contact_person_id = '$site_contact_id'
                                            AND site_contact_no_id = '$site_contact_no_id'";

                    // echo $update_contact_info."<br>";
                    mysqli_query($db, $update_contact_info); 
                    $count++;   
                }

                for ($j=0; $j < count($contact_person_id); $j++) { 
                        
                    $escape_update_contact_name = mysqli_real_escape_string($db, $update_contact_name[$j]);
                    $update_name = "UPDATE site_contact_person 
                                    SET site_contact_name = '$escape_update_contact_name'
                                    WHERE site_contact_person_id = '$contact_person_id[$j]'";

                    // echo $update_name."<br>";
                    mysqli_query($db, $update_name);
                }

                if($count == count($contact_decode->contact)){
                    echo "<script> 
                            alert('Data updated successfully...');
                            window.location.href='client_sites.php' 
                        </script>";
                }
            }else{
                echo "<script> 
                        alert('Data updated successfully...');
                        window.location.href='client_sites.php'
                    </script>";
            }
        }else{
            echo "<script> 
                    alert('Data updated successfully...');
                    window.location.href='client_sites.php'
                </script>";
        }
    }else if(isset($_POST['delete_id'])) {
        
        $site_contact_id = $_POST['hidden_contact_id'];
        $site_contact_no_id = $_POST['hidden_contact_no_id'];


        $delete_contact_no = "DELETE FROM site_contact_number WHERE site_contact_no_id = '$site_contact_no_id'";
        // echo $delete_contact_no."<br>";
        if(mysqli_query($db, $delete_contact_no)){
            phpAlert("Contact No. has been deleted...");
            echo "<meta http-equiv='refresh' content='0'>";
        }

        $sql_no_count_query = "SELECT * FROM site_contact_number
                                WHERE site_contact_person_id = '$site_contact_id'";

        $sql_count = mysqli_query($db, $sql_no_count_query);
        if(mysqli_num_rows($sql_count) == 0){

            $delete_contact_person = "DELETE FROM site_contact_person WHERE site_contact_person_id = '$site_contact_id'";

            if(mysqli_query($db, $delete_contact_person)){
                phpAlert("Contact has been deleted...");
                echo "<meta http-equiv='refresh' content='0'>";
            }

            // echo $delete_contact_person."<br>";
        }
    }else if(isset($_POST['add_new_no'])){
        
        $site_contact_id = $_POST['add_new_no'];
        // phpAlert($client_contact_id);
        $_SESSION['post_site_contact_id'] = $site_contact_id;
        header("location: add_site_contact_new_no.php");

    }


?>