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
    <title>乐智悦读-创建班级</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        include_once("../class/common.php");
        include_once("common.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $user_info = $user->get_user_info();
        $role = $user_info->role;
        $common = new Common();
        if($role!="教师")
        {
          echo "没有权限";
          exit();
        }
        //处理更改信息的表单
        if(isset($_POST['class_school']) && isset($_POST['class_grade']) && isset($_POST['class_name']))
        {
          $class_school = intval($_POST['class_school']);
          $class_grade = intval($_POST['class_grade']);
          $class_name = $_POST['class_name'];
          if($common->check_school($class_school))
          {
              if($common->check_grade($class_grade))
              {
                if(strlen($class_name)>0)
                {
                  $ret = $user->create_class($class_school,$class_grade,$class_name);
                  if($ret==-1)
                  {
                    $common->tips("创建失败,班级个数已达上限");
                    exit();
                  }
                  else
                  {
                    $common->tips("创建成功,班级代号为$ret");
                    exit();
                  }
                }
                else
                {
                  echo "名字不能为空";
                  exit();
                }
              }
              else
              {
                echo "年级不合法";
                exit();
              }
          }
          else
          {
            echo "学校不合法";
            exit();
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
      <h4 style="line-height:50px;">创建班级</h4>
    </center>
    <form action="" method="post" onsubmit="return create_check();">
    <div class="container mt20 mb20">
      <table width="500" height="auto" border="0">
        <tr>
          <td width="100" height="50" align="center" valign="middle">学校</td>
          <td width="200" height="50" align="left" valign="middle">
            <select class="form-control" name="class_school">
              <?php
                $schools = $common->get_all_school();
                foreach($schools as $school)
                {
              ?>
                  <option value="<?php echo $school->id;?>">
                    <?php echo $school->schoolname;?>
                  </option>
              <?php
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td width="100" height="50" align="center" valign="middle">年级</td>
          <td width="200" height="50" align="left" valign="middle">
            <select class="form-control" name="class_grade">
              <?php
                $grades = $common->get_grade();
                foreach($grades as $grade)
                {
              ?>
                  <option value="<?php echo $grade->id;?>">
                    <?php echo $grade->grade_name;?>
                  </option>
              <?php
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td width="100" height="50" align="center" valign="middle">名字</td>
          <td width="200" height="50" align="left" valign="middle">
            <input type="text" id="class_name" name="class_name" class="form-control" required="required">
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="sub" value="提交创建" class="btn btn-danger form-control"/>
          </td>
        </tr>
      </table>
    </div>
  </form>
  <script type="text/javascript">
    function create_check()
    {
      if($("#class_name").val().length<1)
      {
        alert("班级名字不能为空");
        return false;
      }
      return true;
    }
  </script>
  </body>
</html>
