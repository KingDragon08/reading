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
    <title>乐智悦读-语音朗读</title>
    <style media="screen">
      a{color:#555; margin-bottom: 6px; display: inline-block;}
      a:hover{color:#71cba4; text-decoration: none; cursor:pointer;}
      a.active{color:#71cba4;}
    </style>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:login.php");
        }
        else
        {
          include_once("class/speech.php");
          $user = $GLOBALS['user'];
          $role = $user->get_user_info()->role;
          $speech = new Speech();
        }
      ?>
    <!-- top nav end -->
    <script type="text/javascript" src="js/cookie.js"></script>
    <!-- main nav start -->
      <div class="container main-nav">
        <div class="brand">
            <img src="img/nav-brand.png" alt="">
        </div>
        <ul class="navigator">
          <li><a href="index.php">首页</a></li>
          <li><a href="full_reading.php">全本阅读</a></li>
          <li><a href="ing.php" class="active">语音朗读</a></li>
          <li><a href="report.php">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
            语音朗读
            <div class="float_right" id="ctr_btn" style="margin-right:5.8em;">
              <button class="btn btn-success active" style="margin-right:10px;">单字测评</button>
              <button class="btn btn-success" style="margin-right:10px;" onclick="location.href='ing_c.php'">词语测评</button>
              <button class="btn btn-success" onclick="location.href='ing_j.php'">短文测评</button>
            </div>
        </div>
     </div>
    <div class="container mt20 mb20">
      <div class="row">
        <img src="img/book_icon.png" alt="">
        选择书本
      </div>
      <div class="col-lg-12 mt20">

        <h5>请选择教材</h5>
        <div class="row mt20">
          <?php
            $textbook = 1;
            $grade = 1;
            $unit = 1;
            $page = 1;
	    $url = "javascript:void(0);";
            if(isset($_GET['textbook']))
            {
              $textbook = intval($_GET['textbook'])<1?1:intval($_GET['textbook']);
            }
            if(isset($_GET['grade']))
            {
              $grade = intval($_GET['grade'])<1?1:intval($_GET['grade']);
            }
            if(isset($_GET['unit']))
            {
              $unit = intval($_GET['unit'])<1?1:intval($_GET['unit']);
            }
            if(isset($_GET['page']))
            {
              $page = intval($_GET['page'])<1?1:intval($_GET['page']);
            }
            $textbooks = $speech->get_textbooks();
            foreach($textbooks as $item)
            {
          ?>
              <div class="col-lg-2">
                <a href="?textbook=<?php echo $item->id;?>" target="_self"
                    class="textbook <?php if($textbook==$item->id){echo 'active';} ?>">
                  <?php echo $item->name ?>
                </a>
              </div>
          <?php
            }
           ?>
        </div>

        <h5 class="mt20">请选择年级</h5>
        <div class="row mt20">
          <?php
            $grades = $speech->get_grades($textbook);
            if(count($grades))
            {
              foreach($grades as $item)
              {
           ?>
                 <div class="col-lg-2">
                   <a href="?textbook=<?php echo $textbook;?>&grade=<?php echo $item->id;?>" target="_self"
                       class="textbook <?php if($grade==$item->id){echo 'active';} ?>">
                     <?php echo $item->name ?>
                   </a>
                 </div>
           <?php
              }
            }
           ?>
        </div>
        <h5 class="mt20">请选择单元</h5>
        <div class="row mt20">
        <?php
            $units = $speech->get_units($grade);
            if(count($units))
            {
              foreach($units as $item)
              {
        ?>
                <div class="col-lg-2">
                  <a href="?textbook=<?php echo $textbook;?>&grade=<?php echo $grade;?>&unit=<?php echo $item->id;?>&page=1" target="_self"
                      class="textbook <?php if($unit==$item->id){echo 'active'; $url="speech.php?type=zi&textbook=$textbook&grade=$grade&unit=$unit&page=1"; } ?>">
                    <?php echo $item->name ?>
                  </a>
                </div>
        <?php
              }
            }
        ?>
        </div>
    </div>
  </div>
    <style media="screen">
      .start{width:100px; height:100px; color:#fff; position: fixed; right:20px; bottom:40px;
              background: rgba(113,187,164,0.8); border-radius:999px;
              box-shadow: 0 0 10px 10px #f2f2f2; color:#fff; text-align:center; line-height: 100px;
              font-size: 16px; cursor: pointer;
            }
    </style>
    <div class="start" onclick="speech_start()">
      开始测评
    </div>
    <script type="text/javascript">
      function speech_start()
      {
        var speech_time = new Date().getTime();
        location.href = "<?php echo $url?>&speech_time="+speech_time;
      }
    </script>
    <?php
      include_once("footer.php");
    ?>
  </body>
</html>
