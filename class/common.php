<?php
class Common
{

    var $book_pages = 1;//所有书的分页总数
    var $pages = 1;//其他分页

    function Common()
    {

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
      //获取所有书的总数
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
      $this->book_pages = ceil($total/$page_num);
      $start = ($page-1)*$page_num;
      if($start < 1)
      {
        $start = 0;
      }
      $sql_1 .= " order by id desc limit $start,$page_num";
      $books = $db->get_results($sql_1);
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
    *获取所有书的总页数
    **/
    function get_book_pages()
    {
      return $this->book_pages;
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
    *分页搜索我的任务中的书
    **/
    function search_books_task($key,$user_id,$page)
    {
      global $db;
      $sql = "select * from rd_book where name like '%".$db->escape($key)."%' and id in(".
              "select a.book_id from rd_book_list as a left join rd_user_read_list as b ".
              "on a.list_id=b.book_list_id and b.user_id='$user_id')";
      // echo $sql;
      $books = $db->get_results($sql);
      $page_num = 6;
      $this->pages = ceil(count($books)/$page_num);
      $start = ($page-1)*$page_num;
      if($start < 0)
      {
        $start = 0;
      }
      return array_slice($books,$start,$page_num);
    }

    /**
    *获取分页数
    **/
    function get_pages()
    {
      return $this->pages;
    }


    /**
    *分页获取我的任务中的所有书籍
    **/
    function get_books_task($user_id,$grade,$type,$status,$page)
    {
      global $db;
      $sql = "select * from rd_book where id in(".
              "select a.book_id from rd_book_list as a left join rd_user_read_list as b ".
              "on a.list_id=b.book_list_id and b.user_id='$user_id')";
      $books = $db->get_results($sql);
      $page_num = 6;
      $this->pages = ceil(count($books)/$page_num);
      $start = ($page-1)*$page_num;
      if($start < 0)
      {
        $start = 0;
      }
      return array_slice($books,$start,$page_num);
    }

}
?>
