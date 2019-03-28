<?php
	session_start();    
	$ERROR     = false;
    $ERROR_MSG = 'ok';	
	
	$archtype  = '';
	$pn        = '';
	$id        = '';
	
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
			if ($objArchive->tabs) {				
				$table_name = el_TableNameWithPrefix($objArchive->table_name);
				$ida        = $objArchive->ida;
				$objArchive->item_id = $id;
				$contor = 0;
				$main_field ='';
				foreach ($objArchive->list_fields as $column) {
						/*****/
						if ($contor==0) {
							if (isset($column['db_field'])) {
								$main_field = $column['db_field'];
							}
						}
						if (isset($column['main-fields'])) {
							if ($column['main-fields']==true) {
								$main_field = $column['db_field'];
								break;
							}
						}						
						/*****/
						$contor++;
				}
				if (empty($main_field)) {
					$ERROR = true; $ERROR_MSG = _('Eroare determinare camp principal !');
				}
			} else {
				$ERROR = true; $ERROR_MSG = _('Nu exista taburi definite pentru arhiva "'.$archtype.'" !');
			}
		} else {
			$ERROR = true; $ERROR_MSG = _('Nu exista definita clasa "'.$archtype.'" !');
		}							
    }
	/* --------- */
	if (!$ERROR) {
		$ERROR_MSG = $objArchive->ReturnDeleteMessage ($id, $main_field);
	}
	/* --------- */
	$arr_json['error']   = ($ERROR ? 'true' : 'false');
	$arr_json['message'] = $ERROR_MSG;
	
	$ret_json = json_encode($arr_json);
	
	echo $ret_json;	
	
?>