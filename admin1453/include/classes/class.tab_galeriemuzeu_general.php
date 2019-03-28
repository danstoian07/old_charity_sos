<?php

class tab_galeriemuzeu_general extends tab {
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
                  'type'                               => FIELD_TYPE_CHECKBOX,
                  'title'                              => 'Vizibilitate',
                  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
                  'column_size'                        => '',
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Afisul este vizibil in colectie', 
                                                                      'control_name'                       => 'visible',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => true,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'visible',
                                                                  ),
                                                          ),
					'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
                  ),					   
			     array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Index afisare',
                  'control_name'                       => 'display_index',
                  'input_type'                         => 'number',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',
                  'db_field'                           => 'display_index',
                  'value'                              => '0', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti indexul de afisare !',
                  'placeholder'                        => '',
                  'pattern'                            => '\d*',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
                       ),
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'An poza',
                  'control_name'                       => 'year',
                  'db_field'                           => 'year',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati anul',
                  'column_size'                        => '',
                  'width'                              => '',                                                                                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '2005',  'selected' => false, 'title'   => '2005', ),
																   array ( 'value' =>  '2006',  'selected' => false, 'title'   => '2006', ),
																   array ( 'value' =>  '2007',  'selected' => false, 'title'   => '2007', ),
																   array ( 'value' =>  '2008',  'selected' => false, 'title'   => '2008', ),
																   array ( 'value' =>  '2009',  'selected' => false, 'title'   => '2008', ),
																   array ( 'value' =>  '2010',  'selected' => false, 'title'   => '2010', ),
																   array ( 'value' =>  '2011',  'selected' => false, 'title'   => '2011', ),
																   array ( 'value' =>  '2012',  'selected' => false, 'title'   => '2012', ),
																   array ( 'value' =>  '2013',  'selected' => false, 'title'   => '2013', ),
																   array ( 'value' =>  '2014',  'selected' => false, 'title'   => '2014', ),
																   array ( 'value' =>  '2015',  'selected' => false, 'title'   => '2015', ),
																   array ( 'value' =>  '2016',  'selected' => false, 'title'   => '2016', ),
																   array ( 'value' =>  '2017',  'selected' => true, 'title'   => '2017', ),
																   array ( 'value' =>  '2018',  'selected' => false,  'title'   => '2018', ),
																   array ( 'value' =>  '2019',  'selected' => false, 'title'   => '2019', ),
																   array ( 'value' =>  '2020',  'selected' => false, 'title'   => '2020', ),
																   array ( 'value' =>  '2021',  'selected' => false, 'title'   => '2021', ),
																   array ( 'value' =>  '2022',  'selected' => false, 'title'   => '2022', ),
																   array ( 'value' =>  '2023',  'selected' => false, 'title'   => '2023', ),
																   array ( 'value' =>  '2024',  'selected' => false, 'title'   => '2024', ),
																   array ( 'value' =>  '2025',  'selected' => false, 'title'   => '2025', ),
																   array ( 'value' =>  '2026',  'selected' => false, 'title'   => '2026', ),
																   array ( 'value' =>  '2027',  'selected' => false, 'title'   => '2027', ),
																   array ( 'value' =>  '2028',  'selected' => false, 'title'   => '2028', ),
																   array ( 'value' =>  '2029',  'selected' => false, 'title'   => '2029', ),
																   array ( 'value' =>  '2030',  'selected' => false, 'title'   => '2030', ),
                                                               ),
                        ),
					   
				 array (
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => '<strong>Poza (800 x ???)</strong>',
				  'control_name'                       => 'featured_image',
				  'input_type'                         => 'featured_image',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'featured_image',
				  'value'                              => '', 
				  'maxlength'                          => '',
				  'read_only'                          => false,
				  'required'                           => true,
				  'show_preview'                       => true,
				  'required_message'                   => 'Selectati poza afisului',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '',
				  'width'                        	   => '',
				  'icon'                    		   =>  array(
																 array (
																  'class'              => 'fa fa-photo',
																  'type'       	       => '1',
																  'color'              => 'font-red',  			
																 ),				  
															),
					   ),																							
			     array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Descriere',
                  'control_name'                       => 'name',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',
                  'db_field'                           => 'name',
                  'value'                              => '', 
                  'maxlength'                          => '500',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti eticheta pentru poza 1',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
			     array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Eticheta',
                  'control_name'                       => 'download',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',
                  'db_field'                           => 'download',
                  'value'                              => '', 
                  'maxlength'                          => '10',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti eticheta pentru poza 1',
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