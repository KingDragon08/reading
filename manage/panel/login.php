<?php
require ('../include/init.inc.php');
// echo 'str';
// exit();
$user_name = $password = $remember = $verify_code = '';
// var_dump($user_name);
// exit();
extract ( $_POST, EXTR_IF_EXISTS );
// var_dump(Common::isPost());
if (Common::isPost()) {
    // echo "string";
	if(strtolower($verify_code) != strtolower($_SESSION['osa_verify_code'])){
		OSAdmin::alert("error",ErrorMessage::VERIFY_CODE_WRONG);
	}else{
		$user_info = User::checkPassword ( $user_name, $password );
        // var_dump($user_info);

		if ($user_info) {
			if($user_info['status']==1){


				if($remember){
					echo $user_info['user_id'];
					$encrypted = OSAEncrypt::encrypt($user_info['user_id']);
					User::setCookieRemember(urlencode($encrypted),30);
				}

				User::loginDoSomething($user_info['user_id']);
				$ip = Common::getIp();
				SysLog::addLog ( $user_name, 'LOGIN', 'User' ,UserSession::getUserId(),json_encode(array("IP" => $ip)));
				Common::jumpUrl ( 'panel/index.php' );
			}else{
				OSAdmin::alert("error",ErrorMessage::BE_PAUSED);
			}
		} else {
			OSAdmin::alert("error",ErrorMessage::USER_OR_PWD_WRONG);
			SysLog::addLog ( $user_name, 'LOGIN','User' ,'' , json_encode(ErrorMessage::USER_OR_PWD_WRONG) );
		}
	}
}
Template::assign ( '_POST',$_POST );
Template::assign ( 'page_title','登入' );
Template::Display ( 'login.tpl' );
// echo "string";
