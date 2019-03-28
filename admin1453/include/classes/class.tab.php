<?php
/* generic class */
class tab {
	/* ------------------------------------------------------------------------------------- */	
	public  $parent;
	public  $fields			          		= array();
	public  $show_line_between_fields 		= false;					/* show horizontal line after each fields in edit panel */
	public  $label_size               		= 3;						/* label size for fields. Between 2-10 */
	public  $ERROR_MSG				  		= '';						/* will contain error message if not valid fields */	
	public  $edit_tab                 		= true;						/* will be true for tab with editable fields, for tab with list content will be false */	
	public  $boxed                    		= true;						/* if "true" the tab content will be bordered. Only if show_sidebar = true */	
	
	public  $show_sidebar                  	= false;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width                 	= 3;						/* no between 2 and 10 */
	public  $sidebar_title                 	= 'Informatii generale';	/* title in sidebar */
	
	public  $show_on_add                 	= true;						/* tab will show on add operation */
	public  $show_on_edit                 	= true;						/* tab will show on edit operation */
	
	public $count_generate_permalink_attr   = 0;						/* pls no set this fields. leave 0*/
		
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {
		$this->parent = $oParent;
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function init($oParent=NULL) {
		$this->parent = $oParent;
	}
	/* ------------------------------------------------------------------------------------- */	
    public function createProperty($name, $value){
        $this->{$name} = $value;
    }		
	/* ------------------------------------------------------------------------------------- */
	public function ReturnTabContent($arr_fields, $result_line='', $result_multiselect='', $tab_no=0) {
		if (isset($_REQUEST['idma'])) { $arr_fields = $this->RemoveControlFromTabFields($arr_fields);}
		if (empty($result_line))      { $arr_fields = $this->RemoveControlWithAtribute($arr_fields, 'hide_on_add', true);}
		
		$tab_content = '';
	    foreach ($arr_fields as $field) {	        
			if (isset($field['show_in_sidebar']) && $field['show_in_sidebar']==true) {
			} else {
				/* ..... */
				switch ($field['type']) {
					case FIELD_TYPE_TITLE:
																		$tab_content .= $this->field_title($field); 
																		break;
					case FIELD_TYPE_CUSTOM_CONTENT:
																		$tab_content .= $this->field_custom_content($field); 
																		break;																		
					case FIELD_TYPE_INFO:
																		$tab_content .= $this->field_info($field); 
																		break;																		
					case FIELD_TYPE_LINE_SEPARATOR:
																		$tab_content .= $this->field_line_separator($field); 
																		break;
					case FIELD_TYPE_TEXT:
																		$tab_content .= $this->field_text($field, $result_line); 
																		break;
					case FIELD_TYPE_HIDDEN:
																		$tab_content .= $this->field_hidden($field, $result_line);
																		break;																		
					case FIELD_TYPE_COLOR_PICKER:
																		$tab_content .= $this->field_color_picker($field, $result_line); 
																		break;																		
					case FIELD_TYPE_PASSWORD:
																		$tab_content .= $this->field_password($field, $result_line); 
																		break;																		
					case FIELD_TYPE_TEXTAREA:
																		$tab_content .= $this->field_textarea($field, $result_line); 
																		break;
					case FIELD_TYPE_CHECKBOX:
																		$tab_content .= $this->field_checkbox($field, $result_line); 
																		break;
					case FIELD_TYPE_DATE:
																		$tab_content .= $this->field_date($field, $result_line); 
																		break;
					case FIELD_TYPE_DATE_RANGE:
																		$tab_content .= $this->field_date_range($field, $result_line); 
																		break;	                                                                
					case FIELD_TYPE_DATETIME:
																		$tab_content .= $this->field_datetime($field, $result_line); 
																		break;	                                                                
					case FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM:
																		$tab_content .= $this->field_combo_bootstrap_custom($field, $result_line); 
																		break;
					case FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS:
																		$tab_content .= $this->field_combo_custom_icons($field, $result_line); 
																		break;
					case FIELD_TYPE_COMBO_BOOTSTRAP_TABLE:
																		$tab_content .= $this->field_combo_bootstrap_table($field, $result_line); 
																		break;
					case FIELD_TYPE_COMBO_WITH_SEARCH:
																		$tab_content .= $this->field_combo_with_search($field, $result_line); 
																		break;
					case FIELD_TYPE_COMBO_MULTISELECT:
																		$tab_content .= $this->field_combo_multiselect($field, $result_line, $result_multiselect); 
																		break;
					case FIELD_TYPE_COMBO_SWITCH:
																		$tab_content .= $this->field_combo_switch($field, $result_line); 
																		break;
					case FIELD_TYPE_COMBO_INTERACTIVE:
																		$tab_content .= $this->field_combo_interactive($field, $result_line, ''); 
																		break;
					case FIELD_TYPE_EDITOR_CKEDITOR:
																		$tab_content .= $this->field_editor_ckeditor($field, $result_line); 
																		break;
					case FIELD_TYPE_SELECT_IMAGE:
																		$tab_content .= $this->field_select_image($field, $result_line); 
																		break;
					case FIELD_TYPE_SELECT_FILE:
																		$tab_content .= $this->field_select_file($field, $result_line); 
																		break;
					case FIELD_TYPE_TAGS_INPUT:
																		$tab_content .= $this->field_tags_input($field, $result_line); 
																		break;
					case FIELD_TYPE_MENU:
																		$tab_content .= $this->field_menu($field, $result_line);
																		break;
					case FIELD_TYPE_ITINERARY:
																		$tab_content .= $this->field_itinerary($field, $result_line);
																		break;
					case FIELD_TYPE_CABINS_PRICE:
																		$tab_content .= $this->field_cabins_price($field, $result_line);
																		break;
																		
					case FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE:
																		$tab_content .= $this->field_box_multiselect_grouped_table($field, $result_line, $result_multiselect);
																		break;
					case FIELD_TYPE_LOADING_BUTTON:
																		$tab_content .= $this->field_loading_button($field, $result_line);
																		break;
																		
				}
				/* ..... */
			}
	    }
	    return $tab_content;
	}		
	/* ------------------------------------------------------------------------------------- */	
	private function field_title($field) {
		$field_str = '';
		if (isset($field['title']) && (!empty($field['title']))) {
			$color_class = ( isset($field['color_class']) ? $field['color_class'] : '' );
			$icon        = ( isset($field['icon_class']) ? '<i class="'.$field['icon_class'].' '.$color_class.'"></i>' : '' );
			$bold        = ( (isset($field['bold']) && $field['bold']) ? 'bold' : '' );

			$field_str = '
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        '.$icon.'
                                        <span class="caption-subject font-green '.$bold.' uppercase">'._($field['title']).'</span>
                                    </div>
                                </div>
							</div>'.PHP_EOL;
		}
		return $field_str;
	}
	/* ------------------------------------------------------------------------------------- */	
	private function field_custom_content($field) {
		$field_str = '';
		if (isset($field['content']) && (!empty($field['content']))) {
			$field_str = '
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
										'.$field['content'].'
                                    </div>
                                </div>
							</div>'.PHP_EOL;
		}
		return $field_str;
	}	
	/* ------------------------------------------------------------------------------------- */	
	private function field_line_separator($field) {
		$field_str = '';
			$margin   = ( isset($field['margin']) ? 'margin: '.$field['margin'].'px 0 !important;' : '' );
			$border   = ( isset($field['thickness']) ? 'border-width:'.$field['thickness'].'px 0 0 !important;' : '' );

			$field_str = '<hr style="'.$margin.$border.'">'.PHP_EOL;
		return $field_str;
	}	
	/* ------------------------------------------------------------------------------------- */	
	private function field_info($field) {
		$box_class = 'note-warning';
		if (isset($field['message_type'])) {
			switch ($field['message_type']) {
				case MSG_SUCCESS: $box_class = 'note-success'; break;
				case MSG_INFO   : $box_class = 'note-info'; break;
				case MSG_DANGER : $box_class = 'note-danger'; break;
				case MSG_WARNING: $box_class = 'note-warning'; break;
			}
		}
		
		$INFO_CONTENT = '';
		if (isset($field['class_method_for_content']) && (!empty($field['class_method_for_content']))) {
			if (method_exists($this,$field['class_method_for_content'])) {
				$INFO_CONTENT = $this->{$field['class_method_for_content']}($field);
			} else {
				$current_class= get_class($this);
				throw new Exception('In clasa "'.$current_class.'" nu exista definita metoda mentionata in campul "class_method_for_content" la controlul de tip FIELD_TYPE_ITINERARY din tab-ul '.$current_class);
			}
		} else {
			$INFO_CONTENT = (isset($field['message']) ? $field['message'] : '');
			//throw new Exception('Specificati/Setati "class_method_for_content" in campul tip FIELD_TYPE_ITINERARY din tab-ul '.get_class($this));
		}
		
		
		$field_str = '
			<div class="note '.$box_class.'">
				'.(isset($field['title']) && (!empty($field['title'])) ? '<h4 class="block">'.$field['title'].'</h4>' : '').'
				<p>'.$INFO_CONTENT.'</p>
			</div>'.PHP_EOL;
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}			
		return $field_str;
	}		
	/* ------------------------------------------------------------------------------------- */	
	private function field_loading_button($field, $result_line){
		$field_str = '';

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}
		
		$STATIC_ICON_CLASS  = ($field['static_icon_class'] ? $field['static_icon_class'] : '');
		$DINAMIC_ICON_CLASS = ($field['dinamic_icon_class'] ? $field['dinamic_icon_class'] : '');
		$JS_FUNCTION        = ($field['javascript_function'] ? 'onclick="'.$field['javascript_function'].'"' : '');
		

