<?php

class tab_client_general extends tab {
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
				  'title'                              => 'Poza/Logo [300px × 300px]',
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
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Nume client',
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
				  'generate_permalink_to_field'  	   => 'slug',					 /* valable only for FIELD_TYPE_TEXT field */ 
				  'icon'                    		   =>  array(
																 array (
																  'class'              	=> 'fa fa-user', 
																  'type'       			=> '1',		 		          /* 0 - normal, 1 - boxed */	
																  'position'            => '0',           	       	  /* 0 - left, 1 - right  */
																  'color'               => 'font-red',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																  ),
															),															
					   ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Tara',
				  'control_name'                       => 'country',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'country',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Introduceti tara clientului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),

				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Adresa',
				  'control_name'                       => 'address',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'address',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Introduceti adresa clientului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Cod Postal',
				  'control_name'                       => 'postal_code',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'postal_code',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Introduceti codul postal al adresei clientului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => 'Tip client',
                  'control_name'                       => 'type',
                  'db_field'                           => 'type',
                  'control_id'                         => 'type',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul clientului',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '1',
																		   'title' 	  => 'Persoana fizica',
																		   'selected' => true, /* default selected */
                                                                           'fields'   => array( 
																							/* ======================================================================================= */
																								   
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'CNP (Cod Numeric Personal)',
																							  'control_name'                       => 'cnp',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'cnp',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti CNP-ul clientului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Act Identitate',
																							  'control_name'                       => 'identity_document',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'identity_document',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti seria si numarul actului de identitate al clientului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Act eliberat de',
																							  'control_name'                       => 'identity_document_issuing',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'identity_document_issuing',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Specificati cine a eliberat actul de identitate al clientului !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),																								   
																							/* ======================================================================================= */
                                                                                               
																						),
                                                                   ),
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '2', 
																		   'title'    => 'Persoana juridica',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* xxx ======================================================================================= */
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'CUI (Cod Unic Identificare)',
																							  'control_name'                       => 'pj_cui',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'pj_cui',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti CUI !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Nr. ORC',
																							  'control_name'                       => 'pj_reg_com',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'pj_reg_com',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Introduceti Numarul de inregistrare la ORC !',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
                                                                                            /* xxx======================================================================================= */   
																						),
                                                                   ),
																   
																   /* ---------------------------------------------- */																   
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
				  'required_message'                   => 'Introduceti adresa de e-mail !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Cont bancar',
				  'control_name'                       => 'bank_account',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'bank_account',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Specificati contul bancar al clientului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Banca',
				  'control_name'                       => 'bank_name',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'bank_name',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Specificati banca clientului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
				 array (
				  'type'                               => FIELD_TYPE_TEXTAREA,
				  'title'                              => 'Observatii client',
				  'control_name'                       => 'client_observations',
				  'control_id'                         => '',
				  'db_field'                           => 'client_observations',                  
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