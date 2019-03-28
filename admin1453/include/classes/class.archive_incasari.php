<?php

class archive_incasari extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'receipts';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare incasare contract';
	public  $archive_icon_class     			= 'fa fa-money';

	public  $list_archive_title			    = 'Lista incasari contract';			/* Title of archive list */
	public  $list_archive_icon_class        = 'fa fa-money';						/* icon for title of archive list */
	public  $list_add_button_name           = 'Adauga incasare';					/* Add button value */
	
	public  $tabs   			    			= array(
													array('Incasare la contract','tab_incasare_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Incasari contract';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 40;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Nume','name'),
													array('Adresa','address'),
													array('Telefon','phone'),
													array('Fax','fax'),
													array('E-mail','email'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	public  $del_item_message               = 'Confirmati stergerea incasarii <strong>%</strong> ?';
	public $company_name                        = '';
	
	
	public $list_fields = array(
				  /*
                  array (
                  'title'                              => 'ID',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'id',
				  'filter_type'                        => 'LFT_NOFILTER',				  
				  'width'                              => '2%',
                   ),
				   */
                  array (
                  'title'                              => 'Document',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'document',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																				  
				  'width'                              => '10%',
				  'sortable'                           => true,
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_document', /* Method must have parameter "$result_line" */
                   ),
                  array (
                  'title'                              => '<i class="fa fa-money"></i> Echivalent [LEI]',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'value_lei',
				  'filter'                             => array (
																  'type'    => LFT_VALUE_INTERVAL,																  
																),																				  				  
				  'width'                              => '',
				  'sortable'                           => true,
				  'responsive-classes'                 => 'hidden-xs col-sm-4 col-md-3 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_value', /* Method must have parameter "$result_line" */
                   ),
                  array (
                  'title'                              => 'Data',
				  'type'                               => FIELD_DATE,
				  'db_field'                           => 'date_receipt',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'responsive-classes'                 => 'col-xs-6 col-sm-6 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'sortable'                           => true,
                   ),
				   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {		
		parent::__construct($oParent);
		$this->query_order_by = "$this->real_table_name.date_add DESC";
		$this->company_name  = el_decript_info($_SESSION[APP_ID]["user"]["company"]);		
		//$this->AddNotification('Acesta este un mesaj de mare valoare',MSG_WARNING); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
	}	
	/* ------------------------------------------------------------------------------------- */
	/*
	public function ListQuery() {
		$table_name       = el_TableNameWithPrefix($this->table_name);
		$lj_table_users   = el_TableNameWithPrefix('users');
		
		$query = "
		SELECT $table_name.*, $lj_table_users.name AS name  
		FROM ".el_TableNameWithPrefix($this->table_name)." 
		LEFT JOIN $lj_table_users ON $table_name.id_user=$lj_table_users.id 
		WHERE ".$this->query_where." ORDER BY date_add DESC";
		return $query;
	}
	*/
	/* ------------------------------------------------------------------------------------- */
	
	public function ShowEdit($id) {
		if ($id!=0) { $this->archive_title = 'Editare incasare contract';} else { $this->archive_title = 'Adaugare incasare contract';}
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */
	/* lf : list function */
	public function lf_return_document($result_line, $link_to_edit){
			switch ($result_line['moneda']) {
				case  0: $CURRENCY  = 'LEI'; break;
				case  1: $CURRENCY  = 'EUR'; break;
				case  2: $CURRENCY  = 'USD'; break;
				case  3: $CURRENCY  = 'GBP'; break;
				case  4: $CURRENCY  = 'CHF'; break;
				default: $CURRENCY = '';				
			}		
			switch ($result_line['type']) {
				case  0: $incasare = 'Incasare cash, '.$result_line['value'].' '.$CURRENCY;	break;
				case  1: $incasare = 'Incasare cu OP, '.$result_line['value'].' '.$CURRENCY;	break;
				case  2: $incasare = 'Incasare CEC, '.$result_line['value'].' '.$CURRENCY;	break;
				default: $incasare = '';
			}		
		return '<a href="'.$link_to_edit.'"><strong>'.$result_line['document'].'</strong></a><br/>'.$incasare;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_value($result_line, $link_to_edit){
		return $result_line['value_lei'];
	}		
	/* ------------------------------------------------------------------------------------- */
}