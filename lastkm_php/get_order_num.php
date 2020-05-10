<?php
 /*文件名称:get_order_num.php
  *文件作用:得到日期和时间查询此时间段的具体订单数量
  */

 	include ("conn.php");
 	mysqli_select_db($conn, 'zhygl');
 	$order_date = $_POST['order_date'];
 	$date = $order_date;
 	$time = $_POST['time'];
 	class dataClass{
 		public $total;
 		public $small;
 		public $middle;
 		public $big;
 	}
 	$data = new dataClass;
 	$sql = "SELECT * FROM place_order WHERE 
 	target_time_date = '$date' AND 
 	target_time_time = '$time'";
 	$result = mysqli_query($conn, $sql);
 	$data->total = mysqli_num_rows($result);

 	$sql1= "SELECT * FROM place_order WHERE 
 	target_time_date = '$date' AND 
 	target_time_time = '$time' AND 
 	product_volume = '1'";
 	$result1 = mysqli_query($conn, $sql1);
 	$data->small = mysqli_num_rows($result1);

 	$sql2 = "SELECT * FROM place_order WHERE 
 	target_time_date = '$date' AND 
 	target_time_time = '$time' AND 
 	product_volume = '2'";
 	$result2 = mysqli_query($conn, $sql2);
 	$data->middle = mysqli_num_rows($result2);

 	$sql3 = "SELECT * FROM place_order WHERE 
 	target_time_date = '$date' AND 
 	target_time_time = '$time' AND 
 	product_volume = '3'";
 	$result3 = mysqli_query($conn, $sql3);
 	$data->big = mysqli_num_rows($result3);

 	if ($result && $result1 && $result2 && $result3) {
 		echo json_encode($data);
 	}else {
 		echo json_encode(0);
 	}

  ?>