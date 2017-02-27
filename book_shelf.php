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





<!--  学生开始 -->
<?php
  if($role == "学生")
  {
?>
<!-- division panel start -->
  <div class="w100 forget">
    <div class="forget_cover">
      全本阅读
      <div class="float_right" style="margin-right:5.8em;">
        <button class="btn btn-success" onclick="location.href='full_reading.php'">全部书单</button>
        <button class="btn btn-success active" onclick="location.href='book_shelf.php'">我的任务</button>
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
          <button type="button" class="btn btn-default">书单类型</button>
          <button type="button" class="btn btn-default dropdown-toggle"
              data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">选择</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <?php
              $types = $common->get_list_type();
              $status = isset($_GET['status'])?intval($_GET['status']):-1;
              foreach ($types as $type)
              {
            ?>
                <li><a href="javascript:void(0);" onclick="type_change(<?php echo $type->id?>)"><?php echo $type->name?></a></li>
            <?php
              }
            ?>
          </ul>
      </div>
      &nbsp;&nbsp;
      <div class="btn-group">
          <button type="button" class="btn btn-default">学段</button>
          <button type="button" class="btn btn-default dropdown-toggle"
              data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">选择</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <?php
              $grades = $common->get_grade();
              foreach ($grades as $grade)
              {
            ?>
                <li><a href="javascript:void(0);" onclick="grade_change(<?php echo $grade->id?>)"><?php echo $grade->grade_name?></a></li>
            <?php
              }
            ?>
          </ul>
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
  <div class="container">
    <div class="col-lg-8">
      测评状态:&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="radio btn-group">
        <label>
          <input type="radio" name="exam_status" id="exam_status1" value="1" <?php if($status==1) echo "checked"; ?> onclick="change_status(1)">通过测评
        </label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label>
          <input type="radio" name="exam_status" id="exam_status2" value="2" <?php if($status==0) echo "checked"; ?> onclick="change_status(0)">未通过测评
        </label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label>
          <input type="radio" name="exam_status" id="exam_status3" value="3" <?php if($status==2) echo "checked"; ?> onclick="change_status(2)">未测试
        </label>
      </span>
    </div>
    <div class="col-lg-4">&nbsp;</div>
</div>
<!-- filter panel end -->
<!-- booklist panel start -->
<div class="container mt20">
  <div class="col-lg-12">

    <?php
      $grade = isset($_GET['grade'])?intval($_GET['grade']):0;
      $type = isset($_GET['type'])?intval($_GET['type']):0;
      $status = isset($_GET['status'])?intval($_GET['status']):-1;
      $page =isset($_GET['page'])?intval($_GET['page']):1;
      if(isset($_GET['s']))
      {
        $books = $common->search_lists_task($_GET['s'],$user_id);
      }
      else
      {
        $books = $common->get_lists_task($user_id,$grade,$type,$status,$page);
      }
      foreach($books as $book)
      {
    ?>
    <div class="col-lg-4 mb20">
      <div class="col-lg-6 book_img">
        <a href="task.php?task=<?php echo $book->id;?>">
          <img src="<?php echo $book->coverimg; ?>" width="100%"/>
        </a>
      </div>
      <div class="col-lg-6 book_info" style="display:table;">
        <div style="display:table-cell; vertical-align:middle;">
          <p>名字：<?php echo $book->name;?></p>
          <p class="gray f12">作者：<?php echo $book->author;?></p>
          <p class="gray f12">学段：<?php echo $book->grade;?></p>
          <p class="gray f12">类型：<?php echo $book->type;?></p>
          <p class="gray f12">剩余时间：<?php echo $book->restime;?></p>
        </div>
      </div>
    </div>
    <?php
        }
    ?>


    </div>
  </div>
  <?php
  if(!isset($_GET['s']))
  {
  ?>
  <center>
    <ul class="pagination">
        <?php
          $url = "book_shelf.php?grade=".$grade."&type=".$type."&status=".$status."&page=";
          $prior_page = $page-1>0?$page-1:1;
          $next_page = $page+1>$common->get_pages()?$common->get_pages():$page+1;
        ?>
        <li><a href="<?php echo $url.$prior_page;?>">上一页</a></li>
        <?php
          for($i=1; $i<=$common->get_pages(); $i++)
          {
        ?>
          <li class="<?php if($i==$page){echo 'active';}?>"><a href="<?php echo $url.$i;?>"><?php echo $i;?></a></li>
        <?php
          }
        ?>
        <li><a href="<?php echo $url.$next_page;?>">下一页</a></li>
    </ul>
  </center>
<?php
}
?>
</div>
<!-- booklist panel end -->

<script type="text/javascript">
  var grade = <?php echo isset($_GET['grade'])?intval($_GET['grade']):0 ?>;
  var type = <?php echo isset($_GET['type'])?intval($_GET['type']):0 ?>;
  var status = <?php echo isset($_GET['status'])?intval($_GET['status']):-1?>;
  $().ready(function(){
    $(".book_info").each(function(){
      $(this).height($(this).parent().find(".book_img").height());
    });
  });

  function grade_change(id)
  {
    if(type == 0)
    {
      if(status == -1)
      {
        location.href = "book_shelf.php?grade="+id;
      }
      else
      {
        location.href = "book_shelf.php?grade="+id+"&status="+status;
      }
    }
    else
    {
      if(status == -1)
      {
        location.href = "book_shelf.php?grade="+id+"&type="+type;
      }
      else
      {
        location.href = "book_shelf.php?grade="+id+"&type="+type+"&status="+status;
      }
    }
  }

  function type_change(id)
  {
    if(grade == 0)
    {
      if(status == -1)
      {
        location.href = "book_shelf.php?type="+id;
      }
      else
      {
        location.href = "book_shelf.php?type="+id+"&status="+status;
      }
    }
    else
    {
      if(status == -1)
      {
        location.href = "book_shelf.php?type="+id+"&grade="+grade;
      }
      else
      {
        location.href = "book_shelf.php?type="+id+"&grade="+grade+"&status="+status;
      }
    }
  }

  function change_status(id)
  {
    if(grade == 0)
    {
      if(type == 0)
      {
        location.href = "book_shelf.php?status="+id;
      }
      else
      {
        location.href = "book_shelf.php?status="+id+"&type="+type;
      }
    }
    else
    {
      if(type == 0)
      {
        location.href = "book_shelf.php?status="+id+"&grade="+grade;
      }
      else
      {
        location.href = "book_shelf.php?status="+id+"&grade="+grade+"&type="+type;
      }
    }
  }



</script>

<?php
  }
