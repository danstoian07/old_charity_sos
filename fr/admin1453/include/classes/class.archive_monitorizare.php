<?php

class archive_monitorizare extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'users_track';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 0;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $permission_delete_item             = 1;
	public  $archive_title			        	= 'Panou monitorizare';
	public  $archive_icon_class     			= 'fa fa-pencil-square-o';
	
	public  $list_archive_title			    	= 'Luni monitorizare';					/* Title of archive list */
	public  $list_archive_title_for_export    	= 'Luni monitorizare';					/* Title of exported archive list */
	public  $list_archive_icon_class        	= 'fa fa-pencil-square-o';					/* icon for title of archive list */
	public  $list_add_button_show               = 0;
	public  $list_add_button_name               = 'Adauga';
	public  $list_edit_item_button_name         = 'Detalii';
	public  $list_visibility			        = 1;								/* 0 separat si in tab, 1 - only in tab */

	public  $edit_button_save_show          	= 0;	
	public  $edit_button_save_continue_show 	= 0;
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil-square-o"></i> Detalii Monitorizare','tab_monitorizare_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Monitorizare';
	public  $archive_title_top_small        	= '';
	
	public  $del_item_message                   = 'Confirmati stergerea lunii de monitorizare ?';
	public  $activate_menuitem_id           	= 120;
	public  $list_fields_for_export    			= array(
													array('An','year'),
													array('Luna','month'),
													array('Online (sec)','secconds_logged'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
	public $list_fields = array(
                  array (
                  'title'                              => '<i class="fa fa-calendar-check-o"></i> An/Luna',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																
				  'width'                              => '',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-6 col-md-6 col-lg-4',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  'function'                           => 'lf_return_luna', /* Method must have parameter "$result_line" */
                   ),				   
                  array (
                  'title'                              => '<i class="fa fa-clock-o"></i> Timp online',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'seconds_logged',
				  'width'                              => '',
				  'sortable'                           => false,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'hidden-xs col-sm-4 col-md-3 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				   'function'                          => 'lf_return_time', /* Method must have parameter "$result_line" */
                   ),
				   
				   				   
				   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);		
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
			$panel_name = '';
			$query  = "
				SELECT $oDB->users_track.year, $oDB->users_track.month, $oDB->users.name  
				FROM $oDB->users_track 
				LEFT JOIN $oDB->users ON $oDB->users_track.idma = $oDB->users.id 
				WHERE $oDB->users_track.id=$id_decript";
			$result = $oDB->db_query($query);
			if ($result_line = $oDB->db_fetch_array($result)) {
				$panel_name = $result_line['name'].' | '.el_RomanianMonthName($result_line['month']).' '.$result_line['year'];
			}			
			$breadcrumb_title = 'Panou activitate';
			$this->archive_title = 'Panou activitate [ <span class="font-green-sharp bold uppercase">'.$panel_name.'</span> ]';
			} else { $this->archive_title = 'Adaugare avocat'; $breadcrumb_title = $this->archive_title;}
		$this->AddItemToBreadcrumbs($this->list_archive_title, $this->LinkToList($this->archtype));
		$this->AddItemToBreadcrumbs($breadcrumb_title, '');		
		parent::ShowEdit($id);
		
	}
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_luna($result_line, $link_to_edit){		
		return '<a href="'.$link_to_edit.'">'.$result_line['year'].' '.el_RomanianMonthName($result_line['month']).'</a>';
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_time($result_line, $link_to_edit){
		return gmdate("H:i:s", $result_line['seconds_logged']);
	}			
	/* ------------------------------------------------------------------------------------- */
	
}