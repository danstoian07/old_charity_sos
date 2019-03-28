<?php

class tab_demo00 extends tab {
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array(
                  array (
                  'type'                               => FIELD_TYPE_COMBO_MULTISELECT,
                  'title'                              => 'Combo with multiselect value',
                  'control_name'                       => 'combo_multiselect',
                  'control_id'                         => '',
				  'store_table'						   => 'multiselect_options',
				  'store_table_id_archive'			   => 10,
                  'query_table'                        => 'country',                         /* TABLE NAME without app table prefix */
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 0,
                  'order_by_field'                     => 'title',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 1000,
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Selectati macar o tara in multiselect',
                  'column_size'                        => '',
                  'width'                              => '',
                   ),

                 array (
                  'type'                               => FIELD_TYPE_LINE_SEPARATOR,
                  'thickness'                          => 2,                                /* Default 1*/
                  'margin'                             => 20,                               /* Margin in px: Default 20*/
                  ),
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => 'Combo switch 1',
                  'control_name'                       => 'combo_test_switch',
                  'db_field'                           => 'combo_test_switch',
                  'control_id'                         => 'combo_test_switch',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul switch',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '0',
																		   'title' 	  => 'Valoare 0',
																		   'selected' => true, /* default selected */
                                                                           'fields'   => array( 
																							/* ----- */
                                                                                            array (
                                                                                             'type'                               => FIELD_TYPE_TEXT,
                                                                                             'title'                              => 'E-mail',
                                                                                             'control_name'                       => 'text_test1',
                                                                                             'control_id'                         => '',
                                                                                             'input_type'                         => 'email',
                                                                                             'db_field'                           => 'text_test1',                  
                                                                                             'value'                              => '', 
                                                                                             'maxlength'                          => '100',
                                                                                             'read_only'                          => false,
                                                                                             'required'                           => true,
                                                                                             'required_message'                   => 'Introduceti o adresa de e-mail valida',
                                                                                             'placeholder'                        => '',
                                                                                             'pattern'                            => '',
                                                                                             'column_size'                        => '',
                                                                                             'width'                              => '',
                                                                                             'icon'                               =>  array(
                                                                                                                                           array (
                                                                                                                                            'class'              => 'fa fa-envelope', 
                                                                                                                                            'type'               => '1',            
                                                                                                                                            'position'           => '0',            
                                                                                                                                            'color'              => '',          
                                                                                                                                            ),
                                                                                                                                     ),
                                                                                                ),
																								/* ----- */
                                                                                               array (
                                                                                                'type'                               => FIELD_TYPE_TEXTAREA,
                                                                                                'title'                              => 'Detalii avocat',
                                                                                                'control_name'                       => 'text_test2',
                                                                                                'control_id'                         => '',
                                                                                                'db_field'                           => 'text_test2',                  
                                                                                                'value'                              => '', 
                                                                                                'maxlength'                          => '25',
                                                                                                'read_only'                          => false,
                                                                                                'required'                           => true,
                                                                                                'required_message'                   => 'Completati detaliile avocatului',
                                                                                                'placeholder'                        => '',
                                                                                                'column_size'                        => '',
                                                                                                'width'                              => '',        
                                                                                                'rows'                               => '4',
                                                                                                ),
																								/* ----- */
                                                                                               
																						),
                                                                   ),
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '1', 
																		   'title'    => 'Valoare 1',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																							  array (
																							  'type'                               => FIELD_TYPE_DATE,
																							  'title'                              => 'Date Picker',
																							  'bottom_info'                        => 'Selecteaza Data',
																							  'control_name'                       => 'date_test11',
																							  'control_id'                         => '',
																							  'date_format'                        => 'dd-mm-yyyy',                  
																							  'value'                              => '',
																							  'read_only'                          => true,
																							  'can_select_date'                    => true,
																							  'can_delete_date'                    => true,
																							  'db_field'                           => 'date_test11',
																							  'required'                           => true,
																							  'required_message'                   => 'Completati data articolului xxx!',
																							  'width'                              => '',                  
																							  ),                                                                                                                            
																							
