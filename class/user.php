<?php
  class User
  {
      var $username = false;
      var $password = false;
      var $user_info = false;


      function User($username='',$password='')
      {
        global $db;
        $this->username = $username;
        $this->password = $password;
        $this->user_info = $db->get_row("select * from rd_user where username='" . $db->escape($username).
                                        "' and password='". $db->escape($password) ."'");
        if($this->user_info->name == "")//尚未设置用户名
        {
          $this->user_info->name = "新人";
        }
        // if($this->user_info->grade != "")//尚未加入年级
        // {
        //   $this->user_info->grade = "无";
        // }
        // else
        // {
        //   $this->user_info->grade = $this->get_grade();
        // }
        // if($this->user_info->class != "")//已加入班级
        // {
        //   $this->user_info->class = $this->get_class();
        // }
        // if($this->user_info->school != "")//已加入学校
        // {
        //   $this->user_info->school = $this->get_school();
        // }
        if($this->user_info->headimg == "")//尚未设置头像
        {
          $this->user_info->headimg = "https://placeholdit.imgix.net/~text?txtsize=60&txt=暂无头像&w=200&h=200";
        }
        if($this->user_info->score == "")//没有得分
        {
          $this->user_info->score = "0";
        }
        if($this->user_info->role == "")//没有角色
        {
          $this->user_info->role = "学生";
        }
      }
      /**
      *获取用户全部信息
      **/
      function get_user_info()
      {
        return $this->user_info;
      }

      /**
      *获取用户id
      **/
      function get_user_id()
      {
        return $this->get_user_info()->id;
      }

      /**
      *计算年级信息
      *默认9月年级＋1
      **/
      function get_grade()
      {
        $grade = $this->get_user_info()->grade;
        if($grade != "无")
        {
          $addtime = $this->get_user_info()->addtime;
          $r_year = date('Y',$addtime);
          $r_month = date('m',$addtime);
          $ntime = time();
          $n_year = date('Y',$ntime);
          $n_month = date('m',$ntime);
          //同年9月前注册+1
          if($r_year==$n_year && $r_month<9 && $n_month>=9)
          {
            return $grade++;
          }
          //不同年9月前注册
          if($n_year>$r_year && $r_month<9)
          {
            return $grade+$n_year-$r_year;
          }
          //不同年9月后注册
          if($n_year>$r_year && $r_month>=9)
          {
            return $grade+$n_year-$r_year-1;
          }
          //同年9月后
          return $grade;
        }
        else
        {
          return "无";
        }
      }

      /**
      *获取班级
      **/
      function get_class()
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "select rd_class.classname from rd_class left join rd_user on rd_user.class=rd_class.id where rd_user.id='$user_id'";
        return $db->get_var($sql);
      }

      /**
      *获取学校
      **/
      function get_school()
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "select rd_school.schoolname from rd_school left join rd_user on rd_user.school=rd_school.id where rd_user.id='$user_id'";
        return $db->get_var($sql);
      }

      /**
      *获取未读消息数量
      **/
      function get_unread_msg_number()
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "select count(*) from rd_msg where msg_to='$user_id' and msg_status=0";
        return $db->get_var($sql);
      }

      /**
      *获取所有消息数量
      **/
      function get_msg_number()
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "select count(*) from rd_msg where msg_to='$user_id'";
        return $db->get_var($sql);
      }

      /**
      *分页获取消息详情
      **/
      function get_msg($page)
      {
        global $db;
        $page_size = 20;
        $user_id = $this->get_user_id();
        $max_page = $this->get_msg_max_page();
        $page = intval($page);
        if($page>$max_page)
        {
          $page = $max_page;
        }
        if($page<1)
        {
          $page = 1;
        }
        $page--;
        $start = $page * $page_size;
        $sql = "select * from rd_msg where msg_to='$user_id' order by sendtime desc limit $start,$page_size";
        $msgs = $db->get_results($sql);
        $ret = array();
        //将发件人的用户名提取出来
        foreach($msgs as $msg)
        {
          $msg_from = $msg->msg_from;
          $sql = "select name from rd_user where id='$msg_from'";
          $name = $db->get_var($sql);
          if($name == "")
          {
            $name = "新手";
          }
          $msg->msg_from = $name;
          $msg->sendtime = date("Y-m-d H:i",$msg->sendtime);
          $ret[] = $msg;
        }
        return $ret;
      }

      /**
      *获取消息最大分页数
      **/
      function get_msg_max_page()
      {
        $page_size = 20;
        $total = $this->get_msg_number();
        $max_page = $total/$page_size;
        if(floor($max_page)!= $max_page)//如果下取整不等于原数则需要＋1
        {
          $max_page++;
        }
        return floor($max_page);
      }

      /**
      *获取单条信息的详情
      **/
      function get_msg_detail($id)
      {
        global $db;
        $user_id = $this->get_user_id();
        $id = intval($id)<1 ? 1:intval($id);
        $sql = "select * from rd_msg where id='$id' and msg_to='$user_id'";
        $msg = $db->get_row($sql);
        if($msg)
        {
          $msg_from = $msg->msg_from;
          $sql = "select name from rd_user where id='$msg_from'";
          $name = $db->get_var($sql);
          if($name == "")
          {
            $name = "新手";
          }
          $msg->msg_from = $name;
          $msg->sendtime = date("Y-m-d H:i",$msg->sendtime);
          $this->mark_msg_read($id.';');
        }
        return $msg;
      }

      /**
      *回复信息
      **/
      function reply_msg($msg_id,$title,$reply)
      {
        global $db;
        //获取收件人
        $sql = "select msg_from from rd_msg where id='$msg_id'";
        $msg_from = $db->get_var($sql);
        $user_id = $this->get_user_id();
        $title = "[回复]:".$title;
        $sendtime = time();
        $sql = "insert into rd_msg(msg_from,msg_to,msg_title,msg_content,sendtime,msg_type,msg_status)".
                "values('$user_id','$msg_from','$title','$reply','$sendtime','2','0')";
        $db->query($sql);
      }

      /**
      *更改用户头像
      **/
      function change_headimg($headimg)
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "update rd_user set headimg='". $db->escape($headimg) ."' where id='$user_id'";
        $db->query($sql);
      }

      /**
      *更改用户名
      **/
      function change_name($name)
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "update rd_user set name='". $db->escape($name) ."' where id='$user_id'";
        $db->query($sql);
      }

      /**
      *验证密码是否正确
      **/
      function verify_password($password)
      {
        if(md5($password) == $this->get_user_info()->password)
        {
          return true;
        }
        else
        {
          return false;
        }
      }

      /**
      *更改密码
      **/
      function change_psw($old_password,$new_password)
      {
        if($this->verify_password($old_password))
        {
          global $db;
          $user_id = $this->get_user_id();
          $new_password = md5($new_password);
          $sql = "update rd_user set password='". $db->escape($new_password) ."' where id='$user_id'";
          $db->query($sql);
          return true;
        }
        else
        {
          return false;
        }
      }

      /**
      *更改学籍信息
      **/
      function change_learn_info($grade,$class,$school)
      {
        global $db;
        //检查班级是否存在
        $sql = "select count(*) from rd_class where id='". $db->escape($class) ."'";
        $c_result = $db->get_var($sql);
        if($c_result != 1)
        {
          return 2;
        }
        //检查学校是否存在
        $sql = "select count(*) from rd_school where id='". $db->escape($school) ."'";
        $s_result = $db->get_var($sql);
        if($s_result != 1)
        {
          return 3;
        }
        //更改user数据表
        $user_id = $this->get_user_id();
        $sql = "update rd_user set grade='". $db->escape($grade) ."',class='". $db->escape($class) ."',school='". $db->escape($school) ."' where id='$user_id'";
        $db->query($sql);
        return 1;
      }

      /**
      *标记邮件为已读
      **/
      function mark_msg_read($ids)
      {
        global $db;
        $ids = explode(";",$ids);
        array_pop($ids);//去掉最后一个空白的
        $user_id = $this->get_user_id();
        foreach ($ids as $id)
        {
          $sql = "update rd_msg set msg_status=1 where msg_to='$user_id' and id='$id'";
          $db->query($sql);
        }
      }



  }
?>
