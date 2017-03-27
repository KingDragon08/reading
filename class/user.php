<?php
  class User
  {
      var $username = false;
      var $password = false;
      var $user_info = false;
      var $book_shelf_pages = 0;


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
        if($this->user_info->role == 1)//学生
        {
          $this->user_info->role = "学生";
        }
        if($this->user_info->role == 2)//教师
        {
          $this->user_info->role = "教师";
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
      *获取班级名字
      **/
      function get_class()
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "select rd_class.classname from rd_class left join rd_user on rd_user.class=rd_class.id where rd_user.id='$user_id'";
        return $db->get_var($sql);
      }

      /**
      *获取学校名字
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
      *获取同班同学信息
      **/
      function get_classmates()
      {
        global $db;
        $user_id = $this->get_user_id();
        $class = $this->get_user_info()->class;
        if($class != "")
        {
          $sql = "select id,name,headimg from rd_user where class='$class' order by addtime";
          $classmates = $db->get_results($sql);
          $ret = array();
          foreach ($classmates as $student)
          {
              if($student->name == "")
              {
                $student->name = "新手";
              }
              if($student->headimg == "")
              {
                $student->headimg = "https://placeholdit.imgix.net/~text?txtsize=60&txt=暂无头像&w=200&h=200";
              }
              $ret[] = $student;
          }
          return $ret;
        }
        else
        {
          return NULL;
        }
        return NULL;
      }

      /**
      *获取我的书架上的书
      **/
      function get_books($page)
      {
        global $db;
        $user_id = $this->get_user_id();
        $ret = array();
        // //首先获取书单中的全部书籍
        // $now = time();
        // $sql = "select a.book_list_id from rd_user_read_list as a left join".
        //         " rd_read_list as b on a.book_list_id=b.id where a.user_id='$user_id' and b.endtime>'$now'";
        // // echo $sql;
        // $results = $db->get_results($sql);
        // foreach($results as $result)
        // {
        //   $book_list_id = $result->book_list_id;
        //   $sql = "select * from rd_book as a left join rd_book_list as b on a.id=b.book_id ".
        //           "where b.list_id='$book_list_id'";
        //   $books = $db->get_results($sql);
        //   foreach($books as $book)
        //   {
        //     $book->type = $db->get_var("select name from rd_book_type where id='$book->type'");
        //     $ret[] = $book;
        //   }
        // }
        //然后获取书架上的单本书
        $sql = "select * from rd_book as a left join rd_user_read_book as b on a.id=b.book_id ".
                "where b.user_id='$user_id' and removed=0";
        // print $sql;
        $books = $db->get_results($sql);
        foreach($books as $book)
        {
          $book->type = $db->get_var("select name from rd_book_type where id='$book->type'");
          $ret[] = $book;
        }
        $page_num = 10;
        $total = count($ret);
        $start = ($page-1) * $page_num;
        $end = $start + $page_num;
        if($start >= ($total-1))
        {
          $start = $total - $page_num;
        }
        if($start < 1)
        {
          $start = 0;
        }
        if($end > $total)
        {
          $end = $total;
        }
        $this->book_shelf_pages = ceil($total/$page_num);
        return array_slice($ret,$start,($end-$start));
      }

      /**
      *获取我的书架上的书的页数
      **/
      function get_book_shelf_pages()
      {
        return $this->book_shelf_pages;
      }

      /**
      *当用户角色为教师时
      *获取教师所承担的班级
      **/
      function get_teacher_classes()
      {
        global $db;
        $role = $this->user_info->role;
        if($role == "教师")
        {
          $user_id = $this->get_user_id();
          $sql = "select * from rd_class where teacher_id='$user_id'";
          $ret = array();
          $results = $db->get_results($sql);
          if($results)
          {
            foreach($results as $result)
            {
              $result->school = $db->get_var("select schoolname from rd_school where id='$result->school'");
              $result->num = $db->get_var("select count(*) from rd_user where class='$result->id'");
              //除去老师自己
              if($result->num-1 > 0)
              {
                $result->num--;
              }
              $ret[] = $result;
            }
          }
          return $ret;
        }
        else
        {
          return "";
        }
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
                "values('$user_id','$msg_from','". $db->escape($title) ."','". $db->escape($reply) .
                "','$sendtime','2','0')";
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
      function change_learn_info($class,$school)
      {
        global $db;
        // 检查班级和学校是否匹配
        $sql = "select count(*) from rd_class where id='". $db->escape($class) ."' and school='". $db->escape($school) ."'";
        $c_result = $db->get_var($sql);
        if($c_result != 1)
        {
          return 2;
        }
        //更改user数据表
        $user_id = $this->get_user_id();
        $sql = "update rd_user set class='". $db->escape($class) ."',school='". $db->escape($school) ."' where id='$user_id'";
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

      /**
      *发送邮件
      **/
      function send_email($id,$title,$content)
      {
        global $db;
        $user_id = $this->get_user_id();
        $id = intval($id);
        $ret = array();
        //验证是否为同班同学关系
        $class = $this->get_user_info()->class;
        if($class == "")
        {
          $ret['error'] = 1;
          $ret['msg'] = '尚未加入班级';
          return $ret;
        }
        $sql = "select class from rd_user where id='". $db->escape($id) ."'";
        $msg_to_class = $db->get_var($sql);
        if($msg_to_class == "")
        {
          $ret['error'] = 1;
          $ret['msg'] = '邮件接受者尚未加入班级';
          return $ret;
        }
        if($class != $msg_to_class)
        {
          $ret['error'] = 1;
          $ret['msg'] = '你们不是同班同学关系哟';
          return $ret;
        }
        $sendtime = time();
        $sql = "insert into rd_msg(msg_from,msg_to,msg_title,msg_content,sendtime,msg_type,msg_status)".
                "values('$user_id','$id','". $db->escape($title) ."','". $db->escape($content) .
                "','$sendtime','2','0')";
        $db->query($sql);
        $ret['error'] = 0;
        $ret['msg'] = '发送成功';
        return $ret;
      }

      /**
      *推送书单
      **/
      function push_booklist($books,$classes,$endtime)
      {
        global $db;
        $role = $this->user_info->role;
        $user_id = $this->get_user_id();
        $addtime = time();
        $endtime = strtotime($endtime);
        if($role != "教师")
        {
          return "";
        }
        //创建书单
        $sql = "insert into rd_read_list(user_id,type,endtime,addtime)values(".
                "'$user_id','1','$endtime','$addtime')";
        $db->query($sql);
        //获取创建书单的id
        $read_list_id = $db->get_var("select id from rd_read_list where addtime='$addtime'");
        //写入书单的书列表
        //更新每本书的推荐次数
        foreach($books as $book)
        {
          $sql = "insert into rd_book_list(book_id,list_id)values(".
                  "'$book','$read_list_id')";
          $db->query($sql);
          $sql = "update rd_book set recommend_times=recommend_times+1 where id='$book'";
          $db->query($sql);
        }
        //推送给对应班级的学生
        foreach($classes as $class)
        {
          //获取班级里的所有学生
          $sql = "select id from rd_user where class='$class' and role=1";
          $students = $db->get_results($sql);
          if($students)
          {
            foreach($students as $student)
            {
              //写入学生的书架
              $sql = "insert into rd_user_read_list(user_id,book_list_id)values(".
                      "'$student->id','$read_list_id')";
              $db->query($sql);
              //写入rd_user_read_book
              foreach($books as $book)
              {
                $sql = "insert into rd_user_read_book(user_id,book_id,removed,addtime,endtime,type)value(".
                      "'$student->id','$book',0,'$addtime','$endtime',1)";
                $db->query($sql);
              }
              //给学生发邮件
              if($student->id != $user_id)
              {
                $sql = "insert into rd_msg(msg_from,msg_to,msg_content,sendtime,msg_type,msg_status,msg_title)values(".
                        "'$user_id','$student->id','老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','$addtime','1','0','新书单来啦')";
                $db->query($sql);
              }
            }
          }
        }
      }

      /**
      *获取用户所在学校的id
      **/
      function get_school_id()
      {
        return $this->user_info->school;
      }

      /**
      *获取用户所在班级的id
      **/
      function get_class_id()
      {
        return $this->user_info->class;
      }

      /**
      *获取用户所在学校的学生总人数
      **/
      function get_school_students_count()
      {
        global $db;
        $user_id = $this->get_user_id();
        if($this->get_school_id())
        {
          $school = $this->get_school_id();
          $sql = "select count(*) from rd_user where school='$school' and role=1";
          return $db->get_var($sql);
        }
        else
        {
          return 0;
        }
      }

      /**
      *获取用户所在班级的学生总人数
      **/
      function get_class_students_count()
      {
        global $db;
        $user_id = $this->get_user_id();
        if($this->get_class_id())
        {
          // $school = $this->get_school_id();
          $class = $this->get_class_id();
          $sql = "select count(*) from rd_user where class='$class' and role=1";
          return $db->get_var($sql);
        }
        else
        {
          return 0;
        }
      }


      /**
      *获取当前用户的学校排名
      **/
      function get_user_school_rank()
      {
        global $db;
        $user_id = $this->get_user_id();
        if($this->get_school_id())//如果已经加入学校的话
        {
          $school = $this->get_school_id();
          $sql = "select count(id) from rd_user where score>".
                  "(select score from rd_user where id=$user_id) and school='$school'";
          return $db->get_var($sql);
        }
        else
        {
          return -1;
        }
      }

      /**
      *获取当前用户的学校排名
      *教师第三视角
      **/
      function get_user_school_rank2($id)
      {
        global $db;
        $user_id = $id;
        if($this->get_school_id())//如果已经加入学校的话
        {
          $school = $this->get_school_id();
          $sql = "select count(id) from rd_user where score>".
                  "(select score from rd_user where id=$user_id) and school='$school'";
          return $db->get_var($sql);
        }
        else
        {
          return -1;
        }
      }

      /**
      *获取当前用户的班级排名
      **/
      function get_user_class_rank()
      {
        global $db;
        $user_id = $this->get_user_id();
        if($this->get_class_id())//如果已经加入学校的话
        {
          $class = $this->get_class_id();
          $sql = "select count(id) from rd_user where score>".
                  "(select score from rd_user where id=$user_id) and class='$class'";
          return $db->get_var($sql);
        }
        else
        {
          return -1;
        }
      }

      /**
      *获取当前用户的班级排名
      *教师第三视角
      **/
      function get_user_class_rank2($id)
      {
        global $db;
        $user_id = $id;
        if($this->get_class_id())//如果已经加入学校的话
        {
          $class = $this->get_class_id();
          $sql = "select count(id) from rd_user where score>".
                  "(select score from rd_user where id=$user_id) and class='$class'";
          return $db->get_var($sql);
        }
        else
        {
          return -1;
        }
      }

      /**
      *学校级别
      *获取5类题型的得分比例
      *0:细节认知,1:信息提取,2:意义建构,3:直接推论,4:组织概括
      **/
      function get_score_percent_by_item_school()
      {
        global $db;
        $user_id = $this->get_user_id();
        $item1_socre = $this->user_info->item1_score;
        $item2_socre = $this->user_info->item2_score;
        $item3_socre = $this->user_info->item3_score;
        $item4_socre = $this->user_info->item4_score;
        $item5_socre = $this->user_info->item5_score;
        $ret = [];
        if($this->get_school_id())
        {
          $school = $this->get_school_id();
          $school_students_count = $this->get_school_students_count();
          $sql = "select count(id) from rd_user where item1_score>".
                  "(select item1_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item2_score>".
                  "(select item2_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item3_score>".
                  "(select item3_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item4_score>".
                  "(select item4_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item5_score>".
                  "(select item5_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          return $ret;
        }
        else
        {
          return [-1,-1,-1,-1,-1];
        }
      }

      /**
      *学校级别
      *获取5类题型的得分比例
      *0:细节认知,1:信息提取,2:意义建构,3:直接推论,4:组织概括
      *教师第三视角
      **/
      function get_score_percent_by_item_school2($id)
      {
        global $db;
        $user_id = $id;
        $item1_socre = $this->user_info->item1_score;
        $item2_socre = $this->user_info->item2_score;
        $item3_socre = $this->user_info->item3_score;
        $item4_socre = $this->user_info->item4_score;
        $item5_socre = $this->user_info->item5_score;
        $ret = [];
        if($this->get_school_id())
        {
          $school = $this->get_school_id();
          $school_students_count = $this->get_school_students_count();
          $sql = "select count(id) from rd_user where item1_score>".
                  "(select item1_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item2_score>".
                  "(select item2_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item3_score>".
                  "(select item3_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item4_score>".
                  "(select item4_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          $sql = "select count(id) from rd_user where item5_score>".
                  "(select item5_score from rd_user where id=$user_id) and school='$school'";
          $ret[] = round(($school_students_count-$db->get_var($sql))/$school_students_count,2)*100;
          return $ret;
        }
        else
        {
          return [-1,-1,-1,-1,-1];
        }
      }

      /**
      *班级级别
      *获取5类题型的得分比例
      *0:细节认知,1:信息提取,2:意义建构,3:直接推论,4:组织概括
      **/
      function get_score_percent_by_item_class()
      {
        global $db;
        $user_id = $this->get_user_id();
        $item1_socre = $this->user_info->item1_score;
        $item2_socre = $this->user_info->item2_score;
        $item3_socre = $this->user_info->item3_score;
        $item4_socre = $this->user_info->item4_score;
        $item5_socre = $this->user_info->item5_score;
        $ret = [];
        if($this->get_class_id())
        {
          $class = $this->get_class_id();
          $class_students_count = $this->get_class_students_count();
          $sql = "select count(id) from rd_user where item1_score>".
                  "(select item1_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item2_score>".
                  "(select item2_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item3_score>".
                  "(select item3_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item4_score>".
                  "(select item4_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item5_score>".
                  "(select item5_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          return $ret;
        }
        else
        {
          return [-1,-1,-1,-1,-1];
        }
      }

      /**
      *班级级别
      *获取5类题型的得分比例
      *0:细节认知,1:信息提取,2:意义建构,3:直接推论,4:组织概括
      *教师用第三视角
      **/
      function get_score_percent_by_item_class2($id)
      {
        global $db;
        $user_id = $id;
        $item1_socre = $this->user_info->item1_score;
        $item2_socre = $this->user_info->item2_score;
        $item3_socre = $this->user_info->item3_score;
        $item4_socre = $this->user_info->item4_score;
        $item5_socre = $this->user_info->item5_score;
        $ret = [];
        if($this->get_class_id())
        {
          $class = $this->get_class_id();
          $class_students_count = $this->get_class_students_count();
          $sql = "select count(id) from rd_user where item1_score>".
                  "(select item1_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item2_score>".
                  "(select item2_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item3_score>".
                  "(select item3_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item4_score>".
                  "(select item4_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          $sql = "select count(id) from rd_user where item5_score>".
                  "(select item5_score from rd_user where id=$user_id) and class='$class'";
          $ret[] = round(($class_students_count-$db->get_var($sql))/$class_students_count,2)*100;
          return $ret;
        }
        else
        {
          return [-1,-1,-1,-1,-1];
        }
      }

      /**
      *教师用
      *获取教师所管理的班级信息
      **/
      function get_classes()
      {
        global $db;
        $user_id = $this->get_user_id();
        $role = $this->get_user_info()->role;
        if($role!="教师")
        {
          return NULL;
        }
        $sql = "select * from rd_class where teacher_id='$user_id'";
        return $db->get_results($sql);
      }

      /**
      *教师用
      *获取班级下的所有学生
      **/
      function get_students_by_class($class_id)
      {
        global $db;
        $students = $db->get_results("select id,name,score,chinese_score,headimg from rd_user where role=1 and class='$class_id'");
        if($students)
        {
          foreach($students as $student)
          {
            if(strlen($student->name)<1)
            {
              $student->name = '暂无姓名';
            }
            if(strlen($student->headimg)<1)
            {
              $student->headimg = "https://placeholdit.imgix.net/~text?txtsize=60&txt=暂无头像&w=200&h=200";
            }
          }
          return $students;
        }
        else
        {
          return 0;
        }
      }

      /**
      *教师用
      *获取班级内学生的总人数
      **/
      function get_class_student_number($class_id)
      {
        global $db;
        return $db->get_var("select count(id) from rd_user where role=1 and class='$class_id'");
      }

      /**
      *教师用
      *检查班级和教师的对应关系
      **/
      function check_class($class_id)
      {
        global $db;
        $user_id = $this->get_user_id();
        return $db->get_var("select count(id) from rd_class where id='$class_id' and teacher_id='$user_id'");
      }

      /**
      *教师用
      *获取教师测评中心第一个图的六项数据
      **/
      function get_class_report_score_1($class_id)
      {
        global $db;
        $sql = "select round(avg(score),2) as avg_score,round(avg(item1_score),2) as item1,".
                "round(avg(item2_score),2) as item2,round(avg(item3_score),2) as item3,".
                "round(avg(item4_score),2) as item4,round(avg(item5_score),2) as item5 ".
                "from rd_user where role=1 and class='$class_id'";
        return $db->get_row($sql);
      }

      /**
      *教师用
      *获取教师测评中心第二个饼图的数据
      **/
      function get_class_report_score_2($class_id)
      {
        global $db;
        //取出当前班级所有学生测试合格的书的id
        $sql = "select count(id) as total,type from rd_book where id in(".
                "select book_id from rd_user_exam_scores where user_id in(".
                "select id from rd_user where role=1 and class='$class_id') and hege=1) group by type";
        $datas = $db->get_results($sql);
        //取出所有的书的类型
        $sql = "select id,name from rd_book_type";
        $book_types = $db->get_results($sql);
        foreach($book_types as $type)
        {
          $type->num = 0;
          foreach($datas as $data)
          {
            if($data->type == $type->id)
            {
              $type->num = $data->total;
            }
          }
        }
        return $book_types;
      }

      /**
      *教师用
      *获取教师测评中心的第三个图数据
      **/
      function get_class_report_score_3($class_id)
      {
        global $db;
        $sql = "select count(id) as total,level from rd_book where id in(".
                "select book_id from rd_user_exam_scores where user_id in(".
                "select id from rd_user where role=1 and class='$class_id') and hege=1)group by level";
        $datas = $db->get_results($sql);
        $ret = [0,0,0,0,0,0,0,0,0,0];
        if(count($datas)>0)
        {
          foreach($datas as $data)
          {
            $ret[$data->level-1] = $data->total;
          }
        }
        return $ret;
      }

      /**
      *教师用
      *获取教师测评中心的第四个图数据
      *阅读数量
      **/
      function get_class_report_score_4($class_id)
      {
        global $db;
        $students = $this->get_students_by_class($class_id);
        $ret = [];
        //分个获取学生的阅读数量
        if($students)
        {
          foreach($students as $student)
          {
            $temp = [];
            $temp['name'] = $student->name;
            $sql = "select count(id) from rd_user_exam_scores where user_id='$student->id' and hege=1";
            $temp['num'] = $db->get_var($sql);
            $ret[] = $temp;
          }
          return $ret;
        }
        else
        {
          return 0;
        }
      }

      /**
      *教师用
      *获取学生是否是教师的学生
      **/
      function check_is_student($id)
      {
        global $db;
        $sql = "select class from rd_user where id=$id and role=1";
        $class = $db->get_var($sql);
        if($class == $this->get_user_info()->class)
        {
          return true;
        }
        else {
          return false;
        }
      }

      /**
      *教师用
      *获取学生的姓名
      **/
      function get_student_name($id)
      {
        global $db;
        $sql = "select name from rd_user where id='$id'";
        $name = $db->get_var($sql);
        if($name)
        {
          return $name;
        }
        else
        {
          return "暂无姓名";
        }
      }

      /**
      *教师用
      *获取发布的所有书单
      **/
      function get_history_list()
      {
        global $db;
        $user_id = $this->get_user_id();
        $sql = "select id from rd_read_list where user_id='$user_id'";
        return $db->get_results($sql);
      }

      /**
      *获取教师名下所有的学生
      **/
      function get_students()
      {
        global $db;
        $user_id = $this->get_user_id();
        //获取教师所管理的班级
        $sql = "select id from rd_class where teacher_id='$user_id'";
        $classes = $db->get_results($sql);
        $ret = [];
        if(count($classes)>0)
        {
          foreach($classes as $class)
          {
            $students = $db->get_results("select id,name from rd_user where class='$class->id' and role=1");
            if(count($students)>0)
            {
              foreach($students as $student)
              {
                if(strlen($student->name)<1)
                {
                  $student->name = "暂无姓名";
                }
                $ret[] = $student;
              }
            }
          }
        }
        return $ret;
      }

      /**
      *获取书单管理的阅读完成记录板
      **/
      function get_num_data($id)
      {
        global $db;
        $user_id = $this->get_user_id();
        $ret = [];
        if($id!=0)//获取特定书单的阅读完成情况
        {
          //首先获取该书单对应的学生
          $students = $db->get_results("select user_id from rd_user_read_list where book_list_id='$id'");
          if(count($students)>0)
          {
            foreach ($students as $student)
            {
                $temp = [];
                $name = $db->get_var("select name from rd_user where id='$student->user_id'");
                if(strlen($name)<1)
                {
                  $name = "暂无姓名";
                }
                $temp['name'] = $name;
                $sql = "select count(*) from rd_user_exam_scores where user_id='$student->user_id' ".
                        "and hege=1 and book_id in(select book_id from rd_book_list where list_id='$id')";
                $temp['num'] = $db->get_var($sql);
                $ret[] = $temp;
            }
          }
        }
        else//获取总的情况
        {
          $students = $this->get_students();
          if(count($students)>0)
          {
            foreach($students as $student)
            {
                $temp = [];
                $temp['name'] = $student->name;
                $temp['num'] = $db->get_var("select count(*) from rd_user_exam_scores where user_id='$student->id' and hege=1");
                $ret[] = $temp;
            }
          }
        }
        return $ret;
      }

      /**
      *教师用
      *更改班级信息
      **/
      function update_class($class_id,$class_name,$class_grade)
      {
        global $db;
        //更新班级表
        $sql = "update rd_class set classname='".$db->escape($class_name)."',grade='$class_grade' ".
                "where id='$class_id'";
        $db->query($sql);
        //更新用户表
        $sql = "update rd_user set grade='$class_grade' where class='$class_id'";
        $db->query($sql);
      }

      /**
      *教师用
      *创建班级
      **/
      function create_class($class_school,$class_grade,$class_name)
      {
        global $db;
        $user_id = $this->get_user_id();
        //首先检查名下班级个数
        $has_class = $db->get_var("select count(id) from rd_class where teacher_id='$user_id'");
        if($has_class>=5)
        {
          //班级个数已达上限
          return -1;
        }
        else
        {
          //创建班级
          $now = time();
          $sql = "insert into rd_class(classname,school,teacher_id,grade,addtime)values('".$db->escape($class_name).
                  "',$class_school,$user_id,$class_grade,'$now')";
          $db->query($sql);
          //获取刚创建的班级的id号
          $class_id = $db->get_var("select id from rd_class where addtime='$now'");
          //更新用户表中教师的class属性
          $sql = "update rd_user set class=$class_id where id=$user_id";
          $db->query($sql);
          return $class_id;
        }
      }

      /**
      *教师用
      *获取班级学生总数
      **/
      function get_class_students_count_teacher($class_id)
      {
        global $db;
        $user_id = $this->get_user_id();
        $class = $this->get_class_id();
        $sql = "select count(*) from rd_user where class='$class_id' and role=1";
        return $db->get_var($sql);
      }



  }
?>
