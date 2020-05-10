<?php
 /*文件名称: get_user_ticker.php
  *文件作用: 返回用户的下单次数,券数等信息
  */

  include ("conn.php");
  $nick_name = $_GET['user_nick_name'];

  mysqli_select_db($conn, 'zhygl');

  $sql = "SELECT * FROM user_info WHERE nick_name = '$nick_name'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  class dataClass{
  	public $ticket_num;
  	public $cost_num;
  	public $convert_num;
  	public $place_num;
  }

  $data = new dataClass;

  $data->ticket_num = $row['ticket_num'];
  $data->cost_num = $row['cost_num'];
  $data->convert_num = $row['convert_num'];
  $data->place_num = $row['place_num'];
  
  echo json_encode($data);
  ?> 