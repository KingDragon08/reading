<?php
class Book
{
  var $book_id = -1;
  var $book_comment_pages = 1;

  /**
  *init funciton
  **/
  function Book($id)
  {
    global $db;
    $sql = "select count(*) from rd_book where id='".$db->escape($id)."'";
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
      $sql = "select * from rd_book where id='$this->book_id'";
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
    $sql = "insert into rd_book_review(book_id,user_id,content,addtime)values(".
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
    $sql = "select count(*) from rd_book_review where book_id='$this->book_id'";
    $total = $db->get_var($sql);
    $page_num = 8;
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
    $sql = "select * from rd_book_review where book_id='$this->book_id'".
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

}
?>
