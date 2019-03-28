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
				//$table_name = el_TableNameWithPrefix($objArchive->table_name);
				$table_name = $objArchive->real_table_name;
				//$ida        = $objArchive->ida;
				//$objArchive->item_id = $id;
				$query = "
					SELECT $table_name.date_add, $table_name.date_mod, el_users2.add_name,  el_users3.mod_name FROM $table_name 
					LEFT JOIN (SELECT el_users.id, el_users.name AS add_name FROM el_users) AS el_users2 ON el_users2.id=$table_name.add_by 
					LEFT JOIN (SELECT el_users.id, el_users.name AS mod_name FROM el_users) AS el_users3 ON el_users3.id=$table_name.mod_by 
					WHERE $table_name.id = $id";
				$result  = $oDB->db_query($query);
				$DATE_ADD = ''; $DATE_MOD = '';
				$ADD_NAME = ''; $MOD_NAME = '';
				if ($result_line = $oDB->db_fetch_array($result)) {
					$DATE_ADD = el_MysqlDateTime_To_RomanianDateTime($result_line["date_add"]);
					$DATE_MOD = el_MysqlDateTime_To_RomanianDateTime($result_line["date_mod"]);
					$ADD_NAME = $result_line["add_name"];
					$MOD_NAME = $result_line["mod_name"];
				} else {
					$ERROR = true; $ERROR_MSG = _('Eroare determinare informatii inregistrare !');
				}
				
		} else {
			$ERROR = true; $ERROR_MSG = _('Nu exista definita clasa "'.$archtype.'" !');
		}							
    }
	/* --------- */
	if (!$ERROR) {
		
		$ERROR_MSG ='
			<div style="text-align:left;">
				<table style="width:100%">
					<tr><td style="width:40%; text-align:right;">Adaugare:&nbsp;</td><td class="bold mt-sweetalert">'.$DATE_ADD.', '.$ADD_NAME.'</td></tr>
					<tr><td style="width:40%; text-align:right;">Ultima actualizare:&nbsp;</td><td class="bold mt-sweetalert">'.$DATE_MOD.', '.$MOD_NAME.'</td></tr>
				</table>
			</div>
		';		
	}
	/* --------- */
	$arr_json['error']   = ($ERROR ? 'true' : 'false');
	$arr_json['message'] = $ERROR_MSG;
	
	
	$ret_json = json_encode($arr_json);
	
	echo $ret_json;	
	
?>