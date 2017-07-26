<?php
class Book_short
{
  var $book_id = -1;
  var $book_comment_pages = 1;

  /**
  *init funciton
  **/
  function Book_short($id)
  {
    global $db;
    $sql = "select count(*) from rd_book_short where id='".$db->escape($id)."'";
    $c = $db->get_var($sql);
    if($c > 0)
    {
      $this->book_id = intval($id);
    }
  }

  /**
  *获取书本的id号
  **/
  function get_book_id()
  {
    return $this->book_id;
  }

  /**
  *获取书本的详细信息
  **/
  function get_book_info()
  {
    global $db;
    if($this->book_id == -1)
    {
      return "";
    }
    else
    {
      $sql = "select * from rd_book_short where id='$this->book_id'";
      return $db->get_row($sql);
    }
  }

  /**
  *写书评
  **/
  function add_comment($user_id,$comment)
  {
    global $db;
    $addtime = time();
    $sql = "insert into rd_book_short_review(book_id,user_id,content,addtime)values(".
            "'$this->book_id','$user_id','".$db->escape($comment)."','$addtime')";
    $db->query($sql);
  }

  /**
  *获取一本书的书评
  **/
  function get_book_comment($page)
  {
    if($this->book_id == -1)
    {
      return "";
    }
    global $db;
    //获取所有书评的总数
    $sql = "select count(*) from rd_book_short_review where book_id='$this->book_id'";
    $total = $db->get_var($sql);
    $page_num = 2;
    $this->book_pages = ceil($total/$page_num);
    if($page < 1)
    {
      $page = 1;
    }
    if($page > ceil($total/$page_num))
    {
      $page = ceil($total/$page_num);
    }
    $start = ($page-1)*$page_num;
    if($start<1)
    {
      $start = 0;
    }
    $sql = "select * from rd_book_short_review where book_id='$this->book_id'".
            " order by addtime desc limit $start,$page_num";
    $comments = $db->get_results($sql);
    $ret = array();
    if(count($comments)<1)
    {
      return $ret;
    }
    foreach($comments as $comment)
    {
      $name = $db->get_var("select name from rd_user where id='$comment->user_id'");
      if($name == "")
      {
        $name = "新手";
      }
      $comment->username = $name;
      $comment->addtime = date("Y-m:d H:i:s",$comment->addtime);
      $ret[] = $comment;
    }
    return $ret;
  }

  /**
  *获取书评分页的总数
  **/
  function get_book_comment_pages()
  {
    return $this->book_pages;
  }

  /**
  *获取读书笔记题目
  **/
  function get_book_note()
  {
    global $db;
    $id = $this->book_id;
    $sql = "select id,question from rd_read_note_short where book_id=$id";
    return $db->get_results($sql);
  }

  /**
  *获取是否已经答过读书笔记
  **/
  function check_note($user_id)
  {
    global $db;
    $sql = "select count(id) from rd_read_note_short_answer where user_id='$user_id' and book_id='".$this->book_id."'";
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
  *获取推荐书籍
  **/
  function get_related_book()
  {
    global $db;
    $book = $this->book_id;
    $sql = "select id,name,coverimg from rd_book_short where id in(select rec_book_id from rd_book_short_recommend where book_id=$book)";
    $books= $db->get_results($sql);
    return $books;
  }

  /**
  *获取用户提交的读书笔记的答案
  **/
  function get_book_note_answers($user_id)
  {
    global $db;
    $book_id = $this->book_id;
    $sql = "select answer from rd_read_note_answer where book_id=$book_id and user_id=$user_id";
    $answers = $db->get_results($sql);
    return $answers;
  }

}
?>
