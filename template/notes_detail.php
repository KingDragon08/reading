<?php
  include_once("common.php");
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
    <title>乐智悦读-读书笔记</title>
  </head>
  <body>
    <!-- top nav start-->
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        include_once("../class/common.php");
        include_once("../class/book.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $com = new Common();
        $user_id = intval($_GET['user_id']);
        $book_id = intval($_GET['book_id']);
        if($user->get_user_info()->role=="教师")
        {
          if(!$user->check_is_student($user_id))
          {
            $com->tips("没有权限");
            exit();
          }
        }
        else
        {
          if($user_id!==intval($user->get_user_id()))
          {
            $com->tips("没有权限");
            exit();
          }
        }
        $book =  new Book($book_id);
        $questions = $book->get_book_note();
        $answers = $book->get_book_note_answers($user_id);
        if(count($questions)<1 || count($answers)<1 || count($questions)<>count($answers))
        {
          $com->tips("数据出错");
          exit();
        }
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <!-- top nav end -->
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">读书笔记详情</h4>
      <p style="float:right; margin-top:-45px; margin-right:14px; cursor:pointer;" onclick="history.go(-1);">点我返回</p>
    </center>

    <div class="note_container mt20">
      <?php
          for($i=0; $i<count($questions); $i++)
          {
      ?>
            <div class="col-lg-12 mb20" style="white-space:normal;">
              <?php echo ($i+1).":".$questions[$i]->question;?>
            </div>
            <div class="cl-lg-12 mb20">
              <textarea class="form-control" disabled='disabled' rows="6"><?php echo $answers[$i]->answer;?></textarea>
            </div>
      <?php
          }
      ?>
    </div>


  </body>
</html>
