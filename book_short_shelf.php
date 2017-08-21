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
    <title>乐智悦读-短篇阅读</title>
    <style media="screen">
      .btn-small{font-size: 12px; border-radius: 20px;}
      .purple{color:#824399;}
      .paiming{
        background: #f2f2f2; width: 100%;
      }
      .paiming tr{
        border:1px solid #fff;
        border-top:0;
      }
      .paiming td{
        border-right: 1px solid #fff;
      }
      .paiming tr td:last-child{
        border:0;
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
          <li><a href="full_reading.php">全本阅读</a></li>
          <li><a href="page_reading.php" class="active">短篇阅读</a></li>
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
        <button class="btn btn-success" onclick="location.href='page_reading.php'">全部短篇</button>
        <button class="btn btn-success active" onclick="location.href='book_short_shelf.php'">我的短篇</button>
      </div>
    </div>
  </div>
<!-- division panel end -->
<!-- filter panel start -->
<br>
<div class="row">
  <div class="container">
    <div class="col-lg-9">
      选择:&nbsp;&nbsp;&nbsp;&nbsp;

      <div class="btn-group">
          <button type="button" class="btn btn-default" id="list_type">类型</button>
          <button type="button" class="btn btn-default dropdown-toggle"
              data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">选择</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="javascript:void(0);" onclick="type_change(0)">全部类型</a></li>
            <?php
              $types = $common->get_all_book_type_short();
              $status = isset($_GET['status'])?intval($_GET['status']):-1;
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
          <button type="button" class="btn btn-default" id="kd_type">教师推送</button>
          <button type="button" class="btn btn-default dropdown-toggle"
              data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">选择</span>
          </button>
          <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:void(0);" onclick="type_change(-1)">教师推送</a></li>
              <li><a href="javascript:void(0);" onclick="type_change(-2)">自选书单</a></li>
          </ul>
          <?php
            if(isset($_GET['type']))
            {
              if(intval($_GET['type'])==-1)
              {
                echo '<script>$("#kd_type").html("教师推送");</script>';
              }
              if(intval($_GET['type'])==-2)
              {
                echo '<script>$("#kd_type").html("自选书单");</script>';
              }
            }
          ?>
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
      &nbsp;&nbsp;

      <div class="btn-group">
          <button type="button" class="btn btn-default" id="endtime">截止日期</button>
          <button type="button" class="btn btn-default dropdown-toggle"
              data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">选择</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <?php
              $endtimes = $common->get_books_task_endtimes_short($user_id);
              if(count($endtimes))
              {
                foreach($endtimes as $endtime)
                {
                  $time_string = date('Y-m-d',$endtime->endtime);
                  if($time_string!="1970-01-01")
                  {
            ?>
                <li><a href="javascript:void(0);" onclick="endtime_change(<?php echo $endtime->endtime?>)">
                  <?php
                    $time_string = date('Y-m-d',$endtime->endtime);
                    echo $time_string;
                  ?>
                </a></li>
            <?php
                  }
                }
              }
              if(isset($_GET['endtime']))
              {
                  echo '<script>$("#endtime").html("'.date('Y-m-d',$_GET['endtime']).'");</script>';
              }
            ?>
          </ul>
      </div>


    </div>
    <div class="col-lg-3">
      <form action="search.php" method="get" target="_blank" name="search" id="search" onsubmit="return check_search()">
          <div class="input-group">
            <input type="text" name="s" class="form-control" id="search_keywords">
            <input type="hidden" name="type" value="short">
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
      $endtime =isset($_GET['endtime'])?intval($_GET['endtime']):0;
      // $books = $common->get_lists_task($user_id,$grade,$type,$status,$page);
      if($endtime!=0)
      {
          $books = $common->get_books_task_short($user_id,0,0,-1,1,$endtime);
      }
      else
      {
          $books = $common->get_books_task_short($user_id,$grade,$type,$status,$page,$endtime);
      }
      if($books)
      {
        $counter=0;
      foreach($books as $book)
      {
        $counter++;
    ?>
    <div class="col-lg-4 mb20" <?php if($counter%3==1 && $counter!=1) echo "style='clear:both;'"?>>
      <div class="col-lg-6 book_img">
        <a href="book_short.php?book=<?php echo $book->id;?>">
          <img src="<?php echo $book->coverimg; ?>" width="100%"/>
        </a>
      </div>
      <div class="col-lg-6 book_info" style="display:table; height:166px;">
        <div style="display:table-cell; vertical-align:middle;">
          <p><?php echo $book->name;?></p>
          <p class="gray f12">作者：<?php echo $book->author;?></p>
          <p class="gray f12">难度等级：<?php echo $book->level;?></p>
          <p class="gray f12">字数：<?php echo $book->wordcount;?></p>
          <p class="gray f12">积分：<?php echo $book->score;?></p>
          <p class="gray f12">剩余时间：<?php echo $book->restime;?></p>
        </div>
      </div>
      <div class="col-lg-12" style="margin-top:8px;">
        <table width="100%">
          <tr>
            <td align="center" width="50%">
              <?php
              if($book->status==2)
              {
              ?>
                <a class="btn btn-small btn-success" style="padding:4px 12px;" href="exam<?php if($book->grade>=2){echo 2;}?>_short.php?book=<?php echo $book->id;?>">
                  <i class="glyphicon glyphicon-file">我要测评</i>
                </a>
                <!-- <a class="btn btn-small btn-success" style="padding:4px 12px;" href="temp.php">
                  <i class="glyphicon glyphicon-file">我要测评</i>
                </a> -->
              <?php
              }
              if($book->status==1)
              {
              ?>
                <span class="btn btn-small btn-success" style="padding:4px 12px;" onclick="openwin('exam_report_history_short.php?book=<?php echo $book->id;?>');">
                  <i class="glyphicon glyphicon-file">测评结果</i>
                </span>
                <!-- <span class="btn btn-small btn-success" style="padding:4px 12px;" onclick="openwin('temp.php');">
                  <i class="glyphicon glyphicon-file">测评结果</i>
                 --></span>
              <?php
              }
              if($book->status==0)
              {
              ?>
                <a class="btn btn-small btn-success" style="padding:4px 12px;" href="exam<?php if($book->grade>=2){echo 2;}?>_short.php?book=<?php echo $book->id;?>">
                  <i class="glyphicon glyphicon-file">再次测评</i>
                </a>
                <!-- <a class="btn btn-small btn-success" style="padding:4px 12px;" href="temp.php">
                  <i class="glyphicon glyphicon-file">再次测评</i>
                </a> -->
              <?php
              }
              ?>
            </td>
            <td align="left" width="50%">
              <?php
                if($book->shelf_type==0)
                {
              ?>
                <a class="btn btn-small btn-success" style="padding:4px 12px;" href="controller/book_shelf_short.php?action=remove&book=<?php echo $book->id;?>">
                  <i class="glyphicon glyphicon-trash"></i>移除
                </a>
              <?php
                }
                else
                {
              ?>
                <a class="btn btn-small btn-info" style="padding:4px 12px;" href="javascript:;">
                  <i class="glyphicon glyphicon-trash"></i>不可移除
                </a>
              <?php
                }
              ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <?php
        }
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
          $url = "book_short_shelf.php?grade=".$grade."&type=".$type."&status=".$status."&page=";
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

  function grade_change(id)
  {
    if(type == 0)
    {
      if(status == -1)
      {
        location.href = "book_short_shelf.php?grade="+id;
      }
      else
      {
        location.href = "book_short_shelf.php?grade="+id+"&status="+status;
      }
    }
    else
    {
      if(status == -1)
      {
        location.href = "book_short_shelf.php?grade="+id+"&type="+type;
      }
      else
      {
        location.href = "book_short_shelf.php?grade="+id+"&type="+type+"&status="+status;
      }
    }
  }

  function type_change(id)
  {
    if(grade == 0)
    {
      if(status == -1)
      {
        location.href = "book_short_shelf.php?type="+id;
      }
      else
      {
        location.href = "book_short_shelf.php?type="+id+"&status="+status;
      }
    }
    else
    {
      if(status == -1)
      {
        location.href = "book_short_shelf.php?type="+id+"&grade="+grade;
      }
      else
      {
        location.href = "book_short_shelf.php?type="+id+"&grade="+grade+"&status="+status;
      }
    }
  }

  function change_status(id)
  {
    if(grade == 0)
    {
      if(type == 0)
      {
        location.href = "book_short_shelf.php?status="+id;
      }
      else
      {
        location.href = "book_short_shelf.php?status="+id+"&type="+type;
      }
    }
    else
    {
      if(type == 0)
      {
        location.href = "book_short_shelf.php?status="+id+"&grade="+grade;
      }
      else
      {
        location.href = "book_short_shelf.php?status="+id+"&grade="+grade+"&type="+type;
      }
    }
  }

  function endtime_change(endtime)
  {
    location.href = "book_short_shelf.php?endtime="+endtime;
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
        短篇阅读
        <div class="float_right" style="margin-right:5.8em;">
          <button class="btn btn-success" onclick="location.href='page_reading.php'">短篇定制</button>
          <button class="btn btn-success active" onclick="location.href='book_short_shelf.php'">短篇管理</button>
        </div>
      </div>
    </div>
  <!-- division panel end -->
  <!-- filter panel start -->
  <br>
  <div class="container">
  <div class="col-lg-3" style="max-height:750px; overflow:scroll;">
    <div class="paiming_title" style="margin-top:50px;">
      学生阅读完成记录板
    </div>
    <table class="paiming">
      <?php
        if(isset($_GET['id']))
        {
          $id = intval($_GET['id']);
        }
        else
        {
          $id = 0;
        }
        $num_data = $user->get_num_data_short($id);
        if(count($num_data)>0)
        {
          foreach($num_data as $data)
          {
      ?>
          <tr>
            <td width="50%" height="40" align="center" valign="middle"><?php echo $data['name'];?></td>
            <td width="50%" height="40" align="center" valign="middle"><?php echo $data['num'];?>篇</td>
          </tr>
      <?php
          }
        }
      ?>
    </table>
  </div>
  <div class="col-lg-9">
    <div class="col-lg-12">
      <div class="col-lg-8">
        选择:&nbsp;&nbsp;&nbsp;&nbsp;

        <div class="btn-group">
            <button type="button" class="btn btn-default" id="list_type">历史书单</button>
            <button type="button" class="btn btn-default dropdown-toggle"
                data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">选择</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="book_short_shelf.php?id=0">全部历史书单</a></li>
              <?php
                $grades = $common->get_grade();
                $lists = $user->get_history_list_short();
                $counter = 0;
                while($counter<count($lists))
                {
              ?>
                  <li><a href="book_short_shelf.php?id=<?php echo $lists[$counter]->id;?>"><?php echo $lists[$counter]->name;?></a></li>
              <?php
                  if(isset($_GET['id']))
                  {
                    if($lists[$counter]->id==$_GET['id'])
                    {
                      echo "<script>$('#list_type').html('".$lists[$counter]->name."')</script>";
                    }
                  }
                  $counter++;
                }
              ?>
            </ul>
        </div>
      </div>
      <div class="col-lg-4">
        <form action="" method="get" name="search" id="search" onsubmit="return check_search()">
            <div class="input-group">
              <input type="text" name="s" class="form-control" id="search_keywords">
              <input type="hidden" name="type" value="short">
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
  <?php
    $books = "123";
    $page = 1;
    if(isset($_GET['page']))
    {
      $page = $_GET['page'];
    }
    if($page<1)
    {
      $page = 1;
    }
    if(isset($_GET['id']))
    {
      $id = intval($_GET['id']);
      if($id!=0)
      {
        $books = $common->get_teacher_list_by_id_short($user_id,$id,$page);
      }
      else
      {
        $books = $common->get_teacher_book_list_short($user_id,$page);
      }
    }
    else
    {
      if(isset($_GET['s']))
      {
        $keywords = $_GET['s'];
        $books = $common->get_teacher_books_by_keywords_short($user_id,$keywords);
      }
      else
      {
        $books = $common->get_teacher_book_list_short($user_id,$page);
      }
    }
  ?>
  <div class="col-lg-12 mt20">
    <?php
      if($books)
      {
        foreach($books as $book)
        {
    ?>
          <div class="col-lg-6 mb20">
            <div class="col-lg-6 book_img">
              <a href="book_short.php?book=<?php echo $book->id;?>">
                <img src="<?php echo $book->coverimg; ?>" width="100%"/>
              </a>
            </div>
            <div class="col-lg-6 book_info" style="display:table; height:182px;">
              <div style="display:table-cell; vertical-align:middle;">
                <p>名字：<?php echo $book->name;?></p>
                <p class="gray f12">作者：<?php echo $book->author;?></p>
                <p class="purple">已读学生：<?php echo $book->num;?>人</p>
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
          <p class="gray" id="tips">
            暂无满足条件的短篇书单...
          </p>
        </center>
    <?php
      }
    ?>
  </div>
  <!-- booklist panel end -->
  <?php
    if(!isset($_GET['s']))
    {
      $url = '';
      $prior_url = '';
      $next_url = '';
      $page = isset($_GET['page'])?intval($_GET['page']):1;
      $id = isset($_GET['id'])?intval($_GET['id']):-1;
      if($id != -1)
      {
        $url .= "id=$id&";
      }
  ?>
      <center>
        <ul class="pagination">
            <li><a href="book_short_shelf.php?<?php echo $url;?>page=<?php echo $page-1>0?$page-1:1;?>">上一页</a></li>
            <?php
              for($i=1;$i<=$common->get_pages();$i++)
              {
            ?>
                <li class="<?php if($i==$page) echo 'active';?>"><a href="book_short_shelf.php?<?php echo $url;?>page=<?php echo $i;?>"><?php echo $i;?></a></li>
            <?php
              }
            ?>
            <li><a href="book_short_shelf.php?<?php echo $url;?>page=<?php echo $page+1>$common->get_pages()?$common->get_pages():$page+1;?>">下一页</a></li>
        </ul>
      </center>
  </div>
</div>
<?php
  }
}
?>
    <?php
      include_once("footer.php")
    ?>
  </body>
</html>
