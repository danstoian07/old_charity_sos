<?php
	
	session_start();
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ( (isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {    	
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');

    	spl_autoload_register("autoload_backend_classes");

    	if( isset($_REQUEST['lang']) ) { $lang = $_REQUEST['lang']; } else { $lang='';}         /* language code. Ex: ro */
    	if (!empty($lang)) {

            $data['lang'] = $lang;
            $json         = json_encode($data);
            $WHERE        ="id_item= '".el_decript_info($_SESSION[APP_ID]["user"]["id"])."' AND id_archive=10";
            el_update_json_settings($oDB, $WHERE, $json);                         
    	}
    }

    if( isset($_REQUEST['redirect']) ) { $redirect = urldecode($_REQUEST['redirect']); } else { $redirect = __ADMINURL__; } 
    el_redirect($redirect);

?>