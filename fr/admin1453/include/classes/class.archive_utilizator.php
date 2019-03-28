<?php

class archive_utilizator extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'users';
	public  $ida							    = 10;
	public  $permission_add_item      		    = 0;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $permission_delete_item             = 0;
	public  $archive_title			        	= 'Panou editare';
	public  $archive_icon_class     			= 'fa fa-user';
	
	public  $list_archive_title			    	= 'Conturi Utilizatori';					/* Title of archive list */
	public  $list_archive_title_for_export    	= 'Conturi utilizatori';					/* Title of exported archive list */
	public  $list_archive_icon_class        	= 'fa fa-users';					/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga cont utilizator';
	public  $list_edit_item_button_name         = 'Editeaza';
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil"></i> Detalii Utilizator','tab_utilizator_cont'),
													array('<i class="fa fa-cog"></i> Setari utilizator','tab_utilizator_setari2'),
													/*array('<i class="fa fa-calendar"></i> Setari Calendar','tab_utilizator_calendar'),*/
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Profil Utilizator & Preferinte';
	public  $archive_title_top_small        	= '';
	
	public  $del_item_message                   = 'Confirmati stergerea contului utilizatorului <strong>%</strong> ?';
	public  $activate_menuitem_id           	= 120;
	public  $list_fields_for_export    			= array(
													array('Nume','name'),
													array('Telefon','phone'),
													array('E-mail','email'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
	public $list_fields = array(
                  array (
                  'title'                              => '<i class="fa fa-user"></i> Utilizator/Avocat',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																
				  'width'                              => '',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_visible', /* Method must have parameter "$result_line" */
                   ),				   
				   
                  array (
                  'title'                              => '<i class="fa fa-phone"></i> Telefon',
				  'type'                               => FIELD_PHONE,
				  'db_field'                           => 'phone',
				  'width'                              => '',
				  'sortable'                           => false,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
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
		$this->edit_button_back_show  = 0;
		$this->edit_button_save_show  = 0;
		$this->edit_button_more_show  = 0;	
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_WARNING); 
		//$this->AddAlert('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_DANGER,'fa fa-bell-o fa-lg'); 
		//$this->AddAlert('Acesta este o alta alerta', MSG_INFO, 'icon-user'); 
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ShowEdit($id) {
		$breadcrumb_title = '';
		$id_decript      = el_decript_info($id);
		$id_logged_user  = el_decript_info($_SESSION[APP_ID]["user"]["id"]);
		if ($id_decript!=$id_logged_user) {
			$ERROR_MSG = 'Nu ai drepturi de editare pentru aceasta inregistrare !';
			$this->parent->ShowMessage($ERROR_MSG,$this->LinkToList($this->archtype),'&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;',MSG_WARNING);
		} else {
			if ($id_decript!=0) { 
				global $oDB;
				$client_name = '';
				$query  = "SELECT name FROM ".$this->real_table_name." WHERE id=$id_decript";
				$result = $oDB->db_query($query);
				if ($result_line = $oDB->db_fetch_array($result)) {
					$client_name = $result_line['name'];
				}			
				$breadcrumb_title = 'Panou utilizator';
				$this->archive_title = 'Panou cont utilizator [ <span class="font-green-sharp bold uppercase">'.$client_name.'</span> ]';
				} else { 
					$this->archive_title = 'Adaugare utilizator'; $breadcrumb_title = $this->archive_title;
			}		
			$this->AddItemToBreadcrumbs($breadcrumb_title, '');		
			parent::ShowEdit($id);
		}
		
	}
	/* ------------------------------------------------------------------------------------- */	
	public function ExecuteBeforeDelete($id){		
		$ERROR_MSG = 'Nu aveti dreptul de a sterge aceasta inregistrare !';
		return $ERROR_MSG;
	}			
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteAfterUpdate($id){
		$this->update_json_calendar_colors_and_others_param($id);
		parent::ExecuteAfterUpdate($id);
	}			
	/* ------------------------------------------------------------------------------------- */
	public function update_json_calendar_colors_and_others_param($id_user){
		global $oDB;
		$query = "SELECT universal_f1, universal_f2, universal_f3, universal_f4, json_parameters, session_expire_time FROM $oDB->users WHERE $oDB->users.id = $id_user";
		$result = $oDB->db_query($query);
		$arr_colors = array();
		$session_expire_time = 20;
		$json_parameters     = '';
		if ($result_line = $oDB->db_fetch_array($result)) {			
			$arr_colors["universal_f1"] = $result_line['universal_f1'];
			$arr_colors["universal_f2"] = $result_line['universal_f2'];
			$arr_colors["universal_f3"] = $result_line['universal_f3'];
			$arr_colors["universal_f4"] = $result_line['universal_f4'];
			$session_expire_time        = $result_line['session_expire_time'];
			$json_parameters            = $result_line['json_parameters'];
		}
		$json_calendar_colors = json_encode($arr_colors);
		
		$arr_param = json_decode($json_parameters, true);
		$arr_param['s_expire'] = $session_expire_time; 
		$json_parameters = json_encode($arr_param);
		
		$query = "UPDATE $oDB->users SET json_calendar_colors='$json_calendar_colors', json_parameters='$json_parameters' WHERE id=$id_user";
		$result = $oDB->db_query($query);
	}	
	/* ------------------------------------------------------------------------------------- */
	/* suprascrie metoda originala */
	
	public function CanViewListLoggedUser(){
		return false;
	}
	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_visible($result_line, $link_to_edit){
		//$admin = ($result_line['type'] ? ' <i class="fa fa-cog"></i>' : '');
		return '<span ><a '.($result_line['active'] ? '' : 'class="font-grey-salt font-line-through" title="Cont suspendat"').' href="'.$link_to_edit.'">'.$result_line['name'].'</a> '.($result_line['type'] ? ' <i class="fa fa-cog font-grey-salt" title="Administrator"></i>' : '').'</span>';
	}		
	/* ------------------------------------------------------------------------------------- */
	
}