<?php
	include ('conn.php');

	$sql1 = "CREATE DATABASE zhygl";
	$result1 = mysqli_query($conn, $sql1);
	//创建zhygl数据库;

	mysqli_select_db($conn, 'zhygl');

	//创建user_info表
	$sql2 = "CREATE	TABLE user_info(
	user_id varchar(50) COMMENT 'open_id' PRIMARY KEY,					
	nick_name varchar(255) COMMENT '微信昵称',					
	gender tinyint(1) COMMENT '性别',								#微信1为男,0为女
	city varchar(255) COMMENT '市',
	province varchar(255) COMMENT '省',
	country varchar(255) COMMENT '区',
	ticket_num int COMMENT '券数' DEFAULT '0',
	cost_num int COMMENT '消耗券数' DEFAULT '0',
	convert_num int COMMENT '兑换券数' DEFAULT '0',
	place_num int COMMENT '订单数' DEFAULT '0'
	)";
	$result2 = mysqli_query($conn, $sql2);
	if (!$result2) echo "user_info未创建成功!";

	//创建用户地址表
	$sql3 = "CREATE TABLE user_address(
	user_id varchar(50) COMMENT 'open_id' PRIMARY KEY,
	receiver_name varchar(255)  COMMENT '收件人订单姓名',
	receiver_phone_num char(11) COMMENT '收件人电话',
	college varchar(255) COMMENT '大学',				
	/*给大学和校区加上默认值,防止在onload_edit页面的时候请求的为空数据导致原来页面的初
	始数据被覆盖进而防止第一次提交信息不选择地址的化会报错*/
	branch_school varchar(255) COMMENT '校区',
	apartment_num tinyint(1) COMMENT '楼号',
	room_num int COMMENT '宿舍号',
	if_default tinyint(1) DEFAULT '0' COMMENT '是否默认地址',
	FOREIGN KEY (user_id) REFERENCES user_info (user_id)
	)";
	$result3 = mysqli_query($conn, $sql3);
	if (!$result3) echo "user_address未创建成功!";
	
	//创建用户认证表
	$sql4 = "CREATE TABLE user_approve(
	user_id varchar(50) PRIMARY KEY COMMENT 'open_id',
	real_name varchar(255) COMMENT '真实姓名',
	student_id varchar(255) COMMENT '学号',
	phone_num char(11) COMMENT '电话',
	college varchar(255) COMMENT '大学',
	branch_school varchar(255) COMMENT '校区',
	apartment_num tinyint(1) COMMENT '楼号',
	room_num int COMMENT '宿舍号',
	student_card_image varchar(255) COMMENT '学生卡图片地址',
	if_approve tinyint(1) DEFAULT '0' COMMENT '是否认证',
	if_work tinyint(1) DEFAULT '0' COMMENT '是否工作人员',
	collect_num int DEFAULT '0' COMMENT '领单数量',
	week_num int DEFAULT '0' COMMENT '周剩余数量',
	FOREIGN KEY (user_id) REFERENCES user_info (user_id)
	)";
	$result4 = mysqli_query($conn, $sql4);
	if (!$result4) echo "user_approve未创建成功!";
	
	//创建订单
	$sql5 = "CREATE TABLE place_order(
	order_id int(20) AUTO_INCREMENT PRIMARY KEY COMMENT '订单id',
	order_code varchar(12) COMMENT '订单码' NOT NULL,
	order_status tinyint(1) COMMENT '订单状态' DEFAULT '0',			#0表示待领取,1表示代送达,2表示待签收,3表示已完成
	product_volume tinyint(1) COMMENT '物品大小',					#1表示小,2表示中件,3表示大件
	product_cost tinyint(1) COMMENT '运送费用',
	product_code_pre tinyint(2) COMMENT '货架',
	product_code_mid tinyint(1) COMMENT '层数',
	product_code_post int(4)  COMMENT '货号',
	product_code_image varchar(255) COMMENT '短信照片地址',
	receiver_user_id varchar(50)  COMMENT '收件人openid',
	#receiver_name varchar(255)  COMMENT '收件人订单姓名',
	courier_user_id varchar(50) COMMENT '运送人openid',
	if_company tinyint(1) COMMENT '是否公司运送' DEFAULT '1',
	#receiver_phone_num char(11)  COMMENT '收件人电话',
	courier_phone_num char(11) COMMENT '运送人电话',
	#college varchar(255) COMMENT '大学',
	#branch_school varchar(255) COMMENT '校区',
	#apartment_num tinyint(1) COMMENT '楼号',
	#root_num int COMMENT '宿舍号',
	target_time_date date COMMENT '目标日期',
	target_time_time varchar(255) COMMENT '目标时间段',					
	start_time datetime COMMENT '创建时间',
	accept_time datetime COMMENT '接单时间',
	send_time datetime COMMENT '领货时间',
	arrive_time datetime COMMENT '送达时间',
	end_time datetime COMMENT '收货时间',
	convert_code varchar(12) COMMENT '兑换码',
	UNIQUE (order_code)
	)";
	$result5 = mysqli_query($conn, $sql5);
	if (!$result5) echo "place_order未创建成功!";
	

	//创建兑换记录表
	$sql6 = "CREATE TABLE convert_record(
	convert_code varchar(12) PRIMARY KEY COMMENT '兑换码',
	creator_user_id varchar(50) COMMENT '产生者open',
	consumer_user_id varchar(50) COMMENT '使用者open',
	face_value tinyint(1) COMMENT '面值',
	create_way enum('worker','user') COMMENT '产生方式',
	create_time datetime COMMENT '产生时间',
	consume_time datetime COMMENT '消耗时间',
	if_convert tinyint(1) COMMENT '是否兑换' DEFAULT '0'
	)";
	$result6 = mysqli_query($conn, $sql6);
	if (!$result6) echo "convert_record未创建成功!";
	
?>