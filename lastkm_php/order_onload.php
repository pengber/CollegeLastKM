<?php
/*
 *文件名称: order_onload.php
 *文件作用: 接受order页面的open_id信息,返回user_info信息
 */
 	include "conn.php";
 	include "time_information.php";
 	$user_id = $_POST['user_id'];
 	class dataClass {
 		public $ticket_num;
 		public $address;
 		public $times;
 		public $need_piecesArray;
 		public $button_show;			//控制充值Button显示
 		public $button_word;
 	}

 	$data = new dataClass;
 	$data->button_show = true;			//控制充值button显示
 	$data->button_word = "充值";
 	$data->times = $times;
 	$need_piecesArray = array('1','2','4');
 	$data->need_piecesArray = $need_piecesArray;
 	mysqli_select_db($conn, 'zhygl');
 	
 	$sql1 = "SELECT * FROM user_info WHERE user_id = '$user_id'";
 	$result1 = mysqli_query($conn, $sql1);

 	if (mysqli_num_rows($result1)) {
 		$row = mysqli_fetch_assoc($result1);
 		$data->ticket_num = $row['ticket_num'];
 	}
 	else {
 		$data->ticket_num = null;
 		#echo "there is no user_info so there is no ticket_num";
 	}


 	$sql2 = "SELECT * FROM user_address WHERE user_id = '$user_id'";
 	$result2 = mysqli_query($conn, $sql2);
 	if (mysqli_num_rows($result2)) {
 		$row = mysqli_fetch_assoc($result2);
 		$data->address = $row;
 	}
 	else {
 		$data->address = null;
 		#echo "there is no address!";
 	}

 	echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 	
 ?>