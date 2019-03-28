<?php

class archive_contracte extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'contracts';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare detalii contract';
	public  $archive_icon_class     			= 'fa fa-file-text-o';

	public  $list_archive_title			    = 'Lista contracte';					/* Title of archive list */
	public  $list_add_button_name           = 'Adauga contract';					/* Add button value */
	public  $list_archive_icon_class        = 'fa fa-file-text-o';					/* icon for title of archive list */
	public  $list_edit_item_button_name     = 'Detalii';
	
	public  $tabs   			    			= array(
													array('Contract','tab_contract_general'),
													array('<i class="fa fa-plus"></i> Acte aditionale','tab_article_acte_aditionale'),
													array('<i class="fa fa-file-text-o"></i> Dosare','tab_article_dosare'),
													array('<i class="fa fa-files-o"></i> Fisiere la contract','tab_upload_multiple_type_files'),
													array('<i class="fa fa-user-secret"></i> Beneficiari contract','tab_article_beneficiari'),
													array('<i class="fa fa-money"></i> Incasari','tab_article_incasari'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Contracte societate';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 40;								/* id of menuitem wich will be active when panel show */
	
	public $list_fields = array(
                  array (
                  'title'                              => 'Info Contract',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'search_content',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																
				  'width'                              => '',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-4 col-sm-3 col-md-4 col-lg-4',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_contract',    /* Method must have parameter "$result_line" */
                   ),
                  array (
                  'title'                              => 'Data',
				  'type'                               => FIELD_DATE,
				  'db_field'                           => 'contract_data',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'responsive-classes'                 => 'col-xs-6 col-sm-6 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'sortable'                           => true,
                   ),

                  array (
                  'title'                              => 'Locatie',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'id_sediu',
				  'filter'                             => array (
																  'type'               => LFT_COMBO_FROM_TABLE,
																  'query_table'        => 'sedii',
																  'db_field_title'     => 'name',
																  'db_field_value'     => 'id',
																  'first_line_message' => 'Orice locatie',
																  'id_archive'         => 0,
																  'order_by'     	   => 'name ASC', /* Ex: name ASC, id DESC */
																),				  																
				  'width'                              => '',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-md hidden-sm hidden-xs col-md-2 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_sediu',    /* Method must have parameter "$result_line" */
                   ),				   
				   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		$this->query_order_by  = "$this->real_table_name.contract_no DESC";
		
		if (!$this->user_rights_by_admin['administrator']) {
			/* atentie: tab-urile se elimina de la dreapta la stanga */
			if ($this->user_rights_by_admin['permission_tab_fisiere']==0) {
				array_splice($this->tabs, 3,1);
			}
			if ($this->user_rights_by_admin['permission_tab_dosare']==0) {
				array_splice($this->tabs, 2,1);
			}
			if ($this->user_rights_by_admin['permission_tab_acte_aditionale']==0) {
				array_splice($this->tabs, 1,1);
			}			
		}
		$this->query_order_by = "$this->real_table_name.date_add DESC";
		//$this->AddNotification($this->ListQuery(), MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
	}	
	/* ------------------------------------------------------------------------------------- */	
	
	public function ShowEdit($id) {
		global $oDB;		
		$id_contract   = el_decript_info($id);
		$id_client     = 0;
		$client_name   = '';
		$contract_no   = '';
		$contract_data = '';
		
		if (isset($_REQUEST['idma'])) { $id_client = el_decript_info($_REQUEST['idma']);}
		//if (!empty($id_client)) {
			$JOIN_TABLE = el_TableNameWithPrefix('clients');
			$query  = "
				SELECT ".$JOIN_TABLE.".name, contract_no, contract_data 
				FROM ".$this->real_table_name." 
				LEFT JOIN $JOIN_TABLE ON $JOIN_TABLE.id = ".$this->real_table_name.".idma 
				WHERE ".$this->real_table_name.".id=$id_contract";
			$result = $oDB->db_query($query);
			if ($result_line = $oDB->db_fetch_array($result)) {
				$client_name   = $result_line['name'];
				$contract_no   = $result_line['contract_no'];
				$contract_data = el_MysqlDate_To_RomanianDate($result_line['contract_data']);
			}						
		//}
		if ($id_contract!=0) {
			$this->archive_title = 'Panou contract '.(!empty($contract_no) ? '[ <span class="font-green-sharp bold uppercase my-title">'.$contract_no.'<small>'.$contract_data.'</small> <span class="separator">|</span> '.$client_name.'</span> ]' : '');
			} else { $this->archive_title = 'Adaugare contract client '.(!empty($id_client) ? '[ <span class="font-green-sharp bold uppercase">'.$client_name.'</span> ]' : '');}
		if ($id_client!=0) {
			$this->AddItemToBreadcrumbs('Lista clienti', $this->LinkToList('clienti'));
			$this->AddItemToBreadcrumbs('Panou client', $this->url_referer);
			$this->AddItemToBreadcrumbs('Panou contract', '');
		}			
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */	
	public function ListQuery() {
		$table_name       = el_TableNameWithPrefix($this->table_name);
		$lj_table_clients = el_TableNameWithPrefix('clients');
		$lj_table_sedii   = el_TableNameWithPrefix('sedii');
		$query = "
		SELECT $table_name.id, $table_name.search_content, $table_name.contract_object, $table_name.contract_no, $table_name.contract_data, $table_name.id_sediu, $lj_table_clients.name AS client, $lj_table_sedii.name AS nume_sediu, $table_name.can_edit, $table_name.can_delete   
		FROM ".el_TableNameWithPrefix($this->table_name)." 
		LEFT JOIN $lj_table_clients ON $table_name.idma=$lj_table_clients.id 
		LEFT JOIN $lj_table_sedii ON $table_name.id_sediu=$lj_table_sedii.id 
		WHERE ".$this->query_where." ORDER BY ".$this->query_order_by;
		//die ($query);
		return $query;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteAfterInsert(){
		$ERROR_MSG = '';
		global $oDB;
		$id_user = $this->user_id;
		$inserted_id = 0;
		$query = "SELECT MAX(id) AS last_id FROM $oDB->contracts WHERE add_by=$id_user";
		$result = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$inserted_id = $result_line['last_id'];
		} else {
			$ERROR_MSG = 'Eroare determinare ID inserat';
		}
		if (empty($ERROR_MSG)) {
			$this->update_other_fields($inserted_id);
			adm_AddTrackingInfo('Finalizeaza ADAUGARE CONTRACT in : '.$this->list_archive_title);
		}
		return $ERROR_MSG;
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function ExecuteAfterUpdate($id){
		$this->update_other_fields($id);
		parent::ExecuteAfterUpdate($id);
	}			
	/* ------------------------------------------------------------------------------------- */
	
	public function update_other_fields($id_ctr){
		global $oDB;
		$query = "			
			SELECT $oDB->contracts.*, $oDB->clients.name AS client 
			FROM $oDB->contracts 
			LEFT JOIN $oDB->clients ON $oDB->clients.id = $oDB->contracts.idma 
			WHERE $oDB->contracts.id = $id_ctr";
			$result = $oDB->db_query($query);		
		$search_content    = '';
		if ($result_line = $oDB->db_fetch_array($result)) {
			$search_content = addslashes($result_line['contract_no'].' '.$result_line['client']);
		}
		
		$query = "
			UPDATE $oDB->contracts SET 
			search_content='$search_content' 			
			WHERE id=$id_ctr";
		$result = $oDB->db_query($query);
	}			
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_sediu($result_line){				
		return $result_line['nume_sediu'];
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_contract($result_line, $link_to_edit){				
		return '<a href="'.$link_to_edit.'">'.$result_line['contract_no'].'</a><br /><span class="font-normal"><strong>'.$result_line['client'].'</strong></span><br /><span class="font-normal fs13">'.$result_line['contract_object'].'</span>';
	}			
	/* ------------------------------------------------------------------------------------- */
}