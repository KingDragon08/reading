<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css" media="screen">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
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
        include_once("../class/common.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:index.php");
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
            <img src="../img/nav-brand.png" alt="">
        </div>
      </div>
    <!-- main nav end -->


<!--

  校长开始

-->

    <?php
      if($role == "3")
      {
    ?>

    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          全本阅读
          <div class="float_right" style="margin-right:5.8em;">
            <button class="btn btn-success active" onclick="location.href='push.php'">书单定制</button>
            <button class="btn btn-success" onclick="location.href='book_shelf.php'">书单管理</button>
          </div>
        </div>
      </div>
    <!-- division panel end -->
    <!-- filter panel start -->
    <br>
    <div class="row">
      <div class="container">
        <div class="col-lg-8">
          选择书单类型:&nbsp;&nbsp;&nbsp;&nbsp;
          <div class="btn-group">
              <button type="button" class="btn btn-default" id="list_type">书单类型</button>
              <button type="button" class="btn btn-default dropdown-toggle"
                  data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">选择</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" onclick="type_change(0)">全部类型</a></li>
                <?php
                  $types = $common->get_all_book_type();
                  foreach ($types as $type)
                  {
                ?>
                    <li><a href="javascript:void(0);" onclick="type_change(<?php echo $type->id?>)"><?php echo $type->name?></a></li>
                <?php
                    if(isset($_GET['type']))
                    {
                      if($type->id==intval($_GET['type']))
                      {
                          echo '<script>$("#list_type").html("'.$type->name.'");</script>';
                      }
                    }
                  }
                ?>
              </ul>
          </div>
          &nbsp;&nbsp;
          <div class="btn-group">
              <button type="button" class="btn btn-default" id="grade_type">学段</button>
              <button type="button" class="btn btn-default dropdown-toggle"
                  data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">选择</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" onclick="grade_change(0)">全部年级</a></li>
              <?php
                $grades = $common->get_grade();
                foreach ($grades as $grade)
                {
              ?>
                  <li><a href="javascript:void(0);" onclick="grade_change(<?php echo $grade->id?>)"><?php echo $grade->grade_name?></a></li>
              <?php
                  if(isset($_GET['grade']))
                  {
                    if($grade->id==intval($_GET['grade']))
                    {
                        echo '<script>$("#grade_type").html("'.$grade->grade_name.'");</script>';
                    }
                  }
                }
              ?>
              </ul>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <div class="btn-group" onclick="go()">
            <span class="btn btn-default">
              <i class="glyphicon glyphicon-send">&nbsp;</i>推送书单
            </span>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <div class="btn-group" onclick="javascript:del_cookie('books'); alert('删除成功');">
            <span class="btn btn-default">
              删除所有已选图书
            </span>
          </div>
        </div>
        <div class="col-lg-4">
          <form action="" method="get" name="search" id="search" onsubmit="return check_search()">
              <div class="input-group">
                <input type="text" name="s" class="form-control" id="search_keywords">
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

      <?php
        $grade = isset($_GET['grade'])?intval($_GET['grade']):0;
        $type = isset($_GET['type'])?intval($_GET['type']):0;
        $page =isset($_GET['page'])?intval($_GET['page']):1;
        $books = $common->get_books($page,$user_id,$type,$grade);
        // $books = $common->get_read_list($page,$user_id,$type,$grade);
        if(isset($_GET['s']))
        {
          $books = $common->search_books($_GET['s'],$user_id);
        }
        if($books)
        {
          foreach($books as $book)
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
                <div class="float_left purple">
                  已被推荐<?php echo $book->recommend_times;?>次
                </div>
                <div class="float_right">
                      <a href="javascript:void(0);" class="btn btn-info ml20" id="book<?php echo $book->id;?>" onclick="add2_book_list(<?php echo $book->id;?>)">
                          加入书单
                      </a>
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
      ?>

      <?php
        if(!isset($_GET['s']))
        {
      ?>
          <center style="clear:both;">
            <ul class="pagination">
                <?php
                  $url = '';
                  if($grade != 0)
                  {
                    if($type !=0)
                    {
                      $url = "grade=$grade&type=$type";
                    }
                    else
                    {
                      $url = "grade=$grade";
                    }
                  }
                  else
                  {
                    if($type != 0)
                    {
                      $url = "type=$type";
                    }
                  }
                ?>
                <li><a href="?page=<?php echo $page-1>0?$page-1:1; echo '&'; echo $url;  ?>">上一页</a></li>
                <?php
                  $pages = $common->get_read_list_pages();
                  // echo $pages;
                  $index = 1;
                  while($index <= $pages)
                  {
                    if($index == $page)
                    {
                      echo "<li class=\"active\"><a href=\"?page=$index&$url\">$index</a></li>";
                    }
                    else
                    {
                      echo "<li><a href=\"?page=$index&$url\">$index</a></li>";
                    }
                    $index++;
                  }
                ?>
                <li><a href="?page=<?php echo $page+1>$pages?$pages:$page+1; echo '&'; echo $url;  ?>">下一页</a></li>
            </ul>
          </center>
      <?php
        }
      ?>
    </div>

    <script type="text/javascript" src="../js/cookie.js"></script>
    <script type="text/javascript">
      var grade = <?php echo isset($_GET['grade'])?intval($_GET['grade']):0 ?>;
      var type = <?php echo isset($_GET['type'])?intval($_GET['type']):0 ?>;
      function grade_change(id)
      {
        if(type == 0)
        {
          location.href = "?grade="+id;
        }
        else
        {
          location.href = "?grade="+id+"&type="+type;
        }
      }

      function type_change(id)
      {
        if(grade == 0)
        {
          location.href = "?type="+id;
        }
        else
        {
          location.href = "?type="+id+"&grade="+grade;
        }
      }

      function go()
      {
        books = get_cookie('books');
        if(books)
        {
          location.href = "push_booklist.php";
        }
        else
        {
          alert("至少选择一本书才能创建书单");
        }
      }


    </script>
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
    <?php
      }
      else
      {
        echo '<div class="container mt20 mb20">';
        $common->tips("没有访问权限");
        echo '</div>';
        include_once("footer.php");
        exit();
      }
    ?>
<!--
  校长结束
-->

<?php
  include_once("footer.php");
?>
</body>
</html>
