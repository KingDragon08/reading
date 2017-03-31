<?php
  include("ezSQL/init.php");
?>
<!-- top nav start-->
<nav class="nav">
  <div class="container">
      <img src="img/logo.jpg" alt="" class="logo">
      <span class="contact">
        <i class="glyphicon glyphicon-earphone red"></i>
        合作联系方式：010-65583232
      </span>
      <span class="login navbar-right">
        <?php
          if(!isLogin())
          {
            echo '<a href="javascript:void(0);" onclick="open_login_panel()">登录</a>';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="register.php">注册</a>';
          }
          else
          {
            if($user->get_user_info()->role == "学生")
            {
              $role_type = "学员";
            }
            if($user->get_user_info()->role == "教师")
            {
              $role_type = "老师";
            }
            echo '<a href="home.php" class="noline">你好,'.$user->get_user_info()->name.$role_type.
                '&nbsp;&nbsp;&nbsp;&nbsp;<img class="headimg" src="'.$user->get_user_info()->headimg.'"/></a>';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="controller/logout.php">退出</a>';
          }
        ?>
      </span>
  </div>
</nav>
<!-- top nav end -->
<!-- login start -->
<div class="cover" style="display:none;">
  <div class="login_panel">
    <p style="margin-top:10px;">
      &nbsp;
      <i class="glyphicon glyphicon-remove float_right" style="cursor:pointer;" onclick="close_login_panel()">&nbsp;</i>
    </p>
    <center><h4>登录小学教师辅助教学工具平台</h4></center>
    <form action="controller/login.php" method="post" onsubmit="return login_check()">
      <table width="80%" height="auto" align="center" border="0" class="login_table">
        <tr>
          <td width="20%" height="50" align="center" valign="bottom">
            <i class="glyphicon glyphicon-user gray f20"></i>
          </td>
          <td width="60%" align="left" valign="bottom">
            <input type="text" placeholder="请输入您的手机号码" name="username" class="login_input" id="username">
          </td>
          <td width="20%" height="50" align="center" valign="bottom">&nbsp;</td>
        </tr>
        <tr>
          <td width="20%" height="50" align="center" valign="bottom">
            <i class="glyphicon glyphicon-lock gray f20"></i>
          </td>
          <td width="60%" align="left" valign="bottom">
            <input type="password" placeholder="请输入密码" name="password" class="login_input" id="password">
          </td>
          <td width="20%" height="50" align="center" valign="bottom">
            <a href="forget.html" class="forget_btn">忘记密码</a>
          </td>
        </tr>
        <tr>
          <td height="120" align="center" valign="middle" style="border:none;">
            <input type="checkbox" name="remeber">&nbsp;&nbsp;记住我
          </td>
          <td colspan="2" align="right" valign="middle" style="border:none;">
            <input type="submit" name="submit" class="btn btn-success lear_more" value="登录" style="width:60%;">
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<!-- login end -->
<script type="text/javascript" src="js/login.js"></script>

<?php
function isLogin()
{
  if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
  {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    if(isset($_SESSION['username']) && isset($_SESSION['password']))
    {
      if($username==$_SESSION['username'] && $password==$_SESSION['password'])
      {
        include_once("class/user.php");
        $user = new User($username,$password);
        $GLOBALS['user'] = $user;
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
  else
  {
    return false;
  }
}
?>
