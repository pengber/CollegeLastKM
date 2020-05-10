<?php

/*文件名称: onload_control.php
 *文件作用: 得到用户管理员openid,返回对应的大学校区的总订单数和今天上午和晚上的订单数
 */
	include ("conn.php");
	include ("time_information.php");
	$user_id = $_GET['user_id'];


	mysqli_select_db($conn, 'zhygl');
	$todayDate = date('Y-m-d',time());
	$noon = $times[0];
	$afternoon = $times[1];
	$contents = array();
	class dataClass{
		public $contents;
		public $times;
	}

	$sql = "SELECT college, branch_school FROM user_approve WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$college = $row['college'];
	$branch_school = $row['branch_school'];

	$sql1 = "SELECT * FROM user_address AS ad, place_order AS od WHERE 
	ad.college = '$college' AND 
	ad.branch_school = '$branch_school' AND 
	od.receiver_user_id = ad.user_id AND 
	od.target_time_date = '$todayDate'";
	$result1 = mysqli_query($conn, $sql1);
	$contents[0] = mysqli_num_rows($result1);

	$sql2 = "SELECT * FROM user_address AS ad, place_order AS od WHERE 
	ad.college = '$college' AND 
	ad.branch_school = '$branch_school' AND 
	od.receiver_user_id = ad.user_id AND 
	od.target_time_date = '$todayDate' AND 
	od.target_time_time = '$noon'
	";
	$result2 = mysqli_query($conn, $sql2);
	$contents[1] = mysqli_num_rows($result2);

	$sql3 = "SELECT * FROM user_address AS ad, place_order AS od WHERE 
	ad.college = '$college' AND 
	ad.branch_school = '$branch_school' AND 
	od.receiver_user_id = ad.user_id AND 
	od.target_time_date = '$todayDate' AND 
	od.target_time_time = '$afternoon'
	";
	$result3 = mysqli_query($conn, $sql3);
	$contents[2] = mysqli_num_rows($result3);


	if (!$result || !$result1 || !$result2 || !$result3) {
		echo json_encode(0);
	}else {
		$data = new dataClass();
		$data->contents = $contents;
		$data->times = $times;
		echo json_encode($data);
	}


 ?>