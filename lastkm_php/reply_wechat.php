<?php
/*文件名称: reply_wechat.php
 *文件作用: 相应wechat验证消息服务器
 */

//1. 将timestamp , nonce , token 按照字典排序
$timestamp = $_GET['timestamp'];
$nonce = $_GET['nonce'];
$token = "lastkm";
$signature = $_GET['signature'];
$array = array($timestamp,$nonce,$token);
sort($array);
 
//2.将排序后的三个参数拼接后用sha1加密
$tmpstr = implode('',$array);
$tmpstr = sha1($tmpstr);
 
//3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信
if($tmpstr == $signature)
{
	echo $_GET['echostr'];
	exit;
}
 ?>

