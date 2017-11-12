<?php
require('../include/init.inc.php');

$form_token = $type = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($_FILES);
$title = $excel_array = '';
$token = $_SESSION['batch_upload_token'];

switch ($type) {
	case 'book':
		$title = '批量添加图书';
		break;

	case 'objques':
		$title = '批量添加客观题';
		break;

	case 'subques':
		$title = '批量添加主观题';
		break;

	default:
		$title = '';
		break;
}

if (Common::isPost () && checkToken($token, $form_token)) {
	// var_dump('post');
	if (empty($_FILES['excel'])) {
		OSAdmin::alert('error', 'empty file');
	} else {
		if ($_FILES['excel']['error'] != 0) {
			$message = '上传文件失败,error number('.$_FILES['excel']['error'].')';
			OSAdmin::alert("error",$message);
		}
		$file = $_FILES['excel']['tmp_name'];
		echo $file;
		// var_dump($file);
		$excel_array = ExcelReader::readXLS($file);

		// var_dump($excel_array);
		switch ($type) {
			case 'book':
				$res = batchAddBooks($excel_array);
				break;

			case 'objques':
				$res = batchAddObjQues($excel_array);
				break;

			case 'subques':
				$res = batchAddSubQues($excel_array);
				break;

			default:
				$res = '';
				break;
		}

		// var_dump($res);
		// $output = print_r($excel_array,true);
		$output = print_r($res, true);
		// Template::assign("title", $title);
		// // Template::assign("_POST", $_POST);
		// Template::assign("output", $output);
		// Template::display('user/read_res.tpl');
		// Common::exitWithSuccess ( '已删除','book/books.php' );
		// exit();
		// $_REQUEST = array();
		unset($_SESSION['batch_upload_token']);
		// $form_token
		// Template::assign("output", $output);
		// Template::display('user/read_excel.tpl');
		// $_SESSION['batch_upload_token'] = '';
	}
}
else {
	$form_token = time();
	$_SESSION['batch_upload_token'] = generateToken($form_token);
}

// var_dump($token);
// Template::assign("title", $title);
Template::assign("form_token", $form_token);
Template::assign("title", $title);
// Template::assign("_POST", $_POST);
Template::assign("output", $output);
Template::display('user/read_excel.tpl');


function batchAddBooks($batch_data)
{
	// $ret = array();
	$suc = 0;
	$err = 0;
	$fail = array();

	$len = count($batch_data);
	if (empty($batch_data)) {
		return '';
	}
	if ($len < 2) {
		return '无内容添加';
	}
	for ($i=1; $i < $len; $i++) {
		$info = $batch_data[$i];
		$data = array(
			// 'id' => 1,
			'name' => $info[0],
			'author' => $info[1],
			'press' => $info[2],
			'presstime' => strtotime($info[3]),
			'bookdesc' => $info[4],
			'coverimg' => $info[5],
			'type' => $info[6],
			'list_type' => $info[7],
			'score' => $info[8],
			'level' => $info[9],
			'grade' => $info[10],
			'wordcount' => $info[11],
			'addtime' => time(),
		);
		$res = Book::addBook($data);
		if ($res) {
			$suc++;
		}
		else {
			$err++;
			$fail[] = implode(',', $data);
		}
		// var_dump($data);
	}
	// $ret = '成功添加'.$suc;
	return composeMsg($suc, $err, $fail);
}


function batchAddObjQues($batch_data)
{
	// $ret = array();
	$suc = 0;
	$err = 0;
	$fail = array();

	$len = count($batch_data);
	if (empty($batch_data)) {
		return '';
	}
	if ($len < 2) {
		return '无内容添加';
	}
	var_dump($batch_data);
	for ($i=1; $i < $len; $i++) {
		$info = $batch_data[$i];
		$data = array(
			'book_id' => $info[0],
			'question' => $info[1],
			'choice1' => $info[2],
			'choice2' => $info[3],
			'choice3' => $info[4],
			'choice4' => $info[5],
			'answer' => $info[6],
			'view' => $info[7],
			'addtime' => time(),
		);
		$res = Question::addInfo($data);
		if ($res) {
			$suc++;
		}
		else {
			$err++;
			$fail[] = implode(',', $data);
		}
		// var_dump($data);
	}
	// $ret = '成功添加'.$suc;
	return composeMsg($suc, $err, $fail);
}


function batchAddSubQues($batch_data)
{
	// $ret = array();
	$suc = 0;
	$err = 0;
	$fail = array();

	$len = count($batch_data);
	if (empty($batch_data)) {
		return '';
	}
	if ($len < 2) {
		return '无内容添加';
	}
	for ($i=1; $i < $len; $i++) {
		$info = $batch_data[$i];
		$data = array(
			// 'id' => 1,
			'book_id' => $info[0],
			'question' => $info[1],
			'addtime' => time(),
		);
		$res = Objques::addInfo($data);
		if ($res) {
			$suc++;
		}
		else {
			$err++;
			$fail[] = implode(',', $data);
		}
		// var_dump($data);
	}
	// $ret = '成功添加'.$suc;
	return composeMsg($suc, $err, $fail);
}


function composeMsg($suc, $err, $fail)
{
	$msg = '<br>添加成功'.$suc.'条<br><br>';
	$msg .= '添加失败'.$err.'条<br><br>';
	$msg .= implode('<br>', $fail);
	return $msg;
}

function checkToken($token, $form_token)
{
	return $token == generateToken($form_token);
}

function generateToken($form_token)
{
	return md5($_SESSION['osa_verify_code'].$form_token);
}
