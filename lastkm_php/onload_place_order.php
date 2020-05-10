<?php
/*
 *文件名称: onload_place_order.php
 *文件作用: 接受place_order页面的信息,返回用户订单信息,用switch判断哪种订单
 */

 	include ("conn.php");

 	$active_index = (int)($_POST['activeIndex']);
 	$user_id = $_POST['user_id'];
 	$need_all_num = (int)($_POST['need_all_num']);

 	class itemClass{
 		public $order_code;
 		public $name;
 		public $phone;
 		public $apartment;
 		public $room;
 		public $volume;
 		public $target_date;
 		public $target_time;
 		public $code;
 		public $product_image;
 		public $show;
 	}
 	$data = array();
 	mysqli_select_db($conn, 'zhygl');
 	$sql = "SELECT
 	od.order_code,
 	od.target_time_date,
 	od.target_time_time,
 	od.product_code_pre,
 	od.product_code_mid,
 	od.product_code_post,
 	od.product_code_image,
 	od.product_volume,
 	ad.receiver_name,
 	ad.receiver_phone_num,
 	ad.apartment_num,
 	ad.room_num
 	FROM place_order AS od, user_address AS ad 
 	WHERE ad.user_id = '$user_id' and od.receiver_user_id = '$user_id' and od.order_status = '$active_index'
 	ORDER BY od.start_time DESC LIMIT $need_all_num
 	";
 	$result = mysqli_query($conn, $sql);

 	if (mysqli_num_rows($result) > 0) {
 		while($row = mysqli_fetch_assoc($result)) {
 			$item=new itemClass();
 			$item->order_code = $row['order_code'];
 			$item->name = $row['receiver_name'];
 			$item->phone = $row['receiver_phone_num'];
 			$item->apartment = $row['apartment_num'];
 			$item->room = $row['room_num'];
 			$item->target_date = $row['target_time_date'];
 			$item->target_time = $row['target_time_time'];
 			$item->show = true;

 			$item->code = $row['product_code_pre'].'-'.$row['product_code_mid'].'-'.$row['product_code_post'];
 			switch ($row['product_volume']) {
 				case 1:
 					$item->volume = '小件';
 					break;
 				case 2:
 					$item->volume = '中件';
 					break;
 				case 3:
 					$item->volume = '大件';
 					break;
 				default:
 					echo "somthing about volume is wrong!";
 					break;
 			}

 			$path = str_replace("../", "//", $row['product_code_image']);
 			$item->product_image = "http://".$_SERVER['HTTP_HOST'].$path;

 			$data[] = $item;
 		}

 		#echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

 	}else {
 		#echo "null";
 	}
 	/*这下处理place_order每个子列的数字,但并不得到内容*/
 	$itemNum = array();
 	$sql0 = "SELECT * FROM place_order WHERE receiver_user_id = '$user_id' and order_status = '0'";
 	$result0 = mysqli_query($conn, $sql0);
 	$itemNum[0] = mysqli_num_rows($result0);

 	$sql1 = "SELECT * FROM place_order WHERE receiver_user_id = '$user_id' and order_status = '1'";
 	$result1 = mysqli_query($conn, $sql1);
 	$itemNum[1] = mysqli_num_rows($result1);

 	$sql2 = "SELECT * FROM place_order WHERE receiver_user_id = '$user_id' and order_status = '2'";
 	$result2 = mysqli_query($conn, $sql2);
 	$itemNum[2] = mysqli_num_rows($result2);

 	$sql3 = "SELECT * FROM place_order WHERE receiver_user_id = '$user_id' and order_status = '3'";
 	$result3 = mysqli_query($conn, $sql3);
 	$itemNum[3] = mysqli_num_rows($result3);

 	#echo json_encode($itemNum);


 	class dataClass{
 		public $itemArray;
 		public $itemNumArray;
 	}

 	$dataClass = new dataClass();
 	$dataClass->itemArray = $data;
 	$dataClass->itemNumArray = $itemNum;

 	echo json_encode($dataClass);
 ?>