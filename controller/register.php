<?php
  $from_url =  $_SERVER['HTTP_REFERER'];
  if(isset($_POST['username']) && isset($_POST['verify_code']) && isset($_POST['password']) &&
    isset($_POST['re_password']))
  {
    $username = $_POST['username'];
    $verify_code = $_POST['verify_code'];
    $password = md5($_POST['password']);
    $re_password = md5($_POST['re_password']);
    //验证两次密码是否一致
    if($password != $re_password)
    {
      $error = json_encode("两次密码不一致");
      header("Location:tips.php?error=$error&from=$from_url");
      exit();
    }
    include("../ezSQL/init.php");
    //验证验证码是否正确
    $count = $db->get_var("select count(*) from rd_sms where phone='".$db->escape($username)."' and ".
                          "code='". $db->escape($verify_code) ."' and status=0");
    if($count != 1)
    {
      $error = json_encode("验证码错误");
      header("Location:../tips.php?error=$error&from=$from_url&type=0");
      exit();
    }
    //验证手机号码是否已经注册
    $registed = $db->get_var("select count(*) from rd_user where username='". $db->escape($username) ."'");
    if($registed > 0)
    {
      $error = json_encode("该手机号已注册");
      //更新短信数据库
      $db->query("update rd_sms set status=1 where phone='". $db->escape($username) ."'");
      header("Location:../tips.php?error=$error&from=$from_url&type=0");
      exit();
    }
    //一切正常,更改短信发送记录状态
    $db->query("update rd_sms set status=1 where phone='". $db->escape($username) ."'");
    //写入用户信息到用户表
    $db->query("insert into rd_user(username,password,role,addtime)values('".$db->escape($username)."','$password',1,time())");
    // //获取刚注册用户的id
    // $user_id = $db->get_var("select id from rd_user where username='$username'");
    // //为改用户创建一个大书单
    //
    $error = json_encode("注册成功,立即登录完善资料吧");
    header("Location:../tips.php?error=$error&from=login.php&type=0");
  }
?>
