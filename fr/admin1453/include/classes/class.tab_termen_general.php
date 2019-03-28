<?php

class tab_termen_general extends tab {
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
				  'type'                               => FIELD_TYPE_INFO,
				  'title'                              => '<strong>Atentie !</strong>',
                  'message_type'                       => MSG_WARNING,						/*can be: MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING */
				  'message'                            => 'Daca procesul de sincronizare a informatiilor din dosare cu sistemul ECRIS este activ atunci se vor suprascrie informatiile actualizate manual de catre utilizator.',
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'hide_on_add'                    	   => false,                            /* hide field for add operation */
                  ),                                                                                                                            					   

                  array (
                  'type'                               => FIELD_TYPE_DATE,
                  'title'                              => 'Data termen',
                  'bottom_info'                        => 'Selecteaza Data',
                  'control_name'                       => 'data_termen',
                  'control_id'                         => '',
                  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
                  'value'                              => '',
                  'read_only'                          => false,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => true,
                  'db_field'                           => 'data_termen',
                  'required'                           => true,
                  'required_message'                   => 'Completati data termen !',
				  'placeholder'                        => 'zz-ll-yyyy',
                  'width'                              => '',                  
                  ),    
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Complet judecata',
                  'control_name'                       => 'complet',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'complet',
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
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Sectia',
                  'control_name'                       => 'sectia',
                  'control_id'                         => '',
                  'db_field'                           => 'sectia',                  
                  'value'                              => '', 
                  'maxlength'                          => '25',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Completati sectia',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Ora',
                  'control_name'                       => 'ora',
                  'control_id'                         => '',
                  'db_field'                           => 'ora',                  
                  'value'                              => '', 
                  'maxlength'                          => '25',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Completati ora',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),
				 /* 
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Mentiuni',
                  'control_name'                       => 'mentiuni',
                  'control_id'                         => '',
                  'db_field'                           => 'mentiuni',                  
                  'value'                              => '', 
                  'maxlength'                          => '25',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Completati mentiunile',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			
			      'rows'                       	       => '4',
                  ),
				  */
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Solutie',
                  'control_name'                       => 'solutie',
                  'control_id'                         => '',
                  'db_field'                           => 'solutie',                  
                  'value'                              => '', 
                  'maxlength'                          => '25',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Completati solutia',
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