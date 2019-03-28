<?php

class tab_article_termene extends tab_article_list {
	public $archive_name = "archive_termene"; /* name of archive which will be displayed in tab */
	/* ------------------------------------------------------------------------------------- */		
	public function __construct() {
		parent::__construct();		
	}	
	/* ------------------------------------------------------------------------------------- */
	public function Hide($result_line='') {
		if ((isset($result_line['type'])) && ($result_line['type']==2)) {
			/* nu afisa tab-ul pentru termene in cazul dosarelor de executare silita */			
			return true;
		}
		return false;
	}	
	
	/* ------------------------------------------------------------------------------------- */	
}