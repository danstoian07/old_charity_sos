<?php

class tab_menu_general extends tab {
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
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Index afisare',
                  'control_name'                       => 'display_index',
                  'input_type'                         => 'number',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',
                  'db_field'                           => 'display_index',
                  'value'                              => '0', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti indexul de afisare !',
                  'placeholder'                        => '',
                  'pattern'                            => '\d*',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
                       ),

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Nume inregistrare meniu',
                  'control_name'                       => 'name',
				  'input_type'                         => 'name',
				  'unique'							   => false,
                  'control_id'                         => '',                  
                  'db_field'                           => 'name',                  
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti numele inregistrarii din meniu',
                  'placeholder'                        => '',
                  'pattern'                            => '',
			      'column_size'                        => '',
			      'width'                        	   => 'font-bold',
		          'icon'                    		   =>  array(
	                                                             array (
	                                                              'class'              => 'fa fa-navicon',
	                                                              'type'       	     => '1',		 		
	                                                              'position'           => '0',           	
	                                                              'color'              => 'font-red',  			
	                                                             ),
		                                                    ),
                       ),
                 array (
                  'type'                               => FIELD_TYPE_SELECT_FILE,
                  'title'                              => 'Link',
                  'control_name'                       => 'link',
				  'input_type'                         => 'link',
				  'unique'							   => false,
                  'control_id'                         => '',                  
                  'db_field'                           => 'link',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti link-ul inregistrarii',
                  'placeholder'                        => '',
                  'pattern'                            => '',
			      'column_size'                        => '',
			      'width'                        	   => '',
		          'icon'                    		   =>  array(
	                                                             array (
	                                                              'class'              => 'fa fa-link',
	                                                              'type'       	       => '1',
	                                                              'color'              => 'font-red',  			
	                                                             ),				  
															),
                       ),
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'Target',
                  'control_name'                       => 'target',
                  'db_field'                           => 'target',
                  'control_id'                         => 'target',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati Target-ul',
                  'column_size'                        => '',
                  'width'                              => '',              /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '0', 'selected' => true, 'title' => 'Deschide link in aceeasi pagina', ),
                                                                   array ( 'value' =>  '1', 'selected' => false, 'title'  => 'Deschide link in alt tab', ),
                                                               ),
                        ),					   
					   
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => 'Tip meniu',
                  'control_name'                       => 'type',
                  'db_field'                           => 'type',
                  'control_id'                         => 'type',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul meniului',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '0',
																		   'title' 	  => 'Fara submeniu',
																		   'selected' => true, /* default selected */
                                                                           'fields'   => array( 
																							/* ----- */
																							/* ----- */
																							/* ----- */
                                                                                               
																						),
                                                                   ),
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '1', 
																		   'title'    => 'Cu submeniu pe o coloana',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																							 array (
																							  'type'                               => FIELD_TYPE_MENU,
																							  'title'                              => 'Submeniu',
																							  'control_name'                       => 'submenu_col_1',
																							  'control_id'                         => 'submenu_col_1',
																							  'db_field'                           => 'submenu_col_1',
																							  'maxnestedlevel'                     => 1, 					/* Max nested level: 0,1,2, ... */
																							  'value'                              => '', 
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti submeniul pe o coloana !',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),																							
																							/* ----- */
                                                                                               
																						),
                                                                   ),																   
																   /* ---------------------------------------------- */
																   /* ---------------------------------------------- */
																   /* ---------------------------------------------- */
                                                               ),
                  ),

				  

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}