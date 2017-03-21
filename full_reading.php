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
      .label{border-radius: 20px; padding: 4px 12px;}
      .purple{color:#824399;}
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
          <li><a href="report.php">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->



<?php
  if($role == "教师")
  {
?>
<script type="text/javascript" src="js/cookie.js"></script>
<script type="text/javascript">
  $().ready(function(){
    //初始化已经加入当前书单的书的按钮
    var b = get_cookie('books');
    if(b)
    {
      $(b.split(',')).each(function(index,val){
        $("#book"+val).removeClass("btn-info");
        $("#book"+val).addClass("btn-default");
        $('#book'+val).attr("onclick","");
        $('#book'+val).html("加入成功");
      });
    }
  });
  function add2_book_list(book)
  {
    books = "";
    if(get_cookie('books'))
    {
      books = get_cookie('books');
    }
    if(books)
    {
      books += "," + book;
    }
    else
    {
      books = book;
    }
    set_cookie("books",books);
    $("#book"+book).html("加入成功");
    $("#book"+book).removeClass("btn-info");
    $("#book"+book).addClass("btn-default");
    $("#book"+book).attr("onclick","")
  }
</script>
<?
  }
?>

<?php
  include_once("footer.php");
?>
</body>
</html>
