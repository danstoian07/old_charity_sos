<?php

class archive_utilizatori extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'users';
	public  $ida							    = 10;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $permission_delete_item             = 1;
	public  $archive_title			        	= 'Panou editare';
	public  $archive_icon_class     			= 'fa fa-user-secret';
	
	public  $list_archive_title			    	= 'Conturi Utilizatori';					/* Title of archive list */
	public  $list_archive_title_for_export    	= 'Conturi utilizatori';					/* Title of exported archive list */
	public  $list_archive_icon_class        	= 'fa fa-user-secret';					/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga';
	public  $list_edit_item_button_name         = 'Editeaza';
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil"></i> Detalii Utilizator','tab_utilizator_general'),
													array('<i class="fa fa-cog"></i> Setari utilizator','tab_utilizator_setari'),
													array('<i class="fa fa-cog"></i> Drepturi acces','tab_utilizator_rights'),
													array('<i class="fa fa-pencil-square-o"></i> Monitorizare Activitate','tab_article_monitorizare'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Conturi utilizatori';
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
                  'title'                              => '<i class="fa fa-user-secret"></i> Utilizator',
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
		if (!$this->user_rights_by_admin['administrator']) {
			/* atentie: tab-urile se elimina de la dreapta la stanga */
			if ($this->user_rights_by_admin['permission_tab_monitorizare']==0) {
				array_splice($this->tabs, 2,1);
			}
			if ($this->user_rights_by_admin['permission_tab_drepturi_acces']==0) {
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
			$breadcrumb_title = 'Panou cont utilizator';
			$this->archive_title = 'Panou cont utilizator [ <span class="font-green-sharp bold uppercase">'.$client_name.'</span> ]';
			} else { $this->archive_title = 'Adaugare'; $breadcrumb_title = $this->archive_title;}
		$this->AddItemToBreadcrumbs($this->list_archive_title, $this->LinkToList($this->archtype));
		$this->AddItemToBreadcrumbs($breadcrumb_title, '');		
		parent::ShowEdit($id);
		
	}
	/* ------------------------------------------------------------------------------------- */
	/* rescrie metoda originala */
	public function ExecuteBeforeUpdate($id){
		// $id - ESTE DECRIPTAT
		$ERROR_MSG = '';
		global $oDB;		
		$query  = "SELECT count(*) AS no_admin FROM ".$this->real_table_name." WHERE id!=$id AND type=1";
		$result = $oDB->db_query($query);
		$admin_no = 0;
		if ($result_line = $oDB->db_fetch_array($result)) {
			$admin_no = $result_line['no_admin'];
			if (($admin_no==0) && ($_POST["type"]==0)) {
				$ERROR_MSG = 'Nu pot face update-ul !<br><strong>Sistemul trebuie sa aiba cel putin un administrator !</strong>';
			}
		} else {
			$ERROR_MSG = 'Eroare determinare drepturi administrare !';
		}
		return $ERROR_MSG;
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function ExecuteBeforeDelete($id){		
		// $id - ESTE DECRIPTAT
		$ERROR_MSG = '';
		$ERROR     = false;
		global $oDB;		
		$query  = "SELECT count(*) AS no_admin FROM ".$this->real_table_name." WHERE id!=$id AND type=1";
		$result = $oDB->db_query($query);
		$admin_no = 0;
		if ($result_line = $oDB->db_fetch_array($result)) {
			$admin_no = $result_line['no_admin'];
			if ($admin_no==0) {
				$ERROR     = true;
				$ERROR_MSG = 'Nu pot sterge utilizatorul !<br><strong>Sistemul trebuie sa aiba cel putin un administrator !</strong>';				
			}
		} else {
			$ERROR     = true;
			$ERROR_MSG = 'Eroare determinare drepturi administrare !';
		}
		if (!$ERROR) {
			/* aici verifica daca user-ul are dosare */
		}
		return $ERROR_MSG;
	}			
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_visible($result_line, $link_to_edit){
		//$admin = ($result_line['type'] ? ' <i class="fa fa-cog"></i>' : '');
		return '<a '.($result_line['active'] ? '' : 'class="font-grey-salt font-line-through" title="Cont suspendat"').' href="'.$link_to_edit.'">'.$result_line['name'].'</a> '.($result_line['type'] ? ' <i class="fa fa-cog font-grey-salt" title="Administrator"></i>' : '').'';
	}		
	/* ------------------------------------------------------------------------------------- */
	
}