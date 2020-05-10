<?php
/*文件名称: sign_auto.php
 *文件作用: 每隔一小时自动执行脚本,修改需要重新启动服务器
 */
include ("conn.php");
mysqli_select_db($conn, 'zhygl');

ignore_user_abort(); //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行. 
set_time_limit(0); // 执行时间为无限制，php默认执行时间是30秒，可以让程序无限制的执行下去 
//$interval=24*60*60; // 每隔一天运行一次 
$interval = 60*60;
do{ 
sleep($interval); // 按设置的时间等待一小时循环执行 

$sql = "SELECT order_code, arrive_time FROM place_order WHERE order_status = 2";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$order_code = $row['order_code'];
		$arrive_time = $row['arrive_time'];
		$now_time = date("Y-m-d H:i:s",time());
		$now_time = strtotime($now_time);
		$sign_time = strtotime("+1 day",strtotime($arrive_time));
		
		if ($sign_time < $now_time) {
			$sign_time = date("Y-m-d H:i:s",$sign_time);
			echo $sign_time;
			$sql1 = "UPDATE place_order SET end_time = '$sign_time', order_status = 3 WHERE order_code = '$order_code'";
			$result1 = mysqli_query($conn, $sql1);
		}		
	}
}
}
while(true);
?>