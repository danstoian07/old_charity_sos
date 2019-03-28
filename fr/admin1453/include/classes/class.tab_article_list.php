<?php
/* generic class */
class tab_article_list extends tab {
	public $archive_name = ''; /* name of archive which will be displayed in tab */
	public $edit_tab    = false; /* will be true for tab with editable fields, for tab with list content will be false */		
	/* ------------------------------------------------------------------------------------- */	
	public function ReturnTabContent($arr_fields, $result_line='', $result_multiselect='', $tab_no=0) {    
		if (!empty($this->archive_name)) {
			$eval_str = "\$objList = new ".$this->archive_name."(NULL);"; 
			eval($eval_str);		
			return $objList->ShowListInTab($tab_no, $this->archive_name);
		} else {
			return _('Eroare: Nume archiva nespecificat (pentru listarea in TAB) !');
		}
	}
	/* ------------------------------------------------------------------------------------- */		
	public function __construct() {
		parent::__construct();
	}	
	/* ------------------------------------------------------------------------------------- */	
}