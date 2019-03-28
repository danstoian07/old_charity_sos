<?php

class tab_setari_ecris extends tab {
	public  $show_sidebar             = false;					/* will display right sidebar info (only if $this->edit_tab==true ) */
	public  $label_size               = 2;
	public  $sidebar_width            = 4;						/* no between 2 and 10 */			
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 
                array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'SETARI SINCRONIZARE DOSARE CU SISTEMUL ECRIS',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-folder',
                  'bold'                               => false,
                ),
					   
				array (
				  'type'                               => FIELD_TYPE_CHECKBOX,
				  'title'                              => 'Sincronizare automata date',
				  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
				  'column_size'                        => '',
				  'fields'                             => array(
																 array (
																	  'title'                              => 'Aplicatia sincronizeaza automat datele dosarelor cu cele din sistemul ECRIS', 
																	  'control_name'                       => 'ecris_import_automat',
																	  'control_id'                         => '',
																	  'checked'                            => false,
																	  'read_only'                          => false,
																	  'db_field'                           => 'ecris_import_automat',
																	  'help_message'                       => 'Daca este bifata aceasta optiune, aplicatia va actualiza/sincroniza automat datele dosarelor cu cele din sistemul ECRIS (informatii dosar, termene si parti din dosar).',
																  ),
																  
														  ),
				),
				  
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => 'Trimitere e-mail la sincronizare',
                  'control_name'                       => 'ecris_send_mail',
                  'db_field'                           => 'ecris_send_mail',
                  'control_id'                         => 'ecris_send_mail',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati ',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'help_message'                       => 'Este valabila doar daca este activa <strong>Sincronizare automata date</strong>. In cazul in care apar noutati la dosar (in urma procesului de sincronizare cu sistemul ECRIS) aplicatia poate trimite e-mail-uri de informare celor responsabili de dosar',
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '1',
																		   'title' 	  => 'Trimite e-mail de informare doar responsabililor de dosar',
																		   'selected' => true, /* default selected */
                                                                           'fields'   => array(                                                                                                
																						),
                                                                   ),
																   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '2',
																		   'title' 	  => 'Trimite e-mail de informare responsabililor de dosar dar si la adresele ...',
																		   'selected' => false, /* default selected */
                                                                           'fields'   => array( 
																						/* ----------------------------- */
																							 array (
																							  'type'                               => FIELD_TYPE_ITINERARY,
																							  'title'                              => '',
																							  'button_title'                       => 'Adauga adresa e-mail',
																							  'portlet_box'                        => false,
																							  'portlet_color_scheme'               => 'blue-hoki', /* can be: red, green, grey, default,  blue-hoki, etc*/
																							  'portlet_icon'                       => 'fa fa-list-ol',
																							  'portlet_title'                      => 'Adrese suplimentare',
																							  'class_method_for_content'           => 'adrese_suplimentare_2',
																							  'header'           				   => '<div class="col-md-10">Trimit informare si la adresele de e-mail:</div>',
																							  'sortable'                      	   => true, /* can swap line/rows if true */
																							  'control_name'                       => 'json_emails_2',
																							  'control_id'                         => 'json_emails_2',
																							  'db_field'                           => 'json_emails_2',
																							  'maxnestedlevel'                     => 0, 					
																							  'value'                              => '', 
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Trebuie sa existe cel putin o adresa suplimentara',
																							  'column_size'                        => '',			         
																							  'width'                        	   => '',					 
																								   ),																							
																						
																						/* ----------------------------- */
																						),
                                                                   ),													
																   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '3',
																		   'title' 	  => 'Trimite e-mail de informare doar la adresele ...',
																		   'selected' => false, /* default selected */
                                                                           'fields'   => array(
																						/* ----------------------------- */
																							 array (
																							  'type'                               => FIELD_TYPE_ITINERARY,
																							  'title'                              => '',
																							  'button_title'                       => 'Adauga adresa e-mail',
																							  'portlet_box'                        => false,
																							  'portlet_color_scheme'               => 'blue-hoki', /* can be: red, green, grey, default,  blue-hoki, etc*/
																							  'portlet_icon'                       => 'fa fa-list-ol',
																							  'portlet_title'                      => 'Adrese suplimentare',
																							  'class_method_for_content'           => 'adrese_suplimentare_3',
																							  'header'           				   => '<div class="col-md-10">Trimit informare doar la adresele de e-mail:</div>',
																							  'sortable'                      	   => true, /* can swap line/rows if true */
																							  'control_name'                       => 'json_emails_3',
																							  'control_id'                         => 'json_emails_3',
																							  'db_field'                           => 'json_emails_3',
																							  'maxnestedlevel'                     => 0, 					
																							  'value'                              => '', 
																							  'read_only'                          => false,
																							  'required'                           => false,
																							  'required_message'                   => 'Trebuie sa existe cel putin o adresa de e-mail',
																							  'column_size'                        => '',			         
																							  'width'                        	   => '',					 
																								   ),																							
																						
																						/* ----------------------------- */																		   
																						),
                                                                   ),																													   
                                                                   /* ---------------------------------------------- */
                                                                   array ( 
                                                                           'value'    => '0',
																		   'title' 	  => 'Nu trimite e-mail de informare',
																		   'selected' => false, /* default selected */
                                                                           'fields'   => array(                                                                                                
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
	public function adrese_suplimentare_2($json_value='') {
		/* botstrap max columns: 10 */
		/* method will return an array with itinerary rows */
		global $oDB;
		$arr_content = array();		
		
		if ($json_value=='[]') {
			/* este adaugare */
			$content = '
				<div class="col-md-10">
					<input type="email" name="adresa" placeholder="Adresa e-mail" class="form-control" required /> 
				</div>
			'.PHP_EOL;
			array_push($arr_content, $content);
		} else {
			/* modificare */
			$arr_items = json_decode($json_value, true);
			$FIELDS_NO = 1;
			$ITEMS_NO  = count($arr_items);
			for ($i = 0; $i < $ITEMS_NO; $i = $i+$FIELDS_NO) {
				$content = '
				<div class="col-md-5">
					<input type="email" name="adresa" placeholder="Adresa e-mail" class="form-control" value="'.$arr_items[$i]['value'].'" required /> 
				</div>
				'.PHP_EOL;
				array_push($arr_content, $content);
			}
		}
		return $arr_content;
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function adrese_suplimentare_3($json_value='') {
		/* botstrap max columns: 10 */
		/* method will return an array with itinerary rows */
		global $oDB;
		$arr_content = array();		
		
		if ($json_value=='[]') {
			/* este adaugare */
			$content = '
				<div class="col-md-10">
					<input type="email" name="adresa2" placeholder="Adresa e-mail" class="form-control" required /> 
				</div>
			'.PHP_EOL;
			array_push($arr_content, $content);
		} else {
			/* modificare */
			$arr_items = json_decode($json_value, true);
			$FIELDS_NO = 1;
			$ITEMS_NO  = count($arr_items);
			for ($i = 0; $i < $ITEMS_NO; $i = $i+$FIELDS_NO) {
				$content = '
				<div class="col-md-5">
					<input type="email" name="adresa2" placeholder="Adresa e-mail" class="form-control" value="'.$arr_items[$i]['value'].'" required /> 
				</div>
				'.PHP_EOL;
				array_push($arr_content, $content);
			}
		}
		return $arr_content;
	}		
	
}