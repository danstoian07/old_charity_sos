<?php

class tab_article_parti extends tab_article_list {
	public $archive_name = "archive_parti"; /* name of archive which will be displayed in tab */
	public  $edit_tab                 		= false;
	/* ------------------------------------------------------------------------------------- */		
	public function __construct() {
		parent::__construct();		
	}	
	/* ------------------------------------------------------------------------------------- */	
}