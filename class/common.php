<?php
class Common
{

    var $read_list_pages = 1;//所有书单的分页总数
    var $pages = 1;//其他分页

    function Common()
    {

    }

    /**
    *获取所有书单类型
    **/
    function get_list_type()
    {
      global $db;
      $sql = "select id,name from rd_list_type";
      return $db->get_results($sql);
    }

    /**
    *获取所有书的类型
    **/
    function get_all_book_type()
    {
      global $db;
      $sql = "select id,name from rd_book_type";
      return $db->get_results($sql);
    }

    /**
    *获取所有学段
    **/
    function get_grade()
    {
      global $db;
      $sql = "select id,grade_name from rd_grade";
      return $db->get_results($sql);
    }

    /**
    *获取书本类型
    **/
    function get_book_type()
    {
      global $db;
      $sql = "select id,name from rd_book_type";
      return $db->get_results($sql);
    }

    /**
    *获取所有的书
    **/
    function get_books($page,$user_id,$type,$grade)
    {
      global $db;
      $page_num = 6;
      $sql = "select count(*) from rd_book where ";
      $sql_1 = "select * from rd_book where ";
      if($type==0 && $grade==0)
      {
        $sql .= "1";
        $sql_1 .= "1";
      }
      else
      {
        if($type!=0 && $grade!=0)
        {
          $sql .= "grade='$grade' and type='$type'";
          $sql_1 .= "grade='$grade' and type='$type'";
        }
        else
        {
          if($type!=0 && $grade==0)
          {
            $sql .= "type='$type'";
            $sql_1 .= "type='$type'";
          }
          else
          {
            $sql .= "grade='$grade'";
            $sql_1 .= "grade='$grade'";
          }
        }
      }
      $total = $db->get_var($sql);
      $this->read_list_pages = ceil($total/$page_num);
      $start = ($page-1)*$page_num;
      if($start < 1)
      {
        $start = 0;
      }
      $sql_1 .= " order by id desc limit $start,$page_num";
      $book_list = $db->get_results($sql_1);
      return $book_list;
    }

    /**
    *获取所有的书单
    **/
    function get_read_list($page,$user_id,$type,$grade)
    {
      global $db;
      $page_num = 6;
      //获取所有书单的总数
      $sql = "select count(*) from rd_read_list where ";
      $sql_1 = "select * from rd_read_list where ";
      if($type==0 && $grade==0)
      {
        $sql .= "1";
        $sql_1 .= "1";
      }
      else
      {
        if($type!=0 && $grade!=0)
        {
          $sql .= "grade='$grade' and type='$type'";
          $sql_1 .= "grade='$grade' and type='$type'";
        }
        else
        {
          if($type!=0 && $grade==0)
          {
            $sql .= "type='$type'";
            $sql_1 .= "type='$type'";
          }
          else
          {
            $sql .= "grade='$grade'";
            $sql_1 .= "grade='$grade'";
          }
        }
      }
      $now = time();
      $sql .= " and endtime>'$now'";
      $total = $db->get_var($sql);
      $this->read_list_pages = ceil($total/$page_num);

      $start = ($page-1)*$page_num;
      if($start < 1)
      {
        $start = 0;
      }
      $sql_1 .= " and endtime>'$now' order by id desc limit $start,$page_num";
      $read_list = $db->get_results($sql_1);
      $ret = array();
      if($read_list)
      {
        foreach($read_list as $item)
        {
          $list_id = $item->id;//书单的id
          //取书单内第一本书的封面
          $sql = "select a.coverimg from rd_book as a left join rd_book_list as b on ".
                  "a.id=b.book_id where list_id='$list_id' limit 1";
          // $book_names = $db->get_results($sql);
          //取第一本书的封面作为书单的封面
          $item->coverimg = $db->get_var($sql);
          //将书名拼接起来
          // $temp = "";
          // foreach($book_names as $name)
          // {
          //   $temp .= $name->name;
          // }
          // $temp = substr($temp,0,14);
          // $item->name = "《".$book_names[0]->name."》等";
          //获取发布者的名字
          $sql = "select name from rd_user where id='$item->user_id'";
          $item->author = $db->get_var($sql)==""?"新手":$db->get_var($sql);
          //获取学段名称
          $sql = "select grade_name from rd_grade where id='$item->grade'";
          $item->grade = $db->get_var($sql);
          //获取是否在书架上的状态
          $sql = "select count(id) from rd_user_read_list where book_list_id='$item->id' and user_id='$user_id'";
          if($db->get_var($sql)>0)
          {
            $item->status = 1;
          }
          else
          {
            $item->status = 0;
          }
          //获取书单类型名称
          $sql = "select name from rd_list_type where id='$item->type'";
          $item->type = $db->get_var($sql);
          $ret[] = $item;
        }
      }
      return $ret;
    }


