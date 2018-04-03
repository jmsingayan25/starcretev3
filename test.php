<?php

	include("includes/config.php");

	$password = "aprilpalenciaheadoffice";
	$password_crpyt_md5 = crypt($password,'$1$'.$password);
	$password_md5 = md5($password);

	echo "MD5: " . $password_md5 . "<br>";
	echo "Crpyt MD5: " . $password_crpyt_md5 . "<br>";

	$sql = "UPDATE users SET password = '$password_crpyt_md5' WHERE user_id = '9'";
	// echo $sql;

	if(mysqli_query($db, $sql)){
		echo mysqli_info($db);
	}else{
		echo mysqli_error($db);
	}




?>