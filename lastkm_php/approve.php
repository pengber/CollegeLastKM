<?php
/*文件名称: approve.php
 *文件作用: 处理approve提交的表单信息,插入或更新用户认证信息
 */

 	include("conn.php");

	//单引号
 	mysqli_select_db($conn, 'zhygl');

 	$user_id = $_POST['user_id'];
 	$student_id = $_POST['student_id'];
 	$student_id = (string)($student_id);
 	$name = $_POST['name'];
 	$phone = $_POST['phone'];
 	$college = $_POST['college'];
 	$branch_school = $_POST['branch_school'];
 	$apartment = $_POST['apartment'];
 	$apartment = (int)($apartment);
 	$room = $_POST['room'];
 	$room = (int)($room);
 	$student_card_image = $_POST['imagePath'];
 	
 	$sql1 = "SELECT * FROM user_approve WHERE user_id = '$user_id'";
 	$result1 = mysqli_query($conn, $sql1);

 	if (mysqli_num_rows($result1) > 0) {
 		$sql2 = "UPDATE user_approve SET
 		user_id = '$user_id',
 		real_name = '$name',
 		student_id = '$student_id',
 		phone_num = '$phone',
 		college = '$college',
 		branch_school = '$branch_school',
 		apartment_num = '$apartment',
 		room_num = '$room',
 		student_card_image = '$student_card_image',
 		if_approve = '0'
 		";
 		$result2 = mysqli_query($conn, $sql2);
 		if ($result2) {
 			echo "db update success!";
 		}else {
 			echo "db update fail!";
 		}
 	}
 	else {
 		$sql2 = "INSERT INTO user_approve (
 		user_id,
 		real_name,
 		student_id,
 		phone_num,
 		college,
 		branch_school,
 		apartment_num,
 		room_num,
 		student_card_image) VALUES (
 		'$user_id',
 		'$name',
 		'$student_id',
 		'$phone',
 		'$college',
 		'$branch_school',
 		'$apartment',
 		'$room',
 		'$student_card_image'
 		)";
 		$result2 = mysqli_query($conn, $sql2);
 		if ($result2) {
 			echo "db insert success!";
 		}else {
 			echo "db insert fail!";
 		}
 	}
 ?>