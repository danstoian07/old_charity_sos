<?php

class tab_sectie_general extends tab {
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
				  'type'                               => FIELD_TYPE_TEXT,
				  'title'                              => 'Stil link',
				  'control_name'                       => 'slug',
				  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => true,				    /* if true, the field value will be unique in the archive table for a given id_archive */
				  'control_id'                         => '',													
				  'db_field'                           => 'slug',
				  'value'                              => '', 
				  'maxlength'                          => '100',
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Introduceti stilul link-ului !',
				  'placeholder'                        => '',
				  'pattern'                            => '',
				  'column_size'                        => '9',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'hide_on_add'                    	   => true,                             /* hide field for add operation */				  
				  'icon'                    		   =>  array(
																 array (
																  'class'              	=> 'fa fa-link', 
																  'type'       			=> '1',		 		          /* 0 - normal, 1 - boxed */	
																  'position'            => '1',           	       	  /* 0 - left, 1 - right  */
																  'color'               => 'font-dark',  	          /* Ex: font-red, font-purple, etc..; Empty for default  */
																  ),
															),															
					   ),
				array (
                  'type'                               => FIELD_TYPE_SELECT_FILE,
                  'title'                              => 'Poza de profil articol [750 x 565]',
                  'control_name'                       => 'featured_image',
				  'input_type'                         => 'featured_image',
				  'unique'							   => false,
                  'control_id'                         => '',                  
                  'db_field'                           => 'featured_image',
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => false,
				  'show_preview'                       => true,
                  'required_message'                   => 'Introduceti poza articolului',
                  'placeholder'                        => '',
                  'pattern'                            => '',
			      'column_size'                        => '',
			      'width'                        	   => '',
				  'show_in_sidebar'                    => true, 
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
                  'title'                              => 'Descriere poza (tag ALT)',
                  'control_name'                       => 'image_description',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',
                  'db_field'                           => 'image_description',
                  'value'                              => '', 
                  'maxlength'                          => '100',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Introduceti descrierea pozei',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
                       ),
                  array (
                  'type'                               => FIELD_TYPE_CHECKBOX,
                  'title'                              => 'Afisare poza',
                  'style'                              => 0,                                  
                  'column_size'                        => '',
				  'show_in_sidebar'                    => true,
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Afiseaza poza in corpul articolului', 
                                                                      'control_name'                       => 'show_image_in_body',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => true,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'show_image_in_body',
                                                                  ),																  
                                                          ),
                  ),
					   
                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'SETARI META',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-cog',
                  'bold'                               => false,
				  'show_in_sidebar'                    => true,
                  ),

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
				  'show_in_sidebar'                    => true,
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
				  'show_in_sidebar'                    => true,
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
				  'show_in_sidebar'                    => true,
                       ),
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'Tip articol',
                  'control_name'                       => 'type',
                  'db_field'                           => 'type',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul articolului',
                  'column_size'                        => '',
                  'width'                              => '',                                                                                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '0',  'selected' => false, 'title'   => 'Continut website', ),
                                                               ),
                        ),

                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Titlu articol',
                  'control_name'                       => 'name',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'name',
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti articolului !',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => 'font-bold',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
					   
				/*
                  array (
                  'type'                               => FIELD_TYPE_COMBO_WITH_SEARCH,
                  'title'                              => 'Categorie articol',
                  'control_name'                       => 'id_ctr',
				  'db_field'                           => 'idma',
                  'control_id'                         => '',
                  'query_table'                        => 'categories',                         
                  'db_field_value'                     => 'id',
                  'db_field_title'                     => 'name',
                  'id_archive'                         => 20,
                  'order_by_field'                     => 'name',
                  'order_direction'                    => 'ASC',
                  'limit_items'                        => 1000,
                  'first_line_message'                 => 'Selectati categoria',              
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati o categorie',
                  'column_size'                        => '',
                  'width'                              => '',
                        ),
					   
				*/
				 array (
				  'type'                               => FIELD_TYPE_EDITOR_CKEDITOR,
				  'title'                              => 'Descriere',
				  'control_name'                       => 'description',
				  'control_id'                         => 'description',
				  'db_field'                           => 'description',
				  'value'                              => '', 
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Completati descrierea sectiei',
				  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
					   ),
					   
				 array (
				  'type'                               => FIELD_TYPE_TAGS_INPUT,
				  'title'                              => 'Tag-uri articol',
				  'control_name'                       => 'tags',
				  'control_id'                         => 'tags',													
				  'db_field'                           => 'tags',
				  'value'                              => '', 
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Introduceti tagu-uri articol !',
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
					   ),
				  
				  
				  /*
                  array (
                  'type'                               => FIELD_TYPE_CHECKBOX,
                  'title'                              => 'Afiseaza',
                  'style'                              => 0,                                  
                  'column_size'                        => '',
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Afiseaza in dreapta ULTIMELE EVENIMENTE', 
                                                                      'control_name'                       => 'show_right_events',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => true,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'show_right_events',
                                                                  ),
                                                                 array (
                                                                      'title'                              => 'Afiseaza in dreapta ANUNURI ', 
                                                                      'control_name'                       => 'show_right_impresii',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => true,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'show_right_impresii',
                                                                  ),
																  
                                                          ),
                  ),
				*/   
				 array (
				  'type'                               => FIELD_TYPE_SELECT_FILE,
				  'title'                              => 'Redirecteaza catre',
				  'control_name'                       => 'redirect_to',
				  'input_type'                         => 'image_link',
				  'unique'							   => false,
				  'control_id'                         => '',                  
				  'db_field'                           => 'redirect_to',
				  'value'                              => '', 
				  'maxlength'                          => '1500',
				  'read_only'                          => false,
				  'required'                           => false,
				  'required_message'                   => 'Selectati/introduceti link-ul de redirectare',
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
	public function program_sectie($json_value='') {
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
	public function meniu_personalizat($json_value='') {
		/* botstrap max columns: 10 */
		/* method will return an array with itinerary rows */
		global $oDB;
		$arr_content = array();		
		
		if ($json_value=='[]') {
			/* este adaugare */
			$content = '
				<div class="col-md-5">
					<input type="text" name="meniu" placeholder="Titlu meniu" class="form-control" /> 
				</div>
				<div class="col-md-5">
					<input type="text" name="link" placeholder="Link" class="form-control" /> 
				</div>					
			'.PHP_EOL;
			array_push($arr_content, $content);
		} else {
			/* modificare */
			$arr_items = json_decode($json_value, true);
			$FIELDS_NO = 2;
			$ITEMS_NO  = count($arr_items);
			for ($i = 0; $i < $ITEMS_NO; $i = $i+$FIELDS_NO) {
				$content = '
				<div class="col-md-5">
					<input type="text" name="meniu" placeholder="Titlu meniu" class="form-control" value="'.$arr_items[$i]['value'].'" /> 
				</div>
				<div class="col-md-5">
					<input type="text" name="link" placeholder="Link" class="form-control" value="'.$arr_items[$i+1]['value'].'" /> 
				</div>									
				'.PHP_EOL;
				array_push($arr_content, $content);
			}
		}
		return $arr_content;
	}			
	/* ------------------------------------------------------------------------------------- */
	
}