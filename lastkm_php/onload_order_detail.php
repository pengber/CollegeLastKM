<?php
/*文件名称: onload_order_detail.php
 *文件作用: 接受order_id,返回此order对应的详细信息
 */	
	include ("conn.php");
	$order_code = $_GET['order_code'];

	mysqli_select_db($conn, 'zhygl');

	$sql1 = "SELECT * FROM place_order WHERE order_code = '$order_code'";
	$result1 = mysqli_query($conn, $sql1);
	$row = mysqli_fetch_assoc($result1);

	class dataClass{
		public $cost;
		public $courier;
		public $phone_num;
		public $target_time;
		public $start_time;
		public $accept_time;
		public $send_time;
		public $arrive_time;
		public $end_time;
		public $convert_code;
	}

	$data = new dataClass();

	if ($row > 0) {
		$data->cost = $row['product_cost'];
		if ($row['if_company'] > 0) {
			$data->courier = "工作人员";
		}else {
			$data->courier = "用户";
		}
		$data->phone_num = $row['courier_phone_num'];
		$data->target_time = $row['target_time_date'].' '.$row['target_time_time'];
		$data->start_time = $row['start_time'];
		$data->accept_time = $row['accept_time'];
		$data->send_time = $row['send_time'];
		$data->arrive_time = $row['arrive_time'];
		$data->end_time = $row['end_time'];
		$data->convert_code = $row['convert_code'];

		echo json_encode($data);
	}else {
		echo "请求数据错误";
	}



 ?>