<?php
  /* 
   * Paging
   */

  //var_dump($_POST["selected"]);
	session_start();    
	$ERROR     = false;
	$ERROR_MSG = 'ok';		
	$ITEM_ID   = 0;
	
    $SHOW_PREVIEW   = true;   /* set TRUE for image preview in list */
	$PREVIEW_WIDTH  = 50;
	$PREVIEW_HEIGHT = 50;
	$MIN_DIMENSION  = ($PREVIEW_WIDTH<=$PREVIEW_HEIGHT ? $PREVIEW_WIDTH : $PREVIEW_HEIGHT);
	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {    	
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    	spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = _('Eroare: Utilizator Nelogat');
	}
	
	if (!$ERROR) {
		if( isset($_REQUEST['tab_class']) ) { $tab_class = $_REQUEST['tab_class']; }  else { $tab_class = ''; } 
		
		if (!empty($tab_class)) {
			
			$class_name  = "$tab_class";
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
	
	if (!$ERROR) {
		if (isset($_REQUEST["ida"])) {
			$ITEM_ID = el_decript_info($_REQUEST["ida"]);
		} else {
			$ERROR = true; $ERROR_MSG = _('Eroare identificator integistrare: ITEM_ID !');
		}
	} 

	if (!$ERROR) {
		  		  		  
		  /* --------- */
		  $filter_where  = '';
		  $src_value_1   = isset($_REQUEST['filter_date_1']) ? $_REQUEST['filter_date_1'] : '';
		  $src_value_2   = isset($_REQUEST['filter_date_2']) ? $_REQUEST['filter_date_2'] : '';
		  $filter_where .= (!empty($src_value_1) ? " AND DATE(date_add)>='".el_RomanianDate_To_MysqlDate($src_value_1)."'" : "");
		  $filter_where .= (!empty($src_value_2) ? " AND DATE(date_add)<='".el_RomanianDate_To_MysqlDate($src_value_2)."'" : "");		  
		    		  
		  $src_value     = isset($_REQUEST['file_name']) ? $_REQUEST['file_name'] : '';
		  $filter_where .= (!empty($src_value) ? " AND filename LIKE '%$src_value%' " : "");
		  
		  $src_value     = isset($_REQUEST['file_description']) ? $_REQUEST['file_description'] : '';
		  $filter_where .= (!empty($src_value) ? " AND description LIKE '%$src_value%' " : "");
		  
		  /* --------- */
		  
		  $gallery_table_name      = $objTab->upload_table_name;
		  $gallery_real_table_name = $objTab->real_table_name;
		  $query_where             = "$gallery_real_table_name.id_archive=".$ITEM_ID." ".$filter_where;
		  
		  $iTotalRecords           = $oDB->table_records_number($gallery_table_name, $query_where);		  		  
		  
		  //$iTotalRecords = 178;
		  $iDisplayLength = intval($_REQUEST['length']);
		  $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		  $iDisplayStart = intval($_REQUEST['start']);
		  $sEcho = intval($_REQUEST['draw']);
		  		  
		  $records = array();
		  $records["data"] = array(); 

		  $end = $iDisplayStart + $iDisplayLength;
		  $end = $end > $iTotalRecords ? $iTotalRecords : $end;
		  
		  $column_no = $_REQUEST['order'][0]['column']-1;
	      //$order_field_name = $objArchive->list_fields[$column_no]['db_field'];
		  $order_field_name = 'date_add';
		  switch ($column_no) {
				case 0: $order_field_name = 'date_add';    break;
				case 2: $order_field_name = 'filename';    break;
				case 3: $order_field_name = 'description'; break;
				case 4: $order_field_name = 'filesize';    break;
		  }		  
		  		  
	      $order_direction  = $_REQUEST['order'][0]['dir'];
		  
		  $query   = "
				SELECT id, filename, file, filesize, description, date_add, display_index, can_edit, can_delete 
				FROM $gallery_real_table_name 
				WHERE $query_where 
				ORDER BY $order_field_name $order_direction 
				LIMIT $iDisplayStart, $iDisplayLength";
				
		   $result  = $oDB->db_query($query);
		   while ($result_line = $oDB->db_fetch_array($result)) {
				$enc_id = el_encript_info($result_line['id']);
				if (($result_line['can_delete']) && ($objTab->upload_permission_delete_item)) {
					//$del_but     = "<a href=\"javascript:cst_DeleteItemUploadFiles(\'".$enc_id."\',\'".el_encript_info($tab_class)."\');\" class=\"btn btn-sm btn-outline grey-salsa\"><i class=\"fa fa-close\"></i> Sterge</a>";
					$del_but     = "<a href=\"javascript:cst_DeleteItemUploadFiles(\'".$enc_id."\',\'".el_encript_info($tab_class)."\');\"><i class=\"fa fa-close\"></i> Delete file</a>";
				} else {
					$del_but = '';
				}
				$date_add    = el_MysqlDateTime_To_RomanianDateTime($result_line['date_add']);
				if (!empty($result_line['description'])) {	
					$description = str_replace('"', "&#34;", $result_line['description']);
					$description = str_replace("'", "&#39;", $description);
					$description = '<div class="editable text-info" id="enc_'.$enc_id.'">'.$description.'</div>';
				} else {
					$description = '<div class="editable font-grey-salsa" id="enc_'.$enc_id.'">Click to edit</div>';
				}
				$filesize    = $result_line['filesize'].' Mb';				
				$file_extension = pathinfo($result_line['filename'], PATHINFO_EXTENSION);
				$filename    = '<i class="fa '.el_ReturnIconClassFromFileType($file_extension).'"></i> '.$result_line['filename'];
				
				$actiuni = '<div class="actions">
								<div class="btn-group">
									<a class="btn green-haze btn-outline btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="'.$result_line['file'].'" download><i class="fa fa-download"></i> Download file</a>
										</li>
										<li>
											<a href="javascript:;"><i class="fa fa-envelope"></i> Send by e-mail</a>
										</li>										
										<li class="divider"> </li>
										'.(!empty($del_but) ? '<li>'.$del_but.'</a></li>' : '').'
									</ul>
								</div>
							</div>';
				
				
				if ($SHOW_PREVIEW) {										
					if (el_IsImage($result_line['filename'])) {
						$content_preview = '<a class="fancybox-button" data-rel="fancybox-button" href="'.$result_line['file'].'" download><img src="'.el_AdminCropImage($result_line['file'], $PREVIEW_WIDTH, $PREVIEW_HEIGHT ).'" /></a>';
					} else {
						$content_preview = '<a href="'.$result_line['file'].'" download><img width="'.$MIN_DIMENSION.'" src="'.el_AdminReturnPhotoFromFileType($file_extension).'" /></a>';
					}
				} else {
					$content_preview = '';
				}
				
				$eval_str = "
				\$records[\"data\"][] = array(
				  '<label class=\"mt-checkbox mt-checkbox-single mt-checkbox-outline\"><input name=\"id[]\" type=\"checkbox\" class=\"checkboxes\" ".($result_line['can_delete']==0 ? 'disabled readonly' :'')." value=\"".$enc_id."\"/><span></span></label>',
				  '$date_add',
				  '$content_preview',
				  '$filename',
				  '$description',
				  '$filesize',
				  '$actiuni',
				);";
				 eval($eval_str);
				
		   }
		 
	
		  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$records["customActionStatus"] = "OK"; 
			
			if (isset($_REQUEST["id"])) {
				$arr_encripted_id = $_REQUEST["id"];
				$TabsMethodName = el_decript_info($_REQUEST["customActionName"]); 
				$records["customActionMessage"] = "Actiune globala finalizata cu succes !";	
				
				if (!method_exists($objTab, $TabsMethodName)) {
					$records["customActionStatus"]  = 'ERROR';
					$records["customActionMessage"] = _('Eroare metoda tratare actiune globala !');
				} else {
					
					$eval_str = "\$err_msg = \$objTab->$TabsMethodName(\$arr_encripted_id);"; 					
					eval($eval_str);
					
					if (!empty($err_msg)) {
						$records["customActionStatus"]  = 'ERROR';
						$records["customActionMessage"] = _($err_msg);
					}else {
						$records["customActionMessage"] = "Actiune globala finalizata cu succes !";
					}					
					
				}			
				
			}
			
		  }		  
		  

		  $records["draw"] = $sEcho;
		  $records["recordsTotal"] = $iTotalRecords;
		  $records["recordsFiltered"] = $iTotalRecords;
		  
		  echo json_encode($records);		  
	}
?>