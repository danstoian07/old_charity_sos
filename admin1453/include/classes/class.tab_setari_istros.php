<?php

class tab_setari_istros extends tab {
	public  $show_sidebar             = false;					/* will display right sidebar info (only if $this->edit_tab==true ) */
	public  $label_size               = 2;
	public  $sidebar_width            = 4;						/* no between 2 and 10 */			
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 
				 array (
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => 'Aparitii editoriale (PDF)',
				  'control_name'                       => 'aparitii_istros',
				  'input_type'                         => 'image_link',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'aparitii_istros',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati/introduceti link-ul catre aparitiile editurii Istros',
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
				  'title'                              => 'Oferta de carte pentru vanzare (PDF)',
				  'control_name'                       => 'oferta_istros',
				  'input_type'                         => 'image_link',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'oferta_istros',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati/introduceti link-ul catre oferta editurii Istros',
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