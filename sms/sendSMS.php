<?php
//include('ChuanglanApi.php');
//$sms=new ChuanglanSmsApi();
$phone = trim($_REQUEST['phone']);
$code = rand(100000,999999);
//发送短信
$content = '［几木易康］您的验证码是：'.$code.'。';
//$result=$sms->sendSMS($phone,$content,0);
//echo $result."<br/>";
$postArr = array (
                   'un' => 'N6023778',
                   'pw' => '73faf8cf',
                   'msg' => $content,
                   'phone' => $phone,
                    'rd' => 0
                     );
$postFields = http_build_query($postArr);
//phpinfo();
$ch = curl_init();
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_HEADER, 0 );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_URL, 'https://sms.253.com/msg/send' );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
$result = curl_exec ( $ch );
//echo $result;
curl_close ( $ch );
//$temp = split(',',$result);
//$temp = split(':',$temp[0]);
//var_dump($temp);
$ret = array();
$ret['status'] =  'true';
$ret['code'] = $code;
//写入数据库
include("../ezSQL/init.php");
$sql = "insert into rd_sms(phone,code,status,timestamp)values('". $db->escape($phone) ."','$code','0','". time() ."')";
$db->query($sql);
echo json_encode($ret);
?>
