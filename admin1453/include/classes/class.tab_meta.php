<?php

class tab_meta extends tab {
	public  $show_sidebar             = false;					/* will display right sidebar info (only if $this->edit_tab==true ) */
	public  $label_size               = 2;
	public  $sidebar_width            = 4;						/* no between 2 and 10 */			
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Meta title',
                  'control_name'                       => 'meta_title',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'meta_title',													
                  'db_field'                           => 'meta_title',
                  'value'                              => '', 
                  'maxlength'                          => '76',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti META TITLE !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Meta description',
                  'control_name'                       => 'meta_description',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'meta_description',													
                  'db_field'                           => 'meta_description',
                  'value'                              => '', 
                  'maxlength'                          => '240',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti META DESCRIPTION !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Meta keywords',
                  'control_name'                       => 'meta_keywords',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'meta_keywords',													
                  'db_field'                           => 'meta_keywords',
                  'value'                              => '', 
                  'maxlength'                          => '200',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti META KEYWORDS !',
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