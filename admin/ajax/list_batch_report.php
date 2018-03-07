<?php

	include("../../includes/config.php");

	$radio_option = $_REQUEST['radio_option'];
	$office = $_REQUEST['office'];

?>

	<div class="table-responsive">
        
                                        
<?php
	if($radio_option == 'total_cement'){
?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Total cement per day</th>
				</tr>
				<tr>
					<th class="col-md-1">Cement(kg)</th>
					<th class="col-md-1">Date</th>
				</tr>
			</thead>
			<tbody> 
<?php
			$rows = array();
			$final = array();

			$limit = 10;  
			if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
			$start_from = ($page-1) * $limit; 
			$query = "SELECT cement * SUM(batch_count) as total, DATE_FORMAT(batch_date,'%m/%d/%y') as prod_date
						FROM batch WHERE office = '$office'
						GROUP BY prod_date, machine_no, cement
		                ORDER BY batch_date DESC";
		                
			$result = mysqli_query($db, $query);
			while($row = mysqli_fetch_assoc($result)){
		    	$rows[] = $row;
			}
			foreach($rows as $value) {
			    $id = $value['prod_date'];
			    $filter = array_filter($rows, function($ar) {
			        GLOBAL $id;
			        $valueArr = ($ar['prod_date'] == $id);
			        return $valueArr;
			    });
			    $sum = array_sum(array_column($filter, 'total'));
			    $final[$id] = array('prod_date' => $id, 'total' => $sum);
			}
			foreach ($final as $total) {
?>
				<tr>
					<td class="col-md-1"><strong><?php echo number_format($total['total']); ?></strong></td>
					<td class="col-md-1"><strong><?php echo $total['prod_date']; ?></strong></td>
				</tr>
<?php
			}
?>
			</tbody>
		</table>

<?php
	}else if($radio_option == 'total_batch_cement'){
?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="5">Total batch and cement used</th>
				</tr>
				<tr>
	     			<th class="col-md-1">Machine no.</th>
	     			<th class="col-md-1">Item</th>
					<th class="col-md-1">Batch</th>
					<th class="col-md-1">Total Cement(kg)</th>
					<th class="col-md-1">Date</th>
				</tr>
			</thead>
			<tbody>
<?php

	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;  
	$query = "SELECT machine_no, item_no, cement * SUM(batch_count) as total, SUM(batch_count) as count, DATE_FORMAT(batch_date,'%m/%d/%y') as prod_date
				FROM batch WHERE office = '$office'
				GROUP BY machine_no, item_no, prod_date, cement
			  	ORDER BY batch_date DESC, machine_no";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_assoc($result)){	
?>		
				<tr>
					<td class="col-md-1"><strong><?php echo $row['machine_no']; ?></strong></td>
					<td class="col-md-1"><strong><?php echo $row['item_no']; ?></strong></td>
					<td class="col-md-1"><strong><?php echo number_format($row['count']); ?></strong></td>
					<td class="col-md-1"><strong><?php echo number_format($row['total']); ?></strong></td>
					<td class="col-md-1"><strong><?php echo $row['prod_date']; ?></strong></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>

<?php
	}else if($radio_option == 'total_output'){
?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="6">Output per batch</th>
				</tr>
				<tr>
	     			<th class="col-md-1">Item</th>
					<th class="col-md-1">Production</th>
					<th class="col-md-1">Batch</th>
					<th class="col-md-1">Output</th>
					<th class="col-md-1">Reject</th>
					<th class="col-md-1">Date</th>
				</tr>
			</thead>
			<tbody>
<?php

	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;  
	$query = "SELECT batch_prod_id, item_no, SUM(actual_prod) as actual_prod, SUM(batch_prod) as batch_prod, CONCAT(FORMAT(SUM(output),2), ' pcs') as output, DATE_FORMAT(date_production,'%m/%d/%y') as prod_date, reject
		FROM batch_prod WHERE office = '$office'
		GROUP BY prod_date, item_no, reject, batch_prod_id
		ORDER BY date_production DESC, item_no ASC";

	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_assoc($result)){	
?>	
				<tr>
					<td class="col-md-1"><strong><?php echo $row['item_no']; ?></strong></td>
					<td class="col-md-1"><strong><?php echo number_format($row['actual_prod']) . " pcs"; ?></strong></td>
					<td class="col-md-1"><strong><?php echo number_format($row['batch_prod']) . " batches"; ?></strong></td>
					<td class="col-md-1"><strong><?php echo $row['output']; ?></strong></td>
					<td class="col-md-1"><strong><?php echo number_format($row['reject']) . " pcs"; ?></strong></td>
					<td class="col-md-1"><strong><?php echo $row['prod_date']; ?></strong></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
<?php
	}else if($radio_option == 'total_production'){
?>
		<div class="row">
			<div class="col-md-6">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th colspan='3'> Monthly Production Per Type</th>
						</tr>
						<tr>
							<th class="col-md-1">Date</th>
							<th class="col-md-1">Type</th>
							<th class="col-md-1">Total</th>
						</tr>
					</thead>
					<tbody>
<?php
	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;  
	$query = "SELECT DATE_FORMAT(date_production,'%m/%Y') as prod_date, item_no, SUM(actual_prod) as total
				FROM batch_prod
				WHERE office = '$office' 
				GROUP BY MONTH(date_production), item_no 
				ORDER BY date_production DESC, item_no ASC";

	$result = mysqli_query($db, $query);

	while($row = mysqli_fetch_assoc($result)){
?>		
						<tr>
							<td class="col-md-1" text-align: center'><strong><?php echo $row['prod_date']; ?></strong></td>
							<td class="col-md-1"><strong><?php echo $row['item_no']; ?></strong></td>
							<td class="col-md-1"><strong><?php echo number_format($row['total']) . " pcs"; ?></strong></td>
						</tr>
<?php
	}
?>
					</tbody>
				</table>
			</div>
			<div class="col-md-6">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th colspan='2'>Monthly Production for All Type</th>
						</tr>
						<tr>
							<th class="col-md-1">Date</th>
							<th class="col-md-1">Total</th>
						</tr>
					</thead>
					<tbody>
<?php
	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;  
	$query = "SELECT DATE_FORMAT(date_production,'%m/%Y') as prod_date, item_no, SUM(actual_prod) as total
				FROM batch_prod
				WHERE office = '$office' 
				GROUP BY MONTH(date_production) 
				ORDER BY date_production DESC, item_no ASC";

	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_assoc($result)){		
?>
						<tr>
							<td class="col-md-1" text-align: center'>
								<strong><?php echo $row['prod_date']; ?></strong>
							</td>
							<td class="col-md-1"><strong><?php echo number_format($row['total']) . " pcs"; ?></strong></td>
						</tr>
<?php
	}
