<?php
	/*文件名称: abandon_order.php
	 *文件作用: 得到用户user_id和order_code来更新订单状态,并且返还给用户共享券
	 */
	include ("conn.php");

	$user_id = $_GET['user_id'];
	$order_code = $_GET['order_code'];
	$send_time = date('Y-m-d H:i:s', time());
	$zero_time = time();
	$zero_time = $zero_time - $zero_time;
	$arrive_time = date('Y-m-d H:i:s', $zero_time);			//退单的化到达时间和签收时间都为1970-01-01 12:00:00;
	$end_time = date('Y-m-d H:i:s', $zero_time);
	mysqli_select_db($conn, 'zhygl');
	/*首先更新订单状态*/
	$sql1 = "UPDATE place_order SET order_status = '3', 
	send_time = '$send_time',
	arrive_time = '$arrive_time',
	end_time = '$end_time'
	WHERE order_code ='$order_code'";
	$result1 = mysqli_query($conn, $sql1);

	/*然后退还用户下单金额*/


	$sql2 = "SELECT receiver_user_id, product_cost FROM place_order WHERE order_code='$order_code'";
	$result2 =mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($result2);
	$receiver_user_id = $row2['receiver_user_id'];
	$product_cost = $row2['product_cost'];

	$sql3 = "SELECT ticket_num, cost_num FROM user_info WHERE user_id = '$receiver_user_id'";
	$result3 = mysqli_query($conn, $sql3);
	$row3 = mysqli_fetch_assoc($result3);
	$ticket_num = $row3['ticket_num'] + $product_cost;
	$cost_num = $row3['cost_num'] - $product_cost;

	$sql4 = "UPDATE user_info SET ticket_num = '$ticket_num', cost_num = '$cost_num' WHERE user_id = '$receiver_user_id'";
	$result4 = mysqli_query($conn, $sql4);


	if ($result1 && $result2 && $result3 && $result4) {
		echo json_encode(1);
		#echo "get success!";
	}
	else {
		#echo "get fail";
		
		echo json_encode(0);
	}



?>