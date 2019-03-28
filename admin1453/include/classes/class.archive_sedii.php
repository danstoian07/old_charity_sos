<?php

class archive_sedii extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'sedii';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare detalii punct lucru';
	public  $archive_icon_class     			= 'icon-pointer';

	public  $list_archive_title			    = 'Lista puncte de lucru';					/* Title of archive list */
	public  $list_archive_icon_class        = 'icon-pointer';						/* icon for title of archive list */
	
	public  $tabs   			    			= array(
													array('Punct lucru','tab_sediu_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Puncte de lucru societate';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 10;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Nume','name'),
													array('Adresa','address'),
													array('Telefon','phone'),
													array('Fax','fax'),
													array('E-mail','email'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
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
                  'title'                              => 'Sediu',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'name',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_sediu', /* Method must have parameter "$result_line" */
                   ),
				   /*
                  array (
                  'title'                              => 'Sediu',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'name',
				  'filter_type'                        => 'LFT_NOFILTER',				  
				  'width'                              => '10%',
                   ),
				   */
                  array (
                  'title'                              => '<i class="fa fa-phone"></i> Telefon',
				  'type'                               => FIELD_PHONE,
				  'db_field'                           => 'phone',
				  'width'                              => '',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-xs col-sm-4 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
                  array (
                  'title'                              => '<i class="fa fa-envelope"></i> E-mail',
				  'type'                               => FIELD_EMAIL,
				  'db_field'                           => 'email',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-sm hidden-xs hidden-md col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
	}	
	/* ------------------------------------------------------------------------------------- */	
	
	public function ShowEdit($id) {
		if ($id!=0) { $this->archive_title = 'Editare detalii punct lucru';} else { $this->archive_title = 'Adaugare punct lucru';}
		$arr_rights = json_decode(el_decript_info($_SESSION[APP_ID]["user"]["rights"]),true);
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed after operation UPDATE. Rewrited method */	
	/**
		* @param int   $id     		 id of updated items
	*/	
	public function ExecuteAfterUpdate($id){
		global $oDB;
		$ERROR_MSG = '';		
		$query = "SELECT sediu_principal FROM ".$this->real_table_name." WHERE id= $id";		
		$result = $oDB->db_query($query);
		if ($oDB->db_num_rows($result)!=1) {
			$ERROR_MSG = _('Eroare ExecuteAfterUpdate. Nu gasesc in arhiva ID sediu !');
		} else {
			  if ($result_line = $oDB->db_fetch_array($result)) {
				  if ($result_line['sediu_principal']!=0) {
						$multiple_query  = "UPDATE ".$this->real_table_name." SET sediu_principal=0 WHERE id_archive=".$this->ida.";";
						$multiple_query .= "UPDATE ".$this->real_table_name." SET sediu_principal=1 WHERE id=".$id.";";
						$result = $oDB->db_multiquery($multiple_query);
						$oDB->db_next_result();						
				  }				  
			  }
		}
		adm_AddTrackingInfo("ACTUALIZEAZA/MODIFICA inregistrare in sectiunea Sedii (id: $id )");
		return $ERROR_MSG;		
	}		
	/* ------------------------------------------------------------------------------------- */
	/* lf : list function */
	public function lf_return_sediu($result_line, $link_to_edit){
		$ret_value = $result_line['name'];
		if ($result_line['sediu_principal']!=0) {
			$ret_value = '<strong>'.$result_line['name'].'</strong>';
		}
		return '<a '.($result_line['active'] ? '' : 'class="font-grey-salt font-line-through" title="Punct de lucru inchis"').' href="'.$link_to_edit.'">'.$ret_value.'</a><br><span class="fs_13">'.$result_line['address'].'</span>';
	}	
	/* ------------------------------------------------------------------------------------- */
}