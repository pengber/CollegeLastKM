<?php
/*文件名称: sign_order.php
 *文件作用: place_order页面客户签收,接受order_code,操作数据库转移订单状态
 */
	include ("conn.php");

	$user_id = $_GET['user_id'];
	$order_code = $_GET['order_code'];
	mysqli_select_db($conn, 'zhygl');
	/*首先更新订单状态*/
	$now_time =  date('Y-m-d H:i:s', time());
	$sql1 = "UPDATE place_order SET order_status = '3',end_time = '$now_time' WHERE order_code ='$order_code'";
	$result1 = mysqli_query($conn, $sql1);

	if ($result1) {
		echo "sign success!";
	}
	else {
		echo "sign fail";
	}

	$sql3 = "SELECT product_cost, if_company FROM place_order WHERE order_code = '$order_code'";
	$result3 = mysqli_query($conn, $sql3);
	$row3 = mysqli_fetch_assoc($result3);
	$product_cost = $row3['product_cost'];
	$if_company = $row3['if_company'];

	/*签收完了如果是用户配送的话应该给一个十一位兑换码,第一位是面额,后一位0的话是兑换所得,1的话是购买所得*/

	if ($if_company == '0') {
		function foo() {
  		$o = $last = '';
  		do {
    	$last = $o;
    	usleep(10);
    	$t = explode(' ', microtime());
    	$o = substr(base_convert(strtr($t[0].$t[1].$t[1], '.', ''), 10, 36), 0, 9);
  		}while($o == $last);
  		return $o;
		}

		$convert_code = foo();
		$convert_code = (base_convert((int)($product_cost/2+0.5), 10, 16)).$convert_code.'0';/*因为代取的话要打50%的折扣,防止出现小数用四舍五入算法处理*/
		$face_value = (int)($product_cost/2 + 0.5);
		

		$sql5 = "UPDATE place_order SET convert_code = '$convert_code' WHERE order_code = '$order_code'";
		$result5 = mysqli_query($conn, $sql5);

		if ($result5) { 
			echo "Update table user_info's convert_code success!";
		}else {
			echo "Update table user_info's convert_code fail!";
		}

		$sql6 = "INSERT INTO convert_record (convert_code, creator_user_id, face_value, create_way, create_time) VALUES (
		'$convert_code',
		'$user_id',
		'$face_value',
		'user',
		'$now_time'
		)";
		$result6 = mysqli_query($conn, $sql6);

		if ($result6) {
			echo "Insert into table convert_code's information of convert_code success!";
		}else {
			echo "Insert into table convert_code's information of convert_code fail!";
		}
	}
 ?>