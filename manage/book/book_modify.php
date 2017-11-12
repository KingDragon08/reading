<?php
require ('../include/init.inc.php');
$book_id = $book_name = $author_name = $press = $presstime  = $book_type = $grade_id = $level = $score = $wordcount = $bookdesc = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($_POST);
// exit();
Common::checkParam($book_id);
$book = Book::getBookById ( $book_id );
// var_dump($book);
if(empty($book)){
	Common::exitWithError(ErrorMessage::USER_NOT_EXIST,"book/books.php");
}
if (Common::isPost ()) {
	if($book_name=="" || $author_name==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{

		$imgpath = '';
		if (!empty($_FILES['coverimg'])) {
			if ($_FILES['coverimg']['error'] != 0) {
				$message = '上传文件失败,error number('.$_FILES['coverimg']['error'].')';
				OSAdmin::alert("error",$message);
			}
			$up = new FileUpload;
		    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
		    $up -> set("path", "../uploads/");
		    $up -> set("maxsize", 2000000);
		    $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
		    $up -> set("israndname", true);

		    //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
		    if($up -> upload("coverimg")) {
		        //获取上传后文件名子
				$imgpath = "https://www.lezhireading.com/manage/uploads/".$up->getFileName();

		    } else {
		        //获取上传失败以后的错误提示
				OSAdmin::alert("error",$up->getErrorMsg());
		    }
		}

		$update_data = array ('name' => $book_name,
							'author' => $author_name,
							'press' => $press,
							'presstime' => strtotime($presstime),
							'bookdesc' => $bookdesc,
							'type' => $book_type,
							'score' => $score,
							'grade' => $grade_id,
							'level' => $level,
							'wordcount' => $wordcount,
						 );

		 if (! empty ( $imgpath )) {
 			$update_data = array_merge ( $update_data, array ('coverimg' => $imgpath ) );
 		}
		$result = Book::updateBook ( $book_id,$update_data );

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'book' , $book_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','book/books.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}

$book_type_options = BookType::getGroupForOptions();
$grade_options = Grade::getGradeForOptions();

Template::assign("_POST" ,$_POST);
Template::assign ( 'book_type_options', $book_type_options );
Template::assign ( 'grade_options', $grade_options );
Template::assign ( 'book', $book );
Template::display ( 'book/book_modify.tpl' );
