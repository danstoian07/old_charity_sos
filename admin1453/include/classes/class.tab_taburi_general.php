<?php

class tab_taburi_general extends tab {
	public  $show_sidebar             = false;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $label_size               = 2;
	public  $sidebar_width            = 4;						/* no between 2 and 10 */			
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Denumire TAB',
                  'control_name'                       => 'name',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'name',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti denumirea categoriei !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
				 array (
				  'type'                               => FIELD_TYPE_EDITOR_CKEDITOR,
				  'title'                              => 'Continut TAB',
				  'control_name'                       => 'description',
				  'control_id'                         => 'description',
				  'db_field'                           => 'description',
				  'value'                              => '', 
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Completati descrierea categoriei de produse',
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),

			     array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Index afisare',
                  'control_name'                       => 'display_index',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'display_index',
                  'value'                              => '0', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti indexul d afisare !',
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