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
    if($user->get_user_info()->can_fullreading==0)
    {
      echo '<div class="container mt20 mb20">';
      $common->tips("没有访问权限");
      echo '</div>';
      include("footer.php");
      exit();
    }
    ?>

<!--

  学生开始

-->

    <?php
      if($role == "学生")
      {
    ?>

    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          全本阅读
          <div class="float_right" style="margin-right:5.8em;">
            <button class="btn btn-success active" onclick="location.href='full_reading.php'">全部书单</button>
            <button class="btn btn-success" onclick="location.href='book_shelf.php'">我的任务</button>
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
              <button type="button" class="btn btn-default" id="type" style="max-width:6em; overflow:hidden;">图书类型</button>
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
                    <li>
                      <a href="javascript:void(0);" onclick="type_change(<?php echo $type->id?>)">
                        <?php echo $type->name?>
                      </a>
                      <?php
                            if(isset($_GET['type']))
                            {
                              if($type->id==intval($_GET['type']))
                              {
                                  echo '<script>$("#type").html("'.$type->name.'");</script>';
                              }
                            }
                      ?>
                    </li>
                <?php
                  }
                ?>
              </ul>
          </div>
          &nbsp;&nbsp;
          <div class="btn-group">
              <button type="button" class="btn btn-default" id="grade_type" style="max-width:6em; overflow:hidden;">学段</button>
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
                    ?>
                <?php
                  }
                ?>
              </ul>
          </div>

          &nbsp;&nbsp;
          <div class="btn-group">
              <button type="button" class="btn btn-default" id="list_type" style="max-width:6em; overflow:hidden;">书单类型</button>
              <button type="button" class="btn btn-default dropdown-toggle"
                  data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">选择</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" onclick="list_type_change(0)">全部类型</a></li>
                <?php
                  $list_types = $common->get_list_type();
                  foreach ($list_types as $list_type)
                  {
                ?>
                    <li><a href="javascript:void(0);" onclick="list_type_change(<?php echo $list_type->id?>)"><?php echo $list_type->name?></a></li>
                    <?php
                          if(isset($_GET['list_type']))
                          {
                            if($list_type->id==intval($_GET['list_type']))
                            {
                                echo '<script>$("#list_type").html("'.$list_type->name.'");</script>';
                            }
                          }
                    ?>
                <?php
                  }
                ?>
              </ul>
          </div>


          &nbsp;&nbsp;
          <div class="btn-group">
              <button type="button" class="btn btn-default" id="level_type">难度等级</button>
              <button type="button" class="btn btn-default dropdown-toggle"
                  data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">选择</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" onclick="level_type_change(0)">全部等级</a></li>
                <?php
                  $i = 0;
                  while($i++<10)
                  {
                ?>
                    <li><a href="javascript:void(0);" onclick="level_type_change(<?php echo $i?>)"><?php echo $i?></a></li>
                    <?php
                          if(isset($_GET['level_type']))
                          {
                            if($i==intval($_GET['level_type']))
                            {
                                echo '<script>$("#level_type").html("'.$i.'");</script>';
                            }
                          }
                    ?>
                <?php
                  }
                ?>
              </ul>
          </div>


          &nbsp;&nbsp;
          <div class="btn-group">
              <button type="button" class="btn btn-default" id="score_type">积分</button>
              <button type="button" class="btn btn-default dropdown-toggle"
                  data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">选择</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" onclick="score_type_change(0)">全部积分</a></li>
                <?php
                  $i = 0;
                  while($i++<10)
                  {
                ?>
                    <li><a href="javascript:void(0);" onclick="score_type_change(<?php echo $i?>)"><?php echo $i?></a></li>
                    <?php
                          if(isset($_GET['score_type']))
                          {
                            if($i==intval($_GET['score_type']))
                            {
                                echo '<script>$("#score_type").html("'.$i.'");</script>';
                            }
                          }
                    ?>
                <?php
                  }
                ?>
              </ul>
          </div>



        </div>
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
          $grade = isset($_GET['grade'])?intval($_GET['grade']):0;//年级
          $type = isset($_GET['type'])?intval($_GET['type']):0;//图书类型
          $page = isset($_GET['page'])?intval($_GET['page']):1;//页数
          $list_type = isset($_GET['list_type'])?intval($_GET['list_type']):0;//书单类型
          $level_type = isset($_GET['level_type'])?intval($_GET['level_type']):0;//难度等级
          $score_type = isset($_GET['score_type'])?intval($_GET['score_type']):0;//积分数量
          // $books = $common->get_read_list_2($page,$user_id,$type,$grade);
          $books = $common->get_read_list_3($page,$user_id,$type,$grade,$list_type,$level_type,$score_type);
          if($books)
          {
            $counter=0;
            foreach($books as $book)
            {
              $counter++;
        ?>
          <div class="col-lg-4 mb20" style="height:220px;<?php if($counter%3==1 && $counter!=1) echo "clear:both;"?>">
            <div class="col-lg-6 book_img">
              <a href="book.php?book=<?php echo $book->id;?>" target="_blank">
                <img src="<?php echo $book->coverimg;?>" style="width:120px; height:160px; margin-top:30px;"/>
              </a>
            </div>
            <div class="col-lg-6 book_info" style="display:table; height:100%;">
              <div style="display:table-cell;">
                <p><?php echo $book->name;?></p>
                <p class="gray f12" style="margin-bottom:5px;">作者：<?php echo $book->author;?></p>
                <p class="gray f12" style="margin-bottom:5px;">学段：<?php echo $book->grade;?></p>
                <p class="gray f12" style="margin-bottom:5px;">类型：<?php echo $book->type;?></p>
                <p class="gray f12" style="margin-bottom:5px;">难度等级：<?php echo $book->level;?></p>
                <p class="gray f12" style="margin-bottom:5px;">字数：<?php echo $book->wordcount;?></p>
                <p class="gray f12" style="margin-bottom:5px;">积分：<?php echo $book->score;?></p>
                <?php
                  if($book->status == 1)
                  {
                    echo "<label class=\"label label-info\" style='position:absolute; bottom:0;'>在任务里</label>";
                  }
                  else
                  {
                    echo "<label class=\"label label-success\" style='cursor:pointer; position:absolute; bottom:0;' onclick='add2_book_shelf($book->id)'>加入任务</label>";
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
        ?>

      </div>
      <center>
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
            <li><a href="full_reading.php?page=<?php echo $page-1>0?$page-1:1; echo '&'; echo $url;  ?>">上一页</a></li>
            <?php
              $pages = $common->get_read_list_pages();
              // echo $pages;
              $index = 1;
              while($index <= $pages)
              {
                if($index == $page)
                {
                  echo "<li class=\"active\"><a href=\"full_reading.php?page=$index&$url\">$index</a></li>";
                }
                else
                {
                  echo "<li><a href=\"full_reading.php?page=$index&$url\">$index</a></li>";
                }
                $index++;
              }
            ?>
            <li><a href="full_reading.php?page=<?php echo $page+1>$pages?$pages:$page+1; echo '&'; echo $url;  ?>">下一页</a></li>
        </ul>
      </center>
    </div>
    <!-- booklist panel end -->
    <script type="text/javascript">
      var grade = <?php echo isset($_GET['grade'])?intval($_GET['grade']):0 ?>;
      var type = <?php echo isset($_GET['type'])?intval($_GET['type']):0 ?>;
      var list_type = <?php echo $list_type; ?>;
      var level_type = <?php echo $level_type; ?>;
      var score_type = <?php echo $score_type; ?>;

      function grade_change(id)
      {
        location.href = "full_reading.php?grade="+id+"&type="+type+
                        "&list_type="+list_type+"&level_type="+level_type+
                        "&score_type="+score_type;
      }

      function type_change(id)
      {
        location.href = "full_reading.php?grade="+grade+"&type="+id+
                        "&list_type="+list_type+"&level_type="+level_type+
                        "&score_type="+score_type;
      }

      function list_type_change(id)
      {
        location.href = "full_reading.php?grade="+grade+"&type="+type+
                        "&list_type="+id+"&level_type="+level_type+
                        "&score_type="+score_type;
      }

      function level_type_change(id)
      {
        location.href = "full_reading.php?grade="+grade+"&type="+type+
                        "&list_type="+list_type+"&level_type="+id+
                        "&score_type="+score_type;
      }

      function score_type_change(id)
      {
        location.href = "full_reading.php?grade="+grade+"&type="+type+
                        "&list_type="+list_type+"&level_type="+level_type+
                        "&score_type="+id;
      }

      function add2_book_shelf(book)
      {
        location.href = "controller/book_shelf.php?action=add2shelf&book="+book;
      }

    </script>
    <?php
      }
    ?>
<!--

  学生结束

-->




<!--

  教师开始

-->

    <?php
      if($role == "教师")
      {
    ?>

    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          全本阅读
          <div class="float_right" style="margin-right:5.8em;">
            <button class="btn btn-success active" onclick="location.href='full_reading.php'">书单定制</button>
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
                <li><a href="full_reading.php?page=<?php echo $page-1>0?$page-1:1; echo '&'; echo $url;  ?>">上一页</a></li>
                <?php
                  $pages = $common->get_read_list_pages();
                  // echo $pages;
                  $index = 1;
                  while($index <= $pages)
                  {
                    if($index == $page)
                    {
                      echo "<li class=\"active\"><a href=\"full_reading.php?page=$index&$url\">$index</a></li>";
                    }
                    else
                    {
                      echo "<li><a href=\"full_reading.php?page=$index&$url\">$index</a></li>";
                    }
                    $index++;
                  }
                ?>
                <li><a href="full_reading.php?page=<?php echo $page+1>$pages?$pages:$page+1; echo '&'; echo $url;  ?>">下一页</a></li>
            </ul>
          </center>
      <?php
        }
      ?>
    </div>

    <script type="text/javascript" src="js/cookie.js"></script>
    <script type="text/javascript">
      var grade = <?php echo isset($_GET['grade'])?intval($_GET['grade']):0 ?>;
      var type = <?php echo isset($_GET['type'])?intval($_GET['type']):0 ?>;
      function grade_change(id)
      {
        if(type == 0)
        {
          location.href = "full_reading.php?grade="+id;
        }
        else
        {
          location.href = "full_reading.php?grade="+id+"&type="+type;
        }
      }

      function type_change(id)
      {
        if(grade == 0)
        {
          location.href = "full_reading.php?type="+id;
        }
        else
        {
          location.href = "full_reading.php?type="+id+"&grade="+grade;
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
    <?php
      }
    ?>
<!--

  教师结束

-->

<?php
  include_once("footer.php");
?>
</body>
</html>