    /**
    *更改逻辑后
    *获取所有的书
    **/
    function get_read_list_2($page,$user_id,$type,$grade)
    {
      global $db;
      $page_num = 6;
      //获取所有书单的总数
      $sql = "select count(*) from rd_book where ";
      $sql_1 = "select * from rd_book where ";
      if($type==0 && $grade==0)
      {
        $sql .= "1";
        $sql_1 .= "1";
      }
      else
      {
        if($type!=0 && $grade!=0)
        {
          $sql .= "grade='$grade' and type='$type'";
          $sql_1 .= "grade='$grade' and type='$type'";
        }
        else
        {
          if($type!=0 && $grade==0)
          {
            $sql .= "type='$type'";
            $sql_1 .= "type='$type'";
          }
          else
          {
            $sql .= "grade='$grade'";
            $sql_1 .= "grade='$grade'";
          }
        }
      }
      // $now = time();
      // $sql .= " and endtime>'$now'";
      $total = $db->get_var($sql);
      $this->read_list_pages = ceil($total/$page_num);
      $start = ($page-1)*$page_num;
      if($start < 1)
      {
        $start = 0;
      }
      $sql_1 .= " order by id desc limit $start,$page_num";
      $read_list = $db->get_results($sql_1);
      $ret = array();
      if($read_list)
      {
        foreach($read_list as $item)
        {
          //获取学段名称
          $sql = "select grade_name from rd_grade where id='$item->grade'";
          $item->grade = $db->get_var($sql);
          //获取是否在书架上的状态
          // $sql = "select count(id) from rd_user_read_book where book_id='$item->id' and user_id='$user_id' and removed=0";
          //查看是否在书单库里
          $sql = "select count(id) from rd_user_read_book where book_id='$item->id' and user_id='$user_id' and removed=0";
          if($db->get_var($sql)>0)
          {
            $item->status = 1;
          }
          else
          {
            $item->status = 0;
          }
          //获取书单类型名称
          $sql = "select name from rd_book_type where id='$item->type'";
          $item->type = $db->get_var($sql);
          $ret[] = $item;
        }
      }
      return $ret;
    }

    /**
    *获取所有书的总页数
    **/
    function get_read_list_pages()
    {
      return $this->read_list_pages;
    }

    /**
    *按关键字搜索书单
    **/
    function search_book_list($keywords,$user_id)
    {
      global $db;
      $now = time();
      $list = $db->get_results("select * from rd_read_list where name like '%".$db->escape($keywords)."%' and endtime>'$now'");
      $ret = [];
      if(count($list) < 1)
      {
        return $ret;
      }
      foreach ($list as $item) {
        $id = $item->id;
        //取书单内第一本书的封面
        $sql = "select a.coverimg from rd_book as a left join rd_book_list as b on ".
                "a.id=b.book_id where list_id='$item->id' limit 1";
        $item->coverimg = $db->get_var($sql);
        //获取书单作者名字
        $sql = "select name from rd_user where id='$item->user_id'";
        $item->author = $db->get_var($sql)==""?"新手":$db->get_var($sql);
        //获取学段名字
        $sql = "select grade_name from rd_grade where id='$item->grade'";
        $item->grade = $db->get_var($sql);
        //获取是否在书架上的状态
        $sql = "select count(id) from rd_user_read_list where book_list_id='$item->id' and user_id='$user_id'";
        if($db->get_var($sql)>0)
        {
          $item->status = 1;
        }
        else
        {
          $item->status = 0;
        }
        $ret[] = $item;
      }
      return $ret;
    }

