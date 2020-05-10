<?php  

/*文件名称: login.php
 *文件作用: 用自己小程序的id和secret和用户的code通过微信的API来获取用户openid
 */
  	include("conn.php");
    $appid = 'xxxxxxxxxxxxx&secret'; 	//填写你自己的appid
    $secret = 'xxxxxxxxxxxxxxxxxxxxx';      //你自己的secret
    $code = $_GET['code'];
    
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';  

	$ch = curl_init(); 
	$timeout = 5; 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST,0);/*访问https需要*/
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
	$info = curl_exec($ch); 
	curl_close($ch); 
    $json = json_decode($info);//对json数据解码 
    $arr = get_object_vars($json);
    $openid = $arr['openid'];  
    $arr = json_encode($arr);  
    echo $openid;
  
?>  
