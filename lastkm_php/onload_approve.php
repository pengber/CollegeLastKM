<?php
 /*文件名称: onload_approve.php
  *文件作用: 得到openid,返回用户之前的认证状况
  */
 	include ("conn.php");

	$user_id = $_GET['user_id'];
	mysqli_select_db($conn, 'zhygl');

	$sql1 = "SELECT * FROM user_approve WHERE user_id = '$user_id'";
	$result1 = mysqli_query($conn, $sql1);

	$row1 = mysqli_fetch_assoc($result1);

	class dataClass{
		public $name;
		public $id;
		public $phone;
		public $apartment;
		public $room;
		public $college;
		public $branch;
	}

	if (mysqli_num_rows($result1) > 0) {
	$data = new dataClass();
	$data->name = $row1['real_name'];
	$data->id = $row1['student_id'];
	$data->phone = $row1['phone_num'];
	$data->apartment = $row1['apartment_num'];
	$data->room = $row1['room_num'];
	$data->college = $row1['college'];
	$data->branch = $row1['branch_school'];

	echo json_encode($data);
	}
	else {
		echo json_encode(0);
	}












  ?>