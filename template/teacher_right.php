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
    <title>乐智悦读-内容</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $user_info = $user->get_user_info();
        //处理更改用户名的表单
        if(isset($_POST['name']))
        {
          $name = $_POST['name'];
          $user->change_name($name);
          echo "<script>parent.location.reload();</script>";
        }
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">基本资料</h4>
    </center>
    <br><br>
    <form class="" action="" method="post">
      <div class="container">
        <table width="500" height="auto" border="0">
          <tr>
            <td width="100" height="50" align="left" valign="middle">用户名</td>
            <td width="300" height="50" align="left" valign="middle">
              <input type="text" name="name" value="<?php echo $user_info->name ?>" class="form-control">
            </td>
            <td width="100" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">
              <input type="submit" name="submit" value="确认更改" class="btn btn-danger form-control">
            </td>
          </tr>
          <tr>
            <td width="100" height="50" align="left" valign="middle">性别</td>
            <td width="300" height="50" align="left" valign="middle">
              <?php
                if($user_info->sex == 0)
                {
                  echo "男";
                }
                if($user_info->sex == 1)
                {
                  echo "女";
                }
              ?>
            </td>
            <td width="100" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">性别不可更改</td>
          </tr>
          <tr>
            <td width="100" height="50" align="left" valign="middle">手机号</td>
            <td width="300" height="50" align="left" valign="middle">
              <?php
                echo $user_info->username;
              ?>
            </td>
            <td width="100" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">手机号不可更改</td>
          </tr>
          <tr>
            <td width="100" height="50" align="left" valign="middle">角色</td>
            <td width="300" height="50" align="left" valign="middle">
              教师
            </td>
            <td width="100" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">角色不可更改</td>
          </tr>
          <tr>
            <td height="50" align="left" valign="middle"colspan="3">
              <a href="change_psw.php" class="btn btn-success form-control">我要改密码</a>
            </td>
          </tr>
        </table>
      </div>
    </form>
  </body>
</html>
