<?php

class tab_setari_fp extends tab {
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
                  'control_name'                       => 'fp_meta_title',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'fp_meta_title',													
                  'db_field'                           => 'fp_meta_title',
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
                  'control_name'                       => 'fp_meta_description',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'fp_meta_description',													
                  'db_field'                           => 'fp_meta_description',
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
                  'control_name'                       => 'fp_meta_keywords',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'fp_meta_keywords',													
                  'db_field'                           => 'fp_meta_keywords',
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
				  
				 array (
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => 'Poza 1 slider',
				  'control_name'                       => 'slider_1',
				  'input_type'                         => 'slider_1',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'slider_1',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati poza 1 pentru slider',
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
				 array (
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => 'Poza 2 slider',
				  'control_name'                       => 'slider_2',
				  'input_type'                         => 'slider_2',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'slider_2',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati poza 2 pentru slider',
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
				 array (
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => 'Poza 3 slider',
				  'control_name'                       => 'slider_3',
				  'input_type'                         => 'slider_3',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'slider_3',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati poza 3 pentru slider',
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