    /**
    *按关键字查找书籍
    **/
    function search_books($keywords,$user_id)
    {
      global $db;
      $sql  = "select * from rd_book where name like '%".$db->escape($keywords)."%' order by id desc";
      // print $sql;
      @$books = $db->get_results($sql);
      $ret = array();
      if($books)
      {
        foreach ($books as $book)
        {
          $book_id = $book->id;
          $sql = "select count(*) from rd_user_read_book where user_id='$user_id' and book_id='$book_id'".
                  " and removed=0";
          if($db->get_var($sql))
          {
            $book->status = 1;
          }
          else
          {
            $book->status = 0;
          }
          $sql = "select grade_name from rd_grade where id='$book->grade'";
          $book->grade = $db->get_var($sql);
          $ret[] = $book;
        }
      }
      return $ret;
    }

    /**
    *搜索我的任务
    **/
    function search_lists_task($key,$user_id)
    {
      global $db;
      $sql = "select a.* from rd_read_list as a left join rd_user_read_list as b on ".
              "a.id=b.book_list_id where b.user_id='$user_id' and a.name like '%".$db->escape($key)."%' ".
              "order by b.id desc";
      $lists = $db->get_results($sql);
      $temp = [];
      $now = time();
      foreach($lists as $list)
      {
        $list->author = $this->get_list_author($list->user_id);
        $list->coverimg = $this->get_book_list_coverimg($list->id);
        $list->grade = $this->get_book_list_grade($list->grade);
        $list->type = $this->get_book_list_type($list->type);
        $list->restime = $this->get_restime($list->endtime-$now);
        $temp[] = $list;
      }
      return $temp;
    }


    /**
    *搜索我的任务
    *新改逻辑
    **/
    function search_books_task($key,$user_id)
    {
      global $db;
      // $sql = "select a.* from rd_read_list as a left join rd_user_read_list as b on ".
      //         "a.id=b.book_list_id where b.user_id='$user_id' and a.name like '%".$db->escape($key)."%' ".
      //         "order by b.id desc";
      $ret = [];
      $sql = "select a.* from rd_book a left join rd_user_read_book b on a.id=b.book_id where a.name like '%".$db->escape($key)."%' ".
              "order by b.id desc";
      $list_1 = $db->get_results($sql);
      if(count($list_1)>0)
      {
        foreach($list_1 as $book)
        {
          $book->resttime = "自选书单";
          $ret[] = $book;
        }
      }
      // $sql = "select * from rd_book where name like '%".$db->escape($key)."%' ".
      //         " and id in(select book_id from rd_book_list where list_id in (select book_list_id from rd_user_read_list where user_id='$user_id'))";
      $sql = "select a.id from rd_read_list a left join rd_user_read_list b on a.id=b.book_list_id and b.user_id='$user_id'";
      //取出用户所有的书单
      $temp_list = $db->get_results($sql);
      if(count($temp_list)>0)
      {
        foreach($temp_list as $v)
        {
          //取出书单下边所有的书
          $temp_books = $db->get_results("select book_id from rd_book_list where list_id='$v->id'");
          //判断是否相似
          foreach($temp_books as $book)
          {
            $book_name = $db->get_var("select * from rd_book where id='$book'");
            if(strpos($book_name->name,$key)!==false)
            {
              // $book_name->resttime =
            }
          }
        }
      }
      $list_2 = $db->get_results($sql);
      $temp = [];
      $now = time();
      foreach($lists as $list)
      {
        $list->author = $this->get_list_author($list->user_id);
        $list->coverimg = $this->get_book_list_coverimg($list->id);
        $list->grade = $this->get_book_list_grade($list->grade);
        $list->type = $this->get_book_list_type($list->type);
        $list->restime = $this->get_restime($list->endtime-$now);
        $temp[] = $list;
      }
      return $temp;
    }

    /**
    *获取分页数
    **/
    function get_pages()
    {
      return $this->pages;
    }


