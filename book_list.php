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
    <title>乐智悦读-书单详情</title>
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
          <li><a href="page_reading.php">短篇阅读</a></li>
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="report.php">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
              <?php
                $list_id = $_GET['list_id']?intval($_GET['list_id']):1;
                echo $common->get_list_name($list_id);
              ?>
        </div>
      </div>
    <!-- division panel end -->
    <!-- list start -->
    <div class="container mt20 mb20">
      <?php
        $books = $common->get_book_list_books($list_id);
        foreach($books as $book)
        {
      ?>
        <div class="col-lg-12 mylist mt20">
          <div class="col-lg-2">
            <img src="<?php echo $book->coverimg;?>" class="img-responsive"/>
          </div>
          <div class="col-lg-10">
            <h5>
              <span>书名:<?php echo $book->name;?></span>&nbsp;&nbsp;
              <span>作者:<?php echo $book->author;?></span>&nbsp;&nbsp;
              <span>出版社:<?php echo $book->press;?></span>
            </h5>
            <p class="gray"><?php echo substr($book->bookdesc,0,402)."...";?></p>
            <div class="float_right">
              <a class="btn btn-primary" href="book.php?book=<?php echo $book->id?>">了解更多</a>
              <?php
                if($role == "教师")
                {
              ?>
                  <span class="btn btn-primary" id="book<?php echo $book->id?>" onclick="add2_book_list(<?php echo $book->id?>)">加入书单</span>
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
      include_once("footer.php");
    ?>
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
            $("#book"+val).removeClass("btn-primary");
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
        $("#book"+book).removeClass("btn-primary");
        $("#book"+book).addClass("btn-default");
        $("#book"+book).attr("onclick","")
      }
    </script>
    <?
      }
    ?>
</body>
</html>
