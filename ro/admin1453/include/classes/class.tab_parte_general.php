<?php

class tab_parte_general extends tab {
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
				  'type'                               => FIELD_TYPE_SELECT_IMAGE,
				  'title'                              => 'Poza/Logo  [300px × 300px]',
				  'control_name'                       => 'photo',
				  'control_id'                         => 'photo',
				  'db_field'                           => 'photo',
				  'value'                              => '',
				  'max_file_size'                      => 10,  /* max file size in MB; 0 for unlimited size */
				  'upload_quality'                     => 80, /* compress file on upload */
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati poza/logo-ul partii in dosar',
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
					   ),


                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'Parte in dosar',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'icon-user-following',
                  'bold'                               => true,
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
                  'required'                           => false,
                  'required_message'                   => 'Completati numele partii in dosar !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
		          'icon'                    		   =>  array(
	                                                             array (
	                                                              'class'              	=> 'fa fa-user', 
	                                                              'type'       			=> '1',		 		             /* 0 - normal, 1 - boxed */	
	                                                              'position'            => '0',           	       		/* 0 - left, 1 - right  */
	                                                              'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
	                                                              ),
		                                                    ),				
                       ),
				/*
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_TABLE,
                  'title'                              => 'Calitate procesuala',
                  'control_name'                       => 'calitate procesuala',
				  'db_field'                           => 'id_calitate_procesuala',
                  'control_id'                         => 'calitate procesuala',				  
                  'query_table'                        => 'calitati_procesuale',                         
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 0,
                  'order_by_field'                     => 'name',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 1000,
                  'first_line_message'                 => 'Selectati calitatea procesuala',              
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati calitatea procesuala',
                  'column_size'                        => '',
                  'width'                              => '',
                        ),
				*/
					   
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Telefon',
                  'control_name'                       => 'telefon',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'telefon',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti numarul de telefon al reprezentantului !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'E-mail',
                  'control_name'                       => 'email',
                  'input_type'                         => 'email',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'email',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti adresa de e-mail a reprezentantului !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Reprezentant legal',
                  'control_name'                       => 'reprezentant_legal',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'reprezentant_legal',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti numele reprezentantului legal!',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Avocat',
                  'control_name'                       => 'avocat',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'avocat',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti numele avocatului!',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Calitate',
                  'control_name'                       => 'calitate',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'calitate',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti calitatea!',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
					   
				  

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}