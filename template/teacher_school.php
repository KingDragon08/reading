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
        if(isset($_POST['class_grade']) && isset($_POST['class_name']) && isset($_POST['class_id']))
        {
          $class_grade = intval($_POST['class_grade']);
          $class_name = $_POST['class_name'];
          $class_id = intval($_POST['class_id']);
          //检查grade是否正常
          if($common->check_grade($class_grade))
          {
            if($common->check_class($class_id))
            {
              if(strlen($class_name)>0)
              {
                $user->update_class($class_id,$class_name,$class_grade);
                tips("更改成功");
              }
              else
              {
                echo "班级名字至少一个字符";
              }
            }
            else
            {
              echo "班级不存在";
              exit();
            }
          }
          else
          {
            echo "年级不合法";
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
      <h4 style="line-height:50px;">学校信息</h4>
    </center>
    <br><br>
    <div class="container">
        选择班级:&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="btn-group">
            <button type="button" class="btn btn-default" id="class_type">选择班级</button>
            <button type="button" class="btn btn-default dropdown-toggle"
                data-toggle="dropdown" style="height:34px;">
                <span class="caret"></span>
                <span class="sr-only">选择</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <?php
                $classes = $user->get_classes();
                if(count($classes)>0)
                {
                  $counter = 1;
                  foreach ($classes as $class)
                  {
              ?>
                    <li>
                      <a href="teacher_school.php?class=<?php echo $counter;?>">
                        <?php echo $class->classname;?>
                      </a>
                    </li>
              <?php
                    $counter++;
                  }
                  $class = 0;
                  if(isset($_GET['class']))
                  {
                    $class = intval($_GET['class']);
                    if($class>0 && $class<=count($classes))
                    {
                      echo "<script>$('#class_type').html('".$classes[$class-1]->classname."')</script>";
                    }
                    else
                    {
                      $class = 0;
                      echo "<script>$('#class_type').html('".$classes[0]->classname."')</script>";
                    }
                  }
                  else
                  {
                    echo "<script>$('#class_type').html('".$classes[0]->classname."')</script>";
                  }
                }
              ?>
            </ul>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="teacher_addclass.php" class="btn btn-info">创建班级</a>
      </div>
      <br><br>
      <?php
        if(count($classes)>0)
        {
      ?>
            <form  action="" method="post" onsubmit="return check();">
              <div class="container">
                <table width="500" height="auto" border="0">
                  <tr>
                    <td width="100" height="50" align="center" valign="middle">年级</td>
                    <td width="200" height="50" align="left" valign="middle">
                      <select class="form-control" name="class_grade">
                        <?php
                          $grades = $common->get_grade();
                          $class = $class-1>=0?$class-1:0;
                          foreach($grades as $grade)
                          {
                        ?>
                            <option value="<?php echo $grade->id;?>" <?php if($grade->id==$classes[$class]->grade){echo 'selected="selected"';}?>>
                              <?php echo $grade->grade_name;?>
                            </option>
                        <?php
                          }
                        ?>
                      </select>
                    </td>
                    <td width="200" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">
                        &nbsp;
                    </td>
                  </tr>
                  <tr>
                    <td width="100" height="50" align="center" valign="middle">班级</td>
                    <td width="200" height="50" align="left" valign="middle">
                      <input type="text" name="class_name" class="form-control" id="class_name" value="<?php echo $classes[$class]->classname;?>" required="required">
                    </td>
                    <td width="200" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">
                      班级代号：<?php echo $classes[$class]->id;?>
                    </td>
                  </tr>
                  <tr>
                    <td width="100" height="50" align="center" valign="middle">学校</td>
                    <td width="200" height="50" align="left" valign="middle" class="gray">
                      <?php echo $common->get_school_name($classes[$class]->school);?>
                    </td>
                    <td width="200" height="50" align="left" valign="middle" class="gray f12" style="padding-left:1em;">
                        学校代号：<?php echo $classes[$class]->school;?>
                    </td>
                  </tr>
                  <tr>
                    <td height="50" align="left" valign="middle"colspan="3">
                      <input type="hidden" name="class_id" value="<?php echo $classes[$class]->id;?>">
                      <input type="submit" name="submit" value="确认更改" class="btn btn-danger form-control">
                    </td>
                  </tr>
                </table>
              </div>
            </form>
            <script type="text/javascript">
              function check()
              {
                if($("#class_name").val().length<1)
                {
                  alert("班级名称不能为空");
                  return false;
                }
                return true;
              }
            </script>
      <?php
        }
        else
        {
          echo "<center>还没有班级,快创建一个吧</center>";
        }
      ?>
  </body>
</html>
