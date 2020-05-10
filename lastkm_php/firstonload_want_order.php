<?php
/*文件名称: firstonload_want_order.php
 *文件作用: 得到want_order提交的user_id信息,返回时间段,对应的宿舍和周剩余领取量,是否是工作人员,如果未认证则返回错误码
 */
 	include ("conn.php");
 	include ("college_information.php");
 	include ("time_information.php");
 	$user_id = $_GET['user_id'];
 	mysqli_select_db($conn, 'zhygl');

 	$sql1 = "SELECT college, branch_school, if_approve, if_work, week_num FROM user_approve WHERE user_id = '$user_id'";
 	$result1 = mysqli_query($conn, $sql1);
 	$row1 = mysqli_fetch_assoc($result1);
 	$if_approve = $row1['if_approve'];
 	$if_work = $row1['if_work'];
 	$college = $row1['college'];
 	$branch_school = $row1['branch_school'];
 	$school = $college.$branch_school;

 	$apartments = array();
 	for ($i=0; $i < count($schools); $i++) {
		if ($schools[$i] == $school) {
			switch ($i) {
				case '0':
					$GLOBALS['apartments'] = ['1', '2', '3', '4', '5', '6', '7'];/*北京化工大学楼号*/
					break;
				#case '1':
				default:
					break;
			}
		}
	}

	$time = $times;
 	$week_num = $row1['week_num'];
 	class dataClass {
 		public $apartments;
 		public $time;
 		public $week_num;
 		public $if_approve;
 		public $if_work;
 	}
 	$data = new dataClass();

 	$data->apartments = $apartments;
 	$data->time = $time;
 	$data->week_num = $week_num;
 	$data->if_approve = $if_approve;
 	$data->if_work = $if_work;
 	echo json_encode($data);

 ?>