<?php

class archive_parti extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'parts';
	public  $ida							    = 10;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Parti in dosar';
	public  $archive_icon_class     			= 'icon-users';
	
	public  $list_archive_title			    	= 'Lista parti in dosar';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'icon-users';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga parte in dosar';
	
	public  $tabs   			    			= array(
													array('Parte in dosar','tab_parte_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Reprezentanti';
	public  $archive_title_top_small        	= 'client';
	public  $activate_menuitem_id           	= -20;
	
	public $list_fields = array(	
                  array (
                  'title'                              => '<i class="fa fa-balance-scale"></i> Parti',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),
				  'width'                              => '',
				  'sortable'                           => true,
				  'function'                           => 'lf_parte', 
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
				  array (
                  'title'                              => 'Calitate',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'calitate',
				  'filter_type'                        => 'LFT_NOFILTER',
				  'width'                              => '10%',
				  'responsive-classes'                 => 'hidden-xs hidden-sm',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
				   
                  array (
                  'title'                              => '<i class="fa fa-phone"></i> Telefon',
				  'type'                               => FIELD_PHONE,
				  'db_field'                           => 'telefon',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
                  array (
                  'title'                              => '<i class="fa fa-envelope"></i> E-mail',
				  'type'                               => FIELD_EMAIL,
				  'db_field'                           => 'email',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-xs hidden-sm',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   				   

	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_WARNING); 
		//$this->AddAlert('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_DANGER,'fa fa-bell-o fa-lg'); 
		//$this->AddAlert('Acesta este o alta alerta', MSG_INFO, 'icon-user'); 
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ShowEdit($id) {		
		if ($this->lawyer_can_access_parte($id)) {
			if ($id!=0) { $this->archive_title = 'Editare detalii avocat';} else { $this->archive_title = 'Adaugare avocat';}
			parent::ShowEdit($id);
		} else {
			el_redirect(__ADMINURL__.'?pn=2&archtype=dosare');
		}		
	}
	
	/* ------------------------------------------------------------------------------------- */	
	public function lawyer_can_access_parte($id) {
		$id_decript = el_decript_info($id);
		$can_access = true;
		if (!$this->user_rights_by_admin['administrator']) {
			global $oDB;
			$rights_dosare = $this->GetArchiveUserRightsByAdmin('dosare');
			if ($rights_dosare['permission_view_neassociated_cases']==0) {
						$can_access = false;
						if (isset($_REQUEST['idma'])) {
							$id_dosar =  el_decript_info($_REQUEST['idma']);
							/* --- */
							$query ="SELECT id_options FROM $oDB->multiselect_options WHERE id_archive=20 AND id_main_item=$id_dosar";							
							$result = $oDB->db_query($query);			
							while ($result_line = $oDB->db_fetch_array($result)) {
								if ($result_line['id_options']==$this->user_id){
									$can_access = true;
									break;
								}			
							}
							/* --- */
							if ($can_access) {
								if ($id_decript>0) {
									/* verifica daca id-ul partii corespunde dosarului */
									$query = "SELECT COUNT(*) AS no FROM $oDB->parts WHERE id=$id_decript AND idma=$id_dosar";
									$result = $oDB->db_query($query);
									if ($result_line = $oDB->db_fetch_array($result)) {
										if ($result_line['no']!=1){
											$can_access = false;
										}										
									}
								}				
							}
							/* --- */
						}
			}
		}
		return $can_access;
	}			
	/* ------------------------------------------------------------------------------------- */
	public function lf_parte($result_line, $link_to_edit){
		return '<a href="'.$link_to_edit.'">'.stripslashes($result_line['name']).'</a>';
	}	
	/* ------------------------------------------------------------------------------------- */
}