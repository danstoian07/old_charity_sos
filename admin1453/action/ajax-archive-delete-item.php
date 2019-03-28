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
		if (isset($_REQUEST['id'])) {$id = el_decript_info($_REQUEST['id']);} else { $ERROR=true; $ERROR_MSG =_('Eroare ID');}
		if (!$ERROR) {
			if (isset($_REQUEST['en_archtype'])) { $archtype = el_decript_info($_REQUEST['en_archtype']);  } else { $ERROR = true; $ERROR_MSG = _('Eroare parametru "archtype" !'); }
		}		
    }
    /* --------- */
	if (!$ERROR) {
		$class_name  = "archive_".$archtype;
		if (class_exists("$class_name")) {
			$eval_str = "\$objArchive = new $class_name(NULL);"; 
			eval($eval_str);
		} else {
			$ERROR = true; $ERROR_MSG = _('Nu exista definita clasa "'.$archtype.'" !');
		}							
    }
	/* --------- */
	if (!$ERROR) {
		$url_referer   = $_SERVER["HTTP_REFERER"];
		$arr_url_param = el_UrlStringWithParametersToArray($url_referer);
		if ($arr_url_param != false) {
			if (isset($arr_url_param['redirect'])) { $redirect = $arr_url_param['redirect']; }
		}
		
		$ERROR_MSG = $objArchive->DeleteItem ($id);
		if (!empty($ERROR_MSG)) { $ERROR = true; }
	}
	/* --------- */
	$arr_json['error']    = ($ERROR ? 'true' : 'false');
	$arr_json['message']  = $ERROR_MSG;
	$arr_json['redirect'] = $redirect;
	
	$ret_json = json_encode($arr_json);
	
	echo $ret_json;	
	
?>