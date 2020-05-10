<?php
	$hostname_conn = "localhost";
	$username_conn = "root";
	$password_conn = "20010502";

	$conn = mysqli_connect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysqli_error(),E_USER_ERROR);

	
	mysqli_query($conn, "set names 'utf8mb4'");

?>
