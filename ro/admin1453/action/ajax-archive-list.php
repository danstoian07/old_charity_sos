<?php
	session_start();    
	$ERROR     = false;
	$ERROR_MSG = 'ok';
	$grid_id   = '';
	$idma      = '';
    
	if ( isset($_REQUEST['grid_id']) ) { $grid_id = $_REQUEST['grid_id']; }
	if ( isset($_REQUEST['idma']) )    { $idma    = $_REQUEST['idma']; }
	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {    	
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    	spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = _('Eroare: Utilizator Nelogat');
	}	
	if (!$ERROR) {
		if( isset($_REQUEST['archtype']) ) { $archtype = $_REQUEST['archtype']; }  else { $archtype = ''; } 		
		$class_name  = "archive_".$archtype;
		if (class_exists("$class_name")) {
			$eval_str = "\$objArchive = new $class_name(NULL, '$idma');"; 
			eval($eval_str);
		} else {
			$ERROR = true; $ERROR_MSG = _('Eroare: Nu exista definita clasa "'.$archtype.'" !');
		}
	}
	
	if (!$ERROR) {
	  
	  /* -------------------------------------------- */
	  // get filter condition
	  $filter_no    = 0;
	  $filter_where = '';
	  $arr_filter_value = array();
	  
	  // $filter_idma = ''; /* filter id main article */
	  if( isset($_REQUEST['idma']) ) { $filter_idma = ' AND '.$objArchive->real_table_name.'.idma = '.el_decript_info($_REQUEST['idma']).' '; }  else { $filter_idma = ''; } 
	  
	  foreach ($objArchive->list_fields as $column) {
		  if (isset($column['filter'])) {
			switch ($column['filter']['type']) {
				/* .................. */
				case LFT_LIKE_FILTER :
					$fld_name_1   = 'filter_'.$column['db_field']."_1";
					$src_value    = isset($_REQUEST["$fld_name_1"]) ? $_REQUEST["$fld_name_1"] : '';					
					$filter_where .= (!empty($src_value) ? " AND $objArchive->real_table_name.".$column['db_field']." LIKE '%$src_value%' " : "");
					
					if (!empty($src_value)) {$arr_filter_value["$fld_name_1"] = $src_value;}
					
					$filter_no++;
					break;
				/* .................. */
				case LFT_DATE_INTERVAL :
					$fld_name_1   = 'filter_'.$column['db_field']."_1";
					$fld_name_2   = 'filter_'.$column['db_field']."_2";
					$src_value_1  = isset($_REQUEST["$fld_name_1"]) ? $_REQUEST["$fld_name_1"] : '';
					$src_value_2  = isset($_REQUEST["$fld_name_2"]) ? $_REQUEST["$fld_name_2"] : '';
					$filter_where .= (!empty($src_value_1) ? " AND DATE($objArchive->real_table_name.".$column['db_field'].")>='".el_RomanianDate_To_MysqlDate($src_value_1)."'" : "");
					$filter_where .= (!empty($src_value_2) ? " AND DATE($objArchive->real_table_name.".$column['db_field'].")<='".el_RomanianDate_To_MysqlDate($src_value_2)."'" : "");
					
					if (!empty($src_value_1)) {$arr_filter_value["$fld_name_1"] = $src_value_1;}
					if (!empty($src_value_2)) {$arr_filter_value["$fld_name_1"] = $src_value_2;}
					
					$filter_no++;
					break;				
				/* .................. */
				case LFT_VALUE_INTERVAL :
					$fld_name_1   = 'filter_'.$column['db_field']."_1";
					$fld_name_2   = 'filter_'.$column['db_field']."_2";
					$src_value_1  = isset($_REQUEST["$fld_name_1"]) ? $_REQUEST["$fld_name_1"] : '';
					$src_value_2  = isset($_REQUEST["$fld_name_2"]) ? $_REQUEST["$fld_name_2"] : '';
					$filter_where .= (!empty($src_value_1) ? " AND $objArchive->real_table_name.".$column['db_field'].">='".$src_value_1."'" : "");
					$filter_where .= (!empty($src_value_2) ? " AND $objArchive->real_table_name.".$column['db_field']."<='".$src_value_2."'" : "");

					if (!empty($src_value_1)) {$arr_filter_value["$fld_name_1"] = $src_value_1;}
					if (!empty($src_value_2)) {$arr_filter_value["$fld_name_1"] = $src_value_2;}
					
					$filter_no++;
					break;								
				/* .................. */
				case LFT_COMBO_CUSTOM :
					$fld_name_1   = 'filter_'.$column['db_field']."_1";
					$src_value    = isset($_REQUEST["$fld_name_1"]) ? $_REQUEST["$fld_name_1"] : '';					
					//$filter_where .= (!empty($src_value) ? " AND ".$column['db_field']."='$src_value' " : "");
					$filter_where .= ($src_value!='' ? " AND $objArchive->real_table_name.".$column['db_field']."='$src_value' " : "");
					
					if (!empty($src_value)) {$arr_filter_value["$fld_name_1"] = $src_value;}
					
					$filter_no++;
					break;				
				/* .................. */
				case LFT_COMBO_FROM_TABLE :
					$fld_name_1   = 'filter_'.$column['db_field']."__1";
					$src_value    = isset($_REQUEST["$fld_name_1"]) ? $_REQUEST["$fld_name_1"] : '';					
					$filter_where .= (!empty($src_value) ? " AND $objArchive->real_table_name.".$column['db_field']."='$src_value' " : "");
					
					if (!empty($src_value)) {$arr_filter_value["$fld_name_1"] = $src_value;}
					
					$filter_no++;
					break;								
				/* .................. */
				case LFT_COMBO_INTERACTIVE :					
					$fld_name_1   = 'filter_'.$column['db_field']."_mc_1";
					$src_value    = isset($_REQUEST["$fld_name_1"]) ? $_REQUEST["$fld_name_1"] : '';					
					$filter_where .= (!empty($src_value) ? " AND $objArchive->real_table_name.".$column['db_field']."='$src_value' " : "");
					$filter_no++;				
					break;
				/* .................. */
			}
		  }
	  }
	  
	  /*
	  $cookie_name = $objArchive->getClassName().'_listfilter';
	  unset($_COOKIE["$cookie_name"]);
	  if (!empty($arr_filter_value)) {
		  $filter_json = json_encode($arr_filter_value);		  
		  setcookie($cookie_name, $filter_json,0,'/');
	  } else {
		  unset($_COOKIE["$cookie_name"]);
	  }
	  */
	  $objArchive->query_where = $objArchive->query_where.$filter_where.$filter_idma;
	  /* -------------------------------------------- */
	  $iTotalRecords = $oDB->table_records_number($objArchive->table_name, $objArchive->query_where);
	  
	  //$iDisplayLength = 10;
	  $iDisplayLength = intval($_REQUEST['length']);
	  $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
	  $iDisplayStart = intval($_REQUEST['start']);
	  $sEcho = intval($_REQUEST['draw']);
	  
	  $records = array();
	  $records["data"] = array(); 

	  $end = $iDisplayStart + $iDisplayLength;
	  $end = $end > $iTotalRecords ? $iTotalRecords : $end;
	  
	  /* ------------------------------- */
	  
	  /* ------------------------------- */
	  	  
	  $column_no = $_REQUEST['order'][0]['column']-1;
	  $order_field_name = $objArchive->list_fields[$column_no]['db_field'];
	  $order_direction  = $_REQUEST['order'][0]['dir'];
	  
	  /* -------------------------------------------------------- */		  
		//$objArchive->query_order_by = $order_field_name." ".$order_direction;
		$objArchive->query_order_by = "$objArchive->real_table_name.".$order_field_name." ".$order_direction;
		
		$query   = $objArchive->ListQuery()." LIMIT $iDisplayStart, $iDisplayLength";
		
        $result  = $oDB->db_query($query);
		while ($result_line = $oDB->db_fetch_array($result)) {
			$enc_id = el_encript_info($result_line['id']);
			foreach ($result_line as $keyr => $valuer) {
				$result_line["$keyr"] = addslashes($valuer);
				//$result_line["$keyr"] = addslashes(htmlspecialchars($valuer));
			}			
			if (!empty($grid_id)) {
				$old_redirect = ""; 
				$arr_url_param = el_UrlStringWithParametersToArray($_SERVER["HTTP_REFERER"]);
				if ($arr_url_param != false) {
					if (isset($arr_url_param['redirect'])) { $old_redirect = urldecode($arr_url_param['redirect']);}
				}
								
				$redirect     = el_remove_url_param($_SERVER["HTTP_REFERER"],'redirect');
				$redirect     = el_remove_url_param(urldecode($redirect),'tab');				
				
				$redirect = $redirect."&tab=".($grid_id+1).(!empty($old_redirect) ? "&redirect=".urlencode($old_redirect) : '');
				$link_to_edit = __ADMINURL__."?pn=3&archtype=".$archtype."&id=".$enc_id.(!empty($idma) ? "&idma=".$idma : "")."&redirect=".urlencode( $redirect );
				

				
			} else {
				$link_to_edit = $objArchive->LinkToEditItem($result_line['id'], $archtype);
			}
			
			$edit_but = "<a href=\"".$link_to_edit."\" class=\"btn btn-sm grey-mint btn-outline\"><i class=\"fa fa-pencil\"></i><span class=\"hidden-xs\"> ".$objArchive->list_edit_item_button_name."</span></a>";			
			//$edit_but = (( (!$objArchive->permission_edit_item) || (isset($result_line['can_edit']) && $result_line['can_edit']==0)) ? "" : $edit_but);
			if ( (!$objArchive->permission_edit_item) || (isset($result_line['can_edit']) && $result_line['can_edit']==0)) {
				$edit_but     = '';
				//$link_to_edit = 'javascript:void(0);';
				$link_to_edit = 'javascript:cst_notify(&#39;Nu ai drepturi de a edita aceasta inregistrare !&#39;,&#39;Atentie&#39;,2);';
			}
			
			$del_but  = "<a href=\"javascript:cst_DeleteItemArchive(\'".$enc_id."\',\'".el_encript_info($archtype)."\', \'".$grid_id."\');\" class=\"btn btn-default btn-sm\" title=\"Delete item\"><i class=\"fa fa-trash-o\" title=\"Delete item\"></i> </a>";
			$del_but  = (( (!$objArchive->permission_delete_item) || (isset($result_line['can_delete']) && $result_line['can_delete']==0)) ? "" : $del_but);
			
			$eval_str = "
			\$records[\"data\"][] = array(
			  '<label class=\"mt-checkbox mt-checkbox-single mt-checkbox-outline\"><input name=\"id[]\" type=\"checkbox\" class=\"checkboxes\" ".($result_line['can_delete']==0 ? 'disabled readonly' :'')." value=\"".el_encript_info($result_line['id'])."\"/><span></span></label>',
			  ".ajax_records_list($objArchive, $result_line, $link_to_edit)."
			  '$edit_but $del_but',
			);";
			 eval($eval_str);
			
		}
	  /* -------------------------------------------------------- */

	  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
		$records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)

		if (isset($_REQUEST["id"])) {
			$arr_encripted_id = $_REQUEST["id"];
			$ArhiveMethodName = el_decript_info($_REQUEST["customActionName"]); /* name of archive method to be fired in order to execute global action */
			if (!method_exists($objArchive, $ArhiveMethodName)) {
				$records["customActionStatus"]  = 'ERROR';
				$records["customActionMessage"] = _('Eroare metoda tratare actiune globala !');
			} else {
				$eval_str = "\$err_msg = \$objArchive->$ArhiveMethodName(\$arr_encripted_id);"; 
				eval($eval_str);
				if (!empty($err_msg)) {
					$records["customActionStatus"]  = 'ERROR';
					$records["customActionMessage"] = _($err_msg);
				}else {
					$records["customActionMessage"] = "Operatiune globala finalizata cu succes !";
				}
			}			
		}
	  }

	  $records["draw"] = $sEcho;
	  $records["recordsTotal"] = $iTotalRecords;
	  $records["recordsFiltered"] = $iTotalRecords;
	  
	  echo json_encode($records);
	}
	
	/* -------------------------------------------------------------- */
	function ajax_records_list($objArchive, $result_line, $link_to_edit){
	  $str_records = "";
	  foreach ($objArchive->list_fields as $column) {			
			$value = '';
			$db_field = $column['db_field'];
			$class = ( isset($column['style-classes'])  ? $column['style-classes'] : '');
			
			switch ($column['type']) {
				case FIELD_VALUE :					
					$value = $result_line["$db_field"];
					break;
				case FIELD_LINK :					
					$value = '<a href="'.$link_to_edit.'">'.$result_line["$db_field"].'</a>';
					break;					
				case FIELD_DATE :
					$value = el_MysqlDate_To_RomanianDate($result_line["$db_field"]);
					break;
				case FIELD_DATETIME :
					$value =el_MysqlDateTime_To_RomanianDateTime($result_line["$db_field"]);
					break;					
				case FIELD_EMAIL :
					$value = '<a href="mailto:'.$result_line["$db_field"].'" target="_top">'.$result_line["$db_field"].'</a>';
					break;					
				case FIELD_PHONE :
					$value = '<a href="tel:'.$result_line["$db_field"].'">'.$result_line["$db_field"].'</a>';
					break;					
				case FIELD_FUNCTION :
					$eval_str = "\$value=\$objArchive->".$column['function']."(\$result_line, \$link_to_edit);";
					eval($eval_str);
					break;					
					
			}
			$value = "'<span class=\"".$class."\">".$value."</span>'";
			$str_records .= (!empty($str_records) ? ', ' : '').$value;
	  }
	  $str_records .=",";
	  return $str_records;
	}
	/* -------------------------------------------------------------- */
?>