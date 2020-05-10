<?php
/*文件名称: collect_all_orders.php
 *文件作用: 工作人员点击了全选按钮
*/
	include ("conn.php");

 	$user_id = $_POST['user_id'];
 	$date = date('Y-m-d',strtotime($_POST['date']));/*搜索数据库中的日期必须用日期格式 strtotime返回的是一个时间戳,而getDate是由时间戳得到一个日期*/
 	$time = $_POST['time'];
 	$apartment = (int)($_POST['apartment']);
 	$volume = (int)($_POST['volume']);
 	$if_work = (int)($_POST['if_work']);
 	$accept_time = date('Y-m-d H:i:s', time());

	mysqli_select_db($conn, 'zhygl');

	$sql = "SELECT * FROM 
	place_order AS od,
	user_address AS ad
	WHERE 
	od.receiver_user_id = ad.user_id and 
	od.order_status = 0 and 
	od.courier_user_id is null and 
	od.target_time_date = '$date' and 
	od.target_time_time = '$time' and 
	ad.apartment_num = '$apartment' and 
	od.product_volume = '$volume'";
 	$result = mysqli_query($conn, $sql);
 	$length = mysqli_num_rows($result);

 	$sql0 = "SELECT phone_num, collect_num FROM user_approve WHERE user_id = '$user_id'";
	$result0 = mysqli_query($conn, $sql0);
	$row0 = mysqli_fetch_assoc($result0);
	$phone_num = $row0['phone_num'];
	$collect_num = $row0['collect_num'] + $length;
	
	$sql1 = "UPDATE user_approve SET collect_num = '$collect_num' WHERE user_id = '$user_id'";
	$result1 = mysqli_query($conn, $sql1);

	$sql2 = "UPDATE place_order, user_address SET
	courier_user_id = '$user_id',
	courier_phone_num = '$phone_num', 
	accept_time = '$accept_time',
	if_company = '$if_work' WHERE
	place_order.receiver_user_id = user_address.user_id and 
	place_order.order_status = 0 and 
	place_order.courier_user_id is null and 
	place_order.target_time_date = '$date' and 
	place_order.target_time_time = '$time' and 
	user_address.apartment_num = '$apartment' and 
	place_order.product_volume = '$volume'
	";
	$result2 = mysqli_query($conn, $sql2);

	if ($result0 && $result1 && $result2) {
		echo json_encode(1);
	}else {
		var_dump($result0);
		var_dump($result1);
		var_dump($result2);
	}
 ?>