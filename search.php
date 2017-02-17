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
    <title>乐智悦读-搜索</title>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        include_once("class/common.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:login.php");
        }
        else
        {
          $user = $GLOBALS['user'];
          $common = new Common();
          $role = $user->get_user_info()->role;
          $user_id = $user->get_user_id();
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
          <li><a href="full_reading.php">全本阅读</a></li>
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="＃">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->

    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          搜索
        </div>
      </div>
    <!-- division panel end -->
    <!-- filter panel start -->
    <br>
    <div class="row">
      <div class="container">
        <div class="col-lg-8"></div>
        <div class="col-lg-4">
          <form action="search.php" method="get" target="_blank" name="search" id="search" onsubmit="return check_search()">
              <div class="input-group">
                <input type="text" class="form-control" name="s" id="search_keywords">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-search" style="cursor:pointer;" onclick="$('#search').submit()"></i>
                </span>
              </div>
          </form>
        </div>
      </div>
      <br>
    <!-- filter panel end -->
    <!-- booklist panel start -->
    <div class="container mt20">
      <div class="col-lg-12">
        <?php
          $keywords = isset($_GET['s'])?$_GET['s']:-1;
          if($keywords != -1)
          {
            $books = $common->search_books($keywords,$user_id);
            if($books)
            {
              foreach($books as $book)
              {
        ?>
            <div class="col-lg-4 mb20">
              <div class="col-lg-6 book_img">
                <img src="<?php echo $book->coverimg;?>" width="100%"/>
              </div>
              <div class="col-lg-6 book_info" style="display:table;">
                <div style="display:table-cell; vertical-align:middle;">
                  <p>书名：<?php echo $book->name;?></p>
                  <p>作者：<?php echo $book->author;?></p>
                  <p>学段：<?php echo $book->grade;?></p>
                  <?php
                    if($book->status == 1)
                    {
                      echo "<label class=\"label label-info\">在书架上</label>";
                    }
                    else
                    {
                      echo "<label class=\"label label-success\" style='cursor:pointer;' onclick='alert(1)'>加入书架</label>";
                    }
                  ?>

                </div>
              </div>
            </div>
        <?php
            }
          }
          else
          {
        ?>
          <center>
            <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
            <br>
            <p class="gray">
              暂时没有符合条件的书籍...
            </p>
          </center>
        <?php
          }
        }
        else
        {
        ?>
        <center>
          <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
          <br>
          <p class="gray">
            必须输入关键字才能搜索...
          </p>
          <br><br>
        </center>
        <?php
        }
        ?>

      </div>

    </div>
    <!-- booklist panel end -->




    <!-- footer start -->
      <div class="footer">
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
  <script type="text/javascript" src="js/full_reading.js"></script>
</html>
