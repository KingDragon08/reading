<?php
require(dirname(__FILE__).'/ChuanglanSMS.php');
$sms=new ChuanglanSMS('N6023778','73faf8cf');
$phone = trim($_POST['phone']);
$code = rand(100000,999999);
//发送短信
$result=$sms->send($phone,'【几木易康】您的验证码是：'.$code.'。');
//echo $result."<br/>";
$temp = split(',',$result);
$temp = split(':',$temp[0]);
$ret = array();
$ret['status'] =  trim($temp[1]);
//写入数据库
include("../ezSQL/init.php");
$sql = "insert into rd_sms(phone,code,status,timestamp)values('". $db->escape($phone) ."','$code','0','". time() ."')";
$db->query($sql);
echo json_encode($ret);
?>
