<?php

class tab_act_aditional_general extends tab {
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
                  'required_message'                   => 'Completati data adaugarii reprezentantului !',
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
                  'required_message'                   => 'Completati adaugarii reprezentantului !',
				  'placeholder'                        => 'zz-ll-yyyy hh:mm',
                  'column_size'                        => '9',                              /*1-10, default: 4*/
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'skip_update'                        => true,                             /* no update for this field */
				  'hide_on_add'                    	   => true,                             /* hide field for add operation */
                  ),                                                                                                                            

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Numar act aditional',
                  'control_name'                       => 'nr_act_aditional',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'nr_act_aditional',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti numarul actului aditional !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
		          'icon'                    		   =>  array(
	                                                             array (
	                                                              'class'              	=> 'fa fa-user', 
	                                                              'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
	                                                              'position'            => '0',           	       		/* 0 - left, 1 - right  */
	                                                              'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
	                                                              ),
		                                                    ),
                       ),
				  array (
				  'type'                               => FIELD_TYPE_DATE,
				  'title'                              => 'Date inregistrari',
				  'bottom_info'                        => 'Selecteaza Data',
				  'control_name'                       => 'date_act',
				  'control_id'                         => '',
				  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
				  'value'                              => '',
				  'read_only'                          => false,
				  'can_select_date'                    => true,
				  'can_delete_date'                    => true,
				  'db_field'                           => 'date_act',
				  'required'                           => true,
				  'required_message'                   => 'Completati data inregistrarii la tribunal !',
				  'placeholder'                        => 'zz-ll-yyyy',
				  'width'                              => '',                  
				  ),                                                                                                                            

					   
				   array (
					'type'                               => FIELD_TYPE_TEXTAREA,
					'title'                              => 'Obiect',
					'control_name'                       => 'obiect',
					'control_id'                         => '',
					'db_field'                           => 'obiect',                  
					'value'                              => '', 
					'maxlength'                          => '',
					'read_only'                          => false,
					'required'                           => true,
					'required_message'                   => 'Completati obiectul actului aditional',
					'placeholder'                        => '',
					'column_size'                        => '',
					'width'                              => '',        
					'rows'                               => '4',
					),
				   array (
					'type'                               => FIELD_TYPE_TEXTAREA,
					'title'                              => 'Onorariu',
					'control_name'                       => 'onorariu',
					'control_id'                         => '',
					'db_field'                           => 'onorariu',                  
					'value'                              => '', 
					'maxlength'                          => '',
					'read_only'                          => false,
					'required'                           => true,
					'required_message'                   => 'Completati onorariul',
					'placeholder'                        => '',
					'column_size'                        => '',
					'width'                              => '',        
					'rows'                               => '4',
					),
				   array (
					'type'                               => FIELD_TYPE_TEXTAREA,
					'title'                              => 'Observatii (nu se vor include in actul aditional)',
					'control_name'                       => 'observatii',
					'control_id'                         => '',
					'db_field'                           => 'observatii',                  
					'value'                              => '', 
					'maxlength'                          => '',
					'read_only'                          => false,
					'required'                           => false,
					'required_message'                   => 'Completati onorariul',
					'placeholder'                        => '',
					'column_size'                        => '',
					'width'                              => '',        
					'rows'                               => '4',
					),

					   
				  

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}