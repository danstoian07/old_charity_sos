<?php

class tab_utilizator_calendar extends tab {
	public  $show_sidebar             = true;					  /* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width            = 5;						  /* no between 2 and 10 */		
	public  $sidebar_title            = 'Previzualizare';  /* title in sidebar */
	/* ------------------------------------------------------------------------------------- */	
	public $show_line_between_fields = false;
	public $fields = 
		array( 
		         array (
                  'type'                               => FIELD_TYPE_CUSTOM_CONTENT,
				  'content'                            => '<div id="demo_colors_terms" class="margin-bottom-10 fs12" style="padding: 3px; border-radius:3px; background:#1ba39c;color:#ffffff;">Culori pentru fundal si text - termene la dosar.</div><div class="clearfix"></div><div id="demo_colors_activity" class="margin-bottom-10 fs12" style="padding: 3px; border-radius:3px; background:#c5bf66;color:#ffffff;">Culori pentru fundal si text - activitati la dosar.</div>',
				  'show_in_sidebar'                    => true,
                  ),				  				

                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'SETARI CULORI CALENDAR',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-paint-brush',
                  'bold'                               => false,
                  ),
		
                 array (
                  'type'                               => FIELD_TYPE_COLOR_PICKER,
                  'title'                              => 'Culoare fundal termene la dosar',
                  'control_name'                       => 'bg_color_calendar_terms',
                  'input_type'                         => 'text',				/* can be html input type: text, color */
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'bg_color_calendar_terms',													
                  'db_field'                           => 'universal_f1',
				  'load_from_json'                     => 'json_calendar_colors',
                  'value'                              => '#1BA39C', 
                  'maxlength'                          => '7',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Culoarea fundalului pentru termenele la dosar este obligatorie',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_COLOR_PICKER,
                  'title'                              => 'Culoare text termene la dosar',
                  'control_name'                       => 'font_color_calendar_terms',
                  'input_type'                         => 'text',				/* can be html input type: text, color */
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'font_color_calendar_terms',													
                  'db_field'                           => 'universal_f2',
				  'load_from_json'                     => 'json_calendar_colors',
                  'value'                              => '#FFFFFF', 
                  'maxlength'                          => '7',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Culoarea textului pentru termenele la dosar este obligatorie',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_LINE_SEPARATOR,
                  'thickness'                          => 2,                                /* Default 1*/
                  'margin'                             => 20,                               /* Margin in px: Default 20*/
                  ),
                 array (
                  'type'                               => FIELD_TYPE_COLOR_PICKER,
                  'title'                              => 'Culoare fundal activitati la dosar',
                  'control_name'                       => 'bg_color_calendar_activity',
                  'input_type'                         => 'text',				/* can be html input type: text, color */
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'bg_color_calendar_activity',													
                  'db_field'                           => 'universal_f3',
				  'load_from_json'                     => 'json_calendar_colors',
                  'value'                              => '#c5bf66', 
                  'maxlength'                          => '7',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Culoarea fundalului pentru activitatile la dosar este obligatorie',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_COLOR_PICKER,
                  'title'                              => 'Culoare text activitati la dosar',
                  'control_name'                       => 'font_color_calendar_activity',
                  'input_type'                         => 'text',				/* can be html input type: text, color */
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'font_color_calendar_activity',													
                  'db_field'                           => 'universal_f4',
				  'load_from_json'                     => 'json_calendar_colors',
                  'value'                              => '#FFFFFF', 
                  'maxlength'                          => '7',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Culoarea textului pentru activitatile la dosar este obligatorie',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
				 array (
				  'type'                               => FIELD_TYPE_LOADING_BUTTON,
				  'title'                              => 'Resetare culori calendar',
				  'control_id'                         => 'id_ecris',
				  'value'                              => 'Reseteaza culorile la valorile implicite', 
				  'read_only'                          => false,																							  
				  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
				  'width'                        	   => 'load_from_ecris',	 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'static_icon_class'              	   => 'fa fa-undo',
				  'dinamic_icon_class'            	   => 'fa fa-cog',
				  'javascript_function'            	   => 'cst_ResetCalendarColors(this)',				  
					   ),
                 array (
                  'type'                               => FIELD_TYPE_TITLE,
                  'title'                              => 'CONTINUT CALENDAR',
                  'color_class'                        => 'font-green',                     /* Empty fo default */
                  'icon_class'                         => 'fa fa-calendar',
                  'bold'                               => false,
                  ),
					   
                  array (
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Continut',
                  'control_name'                       => 'calendar_type',
                  'db_field'                           => 'calendar_type',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati tip calendar',
                  'column_size'                        => '',
                  'width'                              => '',                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '0', 'icon_class' => '', 'selected' => false, 'title' => 'Afiseaza in calendar Dosare/Activitati utilizator', ),
                                                                   array ( 'value' =>  '1', 'icon_class' => '', 'selected' => false, 'title' => 'Afiseaza in calendar Dosare/Activitati societate', ),
                                                               ),
                        ),
                  array (
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Prima zi din calendar',
                  'control_name'                       => 'calendar_first_day',
                  'db_field'                           => 'calendar_first_day',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati prima zi din calendar',
                  'column_size'                        => '',
                  'width'                              => '',                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '0', 'icon_class' => '', 'selected' => false, 'title' => 'Duminica', ),
                                                                   array ( 'value' =>  '1', 'icon_class' => '', 'selected' => false, 'title' => 'Luni', ),
																   array ( 'value' =>  '2', 'icon_class' => '', 'selected' => false, 'title' => 'Marti', ),
																   array ( 'value' =>  '3', 'icon_class' => '', 'selected' => false, 'title' => 'Miercuri', ),
																   array ( 'value' =>  '4', 'icon_class' => '', 'selected' => false, 'title' => 'Joi', ),
																   array ( 'value' =>  '5', 'icon_class' => '', 'selected' => false, 'title' => 'Vineri', ),
																   array ( 'value' =>  '6', 'icon_class' => '', 'selected' => false, 'title' => 'Sambata', ),
																   array ( 'value' =>  '7', 'icon_class' => '', 'selected' => false, 'title' => 'Ziua curenta', ),
                                                               ),
                        ),
						
				array (
				  'type'                               => FIELD_TYPE_CHECKBOX,
				  'title'                              => 'Weekend',
				  'style'                              => 0,                                  /* 0 - Outline, 1 - Inline; Default: 0 */
				  'column_size'                        => '',
				  'fields'                             => array(
																 array (
																	  'title'                              => 'Afiseaza in calendar zilele de sambata si duminica', 
																	  'control_name'                       => 'calendar_show_weekend',
																	  'control_id'                         => '',
																	  'checked'                            => false,
																	  'read_only'                          => false,
																	  'db_field'                           => 'calendar_show_weekend',
																	  'help_message'                       => 'Daca e bifata optiunea in calendar vor fi afisate si zilele de weekend (sambata si duminica)',
																  ),
																  
														  ),
				),
						

	    );
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {		
		parent::__construct($oParent);		
		if (isset($this->parent->parent->json_calendar_colors)) {
			$arr_calendar_colors = json_decode($this->parent->parent->json_calendar_colors, true);
			$this->fields[0]['content']='<div id="demo_colors_terms" class="margin-bottom-10 fs12" style="padding: 3px; border-radius:3px; background:'.$arr_calendar_colors['universal_f1'].';color:'.$arr_calendar_colors['universal_f2'].';">Culori pentru fundal si text - termene la dosar.</div><div class="clearfix"></div><div id="demo_colors_activity" class="margin-bottom-10 fs12" style="padding: 3px; border-radius:3px; background:'.$arr_calendar_colors['universal_f3'].';color:'.$arr_calendar_colors['universal_f4'].';">Culori pentru fundal si text - activitati la dosar.</div>';
		}
	}	
	/* ------------------------------------------------------------------------------------- */	
}