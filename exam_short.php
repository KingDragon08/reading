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
    <title>乐智悦读-测验</title>
    <style media="screen">
      .item{min-height:515px; width: 759px; height:auto; overflow: auto;}
      .question_title{margin-left:30px; margin-top:40px; font-size: 16px; font-weight: bold;}
      .answers{margin-left: 30px; margin-top:20px;}
      .question_ctr{margin-top:50px; text-align: center; clear: both;}
      .btn{margin-bottom: 8px;}
      #time{
        background:url(img/count_down.png) no-repeat center center;
        font-size:16px; display:inline-block; text-indent:0.8em; width:75px; text-align:left;
        background-size: contain;
      }
      .choice_item_container{
        width:90%; height:auto; min-height:40px; border:1px solid #e5e5e5; border-radius:5px;
        margin-bottom: 8px; overflow: auto; display: flex;
      }
      .choice_item_left{
        width:40px; line-height:38px; text-align:center; float: left;
        display: flex; justify-content: center; align-items: center;
      }
      .choice_item_right{
        float:left; line-height: 38px; padding-left: 0.5em;
        width:calc(100% - 40px);  border-left:1px solid #e5e5e5;
      }
      .choice_item_container:hover{
        cursor: pointer; border:1px solid #662a7c;
      }
      .choice_item_container:hover .choice_item_right{
        border-left:1px solid #662a7c;
      }
      .choice_item_container.active{
        cursor: pointer; border:1px solid #662a7c;
      }
      .choice_item_container.active .choice_item_right{
        border-left:1px solid #662a7c;
      }
    </style>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        include_once("class/exam_short.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:login.php");
        }
        else
        {
          $user = $GLOBALS['user'];
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
          <li><a href="page_reading.php">短篇阅读</a></li>
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="report.php">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <?php
      if($role != "学生")
      {
    ?>
      <center>
        <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
        <br>
        <p class="gray" id="tips">
          没有权限...
        </p>
      </center>
    <?php
        exit();
      }
    ?>
    <!-- division panel start -->
      <div class="w100 forget">
        <div class="forget_cover" id="subtitle">
          短篇阅读（测试习题）
          <div class="float_right" style="margin-right:5.8em;">
            <p id="time">

            </p>
          </div>
        </div>
      </div>
    <!-- division panel end -->
    <!-- list start -->
    <div class="container mt20 mb20">
      <div style="width:960px; min-height:515px; height:auto; overflow-y:auto; margin:0 auto; box-shadow:0 0 5px #999; border-radius:5px;">
        <?php
          if(!isset($_GET['book']))
          {
        ?>
          <center>
            <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
            <br>
            <p class="gray" id="tips">
              非法的访问...
            </p>
          </center>
        <?php
            exit();
          }
          $book = intval($_GET['book']);
          if($book < 1)
          {
        ?>
          <center>
            <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
            <br>
            <p class="gray" id="tips">
              非法的访问...
            </p>
          </center>
        <?php
            exit();
          }
        ?>
        <?php
          //判断书是不是高年级的书
          global $db;
          $grade = $db->get_var("select grade from rd_book_short where id='$book'");
          if($grade>1)
          {
            exit();
          }
          //处理表单
          if(
              isset($_POST['question_id_1']) &&
              isset($_POST['question_id_2']) &&
              isset($_POST['question_id_3']) &&
              isset($_POST['question_id_4']) &&
              isset($_POST['question_id_5']) &&
              isset($_POST['question_id_6']) &&
              isset($_POST['question_id_7']) &&
              isset($_POST['question_id_8']) &&
              isset($_POST['question_id_9']) &&
              isset($_POST['question_id_10']) &&
              isset($_POST['question_1']) &&
              isset($_POST['question_2']) &&
              isset($_POST['question_3']) &&
              isset($_POST['question_4']) &&
              isset($_POST['question_5']) &&
              isset($_POST['question_6']) &&
              isset($_POST['question_7']) &&
              isset($_POST['question_8']) &&
              isset($_POST['question_9']) &&
              isset($_POST['question_10'])
          )
          {
              $question_ids = [];
              $question_ids[] = $_POST['question_id_1'];
              $question_ids[] = $_POST['question_id_2'];
              $question_ids[] = $_POST['question_id_3'];
              $question_ids[] = $_POST['question_id_4'];
              $question_ids[] = $_POST['question_id_5'];
              $question_ids[] = $_POST['question_id_6'];
              $question_ids[] = $_POST['question_id_7'];
              $question_ids[] = $_POST['question_id_8'];
              $question_ids[] = $_POST['question_id_9'];
              $question_ids[] = $_POST['question_id_10'];
              $answers = [];
              $answers[] = $_POST['question_1'];
              $answers[] = $_POST['question_2'];
              $answers[] = $_POST['question_3'];
              $answers[] = $_POST['question_4'];
              $answers[] = $_POST['question_5'];
              $answers[] = $_POST['question_6'];
              $answers[] = $_POST['question_7'];
              $answers[] = $_POST['question_8'];
              $answers[] = $_POST['question_9'];
              $answers[] = $_POST['question_10'];
              $answer_time = $_COOKIE["answer_time"];
              // setCookie("answer_time",600);
              // $_COOKIE["answer_time"] = 600;
              $exam = new Exam_short($book);
              $can_exam = $exam->can_exam($user_id,$book);
              if($can_exam>0)
              {
            ?>
              <center>
                <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
                <br>
                <p class="gray" id="tips">
                  <?php
                    if($can_exam==1)
                    {
                      echo "你已经通过该本书的测试了哟";
                    }
                    if($can_exam==2)
                    {
                      echo "当天答题次数已超过三次,明天再来或换本书测试吧!";
                    }
                  ?>
                </p>
              </center>
            <?php
                exit();
              }
              //获取得分情况
              $scores = $exam->scores($question_ids,$answers);
              //写入得分情况并返回测试结果ID
              $exam_result_id = $exam->write_scores($user_id,$book,$scores,$answer_time,$answers,$question_ids);
              //转到测试结果页
              /*
              <center>
                <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
                <br>
                <p class="gray" id="tips">
                  已打开结果展示页面...
                </p>
              </center>
              */
              echo "<script>location.href = 'exam_report_short.php?exam=$exam_result_id';</script>";
              // header("Location:exam_report.php?exam=$exam_result_id");
              exit();
          }
          else
          {
        ?>
        <form action="" id="kd_exam" method="post" onsubmit="return check();">
        <div id="myCarousel" class="carousel slide" style="width:759px; float:left; min-height:515px; height:auto; overflow:auto; border-right:1px solid #ccc;">
          <!-- 轮播（Carousel）项目 -->
          <div class="carousel-inner" style="min-height:515px; height:auto; overflow:auto;">
            <?php
              $exam = new Exam_short($book);
              //检查当前用户是否可以在当天进行测试
              //0 可以答题
              //1 已经通过
              //2 当天答题次数已经达到3次
              $can_exam = $exam->can_exam($user_id,$book);
              if($can_exam>0)
              {
            ?>
              <center>
                <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
                <br>
                <p class="gray" id="tips">
                  <?php
                    if($can_exam==1)
                    {
                      echo "你已经通过该本书的测试了哟";
                    }
                    if($can_exam==2)
                    {
                      echo "当天答题次数已超过三次,明天再来或换本书测试吧!";
                    }
                  ?>
                </p>
              </center>
            <?php
                exit();
              }
              $questions = $exam->get_questions();
              $counter = 1;
              if(count($questions)<9)
              {
            ?>
              <center>
                <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
                <br>
                <p class="gray" id="tips">
                  测试试题库出错，请等候管理员处理...
                </p>
              </center>
            <?php
                exit();
              }
              $coverimg = $questions[10];
              array_pop($questions);
              foreach($questions as $question)
              {
            ?>
                <div class="item <?php if($counter==1){echo "active";}?>">
                  <div class="answers">
                    <div style="margin-top:20px; mergin-left:20px; font-size:18px; color:#662a7c;">
                      <img src="img/book_icon.png" alt="">
                      书籍名称《<?php echo $exam->get_book_name($book);?>》
                      <div style="float:right; margin-right: 20px;" class="btn btn-success btn-sm" onclick="show_text()">阅读文本</div>
                    </div>
                    <table style="margin-top:50px; width:100%;">
                      <tr>
                        <td width="40%" valign="middle" align="left" style="padding-right:8px; line-height:24px;">
                            <p>
                              第<?php echo $counter;?>题：<?php echo $question->question;?>
                            </p>
                            <center><img src="<?php echo $coverimg;?>" alt="图书封面走丢了" style="max-width:80%;"></center>
                        </td>
                        <td width="60%" valign="middle" id="kd_<?php echo $counter;?>">
                            <div class="choice_item_container" onclick="select_item(this,<?php echo $counter;?>,1)">
                              <div class="choice_item_left">
                                A
                              </div>
                              <div class="choice_item_right">
                                <?php echo $question->choice1;?>
                              </div>
                            </div>
                            <div class="choice_item_container" onclick="select_item(this,<?php echo $counter;?>,2)">
                              <div class="choice_item_left">
                                B
                              </div>
                              <div class="choice_item_right">
                                <?php echo $question->choice2;?>
                              </div>
                            </div>
                            <div class="choice_item_container" onclick="select_item(this,<?php echo $counter;?>,3)">
                              <div class="choice_item_left">
                                C
                              </div>
                              <div class="choice_item_right">
                                <?php echo $question->choice3;?>
                              </div>
                            </div>
                            <div class="choice_item_container" onclick="select_item(this,<?php echo $counter;?>,4)">
                              <div class="choice_item_left">
                                D
                              </div>
                              <div class="choice_item_right">
                                <?php echo $question->choice4;?>
                              </div>
                            </div>
                            <input type="hidden" name="question_<?php echo $counter;?>" value="5" id="question_<?php echo $counter;?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="question_ctr">
                    <?php
                      if($counter!=1)
                      {
                        echo '<input type="button" class="btn btn-default" value="上一题" onclick="prev_page()">&nbsp;';
                      }
                      if($counter!=10)
                      {
                        echo '<input type="button" class="btn btn-default" value="下一题" onclick="next_page()">';
                      }
                    ?>
                  </div>
                  <input type="hidden" name="question_id_<?php echo $counter;?>" value="<?php echo $question->id;?>">
                </div>
            <?php
                $counter++;
              }
            }
            ?>
          </div>
      </div>
      <div class="" id="answer_panel" style="float:left; width:200px; height:515px; text-align:center; padding:10px;">
          <input type="button" class="btn btn-default form-control" value="第1题" onclick="slide2page(0)">
          <input type="button" class="btn btn-default form-control" value="第2题" onclick="slide2page(1)">
          <input type="button" class="btn btn-default form-control" value="第3题" onclick="slide2page(2)">
          <input type="button" class="btn btn-default form-control" value="第4题" onclick="slide2page(3)">
          <input type="button" class="btn btn-default form-control" value="第5题" onclick="slide2page(4)">
          <input type="button" class="btn btn-default form-control" value="第6题" onclick="slide2page(5)">
          <input type="button" class="btn btn-default form-control" value="第7题" onclick="slide2page(6)">
          <input type="button" class="btn btn-default form-control" value="第8题" onclick="slide2page(7)">
          <input type="button" class="btn btn-default form-control" value="第9题" onclick="slide2page(8)">
          <input type="button" class="btn btn-default form-control" value="第10题" onclick="slide2page(9)">
          <input type="submit" class="btn btn-danger form-control" value="交卷">
          <!-- <span id="time" style="display:inline-block; margin-top:20px;"></span> -->
      </div>
      </form>
      <script type="text/javascript" src="js/cookie.js"></script>
      <script>
          answer_time = 10*40;
          answer_interval = "";
          $().ready(function(){
            $('#myCarousel').carousel('pause');
            // if(!get_cookie("answer_time"))
            // {
            set_cookie("answer_time",600)
            // }
            // else
            // {
            //   answer_time = get_cookie("answer_time");
            // }

            answer_interval = setInterval("count_time()",1000);

          });

          //计时
          function count_time()
          {
            answer_time--;
            set_cookie("answer_time",answer_time);
            if(answer_time<0)
            {
              alert("时间到，自动交卷");
              clearInterval(answer_interval);
              $("#answer_panel input").each(function(){
                if(!$(this).hasClass("active"))
                {
                  $(this).addClass("active");
                }
              });
              $("#kd_exam").submit();
              return;
            }
            var temp = answer_time;
            // var hours = Math.floor(temp/3600);
            // if(hours<10)
            // {
            //   hours = "0"+hours;
            // }
            // temp = temp%3600;
            var minutes = Math.floor(temp/60);
            if(minutes<10)
            {
              minutes = "0"+minutes;
            }
            temp = temp%60;
            var seconds = temp;
            if(seconds<10)
            {
              seconds = "0"+seconds;
            }
            // var time_string = hours+":"+minutes+":"+seconds;
            var time_string = minutes+":"+seconds;
            $("#time").html(time_string);
          }

          function prev_page()
          {
            $("#myCarousel").carousel('prev');
          }
          function next_page()
          {
            $("#myCarousel").carousel('next');
          }
          function slide2page(page)
          {
            $("#myCarousel").carousel(page);
          }
          function answer(id)
          {
            $("#answer_panel input:nth-child("+id+")").addClass("active");
          }
          function select_item(e,id,v)
          {
            //清除所有的active状态
            $(e).parent().find(".choice_item_container").each(function(){
              $(this).removeClass("active");
            });
            //选中当前项
            $(e).addClass("active");
            $("#question_"+id).val(v);
            answer(id);
          }
          function check()
          {
            var ret = false;
            var counter = 0;
            $("#answer_panel input").each(function(){
              if($(this).hasClass("active"))
              {
                counter++;
              }
            });
            if(counter>9)
            {
              clearInterval(answer_interval);
              ret = true;
            }
            else
            {
              alert("你还有题没答完噢");
            }
            return ret;
          }
          function show_text(){
            $("#text").fadeIn();
          }

          function hide_text(){
            $("#text").fadeOut();
          }
      </script>
      </div>
    </div>
    <?php
      include_once("footer.php");
    ?>

    <style media="screen">
      .note_cover{position:fixed; left:0; top:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index: 10000;}
      .note_container{width:800px; height:600px; overflow-x: hidden; overflow-y: scroll; border-radius:8px; box-shadow: 0 0 8px #ccc; padding:16px;}
      .note_container{position:absolute; left:50%; top:50%; margin-left: -400px; margin-top:-300px; background:#fff;}
      .mt10{margin-top:10px;}
      .bookdesc{
        padding:2em; line-height: 1.8em; text-align: left;
      }
    </style>

    <div class="note_cover" id="text" style="display:none;">
      <div class="note_container">
      <center>
        <p class="bookdesc">
          <?php echo $exam->get_text();?>
        </p>
        <input type="button" value="关闭" class="btn btn-default" onclick="hide_text()">
      </center>
      </div>
    </div>


  </body>
</html>
