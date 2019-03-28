<?php
/* generic class */
class tab_upload extends tab {
	public  $upload_table_name                    	= 'gallery';						/* table in whicht will be stored uploaded files info (without app prefix) */	
	public  $real_table_name                        = '';
	public  $upload_permission_add_item            	= 1;								/* users can add file for upload */	
	public  $upload_permission_delete_item         	= 1;								/* users can delete file */			
	public  $upload_accepted_file_type     			= array(
														array('Image files','jpg,gif,png,jpeg,tiff'),													
														array('Archive files','zip,arj,ace,rar'),
														array('PDF files','pdf'),
														array('MS Word files','doc,docx'),
														array('MS Excel files','xls,xlsx'),
														array('Movie files','mp4,avi,mpeg'),
														array('Audio files','mp3,wav'),
													);	/* bidimensional array with accepted files type for upload. Ex: (('Graphical file', 'jpg, bmp, tiff'),('Archive file', 'zip, arj, rar'), ...) */	
	public  $del_item_message                       = 'Confirmati stergerea fisierului <strong>%</strong> ?';
	public  $global_actions							= array();							/* Archive global actions, bidimensional array Ex: (($actions_name1, $archive_method_name1),($actions_name2, $archive_method_name2) ...) Obs: method must return empty string for success or error message in case of error */ 
	public  $edit_tab                 				= false; /* will be true for tab with editable fields, for tab with list content will be false */		
	
	/* ------------------------------------------------------------------------------------- */	
	public function ReturnDeleteMessage ($id ) {
		global $oDB;
		$ERROR     = false;
		$ERROR_MSG = '';
		
		$DELETE_MSG     = 'Stergeti inregistrarea ?';		
		$query = "SELECT filename FROM ".$this->real_table_name." WHERE id = '$id'";
		$result = $oDB->db_query($query);
		if ($oDB->db_num_rows($result)!=1) {
			$ERROR = true; $ERROR_MSG = _('Nu exista in arhiva aceasta inregistrare !');
		} else {
			  if ($result_line = $oDB->db_fetch_array($result)) {
				  $DELETE_MSG = str_replace("%", $result_line['filename'], $this->del_item_message);
			  }
		}
		$arr_json['error']   = ($ERROR ? 'true' : 'false');
		$arr_json['message'] = ($ERROR ? $ERROR_MSG : $DELETE_MSG);
		
		return json_encode($arr_json);
	}	
	
