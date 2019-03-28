<?php
	
	session_start();
    
    require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
    require_once('..'.DIRECTORY_SEPARATOR.'config.php');
   	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
   	spl_autoload_register("autoload_backend_classes");	
	
	adm_AddTrackingInfo('Logout utilizator');
	adm_StoreTrackingInfoToBD();
    
    unset($_SESSION[APP_ID]["user"]);
	unset($_SESSION['unique_app_id']);
	unset($_SESSION['enc_string']);
	
    el_redirect(__ADMINURL__);
?>