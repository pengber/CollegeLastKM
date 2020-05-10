<?php
/*文件名称: convert.php
 *文件作用: 收集来自convert页面的数据来利用查询convert_record来更新convert_record和更新user_info
 */
	include ("conn.php");

	$convert_code = $_GET['convert_code'];
	$user_id = $_GET['user_id'];

	mysqli_select_db($conn, 'zhygl');

	$sql1 = "SELECT if_convert, face_value FROM convert_record WHERE convert_code = '$convert_code'";
	$result1 = mysqli_query($conn, $sql1);

	if (mysqli_num_rows($result1) > 0) {
		$row1 = mysqli_fetch_assoc($result1);
		$if_convert = $row1['if_convert'];
		$face_value = $row1['face_value'];
		$now_time = date('Y-m-d H:i:s', time());
		if ($if_convert == 0) {
			$sql2 = "UPDATE convert_record SET if_convert = '1',
			consumer_user_id = '$user_id',
			consume_time = '$now_time' 
			WHERE convert_code = '$convert_code'";
			$reuslt2 = mysqli_query($conn, $sql2);
			if (!$reuslt2) {
				echo json_encode(3);					/*3表示意外失败*/
				return;
			}

			$sql3 = "SELECT ticket_num, convert_num FROM user_info WHERE user_id ='$user_id'";
			$result3 = mysqli_query($conn, $sql3);
			$row3 = mysqli_fetch_assoc($result3);

			$ticket_num = $row3['ticket_num'] + $face_value;
			$convert_num = $row3['convert_num'] + $face_value;
			$sql4 = "UPDATE user_info SET ticket_num = '$ticket_num', convert_num = '$convert_num' WHERE user_id='$user_id'";
			$result4 = mysqli_query($conn, $sql4);

			if (!$result4 || !$result3) {
				echo json_encode(3);						/*3表示兑换码正确未兑换但兑换失败*/
				return;
			}

			echo json_encode(0);							/*0表示兑换码未兑换此次兑换成功*/
			return;

		}else {
			echo json_encode(1);			/*返回1表示兑换过了*/
		}

	}else {
		echo json_encode(2);				/*2表示兑换码不存在*/
		return;
	}

 ?>