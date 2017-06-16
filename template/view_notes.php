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
    <style media="screen">
      .classmate{
        width:120px; height:120px;
        background-size:cover; background-position:center center;
        margin:6px auto;
      }
      .classmate_button{
        margin:0 auto; display: block;
      }
    </style>
  </head>
  <body>
    <!-- top nav start-->
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        include_once("../class/common.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $com = new Common();
        $type = $_GET['type'];
        if($type=="teacher")
        {
          $id=intval($_GET['id']);
          if($user->check_is_student($id))
          {
            $notes = $user->get_notes($id);
          }
          else
          {
            $com->tips("没有权限");
            exit();
          }
        }
        if($type=="self")
        {
          $id = $user->get_user_id();
          $notes = $user->get_notes($id);
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
      <h4 style="line-height:50px;">读书笔记</h4>
      <p style="float:right; margin-top:-45px; margin-right:14px; cursor:pointer;" onclick="history.go(-1);">点我返回</p>
    </center>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php
        if($notes)
        {
          foreach($notes as $note)
          {
    ?>
            <div class="col-ls-3 col-md-3 col-sm-3 col-xs-3" style="margin-top:12px;">
              <div class="img-responsive classmate" style="background-image:url('<?php echo $note->coverimg;?>')"></div>
              <p style="text-align:center;"><?php echo $note->name;?></p>
              <button type="button" class="btn btn-success classmate_button" name="button" onclick="notes_detail('<?php echo $note->id;?>',<?php echo $id;?>)">
                查看读书笔记
              </button>
            </div>
    <?php
        }
      }
      else
      {
        $com->tips("暂时没有读书笔记");
      }
   ?>
    </div>
    <script type="text/javascript">
      function notes_detail(book_id,user_id)
      {
        id = parseInt(book_id);
        location.href = "notes_detail.php?book_id="+book_id+"&user_id="+user_id;
      }
    </script>
  </body>
</html>
