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
          include_once("class/common.php");
          $user = new User($_SESSION['username'],$_SESSION['password']);
          $user_info = $user->get_user_info();
          $school_students_count = $user->get_school_students_count();
          $role = $user_info->role;
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
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="report.php" class="active">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          测评中心
          <div class="float_right" id="ctr_btn" style="margin-right:5.8em;">
            <button class="btn btn-success active">全校能力值范围</button>
            <button class="btn btn-success" onclick="location.href='report_class.php'">全班能力值范围</button>
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
                  if($school_students_count)
                  {
                      echo 829*round(($school_students_count-$user->get_user_school_rank()-1)/($school_students_count-1),2)-4;
                      echo "px;";
                  }
                  else
                  {
                    echo 0;
                  }?>">
              <img src="img/biaochi.png" alt="">
              <div style="width:100%; height:30px; line-height:30px; text-align:center; font-size:16px; margin-top:10px;">
                全校能力值范围
              </div>
              <span style="float:right; margin-right:6em; font-size:14px; color:#999; margin-top:-22px;">
                共：<?php echo $school_students_count;?>人
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
                    data : ['细节认知','信息提取','意义建构','直接推论','批判思考']
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
                        if($school_students_count)
                        {
                          $score_percent_by_item = $user->get_score_percent_by_item_school();
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
        <script type="text/javascript">
          $("#ctr_btn").remove();
        </script>
        <div class="container mt20 mb20">
          查看个人报表:&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
            $classes = $user->get_classes();
            if(count($classes))
            {
              foreach($classes as $class)
              {
          ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><?php echo $class->classname;?></button>
                    <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">选择</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                          <?php
                            $students = $user->get_students_by_class($class->id);
                            if($students)
                            {
                              foreach($students as $student)
                              {
                          ?>
                                <li><a href="report_single.php?id=<?php echo $student->id;?>" target="_blank"><?php echo $student->name;?></a></li>
                          <?php
                              }
                            }
                          ?>
                    </ul>
                </div>
          <?php
              }
            }
          ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;查看班级报表:&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
            if(count($classes))
            {
          ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default">选择班级</button>
                    <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">选择</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <?php
                      foreach($classes as $class)
                      {
                      ?>
                        <li><a href="report.php?class=<?php echo $class->id;?>"><?php echo $class->classname;?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                </div>
          <?php
            }
          ?>
        </div>

        <div class="container mt20 mb20">
          <?php
            $class_id = isset($_GET['class'])?intval($_GET['class']):-1;
            if($class_id>0)
            {
              //检查该class_id是否属于当前登录教师
              if(!$user->check_class($class_id))
              {
                $common->tips("没有该班级的访问权限");
                exit();
              }
            }
            else
            {
              if($class_id==-1)//没有设置class参数的情况
              {
                if(count($classes)>0)
                {
                  $class_id = $classes[0]->id;
                }
                else
                {
                  $common->tips("名下没有班级,去个人中心创建一个吧!");
                  exit();
                }
              }
              else
              {
                $common->tips("非法的参数");
                exit();
              }
            }
            //开始以班级为单位画图
          ?>
          <script type="text/javascript" src='js/echarts-all.js'></script>
          <div class="col-lg-8" id="graph1" style="height:400px; padding:0;">
            <?php
              $class_score = "";
              if($user->get_class_students_count()>0)
              {
                $class_score = $user->get_class_report_score_1($class_id);
              }
            ?>
            <script type="text/javascript">
                var myChart_1 = echarts.init(document.getElementById('graph1'),'default');
                var option_1 = {
                title:{
                  text:"总平均分:<?php echo $class_score->avg_score;?>"
                },
                tooltip : {
                    trigger: 'axis'
                },
                toolbox: {
                    show : false,
                    feature : {
                        dataView : {show: true, readOnly: false},
                        saveAsImage : {show: true}
                    },
                    orient:'vertical'
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'value'//,
                        // min:0,
                        // max:100
                    }
                ],
                yAxis : [
                    {
                      type : 'category',
                      data : ['细节认知','信息提取','意义建构','直接推论','批判思考']
                    }
                ],
                series : [
                    {
                        type:'bar',
                        barCategoryGap:'50%',
                        data:[<?php
                            if(count($class_score)>0)
                            {
                              echo $class_score->item1.','.$class_score->item2.','.$class_score->item3.','
                                  .$class_score->item4.','.$class_score->item5;
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
            </script>
          </div>
          <div class="col-lg-4" style="height:400px;">
            <div class="row" id="graph2" style="height:50%; line-height:200px; text-align:center;">
            <?php
              $pie_data = "";
              if($user->get_students_by_class($class_id))
              {
                $pie_data = $user->get_class_report_score_2($class_id);
                if(count($pie_data)>0)
                {
            ?>
                  <script type="text/javascript">
                      var myChart_2 = echarts.init(document.getElementById('graph2'),'default');
                      var option_2 = {
                          tooltip : {
                              trigger: 'item',
                              formatter: "{b} : {c} ({d}%)"
                          },
                          legend: {
                              orient: 'horizontal',
                              left: 'right',
                              data: [<?php
                                    $out_string = '';
                                    $s_string = '';
                                    foreach($pie_data as $item)
                                    {
                                      if($item->num>0)
                                      {
                                          $out_string .= "'".$item->name."'";
                                          $out_string .= ',';
                                          $s_string .= "{value:$item->num,name:'$item->name'},";
                                      }
                                    }
                                    $out_string = substr($out_string,0,-1);
                                    $s_string = substr($s_string,0,-1);
                                    echo $out_string;
                              ?>]
                          },
                          series : [
                              {
                                  name: '读书类别',
                                  type: 'pie',
                                  radius : '80%',
                                  center: ['50%', '60%'],
                                  data:[<?php echo $s_string;?>],
                                  itemStyle: {
                                      emphasis: {
                                          shadowBlur: 10,
                                          shadowOffsetX: 0,
                                          shadowColor: 'rgba(0, 0, 0, 0.5)'
                                      }
                                  }
                              }
                          ]
                      };
                    myChart_2.setOption(option_2);
                  </script>
            <?php
                }
                else
                {
                  echo "还没有学生完成测评";
                }
              }
              else
              {
                echo "班内没有学生";
              }
            ?>
            </div>
            <div class="row" id="graph3" style="height:50%; line-height:200px; text-align:center; margin-top:20px;">
              <?php
              $raddar_data = "";
              if($user->get_students_by_class($class_id))
              {
                $raddar_data = $user->get_class_report_score_3($class_id);
                $max = -1;
                foreach($raddar_data as $data)
                {
                  if($data>$max)
                  {
                    $max = $data;
                  }
                }
                if($max > 0)
                {
              ?>
                <script type="text/javascript">
                var myChart_3 = echarts.init(document.getElementById('graph3'),'default');
                var option_3 = {
                      tooltip : {
                          trigger: 'axis'
                      },
                      polar : [
                         {
                             radius:80,
                             indicator : [
                                 { text: '10级',max:<?php echo $max;?>},
                                 { text: '9级',max:<?php echo $max;?>},
                                 { text: '8级',max:<?php echo $max;?>},
                                 { text: '7级',max:<?php echo $max;?>},
                                 { text: '6级',max:<?php echo $max;?>},
                                 { text: '5级',max:<?php echo $max;?>},
                                 { text: '4级',max:<?php echo $max;?>},
                                 { text: '3级',max:<?php echo $max;?>},
                                 { text: '2级',max:<?php echo $max;?>},
                                 { text: '1级',max:<?php echo $max;?>}
                              ]
                          }
                      ],
                      calculable : true,
                      series : [
                          {
                              name: '难度等级',
                              type: 'radar',
                              data : [
                                  {
                                      value : [<?php
                                        echo $raddar_data[9].','.$raddar_data[8].','.$raddar_data[7].','.$raddar_data[6]
                                              .','.$raddar_data[5].','.$raddar_data[4].','.$raddar_data[3].','
                                              .$raddar_data[2].','.$raddar_data[2].','.$raddar_data[0];
                                      ?>],
                                      name : '难度等级'
                                  }
                              ]
                          }
                      ]
                  };

                  myChart_3.setOption(option_3);
                </script>
              <?php
                }
                else
                {
                  echo "暂无数据";
                }
              }
              else
              {
                echo "班内没有学生";
              }
              ?>
            </div>
          </div>
        </div>

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
