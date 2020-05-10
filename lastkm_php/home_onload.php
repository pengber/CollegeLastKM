<?php
/*
 *文件名称: home_onload.php
 *文件作用: 得到用户id,然后返回用户的认证信息和共享券数量信息
 */
	
	include ("conn.php");

	$user_id = $_POST['user_id'];

	mysqli_select_db($conn, 'zhygl');

	class dataClass{
		public $isApprove;
		public $hasTickets;
		public $isWork;
	}
	$data = new dataClass();

	$sql1 = "SELECT ticket_num FROM user_info WHERE user_id = '$user_id'";
	$result1 = mysqli_query($conn, $sql1);

	if (mysqli_num_rows($result1) > 0) {
		$row = mysqli_fetch_assoc($result1);
		$data->hasTickets = $row['ticket_num'];
	}
	else {
		$data->hasTickets = 0;
	}

	$sql2 = "SELECT * FROM user_approve WHERE user_id = '$user_id'";
	$result2 = mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($result2);
	$if_approve = $row2['if_approve'];
	$if_work = $row2['if_work'];
	if ($if_approve == 1) {
		$data->isApprove = $if_approve;
	}else {
		$data->isApprove = 0;
	}

	if ($if_work == 1) {
		$data->isWork = $if_work;
	}else {
		$data->isWork = 0;
	}

	echo json_encode($data);

?>