    /**
    *分页获取我的任务中的所有书单列表
    *grade:0 type:0 status:-1 page:1
    *status 0:测试未通过 1:测试通过 2:未测试
    **/
    function get_lists_task($user_id,$grade,$type,$status,$page)
    {
      global $db;
      $sql = "select a.* from rd_read_list as a left join rd_user_read_list as b on ".
              "a.id=b.book_list_id where b.user_id='$user_id' ";
      if($grade != 0)
      {
        $sql .= "and a.grade='$grade' ";
      }
      if($type != 0)
      {
        $sql .= "and a.type='$type'";
      }
      $sql .= " order by b.id desc";
      // echo $sql;
      // $sql = "select * from rd_book where id in(".
      //         "select a.book_id from rd_book_list as a left join rd_user_read_list as b ".
      //         "on a.list_id=b.book_list_id and b.user_id='$user_id')";
      $lists = $db->get_results($sql);
      if($status != -1)
      {
        $temp = [];
        foreach ($lists as $list) {
          $list_id = $list->id;
          if($status == 0)
          {
            $sql = "select count(id) from rd_read_log where list_id='$list_id' and status=0 and user_id='$user_id'";
            if($db->get_var($sql)>0)
            {
              $temp[] = $list;
            }
          }
          if($status == 1)
          {
            $sql = "select count(id) from rd_read_log where list_id='$list_id' and status=1 and user_id='$user_id'";
            if($db->get_var($sql)>0)
            {
              $temp[] = $list;
            }
          }
          if($status == 2)
          {
            $sql = "select count(id) from rd_read_log where list_id='$list_id' and user_id='$user_id'";
            if($db->get_var($sql)<1)
            {
              $temp[] = $list;
            }
          }
        }
        $lists = $temp;
      }
      //获取书单下边第一本书的封面图片、积分等信息
      $temp = [];
      $now = time();
      if(count($lists))
      {
        foreach($lists as $list)
        {
          $list->author = $this->get_list_author($list->user_id);
          $list->coverimg = $this->get_book_list_coverimg($list->id);
          $list->grade = $this->get_book_list_grade($list->grade);
          $list->type = $this->get_book_list_type($list->type);
          $list->restime = $this->get_restime($list->endtime-$now);
          $temp[] = $list;
        }
        $lists = $temp;
        $page_num = 6;
        $this->pages = ceil(count($lists)/$page_num);
        $start = ($page-1)*$page_num;
        if($start < 0)
        {
          $start = 0;
        }
        return array_slice($lists,$start,$page_num);
      }
      else
      {
        return 0;
      }
    }

    /**
    *分页获取我的任务中的所有书单列表
    *grade:0 type:0 status:-1 page:1
    *status 0:测试未通过 1:测试通过 2:未测试
    **/
    function get_books_task($user_id,$grade,$type,$status,$page)
    {
      global $db;
      // $sql = "select a.* from rd_read_list as a left join rd_user_read_list as b on ".
      //         "a.id=b.book_list_id where b.user_id='$user_id' ";
      $sql = "select a.*,b.addtime,b.endtime,b.type as shelf_type from rd_book a left join rd_user_read_book b on ".
              "a.id=b.book_id where b.removed=0 and b.user_id='$user_id' ";
      if($grade != 0)
      {
        $sql .= "and a.grade='$grade' ";
      }
      if($type!=0 && $type!=-1 && $type!=-2)
      {
        $sql .= "and a.type='$type' ";
      }
      if($type == -1)
      {
        $sql .= "and b.type=1";
      }
      if($type == -2)
      {
        $sql .= "and b.type=0";
      }
      $sql .= " order by b.id desc";
      $lists = $db->get_results($sql);
      if($status != -1)
      {
        $temp = [];
        foreach ($lists as $list) {
          $book_id = $list->id;
          $list->status = $status;
          if($status == 0)
          {
            $sql = "select count(id) from rd_user_exam_scores where book_id='$book_id' and hege=0 and user_id='$user_id'";
            if($db->get_var($sql)>0)
            {
              $temp[] = $list;
            }
          }
          if($status == 1)
          {
            $sql = "select count(id) from rd_user_exam_scores where book_id='$book_id' and hege=1 and user_id='$user_id'";
            if($db->get_var($sql)>0)
            {
              $temp[] = $list;
            }
          }
          if($status == 2)
          {
            $sql = "select count(id) from rd_user_exam_scores where book_id='$book_id' and user_id='$user_id'";
            if($db->get_var($sql)<1)
            {
              $temp[] = $list;
            }
          }
        }
        $lists = $temp;
      }
      else
      {
        $temp = [];
        if(count($lists)>0)
        {
          foreach ($lists as $list)
          {
            $book_id = $list->id;
            $sql = "select count(id) from rd_user_exam_scores where book_id='$book_id' and user_id='$user_id'";
            if($db->get_var($sql)<1)
            {
              $list->status = 2;
            }
            else
            {
              $list->status = $db->get_var("select hege from rd_user_exam_scores where book_id='$book_id' and user_id='$user_id'");
            }
            $temp[] = $list;
          }
        }
      }
      //获取书单下边第一本书的封面图片、积分等信息
      $temp = [];
      $now = time();
      if(count($lists))
      {
        foreach($lists as $list)
        {
          if($list->shelf_type!=0)
          {
              $list->restime = $this->get_restime($list->endtime-$now);
          }
          else
          {
            $list->restime = "自选不过期";
          }
          $temp[] = $list;
        }
        $lists = $temp;
        $page_num = 6;
        $this->pages = ceil(count($lists)/$page_num);
        $start = ($page-1)*$page_num;
        if($start < 0)
        {
          $start = 0;
        }
        return array_slice($lists,$start,$page_num);
      }
      else
      {
        return 0;
      }
    }


