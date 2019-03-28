<?php

class archive_info extends archive {
	/* ------------------------------------------------------------------------------------- */	
	//public  $archive_title			      = 'Avocati';
	//public  $archive_icon_class     		  = 'fa-file-o';
	public  $activate_menuitem_id             = -1;
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent, $msg_type) {
		parent::__construct($oParent);		

		$this->archive_title_top_big = 'MESAJ APLICATIE';
		switch ($msg_type) {
		    case MSG_SUCCESS: $this->archive_title_top_small = 'succes';    break; 
		    case MSG_INFO   : $this->archive_title_top_small = 'informare'; break;    
		    case MSG_DANGER : $this->archive_title_top_small = 'pericol';   break;  
		    case MSG_WARNING: $this->archive_title_top_small = 'atentionare'; break; 
		}

		$this->AddItemToBreadcrumbs(ucfirst(strtolower($this->archive_title_top_big)), '');
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ShowInfo() {
		 	include(__THEMEPATH__.'app_header.php');
		 	include(__THEMEPATH__.'page_info.php');
		 	include(__THEMEPATH__.'app_footer.php');				 
	}		
	/* ------------------------------------------------------------------------------------- */	
}