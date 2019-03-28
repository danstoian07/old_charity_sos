<?php

class archive_setari_coperte extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'app_settings';
	public  $ida							    = 20;
	public  $permission_add_item      		    = 0;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Editeaza setare';
	public  $archive_icon_class     			= 'fa fa-cog';

	public  $list_archive_title			    	= 'Lista Setari';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-cog';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga setare';
	public  $list_edit_item_button_name         = 'Edit';
	
	
	public  $tabs   			    			= array(
													array('<i class="fa fa-camera"></i> Coperti Editura Istros','tab_upload_photo_files'),
													/*array('<i class="fa fa-cog"></i> Setari Generale','tab_setari_generale'),*/
													/*array('<i class="fa fa-cog"></i> Homepage','tab_setari_fp'),
													array('<i class="fa fa-cog"></i> Contact','tab_setari_contact'),
													/*array('<i class="fa fa-cog"></i> Bannere Top','tab_setari_topbanners'),*/
													/*array('<i class="fa fa-cog"></i> Editura Istros','tab_setari_istros'),*/
													/*
													array('<i class="fa fa-arrow-down"></i> Footer website','tab_setari_footer'),
													array('<i class="fa fa-home"></i> Prima pagina','tab_setari_fp'),
													array('<i class="fa fa-phone"></i> Contact','tab_setari_contact'),
													array('<i class="fa fa-wpforms"></i> Formulare','tab_article_parteneri'),
													array('<i class="fa fa-bank"></i> Companie','tab_setari_companie'),
													array('<i class="fa fa-shopping-cart"></i> Comanda','tab_setari_comanda'),
													array('<i class="fa fa-cube"></i> Detalii produs','tab_setari_produs'),
													*/
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Setari';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= 1122;								/* id of menuitem wich will be active when panel show */
	public  $list_fields_for_export    			= array(
													array('Nume','name'),
													array('Header Email','header_email'),
													array('Header Tel','header_phone'),
												);	/* Field from database to export Ex: (($table_head_title1, $database_field_1),(($table_head_title1, $database_field_1) ...) */
	
	
	public $list_fields = array(

				  array (
                  'title'                              => 'Nume atribut',
				  'type'                               => FIELD_VALUE,			/*for this type of data the array must contain index "function". Will store method name of class wich will process the data; */
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),																				  
				  'width'                              => '',
				  'sortable'                           => true,
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-6 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */				  
                   ),				   
				   
				   
	);
	public  $edit_button_back_show          	= 0;
	public  $edit_button_save_show          	= 0;
	public  $edit_button_more_show          	= 0;	
	
	public  $list_fields_order_by_fiels_no		= 1; 								/* Order list by column no X. Value from 1 ... */
	public  $list_fields_order_by_direction		= 'ASC';  							/* ASC or DESC */	

	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL, $idma='') {
		parent::__construct($oParent);
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
	}	
	/* ------------------------------------------------------------------------------------- */	
	
	public function ShowEdit($id) {
		$breadcrumb_title = 'Setari Aplicatie & Administrare';
		$this->archive_title = 'Setari Aplicatie & Administrare';
		//$this->AddItemToBreadcrumbs($this->list_archive_title, $this->LinkToList($this->archtype));
		$this->AddItemToBreadcrumbs($breadcrumb_title, '');
		
		parent::ShowEdit($id);
	}
	
	/* ------------------------------------------------------------------------------------- */		
	/* function will be executed after operation UPDATE. Rewrited method */	
	/**
		* @param int   $id     		 id of updated items
	*/	
	
	/* ------------------------------------------------------------------------------------- */
	
}