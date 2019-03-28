<?php

class archive_acte_aditionale extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'addenda';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare act aditional';
	public  $archive_icon_class     			= 'fa fa-plus';

	public  $list_archive_title			    = 'Lista acte aditionale';					/* Title of archive list */
	public  $list_add_button_name           = 'Adauga act aditional';					/* Add button value */
	public  $list_archive_icon_class        = 'fa fa-plus';					/* icon for title of archive list */
	public  $list_edit_item_button_name     = 'Editare';
	
	public  $tabs   			    			= array(
													array('Act aditional','tab_act_aditional_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Act aditional la contract';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 60;								/* id of menuitem wich will be active when panel show */
	
	public $list_fields = array(
                  array (
                  'title'                              => 'Nr act aditional',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'nr_act_aditional',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																
				  'width'                              => '10%',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */				  
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'width'                              => '',
				  'function'                           => 'lf_return_act',    /* Method must have parameter "$result_line" */
                   ),
				   
                  array (
                  'title'                              => 'Inregistrare',
				  'type'                               => FIELD_DATE,
				  'db_field'                           => 'date_act',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'responsive-classes'                 => 'col-xs-6 col-sm-6 col-md-3 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
				  array (
                  'title'                              => 'Contract',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'contract',
				  'filter_type'                        => 'LFT_NOFILTER',
				  'width'                              => '10%',
				  'responsive-classes'                 => 'hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   

				  array (
                  'title'                              => 'Client',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'client',
				  'filter_type'                        => 'LFT_NOFILTER',
				  'width'                              => '10%',
				  'responsive-classes'                 => 'hidden-xs hidden-sm',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
				   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		$this->query_order_by  = "$this->real_table_name.nr_dosar DESC";
		//$this->AddNotification($this->ListQuery(), MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
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
		
		if (isset($_REQUEST['idma'])) { $id_contract = el_decript_info($_REQUEST['idma']);}
		if (!empty($id_contract)) {
			$TABLE_CLIENTS   = el_TableNameWithPrefix('clients');
			$TABLE_CONTRACTS = el_TableNameWithPrefix('contracts');
			$query  = "
				SELECT nr_act_aditional, date_act, $TABLE_CONTRACTS.contract_no, $TABLE_CONTRACTS.contract_data, $TABLE_CLIENTS.name 
				FROM ".$this->real_table_name." 
				LEFT JOIN $TABLE_CONTRACTS ON $TABLE_CONTRACTS.id = ".$this->real_table_name.".idma 
				LEFT JOIN $TABLE_CLIENTS ON $TABLE_CONTRACTS.idma = $TABLE_CLIENTS.id  				
				WHERE ".$this->real_table_name.".id=$id_dosar";
				//die($query);
			$result = $oDB->db_query($query);
			if ($result_line = $oDB->db_fetch_array($result)) {
				$client_name   = $result_line['name'];
				$contract_no   = $result_line['contract_no'];
				$contract_data = el_MysqlDate_To_RomanianDate($result_line['contract_data']);
				$dosar_no      = $result_line['nr_dosar'];
			}						
		}
		
		if ($id_dosar!=0) {
			$this->archive_title = 'Panou act aditional '.(!empty($id_dosar) ? '[ <span class="font-green-sharp bold uppercase my-title"><span title="Numar dosar">'.$dosar_no.'</span> <span class="separator">|</span> <span title="Numar contract">'.$contract_no.'</span><span title="Data contract"><small>'.$contract_data.'</small></span> <span class="separator">|</span> <span title="Nume client">'.$client_name.'</span></span> ]' : '');
			} else { $this->archive_title = 'Adaugare dosar '.(!empty($id_dosar) ? '[ <span class="font-green-sharp bold uppercase">'.$client_name.'</span> ]' : '');}
		
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */	
	public function ListQuery() {
		$table_name       = el_TableNameWithPrefix($this->table_name);
		$lj_table_ctr     = el_TableNameWithPrefix('contracts');
		$lj_table_clients = el_TableNameWithPrefix('clients');
		
		$query = "
		SELECT $table_name.id, $table_name.date_act, $table_name.nr_act_aditional, $lj_table_clients.name AS client, $lj_table_ctr.contract_no AS contract, $table_name.can_edit, $table_name.can_delete  
		FROM ".el_TableNameWithPrefix($this->table_name)." 
		LEFT JOIN $lj_table_ctr ON $table_name.idma=$lj_table_ctr.id 
		LEFT JOIN $lj_table_clients ON $lj_table_ctr.idma = $lj_table_clients.id 	
		WHERE ".$this->query_where." ORDER BY ".$this->query_order_by;
		//die ($query);
		return $query;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_sediu($result_line){				
		return $result_line['nume_sediu'];
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_act($result_line, $link_to_edit){
		return '<a href="'.$link_to_edit.'">'.$result_line['nr_act_aditional'].'</a>';
	}			
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
}