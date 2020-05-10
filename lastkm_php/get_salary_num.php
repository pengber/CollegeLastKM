<?php
	/*文件名称: get_salary_num.php
	*文件作用:得到姓名,起始日期,终止日期,返回小件,中件,大件信息;
	*/

	include ("conn.php");
 	mysqli_select_db($conn, 'zhygl');
 	$name = $_POST['name'];
 	$start_date = $_POST['start_date'];
 	$end_date = $_POST['end_date'];
 	class dataClass{
 		public $total;
 		public $small;
 		public $middle;
 		public $big;
 	}
 	$data = new dataClass;

 	$sql0 = "SELECT user_id FROM user_approve WHERE real_name = '$name'";
 	$result0 = mysqli_query($conn, $sql0);
 	$row = mysqli_fetch_assoc($result0);
 	$user_id = $row['user_id'];

 	$sql = "SELECT * FROM place_order WHERE
 	courier_user_id = '$user_id' AND 
 	target_time_date >= '$start_date' AND 
 	target_time_date <= 'end_date'";
 	$result = mysqli_query($conn, $sql);
 	$data->total = mysqli_num_rows($result);

 	$sql1= "SELECT * FROM place_order WHERE 
 	courier_user_id = '$user_id' AND 
 	target_time_date >= '$start_date' AND 
 	target_time_date <= 'end_date' AND 
 	product_volume = '1'";
 	$result1 = mysqli_query($conn, $sql1);
 	$data->small = mysqli_num_rows($result1);

 	$sql2 = "SELECT * FROM place_order WHERE 
 	courier_user_id = '$user_id' AND 
 	target_time_date >= '$start_date' AND 
 	target_time_date <= 'end_date' AND
 	product_volume = '2'";
 	$result2 = mysqli_query($conn, $sql2);
 	$data->middle = mysqli_num_rows($result2);

 	$sql3 = "SELECT * FROM place_order WHERE 
 	courier_user_id = '$user_id' AND 
 	target_time_date >= '$start_date' AND 
 	target_time_date <= 'end_date' AND
 	product_volume = '3'";
 	$result3 = mysqli_query($conn, $sql3);
 	$data->big = mysqli_num_rows($result3);

 	if ($result0 && $result && $result1 && $result2 && $result3) {
 		echo json_encode($data);
 	}else {
 		echo json_encode(0);
 	}


?>