<?php
	session_start();    
	$ERROR     = false;
	$ERROR_MSG = '';		
	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {    	
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    	spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = 'Eroare: Utilizator Nelogat';
	}	
	if (!$ERROR) {
		/* $jcolors - urlencoded json with color shema */
		if ( isset($_REQUEST['jcolors']) )    { $jcolors    = $_REQUEST['jcolors']; } else { 
			$ERROR = true; $ERROR_MSG = 'Lipsa schema culori';
		}
	}
	if (!$ERROR) {
		$json_colors = stripslashes(urldecode($jcolors));
		if (el_valid_json($json_colors)) {
			$id_user = el_decript_info($_SESSION[APP_ID]["user"]["id"]);
			$query = "UPDATE $oDB->users SET json_calendar_colors='$json_colors' WHERE id=$id_user";
			$result    = $oDB->db_query($query);
		}		
	}
	el_redirect(__ADMINURL__.'?pn=4&archtype=calendar');
?>