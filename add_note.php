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
    <title>乐智悦读-读书笔记</title>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        include_once("class/book.php");
        include_once("class/common.php");
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
      <!-- main nav start -->
        <div class="container main-nav">
          <div class="brand">
              <img src="img/nav-brand.png" alt="">
          </div>
          <ul class="navigator">
            <li><a href="index.php">首页</a></li>
            <li><a href="full_reading.php" class="active">全本阅读</a></li>
            <li><a href="page_reading.php">短篇阅读</a></li>
            <li><a href="ing.php">语音朗读</a></li>
            <li><a href="＃">测评中心</a></li>
          </ul>
        </div>
      <!-- main nav end -->
      <!-- division panel start -->
        <div class="w100 forget">
          <div class="forget_cover">
            读书笔记
          </div>
        </div>
      <!-- division panel end -->
      <div class="container mt20">
          <?php
            $answers = [];
            for($i=1; $i<=$_POST['num']; $i++)
            {
              $answers[] = $_POST["question_$i"];
            }
            $book = intval($_POST['book']);
            //检查是否已经答过
            $book = new Book($book);
            $com = new Common();
            if($book->check_note($user_id))
            {
              $com->tips("读书笔记已经提交过一次了哟");
            }
            else
            {
              $book_id = $book->book_id;
              foreach($answers as $answer)
              {
                $sql = "insert into rd_read_note_answer(book_id,user_id,answer)values(".
                        "$book_id,$user_id,'".$db->escape($answer)."')";
                $db->query($sql);
              }
              //给老师发消息
              $sql = "select a.teacher_id from rd_class a left join rd_user b on a.id=b.class where b.id=$user_id";
              $teacher_id = $db->get_var($sql);
              //写入消息
              $sendtime = time();
              $title = $user->get_user_info()->name."完成了《".$book->get_book_info()->name."》的读书笔记";
              $content = $title.",快去看看吧!";
              $sql = "insert into rd_msg(msg_from,msg_to,msg_title,msg_content,sendtime,msg_type,msg_status)".
                      "values('$user_id','$teacher_id','". $db->escape($title) ."','". $db->escape($content) .
                      "','$sendtime','4','0')";
              $db->query($sql);
              $com->tips('读书笔记提交成功!3秒后跳转到“全部书单”图书列表');
          ?>
            <script type="text/javascript">
              var timeLeast = 2;
              setInterval(function(){
                if(timeLeast==0){
                  location.href="full_reading.php";
                } else {
                  document.getElementById("tips").innerHTML = "读书笔记提交成功!"+timeLeast+"秒后跳转到“全部书单”图书列表";
                }
                timeLeast--;
              },1000);
            </script>
          <?php
            }
          ?>
      </div>
      <?php
        include_once("footer.php");
      ?>
  </body>
</html>
