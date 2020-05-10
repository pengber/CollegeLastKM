<?php
/*
 *文件名称: place_order.php
 *文件作用: 收集order页面提交的数据在数据库内插入订单
 */	
	
	include ("conn.php");
	#以下代码产生12位随机码作为订单码存在
	function foo() {
  	$o = $last = '';
  	do {
    $last = $o;
    usleep(10);
    $t = explode(' ', microtime());
    $o = substr(base_convert(strtr($t[0].$t[1].$t[1], '.', ''), 10, 36), 0, 12);
  	}while($o == $last);
  	return $o;
	}
	$order_code = foo();

	mysqli_select_db($conn, 'zhygl');

	$user_id = $_POST['user_id'];
	$volume = (int)$_POST['volume'];
	$cost = (int)$_POST['cost'];
	$code_pre = (int)$_POST['code_pre'];
	$code_mid = (int)$_POST['code_mid'];
	$code_post = (int)$_POST['code_post'];
	$target_date = $_POST['target_date'];
	$target_time = $_POST['target_time'];
	$image_path = $_POST['image_path'];
	$start_time = date('Y-m-d H:i:s', time());
	$sql1 = "INSERT INTO place_order (
	order_code,
	product_volume,
	product_cost,
	product_code_pre,
	product_code_mid,
	product_code_post,
	product_code_image,
	receiver_user_id,
	target_time_date,
	target_time_time,
	start_time) VALUES (
	'$order_code',
	'$volume',
	'$cost',
	'$code_pre',
	'$code_mid',
	'$code_post',
	'$image_path',
	'$user_id',
	'$target_date',
	'$target_time',
	'$start_time'
	)";

	$result1 = mysqli_query($conn, $sql1);
	if ($result1) {
		echo json_encode(1);
		#echo "insert success!";
	}
	else {
		#echo "insert fail!";
		echo json_encode(0);
	}

	$sql2 = "SELECT place_num,ticket_num,cost_num FROM user_info WHERE user_id = '$user_id'";
	$result2 = mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($result2);

	$place_num = $row2['place_num'] + 1;
	$ticket_num = $row2['ticket_num'] - $cost;
	$cost_num = $row2['cost_num'] + $cost;

	$sql3 = "UPDATE user_info SET place_num = '$place_num', ticket_num = '$ticket_num', cost_num = '$cost_num' WHERE user_id = '$user_id'";
	$result3 = mysqli_query($conn, $sql3);
	if ($result3) {
		echo json_encode(1);
		#echo "update user_info's place_num success!";
	}else {
		echo json_encode(0);
		#echo "update user_info's place_num fail!";
	}
 ?>