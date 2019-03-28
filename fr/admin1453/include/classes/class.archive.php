<?php
/* generic class */
class archive extends info_messages {
	/* ------------------------------------------------------------------------------------- */	
	public  $parent;
	
	public  $archtype;															/* archive name */
	
	public  $ida							= 0;								/* id archive (for filter items) */
	public  $idma							= '';								/* id main archive */
	public  $table_name;														/* Database table of archive - whithout prefix*/
	public  $real_table_name;													/* Database table of archive - whithout prefix*/
	public  $url_referer;														/* Redirect link after edit item*/
	
	public  $result_line					= '';								/* Array with fields value from database */
	public  $result_multiselect				= '';								/* Array with multiselect values */
	
	public  $list_fields = array();
	public  $list_fields_order_by_fiels_no	= 1; 								/* Order list by column no X. Value from 1 ... */
	public  $list_fields_order_by_direction	= 'ASC';  							/* ASC or DESC */
	
	public  $list_fields_for_export         = array();							/* array of filds from database table, to be print*/
	
	public  $breadcrumbs					= array();							/* Archive breadcrumbs, bidimensional array Ex: (($str1, $link1),($str2, $link2) ...) */
	public  $actions 						= array();							/* Archive actions, bidimensional array Ex: (($str1, $link1,$str_icon1),($str2, $link2, $str_icon2) ...) */
	public  $actions_more					= array();							/* Archive actions, bidimensional array Ex: (($str1, $link1,$str_icon1),($str2, $link2, $str_icon2) ...) : more button on edit archive; for divider set str="-" */
	public  $global_actions					= array();							/* Archive global actions, bidimensional array Ex: (($actions_name1, $archive_method_name1),($actions_name2, $archive_method_name2) ...) Obs: method must return empty string for success or error message in case of error */ 
	
	public  $notifications 			    	= array();							/* Archive notifications, bidimensional array Ex: (($msg1, $msg_type1),($msg2, $msg_type2) ...) */
	public  $alerts   			    		= array();							/* Archive alerts, bidimensional array Ex: (($msg1, $msg_type1, $msg_icon_class1),($msg2, $msg_type2, $msg_icon_class2) ...) */
	
	public  $tabs   			    		= array(); 							/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */
	public  $active_tab   			   		= 1;								/* Active tabs */
	
	public  $permission_add_item            = 1;								/* users can add item in archive */	
	public  $permission_edit_item           = 1;  								/* users can edit archive items */	
	public  $permission_delete_item         = 1;								/* users can delete archive items */	

	public  $item_id                        = 0;								/* item id */		
	public  $item_id_encripted;													/* encripted item id */
	
	public  $display_actions                = 1;								/* show or not actions menu in top of panel */		
	
	public  $archive_title_top_big          = 'Editare date';
	public  $archive_title_top_small        = '';

	public  $archive_title			        = 'Nume Arhiva';					/* Archive Name */
	public  $archive_icon_class     		= 'fa-file-o';						/* Archive icon */
	
	public  $list_archive_title			    = 'Nume Arhiva';					/* Title of archive list */
	public  $list_archive_title_for_export  = 'Lista inregistrari';	  			/* Title of exported List */
	public  $list_archive_icon_class        = 'fa-file-o';						/* icon for title of archive list */
	public  $list_add_button_show           = 1;
	public  $list_add_button_name           = 'Adauga inregistrare';			/* Add button value */
	public  $list_edit_item_button_name     = 'Detalii';	 					/* Add button value */
	
	public  $list_visibility			    = 0;								/* 0 separat si in tab, 1 - only in tab */	
	
	public  $query_where;
	public  $query_order_by;
	
	public  $edit_button_back_show          = 1;
	public  $edit_button_save_show          = 1;	
	public  $edit_button_save_continue_show = 1;
	public  $edit_button_more_show          = 1;	
	
	public  $user_rights_by_admin           = array();							/* array cu drepturi utilizator pentru aceasta arhiva, setate de administratorul sistemului */
	public  $user_view_only_own_records		= 0;								/* daca este 1, userul logat vede doar inregistrarile adaugate de el; daca este 0 vede in lista toate inregistrarile */
	public  $user_can_update_archive		= 1;								/* user can update archive */
	
	public  $del_item_message               = 'Confirmati stergerea inregistrarii <strong>%</strong> ?';	
	
	public  $activate_menuitem_id           = 10;								/* id of menuitem wich will be active when panel show */	
	public  $user_id						= 0;
	

