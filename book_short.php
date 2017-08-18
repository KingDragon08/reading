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
        include_once("class/book_short.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:login.php");
        }
        else
        {
          $user = $GLOBALS['user'];
          $role = $user->get_user_info()->role;
          $user_id = $user->get_user_id();
          if(isset($_GET['book']))
          {
            $book = new Book_short(intval($_GET['book']));
            if($book->get_book_id() == -1)
            {
      ?>
              <center>
                <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
                <br>
                <p class="gray" id="tips">
                  找不到该短篇阅读...
                </p>
              </center>
      <?php
              exit();
            }
            else
            {
              $book_info = $book->get_book_info();
              $can_note = $book->check_note($user_id);
              //处理表单
              if(isset($_POST['comment']))
              {
                $comment = $_POST['comment'];
                if(strlen($comment) >= 5)
                {
                  $book->add_comment($user_id,$comment);
                }
              }
            }
          }
          else
          {
      ?>
            <center>
              <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
              <br>
              <p class="gray" id="tips">
                找不到该短篇阅读...
              </p>
            </center>
      <?php
            exit();
          }
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
          <li><a href="＃">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          <?php echo $book_info->name; ?>
          <!-- <div class="float_right" style="margin-right:5.8em;">
            <button class="btn btn-success" onclick="location.href='full_reading.html'">书单</button>
            <button class="btn btn-success active" onclick="location.href='book_shelf.html'">我的书架</button>
          </div> -->
        </div>
      </div>
    <!-- division panel end -->

    <?php
    if($user->get_user_info()->can_fullreading==0)
    {
    ?>
    <center>
      <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
      <br>
      <p class="gray" id="tips">
        没有访问权限...
      </p>
    </center>
    <?php
      include("footer.php");
      exit();
    }
    ?>


    <!-- book panel start -->
    <div class="container mt20">
        <div class="col-lg-12">
          <div class="col-lg-8" style="padding:0;">
            <!-- sub book info panel start -->
            <div class="row">
              <div class="col-lg-3">
                <img src="<?php echo $book_info->coverimg; ?>" alt="">
              </div>
              <div class="col-lg-9">
                <div class="col-lg-12" style="border:1px solid #ccc;">
                  <h4><?php echo $book_info->name; ?></h4>
                  <p class="f12 gray">权威版本、收藏经典</p>
                  <span class="single_book_info">
                    <font style="width:200px; display:inline-block;">作者：<?php echo $book_info->author; ?></font>&nbsp;&nbsp;&nbsp;&nbsp;
                    <font>类型：<?php echo $book_info->type_name;?></font>
                    <br>
                    <font style="width:200px; display:inline-block;">难度：<?php echo $book_info->level; ?></font>&nbsp;&nbsp;&nbsp;&nbsp;
                    <font>学段：<?php echo $book_info->grade_name; ?></font>
                    <br>
                    <font style="width:200px; display:inline-block;">字数：<?php echo $book_info->wordcount ?></font>&nbsp;&nbsp;&nbsp;&nbsp;
                    <font>积分：<?php echo $book_info->score ?></font>
                  </span>
                </div>
                <div class="col-lg-12 mt10 mb10" style="padding:0;">
                  
                </div>
              </div>
            </div>
            <!-- sub book info panel end -->
          </div>
          <script type="text/javascript">
            function comment()
            {
              if($("#t").val().length>5)
              {
                $("#comment").submit();
              }
              else
              {
                alert("至少6个字");
                return;
              }
            }
          </script>
          <div class="col-lg-4">
            <div class="list-group">
                <a href="javascript:void(0);" class="list-group-item" style="color:#5cb85c;">
                        本书评论
                </a>
                <?php
                  $page = 1;
                  if(isset($_GET['page']))
                  {
                    $page = intval($_GET['page']);
                  }
                  if($page < 1)
                  {
                    $page = 1;
                  }
                  $book_comments = $book->get_book_comment($page);
                  if(count($book_comments)>0)
                  {
                    foreach($book_comments as $comment)
                    {
                ?>
                      <a href="javascript:void(0);" class="list-group-item" title="评论详情" data-toggle="popover" data-container="body" data-placement="bottom" data-content="<?php echo $comment->content;?>">
                          <p class="list-group-item-heading">
                              <?php echo mb_substr($comment->content,0,49).'...'; ?>
                          </p>
                          <div class="list-group-item-text" style="margin-bottom:16px;">
                              <div class="float_left f12">用户：<?php echo $comment->username; ?></div>
                              <div class="float_right f12"><?php echo $comment->addtime;?></div>
                          </div>
                      </a>
                <?php
                    }
                  }
                  else
                  {
                    echo "<a class='gray list-group-item'>暂时没有评论...</a>";
                  }
                ?>
            </div>
            <center>
              <ul class="pagination" style="margin-top:0;">
                  <?php
                    $pages = $book->get_book_comment_pages();
                    $index = $page;
                    $end = $index + 4;
                    if($index!=1){
                  ?>
                    <li>
                          <a href="book_short.php?book=<?php echo $_GET['book']?>&page=1">
                            1
                          </a>
                      </li>
                  <?php
                    }
                    while($index<=$end && $index<=$pages)
                    {
                  ?>
                      <li <?php if($index==$page) echo "class='active'"?>>
                          <a href="book_short.php?book=<?php echo $_GET['book']?>&page=<?php echo $index;?>">
                            <?php echo $index; ?>
                          </a>
                      </li>
                  <?php
                      $index++;
                    }
                    if($end<$pages){
                  ?>
                    <li>
                        <a href="book_short.php?book=<?php echo $_GET['book']?>&page=<?php echo $pages;?>">
                          1
                        </a>
                    </li>
                  <?php
                    }
                  ?>
              </ul>
          </div>
        </div>

        <!-- sub book bref intro start -->
        <div class="col-lg-12" style="background: #f2f2f2; border-radius: 3px; padding: 15px;">
          <h5>《<?php echo $book_info->name; ?>》内容简介:</h5>
          <p class="f12" style="line-height:20px; text-indent: 2em;">
            <?php echo $book_info->bookdesc; ?>
          </p>
        </div>
        <!-- sub book bref intro end -->


        <?php
          $rec_books = $book->get_related_book();
          if(count($rec_books))
          {
        ?>
        <!-- sub recommend book panel start -->
        <div class="col-lg-12 mt20">
          <h5>好书推荐</h5>
          <div class="Div1">
            <b class="Div1_prev Div1_prev1" >
              <i class="glyphicon glyphicon-chevron-left">&nbsp;</i>
            </b>
            <b class="Div1_next Div1_next1" >
              <i class="glyphicon glyphicon-chevron-right">&nbsp;</i>
            </b>
            <div class="Div1_main">
                <div>
                  <?php
                    foreach($rec_books as $rec_book)
                    {
                  ?>
                    <span class="Div1_main_span1">
                        <a href="book.php?book=<?php echo $rec_book->id;?>" class="Div1_main_a1">
                          <img src="<?php echo $rec_book->coverimg;?>" />
                        </a>
                        <a href="book.php?book=<?php echo $rec_book->id;?>" class="Div1_main_a2">了解更多</a>
                    </span>
                  <?php
                    }
                  ?>
                </div>
            </div>
          </div>
        </div>
        <!-- sub recommend book panel end -->
        <script type="text/javascript" src="js/lunbo.js"></script>
        <?php
          }
        ?>





        <!--comment panel start-->
        <a name="comment">&nbsp;</a>
        <form class="" action="" method="post" id="comment">
          <div class="col-lg-12">
            <div class="form-group">
              <label for="name">写书评</label>
              <textarea class="form-control" id="t" name="comment" rows="8"></textarea>
            </div>
            <div class="btn-group" onclick="comment()" style="float:right;">
              <span class="btn btn-success">
                <i class="glyphicon glyphicon-send">&nbsp;</i>写书评
              </span>
            </div>
          </div>
        </form>
        <!--comment panel end-->
        <p>&nbsp;</p>


    </div>
    <!-- book panel end -->
    <?php
      include_once("footer.php");
    ?>
  </body>
  <script src="js/tooltip.js"></script>
  <script src="js/popover.js"></script>
  <script type="text/javascript">
    $(function () {
    	$("[data-toggle='popover']").popover();
    });

    //片段赏析
    function preview()
    {
      openwin("temp.php")
    }

    //相关习题
    function exam()
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

    function show_note()
    {
      $("#note").fadeIn();
    }

    function cancel_note()
    {
      $("#note").fadeOut();
    }
  </script>
  
  </div>
</html>
