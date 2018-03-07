<?php

    include("../includes/config.php");
    include("../includes/function.php");

	$user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
	$user_query->bind_param('s', $_SESSION['login_user']);
	$user_query->execute();
	$result = $user_query->get_result();
	$user = $result->fetch_assoc();

	$session_office = $user['office'];
	$position = $user['position'];

	if(isset($_POST['date_prev']) && isset($_POST['office'])){
		$date_prev = $_POST['date_prev'];
		$office = $_POST['office'];
		if($date_prev != ''){
			$sql = "SELECT DISTINCT item_no
					FROM batch 
					WHERE office = '$office' 
					AND (item_no, DATE_FORMAT(batch_date,'%m/%d/%y')) NOT IN (SELECT item_no, DATE_FORMAT(date_production,'%m/%d/%y') FROM batch_prod WHERE office = '$office') 
					AND DATE_FORMAT(batch_date,'%m/%d/%y') = '$date_prev'
					ORDER BY item_no ASC";
			$result = mysqli_query($db,$sql);

			if(mysqli_num_rows($result) > 0){
				echo '<option value="">Select</option>';
				while($row = mysqli_fetch_assoc($result)){
					echo "<option value='" . $row['item_no'] . "'>" . $row['item_no'] . "</option>";			
				}
			}else{
				echo '<option value="">Select</option>';
			}
		}else{
			echo '<option value="">Select</option>';
		}
	}
?>