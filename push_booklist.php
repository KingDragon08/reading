<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css" media="screen">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <title>乐智悦读-推送书单</title>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:index.php");
        }
        else
        {
          $user = $GLOBALS['user'];
          $role = $user->get_user_info()->role;
        }
      ?>
    <!-- top nav end -->
    <!-- main nav start -->
      <div class="container main-nav">
        <div class="brand">
            <img src="img/nav-brand.png" alt="">
        </div>
        <ul class="navigator">
          <li><a href="index.php">首页</a></li>
          <li><a href="full_reading.php" class="active">全本阅读</a></li>
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="＃">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
            推送书单
        <div class="float_right" style="margin-right:5.8em;">
          <button class="btn btn-success active" onclick="location.href='full_reading.php'">书单定制</button>
          <button class="btn btn-success" onclick="location.href='book_shelf.php'">书单管理</button>
        </div>
      </div>
    </div>
    <br><br>
    <?php
      if($role != "教师")
      {
    ?>
      <center>
        <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
        <br>
        <p class="gray" id="tips">
          没有权限推送书单...
        </p>
      </center>
    <?php
      }
      else
      {
        if(!isset($_COOKIE['books']))
        {
    ?>
        <center>
          <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
          <br>
          <p class="gray" id="tips">
            当前书单中没有书...
          </p>
        </center>
    <?php
          exit();
        }
        $books = explode(",",$_COOKIE['books']);
        //处理表单提交
        if(isset($_POST['book']) && isset($_POST['class']) && isset($_POST['endtime']))
        {
          $books = $_POST['book'];
          $classes = $_POST['class'];
          $endtime = $_POST['endtime'];
          if(count($books)>0 && count($classes)>0)
          {
            $user->push_booklist($books,$classes,$endtime);
    ?>
          <center>
            <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
            <br>
            <p class="gray" id="tips">
              推送成功
            </p>
          </center>
          <script type="text/javascript" src="js/cookie.js"></script>
          <script type="text/javascript">
            del_cookie('books');
          </script>
    <?php
            exit();
          }
        }
    ?>
      <form class="" action="" method="post" onsubmit="return check_push();">
      <div class="container">
          <div class="col-lg-12" style="margin-bottom:20px;">
            当前书单中的书：
          </div>
          <div class="col-lg-12">
            <div class="col-lg-8">
              <?php
                foreach($books as $book)
                {
                  $book = $db->get_row("select * from rd_book where id='$book'");
              ?>
              <div class="col-lg-12" style="border-bottom:1px dashed #eee;">
                <div class="col-lg-1">
                  <input type="checkbox" name="book[]" value="<?php echo $book->id?>" checked="checked" style="margin-top:50px;">
                </div>
                <div class="col-lg-2">
                  <img src="img/book1.png" class="img-responsive"/>
                </div>
                <div class="col-lg-9">
                  <h5>
                    <span>书名：<?php echo $book->name;?></span>
                    <span>作者：<?php echo $book->author;?></span>
                    <span>出版社：<?php echo $book->press;?></span>
                  </h5>
                  <p class="gray"><?php echo substr($book->bookdesc,0,201)."...";?></p>
                </div>
              </div>
              <?php
                }
              ?>
          </div>
          <div class="col-lg-4">
            <center style="height:50px; background:#71cba4; color:#fff;">
              <h4 style="line-height:50px;">选择推送班级</h4>
            </center>
            <?php
              $classes = $user->get_teacher_classes();
              if(count($classes))
              {
                foreach($classes as $class)
                {
            ?>
            <div class="checkbox" style="height:40px; line-height:40px; font-size:12px;">
              <label>
                <input type="checkbox" name="class[]" value="<?php echo $class->id?>" style="margin-top:14px;">
                <?echo $class->school; echo "-"; echo $class->classname;?>
                [<?echo $class->num?>人]
              </label>
            </div>
            <?php
                }
              ?>
                选择截止日期：
                <input type="date" name="endtime" value="" id="endtime" min="" class="form-control" required>
                <br>
                <input type="submit" name="submit" value="确认推送" class="btn btn-danger form-control">
              <?php
              }
              else
              {
                echo '<br><br><p class="gray">暂时没有班级哟，赶紧去个人中心创建班级吧</p>';
              }
            ?>
          </div>
        </div>
      </div>
    </form>
    <?php
      }
    ?><!-- footer start -->
      <div class="footer mt20">
        <table width="90%" height="160" align="center">
          <tr>
            <td width="65%" align="left" height="160" valign="middle">
              Copyright (c) 2016 北京乐智起航文化发展有限公司 All Rights Reserved.
            </td>
            <td width="35%" align="left" height="160" valign="middle">
                <p>
                  <i class="glyphicon glyphicon-map-marker"></i>
                  地址：北京市海淀区首都师范大学出版社
                </p>
                <p>
                  <i class="glyphicon glyphicon-earphone"></i>
                  电话：123-456-7890
                </p>
                <p>
                  <i class="glyphicon glyphicon-envelope"></i>
                  邮箱：helloworld@gmail.com
                </p>
            </td>
          </tr>
        </table>
      </div>
    <!-- footer end -->
    <!-- login start -->
    <div class="cover" style="display:none;">
      <div class="login_panel">
        <p style="margin-top:10px;">
          &nbsp;
          <i class="glyphicon glyphicon-remove float_right" style="cursor:pointer;" onclick="close_login_panel()">&nbsp;</i>
        </p>
        <center><h4>登录小学教师辅助教学工具平台</h4></center>
        <form action="" method="post" onsubmit="return login_check()">
          <table width="80%" height="auto" align="center" border="0" class="login_table">
            <tr>
              <td width="20%" height="50" align="center" valign="bottom">
                <i class="glyphicon glyphicon-user gray f20"></i>
              </td>
              <td width="60%" align="left" valign="bottom">
                <input type="tel" placeholder="请输入您的手机号码" class="login_input" id="username">
              </td>
              <td width="20%" height="50" align="center" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td width="20%" height="50" align="center" valign="bottom">
                <i class="glyphicon glyphicon-lock gray f20"></i>
              </td>
              <td width="60%" align="left" valign="bottom">
                <input type="password" placeholder="请输入密码" class="login_input" id="password">
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
  </body>
  <script type="text/javascript" src="js/login.js"></script>
  <script type="text/javascript">
    $().ready(function(){
      var t = new Date();
      var year = t.getFullYear();
      var month = (t.getMonth()+1)>9 ? (t.getMonth()+1) : ("0"+(t.getMonth()+1));
      var day = t.getDate()>9 ? t.getDate() : ("0"+t.getDate());
      $("#endtime").attr("min",year+"-"+month+"-"+day);
    });
    function check_push()
    {
      books = 0;
      classes = 0;
      $("input[name='book[]']").each(function(){
        if($(this).is(':checked'))
        {
          books++;
        }
      });
      $("input[name='class[]']").each(function(){
        if($(this).is(':checked'))
        {
          classes++;
        }
      });
      if(books == 0)
      {
        alert("至少选择一本书才能推送");
        return false;
      }
      if(classes == 0)
      {
        alert("至少选择一个班级才能推送");
        return false;
      }
      if($("$endtime").val().length != 10)
      {
        alert("请选择截止日期");
        return false;
      }
      return true;
    }
  </script>
</html>
