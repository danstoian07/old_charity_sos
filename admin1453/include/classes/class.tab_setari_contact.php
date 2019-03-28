<?php

class tab_setari_contact extends tab {
	public  $show_sidebar             = false;					/* will display right sidebar info (only if $this->edit_tab==true ) */
	public  $label_size               = 2;
	public  $sidebar_width            = 4;						/* no between 2 and 10 */			
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 
                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'BANNER TOP - IMPLICIT',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-gear',
                  'bold'                               => false,
                  ),
		
				 array (
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Telefon 1',
				  'control_name'                       => 'company_contact_tel1',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_contact_tel1',													
				  'db_field'                           => 'company_contact_tel1',
				  'value'                              => '', 
				  'maxlength'                          => '30',
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
				  'title'                              => 'Telefon 2',
				  'control_name'                       => 'company_contact_tel2',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_contact_tel2',													
				  'db_field'                           => 'company_contact_tel2',
				  'value'                              => '', 
				  'maxlength'                          => '30',
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
				  'title'                              => 'Fax 1',
				  'control_name'                       => 'company_contact_fax1',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_contact_fax1',													
				  'db_field'                           => 'company_contact_fax1',
				  'value'                              => '', 
				  'maxlength'                          => '30',
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
				  'title'                              => 'Fax 2',
				  'control_name'                       => 'company_contact_fax2',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => 'company_contact_fax2',													
				  'db_field'                           => 'company_contact_fax2',
				  'value'                              => '', 
				  'maxlength'                          => '30',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => '',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),					   		
				 array (
				  'type'                               => FIELD_TYPE_EDITOR_CKEDITOR,
				  'title'                              => 'Descriere',
				  'control_name'                       => 'company_contact_description',
				  'control_id'                         => 'company_contact_description',
				  'db_field'                           => 'company_contact_description',
				  'value'                              => '', 
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Completati descrierea sectiunii de contact',
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
		
					   

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}