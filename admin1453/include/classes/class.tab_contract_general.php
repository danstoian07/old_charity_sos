<?php

class tab_contract_general extends tab {
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
                  'title'                              => 'Numar contract',
                  'control_name'                       => 'contract_no',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'contract_no',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti numarul contractului !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => 'font-bold',			 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
		          'icon'                    		   =>  array(
	                                                             array (
	                                                              'class'              	=> 'fa fa-file-text-o', 
	                                                              'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
	                                                              'position'            => '0',           	       /* 0 - left, 1 - right  */
	                                                              'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
	                                                              ),
		                                                    ),
                       ),

                  array (
                  'type'                               => FIELD_TYPE_DATE,
                  'title'                              => 'Date contract',
                  'bottom_info'                        => 'Selecteaza Data',
                  'control_name'                       => 'contract_data',
                  'control_id'                         => '',
                  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
                  'value'                              => '',
                  'read_only'                          => false,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => true,
                  'db_field'                           => 'contract_data',
                  'required'                           => true,
                  'required_message'                   => 'Completati data contractului !',
				  'placeholder'                        => 'zz-ll-yyyy',
                  'width'                              => '',                  
                  ),                                                                                                                            
				  /*
                  array (
                  'type'                               => FIELD_TYPE_COMBO_WITH_SEARCH,
                  'title'                              => 'Client',
                  'control_name'                       => 'id_client',
				  'db_field'                           => 'idma',
                  'control_id'                         => '',
                  'query_table'                        => 'clients',                         
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 0,
                  'order_by_field'                     => 'title',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 1000,
                  'first_line_message'                 => 'Selecteaza clientul',              
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati un client',
                  'column_size'                        => '',
                  'width'                              => '',
                        ),
					*/
                  array (
                  'type'                               => FIELD_TYPE_COMBO_WITH_SEARCH,
                  'title'                              => 'Client',
                  'control_name'                       => 'id_client',
				  'db_field'                           => 'idma',
                  'control_id'                         => '',
                  'query_table'                        => 'clients',                         
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 0,
                  'order_by_field'                     => 'title',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 10000,
                  'first_line_message'                 => 'Selecteaza clientul',              
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati un client',
                  'column_size'                        => '',
                  'width'                              => '',
                        ),
					
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_TABLE,
                  'title'                              => 'Locul intocmirii',
                  'control_name'                       => 'id_sediu',
				  'db_field'                           => 'id_sediu',
                  'control_id'                         => '',				  
                  'query_table'                        => 'sedii',                         /* TABLE NAME without app table prefix */
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 0,
                  'order_by_field'                     => 'name',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 1000,
                  'first_line_message'                 => 'Selecteaza locul intocmirii',              /* Leave empty for: without select message */
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati locul intocmirii contractului',
                  'column_size'                        => '',
                  'width'                              => '',
                        ),
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Obiectul contractului',
                  'control_name'                       => 'contract_object',
                  'control_id'                         => '',
                  'db_field'                           => 'contract_object',
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Completati obiectul contractului',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Onorariu',
                  'control_name'                       => 'contract_fee',
                  'control_id'                         => '',
                  'db_field'                           => 'contract_fee',
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Completati onorariul',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Alte clauze',
                  'control_name'                       => 'contract_other_clauses',
                  'control_id'                         => '',
                  'db_field'                           => 'contract_other_clauses',
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Completati alte clauze la contract',
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
}