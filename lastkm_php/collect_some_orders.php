<?php
/*文件名称: collect_some_orders.php
 *文件作用: 得到来自want_order页面请求的
*/
	include ("conn.php");

	$value = $_POST['checked_values'];
	$value = explode(',', $value);
	$length = count($value);
	$user_id = $_POST['user_id'];
	$if_work = (int)($_POST['if_work']);
	$accept_time = date('Y-m-d H:i:s', time());
	mysqli_select_db($conn, 'zhygl');


	$sql0 = "SELECT phone_num, collect_num, week_num FROM user_approve WHERE user_id = '$user_id'";
	$result0 = mysqli_query($conn, $sql0);
	$row0 = mysqli_fetch_assoc($result0);
	$phone_num = $row0['phone_num'];
	$week_num = $row0['week_num'] - $length;
	$collect_num = $row0['collect_num'] + $length;

	$sql0 = "UPDATE user_approve SET collect_num = '$collect_num',week_num = '$week_num' WHERE user_id = '$user_id'";
	$result0 = mysqli_query($conn, $sql0);

	if (!$result0) {
		echo "update collect_num fail";
		return;
	}

	for ($i = 0; $i < $length; $i++) {
		$sql1 = "UPDATE place_order SET courier_user_id = '$user_id', courier_phone_num = '$phone_num', accept_time = '$accept_time',if_company = '$if_work' WHERE order_code = '$value[$i]'";
		$result1 = mysqli_query($conn, $sql1);
	}
	echo json_encode(1);
 ?>