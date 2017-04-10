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
        if($id<1)
        {
          $id=1;
        }
        $msg = $user->get_msg_detail($id);
        //处理回复信息表单
        if(isset($_POST['reply']))
        {
          $reply = $_POST['reply'];
          if(strlen($reply)>0 || strlen($reply)<2000)
          {
            $user->reply_msg($msg->id,$msg->msg_title,$reply);
            echo "<script>alert('回复成功');location.href='msg.php'</script>";
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
      <h4 style="line-height:50px;">信息详情</h4>
    </center>
    <div class="" style="width:100%;">
      <?php
        if($msg)
        {
      ?>
        <table class="table table-striped">
          <tr>
            <td width="10%">来源</td>
            <td width="90%"><?php echo $msg->msg_from;?></td>
          </tr>
          <tr>
            <td>时间</td>
            <td><?php echo $msg->sendtime;?></td>
          </tr>
          <tr>
            <td>主题</td>
            <td><?php echo $msg->msg_title;?></td>
          </tr>
          <tr>
            <td>内容</td>
            <td style="word-break:break-all;"><?php echo $msg->msg_content;?></td>
          </tr>
          <?php
            if($msg->msg_type<>4)
            {
          ?>
          <tr>
            <td>回复</td>
            <td>
              <form class="" action="" id="reply" method="post">
                  <textarea class="form-control" id="msg" name="reply" rows="8" style="resize:none;"></textarea>
              </form>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">
              <button type="button" name="submit" class="btn btn-success" onclick="check_reply()">
                <i class="glyphicon glyphicon-send">&nbsp;</i>回复
              </button>
            </td>
          </tr>
          <?php
            }
          ?>
        </table>
      <?php
        }
        else
        {
          echo "该消息不存在或你没有访问权限";
        }
      ?>
    </div>

  </body>
  <script type="text/javascript">
    function check_reply()
    {
      var msg = $("#msg").val();
      if(msg.length<1 || msg.length>2000)
      {
        alert("回复内容应在1-2000字之间");
      }
      else
      {
        $("#reply").submit();
      }
    }
  </script>
</html>
