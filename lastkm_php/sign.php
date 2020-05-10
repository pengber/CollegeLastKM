<?php
/*
文件名称: sign.php
文件作用: 接受getUserinfo的信息,如果没有注册的话注册信息
*/
	include "conn.php";

	$user_id = $_POST['user_id'];
	$nick_name = $_POST['nick_name'];
	$gender = $_POST['gender'];
	$gender = (int)($gender);
	$city = $_POST['city'];
	$province = $_POST['province'];
	$country = $_POST['country'];
	
	mysqli_select_db($conn, 'zhygl');

	$sql1 = "SELECT * FROM user_info WHERE user_id = '$user_id'";
	$result1 = mysqli_query($conn, $sql1);
	echo json_encode(mysqli_num_rows($result1));
	if (mysqli_num_rows($result1) == 0) {
		$sql2 = "INSERT INTO user_info (user_id, nick_name, gender, city, province, country) VALUES (
		'$user_id', '$nick_name', '$gender', '$city', '$province', '$country')";
		$result2 = mysqli_query($conn, $sql2);
		if ($result2) {
			#echo "insert success!";
			echo json_encode(1);
		}
		else {
			#echo "insert fail";
			echo json_encode(0);
		}
	}
	else {
		$sql3 = "UPDATE user_info SET 
		nick_name = '$nick_name',
		gender = '$gender',
		city = '$city',
		province = '$province',
		country = '$country' WHERE 				
		user_id = '$user_id'
		";
		$result3 = mysqli_query($conn, $sql3);
		if ($result3) {
			#echo "update success!";
			echo json_encode(1);
		}
		else {
			#echo "update fail";
			echo json_encode(0);
		}

	}
?>