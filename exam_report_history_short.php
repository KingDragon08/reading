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
    <title>乐智悦读-测验结果</title>
    <style media="screen">
      .item{height:565px; width: 600px;}
      .question_title{margin-left:30px; margin-top:40px; font-size: 16px; font-weight: bold;}
      .answers{margin-left: 30px; margin-top:20px;}
      .question_ctr{margin-left: 30px; margin-top:20px; text-align: center;}
      .btn{margin-bottom: 8px;}
      .w100{width:100%;}
      #list{border:1px solid #eee; margin-top:10px;}
      #list tr td{border-right:1px solid #eee; border-bottom:1px solid #eee;}
      #list tr td:last-child{border-right: 0;}
      #list tr:last-child td{border-bottom: 0;}
      #flag{
              width:150px; height:100px; position:absolute; right:30px; top:190px; z-index:999;
              transform:rotate(45deg);
              -ms-transform:rotate(45deg); /* Internet Explorer */
              -moz-transform:rotate(45deg); /* Firefox */
              -webkit-transform:rotate(45deg); /* Safari 和 Chrome */
              -o-transform:rotate(45deg); /* Opera */
            }
    </style>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        include_once("class/exam_short.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:login.php");
        }
        else
        {
          $user = $GLOBALS['user'];
          $role = $user->get_user_info()->role;
          $user_id = $user->get_user_id();
        }
      ?>
    <!-- top nav end -->
    <?php
      if($role != "学生")
      {
    ?>
      <center>
        <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
        <br>
        <p class="gray" id="tips">
          没有权限...
        </p>
      </center>
    <?php
        exit();
      }
    ?>
    <!-- list start -->
    <div style="width:100%; height:565px;">
      <?php
        if(!isset($_GET['book']))
        {
      ?>
        <center>
          <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
          <br>
          <p class="gray" id="tips">
            非法的访问...
          </p>
        </center>
      <?php
          exit();
        }
        $book_id = intval($_GET['book']);
        if($book_id < 1)
        {
      ?>
        <center>
          <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
          <br>
          <p class="gray" id="tips">
            非法的访问...
          </p>
        </center>
      <?php
          exit();
        }
        $exam = new Exam_short(1);
        $exam_id = $db->get_var("select id from rd_user_exam_scores_short where user_id='$user_id' and book_id='$book_id' order by id desc limit 1");
        $exam_report = $exam->get_exam_report($user_id,$exam_id);
        // var_dump($exam_report);
        if($exam_report)
        {
      ?>
      <div id="flag">
        <img src="img/<?php if($exam_report->total_score<count($exam_report->scores)*0.6){echo 'bu';} ?>hege.png" style="width:150px;"/>
      </div>
      <div class="w100 forget">
        <div class="forget_cover">
          测评结果
          <div class="float_right" style="margin-right:5.8em; font-size:14px; font-weight:normal;">
              测试时间：<?php echo date("Y-m-d",$exam_report->exam_time);?>
          </div>
        </div>
      </div>
      <div style="margin:0 auto; padding:10px; margin-top:10px; box-shadow:0 0 5px #ccc; width:790px;">
        <div style="text-align:center; font-size:16px; height:50px; line-height:50px; width:100%;">
          测评结果[<?php if($exam_report->total_score<count($exam_report->scores)*0.6){echo '不';} echo '合格';?>]
        </div>
        <table width="100%" height="50">
          <tr>
            <td height="50" align="center" valign="middle" width="25%">阅读材料：<?php echo $exam_report->book_name;?></td>
            <td height="50" align="center" valign="middle" width="25%">试题数量：<?php echo count($exam_report->scores);?>题</td>
            <td height="50" align="center" valign="middle" width="25%">用时：<?php echo $exam_report->use_time;?></td>
            <td height="50" align="center" valign="middle" width="25%">得分：<?php echo $exam_report->total_score;?>/<?php echo count($exam_report->scores);?>分</td>
          </tr>
        </table>
        <table width="100%" height="30" style="background:#f2f2f2;">
          <tr>
            <?php
              if(count($exam_report->scores)==10)
              {
            ?>
                <td height="30" align="center" valign="middle" width="20%">字词积累：<?php echo intval($exam_report->scores[0])+intval($exam_report->scores[1])?>/2分</td>
                <td height="30" align="center" valign="middle" width="20%">文句理解：<?php echo intval($exam_report->scores[2])+intval($exam_report->scores[3])?>/2分</td>
                <td height="30" align="center" valign="middle" width="20%">文意把握：<?php echo intval($exam_report->scores[4])+intval($exam_report->scores[5])?>/2分</td>
                <td height="30" align="center" valign="middle" width="20%">要点概括：<?php echo intval($exam_report->scores[6])+intval($exam_report->scores[7])?>/2分</td>
                <td height="30" align="center" valign="middle" width="20%">内容探究：<?php echo intval($exam_report->scores[8])+intval($exam_report->scores[9])?>/2分</td>
            <?php
              }
              else
              {
            ?>
                <td height="30" align="center" valign="middle" width="20%">字词积累：<?php echo intval($exam_report->scores[0])+intval($exam_report->scores[1])+intval($exam_report->scores[2])?>/3分</td>
                <td height="30" align="center" valign="middle" width="20%">文句理解：<?php echo intval($exam_report->scores[3])+intval($exam_report->scores[4])+intval($exam_report->scores[5])?>/3分</td>
                <td height="30" align="center" valign="middle" width="20%">文意把握：<?php echo intval($exam_report->scores[6])+intval($exam_report->scores[7])+intval($exam_report->scores[8])?>/3分</td>
                <td height="30" align="center" valign="middle" width="20%">要点概括：<?php echo intval($exam_report->scores[9])+intval($exam_report->scores[10])+intval($exam_report->scores[11])?>/3分</td>
                <td height="30" align="center" valign="middle" width="20%">内容探究：<?php echo intval($exam_report->scores[12])+intval($exam_report->scores[13])+intval($exam_report->scores[14])?>/3分</td>
            <?php
              }
            ?>
          </tr>
        </table>
        <table width="100%" height="auto" id="list">
          <tr>
            <td height="40" align="center" valign="middle" width="25%">题目序号</td>
            <td height="40" align="center" valign="middle" width="25%">你的答案</td>
            <td height="40" align="center" valign="middle" width="25%">考察能力</td>
            <td height="40" align="center" valign="middle" width="25%">分值</td>
          </tr>
          <?php
            $counter=0;
            foreach($exam_report->scores as $score)
            {
          ?>
              <tr>
                <td height="40" align="center" valign="middle" width="25%"><?php echo $counter+1;?></td>
                <td height="40" align="center" valign="middle" width="25%">
                  <?php
                      if($score=="1")
                      {
                          echo $exam_report->answers[$counter]."[正确]";
                      }
                      else
                      {
                          echo "<font style='color:red;'>".$exam_report->answers[$counter]."[错误]</font>";
                      }
                  ?>
                </td>
                <td height="40" align="center" valign="middle" width="25%">
                  <?php
                    if($counter<count($exam_report->scores)/5)
                    {
                      echo "字词积累";
                    }
                    else
                    {
                      if($counter<2*count($exam_report->scores)/5)
                      {
                        echo "文句理解";
                      }
                      else
                      {
                        if($counter<3*count($exam_report->scores)/5)
                        {
                          echo "文意把握";
                        }
                        else
                        {
                          if($counter<4*count($exam_report->scores)/5)
                          {
                            echo "要点概括";
                          }
                          else
                          {
                            echo "内容探究";
                          }
                        }
                      }
                    }
                  ?>
                </td>
                <td height="40" align="center" valign="middle" width="25%">1</td>
              </tr>
          <?php
              $counter++;
            }
          ?>
        </table>
      </div>
      <?php
          include_once("footer_dialog.php");
        }
        else
        {
      ?>
          <center>
            <img src="img/gongchengshi.jpeg" style="margin-top:20px;"/>
            <br>
            <p class="gray" id="tips">
              非法的访问...
            </p>
          </center>
      <?php
        }
      ?>
    </div>
  </body>
  </html>