    /**
    *获取书单的剩余时间
    **/
    function get_restime($res)
    {
      if($res < 0)
      {
        return "<font style='color:red;'>已过期</font>";
      }
      return ceil($res/(24*60*60))."天";
    }

    /**
    *获取书单的类型名称
    **/
    function get_book_list_type($type)
    {
      global $db;
      return $db->get_var("select name from rd_list_type where id='$type'");
    }

    /**
    *获取书单的学段名称
    **/
    function get_book_list_grade($grade)
    {
      global $db;
      return $db->get_var("select grade_name from rd_grade where id='$grade'");
    }

    /**
    *获取书单下第一本书的封面
    *id:书单的ID
    **/
    function get_book_list_coverimg($id)
    {
      global $db;
      $sql = "select a.coverimg from rd_book as a left join rd_book_list as b ".
              "on a.id=b.book_id where b.list_id='$id' order by b.id desc limit 1";
      return $db->get_var($sql);
    }

    /**
    *获取书单的作者名字
    **/
    function get_list_author($id)
    {
      global $db;
      $name = $db->get_var("select name from rd_user where id='$id'");
      if($name)
      {
        return $name;
      }
      else
      {
        return "新手";
      }
    }

    /**获取书单列表下所有的书**/
    function get_book_list_books($list_id)
    {
      global $db;
      $sql = "select a.* from rd_book as a left join rd_book_list as b on a.id=b.book_id ".
              "where b.list_id='$list_id'";
      $ret = $db->get_results($sql);
      if($ret)
      {
        return $ret;
      }
      else
      {
        return [];
      }
    }

    /**
    *获取任务列表下所有的书
    **/
    function get_task_list_books($user_id,$list_id)
    {
      global $db;
      $sql = "select a.* from rd_book as a left join rd_book_list as b on a.id=b.book_id ".
              "where b.list_id='$list_id'";
      $ret = $db->get_results($sql);
      if($ret)
      {
        foreach($ret as $item)
        {
          $book_id = $item->id;
          // $sql = "select count(id) from rd_read_log where user_id='$user_id' and list_id='$list_id' ".
          //         "and book_id='$book_id'";
          $sql = "select count(id) from rd_user_exam_scores where user_id='$user_id' and book_id='$book_id'";
          if($db->get_var($sql))//做过了则检查是否合格
          {
            // $sql = "select status from rd_read_log where user_id='$user_id' and list_id='$list_id' ".
            //         "and book_id='$book_id'";
            $sql = "select hege from rd_user_exam_scores where user_id='$user_id' and book_id='$book_id' order by id desc limit 1";
            $item->status = $db->get_var($sql);
          }
          else
          {
            $item->status = 2;
          }
        }
        return $ret;
      }
      else
      {
        return [];
      }
    }

