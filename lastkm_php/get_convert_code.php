<?php
	/*文件名称: get_convert_code.php
	*文件作用: 得到充值或其他方式得来金额,然后根据方式插入兑换码
	*/

	include ("conn.php");
	mysqli_select_db($conn, 'zhygl');
	$type = $_POST['type'];
	$user_id = $_POST['user_id'];
	$ticket_value = $_POST['ticket_value'];

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
	$convert_code = (base_convert((int)($ticket_value), 10, 16)).$convert_code.$type;/*因为代取的话要打50%的折扣,防止出现小数用四舍五入算法处理*/
	$now_time =  date('Y-m-d H:i:s', time());

	$sql = "INSERT INTO convert_record(convert_code, creator_user_id, face_value, create_way, create_time) VALUES(
	'$convert_code',
	'$user_id',
	'$ticket_value',
	'worker',
	'$now_time')";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		echo json_encode($convert_code);
	}else {
		echo json_encode("insert fail");
	}



?>