		$field_str = '
	                                <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                            </label>
	                                    <div class="col-md-'.$COLUMN_SIZE.'">
                                                <button '.$JS_FUNCTION.' type="button" class="btn btn-default '.$CONTROL_WIDTH_CLASS.' el_class" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' '.($field['read_only'] ? 'disabled' : '').'>
													<span class="static_icon"><i class="'.$STATIC_ICON_CLASS.'"></i></span><span class="dinamic_icon" style="display:none;"><i class="'.$DINAMIC_ICON_CLASS.' fa-spin"></i></span> <span class="ladda-label">'.(isset($field['value']) ? $field['value'] : '').'</span>
                                                </button>										
	                                    </div>
	                                </div>'.PHP_EOL;

		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}			
	/* ------------------------------------------------------------------------------------- */
	private function field_text($field, $result_line) {
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_TEXT din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_TEXT din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] :$default_value );            
        $value         = htmlentities($value, ENT_QUOTES, "UTF-8");


        $arr_accepted_input_type = array('text','email','number','time');
        $INPUT_TYPE = 'text';
		if (isset($field['input_type'])) { 
			if (in_array($field['input_type'], $arr_accepted_input_type)) {
				$INPUT_TYPE = strtolower($field['input_type']);
			}
		}        
		$OTHER_ATTRIBUTES = '';
		if (isset($field['other_attribs'])) {
				$OTHER_ATTRIBUTES = $field['other_attribs'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$FORM_GROUP_ID = '';
		if (isset($field['form_group_id']) && (!empty($field['form_group_id']))) { 
			$FORM_GROUP_ID = _($field['form_group_id']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		
		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}


        $DISPLAY_TYPE  = 0; /* clasic input */
        if (isset($field['icon']) && (!empty($field['icon'][0]['class']))) { 
        	if (isset($field['icon'][0]['type'])) {
        		if ($field['icon'][0]['type']==0) { $DISPLAY_TYPE  = 1; /* input with icon */ }
        		if ($field['icon'][0]['type']==1) { $DISPLAY_TYPE  = 2; /* input with boxed icon */ }
        		$ICON_POSITION = 0;
        		if (isset($field['icon'][0]['position']) && el_between($field['icon'][0]['position'],0,1)) { 
        			$ICON_POSITION = $field['icon'][0]['position'];
        		}
        	}

        }
		$RIGHT_BUTTON = '';
		if (isset($field['button_right_show']) && $field['button_right_show']==true) {
			$RIGHT_BUTTON = '<span class="input-group-btn"><button id="'.$field['control_id'].'_but" class="btn blue" type="button">'.$field['button_right_title'].'</button></span>';
		}
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		switch ($DISPLAY_TYPE) {
			case 0: 
					if (!empty($RIGHT_BUTTON)) {
						$field_str = '
										<div class="form-group" '.(!empty($FORM_GROUP_ID) ? 'id="'.$FORM_GROUP_ID.'"' : '').'>
											<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
												'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
											</label>
											<div class="col-md-'.$COLUMN_SIZE.'">
												<div class="input-group">
													<input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
													'.$RIGHT_BUTTON.'
												</div>
											</div> 
										</div>'.PHP_EOL;         			
					} else {
						$field_str = '
										<div class="form-group" '.(!empty($FORM_GROUP_ID) ? 'id="'.$FORM_GROUP_ID.'"' : '').'>
											<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
												'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
											</label>
											<div class="col-md-'.$COLUMN_SIZE.'">
												<input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
											</div> 
										</div>'.PHP_EOL;         									
					}
		    		break;
			        /* ----------------------------------------- */
			case 1:         
					$field_str = '
                                    <div class="form-group" '.(!empty($FORM_GROUP_ID) ? 'id="'.$FORM_GROUP_ID.'"' : '').'>
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                            <div class="input-icon '.($ICON_POSITION!=0 ? 'right' : '').'">
                                                <i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i>
                                                <input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
                                            </div>
                                        </div>
                                    </div>'.PHP_EOL;         									
		    		break;
			        /* ----------------------------------------- */
			case 2: 
					$field_str = '
                                    <div class="form-group" '.(!empty($FORM_GROUP_ID) ? 'id="'.$FORM_GROUP_ID.'"' : '').'>
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                            <div class="input-group">
                                                '.($ICON_POSITION==0 ? '<span class="input-group-addon"><i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i></span>' : '').'
                                                <input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
                                                '.($ICON_POSITION!=0 ? '<span class="input-group-addon"><i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i></span>' : '').'
                                            </div>
                                        </div>
                                    </div>'.PHP_EOL;         						
		    		break;
			        /* ----------------------------------------- */			        
		}
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}
		
		return $field_str;
	}
	/* ------------------------------------------------------------------------------------- */
	// hidden
	private function field_hidden($field, $result_line) {
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_TEXT din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_TEXT din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] :$default_value );            
        $value         = htmlentities($value, ENT_QUOTES, "UTF-8");

		$OTHER_ATTRIBUTES = '';
		if (isset($field['other_attribs'])) {
				$OTHER_ATTRIBUTES = $field['other_attribs'];
		}
				
		$field_str = '<input type="hidden" '.$OTHER_ATTRIBUTES.' class="form-control el_class" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' value="'.$value.'">'.PHP_EOL;
		
		return $field_str;
	}
	
	/* ------------------------------------------------------------------------------------- */
	// color picker
	private function field_color_picker($field, $result_line) {
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COLOR_PICKER din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_COLOR_PICKER din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] :$default_value );
		if (isset($field['load_from_json']) && (!empty($field['load_from_json']))) { 
			$json_field_name    = $field['load_from_json'];
			$json = $result_line["$json_field_name"];
			$arr_value = json_decode($json, true);			
			$value = $arr_value["$field_name"];
		}
        $value         = htmlentities($value, ENT_QUOTES, "UTF-8");


        $arr_accepted_input_type = array('text','color');
        $INPUT_TYPE = 'text';
		if (isset($field['input_type'])) { 
			if (in_array($field['input_type'], $arr_accepted_input_type)) {
				$INPUT_TYPE = strtolower($field['input_type']);
			}
		}        
		$OTHER_ATTRIBUTES = '';
		if (isset($field['other_attribs'])) {
				$OTHER_ATTRIBUTES = $field['other_attribs'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}


        $DISPLAY_TYPE  = 0; /* clasic input */
        if (isset($field['icon']) && (!empty($field['icon'][0]['class']))) { 
        	if (isset($field['icon'][0]['type'])) {
        		if ($field['icon'][0]['type']==0) { $DISPLAY_TYPE  = 1; /* input with icon */ }
        		if ($field['icon'][0]['type']==1) { $DISPLAY_TYPE  = 2; /* input with boxed icon */ }
        		$ICON_POSITION = 0;
        		if (isset($field['icon'][0]['position']) && el_between($field['icon'][0]['position'],0,1)) { 
        			$ICON_POSITION = $field['icon'][0]['position'];
        		}
        	}

        }
		$RIGHT_BUTTON = '';
		if (isset($field['button_right_show']) && $field['button_right_show']==true) {
			$RIGHT_BUTTON = '<span class="input-group-btn"><button id="'.$field['control_id'].'_but" class="btn blue" type="button">'.$field['button_right_title'].'</button></span>';
		}
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		switch ($DISPLAY_TYPE) {
			case 0: 
					if (!empty($RIGHT_BUTTON)) {
						$field_str = '
										<div class="form-group">
											<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
												'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
											</label>
											<div class="col-md-'.$COLUMN_SIZE.'">
												<div class="input-group">
													<input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' mycolorpicker el_class '.$CLASS_REQUIRED.'" data-control="hue" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
													'.$RIGHT_BUTTON.'
												</div>
											</div> 
										</div>'.PHP_EOL;         			
					} else {
						$field_str = '
										<div class="form-group">
											<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
												'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
											</label>
											<div class="col-md-'.$COLUMN_SIZE.'">
												<input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' mycolorpicker el_class '.$CLASS_REQUIRED.'" data-control="hue" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
											</div> 
										</div>'.PHP_EOL;         									
					}
		    		break;
			        /* ----------------------------------------- */
			case 1:         
					$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                            <div class="input-icon '.($ICON_POSITION!=0 ? 'right' : '').'">
                                                <i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i>
                                                <input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' mycolorpicker el_class '.$CLASS_REQUIRED.'" data-control="hue" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
                                            </div>
                                        </div>
                                    </div>'.PHP_EOL;         									
		    		break;
			        /* ----------------------------------------- */
			case 2: 
					$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                            <div class="input-group">
                                                '.($ICON_POSITION==0 ? '<span class="input-group-addon"><i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i></span>' : '').'
                                                <input '.$OTHER_ATTRIBUTES.' oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' mycolorpicker el_class '.$CLASS_REQUIRED.'" data-control="hue" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
                                                '.($ICON_POSITION!=0 ? '<span class="input-group-addon"><i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i></span>' : '').'
                                            </div>
                                        </div>
                                    </div>'.PHP_EOL;         						
		    		break;
			        /* ----------------------------------------- */			        
		}
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}
		
		return $field_str;
	}
	
	/* ------------------------------------------------------------------------------------- */
	private function field_password ($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_TEXT din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_TEXT din tab-ul '.get_class($this));			
		} 

        $arr_accepted_input_type = array('text','password');
        $INPUT_TYPE = 'text';
		if (isset($field['input_type'])) { 
			if (in_array($field['input_type'], $arr_accepted_input_type)) {
				$INPUT_TYPE = strtolower($field['input_type']);
			}
		}        

		$REQUIRED_MSG = ''; 
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED_MSG = _($field['required_message']);
		}
				
		if (empty($result_line)) {
			/* este adaugare */
			$REQUIRED = 'required="required"'; /* la adaugare este obligatoriu, nu si la modificare */
			$PLACEHOLDER = (isset($field['placeholder']) ? $field['placeholder'] : '');
			$CLASS_REQUIRED = 'required2';
		} else {
			$REQUIRED = '';
			$PLACEHOLDER = (isset($field['placeholder_on_edit']) ? $field['placeholder_on_edit'] : 'Lasa necompletat daca nu modifici');
			$CLASS_REQUIRED = '';
		}

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

        $DISPLAY_TYPE  = 0; /* clasic input */
        if (isset($field['icon']) && (!empty($field['icon'][0]['class']))) { 
        	if (isset($field['icon'][0]['type'])) {
        		if ($field['icon'][0]['type']==0) { $DISPLAY_TYPE  = 1; /* input with icon */ }
        		if ($field['icon'][0]['type']==1) { $DISPLAY_TYPE  = 2; /* input with boxed icon */ }
        		$ICON_POSITION = 0;
        		if (isset($field['icon'][0]['position']) && el_between($field['icon'][0]['position'],0,1)) { 
        			$ICON_POSITION = $field['icon'][0]['position'];
        		}
        	}

        }
		switch ($DISPLAY_TYPE) {
			case 0: 
					$field_str = '
			                        <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.(!empty($REQUIRED) ? '<span class="required"> * </span>' : '').'
			                            </label>
			                            <div class="col-md-'.$COLUMN_SIZE.'">
			                                <input oninvalid="this.setCustomValidity(\''.$REQUIRED_MSG.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED_MSG.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'.$PLACEHOLDER.'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.$REQUIRED.' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="" >
			                            </div>
			                        </div>'.PHP_EOL;         			
		    		break;
			        /* ----------------------------------------- */
			case 1:         
					$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.(!empty($REQUIRED) ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                            <div class="input-icon '.($ICON_POSITION!=0 ? 'right' : '').'">
                                                <i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i>
                                                <input oninvalid="this.setCustomValidity(\''.$REQUIRED_MSG.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED_MSG.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'.$PLACEHOLDER.'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.$REQUIRED.' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="">
                                            </div>
                                        </div>
                                    </div>'.PHP_EOL;         									
		    		break;
			        /* ----------------------------------------- */
			case 2: 
					$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.(!empty($REQUIRED) ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                            <div class="input-group">
                                                '.($ICON_POSITION==0 ? '<span class="input-group-addon"><i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i></span>' : '').'
                                                <input oninvalid="this.setCustomValidity(\''.$REQUIRED_MSG.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED_MSG.'" type="'.$INPUT_TYPE.'" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'.$PLACEHOLDER.'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.$REQUIRED.' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="" >
                                                '.($ICON_POSITION!=0 ? '<span class="input-group-addon"><i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i></span>' : '').'
                                            </div>
                                        </div>
                                    </div>'.PHP_EOL;         						
		    		break;
			        /* ----------------------------------------- */			        
		}
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}
		
		return $field_str;

	}
	/* ------------------------------------------------------------------------------------- */
	private function field_textarea($field, $result_line){		
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_TEXTAREA din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_TEXTAREA din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] :$default_value );		
		$HIDDEN = '';
		if (isset($field['hidden']) && ($field['hidden']==true)) { 
			$HIDDEN = 'style="display:none;"';
		}
		
		$REQUIRED = ''; 
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}
		
		$COPY_CONTENT = '';
		if (isset($field['show_copy_to_clipboard'])) { 
			if ($field['show_copy_to_clipboard']==true) {
				$COPY_CONTENT = '<label class="pull-right" data-copy="'.$field['control_id'].'"><button class="btn btn-sm" onclick="$(\'#'.$field['control_id'].'\').select(); document.execCommand(\'copy\'); return false;">Copiaza continut</button></label>';
			}
		}

		$ROWS = '3';
		if (isset($field['rows']) && (!empty($field['rows'])) && (is_numeric ( $field['rows'] ))) { 
			$ROWS = $field['rows'];
		}
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
	                                <div class="form-group" '.$HIDDEN.' >
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
	                                    <div class="col-md-'.$COLUMN_SIZE.'">
											'.$COPY_CONTENT.'
	                                        <textarea oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" rows="'.$ROWS.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' placeholder="'._($field['placeholder']).'" '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' '.($field['read_only'] ? 'readonly=""' : '').'>'.$value.'</textarea>
	                                    </div>
	                                </div>'.PHP_EOL;

		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}
        return $field_str;
	}
	/* ------------------------------------------------------------------------------------- */
	private function field_checkbox($field, $result_line) {
		
		$field_str          = '';
	    $checkbox_fields    = '';
	    $checked            = '';
	    $error_control_name = false;
	    $error_db_field     = false;

	    $cb_style           = ((isset($field['style']) && el_between($field['style'],0,1)) ? $field['style'] : 0);

	    if (isset($field['fields'])) {
	        if ( is_array($field['fields']) ) {
	            foreach ($field['fields'] as $row) {
	                
	                if ( !empty($row['db_field']) ) {	                    
	                    $checked='';
	                    $field_name=$row['db_field']; 
	                    if (isset($result_line["$field_name"])) {
	                        // modificare articol
	                        if ($result_line["$field_name"]!=0) { $checked='checked="checked"';}                        
	                    } else {
	                        // adaugare articol
	                        $checked=((isset($row['checked']) && $row['checked']==true ) ? 'checked="checked"' : '');
	                    }
	                }
	                
	                if (!isset($row['control_name']) || empty($row['control_name'])) { $error_control_name = true; break;}
	                if (!isset($row['db_field']) || empty($row['db_field'])) { $error_db_field = true; break;}

	                if (( !$error_control_name ) && ( !$error_db_field )) {
	                    
	                    $id=((isset($row['control_id']) && (!empty($row['control_id']))) ? 'id="'.$row['control_id'].'"' : '');
	                    $read_only=((isset($row['read_only']) && ($row['read_only']==true)) ? 'disabled="disabled"' : '');
						$HELP_MESSAGE_CK = '';
						if (isset($row['help_message']) && (!empty($row['help_message']))) {
							$HELP_MESSAGE_CK = '&nbsp;&nbsp;<strong class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$row['help_message'].'"></strong> ';
						}						
	                    $checkbox_fields .= '
                                                    <label class="mt-checkbox '.($cb_style==0 ? 'mt-checkbox-outline' : '').'"> '._($row['title']).$HELP_MESSAGE_CK.'
                                                        <input type="checkbox" '.$checked.' '.$read_only.' name="'.$row['control_name'].'" '.$id.' />
                                                        <span></span>
                                                    </label>'.PHP_EOL;
	                }
	            }

	            if ($error_control_name) { 	            	
	            	throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_CHECKBOX din tab-ul '.get_class($this));
	            }
	            if ($error_db_field) { 	            	
	            	throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_CHECKBOX din tab-ul '.get_class($this));
	            }

	        }
	    }

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
	                                <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.'<!--<span class="required"> * </span>-->
			                            </label>
	                                    <div class="col-md-'.$COLUMN_SIZE.'">
                                                <div class="'.($cb_style ? 'mt-checkbox-inline' : 'mt-checkbox-list').' pt0">
                                                	'.$checkbox_fields.'
                                                </div>	                                        
	                                    </div>
	                                </div>'.PHP_EOL;

		return $field_str;
	}		
	/* ------------------------------------------------------------------------------------- */
	// date picker
	private function field_date($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_DATE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_DATE din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? el_MysqlDate_To_RomanianDate($result_line["$field_name"]) :$default_value );            
		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$DATE_FORMAT = 'dd-mm-yyyy';
		if (isset($field['date_format']) && (!empty($field['date_format'])) ) { 
			$DATE_FORMAT = $field['date_format'];
		}

		$READONLY = '';
		if (isset($field['read_only']) && (is_bool($field['read_only'])) ) { 
			if ($field['read_only']==true) {
				$READONLY = 'readonly';
			}
		}

		$BOTTOM_INFO = '';
		if (isset($field['bottom_info']) && (!empty($field['bottom_info'])) ) { 
			$BOTTOM_INFO = '<span class="help-block"> '._($field['bottom_info']).' </span>';
		}

		$CAN_SELECT_DATE = true;
		if (isset($field['can_select_date']) && is_bool($field['can_select_date']) ) { 
			$CAN_SELECT_DATE = $field['can_select_date'];
		}

		$CAN_DELETE_DATE = true;
		if (isset($field['can_delete_date']) && is_bool($field['can_delete_date']) ) { 
			$CAN_DELETE_DATE = $field['can_delete_date'];
		}

		$PLACEHOLDER = (isset($field['placeholder']) ? $field['placeholder'] : '');
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                            <div class="input-group input-medium date '.($CAN_SELECT_DATE ? 'date-picker' : '').'" data-date-format="'.$DATE_FORMAT.'" data-date-start-date="">
                                                <input oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="text" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" '.$READONLY.' '.($field['required'] ? 'required=""' : '').' value="'.$value.'" name="'.$field['control_name'].'" placeholder="'._($PLACEHOLDER).'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').'>
                                                <span class="input-group-btn">
                                                	'.($CAN_DELETE_DATE ? '
                                                    <button class="btn default date-reset" type="button" onclick="$(this).parent().parent().find(\'input[type=text]\').val(\'\')">
                                                        <i class="fa fa-times"></i>
                                                    </button>' : '').'
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>                                            
                                            '.$BOTTOM_INFO.'
                                        </div>
                                    </div>'.PHP_EOL;


		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}

	/* ------------------------------------------------------------------------------------- */
	// date range picker
	private function field_date_range($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name_1']) || empty($field['control_name_1'])) { 
			throw new Exception('Specificati "control_name_1" in campul tip FIELD_TYPE_DATE_RANGE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['control_name_2']) || empty($field['control_name_2'])) { 
			throw new Exception('Specificati "control_name_2" in campul tip FIELD_TYPE_DATE_RANGE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field_1']) || empty($field['db_field_1'])) { 
			throw new Exception('Specificati "db_field_1" in campul tip FIELD_TYPE_DATE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field_2']) || empty($field['db_field_2'])) {
			throw new Exception('Specificati "db_field_2" in campul tip FIELD_TYPE_DATE din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field_1']; 
        $default_value = (isset($field['value_1']) ? $field['value_1'] : '');
        $value_1       = (isset($result_line["$field_name"]) ? el_MysqlDate_To_RomanianDate($result_line["$field_name"]) :$default_value );            

        $field_name    = $field['db_field_2']; 
        $default_value = (isset($field['value_2']) ? $field['value_2'] : '');
        $value_2       = (isset($result_line["$field_name"]) ? el_MysqlDate_To_RomanianDate($result_line["$field_name"]) :$default_value );            


		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		/*
		$COLUMN_SIZE = '10';
		if (isset($field['column_size']) && el_between($field['column_size'],2,10)) { 
			$COLUMN_SIZE = $field['column_size'];
		}
		*/
		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$DATE_FORMAT = 'dd-mm-yyyy';
		if (isset($field['date_format']) && (!empty($field['date_format'])) ) { 
			$DATE_FORMAT = $field['date_format'];
		}

		$READONLY = '';
		if (isset($field['read_only']) && (is_bool($field['read_only'])) ) { 
			if ($field['read_only']==true) {
				$READONLY = 'readonly';
			}
		}

		$BOTTOM_INFO = '';
		if (isset($field['bottom_info']) && (!empty($field['bottom_info'])) ) { 
			$BOTTOM_INFO = '<span class="help-block"> '._($field['bottom_info']).' </span>';
		}

		$CAN_SELECT_DATE = true;
		if (isset($field['can_select_date']) && is_bool($field['can_select_date']) ) { 
			$CAN_SELECT_DATE = $field['can_select_date'];
		}

		$CAN_DELETE_DATE = true;
		if (isset($field['can_delete_date']) && is_bool($field['can_delete_date']) ) { 
			$CAN_DELETE_DATE = $field['can_delete_date'];
		}		
		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
									<div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
									    <div class="col-md-'.$COLUMN_SIZE.'">
									        <div class="input-group input-medium '.($CAN_SELECT_DATE ? 'date-picker' : '').' input-daterange" data-date="10/11/2012" data-date-format="'.$DATE_FORMAT.'">
									            <input oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="text" class="form-control el_class input-small '.$CLASS_REQUIRED.'" '.$READONLY.' '.($field['required'] ? 'required=""' : '').' value="'.$value_1.'" name="'.$field['control_name_1'].'" '.(!empty($field['control_id_1']) ? 'id="'.$field['control_id_1'].'"' : '').'>
									            <span class="input-group-addon"> to </span>
									            <input oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="text" class="form-control el_class input-small '.$CLASS_REQUIRED.'" '.$READONLY.' '.($field['required'] ? 'required=""' : '').' value="'.$value_2.'" name="'.$field['control_name_2'].'" '.(!empty($field['control_id_2']) ? 'id="'.$field['control_id_2'].'"' : '').'>
                                                <span class="input-group-btn">
                                                	'.($CAN_DELETE_DATE ? '
                                                    <button class="btn default date-reset" type="button" onclick="$(this).parent().parent().find(\'input[type=text]\').val(\'\')">
                                                        <i class="fa fa-times"></i>
                                                    </button>' : '').'
                                                </span>									            
									        </div>

									        <!-- /input-group -->
									    </div>
									</div>'.PHP_EOL;


		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}

	/* ------------------------------------------------------------------------------------- */	
	// date time picker
			private function field_datetime($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_DATE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_DATE din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        
		$value         = (isset($result_line["$field_name"]) ? el_MysqlDateTime_To_RomanianDateTime($result_line["$field_name"]) :$default_value );
		$data_date     = (isset($result_line["$field_name"]) ? el_MysqlDateTime_To_Date($result_line["$field_name"]) : date("Y-m-d") );
		$data_time     = (isset($result_line["$field_name"]) ? el_MysqlDateTime_To_Time($result_line["$field_name"]) : date("H:i:s") );

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');

		$COLUMN_SIZE = '4';
		if (isset($field['column_size']) && el_between($field['column_size'],2,10)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CAN_SELECT_DATE = true;
		if (isset($field['can_select_date']) && is_bool($field['can_select_date']) ) { 
			$CAN_SELECT_DATE = $field['can_select_date'];
		}
				

		$CAN_DELETE_DATE = true;
		if (isset($field['can_delete_date']) && is_bool($field['can_delete_date']) ) { 
			$CAN_DELETE_DATE = $field['can_delete_date'];
		}		
				
		$DISABLE_PAST_DATE = false;
		if (isset($field['disable_past_date']) && is_bool($field['disable_past_date']) ) { 
			$DISABLE_PAST_DATE = $field['disable_past_date'];
		}
		

		$READONLY = '';
		if (isset($field['read_only']) && (is_bool($field['read_only'])) ) { 
			if ($field['read_only']==true) {
				$READONLY = 'readonly';
			}
		}
		
		$PLACEHOLDER = (isset($field['placeholder']) ? $field['placeholder'] : '');
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		// for metronic version v4.7.5		
		$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
                                        <div class="col-md-'.$COLUMN_SIZE.'">
                                                        <div class="input-group disablepastdate date '.($CAN_SELECT_DATE ? 'form_datetime' : '').' bs-datetime" data-date="'.$data_date.'T'.$data_time.'Z" '.($DISABLE_PAST_DATE ? 'data-date-startDate="'.$data_date.'"' : '').'  data-date-todayHighlight="true">
                                                            <input oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="text" class="form-control el_class '.$CLASS_REQUIRED.'" '.$READONLY.' value="'.$value.'" name="'.$field['control_name'].'" placeholder="'._($PLACEHOLDER).'" '.($field['required'] ? 'required=""' : '').'>
                                                            <span class="input-group-addon">
                                                                <button class="btn default date-set" type="button">
																	<i class="'.((isset($field['skip_update']) && $field['skip_update']==true) ? 'fa fa-calendar-times-o' : 'fa fa-calendar').'"></i>
                                                                </button>
                                                            </span>
                                                        </div>										
                                        </div>
                                    </div>'.PHP_EOL;
		
		
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}

	/* ------------------------------------------------------------------------------------- */
	private function field_combo_bootstrap_custom($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in tab-ul '.get_class($this));			
		} 

		$combo_attributes = '';
		if (isset($field['attributes'])) {
		    if (is_array($field['attributes'])) {
		        foreach ($field['attributes'] as $row) {
		            if (!empty($field['db_field'])) {
		                $selected='';
		                $field_name=$field['db_field']; 
		                if (isset($result_line["$field_name"])) {
		                    // edit section
		                    if ($result_line["$field_name"]==$row['value']) { $selected='selected="selected"';}
		                } else {
		                    // insert section
		                    $selected=((isset($row['selected']) && $row['selected']==true ) ? 'selected="selected"' : '');
		                }
		            }                
		            $value=((isset($row['value'])) ? 'value="'.$row['value'].'"' : '');
		            $combo_attributes .='<option '.$selected.' '.$value.' >'.$row['title'].'</option>'.PHP_EOL;
		        }
		    }
		}   

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
			                            <div class="col-md-'.$COLUMN_SIZE.'">
	                                        <select oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.($field['required'] ? 'required=""' : '').' '.($field['read_only'] ? 'readonly=""' : '').'>
	                                        	'.$combo_attributes.'
	                                        </select>
                                        </div>
                                    </div>'.PHP_EOL;


		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}
	/* ------------------------------------------------------------------------------------- */
	// field_combo_custom_icons
	private function field_combo_custom_icons($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS din tab-ul '.get_class($this));			
		} 

		$combo_attributes = '';
		if (isset($field['attributes'])) {
		    if (is_array($field['attributes'])) {
		        foreach ($field['attributes'] as $row) {
		            if (!empty($field['db_field'])) {
		                $selected='';
		                $field_name=$field['db_field']; 
		                if (isset($result_line["$field_name"])) {
		                    // edit section
		                    if ($result_line["$field_name"]==$row['value']) { $selected='selected="selected"';}
		                } else {
		                    // insert section
		                    $selected=((isset($row['selected']) && $row['selected']==true ) ? 'selected="selected"' : '');
		                }
		            }                
		            $value=((isset($row['value'])) ? 'value="'.$row['value'].'"' : '');
		            $combo_attributes .='<option '.$selected.' '.$value.' data-icon="'.$row['icon_class'].'" >'.$row['title'].'</option>'.PHP_EOL;
		        }
		    }
		}   

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
			                            <div class="col-md-'.$COLUMN_SIZE.'">
	                                        <select oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="bs-select form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' data-show-subtext="true" '.($field['required'] ? 'required=""' : '').' '.($field['read_only'] ? 'disabled=""' : '').'>
	                                        	'.$combo_attributes.'
	                                        </select>
                                        </div>
                                    </div>'.PHP_EOL;


		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}	
	/* ------------------------------------------------------------------------------------- */
	private function field_combo_bootstrap_table($field, $result_line){
		global $oDB;
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COMBO_BOOTSTRAP_TABLE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_COMBO_BOOTSTRAP_TABLE din tab-ul '.get_class($this));			
		} 		
		if (!isset($field['query_table']) || empty($field['query_table'])) { 
			throw new Exception('Specificati "query_table" in campul tip FIELD_TYPE_COMBO_BOOTSTRAP_TABLE din tab-ul '.get_class($this));
		} 		
		if (!isset($field['db_field_value']) || empty($field['db_field_value'])) { 
			throw new Exception('Specificati "db_field_value" in campul tip FIELD_TYPE_COMBO_BOOTSTRAP_TABLE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field_title']) || empty($field['db_field_title'])) { 
			throw new Exception('Specificati "db_field_value" in campul tip FIELD_TYPE_COMBO_BOOTSTRAP_TABLE din tab-ul '.get_class($this));
		} 


	    $field['order_direction'] = strtoupper(trim($field['order_direction']));
	    $where_id_archive = (isset($field['id_archive']) ? " AND id_archive =".$field['id_archive']." " : "");
	    $order_by         = (isset($field['order_by_field']) ? "ORDER BY ".$field['order_by_field']." " : "");
	    $order_direction  = (isset($field['order_direction']) && (($field['order_direction']=='ASC') || ($field['order_direction']=='DESC')) ? $field['order_direction']." " : "");
	    $limit            = (isset($field['limit_items']) ? " LIMIT ".$field['limit_items'] : " LIMIT 10000 ");
	    
	    $table_name = $field['query_table'];
	    $eval_str = "\$table_name = \$oDB->$table_name;";
	    eval($eval_str);

	    $query  = "SELECT ".$field['db_field_value']." AS id, ".$field['db_field_title']." AS title FROM ".$table_name." WHERE 1 $where_id_archive $order_by $order_direction $limit";
	    $result = $oDB->db_query($query);
	    
		$field_name = $field['db_field'];
		$value = '';
	    $combo_options    = ((!isset($field['first_line_message']) || empty($field['first_line_message'])) ? '' : '<option value="" >'.$field['first_line_message'].'</option>');
	    while ($result_line_table = $oDB->db_fetch_array($result)) {
	        $selected = '';
	        if ($result_line) {
	        	if ( $result_line["$field_name"] == $result_line_table['id'] ) { $selected = 'selected="selected"'; $value =$result_line_table['id'];}
	    	}
	        $combo_options .= '<option value="'.$result_line_table['id'].'" '.$selected.'>'.$result_line_table['title'].'</option>'.PHP_EOL;
	    }

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		$READ_ONLY = false;
		if (isset($field['read_only']) && (!empty($field['read_only']))) {
			$READ_ONLY = $field['read_only'];
		}
		if ($READ_ONLY==false) {
			if ((!empty($result_line)) && (isset($field['read_only_on_edit'])) && (!empty($field['read_only_on_edit']))) {
				$READ_ONLY = $field['read_only_on_edit'];
			}
		}		
		
		$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
			                            <div class="col-md-'.$COLUMN_SIZE.'">
	                                        <select oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.($field['required'] ? 'required=""' : '').' '.($READ_ONLY ? 'disabled=""' : '').'>
	                                        	'.$combo_options.'
	                                        </select>
											'.($READ_ONLY ? '<input type="hidden" name="'.$field['control_name'].'" value="'.$value.'">' : '').'
                                        </div>
                                    </div>'.PHP_EOL;

		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}

	/* ------------------------------------------------------------------------------------- */
	private function field_combo_with_search($field, $result_line){
		global $oDB;
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COMBO_WITH_SEARCH din tab-ul '.get_class($this));			
		} 
		if (!isset($field['query_table']) || empty($field['query_table'])) { 
			throw new Exception('Specificati "query_table" in campul tip FIELD_TYPE_COMBO_WITH_SEARCH din tab-ul '.get_class($this));
		} 		
		if (!isset($field['db_field_value']) || empty($field['db_field_value'])) { 
			throw new Exception('Specificati "db_field_value" in campul tip FIELD_TYPE_COMBO_WITH_SEARCH din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field_title']) || empty($field['db_field_title'])) { 
			throw new Exception('Specificati "db_field_value" in campul tip FIELD_TYPE_COMBO_WITH_SEARCH din tab-ul '.get_class($this));
		} 


	    $field['order_direction'] = strtoupper(trim($field['order_direction']));
	    $where_id_archive = (isset($field['id_archive']) ? " AND id_archive =".$field['id_archive']." " : "");
	    $order_by         = (isset($field['order_by_field']) ? "ORDER BY ".$field['order_by_field']." " : "");
	    $order_direction  = (isset($field['order_direction']) && (($field['order_direction']=='ASC') || ($field['order_direction']=='DESC')) ? $field['order_direction']." " : "");
	    $limit            = (isset($field['limit_items']) ? " LIMIT ".$field['limit_items'] : " LIMIT 10000 ");
	    
	    $table_name = $field['query_table'];
	    $eval_str = "\$table_name = \$oDB->$table_name;";
	    eval($eval_str);
		if (isset($field['query']) && (!empty($field['query']))) {
			$query = $field['query'];
		} else {					
			$query  = "SELECT ".$field['db_field_value']." AS id, ".$field['db_field_title']." AS title FROM ".$table_name." WHERE 1 $where_id_archive $order_by $order_direction $limit";
		}
	    $result = $oDB->db_query($query);

	    $field_name = $field['db_field'];

		$value = '';
	    $combo_options    = ((!isset($field['first_line_message']) || empty($field['first_line_message'])) ? '' : '<option value="" >'.$field['first_line_message'].'</option>');
	    while ($result_line_table = $oDB->db_fetch_array($result)) {
	        $selected = '';
	        if ($result_line) {
	        	if ( $result_line["$field_name"] == $result_line_table['id'] ) { $selected = 'selected="selected"'; $value =$result_line_table['id']; }
	    	}
	        $combo_options .= '<option value="'.$result_line_table['id'].'" '.$selected.'>'.$result_line_table['title'].'</option>'.PHP_EOL;
	    }

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		$READ_ONLY = false;
		if (isset($field['read_only']) && (!empty($field['read_only']))) {
			$READ_ONLY = $field['read_only'];
		}
		if ($READ_ONLY==false) {
			if ((!empty($result_line)) && (isset($field['read_only_on_edit'])) && (!empty($field['read_only_on_edit']))) {
				$READ_ONLY = $field['read_only_on_edit'];
			}
		}
		
		$field_str = '
									<div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
									  <div class="col-md-'.$COLUMN_SIZE.'">
									      <select  oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="bs-select form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' data-live-search="true" data-size="8" '.($field['required'] ? 'required=""' : '').' '.($READ_ONLY ? 'disabled=""' : '').'>
									      		'.$combo_options.'
									      </select>
										  '.($READ_ONLY ? '<input type="hidden" name="'.$field['control_name'].'" value="'.$value.'">' : '').'
									  </div>
									</div>'.PHP_EOL;

		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}
		/*
		if ($field['db_field']=='idma') {
			if (isset($_REQUEST['idma'])) {
				$field_str = '';
			}
		}
		*/
        return $field_str;
	}

	/* ------------------------------------------------------------------------------------- */
	//
	private function field_combo_multiselect($field, $result_line, $result_multiselect){
		global $oDB;
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COMBO_MULTISELECT din tab-ul '.get_class($this));			
		} 
		if (!isset($field['query_table']) || empty($field['query_table'])) { 
			throw new Exception('Specificati "query_table" in campul tip FIELD_TYPE_COMBO_MULTISELECT din tab-ul '.get_class($this));
		} 		
		if (!isset($field['db_field_value']) || empty($field['db_field_value'])) { 
			throw new Exception('Specificati "db_field_value" in campul tip FIELD_TYPE_COMBO_MULTISELECT din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field_title']) || empty($field['db_field_title'])) { 
			throw new Exception('Specificati "db_field_value" in campul tip FIELD_TYPE_COMBO_MULTISELECT din tab-ul '.get_class($this));
		} 
		
		$db_field   = $field['db_field_title']; 
		
		$arr_options_id=array();
		if ($result_multiselect) {
			$oDB->db_data_seek($result_multiselect,0);
			while ($result_line1 = $oDB->db_fetch_array($result_multiselect)) {
				if ($result_line1['id_archive']==$field['store_table_id_archive']) {
					array_push($arr_options_id, $result_line1['id_options'] );
				}
			}
		}
		
		if(isset($field['query']) && (!empty($field['query']))) {
			$query = $field['query'];
		} else {
			$field['order_direction'] = strtoupper(trim($field['order_direction']));
			$where_id_archive = (isset($field['id_archive']) ? " AND id_archive =".$field['id_archive']." " : "");
			$order_by         = (isset($field['order_by_field']) ? "ORDER BY ".$field['order_by_field']." " : "");
			$order_direction  = (isset($field['order_direction']) && (($field['order_direction']=='ASC') || ($field['order_direction']=='DESC')) ? $field['order_direction']." " : "");
			$limit            = (isset($field['limit_items']) ? " LIMIT ".$field['limit_items'] : " LIMIT 10000 ");
			
			$table_name = $field['query_table'];
			$eval_str   = "\$table_name = \$oDB->$table_name;";
			eval($eval_str);

			$field_image = (((isset($field['db_field_image'])) && (!empty($field['db_field_image']))) ? $field['db_field_image'] : '');			
			
			$query = '';
			if (isset($field['method_to_return_custom_query']) && (!empty($field['method_to_return_custom_query']))) {
				if (method_exists($this,$field['method_to_return_custom_query'])) {
					$query = $this->{$field['method_to_return_custom_query']}($field['db_field_value'], $field['db_field_title'], $field_image);
				}
			}			
			if (empty($query)) {
				if (!empty($field_image)) {
					$query  = "SELECT ".$field['db_field_value']." AS id, ".$field['db_field_title'].", ".$field['db_field_image']." FROM ".$table_name." WHERE 1 $where_id_archive $order_by $order_direction $limit";
				} else {
					$query  = "SELECT ".$field['db_field_value']." AS id, ".$field['db_field_title']." FROM ".$table_name." WHERE 1 $where_id_archive $order_by $order_direction $limit";
				}
			}
		}
		
	    $result = $oDB->db_query($query);
	    $combo_options    = '';
		
		$ITEM_HAS_IMAGE =(!empty($field_image) ? true : false);
	    while ($result_line_table = $oDB->db_fetch_array($result)) {
	        $selected = '';			
        	if (in_array($result_line_table['id'], $arr_options_id)) { $selected = 'selected="selected"'; }
			$combo_options .= '<option value="'.$result_line_table['id'].'" '.$selected.' '.($ITEM_HAS_IMAGE ? 'data-image="'.$result_line_table["$field_image"].'"' : '').'>'.$result_line_table["$db_field"].'</option>'.PHP_EOL;
	    }

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		$field_str = '
                                    <div class="form-group">
										<div class="input-group select2-bootstrap-prepend">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
			                            <div class="col-md-'.$COLUMN_SIZE.'">
                                            <select oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control input-lg select2-multiple'.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'[]" multiple '.($field['required'] ? 'required=""' : '').' '.($field['read_only'] ? 'disabled=""' : '').'>
                                            	'.$combo_options.'
                                            </select>

                                        </div>
										</div>
                                    </div>'.PHP_EOL;

		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}

	/* ------------------------------------------------------------------------------------- */
	//
	private function field_combo_switch($field, $result_line){
		$field_str        = '';
		$field_str_switch = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COMBO_SWITCH din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_COMBO_SWITCH din tab-ul '.get_class($this));			
		} 

		$combo_attributes = '';
		if (isset($field['attributes'])) {
		    if (is_array($field['attributes'])) {
		        foreach ($field['attributes'] as $row) {
		            if (!empty($field['db_field'])) {
		                $selected='';
		                $field_name=$field['db_field']; 
		                if (isset($result_line["$field_name"])) {
		                    // edit section
		                    if ($result_line["$field_name"]==$row['value']) { $selected='selected="selected"';}
		                } else {
		                    // insert section
		                    $selected=((isset($row['selected']) && $row['selected']==true ) ? 'selected="selected"' : '');
		                }
		            }                
		            $value=((isset($row['value'])) ? 'value="'.$row['value'].'"' : '');
					/* ====== */
					$option_title = '';
					if (isset($row['class_method_for_title']) && (!empty($row['class_method_for_title']))) {
						if (method_exists($this,$row['class_method_for_title'])) {
							$option_title = $this->{$row['class_method_for_title']}();
						} else {
							$current_class= get_class($this);
							throw new Exception('In clasa "'.$current_class.'" nu exista definita metoda mentionata in campul "class_method_for_content" la controlul de tip FIELD_TYPE_COMBO_SWITCH din tab-ul '.$current_class);
						}
					} else {
						$option_title = (isset($row['title']) ? $row['title'] : '');
					}					
					/* ====== */
		            //$combo_attributes .='<option '.$selected.' '.$value.' >'.$row['title'].'</option>'.PHP_EOL;
					$combo_attributes .='<option '.$selected.' '.$value.' >'.$option_title.'</option>'.PHP_EOL;
					/* ----*/
					$arr_fields        = $row['fields'];
					$div_id            = $field['control_name'].'_'.(isset($row['value']) ? $row['value'] : '');
					$div_class         = 'combo_switch_'.$field['control_name'];
					$field_str_switch .= '<div id="'.$div_id.'" class="'.$div_class.' combo_sw_areas" style="">'.PHP_EOL;
					if ((isset($row['custom_fields'])) && (!empty($row['custom_fields']))) {
						$field_str_switch .= $this->ReturnCustomFields($result_line);
					} else {						
						$field_str_switch .= $this->ReturnTabContent($arr_fields, $result_line);
					}
					$field_str_switch .= '</div>'.PHP_EOL;
					/* ---- */
		        }
		    }
		}   

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
                                    <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
			                            <div class="col-md-'.$COLUMN_SIZE.'">
	                                        <select name="'.$field['control_name'].'" oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\');$(\'.combo_switch_\'+$(this).attr(\'name\')).hide(0).attr(\'activecontrol\', \'false\');$(\'#\'+$(this).attr(\'name\')+\'_\'+$(this).val()).show(0).attr(\'activecontrol\', \'true\'); cst_DisableFieldsOnComboSwitch(); }catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class combo_switch_select '.$CLASS_REQUIRED.'" '.($field['required'] ? 'required=""' : '').' '.($field['read_only'] ? 'disabled=""' : '').'>
	                                        	'.$combo_attributes.'
	                                        </select>
                                        </div>
                                    </div>'.PHP_EOL;
		$field_str .= $field_str_switch;


		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}
	
	/* ---------------------------------------------------------------------------------------- */
	private function field_combo_interactive($field, $result_line='') {
		global $oDB;
		
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_COMBO_INTERACTIVE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_COMBO_INTERACTIVE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['categories']) || empty($field['categories'])) { 
			throw new Exception('Specificati "categories" in campul tip FIELD_TYPE_COMBO_INTERACTIVE din tab-ul '.get_class($this));			
		} 
		
		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
				
		$categs_no=0;
		if (isset($field['categories'])) {
			if (is_array($field['categories'])) {
				$i=0;
				$filter_categ_table = '';
				$filter_id_archive  = '';
				$filter_fields      = '';
				$value_fields       = '';
				$title_fields       = '';
				$order_by           = '';
				$first_values       = '';
				
				foreach ($field['categories'] as $row) {
					$arr_categ[$i][0]=$row['db_field_value'];
					$arr_categ[$i][1]=$row['db_field_title'];
					$arr_categ[$i][2]=$row['id_archive'];
					$arr_categ[$i][3]=$row['title'];
					$arr_categ[$i][4]=$row['read_only'];
					$arr_categ[$i][5]=el_TableNameWithPrefix($row['query_table']);
					$arr_categ[$i][6]=$row['db_field_filter'];
					//$arr_categ[$i][7]=$row['order_by'];
					$arr_categ[$i][8]=$row['limit_items'];
					$arr_categ[$i][9]=$row['order_by_field'];
					$arr_categ[$i][10]=$row['order_direction'];
					
					$filter_categ_table .= ($i!=0 ? ';' : '').$row['query_table'];
					$filter_id_archive  .= ($i!=0 ? ';' : '').$row['id_archive'];
					$filter_fields      .= ($i!=0 ? ';' : '').$row['db_field_filter'];
					$value_fields       .= ($i!=0 ? ';' : '').$row['db_field_value'];
					$title_fields       .= ($i!=0 ? ';' : '').$row['db_field_title'];
					$order_by           .= ($i!=0 ? ';' : '').$row['order_by_field'].' '.$row['order_direction'];
					$first_values       .= ($i!=0 ? ';' : '').$row['title'];
					$i++;
				}
			}
		}
		$categs_no=$i;
					   
		if (!empty($field['db_field']) && ($categs_no>0)) {
			$field_name=$field['db_field']; 
			if (isset($result_line["$field_name"])) {
				/* ------------------------------------------------------------------------------------ */
				// modificare articol
				
				// query pentru determinarea id-urilor categoriilor dupa care se face filtrarea            
				// echo($this->parent);
				// die ('ccc');

				$archive_table   = el_TableNameWithPrefix($this->parent->table_name);
				//$archive_table = 'el_products';
				$field_of_query  = '';
				$LEFT_JOIN_QUERY = '';
				$current_table   = $archive_table;
				$db_filter_field = $field['db_field'];
				
				for ($i = ($categs_no-1); $i >=0; $i--) {
					$field_of_query  .= ($i!=($categs_no-1) ? ', ' : '').$arr_categ[$i][5].'.id AS '.$arr_categ[$i][5];
					$table_to_join    = $arr_categ[$i][5];
					$LEFT_JOIN_QUERY .= "LEFT JOIN $table_to_join ON $current_table.$db_filter_field=$table_to_join.id ";
					$current_table    = $table_to_join;
					$db_filter_field  = $arr_categ[$i][6];
				}
				$SELECT_QUERY = "SELECT $field_of_query FROM $archive_table $LEFT_JOIN_QUERY WHERE $archive_table.".$field['db_field']."=".$result_line["$field_name"]." LIMIT 1";
				//$result       = tep_db_query($SELECT_QUERY);            
				$result       = $oDB->db_query($SELECT_QUERY);
				
				$ERROR     = false;
				$ERROR_MSG = '';
				$combo     = '';
				if (!($result_line_filter_code =  $oDB->db_fetch_array($result))) {
					$ERROR=true; $ERROR_MSG='Eroare afisare combo categorii (1) !';
				}            
				if (!$ERROR) {
					$select_query = '';
					for ($i = ($categs_no-1); $i >=0; $i--) {
						$previous_table = ((($i-1)>=0) ? $arr_categ[$i-1][5] : '');                    
						//$filter_cond= (!empty($previous_table) ? 'AND '.$arr_categ[$i][6].' = '.$result_line_filter_code["$previous_table"] : '' );
						$filter_cond= (!empty($previous_table) ? 'AND '.$arr_categ[$i][6].' = '.($result_line_filter_code["$previous_table"]!='' ? $result_line_filter_code["$previous_table"] : '0') : '' );
						
						$ORDER_QUERY=" ORDER BY ".$arr_categ[$i][9]." ".$arr_categ[$i][10];
						$select_query  .= ($i!=($categs_no-1) ? ' UNION ' : '')." (SELECT ".$arr_categ[$i][0]." AS id, ".$arr_categ[$i][1]." AS title, $i AS type FROM ".$arr_categ[$i][5]." WHERE id_archive=".$arr_categ[$i][2]." AND visible!=0 $filter_cond $ORDER_QUERY LIMIT ".$arr_categ[$i][8].") ";
					}                
					if (empty($select_query)) {
						$ERROR=true; $ERROR_MSG='Eroare afisare combo categorii (2) !';
					}
					if (!$ERROR) {
						//$result  = tep_db_query($select_query);
						$result = $oDB->db_query($select_query);
						$field_str = '';
						for ($i = 0; $i <$categs_no; $i++) {
							//tep_db_data_seek($result, 0);
							$oDB->db_data_seek($result,0);
							$combo_content[$i] = '';
							while ($result_line = $oDB->db_fetch_array($result)) {
								if ($result_line['type']==$i) {
									$combo_table=$arr_categ[$i][5];
									if ($result_line['id']==$result_line_filter_code["$combo_table"]) { $selected='selected'; } else {$selected='';}
									$combo_content[$i] .= '<option value="'.$result_line['id'].'" '.$selected.'>'.$result_line['title'].'</option>'.PHP_EOL;
								}
							}
							$fld_name=$field['control_name'].'_'.($categs_no-$i);
							$field_str .= '
								<div class="form-group">
								  <label class="col-md-'.$this->label_size.' control-label">'.($i==0 ? _($field['title']).$HELP_MESSAGE.'<span class="required"> * </span>' : '').'</label>
								  <div class="col-md-'.$COLUMN_SIZE.'">							  
									  <select required="" id="'.$fld_name.'" name="'.$fld_name.'" oninvalid="this.setCustomValidity(\''.$arr_categ[$i][3].'\')" onchange="try{this.setCustomValidity(\'\');reload_combo_when_change('.($categs_no-$i).',this.options[this.selectedIndex].value,\''.$field['control_name'].'\', \''.$filter_categ_table.'\', \''.$filter_id_archive.'\', \''.$filter_fields.'\', \''.$value_fields.'\', \''.$title_fields.'\', \''.$order_by.'\', \''.$first_values.'\');}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class" >
											<option value="">'.$arr_categ[$i][3].'</option>
											'.$combo_content[$i].'
									  </select>
								  </div>
								</div>'.PHP_EOL;
							
							//$field_str .= $combo_content[$i];
						}   
					} else {
						echo $ERROR_MSG;
					}                					
				}
				
				// end modifica erticol            
				/* ------------------------------------------------------------------------------------ */
			} else {
				/* ------------------------------------------------------------------------------------ */
				// adaugare articol
				
				$table_name = $arr_categ[0][5];
				
				$first_select_content = '';
				$query 		  		  = "SELECT ".$arr_categ[0][0]." AS id, ".$arr_categ[0][1]." AS title FROM ".$table_name." WHERE id_archive=".$arr_categ[0][2]." AND visible!=0 ORDER BY ".$arr_categ[0][9]." ".$arr_categ[0][10]." LIMIT ".$arr_categ[0][8];
				$result               = $oDB->db_query($query);
				while ($result_line = $oDB->db_fetch_array($result)) {				
					$first_select_content .= '<option value="'.$result_line['id'].'">'.$result_line['title'].'</option>'.PHP_EOL;
				}				
				$field_str = '';
				for ($i = 0; $i < $categs_no; $i++) {
					$fld_name=$field['control_name'].'_'.($categs_no-$i);
					$field_str .= '
						<div class="form-group">
						  <label class="col-md-'.$this->label_size.' control-label">'.($i==0 ? _($field['title']).$HELP_MESSAGE.'<span class="required"> * </span>' : '').'</label>
						  <div class="col-md-'.$COLUMN_SIZE.'">							  
							  <select required="" id="'.$fld_name.'" name="'.$fld_name.'" oninvalid="this.setCustomValidity(\''.$arr_categ[$i][3].'\')" onchange="try{this.setCustomValidity(\'\');reload_combo_when_change('.($categs_no-$i).',this.options[this.selectedIndex].value,\''.$field['control_name'].'\', \''.$filter_categ_table.'\', \''.$filter_id_archive.'\', \''.$filter_fields.'\', \''.$value_fields.'\', \''.$title_fields.'\', \''.$order_by.'\', \''.$first_values.'\');}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class" >
									<option value="">'.$arr_categ[$i][3].'</option>
									'.($i==0 ? $first_select_content : '').'
							  </select>
						  </div>
						</div>'.PHP_EOL;
				}
				
				// end adauga articol
				/* ------------------------------------------------------------------------------------ */
			}
		}                
		
		return $field_str;        
	}
	
	/* ---------------------------------------------------------------------------------------- */
	public function field_editor_ckeditor($field, $result_line='') {
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_EDITOR_CKEDITOR din tab-ul '.get_class($this));
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_EDITOR_CKEDITOR din tab-ul '.get_class($this));
		} 	

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] : $default_value );            
        $value         = htmlentities($value, ENT_QUOTES, "UTF-8");		

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		$field_str = '
						<div class="form-group">
							<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
								'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
							</label>
							<div class="col-md-'.$COLUMN_SIZE.'">
								<textarea oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="ckeditor form-control el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.($field['read_only'] ? 'disabled=""' : '').'>'.$value.'</textarea>
							</div>
						</div>'.PHP_EOL;         			
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}						
		return $field_str;		
	}
	/* ---------------------------------------------------------------------------------------- */
	public function field_select_image($field, $result_line='') {
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_SELECT_IMAGE din tab-ul '.get_class($this));
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_SELECT_IMAGE din tab-ul '.get_class($this));
		} 	

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] : $default_value );            
		
        //$value         = htmlentities($value, ENT_QUOTES, "UTF-8");
		

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}
		
		$FILE_CONTROL_NAME  = $field['control_name'].'_'.'3gURNv';
		$STATE_CONTROL_NAME = $FILE_CONTROL_NAME.'_1';
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		$field_str = '
						<div class="form-group">
							<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
								'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
							</label>
							<div class="col-md-'.$COLUMN_SIZE.'">
								<div class="fileinput '.(empty($value) ? 'fileinput-new' : 'fileinput-exists').'" data-provides="fileinput">
									<input type="hidden" name="'.$FILE_CONTROL_NAME.'" value="'.el_encript_info($value).'">
									<input type="hidden" name="'.$STATE_CONTROL_NAME.'" value="-1" data-info="imgstate">
									<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">'.(!empty($value) ? '<img src="'.el_AdminCropImage($value,0,150).'" />' : '').' </div>
									<div>
										<span class="btn red btn-outline btn-file">
											<span class="fileinput-new"> Select image </span>
											<span class="fileinput-exists"> Change </span>
											<input oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="file" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.($field['read_only'] ? 'disabled=""' : '').'>
										</span>
										<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
									</div>
								</div>
								<!--<div class="clearfix margin-top-10"><span class="label label-success">NOTE!</span> Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead. </div>-->
							</div>							
						</div>'.PHP_EOL;         			
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}						
		return $field_str;
	}	
	/* ---------------------------------------------------------------------------------------- */
	public function field_select_file($field, $result_line='') {
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_SELECT_IMAGE din tab-ul '.get_class($this));
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_SELECT_IMAGE din tab-ul '.get_class($this));
		} 	

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] : $default_value );            
		
        //$value         = htmlentities($value, ENT_QUOTES, "UTF-8");
		

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');
		
		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}
		$SHOW_PREVIEW = (isset($field['show_preview']) ? $field['show_preview'] : false);
		$CONTROL_ID = (!empty($field['control_id']) ? $field['control_id'] : $field['control_name'].'_xFtYy');
		
		$IMG_HEIGHT = (isset($field['auto_height']) && $field['auto_height']==true ? 'auto' : '150px');
		
        $DISPLAY_TYPE  = 0; /* clasic input */
		$SHOW_ICON     = 0;
        if (isset($field['icon']) && (!empty($field['icon'][0]['class']))) { 
        	if (isset($field['icon'][0]['type'])) {
        		if ($field['icon'][0]['type']==0) { $DISPLAY_TYPE  = 1; /* input with icon */ }
        		if ($field['icon'][0]['type']==1) { $DISPLAY_TYPE  = 2; /* input with boxed icon */ }
        		$SHOW_ICON = 1;
        	}

        }		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		$field_str = '
						<div class="form-group">
							<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
								'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
							</label>
							<div class="col-md-'.$COLUMN_SIZE.'">
									'.($SHOW_PREVIEW ? '<div id="img'.$CONTROL_ID.'" class="fileinput-preview thumbnail" style="width: 200px; height: '.$IMG_HEIGHT.';">'.(!empty($value) ? '<a href="'.$value.'" download><img src="'.el_AdminCropImage($value,0,150).'" /></a>' : '').' </div>' : '').'
									<div class="input-group">
										'.($SHOW_ICON ? '<span class="input-group-addon"><a target="_blank" href="'.(!empty($value) ? $value : 'javascript:;').'" download><i class="'.$field['icon'][0]['class'].' '.$field['icon'][0]['color'].'"></i></a></span>' : '').'
										<input oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" title="'.$REQUIRED.'" type="text" class="file-input-elfinder form-control '.$CONTROL_WIDTH_CLASS.' el_class '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" id="'.$CONTROL_ID.'" placeholder="'._($field['placeholder']).'" '.(!empty($field['pattern']) ? 'pattern="'.$field['pattern'].'"' : '').' '.($field['required'] ? 'required=""' : '').' '.(!empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '').' value="'.$value.'" '.($field['read_only'] ? 'readonly=""' : '').'>
										<span class="input-group-btn">
											<button class="btn btn-outline red btn_select_file" rel="'.$CONTROL_ID.'" type="button">Select</button>
										</span>
										<span class="input-group-btn">
											<button type="button" class="btn red dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
												<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right" role="menu">
												<li><a href="'.(!empty($value) ? $value : 'javascript:;').'" download id="open'.$CONTROL_ID.'"><i class="fa fa-search"></i> Preview</a></li>
												<li><a href="javascript:activate_file_input(\''.$CONTROL_ID.'\')"><i class="fa fa-pencil"></i> Edit</a></li>
												<li class="divider"> </li>
												<li><a href="javascript:clear_file_input(\''.$CONTROL_ID.'\')"><i class="fa fa-trash-o"></i> Remove</a></li>
											</ul>
                                        </span>																				
									</div>							
							</div>
						</div>'.PHP_EOL;
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}						
		return $field_str;
		
	}
	/* ---------------------------------------------------------------------------------------- */
	public function field_tags_input($field, $result_line='') {
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_TAGS_INPUT din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul de tip FIELD_TYPE_TAGS_INPUT din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] :$default_value );            
        $value         = htmlentities($value, ENT_QUOTES, "UTF-8");

		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}		

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		$field_str = '
						<div class="form-group">
							<label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
								'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
							</label>
							<div class="col-md-'.$COLUMN_SIZE.'">
								<input type="text" class="form-control el_class" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' value="'.$value.'" data-role="tagsinput"> </div>
						</div>'.PHP_EOL;
		
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}						
		return $field_str;		
	}	
	/* ---------------------------------------------------------------------------------------- */
	private function field_menu($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_MENU din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_MENU din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] : $default_value );
		if (empty($value)) {
			$value = "[]";
		}
				
		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}

		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
	                                <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
	                                    <div class="col-md-'.$COLUMN_SIZE.'">
										  <div class="dd" id="'.$field_name.'-1">
											<button id="domenu-add-item-btn" class="dd-new-item">+</button>
											<li class="dd-item-blueprint">
											  <button class="collapse" data-action="collapse" type="button" style="display: none;">–</button>
											  <button class="expand" data-action="expand" type="button" style="display: none;">+</button>
											  <div class="dd-handle dd3-handle">&nbsp;</div>
											  <div class="dd3-content">
												<span class="item-name">[item_name]</span>
												<div class="dd-button-container">
												  <button class="custom-button-example">&#x270E;</button>
												  <button class="item-add">+</button>
												  <button class="item-remove" data-confirm-class="item-remove-confirm">&times;</button>
												</div>
												<div class="dd-edit-box" style="display: none;">
												  <input type="text" name="title" autocomplete="off" placeholder="Item"
														 data-placeholder="Titlu inregistrare"
														 data-default-value="Inregistrare {?numeric.increment}">
												  <input type="url" name="http" placeholder="http://">
												  <i class="end-edit">salvez</i>
												</div>
											  </div>
											</li>

											<ol class="dd-list"></ol>
										  </div>	                                        
										  <div id="'.$field_name.'-1-output" class="output-preview-container">
											<textarea oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class jsonOutput '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : '').' '.($field['required'] ? 'required=""' : '').'></textarea>
										  </div>
	                                    </div>
	                                </div>'.PHP_EOL;
									
		$menu_script_for_app_footer = '
		<script>
		  $(document).ready(function() {
			var $domenu            = $("#'.$field_name.'-1"),
				domenu             = $("#'.$field_name.'-1").domenu(),
				$outputContainer   = $("#'.$field_name.'-1-output"),
				$jsonOutput        = $outputContainer.find(".jsonOutput");

			$domenu.domenu({
				slideAnimationDuration: 0,
				maxDepth:               '.(isset($field['maxnestedlevel']) ? $field['maxnestedlevel'] : '0').',
				select2:                {
				  support: true,
				  params:  {
					tags: true
				  }
				},
				data: \''.$value.'\'
			  })
			  .onCreateItem(function(blueprint) {	  
				var customButton = $(blueprint).find(".custom-button-example");
				customButton.click(function() {
				  blueprint.find(".dd3-content span").first().click();
				  return false;
				});
			  })	  
			  .parseJson()
			  .on(["onItemCollapsed", "onItemExpanded", "onItemAdded", "onSaveEditBoxInput", "onItemDrop", "onItemDrag", "onItemRemoved", "onItemEndEdit"], function(a, b, c) {
				$jsonOutput.val(domenu.toJson());
				
			  })
			  .onToJson(function() {        
			  }); 

			  $jsonOutput.val(domenu.toJson());
		  });
		</script>'.PHP_EOL;
		
		if (!property_exists($this->parent->parent, 'nested_list_menu')) {
			$this->parent->parent->createProperty('nested_list_menu', array());
		}
		array_push($this->parent->parent->nested_list_menu, $menu_script_for_app_footer);

		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}	
	/* ---------------------------------------------------------------------------------------- */	
	private function field_itinerary($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_ITINERARY din tab-ul '.get_class($this));
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_ITINERARY din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] : $default_value );
		if (empty($value)) {
			$value = "[]";
		}

		$REQUIRED = ''; 
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = $field['required_message'];
		}
		
		$ITINERARY_CONTENT = '';
		if (isset($field['class_method_for_content']) && (!empty($field['class_method_for_content']))) {
			if (method_exists($this,$field['class_method_for_content'])) {				
				$arr_items_content = $this->{$field['class_method_for_content']}($value);
				$sortable_content = ((isset($field['sortable']) && ($field['sortable']==true)) ? '<div class="col-md-1"><span class="btn btn-default swapper"><i class="glyphicon glyphicon-move"></i></span></div>' : '');
				foreach ($arr_items_content as $key => $value) {
					$ITINERARY_CONTENT .= '
							<div data-repeater-item class="row" class="sortable-item">
								'.$value.'
								<div class="col-md-1">
									<a href="javascript:;" data-repeater-delete class="btn btn-danger">
										<i class="fa fa-close"></i>
									</a>
								</div>
								'.$sortable_content.'
							</div>'.PHP_EOL;
				}
			} else {
				$current_class= get_class($this);
				throw new Exception('In clasa "'.$current_class.'" nu exista definita metoda mentionata in campul "class_method_for_content" la controlul de tip FIELD_TYPE_ITINERARY din tab-ul '.$current_class);
			}
		} else {
			throw new Exception('Specificati/Setati "class_method_for_content" in campul tip FIELD_TYPE_ITINERARY din tab-ul '.get_class($this));
		}

				
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}
					
		$PORTLET_BOX_START = ''; $PORTLET_BOX_END = '';
		if (isset($field['portlet_box']) && ($field['portlet_box']==true)) { 
			$PORTLET_BOX_START = '
                        <div class="portlet box '.(isset($field['portlet_color_scheme']) ? $field['portlet_color_scheme'] : '').'">
                            <div class="portlet-title">
                                <div class="caption">
                                    '.(isset($field['portlet_icon']) ? '<i class="'.$field['portlet_icon'].'"></i>' : '').(isset($field['portlet_title']) ? $field['portlet_title'] : '').' </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                    <!--<a href="#portlet-config" data-toggle="modal" class="config"> </a>-->
                                    <a href="javascript:;" class="reload"> </a>
                                    <!--<a href="javascript:;" class="remove"> </a>-->
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">'.PHP_EOL;
			$PORTLET_BOX_END = '
                                </div>
                            </div>
                        </div>'.PHP_EOL;
		}		
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		
		$field_str .= $PORTLET_BOX_START;
		$field_str .= '
			<div class="form-group">
			<label class="col-md-'.$this->label_size.' control-label">'.((isset($field['title']) && (!empty($field['title']))) ? $field['title'].':' : '').'
				'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			</label>
				<div class="col-md-9">													
					<div class="mt-repeater" store-control-name="'.$field['control_name'].'">
						<div class="row">'.$field['header'].'</div>
						<div data-repeater-list="fields" class="thumbnail-sortable-'.$field['control_name'].'" id="thumbnail-sortable-'.$field['control_name'].'">
							'.$ITINERARY_CONTENT.'
						</div>
						<hr>
						<a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add-'.$field['control_name'].'">
							<i class="fa fa-plus"></i> '.(isset($field['button_title']) ? $field['button_title'] : 'Add new item').'</a>
						<br>
						<br> 
					</div>													
				</div>
			  <div id="'.$field_name.'-itinerary-output" class="output-itinerary">
				<textarea oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class noafis '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : 'id="'.$field['control_name'].'"').' '.($field['required'] ? 'required=""' : '').'></textarea>
			  </div>				
			</div>'.PHP_EOL;
									
		$field_str .= $PORTLET_BOX_END;
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

		$menu_script_for_app_footer = '
			<script>
				$(function  () {
				  $("#thumbnail-sortable-'.$field['control_name'].'").sortable({ 
					handle: \'.swapper\',
					cursor: \'move\',
					update: function  () {
						cst_SerializeItinerary_'.$field['control_name'].'();
						}					
					});
				});  
				
				cst_SerializeItinerary_'.$field['control_name'].' = function() {					
					$(\'#'.((isset($field['control_id']) && (!empty($field['control_id']))) ? $field['control_id'] : $field['control_name']).'\').val(JSON.stringify($(\'#thumbnail-sortable-'.$field['control_name'].' :input:visible, #thumbnail-sortable-'.$field['control_name'].' :input:hidden\').serializeArray()));
				}
				$(\'body\').on("change","#thumbnail-sortable-'.$field['control_name'].' :input", function(e) {	  		
					cst_SerializeItinerary_'.$field['control_name'].'();
				});
				
				$(\'body\').on(\'DOMSubtreeModified\', "#thumbnail-sortable-'.$field['control_name'].'", function() {
					cst_SerializeItinerary_'.$field['control_name'].'();
				});	
				
			</script>'.PHP_EOL;
		if (!property_exists($this->parent->parent, 'itinerary_scripts')) {
			$this->parent->parent->createProperty('itinerary_scripts', array());
		}
		array_push($this->parent->parent->itinerary_scripts, $menu_script_for_app_footer);

        return $field_str;
	}	
	
	/* ---------------------------------------------------------------------------------------- */
	// cabins_price
	private function field_cabins_price($field, $result_line){
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_CABINS_PRICE din tab-ul '.get_class($this));
		} 
		if (!isset($field['db_field']) || empty($field['db_field'])) { 
			throw new Exception('Specificati "db_field" in campul tip FIELD_TYPE_CABINS_PRICE din tab-ul '.get_class($this));			
		} 

        $field_name    = $field['db_field']; 
        $default_value = (isset($field['value']) ? $field['value'] : '');
        $value         = (isset($result_line["$field_name"]) ? $result_line["$field_name"] : $default_value );
		if (empty($value)) {
			$value = "[]";
		}

		$REQUIRED = ''; 
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = $field['required_message'];
		}
		
		$CABINS_PRICES_CONTENT = '';
		if (isset($field['class_method_for_content']) && (!empty($field['class_method_for_content']))) {
			if (method_exists($this,$field['class_method_for_content'])) {				
				$arr_items_content = $this->{$field['class_method_for_content']}($value, $result_line);
				//$sortable_content = ((isset($field['sortable']) && ($field['sortable']==true)) ? '<div class="col-md-1"><span class="btn btn-default swapper"><i class="glyphicon glyphicon-move"></i></span></div>' : '<div class="col-md-1"></div>');
				foreach ($arr_items_content as $key => $value) {
					$CABINS_PRICES_CONTENT .= $value.PHP_EOL;
				}
			} else {
				$current_class= get_class($this);
				throw new Exception('In clasa "'.$current_class.'" nu exista definita metoda mentionata in campul "class_method_for_content" la controlul de tip FIELD_TYPE_CABINS_PRICE din tab-ul '.$current_class);
			}
		} else {
			throw new Exception('Specificati/Setati "class_method_for_content" in campul tip FIELD_TYPE_CABINS_PRICE din tab-ul '.get_class($this));
		}

				
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}

		$CONTROL_WIDTH_CLASS = '';
		if (isset($field['width'])) { 
			$CONTROL_WIDTH_CLASS = $field['width'];
		}
					
		$PORTLET_BOX_START = ''; $PORTLET_BOX_END = '';
		if (isset($field['portlet_box']) && ($field['portlet_box']==true)) { 
			$PORTLET_BOX_START = '
                        <div class="portlet box '.(isset($field['portlet_color_scheme']) ? $field['portlet_color_scheme'] : '').'">
                            <div class="portlet-title">
                                <div class="caption">
                                    '.(isset($field['portlet_icon']) ? '<i class="'.$field['portlet_icon'].'"></i>' : '').(isset($field['portlet_title']) ? $field['portlet_title'] : '').' </div>
                                <div class="tools">
									<i id="sort_date" class="fa fa-sort-numeric-asc cursor_pointer portlet_tools" aria-hidden="true"></i>&nbsp;&nbsp;
									<i id="toggle_price" class="fa fa-calendar-minus-o cursor_pointer portlet_tools" aria-hidden="true"></i>&nbsp;
									<!--<a href="#portlet-config" class="config"> </a>-->
                                    <a href="javascript:;" class="collapse"> </a>                                    
                                    <a href="javascript:;" class="reload"> </a>
                                    <!--<a href="javascript:;" class="remove"> </a>-->
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">'.PHP_EOL;
			$PORTLET_BOX_END = '
                                </div>
                            </div>
                        </div>'.PHP_EOL;
		}		
		
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}
		
		
		$field_str .= $PORTLET_BOX_START;
		$field_str .= '
			<div class="form-group">
			<label class="col-md-'.$this->label_size.' control-label">'.((isset($field['title']) && (!empty($field['title']))) ? $field['title'].':' : '').'
				'.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			</label>
				<div class="col-md-9">													
					<div class="mt-repeater" store-control-name="'.$field['control_name'].'">
						<div class="row">'.$field['header'].'</div>
						<div data-repeater-list="fields" class="thumbnail-sortable-'.$field['control_name'].'" id="thumbnail-sortable-'.$field['control_name'].'">
							'.$CABINS_PRICES_CONTENT.'
						</div>
						<hr>
						<a href="javascript:;" data-repeater-create class="btn btn-info add-new-date mt-repeater-add-'.$field['control_name'].'">
							<i class="fa fa-plus"></i> '.(isset($field['button_title']) ? $field['button_title'] : 'Add new item').'</a>
						<br>
						<br> 
					</div>													
				</div>
			  <div id="'.$field_name.'-itinerary-output" class="output-itinerary">
				<textarea oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_class noafis '.$CLASS_REQUIRED.'" name="'.$field['control_name'].'" '.(!empty($field['control_id']) ? 'id="'.$field['control_id'].'"' : 'id="'.$field['control_name'].'"').' '.($field['required'] ? 'required=""' : '').'></textarea>
			  </div>				
			</div>'.PHP_EOL;
									
		$field_str .= $PORTLET_BOX_END;
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

		$menu_script_for_app_footer = '
			<script>
				$(function  () {
				  $("#thumbnail-sortable-'.$field['control_name'].'").sortable({ 
					handle: \'.swapper\',
					cursor: \'move\',
					update: function  () {
						cst_SerializeItinerary_'.$field['control_name'].'();
						}					
					});
				});  
				$(function  () {
				  $(".thumbnail-sortable-aditional").sortable({ 
					handle: \'.swapper1\',
					cursor: \'move\',
					update: function  () {
						cst_SerializeItinerary_'.$field['control_name'].'();
						}					
					});
				});  
				
				cst_SerializeItinerary_'.$field['control_name'].' = function() {					
					//$(\'#'.((isset($field['control_id']) && (!empty($field['control_id']))) ? $field['control_id'] : $field['control_name']).'\').val(JSON.stringify($(\'#thumbnail-sortable-'.$field['control_name'].' :input:visible, #thumbnail-sortable-'.$field['control_name'].' :input:hidden\').serializeArray()));					
					//$(\'#'.((isset($field['control_id']) && (!empty($field['control_id']))) ? $field['control_id'] : $field['control_name']).'\').val(JSON.stringify($(\'#thumbnail-sortable-'.$field['control_name'].' :input:visible, #thumbnail-sortable-'.$field['control_name'].' :input:hidden\').map(function() { return { name: $(this).attr(\'name\'), value: this.value, code: $(this).attr(\'cab-id\') }}).get()));
					$(\'#'.((isset($field['control_id']) && (!empty($field['control_id']))) ? $field['control_id'] : $field['control_name']).'\').val(JSON.stringify($(\'#thumbnail-sortable-'.$field['control_name'].' .one-data-block :input:visible, #thumbnail-sortable-'.$field['control_name'].' .one-data-block :input:hidden\').map(function() { return { name: $(this).attr(\'name\'), value: this.value, code: $(this).attr(\'cab-id\') }}).get()));
				}
				$(\'body\').on("change","#thumbnail-sortable-'.$field['control_name'].' :input", function(e) {	  		
					cst_SerializeItinerary_'.$field['control_name'].'();
				});
				
				$(\'body\').on(\'DOMSubtreeModified\', "#thumbnail-sortable-'.$field['control_name'].'", function() {
					cst_SerializeItinerary_'.$field['control_name'].'();
				});	
				
			</script>'.PHP_EOL;
		if (!property_exists($this->parent->parent, 'itinerary_scripts')) {
			$this->parent->parent->createProperty('itinerary_scripts', array());
		}
		array_push($this->parent->parent->itinerary_scripts, $menu_script_for_app_footer);

        return $field_str;
	}		
	/* ---------------------------------------------------------------------------------------- */	
	private function field_box_multiselect_grouped_table($field, $result_line, $result_multiselect){
		global $oDB;
		$field_str = '';
		if (!isset($field['control_name']) || empty($field['control_name'])) { 
			throw new Exception('Specificati "control_name" in campul tip FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE din tab-ul '.get_class($this));
		} 

		if ((!isset($field['query']) || empty($field['query'])) && (!isset($field['method_to_return_custom_query']) || empty($field['method_to_return_custom_query']))) { 
			throw new Exception('Specificati "query" sau "method_to_return_custom_query" in campul tip FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE din tab-ul '.get_class($this));
		} 		
		if (!isset($field['db_field_value']) || empty($field['db_field_value'])) { 
			throw new Exception('Specificati "db_field_value" in campul tip FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE din tab-ul '.get_class($this));			
		} 
		if (!isset($field['db_field_title']) || empty($field['db_field_title'])) {
			throw new Exception('Specificati "db_field_title" in campul tip FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE din tab-ul '.get_class($this));
		} 
		if (!isset($field['db_field_categ']) || empty($field['db_field_categ'])) {
			throw new Exception('Specificati "db_field_categ" in campul tip FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE din tab-ul '.get_class($this));
		} 
		$arr_options_id=array();
		if ($result_multiselect) {
			$oDB->db_data_seek($result_multiselect,0);
			while ($result_line1 = $oDB->db_fetch_array($result_multiselect)) {
				if ($result_line1['id_archive']==$field['store_table_id_archive']) {
					array_push($arr_options_id, $result_line1['id_options'] );
				}
			}
		}

	    $db_field_value = $field['db_field_value']; 
		$db_field_name  = $field['db_field_title']; 
		$db_field_categ = $field['db_field_categ'];
		
		
		$query  = $field['query'];		
		if (empty($query)) {
			if (isset($field['method_to_return_custom_query']) && (!empty($field['method_to_return_custom_query']))) {
				if (method_exists($this,$field['method_to_return_custom_query'])) {
					$query = $this->{$field['method_to_return_custom_query']}($db_field_value, $db_field_name, $db_field_categ);
				}
			}						
		}
	    $result = $oDB->db_query($query);

	    $select_content = '';
		$categ_value    = '';
		$contor         = 0;
	    while ($result_line_table = $oDB->db_fetch_array($result)) {
	        $selected = '';			
        	if (in_array($result_line_table['id'], $arr_options_id)) { $selected = 'selected="selected"'; }
			if ($categ_value!=$result_line_table["$db_field_categ"]) {
				if ($contor!=0) { $select_content .= '</optgroup>'.PHP_EOL;}
				$select_content .= '<optgroup label="'.$result_line_table["$db_field_categ"].'">'.PHP_EOL;
				$categ_value     = $result_line_table["$db_field_categ"];
			}
			$select_content .= '<option '.$selected.' value="'.$result_line_table["$db_field_value"].'">'.$result_line_table["$db_field_name"].'</option>'.PHP_EOL; 
			$contor++;
	    }
		
		$REQUIRED = '';
		if (isset($field['required_message']) && (!empty($field['required_message']))) { 
			$REQUIRED = _($field['required_message']);
		}
		$CLASS_REQUIRED = ($field['required'] ? 'required2' : '');

		$COLUMN_SIZE = 12 - $this->label_size;
		if (isset($field['column_size']) && el_between($field['column_size'],2,$COLUMN_SIZE)) { 
			$COLUMN_SIZE = $field['column_size'];
		}
		$CONTROL_ID = (!empty($field['control_id']) ? $field['control_id'] : $field['control_name']);
		$HELP_MESSAGE = '';
		if (isset($field['help_message']) && (!empty($field['help_message']))) {
			$HELP_MESSAGE = '<span class="icon-question font-grey-silver custom-tooltip" data-toggle="tooltip" title="'.$field['help_message'].'"></span> ';
		}

		$field_str = '
	                                <div class="form-group">
			                            <label class="col-md-'.$this->label_size.' control-label">'._($field['title']).':
			                                '.$HELP_MESSAGE.($field['required'] ? '<span class="required"> * </span>' : '').'
			                            </label>
	                                    <div class="col-md-'.$COLUMN_SIZE.'">
													<select oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="multi-select el_class '.$CLASS_REQUIRED.'" id="'.$CONTROL_ID.'" name="'.$field['control_name'].'[]" multiple="multiple" '.($field['required'] ? 'required=""' : '').' '.($field['read_only'] ? 'disabled=""' : '').'>
                                                    <!--<select multiple="multiple" class="multi-select el_class" id="'.$CONTROL_ID.'" name="'.$field['control_name'].'[]">-->
														'.$select_content.'
                                                    </select>	                                        
	                                    </div>
	                                </div>'.PHP_EOL;
		
		$script_for_app_footer = '		
					$("#'.$CONTROL_ID.'").multiSelect({
						selectableOptgroup: !0
					})';
		
		if (!property_exists($this->parent->parent, 'boxed_multiselect_grouped_table')) {
			$this->parent->parent->createProperty('boxed_multiselect_grouped_table', array());
		}
		array_push($this->parent->parent->boxed_multiselect_grouped_table, $script_for_app_footer);
		
		
		if ($this->show_line_between_fields) {
			$field_str = $field_str.'<hr/>'.PHP_EOL;
		}

        return $field_str;
	}
		
	/* ---------------------------------------------------------------------------------------- */
	public function valid_fields($arr_fields, $id, $table_name, $ida, $idma=0){
		global $oDB;
		$ERROR = false;		
		
		if (!empty($idma)) { 
			$arr_fields = $this->RemoveControlFromTabFields($arr_fields);
		}
		if ($id==0) { 
			$arr_fields = $this->RemoveControlWithAtribute($arr_fields, $attr='hide_on_add', true);
		}
		
		
		/*****/
		
		foreach ($arr_fields as $field) {
			switch ($field['type']) {
				/* ................................................................... */
				case FIELD_TYPE_TEXT:
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						if (!$ERROR) {
							if (($field['input_type']=='email') && (!empty($POST_VALUE))) {
								$email_pattern = "/^[a-zA-Z0-9][a-zA-Z0-9\.-_]+\@([a-zA-Z0-9_-]+\.)+[a-zA-Z]+$/";
								if(!preg_match($email_pattern, $POST_VALUE)) { $ERROR=true;  $this->ERROR_MSG = _('Introduceti o adresa de e-mail valida !'); }
							}
						}
						if (!$ERROR) {
							if ((isset($field['unique'])) && ($field['unique']==true)) {
								$query  = "SELECT count(*) AS items_no FROM $table_name	WHERE id_archive=$ida AND $field_name='$POST_VALUE' ".(($id!=0) ? " AND id!=$id " : '');
								$result = $oDB->db_query($query);
								if ($result_line = $oDB->db_fetch_array($result)) {
									if ($result_line['items_no']!=0) {
										$ERROR=true;  $this->ERROR_MSG = _('<strong>'.$POST_VALUE.'</strong> exista deja in baza de date !');
									}
								}
							}
						}
						break;
				/* ................................................................... */
				case FIELD_TYPE_COLOR_PICKER:
						$field_name = $field['control_name'];						
						if ($id==0) {
							/* este adaugare */
							$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						break;								
				/* ................................................................... */
				case FIELD_TYPE_PASSWORD:
						$field_name = $field['control_name'];						
						if ($id==0) {
							/* este adaugare */
							$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						break;				
				/* ................................................................... */
				case FIELD_TYPE_TEXTAREA:				
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);												
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						break;
				/* ................................................................... */
				case FIELD_TYPE_EDITOR_CKEDITOR:
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);												
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						//$ERROR = true; $this->ERROR_MSG = 'pOST VALUE: '.$POST_VALUE;
						break;				
				/* ................................................................... */
				case FIELD_TYPE_DATE:
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);												
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						if (!$ERROR) {
							if (!empty($POST_VALUE)) {
								if ($field['date_format']=='dd-mm-yyyy') {
									if (!el_ValidRomanianDate($POST_VALUE)) {
										$ERROR=true;  $this->ERROR_MSG = _('Campul ['.$field['title'].'] nu este valid !');
									}
								}												
							}
						}
						break;
				/* ................................................................... */
				case FIELD_TYPE_DATETIME:
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);												
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						if (!$ERROR) {
							if (!empty($POST_VALUE)) {
									if (!el_ValidRomanianDateTime($POST_VALUE)) {
										$ERROR=true;  $this->ERROR_MSG = _('Campul ['.$field['title'].'] nu este valid !');
									}												
							}
						}
						break;									
				/* ................................................................... */
				case FIELD_TYPE_DATE_RANGE:
						$field_name1  = $field['control_name_1'];
						$field_name2  = $field['control_name_2'];
						$POST_VALUE_1 = addslashes(stripslashes($_POST["$field_name1"]));
						$POST_VALUE_2 = addslashes(stripslashes($_POST["$field_name2"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);
							if (empty($POST_VALUE_1) || empty($POST_VALUE_2)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						if (!$ERROR) {
							if (!empty($POST_VALUE_1)) {
								if ($field['date_format']=='dd-mm-yyyy') {
									if (!el_ValidRomanianDate($POST_VALUE_1)) {
										$ERROR=true;  $this->ERROR_MSG = _('In sectiunea ['.$field['title'].'] : data1 este invalida !');
									}
								}												
							}
						}
						if (!$ERROR) {
							if (!empty($POST_VALUE_2)) {
								if ($field['date_format']=='dd-mm-yyyy') {
									if (!el_ValidRomanianDate($POST_VALUE_2)) {
										$ERROR=true;  $this->ERROR_MSG = _('In sectiunea ['.$field['title'].'] : data2 este invalida !');
									}
								}												
							}											
						}
						if (!$ERROR) {
							if (el_RomanianDate_To_MysqlDate($POST_VALUE_1)>el_RomanianDate_To_MysqlDate($POST_VALUE_2)) {
								$ERROR=true;  $this->ERROR_MSG = _('Intervalul sectiunii ['.$field['title'].'] : nu este valid !');
							}
						}
						break;									
				/* ................................................................... */
				case FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM:
						$field_name = $field['control_name'];
						$POST_VALUE = $_POST["$field_name"];
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Selectati optiunea pentru campul "'.$field['title'].'" !' : $field['required_message']);
							if (strlen(trim($POST_VALUE))==0){
								 $ERROR = true; $this->ERROR_MSG = _($required_msg);
							}
						}
						break;
				/* ................................................................... */
				case FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS:
						$field_name = $field['control_name'];
						$POST_VALUE = $_POST["$field_name"];
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Selectati optiunea pentru campul "'.$field['title'].'" !' : $field['required_message']);
							if (strlen(trim($POST_VALUE))==0){
								 $ERROR = true; $this->ERROR_MSG = _($required_msg);
							}
						}
						break;									
				/* ................................................................... */
				case FIELD_TYPE_COMBO_BOOTSTRAP_TABLE:
						$field_name = $field['control_name'];
						$POST_VALUE = $_POST["$field_name"];
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Selectati optiunea pentru campul "'.$field['title'].'" !' : $field['required_message']);
							if (strlen(trim($POST_VALUE))==0){
								 $ERROR = true; $this->ERROR_MSG = _($required_msg);
							}
						}
						break;																		
				/* ................................................................... */
				case FIELD_TYPE_COMBO_WITH_SEARCH:
						$field_name = $field['control_name'];
						if (isset($_POST["$field_name"])) {							
							$POST_VALUE = $_POST["$field_name"];
							if ($field['required']) {
								$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Selectati optiunea pentru campul "'.$field['title'].'" !' : $field['required_message']);
								if (strlen(trim($POST_VALUE))==0){
									 $ERROR = true; $this->ERROR_MSG = _($required_msg);
								}
							}
						}
						break;																											
				/* ................................................................... */
				case FIELD_TYPE_COMBO_MULTISELECT:
						$field_name = $field['control_name'];
						if ($field['required']) {												
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Selectati optiunile pentru campul "'.$field['title'].'" !' : $field['required_message']);
							if (!isset($_POST["$field_name"])){
								 $ERROR = true; $this->ERROR_MSG = _($required_msg);
							}
						}
						break;																																				
				/* ................................................................... */
				case FIELD_TYPE_COMBO_SWITCH:
						$field_name = $field['control_name'];
						$POST_VALUE = $_POST["$field_name"];
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Selectati optiunea pentru campul "'.$field['title'].'" !' : $field['required_message']);
							if (strlen(trim($POST_VALUE))==0){
								 $ERROR = true; $this->ERROR_MSG = _($required_msg);
							}
						}						
						if (!$ERROR) {
							if (isset($field['attributes'])) {
								if (is_array($field['attributes'])) {
									foreach ($field['attributes'] as $row) {
										if ($row['value']==$POST_VALUE) {
											$arr_fields = $row['fields'];
											if (!$this->valid_fields($arr_fields, $id, $table_name, $ida, $idma)){
												$ERROR = true; $ERROR_MSG = _($this->ERROR_MSG);
											}										
											break;
										}
									}
								}
							}
						}
						break;																																				
				/* ................................................................... */
				case FIELD_TYPE_COMBO_INTERACTIVE:
						//$field_name = $field['control_name'];
						$field_name=$field['control_name'].'_1';
						$POST_VALUE = $_POST["$field_name"];
						if (strlen(trim($POST_VALUE))==0){
							/* .... */
							$all_title_combo = '';
							if (isset($field['categories'])) {
								if (is_array($field['categories'])) {
									$cnt = 0;
									foreach ($field['categories'] as $row) {
										$cnt++;
										$all_title_combo .= ($cnt>1 ? '/': '').$row['title'];
									}
								}
							}							
							/* .... */
							$ERROR = true; $this->ERROR_MSG = _('Atentie ! '.$all_title_combo.' in sectiunea "'.$field['title'].'" !');
						}						
						break;																															
				/* ................................................................... */
				case FIELD_TYPE_SELECT_IMAGE:				
						$field_name = $field['control_name'];						
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);												
							if (!isset($_FILES["$field_name"]['name'][0])) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						if (!$ERROR) {
							if (isset($_FILES["$field_name"]['name'][0])) {
								$POST_VALUE = $_FILES["$field_name"]['name'][0];
								if (!$ERROR) {
									$arr_allowed_extensions = array('jpg','jpeg','gif','png');
									$path_parts = pathinfo($POST_VALUE);
									$path_parts['extension'] = strtolower($path_parts['extension']);
									if (!in_array($path_parts['extension'], $arr_allowed_extensions)) {
										$ERROR = true; $this->ERROR_MSG = _('Pentru campul <strong>'.$field['title'].'</strong> sunt acceptate doar fisierele: .jpg, .jpeg, .gif, .png !');
									}							
								}
								if (!$ERROR) {
									if (!empty($POST_VALUE)) {
										$MAX_FILE_SIZE = (isset($field['max_file_size']) ? $field['max_file_size'] : 0);
										if ($MAX_FILE_SIZE>0) {
											if ($MAX_FILE_SIZE < round($_FILES["$field_name"]['size'][0]/1048576,2)) {
												$ERROR = true; $this->ERROR_MSG = _('Dimensiunea maxim admisa pentru <strong>'.$field['title'].'</strong> este '.$MAX_FILE_SIZE.'MB !');
											}
										}
									}
								}
							}
						}
						break;
				/* ................................................................... */
				case FIELD_TYPE_SELECT_FILE:
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);												
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}				
						break;
				/* ................................................................... */
				case FIELD_TYPE_TAGS_INPUT:				
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);												
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						break;				
				/* ................................................................... */
				case FIELD_TYPE_MENU:				
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						break;				
				/* ................................................................... */
				case FIELD_TYPE_ITINERARY:				
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Please set "'.$field['title'].'"' : $field['required_message']);
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
							if (trim($POST_VALUE)=='[]') { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
						}
						break;								
				/* ................................................................... */
				case FIELD_TYPE_CABINS_PRICE:				
						$field_name = $field['control_name'];
						$POST_VALUE = addslashes(stripslashes($_POST["$field_name"]));
						if ($field['required']) {
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Completati campul "'.$field['title'].'"' : $field['required_message']);
							if (empty($POST_VALUE)) { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
							if (trim($POST_VALUE)=='[]') { $ERROR = true; $this->ERROR_MSG = _($required_msg);}
							/* ----------- */														
							if (!$ERROR) {
								/* afiseaza eroare la date duplicat */
								$json_departures = stripslashes($POST_VALUE);
								if (!empty($json_departures)){
									$arr_unordered_departures = json_decode($json_departures, true);
									$arr_dates = array();
									foreach ($arr_unordered_departures as $key => $item) {
										if (isset($item['name'])) {
											if (el_string_contain_substring($item['name'], '[data_plec]')) {
												array_push($arr_dates, $item['value']);
											}
										}
									}
									/*****/
									if(count(array_unique($arr_dates))<count($arr_dates)) {
										// Array has duplicates
										$ERROR = true; $this->ERROR_MSG = _('The form contains duplicate dates!');
									}
								}
							}
							/* ----------- */
							
						}
						break;												
				/* ................................................................... */
				case FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE:
						$field_name = $field['control_name'];
						if ($field['required']) {												
							$required_msg = (((!isset($field['required_message'])) || (empty($field['required_message']))) ? 'Selectati optiunile pentru campul "'.$field['title'].'" !' : $field['required_message']);
							if (!isset($_POST["$field_name"])){
								 $ERROR = true; $this->ERROR_MSG = _($required_msg);
							}
						}
						break;																																				
				/* ................................................................... */
				
			}
			if ($ERROR) {break;}
		}		
		/*****/
		if ($this->count_generate_permalink_attr>1) {
			$ERROR = true; $this->ERROR_MSG = _('Intr-un TAB poate exista doar un singur atribut "generate_permalink_to_field" !');
		}
		
		return !$ERROR;
	}
	/* ---------------------------------------------------------------------------------------- */
	public function DisplaySideBarContent($result_line='') {
		$output = '';
		if ($this->edit_tab==true) {
			// este tab editare (nu este lista)
			if ($this->show_sidebar) {
				//if (!empty($result_line)) {
					/* .................................................. */
					ob_start();
					?>
						<!-- ...----------------------------------------------------- -->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-info-circle font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase"><?=$this->sidebar_title?></span>
                                    </div>
                                    <div class="tools">
                                        <a href="" class="collapse"> </a>
                                        <a href="" class="reload"> </a>
                                        <!--<a href="" class="remove"> </a>-->
                                    </div>
                                </div>
                                <div class="portlet-body">
									<?php
										$SideBar_content = '';
										$arr_fields = $this->fields;
										if (empty($result_line))      { $arr_fields = $this->RemoveControlWithAtribute($arr_fields, 'hide_on_add', true);}
										foreach ($arr_fields as $field) {
											 if (isset($field['show_in_sidebar']) && $field['show_in_sidebar']==true) {
												switch ($field['type']) {

													case FIELD_TYPE_TITLE:
															$SideBar_content .= $this->field_title($field); 
															break;
													case FIELD_TYPE_CUSTOM_CONTENT:
															$SideBar_content .= $this->field_custom_content($field); 
															break;															
													case FIELD_TYPE_INFO:
															$SideBar_content .= $this->field_info($field);
															break;
													case FIELD_TYPE_LINE_SEPARATOR:
															$SideBar_content .= $this->field_line_separator($field); 
															break;
													case FIELD_TYPE_TEXT:
															$SideBar_content .= $this->field_text($field, $result_line); 
															break;
													case FIELD_TYPE_HIDDEN:
															$tab_content .= $this->field_hidden($field, $result_line);
															break;																		
													case FIELD_TYPE_COLOR_PICKER:
															$SideBar_content .= $this->field_color_picker($field, $result_line); 
															break;															
													case FIELD_TYPE_PASSWORD:
															$SideBar_content .= $this->field_password($field, $result_line); 
															break;															
													case FIELD_TYPE_TEXTAREA:
															$SideBar_content .= $this->field_textarea($field, $result_line); 
															break;
													case FIELD_TYPE_CHECKBOX:
															$SideBar_content .= $this->field_checkbox($field, $result_line); 
															break;
													case FIELD_TYPE_DATE:
															$SideBar_content .= $this->field_date($field, $result_line); 
															break;
													case FIELD_TYPE_DATE_RANGE:
															$SideBar_content .= $this->field_date_range($field, $result_line); 
															break;	                                                                
													case FIELD_TYPE_DATETIME:
															$SideBar_content .= $this->field_datetime($field, $result_line); 
															break;	                                                                
													case FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM:
															$SideBar_content .= $this->field_combo_bootstrap_custom($field, $result_line); 
															break;
													case FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS:
															$SideBar_content .= $this->field_combo_custom_icons($field, $result_line); 
															break;
													case FIELD_TYPE_COMBO_BOOTSTRAP_TABLE:
															$SideBar_content .= $this->field_combo_bootstrap_table($field, $result_line); 
															break;
													case FIELD_TYPE_COMBO_WITH_SEARCH:
															$SideBar_content .= $this->field_combo_with_search($field, $result_line); 
															break;
													case FIELD_TYPE_COMBO_MULTISELECT:
															$SideBar_content .= $this->field_combo_multiselect($field, $result_line, $result_multiselect); 
															break;
													case FIELD_TYPE_COMBO_SWITCH:
															$SideBar_content .= $this->field_combo_switch($field, $result_line); 
															break;
													case FIELD_TYPE_COMBO_INTERACTIVE:
															$SideBar_content .= $this->field_combo_interactive($field, $result_line, ''); 
															break;
													case FIELD_TYPE_EDITOR_CKEDITOR:
															$SideBar_content .= $this->field_editor_ckeditor($field, $result_line); 
															break;
													case FIELD_TYPE_SELECT_IMAGE:
															$SideBar_content .= $this->field_select_image($field, $result_line); 
															break;													
													case FIELD_TYPE_SELECT_FILE:
															$SideBar_content .= $this->field_select_file($field, $result_line); 
															break;
													case FIELD_TYPE_TAGS_INPUT:
															$SideBar_content .= $this->field_tags_input($field, $result_line); 
															break;
													case FIELD_TYPE_MENU:
															$tab_content .= $this->field_menu($field, $result_line);
															break;
													case FIELD_TYPE_ITINERARY:
															$tab_content .= $this->field_itinerary($field, $result_line);
															break;	
													case FIELD_TYPE_CABINS_PRICE:
															$tab_content .= $this->field_cabins_price($field, $result_line);
															break;																
													case FIELD_TYPE_BOX_MULTISELECT_GROUPED_TABLE:
															$tab_content .= $this->field_box_multiselect_grouped_table($field, $result_line, $result_multiselect);
															break;
															
															
												}        	        
											 }
										}
										echo $SideBar_content;
									?>
									
									<div class="note note-warning">
										<!--<h4 class="block">Atentie</h4>-->
										<p>Campurile marcate cu * sunt obligatorii!</p>
									</div>									
									
                                </div>
                            </div>

						<!-- ...----------------------------------------------------- -->
					<?php
					$output = ob_get_clean();
					/* .................................................. */
				//} 
			}
		}
		return $output;
	}
	/* ---------------------------------------------------------------------------------------- */
	public function ReturnCustomFields() {	
		return '';
	}
	/* ---------------------------------------------------------------------------------------- */
	public function Hide($result_line='') {
		return false;
	}	
	/* ---------------------------------------------------------------------------------------- */
	public function RemoveControlFromTabFields($arr_fields, $db_field='idma') {
		
		$contor=0;
		foreach ($arr_fields as $field) {
			if (isset($field['db_field'])) {
				if ($field['db_field']==$db_field) {
					break;
				}
			}
			$contor++;
		}
		unset($arr_fields[$contor]);
		
		return $arr_fields;
		
	}
	/* ---------------------------------------------------------------------------------------- */
	public function RemoveControlWithAtribute($arr_fields, $attr='', $attr_value = true) {
		
		$contor=0;
		foreach ($arr_fields as $field) {
			if (isset($field["$attr"])) {
				if ($field["$attr"]==$attr_value) {
					unset($arr_fields[$contor]);
				}
			}
			$contor++;
		}				
		return $arr_fields;		
	}	
	/* ---------------------------------------------------------------------------------------- */
	public function SetTitleValueForDBField($db_field, $value) {
		foreach ($this->fields as $key => $field) {
			if (isset($field['db_field'])) {
				if ($field['db_field']==$db_field) {
					if (isset($field['title'])) {
						$this->fields[$key]['title'] = $value;
						break;
					}
				}
			}			
		}		
	}
	/* ---------------------------------------------------------------------------------------- */
}
