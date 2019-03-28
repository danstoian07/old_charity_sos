<?php

class archive_galerii extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'galerii';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare detalii galerie';
	public  $archive_icon_class     			= 'fa fa-folder-open-o';

	public  $list_archive_title			    	= 'Lista galerii foto articol';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-folder-open-o';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga GALERIE FOTO';
	public  $list_edit_item_button_name         = 'Editeaza/Adauga poze';
	
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil"></i> Editeaza GALERIE FOTO','tab_galerii_general'),
													array('<i class="fa fa-camera"></i> Poze galerie','tab_upload_photo_files'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'GALERII FOTO articol';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 11;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Denumire','name'),
													array('Adaugat','date_add'),
													array('Ultima actualizare','date_mod'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
	public $list_fields = array(
                  array (
                  'title'                              => 'Index',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'display_index',
				  'width'                              => '2%',
				  'sortable'                           => true,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'hidden-xs col-sm-2 col-md-1 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  
				  
                   ),
                  array (
                  'title'                              => 'Denumire GALERIE',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																				  
				  'width'                              => '',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-6 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  
				  'function'                           => 'lf_return_galerie',  /* Method must have parameter "$result_line" */
                   ),

				   array (
                  'title'                              => 'Adaugat la Data',
				  'type'                               => FIELD_DATE,
				  'db_field'                           => 'date_add',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-sm-4 col-md-4 col-lg-2 hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  
                   ),
				   
				   
	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
	}	
	/* ------------------------------------------------------------------------------------- */	
	
	public function ShowEdit($id) {
		$id_decript = el_decript_info($id);
		//if ($id_decript!=0) { $this->archive_title = 'Panou subcategorie';} else { $this->archive_title = 'Adaugare subcategorie produs';}
		if ($id_decript!=0) { 
			global $oDB;
			$categ_name = '';
			$query  = "SELECT name FROM ".$this->real_table_name." WHERE id=$id_decript";
			$result = $oDB->db_query($query);
			if ($result_line = $oDB->db_fetch_array($result)) {
				$categ_name = $result_line['name'];
			}			
			$breadcrumb_title = 'Panou GALERIE FOTO';
			$this->archive_title = 'Panou GALERIE FOTO [ <span class="font-green-sharp bold uppercase">'.$categ_name.'</span> ]';
			} else { $this->archive_title = 'Adaugare GALERIE FOTO articol'; $breadcrumb_title = $this->archive_title;}
		$this->AddItemToBreadcrumbs($this->list_archive_title, $this->LinkToList($this->archtype));
		$this->AddItemToBreadcrumbs($breadcrumb_title, '');
		
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
		return $ERROR_MSG;		
	}		
	/* ------------------------------------------------------------------------------------- */		
	/* If logged user can edit item return TRUE. Othewise FALSE. Method will be rewritten if necessary */
	/*
	public function CanViewListLoggedUser(){
		return true;
	}
	*/
	/* ------------------------------------------------------------------------------------- */		
	public function lf_return_galerie($result_line, $link_to_edit){
		return '<a href="'.$link_to_edit.'">'.$result_line['name'].'</a>';
	}			
	/* ------------------------------------------------------------------------------------- */		
	
}