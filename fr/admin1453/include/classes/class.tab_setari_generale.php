<?php

class tab_setari_generale extends tab {
	public  $show_sidebar             = false;					/* will display right sidebar info (only if $this->edit_tab==true ) */
	public  $label_size               = 2;
	public  $sidebar_width            = 4;						/* no between 2 and 10 */			
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 
                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'DETALII INSTITUTIE',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-building',
                  'bold'                               => false,
                  ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Nume Institutie',
				  'control_name'                       => 'company_name',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_name',													
				  'db_field'                           => 'company_name',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Type the company name',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Adresa Institutie',
				  'control_name'                       => 'company_address',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_address',													
				  'db_field'                           => 'company_address',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => '',
				  'placeholder'                        => 'Address',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Telefoane',
				  'control_name'                       => 'company_phone',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_phone',													
				  'db_field'                           => 'company_phone',
				  'value'                              => '', 
				  'maxlength'                          => '',
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
				  'title'                              => 'Fax',
				  'control_name'                       => 'company_fax',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_fax',													
				  'db_field'                           => 'company_fax',
				  'value'                              => '', 
				  'maxlength'                          => '',
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
				  'title'                              => 'E-mail',
				  'control_name'                       => 'company_email',
				  'input_type'                         => 'email',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_email',													
				  'db_field'                           => 'company_email',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => '',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),					   		
					   
                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'ADMINISTRATOR SISTEM',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-user-o',
                  'bold'                               => false,
                  ),
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Nume Administrator',
				  'control_name'                       => 'admin_name',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'admin_name',													
				  'db_field'                           => 'admin_name',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Completati numele administratorului de sistem',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'help_message'                       => 'Numele administratorului aplicatiei',
					   ),
				array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'E-mail Administrator',
				  'control_name'                       => 'admin_contact_email',
				  'input_type'                         => 'email',			/* can be html input type: text, email, etc*/
				  'unique'							   => true,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'admin_contact_email',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Completati adresa de e-mail a administratorului de sistem',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'help_message'                       => 'Adresa de e-mail a administratorului aplicatiei. Aici se vor primi si e-mail-urile transmise prin formularul de contact.',
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
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'TRIMITERE MESAJE E-MAIL DE CATRE APLICATIE',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-envelope',
                  'bold'                               => false,
                  ),
				  
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => '<strong>Protocol</strong>',
                  'control_name'                       => 'mail_type',
                  'db_field'                           => 'mail_type',
                  'control_id'                         => 'mail_type',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati Protoculul de trimitere e-mail-uri',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'help_message'                       => 'Protoculul prin care aplicatia trimite mesaje utilizatorilor',
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '0',
																		   'title' 	  => 'Sending mail using PHP mail() function',
																		   'selected' => true, /* default selected */
                                                                           'fields'   => array(                                                                                                
																						),
                                                                   ),
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '1', 
																		   'title'    => 'Sending mail via SMTP',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																							array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'E-mail Address',
																							  'control_name'                       => 'mail_email',
																							  'input_type'                         => 'email',			/* can be html input type: text, email, etc*/
																							  'unique'							   => true,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'mail_email',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Type the e-mail address',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																							  'help_message'                       => 'Adresa de e-mail prin care se trimit mesaje utilizatorilor aplicatiei folosind protocolul SMTP',
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
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Username',
																							  'control_name'                       => 'mail_username',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'mail_username',													
																							  'db_field'                           => 'mail_username',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Type the user name',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							 array (
																							  'type'                               => FIELD_TYPE_PASSWORD,
																							  'title'                              => 'Password',
																							  'control_name'                       => 'mail_password',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'md5_encript'						   => false,				/* default: true - can not decript password; false - can decript password */
																							  'control_id'                         => '',													
																							  'db_field'                           => 'mail_password',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'required_message'                   => 'Type the password',
																							  'placeholder'                        => 'Your password',
																							  'placeholder_on_edit'                => 'Type a new password if you want to change the old one',
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
																							  'title'                              => 'SMTP server address (Outgoing Server)',
																							  'control_name'                       => 'mail_server',
																							  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'mail_server',													
																							  'db_field'                           => 'mail_server',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Type the SMTP server adress',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),
																							array (
																							  'type'                               => FIELD_TYPE_TEXT,
																							  'title'                              => 'Port',
																							  'control_name'                       => 'mail_server_port',
																							  'input_type'                         => 'number',				/* can be html input type: text, email, etc*/
																							  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
																							  'control_id'                         => 'mail_server_port',													
																							  'db_field'                           => 'mail_server_port',
																							  'value'                              => '', 
																							  'maxlength'                          => '100',
																							  'read_only'                          => false,
																							  'required'                           => true,
																							  'required_message'                   => 'Type the port number',
																							  'placeholder'                        => '',
																							  'pattern'                            => '',
																							  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
																							  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
																								   ),																							
																							array (
																							  'type'                               => FIELD_TYPE_CHECKBOX,
																							  'title'                              => 'Authentication',
																							  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
																							  'column_size'                        => '',
																							  'fields'                             => array(
																																			 array (
																																				  'title'                              => 'My server requires authentication', 
																																				  'control_name'                       => 'mail_server_require_authentication',
																																				  'control_id'                         => '',
																																				  'checked'                            => false,
																																				  'read_only'                          => false,
																																				  'db_field'                           => 'mail_server_require_authentication',
																																				  'help_message'                       => '',
																																			  ),
																																			  
																																	  ),
																							),
																								   
																							/* ----- */                                                                                               
																						),
                                                                   ),
																   
																   /* ---------------------------------------------- */
                                                               ),
                  ),
				  
					   

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
	public function program_institutie($json_value='') {
		/* botstrap max columns: 10 */
		/* method will return an array with itinerary rows */
		global $oDB;
		$arr_content = array();		
		
		if ($json_value=='[]') {
			/* este adaugare */
			$content = '
				<div class="col-md-3">
					<input type="text" name="perioada" placeholder="Zi/Perioada" class="form-control" /> 
				</div>
				<div class="col-md-3">
					<input type="text" name="ore" placeholder="Interval orar" class="form-control" /> 
				</div>					
				<div class="col-md-4">
					<input type="text" name="observatii" placeholder="Observatii" class="form-control"/> 
				</div>									
			'.PHP_EOL;
			array_push($arr_content, $content);
		} else {
			/* modificare */
			$arr_items = json_decode($json_value, true);
			$FIELDS_NO = 3;
			$ITEMS_NO  = count($arr_items);
			for ($i = 0; $i < $ITEMS_NO; $i = $i+$FIELDS_NO) {
				$content = '
				<div class="col-md-3">
					<input type="text" name="perioada" placeholder="Zi/Perioada" class="form-control" value="'.$arr_items[$i]['value'].'" /> 
				</div>
				<div class="col-md-3">
					<input type="text" name="ore" placeholder="Interval orar" class="form-control" value="'.$arr_items[$i+1]['value'].'" /> 
				</div>									
				<div class="col-md-4">
					<input type="text" name="observatii" placeholder="Observatii" class="form-control" value="'.$arr_items[$i+2]['value'].'" /> 
				</div>													
				'.PHP_EOL;
				array_push($arr_content, $content);
			}
		}
		return $arr_content;
	}		
	
	/* ------------------------------------------------------------------------------------- */
	
}