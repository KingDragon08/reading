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
    <title>乐智悦读-测评结果</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $user_info = $user->get_user_info();
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">
        <div style="float:left; margin-left:1em;"><?php echo $user_info->name?>个人测评动态结果展示台-[全校]</div>
        <div class="float_right" style="margin-right:1em;">
          <button class="btn btn-success active" onclick="location.href='student_eval_school.php'">全校</button>
          <button class="btn btn-success" onclick="location.href='student_eval_class.php'">全班</button>
        </div>
      </h4>
    </center>
    <br><br>
    <div class="col-lg-12 col-md-12 cols-sm-12 col-xs-12">
        <div class="" style="height:300px;" id="graph3"></div>
    </div>
    <div class="col-lg-12 col-md-12 cols-sm-12 col-xs-12">
        <div class="" style="height:300px;" id="graph1"></div>
    </div>
    <div class="col-lg-12 col-md-12 cols-sm-12 col-xs-12">
        <div class="" style="height:300px;" id="graph2"></div>
    </div>
  </body>
  <script type="text/javascript" src="../js/echarts-all.js"></script>
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
            type : 'value',
            // boundaryGap : [0, 0.01]
            min:0,
            max:100
        }
    ],
    yAxis : [
        {
            type : 'category',
            data : ['联想概括','组织概括','字词认识','书评积分','难度指数']
        }
    ],
    series : [
        {
            type:'bar',
            data:[80, 73, 95, 99, 60]
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
          type : 'value',
          // boundaryGap : [0, 0.01]
          min:0,
          max:100
      }
  ],
  yAxis : [
      {
          type : 'category',
          data : ['单字','词语','短文']
      }
  ],
  series : [
      {
          type:'bar',
          data:[79, 73,75]
      }
  ]
  };
  myChart_2.setOption(option_2);

  //第三个图
  var myChart_3 = echarts.init(document.getElementById('graph3'),'default');
  var option_3 = {
      toolbox: {
          show : true,
          feature : {
              mark : {show: true},
              restore : {show: true},
              saveAsImage : {show: true}
          }
      },
      toolbox: {
          show : true,
          feature : {
              dataView : {show: true, readOnly: false},
              saveAsImage : {show: true}
          }
      },
      series : [
          {
              name:'全校排名',
              type:'gauge',
              startAngle: 180,
              endAngle: 0,
              center : ['50%', '90%'],    // 默认全局居中
              radius : 260,
              axisLine: {            // 坐标轴线
                  lineStyle: {       // 属性lineStyle控制线条样式
                      width: 200
                  }
              },
              axisTick: {            // 坐标轴小标记
                  splitNumber: 10,   // 每份split细分多少段
                  length :12,        // 属性length控制线长
              },
              axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                  formatter: function(v){
                      switch (v+''){
                          case '0': return '0';
                          case '10': return '10';
                          case '20': return '20';
                          case '30': return '30';
                          case '40': return '40';
                          case '50': return '50';
                          case '60': return '60';
                          case '70': return '70';
                          case '80': return '80';
                          case '90': return '90';
                          case '100': return '100';
                          default: return '';
                      }
                  },
                  textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                      color: '#fff',
                      fontSize: 15,
                      fontWeight: 'bolder'
                  }
              },
              pointer: {
                  width:50,
                  length: '90%',
                  color: 'rgba(255, 255, 255, 0.8)'
              },
              title : {
                  show : true,
                  offsetCenter: [0, '-60%'],       // x, y，单位px
                  textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                      color: '#fff',
                      fontSize: 30
                  }
              },
              detail : {
                  show : true,
                  backgroundColor: 'rgba(0,0,0,0)',
                  borderWidth: 0,
                  borderColor: '#ccc',
                  width: 100,
                  height: 40,
                  offsetCenter: [0, -40],       // x, y，单位px
                  formatter:'{value}%',
                  textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                      fontSize : 50
                  }
              },
              data:[{value: 80, name: '优于全校'}]
          }
      ]
  };

  myChart_3.setOption(option_3);
  </script>
</html>
