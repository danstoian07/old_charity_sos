<?php
class archive_calendar extends archive_custom {
	/* ------------------------------------------------------------------------------------- */	
	public  $list_archive_title			    = 'Calendar';						/* Title of archive */
	public  $activate_menuitem_id           = 110;					    /* id of menuitem wich will be active when panel show */
	public  $actions_title                  = 'Calendar';
		
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {
		parent::__construct($oParent);
		$this->AddItemToBreadcrumbs('Easy Calendar', '');
		$this->AddItemToActions('Adauga eveniment', __ADMINURL__, 'fa fa-calendar-plus-o');
		$this->AddItemToActions('Tipareste agenda', __ADMINURL__, 'fa fa-print');
		$this->AddItemToActions('Preferinte', __ADMINURL__.'?pn=3&archtype=utilizator&id='.$_SESSION[APP_ID]["user"]["id"].'&tab=3', 'fa fa-cog');
		
	}
	/* ------------------------------------------------------------------------------------- */	
	public function IncludeResources() {
		include(__THEMEPATH__.'app_header_calendar.php');
		include(__THEMEPATH__.'page_calendar.php');
		include(__THEMEPATH__.'app_footer_calendar.php');
	}
	/* ------------------------------------------------------------------------------------- */	
	/* ------------------------------------------------------------------------------------- */
}