<?php

class archive_menu extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'menus';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare inregistrare meniu';
	public  $archive_icon_class     			= 'fa fa-navicon';

	public  $list_archive_title			    	= 'Lista inregistrari meniu';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-navicon';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga inregistrare';
	public  $list_edit_item_button_name         = 'Editeaza';
	
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil"></i> Editeaza inregistrare','tab_menu_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Meniu Principal website';
	public  $archive_title_top_small        	= '';
	public  $del_item_message                   = 'Confirmati stergerea inregistrarii <strong>%</strong> ?';
	public  $activate_menuitem_id           	= 12;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Nume inregistrare','name'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
	public $list_fields = array(
                  array (
                  'title'                              => 'Index',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'display_index',
				  'width'                              => '2%',
				  'sortable'                           => true,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => '',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  				  
                   ),	
                  array (
                  'title'                              => 'Inregistrare',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																				  
				  'width'                              => '',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  
				  'function'                           => 'lf_return_visible',  /* Method must have parameter "$result_line" */
                   ),
				   array (
                  'title'                              => 'Adaugat la Data',
				  'type'                               => FIELD_DATETIME,
				  'db_field'                           => 'date_add',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-sm-4 col-md-4 col-lg-2 hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  
                   ),				   
				   
				   
	);
	public  $list_fields_order_by_fiels_no		= 1; 								/* Order list by column no X. Value from 1 ... */
	public  $list_fields_order_by_direction		= 'ASC';  							/* ASC or DESC */
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		//$this->query_order_by  = "$this->real_table_name.date_add DESC";
		//$this->query_order_by  = "$this->real_table_name.name ASC";
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ExecuteAfterUpdate($id){
		$ERROR_MSG = '';
		$ERROR     = false;
		
		$MenuMainString = ''; $MenuMobileString = '';
		global $oDB;
		
		$query = "SELECT * FROM el_menus WHERE id_archive = 0 ORDER BY display_index ASC, date_add DESC";
		$result = $oDB->db_query($query);		
		if ($oDB->db_num_rows($result)==0) {
			$ERROR = true; $ERROR_MSG = _('Nu exista inregistrari in meniu !');
		} else {
			  
			  while ($result_line = $oDB->db_fetch_array($result)) {
				  $MenuMainString   .= '<li><a '.(($result_line['target']!=0) ? 'target="_blank"' : '').' href="'.$result_line['link'].'">'.$result_line['name'].'</a>'.PHP_EOL;
					switch ($result_line['type']) {
						case 1:
							/* ----------------------- */
							$MenuMainString   .= '<ul class="dropdown">'.PHP_EOL;
								$arrmenu = return_array_from_nestedmenu_string($result_line['submenu_col_1']);
								//print_r($arrmenu);die('');
								foreach ($arrmenu as $key => $value) {
									$child_string = ''; $has_child = false;
									if (isset($value['children'])) {
										$arr_child = $value['children'];
										if (count($arr_child)>0) {
											$has_child = true;
											$child_string = '<ul class="dropdown">'.PHP_EOL;
										}
										foreach ($arr_child as $key_child => $value_child) {
											$child_string .= '<li><a href="'.$value_child['http'].'">'.$value_child['title'].'</a></li>';
										}
										if (!empty($child_string)) {
											$child_string .= '</ul>'.PHP_EOL;
										}
									}
									//$tmp_str           = '<li '.($has_child ? 'class="dropdown"' : '').'><a href="'.$value['http'].'">'.$value['title'].($has_child ? '<i class="fa flm fa-angle-right"></i>' : '').'</a>'.$child_string.'</li>'.PHP_EOL;
									$tmp_str           = '<li><a href="'.$value['http'].'">'.$value['title'].'</a>'.$child_string.'</li>'.PHP_EOL;
									$MenuMainString   .= $tmp_str;
								}								
							$MenuMainString   .= '</ul>'.PHP_EOL;
							break;
							/* ----------------------- */
						case 2:break;
						case 3:break;
					}					
				  $MenuMainString   .= '</li>'.PHP_EOL;
				  $MenuMobileString .= '</li>'.PHP_EOL;
			  }
		}
		if (!$ERROR) {
			$myFile = __APPFILESPATH__."generate/menu_main.php";
			$fh = fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, $MenuMainString);    
			fclose($fh); 
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
		$ERROR_MSG = $this->ExecuteAfterUpdate($id);
		return $ERROR_MSG;	
	}		
	/* ------------------------------------------------------------------------------------- */		
	public function ExecuteAfterInsert(){
		$ERROR_MSG = $this->ExecuteAfterUpdate(0);
		return $ERROR_MSG;
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_visible($result_line){		
		return '<span '.($result_line['visible'] ? '' : 'class="font-grey-salt font-line-through"').'>'.$result_line['name'].'</span>';
	}	
	/* ------------------------------------------------------------------------------------- */	

}