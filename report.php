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
          header("Location:login.php");
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
                text: '<?php echo $user_info->name?>的阅读－图书项测评结果',
                subtext: '共读<?php $kd_data = $user->get_read_book_number_and_wordcount(); echo $kd_data['num']; ?>本  <?php echo $kd_data['wordcount']; ?>字'
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
                    data : ['细节认知','信息获取','直接推论','组织概括','批判思考']
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    min:0,
                    max:3
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
                  data:[<?php
                      if($school_students_count)
                      {
                        $score_percent_by_item = $user->get_speech_percent_by_item_school();
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
                        echo "0,0,0";
                      }
                  ?>]
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
                                <li><a href="report_single_school.php?id=<?php echo $student->id;?>" target="_blank"><?php echo $student->name;?></a></li>
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
            if(count($classes))
            {
          ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="list_class">选择班级</button>
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
                        if($class->id == $class_id)
                        {
                          echo "<script>$('#list_class').html('$class->classname');</script>";
                        }
                      }
                      ?>
                    </ul>
                </div>
          <?php
            }
          ?>
        </div>

        <div class="container mt20 mb20">
          <script type="text/javascript" src='js/echarts-all.js'></script>
          <div class="col-lg-8" id="graph1" style="height:400px; padding:0;">
            <?php
              $class_score = "";
              if($user->get_class_students_count_teacher($class_id)>0)
              {
                $class_score = $user->get_class_report_score_1($class_id);
              }
              else
              {
                $class_score->avg_score = 0;
                $class_score->item1 = 0;
                $class_score->item2 = 0;
                $class_score->item3 = 0;
                $class_score->item4 = 0;
                $class_score->item5 = 0;
              }
              $kd_nums = $user->get_students_read_num_and_wordcount($class_id);
            ?>
            <script type="text/javascript">
                var myChart_1 = echarts.init(document.getElementById('graph1'),'default');
                var option_1 = {
                title:{
                  text:"<?php echo "总平均分:".$class_score->avg_score."  共读".$kd_nums['num1']."本  ".$kd_nums['num2']."字";?>"
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
                      data : ['细节认知','信息获取','直接推论','组织概括','批判思考']
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
            <div class="row" id="graph2" style="height:50%; text-align:center;">
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
                                  radius : '60%',
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
            <div class="row" id="graph3" style="height:50%; text-align:center; margin-top:20px;">
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
                             radius:60,
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
                                              .$raddar_data[2].','.$raddar_data[1].','.$raddar_data[0];
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


        <div class="container mt20 mb20">

          <div class="col-lg-8" style="height:400px;">
            <div class="row" id="yuyin_graph2" style="height:280px; margin-top:60px; text-align:center;">
              <?php
                $students = $user->get_students_by_class($class_id);
                if($students)
                {
                  $speech_data = $user->get_class_report_score_5($class_id);
              ?>
              <script type="text/javascript">
              var myChart_yuyin_2 = echarts.init(document.getElementById('yuyin_graph2'),'default');
              var option_yuyin_2 = {
                tooltip : {
                    trigger: 'axis'
                },
                calculable : true,
                xAxis : [
                    {
                      type : 'category',
                      data : ['单字发音报告','词语发音报告','短文发音报告']
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
                        barCategoryGap:'80%',
                        data:[<?php
                          echo $speech_data[0].','.$speech_data[1].','.$speech_data[2];
                        ?>]
                    }
                ]
              };
              myChart_yuyin_2.setOption(option_yuyin_2);
              </script>
              <?php
                }
                else
                {
                  echo "班内没有学生";
                }
              ?>
            </div>
          </div>

          <div class="col-lg-4" id="yuyin_graph1" style="height:400px; padding:0;">
            <?php
              if($students)
              {
            ?>
            <script type="text/javascript">
              var myChart_yuyin_1 = echarts.init(document.getElementById('yuyin_graph1'),'default');
              var yuyin_option_1 = {
                tooltip : {
                    trigger: 'axis'
                },
                calculable : true,
                polar : [
                    {
                        indicator : [
                            {text : '单字', max  : 100},
                            {text : '词语', max  : 100},
                            {text : '短文', max  : 100}
                        ],
                        radius : 120
                    }
                ],
                series : [
                    {
                        name: '发音得分',
                        type: 'radar',
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
                        data : [
                            {
                                value : [<?php
                                  echo $speech_data[0].','.$speech_data[1].','.$speech_data[2];
                                ?>],
                                name : '发音得分'
                            }
                        ]
                    }
                ]
            };
            myChart_yuyin_1.setOption(yuyin_option_1);
            </script>
            <?php
              }
              else
              {
                echo "班内没有学生";
              }
            ?>
          </div>



        </div>





        <div class="container">
          <div class="col-lg-1">
            <button type="button" class="btn btn-success mb10" id='kd_btn1' onclick="kd_change(1)" style="margin-top:90px;">阅读数量</button>
            <button type="button" class="btn btn-default mb10" id='kd_btn2' onclick="kd_change(2)">阅读评分</button>
            <button type="button" class="btn btn-default mb10" id='kd_btn3' onclick="kd_change(3)">朗读评分</button>
          </div>
          <script type="text/javascript">
            $().ready(function(){
              $("#graph5_1").hide();
              $("#graph6").hide();
            });
            function kd_change(i)
            {
              if(i==1)
              {
                $("#kd_btn1").addClass("btn-success");
                $("#kd_btn1").removeClass("btn-default");
                $("#kd_btn2").removeClass("btn-success");
                $("#kd_btn2").addClass("btn-default");
                $("#kd_btn3").removeClass("btn-success");
                $("#kd_btn3").addClass("btn-default");
                $("#graph4").show();
                $("#graph5_1").hide();
                $("#graph6").hide();
              }
              if(i==2)
              {
                $("#kd_btn2").addClass("btn-success");
                $("#kd_btn2").removeClass("btn-default");
                $("#kd_btn1").removeClass("btn-success");
                $("#kd_btn1").addClass("btn-default");
                $("#kd_btn3").removeClass("btn-success");
                $("#kd_btn3").addClass("btn-default");
                $("#graph6").show();
                $("#graph4").hide();
                $("#graph5_1").hide();
              }
              if(i==3)
              {
                $("#kd_btn3").addClass("btn-success");
                $("#kd_btn3").removeClass("btn-default");
                $("#kd_btn2").removeClass("btn-success");
                $("#kd_btn2").addClass("btn-default");
                $("#kd_btn1").removeClass("btn-success");
                $("#kd_btn1").addClass("btn-default");
                $("#graph5_1").show();
                $("#graph6").hide();
                $("#graph4").hide();
              }
            }
          </script>
          <div class="col-lg-11" style="padding-right:0;">
            <div style="height:300px; width:100%;" id="graph4">
            <?php
              $yuedu_data = "";
              if($user->get_students_by_class($class_id))
              {
                  $yuedu_data = $user->get_class_report_score_4($class_id);
                  if($yuedu_data)
                  {
                    $x = "";
                    $y = "";
                    foreach($yuedu_data as $item)
                    {
                      $x .= "'".$item['name']."',";
                      $y .= "'". (intval($item['num'])) ."',";
                    }
                    $x = substr($x,0,-1);
                    $y = substr($y,0,-1);
            ?>
                  <script type="text/javascript">
                  var myChart_4 = echarts.init(document.getElementById('graph4'),'default');
                  var option_4 = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: [<?php echo $x;?>],
                        axisLabel:{
                          rotate:-90
                        }
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name:'阅读数量',
                            type:'line',
                            data:[<?php echo $y;?>]
                        }
                    ]
                  };
                  myChart_4.setOption(option_4);
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

              <!--阅读评分-->
              <div class="container" id="graph6" style="height:300px; width:100%; padding-right:1px;">
                <?php
                  $students = $user->get_students_by_class($class_id);
                  if($students)
                  {
                    $name_string = "";
                    $data_string = "";
                    foreach ($students as $student)
                    {
                      $name_string .= "'".$student->name."'";
                      $name_string .= ",";
                      $data_string .= $student->score;
                      $data_string .= ",";
                    }
                    $name_string = substr($name_string,0,-1);
                    $data_string = substr($data_string,0,-1);
                  ?>
                  <script type="text/javascript">
                  var myChart_6 = echarts.init(document.getElementById('graph6'),'default');
                  var option_6 = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: [<?php echo $name_string;?>],
                        axisLabel:{
                          rotate:-90
                        }
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name:'阅读评分',
                            type:'line',
                            data:[<?php echo $data_string;?>]
                        }
                    ]
                  };
                  myChart_6.setOption(option_6);
                  </script>
                  <?php
                  }
                  else
                  {
                    echo "班内没有学生";
                  }
                ?>
              </div>





              <div class="container" style="height:300px; width:100%; padding-right:0;" id="graph5_1">
                <?php
                  $data_1 = $user->get_class_report_score_5_1($class_id);
                  $data_2 = $user->get_class_report_score_5_2($class_id);
                  $data_3 = $user->get_class_report_score_5_3($class_id);
                  $students = $data_1[0];
                  $scores_1 = $data_1[1];
                  $scores_2 = $data_2[1];
                  $scores_3 = $data_3[1];
                  $name_string = "";
                  $data_string_1 = "";
                  if($students)
                  {
                    for($i=0; $i<count($students); $i++)
                    {
                      $name_string .= "'".$students[$i]->name."'";
                      $name_string .= ",";
                      $data_string_1 .= $scores_1[$i]->average;
                      $data_string_1 .= ",";
                      $data_string_2 .= $scores_2[$i]->average;
                      $data_string_2 .= ",";
                      $data_string_3 .= $scores_3[$i]->average;
                      $data_string_3 .= ",";
                    }
                    $name_string = substr($name_string,0,-1);
                    $data_string_1 = substr($data_string_1,0,-1);
                    $data_string_2 = substr($data_string_2,0,-1);
                    $data_string_3 = substr($data_string_3,0,-1);
                  }
                  else
                  {
                      $name_string = "无";
                      $data_string = "0";
                  }
                ?>
              <script type="text/javascript">
              var myChart_5_1 = echarts.init(document.getElementById('graph5_1'),'default');
              var option_5_1 = {
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:['单字','词语','短文']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: [<?php echo $name_string;?>]
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name:'单字',
                        type:'line',
                        data:[<?php echo $data_string_1;?>]
                    },
                    {
                        name:'词语',
                        type:'line',
                        data:[<?php echo $data_string_2;?>]
                    },
                    {
                        name:'短文',
                        type:'line',
                        data:[<?php echo $data_string_3;?>]
                    }
                ]
              };
              myChart_5_1.setOption(option_5_1);
              </script>
            </div>
          </div>
        </div>

      <script type="text/javascript">
        var myChart_5_3 = echarts.init(document.getElementById('graph5_3'),'default');
        var option_5_3 = {
        title:{
          text:"语音评分(短文)",
          x:'center'
        },
        tooltip : {
            trigger: 'axis'
        },
        toolbox: {
            show : false
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                axisLabel:{
                  rotate:-90
                },
                data:[<?php echo $name_string;?>]
            }
        ],
        yAxis : [
            {
              type : 'value'
            }
        ],
        series : [
            {
                type:'bar',
                barCategoryGap:'50%',
                data:[<?php echo $data_string;?>]
            }
        ]
      };
      myChart_5_3.setOption(option_5_3);
      </script>












        <div class="container mt20 mb20">
          <div class="col-lg-1">
            <button type="button" class="btn btn-success mb10" style="margin-top:140px;">语文成绩</button>
          </div>
          <div class="col-lg-11" id="graph7" style="height:300px;padding-right:0;"></div>
          <?php
          if($students)
          {
            $name_string = "";
            $data_string = "";
            $data_string_recently = "";
            $chinese_score = array();
            $chinese_score_recently = array();
            foreach ($students as $student)
            {
              //$chinese_score[] = $student->chinese_score;
              $chinese_score[] = $user->get_chinese_score($student->id);
              $chinese_score_recently[] = $user->get_chinese_score_recently($student->id);
            }
            array_multisort($chinese_score,SORT_ASC,$students);
            foreach($students as $key=>$student)
            {
              $name_string .= "'".$student->name."'";
              $name_string .= ",";
              $data_string .= $chinese_score[$key];
              $data_string .= ",";
              $data_string_recently .= $chinese_score_recently[$key];
              $data_string_recently .= ",";
            }
            $name_string = substr($name_string,0,-1);
            $data_string = substr($data_string,0,-1);
            $data_string_recently = substr($data_string_recently,0,-1);
          ?>
          <script type="text/javascript">
            var myChart_7 = echarts.init(document.getElementById('graph7'),'default');
            var option_7 = {
              tooltip: {
                  trigger: 'axis'
              },
              legend:{
                data:['平均成绩','最近一次成绩']
              }
              grid: {
                  left: '3%',
                  right: '4%',
                  bottom: '3%',
                  containLabel: true
              },
              xAxis: {
                  type: 'category',
                  boundaryGap: false,
                  data: [<?php echo $name_string;?>],
                  axisLabel:{
                    rotate:-90
                  }
              },
              yAxis: {
                  type: 'value'
              },
              series: [
                  {
                      name:'平均成绩',
                      type:'line',
                      data:[<?php echo $data_string;?>]
                  },
                  {
                    name:'最近一次成绩',
                    type:'line',
                    data:[<?php echo $data_string_recently;?>]
                  }
              ]
            };
            myChart_7.setOption(option_7);
            </script>
          <?php
          }
          else
          {
            echo "班内没有学生";
          }
          ?>
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
