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
        //处理更改信息的表单
        if(isset($_GET['grade']) && isset($_GET['class']) && isset($_GET['school']))
        {
          $grade = $_GET['grade'];
          $class = $_GET['class'];
          $school = $_GET['school'];
          if(!is_numeric($class) || strlen($class)<1)
          {
            tips("班级代号必须是纯数字");
          }
          else
          {
            if(!is_numeric($school) || strlen($school)<1)
            {
              tips("学校代号必须是纯数字");
            }
            else
            {
              $result = $user->change_learn_info($grade,$class,$school);
              if($result==1)
              {
                tips("更改成功");
                $user = new User($_SESSION['username'],$_SESSION['password']);
                $user_info = $user->get_user_info();
              }
              if($result==2)
              {
                tips("更改失败,班级代号不存在");
              }
              if($result==3)
              {
                tips("更改失败,学校代号不存在");
              }
            }
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
      <h4 style="line-height:50px;">学校信息</h4>
    </center>
    <br><br>
    <form class="" action="" method="get" onsubmit="return check();">
      <div class="container">
        <table width="400" height="auto" border="0">
          <tr>
            <td width="100" height="50" align="center" valign="middle">年级</td>
            <td width="200" height="50" align="left" valign="middle">
                <input type="text" name="grade" id="grade" value="<?php echo $user_info->grade;?>" class="form-control" placeholder="请填入年级">
            </td>
            <td width="100" height="50" align="left" valign="middle">
                &nbsp;
            </td>
          </tr>
          <tr>
            <td width="100" height="50" align="center" valign="middle">班级</td>
            <td width="200" height="50" align="left" valign="middle">
              <input type="text" name="class" id="class" value="<?php echo $user_info->class;?>" class="form-control" placeholder="请询问老师后填入班级代号">
              </td>
            <td width="100" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">
                <?php echo $user->get_class();?>
            </td>
          </tr>
          <tr>
            <td width="100" height="50" align="center" valign="middle">学校</td>
            <td width="200" height="50" align="left" valign="middle">
              <input type="text" name="school" id="school" value="<?php echo $user_info->school;?>" class="form-control" placeholder="请询问老师后填入学校代号">
            </td>
            <td width="100" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">
                <?php echo $user->get_school();?>
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
        if($("#grade").val().length<1)
        {
          alert("年级信息不能为空");
          return false;
        }
        if($("#class").val().length<1)
        {
          alert("班级代号不能为空");
          return false;
        }
        if($("#school").val().length<1)
        {
          alert("学校代号不能为空");
          return false;
        }
        if(isNaN($("#class").val()))
        {
          alert("班级代号必须为纯数字");
          return false;
        }
        if(isNaN($("#school").val()))
        {
          alert("学校代号必须为纯数字");
          return false;
        }
        return true;
      }
    </script>
  </body>
</html>
