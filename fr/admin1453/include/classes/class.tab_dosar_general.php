<?php

class tab_dosar_general extends tab {
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
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Status dosar',
                  'control_name'                       => 'status',
                  'db_field'                           => 'status',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati status dosar',
                  'column_size'                        => '',
                  'width'                              => '',                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '0', 'icon_class' => '', 'selected' => false, 'title' => 'Dosar in lucru', ),
                                                                   array ( 'value' =>  '1', 'icon_class' => '', 'selected' => false, 'title' => 'Dosar suspendat', ),
																   array ( 'value' =>  '2', 'icon_class' => '', 'selected' => false, 'title' => 'Dosar finalizat', ),
                                                               ),
                        ),
				  
				  array (
				  'type'                               => FIELD_TYPE_COMBO_WITH_SEARCH,
				  'title'                              => 'Numar contract',
				  'control_name'                       => 'id_ctr',
				  'db_field'                           => 'idma',
				  'control_id'                         => '',
				  'query_table'                        => 'contracts',                         /* TABLE NAME without app table prefix */
				  'db_field_value'                     => 'id',
				  'db_field_title'                     => 'contract_no',
				  'query'              				   => 'SELECT el_contracts.id, CONCAT(el_contracts.contract_no," | ", DATE_FORMAT(el_contracts.contract_data,"%d-%m-%Y"), " | ", el_clients.name) AS title FROM el_contracts LEFT JOIN el_clients ON el_clients.id=el_contracts.idma WHERE el_contracts.id_archive=0 LIMIT 100000',
				  'id_archive'                         => 0,
				  'order_by_field'                     => 'contract_no',
				  'order_direction'                    => 'ASC',
				  'limit_items'                        => 1000,
				  'first_line_message'                 => 'Selectati nr. contact',              /* Leave empty for: without select message */
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Selectati un numar de contract',
				  'column_size'                        => '',
				  'width'                              => '',
						),
				  
				  array (
				  'type'                               => FIELD_TYPE_COMBO_MULTISELECT,
				  'title'                              => 'Avocati responsabili',
				  'control_name'                       => 'combo_multiselect',
				  'control_id'                         => '',
				  'store_table'						   => 'multiselect_options',
				  'store_table_id_archive'			   => 20,
				  'query_table'                        => 'users',                         
				  'db_field_value'                     => 'id',
				  'db_field_title'                     => 'name',
				  'id_archive'                         => 10,
				  'order_by_field'                     => 'name',
				  'order_direction'                    => 'ASC',
				  'limit_items'                        => 1000,
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Selectati cel putin un avocat',
				  'column_size'                        => '',
				  'width'                              => '',
				   ),
				  
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => 'Tip Dosar',
                  'control_name'                       => 'type',
                  'db_field'                           => 'type',
                  'control_id'                         => 'type',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul dosarului',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '0',
																		   'title' 	  => 'Dosar de instanta civil',
																		   'selected' => true, /* default selected */
                                                                           'fields'   => array( 
																							/* =================================================================================================== */																																														
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Numar dosar',
																							  'control_name'                       => 'nr_dosar',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'nr_dosar',													
																							  'db_field'                           => 'nr_dosar',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Introduceti numarul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																							  'icon'                    		   =>  array(
																																			 array (
																																			  'class'              	=> 'fa fa-folder-open-o', 
																																			  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																																			  'position'            => '0',           	       /* 0 - left, 1 - right  */
																																			  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																																			  ),
																																		),
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_LOADING_BUTTON,
																							  'title'                              => 'Incarcare date',
																							  'control_id'                         => 'id_ecris',
																							  'value'                              => 'Incarca date din ECRIS', 
																							  'read_only'                          => false,																							  
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => 'load_from_ecris',	 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																							  'static_icon_class'              	   => 'fa fa-refresh',
																							  'dinamic_icon_class'            	   => 'fa fa-cog',
																							  'javascript_function'            	   => 'cst_LoadFromEcris(this)',
																							  
																								   ),
																								   
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Obiect',
																							  'control_name'                       => 'obiect',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'obiect',													
																							  'db_field'                           => 'obiect',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti obiectul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),

																							  array (
																							  'type'                               => FIELD_TYPE_DATE,
																							  'title'                              => 'Date inregistrari la tribunal',
																							  'bottom_info'                        => 'Selecteaza Data',
																							  'control_name'                       => 'date_reg_tribunal',
																							  'control_id'                         => 'date_reg_tribunal',
																							  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
																							  'value'                              => '',
																							  'read_only'                          => false,
																							  'can_select_date'                    => true,
																							  'can_delete_date'                    => true,
																							  'db_field'                           => 'date_reg_tribunal',
																							  'required'                           => true,
																							  'required_message'                   => 'Completati data inregistrarii la tribunal !',
																							  'placeholder'                        => 'zz-ll-yyyy',
																							  'width'                              => '',                  
																							  ),                                                                                                                            
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Materie juridica',
																							  'control_name'                       => 'materie_juridica',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'materie_juridica',													
																							  'db_field'                           => 'materie_juridica',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Introduceti materia juridica !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							  
																								/*
																							  array (
																							  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_TABLE,
																							  'title'                              => 'Stadiu procesual',
																							  'control_name'                       => 'stadiu_procesual',
																							  'db_field'                           => 'id_stadiu_procesual',
																							  'control_id'                         => '',				  
																							  'query_table'                        => 'stadii_procesuale',                         
																							  'db_field_value'                     => 'id',
																							  'db_field_title'                     => 'name',
																							  'id_archive'                         => 0,
																							  'order_by_field'                     => 'name',
																							  'order_direction'                    => 'ASC',
																							  'limit_items'                        => 1000,
																							  'first_line_message'                 => 'Selectati stadiul procesual',              
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Selectati stadiul procesual',
																							  'column_size'                        => '',
																							  'width'                              => '',
																									),
																									*/
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Stadiu procesual',
																							  'control_name'                       => 'stadiu_procesual',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'stadiu_procesual',													
																							  'db_field'                           => 'stadiu_procesual',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti instanta !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																									
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Instanta',
																							  'control_name'                       => 'instanta',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'instanta',													
																							  'db_field'                           => 'instanta',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti instanta !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																									
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Sectie',
																							  'control_name'                       => 'sectie',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'sectie',													
																							  'db_field'                           => 'sectie',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti sectia !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																									
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Complet judecata',
																							  'control_name'                       => 'complet_judecata',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'complet_judecata',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti completul de judecata !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Sala judecata',
																							  'control_name'                       => 'sala_judecata',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'sala_judecata',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Specificati sala de judecata !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																									
																							/* =================================================================================================== */
                                                                                               
																						),
                                                                   ),
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '1', 
																		   'title'    => 'Dosar de instanta penal',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ===================================================================================================== */
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Numar dosar',
																							  'control_name'                       => 'nr_dosar_1',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'nr_dosar_1',													
																							  'db_field'                           => 'nr_dosar_1',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Introduceti numarul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																							  'icon'                    		   =>  array(
																																			 array (
																																			  'class'              	=> 'fa fa-folder-open-o', 
																																			  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																																			  'position'            => '0',           	       /* 0 - left, 1 - right  */
																																			  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																																			  ),
																																		),
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_LOADING_BUTTON,
																							  'title'                              => 'Incarcare date',
																							  'control_id'                         => 'id_ecris2',
																							  'value'                              => 'Incarca date din ECRIS', 
																							  'read_only'                          => false,																							  
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => 'load_from_ecris',	 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																							  'static_icon_class'              	   => 'fa fa-refresh',
																							  'dinamic_icon_class'            	   => 'fa fa-cog',
																							  'javascript_function'            	   => 'cst_LoadFromEcris2(this)',
																							  
																								   ),
																								   
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Obiect',
																							  'control_name'                       => 'obiect_1',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'obiect_1',													
																							  'db_field'                           => 'obiect_1',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti obiectul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),

																							  array (
																							  'type'                               => FIELD_TYPE_DATE,
																							  'title'                              => 'Date inregistrari la tribunal',
																							  'bottom_info'                        => 'Selecteaza Data',
																							  'control_name'                       => 'date_reg_tribunal_1',
																							  'control_id'                         => 'date_reg_tribunal_1',
																							  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
																							  'value'                              => '',
																							  'read_only'                          => false,
																							  'can_select_date'                    => true,
																							  'can_delete_date'                    => true,
																							  'db_field'                           => 'date_reg_tribunal_1',
																							  'required'                           => true,
																							  'required_message'                   => 'Completati data inregistrarii la tribunal !',
																							  'placeholder'                        => 'zz-ll-yyyy',
																							  'width'                              => '',                  
																							  ),                                                                                                                            
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Materie juridica',
																							  'control_name'                       => 'materie_juridica_1',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'materie_juridica_1',													
																							  'db_field'                           => 'materie_juridica_1',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Introduceti materia juridica !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Stadiu procesual',
																							  'control_name'                       => 'stadiu_procesual_1',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'stadiu_procesual_1',													
																							  'db_field'                           => 'stadiu_procesual_1',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti stadiul procesual !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),

																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Sectie',
																							  'control_name'                       => 'sectie_1',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'sectie_1',													
																							  'db_field'                           => 'sectie_1',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti sectia !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																									
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Complet judecata',
																							  'control_name'                       => 'complet_judecata_1',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'complet_judecata_1',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti completul de judecata !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Sala judecata',
																							  'control_name'                       => 'sala_judecata_1',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'sala_judecata_1',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Specificati sala de judecata !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																																																
																							/* ===================================================================================================== */
                                                                                               
																						),
                                                                   ),																   																   
																   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    =>  '2', 
																		   'title'    => 'Dosar de executare silita',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* /////////////////////////////////////////////////////////////////// */
																						  array (
																								  'type'                               => FIELD_TYPE_COMBO_SWITCH,
																								  'title'                              => 'Am numar dosar ?',
																								  'control_name'                       => 'tip_dosar_executare',
																								  'db_field'                           => 'tip_dosar_executare',
																								  'control_id'                         => 'tip_dosar_executare',
																								  'read_only'                          => false,
																								  'required'                           => true,
																								  'required_message'                   => 'Selectati daca aveti sau nu numar de dosar',
																								  'column_size'                        => '',
																								  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								  'attributes'                         => array(
																																				   /* ---------------------------------------------- */
																																				   array ( 
																																						   'value'    => '0',
																																						   'title' 	  => 'Nu am inca numar dosar',
																																						   'selected' => true, /* default selected */
																																						   'fields'   => array( 
																																											/* ----- */
																																											/* ----- */
																																											   
																																										),
																																				   ),
																																				   /* ---------------------------------------------- */																   
																																				   array ( 
																																						   'value'    =>  '1', 
																																						   'title'    => 'Am numar dosar',
																																						   'selected' => false,
																																						   'fields'   => array( 
																																											/* ----- */
																																											 array (
																																											  'type'                               => FIELD_TYPE_TEXT,
																																											  'title'                              => 'Numar dosar',
																																											  'control_name'                       => 'nr_dosar_2',
																																											  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																																											  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																																											  'control_id'                         => '',													
																																											  'db_field'                           => 'nr_dosar_2',
																																											  'value'                              => '', 
																																											  'maxlength'                          => '100',
																																											  'read_only'                          => false,
																																											  'required'                           => true,
																																											  'required_message'                   => 'Introduceti numarul dosarului !',
																																											  'placeholder'                        => '',
																																											  'pattern'                            => '',
																																											  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																																											  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																																											  'icon'                    		   =>  array(
																																																							 array (
																																																							  'class'              	=> 'fa fa-folder-open-o', 
																																																							  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																																																							  'position'            => '0',           	       /* 0 - left, 1 - right  */
																																																							  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																																																							  ),
																																																						),
																																												   ),
																																				  array (
																																				  'type'                               => FIELD_TYPE_DATE,
																																				  'title'                              => 'Date inregistrari la bej',
																																				  'bottom_info'                        => 'Selecteaza Data',
																																				  'control_name'                       => 'date_reg_bej',
																																				  'control_id'                         => '',
																																				  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
																																				  'value'                              => '',
																																				  'read_only'                          => false,
																																				  'can_select_date'                    => true,
																																				  'can_delete_date'                    => true,
																																				  'db_field'                           => 'date_reg_bej',
																																				  'required'                           => true,
																																				  'required_message'                   => 'Completati data inregistrarii la tribunal !',
																																				  'placeholder'                        => 'zz-ll-yyyy',
																																				  'width'                              => '',                  
																																				  ),                                                                                                                            
																																											
																																											/* ----- */
																																											   
																																										),
																																				   ),
																																				   
																																				   /* ---------------------------------------------- */																   
																																			   ),
																								  ),
																								  
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Obiectul executarii',
																							  'control_name'                       => 'obiect_2',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'obiect_2',
																							  'value'                              => '', 
																							  'maxlength'                          => '1000',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti obiectul executarii !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Data si numar titlu executoriu',
																							  'control_name'                       => 'dn_te',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'dn_te',													
																							  'db_field'                           => 'dn_te',
																							  'value'                              => '', 
																							  'maxlength'                          => '50',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => '',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Data si numar incuviintare executare silita',
																							  'control_name'                       => 'dn_ies',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'dn_ies',													
																							  'db_field'                           => 'dn_ies',
																							  'value'                              => '', 
																							  'maxlength'                          => '50',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => '',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Data si numar incheiere deschidere dosar',
																							  'control_name'                       => 'dn_idd',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'dn_idd',													
																							  'db_field'                           => 'dn_idd',
																							  'value'                              => '', 
																							  'maxlength'                          => '50',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => '',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Data si numar incheiere cheltuieli de executare',
																							  'control_name'                       => 'dn_ice',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'dn_ice',													
																							  'db_field'                           => 'dn_ice',
																							  'value'                              => '', 
																							  'maxlength'                          => '50',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => '',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																								  
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Nume executor',
																							  'control_name'                       => 'executor_nume',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'executor_nume',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti numele executorului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'E-mail executor',
																							  'control_name'                       => 'executor_email',
																							  'input_type'                         => 'email',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'executor_email',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti email-ul executoreului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Telefon executor',
																							  'control_name'                       => 'executor_tel',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'executor_tel',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti email-ul executoreului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Nume debitor',
																							  'control_name'                       => 'nume_debitor',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'nume_debitor',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti numele debitorului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Nume creditor',
																							  'control_name'                       => 'nume_creditor',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'nume_creditor',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti numele creditorului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),

																							/* /////////////////////////////////////////////////////////////////// */
                                                                                               
																						),
                                                                   ),																   																   																   
																   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    =>  '3', 
																		   'title'    => 'Dosar consultanta',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Numar dosar',
																							  'control_name'                       => 'nr_dosar_3',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'nr_dosar_3',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Introduceti numarul dosarului !',
																							  'placeholder'                        => 'nr intern - se va genera automat',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																							  'icon'                    		   =>  array(
																																			 array (
																																			  'class'              	=> 'fa fa-folder-open-o', 
																																			  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																																			  'position'            => '0',           	       /* 0 - left, 1 - right  */
																																			  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																																			  ),
																																		),
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Obiect',
																							  'control_name'                       => 'obiect_3',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'obiect_3',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti obiectul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Destinatar',
																							  'control_name'                       => 'destinatar_3',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'destinatar_3',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti destinatarul !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),

																							
																							/* ----- */
                                                                                               
																						),
                                                                   ),																   																   																   																   
																   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    =>  '4', 
																		   'title'    => 'Dosar de arbitraj',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																						  array (
																								  'type'                               => FIELD_TYPE_COMBO_SWITCH,
																								  'title'                              => 'Am numar dosar ?',
																								  'control_name'                       => 'tip_dosar_arbitraj',
																								  'db_field'                           => 'tip_dosar_arbitraj',
																								  'control_id'                         => 'tip_dosar_arbitraj',
																								  'read_only'                          => false,
																								  'required'                           => true,
																								  'required_message'                   => 'Selectati daca aveti sau nu numar de dosar',
																								  'column_size'                        => '',
																								  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								  'attributes'                         => array(
																																				   /* ---------------------------------------------- */
																																				   array ( 
																																						   'value'    => '0',
																																						   'title' 	  => 'Nu am inca numar dosar',
																																						   'selected' => true, /* default selected */
																																						   'fields'   => array( 
																																											/* ----- */
																																											/* ----- */
																																											   
																																										),
																																				   ),
																																				   /* ---------------------------------------------- */																   
																																				   array ( 
																																						   'value'    =>  '1', 
																																						   'title'    => 'Am numar dosar',
																																						   'selected' => false,
																																						   'fields'   => array( 
																																											/* ----- */
																																											 array (
																																											  'type'                               => FIELD_TYPE_TEXT,
																																											  'title'                              => 'Numar dosar',
																																											  'control_name'                       => 'nr_dosar_4',
																																											  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																																											  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																																											  'control_id'                         => '',													
																																											  'db_field'                           => 'nr_dosar_4',
																																											  'value'                              => '', 
																																											  'maxlength'                          => '100',
																																											  'read_only'                          => false,
																																											  'required'                           => true,
																																											  'required_message'                   => 'Introduceti numarul dosarului !',
																																											  'placeholder'                        => '',
																																											  'pattern'                            => '',
																																											  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																																											  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																																											  'icon'                    		   =>  array(
																																																							 array (
																																																							  'class'              	=> 'fa fa-folder-open-o', 
																																																							  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																																																							  'position'            => '0',           	       /* 0 - left, 1 - right  */
																																																							  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																																																							  ),
																																																						),
																																												   ),
																																											  array (
																																											  'type'                               => FIELD_TYPE_DATE,
																																											  'title'                              => 'Date inregistrari (centru arbitraj)',
																																											  'bottom_info'                        => 'Selecteaza Data',
																																											  'control_name'                       => 'date_reg_arb',
																																											  'control_id'                         => '',
																																											  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
																																											  'value'                              => '',
																																											  'read_only'                          => false,
																																											  'can_select_date'                    => true,
																																											  'can_delete_date'                    => true,
																																											  'db_field'                           => 'date_reg_arb',
																																											  'required'                           => false,
																																											  'required_message'                   => 'Completati data inregistrarii la centrul de arbitraj !',
																																											  'placeholder'                        => 'zz-ll-yyyy',
																																											  'width'                              => '',                  
																																											  ),                                                                                                                            
																																											
																																											/* ----- */
																																											   
																																										),
																																				   ),
																																				   
																																				   /* ---------------------------------------------- */																   
																																			   ),
																								  ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Obiect',
																							  'control_name'                       => 'obiect_4',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'obiect_4',
																							  'value'                              => '', 
																							  'maxlength'                          => '',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti obiectul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Materie juridica',
																							  'control_name'                       => 'materie_juridica_4',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'materie_juridica_4',
																							  'value'                              => '', 
																							  'maxlength'                          => '',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti materia juridica !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Arbitri',
																							  'control_name'                       => 'arbitri_4',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'arbitri_4',
																							  'value'                              => '', 
																							  'maxlength'                          => '',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti arbitrii !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							
																							/* ----- */
                                                                                               
																						),
                                                                   ),																   																   																   																   																   
																   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    =>  '5', 
																		   'title'    => 'Dosar procedura jurisdictionala administrativa',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Numar dosar',
																							  'control_name'                       => 'nr_dosar_5',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'nr_dosar_5',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Introduceti numarul dosarului !',
																							  'placeholder'                        => 'nr intern - se va genera automat',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																							  'icon'                    		   =>  array(
																																			 array (
																																			  'class'              	=> 'fa fa-folder-open-o', 
																																			  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																																			  'position'            => '0',           	       /* 0 - left, 1 - right  */
																																			  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																																			  ),
																																		),
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Obiect',
																							  'control_name'                       => 'obiect_5',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'obiect_5',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti obiectul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Destinatar',
																							  'control_name'                       => 'destinatar_5',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'destinatar_5',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti destinatarul !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							
																							/* ----- */
                                                                                               
																						),
                                                                   ),
																   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    =>  '6', 
																		   'title'    => 'Dosar urmarire penala',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																						  array (
																								  'type'                               => FIELD_TYPE_COMBO_SWITCH,
																								  'title'                              => 'Am numar dosar ?',
																								  'control_name'                       => 'tip_dosar_urmarire',
																								  'db_field'                           => 'tip_dosar_urmarire',
																								  'control_id'                         => 'tip_dosar_urmarire',
																								  'read_only'                          => false,
																								  'required'                           => true,
																								  'required_message'                   => 'Selectati daca aveti sau nu numar de dosar',
																								  'column_size'                        => '',
																								  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								  'attributes'                         => array(
																																				   /* ---------------------------------------------- */
																																				   array ( 
																																						   'value'    => '0',
																																						   'title' 	  => 'Nu am inca numar dosar',
																																						   'selected' => true, /* default selected */
																																						   'fields'   => array( 
																																											/* ----- */
																																											/* ----- */
																																											   
																																										),
																																				   ),
																																				   /* ---------------------------------------------- */																   
																																				   array ( 
																																						   'value'    =>  '1', 
																																						   'title'    => 'Am numar dosar',
																																						   'selected' => false,
																																						   'fields'   => array( 
																																											/* ----- */
																																											 array (
																																											  'type'                               => FIELD_TYPE_TEXT,
																																											  'title'                              => 'Numar dosar',
																																											  'control_name'                       => 'nr_dosar_6',
																																											  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																																											  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																																											  'control_id'                         => '',													
																																											  'db_field'                           => 'nr_dosar_6',
																																											  'value'                              => '', 
																																											  'maxlength'                          => '100',
																																											  'read_only'                          => false,
																																											  'required'                           => true,
																																											  'required_message'                   => 'Introduceti numarul dosarului !',
																																											  'placeholder'                        => '',
																																											  'pattern'                            => '',
																																											  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																																											  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																																											  'icon'                    		   =>  array(
																																																							 array (
																																																							  'class'              	=> 'fa fa-folder-open-o', 
																																																							  'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
																																																							  'position'            => '0',           	       /* 0 - left, 1 - right  */
																																																							  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																																																							  ),
																																																						),
																																												   ),																																											
																																											/* ----- */
																																											   
																																										),
																																				   ),
																																				   
																																				   /* ---------------------------------------------- */																   
																																			   ),
																								  ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Obiect',
																							  'control_name'                       => 'obiect_6',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'obiect_6',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti obiectul dosarului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Procuror/Politist',
																							  'control_name'                       => 'procuror_politist_6',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'procuror_politist_6',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti Politistul/Procurorul !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Parchet/Politie',
																							  'control_name'                       => 'parchet_politie_6',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'parchet_politie_6',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti Parchet/Politie !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							
																							/* ----- */
                                                                                               
																						),
                                                                   ),																   
																   /* ---------------------------------------------- */
                                                               ),
                  ),
				  
			 array (
			  'type'                               => FIELD_TYPE_TEXTAREA,
			  'title'                              => 'Observatii',
			  'control_name'                       => 'observatii',
			  'control_id'                         => '',
			  'db_field'                           => 'observatii',
			  'value'                              => '', 
			  'maxlength'                          => '25',
			  'read_only'                          => false,
			  'required'                           => false,
			  'required_message'                   => 'Completati obvervatii dosar',
			  'placeholder'                        => '',
			  'column_size'                        => '',
			  'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			  'rows'                       	       => '4',
			  ),
			 array (
			  'type'                               => FIELD_TYPE_TEXTAREA,
			  'title'                              => '',
			  'control_name'                       => 'must_update',
			  'control_id'                         => 'must_update',
			  'db_field'                           => 'must_update',
			  'value'                              => '', 
			  'maxlength'                          => '',
			  'hidden'                             => true,
			  'read_only'                          => false,
			  'required'                           => false,
			  'required_message'                   => 'Completati obvervatii dosar',
			  'placeholder'                        => '',
			  'column_size'                        => '',
			  'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			  'rows'                       	       => '4',
			  ),
			 array (
			  'type'                               => FIELD_TYPE_TEXTAREA,
			  'title'                              => '',
			  'control_name'                       => 'last_soap_response',
			  'control_id'                         => 'last_soap_response',
			  'db_field'                           => 'last_soap_response',
			  'value'                              => '', 
			  'maxlength'                          => '',
			  'hidden'                             => true,
			  'read_only'                          => false,
			  'required'                           => false,
			  'required_message'                   => 'Completati last soap response',
			  'placeholder'                        => '',
			  'column_size'                        => '',
			  'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			  'rows'                       	       => '4',
			  ),
			  

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
	/* ---------------------------------------------------------------------------------------- */
	
}