?>
					</tbody>
				</table>
			</div>
		</div>
			
<?php
	}else if($radio_option == 'total_delivered'){
?>
		<div class="row">
			<div class="col-md-6">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th colspan='3'>Monthly Delivered CHB Per Type</th>
						</tr>
						<tr>
							<th class="col-md-1">Date</th>
							<th class="col-md-1">Type</th>
							<th class="col-md-1">Total</th>
						</tr>
					</thead>
					<tbody>
<?php
	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;  
	$query = "SELECT item_no, SUM(delivered) as total, DATE_FORMAT(date_production,'%m/%Y') as delivery_date 
				FROM batch_prod_stock 
				WHERE office = '$office'
				GROUP BY MONTH(date_production), item_no 
				ORDER BY date_production DESC, item_no ASC";

	$result = mysqli_query($db, $query);

	while($row = mysqli_fetch_assoc($result)){		
?>
					<tr>
						<td class="col-md-1"><strong><?php echo $row['delivery_date']; ?></strong></td>
						<td class="col-md-1"><strong><?php echo $row['item_no']; ?></strong></td>
						<td class="col-md-1"><strong><?php echo number_format($row['total']) . " pcs"; ?></strong></td>
					</tr>
<?php
	}
?>						
					</tbody>
				</table>
				
			</div>
			<div class="col-md-6">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th colspan='2'>Monthly Delivered CHB for All Type</th>
						</tr>
						<tr>
							<th class="col-md-1">Date</th>
							<th class="col-md-1">Total</th>
						</tr>
					</thead>
					<tbody>
<?php
	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;  
	$query = "SELECT item_no, SUM(delivered) as total, DATE_FORMAT(date_production,'%m/%Y') as delivery_date 
				FROM batch_prod_stock 
				WHERE office = '$office'
				GROUP BY MONTH(date_production) 
				ORDER BY date_production DESC, item_no ASC";

	$result = mysqli_query($db, $query);

	while($row = mysqli_fetch_assoc($result)){	
?>	
					<tr>
						<td class="col-md-1"><strong><?php echo $row['delivery_date']; ?></strong></td>
						<td class="col-md-1"><strong><?php echo number_format($row['total']) . " pcs"; ?></strong></td>
					</tr>
<?php
	}
?>						
					</tbody>
				</table>
			</div>
		</div>
<?php
	}
?>
		</table>
	</div>