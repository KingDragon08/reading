<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css" media="screen">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <title>乐智悦读-测评中心</title>
  </head>
  <body>
    <!-- top nav start-->
    <?php
      include_once("top.php");
      if(!isLogin())//如果没有登录则跳转到首页
      {
        header("Location:index.php");
      }
      else
      {
        include_once("ezSQL/init.php");
        include_once("class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $user_info = $user->get_user_info();
        $class_students_count = $user->get_class_students_count();
        $role = $user_info->role;
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
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="report.php" class="active">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          测评中心
          <div class="float_right" style="margin-right:5.8em;">
            <button class="btn btn-success" onclick="location.href='report.php'">全校能力值范围</button>
            <button class="btn btn-success active">全班能力值范围</button>
          </div>
        </div>
      </div>
      <br>
      <div class="container">
        <?php
          if($role == "学生")
          {
        ?>
        <!-- 学生开始 -->
          <div class="col-lg-6" style="height:300px;" id="graph1"></div>
          <div class="col-lg-2" style="height:300px; padding:5px;">
            <img src="img/rabbit.png" alt="" class="img-responsive" style="margin-top:80px;">
          </div>
          <div class="col-lg-4" style="height:300px;" id="graph2"></div>
          <div class="col-lg-12" style="margin-top:30px; margin-bottom:20px;" id="">
            <div style="width:847px; margin:0 auto;">
              <img src="img/luobo.png" alt="" style="margin-left:<?php
                  if($class_students_count)
                  {
                      echo 829*round(($class_students_count-$user->get_user_class_rank())/$class_students_count,2)-4;
                      echo "px;";
                  }
                  else
                  {
                    echo 0;
                  }?>">
              <img src="img/biaochi.png" alt="">
              <div style="width:100%; height:30px; line-height:30px; text-align:center; font-size:16px; margin-top:10px;">
                全班能力值范围
              </div>
              <span style="float:right; margin-right:6em; font-size:14px; color:#999; margin-top:-22px;">
                共：<?php echo $class_students_count;?>人
              </span>
            </div>
          </div>
          <script type="text/javascript" src="js/echarts-all.js"></script>
          <script type="text/javascript">
            //第一个图
            var myChart_1 = echarts.init(document.getElementById('graph1'),'default');
            var option_1 = {
            title : {
                text: '<?php echo $user_info->name?>的阅读－图书项测评结果'
            },
            tooltip : {
                trigger: 'axis'
            },
            toolbox: {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : ['细节认知','信息提取','意义建构','直接推论','组织概括']
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    min:0,
                    max:100
                }
            ],
            series : [
                {
                    type:'bar',
                    barCategoryGap:'50%',
                    data:[<?php
                        if($class_students_count)
                        {
                          $score_percent_by_item = $user->get_score_percent_by_item_class();
                          $out_string = "";
                          foreach($score_percent_by_item as $score)
                          {
                              $out_string .= $score;
                              $out_string .= ',';
                          }
                          $out_string = substr($out_string,0,-1);
                          echo $out_string;
                        }
                        else
                        {
                          echo "0,0,0,0,0";
                        }
                    ?>]
                }
            ]
          };
          myChart_1.setOption(option_1);

          //第二个图
          var myChart_2 = echarts.init(document.getElementById('graph2'),'default');
          var option_2 = {
          title : {
              text: '<?php echo $user_info->name?>的普通话测评结果'
          },
          tooltip : {
              trigger: 'axis'
          },
          toolbox: {
              show : true,
              feature : {
                  dataView : {show: true, readOnly: false},
                  saveAsImage : {show: true}
              }
          },
          calculable : true,
          xAxis : [
              {
                type : 'category',
                data : ['单字','词语','短文']
              }
          ],
          yAxis : [
              {
                type : 'value',
                min:0,
                max:100
              }
          ],
          series : [
              {
                  type:'bar',
                  barCategoryGap:'50%',
                  data:[79, 73,75]
              }
          ]
          };
          myChart_2.setOption(option_2);
          </script>

        <!-- 学生结束 -->
        <?php
          }
          else
          {
        ?>
        <!-- 教师开始 -->
        <h4>我是教师</h4>
        <!-- 教师结束 -->
        <?php
          }
        ?>
      </div>
      <br>
    <!-- forget panel end -->
    <?php
      include_once("footer.php")
    ?>
  </body>
  <script type="text/javascript">
    $().ready(function(){
      $("#menu").load(function () {
          var mainheight = $(this).contents().find("body").height() + 100;
          $(this).height(mainheight);
      });
      $("#main").load(function () {
          // var mainheight = $(this).contents().find("body").offsetHeight;
          // $(this).height(mainheight);
          var iframe = document.getElementById("main");
          var bHeight = iframe.contentWindow.document.body.scrollHeight;
          var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
          var height = Math.max(bHeight, dHeight);
          iframe.height = height;
      });
    });
  </script>
</html>
