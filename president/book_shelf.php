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
        include_once("../class/common.php");
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
      </div>
    <!-- main nav end -->



<!--校长开始-->
<?php
if($role == "3")
{
?>
  <!-- division panel start -->
    <div class="w100 forget">
      <div class="forget_cover">
        全本阅读
        <div class="float_right" style="margin-right:5.8em;">
          <button class="btn btn-success" onclick="location.href='push.php'">书单定制</button>
          <button class="btn btn-success active" onclick="location.href='book_shelf.php'">书单管理</button>
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
        $num_data = $user->get_num_data_president($id);
        if(count($num_data)>0)
        {
          foreach($num_data as $data)
          {
      ?>
          <tr>
            <td width="50%" height="40" align="center" valign="middle"><?php echo $data['name'];?></td>
            <td width="50%" height="40" align="center" valign="middle"><?php echo $data['num'];?>本</td>
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
        选择书单类型:&nbsp;&nbsp;&nbsp;&nbsp;

        <div class="btn-group">
            <button type="button" class="btn btn-default" id="list_type">历史书单</button>
            <button type="button" class="btn btn-default dropdown-toggle"
                data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">选择</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="book_shelf.php?id=0">全部历史书单</a></li>
              <?php
                $grades = $common->get_grade();
                $lists = $user->get_history_list();
                $counter = 0;
                while($counter<count($lists))
                {
              ?>
                  <li><a href="book_shelf.php?id=<?php echo $lists[$counter]->id;?>"><?php echo $lists[$counter]->name;?></a></li>
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
        $books = $common->get_teacher_list_by_id($user_id,$id,$page);
      }
      else
      {
        $books = $common->get_teacher_book_list($user_id,$page);
      }
    }
    else
    {
      if(isset($_GET['s']))
      {
        $keywords = $_GET['s'];
        $books = $common->get_teacher_books_by_keywords($user_id,$keywords);
      }
      else
      {
        $books = $common->get_teacher_book_list($user_id,$page);
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
              <a href="book.php?book=<?php echo $book->id;?>">
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
            暂无满足条件的书单...
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
      $grade = isset($_GET['id'])?intval($_GET['id']):-1;
      if($id != -1)
      {
        $url .= "id=$id&";
      }
  ?>
      <center>
        <ul class="pagination">
            <li><a href="book_shelf.php?<?php echo $url;?>page=<?php echo $page-1>0?$page-1:1;?>">上一页</a></li>
            <?php
              for($i=1;$i<=$common->get_pages();$i++)
              {
            ?>
                <li class="<?php if($i==$page) echo 'active';?>"><a href="book_shelf.php?<?php echo $url;?>page=<?php echo $i;?>"><?php echo $i;?></a></li>
            <?php
              }
            ?>
            <li><a href="book_shelf.php?<?php echo $url;?>page=<?php echo $page+1>$common->get_pages()?$common->get_pages():$page+1;?>">下一页</a></li>
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
