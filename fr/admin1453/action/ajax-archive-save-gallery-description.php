<?php
	session_start();    
	$ERROR     = false;
    $ERROR_MSG = 'ok';	
	$id        = '';
	$item_text = '';	
	$enc_tbl   = ''; /* encripted table name */
		
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
		if (isset($_REQUEST['id'])) {$id = el_decript_info($_REQUEST['id']);} else { $ERROR=true; $ERROR_MSG =_('Eroare ID NECUNOSCUT !');}
	}
	if (!$ERROR) {
		if (isset($_REQUEST['item_text'])) {$item_text = addslashes( stripslashes(urldecode($_REQUEST['item_text'])));} else { $ERROR=true; $ERROR_MSG =_('Eroare LIPSA TEXT !');}
	}
	if (!$ERROR) {
		if (isset($_REQUEST['enc_tbl'])) {$enc_tbl = el_decript_info(urldecode($_REQUEST['enc_tbl']));} else { $ERROR=true; $ERROR_MSG =_('Eroare NUME TABELA !');}
	}
	
	/* --------- */
	
	if (!$ERROR) {		
		$query ="UPDATE ".el_TableNameWithPrefix($enc_tbl)." SET description ='$item_text' WHERE id = $id";
		$result = $oDB->db_query($query);
    }
	/* --------- */	
	
	echo $ERROR_MSG;
	
?>