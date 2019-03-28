<?php

class archive_reprezentanti extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'representants';
	public  $ida							    = 10;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Reprezentanti';
	public  $archive_icon_class     			= 'icon-user';
	
	public  $list_archive_title			    	= 'Lista reprezentanti client';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-list';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga reprezentant';
	
	public  $tabs   			    			= array(
													array('Reprezentanti','tab_reprezentant_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Reprezentanti';
	public  $archive_title_top_small        	= 'client';
	public  $activate_menuitem_id           	= -20;
	
	public $list_fields = array(	
                  array (
                  'title'                              => '<i class="icon-user"></i> Reprezentant',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'name',
				  'filter'                             => array (
																  'type'    => LFT_LIKE_FILTER,																  
																),
				  'width'                              => '',
				  'sortable'                           => true,
				  'function'                           => 'lf_reprezentant', 
				  'main-fields'                        => true, /*fields will appear in delete message */
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
                  array (
                  'title'                              => '<i class="fa fa-phone"></i> Telefon',
				  'type'                               => FIELD_PHONE,
				  'db_field'                           => 'phone',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   
                  array (
                  'title'                              => '<i class="fa fa-envelope"></i> E-mail',
				  'type'                               => FIELD_EMAIL,
				  'db_field'                           => 'email',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-sm hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   				   
                  array (
                  'title'                              => '<i class="fa fa-fax"></i> Fax',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'fax',
				  'width'                              => '10%',
				  'sortable'                           => false,
				  'responsive-classes'                 => 'hidden-md hidden-sm hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   				   

	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent, $idma='') {
		parent::__construct($oParent, $idma);
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_WARNING); 
		//$this->AddAlert('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_DANGER,'fa fa-bell-o fa-lg'); 
		//$this->AddAlert('Acesta este o alta alerta', MSG_INFO, 'icon-user'); 
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ShowEdit($id) {
		$id_decript = el_decript_info($id);
		if ($id_decript!=0) { $this->archive_title = 'Editare date reprezentant';} else { $this->archive_title = 'Adaugare reprezentant';}
		parent::ShowEdit($id);
	}	
	/* ------------------------------------------------------------------------------------- */
	public function lf_reprezentant($result_line, $link_to_edit){		
		//return '<a href="'.$this->LinkToEditItem($result_line['id'], 'reprezentanti', $this->idma).'"><strong>'.$result_line['name'].'</strong></a>';
		$ret_value = '<a href="'.$link_to_edit.'">'.$result_line['name'].'</a>';
		return $ret_value;
	}	
	/* ------------------------------------------------------------------------------------- */
}