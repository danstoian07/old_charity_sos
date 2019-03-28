<?php
	
	session_start();

    require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
    require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    require_once('..'.DIRECTORY_SEPARATOR.'functions.php');

    spl_autoload_register("autoload_backend_classes");
	 
	$objApp = new App();
    $objApp->Login();  	
?>