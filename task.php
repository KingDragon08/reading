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
    <title>乐智悦读-全本阅读</title>
    <style media="screen">
      .mylist{
        border-bottom: 1px solid #ccc;
      }
      .mylist:hover{
        background: #f2f2f2;
      }
    </style>
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
          <li><a href="full_reading.php" class="active">全本阅读</a></li>
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="＃">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover" id="subtitle">
          我的任务
        </div>
      </div>
    <!-- division panel end -->
    <?php
      if($role != "学生")
      {
    ?>
      <center>
        <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
        <br>
        <p class="gray" id="tips">
          没有权限...
        </p>
      </center>
    <?php
        exit();
      }
    ?>
    <!-- list start -->
    <div class="container mt20 mb20">
      <?php
        if(!isset($_GET['task']))
        {
      ?>
        <center>
          <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
          <br>
          <p class="gray" id="tips">
            非法的访问...
          </p>
        </center>
      <?php
          exit();
        }
        $task = intval($_GET['task']);
        if($task < 1)
        {
      ?>
        <center>
          <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
          <br>
          <p class="gray" id="tips">
            非法的访问...
          </p>
        </center>
      <?php
          exit();
        }
        if(!$common->check_illegal_task($user_id,$task))
        {
      ?>
        <center>
          <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
          <br>
          <p class="gray" id="tips">
            非法的访问...
          </p>
        </center>
      <?php
          exit();
        }
        $books = $common->get_task_list_books($user_id,$task);
        // var_dump($books);
        foreach ($books as $book)
        {
      ?>
          <div class="col-lg-12 mylist mt20">
            <div class="col-lg-2">
              <a href="book.php?book=<?php echo $book->id;?>">
                <img src="<?php echo $book->coverimg?>" class="img-responsive"/>
              </a>
            </div>
            <div class="col-lg-10">
              <h5>
                <span>书名:<?php echo $book->name;?></span>&nbsp;&nbsp;
                <span>作者:<?php echo $book->author;?></span>&nbsp;&nbsp;
                <span>出版社:<?php echo $book->press;?></span>
              </h5>
              <p class="gray"><?php echo substr($book->bookdesc,0,402)."...";?></p>
              <div class="float_right">
                <?php
                  if($book->status==0)
                  {
                ?>
                    <a href="javascript:void(0);" class="btn btn-danger ml20" onclick="exam(<?php echo $book->id;?>)">
                      <i class="glyphicon glyphicon-tags"></i>
                        测评未通过
                    </a>
                <?php
                  }
                  if($book->status==1)
                  {
                ?>
                    <a href="javascript:void(0);" class="btn btn-primary ml20">
                      <i class="glyphicon glyphicon-tags"></i>
                        测评通过
                    </a>
                <?php
                  }
                  if($book->status==2)
                  {
                ?>
                    <a href="javascript:void(0);" class="btn btn-success ml20" onclick="exam(<?php echo $book->id;?>)">
                      <i class="glyphicon glyphicon-tags"></i>
                        我要测评
                    </a>
                <?php
                  }
                ?>

              </div>
            </div>
          </div>
      <?php
        }
      ?>
    </div>
    <!-- list end -->
    <?php
      include_once("footer.php")
    ?>
    <script type="text/javascript">
      $().ready(function(){
        $("#subtitle").html('<?php echo $common->get_list_name($task);?>');
      });
      //测评
      function exam(book)
      {
        openwin("exam.php?book="+book);
      }
    </script>
  </body>
  </html>
