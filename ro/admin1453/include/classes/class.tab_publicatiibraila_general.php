<?php

class tab_publicatiibraila_general extends tab {
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
                  'title'                              => 'Vizibilitate',
                  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
                  'column_size'                        => '',
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Publicatia este vizibila in site', 
                                                                      'control_name'                       => 'visible',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => true,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'visible',
                                                                  ),
                                                          ),
					'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
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
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => '<strong>Poza (800 x ???)</strong>',
				  'control_name'                       => 'featured_image',
				  'input_type'                         => 'featured_image',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'featured_image',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => true,
				  'show_preview'                       => true,
				  'required_message'                   => 'Selectati poza afisului',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',
				  'width'                        	   => '',
				  'icon'                    		   =>  array(
																 array (
																  'class'              => 'fa fa-photo',
																  'type'       	       => '1',
																  'color'              => 'font-red',  			
																 ),				  
															),
					   ),																							
			     array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Titlu',
                  'control_name'                       => 'name',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',
                  'db_field'                           => 'name',
                  'value'                              => '', 
                  'maxlength'                          => '200',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti eticheta pentru poza 1',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),					   					   
				 array (
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => 'PDF atasat',
				  'control_name'                       => 'download',
				  'input_type'                         => 'image_link',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'download',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati/introduceti link-ul de redirectare',
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
					   
				  

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}