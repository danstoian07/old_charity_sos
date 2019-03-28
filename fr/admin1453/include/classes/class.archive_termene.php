<?php

class archive_termene extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'termene';
	public  $ida							    = 10;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Termen in dosar';
	public  $archive_icon_class     			= 'fa fa-clock-o';
	
	public  $list_archive_title			    	= 'Lista termene dosar';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-clock-o';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga termen in dosar';
		
	public  $tabs   			    			= array(
													array('Termen in dosar','tab_termen_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Termene in dosar';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= -20;
	public  $list_fields_order_by_fiels_no	    = 1; 								/* Order list by column no X. Value from 1 ... */
	public  $list_fields_order_by_direction	    = 'DESC';  							/* ASC or DESC */
	
	
	public $list_fields = array(	
                  array (
                  'title'                              => 'Termen',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'data_termen',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'function'                           => 'lf_return_date',    /* Method must have parameter "$result_line" */
				  'responsive-classes'                 => 'col-xs-6 col-sm-4 col-md-4 col-lg-2',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
				  array (
                  'title'                              => 'Complet',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'complet',
				  'width'                              => '5%',
				  'responsive-classes'                 => 'hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  
                   ),				   
				  array (
                  'title'                              => 'Solutie',
				  'type'                               => FIELD_VALUE,
				  'db_field'                           => 'solutie',
				  'width'                              => '40%',
				  'responsive-classes'                 => 'hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
				  
                   ),				   


	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {
		
		parent::__construct($oParent);
		$this->query_order_by = "$this->real_table_name.data_termen DESC";
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_WARNING); 
		//$this->AddAlert('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_DANGER,'fa fa-bell-o fa-lg'); 
		//$this->AddAlert('Acesta este o alta alerta', MSG_INFO, 'icon-user'); 
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ShowEdit($id) {
		if ($this->lawyer_can_access_termen($id)) {
			if ($id!=0) { $this->archive_title = 'Editare detalii avocat';} else { $this->archive_title = 'Adaugare avocat';}
			parent::ShowEdit($id);
		} else {
			el_redirect(__ADMINURL__.'?pn=2&archtype=dosare');
		}
	}
	
	/* ------------------------------------------------------------------------------------- */	
	public function lawyer_can_access_termen($id) {
		$id_decript = el_decript_info($id);
		$can_access = true;
		if (!$this->user_rights_by_admin['administrator']) {
			global $oDB;
			$rights_dosare = $this->GetArchiveUserRightsByAdmin('dosare');
			if ($rights_dosare['permission_view_neassociated_cases']==0) {
						$can_access = false;
						if (isset($_REQUEST['idma'])) {
							$id_dosar =  el_decript_info($_REQUEST['idma']);
							/* --- */
							$query ="SELECT id_options FROM $oDB->multiselect_options WHERE id_archive=20 AND id_main_item=$id_dosar";							
							$result = $oDB->db_query($query);			
							while ($result_line = $oDB->db_fetch_array($result)) {
								if ($result_line['id_options']==$this->user_id){
									$can_access = true;
									break;
								}			
							}
							/* --- */
							if ($can_access) {
								if ($id_decript>0) {
									/* verifica daca id-ul partii corespunde dosarului */
									$query = "SELECT COUNT(*) AS no FROM $oDB->termene WHERE id=$id_decript AND idma=$id_dosar";
									$result = $oDB->db_query($query);
									if ($result_line = $oDB->db_fetch_array($result)) {
										if ($result_line['no']!=1){
											$can_access = false;
										}										
									}
								}				
							}
							/* --- */
						}
			}
		}
		return $can_access;
	}			

	/* ------------------------------------------------------------------------------------- */
	public function lf_return_date($result_line, $link_to_edit){
		return '<a href="'.$link_to_edit.'">'.el_MysqlDate_To_RomanianDate($result_line['data_termen']).'</a><br /><span class="font-normal">Ora estimata: <strong>'.$result_line['ora'].'</strong></span>';
	}	
	/* ------------------------------------------------------------------------------------- */
}