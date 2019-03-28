<?php

class archive_afise extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'afise';
	public  $ida							    = 0;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare detalii afis';
	public  $archive_icon_class     			= 'fa fa-image';

	public  $list_archive_title			    	= 'Lista afise';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-image';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga afis';
	public  $list_edit_item_button_name         = 'Editeaza';
	
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil"></i> Editeaza afis','tab_afise_general'),
													/*array('<i class="fa fa-gear"></i> Setari META','tab_meta'),*/
													/*array('<i class="fa fa-cube"></i> Produse','tab_article_produse'),*/
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Colectia de afise';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 15;								/* id of menuitem wich will be active when panel show */
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
				  'responsive-classes'                 => '',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  				  
                   ),
				  array (
                  'title'                              => 'Poza',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'featured_image',
				  'width'                              => '',
				  'sortable'                           => false,
				  'style-classes'                      => '',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-3 col-md-2 col-lg-1',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  
				  'function'                           => 'lf_return_photo',  /* Method must have parameter "$result_line" */
                   ),

				  array (
                  'title'                              => 'Descriere',
				  'type'                               => FIELD_FUNCTION,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																				  
				  'width'                              => '',
				  'sortable'                           => false,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-6 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  
				  'function'                           => 'lf_return_visible',  /* Method must have parameter "$result_line" */
                   ),

				   array (
                  'title'                              => 'Adaugata la Data',
				  'type'                               => FIELD_DATETIME,
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
	public  $list_fields_order_by_fiels_no		= 1; 								/* Order list by column no X. Value from 1 ... */
	public  $list_fields_order_by_direction		= 'ASC';  							/* ASC or DESC */
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
	}	
	/* ------------------------------------------------------------------------------------- */	
	
	public function ShowEdit($id) {
		$id_decript = el_decript_info($id);		
		$this->AddItemToBreadcrumbs($this->list_archive_title, $this->LinkToList($this->archtype));
		//$this->AddItemToBreadcrumbs($breadcrumb_title, '');
		
		parent::ShowEdit($id);
	}
	/* ------------------------------------------------------------------------------------- */	
	/* ------------------------------------------------------------------------------------- */	
	/* function will be executed after operation UPDATE. Rewrited method */	
	/**
		* @param int   $id     		 id of updated items
	*/	
	public function ExecuteAfterUpdate($id){
		$ERROR_MSG = '';
		$ERROR     = false;
		
		$SliderString = '';
		global $oDB;
		/*
		$query = "SELECT * FROM el_slider WHERE id_archive = 0 AND visible!=0 ORDER BY display_index ASC, date_add DESC";
		$result = $oDB->db_query($query);		
		if ($oDB->db_num_rows($result)==0) {
			$ERROR = true; $ERROR_MSG = _('Nu exista inregistrari in meniu !');
		} else {
			  $i=15;
			  while ($result_line = $oDB->db_fetch_array($result)) {
				  $i++;				  
				  
				  $SliderString .= ''.PHP_EOL;							
				  
			  }
		}
		*/
		if (!$ERROR) {
			//$myFile = __APPFILESPATH__."generate/slider_first_page.php";
			//$fh = fopen($myFile, 'w') or die("can't open file");
			//fwrite($fh, $SliderString);    
			//fclose($fh); 
		}
		
		return $ERROR_MSG;		
	}		
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteAfterInsert(){
		$ERROR_MSG = '';
		$ERROR_MSG = $this->ExecuteAfterUpdate(0);
		return $ERROR_MSG;		
	}		
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteAfterDelete($id){		
		$ERROR_MSG = '';
		$ERROR_MSG = $this->ExecuteAfterUpdate(0);
		return $ERROR_MSG;	
	}			
	/* ------------------------------------------------------------------------------------- */
	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_visible($result_line){
		return '<span '.($result_line['visible'] ? '' : 'class="font-grey-salt"').'>'.stripslashes($result_line['name']).'</span>';
	}	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_photo($result_line){
		return '<img src="'.el_AdminCropImage($result_line['featured_image'], 100, 153).'" />';
	}		
	/* ------------------------------------------------------------------------------------- */		
	
}