<?php
	session_start();    
	$ERROR     = false;
    $ERROR_MSG = 'ok';	
	
	$archtype  = '';
	$pn        = '';
	$id        = '';
	$redirect  = '';
	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    	spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = _('Eroare: Utilizator Nelogat');
	}	
	/* --------- */
	if (!$ERROR) {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			$ERROR = true; $ERROR_MSG = _('Eroare POST');
		}
	}
    /* --------- */
	if (!$ERROR) {
		if (!$ERROR) {
			if (isset($_REQUEST['id'])) {$id = $_REQUEST['id'];} else { $ERROR=true; $ERROR_MSG =_('Eroare ID');}
		}		
    }
    /* --------- */
	if (!$ERROR) {
		if( isset($_REQUEST['tab_class']) ) { $tab_class = $_REQUEST['tab_class']; }  else { $tab_class = ''; } 		
		if (!empty($tab_class)) {			
			$class_name  = el_decript_info($tab_class);
			if (class_exists("$class_name")) {
				$eval_str = "\$objTab = new $class_name();"; 
				eval($eval_str);			
			} else {
				$ERROR = true; $ERROR_MSG = _('Eroare: Nu exista definita clasa tab "'.$tab_class.'" !');
			}
			
		} else {
			$ERROR = true; $ERROR_MSG = _('Eroare determinare clasa tab upload !');
		}
	}	
	
	/* --------- */
	if (!$ERROR) {
		$id = el_decript_info($id );
		$ERROR_MSG = $objTab->DeleteItem($id);
		if (!empty($ERROR_MSG)) {
			$ERROR = true;
		}
	}
	/* --------- */
	$arr_json['error']    = ($ERROR ? 'true' : 'false');
	$arr_json['message']  = $ERROR_MSG;
	
	$ret_json = json_encode($arr_json);
	
	echo $ret_json;	
	
?>