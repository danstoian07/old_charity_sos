<?php
	session_start();    
	$ERROR     = false;
	$ERROR_MSG = 'ok';
    
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    	//spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = 'Eroare: Utilizator Nelogat';
	}	
	if (!$ERROR) {
		$AJAX_SEC_GET_USERS_STATUS_LIST = AJAX_TIME_GET_USERS_STATUS_LIST/1000;
		$query     = "
			SELECT id, name, phone, email, type, photo, type_association, last_login, IF(TIME_TO_SEC(TIMEDIFF(NOW(), last_seen))<=$AJAX_SEC_GET_USERS_STATUS_LIST,1,0) AS is_online 
			FROM $oDB->users 
			WHERE active=1 
			ORDER BY is_online DESC, last_login ASC";
		$result    = $oDB->db_query($query);
		$users_list = '';		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$users_list .= '
				<li class="media">
					'.($result_line['is_online'] ? '<div class="media-status"><span class="badge badge-success">online</span></div>' : '').'
					<img class="media-object" src="'.(!empty($result_line['photo']) ? adm_thumb_image($result_line['photo'],45,45) : __THEMEURL__.'assets/layouts/layout/img/user-icon.jpg').'" alt="">
					<div class="media-body">
						<h4 class="media-heading">'.$result_line['name'].'</h4>
						<div class="media-heading-sub"> '.adm_tip_colaborare($result_line['type_association']).' </div>
						<div class="media-heading-sub2"> Ultimul Login: '.el_MysqlDateTime_To_RomanianShortDate_Literal($result_line['last_login']).' </div>
					</div>
				</li>'.PHP_EOL;
		}
		$query = "UPDATE $oDB->users SET users_status_list ='".addslashes(stripslashes($users_list))."' WHERE id=".el_decript_info($_SESSION[APP_ID]["user"]["id"]);
		$result    = $oDB->db_query($query);
	}
	echo $users_list;
?>