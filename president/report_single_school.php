<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css" media="screen">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/echarts-all.js"></script>
    <title>乐智悦读-个人报告</title>
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
          include_once("../ezSQL/init.php");
          include_once("../class/user.php");
          include_once("../class/common.php");
          $user = new User($_SESSION['username'],$_SESSION['password']);
          $user_info = $user->get_user_info();
          $school_students_count = $user->get_school_students_count();
          $role = $user_info->role;
          $common = new Common();
        }
      ?>
    <!-- top nav end -->

    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          <?php
            if(isset($_GET['id']))
            {
              $id = intval($_GET['id']);
              if($id>0)
              {
                if($user->check_is_student_president($id))
                {
            ?>
            学生成绩详情
            <?php
                }
                else
                {
                  $common->tips("没有访问权限");
                  exit();
                }
              }
              else
              {
                $common->tips("参数不合法");
                exit();
              }
            }
            else
            {
              $common->tips("非法的访问");
              exit();
            }
          ?>
        </div>
      </div>
      <br>
      <div class="container">
        <?php
          if($role == "3")
          {
        ?>
        <style media="screen">
          .box{width:100%; padding:1.5em; min-height:515px; height:auto; overflow-y:auto; margin:0 auto; box-shadow:0 0 5px #999; border-radius:5px;}
          .box_head{background:#824399; color:#fff; text-align:center; font-size:16px; border-radius:5px 5px 0 0; height:40px; line-height:40px;}
          .box_graph{border:1px solid #824399; height:auto; box-shadow:0 0 5px #999; border-radius:0 0 5px 5px;}
          .box_graph_item{position:relative; height:260px;}
          .box_graph_item_title{position:absolute; left:0; top:40px; font-size:16px; color:#824399;}
          .box_graph_graph{width:100%; height:100%;}
        </style>
        <div class="container mt20 mb20">
          <div class="box">
            <h4><?php echo $user->get_student_name($id);?>个人测评报告</h4>
            <div class="col-lg-12 box_head">
              全本阅读
            </div>
            <div class="col-lg-12 box_graph">



              <div class="col-lg-4 box_graph_item">
                <div class="box_graph_item_title">阅读能力</div>
                <div class="box_graph_graph" id="box_graph2"></div>
              </div>
              <?php
                $score_percent_by_item = $user->get_score_percent_by_item_school2($id);
              ?>
              <script type="text/javascript">

              var myChart_2 = echarts.init(document.getElementById('box_graph2'),'default');
              var option_2 = {
                tooltip : {
                    trigger: 'axis'
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'value',
                        min:0,
                        max:3,
                        axisLabel:{
                          rotate:-90
                        }
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
                        data:[<?php echo implode(",",$score_percent_by_item)?>]
                    }
                ]
              };
              myChart_2.setOption(option_2);
              </script>


              <div class="col-lg-4 box_graph_item">
                <div class="box_graph_item_title">阅读范围</div>
                <div class="box_graph_graph" id="box_graph1"></div>
              </div>
              <?php
                $pie_data = "";
                $pie_data = $user->get_single_student_report_1($id);
                if(count($pie_data)>0)
                {
            ?>
                  <script type="text/javascript">
                      var myChart_1 = echarts.init(document.getElementById('box_graph1'),'default');
                      var option_1 = {
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
                                  name: '阅读范围',
                                  type: 'pie',
                                  radius : '50%',
                                  center: ['50%', '60%'],
                                  data:[<?php echo $s_string;?>],
                                  itemStyle: {
                                      emphasis: {
                                          shadowBlur: 10,
                                          shadowOffsetX: 1,
                                          shadowColor: 'rgba(0, 0, 0, 0.5)'
                                      }
                                  }
                              }
                          ]
                      };
                    myChart_1.setOption(option_1);
                  </script>
            <?php
                  }
                  else
                  {
                    echo "暂时没有数据";
                  }
              ?>




              <div class="col-lg-4 box_graph_item">
                <div class="box_graph_item_title">阅读难度</div>
                <div class="box_graph_graph" id="box_graph3"></div>
              </div>
            </div>
            <?php
            $raddar_data = $user->get_single_student_report_2($id);
            $max = 1;
            foreach($raddar_data as $data)
            {
              if($data>$max)
              {
                $max = $data;
              }
            }
          ?>
            <script type="text/javascript">
            var myChart_3 = echarts.init(document.getElementById('box_graph3'),'default');
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
                          name: '阅读难度',
                          type: 'radar',
                          data : [
                              {
                                  value : [<?php
                                    echo $raddar_data[9].','.$raddar_data[8].','.$raddar_data[7].','.$raddar_data[6]
                                          .','.$raddar_data[5].','.$raddar_data[4].','.$raddar_data[3].','
                                          .$raddar_data[2].','.$raddar_data[1].','.$raddar_data[0];
                                  ?>],
                                  name : '阅读难度'
                              }
                          ]
                      }
                  ]
              };

              myChart_3.setOption(option_3);
            </script>


            <div class="col-lg-12 box_head mt20">
              语音朗读
            </div>
            <div class="col-lg-12 box_graph">


              <div class="col-lg-6 box_graph_item">
                <div class="box_graph_item_title" style="top:10px;">朗读均衡值</div>
                <div class="box_graph_graph" id="box_graph4"></div>
              </div>

              <?php
                $score_percent_by_item = $user->get_speech_percent_by_item_school_teacher($id);
                $out_string = "";
                foreach($score_percent_by_item as $score)
                {
                    $out_string .= $score;
                    $out_string .= ',';
                }
                $out_string = substr($out_string,0,-1);
            ?>
              <script type="text/javascript">
              var myChart_4 = echarts.init(document.getElementById('box_graph4'),'default');
              var option_4 = {
                  tooltip: {
                      trigger: 'axis'
                  },
                  polar: [
                      {
                          indicator: [
                              {text: '单字', max: 100},
                              {text: '词语', max: 100},
                              {text: '短文', max: 100}
                          ],
                          center: ['50%','50%'],
                          radius: 100
                      }
                  ],
                  series: [
                      {
                          type: 'radar',
                           tooltip: {
                              trigger: 'item'
                          },
                          itemStyle: {normal: {areaStyle: {type: 'default'}}},
                          data: [
                              {
                                  value: [<?php echo $out_string; ?>],
                                  name: '朗读均衡值'
                              }
                          ]
                      }
                  ]
                };

                myChart_4.setOption(option_4);
              </script>

              <div class="col-lg-6 box_graph_item">
                <div class="box_graph_item_title" style="top:10px;">朗读单项平均值</div>
                <div class="box_graph_graph" id="box_graph5"></div>
              </div>

              <script type="text/javascript">

              var myChart_5 = echarts.init(document.getElementById('box_graph5'),'default');
              var option_5 = {
                tooltip : {
                    trigger: 'axis'
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
                        barCategoryGap:'80%',
                        data:[<?php
                              // $score_percent_by_item = $user->get_speech_percent_by_item_school_teacher($id);
                              // $out_string = "";
                              // foreach($score_percent_by_item as $score)
                              // {
                              //     $out_string .= $score;
                              //     $out_string .= ',';
                              // }
                              // $out_string = substr($out_string,0,-1);
                              echo $out_string;
                        ?>]
                    }
                ]
                };
                myChart_5.setOption(option_5);
              </script>



          </div>
        </div>
        <?php
          }
          else
          {
            $common->tips("没有访问权限");
          }
        ?>
      </div>
      <br>
    <!-- forget panel end -->
    <?php
      include_once("footer.php")
    ?>
  </body>
</html>
