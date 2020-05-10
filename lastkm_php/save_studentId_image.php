<?php
/*文件名称: save_studentId_image.php
 *文件作用: 收集来自approve页面的照片信息并存储下来
 *如果有新的大学加进来的话需要修改schools来得到不同的处理大学学号的方式并且存储其学生卡信息
 *更新方式就是1.在shools添加新学区. 2.在16行switch里面添加新的处理方法(与shcools下标对应);
 */
	header('content-type:application/json;charset=utf8');
	include ("college_information.php");
	$studentId = $_POST['studentId'];
	$college = $_POST['college'];
	$branch = $_POST['branch'];
	$school = $college.$branch;
	$year = '入学年份';
	$institute = '专业';
	for ($i=0; $i < count($schools); $i++) {
		if ($schools[$i] == $school) {
			switch ($i) {
				case '0':
					$GLOBALS['year'] = substr($studentId, 0, 4);
					$GLOBALS['institute'] = substr($studentId, 4, 2);
					break;
				#case '1':
				default:
					break;
			}
		}
	}

	function createDir($schoolLevel, $yearNum, $instituteNum) {
		if (!is_dir("../studentId_image/$schoolLevel")) {
			$schoolFlag = mkdir("../studentId_image/$schoolLevel");
			
			if (!$schoolFlag) {
				#echo "create schoolLevel file fail";
				return fail;
			}else {
				if (!is_dir("../studentId_image/$schoolLevel/$yearNum")) {
					$dateFlag = mkdir("../studentId_image/$schoolLevel/$yearNum");
					if (!$dateFlag) {
      					  #echo "create dateLevel file fail!";
						return fail;
					}else {
						if(!is_dir("../studentId_image/$schoolLevel/$yearNum/$instituteNum")) {
							$timeFlag = mkdir("../studentId_image/$schoolLevel/$yearNum/$instituteNum");
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
					if(!is_dir("../studentId_image/$schoolLevel/$yearNum/$instituteNum")) {
						$timeFlag = mkdir("../studentId_image/$schoolLevel/$yearNum/$instituteNum");
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
		}else {
			if (!is_dir("../studentId_image/$schoolLevel/$yearNum")) {
				$dateFlag = mkdir("../studentId_image/$schoolLevel/$yearNum");
				if (!$dateFlag) {
        			#echo "create dateLevel file fail!";
					return fail;
				}else {
					if(!is_dir("../studentId_image/$schoolLevel/$yearNum/$instituteNum")) {
						$timeFlag = mkdir("../studentId_image/$schoolLevel/$yearNum/$instituteNum");
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
				if(!is_dir("../studentId_image/$schoolLevel/$yearNum/$instituteNum")) {
					$timeFlag = mkdir("../studentId_image/$schoolLevel/$yearNum/$instituteNum");
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
 		if (createDir($school, $year, $institute)) {
 			if (file_exists("../studentId_image/$school/$year/$institute/".$_FILES['file']['name'])){
 				echo "this product_image has already exited!";
 				return;
 			}
 			else {
 				//这里和save_express_image不同,因为express_image名字后面的和前面的可以重复,但是学号重复的话就得覆盖
 				move_uploaded_file($_FILES['file']['tmp_name'], "../studentId_image/$school/$year/$institute/".$_FILES['file']['name']);
 				$oldname = "../studentId_image/$school/$year/$institute/".$_FILES['file']['name'];
 				$newname = "../studentId_image/$school/$year/$institute/".$studentId.'.'.$extension;
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