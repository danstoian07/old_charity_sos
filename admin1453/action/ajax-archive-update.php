<?php
	session_start();    
	$ERROR     = false;
    $ERROR_MSG = 'ok';	
	
	$archtype  = '';
	$pn        = '';
	$id        = '';
	$idma      = 'all';
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
		if (!isset($_SERVER["HTTP_REFERER"])) {
			$ERROR = true; $ERROR_MSG = _('Eroare HTTP_REFERER');
		} else {
				$url_referer   = $_SERVER["HTTP_REFERER"];
				$arr_url_param = el_UrlStringWithParametersToArray($url_referer);
				if ($arr_url_param == false) {
					$ERROR = true; $ERROR_MSG = _('Eroare la determinarea parametrilor din URL referer');
				} else {
					if ((!isset($arr_url_param['pn'])) || ($arr_url_param['pn']!=3)) { $ERROR = true; $ERROR_MSG = _('Eroare parametru "pn" !'); }
					if (!$ERROR) {
						if (!isset($arr_url_param['archtype'])) { $ERROR = true; $ERROR_MSG = _('Eroare parametru "archtype" !'); } else { $archtype = $arr_url_param['archtype']; }
					}
					if (!$ERROR) {
						if (!isset($arr_url_param['id'])) { $ERROR = true; $ERROR_MSG = _('Eroare parametru "id" !'); } else { $id = el_decript_info($arr_url_param['id']); }
					}
					if (!$ERROR) {
						if (isset($arr_url_param['idma'])) { $idma = el_decript_info($arr_url_param['idma']); }
					}					
					
				}			
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
				//$objArchive->item_id = $id;
				foreach ($objArchive->tabs as $curent_tab) {
						/*****/
						$tab_class_name  = $curent_tab[1];
						if (class_exists("$tab_class_name")) {
							if (isset($objTab)) { unset($objTab); }
							$eval_str = "\$objTab = new $tab_class_name(\$objArchive);"; 
							eval($eval_str);
							$need_validation = true;
							if (($id==0) && ($objTab->show_on_add==false)) {
								// este adaugare si tabul nu este afisat la adaugare
								$need_validation = false;
							}
							if (($id!=0) && ($objTab->show_on_edit==false)) {
								// este modificare si tabul nu este afisat la modificare
								$need_validation = false;
							}							
							if ($need_validation) {
								if (!$objTab->valid_fields($objTab->fields, $id, $table_name, $ida, $idma)){
									$ERROR = true; $ERROR_MSG = _($objTab->ERROR_MSG);
								}
							}
						} else { 
							$ERROR = true; $ERROR_MSG = _('Nu exista definita clasa "'.$tab_class_name.'"');
							break;
						}					
						/*****/
						if ($ERROR) {break;}
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
		/* insert or update form */
		$update_msg = $objArchive->StoreTabsFieldsToDatabase($id, $idma);
		if ($update_msg!='ok') {
			$ERROR = true; $ERROR_MSG = _($update_msg);
		} 
	}
	/* --------- */
	echo $ERROR_MSG;	
	
?>