<?php
    session_start();
    
    if (defined(APP_DEBUG)) { if (APP_DEBUG) {error_reporting(E_ALL); ini_set('display_errors', 1); } else {error_reporting(0);}}        

    require_once('app-top.php');
    require_once('app-config.php');
    require_once('app-functions.php');

    spl_autoload_register("autoload_frontend_classes");

	try {
		$objApp = new AppMain();
		$objApp->Run();
	}	
	catch(Exception $e) {
		  $oErr->exceptionHandler($e);
	}

?>