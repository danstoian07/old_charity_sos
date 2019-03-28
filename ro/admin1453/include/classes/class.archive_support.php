<?php
class archive_support extends archive_custom {
	/* ------------------------------------------------------------------------------------- */	
	public  $list_archive_title			    = 'Suport';						/* Title of archive */
	public  $activate_menuitem_id           = 122;					    /* id of menuitem wich will be active when panel show */
	public  $actions_title                  = 'Actiuni';

	public  $archive_title_top_big          	= '<strong>Support tehnic</strong>';
	public  $archive_title_top_small        	= 'aplicatie Easy Law';
	
		
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {
		parent::__construct($oParent);
		$this->AddItemToBreadcrumbs('Suport Easy Law', '');
		//$this->AddItemToActions('Adauga eveniment', __ADMINURL__, 'fa fa-calendar-plus-o');
		//$this->AddItemToActions('Tipareste agenda', __ADMINURL__, 'fa fa-print');
		//$this->AddItemToActions('Preferinte', __ADMINURL__.'?pn=3&archtype=utilizator&id='.$_SESSION[APP_ID]["user"]["id"].'&tab=2', 'fa fa-cog');
		
	}
	/* ------------------------------------------------------------------------------------- */	
	public function IncludeResources() {
		include(__THEMEPATH__.'app_header_support.php');
		include(__THEMEPATH__.'page_support.php');
		include(__THEMEPATH__.'app_footer_support.php');
	}
	/* ------------------------------------------------------------------------------------- */	
	/* ------------------------------------------------------------------------------------- */
}