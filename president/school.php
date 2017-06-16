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
    <title>乐智悦读-学校信息</title>
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
        if(isset($_POST['school']))
        {
          $school = $_POST['school'];
          $user->change_school($school);
          //echo "<script>parent.location.reload();</script>";
        }
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">学校信息</h4>
    </center>
    <br><br>
    <form class="" action="" method="post" onsubmit="return check();">
      <div class="container">
        <table width="500" height="auto" border="0">
          <tr>
            <td width="100" height="80" align="left" valign="middle">学校</td>
            <td width="300" height="80" align="left" valign="middle">
              <input type="text" id="school" name="school" class="form-control" value="<?php echo $user->get_school();?>" placeholder="学校名字"/>
            </td>
            <td width="100" height="80" align="left" valign="middle" class="gray f12" style="padding-left:1em;">
              学校代号：<?php echo $user_info->school;?>
            </td>
          </tr>
          <tr>
            <td height="80" align="left" valign="middle"colspan="3">
              <input type="submit" class="btn btn-success form-control" value="更改名字"/>
            </td>
          </tr>
        </table>
      </div>
    </form>
  </body>
  <script type="text/javascript">
    function check()
    {
      var school = $("#school").val();
      if(school.length<1)
      {
        alert("学校名字不能为空");
        return false;
      }
      return true;
    }
  </script>
</html>
