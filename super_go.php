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
    <title>乐智悦读-明星领读</title>
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
      .speech_btn_1{width:60px; height:60px; border:1px solid #ccc; border-right: 0;
                  float:left; background: #f2f2f2; margin-bottom: 30px;
                  text-align: center; line-height: 60px; font-size: 20px; font-weight: bold;
                  cursor: pointer;
      }
      .tips_cover_ci .speech_btn_1{font-size:14px; font-weight: normal; overflow: hidden;}
      #report .speech_btn_1:nth-child(2n){font-size:14px; font-weight: normal;}
      #report .speech_btn_1:hover{background:none; color:#333;}
      .speech_container_ci,.speech_container_ju{height:210px; width:90%; margin:0 auto; margin-top:50px;}
      .speech_btn:hover,.speech_btn.active,.speech_btn_ci:hover,.speech_btn_ci.active,.speech_btn_ju:hover{ background: #71cba4; color:#fff;}
      .speech_btn_ci{width:auto; height: 60px; line-height: 60px;
                      border:1px solid #ccc; border-radius: 5px;
                      float:left; background: #f2f2f2; margin-bottom: 20px; margin-right: 16px;
                      text-align: center; font-size: 20px; font-weight: bold;
                      cursor: pointer; padding:0 20px;
      }
      .speech_btn_ju{width:40px; height:40px; border:1px solid #ccc; border-right: 0;
                  float:left; background: #f2f2f2; margin-bottom: 10px;
                  text-align: center; line-height: 40px; font-size: 18px; font-weight: bold;
                  cursor: pointer;
      }

      .first{border-radius: 5px 0 0 5px;}
      .last{border-radius: 0 5px 5px 0; border-right: 1px solid #ccc;}
      .first.last{border-radius: 5px;}
      .listen{position:fixed; z-index: 9999; bottom:50px; width: 100px;
              height: 100px; right: 100px; border-radius: 99px;
              box-shadow: 0 0 20px #333; background-color:#fff; font-size: 120px;
              color: #71cba4; background-image: url('img/audio.png');
              background-size: 60%; background-repeat: no-repeat; 
              background-position: center center; cursor: pointer;
      }
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
          <li><a href="page_reading.php">短篇阅读</a></li>
          <li><a href="ing.php" class="active">语音朗读</a></li>
          <li><a href="report.php">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
            语音朗读
            <div class="float_right" id="ctr_btn" style="margin-right:5.8em;">
              <button class="btn btn-danger">明星领读</button>
            </div>
        </div>
     </div>

     <?php
     if($user->get_user_info()->can_speech==0)
     {
     ?>
     <center>
       <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
       <br>
       <p class="gray" id="tips">
         没有访问权限...
       </p>
     </center>
     <?php
       include("footer.php");
       exit();
     }
     ?>
     <div class="listen"></div>
    <div class="container mt20 mb20">
      <?php
        $textbook = 0;
        $grade = 0;
        $unit = 0;
        $page = 0;
        $type = 'du';
        if(isset($_GET['textbook']))
        {
            $textbook = intval($_GET['textbook']);
        }
        else
        {
            $common->tips("路径不合法2");
            exit();
        }
        if(isset($_GET['grade']))
        {
            $grade = intval($_GET['grade']);
        }
        else
        {
            $common->tips("路径不合法3");
            exit();
        }
        if(isset($_GET['unit']))
        {
            $unit = intval($_GET['unit']);
        }
        else
        {
            $common->tips("路径不合法4");
            exit();
        }
        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']);
        }
        else
        {
            $common->tips("路径不合法5");
            exit();
        }
        if(!isset($_GET['speech_time']))
        {
            $common->tips("路径不合法6");
            exit();
        }
        if($speech->check_path($textbook,$grade,$unit,$page))
        {
          $corum = $speech->get_path($type,$textbook,$grade,$unit,$page);
      ?>
        <script type="text/javascript">
          $().ready(function(){
            $("#corum").html('<?php echo $corum;?>');
          });
        </script>
        <div style="width:800px; height:565px; margin:0 auto; box-shadow:0 0 5px #999; border-radius:5px;">
          <div class="col-lg-12 mt20">
            <img src="img/book_icon.png" alt="">
            跟读文本：<?php if($type=='ju' || $type=='du'){echo explode(">",$corum)[3];}else{echo explode(">",$corum)[2];}?>
          </div>


          
          <?php
            if(1)
            {
              $words = $speech->get_test('du',$page);
              if(count($words))
              {
          ?>
          <style media="screen">
            .j_left_control{
              width:122px; height:auto; min-height: 60px; position: absolute;
              left:-202px; border:1px solid #e5e5e5; border-radius: 5px;
            }
            .j_left_control div{
              float:left;width:60px; height:60px; line-height: 60px; text-align: center;
              color:#333; font-size: 20px; font-weight: bold; border-bottom: 1px solid #e5e5e5;
              cursor: pointer;
            }
            .j_left_control div:nth-child(2n+1){
              border-right: 1px solid #e5e5e5;
            }
            .j_left_control div:hover,.j_left_control div.active{
              background:#71cba4; color:#fff;
            }
            .j_left_control div.ed{
              background:#aaa; color:#fff;
            }
            .boyin{width:75px; height: 100px; position: relative; cursor: pointer;
                float:left; margin-top: -40px; margin-right: 20px; color:#824399;
            }
            .boyin img{width: 75px; height: 100px;}
            .boyin .qrcode{position: absolute; top: -75px; width: 75px; height: 75px; display: none;}
            .boyin .qrcode img{width: 75px; height: 75px;}
            .boyin:hover .qrcode{display: block;}
          </style>
                <div class="col-lg-12 mt20">
                  <div class="col-lg-8">
                    <div class="j_left_control">
                      <?php
                      for($i=0; $i<count($words); $i++)
                      {
                      ?>
                        <div id="j_exam_<?php echo $i;?>" onclick="j_exam(<?php echo $i;?>)" class="j_exam_kd <?php if($i==0){echo "active";}?>"><?php echo ($i+1);?></div>
                      <?php
                      }
                      ?>
                    </div>
                    <script type="text/javascript">
                      function j_exam(page)
                      {
                        choose_ju(page);
                        $("#j_words_"+page).click();
                        $(".j_exam_kd").each(function(){
                          $(this).removeClass("active");
                        });
                        $("#j_exam_"+page).addClass("active");
                        $("#myCarousel").carousel(page);
                        $("#myCarousel").carousel("pause");
                      }
                    </script>


                    <div id="myCarousel" class="carousel slide">
                      <!-- 轮播（Carousel）项目 -->
                      <div class="carousel-inner">
                      <?php
                          //$words = explode(",",$words[0]->name);
                          // print_r($words);
                          for($i=0; $i<count($words); $i++)
                          {
                            if($i==0)
                            {
                                echo '<div class="speech_container_ju item active">';
                            }
                            else
                            {
                                echo '<div class="speech_container_ju item">';
                            }
                            echo "<input type=\"hidden\" id=\"words_".$i."\" value=\"".$words[$i]->name."\">";
                            echo "<input type=\"hidden\" id=\"url_".$i."\" value=\"".$words[$i]->url."\">";
                            if($i==0)
                            {
                              echo "<input type=\"radio\" name=\"ju\" id=\"j_words_$i\" onclick=\"choose_ju($i)\" checked=\"checked\" style=\"float:right; display:none;\"/>";
                            }
                            else
                            {
                              echo "<input type=\"radio\" name=\"ju\" id=\"j_words_$i\" onclick=\"choose_ju($i)\" style=\"float:right; display:none;\"/>";
                            }
                            preg_match_all("/./u",$words[$i]->name,$words[$i]);
                            for($j=0; $j<count($words[$i][0]); $j++)
                            {
                      ?>
                            <div class="speech_btn_ju <?php if($j%10==0){echo ' first';} if($j%10==9 || $j==count($words[$i][0])-1){echo ' last';} ?>"
                                 data-toggle="tooltip" title=""><?php echo $words[$i][0][$j];?></div>
                      <?php
                            }
                            echo "</div>";
                          }
                      ?>
                          <input type="hidden" name="selected_ju" id="selected_ju" value="0">
                          <input type="hidden" name="selected_url" id="selected_url" value="">
                    </div>
                  </div>
                  <script type="text/javascript">
                  $().ready(function(){
                    $('#myCarousel').carousel('pause');
                  });
                  </script>
                  </div>
                  <div class="col-lg-4" style="text-align:center; position:relative;">
                    <div style="position:absolute; right:20px; top:40px;">
                      <div class="boyin">
                        <img src="img/boyin.png">
                        点我关注
                        <div class="qrcode">
                          <img src="img/qrcode.png">
                        </div>
                      </div>
                      <i class="glyphicon glyphicon-bullhorn" onclick="play_xiaoyan()" style="font-size:20px; cursor:pointer; color:#71cba4;">&nbsp;</i>
                    </div>
                  </div>
                </div>
                <div class="tips_cover tips_cover_ci" id="report" style="display:none;">
                  <div style="width:510px; height:300px; overflow-y:scroll; padding:14px; box-shadow:0 0 5px #999; border-radius:5px; background:#f2f2f2; left:50%; top:50%; margin-left:-255px; margin-top:-150px; position:fixed;">
                  <?php
                      for($i=0; $i<count($words); $i++)
                      {
                  ?>
                        <div class="speech_btn_1 <?php if($i%4==0){echo 'first';} ?>">第<?php echo $i+1;?>句</div>
                        <div class="speech_btn_1 <?php if($i%4==3 || $i==count($words)-1){echo 'last';} ?>" id="report_<?php echo $i;?>"></div>
                  <?php
                      }
                  ?>
                    <audio id="myAudio" src=""></audio>
                  </div>
                </div>
                <script type="text/javascript" src="js/pydic.js"></script>
                <script type="text/javascript" src="js/ise/fingerprint2.min.js"></script>
                <script type="text/javascript" src="js/tts/fingerprint.js"></script>
                <script type="text/javascript">
                  var scores = [];
                  // var words = 0;
                  $(function(){
                      //初始化scores
                      for(var i=0; i<<?php echo count($words);?>; i++)
                      {
                        scores.push(0);
                      }
                      //标注拼音
                      $(".speech_btn_ju").each(function(){
                        var word = $(this).html().replace(/(^\s*)|(\s*$)/g, "");
                        // words.push(word);
                        if(zi.indexOf(word))
                        {
                          $(this).attr("title",pinyin[zi.indexOf(word)]);
                        }

                      });
                      //鼠标经过显示拼音
                      $("[data-toggle='tooltip']").tooltip();

                  });

                  //选择某一句进行测评
                  function choose_ju(id)
                  {
                    var val = $("#words_"+id).val();
                    $("#selected_ju").val(id);
                    $("#score").html(scores[id]);
                    var url = $("#url_"+id).val();
                    $("#selected_url").val(url);
                  }

                  function play_xiaoyan(){
                    var url = $("#selected_url").val();
                    if(url.length<1){
                      url = $("#url_0").val();
                    }
                    var x = document.getElementById("myAudio");
                    $("#myAudio").attr("src",url);
                    x.play();
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
                  var sum = 0;
                  for(var i=0; i<scores.length; i++)
                  {
                    $("#report_"+i).html(scores[i]);
                    sum += scores[i];
                  }
                  sum = sum/scores.length;
                  $("#report .label-info").html("平均分:"+sum.toFixed(3));
                  $("#report").fadeIn();
                }
                function go()
                {
                  
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
          <!-- 句结束 -->


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
  </body>
</html>
