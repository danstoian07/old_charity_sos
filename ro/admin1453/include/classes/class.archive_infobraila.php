<?php

class archive_infobraila extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'articles';
	public  $ida							    = 60;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editare detalii informatie';
	public  $archive_icon_class     			= 'fa fa-map-o';

	public  $list_archive_title			    	= 'Lista informatii despre Braila';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-map-o';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga informatie despre Braila';
	public  $list_edit_item_button_name         = 'Editeaza';
	
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-pencil"></i> Editeaza informatie despre Braila','tab_infobraila_general'),													
													/*array('<i class="fa fa-exchange"></i> TAB-uri','tab_article_taburi'),*/
													array('<i class="fa fa-camera"></i> Poze lateral','tab_upload_photo_files'),
													/*array('<i class="fa fa-picture-o"></i> GALERII FOTO','tab_article_galerii'),*/
													array('<i class="fa fa-level-down"></i> Subarticole','tab_article_subarticle'),
													/*array('<i class="fa fa-cube"></i> Produse','tab_article_produse'),*/
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Informatii despre Braila';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 34;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Title','name'),
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
				  'style-classes'                      => '',   
				  'responsive-classes'                 => '',   
                   ),
					
				  array (
                  'title'                              => 'Titlu informatie',
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
				  'function'                           => 'lf_return_sectie',  /* Method must have parameter "$result_line" */
                   ),
				   /*
                  array (
                  'title'                              => 'Categorie',
				  'type'                               => FIELD_FUNCTION,			
				  'db_field'                           => 'idma',
				  'filter'                             => array (
																  'type'               => LFT_COMBO_FROM_TABLE,
																  'query_table'        => 'categories',
																  'db_field_title'     => 'name',
																  'db_field_value'     => 'id',
																  'first_line_message' => 'Select. Categoria',
																  'id_archive'         => 20,
																  'order_by'     	   => 'name ASC', 
																),				  																
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'style-classes'                      => '',   
				  'responsive-classes'                 => 'hidden-xs col-sm-4 col-md-4 col-lg-2',   
				  'function'                           => 'lf_return_categorie',    
                   ),				   
					*/
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
	public  $list_fields_order_by_fiels_no		= 2; 								/* Order list by column no X. Value from 1 ... */
	public  $list_fields_order_by_direction		= 'DESC';  							/* ASC or DESC */
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		parent::__construct($oParent);
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ListQuery() {
		/* field list in ListQuery() must contain all fields declared in "list_fields_for_export" property */
		$CATEG_TABLE = el_TableNameWithPrefix('categories');
		$query = "
			SELECT $this->real_table_name.*, $CATEG_TABLE.name AS categ_name, $CATEG_TABLE.slug AS categ_slug 
			FROM $this->real_table_name 
			LEFT JOIN $CATEG_TABLE ON $CATEG_TABLE.id=$this->real_table_name.idma 
			WHERE ".$this->query_where." ORDER BY ".$this->query_order_by;
		return $query;
	}	
	/* ------------------------------------------------------------------------------------- */
	
	public function ShowEdit($id) {
		$id_decript = el_decript_info($id);
		if ($id_decript!=0) { 
			global $oDB;
			$categ_name = '';
			$categ_table    = el_TableNameWithPrefix('categories');
			$query = "
			SELECT $this->real_table_name.name, $this->real_table_name.slug AS product_slug, $categ_table.slug AS categ_slug 
			FROM $this->real_table_name 
			LEFT JOIN $categ_table ON $categ_table.id = $this->real_table_name.idma 
			WHERE $this->real_table_name.id=$id_decript AND $this->real_table_name.id_archive =$this->ida";
			
			$result = $oDB->db_query($query);
			if ($result_line = $oDB->db_fetch_array($result)) {
				$categ_name = $result_line['name'];
				$this->AddItemToActionsMore('Vezi articolul in website', $this->return_link_in_website($result_line['categ_slug'], $result_line['product_slug']), 'fa fa-globe','_blank');
			}			
			$breadcrumb_title = $categ_name;
			$this->archive_title = 'Panou informatii Braila [ <span class="font-green-sharp bold uppercase">'.$categ_name.'</span> ]';
			} else { $this->archive_title = 'Adaugare informatii Braila'; $breadcrumb_title = $this->archive_title;}
		$this->AddItemToBreadcrumbs($this->list_archive_title, $this->LinkToList($this->archtype));
		$this->AddItemToBreadcrumbs($breadcrumb_title, '');
		
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_in_website($categ_slug, $product_slug){
		return __URL__.$categ_slug.DIRECTORY_SEPARATOR.$product_slug.DIRECTORY_SEPARATOR;
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_sectie($result_line, $link_to_edit){
		return '<a href="'.$link_to_edit.'">'.stripslashes($result_line['name']).'</a>';
	}			
	/* ------------------------------------------------------------------------------------- */		
	public function lf_return_categorie($result_line){		
		return '<span class="font-grey-salt">'.$result_line['categ_name'].'</span>';
	}		
	/* ------------------------------------------------------------------------------------- */		
	
}