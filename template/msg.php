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
    <title>乐智悦读-未读消息</title>
    <style>
    #mail tr td{
      font-size:14px; color:#666;
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
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $max_page = $user->get_msg_max_page();
        $msg = $user->get_msg($page);
        //处理标记为已读
        if(isset($_POST['ids']))
        {
          $ids = $_POST['ids'];
          if(strlen($ids)>0)
          {
            $user->mark_msg_read($ids);
            $msg = $user->get_msg($page);
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
      <h4 style="line-height:50px;">我的信息</h4>
    </center>
    <div class="" style="width:100%; margin:0 auto;">
      <table width="100%" height="autp" border="0" class="table table-hover" style="margin-bottom:0;">
        <tr>
          <td width="5%">
            <input type="checkbox" id="ctr" name="" value="" onchange="select_all()">
          </td>
          <td width="5%"></td>
          <td width="10%">
            <a href="javascript:;" onclick="mark_read()">标为已读</a>
          </td>
          <td width="60%"></td>
          <td width="20%"></td>
        </tr>
      </table>
      <table width="100%" height="autp" border="0" id="mail" class="table table-hover">
        <?php
          foreach($msg as $val)
          {
        ?>
          <tr style="cursor:pointer;" onclick="view_msg('<?php echo $val->id;?>')">
            <td width="5%">
              <input type="checkbox" name="" data-id="<?php echo $val->id;?>">
            </td>
            <td width="5%">
              <?php
                if($val->msg_status==0)
                {
                  echo "<i class='glyphicon glyphicon-map-marker' style='color:#d9534f;'></i>";
                }
              ?>
            </td>
            <td width="10%">
              <?php echo $val->msg_from;?>
            </td>
            <td width="60%">
                <?php echo $val->msg_title;?>
            </td>
            <td width="20%">
              <?php echo $val->sendtime;?>
            </td>
          </tr>
        <?php
          }
        ?>
      </table>
    </div>
    <form class="" action="" method="post" id="f">
      <input type="hidden" name="ids" id="ids" value="">
    </form>
    <ul class="pagination" style="float:right;">
        <li><a href="msg.php?page=1">&laquo;</a></li>
        <?php
          $i=1;
          while($i <= $max_page)
          {
            if($i == $page)
            {
              echo '<li class="active"><a href="msg.php?page='. $i .'">'. $i .'</a></li>';
            }
            else
            {
              echo '<li><a href="msg.php?page='. $i .'">'. $i .'</a></li>';
            }
            $i++;
          }
        ?>
        <li><a href="msg.php?page=<?php echo $max_page;?>">&raquo;</a></li>
    </ul>
  </body>
  <script type="text/javascript">
    //全选与全不选
    function select_all()
    {
      if($("#ctr").is(':checked'))//选中
      {
        $("#mail input[type='checkbox']").each(function(){
          $(this).prop({"checked":true});
        });
      }
      else//取消选中
      {
        $("#mail input[type='checkbox']").each(function(){
          $(this).prop({"checked":false});
        });
      }
    }

    //标记消息为已读
    function mark_read()
    {
      var ids = "";
      $("#mail input[type='checkbox']").each(function(){
        if($(this).is(":checked"))
        {
          ids += $(this).attr("data-id");
          ids += ';';
        }
      });
      if(ids.length > 0)
      {
        $("#ids").val(ids);
        $("#f").submit();
      }
      else
      {
          alert("至少选中一个进行标记");
      }
    }

    //查看消息详情
    function view_msg(id)
    {
      location.href="msg_detail.php?id="+id;
    }

  </script>
</html>
