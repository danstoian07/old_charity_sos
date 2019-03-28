<?php

class archive_dosare extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'cases';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare detalii dosar';
	public  $archive_icon_class     			= 'fa fa-folder-open-o';

	public  $list_archive_title			    = 'Lista dosare';					/* Title of archive list */
	public  $list_add_button_name           = 'Adauga dosar';					/* Add button value */
	public  $list_archive_icon_class        = 'fa fa-folder-open-o';			/* icon for title of archive list */
	public  $list_edit_item_button_name     = 'Detalii';
	
	public  $tabs   			    			= array(
													array('Dosar','tab_dosar_general'),
													array('<i class="icon-users"></i> Parti in dosar','tab_article_parti'),
													array('<i class="fa fa-clock-o"></i> Termene','tab_article_termene'),
													array('<i class="fa fa-hourglass-3"></i> Activitati','tab_article_activitati'),
													array('<i class="fa fa-files-o"></i> Fisiere la dosar','tab_upload_multiple_type_files'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Dosare contract';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 60;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Nr','nr_dosar'),
													array('Obiect','obiect'),
													array('Materie juridica','materie_juridica'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
	public $list_fields = array(
                  array (
                  'title'                              => 'Info dosar',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'search_content',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */				  
				  'responsive-classes'                 => 'col-xs-4 col-sm-3 col-md-4 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'width'                              => '',
				  'function'                           => 'lf_return_dosar',    /* Method must have parameter "$result_line" */
                   ),
                  array (
                  'title'                              => 'Responsabili',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'json_responsabili',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																
				  'sortable'                           => false,
				  'main-fields'                        => false, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */				  
				  'responsive-classes'                 => 'col-xs-4 col-sm-3 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'width'                              => '',
				  'function'                           => 'lf_return_responsabili',    /* Method must have parameter "$result_line" */
                   ),
                  array (
                  'title'                              => 'Inregistrare',
				  'type'                               => FIELD_DATE,
				  'db_field'                           => 'date_reg_tribunal',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'responsive-classes'                 => 'col-xs-6 col-sm-6 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
                  array (
                  'title'                              => 'Tip dosar',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'type',
				  'filter'                             => array (
																  'type'    => LFT_COMBO_CUSTOM,																  
																  'options' => array(
																				   array ( 'value' =>  '',  'title' => 'Tip dosar', ),
																				   array ( 'value' =>  '0', 'title' => 'Instanta civil', ),
																				   array ( 'value' =>  '1', 'title' => 'Instanta penal', ),
																				   array ( 'value' =>  '2', 'title' => 'Executare silita', ),
																				   array ( 'value' =>  '3', 'title' => 'Consultanta', ),
																				   array ( 'value' =>  '4', 'title' => 'Arbitraj', ),
																				   array ( 'value' =>  '5', 'title' => 'Procedura jurisdictionala administrativa', ),
																				   array ( 'value' =>  '6', 'title' => 'Urmarire penala', ),
																				),																  
																),				  																				  
				  'width'                              => '',
				  'sortable'                           => false,
				  'main-fields'                        => false, /*fields will appear in delete message */
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'hidden-xs col-sm-4 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  
				  'function'                           => 'lf_return_type',  /* Method must have parameter "$result_line" */
                   ),
                  array (
                  'title'                              => 'Adaugat',
				  'type'                               => FIELD_DATE,
				  'db_field'                           => 'date_add',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'responsive-classes'                 => 'col-xs-6 col-sm-6 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
				   
				/*
				  array (
                  'title'                              => 'Contract',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'contract',
				  'filter_type'                        => 'LFT_NOFILTER',
				  'width'                              => '10%',
				  'responsive-classes'                 => 'hidden-xs',   
                   ),				   
				*/
				/*
				  array (
                  'title'                              => 'Client',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'client',
				  'filter_type'                        => 'LFT_NOFILTER',
				  'width'                              => '10%',
				  'responsive-classes'                 => 'hidden-xs hidden-sm',   
                   ),				   
				*/   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		global $oDB;		
		
		parent::__construct($oParent);
		
		if (!$this->user_rights_by_admin['administrator']) {
			if ($this->user_rights_by_admin['permission_tab_fisiere']==0) {
				array_splice($this->tabs, 4,1);
			}
			if ($this->user_rights_by_admin['permission_tab_activitati']==0) {
				array_splice($this->tabs, 3,1);
			}
			if ($this->user_rights_by_admin['permission_tab_termene']==0) {
				array_splice($this->tabs, 2,1);
			}			
			if ($this->user_rights_by_admin['permission_tab_parti']==0) {
				array_splice($this->tabs, 1,1);
			}									
			
			if ($this->user_rights_by_admin['permission_view_neassociated_cases']==0) {
				$query ="SELECT id_options, id_main_item FROM $oDB->multiselect_options WHERE id_archive=20 AND id_options=".$this->user_id;
				$result = $oDB->db_query($query);
				$i=0;
				$cases_list_ids = '';
				while ($result_line = $oDB->db_fetch_array($result)) {
					$cases_list_ids .= ($i>0 ? ',' : '').$result_line['id_main_item'];
					$i++;
				}
				if (!empty($cases_list_ids)) {
					$filter_dosare_atasate_admin = " AND  $oDB->cases.id IN ($cases_list_ids) ";
				} else {
					$filter_dosare_atasate_admin = " AND $oDB->cases.id IN (-1) ";
				}
				
				$this->query_where     = $this->query_where.$filter_dosare_atasate_admin;		
				$this->query_order_by  = "$this->real_table_name.nr_dosar DESC";
			}
		}
		$this->query_order_by = "$this->real_table_name.date_add DESC";
		
		
	}
	/* ------------------------------------------------------------------------------------- */
	
	public function ShowLegend() {
		?>
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
				  <i class="fa fa-info-circle font-dark"></i>
				  <span class="caption-subject font-dark sbold uppercase">Legenda</span>
				</div>		
			</div>
			<div class="portlet-body">
				<i class="fa fa-square font-blue-sharp font-lg bold" aria-hidden="true"></i> Dosare in lucru&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<i class="fa fa-square font-grey-salt font-lg bold" aria-hidden="true"></i> Dosare suspendate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<i class="fa fa-square font-green-seagreen font-lg bold" aria-hidden="true"></i> Dosare finalizate
			</div>
		</div>
		<?php
	}		
	/* ------------------------------------------------------------------------------------- */		
	public function ShowEdit($id) {
		global $oDB;
		
		$id_dosar      = el_decript_info($id);
		$id_client     = 0;
		$client_name   = '';
		$contract_no   = '';
		$contract_data = '';
		$dosar_no      = '';
		
		if ($this->lawyer_can_access_case($id_dosar)) {
			if (isset($_REQUEST['idma'])) { $id_contract = el_decript_info($_REQUEST['idma']);}
			
				$TABLE_CLIENTS   = el_TableNameWithPrefix('clients');
				$TABLE_CONTRACTS = el_TableNameWithPrefix('contracts');
				$query  = "
					SELECT nr_dosar, $TABLE_CONTRACTS.contract_no, $TABLE_CONTRACTS.contract_data, $TABLE_CLIENTS.name 
					FROM ".$this->real_table_name." 
					LEFT JOIN $TABLE_CONTRACTS ON $TABLE_CONTRACTS.id = ".$this->real_table_name.".idma 
					LEFT JOIN $TABLE_CLIENTS ON $TABLE_CONTRACTS.idma = $TABLE_CLIENTS.id  				
					WHERE ".$this->real_table_name.".id=$id_dosar";
				$result = $oDB->db_query($query);
				if ($result_line = $oDB->db_fetch_array($result)) {
					$client_name   = $result_line['name'];
					$contract_no   = $result_line['contract_no'];
					$contract_data = el_MysqlDate_To_RomanianDate($result_line['contract_data']);
					$dosar_no      = $result_line['nr_dosar'];
				}						
			
			
			if ($id_dosar!=0) {
				$this->archive_title = 'Panou dosar '.(!empty($id_dosar) ? '[ <span class="font-green-sharp bold uppercase my-title"><span title="Numar dosar">'.$dosar_no.'</span> <span class="separator">|</span> <span title="Numar contract">'.$contract_no.'</span><span title="Data contract"> <small>'.$contract_data.'</small></span> <span class="separator">|</span> <span title="Nume client">'.$client_name.'</span></span> ]' : '');
				} else { $this->archive_title = 'Adaugare dosar '.(!empty($id_dosar) ? '[ <span class="font-green-sharp bold uppercase">'.$client_name.'</span> ]' : '');}

			$this->AddItemToBreadcrumbs('Dosare', $this->LinkToList('dosare'));		
			$this->AddItemToBreadcrumbs('Panou dosar', '');

			parent::ShowEdit($id);
			
		} else {
			el_redirect(__ADMINURL__.'?pn=2&archtype=dosare');
		}
	}
	
	/* ------------------------------------------------------------------------------------- */	
	public function ExecuteAfterInsert(){
		$ERROR_MSG = '';		
		global $oDB;
		$id_user = $this->user_id;
		$inserted_id = 0;
		$query = "SELECT MAX(id) AS last_id FROM $oDB->cases WHERE add_by=$id_user";
		$result = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$inserted_id = $result_line['last_id'];
		}
		if ($inserted_id!=0) {
			$query = "SELECT must_update FROM $oDB->cases WHERE id = $inserted_id";
			$result = $oDB->db_query($query);		
			if ($result_line = $oDB->db_fetch_array($result)) {
				$multiple_query = '';
				if (!empty($result_line['must_update'])) {
					$multiple_query = str_replace("idma=0","idma=$inserted_id",$result_line['must_update']);
					$result = $oDB->db_multiquery($multiple_query);
					$oDB->db_next_result();
				}
			}	
		}
		if (empty($ERROR_MSG)) {
			$this->update_avocati_responsabili_dosar($inserted_id);
			$this->update_other_fields($inserted_id);
			adm_AddTrackingInfo('Finalizeaza ADAUGARE DOSAR in : '.$this->list_archive_title);
		}
		return $ERROR_MSG;
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function ExecuteAfterUpdate($id){
		$this->update_avocati_responsabili_dosar($id);
		$this->update_other_fields($id);
		parent::ExecuteAfterUpdate($id);
	}		
	/* ------------------------------------------------------------------------------------- */
	public function ListQuery() {
		$table_name       = el_TableNameWithPrefix($this->table_name);
		$lj_table_ctr     = el_TableNameWithPrefix('contracts');
		$lj_table_clients = el_TableNameWithPrefix('clients');
		
		$query = "
		SELECT $table_name.id, $table_name.nr_dosar_5, $table_name.obiect_5, $table_name.nr_dosar_3, $table_name.obiect_3, $table_name.tip_dosar_urmarire, $table_name.nr_dosar_6, $table_name.tip_dosar_executare, $table_name.nr_dosar_2, $table_name.tip_dosar_arbitraj, $table_name.date_add, $table_name.type, $table_name.status, $table_name.stadiu_procesual, $table_name.stadiu_procesual_1, $table_name.json_responsabili, $table_name.materie_juridica, $table_name.obiect, $table_name.obiect_1, $table_name.obiect_2, $table_name.obiect_3, $table_name.obiect_4, $table_name.obiect_5, $table_name.obiect_6, $table_name.nr_dosar, $table_name.date_reg_tribunal, $table_name.nr_dosar_1, $table_name.nr_dosar_4, $lj_table_clients.name AS client, $lj_table_ctr.contract_no AS contract, DATE_FORMAT($lj_table_ctr.contract_data, '%d-%m-%Y') AS contract_data, $table_name.can_edit, $table_name.can_delete  
		FROM ".el_TableNameWithPrefix($this->table_name)." 
		LEFT JOIN $lj_table_ctr ON $table_name.idma=$lj_table_ctr.id 
		LEFT JOIN $lj_table_clients ON $lj_table_ctr.idma = $lj_table_clients.id 	
		WHERE ".$this->query_where." ORDER BY ".$this->query_order_by;
		return $query;
	}	
	/* ------------------------------------------------------------------------------------- */
	
	public function lawyer_can_access_case($id_dosar) {
		$can_acccess = true;
		if ((!$this->user_rights_by_admin['administrator']) && ($this->user_rights_by_admin['permission_view_neassociated_cases']==0)) {	
			global $oDB;
			$can_acccess = false;
			$query ="SELECT id_options FROM $oDB->multiselect_options WHERE id_archive=20 AND id_main_item=$id_dosar";			
			$result = $oDB->db_query($query);			
			while ($result_line = $oDB->db_fetch_array($result)) {
				if ($result_line['id_options']==$this->user_id){
					$can_acccess = true;
					break;
				}			
			}
		}
		return $can_acccess;
	}
	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_sediu($result_line){				
		return $result_line['nume_sediu'];
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_dosar($result_line, $link_to_edit){
		switch ($result_line['type']) {
			case 0 : 
					//$tip_dosar  = "Dosar Instanta Civil<br>";
					$nr_dosar = $result_line['nr_dosar'];
					$tip_dosar = '&#8226; '.$result_line['obiect'].'<br>&#8226; <span class="font-blue-sharp">'.$result_line['stadiu_procesual'].'</span>';
					break;
			case 1 : 
					//$tip_dosar  = "Dosar Instanta Penal<br>"; 
					$nr_dosar = $result_line['nr_dosar_1'];
					$tip_dosar = '&#8226; '.$result_line['obiect_1'].'<br>&#8226; <span class="font-blue-sharp">'.$result_line['stadiu_procesual_1'].'</span>';
					break;
			case 2 : 
					//$tip_dosar  = "Dosar Executare Silita<br>"; 
					$nr_dosar  = ($result_line['tip_dosar_executare']!=0 ? $result_line['nr_dosar_2'] : 'Nu am numar dosar');
					$tip_dosar = '&#8226; '.$result_line['obiect_2'].'<br>';
					break;
			case 3 : 
					//$tip_dosar  = "Dosar Consultanta<br>"; 
					$nr_dosar  = $result_line['nr_dosar_3'];
					$tip_dosar = '&#8226; '.$result_line['obiect_3'].'<br>';
					break;
			case 4 : 
					//$tip_dosar  = "Dosar Arbitraj<br>"; 
					$nr_dosar  = ($result_line['tip_dosar_arbitraj']!=0 ? $result_line['nr_dosar_4'] : 'Nu am numar dosar');
					$tip_dosar = '&#8226; '.$result_line['obiect_4'].'<br>';
					break;
			case 5 : 
					//$tip_dosar  = "Dosar Procedura Jurisdictionala Administrativa<br>"; 
					$nr_dosar  = $result_line['nr_dosar_5'];
					$tip_dosar = '&#8226; '.$result_line['obiect_5'].'<br>';
					break;
			case 6 : 
					//$tip_dosar  = "Dosar Urmarire Penala<br>"; 
					$nr_dosar  = ($result_line['tip_dosar_urmarire']!=0 ? $result_line['nr_dosar_6'] : 'Nu am numar dosar');
					$tip_dosar = '&#8226; '.$result_line['obiect_6'].'<br>';
					break;
			default: 
					$tip_dosar  = ""; 
					break;
		}
		
		if ($result_line['status']==0) { $font_color_class = "";} else if ($result_line['status']==1) {$font_color_class = "font-grey-salt";} else {$font_color_class = "font-green-seagreen";}
		return '<a class="'.$font_color_class.'" href="'.$link_to_edit.'">'.$nr_dosar.'</a><br>'.$result_line['client'].'<span class="font-normal"> (CTR.'.$result_line['contract'].'/'.$result_line['contract_data'].')</span><br><span class="fs13 font-normal">'.$tip_dosar.'</span>';
	}			
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_type($result_line){				
		switch ($result_line['type']) {
			case 0: return '<span alt="Dosar Instanta Civil">IC</span>'; break;
			case 1: return '<span alt="Dosar Instanta Penal">IP</span>'; break;
			case 2: return '<span alt="Dosar Executare Silita">ES</span>'; break;
			case 3: return '<span alt="Dosar Consultanta">C</span>'; break;
			case 4: return '<span alt="Dosar Arbitraj">A</span>'; break;
			case 5: return '<span alt="Dosar Procedura Jurisdictionala Administrativa">PJA</span>'; break;
			case 6: return '<span alt="Dosar Urmarire Panala">UP</span>'; break;
		}		
		
	}				
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_responsabili($result_line){
		$ret_responsabili = '';
		if (!empty($result_line['json_responsabili'])) {
			$json = stripslashes($result_line['json_responsabili']);
			$arr_avocati = json_decode($json,true);
			if (is_array($arr_avocati)) {
				foreach ($arr_avocati as $id_avocat => $avocat) {
					$ret_responsabili .= '&#8226; '.$avocat.'<br>';
				}
			}
		}
		return $ret_responsabili;
	}					
	/* ------------------------------------------------------------------------------------- */
	public function update_avocati_responsabili_dosar($id_dosar){
		global $oDB;
		$query = "
			SELECT $oDB->multiselect_options.id_options, $oDB->users.id AS id_avocat, $oDB->users.name, $oDB->users.email 
			FROM $oDB->multiselect_options 
			LEFT JOIN $oDB->users ON $oDB->users.id= $oDB->multiselect_options.id_options 
			WHERE $oDB->multiselect_options.id_archive = 20 AND $oDB->multiselect_options.id_main_item = $id_dosar";
			$result = $oDB->db_query($query);
		$arr_avocati = array();
		while ($result_line = $oDB->db_fetch_array($result)) {
			$id_avocat = $result_line['id_avocat'];
			$arr_avocati["$id_avocat"] = $result_line['name'];			
		}
		$json_avocati_responsabili = json_encode($arr_avocati);
		
		$query = "UPDATE $oDB->cases SET json_responsabili='$json_avocati_responsabili' WHERE id=$id_dosar";
		$result = $oDB->db_query($query);
	}
	/* ------------------------------------------------------------------------------------- */
	public function update_other_fields($id_dosar){
		global $oDB;
		$query = "			
			SELECT $oDB->cases.*, $oDB->contracts.contract_no AS contract, $oDB->contracts.contract_data, $oDB->clients.name AS client 
			FROM $oDB->cases 
			LEFT JOIN $oDB->contracts ON $oDB->cases.idma= $oDB->contracts.id 
			LEFT JOIN $oDB->clients ON $oDB->contracts.idma= $oDB->clients.id 
			WHERE $oDB->cases.id = $id_dosar";
			$result = $oDB->db_query($query);		
		$search_content    = '';
		$universal_date = '';
		if ($result_line = $oDB->db_fetch_array($result)) {
			switch ($result_line['type']) {
				case 0: 
						/* dosar instanta civil */
						$search_content = addslashes(return_SearchContent_cases_InstantaCivil($result_line['nr_dosar'], $result_line['client'], $result_line['contract'], $result_line['contract_data'], $result_line['obiect'], $result_line['stadiu_procesual']));
						break;
				case 1: 
						/* dosar instanta penal */
						$search_content = addslashes(return_SearchContent_cases_InstantaCivil($result_line['nr_dosar_1'], $result_line['client'], $result_line['contract'], $result_line['contract_data'], $result_line['obiect_1'], $result_line['stadiu_procesual_1']));
						$universal_date = $result_line['date_reg_tribunal_1'];
						break;
				case 2: 
						/* dosar executare silita */
						$search_content = addslashes(return_SearchContent_cases_InstantaCivil(($result_line['tip_dosar_executare']!=0 ? $result_line['nr_dosar_2'] : 'Nu am numar dosar'), $result_line['client'], $result_line['contract'], $result_line['contract_data'], $result_line['obiect_2'], ''));
						$universal_date = $result_line['date_reg_bej'];
						break;
				case 3: 
						/* Dosar consultanta */
						$search_content = addslashes(return_SearchContent_cases_InstantaCivil( $result_line['nr_dosar_3'], $result_line['client'], $result_line['contract'], $result_line['contract_data'], $result_line['obiect_3'], ''));
						//$universal_date = $result_line['date_reg_bej'];
						break;
						
				case 4: 
						/* dosar arbitraj */
						$search_content = addslashes(return_SearchContent_cases_Arbitraj($result_line['nr_dosar_4'], $result_line['client'], $result_line['contract'], $result_line['contract_data'], $result_line['obiect']));
						$universal_date = $result_line['date_reg_arb'];
						break;
				case 5: 
						/* Dosar procedura jurisdictionala administrativa*/
						$search_content = addslashes(return_SearchContent_cases_InstantaCivil( $result_line['nr_dosar_5'], $result_line['client'], $result_line['contract'], $result_line['contract_data'], $result_line['obiect_5'], ''));
						//$universal_date = $result_line['date_reg_bej'];
						break;
						
				case 6: 
						/* dosar urmarire penala */
						$search_content = addslashes(return_SearchContent_cases_InstantaCivil(($result_line['tip_dosar_urmarire']!=0 ? $result_line['nr_dosar_6'] : 'Nu am numar dosar'), $result_line['client'], $result_line['contract'], $result_line['contract_data'], $result_line['obiect_6'], ''));
						break;
						
			}						
		}
		
		$query = "
			UPDATE $oDB->cases SET 
			search_content='$search_content' 
			".(!empty($universal_date) ? ", date_reg_tribunal='$universal_date'" : "")."
			WHERE id=$id_dosar";
		$result = $oDB->db_query($query);
	}	
	
	/* ------------------------------------------------------------------------------------- */
}