																							/* ----- */
																							  array (
																							  'type'                               => FIELD_TYPE_DATETIME,
																							  'title'                              => 'DateTime Picker',
																							  'control_name'                       => 'datetime_test11',
																							  'control_id'                         => '',
																							  'value'                              => '',
																							  'read_only'                          => true,
																							  'can_select_date'                    => true,
																							  'can_delete_date'                    => true,
																							  'db_field'                           => 'datetime_test11',
																							  'required'                           => true,
																							  'required_message'                   => 'Completati datatimp articolului yyy!',
																							  'column_size'                        => '3',                              /*1-10, default: 4*/
																							  ),
																							/* ----- */
                                                                                               
																						),
                                                                   ),
																   
																   /* ---------------------------------------------- */																   
                                                               ),
                  ),
                 array (
                  'type'                               => FIELD_TYPE_LINE_SEPARATOR,
                  'thickness'                          => 2,                                /* Default 1*/
                  'margin'                             => 20,                               /* Margin in px: Default 20*/
                  ),
		
				 array (
				  'title'                              => 'Combouri interactive',
				  'control_name'                       => 'categ_art',                                      
				  'type'                               => FIELD_TYPE_COMBO_INTERACTIVE,                
				  'db_field'                           => 'id_categ', 
				  'column_size'                        => '',			         		/* number between 2 and 10. Empty for default:10 */
				  'width'                              => '',							/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'categories'                         => array(
																 array (
																	  'title'                              => 'Selectati Continentul',      
																	  'read_only'                          => false,                        
																	  'query_table'                        => 'continents',         		/* TABLE NAME without app table prefix */
																	  'db_field_value'                     => 'id',                         /* campul din care va fi preluat id-ul */
																	  'db_field_title'                     => 'name',                      /* campul din care va fi preluata denumirea */
																	  'db_field_filter'                    => 'id_categ',                   /* campul dupa care se face filtrarea */
																	  'id_archive'                         => 0,                           /* id archive */
																	  'order_by_field'                     => 'title',
																	  'order_direction'                    => 'ASC',
																	  'limit_items'                        => 1000,																	  
																  ),
																 array (
																	  'title'                              => 'Selectati tara',
																	  'read_only'                          => false,
																	  'query_table'                        => 'country',
																	  'db_field_value'                     => 'id',
																	  'db_field_title'                     => 'name',
																	  'db_field_filter'                    => 'id_categ',
																	  'id_archive'                         => 0,
																	  'order_by_field'                     => 'title',
																	  'order_direction'                    => 'ASC',
																	  'limit_items'                        => 1000,
																	  'width'                              => '',
																  ),                                                                                                              
																 array (
																	  'title'                              => 'Selectati judetul',
																	  'read_only'                          => false,
																	  'query_table'                        => 'judete',
																	  'db_field_value'                     => 'id',
																	  'db_field_title'                     => 'name',
																	  'db_field_filter'                    => 'id_categ',
																	  'id_archive'                         => 0,
																	  'order_by_field'                     => 'title',
																	  'order_direction'                    => 'ASC',																	  
																	  'limit_items'                        => 1000,
																	  'width'                              => '',
																  ),                                                                                                              
																  
														  ),
				 ),                                                              
		
                  array (                  
                  'type'                               => FIELD_TYPE_CHECKBOX,
                  'title'                              => 'Check box-uri Outline',
                  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
                  'column_size'                        => '',
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Acesta este checkbox 1', 
                                                                      'control_name'                       => 'check_test_1',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => false,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'check_test_1',
                                                                  ),                                                                 
                                                                 array (
                                                                      'title'                              => 'Acesta este un alt checkbox',
                                                                      'control_name'                       => 'check_test_2',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => false,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'check_test_2',
                                                                  ),
                                                          ),
                  ),
		
                  array (
                  'type'                               => FIELD_TYPE_DATE_RANGE,
                  'title'                              => 'Date Range Picker',
                  'bottom_info'                        => 'Selecteaza Data',
                  'required'                           => true,
                  'read_only'                          => false,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => true,
                  'date_format'                        => 'dd-mm-yyyy',						/* can be only dd-mm-yyyy */
                  'required_message'                   => 'Completati data articolului !',

                  'control_name_1'                     => 'data_r1',
                  'control_id_1'                       => '',
                  'value_1'                            => '',
                  'db_field_1'                         => 'date_test_r1',
                  'value_1'                            => '',

                  'control_name_2'                     => 'data_r2',
                  'control_id_2'                       => '',
                  'value_2'                            => '',
                  'db_field_2'                         => 'date_test_r2',
                  'value_2'                            => '',
                  ),
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_WITH_SEARCH,
                  'title'                              => 'Combo with Search',
                  'control_name'                       => 'combo_test_src',
				  'db_field'                           => 'combo_test_src',
                  'control_id'                         => '',
                  'query_table'                        => 'country',                         /* TABLE NAME without app table prefix */
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 0,
                  'order_by_field'                     => 'title',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 1000,
                  'first_line_message'                 => 'Selecteaza o tara',              /* Leave empty for: without select message */
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati o tara in combo search',
                  'column_size'                        => '',
                  'width'                              => '',
                        ),
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_TABLE,
                  'title'                              => 'Combo Bootstrap from table',
                  'control_name'                       => 'combo_test_bt',
				  'db_field'                           => 'combo_test_bt',
                  'control_id'                         => '',				  
                  'query_table'                        => 'country',                         /* TABLE NAME without app table prefix */
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 0,
                  'order_by_field'                     => 'title',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 1000,
                  'first_line_message'                 => 'Selecteaza o tara',              /* Leave empty for: without select message */
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati o tara',
                  'column_size'                        => '',
                  'width'                              => '',
                        ),
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Combo  custom with Fontawesome icons',
                  'control_name'                       => 'combo_test_icons',
                  'db_field'                           => 'combo_test_icons',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati optiunea combo cu icons',
                  'column_size'                        => '',
                  'width'                              => '',                                                                                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>   '', 'icon_class' => '', 'selected' => true,  'title' => 'Selecteaza optiunea', ),
                                                                   array ( 'value' =>  '0', 'icon_class' => 'fa-user font-red', 'selected' => false, 'title' => 'Valoare 0', ),
                                                                   array ( 'value' =>  '1', 'icon_class' => 'fa-film font-purple', 'selected' => false, 'title' => 'Valoare 1', ),
                                                                   array ( 'value' =>  '2', 'icon_class' => 'fa-home', 'selected' => false, 'title' => 'Valoare 2', ),
                                                                   array ( 'value' =>  '3', 'icon_class' => 'fa-user', 'selected' => false, 'title' => 'Valoare 3', ),
                                                               ),
                        ),
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'Combo  Bootstrap custom',
                  'control_name'                       => 'combo_test_bc',
                  'db_field'                           => 'combo_test_bc',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati optiunea pentru acest combo',
                  'column_size'                        => '',
                  'width'                              => '',              /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '',  'selected' => true,  'title' => 'Selecteaza optiunea', ),
                                                                   array ( 'value' =>  '0', 'selected' => false, 'title' => 'Valoare 0', ),
                                                                   array ( 'value' =>  '1', 'selected' => false, 'title' => 'Valoare 1', ),
                                                                   array ( 'value' =>  '2', 'selected' => false, 'title' => 'Valoare 2', ),
                                                                   array ( 'value' =>  '3', 'selected' => false, 'title' => 'Valoare 3', ),
                                                               ),
                        ),
		
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Nume',
                  'control_name'                       => 'name',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'name',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti numele avocatului !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
		          'icon'                    		   =>  array(
	                                                             array (
	                                                              'class'              	=> 'fa fa-user', 
	                                                              'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
	                                                              'position'            => '0',           	       /* 0 - left, 1 - right  */
	                                                              'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
	                                                              ),
		                                                    ),
                       ),

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'E-mail',
                  'control_name'                       => 'email',
				  'input_type'                         => 'email',
				  'unique'							   => true,
                  'control_id'                         => '',                  
                  'db_field'                           => 'email',                  
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti o adresa de e-mail valida',
                  'placeholder'                        => '',
                  'pattern'                            => '',
			      'column_size'                        => '',
			      'width'                        	   => '',
		          'icon'                    		   =>  array(
	                                                             array (
	                                                              'class'              => 'fa fa-envelope', 
	                                                              'type'       	     => '1',		 		
	                                                              'position'           => '0',           	
	                                                              'color'              => '',  			
	                                                             ),
		                                                    ),
                       ),

                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Detalii',
                  'control_name'                       => 'test1',
                  'control_id'                         => '',
                  'db_field'                           => 'test1',                  
                  'value'                              => '', 
                  'maxlength'                          => '25',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Completati detaliile avocatului',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),
                  array (
                  'type'                               => FIELD_TYPE_DATE,
                  'title'                              => 'Date Picker',
                  'bottom_info'                        => 'Selecteaza Data',
                  'control_name'                       => 'date_test1',
                  'control_id'                         => '',
                  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
                  'value'                              => '',
                  'read_only'                          => false,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => true,
                  'db_field'                           => 'date_test1',
                  'required'                           => true,
                  'required_message'                   => 'Completati data articolului !',
				  'placeholder'                        => 'zz-ll-yyyy',
                  'width'                              => '',                  
                  ),                                                                                                                            
                  array (
                  'type'                               => FIELD_TYPE_DATETIME,
                  'title'                              => 'DateTime Picker',
                  'control_name'                       => 'datetime_test1',
                  'control_id'                         => '',
                  'value'                              => '',
                  'read_only'                          => false,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => true,
                  'db_field'                           => 'datetime_test1',
                  'required'                           => true,
                  'required_message'                   => 'Completati datetime pentru articol !',
				  'placeholder'                        => 'zz-ll-yyyy hh:mm',
                  'column_size'                        => '3',                              /*1-10, default: 4*/
                  ),                                                                                                                            

                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'Titlu sectiune',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'icon-social-dribbble',
                  'bold'                               => true,
                  ),
				  


	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);		

	}	
	/* ------------------------------------------------------------------------------------- */	
}