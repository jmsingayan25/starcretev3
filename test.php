<?php

	include("includes/config.php");

	// $password = "aprilpalenciaheadoffice";
	// $password_crpyt_md5 = crypt($password,'$1$'.$password);
	// $password_md5 = md5($password);

	// echo "MD5: " . $password_md5 . "<br>";
	// echo "Crpyt MD5: " . $password_crpyt_md5 . "<br>";

	// $sql = "UPDATE users SET password = '$password_crpyt_md5' WHERE user_id = '9'";
	// // echo $sql;

	// if(mysqli_query($db, $sql)){
	// 	echo mysqli_info($db);
	// }else{
	// 	echo mysqli_error($db);
	// }

	// $sql = "CREATE TABLE notification(
	// 		notif_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	// 		from_office varchar(10) NOT NULL,
	// 		to_office varchar(10) NOT NULL,
	// 		table_name varchar(30) NOT NULL,
	// 		content int(11) NOT NULL,
	// 		datetime NOT NULL,
	// 		counter int(11) NOT NULL
	// 	)";


	// $datetime1 = new DateTime();
	// $datetime2 = new DateTime('2018-04-14 17:13:00');
	// $interval = $datetime1->diff($datetime2);
	// $elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
	// echo $elapsed;
	// $temp_count = 0;

	// $sql = "SELECT * FROM history";
	// $result = mysqli_query($db, $sql);
	// $count = mysqli_num_rows($result);

	// echo "Count: " . $count . " Temp: " . $temp_count;

	// if($temp_count != $count){
	// 	echo "New update on database";
	// 	$temp_count += $count;
	// echo "Count: " . $count . " Temp: " . $temp_count;
		
	// }else{
	// 	echo "No new update on database.";
	// }

	$firstname = mysqli_real_escape_string($db, "Mary Rose");
	$lastname = mysqli_real_escape_string($db, "michael");
	$username = mysqli_real_escape_string($db, "Maro");
	$password = mysqli_real_escape_string($db, "maroheadoffice1010");
	$position = mysqli_real_escape_string($db, "admin");
	$office = mysqli_real_escape_string($db, "head");

	$password_crpyt_md5 = mysqli_real_escape_string($db, crypt($password,'$1$'.$password));

	$sql = "INSERT INTO users(firstname, lastname, username, password, position, office)
			VALUES('$firstname','$lastname','$username','$password_crpyt_md5','$position','$office')";

	echo $sql;
	// if(mysqli_query($db, $sql)){
	// 	echo mysqli_info($db);
	// }else{
	// 	echo mysqli_error($db);
	// }

?>
<!-- <!DOCTYPE html>
<html>
<head>
	<title></title>

<script type="text/javascript">
	function onSubmit(){
		var txt;
		if(confirm("Proceed")){
			form.submit();
			if(confirm("Insert Update ok. Want more?")){
				window.location.reload();
			}else{
				alert("FALSE");
			}
		}
	}
</script>
</head>
<body>
<form action="test.php" method="post">
	<input type="submit" name="submit" value="Submit" onclick="onSubmit();">
</form>
</body>
</html> -->