<?php

class tab_incasare_general extends tab {
	public  $show_sidebar             = true;					/* will display right sidebar info (only if $this->edit_tab==true ) */	
	public  $sidebar_width            = 4;						/* no between 2 and 10 */					
	/* ------------------------------------------------------------------------------------- */	
	public  $show_line_between_fields = false;
	public $fields = 
		array( 
                  array (
                  'type'                               => FIELD_TYPE_DATETIME,
                  'title'                              => 'Adaugat',
                  'control_name'                       => 'date_add',
                  'control_id'                         => 'date_add',
                  'value'                              => '',
                  'read_only'                          => true,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => false,
                  'db_field'                           => 'date_add',
                  'required'                           => true,
                  'required_message'                   => 'Completati data adaugarii articolului !',
				  'placeholder'                        => 'zz-ll-yyyy hh:mm',
                  'column_size'                        => '9',                              /*1-10, default: 4*/
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'hide_on_add'                    	   => true,                             /* hide field for add operation */
                  ),                                                                                                                            
                  array (
                  'type'                               => FIELD_TYPE_DATETIME,
                  'title'                              => 'Ultima actualizare',
                  'control_name'                       => 'date_mod',
                  'control_id'                         => 'date_mod',
                  'value'                              => '',
                  'read_only'                          => true,
                  'can_select_date'                    => false,
                  'can_delete_date'                    => false,
                  'db_field'                           => 'date_mod',
                  'required'                           => false,
                  'required_message'                   => 'Completati adaugarii articolului !',
				  'placeholder'                        => 'zz-ll-yyyy hh:mm',
                  'column_size'                        => '9',                              /*1-10, default: 4*/
				  'show_in_sidebar'                    => true,                             /* this field will be show in sidebar */
				  'skip_update'                        => true,                             /* no update for this field */
				  'hide_on_add'                    	   => true,                             /* hide field for add operation */
                  ),                                                                                                                            
				  array (
				  'type'                               => FIELD_TYPE_COMBO_WITH_SEARCH,
				  'title'                              => 'Numar contract',
				  'control_name'                       => 'id_ctr',
				  'db_field'                           => 'idma',
				  'control_id'                         => '',
				  'query_table'                        => 'contracts',                         /* TABLE NAME without app table prefix */
				  'db_field_value'                     => 'id',
				  'db_field_title'                     => 'contract_no',
				  'query'              				   => 'SELECT el_contracts.id, CONCAT(el_contracts.contract_no," | ", DATE_FORMAT(el_contracts.contract_data,"%d-%m-%Y"), " | ", el_clients.name) AS title FROM el_contracts LEFT JOIN el_clients ON el_clients.id=el_contracts.idma WHERE el_contracts.id_archive=0 LIMIT 100000',
				  'id_archive'                         => 0,
				  'order_by_field'                     => 'contract_no',
				  'order_direction'                    => 'ASC',
				  'limit_items'                        => 1000,
				  'first_line_message'                 => 'Selectati nr. contact',              /* Leave empty for: without select message */
				  'read_only'                          => false,
				  'required'                           => true,
				  'required_message'                   => 'Selectati un numar de contract',
				  'column_size'                        => '',
				  'width'                              => '',
						),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Document incasare',
                  'control_name'                       => 'document',
                  'input_type'                         => 'text',				/* can be html input type: text, email, etc*/
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => '',													
                  'db_field'                           => 'document',
                  'value'                              => '', 
                  'maxlength'                          => '50',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Introduceti numarul documentului de incasare !',
				  'help_message'                   	   => 'Ex. incasare cu chitanta: CHT123546, Ex. incasare cu OP: OP546',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                  array (
                  'type'                               => FIELD_TYPE_DATE,
                  'title'                              => 'Date incasarii',
                  'bottom_info'                        => 'Selecteaza Data',
                  'control_name'                       => 'date_receipt',
                  'control_id'                         => 'date_receipt',
                  'date_format'                        => 'dd-mm-yyyy',             		/* can be only: dd-mm-yyyy*/
                  'value'                              => '',
                  'read_only'                          => false,
                  'can_select_date'                    => true,
                  'can_delete_date'                    => true,
                  'db_field'                           => 'date_receipt',
                  'required'                           => true,
                  'required_message'                   => 'Completati data incasarii !',
				  'placeholder'                        => 'zz-ll-yyyy',
                  'width'                              => '',                  
                  ),                                                                                                                            
                  array (
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Moneda',
                  'control_name'                       => 'change_moneda',
                  'db_field'                           => 'moneda',
                  'control_id'                         => 'change_moneda',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati moneda de incasare',
                  'column_size'                        => '',
                  'width'                              => '',                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
																   array ( 'value' =>  '0', 'icon_class' => '', 'selected' => false, 'title' => 'LEI', ),
                                                                   array ( 'value' =>  '1', 'icon_class' => '', 'selected' => false, 'title' => 'EUR (Euro)', ),
																   array ( 'value' =>  '2', 'icon_class' => '', 'selected' => false, 'title' => 'USD (Dolar American)', ),
																   array ( 'value' =>  '3', 'icon_class' => '', 'selected' => false, 'title' => 'GBP (Lira Sterlina)', ),
																   array ( 'value' =>  '4', 'icon_class' => '', 'selected' => false, 'title' => 'CHF (Franc elvetian)', ),
                                                               ),
                        ),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Suma incasata [ <strong><span id="valuta_incasare">LEI</span></strong> ]',
                  'control_name'                       => 'value',
                  'input_type'                         => 'number',				/* can be html input type: text, email, etc*/
				  'other_attribs'                  	   => 'step="0.01" max="10000000" min="0"',
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'suma_incasata',													
                  'db_field'                           => 'value',
                  'value'                              => '0.00', 
                  'maxlength'                          => '10',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => '',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                       ),
                 array (
                  'type'                               => FIELD_TYPE_TEXT,
                  'title'                              => 'Echivalent lei',
                  'control_name'                       => 'value_lei',
                  'input_type'                         => 'number',				/* can be html input type: text, email, etc*/
				  'other_attribs'                  	   => 'step="0.01" max="10000000" min="0"',
				  'unique'							   => false,				/* if true, the field value will be unique in the archive table for a given id_archive */
                  'control_id'                         => 'echivaleaza_lei',
				  'form_group_id'                      => 'fg_echivaleaza_lei',
                  'db_field'                           => 'value_lei',
                  'value'                              => '0.00', 
                  'maxlength'                          => '10',
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => '',
				  'help_message'                   	   => 'Apasand butonul <strong>Calculeaza</strong> se va echivala automat incasarea in valuta la cursul BNR din ziua incasarii',
                  'placeholder'                        => '',
                  'pattern'                            => '',
                  'column_size'                        => '',			         /* number between 2 and 10. Empty for default:10 */
                  'width'                        	   => '',					 /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
				  'button_right_show'                  => true,			         /* show button on the right of input */
				  'button_right_title'                 => 'Calculeaza',	         /* show button on the right of input */
				  
                       ),
					   
                  array (
                  'type'                               => FIELD_TYPE_COMBO_CUSTOM_WITH_ICONS,
                  'title'                              => 'Modalitate incasare',
                  'control_name'                       => 'type',
                  'db_field'                           => 'type',
                  'control_id'                         => '',                                    
                  'read_only'                          => false,
                  'required'                           => true,
                  'required_message'                   => 'Selectati modalitatea de incasare',
                  'column_size'                        => '',
                  'width'                              => '',                               /* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
                  'attributes'                         => array(
                                                                   array ( 'value' =>  '',  'icon_class' => '', 'selected' => false, 'title' => 'Selectati Modalitatea de incasare', ),
																   array ( 'value' =>  '0', 'icon_class' => '', 'selected' => false, 'title' => 'Cash', ),
                                                                   array ( 'value' =>  '1', 'icon_class' => '', 'selected' => false, 'title' => 'Ordin de Plata', ),
																   array ( 'value' =>  '2', 'icon_class' => '', 'selected' => false, 'title' => 'CEC', ),
                                                               ),
                        ),					
                 array (
                  'type'                               => FIELD_TYPE_TEXTAREA,
                  'title'                              => 'Observatii',
                  'control_name'                       => 'observations',
                  'control_id'                         => '',
                  'db_field'                           => 'observations',
                  'value'                              => '', 
                  'maxlength'                          => '',
                  'read_only'                          => false,
                  'required'                           => false,
                  'required_message'                   => 'Complatati observatiile despre INCASARE',
                  'placeholder'                        => '',
		          'column_size'                        => '',
			      'width'                              => '',			/* Can be: input-xlarge, input-large, input-medium, input-small, input-xsmall. Recomanded: use column_size instead this property */
			      'rows'                       	       => '4',
                  ),
				  
				  

	    );
	/* ------------------------------------------------------------------------------------- */
	public function return_company_name(){
		return el_decript_info($_SESSION[APP_ID]["user"]["company"]);
	}
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {
		parent::__construct($oParent);
		if (isset($_REQUEST['pn']))       { $pn=$_REQUEST['pn'];} else {$pn=0;}
		if (isset($_REQUEST['archtype'])) { $archtype=$_REQUEST['archtype'];} else {$archtype='';}
		if (($pn==3) && ($archtype=='incasari')) {
			$script_for_app_footer = '
			<script>
			  //$(document).ready(function() {
					var currency_type = $(\'#change_moneda\').val();
					$(\'#valuta_incasare\').text(cst_currency(currency_type));
					if (currency_type!=0) {
						$(\'#fg_echivaleaza_lei\').show();
					} else {
						$(\'#fg_echivaleaza_lei\').hide();
					}
			  //});
			</script>'.PHP_EOL;
			
			if (!property_exists($this->parent->parent, 'app_footer_scripts')) {
				$this->parent->parent->createProperty('app_footer_scripts', array());
			}
			array_push($this->parent->parent->app_footer_scripts, $script_for_app_footer);
		}
	}	
	/* ------------------------------------------------------------------------------------- */	
}