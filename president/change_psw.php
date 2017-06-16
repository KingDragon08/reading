<?php
  include_once("common.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css" media="screen">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <title>乐智悦读-更改密码</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $user_info = $user->get_user_info();
        //处理更改密码的表单
        if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']))
        {
          $old_password = $_POST['old_password'];
          $new_password = $_POST['new_password'];
          $confirm_password = $_POST['confirm_password'];
          if(strlen($old_password)<6 || strlen($new_password)<6 || strlen($confirm_password)<6)
          {
            echo "<script>alert('修改密码失败');</script>";
          }
          if($user->change_psw($old_password,$new_password))
          {
            foreach($_COOKIE as $key=>$value)
            {
              setCookie($key,"",time()-60);
              $_COOKIE[$key] = "";
            }
            session_unset();
            session_destroy();
            echo "<script>alert('修改密码成功,请重新登录');parent.window.location.href='index.php'</script>";
          }
          else
          {
            echo "<script>alert('修改密码失败');</script>";
          }
        }
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">更改密码</h4>
    </center>
    <br><br>
    <form class="" action="" method="post" onsubmit="return check();">
      <div class="container">
        <table width="400" height="auto" border="0">
          <tr>
            <td width="100" height="50" align="left" valign="middle">旧密码</td>
            <td width="300" height="50" align="left" valign="middle">
              <input type="password" name="old_password" id="old_password" class="form-control" placeholder="请填入旧密码">
            </td>
          </tr>
          <tr>
            <td width="100" height="50" align="left" valign="middle">新密码</td>
            <td width="300" height="50" align="left" valign="middle">
              <input type="password" name="new_password" id="new_password" class="form-control" placeholder="请填入新密码">
            </td>
          </tr>
          <tr>
            <td width="100" height="50" align="left" valign="middle">确认密码</td>
            <td width="300" height="50" align="left" valign="middle">
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="请再次填入新密码">
            </td>
          </tr>
          <tr>
            <td height="50" align="left" valign="middle"colspan="3">
              <input type="submit" name="submit" value="确认更改" class="btn btn-danger form-control">
            </td>
          </tr>
        </table>
      </div>
    </form>
    <script type="text/javascript">
      function check()
      {
        if($("#old_password").val().length < 6)
        {
          alert("旧密码不正确");
          return false;
        }
        if($("#new_password").val().length < 6)
        {
          alert("新密码至少6位");
          return false;
        }
        if($("#confirm_password").val().length < 6)
        {
          alert("确认密码至少6位");
          return false;
        }
        if($("#confirm_password").val() != $("#new_password").val())
        {
          alert("两次密码不一致");
          return false;
        }
        return true;
      }
    </script>
  </body>
</html>
