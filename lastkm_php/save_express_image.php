<?php
/*
 *文件名称: save_express_image.php
 *文件作用: 接受从前端提交的图片并将他们依照目标时间和日期存在对应的文件夹里
 */
header('content-type:application/json;charset=utf8');
$college = $_POST['college'];
$branch = $_POST['branch'];
$school = $college.$branch;
$target_date = $_POST['target_date'];
 	$target_date = explode('-',$target_date);					#打散成数组
 	$target_date = implode('', $target_date);					#结合字符串
 	$target_time = $_POST['target_time'];
 	$target_time = explode(':', $target_time);
 	$target_time = implode('.', $target_time);
 	$code_pre = $_POST['code_pre'];
 	$code_mid = $_POST['code_mid'];
 	$code_post = $_POST['code_post'];
 	$image_name = (string)($code_pre).'-'.(string)($code_mid).'-'.(string)($code_post).'-'.time();

 	function createDir($schoolLevel,$dateLevel, $timeLevel) {
 		if (!is_dir("../express_image/$schoolLevel")) {
 			$schoolFlag = mkdir("../express_image/$schoolLevel");
 			if (!$schoolFlag) {
	 				#echo "Create shoolLevel fail!";
 				return fail;
 			}
 			else {
			 		if (!is_dir("../express_image/$schoolLevel/$dateLevel")) {				#这里两个变量连用可能有问题
			 			$dateFlag = mkdir("../express_image/$schoolLevel/$dateLevel");
			 			if (!$dateFlag) {
		 				#echo "create dateLevel file fail!";
			 				return fail;
			 			}else {
			 				if(!is_dir("../express_image/$schoolLevel/$dateLevel/$timeLevel")) {
			 					$timeFlag = mkdir("../express_image/$schoolLevel/$dateLevel/$timeLevel");
			 					if (!$timeFlag) {
		 						#echo "create dateLevel file success,create timeLevel file fail!";
			 						return fail;
			 					}
			 					else {
		 						#echo "create dateLevel file success, create timeLevel file success!";
			 						return true; 
			 					}
			 				}else {
		 					#echo "dateLevel file create, but timeLevel file exited, this can't happen!";
			 					return true;
			 				}
			 			}
			 		}else {
			 			if(!is_dir("../express_image/$schoolLevel/$dateLevel/$timeLevel")) {
			 				$timeFlag = mkdir("../express_image/$schoolLevel/$dateLevel/$timeLevel");
			 				if (!$timeFlag) {
		 						#echo "already had dateLevel file, create timeLevel file fail!";
			 					return fail;
			 				}
			 				else {
		 						#echo "already had dateLevel file, create timeLevel file success!";
			 					return true;
			 				}
			 			}else {
		 					#echo "both already had been exited!";
			 				return true;
			 			}
			 		}
			 	}
			 }else {/*如果shcoolLevel级的存在*/
			if (!is_dir("../express_image/$schoolLevel/$dateLevel")) {				#这里两个变量连用可能有问题
				$dateFlag = mkdir("../express_image/$schoolLevel/$dateLevel");
				if (!$dateFlag) {
		 				#echo "create dateLevel file fail!";
					return fail;
				}else {
					if(!is_dir("../express_image/$schoolLevel/$dateLevel/$timeLevel")) {
						$timeFlag = mkdir("../express_image/$schoolLevel/$dateLevel/$timeLevel");
						if (!$timeFlag) {
		 						#echo "create dateLevel file success,create timeLevel file fail!";
							return fail;
						}
						else {
		 						#echo "create dateLevel file success, create timeLevel file success!";
							return true; 
						}
					}else {
		 					#echo "dateLevel file create, but timeLevel file exited, this can't happen!";
						return true;
					}
				}
			}else {
				if(!is_dir("../express_image/$schoolLevel/$dateLevel/$timeLevel")) {
					$timeFlag = mkdir("../express_image/$schoolLevel/$dateLevel/$timeLevel");
					if (!$timeFlag) {
		 						#echo "already had dateLevel file, create timeLevel file fail!";
						return fail;
					}
					else {
		 						#echo "already had dateLevel file, create timeLevel file success!";
						return true;
					}
				}else {
		 					#echo "both already had been exited!";
					return true;
				}
			}
		}
	}

	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 1024000)
		&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0) {
        #echo "错误：: " . $_FILES["file"]["error"] . "<br>";
		}else {
			if (createDir($school,$target_date,$target_time)) {
				if (file_exists("../express_image/$school/$target_date/$target_time/".$_FILES['file']['name'])){
					echo "this product_image has already exited!";
					return;
				}
				else {
					
					move_uploaded_file($_FILES['file']['tmp_name'], "../express_image/$school/$target_date/$target_time/".$_FILES['file']['name']);
					$oldname = "../express_image/$school/$target_date/$target_time/".$_FILES['file']['name'];
					$newname = "../express_image/$school/$target_date/$target_time/".$image_name.'.'.$extension;
					rename($oldname, $newname);
					echo $newname;
 				#echo "upload product image success";
					return;
				}
			}
			else {
 			#echo "create dir fail!";
				return;
			}
		}	
	}
	else {
 		#echo "image has something wrong!";
	}
	?>