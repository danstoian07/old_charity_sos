<?php

class tab_utilizator_setari extends tab {
	public  $show_sidebar             = true;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width            = 4;						/* no between 2 and 10 */		
	/* ------------------------------------------------------------------------------------- */	
	public $show_line_between_fields = false;
	public $fields = 
		array( 
                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'SESIUNE DE LUCRU',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-clock-o',
                  'bold'                               => false,
                  ),
		
                  array (                  
				  'type'                               => FIELD_TYPE_INFO,
				  'title'                              => '',
                  'message_type'                       => MSG_INFO,						/*can be: MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING */
				  'class_method_for_content'		   => 'session_settings_info',		/* metoda suprascrie sectiunea message */
				  'message'                            => 'Acesta este un mesaj',
				  'show_in_sidebar'                    => false,                             /* this field will be show in sidebar */
				  'hide_on_add'                    	   => false,                            /* hide field for add operation */
                  ),                                                                                                                            					   
		
                  array (
                  'type'                               => FIELD_TYPE_COMBO_BOOTSTRAP_CUSTOM,
                  'title'                              => 'Sesiunea de lucru expira in',
                  'control_name'                       => 'session_expire_time',
                  'db_field'                           => 'session_expire_time',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati timpul de expirare al sesiunii de lucru',
                  'column_size'                        => '',
                  'width'                              => '',                                                                                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'help_message'                       => 'Timpul de inactivitate dupa care expira sesiunea de lucru iar aplicatia se inchide automat',
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '10',  'selected' => false, 'title'   => '10 minute', ),
																   array ( 'value' =>  '20',  'selected' => false, 'title'   => '20 minute', ),
																   array ( 'value' =>  '30',  'selected' => false, 'title'   => '30 minute', ),
																   array ( 'value' =>  '40',  'selected' => false, 'title'   => '40 minute', ),
																   array ( 'value' =>  '50',  'selected' => false, 'title'   => '50 minute', ),
																   array ( 'value' =>  '60',  'selected' => false, 'title'   => '60 minute', ),
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