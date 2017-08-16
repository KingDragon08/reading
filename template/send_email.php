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
    <title>乐智悦读-消息详情</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $id =  isset($_GET['id']) ? intval($_GET['id']):1;
        $role = $user->user_info->role;
        if($id<1)
        {
          $id=1;
        }
        $name = isset($_GET['name']) ?  $_GET['name']:'新手';
        $name = str_replace("<","_",$name);
        $name = str_replace("&lt;","_",$name);
        //处理发送事件
        if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content']))
        {
          $id = $_POST['id'];
          $title = $_POST['title'];
          $content = $_POST['content'];
          $result = $user->send_email($id,$title,$content);
          if($result['error'] == 0)
          {
            if($role=="学生"){
              echo '<script>alert("发送成功");location.href="classmate.php"</script>';
            }
            else{
              echo '<script>alert("发送成功");location.href="teacher_students.php"</script>';
            }
          }
          else
          {
            echo '<script>alert("发送失败:'. $result['msg'] .'");"</script>';
          }
        }
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">发送邮件</h4>
    </center>
    <div class="" style="width:100%;">
      <form class="" action="" id="send_email" method="post" onsubmit="return check_email();">
        <table class="table table-striped">
          <tr>
            <td width="10%">接收者</td>
            <td width="90%"><?php echo $name;?></td>
          </tr>
          <tr>
            <td>主题</td>
            <td>
              <input type="text" name="title" id="title" value="" placeholder="邮件主题" class="form-control">
            </td>
          </tr>
          <tr>
            <td>内容</td>
            <td>
                <textarea class="form-control" id="content" name="content" rows="12" placeholder="邮件征文在1-2000个字之间" style="resize:none;"></textarea>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">
              <button type="submit" name="submit" class="btn btn-success">
                <i class="glyphicon glyphicon-send">&nbsp;</i>发送
              </button>
            </td>
          </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo $id;?>">
      </form>
    </div>

  </body>
  <script type="text/javascript">
    function check_email()
    {
      var title = $("#title").val();
      var content = $("#content").val();
      if(title.length<1 || title.length>50)
      {
        alert("主题长度应在1-50字之间");
        return false;
      }
      if(content.length<1 || content.length>2000)
      {
        alert("正文长度应在1-2000字之间");
        return false;
      }
      return true;
    }
  </script>
</html>
