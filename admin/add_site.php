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

    if(isset($_REQUEST['post_client_id'])){
		$_SESSION['client_id'] = $_REQUEST['post_client_id'];
	}

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];

    $info = getClientInfo($db, $_SESSION['client_id']);
    $client_id = $info['client_id'];
    $client_name = $info['client_name'];
    $client_address = $info['address'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>New Project - Projects</title>

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

	function add_row(){
		$rowno=$("#item_table tr").length;
		$rowno=$rowno+1;
		$("#item_table tr:last").after("<tr id='row"+$rowno+"' style='text-align: center;'><td class='col-md-4'><div class='form-group'><input type='type' name='contact_name[]' class='form-control' autocomplete='off' required></div></td><td class='col-md-4'><div class='form-group'><input type='type' name='contact_no[]' class='form-control' autocomplete='off' required></div></td><td class='col-md-4'><div class='form-group'><input type='button' value='Remove' class='btn btn-danger btn-md' onclick=delete_row('row"+$rowno+"') style='font-weight: bold;'></div></td></tr>");
	}

	function delete_row(rowno){
		$('#'+rowno).remove();
	}

</script>
<style>
/*.page_links a{
	color: inherit;
}*/
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
	<!--                 <li class="sub-menu">                       
	                    <a class="" href="form_validation.html">Form Validation</a>
	                </li>   --> 
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
	                    <!-- <h3 class="page-header"><i class="fa fa-laptop"></i> New Client</h3> -->
	                    <ol class="breadcrumb">
	                        <li><i class="fa fa-address-book"></i><a href="clients.php">Clients</a></li>
	                        <li><i class="fa fa-building"></i><a href="client_sites.php"><?php echo $client_name; ?></a></li>
	                        <!-- <li><a href="client_sites.php"><i class="icon_document_alt"></i>Sites</a></li> -->
	                        <li><i class="icon_document"></i>New Project</li>						  	
	                    </ol>
	                </div>
	            </div>
	            <!-- Basic Forms & Horizontal Forms-->
	            <form class="form-horizontal" role="form" action="add_site.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
	            	<div class="row">
	            		<!-- Start column for client and site info -->
	            		<div class="col-md-6">
	            			<div class="row">
								<div class="col-md-12">
									<section class="panel">
										<header class="panel-heading">
										Client Info
										</header>
										<div class="panel-body">
											<div class="form-group">
												<label for="client_name" class="col-md-4 control-label">Client Name: </label>
												<div class="col-md-8">
													<!-- <label class="control-label"><?php echo $client_name; ?></label> -->
													<p class="help-block"><?php echo $client_name; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label for="client_address" class="col-md-4 control-label">Client Address: </label>
												<div class="col-md-8">
													<!-- <label class="control-label"><?php echo $client_address; ?></label> -->
													<p class="help-block"><?php echo $client_address; ?></p>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<section class="panel">
										<header class="panel-heading">
										Project Info
										</header>
										<div class="panel-body">
											<div class="form-group">
												<label for="site_name" class="col-md-4 control-label">Project Name<span class="required" style="color: red;">*</span></label>
												<div class="col-md-8">
													<!-- <input type="text" name="site_name" class="form-control" required> -->
													<textarea name="site_name" class="form-control" style="resize: none;" required></textarea>
												</div>
											</div>
											<div class="form-group">
												<label for="site_address" class="col-md-4 control-label">Project Address<span class="required" style="color: red;">*</span> </label>
												<div class="col-md-8">
													<!-- <input type="textarea" name="site_address" class="form-control" required> -->
													<textarea name="site_address" class="form-control" rows="5" style="resize: none;" required></textarea>
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
							</div>
	            		</div>
	            		<!-- End of column for client and site info -->
	            		<!-- Start of column for contact no -->
	            		<div class="col-md-6">
	            			<div class="row">
								<div class="col-md-12">
									<section class="panel">
										<header class="panel-heading">
										Project Contacts
										</header>
										<div class="panel-body">
											<div class="row">
												<table id="item_table" align="center">
													<tr>
														<td class="col-md-4">
															<label for="item_no">Name<span class="required" style="color: red;">*</span></label>
														</td>
														<td class="col-md-4">
															<label for="quantity">Number<span class="required" style="color: red;">*</span></label>
														</td>
														<td class="col-md-4">
															<label for="button"></label>
														</td>
													</tr>
													<tr id="row1" style="text-align: center;">
														<td class="col-md-3">
															<div class="form-group">
																<input type="type" name="contact_name[]" class="form-control" autocomplete="off" required>
															</div>
														</td>
														<td class="col-md-5">
															<div class="form-group" >
																<input type="type" name="contact_no[]" class="form-control" autocomplete="off" required>
															</div>
														</td>
														<td class="col-md-4">
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
											<p class="help-block">Note: Put a comma between contact numbers</p>
										</footer>
									</section>
								</div>
							</div>
	            		</div>
	            		<!-- End of column for contact no -->
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

		$count = 0;
		$array_contact_name = array();
		$site_name = mysqli_real_escape_string($db, $_POST['site_name']);
		$site_address = mysqli_real_escape_string($db, $_POST['site_address']);
		$contact_name = $_POST['contact_name'];
		$contact_no = str_replace("-", "", $_POST['contact_no']);

		$insert_site = "INSERT INTO site(site_name, site_address, client_id) VALUES('$site_name','$site_address',$client_id)";

		// echo $insert_site;

		if(mysqli_query($db, $insert_site)){

			$sql = "SELECT MAX(site_id) as site_id FROM site WHERE client_id = '$client_id'";
			$result = mysqli_query($db, $sql);
			$row = mysqli_fetch_assoc($result);
			$site_id = $row['site_id'];

			for ($i=0; $i < count($contact_name); $i++) { 
				$array_contact_name[] = $contact_name[$i];

				$insert_contact_person = "INSERT INTO site_contact_person(site_contact_name, site_id) 
										VALUES('$contact_name[$i]','$site_id')";

				// echo $insert_contact_person."<br>";
				mysqli_query($db, $insert_contact_person);						
			}

			for ($j=0; $j < count($array_contact_name); $j++) { 
				
				$sql_contact_id = "SELECT site_contact_person_id FROM site_contact_person
									WHERE site_contact_name = '$array_contact_name[$j]'
									AND site_id = $site_id";

				$result_contact = mysqli_query($db, $sql_contact_id);
				$row_contact_id = mysqli_fetch_assoc($result_contact);

				$explode_no = explode(",", $contact_no[$j]);	
				for ($k=0; $k < count($explode_no); $k++) { 
					
					echo $row_contact_id['site_contact_person_id']." ".$explode_no[$k]."<br>";	

					$insert_contact_no = "INSERT INTO site_contact_number(site_contact_no,site_contact_person_id)
											VALUES('$explode_no[$k]','".$row_contact_id['site_contact_person_id']."')";

					// echo $insert_contact_no."<br>";
					mysqli_query($db, $insert_contact_no);

				}
				$count++;					
			}

			if($count == count($array_contact_name)){
				// echo "<meta http-equiv='refresh' content='0'>";
				echo "<script>
				if(confirm('New project added successfully. Add another project?')){
					window.location.href='add_site.php?post_client_id=".$client_id."';
				}else{
					window.location.href='client_sites.php?post_client_id=".$client_id."';
				}</script>";
			}
		}
	}
?>