<?php

	session_start();    
	$ERROR         = false;
	$ERROR_MSG     = 'ok';
	$MAX_FIELDS_NO = 8;	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {    	
    	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php');
    	spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = _('Eroare: Utilizator Nelogat');
	}
	
	if (!$ERROR) {
		if( isset($_REQUEST['archtype']) ) { 
			$archtype = $_REQUEST['archtype']; 
			if (empty($archtype)) {
				$ERROR = true; $ERROR_MSG = _('Eroare: nespecificata (1) !');
			}
		}  else { 
			$ERROR = true; $ERROR_MSG = _('Eroare: Arhiva nespecificata (2) !');
		} 
	}
	
	if (!$ERROR) {
		$class_name  = "archive_".$archtype;
		if (class_exists("$class_name")) {
			$eval_str = "\$objArchive = new $class_name(NULL);"; 
			eval($eval_str);
		} else {
			$ERROR = true; $ERROR_MSG = _('Eroare identificare arhiva !');
		}							
	}
	if (!$ERROR) {
		 if (!$objArchive->CanViewListLoggedUser()) {
			 $ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a vizualiza/lista inregistrarile acestei arhive ( ARCHTYPE: '.$this->archtype.' ) (1) !');
		 }		
	}
	if (!$ERROR) {
		if ((isset($objArchive->permission_export_archive)) && ($objArchive->permission_export_archive==0)) {
			$ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a exporta inregistrari ale acestei arhive ( ARCHTYPE: '.$objArchive->archtype.' ) (1) !');
		}
	}		
	
/* ----------------------------- determina date document --------------------- */	
	if (!$ERROR) {
		$message='';			
		if(isset($_REQUEST['idma'])) {$idma = $_REQUEST['idma'];} else { $idma = '';}
		
		$eval_str  = '';
		$FIELDS_NO = 0;
		$arr_data        = array();
		$arr_db_fields   = array();
		$arr_first_line  = array();
		
		foreach ($objArchive->list_fields_for_export as $key => $value) {						
			if ($FIELDS_NO<=$MAX_FIELDS_NO) {
				array_push($arr_db_fields,$value[1]);
				$arr_first_line[] = $value[0];
			}
			$FIELDS_NO++;
		}
		if ($FIELDS_NO==0) {
			$ERROR = true;  $ERROR_MSG = _('Nu au fost declarate campurile de listare (proprietate list_fields_for_export) in archiva '.$objArchive->archtype.' !');
		}
	}
	if (!$ERROR) {
			$f = fopen('php://memory', 'w');
			fputcsv($f, $arr_first_line, ',');			
			$filename = "lista_".$archtype."_" . date('Ymd') . ".csv";
			header('Content-Type: application/csv');
			header('Content-Disposition: attachement; filename="' . $filename . '";');
			
								
			if (!$ERROR) {
				$query      = $objArchive->ListQuery(); /* field list in ListQuery() must contain all fields declared in "list_fields_for_export" property */
				$result     = $oDB->db_query($query);
				while ($result_line = $oDB->db_fetch_array($result)) {
					unset($arr_line);
					$arr_line = array();					
					foreach ($arr_db_fields as $key => $fields_name) {
						$arr_line[] = $result_line["$fields_name"];
					}
					fputcsv($f, $arr_line, ',');
					//$arr_data[] = $arr_line;
				}
				fseek($f, 0);
				fpassthru($f);
			}
			
	} else {
		echo $ERROR_MSG;
	}
	
	/* ------------------------------------------ */
?>
