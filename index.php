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
    <title>乐智悦读</title>
  </head>
  <body>

<?php
  include("top.php")
?>
<!-- main nav start -->
  <div class="container main-nav">
    <div class="brand">
        <img src="img/nav-brand.png" alt="">
    </div>
    <ul class="navigator">
      <li><a href="＃" class="active">首页</a></li>
      <li><a href="full_reading.php">全本阅读</a></li>
      <li><a href="page_reading.php">短篇阅读</a></li>
      <li><a href="ing.php">语音朗读</a></li>
      <li><a href="report.php">测评中心</a></li>
    </ul>
  </div>
  <div class="intro">
    <div class="three_part container w800">
      <div class="row">
        <div class="col-lg-4">
          <div class="panel">
            <p><br>在这里你会学到如何高效的阅读一本书籍。并使每一本你阅读过的好书都成为看得见的成长印记。</p>
            <a href="learn_more.html" class="lear_more btn btn-success">
              了解更多
            </a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel">
            <p><br>在这里你会学习<br>标准普通话的发音，<br>并时刻了解自己<br>与标准发音的差距</p>
            <a href="learn_more.html" class="lear_more btn btn-success">
              了解更多
            </a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel">
            <p>在这里你将看到<br>为自己量身定制的<br>综合评价报告，<br>你一定会好奇<br>你在里面会是什么样子</p>
            <a href="learn_more.html" class="lear_more btn btn-success">
              了解更多
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- main nav end -->
<!-- function intro start -->
  <div class="white_space"></div>
  <table width="100%" height="450" align="center" border="0" cellspacing="0" cellspadding="0" class="function">
    <tr>
      <td height="450" align="center" valign="middle" width="50%">
        <img src="img/func1.png" alt="">
        <p class="big_font">&nbsp;</p>
        <p class="big_font">测评中心</p>
        <p>万般学习数据，全在测评中心</p>
        <p>轻松统计阅读，朗诵成绩</p>
        <p>教师掌控全局，学生了解自我</p>
      </td>
      <td width="5" class="white_space">&nbsp;</td>
      <td height="450" align="center" valign="middle" width="50%">
        <table width="100%" height="450" align="center" border="0">
          <tr>
            <td height="50%" align="center">
              <table width="100%" height="100%" align="center" border=0>
                <tr>
                  <td width="50%" align="right" style="padding-right20px;">
                    <img src="img/func2.png" alt="" class="">
                  </td>
                  <td width="50%" align="left" style="padding-left:20px;">
                    <p class="big_font" class="float_left">全本阅读</p>
                    <p>学校的图书馆，亦如你的，读书学习</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="4" class="white_space"></td>
          </tr>
          <tr>
            <td height="50%">
              <table width="100%" height="100%" align="center" border=0>
                <tr>
                  <td width="50%" align="right" style="padding-right20px;">
                    <img src="img/func3.png" alt="" class="">
                  </td>
                  <td width="50%" align="left" style="padding-left:20px;">
                    <p class="big_font" class="float_left">语音朗读</p>
                    <p>汉字，词组，文章；齐全的语音测试</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<!-- function intro end -->
<?php
  include_once("footer.php")
?>

</body>
</html>
