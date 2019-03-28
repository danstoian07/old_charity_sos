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
		$ID_LOGGED_USER = el_decript_info($_SESSION[APP_ID]["user"]["id"]);
		$year   = date("Y"); $month = date("n");
		$ONLINE_TIME = AJAX_TIME_SET_ONLINE_USER_STATUS/1000;
		$multiple_query  = "
			UPDATE $oDB->users SET last_seen=	NOW() WHERE id=$ID_LOGGED_USER;	
			UPDATE $oDB->users_track SET seconds_logged = seconds_logged+$ONLINE_TIME WHERE idma=$ID_LOGGED_USER AND year=$year AND month=$month;";
		$result = $oDB->db_multiquery($multiple_query);
		$oDB->db_next_result();		
		adm_StoreTrackingInfoToBD();
	}
?>