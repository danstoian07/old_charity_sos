<?php

class tab_activitate_general extends tab {
	public  $show_sidebar             = true;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width            = 4;						/* no between 2 and 10 */								
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 
                  array (
                  'type'                               => FIELD_TYPE_DATETIME,
                  'title'                              => 'Adaugat',
                  'control_name'                       => 'date_add',
                  'control_id'                         => 'date_add',
                  'value'                              => '',
                  'read_only'                          => true,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => false,
                  'db_field'                           => 'date_add',
                  'required'                           => true,
                  'required_message'                   => 'Completati data adaugarii articolului !',
				  'placeholder'                        => 'zz-ll-yyyy hh:mm',
                  'column_size'                        => '9',                              /*1-10, default: 4*/
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'hide_on_add'                    	   => true,                             /* hide field for add operation */
                  ),                                                                                                                            
                  array (
                  'type'                               => FIELD_TYPE_DATETIME,
                  'title'                              => 'Ultima actualizare',
                  'control_name'                       => 'date_mod',
                  'control_id'                         => 'date_mod',
                  'value'                              => '',
                  'read_only'                          => true,				  
                  'can_select_date'                    => false,
                  'can_delete_date'                    => false,
                  'db_field'                           => 'date_mod',
                  'required'                           => false,
                  'required_message'                   => 'Completati adaugarii articolului !',
				  'placeholder'                        => 'zz-ll-yyyy hh:mm',
                  'column_size'                        => '9',                              /*1-10, default: 4*/
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'skip_update'                        => true,                             /* no update for this field */
				  'hide_on_add'                    	   => true,                             /* hide field for add operation */
                  ),                                                                                                                            
                  array (                  
                  'type'                               => FIELD_TYPE_CHECKBOX,
                  'title'                              => 'Notificare la actualiare',
                  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
                  'column_size'                        => '',
				  'help_message'                       => 'Daca e bifata optiunea, sistemul va trimite responsabililor de activitate un e-mai de instiintare, la actualizarea/modificarea informatiilor despre activitate',
				  'show_in_sidebar'                    => true,
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Trimite e-mail de informare avocatilor responsabili de activitate', 
                                                                      'control_name'                       => 'send_notification',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => true,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'send_notification',
                                                                  ),
                                                          ),
                  ),
		
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Denumire activitate',
				  'control_name'                       => 'name',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'name',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Completati denumirea activitatii',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'icon'                    		   =>  array(
																 array (
																  'class'              	=> 'fa fa-hourglass-3', 
																  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																  'position'            => '0',           	       		/* 0 - left, 1 - right  */
																  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																  ),
															),
					   ),
				  array (
				  'type'                               => FIELD_TYPE_COMBO_MULTISELECT,
				  'title'                              => 'Avocati responsabili',
				  'control_name'                       => 'combo_multiselect',
				  'control_id'                         => '',
				  'store_table'						   => 'multiselect_options',
				  'store_table_id_archive'			   => 200,
				  'query_table'                        => 'users',                         /* TABLE NAME without app table prefix */
				  'db_field_value'                     => 'id',
				  'db_field_title'                     => 'name',
				  'id_archive'                         => 10,
				  'order_by_field'                     => 'name',
				  'order_direction'                    => 'ASC',
				  'limit_items'                        => 1000,
				  'method_to_return_custom_query'      => 'avocati_dosar',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Selectati cel putin un avocat',
				  'column_size'                        => '',
				  'width'                              => '',
				   ),
					   
                  array (
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Prioritate',
                  'control_name'                       => 'id_prioritate',
                  'db_field'                           => 'id_prioritate',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati prioritatea activitatii',
                  'column_size'                        => '',
                  'width'                              => '',                                                                                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>   '', 'icon_class' => '', 'selected' => true,  'title' => 'Selectati prioritatea', ),
                                                                   array ( 'value' =>  '1', 'icon_class' => 'fa fa-battery-half font-gray', 'selected' => false, 'title' => 'Prioritate normala', ),
                                                                   array ( 'value' =>  '2', 'icon_class' => 'fa fa-battery-1 font-purple', 'selected' => false, 'title' => 'Prioritate scazuta', ),
                                                                   array ( 'value' =>  '3', 'icon_class' => 'fa fa-battery-full font-red', 'selected' => false, 'title' => 'Prioritate Mare', ),
                                                               ),
                        ),
					   
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Descriere',
                  'control_name'                       => 'descriere',
                  'control_id'                         => '',
                  'db_field'                           => 'descriere',                  
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Descrieti activitatea',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),

                  array (
                  'type'                               => FIELD_TYPE_DATETIME,
                  'title'                              => 'Data si ora scadenta',
                  'bottom_info'                        => 'Selecteaza Data',
                  'control_name'                       => 'data_scadenta',
                  'control_id'                         => '',
                  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
                  'value'                              => '',
                  'read_only'                          => true,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => true,
				  'disable_past_date'                  => true,
                  'db_field'                           => 'data_scadenta',
                  'required'                           => true,
                  'required_message'                   => 'Completati data scadenta !',
				  'placeholder'                        => 'zz-ll-yyyy',
                  'width'                              => '',                  
                  ),
				  
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'Reminder avocati responsabili',
                  'control_name'                       => 'reminder_days_before',
                  'db_field'                           => 'reminder_days_before',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Selectati reminder-ul',
                  'column_size'                        => '',
                  'width'                              => '',                                                                                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>   '',  'selected' => true,  'title'   => 'Setati un reminder', ),
                                                                   array ( 'value' =>  '1',  'selected' => false, 'title'   => 'Anunta cu 1 ora inainte', ),
																   array ( 'value' =>  '2',  'selected' => false, 'title'   => 'Anunta cu 2 ore inainte', ),
																   array ( 'value' =>  '3',  'selected' => false, 'title'   => 'Anunta cu 3 ore inainte', ),
																   array ( 'value' =>  '4',  'selected' => false, 'title'   => 'Anunta cu 4 ore inainte', ),
																   array ( 'value' =>  '5',  'selected' => false, 'title'   => 'Anunta cu 5 ore inainte', ),
																   array ( 'value' =>  '6',  'selected' => false, 'title'   => 'Anunta cu 6 ore inainte', ),
																   array ( 'value' =>  '7',  'selected' => false, 'title'   => 'Anunta cu 7 ore inainte', ),
																   array ( 'value' =>  '8',  'selected' => false, 'title'   => 'Anunta cu 8 ore inainte', ),
																   array ( 'value' =>  '9',  'selected' => false, 'title'   => 'Anunta cu 9 ore inainte', ),
																   array ( 'value' =>  '10', 'selected' => false, 'title'  => 'Anunta cu 10 ore inainte', ),
                                                                   array ( 'value' =>  '11', 'selected' => false, 'title'  => 'Anunta cu 1 zi inainte', ),
																   array ( 'value' =>  '12', 'selected' => false, 'title'  => 'Anunta cu 2 zile inainte', ),
																   array ( 'value' =>  '13', 'selected' => false, 'title'  => 'Anunta cu 3 zile inainte', ),
																   array ( 'value' =>  '14', 'selected' => false, 'title'  => 'Anunta cu 4 zile inainte', ),
																   array ( 'value' =>  '15', 'selected' => false, 'title'  => 'Anunta cu 5 zile inainte', ),
																   array ( 'value' =>  '16', 'selected' => false, 'title'  => 'Anunta cu 6 zile inainte', ),
																   array ( 'value' =>  '17', 'selected' => false, 'title'  => 'Anunta cu 7 zile inainte', ),
																   array ( 'value' =>  '18', 'selected' => false, 'title'  => 'Anunta cu 8 zile inainte', ),
																   array ( 'value' =>  '19', 'selected' => false, 'title'  => 'Anunta cu 9 zile inainte', ),
																   array ( 'value' =>  '20', 'selected' => false, 'title'  => 'Anunta cu 10 zile inainte', ),
                                                               ),
                        ),
				  
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => 'Status activitate',
                  'control_name'                       => 'id_status',
                  'db_field'                           => 'id_status',
                  'control_id'                         => 'id_status',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati status activitate',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '1',
																		   'title' 	  => 'In curs de finalizare',
																		   'selected' => true, /* default selected */
                                                                           'fields'   => array( 
																							/* ======================================================================================= */																								   
																							/* ======================================================================================= */
                                                                                               
																						),
                                                                   ),
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '2', 
																		   'title'    => 'Finalizata',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* xxx ======================================================================================= */
																							  array (
																							  'type'                               => FIELD_TYPE_DATE,
																							  'title'                              => 'Data finalizarii',
																							  'bottom_info'                        => 'Selecteaza Data',
																							  'control_name'                       => 'data_efectuarii',
																							  'control_id'                         => '',
																							  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
																							  'value'                              => '',
																							  'read_only'                          => false,
																							  'can_select_date'                    => true,
																							  'can_delete_date'                    => true,
																							  'db_field'                           => 'data_efectuarii',
																							  'required'                           => false,
																							  'required_message'                   => 'Completati data finalizarii !',
																							  'placeholder'                        => 'zz-ll-yyyy',
																							  'width'                              => '',                  
																							  ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Ore lucrate',
																							  'control_name'                       => 'ore_lucrate',
																							  'input_type'                         => 'number',				/* can be html input type: text, email, etc*/
																							  'other_attribs'                  	   => 'step="0.1" max="10000" min="0"',
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'ore_lucrate',
																							  'value'                              => '', 
																							  'maxlength'                          => '6',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => '',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */																							  
																								   ),
																							  
                                                                                            /* xxx======================================================================================= */   
																						),
                                                                   ),
																   
																   /* ---------------------------------------------- */																   
                                                               ),
                  ),

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
	public function avocati_dosar($a='', $b='', $c='') {
		global $oDB;
		$id_dosar = el_decript_info($_REQUEST['idma']);
		$query ="SELECT id_options FROM $oDB->multiselect_options WHERE id_archive=20 AND id_main_item=$id_dosar";
		$result = $oDB->db_query($query);
		$i=0;
		$list_ids = '';
		while ($result_line = $oDB->db_fetch_array($result)) {
			$list_ids .= ($i>0 ? ',' : '').$result_line['id_options'];
			$i++;
		}
		if (!empty($list_ids)) {
			$ret_query = "SELECT id, name FROM $oDB->users WHERE id IN ($list_ids) ORDER BY name ASC";
		} else {
			$ret_query = 'SELECT id, name FROM $oDB->users WHERE id=-1 ORDER BY name ASC';
		}
		
		return $ret_query;
	}
	/* ------------------------------------------------------------------------------------- */
}