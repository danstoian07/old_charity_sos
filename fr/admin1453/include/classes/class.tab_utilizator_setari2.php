<?php

class tab_utilizator_setari2 extends tab {
	public  $show_sidebar             = true;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width            = 4;						/* no between 2 and 10 */		
	/* ------------------------------------------------------------------------------------- */	
	public $show_line_between_fields = false;
	public $fields = 
		array( 
                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'SETARI GENERALE',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-clock-o',
                  'bold'                               => false,
                  ),
		
                  array (                  
                  'type'                               => FIELD_TYPE_CHECKBOX,
                  'title'                              => 'Afiseaza',
                  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
                  'column_size'                        => '',				  
                  'fields'                             => array(
                                                                 array (
                                                                      'title'                              => 'Afiseaza in aplicatie Quick Menu (meniul de editare rapida)', 
                                                                      'control_name'                       => 'show_quick_menu',
                                                                      'control_id'                         => '',
                                                                      'checked'                            => false,
                                                                      'read_only'                          => false,
                                                                      'db_field'                           => 'show_quick_menu',
																	  'help_message'                       => 'Daca e bifata aceasta optiune, in partea dreapta a aplicatiei se va afisa permanent un meniu de adaugare rapida a clientilor, dosarelor si contractelor.',
                                                                  ),                                                                 
                                                          ),
                  ),
		
	    );
	/* ------------------------------------------------------------------------------------- */	
	public function session_settings_info($param='') {
		$maxlifetime = floor(ini_get("session.gc_maxlifetime")/60);
		return "Timpul maxim acceptat de server pentru o sesiune de lucru este de <span class=\"bold\">$maxlifetime minute</span>. Setati timpul de expirare al sesiunii de lucru mai mic sau egal cu aceasta valoare.";
	}
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		

	}	
	/* ------------------------------------------------------------------------------------- */	
}