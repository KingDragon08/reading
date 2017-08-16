<meta charset="utf-8">
<?php
  session_start();
  include("../ezSQL/init.php");
  $username = $_POST['username'];
  $password = $_POST['password'];
  $class_id = $_POST['id'];
  //获取用户ID
  $sql = "select id from rd_user where username='$username' and password='$password'";
  $id = $db->get_var($sql);
  if($id){
  	$sql = "delete from rd_class where id='$class_id' and teacher_id='$id'";
  	$db->query($sql);
  	$ret = array();
  	$ret['status'] = 1;
  	$ret['error'] = '删除成功';
  	echo json_encode($ret);
  	exit();
  }
  else{
  	$ret = array();
  	$ret['status'] = 0;
  	$ret['error'] = '参数错误';
  	echo json_encode($ret);
  	exit();
  }
?>