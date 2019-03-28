<?php

  require_once('app-config.php');  
  require_once('include'.DIRECTORY_SEPARATOR.'general.php');
  require_once('app-functions.php');
  
  spl_autoload_register("autoload_frontend_classes");
  

$oErr = new errorhandler();
try {
    $oDB    = new db( DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, DB_SERVER );
}	
catch(Exception $e) {
	  $oErr->exceptionHandler($e);
}

?>