	/* ------------------------------------------------------------------------------------- */		
	public function __construct($oParent=NULL, $idma='') {		

		$this->parent               = $oParent;
		$this->user_id              = el_decript_info($_SESSION[APP_ID]["user"]["id"]);
		$this->archtype             = preg_replace('/archive_/', '', get_class($this), 1);
		$this->user_rights_by_admin = $this->SetArchiveUserRightsByAdmin();
		$this->real_table_name      = el_TableNameWithPrefix($this->table_name);
		//$this->query_where          = "$this->real_table_name.id_archive=".$this->ida;
		$this->query_where          = ($this->user_view_only_own_records==0 ? "$this->real_table_name.id_archive=".$this->ida : "($this->real_table_name.id_archive=".$this->ida." AND $this->real_table_name.add_by=".el_decript_info($_SESSION[APP_ID]["user"]["id"])." )");
		$this->query_order_by       = "$this->real_table_name.id ASC";
		$this->idma                 = $idma;
		$this->createProperty('encoded_link_to_archive_list', urlencode($this->LinkToList($this->archtype)));
		$this->AddItemToBreadcrumbs('Home', __ADMINURL__);
		$this->AddItemToActions('Goto Homepage', __ADMINURL__, 'icon-home');
		$this->AddItemToGlobalActions('Sterge','GlobalActions_Delete');
		
	}
	/* ------------------------------------------------------------------------------------- */
    public function createProperty($name, $value){
        $this->{$name} = $value;
    }		
	/* ------------------------------------------------------------------------------------- */
	public function GetArchiveUserRightsByAdmin($archtype){
		$arr_return_rights = array();
		$arr_all_user_rights = json_decode( el_decript_info($_SESSION[APP_ID]["user"]["rights"]), true);
		if ($arr_all_user_rights) {
			foreach ($arr_all_user_rights as $rights) {
				if ( $rights['name']=='administrator' ) {
					$arr_return_rights["administrator"] = $rights['value'];
				}			
				if ( $rights['name']==$archtype ) {
					$arr_return_rights["$archtype"] = $rights['value'];
				}
				if (strpos($rights['name'], $archtype)!==false) {
					if ($rights['name']!=$archtype) {
						$rights_name = str_replace( $archtype."_", "", $rights['name'] );
						$arr_return_rights["$rights_name"] = ($rights['value']=='on' ? 1 : 0);
					}
				}
			}		
		}
		return $arr_return_rights;
	}
	/* ------------------------------------------------------------------------------------- */
	public function SetArchiveUserRightsByAdmin_org(){		
		$arr_return_rights = $this->GetArchiveUserRightsByAdmin($this->archtype);
		//print_r($arr_return_rights);die('');
		if ($arr_return_rights) {			
			if (($arr_return_rights["administrator"]==0) && (isset($arr_return_rights["$this->archtype"])) && ($arr_return_rights["$this->archtype"]!=0)) {				
				foreach ($arr_return_rights as $key => $value) {
					if (($key!="administrator") && ($key!=$this->archtype)) {
						if (property_exists(get_class($this), $key)) {
							$eval_str = "\$this->$key = $value;";
							eval($eval_str);
						} else {
							$this->createProperty($key, $value);
						}
					}
				}
			} else {
				//$this->permission_add_item  = 0;
				//$this->permission_edit_item = 0;
				//$this->permission_del_item  = 0;
			}
		}		
		return $arr_return_rights;
	}
	/* ------------------------------------------------------------------------------------- */
	public function SetArchiveUserRightsByAdmin(){		
		$arr_return_rights = $this->GetArchiveUserRightsByAdmin($this->archtype);		
		if ($arr_return_rights) {			
			if ($arr_return_rights["administrator"]==0) {
				if ((isset($arr_return_rights["$this->archtype"])) && ($arr_return_rights["$this->archtype"]!=0)) {
					foreach ($arr_return_rights as $key => $value) {
						if (($key!="administrator") && ($key!=$this->archtype)) {
							if (property_exists(get_class($this), $key)) {
								$eval_str = "\$this->$key = $value;";
								eval($eval_str);
							} else {
								$this->createProperty($key, $value);
							}
						}
					}
				} else {
					/* daca arhiva nu este setata in class.tab_utilizator_rights.php, se vor lua in considerare drepturile de aici. A se seta daca este cazul. Daca nu e setat nimic, se vor lua in consideratie drepturile implicite ale arhivei */
				}
					
			} else {
				// este administrator; are drepturi implicite pentru arhiva, setate de programator
			}
		}		
		return $arr_return_rights;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function ReturnDeleteMessage ($id, $field_name) {
		global $oDB;
		$DELETE_QUERY     = $this->del_item_message;
		$FIELD_NAME_VALUE = '';
		$query = "SELECT $field_name FROM ".$this->real_table_name." WHERE id = '$id'";
		$result = $oDB->db_query($query);
		if ($oDB->db_num_rows($result)!=1) {
			$ERROR = true; $ERROR_MSG = _('Nu exista in arhiva aceasta inregistrare !');
		} else {
			  if ($result_line = $oDB->db_fetch_array($result)) {
				  $FIELD_NAME_VALUE = $result_line["$field_name"];
				  $DELETE_QUERY = str_replace("%", $FIELD_NAME_VALUE, $DELETE_QUERY);
			  }
		}
		return $DELETE_QUERY;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function DeleteItem($id) {
		global $oDB;
		$ERROR     = false;
		$ERROR_MSG = '';				
		if ((!$this->permission_delete_item) || (!$this->AdminAllowToDeleteItem())) {
			$ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de stergere inregistrari in arhiva curenta !');
		}
		if (!$ERROR) {
			$query = "SELECT id, can_delete FROM ".$this->real_table_name." WHERE id = '$id'";
			$result = $oDB->db_query($query);
			if ($oDB->db_num_rows($result)!=1) {
				$ERROR = true; $ERROR_MSG = _('Nu exista in arhiva aceasta inregistrare !');
			} else {
				  if ($result_line = $oDB->db_fetch_array($result)) {
					  if ($result_line["can_delete"]==false) {
						$ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a sterge aceasta inregistrare !');
					  } 
				  }
			}
		}
		
		$ERROR_MSG = $this->ExecuteBeforeDelete($id);		
		if (!empty($ERROR_MSG)) { $ERROR = true; }
		
		if (!$ERROR) {
			$query = "DELETE FROM ".$this->real_table_name." WHERE id = '$id'";
			$result = $oDB->db_query($query);
			if ($oDB->db_affected_rows($result)!=1) {
				$ERROR = true; $ERROR_MSG = _('Eroare stergere inregistrare !');
			} else {
				$ERROR_MSG = $this->ExecuteAfterDelete($id);		
				if (!empty($ERROR_MSG)) { $ERROR = true; }				
			}
		}
		return $ERROR_MSG;
	}
	/* ------------------------------------------------------------------------------------- */
	public function ListQuery() {
		/* field list in ListQuery() must contain all fields declared in "list_fields_for_export" property */
		$query = "SELECT * FROM ".$this->real_table_name." WHERE ".$this->query_where." ORDER BY ".$this->query_order_by;
		return $query;
	}
	/* ------------------------------------------------------------------------------------- */
	public function ShowListHeader($return=0) {
		global $oDB;
		$header_title  = '
		<tr role="row" class="heading">
			<th width="2%">
				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
					<input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
					<span></span>
				</label>
			</th>'.PHP_EOL;
		
		/*
		$cookie_name      = $this->getClassName().'_listfilter'; 
		$arr_filter_value = array();
		if (isset($_COOKIE["$cookie_name"])) {
			$arr_filter_value = json_decode($_COOKIE["$cookie_name"], true);						
		}
		*/
		
		$header_filter = '
		<tr role="row" class="filter">
			<td> </td>'.PHP_EOL;
		$filter_no = 0;
		foreach ($this->list_fields as $column) {
			$responsive_classes = (((isset($column['responsive-classes'])) && (!empty($column['responsive-classes'])))  ? ' class= "'.$column['responsive-classes'].'" ' : '');
			
			$header_title .= '<th '.$responsive_classes.' width="'.$column['width'].'"> '.$column['title'].' </th>'.PHP_EOL;
			if (isset($column['filter'])) {
					switch ($column['filter']['type']) {
						/* .................. */
						case LFT_NOFILTER :
							$header_filter .= '<td '.$responsive_classes.'> </td>';
							break;
						/* .................. */
						case LFT_LIKE_FILTER :
							$fld_name_1 = 'filter_'.$column['db_field']."_1";
							$value = (isset($arr_filter_value["$fld_name_1"]) ? $arr_filter_value["$fld_name_1"] : '');
							$header_filter .= '<td '.$responsive_classes.'> <input type="text" class="form-control form-filter input-sm header-input-text" name="'.$fld_name_1.'" value="'.$value.'"> </td>'.PHP_EOL;
							$filter_no++;
							break;
						/* .................. */
						case LFT_DATE_INTERVAL :
							$fld_name_1 = 'filter_'.$column['db_field']."_1";
							$fld_name_2 = 'filter_'.$column['db_field']."_2";
							$header_filter .= '
							<td '.$responsive_classes.'>
								<div class="input-group date date-picker margin-bottom-5" data-date-format="dd-mm-yyyy">
									<input type="text" class="form-control form-filter input-sm" readonly name="'.$fld_name_1.'" placeholder="'._('From').'">
									<span class="input-group-btn">
										<button class="btn btn-sm default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
								<div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
									<input type="text" class="form-control form-filter input-sm" readonly name="'.$fld_name_2.'" placeholder="'._('To').'">
									<span class="input-group-btn">
										<button class="btn btn-sm default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</td>'.PHP_EOL;
							$filter_no++;
							break;
						/* .................. */
						case LFT_VALUE_INTERVAL :
							$fld_name_1 = 'filter_'.$column['db_field']."_1";
							$fld_name_2 = 'filter_'.$column['db_field']."_2";						
							$header_filter .= '
							<td '.$responsive_classes.'>
								<div class="margin-bottom-5">
									<input type="text" class="form-control form-filter input-sm" name="'.$fld_name_1.'" placeholder="'._('De la').'" /> </div>
								<input type="text" class="form-control form-filter input-sm" name="'.$fld_name_2.'" placeholder="'._('Pana la').'" /> 
							</td>'.PHP_EOL;
							$filter_no++;
							break;
						/* .................. */
						case LFT_COMBO_CUSTOM :
							$fld_name_1 = 'filter_'.$column['db_field']."_1";
							$sel_options    = '';
							if (isset($column['filter']['options'])) {
								foreach ($column['filter']['options'] as $option) {
									$sel_options    .= '<option value="'.$option['value'].'">'.$option['title'].'</option>'.PHP_EOL;
								}
							}
							$header_filter .= '
							<td '.$responsive_classes.'>
								<select name="'.$fld_name_1.'" class="form-control form-filter input-sm">
								'.$sel_options.'
								</select>
							</td>'.PHP_EOL;
							$filter_no++;
							break;
						/* .................. */
						case LFT_COMBO_FROM_TABLE :
							$fld_name_1 = 'filter_'.$column['db_field']."__1";
							$sel_options = (( isset($column['filter']['first_line_message']) && (!empty($column['filter']['first_line_message']))) ? '<option value="">'.$column['filter']['first_line_message'].'</option>' : '<option value="">'._('Selecteaza optiunea').'</option>');
							if (isset($column['filter']['query_table']) && isset($column['filter']['db_field_title']) && isset($column['filter']['db_field_value'])) {
								$query_where    = (isset($column['filter']['id_archive']) ? 'id_archive='.$column['filter']['id_archive'].' AND visible !=0' : 'visible !=0'); 
								$query_order_by = (isset($column['filter']['order_by']) ? 'ORDER BY '.$column['filter']['order_by'] : ''); 
								$query = "SELECT ".$column['filter']['db_field_value']." AS value, ".$column['filter']['db_field_title']." AS title FROM ".el_TableNameWithPrefix($column['filter']['query_table'])." WHERE $query_where $query_order_by";
								$result  = $oDB->db_query($query);
								while ($result_line = $oDB->db_fetch_array($result)) {
									$sel_options    .= '<option value="'.$result_line['value'].'">'.$result_line['title'].'</option>'.PHP_EOL;
								}									
							}
							$header_filter .= '
							<td '.$responsive_classes.'>
								<select name="'.$fld_name_1.'" class="form-control form-filter input-sm">
								'.$sel_options.'
								</select>
							</td>'.PHP_EOL;
							$filter_no++;
							break;						
						/* .................. */
						case LFT_COMBO_INTERACTIVE :
							//$fld_name_1 = $column['db_field']."_1";
							$categs_no=0;
							if (isset($column['filter']['categories'])) {
								if (is_array($column['filter']['categories'])) {
									$i=0;
									$filter_categ_table = '';
									$filter_id_archive  = '';
									$filter_fields      = '';
									$value_fields       = '';
									$title_fields       = '';
									$order_by           = '';
									$first_values       = '';
									
									foreach ($column['filter']['categories'] as $row) {
										$arr_categ[$i][0]=$row['db_field_value'];
										$arr_categ[$i][1]=$row['db_field_title'];
										$arr_categ[$i][2]=$row['id_archive'];
										$arr_categ[$i][3]=$row['first_line_message'];
										$arr_categ[$i][4]=$row['read_only'];
										$arr_categ[$i][5]=el_TableNameWithPrefix($row['query_table']);
										$arr_categ[$i][6]=$row['db_field_filter'];
										$arr_categ[$i][8]=$row['limit_items'];
										$arr_categ[$i][9]=$row['order_by_field'];
										$arr_categ[$i][10]=$row['order_direction'];
										
										$filter_categ_table .= ($i!=0 ? ';' : '').$row['query_table'];
										$filter_id_archive  .= ($i!=0 ? ';' : '').$row['id_archive'];
										$filter_fields      .= ($i!=0 ? ';' : '').$row['db_field_filter'];
										$value_fields       .= ($i!=0 ? ';' : '').$row['db_field_value'];
										$title_fields       .= ($i!=0 ? ';' : '').$row['db_field_title'];
										$order_by           .= ($i!=0 ? ';' : '').$row['order_by_field'].' '.$row['order_direction'];
										$first_values       .= ($i!=0 ? ';' : '').$row['first_line_message'];
										$i++;
									}
								}
							}
							$categs_no=$i;

							$table_name = $arr_categ[0][5];
							
							$first_select_content = '';
							$query 		  		  = "SELECT ".$arr_categ[0][0]." AS id, ".$arr_categ[0][1]." AS title FROM ".$table_name." WHERE id_archive=".$arr_categ[0][2]." AND visible!=0 ORDER BY ".$arr_categ[0][9]." ".$arr_categ[0][10]." LIMIT ".$arr_categ[0][8];
							$result               = $oDB->db_query($query);
							while ($result_line = $oDB->db_fetch_array($result)) {				
								$first_select_content .= '<option value="'.$result_line['id'].'">'.$result_line['title'].'</option>'.PHP_EOL;
							}				
							$field_str = '';
							for ($i = 0; $i < $categs_no; $i++) {
								$base_control_name = 'filter_'.$column['db_field'].'_mc';
								$fld_name=$base_control_name.'_'.($categs_no-$i);								
								$field_str .= '
									<div class="margin-bottom-5">
										  <select required="" id="'.$fld_name.'" name="'.$fld_name.'" oninvalid="this.setCustomValidity(\''.$arr_categ[$i][3].'\')" onchange="try{this.setCustomValidity(\'\');reload_combo_when_change('.($categs_no-$i).',this.options[this.selectedIndex].value,\''.$base_control_name.'\', \''.$filter_categ_table.'\', \''.$filter_id_archive.'\', \''.$filter_fields.'\', \''.$value_fields.'\', \''.$title_fields.'\', \''.$order_by.'\', \''.$first_values.'\');}catch(e){}" class="form-control form-filter input-sm" >
												<option value="">'.$arr_categ[$i][3].'</option>
												'.($i==0 ? $first_select_content : '').'
										  </select>
									</div>'.PHP_EOL;
							}
							
							$header_filter .= '<td '.$responsive_classes.'> '.$field_str.' </td>';
							break;
						/* .................. */
						default:
							$header_filter .= '<td '.$responsive_classes.'> </td>';
							break;					
					}
			} else {
				$header_filter .= '<td '.$responsive_classes.'> </td>';
			}
		}
		//$header_title .= '<th width="10%"> Actiuni </th></tr>'.PHP_EOL;
		$header_title .= '<th width=""> Actiuni </th></tr>'.PHP_EOL;
		
		$header_filter .= '
			<td>
				'.($filter_no ? '<button class="btn btn-sm green btn-outline filter-submit margin-bottom-5" id="filter_button_list"><i class="fa fa-search"></i><span class="hidden-xs"> Cauta</span></button><button class="btn btn-sm red btn-outline filter-cancel margin-bottom-5" title="Reseteaza filtru"><i class="fa fa-times" title="Reseteaza filtru"></i> </button>' : '').'
			</td>
		</tr>'.PHP_EOL;
		if ($return==0) {
			echo $header_title.$header_filter;
		} else {
			return $header_title.$header_filter;
		}
	}
	/* ------------------------------------------------------------------------------------- */
	public function getClassName(){
		return get_class($this);
	}
	/* ------------------------------------------------------------------------------------- */
	/**
		* Add a item to breadcrumbs
		* @param string   $title        		 Items title
		* @param string   $link        		 	 Link of item (Set empty string for: no link)
	*/	
	public function AddItemToBreadcrumbs($title, $link) {
		array_push($this->breadcrumbs,array($title, $link));
	}
	/* ------------------------------------------------------------------------------------- */
	/**
		* Remove all items from breadcrumbs except first
	*/	
	public function ClearBreadcrumbs() {		
		$this->breadcrumbs = array_slice($this->breadcrumbs, 0, 1); 
	}	
	/* ------------------------------------------------------------------------------------- */
	/**
		* Display archive breadcrumbs
	*/	
	public function ShowBreadcrumbs() {
		$breadcrumbs_length = count($this->breadcrumbs);
		$str_items = '<ul class="page-breadcrumb">';
		for ($i = 0; $i < $breadcrumbs_length; $i++) {
			if (!empty($this->breadcrumbs[$i][1])) {
		    	$str_items .= '<li><a href="'.$this->breadcrumbs[$i][1].'">'.$this->breadcrumbs[$i][0].'</a>'.(($i+1)<$breadcrumbs_length ? '<i class="fa fa-circle"></i>' : '').'</li>'.PHP_EOL;
			} else {
				$str_items .= '<li>'.$this->breadcrumbs[$i][0].(($i+1)<$breadcrumbs_length ? '<i class="fa fa-circle"></i>' : '').'</li>'.PHP_EOL;
			}
		}
		$str_items .='</ul>'.PHP_EOL;
		echo $str_items;
	}		
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Add a item to panel actions
		* @param string   $title        		 Action title
		* @param string   $link        		 	 Link of action (Set empty string for: no link)
		* @param string   $link        		 	 Icon class for action: Ex: "icon-bell"
	*/	
	public function AddItemToActions($title, $link, $icon_class) {
		array_push($this->actions,array($title, $link, $icon_class));
	}

	/* ------------------------------------------------------------------------------------- */	
	/**
		* Remove all items from actions array
	*/	
	public function ClearActions() {		
		$this->actions = array_slice($this->actions, 0, 0); 
	}		
	/* ------------------------------------------------------------------------------------- */	
	/* display action top menu */
	public function ShowActions() {
		if ($this->display_actions) {
			$actions_length = count($this->actions);
			if ($actions_length>0) {
				$str_actions = '<div class="btn-group pull-right">
	                                <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Navigation
	                                    <i class="fa fa-angle-down"></i>
	                                </button>
	                                <ul class="dropdown-menu pull-right" role="menu">'.PHP_EOL;
				for ($i = 0; $i < $actions_length; $i++) {
					if (!empty($this->actions[$i][0])) {
				    	$str_actions .= '<li><a href="'.(!empty($this->actions[$i][1]) ? $this->actions[$i][1] : 'javascript:void(0);').'">'.((!empty($this->actions[$i][2])) ? '<i class="'.$this->actions[$i][2].'"></i>' : '').' '.$this->actions[$i][0].'</a></li>'.PHP_EOL;
				    }
				}
				$str_actions .='</ul></div>'.PHP_EOL;
				echo $str_actions;
			}
		}
	}			
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Remove all items from actions array
	*/	
	public function ClearActionsMore() {		
		$this->actions_more = array_slice($this->actions_more, 0, 0); 
	}			
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Add a item to button more, on edit archive
		* @param string   $title        		 Action title; 
		* @param string   $link        		 	 Link of action (Set empty string for: no link)
	*/	
	public function AddItemToActionsMore($title, $link, $icon_class='', $target='') {
		array_push($this->actions_more,array($title, $link, $icon_class, $target));
	}
	
	/* ------------------------------------------------------------------------------------- */		
	/* display action for more button on edit archive */
	private function ReturnActionsMoreString() {
			$str_actions = '';
			$actions_length = count($this->actions_more);
			if ($actions_length>0) {				
				for ($i = 0; $i < $actions_length; $i++) {
					if (!empty($this->actions_more[$i][0])) {
						$str_actions .= '<li><a '.((!empty($this->actions_more[$i][3])) ? 'target='.$this->actions_more[$i][3] : '').' href="'.(!empty($this->actions_more[$i][1]) ? $this->actions_more[$i][1] : 'javascript:void(0);').'">'.((!empty($this->actions_more[$i][2])) ? '<i class="'.$this->actions_more[$i][2].'"></i>' : '').' '.$this->actions_more[$i][0].'</a></li>'.PHP_EOL;
				    }
				}
			}
			return $str_actions;
	}
	
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Add message to notifications stack
		* @param string   $msg        		 	 Notification message
		* @param int      $msg_type    		 	 Type of message, as per constants: MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING (defined in config.php)
	*/	
	public function AddNotification($msg, $msg_type) {
		if (!empty($msg)) {
			array_push($this->notifications,array($msg, $msg_type));
		}
	}

	/* ------------------------------------------------------------------------------------- */	
	/**
		* Remove all notification messages from stack
	*/	
	public function ClearNotifications() {		
		$this->notifications = array_slice($this->notifications, 0, 0); 
	}	
	/* ------------------------------------------------------------------------------------- */
	/* display action top menu */
	public function ShowNotifications() {
			$info_length = count($this->notifications);
			if ($info_length>0) {
				$str_info = '';
				for ($i = 0; $i < $info_length; $i++) {
					if (!empty($this->notifications[$i][0])) {
				    	$str_info .= '<div class="note '.$this->ReturnMessageClassFromType($this->notifications[$i][1]).'">
				    					'.(($this->notifications[$i][0] !=strip_tags($this->notifications[$i][0])) ? $this->notifications[$i][0] : '<p>'.$this->notifications[$i][0].'</p>').'
                            		  </div>'.PHP_EOL;
				    }
				}				
				echo $str_info;
			}
	}	
	/* ------------------------------------------------------------------------------------- */
	public function ReturnMessageClassFromType($msg_type){
		switch ($msg_type) {
		    case MSG_SUCCESS: return 'note-success'; 
		    case MSG_INFO   : return 'note-info';    
		    case MSG_DANGER : return 'note-danger';  
		    case MSG_WARNING: return 'note-warning'; 
		}
	}	
	/* ------------------------------------------------------------------------------------- */
	public function ReturnAlertsClassFromType($msg_type){
		switch ($msg_type) {
		    case MSG_SUCCESS: return 'alert-success'; 
		    case MSG_INFO   : return 'alert-info';    
		    case MSG_DANGER : return 'alert-danger';  
		    case MSG_WARNING: return 'alert-warning'; 
		}
	}	
	/* ------------------------------------------------------------------------------------- */
	/**
		* Add message to alerts stack
		* @param string   $msg        		 	 Alert message
		* @param int      $msg_type    		 	 Type of message, as per constants: MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING (defined in config.php)
		* @param string   $msg_icon_class	 	 Icon class for notification: Ex: "icon-bell","fa fa-map"
	*/	
	public function AddAlert($msg, $msg_type, $msg_icon_class) {
		if (!empty($msg)) {
			array_push($this->alerts,array($msg, $msg_type, $msg_icon_class));
		}
	}

	/* ------------------------------------------------------------------------------------- */
	/**
		* Remove all notification messages from stack
	*/	
	public function ClearAlerts() {		
		$this->alerts = array_slice($this->alerts, 0, 0); 
	}	
	/* ------------------------------------------------------------------------------------- */
	/* display action top menu */
	public function ShowAlerts() {
			$alerts_length = count($this->alerts);
			if ($alerts_length>0) {
				$str_info = '';
				for ($i = 0; $i < $alerts_length; $i++) {
					if (!empty($this->alerts[$i][0])) {
				    	$str_info .= '<div class="alert '.$this->ReturnAlertsClassFromType($this->alerts[$i][1]).' margin-bottom-10">
									    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
									    '.((!empty($this->alerts[$i][2])) ? '<i class="'.$this->alerts[$i][2].'"></i>' : '').' '.$this->alerts[$i][0].' 
									</div>'.PHP_EOL;
				    }
				}				
				echo $str_info;
			}
	}				
	/* ------------------------------------------------------------------------------------- */
	/**
		* Remove all items from global actions array
	*/	
	public function ClearGlobalActions() {		
		$this->actions_more = array_slice($this->global_actions, 0, 0); 
	}			
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Add a item to combo global actions, on list archive
		* @param string   $title        		 Action title; 
		* @param string   $archive_method_name 	 Method name of archive wich will be fired when execute this global action
	*/	
	public function AddItemToGlobalActions($title, $archive_method_name) {
		array_push($this->global_actions,array($title, $archive_method_name));
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ReturnGlobalActionsString() {
		$str_actions = '';
		$actions_length = count($this->global_actions);
		if ($actions_length>0) {				
			for ($i = 0; $i < $actions_length; $i++) {
				if (!empty($this->global_actions[$i][0])) {
					$str_actions .= '<option value="'.el_encript_info($this->global_actions[$i][1]).'">'.$this->global_actions[$i][0].'</option>'.PHP_EOL;
				}
			}
		}
		return $str_actions;
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* 
		Method will execute global action DELETE. The methosd must have as paratemer: array with encripted ids (which will be delete).
		All methods defined for global actions must return empty string for success or error message in case of error.
	*/
	public function GlobalActions_Delete($arr_encripted_id) {
		global $oDB;
		$ERROR     = false;
		$ERROR_MSG = '';
		if (!$this->permission_delete_item) {
			$ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de stergere inregistrari in arhiva curenta !');
		}
		if (!$ERROR) {
			// check if exist selected id which can not delete because field "can_delete" of archive table is 0.
			$no_items_from_array = count($arr_encripted_id);
			$list_of_id = '';
			$contor = 0;
			foreach ($arr_encripted_id as $key => $value) {
				$list_of_id .= ($contor!=0 ? ',' : '').el_decript_info($value);
				$contor++;
			}
			$where =  $this->query_where." AND $this->real_table_name.id IN ($list_of_id) AND $this->real_table_name.can_delete!=0 ";
			$no_items_from_table = $oDB->table_records_number($this->table_name, $where);
			if ($no_items_from_array!=$no_items_from_table) {
				$ERROR = true; $ERROR_MSG = _('Exista inregistrari selectate pe care nu aveti dreptul sa le stergeti !');
			}			
		}
		if (!$ERROR) {
			$query = "DELETE FROM $this->real_table_name WHERE $this->real_table_name.id IN ($list_of_id)";
			$result = $oDB->db_query($query);
			if ($oDB->db_affected_rows($result)!=$no_items_from_array) {
				$ERROR = true; $ERROR_MSG = _('Eroare stergere inregistrari !');
			} 
		}
		
		return $ERROR_MSG;
	}
	/* ------------------------------------------------------------------------------------- */	

	public function ShowTopButtons($title_left=true){
		?>
                                    <div class="portlet-title">
                                    	<?php if ((!empty($this->archive_title)) || (!empty($this->archive_icon_class))) { ?>
											<?php if ($title_left) { ?>
	                                        <div class="caption">
	                                            <?=((!empty($this->archive_icon_class)) ? '<i class="'.$this->archive_icon_class.'"></i>' : '')?> <?=$this->archive_title?>
	                                        </div>
											<?php } ?>
                                        <?php } ?>
                                        <div class="actions btn-set">
                                            <?php if ($this->edit_button_back_show) { ?>
                                            	<button type="button" name="back" class="btn btn-secondary-outline but_el_app" onclick="cst_BackFromEditArchive('<?=$this->url_referer?>')"><i class="fa fa-angle-left"></i> <?=_('Back')?></button>
                                            <?php } ?>
                                            <?php if ($this->edit_button_save_show) { ?>
                                            	<button type="submit" class="btn btn-success but_el_app" goto="<?=$this->url_referer?>"><i class="fa fa-save"></i> <?=_(($this->item_id ? 'Save & go back' : 'Adauga inregistrare'))?></button>
                                            <?php } ?>
                                            <?php if (($this->edit_button_save_continue_show) && ($this->item_id)) { ?>
                                            	<button type="submit" class="btn btn-success but_el_app" id="yyy" title="Save & Continue edit"><i class="fa fa-pencil-square-o" title="Save & Continue edit"></i> <?=_('Save')?></button>
                                            <?php } ?>
                                            <?php if (($this->edit_button_more_show) && ($this->item_id!=0)) { ?>
                                            <div class="btn-group">
                                                <a class="btn btn-success dropdown-toggle but_el_app" href="javascript:;" data-toggle="dropdown">
                                                    <i class="fa fa-share"></i> <?=_('Plus')?>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <div class="dropdown-menu pull-right">
													<?=$this->ReturnActionsMoreString()?>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>		
		<?php
	}
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Metoda va fi executata inainte de afisarea listei cu inregistrari a arhivei
		* 
	*/
	public function ExecureBeforeLoadList() {
		
	}
	/* ------------------------------------------------------------------------------------- */	
	
	/**
		* Display list items of archive
		* 
	*/
	public function ShowList() {
		 global $oDB;
		 $ERROR     = false;
		 $ERROR_MSG = '';		
		 if (!$ERROR) {
			 if (!$this->CanViewListLoggedUser()) {
				 $ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a vizualiza inregistrarile acestei arhive ( ARCHTYPE: '.$this->archtype.' ) (1) !');
			 }
		 }
		 if ($ERROR) {
			 $this->parent->ShowMessage($ERROR_MSG,'','&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;',MSG_WARNING);
		 } else {
			$this->ExecureBeforeLoadList();
		 	include(__THEMEPATH__.'app_header.php');
		 	include(__THEMEPATH__.'page_list.php');
		 	include(__THEMEPATH__.'app_footer.php');
			adm_AddTrackingInfo('Acceseaza sectiunea: '.$this->list_archive_title);
		 }
	}			
	/* ------------------------------------------------------------------------------------- */
	/**
		* Display list items of archive inside TAB
		* 
	*/
	public function ShowListInTab($tab_no=0, $archive_name='') {
		 global $oDB;
		 $ERROR           = false;
		 $ERROR_MSG       = '';		
		 $list_to_display = '';
		 
		 if (!$ERROR) {
			 if (!$this->CanViewListLoggedUserInTab()) {
				 $ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a vizualiza inregistrarile acestei arhive ( ARCHTYPE: '.$this->archtype.' ) (1) !');
			 }
		 }
		 if ($ERROR) {
			 $this->parent->ShowMessage($ERROR_MSG,'','&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;',MSG_WARNING);
		 } else {
			$this->ExecureBeforeLoadList();
			$grid            = 'grid'.$tab_no; 
			$grid_src        = $archive_name.$tab_no; 
			$but_add = ($this->list_add_button_show ? '<a class="btn red-mint btn-outline sbold uppercase" href="'.$this->LinkToAddItemInTab($archive_name, $tab_no).'">  <i class="fa fa-file-o"></i> '.$this->list_add_button_name.' </a>' : '');
			$list_to_display = '
					<div class="clearfix"> </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="'.$this->list_archive_icon_class.' font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase">'.$this->list_archive_title.'</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided">
											'.$but_add.'
											<!--<a class="btn red-mint btn-outline sbold uppercase" href="'.$this->LinkToAddItemInTab($archive_name, $tab_no).'">  <i class="fa fa-file-o"></i> '.$this->list_add_button_name.' </a>-->
											<!--<a class="btn btn-default" role="button" href="javascript:'.$grid.'.getDataTable().ajax.reload();">  <i class="fa fa-refresh"></i> Refresh </a>-->
											<button class="btn btn-default" type="button" onclick="'.$grid.'.getDataTable().ajax.reload(\'\',false);"><i class="fa fa-refresh"></i> Refresh</button>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-outline" href="javascript:;" data-toggle="dropdown">
                                                <i class="fa fa-share"></i>
                                                <span class="hidden-xs"> Tools </span>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="'.$this->LinkExportToMSExcel().'"> Export to MSExcel </a>
                                                </li>
                                                <li>
                                                    <a href="'.$this->LinkExportToCSV().'"> Export to CSV </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>									
                                </div>								
                                <div class="portlet-body">
                                    <div class="table-container">
										 <div class="table-actions-wrapper">	
										'.$this->ShowAlerts().'
										</div>
                                        <div class="table-actions-wrapper">											
                                            <span> </span>
                                            <select class="table-group-action-input form-control input-inline input-small input-sm">
                                                <option value="">Global actions...</option>
                                                '.$this->ReturnGlobalActionsString().'
                                            </select>
                                            <button class="btn btn-sm green table-group-action-submit">
                                                <i class="fa fa-check"></i><span class="hidden-sm hidden-md hidden-xs"> Submit</span></button>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover table-checkable" id="'.$grid_src.'">
                                            <thead>
												'.$this->ShowListHeader(1).'
                                            </thead>
                                            <tbody> </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- End: life time stats -->
                        </div>
                    </div>
					<div class="clearfix"> </div>
			'.PHP_EOL;
			
		 }
		 return $list_to_display;
	}			
	
	/* ------------------------------------------------------------------------------------- */
	/**
		* Display edit panel of archive
		* @param int   $id        		 id of item wich will edit; if $id==0 -> means add new item
	*/

	public function ShowEdit($id) {		 
		 global $oDB;
		 $ERROR     = false;
		 $ERROR_MSG = '';
		 
		 $enc_id = $id;
		 $id = el_decript_info($id);
		 /* ===================================================== */
		 /* set edit parameters as per user rights */
		 if (!$this->user_rights_by_admin['administrator']) {
			 /* user is not admin */
			 if ($id!=0) {
				if ((isset($this->permission_update_item)) && ($this->permission_update_item==0)) {
					$this->edit_button_save_show          = 0;	
					$this->edit_button_save_continue_show = 0;
					$this->user_can_update_archive		  = 0;					
				}
				if ((!$this->permission_edit_item) || (!$this->AdminAllowToEditItem())) { $ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a vizualiza inregistrari din aceasta arhiva (1) !');}
			 } else {
				if ((isset($this->permission_add_item)) && ($this->permission_add_item==0)) {
					$this->edit_button_save_show          = 0;	
					$this->edit_button_save_continue_show = 0;
					$this->user_can_update_archive		  = 0;
				}
				if ((!$this->permission_add_item) || (!$this->AdminAllowToAddItem())) { $ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a adauga inregistrari in aceasta arhiva !');}
			 }
			 if (!$ERROR) {	
				 if ((isset($this->user_view_only_own_records)) && ($this->user_view_only_own_records==1)) {					 
					 $query ="SELECT COUNT(*) AS items_no FROM $this->real_table_name WHERE id=$id AND add_by = $this->user_id";
					 $result = $oDB->db_query($query);
  				     if ($result_line = $oDB->db_fetch_array($result)) {
						if ($result_line['items_no']!=1) {
							$ERROR = true; $ERROR_MSG = _('Nu aveti drepturi pentru aceasta inregistrare!');
						}
					 }
				 }
			 }			 
		 }
		 /* ===================================================== */
		 if (!$ERROR) {
			 if ($id!=0) {
				 // edit items
				 /* ----- */
				 if (!$ERROR) {
					if (empty($this->table_name)) {
						throw new Exception('Specificati "table_name" in clasa '.get_class($this));
					} else {
						$table_name = $this->table_name;
						$eval_str = "\$table_name = \$oDB->$table_name;";
						eval($eval_str);
						$query  = "SELECT * FROM ".$table_name." WHERE id=$id";
						$result = $oDB->db_query($query);
						if ($oDB->db_num_rows($result)!=1) {
							$ERROR = true; $ERROR_MSG = _('Nu exista in arhiva aceasta inregistrare, pentru a fi editata !');
						} else {
							  if ($result_line = $oDB->db_fetch_array($result)) {
								  if ($result_line['can_edit']==0) {
									  $ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a modifica aceasta inregistrare ( ID: '.$id.', ARCHTYPE: '.$this->archtype.' ) (1) !');
								  }
							  }
						}
					}
				 }
				 /* ----- */
				 if (!$ERROR) {
					 if (!$this->CanEditItemLoggedUser($id)) {
						 $ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a modifica aceasta inregistrare ( ID: '.$id.', ARCHTYPE: '.$this->archtype.' ) (2) !');
					 }
				 }
				 /* ----- */
				 // get result2 for all multiselect combo in the archive
				 $result2='';
				 if ($this->tabs) {
					 $list_id_archive=array();
					 $contor = 0;
					 foreach ($this->tabs as $curent_tab) {
						$tab_class_name  = $curent_tab[1];
						if (class_exists("$tab_class_name")) {
							$eval_str = "\$objTab = new $tab_class_name(\$this);"; 
							eval($eval_str);												
							foreach ($objTab->fields as $field) {
								if (($field['type']==FIELD_TYPE_COMBO_MULTISELECT) || ($field['type']==FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE)) {
									$list_id_archive[$contor][0] = $field['store_table'];
									$list_id_archive[$contor][1] = $field['store_table_id_archive'];
									$contor++;
								}								
							}
						} else {
							$ERROR = true; $ERROR_MSG = _('Nu exista definita clasa '.$tab_class_name);
							break;
						}						 
					 }
					 if (!$ERROR) {						
						$no_of_id = count($list_id_archive);        
						if ($no_of_id!=0) {
							$query= '';
							for ($i = 0; $i < $no_of_id; $i++) {
								if ($i!=0) { $query .= " UNION ";}
								$query .= "( SELECT * FROM ".el_TableNameWithPrefix($list_id_archive[$i][0])." WHERE id_archive=".$list_id_archive[$i][1]." AND id_main_item=$id )";
							}
							$result2 = $oDB->db_query($query);
						}						 
					 }
				 }
				 /* ------ */
				 if (!$ERROR) {
					 $this->result_line        = $result_line;
					 $this->result_multiselect = $result2;
				 }
				 /* ----- */
			 }
		 }
		 /* ===================================================== */
		 if ($ERROR) {
			 $this->parent->ShowMessage($ERROR_MSG,$this->LinkToList($this->archtype),'&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;',MSG_WARNING);			 
		 } else {			
			/* -------------------- */
			if (isset($_SERVER["HTTP_REFERER"])) {
				$url_referer   = $_SERVER["HTTP_REFERER"];
				$arr_url_param = el_UrlStringWithParametersToArray($url_referer);
				if ($arr_url_param == false) {					
				} else {
					if ($id==0) {
						/* daca este adaugare */
						if (isset($arr_url_param['archtype'])) {
							$curent_archtype = preg_replace('/archive_/', '', get_class($this), 1);
							if ($arr_url_param['archtype']!=$curent_archtype){
								if (isset($arr_url_param['id'])) {
									$id_parent_categ = el_decript_info($arr_url_param['id']); 
									$class_name_p  = "archive_".$arr_url_param['archtype'];
									if (class_exists("$class_name_p")) {
										$eval_str = "\$objArchive = new $class_name_p(NULL);"; 
										eval($eval_str);
										foreach ($objArchive->list_fields as $field) {
											if (isset($field["main-fields"]) && $field["main-fields"]==true) {
												if (isset($field["db_field"])) {
													$query_parent = "SELECT ".$field["db_field"]." AS name FROM ".$objArchive->real_table_name." WHERE id =".$id_parent_categ;
													$result = $oDB->db_query($query_parent);
													$name_parent_categ = '';
													if ($result_line = $oDB->db_fetch_array($result)) {
														$name_parent_categ = $result_line['name'];														
													}
													$this->archive_title = $this->archive_title.' | '.'<span class="font-green-sharp bold uppercase">'.$name_parent_categ.'</span>';
												}
												break;
											}
										}
									} else {
										//$ERROR = true; $ERROR_MSG = _('Eroare: Nu exista definita clasa "'.$archtype.'" !');
									}
								}
							}						
						}		
					}						
				}						
			}
			/* -------------------- */
			$this->item_id = $id; 
			$this->item_id_encripted = $enc_id;	
			//$this->archive_title_top_small = $this->archive_title_top_small.' <a href="'.$this->url_referer.'">Vezi lista</a>';	
			$this->AddItemToActionsMore('Item info',"javascript:cst_GetItemInfo('".$enc_id."','".el_encript_info($this->archtype)."');", 'fa fa-info');
			$this->AddItemToActionsMore('Delete this item',"javascript:cst_DeleteItemArchive('".$enc_id."','".el_encript_info($this->archtype)."');", 'fa fa-trash');
		 	include(__THEMEPATH__.'app_header.php');
		 	include(__THEMEPATH__.'page_edit.php');
		 	include(__THEMEPATH__.'app_footer.php');
			if ($this->item_id==0) {
				adm_AddTrackingInfo('Acceseaza ADAUGA INREGISTRARE in : '.$this->list_archive_title);
			} else {
				adm_AddTrackingInfo('Deschide in '.$this->list_archive_title.' inregistrarea cu id-ul '.$this->item_id);
			}
		 }		 
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* returneaza true daca TAB-UL poate fi afisat */
	public function CanDisplayTab($objTab) {
		$DISPLAY_TAB = true;
		if ($objTab->edit_tab==false) {
			// este tab tip lista
			if (empty($this->result_line) && ($objTab->edit_tab==false)) {
				// daca este adaugare si este tab tip lista
				$DISPLAY_TAB = false;
			}
		} else {
			// este tab cu inputuri
			if (empty($this->result_line) &&($objTab->show_on_add==false)) {
				$DISPLAY_TAB = false;
			}
			if ((!empty($this->result_line)) &&($objTab->show_on_edit==false)) {
				$DISPLAY_TAB = false;
			}						
		}
		if ($objTab->Hide($this->result_line)) {
			$DISPLAY_TAB = false;						
		}								
		/* ............... */
		// xxx - verifica daca userul are drepturi de acces (setate de admin) pentru vizualizarea tabului de tip lista					
		if ($DISPLAY_TAB) {
			if ($objTab->edit_tab==false) {
				//este tab tip lista
				if (isset($objTab->archive_name)) {
					$class_name_list = $objTab->archive_name;
					$eval_str = "\$objArchive_tmp = new $class_name_list(NULL, '');";
					eval($eval_str);
					if (!$objArchive_tmp->CanViewListLoggedUser()) {
						$DISPLAY_TAB = false;
						//$tabs_no++;
					} else {
						$DISPLAY_TAB = true;
					}
					unset($objArchive_tmp);
				}
			}
		}
		return $DISPLAY_TAB;
	}
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Display tabs inside edit panel
	*/	
	public function ShowTabs() {
		$content = '';
		if ($this->tabs) {
			/* ------------------------------------------------*/
			$tabs_nav     = '<ul class="nav nav-tabs">';	
			$tabs_content = '<div class="tab-content">';
			$tabs_count   = 0;
			$tabs_no      = 0;
			foreach ($this->tabs as $curent_tab) {
				$tab_class_name  = $curent_tab[1];
				if (class_exists("$tab_class_name")) {
					$eval_str = "\$objTab = new $tab_class_name(\$this);"; 
					eval($eval_str);
					$objTab->init($this);
					/* ............... */
					$DISPLAY_TAB = $this->CanDisplayTab($objTab);
					/* ............... */
					$DISPLAY_SIDEBAR = false;
					if (($objTab->edit_tab==true) && ($objTab->show_sidebar==true)) {
						$LEFT_COLUMN_WIDTH = 12-$objTab->sidebar_width;
						if ($LEFT_COLUMN_WIDTH>=6) {
							$RIGHT_COLUMN_WIDTH = $objTab->sidebar_width;
							$DISPLAY_SIDEBAR = true;
						}						
					}
					/* ............... */
					if ($DISPLAY_TAB) {
						$tabs_count++;
						$tabs_nav     .= '<li '.($tabs_count==$this->active_tab ? 'class="active"' : '').'><a class="fs16" href="#tab_'.$tabs_count.'" data-toggle="tab"> '.$curent_tab[0].(isset($curent_tab[2]) ? ' ('.$curent_tab[2].')':'').' </a></li>'.PHP_EOL;
						$tabs_content .= '<div class="tab-pane '.($tabs_count==$this->active_tab ? 'active' : '').'" id="tab_'.$tabs_count.'">
											<div class="form-body">
												'.(($DISPLAY_SIDEBAR) ? '<div class="row"><div class="col-md-'.$LEFT_COLUMN_WIDTH.'">'.($objTab->boxed ? '<div class="portlet light bordered">' : '') : '').PHP_EOL; 
												/* ---------------- */
													$tabs_content .= $objTab->ReturnTabContent($objTab->fields, $this->result_line, $this->result_multiselect, $tabs_no);
													/* ................................... */
													// for upload tabs
													if (property_exists("$tab_class_name", 'upload_accepted_file_type')) {
														if (!isset($this->upload_file_type)) {
															$this->createProperty('upload_file_type', $objTab->upload_accepted_file_type);
														} else {
															$this->upload_file_type = $objTab->upload_accepted_file_type;
														}
														if (!isset($this->upload_tab_class)) {
															$this->createProperty('upload_tab_class', "$tab_class_name");
														} else {
															$this->upload_tab_class = "$tab_class_name";
														}													
													}
													$tabs_no++;
													/* ................................... */
												/* ---------------- */
						$tabs_content .= '		    '.(($DISPLAY_SIDEBAR) ? ($objTab->boxed ? '</div>' : '').'</div><div class="col-md-'.$RIGHT_COLUMN_WIDTH.'">'.$objTab->DisplaySideBarContent($this->result_line).'</div></div>' : '').'
											</div>
									  </div>'.PHP_EOL;
					}
				}  else {
						throw new Exception('Nu exista definita clasa '.$tab_class_name);
						}
			}
			$tabs_nav     .= '</ul>'.PHP_EOL;
			$tabs_content .= '</div>'.PHP_EOL;
			/* ------------------------------------------------*/
			$content = $tabs_nav.$tabs_content;
		}
		return $content;
	}
	/* ------------------------------------------------------------------------------------- */	
	/* If logged user can edit item return TRUE. Othewise FALSE. Method will be rewritten if necessary */
	public function CanEditItemLoggedUser($id){
		$GRANTED_ACCES = true;
		if (!$this->permission_edit_item) {
			$GRANTED_ACCES =false;
		}
		if ($GRANTED_ACCES) {
			$GRANTED_ACCES = $this->AdminAllowToEditItem();
		}
		return $GRANTED_ACCES;
	}
	/* ------------------------------------------------------------------------------------- */	
	/* If logged user can edit item return TRUE. Othewise FALSE. Method will be rewritten if necessary */
	public function CanViewListLoggedUser(){
		$GRANTED_ACCES = true;
		if ( $this->user_rights_by_admin && (($this->user_rights_by_admin['administrator']==1) || (isset($this->user_rights_by_admin["$this->archtype"]) && ($this->user_rights_by_admin["$this->archtype"]==1)))) {
			// acces permis			
		} else {
			$GRANTED_ACCES = false;
		}		
		return $GRANTED_ACCES;
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* If logged user can edit item return TRUE. Othewise FALSE. Method will be rewritten if necessary */
	public function CanViewListLoggedUserInTab(){
		return true;
	}	
	
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed before operation INSERT. Method will be rewritten if necessary. The function will return non empty string in case of error; */
	public function ExecuteBeforeInsert(){
		$ERROR_MSG = '';		
		return $ERROR_MSG;
	}
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed after operation INSERT. Method will be rewritten if necessary. The function will return non empty string in case of error; */
	public function ExecuteAfterInsert(){
		$ERROR_MSG = '';
		adm_AddTrackingInfo('Finalizeaza ADAUGARE INREGISTRARE in : '.$this->list_archive_title);
		return $ERROR_MSG;		
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed before operation UPDATE. Method will be rewritten if necessary. Can set parameter $permission_edit_item to 0/1 to block or not UPDATE */
	/**
		* @param int   $id     		 id of updated items
	*/		
	public function ExecuteBeforeUpdate($id){
		$ERROR_MSG = '';
		return $ERROR_MSG;
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed after operation UPDATE. Method will be rewritten if necessary. */	
	/**
		* @param int   $id     		 id of updated items
	*/	
	public function ExecuteAfterUpdate($id){
		$ERROR_MSG = '';	
		adm_AddTrackingInfo("ACTUALIZEAZA/MODIFICA inregistrare in : ".$this->list_archive_title." (id: $id )");
		return $ERROR_MSG;		
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed before operation DELETE. Method will be rewritten if necessary.
	   the function will return non empty string in case of error;
	/**
		* @param int   $id     		 id of deleted items
	*/
	
	public function ExecuteBeforeDelete($id){		
		$ERROR_MSG = '';
		
		$GRANTED_ACCES = true;
		if (!$this->permission_delete_item) {
			/* $this->permission_edit_item este setat de functia SetArchiveUserRightsByAdmin() */
			$GRANTED_ACCES =false;
		}
		if ($GRANTED_ACCES) {
			if ($this->user_rights_by_admin["administrator"]==0) {				
				if (!isset($this->user_rights_by_admin["$this->archtype"])) {
					$GRANTED_ACCES =false;
				} else {
					if ($this->user_rights_by_admin["$this->archtype"]==0) {
						$GRANTED_ACCES =false;
					} else {
						if (isset($this->user_rights_by_admin["permission_delete_item"]) && ($this->user_rights_by_admin["permission_delete_item"]==0)) {
							$GRANTED_ACCES =false;
						}
					}					
				}
			}
		}
		if (!$GRANTED_ACCES) {
			$ERROR_MSG = 'Nu exista drepturi de stergere pentru aceasta inregistrare !';
		}
		
		return $ERROR_MSG;
	}		
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed after operation DELETE. Method will be rewritten if necessary.
	   the function will return non empty string in case of error;
	/**
		* @param int   $id     		 id of deleted items
	*/

	public function ExecuteAfterDelete($id){		
		$ERROR_MSG = '';
		adm_AddTrackingInfo("STERGE in : ".$this->list_archive_title." inregistrearea cu id: $id ");
		return $ERROR_MSG;	
	}		
	/* ------------------------------------------------------------------------------------- */	
	
	/*  store all archive fields of tabs to database 
		will return 'ok' in case of succes, otherwise error message
	*/
	public function StoreTabsFieldsToDatabase($id, $idma=''){
		global $oDB;
		
		$ERROR          = false;
		$ERROR_MSG      = 'ok';		
		$this->item_id  = $id;		
		$STR_SET_FIELDS = "";
		$arr_multiple_options       = array();
		$fields_no_multiple_options = 0;
		$arr_upload_info            = array();
		$arr_delete_file            = array();
		$upl_key                    = 0;
		$del_key                    = 0;
		$this->idma                 = $idma;
		foreach ($this->tabs as $curent_tab) {
			/* ---------------- */
			$tab_class_name  = $curent_tab[1];
			if (class_exists("$tab_class_name")) {
				unset($objTab);
				$eval_str = "\$objTab = new $tab_class_name(\$this);"; 
				eval($eval_str);
				
				if (!empty($idma) && ($idma!=='all')) { 
					$objTab->fields = $objTab->RemoveControlFromTabFields($objTab->fields);
				}
				if ($id==0) { 
					$objTab->fields = $objTab->RemoveControlWithAtribute($objTab->fields, $attr='hide_on_add', true);
				}
				/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
				$update_tab = true;
				if (($id==0) && ($objTab->show_on_add==false)) {
					// este adaugare si tabul nu este afisat la adaugare
					$update_tab = false;
				}
				if (($id!=0) && ($objTab->show_on_edit==false)) {
					// este modificare si tabul nu este afisat la modificare
					$update_tab = false;
				}							
				if ($update_tab==true) {
						foreach ($objTab->fields as $field) {					
							if ($field['type']) {						
								$arr_json = json_decode($this->ReturnSetFieldsString($field, $id), true);
								if ($arr_json['error']==true) {
									$ERROR = true;  $ERROR_MSG = _($arr_json['msg']);
								} else {
									if (!empty($arr_json['msg'])) {
										$STR_SET_FIELDS .= ((!empty($STR_SET_FIELDS)) ? ', ' :'').$arr_json['msg'];
									}
									if (!empty($arr_json['multiple_options_store_table'])) {								
										$arr_multiple_options [$fields_no_multiple_options][0]= $arr_json['multiple_options_values'];
										$arr_multiple_options [$fields_no_multiple_options][1]= $arr_json['multiple_options_store_table'];
										$arr_multiple_options [$fields_no_multiple_options][2]= $arr_json['multiple_options_store_table_id_archive'];
										$fields_no_multiple_options++;
									}
									/* -----  */							
									if (($field['type']==FIELD_TYPE_SELECT_IMAGE) || ($field['type']==FIELD_TYPE_SELECT_FILE)) {
										/* prepare array $arr_upload_info with specific info, in order to upload files (for input with type="file") */
										$fieldnameinput = $field['control_name'];
										if (isset($_FILES["$fieldnameinput"]['name'][0])) {
											$arr_upload_info[$upl_key]['control_name'] = $fieldnameinput;
											if (isset($field['upload_quality'])) { $arr_upload_info[$upl_key]['upload_quality'] = $field['upload_quality']; } /* only for image */
											
											$path_parts     = pathinfo($_FILES["$fieldnameinput"]['name'][0]);
											$file_extension = strtolower($path_parts['extension']);
											$arr_tmp_file   = explode('/', $_FILES["$fieldnameinput"]['tmp_name'][0]);
											$NewFileName    = array_pop($arr_tmp_file).'.'.$file_extension;
											
											$arr_upload_info[$upl_key]['tmp_name']       = $_FILES["$fieldnameinput"]['tmp_name'][0];
											$arr_upload_info[$upl_key]['upload_path']    = __UPLOADPATH__.$NewFileName;
											$arr_upload_info[$upl_key]['name']           = $_FILES["$fieldnameinput"]['name'][0];
											$arr_allowed_extensions                      = array('jpg','jpeg','gif','png');
											$arr_upload_info[$upl_key]['is_image']       = (in_array($file_extension, $arr_allowed_extensions) ? true : false);
											$arr_upload_info[$upl_key]['old_image_path'] = '';
											
											$OLDFILE_CONTROL_NAME  = $fieldnameinput.'_'.'3gURNv';
											if (isset($_POST["$OLDFILE_CONTROL_NAME"])) {										
												$old_file     = el_decript_info($_POST["$OLDFILE_CONTROL_NAME"]);
												if (!empty($old_file)) {
													$parts        = parse_url($old_file);
													$FileToDelete = basename($parts["path"]);											
													$arr_upload_info[$upl_key]['old_image_path'] = __UPLOADPATH__.$FileToDelete;
												}
											}
											
											$upl_key++;
										} else {
											$OLDFILE_CONTROL_NAME  = $field['control_name'].'_'.'3gURNv';
											$STATE_CONTROL_NAME    = $OLDFILE_CONTROL_NAME.'_1';
											if (isset($_POST["$OLDFILE_CONTROL_NAME"]) && isset($_POST["$STATE_CONTROL_NAME"])) {
												
												if ($_POST["$STATE_CONTROL_NAME"]==0) {
													$url_to_delete = el_decript_info($_POST["$OLDFILE_CONTROL_NAME"]);
													if (!empty($url_to_delete)) {
														$parts        = parse_url($url_to_delete);
														$FileToDelete = basename($parts["path"]);																							
														$arr_delete_file[$del_key]['file_to_delete'] = __UPLOADPATH__.$FileToDelete;												
														//$ERROR_MSG = $arr_delete_file[$del_key]['file_to_delete']; $ERROR = true; break;
														$del_key++;
													}
												}
											}
										}
									}
									/* -----  */
								}
							}
							if ($ERROR) {break;}					
						}
				}
				/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
			} else {
				$ERROR = true;  $ERROR_MSG = _('Nu exista definita clasa "'.$tab_class_name.'" in arhiva "'.get_class($this).'"');
			}
			/* ---------------- */
		}
		
		if (!$ERROR) {
			/* ........... */
			if (!empty($STR_SET_FIELDS)) {
				$app_logged_user_id = el_decript_info($_SESSION[APP_ID]["user"]["id"]);
				if (($idma!='all') && (trim($idma)!='')) { $STR_SET_FIELDS .= ", "."idma='$idma' "; }
				$ARCHIVE_TABLE   = el_TableNameWithPrefix($this->table_name);
				$STR_SET_FIELDS .= ", "."id_archive='".$this->ida."' ";
				$ACTION          = "INSERT INTO $ARCHIVE_TABLE SET ";
				$WHERE           = "";
				if ($id!=0) {
					// it's update
					$ACTION  = "UPDATE $ARCHIVE_TABLE SET ";
					$WHERE   = "WHERE id='$id'";
					$id_main_item_for_atribute = $id;
				}
				
				//$PERMISSION_QUERY = true;
				if ($id!=0) { 
					// it's update
					$STR_SET_FIELDS .= ", "."mod_by='".$app_logged_user_id."' ";
					$ERROR_MSG = $this->ExecuteBeforeUpdate($id);
					if (!empty($ERROR_MSG)) { $ERROR = true; } else { $ERROR_MSG = 'ok'; $ERROR = false;}
					
				} else {
					//it's insert
					$STR_SET_FIELDS .= ", "."add_by='".$app_logged_user_id."' ";
					$STR_SET_FIELDS .= ", "."mod_by='".$app_logged_user_id."' ";
					$ERROR_MSG = $this->ExecuteBeforeInsert();		
					if (!empty($ERROR_MSG)) { $ERROR = true; } else { $ERROR_MSG = 'ok'; $ERROR = false;}				
				}
				if (!$ERROR) {
					/* .................. */
					/* upload files/photo */
					$ERROR_MSG = $this->UploadFiles($arr_upload_info);
					if (!empty($ERROR_MSG)) { $ERROR = true; }
				}
				if (!$ERROR) {
					// delete removed photos
					$this->DeleteFiles($arr_delete_file);
				}
				if (!$ERROR) {
					/* .................. */
					$SQL_QUERY = $ACTION.$STR_SET_FIELDS.$WHERE;
					$result = $oDB->db_query($SQL_QUERY);										
					if ($result) {
						$last_insert_id = $oDB->db_last_inserted_id(); 
						if ($last_insert_id>0) {
							$id_main_item_for_atribute = $last_insert_id;
						}
					}
					/* .............. */
					if ($this->user_can_update_archive) {
							if ($fields_no_multiple_options!=0) {
								$multiple_query = '';
								for ($i = 0; $i < $fields_no_multiple_options; $i++) {
									$table_name_multiple = el_TableNameWithPrefix($arr_multiple_options[$i][1]);
									$multiple_query .= "DELETE FROM ".$table_name_multiple." WHERE id_archive=".$arr_multiple_options[$i][2]." AND id_main_item=$id_main_item_for_atribute;";
									$arr_post_value = explode(",", $arr_multiple_options[$i][0]);
									$arr_post_value = array_unique($arr_post_value, SORT_REGULAR); /* elimina inregistrari duplicat */
									foreach ($arr_post_value as $key => $value) {
										if ($value!=0) {
											$multiple_query .= "INSERT INTO ".$table_name_multiple." (id_archive, id_main_item, id_options) VALUES ('".$arr_multiple_options[$i][2]."', '$id_main_item_for_atribute', '$value');";
										}
									}
								}
								if (!empty($multiple_query)) {						
										//echo $multiple_query;
										$result = $oDB->db_multiquery($multiple_query);
										$oDB->db_next_result();
								}
							}					
							/* .............. */
							if ($id!=0) { 
								// it's update	
								$ERROR_MSG = $this->ExecuteAfterUpdate($id);								
								if (!empty($ERROR_MSG)) { $ERROR = true; } else { $ERROR_MSG = 'ok'; $ERROR = false;}
							} else {
								//it's insert
								$ERROR_MSG = $this->ExecuteAfterInsert();
								if (!empty($ERROR_MSG)) { $ERROR = true; } else { $ERROR_MSG = 'ok'; $ERROR = false;}	
							}	
					}							
					/* .............. */
					
				}
			}
		}		
		
		return $ERROR_MSG;
	}
	/* ------------------------------------------------------------------------------------- */
	public function DeleteFiles( $arr_delete_file = array() ) {
		foreach($arr_delete_file as $key => $value) {
			unlink($arr_delete_file[$key]['file_to_delete']);
		}
	}
	/* ------------------------------------------------------------------------------------- */
	public function UploadFiles( $arr_upload_info = array() ) {
		
		$ERROR             = false;
		$ERROR_MSG         = '';
		$arr_uploaded_file = array();
		
		foreach($arr_upload_info as $key => $value) {
			if (!move_uploaded_file($arr_upload_info[$key]['tmp_name'],$arr_upload_info[$key]['upload_path'])) {
				$ERROR = true; $ERROR_MSG = 'Eroare upload fisier: '.$arr_upload_info[$key]['name'].' !';
				break;				
			} else {
				/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
				if ($arr_upload_info[$key]['is_image']) {
					$UploadedFile = $arr_upload_info[$key]['upload_path'];
					$info = getimagesize($UploadedFile);
					if ($info!=false) {
						$mimeType = $info['mime'];
						if(! preg_match('/^image\/(?:gif|jpg|jpeg|png)$/i', $mimeType)){
							$ERROR = true; $ERROR_MSG = "Continut invalid fisier: ".$UploadedFile." !";
							unlink($UploadedFile);
						} else {
							$QUALITY = $arr_upload_info[$key]['upload_quality'];
							switch ($mimeType) {
									case 'image/jpeg':
											$img = imagecreatefromjpeg($UploadedFile);
											imagejpeg($img,$UploadedFile,$QUALITY);
											$pathfile_info = pathinfo($UploadedFile);
											$file_url      = __UPLOADURL__.$pathfile_info['basename'];
											array_push($arr_uploaded_file,$file_url);
											break;

									case 'image/png':
											$img = imagecreatefrompng($image);
											imagepng($img,$UploadedFile,$QUALITY);
											$pathfile_info = pathinfo($UploadedFile);
											$file_url      = __UPLOADURL__.$pathfile_info['basename'];
											array_push($arr_uploaded_file,$file_url);										
											break;

									case 'image/gif':
											$img = imagecreatefromgif($UploadedFile);
											unlink($UploadedFile);
											$UploadedFile = preg_replace('"\.gif$"', '.jpg', $UploadedFile);
											imagejpeg($img,$UploadedFile,$QUALITY);
											$pathfile_info = pathinfo($UploadedFile);
											$file_url      = __UPLOADURL__.$pathfile_info['basename'];
											array_push($arr_uploaded_file,$file_url);										
											break;			
									default: 
											$ERROR = true; $ERROR_MSG = 'Eroare tip fisier !';
											break;
							}
							if (!$ERROR) {
								if (!empty($arr_upload_info[$key]['old_image_path'])) {
									if (file_exists($arr_upload_info[$key]['old_image_path'])) {
										unlink($arr_upload_info[$key]['old_image_path']);
									}
								}
							}							
						}
					} else {
						$ERROR = true; $ERROR_MSG = 'Eroare tip/continut fisier '.$arr_upload_info[$key]['name'].' !!!';
						unlink($UploadedFile);
					}
				}					
				/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
			}
		}
		return $ERROR_MSG;		
	}
	/* ------------------------------------------------------------------------------------- */
	public function ReturnSetFieldsString($field, $id=0){
		
		$ERROR          = false;
		$ERROR_MSG      = 'ok';		
		$STR_SET_FIELDS = '';
		
		$multiple_options_values                 = '';
		$multiple_options_store_table            = '';
		$multiple_options_store_table_id_archive = '';
		
		switch ($field['type']) {
			/* .................. */
			case FIELD_TYPE_TEXT :
			case FIELD_TYPE_HIDDEN :
			case FIELD_TYPE_COLOR_PICKER :
			case FIELD_TYPE_PASSWORD :
			case FIELD_TYPE_TEXTAREA :
			case FIELD_TYPE_EDITOR_CKEDITOR :
			case FIELD_TYPE_DATE :
			case FIELD_TYPE_DATETIME :
			case FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM :
			case FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS: 
			case FIELD_TYPE_COMBO_BOOTSTRAP_TABLE :
			case FIELD_TYPE_COMBO_WITH_SEARCH :	
			case FIELD_TYPE_SELECT_FILE :
			case FIELD_TYPE_TAGS_INPUT :
			case FIELD_TYPE_MENU :
			case FIELD_TYPE_ITINERARY :
			case FIELD_TYPE_CABINS_PRICE :
				 if ( (!isset($field['control_name'])) || empty($field['control_name']) || (!isset($field['db_field'])) || (empty($field['db_field']))  ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update in arhiva '.get_class($this).', tip camp '.el_ConstantName($field['type']).' (1) !!!');
				 }
				 
				 if (!$ERROR) {
					 $field_name=$field['control_name']; $db_field=$field['db_field'];
					 if (!isset($_POST["$field_name"])) {
						 $ERROR = true;  $ERROR_MSG = _('Eroare update in arhiva '.get_class($this).', tip camp '.el_ConstantName($field['type']).', (2) !!!');
					 }
				 }				 
				 if (!$ERROR) {
					 $POST_VALUE = addslashes( stripslashes( $_POST["$field_name"] ) );
					 if ( $field['type'] == FIELD_TYPE_DATE )     { $POST_VALUE = el_RomanianDate_To_MysqlDate( $POST_VALUE ); }
					 if ( $field['type'] == FIELD_TYPE_DATETIME ) { $POST_VALUE = el_RomanianDateTime_To_MysqlDateTime( $POST_VALUE ); }
					 if (isset($field['read_only']) && ($field['read_only']==true) && isset($field['skip_update']) && ($field['skip_update']==true)) {
						 $STR_SET_FIELDS = "";
					 } else {
						$STR_SET_FIELDS = " $db_field='$POST_VALUE' ";
					 }
					 if (isset($field['read_only_on_edit']) && ($field['read_only_on_edit']==true) && ($id!=0) ) {
						 $STR_SET_FIELDS = "";
					 } else {
						$STR_SET_FIELDS = " $db_field='$POST_VALUE' ";
					 }
					 
				 }
				 
				 if (!$ERROR) {
					 if ($field['type'] == FIELD_TYPE_PASSWORD) {
						 /* --- */
							 $encript_md5 = true;
							 if (isset($field['md5_encript'])) {
								 if ($field['md5_encript']==true) {
									 $encript_md5 = true;
								 } else {
									 $encript_md5 = false;
								 }
							 }						 
						 /* --- */
						 if ($id==0) {							 
							 $POST_VALUE = ($encript_md5 ? md5($POST_VALUE) : el_encript_info($POST_VALUE));
							 $STR_SET_FIELDS = " $db_field='$POST_VALUE' ";
						 } else {
							 if (!empty($_POST["$field_name"])) {
								 //$POST_VALUE = md5($POST_VALUE);
								 $POST_VALUE = ($encript_md5 ? md5($POST_VALUE) : el_encript_info($POST_VALUE));
								 $STR_SET_FIELDS = " $db_field='$POST_VALUE' ";
							 } else {
								 $STR_SET_FIELDS = "";
							 }
						 }
					 }
				 }
				 
				break;
			/* .................. */
			case FIELD_TYPE_DATE_RANGE :
				 if ( (!isset($field['control_name_1'])) || empty($field['control_name_1']) || (!isset($field['db_field_1'])) || (empty($field['db_field_1']))  ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update DATARANGE in arhiva '.get_class($this).', sectiune: '.$field['title'].', (1) !!!');
				 }
				 if ( (!isset($field['control_name_2'])) || empty($field['control_name_2']) || (!isset($field['db_field_2'])) || (empty($field['db_field_2']))  ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update DATARANGE in arhiva '.get_class($this).', sectiune: '.$field['title'].', (2) !!!');
				 }
				 if (!$ERROR) {
					 $field_name = $field['control_name_1']; $db_field = $field['db_field_1'];
					 if (!isset($_POST["$field_name"])) {
						 $ERROR = true;  $ERROR_MSG = _('Eroare update DATARANGE in arhiva '.get_class($this).', sectiune: '.$field['title'].', data 1 !!!');
					 } else {
						 $POST_VALUE = el_RomanianDate_To_MysqlDate(addslashes( stripslashes( $_POST["$field_name"] )));
						 $STR_SET_FIELDS = " $db_field='$POST_VALUE' ";
						 
					 }
				 }
				 if (!$ERROR) {
					 $field_name = $field['control_name_2']; $db_field = $field['db_field_2'];
					 if (!isset($_POST["$field_name"])) {
						 $ERROR = true;  $ERROR_MSG = _('Eroare update DATARANGE in arhiva '.get_class($this).', sectiune: '.$field['title'].', data 2 !!!');
					 } else {
						 $POST_VALUE = el_RomanianDate_To_MysqlDate(addslashes( stripslashes( $_POST["$field_name"] )));
						 $STR_SET_FIELDS .= ", $db_field='$POST_VALUE' ";
						 
					 }
				 }
				break;
			/* .................. */
			case FIELD_TYPE_CHECKBOX :
				$contor = 0;
				foreach ($field['fields'] as $row) {
					if ( (!isset($row['control_name'])) || (empty($row['control_name'])) || (!isset($row['db_field'])) || (empty($row['db_field']))  ){
						$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_CHECKBOX in arhiva '.get_class($this).', sectiune: '.$field['title'].', (1) !!!');
					}
					if (!$ERROR) {										
						$field_name = $row['control_name']; $db_field = $row['db_field'];
						if(!isset($_POST["$field_name"])) {$POST_VALUE=0;} else { $POST_VALUE=1; }
						$STR_SET_FIELDS .= ($contor>0 ? ', ' :'')." $db_field='$POST_VALUE' ";
						$contor++;
					}
					if ($ERROR) {break;}
				}
				break;
			/* .................. */
			case FIELD_TYPE_COMBO_INTERACTIVE :
				 if ( (!isset($field['control_name'])) || empty($field['control_name']) || (!isset($field['db_field'])) || (empty($field['db_field']))  ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_COMBO_INTERACTIVE in arhiva '.get_class($this).' sectiune: '.$field['title'].' (1) !!!');
				 }
				 if (!$ERROR) {
					 $field_name = $field['control_name'].'_1'; $db_field=$field['db_field'];
					 if (!isset($_POST["$field_name"])) {
						 $ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_COMBO_INTERACTIVE in arhiva '.get_class($this).' sectiune: '.$field['title'].' (2) !!!');
					 }
				 }
				 if (!$ERROR) {
					 $POST_VALUE = addslashes( stripslashes( $_POST["$field_name"] ) );
					 $STR_SET_FIELDS = " $db_field='$POST_VALUE' ";
				 }
				break;
			/* .................. */
			case FIELD_TYPE_COMBO_SWITCH :
				 if ( (!isset($field['control_name'])) || empty($field['control_name']) || (!isset($field['db_field'])) || (empty($field['db_field']))  ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_COMBO_SWITCH "'.$field['title'].'" in arhiva '.get_class($this).' (1) !!!');
				 }
				 if (!$ERROR) {
					 $field_name=$field['control_name']; $db_field=$field['db_field'];
					 if (!isset($_POST["$field_name"])) {
						 $ERROR = true;  $ERROR_MSG = _('Eroare FIELD_TYPE_COMBO_SWITCH update in arhiva '.get_class($this).', tip camp '.$field['type'].', (2) !!!');
					 }
				 }
				 if (!$ERROR) {
					$POST_VALUE = $_POST["$field_name"];
					$STR_SET_FIELDS = " $db_field='$POST_VALUE' ";

					if (isset($field['attributes'])) {
						if (is_array($field['attributes'])) {
							foreach ($field['attributes'] as $row) {
								if ($row['value']==$POST_VALUE) {
									$arr_fields = $row['fields'];
									foreach ($arr_fields as $field) {
										$arr_json = json_decode($this->ReturnSetFieldsString($field, $id), true);
										if ($arr_json['error']==true) {
											$ERROR = true;  $ERROR_MSG = _($arr_json['msg']);
										} else {
											if (!empty($arr_json['msg'])) {
												$STR_SET_FIELDS .= ((!empty($STR_SET_FIELDS)) ? ', ' :'').$arr_json['msg'];
											}
										}										
									}
									break;
								}
								if ($ERROR) {break;}
							}
						}
					}					 
				 }
				break;
			/* .................. */
			case FIELD_TYPE_COMBO_MULTISELECT :
				 if ( (!isset($field['control_name'])) || empty($field['control_name']) ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_COMBO_MULTISELECT "'.$field['title'].'" in arhiva '.get_class($this).' (1) !!!');
				 }
				 if (!$ERROR) {
					 if ( (!isset($field['store_table'])) || empty($field['store_table']) ){
						$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_COMBO_MULTISELECT "'.$field['title'].'" in arhiva '.get_class($this).' (store_table) !!!');
					 }
				 }
				 if (!$ERROR) {
					 if ( (!isset($field['store_table_id_archive'])) || empty($field['store_table_id_archive']) ){
						$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_COMBO_MULTISELECT "'.$field['title'].'" in arhiva '.get_class($this).' (store_table_id_archive) !!!');
					 }					
				 }
				 if (!$ERROR) {
					$field_name = $field['control_name'];
					$multiple_options_values                 = (!empty($_POST["$field_name"]) ? implode(",", $_POST["$field_name"]) : '' ); 
					$multiple_options_store_table            = $field['store_table'];
					$multiple_options_store_table_id_archive = $field['store_table_id_archive']; 
				 }
				break;
			/* .................. */
			case FIELD_TYPE_SELECT_IMAGE :	
				 $STR_SET_FIELDS = '';
				 if ( (!isset($field['control_name'])) || empty($field['control_name']) || (!isset($field['db_field'])) || (empty($field['db_field']))  ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update in arhiva '.get_class($this).', tip camp FIELD_TYPE_SELECT_IMAGE (1) !!!');
				 }
				 if (!$ERROR) {
					 $field_name = $field['control_name'];
					 if (isset($_FILES["$field_name"]['name'][0])) {
						 if (!$ERROR) {
							 $field_name = $field['control_name']; $db_field=$field['db_field'];
							 $POST_VALUE = $_FILES["$field_name"]['name'][0];
							 if (!isset($POST_VALUE)) {
								 $ERROR = true;  $ERROR_MSG = _('Eroare update in arhiva '.get_class($this).', tip camp FIELD_TYPE_SELECT_IMAGE, (2) !!!');
							 }
						 }
						 if (!$ERROR) {										
							$arr_tmp_file   = explode('/', $_FILES["$field_name"]['tmp_name'][0]);
							$fileName       = array_pop($arr_tmp_file).'.'.strtolower(pathinfo($POST_VALUE, PATHINFO_EXTENSION));
							$FILE_URL       = __UPLOADURL__ . $fileName;
							$STR_SET_FIELDS = " $db_field='$FILE_URL' ";
						 }
					 } else {
						 /* ___ */
							$STATE_CONTROL_NAME  = $field['control_name'].'_'.'3gURNv'.'_1';
							if (isset($_POST["$STATE_CONTROL_NAME"])) {
								if ($_POST["$STATE_CONTROL_NAME"]==0) {
									// user remove photo
									$db_field=$field['db_field'];
									$STR_SET_FIELDS = " $db_field='' ";
								}
							}
						 /* ___ */
					 }
				 }
				break;			
			/* .................. */
			case FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE :
				 if ( (!isset($field['control_name'])) || empty($field['control_name']) ){
					$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE "'.$field['title'].'" in arhiva '.get_class($this).' (1) !!!');
				 }
				 if (!$ERROR) {
					 if ( (!isset($field['store_table'])) || empty($field['store_table']) ){
						$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE "'.$field['title'].'" in arhiva '.get_class($this).' (store_table) !!!');
					 }
				 }
				 if (!$ERROR) {
					 if ( (!isset($field['store_table_id_archive'])) || empty($field['store_table_id_archive']) ){
						$ERROR = true;  $ERROR_MSG = _('Eroare update FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE "'.$field['title'].'" in arhiva '.get_class($this).' (store_table_id_archive) !!!');
					 }					
				 }
				 if (!$ERROR) {
					$field_name 							 = $field['control_name'];
					$multiple_options_values                 = (!empty($_POST["$field_name"]) ? implode(",", $_POST["$field_name"]) : '' ); 
					$multiple_options_store_table            = $field['store_table'];
					$multiple_options_store_table_id_archive = $field['store_table_id_archive']; 
				 }
				break;
			/* .................. */
			
			default:
				break;
			/* .................. */
		} /* end switch */		
		
		if (isset($field['skip_update']) && ($field['skip_update'])) {
			$STR_SET_FIELDS = '';
		}
		
		$arr_json = array();
		$arr_json['error'] = $ERROR;		
		
		if (!$ERROR) {
			$arr_json['msg']                                     = $STR_SET_FIELDS;
			$arr_json['multiple_options_values']                 = $multiple_options_values;
			$arr_json['multiple_options_store_table']            = $multiple_options_store_table;
			$arr_json['multiple_options_store_table_id_archive'] = $multiple_options_store_table_id_archive;
			
		} else {
			$arr_json['msg'] = $ERROR_MSG;
		}
		
		return json_encode($arr_json);
	}
	/* ------------------------------------------------------------------------------------- */		
	/* Set grid javascripts for tabs which contain archive list */
	public function ReturnTabScriptsForGrid() {
		$javascript_snippets = '';
		$tabs_no = count($this->tabs);
		$j=0;
		for ($i = 0; $i < $tabs_no; $i++) {
			$tab_class_name  = $this->tabs[$i][1];
			if (class_exists("$tab_class_name")) {
				//$eval_str = "\$objTab = new $tab_class_name(\$this);"; 
				eval("\$objTab = new $tab_class_name(\$this);");
				
				$DISPLAY_TAB = $this->CanDisplayTab($objTab);
				if ($DISPLAY_TAB) {
							if (property_exists("$tab_class_name", 'archive_name')) {
								if (!empty($objTab->archive_name)) {						
									$archive_class_name = $objTab->archive_name;
									if (class_exists("$archive_class_name")) {
										/* ................................................................ */
											//$eval_str = "\$objArchive = new $archive_class_name(NULL);"; 
											eval("\$objArchive = new $archive_class_name(NULL);");							
											$option_fields = '';
											$contor_fields = 0;
											foreach ($objArchive->list_fields as $column) {
												$contor_fields++;
												if (isset($column['sortable'])) {
													if ($column['sortable']==false) {
														$option_fields .='{orderable: false, targets: '.$contor_fields.' },'.PHP_EOL;
													}
												}
											}
											//unset($objArchive);
											
											//$grid     = 'grid'.$i;
											//$grid_src = $archive_class_name.$i;
											$grid     = 'grid'.$j;
											$grid_src = $archive_class_name.$j;
											$archive_name = str_replace("archive_","",$archive_class_name);
											
											$javascript_snippets .= '
											<script type="text/javascript">
											var '.$grid.';
											var TableDatatablesAjax2'.$grid.' = function () {

												var initPickers = function () {
													$(\'.date-picker\').datepicker({
														rtl: App.isRTL(),
														autoclose: true
													});
												}

												var handleRecords = function () {

													'.$grid.' = new Datatable();
														<!-- ****************************** -->
														arr_index'.$j.' = new Array();
														arr_class'.$j.' = new Array();
														var no_of_responsive_columns'.$j.' =0;
														$(\'#'.$grid_src.' thead tr.heading th[class]\').each(function () {
															arr_index'.$j.'.push($(this).index());
															arr_class'.$j.'.push(this.className);
															no_of_responsive_columns'.$j.'++;
														});
														<!-- ****************************** -->
													'.$grid.'.init({
														src: $("#'.$grid_src.'"),
														onSuccess: function ('.$grid.', response) {
														},
														onError: function ('.$grid.') {
														},
														onDataLoad: function('.$grid.') {
														},
														loadingMessage: \'Incarcare...\',
														dataTable: { 							
															"bStateSave": true, 
															"lengthMenu": [
																[10, 20, 50, 100, 150, -1],
																[10, 20, 50, 100, 150, "All"] 
															],
															"pageLength": 10, 
															"ajax": {
																"url": "action/ajax-archive-list.php?archtype='.$archive_name.'&idma='.$this->item_id_encripted.'&grid_id='.$j.'", // ajax source
															},
															"order": [
																['.$objArchive->list_fields_order_by_fiels_no.', "'.$objArchive->list_fields_order_by_direction.'"]
															],
															<!-- ********************** -->
															"columnDefs": [
																{orderable: false, targets: -1 }, 
																{orderable: false, targets: 0 },
																'.$option_fields.'
															],
															<!-- ********************** -->
															"createdRow": function( row, data, dataIndex ) {
															   
																for (i = 0; i < no_of_responsive_columns'.$j.'; i++) {
																   $(\'td:eq(\'+arr_index'.$j.'[i]+\')\', row).addClass(arr_class'.$j.'[i]);
																}
																
															}							
															<!-- ********************** -->
															
														}
													});
													'.$grid.'.getTableWrapper().on(\'click\', \'.table-group-action-submit\', function (e) {
														e.preventDefault();
														var action = $(".table-group-action-input", '.$grid.'.getTableWrapper());
														if (action.val() != "" && '.$grid.'.getSelectedRowsCount() > 0) {						
																icon = \'<i class="icon-question fs18"></i> \';
																msg  = \'Confirmati stergerea inregistrarilor selectate ?\';
																bootbox.confirm({
																	title: cst_var_app_name,
																	message: icon+\'\'+msg+\'\',
																	buttons: {
																		\'cancel\': {
																			label: \'Nu\',
																			className: \'btn-primary plr30\'
																		},
																		\'confirm\': {
																			label: \'Da\',
																			className: \'btn-default plr30\'
																		}
																	},
																	callback: function(result) {
																		if (result) {
																			'.$grid.'.setAjaxParam("customActionType", "group_action");
																			'.$grid.'.setAjaxParam("customActionName", action.val());
																			'.$grid.'.setAjaxParam("id", '.$grid.'.getSelectedRows());											
																			'.$grid.'.getDataTable().ajax.reload();
																			'.$grid.'.clearAjaxParams();
																		} 
																	}
																});
														} else if (action.val() == "") {
															App.alert({
																type: \'danger\',
																icon: \'warning\',
																message: \'Selectati o actiune globala !\',
																container: '.$grid.'.getTableWrapper(),
																place: \'prepend\'
															});
														} else if ('.$grid.'.getSelectedRowsCount() === 0) {
															App.alert({
																type: \'danger\',
																icon: \'warning\',
																message: \'Nu ati selectat nici o inregistrare\',
																container: '.$grid.'.getTableWrapper(),
																place: \'prepend\'
															});
														} 
														
													});
												}

												return {
													init: function () {
														initPickers();
														handleRecords();
													}
												};

											}();

											jQuery(document).ready(function() {
												TableDatatablesAjax2'.$grid.'.init();
											});		
										 
											</script>'.PHP_EOL;																	
										/* ................................................................ */
										unset($objArchive);
									}						
								}
							}
							unset($objTab);
							$j++;
				}
			} 
		}		
		return $javascript_snippets;
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function AdminAllowToAddItem() {
		$GRANTED_ACCES = true;
		if ($this->user_rights_by_admin["administrator"]==0) {
			if (!isset($this->user_rights_by_admin["$this->archtype"])) {
				$GRANTED_ACCES = false;
			} else {
				if ($this->user_rights_by_admin["$this->archtype"]==0) {
					$GRANTED_ACCES = false;
				} else {
					if (isset($this->user_rights_by_admin["permission_add_item"]) && ($this->user_rights_by_admin["permission_add_item"]==0)) {
						$GRANTED_ACCES = false;
					}
				}					
			}
		}
		return $GRANTED_ACCES;		
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function AdminAllowToEditItem() {
		$GRANTED_ACCES = true;
		if ($this->user_rights_by_admin["administrator"]==0) {
			if (!isset($this->user_rights_by_admin["$this->archtype"])) {
				$GRANTED_ACCES = false;
			} else {
				if ($this->user_rights_by_admin["$this->archtype"]==0) {
					$GRANTED_ACCES = false;
				} else {
					if (isset($this->user_rights_by_admin["permission_edit_item"]) && ($this->user_rights_by_admin["permission_edit_item"]==0)) {
						$GRANTED_ACCES = false;
					}
				}					
			}
		}
		return $GRANTED_ACCES;
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function AdminAllowToDeleteItem() {
		$GRANTED_ACCES = true;
		if ($this->user_rights_by_admin["administrator"]==0) {
			if (!isset($this->user_rights_by_admin["$this->archtype"])) {
				$GRANTED_ACCES = false;
			} else {
				if ($this->user_rights_by_admin["$this->archtype"]==0) {
					$GRANTED_ACCES = false;
				} else {
					if (isset($this->user_rights_by_admin["permission_delete_item"]) && ($this->user_rights_by_admin["permission_delete_item"]==0)) {
						$GRANTED_ACCES = false;
					}
				}					
			}
		}
		return $GRANTED_ACCES;		
	}				
	/* ------------------------------------------------------------------------------------- */	
	/* diaply info in footer of the list */
	public function ShowLegend() {
	}		
	/* ------------------------------------------------------------------------------------- */	
	/* Display info panel of item archive */
	public function ShowInfo() {
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* Return link to item info */
	public function LinkToInfo() {
		
	}			
	/* ------------------------------------------------------------------------------------- */	
	/* Return link to edit item */
	public function LinkToAddItem() {
		if ($this->AdminAllowToAddItem()) {
			$redirect = (!empty($this->url_referer) ? $this->url_referer : $this->LinkToList($this->archtype));
			return __ADMINURL__."?pn=3&archtype=".$this->archtype."&id=".el_encript_info('0')."&redirect=".urlencode( el_remove_url_param($redirect,'redirect') );
		} else {
			return 'javascript:cst_notify(\'Nu ai drepturi pentru aceasta operatiune !\',\'Atentie\',2);';
		}
	}				
	/* ------------------------------------------------------------------------------------- */
	public function LinkToAddItemInTab($archive_name, $tab_no) {
			
			$archtype                 = str_replace("archive_","",$archive_name);
			$arr_user_rights_by_admin = $this->GetArchiveUserRightsByAdmin($archtype);
			
			$GRANTED_ACCES = true;
			if ($arr_user_rights_by_admin["administrator"]==0) {
				if (!isset($arr_user_rights_by_admin["$archtype"])) {
					$GRANTED_ACCES = false;
				} else {
					if ($arr_user_rights_by_admin["$archtype"]==0) {
						$GRANTED_ACCES = false;
					} else {
						if (isset($arr_user_rights_by_admin["permission_add_item"]) && ($arr_user_rights_by_admin["permission_add_item"]==0)) {
							$GRANTED_ACCES = false;
						}
					}					
				}
			}			
			if ($GRANTED_ACCES) {
				$old_redirect = ""; 
				$arr_url_param = el_UrlStringWithParametersToArray($_SERVER["REQUEST_URI"]);
				$idma = '0';
				if ($arr_url_param != false) {
					if (isset($arr_url_param['redirect'])) { $old_redirect = urldecode($arr_url_param['redirect']);}
					if (isset($arr_url_param['id']))       { $idma         = $arr_url_param['id'];}
				}
				
								
				$redirect     = el_remove_url_param($_SERVER["REQUEST_URI"],'redirect');
				$redirect     = el_remove_url_param(urldecode($redirect),'tab');
				
				$redirect = $redirect."&tab=".($tab_no+1).(!empty($old_redirect) ? "&redirect=".urlencode($old_redirect) : '');
				
				return __ADMINURL__."?pn=3&archtype=".str_replace("archive_","",$archive_name)."&id=".el_encript_info('0')."&idma=".$idma."&redirect=".urlencode( $redirect );		
			} else {
				return 'javascript:cst_notify(\'Nu ai drepturi pentru aceasta operatiune !\',\'Atentie\',2);';
			}
	}					
	/* ------------------------------------------------------------------------------------- */	
	/* Return link to edit item */
	public function LinkToEditItem($id_item_to_edit, $archtype, $idma='') {
		
		$redirect = (!empty($this->url_referer) ? $this->url_referer : $this->LinkToList($archtype));
		return __ADMINURL__."?pn=3&archtype=".$archtype."&id=".el_encript_info($id_item_to_edit).(!empty($idma) ? '&idma='.$idma : '')."&redirect=".urlencode( el_remove_url_param($redirect,'redirect') );
	}			
	/* ------------------------------------------------------------------------------------- */	
	/* Return link to archive list */
	public function LinkToList($archtype) {
		return __ADMINURL__."?pn=2&archtype=".$archtype;
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function LinkExportToMSExcel() {
		if ((isset($this->permission_export_archive)) && ($this->permission_export_archive==0)) {
			return "javascript:cst_notify('Nu aveti dreptul de a exporta inregistrari in format Excel!', 'Atentie!', 2)";
		} else {
			if (isset($this->archtype) && (!empty($this->archtype))) {
				$param_archtype = $this->archtype;
			} else {
				$param_archtype = preg_replace('/archive_/', '', get_class($this), 1);
			}
			$idma = '';
			$arr_url_param = el_UrlStringWithParametersToArray(el_curent_url());
			if ($arr_url_param != false) {
				if (isset($arr_url_param['id'])) {
					$idma=$arr_url_param['id'];				
				}
			}
			return __UTILSAPP__."gendoc/export_to_excel.php?archtype=".$param_archtype.(!empty($idma) ? '&idma='.$idma : '');
		}
	}				
	/* ------------------------------------------------------------------------------------- */	
	public function LinkExportToCSV() {
		if ((isset($this->permission_export_archive)) && ($this->permission_export_archive==0)) {
			return "javascript:cst_notify('Nu aveti dreptul de a exporta inregistrari in format CSV!', 'Atentie!', 2)";
		} else {	
			return __UTILSAPP__."gendoc/export_to_csv.php?archtype=".$this->archtype."";
		}
	}					
	/* ------------------------------------------------------------------------------------- */	

}
