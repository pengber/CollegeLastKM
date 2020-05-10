<?php
	/*文件名称: check_password.php
	*文件作用: 检查密码
	*
	*/
	$password = $_POST['password'];
	$realPassword = "123.";

	if ($password === $realPassword) {
		echo json_encode(1);
	}else {
		echo json_encode(0);
	}


?>