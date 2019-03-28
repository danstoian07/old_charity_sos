<?php

class archive_beneficiari extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'beneficiaries';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare detalii beneficiar contract';
	public  $archive_icon_class     			= 'icon-pointer';

	public  $list_archive_title			    = 'Lista beneficiari contract';			/* Title of archive list */
	public  $list_archive_icon_class        = 'icon-pointer';						/* icon for title of archive list */
	public  $list_add_button_name           = 'Adauga beneficiar';					/* Add button value */
	
	public  $tabs   			    			= array(
													array('Beneficiar contract','tab_beneficiar_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Beneficiari contract';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 40;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Nume','name'),
													array('Adresa','address'),
													array('Telefon','phone'),
													array('Fax','fax'),
													array('E-mail','email'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	public  $del_item_message               = 'Confirmati stergerea beneficiarului <strong>%</strong> ?';
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
                  'title'                              => 'Beneficiar',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'idma',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_beneficiar', /* Method must have parameter "$result_line" */
                   ),
                  array (
                  'title'                              => '<i class="fa fa-percent"></i> Procent',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'procent',
				  'width'                              => '',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-xs col-sm-4 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_procent', /* Method must have parameter "$result_line" */
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
	/**
		* Metoda va fi executata inainte de afisarea listei cu inregistrari a arhivei
		* 
	*/	
	public function ExecureBeforeLoadList() {		
		global $oDB;
		if ( isset($_REQUEST['id']) )    { 			
			$idma    = el_decript_info($_REQUEST['id']); 		
			$query ="SELECT sum(commission) AS suma_procente FROM $oDB->beneficiaries WHERE idma=$idma";
			$result = $oDB->db_query($query);
			$suma_procente = 0;
			if ($result_line = $oDB->db_fetch_array($result)) {
				$suma_procente = $result_line['suma_procente'];
			}
			if (($suma_procente!=0) && ($suma_procente!=100)) {
				$this->AddAlert('Suma procentelor comisioanelor beneficiarilor contractului nu este 100%!', MSG_WARNING, 'fa fa-exclamation-triangle'); 
			}
			if ($suma_procente==0) {
				$this->AddAlert('Nu au fost inregistrati beneficiarii acestui contract!', MSG_WARNING, 'fa fa-exclamation-triangle'); 
			}
		}
	}
	/* ------------------------------------------------------------------------------------- */
	public function ReturnDeleteMessage ($id, $field_name) {
		global $oDB;		
		$DELETE_QUERY     = $this->del_item_message;
		$FIELD_NAME_VALUE = '';
		$lj_table_users   = el_TableNameWithPrefix('users');
		$query = "
		SELECT $this->real_table_name.type, $lj_table_users.name FROM ".$this->real_table_name." 
		LEFT JOIN $lj_table_users ON $this->real_table_name.id_user=$lj_table_users.id 
		WHERE $this->real_table_name.id = '$id'";
		$result = $oDB->db_query($query);
		if ($oDB->db_num_rows($result)!=1) {
			$ERROR = true; $ERROR_MSG = _('Nu exista in arhiva aceasta inregistrare !');
		} else {
			  if ($result_line = $oDB->db_fetch_array($result)) {
				  $FIELD_NAME_VALUE = ($result_line['type']==0 ? $this->company_name : $result_line['name']);
				  $DELETE_QUERY = str_replace("%", $FIELD_NAME_VALUE, $DELETE_QUERY);
			  }
		}
		return $DELETE_QUERY;
	}		
	/* ------------------------------------------------------------------------------------- */
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
	/* ------------------------------------------------------------------------------------- */
	
	public function ShowEdit($id) {
		if ($id!=0) { $this->archive_title = 'Editare beneficiar contract';} else { $this->archive_title = 'Adaugare beneficiar contract';}
		//$arr_rights = json_decode(el_decript_info($_SESSION[APP_ID]["user"]["rights"]),true);
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteBeforeInsert(){
		$ERROR_MSG = '';
		global $oDB;
		if (isset($_POST["type"])) {
			if ($_POST["type"]!=0) {
				// este alt beneficiat decat Societatea de avocati
				if ((isset($_POST["id_user"]))) {
					$query = "SELECT count(*) AS no_items FROM $oDB->beneficiaries WHERE idma=$this->idma AND id_user=".$_POST["id_user"];
					$result = $oDB->db_query($query);
					$no_items = 0;
					if ($result_line = $oDB->db_fetch_array($result)) {
						if ($result_line['no_items']!=0) {
							$ERROR_MSG = 'Acest beneficiar exista deja la contract!';
						}
					}
				}
			} else {
				// beneficiarul este Societatea de avocati
				$query = "SELECT count(*) AS no_items FROM $oDB->beneficiaries WHERE idma=$this->idma AND id_user=0";
				$result = $oDB->db_query($query);
				$no_items = 0;
				if ($result_line = $oDB->db_fetch_array($result)) {
					if ($result_line['no_items']!=0) {
						$ERROR_MSG = 'Exista deja la contract beneficiarul '.$this->company_name.'!';
					}
				}				
			}
		}
		return $ERROR_MSG;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteBeforeUpdate($id){
		$ERROR_MSG = '';
		global $oDB;
		if (isset($_POST["type"])) {
			if ($_POST["type"]!=0) {
				// este alt beneficiat decat Societatea de avocati
				if ((isset($_POST["id_user"]))) {
					$query = "SELECT count(*) AS no_items FROM $oDB->beneficiaries WHERE idma=$this->idma AND id!=$id AND id_user=".$_POST["id_user"];
					$result = $oDB->db_query($query);
					$no_items = 0;
					if ($result_line = $oDB->db_fetch_array($result)) {
						if ($result_line['no_items']!=0) {
							$ERROR_MSG = 'Acest beneficiar exista deja la contract!';
						}
					}
				}
			} else {
				// beneficiarul este Societatea de avocati
				$query = "SELECT count(*) AS no_items FROM $oDB->beneficiaries WHERE idma=$this->idma AND id!=$id AND id_user=0";
				$result = $oDB->db_query($query);
				$no_items = 0;
				if ($result_line = $oDB->db_fetch_array($result)) {
					if ($result_line['no_items']!=0) {
						$ERROR_MSG = 'Exista deja la contract beneficiarul '.$this->company_name.'!';
					}
				}				
			}
		}		
		return $ERROR_MSG;
	}		
	/* ------------------------------------------------------------------------------------- */
	/* lf : list function */
	public function lf_return_beneficiar($result_line, $link_to_edit){
		return '<a href="'.$link_to_edit.'"><strong>'.($result_line['type']==0 ? $this->company_name : $result_line['name']).'</strong></a>';
	}	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_procent($result_line, $link_to_edit){
		return $result_line['commission'].'%';
	}		
	/* ------------------------------------------------------------------------------------- */
}