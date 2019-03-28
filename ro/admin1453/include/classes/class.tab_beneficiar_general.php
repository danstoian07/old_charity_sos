<?php

class tab_beneficiar_general extends tab {
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
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => 'Beneficiar',
                  'control_name'                       => 'type',
                  'db_field'                           => 'type',
                  'control_id'                         => 'type',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati beneficiarul',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    				=> '0',
																		   'title' 	  				=> 'Societatea de avocati',
																		   'class_method_for_title'	=> 'return_company_name',
																		   'selected' 				=> true, /* default selected */
                                                                           'fields'   				=> array( 
																									/* ----- */
																									
																									/* ----- */                                                                                               
																									),
                                                                   ),
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '1', 
																		   'title'    => 'Alt beneficiar',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																							  array (
																							  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_TABLE,
																							  'title'                              => 'Beneficiar contract',
																							  'control_name'                       => 'id_user',
																							  'db_field'                           => 'id_user',
																							  'control_id'                         => '',				  
																							  'query_table'                        => 'users',                         /* TABLE NAME without app table prefix */
																							  'db_field_value'                     => 'id',
																							  'db_field_title'                     => 'name',
																							  'id_archive'                         => 10,
																							  'order_by_field'                     => 'title',
																							  'order_direction'                    => 'ASC',
																							  'limit_items'                        => 1000,
																							  'first_line_message'                 => 'Selecteaza beneficiarul',              /* Leave empty for: without select message */
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Selecteaza beneficiarul',
																							  'column_size'                        => '',
																							  'width'                              => '',
																									),
																							/*
																							  array (
																							  'type'                               => FIELD_TYPE_COMBO_WITH_SEARCH,
																							  'title'                              => 'Beneficiar contract',
																							  'control_name'                       => 'id_user',
																							  'db_field'                           => 'id_user',
																							  'control_id'                         => '',
																							  'query_table'                        => 'users',
																							  'db_field_value'                     => 'id',
																							  'db_field_title'                     => 'name',
																							  'id_archive'                         => 10,
																							  'order_by_field'                     => 'title',
																							  'order_direction'                    => 'ASC',
																							  'limit_items'                        => 10000,
																							  'first_line_message'                 => 'Selecteaza beneficiarul',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Selectati un beneficiar',
																							  'column_size'                        => '',
																							  'width'                              => '',
																									),	
																							*/
																							/* ----- */
                                                                                               
																						),
                                                                   ),
																   
																   /* ---------------------------------------------- */																   
                                                               ),
                  ),

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Procent comision [%]',
                  'control_name'                       => 'commission',
                  'input_type'                         => 'number',				/* can be html input type: text, email, etc*/
				  'other_attribs'                  	   => 'step="0.5" max="100" min="0"',
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'commission',
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
					
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Observatii',
                  'control_name'                       => 'observations',
                  'control_id'                         => '',
                  'db_field'                           => 'observations',
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Complatati observatiile despre beneficiar',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),
				  
				  

	    );
	/* ------------------------------------------------------------------------------------- */
	public function return_company_name(){
		return el_decript_info($_SESSION[APP_ID]["user"]["company"]);
	}
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}