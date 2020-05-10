<?php
/*文件名称: onload_want_order.php
 *文件作用: 得到want_order页面的usere_id,time,volume,apartment,now_itme_num信息,返回否和要求的未接单的数据;
 */
 	include ("conn.php");

 	$user_id = $_POST['user_id'];
 	$date = date('Y-m-d',strtotime($_POST['date']));/*搜索数据库中的日期必须用日期格式 strtotime返回的是一个时间戳,而getDate是由时间戳得到一个日期*/
 	$time = $_POST['time'];
 	$apartment = (int)($_POST['apartment']);
 	$volume = (int)($_POST['volume']);
 	$now_item_num = (int)($_POST['now_item_num']);

 	class itemClass {
 		public $name;
 		public $value;
 		public $checked;
 	}

 	mysqli_select_db($conn, 'zhygl');
 	$data = array();
 	/*先得到领单人的学校,然后所显示的订单的收货学校必须与此学校校区匹配*/
 	$sql = "SELECT college, branch_school FROM user_approve WHERE user_id = '$user_id'";
 	$result = mysqli_query($conn, $sql);
 	$row = mysqli_fetch_assoc($result);
 	$college = $row['college'];
 	$branch_school = $row['branch_school'];

 	if ($volume < 4) {
 		$sql1 = "SELECT 
 		ad.college,
 		ad.branch_school,
 		ad.apartment_num,
 		od.order_code,
 		od.product_volume FROM 
 		place_order AS od,
 		user_address AS ad
 		WHERE
 		ad.college = '$college' and
 		ad.branch_school = '$branch_school' and
 		od.receiver_user_id = ad.user_id and 
 		od.order_status = 0 and 
 		od.courier_user_id is null and 
 		od.target_time_date = '$date' and 
 		od.target_time_time = '$time' and 
 		ad.apartment_num = '$apartment' and 
 		od.product_volume = '$volume' 
 		ORDER BY ad.room_num ASC, od.product_code_pre ASC, od.product_code_mid ASC, od.product_code_post ASC 
 		LIMIT $now_item_num ";
 		$result1 = mysqli_query($conn, $sql1);
 	
 		if (mysqli_num_rows($result1) > 0) {
 			while ($row1 = mysqli_fetch_assoc($result1)) {
 				$item = new itemClass();
 				switch ($row1['product_volume']) {
 					case '1':
 						$volume_word = '小件';
 						break;
 					case 2: 
 						$volume_word = '中件';
 						break;
 					case 3:
 						$volume_word = '大件';
 						break;
 					default:
 						# code...
 						break;
 				}
 				$name = $date.' '.$time.' '.$row1['apartment_num'].'号楼'.' '.$volume_word;
 				$item->name = $name;
 				$item->value = $row1['order_code'];
 				$item->checked = false;

 				$data[] = $item;

 			}
 			echo json_encode($data);
 		}else {
 			echo json_encode($data);
 		}
 	}else {
 		$sql1 = "SELECT 
 		ad.college,
 		ad.branch_school,
 		ad.apartment_num,
 		od.order_code,
 		od.product_volume FROM 
 		place_order AS od,
 		user_address AS ad
 		WHERE 
 		ad.college = '$college' and
 		ad.branch_school = '$branch_school' and
 		od.receiver_user_id = ad.user_id and 
 		od.order_status = 0 and 
 		od.courier_user_id is null and 
 		od.target_time_date = '$date' and 
 		od.target_time_time = '$time' and 
 		ad.apartment_num = '$apartment' and 
 		(od.product_volume = 1 or 
 		od.product_volume = 2) 
 		ORDER BY ad.room_num ASC, od.product_code_pre ASC, od.product_code_mid ASC, od.product_code_post ASC 
 		LIMIT $now_item_num ";
 		$result1 = mysqli_query($conn, $sql1);
 		if (mysqli_num_rows($result1) > 0) {
 			while ($row1 = mysqli_fetch_assoc($result1)) {
 				$item = new itemClass();
 				switch ($row1['product_volume']) {
 					case '1':
 						$volume_word = '小件';
 						break;
 					case 2: 
 						$volume_word = '中件';
 						break;
 					case 3:
 						$volume_word = '大件';
 						break;
 					default:
 						# code...
 						break;
 				}
 				$name = $date.' '.$time.' '.$row1['apartment_num'].'号楼'.' '.$volume_word;
 				$item->name = $name;
 				$item->value = $row1['order_code'];
 				$item->checked = false;

 				$data[] = $item;

 			}
 			echo json_encode($data);
 		}else {
 			echo json_encode($data);
 		}
 	}
 ?>