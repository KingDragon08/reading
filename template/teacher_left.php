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
    <title>乐智悦读-菜单</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
    ?>
        <br>
          <center id="headimg">
            <div class="img-circle home_headimg" style="background-image:url('<?php echo $user->get_user_info()->headimg; ?>');">
              <span id="progress" style="width:150px; heihgt:150px; text-align:center; line-height:150px; color:#fff; display:none;">100%</span>
            </div>
          </center>
        <br>
        <p class="pcenter">
          <?php echo $user->get_user_info()->role .':'. $user->get_user_info()->name;?>
        </p>
        <ul class="list-group">
            <a href="../template/teacher_right.php" target="main" class="list-group-item active">基本资料</a>
            <a href="../template/teacher_school.php" target="main" class="list-group-item">学校信息</a>
            <a href="../template/msg.php" target="main" class="list-group-item">
                <span class="badge"><?php echo $user->get_unread_msg_number();?></span>
                未读消息
            </a>
            <a href="../template/teacher_students.php" target="main" class="list-group-item">我的学生</a>
            <a href="../template/teacher_notes.php" target="main" class="list-group-item">读书笔记</a>
            <!-- <a href="../template/teacher_chinese_score.php" target="main" class="list-group-item">语文成绩</a> -->
            <!-- <a href="../template/student_eval_school.php" target="main" class="list-group-item">测评结果</a> -->
            <!-- <a href="../template/student_book_shelf.php" target="main" class="list-group-item">我的书架</a> -->
            <!-- <a href="#" target="main" class="list-group-item">读书笔记</a> -->
            <!-- <a href="#" target="main" class="list-group-item">我的提问</a> -->
        </ul>
    <?php
      }
    ?>
  </body>
  <script type="text/javascript" src="../js/webuploader/webuploader.js"></script>
  <script type="text/javascript">
    //点击菜单项时动态改变菜单的高亮状态
    $("a").each(function(){
      $(this).click(function(){
        if($(this).hasClass("active"))
        {

        }
        else
        {
          $("a").each(function(){
            if($(this).hasClass("active"))
            {
              $(this).removeClass("active");
            }
          });
          $(this).addClass("active");
        }
      });
    });
    //头像更改
    var uploader = WebUploader.create({
        auto: true,
        swf: '../js/webuploader/Uploader.swf',
        server: '../controller/fileupload.php',
        pick: '#headimg',
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    //上传过程中
    uploader.on( 'uploadProgress', function( file, percentage ) {
        //alert(percentage);
        $("#progress").css("display","");
        $("#progress").html(percentage*100+"%");
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ) {
        // console.log(file);
        //alert("success");
        $("#progress").css("display","none");
        parent.location.reload();
    });

    // 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        //alert("error");
        //console.log(file);
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        //alert("complete");
    });
  </script>
</html>