	/* ------------------------------------------------------------------------------------- */	
	public function DeleteItem($id) {
		global $oDB;
		$ERROR     = false;
		$ERROR_MSG = '';
		$FILE_PATH = '';
		
		if (!$this->upload_permission_delete_item) {
			$ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de stergere inregistrari in arhiva curenta !');
		}
		if (!$ERROR) {
			$query = "SELECT id, file, can_delete FROM ".$this->real_table_name." WHERE id = '$id'";
			$result = $oDB->db_query($query);
			if ($oDB->db_num_rows($result)!=1) {
				$ERROR = true; $ERROR_MSG = _('Nu exista in arhiva aceasta inregistrare !');
			} else {
				  if ($result_line = $oDB->db_fetch_array($result)) {
					  $FILE_PATH = __UPLOADPATH__ . basename($result_line['file']); /* get file path in order to delete the file */
					  if ($result_line["can_delete"]==false) {
						$ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de a sterge aceasta inregistrare !');
					  } 
				  }
			}
		}
		
		$ERROR_MSG = $this->ExecuteBeforeDelete($id);
		if (!empty($ERROR_MSG)) { $ERROR = true; }
		
		if (!$ERROR) {
			$query = "DELETE FROM ".$this->real_table_name." WHERE id = '$id'";
			$result = $oDB->db_query($query);
			if ($oDB->db_affected_rows($result)!=1) {
				$ERROR = true; $ERROR_MSG = _('Eroare stergere inregistrare !');
			} else {
				$ERROR_MSG = $this->ExecuteAfterDelete($id);		
				if (!empty($ERROR_MSG)) { $ERROR = true; }				
			}
		}
		if (!$ERROR) {
			if(!empty($FILE_PATH)) {
				if (!unlink($FILE_PATH)) {
					$ERROR = true; $ERROR_MSG = _('Eroare stergere fisier de pe server !');
				}				
			} else {
				$ERROR = true; $ERROR_MSG = _('Nu cunosc calea catre fisier !');
			}
		}
		
		return $ERROR_MSG;
	}	
	/* ------------------------------------------------------------------------------------- */
	/* function will be executed before operation DELETE. Method will be rewritten if necessary.
	   the function will return non empty string in case of error;
	/**
		* @param int   $id     		 id of deleted items
	*/	
	private function ExecuteBeforeDelete($id){		
		$ERROR_MSG = '';
		return $ERROR_MSG;
	}		
	/* ------------------------------------------------------------------------------------- */
	/* function will be executed after operation DELETE. Method will be rewritten if necessary.
	   the function will return non empty string in case of error;
	/**
		* @param int   $id     		 id of deleted items
	*/
	private function ExecuteAfterDelete($id){		
		$ERROR_MSG = '';
		return $ERROR_MSG;	
	}			
	/* ------------------------------------------------------------------------------------- */
	/* 
		Method will execute global action DELETE. The methosd must have as paratemer: array with encripted ids (which will be delete).
		All methods defined for global actions must return empty string for success or error message in case of error.
	*/
	public function GlobalActions_Delete($arr_encripted_id) {
		global $oDB;
		$ERROR     = false;
		$ERROR_MSG = '';
		if (!$this->upload_permission_delete_item) {
			$ERROR = true; $ERROR_MSG = _('Nu aveti dreptul de stergere inregistrari in arhiva curenta !');
		}
		if (!$ERROR) {
			// check if exist selected id which can not delete because field "can_delete" of archive table is 0.
			$no_items_from_array = count($arr_encripted_id);
			$list_of_id = '';
			$contor = 0;
			foreach ($arr_encripted_id as $key => $value) {
				$list_of_id .= ($contor!=0 ? ',' : '').el_decript_info($value);
				$contor++;
			}
			$where =  " $this->real_table_name.id IN ($list_of_id) AND $this->real_table_name.can_delete!=0 ";
			$no_items_from_table = $oDB->table_records_number($this->upload_table_name, $where);
			if ($no_items_from_array!=$no_items_from_table) {
				$ERROR = true; $ERROR_MSG = _('Exista inregistrari selectate pe care nu aveti dreptul sa le stergeti !');
			}			
		}	
		
		if (!$ERROR) {
			$arr_files = array();
			$query = "SELECT file FROM $this->real_table_name WHERE $this->real_table_name.id IN ($list_of_id)";
			$result = $oDB->db_query($query);	
			while ($result_line = $oDB->db_fetch_array($result)) {
				array_push($arr_files,__UPLOADPATH__ . basename($result_line['file']));
			}
		}
		if (!$ERROR) {
			$query = "DELETE FROM $this->real_table_name WHERE $this->real_table_name.id IN ($list_of_id)";
			$result = $oDB->db_query($query);
			if ($oDB->db_affected_rows($result)!=$no_items_from_array) {
				$ERROR = true; $ERROR_MSG = _('Eroare stergere inregistrari !');
			} else {
				/* delete file from server */
				foreach ($arr_files as $key => $file_to_delete) {
					if(!empty($file_to_delete)) {
						unlink($file_to_delete);
					}
				}
				
			}
		}
		
		return $ERROR_MSG;
	}
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Add a item to combo global actions, on list archive
		* @param string   $title        		 Action title; 
		* @param string   $archive_method_name 	 Method name of archive wich will be fired when execute this global action
	*/	
	public function AddItemToGlobalActions($title, $archive_method_name) {
		$can_add = true;
		if (($archive_method_name=='GlobalActions_Delete') && (!$this->upload_permission_delete_item)) { $can_add = false;}
		if ($can_add) {
			array_push($this->global_actions,array($title, $archive_method_name));
		}
	}	
	/* ------------------------------------------------------------------------------------- */		
	public function ReturnGlobalActionsString() {
		$str_actions = '';
		$actions_length = count($this->global_actions);
		if ($actions_length>0) {				
			for ($i = 0; $i < $actions_length; $i++) {
				if (!empty($this->global_actions[$i][0])) {
					$str_actions .= '<option value="'.el_encript_info($this->global_actions[$i][1]).'">'.$this->global_actions[$i][0].'</option>'.PHP_EOL;
				}
			}
		}
		return $str_actions;
	}	
	/* ------------------------------------------------------------------------------------- */		
	//class constructor
	public function __construct() {
		parent::__construct();	
		$this->real_table_name = el_TableNameWithPrefix($this->upload_table_name);		
		$this->AddItemToGlobalActions('Stergere','GlobalActions_Delete');
	}	
	/* ------------------------------------------------------------------------------------- */	
}