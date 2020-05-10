<?php
/*
 *文件名称: onload_sharing_ticket.php
 *文件作用: 得到sharing_ticket页面提交的openid,返回用户共享券情况
 */

 include ("conn.php");

 $user_id = $_GET['user_id'];

 mysqli_select_db($conn, 'zhygl');
 $sql1 = "SELECT ticket_num, cost_num, convert_num FROM user_info WHERE user_id = '$user_id'";
 $result1 = mysqli_query($conn, $sql1);
 $row = mysqli_fetch_assoc($result1);

 class dataClass{
 	public $balance;
 	public $use;
 	public $totalConvert;
 	public $button_show;
 	public $button_word;
 }
 $data = new dataClass();
 $data->button_show = true;					//控制支付按钮
 $data->button_word = "充值";
 $data->balance = $row['ticket_num'];			#剩余券数
 $data->use = $row['cost_num'];
 $data->totalConvert = $row['convert_num'];

 echo json_encode($data);
?>