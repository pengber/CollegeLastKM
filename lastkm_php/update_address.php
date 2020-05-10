<?php
/*
 *文件名称: update_address.php
 *文件作用: 接受来自edit表单的数据,更新或插入用户默认地址
 */
 	include("conn.php");

	//单引号
 	mysqli_select_db($conn, 'zhygl');

 	$user_id = $_POST['user_id'];
 	$name = $_POST['name'];
 	$phone = $_POST['phone'];
 	$college = $_POST['college'];
 	$branch_school = $_POST['branch_school'];
 	$apartment = $_POST['apartment'];
 	$apartment = (int)($apartment);
 	$room = $_POST['room'];
 	$room = (int)($room);
 	
 	$sql1 = "SELECT * FROM user_address WHERE user_id = '$user_id'";
 	$result1 = mysqli_query($conn, $sql1);

 	if (mysqli_num_rows($result1)) {
 		$sql2 = "UPDATE user_address SET
 		receiver_name = '$name',
 		receiver_phone_num = '$phone',
 		college = '$college',
 		branch_school = '$branch_school',
 		apartment_num = '$apartment',
 		room_num = '$room',
 		if_default = '1' WHERE
 		user_id = '$user_id'
 		";
 		$result2 = mysqli_query($conn, $sql2);
 		if ($result2) {
 			echo "db update success!";
 		}else {
 			echo "db update fail!";
 		}
 	}
 	else {
 		$sql2 = "INSERT INTO user_address (
 		user_id,
 		receiver_name, 
 		receiver_phone_num, 
 		college,
 		branch_school, 
 		apartment_num, 
 		room_num, 
 		if_default) VALUES (
 		'$user_id',
 		'$name',
 		'$phone',
 		'$college',
 		'$branch_school',
 		'$apartment',
 		'$room',
 		'1'
 		)";
 		$result2 = mysqli_query($conn, $sql2);
 		if ($result2) {
 			echo "db insert success!";
 		}else {
 			echo "db insert fail!";
 		}
 	}
?>