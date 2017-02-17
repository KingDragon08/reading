<?php
  include_once("common.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <title>乐智悦读-我的书架</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $user_info = $user->get_user_info();
        $page = 1;
        if(isset($_GET['page']))
        {
          $page = intval($_GET['page']);
        }
        $books = $user->get_books($page);
        // print_r($books);
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">我的书架</h4>
    </center>
    <br><br>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
          foreach($books as $book)
          {
        ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb20 mt20">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 book_img" >
            <img src="<?php echo $book->coverimg?>" width="100%"/>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 book_info" style="display:table;">
            <div style="display:table-cell; vertical-align:middle;">
              <p>书名：<?php echo $book->name?></p>
              <p class="gray f12">作者：<?php echo $book->author?></p>
              <p class="gray f12">积分：<?php echo $book->score?>分</p>
              <p class="gray f12">类型：<?php echo $book->type?></p>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="#" class="label label-lg label-success ml20" onclick="exam(<?php echo $book->id?>)">
              <i class="glyphicon glyphicon-tags"></i>
              我要测评
            </a>
            <i class="glyphicon">&nbsp;</i>
            <a href="../controller/book_shelf.php?action=remove&book=<?php echo $book->id?>" class="label label-success label-lg">
              <i class="glyphicon glyphicon-trash"></i>
              移除
            </a>
          </div>
        </div>
        <?php
          }
        ?>
      </div>
      <center>
        <ul class="pagination">
            <li><a href="student_book_shelf.php?page=<?php echo ($page-1)>0?($page-1):1; ?>">上一页</a></li>
            <?php
              $pages = $user->get_book_shelf_pages();
              $counter = 1;
              while($counter <= $pages)
              {
                if($counter == $page)
                {
                  echo "<li class='active'><a href='#'>".$counter."</a></li>";
                }
                else
                {
                  echo "<li><a href='student_book_shelf.php?page=$counter'>".$counter."</a></li>";
                }
                $counter++;
              }
            ?>
            <li><a href="student_book_shelf.php?page=<?php echo ($page+1)>$pages?($page+1):$pages; ?>">下一页</a></li>
        </ul>
      </center>
    </div>
  </body>
  <script type="text/javascript">
    function exam(book)
    {
      //alert(book);
       var width = 800;
       var height = 600;
       var left = parseInt((screen.availWidth/2) - (width/2));//屏幕居中
       var top = parseInt((screen.availHeight/2) - (height/2));
       var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
       windowFeatures += ",location='no',menubar='no',resizable='no',status='no',titlebar='no',toolbar='no'";
       newWindow = window.open("exam.php", "subWind", windowFeatures);
    }
  </script>
</html>