?>

<!-- 学生结束 -->


<!--教师开始-->
<?php
if($role == "教师")
{
?>
  <!-- division panel start -->
    <div class="w100 forget">
      <div class="forget_cover">
        全本阅读
        <div class="float_right" style="margin-right:5.8em;">
          <button class="btn btn-success" onclick="location.href='full_reading.php'">书单定制</button>
          <button class="btn btn-success active" onclick="location.href='book_shelf.php'">书单管理</button>
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
            <button type="button" class="btn btn-default">学段</button>
            <button type="button" class="btn btn-default dropdown-toggle"
                data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">选择</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <?php
                $grades = $common->get_grade();
                foreach ($grades as $grade)
                {
              ?>
                  <li><a href="javascript:void(0);" onclick="grade_change(<?php echo $grade->id?>)"><?php echo $grade->grade_name?></a></li>
              <?php
                }
              ?>
            </ul>
        </div>
      </div>
      <div class="col-lg-4">
        <form action="" method="post" name="search" id="search" onsubmit="return check_search()">
            <div class="input-group">
              <input type="text" class="form-control" id="search_keywords">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-search" style="cursor:pointer;" onclick="$('#search').submit()"></i>
              </span>
            </div>
        </form>
      </div>
    </div>
    <br>
  <!-- filter panel end -->
  
<?php
}
?>

    <!-- booklist panel start -->
    <!-- <div class="container mt20">
      <div class="col-lg-12">
        <div class="col-lg-4 mb20">
          <div class="col-lg-6 book_img">
            <img src="img/book1.png" width="100%"/>
          </div>
          <div class="col-lg-6 book_info" style="display:table;">
            <div style="display:table-cell; vertical-align:middle;">
              <p>书名：红楼梦</p>
              <p class="gray f12">作者：曹雪芹</p>
              <p class="gray f12">积分：7分</p>
              <p class="gray f12">剩余：30天</p>
            </div>
          </div>
          <div class="col-lg-12">
            <a href="#" class="label label-lg label-success ml20">
              <i class="glyphicon glyphicon-tags"></i>
              我要测评
            </a>
            <i class="glyphicon">&nbsp;</i>
            <a href="#" class="label label-success label-lg">
              <i class="glyphicon glyphicon-trash"></i>
              移除
            </a>
          </div>
        </div>
        <div class="col-lg-4 mb20">
          <div class="col-lg-6 book_img">
            <img src="img/book1.png" width="100%"/>
          </div>
          <div class="col-lg-6 book_info" style="display:table;">
            <div style="display:table-cell; vertical-align:middle;">
              <p>书名：红楼梦</p>
              <p class="gray f12">作者：曹雪芹</p>
              <p class="gray f12">积分：7分</p>
              <p class="gray f12">剩余：30天</p>
            </div>
          </div>
          <div class="col-lg-12">
            <a href="#" class="label label-lg label-success ml20">
              <i class="glyphicon glyphicon-tags"></i>
              我要测评
            </a>
            <i class="glyphicon">&nbsp;</i>
            <a href="#" class="label label-success label-lg">
              <i class="glyphicon glyphicon-trash"></i>
              移除
            </a>
          </div>
        </div>
        <div class="col-lg-4 mb20">
          <div class="col-lg-6 book_img">
            <img src="img/book1.png" width="100%"/>
          </div>
          <div class="col-lg-6 book_info" style="display:table;">
            <div style="display:table-cell; vertical-align:middle;">
              <p>书名：红楼梦</p>
              <p class="gray f12">作者：曹雪芹</p>
              <p class="gray f12">积分：7分</p>
              <p class="gray f12">剩余：30天</p>
            </div>
          </div>
          <div class="col-lg-12">
            <a href="#" class="label label-lg label-success ml20">
              <i class="glyphicon glyphicon-tags"></i>
              我要测评
            </a>
            <i class="glyphicon">&nbsp;</i>
            <a href="#" class="label label-success label-lg">
              <i class="glyphicon glyphicon-trash"></i>
              移除
            </a>
          </div>
        </div>
        <div class="col-lg-4 mb20">
          <div class="col-lg-6 book_img">
            <img src="img/book1.png" width="100%"/>
          </div>
          <div class="col-lg-6 book_info" style="display:table;">
            <div style="display:table-cell; vertical-align:middle;">
              <p>书名：红楼梦</p>
              <p class="gray f12">作者：曹雪芹</p>
              <p class="gray f12">积分：7分</p>
              <p class="gray f12">剩余：30天</p>
            </div>
          </div>
          <div class="col-lg-12">
            <a href="#" class="label label-lg label-success ml20">
              <i class="glyphicon glyphicon-tags"></i>
              我要测评
            </a>
            <i class="glyphicon">&nbsp;</i>
            <a href="#" class="label label-success label-lg">
              <i class="glyphicon glyphicon-trash"></i>
              移除
            </a>
          </div>
        </div>
        <div class="col-lg-4 mb20">
          <div class="col-lg-6 book_img">
            <img src="img/book1.png" width="100%"/>
          </div>
          <div class="col-lg-6 book_info" style="display:table;">
            <div style="display:table-cell; vertical-align:middle;">
              <p>书名：红楼梦</p>
              <p class="gray f12">作者：曹雪芹</p>
              <p class="gray f12">积分：7分</p>
              <p class="gray f12">剩余：30天</p>
            </div>
          </div>
          <div class="col-lg-12">
            <a href="#" class="label label-lg label-success ml20">
              <i class="glyphicon glyphicon-tags"></i>
              我要测评
            </a>
            <i class="glyphicon">&nbsp;</i>
            <a href="#" class="label label-success label-lg">
              <i class="glyphicon glyphicon-trash"></i>
              移除
            </a>
          </div>
        </div>
        <div class="col-lg-4 mb20">
          <div class="col-lg-6 book_img">
            <img src="img/book1.png" width="100%"/>
          </div>
          <div class="col-lg-6 book_info" style="display:table;">
            <div style="display:table-cell; vertical-align:middle;">
              <p>书名：红楼梦</p>
              <p class="gray f12">作者：曹雪芹</p>
              <p class="gray f12">积分：7分</p>
              <p class="gray f12">剩余：30天</p>
            </div>
          </div>
          <div class="col-lg-12">
            <a href="#" class="label label-lg label-success ml20">
              <i class="glyphicon glyphicon-tags"></i>
              我要测评
            </a>
            <i class="glyphicon">&nbsp;</i>
            <a href="#" class="label label-success label-lg">
              <i class="glyphicon glyphicon-trash"></i>
              移除
            </a>
          </div>
        </div>
      </div>
      <center>
        <ul class="pagination">
            <li><a href="#">上一页</a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">下一页</a></li>
        </ul>
      </center>
    </div> -->
    <!-- booklist panel end -->
    <?php
      include_once("footer.php")
    ?>
  </body>
  <script type="text/javascript">
    //测评
    function exam(book)
    {
      openwin("temp.php");
    }

    //弹出窗口
    function openwin(url)
    {
      var width = 800;
      var height = 600;
      var left = parseInt((screen.availWidth/2) - (width/2));//屏幕居中
      var top = parseInt((screen.availHeight/2) - (height/2));
      var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
      windowFeatures += ",location='no',menubar='no',resizable='no',status='no',titlebar='no',toolbar='no'";
      newWindow = window.open(url, "subWind", windowFeatures);
    }
  </script>
</html>
