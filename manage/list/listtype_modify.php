<?php
require ('../include/init.inc.php');
$type_id = $type_name = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );

Common::checkParam($type_id);
$types = ListType::getInfoById ( $type_id );
// var_dump($types);
// exit();
if(empty($types)){
	Common::exitWithError('书单类型不存在',"list/listtype.php");
}

if (Common::isPost()) {
	if($type_name =="" || (empty($type_id)) ){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		// var_dump($grade_name);
		$update_data = array ('name' => $type_name);

		$result = ListType::updateType ( $type_id, $update_data );
        // var_dump($result);

		if ($result) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'listtype' , $type_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','list/listtype.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}
// echo "string";

Template::assign ( 'types', $types );
Template::display ( 'list/listtype_modify.tpl' );
