<?php

class tab_utilizator_rights extends tab {
	public  $show_sidebar             = true;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width            = 4;						/* no between 2 and 10 */
	/* ------------------------------------------------------------------------------------- */	
	public $show_line_between_fields = false;
	/* ------------------------------------------------------------------------------------- */	
	public $fields = 
		array(
                  array (                  
				  'type'                               => FIELD_TYPE_INFO,
				  'title'                              => '<strong>Important!<br>(pentru utilizatori cu drepturi limitate)</strong>',
                  'message_type'                       => MSG_WARNING,						/*can be: MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING */
				  'message'                            => '1) Daca este bifat inseamna ca utilizatorul va vedea in cadrul sectiunii doar inregistrarile adaugate de el. Nebifat: va vedea si inregistrarile adaugate de alti utilizatori.',
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'hide_on_add'                    	   => false,                            /* hide field for add operation */
                  ),                                                                                                                            					   
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_SWITCH,
                  'title'                              => '<strong>Tip utilizator</strong>',
                  'control_name'                       => 'type',
                  'db_field'                           => 'type',
                  'control_id'                         => 'type',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tipul switch',
                  'column_size'                        => '',
                  'width'                              => '',     /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   /* ---------------------------------------------- */
																   /*
                                                                   array ( 
                                                                           'value'         => '0',
																		   'title' 	       => 'Utilizator cu drepturi limitate',
																		   'selected'      => true, 
																		   'custom_fields' => true, 
                                                                           'fields'        => array( 
																						      ),
                                                                   ),
																   */
                                                                   /* ---------------------------------------------- */																   
                                                                   array ( 
                                                                           'value'    =>  '1', 
																		   'title'    => 'Administrator',
																		   'selected' => false,
                                                                           'fields'   => array( 
																							/* ----- */
																							/* ----- */
																						),
                                                                   ),
																   
																   /* ---------------------------------------------- */																   
                                                               ),
                  ),
				   array (
					'type'                               => FIELD_TYPE_TEXTAREA,
					'title'                              => '',
					'control_name'                       => 'json_rights',
					'control_id'                         => 'json_rights',
					'db_field'                           => 'json_rights',                  
					'value'                              => '', 
					'maxlength'                          => '',
					'read_only'                          => false,
					'required'                           => false,
					'hidden'                             => true,
					'required_message'                   => '',
					'placeholder'                        => '',
					'column_size'                        => '',
					'width'                              => '',        
					'rows'                               => '4',
					),
				  
		);
	/* ------------------------------------------------------------------------------------  */
	public function ReturnCustomFields($result_line='') {		
		/* in array-ul de mai jos, in nicio inregistrare, archtype nu trebuie sa aiba valoarea "administrator" */
		$arr_app_archives_rights = array (
			
			array (
			'name'                 	=> 'Profil utilizator',
			'description'          	=> 'Profilul utilizatorului este sectiunea (accesibila prin meniul utilizatorului din dreapta sus) prin care utilizatorul isi poate vizualiza/actualiza datele de profil.',
			'archtype'              => 'utilizator',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate vizualiza datele de profil',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) datele profilului',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 
										),
			),
		
			array (
			'name'                 	=> 'Utilizatori',
			'description'          	=> '',
			'archtype'              => 'utilizatori',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga inregistrari', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii avocati',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii avocati',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate sterge avocati',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta lista avocatilor',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Drepturi acces</strong>',
												  'rights_name'                        => 'permission_tab_drepturi_acces',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Monitorizare activitate</strong>',
												  'rights_name'                        => 'permission_tab_monitorizare',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 											 
											 
											 /* ---------------------- */
										),
			),
			array (
			'name'                 	=> 'Monitorizare Activitate',
			'description'          	=> 'Tab-ul <strong>Monitorizare activitate</strong> se afla in cadrul sectiunii <span class="font-green">Utilizatori</span>. ',
			'archtype'              => 'monitorizare',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii monitorizare',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate sterge informatiile de monitorizare',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
										),
			),
			
			array (
			'name'                 	=> 'Sectii muzeu',
			'archtype'              => 'sedii',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => false,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga inregistrari', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii sectie',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii sectie',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 
											 array (
												  'title'                              => 'Utilizatorul poate sterge sectia',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta inregistrarile',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 
										),
			),
			array (
			'name'                 	=> 'Clienti',
			'description'          	=> '',
			'archtype'              => 'clienti',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga clienti', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii client',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii client',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate sterge clienti',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta lista clientilor',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Reprezentanti client</strong>',
												  'rights_name'                        => 'permission_tab_reprezentanti',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Contracte</strong>',
												  'rights_name'                        => 'permission_tab_contracte',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza la tab-ul <strong>Fisiere client</strong>',
												  'rights_name'                        => 'permission_tab_fisiere',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
										),
			),
			array (
			'name'                 	=> 'Reprezentanti client',
			'description'          	=> 'Tab-ul <strong>Reprezentanti client</strong> se afla in cadrul sectiunii <span class="font-green">Clienti</span>. ',
			'archtype'              => 'reprezentanti',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => false,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga reprezentanti client', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii reprezentant',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii reprezentant',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 
											 array (
												  'title'                              => 'Utilizatorul poate sterge reprezentanti',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta reprezentanti',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 
										),
			),
			array (
			'name'                 	=> 'Contracte',
			'description'          	=> '',
			'archtype'              => 'contracte',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga contracte', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii contract',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii contract',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate sterge contracte',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta lista contracte',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Acte aditionale</strong>',
												  'rights_name'                        => 'permission_tab_acte_aditionale',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Dosare</strong>',
												  'rights_name'                        => 'permission_tab_dosare',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza la tab-ul <strong>Fisiere client</strong>',
												  'rights_name'                        => 'permission_tab_fisiere',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
										),
			),
			array (
			'name'                 	=> 'Acte aditionale',
			'description'          	=> 'Tab-ul <strong>Acte aditionale</strong> se afla in cadrul sectiunii <span class="font-green">Contracte</span>.',
			'archtype'              => 'acte_aditionale',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => false,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga acte aditionale la contract', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii act aditional',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii act aditional',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 
											 array (
												  'title'                              => 'Utilizatorul poate sterge acte aditionale',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta acte aditionale',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 
										),
			),
			array (
			'name'                 	=> 'Dosare',
			'description'          	=> '',
			'archtype'              => 'dosare',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede dosarele chiar daca nu i-au fost asociate', 
												  'rights_name'                        => 'permission_view_neassociated_cases',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga dosare', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii dosar',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii dosar',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate sterge dosare',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta lista dosare',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Parti in dosar</strong>',
												  'rights_name'                        => 'permission_tab_parti',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Termene</strong>',
												  'rights_name'                        => 'permission_tab_termene',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza tab-ul <strong>Activitati</strong>',
												  'rights_name'                        => 'permission_tab_activitati',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Afiseaza la tab-ul <strong>Fisiere client</strong>',
												  'rights_name'                        => 'permission_tab_fisiere',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
										),
			),
			array (
			'name'                 	=> 'Parti in dosar',
			'description'          	=> 'Tab-ul <strong>Parti in dosar</strong> se afla in cadrul sectiunii <span class="font-green">Dosare</span>.',
			'archtype'              => 'parti',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => false,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga parti in dosar', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii parte',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii parte',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 
											 array (
												  'title'                              => 'Utilizatorul poate sterge partile din dosar',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta partile',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 
										),
			),
			array (
			'name'                 	=> 'Termene dosar',
			'description'          	=> 'Tab-ul <strong>Termene</strong> se afla in cadrul sectiunii <span class="font-green">Dosare</span>.',
			'archtype'              => 'termene',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => false,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga un termen la dosar', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii termen',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii termen',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 
											 array (
												  'title'                              => 'Utilizatorul poate sterge termene din dosar',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta termene',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 
										),
			),
			array (
			'name'                 	=> 'Activitati dosar',
			'description'          	=> 'Tab-ul <strong>Activitati</strong> se afla in cadrul sectiunii <span class="font-green">Dosare</span>.',
			'archtype'              => 'activitati',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul vede doar inregistrarile adaugate de el (nebifat: le vede pe toate) <sup>1)</sup>', 
												  'rights_name'                        => 'user_view_only_own_records',
												  'checked'                            => false,
												  'read_only'                          => false,
											 ),			
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate adauga o activitate la dosar', 
												  'rights_name'                        => 'permission_add_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate accesa panou detalii activitate',
												  'rights_name'                        => 'permission_edit_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate actualiza (modifica) detalii activitate',
												  'rights_name'                        => 'permission_update_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 
											 array (
												  'title'                              => 'Utilizatorul poate sterge activitati din dosar',
												  'rights_name'                        => 'permission_delete_item',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 
											 /* ---------------------- */
											 array (
												  'title'                              => 'Utilizatorul poate exporta activitati',
												  'rights_name'                        => 'permission_export_archive',
												  'checked'                            => true,
												  'read_only'                          => false,
											 ),											 											 											 
											 /* ---------------------- */
											 
										),
			),
			array (
			'name'                 	=> 'Suport online',
			'description'          	=> '',
			'archtype'              => 'support',
			'value'              	=> 0,
			'rights' 				=> array(
											 /* ---------------------- */
											 /* ---------------------- */											 
										),
			),
			
			
		);
		
		if (!empty($result_line)) {
			/* este modificare */
			if (isset($result_line["json_rights"])) {
				/* ------------------------------------------------------- */
				foreach ($arr_app_archives_rights as $key => $archive) {
					$arr_checkbox = $archive['rights'];
					foreach ($arr_checkbox as $key2 => $checkbox) {
						$arr_app_archives_rights[$key]['rights'][$key2]['checked']=false;
					}
				}
				/* ------------------------------------------------------- */
				if (!empty($result_line["json_rights"])) {
					$arr_rights = json_decode($result_line["json_rights"], true);	 
					//print_r($arr_rights); die('');
					foreach ($arr_rights as $rights) {
						foreach ($arr_app_archives_rights as $key => $archive) {
							if ($archive['archtype']==$rights['name']) {
								$arr_app_archives_rights[$key]['value'] = $rights['value'];
							}
							//$field_name = str_replace($archive['archtype'].'_',"",$rights['name']);
							$arr_checkbox = $archive['rights'];
							foreach ($arr_checkbox as $key2 => $checkbox) {
								if ((($archive['archtype'].'_'.$checkbox['rights_name'])==$rights['name']) && ($rights['value']=='on')) {
									$arr_app_archives_rights[$key]['rights'][$key2]['checked']=true;
								}
							}
						}
					}
				}
				/* ------------------------------------------------------- */
			}
		}
		
		$str_to_return   = '<div id="rights_area">';
		
		foreach ($arr_app_archives_rights as $archive) {
			$archive_class_name = 'archive_'.$archive['archtype'];
			$eval_str           = "\$objArchive = new $archive_class_name(NULL,'');"; 
			eval($eval_str);
			$archive_name   = (isset($archive['name']) ? $archive['name'] : $objArchive->list_archive_title);
			$archive_desc   = (isset($archive['description']) ? $archive['description'] : '');
			$arr_fields     = (isset($archive['fields']) ? $archive['fields'] : array());
			$str_to_return .= '
							<hr class="hr2 border-grey-silver">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cog font-green"></i>
                                        <span class="caption-subject uppercase font-green font-bold">'.$archive_name.'</span>										
                                    </div>
                                </div>
								'.(!empty($archive_desc) ? '<p>'.$archive_desc.'</p>' : '').'
							</div>'.PHP_EOL;	
			$str_to_return .= $this->ReturnRightsFieldsForArchive($archive['archtype'], $archive_name, $archive['value']);
			
			$cb_style        = 0; /* poate fi 0 sau 1 */
			$checkbox_fields = '';
			$arr_rights      = $archive['rights'];
			foreach ($arr_rights as $row) {
				$id               = 'id_'.$archive['archtype'];
				$checked          = ((isset($row['checked']) && $row['checked']==true ) ? 'checked="checked"' : '');
				$read_only        = ((isset($row['read_only']) && ($row['read_only']==true)) ? 'disabled="disabled"' : '');
				$checkbox_fields .= '
											<label class="mt-checkbox '.($cb_style==0 ? 'mt-checkbox-outline' : '').'"> '._($row['title']).'
												<input class="el_rights_ckb" type="checkbox" '.$checked.' '.$read_only.' name="'.$archive['archtype'].'_'.$row['rights_name'].'" '.$id.' />
												<span></span>
											</label>'.PHP_EOL;
				
			}
			$COLUMN_SIZE     = 12 - $this->label_size;
			$str_to_return  .= '
						<div class="form-group" id="'.$archive_class_name.'" style="display:none;">
							<label class="col-md-'.$this->label_size.' control-label">
								<!--<span class="required"> * </span>-->
							</label>
							<div class="col-md-'.$COLUMN_SIZE.'">
									<div class="'.($cb_style ? 'mt-checkbox-inline' : 'mt-checkbox-list').' pt0">
										'.$checkbox_fields.'
									</div>	                                        
							</div>
						</div>'.PHP_EOL;
			
		}
		$str_to_return .='</div>';
		return $str_to_return;
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ReturnRightsFieldsForArchive($archive_archtype, $archive_name, $archive_value) {
		$str_rights = '';
		$COLUMN_SIZE         = 12 - $this->label_size;
		$REQUIRED            = 'Selectati o optiune';
		$CONTROL_WIDTH_CLASS = '';
		$combo_attributes = '<option value="0" '.($archive_value==0 ? 'selected' : '').'>User-ul NU ARE ACCES la sectiunea '.$archive_name.'</option><option value="1" '.($archive_value==1 ? 'selected' : '').'>User-ul ARE ACCES la sectiunea '.$archive_name.'</option>'.PHP_EOL;
		$str_rights .= '
			<div class="form-group">
				<label class="col-md-'.$this->label_size.' control-label">Drepturi acces:
					<span class="required"> * </span>
				</label>
				<div class="col-md-'.$COLUMN_SIZE.'">
					<select oninvalid="this.setCustomValidity(\''.$REQUIRED.'\')" onchange="try{this.setCustomValidity(\'\')}catch(e){}" class="form-control '.$CONTROL_WIDTH_CLASS.' el_rights" name="'.$archive_archtype.'" '.(true ? 'required=""' : '').' '.(false ? 'readonly=""' : '').'>
						'.$combo_attributes.'
					</select>
				</div>
			</div>'.PHP_EOL;
		
		
		return $str_rights;
	}
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}