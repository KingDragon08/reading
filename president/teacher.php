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
    <title>乐智悦读-教师</title>
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
        //$classmates = $user->get_classmates();
        $teachers = $user->get_teachers();
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">学校教师</h4>
    </center>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?php
        if(count($teachers)<1)
        {
          echo "没有老师在学校内";
          exit();
        }
        foreach($teachers as $teacher)
        {
      ?>
          <div class="col-ls-3 col-md-3 col-sm-3 col-xs-3" style="margin-top:12px;">
            <div class="img-responsive img-circle classmate" style="background-image:url('<?php echo $teacher->headimg;?>')"></div>
            <p style="text-align:center;"><?php echo $teacher->name;?></p>
            <a target="_blank" class="btn btn-success classmate_button" name="button" href="teacher_class.php?id=<?php echo $teacher->id;?>">
              查看详情
            </a>
          </div>
      <?php
        }
      ?>
    </div>

  </body>
</html>
