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
      .item{height:565px; width: 600px;}
      .question_title{margin-left:30px; margin-top:40px; font-size: 16px; font-weight: bold;}
      .answers{margin-left: 30px; margin-top:20px;}
      .question_ctr{margin-left: 30px; margin-top:20px; text-align: center;}
      .btn{margin-bottom: 8px;}
    </style>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        include_once("class/exam.php");
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
    <!-- list start -->
    <div style="width:100%; height:565px;">
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
            setCookie("answer_time",0);
            $_COOKIE["answer_time"] = 0;
            $exam = new Exam($book);
            //获取得分情况
            $scores = $exam->scores($question_ids,$answers);
            //写入得分情况并返回测试结果ID
            $exam_result_id = $exam->write_scores($user_id,$book,$scores,$answer_time,$answers,$question_ids);
            //转到测试结果页
            header("Location:exam_report.php?exam=$exam_result_id");
        }
        else
        {
      ?>
      <form action="" method="post" onsubmit="return check();">
      <div id="myCarousel" class="carousel slide" style="width:599px; float:left; height:565px; border-right:1px solid #ccc;">
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner" style="height:565px;">
          <?php
            $exam = new Exam($book);
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
            if(!$questions[9])
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
            foreach($questions as $question)
            {
          ?>
              <div class="item <?php if($counter==1){echo "active";}?>">
                <div class="question_title">
                  第<?php echo $counter;?>题：<?php echo $question->question;?>
                </div>
                <div class="answers">
                  <label class="checkbox-inline">
                    <input type="radio" name="question_<?php echo $counter;?>" onclick="answer(<?php echo $counter;?>)" value="1">&nbsp;&nbsp;<?php echo $question->choice1;?>
                  </label><br><br>
                  <label class="checkbox-inline">
                    <input type="radio" name="question_<?php echo $counter;?>" onclick="answer(<?php echo $counter;?>)" value="2">&nbsp;&nbsp;<?php echo $question->choice2;?>
                  </label><br><br>
                  <label class="checkbox-inline">
                    <input type="radio" name="question_<?php echo $counter;?>" onclick="answer(<?php echo $counter;?>)" value="3">&nbsp;&nbsp;<?php echo $question->choice3;?>
                  </label><br><br>
                  <label class="checkbox-inline">
                    <input type="radio" name="question_<?php echo $counter;?>" onclick="answer(<?php echo $counter;?>)" value="4">&nbsp;&nbsp;<?php echo $question->choice4;?>
                  </label>
                </div>
                <div class="question_ctr">
                  <input type="button" class="btn btn-default" value="上一题" onclick="prev_page()">
                  <input type="button" class="btn btn-default" value="下一题" onclick="next_page()">
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
    <div class="" id="answer_panel" style="float:left; width:200px; height:565px; text-align:center; padding:10px;">
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
        <span id="time" style="display:inline-block; margin-top:20px;"></span>
    </div>
    </form>
    <script type="text/javascript" src="js/cookie.js"></script>
    <script>
        answer_time = 0;
        answer_interval = "";
        $().ready(function(){
          $('#myCarousel').carousel('pause');
          if(!get_cookie("answer_time"))
          {
              set_cookie("answer_time",0)
          }
          else
          {
            answer_time = get_cookie("answer_time");
          }
          answer_interval = setInterval("count_time()",1000);
        });

        //计时
        function count_time()
        {
          answer_time++;
          set_cookie("answer_time",answer_time);
          var temp = answer_time;
          var hours = Math.floor(temp/3600);
          if(hours<10)
          {
            hours = "0"+hours;
          }
          temp = temp%3600;
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
          var time_string = hours+":"+minutes+":"+seconds;
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
    </script>
    </div>
  </body>
</html>
