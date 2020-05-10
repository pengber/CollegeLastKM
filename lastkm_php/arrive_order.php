<?php
/*文件名称: arrive_order.php
 *文件作用: 接受order_code,领取订单,将订单状态由0变为1,并更新领单时间
*/

	include ("conn.php");

	$user_id = $_GET['user_id'];
	$order_code = $_GET['order_code'];
	$arrive_time = date('Y-m-d H:i:s', time());
	mysqli_select_db($conn, 'zhygl');
	/*首先更新订单状态*/
	$sql1 = "UPDATE place_order SET order_status = '2', arrive_time = '$arrive_time' WHERE order_code ='$order_code'";
	$result1 = mysqli_query($conn, $sql1);

	if ($result1) {
		echo json_encode(1);
		#echo "get success!";
	}
	else {
		#echo "get fail";
		echo json_encode(0);
	}
	


?>