<?php

class archive_clienti extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'clients';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $permission_delete_item             = 1;
	public  $archive_title			        	= 'Panou editare';
	public  $archive_icon_class     			= 'fa fa-user';
	
	public  $list_archive_title			    	= 'Lista clienti';					/* Title of archive list */
	public  $list_archive_title_for_export    	= 'Lista clienti';					/* Title of exported archive list */
	public  $list_archive_icon_class        	= 'fa fa-users';					/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga client';
	public  $list_edit_item_button_name         = 'Detalii';
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil"></i> Detalii Client','tab_client_general'),
													array('<i class="icon-users"></i> Reprezentanti','tab_article_reprezentanti'),
													array('<i class="fa fa-file-text-o"></i> Contracte','tab_article_contracte'),
													array('<i class="fa fa-files-o"></i> Fisiere client','tab_upload_multiple_type_files'),													
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Clientii societatii';
	public  $archive_title_top_small        	= '';
	
	public  $del_item_message                   = 'Confirmati stergerea clientului <strong>%</strong> ?';
	public  $activate_menuitem_id           	= 20;
	public  $list_fields_for_export    			= array(
													array('Nume','name'),
													array('Adresa','address'),
													array('Telefon','phone'),
													array('E-mail','email'),
													array('CNP','cnp'),													
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
	public $list_fields = array(
                  array (
                  'title'                              => '<i class="fa fa-user"></i> Client',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'search_content',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																
				  'width'                              => '',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-4 col-sm-3 col-md-4 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_nume_client', /* Method must have parameter "$result_line" */
                   ),				   
                  array (
                  'title'                              => 'Tip',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'type',
				  'filter'                             => array (
																  'type'    => LFT_COMBO_CUSTOM,																  
																  'options' => array(
																				   array ( 'value' =>  '',  'title' => 'Orice', ),
																				   array ( 'value' =>  '1', 'title' => 'PF-Persoana fizica', ),
																				   array ( 'value' =>  '2', 'title' => 'PJ-Persoana juridica', ),
																				),																  
																),				  																				  
				  'width'                              => '90',
				  'sortable'                           => false,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_tip_client', /* Method must have parameter "$result_line" */
                   ),
				   
                  array (
                  'title'                              => '<i class="fa fa-phone"></i> Telefon',
				  'type'                               => FIELD_PHONE,
				  'db_field'                           => 'phone',
				  'width'                              => '8%',
				  'sortable'                           => false,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
                  array (
                  'title'                              => '<i class="fa fa-envelope"></i> E-mail',
				  'type'                               => FIELD_EMAIL,
				  'db_field'                           => 'email',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-sm hidden-xs hidden-md',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
				   /*
                  array (
                  'title'                              => 'Sectiuni',
				  'type'                               => FIELD_FUNCTION,			
				  'db_field'                           => 'type',
				  'width'                              => '',
				  'sortable'                           => false,
				  'style-classes'                      => '',   
				  'responsive-classes'                 => 'hidden-sm hidden-xs',   
				  'function'                           => 'lf_operatiuni', 
                   ),
				   */
				   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);		
		
		if (!$this->user_rights_by_admin['administrator']) {
			/* atentie: tab-urile se elimina de la dreapta la stanga */
			if ($this->user_rights_by_admin['permission_tab_fisiere']==0) {
				array_splice($this->tabs, 3,1);
			}
			if ($this->user_rights_by_admin['permission_tab_contracte']==0) {
				array_splice($this->tabs, 2,1);
			}
			if ($this->user_rights_by_admin['permission_tab_reprezentanti']==0) {
				array_splice($this->tabs, 1,1);
			}			
		}
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_WARNING); 
		//$this->AddAlert('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_DANGER,'fa fa-bell-o fa-lg'); 
		//$this->AddAlert('Acesta este o alta alerta', MSG_INFO, 'icon-user'); 
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ShowEdit($id) {
		$breadcrumb_title = '';
		$id_decript = el_decript_info($id);
		if ($id_decript!=0) { 
			global $oDB;
			$client_name = '';
			$query  = "SELECT name FROM ".$this->real_table_name." WHERE id=$id_decript";
			$result = $oDB->db_query($query);
			if ($result_line = $oDB->db_fetch_array($result)) {
				$client_name = $result_line['name'];
			}			
			$breadcrumb_title = 'Panou client';
			$this->archive_title = 'Panou client [ <span class="font-green-sharp bold uppercase">'.$client_name.'</span> ]';
			} else { $this->archive_title = 'Adaugare client'; $breadcrumb_title = $this->archive_title;}
		$this->AddItemToBreadcrumbs($this->list_archive_title, $this->LinkToList($this->archtype));
		$this->AddItemToBreadcrumbs($breadcrumb_title, '');
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteAfterInsert(){
		$ERROR_MSG = '';
		global $oDB;
		$id_user = $this->user_id;
		$inserted_id = 0;
		$query = "SELECT MAX(id) AS last_id FROM $oDB->clients WHERE add_by=$id_user";
		$result = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$inserted_id = $result_line['last_id'];
		} else {
			$ERROR_MSG = 'Eroare determinare ID inserat';
		}
		if (empty($ERROR_MSG)) {
			$this->update_other_fields($inserted_id);
			adm_AddTrackingInfo('Finalizeaza ADAUGARE CLIENT in : '.$this->list_archive_title);
		}
		return $ERROR_MSG;
	}			
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteAfterUpdate($id){
		$this->update_other_fields($id);
		parent::ExecuteAfterUpdate($id);
	}			
	/* ------------------------------------------------------------------------------------- */
	public function update_other_fields($id_client){
		global $oDB;
		$query = "			
			SELECT $oDB->clients.* 
			FROM $oDB->clients 
			WHERE $oDB->clients.id = $id_client";
			$result = $oDB->db_query($query);		
		$search_content    = '';
		if ($result_line = $oDB->db_fetch_array($result)) {
			if ($result_line['type']==1) {
				/* client persoana fizica */
				$search_content = addslashes($result_line['name'].' '.$result_line['address'].' '.$result_line['judet'].' '.$result_line['country'].' '.$result_line['cnp'].$result_line['identity_document']);
			} else {
				/* client persoana juridica */
				$search_content = addslashes($result_line['name'].' '.$result_line['address'].' '.$result_line['judet'].' '.$result_line['country'].' '.$result_line['pj_cui'].$result_line['pj_reg_com']);
			}
		}
		
		$query = "
			UPDATE $oDB->clients SET 
			search_content='$search_content' 			
			WHERE id=$id_client";
		$result = $oDB->db_query($query);
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_operatiuni($result_line){
		//$link_reprezentanti = $this->LinkToEditItem($result_line['id'], 'clienti').'&tab=2';
		$link_contracte     = $this->LinkToEditItem($result_line['id'], 'clienti').'&tab=3';
		$link_fisiere       = $this->LinkToEditItem($result_line['id'], 'clienti').'&tab=4';
		$link_reprezentanti = $this->LinkToEditItem($result_line['id'], 'clienti').'&tab=2';
		$ret_value = '		
		<a href="'.$link_contracte.'" class="btn btn-default btn-icon-only" title="Contracte client"><i class="fa fa-file-text-o"></i></a>
		<a href="'.$link_fisiere.'" class="btn btn-default btn-icon-only" title="Fisiere client"><i class="fa fa-files-o"></i></a>
		<a href="'.$link_reprezentanti.'" class="btn btn-default btn-icon-only hidden-sm hidden-md hidden-xs" title="Reprezentanti client"><i class="icon-users"></i></a>		
		';
		
		return $ret_value;
	}
	/* ------------------------------------------------------------------------------------- */		
	public function lf_tip_client($result_line){		
		//$ret_value = ($result_line['type']!=1 ? '<i class="fa fa-bank" title="Persoana juridica"></i>' : '<i class="fa fa-user" title="Persoana fizica"></i>');		
		return ($result_line['type']!=1 ? '<i class="fa fa-bank" title="Persoana juridica"></i>' : '<i class="fa fa-user" title="Persoana fizica"></i>');
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function lf_nume_client($result_line, $link_to_edit){
		if ($result_line['type']==1) {
			/* persoana fizica */
			$info_client = $result_line['cnp'].(!empty($result_line['identity_document']) ? ', '.$result_line['identity_document'] : '');
		} else {
			$info_client = $result_line['pj_cui'].(!empty($result_line['pj_reg_com']) ? ', '.$result_line['pj_reg_com'] : '');
		}
		return '<a href="'.$link_to_edit.'">'.$result_line['name'].'</a><br /><span class="font-normal">'.$result_line['address'].', '.$result_line['judet'].', '.$result_line['country'].'<br />'.$info_client.'</span>';
	}		
	/* ------------------------------------------------------------------------------------- */	
}