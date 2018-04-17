<?php 

	$request = $_GET['request'];
	$sql = "SELECT rowCounter FROM setting";

	$result = mysqli_query($db, $sql);
	$count = mysqli_num_rows($result);

	if($count == $request){

		$update = "UPDATE setting SET rowCounter = rowCounter + 1";
	}

?>