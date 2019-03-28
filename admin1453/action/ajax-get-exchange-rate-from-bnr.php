<?php
	session_start();    
	$ERROR     = false;
	$ERROR_MSG = '';
	$ro_date   = '';
	$valute    = 0;
	$CURRENCY  = '';
	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
    	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    	spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = _('Eroare: Utilizator Nelogat');
	}	
	
	if (!$ERROR) {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			$ERROR = true; $ERROR_MSG = 'Eroare POST';
		}
	}	
	if (!$ERROR) {
		if ( isset($_REQUEST['ro_date']) ) { $ro_date = urldecode($_REQUEST['ro_date']); }
		if (empty($ro_date)) {
			$ERROR = true; $ERROR_MSG = 'Trebuie sa specificati data';
		}
	}
	if (!$ERROR) {
		if (!el_ValidRomanianDate($ro_date)) {
			$ERROR = true; $ERROR_MSG = 'Format data invalid';
		}
	}
	if (!$ERROR) {
		if ( isset($_REQUEST['valute']) ) { $valute = urldecode($_REQUEST['valute']); }
		/* 1 - EUR, 2 -USD, 3 - GBP, 4 - CHF */
		if (($valute!=1) && ($valute!=2) && ($valute!=3) && ($valute!=4)) {
			$ERROR = true; $ERROR_MSG = 'Cod valuta necunoscut';
		}
		if (!$ERROR) {
			switch ($valute) {
				case  1: $CURRENCY  = 'EUR'; break;
				case  2: $CURRENCY  = 'USD'; break;
				case  3: $CURRENCY  = 'GBP'; break;
				case  4: $CURRENCY  = 'CHF'; break;
			}
		}
	}
	
	$records = array();	
	if (!$ERROR) {		
		/* de determina ziua precedenta datei */
		$eng_date = el_RomanianDate_To_MysqlDate($ro_date);
		$date = new DateTime($eng_date);
		$date->modify('-1 day');
		$ro_date = $date->format('d-m-Y');
		$json_info = el_get_currency_rate($ro_date);		
		$arr_info = json_decode($json_info, true);		
		if (!empty($arr_info['ERROR'])) {
			$ERROR = true; $ERROR_MSG = $arr_info['ERROR'];
		}
	}
	
	$records["error"]      = $ERROR_MSG;	
	if (!$ERROR) {
		$records["exchange_rate"]    = $arr_info["array"]["$CURRENCY"]["exchange"];
		$records["multiplier"]       = $arr_info["array"]["$CURRENCY"]["multiplier"];
		$records["ro_date_exchange"] = $arr_info["ro_date_exchange"];
	}	

	
	echo json_encode($records);					
	
?>