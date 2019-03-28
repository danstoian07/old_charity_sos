<?php

class tab_utilizator_general extends tab {
	public  $show_sidebar             = true;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width            = 4;						/* no between 2 and 10 */		
	/* ------------------------------------------------------------------------------------- */	
	public $show_line_between_fields = false;
	public $fields = 
		array( 
                  array (
                  'type'                               => FIELD_TYPE_DATETIME,
                  'title'                              => 'Adaugat',
                  'control_name'                       => 'date_add',
                  'control_id'                         => 'date_add',
                  'value'                              => '',
                  'read_only'                          => true,
                  'can_select_date'                    => false,
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
				  'type'                               => FIELD_TYPE_SELECT_IMAGE,
				  'title'                              => 'Poza [Max: 300px × 300px]',
				  'control_name'                       => 'photo',
				  'control_id'                         => 'photo',
				  'db_field'                           => 'photo',
				  'value'                              => '',
				  'max_file_size'                      => 10,  /* max file size in MB; 0 for unlimited size */
				  'upload_quality'                     => 80, /* compress file on upload */
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati poza produsului',
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
					   ),
                  array (
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Status cont',
                  'control_name'                       => 'active',
                  'db_field'                           => 'active',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
				  'help_message'                       => 'Daca <strong>Contul este suspendat</strong> utilizatorului<br>nu i se va mai permite accesul in sistem.',
                  'required_message'                   => 'Selectati optiunea combo cu icons',
                  'column_size'                        => '',
                  'width'                              => '',                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '1', 'icon_class' => 'fa-unlock font-green', 'selected' => false, 'title' => 'Cont activ', ),
                                                                   array ( 'value' =>  '0', 'icon_class' => 'fa-lock font-red', 'selected' => false, 'title' => 'Cont suspendat', ),
                                                               ),
                        ),
		
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Nume avocat',
				  'control_name'                       => 'name',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'name',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Introduceti numele clientului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'icon'                    		   =>  array(
																 array (
																  'class'              	=> 'fa fa-user', 
																  'type'       			=> '1',		 		          /* 0 - normal, 1 - boxed */	
																  'position'            => '0',           	       	  /* 0 - left, 1 - right  */
																  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																  ),
															),															
					   ),
				  /*
                  array (                  
                  'type'                               => FIELD_TYPE_CHECKBOX,
                  'title'                              => 'Cont Activ',
                  'style'                              => 0,                                  
                  'column_size'                        => '',
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Contul este activ', 
                                                                      'control_name'                       => 'visible',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => true,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'visible',
                                                                  ),
                                                          ),
                  ),
					*/
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'E-mail',
				  'control_name'                       => 'email',
				  'input_type'                         => 'email',			/* can be html input type: text, email, etc*/
				  'unique'							   => true,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'email',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Introduceti adresa de e-mail !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'icon'                    		   =>  array(
																 array (
																  'class'              	=> 'fa fa-envelope', 
																  'type'       			=> '1',		 		          /* 0 - normal, 1 - boxed */	
																  'position'            => '0',           	       	  /* 0 - left, 1 - right  */
																  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																  ),
															),															
					   ),
				 array (
				  'type'                               => FIELD_TYPE_PASSWORD,
				  'title'                              => 'Parola contului',
				  'control_name'                       => 'password',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'password',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'required_message'                   => 'Introduceti parola contului !',
				  'placeholder'                        => 'Parola contului',
				  'placeholder_on_edit'                => 'Lasa necompletat daca nu doresti schimbarea parolei',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'icon'                    		   =>  array(
																 array (
																  'class'              	=> 'fa fa-lock', 
																  'type'       			=> '1',		 		          /* 0 - normal, 1 - boxed */	
																  'position'            => '0',           	       	  /* 0 - left, 1 - right  */
																  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																  ),
															),															
					   ),
		
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Telefon',
				  'control_name'                       => 'phone',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'phone',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Introduceti numarul de telefon al clientului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
					/*
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'Tip colaborare',
                  'control_name'                       => 'type_association',
                  'db_field'                           => 'type_association',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul de colaborare',
                  'column_size'                        => '',
                  'width'                              => '',              
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '',  'selected' => true,  'title' => 'Selecteaza tipul de colaborare', ),
                                                                   array ( 'value' =>  '0', 'selected' => false, 'title' => 'Avocat asociat', ),
                                                                   array ( 'value' =>  '1', 'selected' => false, 'title' => 'Avocat colaborator', ),
																   array ( 'value' =>  '2', 'selected' => false, 'title' => 'Avocat coordonator', ),
																   array ( 'value' =>  '3', 'selected' => false, 'title' => 'Office manager/secretar', ),
                                                               ),
                        ),
					*/
				/*
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'Calitate avocat',
                  'control_name'                       => 'type_lawyer',
                  'db_field'                           => 'type_lawyer',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul avocatului',
                  'column_size'                        => '',
                  'width'                              => '',              
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '',  'selected' => true,  'title' => 'Selecteaza optiunea', ),
                                                                   array ( 'value' =>  '0', 'selected' => false, 'title' => 'Avocat stagiar', ),
                                                                   array ( 'value' =>  '1', 'selected' => false, 'title' => 'Avocat definitiv', ),
                                                               ),
                        ),
				  */
				 array (
				  'type'                               => FIELD_TYPE_TEXTAREA,
				  'title'                              => 'Observatii utilizator',
				  'control_name'                       => 'observations',
				  'control_id'                         => '',
				  'db_field'                           => 'observations',                  
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Completati observatiile despre client',
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