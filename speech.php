<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/loading.css">
    <link rel="stylesheet" href="css/index.css" media="screen">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <title>乐智悦读-语音测评</title>
    <style media="screen">
      a{color:#555; margin-bottom: 6px; display: inline-block;}
      a:hover{color:#71cba4; text-decoration: none; cursor:pointer;}
      a.active{color:#71cba4;}
      .speech_container{height:210px; width:310px; margin:0 auto; margin-top:60px;}
      .speech_btn{width:60px; height:60px; border:1px solid #ccc; border-right: 0;
                  float:left; background: #f2f2f2; margin-bottom: 30px;
                  text-align: center; line-height: 60px; font-size: 20px; font-weight: bold;
                  cursor: pointer;
      }
      .speech_btn:hover,.speech_btn.active{ background: #71cba4; color:#fff;}
      .first{border-radius: 5px 0 0 5px;}
      .last{border-radius: 0 5px 5px 0; border-right: 1px solid #ccc;}
    </style>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:login.php");
        }
        else
        {
          include_once("class/speech.php");
          include_once("class/common.php");
          $user = $GLOBALS['user'];
          $role = $user->get_user_info()->role;
          $speech = new Speech();
          $common = new Common();
        }
      ?>
    <!-- top nav end -->
    <!-- main nav start -->
      <div class="container main-nav">
        <div class="brand">
            <img src="img/nav-brand.png" alt="">
        </div>
        <ul class="navigator">
          <li><a href="index.php">首页</a></li>
          <li><a href="full_reading.php">全本阅读</a></li>
          <li><a href="ing.php" class="active">语音朗读</a></li>
          <li><a href="report.php">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
            语音朗读
            <font style="font-size:12px; margin-left:24px;" id="corum"></font>
            <div class="float_right" id="ctr_btn" style="margin-right:5.8em;">
              <button class="btn btn-success <?php if(isset($_GET['type'])&&$_GET['type']=='zi'){echo 'active';}?>" style="margin-right:10px;" onclick="location.href='ing.php'">单字测评</button>
              <button class="btn btn-success <?php if(isset($_GET['type'])&&$_GET['type']=='ci'){echo 'active';}?>" style="margin-right:10px;" onclick="location.href='ing_c.php'">词语测评</button>
              <button class="btn btn-success <?php if(isset($_GET['type'])&&$_GET['type']=='ju'){echo 'active';}?>" onclick="location.href='ing_j.php'">短文测评</button>
            </div>
        </div>
     </div>
    <div class="container mt20 mb20">
      <?php
        $textbook = 0;
        $grade = 0;
        $unit = 0;
        $page = 0;
        $type = 0;
        if(isset($_GET['type']))
        {
          $type = $_GET['type'];
        }
        else
        {
            $common->tips("路径不合法");
            exit();
        }
        if(isset($_GET['textbook']))
        {
            $textbook = intval($_GET['textbook']);
        }
        else
        {
            $common->tips("路径不合法");
            exit();
        }
        if(isset($_GET['grade']))
        {
            $grade = intval($_GET['grade']);
        }
        else
        {
            $common->tips("路径不合法");
            exit();
        }
        if(isset($_GET['unit']))
        {
            $unit = intval($_GET['unit']);
        }
        else
        {
            $common->tips("路径不合法");
            exit();
        }
        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']);
        }
        else
        {
            $common->tips("路径不合法");
            exit();
        }
        if(!isset($_GET['speech_time']))
        {
            $common->tips("路径不合法");
            exit();
        }
        if($speech->check_path($textbook,$grade,$unit,$page) && ($type=='zi' || $type=='ci' || $type=='ju'))
        {
          $corum = $speech->get_path($textbook,$grade,$unit,$page);
      ?>
        <script type="text/javascript">
          $().ready(function(){
            $("#corum").html('<?php echo $corum;?>');
          });
        </script>
        <div style="width:800px; height:515px; margin:0 auto; box-shadow:0 0 5px #999; border-radius:5px;">
          <div class="col-lg-12 mt20">
            <img src="img/book_icon.png" alt="">
            跟读文本：<?php echo explode(">",$corum)[3];?>
          </div>


          <!-- 字开始 -->
          <?php
            if($type=='zi')
            {
              $words = $speech->get_test($type,$page);
              if(count($words))
              {
          ?>
                <div class="col-lg-12 mt20">
                  <div class="col-lg-8">
                    <div class="speech_container">
                      <?php
                          for($i=0; $i<count($words); $i++)
                          {
                      ?>
                            <div class="speech_btn <?php if($i%5==0){echo 'first';} if($i%5==4 || $i==count($words)-1){echo 'last';} ?>"
                                 data-toggle="tooltip" title="" onclick="choose(<?php echo $i.",'".$words[$i]->name."'";?>)"><?php echo $words[$i]->name;?></div>
                      <?php
                          }
                      ?>
                    </div>
                    <input type="hidden" name="selected_zi" value="">
                    <input type="hidden" name="selected_zi_id" value="">
                  </div>
                  <div class="col-lg-4" style="text-align:center; position:relative;">
                    <div style="font-size:24px; margin-top:140px;">
                      <span>得分：</span>
                      <span id="score">0</span>
                    </div>
                    <div class="btn btn-success" style="margin:0 auto; margin-top:20px;" id="a">
                      开始测试
                    </div>

                    <div id="canvas_wrapper" style="display:none">
                        <canvas id="volume" height="4"></canvas>
                    </div>

                    <p class="gray" style="margin-top:14px;">
                      点击右上角麦克风调试音频设备
                    </p>
                    <div class="btn btn-danger" style="margin:0 auto; margin-top:20px;" onclick="test_done()">
                      提交成绩
                    </div>
                    <div style="position:absolute; right:20px; top:40px;">
                      <img src="img/mic.png" alt="" style="cursor:pointer;" onclick="check_mic()">
                    </div>
                  </div>
                </div>
                <script type="text/javascript" src="js/pydic.js"></script>
                <script type="text/javascript" src="js/ise/fingerprint2.min.js"></script>
                <script type="text/javascript" src="js/ise/ise.all.js"></script>
                <script type="text/javascript" src="js/ise/test_zi.js"></script>
                <script type="text/javascript">
                  var scores = [];
                  var words = [];
                  $(function(){
                      //标注拼音
                      $(".speech_btn").each(function(){
                        var word = $(this).html();
                        scores.push(0);
                        words.push(word);
                        if(zi.indexOf(word))
                        {
                          $(this).attr("title",pinyin[zi.indexOf(word)]);
                        }
                      });
                      //鼠标经过显示拼音
                      $("[data-toggle='tooltip']").tooltip();

                  });

                  //选择单字
                  function choose(i,zi)
                  {
                      $(".speech_btn").each(function(index,val){
                        if(index==i)
                        {
                          $(this).addClass("active");
                          $("#score").html(scores[i]);
                        }
                        else
                        {
                          $(this).removeClass("active");
                        }
                      });
                      $("input[name='selected_zi']").val(zi);
                      $("input[name='selected_zi_id']").val(i);
                }

                //提交成绩
                function test_done()
                {
                  for(var i=0; i<scores.length; i++)
                  {
                    if(scores[i]==0)
                    {
                      alert("未完成测评,不能提交!");
                      return;
                    }
                  }
                  $("#loading").fadeIn();
                  $.ajax({
                    url:'controller/speech.php',
                    type:'post',
                    dataType:'json',
                    data:{scores:JSON.stringify(scores),sk:'<?php echo md5($user->get_user_id());?>',page:<?php echo $page;?>,size:<?php echo count($words);?>},
                    success:function(data){
                      alert("成绩提交成功");
                      location.href = "ing.php";
                    },
                    error:function(){
                      alert("网络不畅");
                    }
                  });
                }

                //检测麦克风是否可用
                function check_mic()
                {
                    navigator.getUserMedia = navigator.getUserMedia ||
                                    navigator.webkitGetUserMedia ||
                                    navigator.mozGetUserMedia ||
                                    navigator.msGetUserMedia;

                    if(navigator.getUserMedia)
                    {
                        alert("麦克风正常");
                    } else
                    {
                        alert("麦克风异常");
                    }
                }

                </script>
          <?php
              }
              else
              {
                $common->tips("暂时不支持该测评");
                exit();
              }
          ?>
          <?php
            }
          ?>
          <!-- 字结束 -->




        </div>
      <?php
        }
        else
        {
          $common->tips("路径不合法");
          exit();
        }
      ?>
    </div>
    <!-- forgetend -->
    <?php
      include_once("footer.php");
    ?>
    <style media="screen">
      .tips_cover{position:fixed; left:0; right:0; top:0; bottom:0; background:rgba(0,0,0,0.5); z-index: 1000;}
      .tips{width:560px; height:400px; position:fixed;
            left:50%; top:50%; margin-left:-280px; margin-top:-200px;
            background:#fff; border-radius: 5px;
      }
    </style>
    <div class="tips_cover" id="tips_cover">
      <div class="tips">
        <div class="mt20" style="width:560px; text-align:center; font-size:18px; color:#824399;">测试注意事项</div>
        <div style="padding:30px;">
          <h5>为保证您的测试顺利进行,确保测试结果的准确性,请确认：</h5><br>
          <p class="gray">（1）保持测试现场相对比较安静，避免环境噪声的干扰</p>
          <p class="gray">（2）正确佩戴麦克风，在测试过程中不要随意调整麦克风</p>
          <p class="gray">（3）按照计算机提示进行操作</p>
          <p class="gray">（4）在正式开始测试时，请不要说与试题内容无关的话，注意试卷内容应该<br>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          横向朗读，避免错行，漏行</p>
        </div>
        <div class="mt20" style="text-align:center;">
          <span class="btn btn-success active" onclick="$('#tips_cover').fadeOut();">我已经准备好了</span>
          <span class="btn btn-success">我还未准备好</span>
        </div>
      </div>
    </div>

    <div class="tips_cover" id="loading" style="display:none;">
      <div class="loading">
           <span></span>
           <span></span>
           <span></span>
           <span></span>
           <span></span>
      </div>
    </div>


  </body>
</html>