<?php
    session_start();
    
    //if (defined(APP_DEBUG)) { if (APP_DEBUG) {error_reporting(E_ALL); ini_set('display_errors', 1); } else {error_reporting(0);}}        

    require_once('..'.DIRECTORY_SEPARATOR.'app-top.php');
    require_once('config.php');
    require_once('functions.php');

    spl_autoload_register("autoload_backend_classes");

try {
    $objApp = new App();
    $objApp->Run();
}	
catch(Exception $e) {
	  $oErr->exceptionHandler($e);
}

?>