    /**
    *获取书单列表的名称
    **/
    function get_list_name($list_id)
    {
      global $db;
      return $db->get_var("select name from rd_read_list where id='$list_id'");
    }

    /**
    *检查书单列表是否属于当前用户
    **/
    function check_illegal_task($user_id,$task)
    {
      global $db;
      $sql = "select count(id) from rd_user_read_list where user_id='$user_id' and book_list_id='$task'";
      if($db->get_var($sql)>0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    /**
    *分页获取教师的所有书单
    **/
    function get_teacher_read_list($user_id,$page)
    {
      global $db;
      $page_num = 6;
      $start = ($page-1)*$page_num;
      $end = $start + $page_num;
      $sql = "select * from rd_read_list where user_id='$user_id' order by id desc limit $start,$end";
      $results = $db->get_results($sql);
      $ret = [];
      if($results)
      {
        foreach($results as $item)
        {
          //获取书单下的第一本书封面
          $item->coverimg = $this->get_book_list_coverimg($item->id);
          $item->restime = $this->get_restime($item->endtime-time());
          $item->author = $this->get_list_author($item->user_id);
          $item->grade = $this->get_book_list_grade($item->grade);
          $ret[] = $item;
        }
      }
      //获取最大页数
      $sql = "select count(*) from rd_read_list where user_id='$user_id'";
      $this->pages = ceil($db->get_var($sql)/$page_num);
      return $ret;
    }

    /**
    *按学段分页获取教师书单
    **/
    function get_teacher_list_by_grade($user_id,$grade,$page)
    {
      global $db;
      $page_num = 6;
      $start = ($page-1)*$page_num;
      $end = $start + $page_num;
      $grade = $grade>0?$grade:1;
      $sql = "select * from rd_read_list where user_id='$user_id' and grade='$grade' order by id desc limit $start,$end";
      $results = $db->get_results($sql);
      $ret = [];
      if($results)
      {
        foreach($results as $item)
        {
          //获取书单下的第一本书封面
          $item->coverimg = $this->get_book_list_coverimg($item->id);
          $item->restime = $this->get_restime($item->endtime-time());
          $item->author = $this->get_list_author($item->user_id);
          $item->grade = $this->get_book_list_grade($item->grade);
          $ret[] = $item;
        }
      }
      //获取最大页数
      $sql = "select count(*) from rd_read_list where user_id='$user_id' and grade='$grade'";
      $this->pages = ceil($db->get_var($sql)/$page_num);
      return $ret;
    }

    /**
    *按书单id获取教师书单管理的书
    **/
    function get_teacher_list_by_id($user_id,$id,$page)
    {
      global $db;
      $page_num = 6;
      $start = ($page-1)*$page_num;
      $end = $start + $page_num;
      if($db->get_var("select count(id) from rd_read_list where id='$id' and user_id='$user_id'")>0)
      {
        $sql = "select a.* from rd_book a left join rd_book_list b on a.id=b.book_id where b.list_id='$id' limit $start,$end";
        $sql_1 = "select count(*) from rd_book a left join rd_book_list b on a.id=b.book_id where b.list_id='$id'";
        $this->pages = ceil($db->get_var($sql_1)/$page_num);
        $ret = $db->get_results($sql);
        foreach ($ret as $r)
        {
          $book_id = $r->id;
          $classes = $db->get_results("select id from rd_class where teacher_id='$user_id'");
          $r->num = 0;
          if(count($classes)>0)
          {
            foreach ($classes as $class) {
              $class_id = $class->id;
              $sql = "select count(*) from rd_user_exam_scores where book_id='$book_id' and user_id ".
                      "in(select id from rd_user where class='$class_id')";
              $r->num += $db->get_var($sql);
            }
          }
          else
          {
            $r->num = 0;
          }
        }
        return $ret;
      }
      else
      {
        $this->pages = 1;
        return 0;
      }
    }

    /**
    *获取教师书单管理里的所有的书
    **/
    function get_teacher_book_list($user_id,$page)
    {
      global $db;
      $page_num = 6;
      $start = ($page-1)*$page_num;
      $end = $start + $page_num;
      $sql = "select a.* from rd_book a left join rd_book_list b on a.id=b.book_id where b.list_id in ".
              "(select id from rd_read_list where user_id='$user_id') order by b.id desc";
      $sql_1 = "select count(*) from rd_book a left join rd_book_list b on a.id=b.book_id where b.list_id in ".
              "(select id from rd_read_list where user_id='$user_id')";
      $this->pages = ceil($db->get_var($sql_1)/$page_num);
      $ret = array_slice($db->get_results($sql),$start,$page_num);
      foreach($ret as $r)
      {
        $book_id = $r->id;
        $classes = $db->get_results("select id from rd_class where teacher_id='$user_id'");
        $r->num = 0;
        if(count($classes)>0)
        {
          foreach ($classes as $class) {
            $class_id = $class->id;
            $sql = "select count(*) from rd_user_exam_scores where book_id='$book_id' and user_id ".
                    "in(select id from rd_user where class='$class_id')";
            $r->num += $db->get_var($sql);
          }
        }
        else
        {
          $r->num = 0;
        }
      }
      return $ret;
    }


    /**
    *按关键字搜索教师书单中的书
    **/
    function get_teacher_books_by_keywords($user_id,$keywords)
    {
      global $db;
      $sql = "select a.* from rd_book a left join rd_book_list b on a.id=b.book_id where b.list_id in ".
              "(select id from rd_read_list where user_id='$user_id') and a.name like '%".$db->escape($keywords)."%'";
      $ret = $db->get_results($sql);
      foreach($ret as $r)
      {
        $book_id = $r->id;
        $classes = $db->get_results("select id from rd_class where teacher_id='$user_id'");
        $r->num = 0;
        if(count($classes)>0)
        {
          foreach ($classes as $class) {
            $class_id = $class->id;
            $sql = "select count(*) from rd_user_exam_scores where book_id='$book_id' and user_id ".
                    "in(select id from rd_user where class='$class_id')";
            $r->num += $db->get_var($sql);
          }
        }
        else
        {
          $r->num = 0;
        }
      }
      return $ret;
    }

    /**
    *根据关键字搜索教师的书单
    **/
    function get_teacher_list_by_keywords($user_id,$keywords)
    {
      global $db;
      $sql = "select * from rd_read_list where user_id='$user_id' and ".
              "name like '%".$db->escape($keywords)."%' order by id desc";
      $results = $db->get_results($sql);
      $ret = [];
      if($results)
      {
        foreach($results as $item)
        {
          //获取书单下的第一本书封面
          $item->coverimg = $this->get_book_list_coverimg($item->id);
          $item->restime = $this->get_restime($item->endtime-time());
          $item->author = $this->get_list_author($item->user_id);
          $item->grade = $this->get_book_list_grade($item->grade);
          $ret[] = $item;
        }
      }
      return $ret;
    }

    /**
    *输出报错信息
    **/
    function tips($tips)
    {
      echo '<center><img src="img/gongchengshi.jpeg" style="margin-top:20px;"/><br>'.
            '<p class="gray" id="tips">'.$tips.'...</p></center>';
    }

    /**
    *获取学校名字
    **/
    function get_school_name($id)
    {
      global $db;
      $sql = "select schoolname from rd_school where id='$id'";
      return $db->get_var($sql);
    }

    /**
    *检查学校是否合法
    **/
    function check_school($school)
    {
      global $db;
      $sql = "select count(id) from rd_school where id='$school'";
      if($db->get_var($sql)>0)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }

    /**
    *检查年级是否合法
    **/
    function check_grade($grade)
    {
      global $db;
      $sql = "select count(id) from rd_grade where id='$grade'";
      if($db->get_var($sql)>0)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }

    /**
    *检查班级是否合法
    **/
    function  check_class($id)
    {
      global $db;
      $sql = "select count(id) from rd_class where id='$id'";
      if($db->get_var($sql)>0)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }

    /**
    *获取所有学校的名字和id
    **/
    function get_all_school()
    {
      global $db;
      $sql = "select * from rd_school order by id desc";
      return $db->get_results($sql);
    }

}
?>
