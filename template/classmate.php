<?php
  include_once("common.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css" media="screen">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <title>乐智悦读-同伴同学</title>
    <style media="screen">
      .classmate{
        border:1px solid #71cba4; width:120px; height:120px;
        background-size:cover; background-position:center center;
        margin:6px auto;
      }
      .classmate_button{
        margin:0 auto; display: block;
      }
    </style>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $classmates = $user->get_classmates();
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">同班同学</h4>
    </center>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?php
        if($classmates == "")
        {
          echo "尚未加入班级";
          exit();
        }
        foreach($classmates as $student)
        {
      ?>
          <div class="col-ls-3 col-md-3 col-sm-3 col-xs-3" style="margin-top:12px;">
            <div class="img-responsive img-circle classmate" style="background-image:url('<?php echo $student->headimg;?>')"></div>
            <p style="text-align:center;"><?php echo $student->name;?></p>
            <button type="button" class="btn btn-success classmate_button" name="button" onclick="send_email('<?php echo $student->id;?>','<?php echo $student->name;?>')">
              <i class="glyphicon glyphicon-send"></i>发送邮件
            </button>
          </div>
      <?php
        }
      ?>
    </div>

  </body>
  <script type="text/javascript">
    function send_email(id,name)
    {
      id = parseInt(id);
      location.href = "send_email.php?id=id&name="+name;
    }
  </script>
</html>
