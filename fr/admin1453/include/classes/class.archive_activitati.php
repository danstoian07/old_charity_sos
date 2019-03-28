<?php

class archive_activitati extends archive {
	/* ------------------------------------------------------------------------------------- */	
	public  $table_name                         = 'activitati';
	public  $ida							    = 10;
	public  $permission_add_item      		    = 1;								/* */	
	public  $permission_edit_item               = 1;  								/* */		
	public  $archive_title			        	= 'Activitati';
	public  $archive_icon_class     			= 'fa fa-hourglass-3';
	
	public  $list_archive_title			    	= 'Lista activitati dosar';					/* Title of archive list */
	public  $list_archive_icon_class        	= 'fa fa-hourglass-3';						/* icon for title of archive list */
	public  $list_add_button_name               = 'Adauga activitate la dosar';
	
	
	public  $tabs   			    			= array(
													array('Activitate dosar','tab_activitate_general'),
												);									/* Edit Panel tabs, bidimensional array Ex: (($tab_name1, $tab_class1),($tab_name1, $tab_class1) ...) */

	public  $archive_title_top_big          	= 'Activitati in dosar';
	public  $archive_title_top_small        	= '';
	public  $activate_menuitem_id           	= -20;
	
	public $list_fields = array(	
                  array (
                  'title'                              => 'Activitate',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'name',
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'function'                           => 'lf_return_activitate',    /* Method must have parameter "$result_line" */
				  'sortable'                           => false,
				  'style-classes'                      => 'font-bold',   /* Ex: "font-bold font-blue font-italic font-underline" */
				  'responsive-classes'                 => 'col-xs-2 col-sm-3 col-md-4 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
                  array (
                  'title'                              => 'Scadenta',
				  'type'                               => FIELD_DATE,
				  'db_field'                           => 'data_scadenta',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => true,
				  'responsive-classes'                 => 'hidden-xs col-sm-3 col-md-3 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
                  array (
                  'title'                              => 'Finalizata',
				  'type'                               => FIELD_FUNCTION,
				  'db_field'                           => 'data_efectuarii',
				  'filter'                             => array (
																  'type'    => LFT_DATE_INTERVAL,																  
																),				  
				  'width'                              => '',					/* can be: percent or value */
				  'sortable'                           => false,
				  'function'                           => 'lf_return_efectuare',
				  'responsive-classes'                 => 'hidden-xs col-sm-3 col-md-3 col-lg-3',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),
				   
				  array (
                  'title'                              => 'Status',
				  'type'                               => FIELD_FUNCTION,
				  'function'                           => 'lf_return_status',
				  'db_field'                           => 'id_status',
				  'width'                              => '',				  
				  'responsive-classes'                 => 'hidden-sm hidden-xs',   /* hidden-sm, hidden-md, hidden-xs, hidden-lg, visible-xs, visible-sm, visible-md, visible-lg */
                   ),				   


	);
	
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent) {

		parent::__construct($oParent);
		//$this->AddNotification('Acesta este un mesaj de mare valoare', MSG_SUCCESS); // MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING		
		
		//$this->AddNotification('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_WARNING); 
		//$this->AddAlert('Acesta este un mesaj de mare valoare cu si mai mare valoare', MSG_DANGER,'fa fa-bell-o fa-lg'); 
		//$this->AddAlert('Acesta este o alta alerta', MSG_INFO, 'icon-user'); 
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function ShowEdit($id) {
		$id_decript = el_decript_info($id);
		if ($this->lawyer_can_access_activity($id)) {
			if ($id_decript!=0) { $this->archive_title = 'Editare detalii activitate';} else { $this->archive_title = 'Adaugare activitate';}
			parent::ShowEdit($id);
		} else {
			el_redirect(__ADMINURL__.'?pn=2&archtype=dosare');
		}
	}
	
	/* ------------------------------------------------------------------------------------- */	
	public function ExecuteBeforeUpdate($id){
		$ERROR     = false;
		$ERROR_MSG = '';
		global $oDB;
		$query = "
		SELECT $oDB->activitati.id, $oDB->activitati.name, $oDB->activitati.date_mod, $oDB->cases.id AS id_dosar, $oDB->cases.nr_dosar 
		FROM $oDB->activitati 
		LEFT JOIN $oDB->cases ON $oDB->cases.id = $oDB->activitati.idma 
		WHERE $oDB->activitati.id=$id";
		$result = $oDB->db_query($query);			
		if ($result_line = $oDB->db_fetch_array($result)) {
			$this->createProperty('last_update', $result_line['date_mod']);
			$this->createProperty('activity_name', $result_line['name']);
			$this->createProperty('nr_dosar', $result_line['nr_dosar']);
			$this->createProperty('id_dosar', $result_line['id_dosar']);
		} else {
			$ERROR     = true; $ERROR_MSG = 'Eroare determinare data ultim update';
		}		
		return $ERROR_MSG;
	}
	/* ------------------------------------------------------------------------------------- */
		public function ExecuteAfterUpdate($id){
		$ERROR     = false;
		$ERROR_MSG = '';
		global $oDB;
		/* --------------------------------------- */
		/* trimite email de notificare avocatilor responsabili ATENTIE: doar daca a fost modificat continutul activitatii */
		$query = "SELECT $oDB->activitati.date_mod, $oDB->activitati.send_notification FROM $oDB->activitati WHERE id=$id";
		$result = $oDB->db_query($query);			
		if ($result_line = $oDB->db_fetch_array($result)) {
			$TRIMIT_NOTIFICARE = ((($result_line['send_notification']!=0) &&($result_line['date_mod']!=$this->last_update)) ? true : false );
		} else {
			$ERROR = true; $ERROR_MSG = 'Eroare determinare data update';
		}
		if (!$ERROR) {
			if ($TRIMIT_NOTIFICARE) {
				$id_dosar_enc = el_encript_info($this->id_dosar);
				$link_to_dosare           = __ADMINURL__.'?pn=2&archtype=dosare';
				$link_to_activitati_dosar = __ADMINURL__.'?pn=3&archtype=dosare&id='.$id_dosar_enc.'&tab=4&redirect='.urlencode($link_to_dosare);
				$link_to_activity   = __ADMINURL__.'?pn=3&archtype=activitati&id='.el_encript_info($id).'&idma='.$id_dosar_enc.'&redirect='.urlencode($link_to_activitati_dosar);
				$msg                = 'Primiti acest mesaj intrucat a aparut un update la activitatea <a href="'.$link_to_activity.'">'.$this->activity_name.'</a> din dosarul: '.$this->nr_dosar.'<br /><br />';				
				$this->send_notification_to_lawyers($id, $msg, 'Actualizare activitate la dosarul '.$this->nr_dosar);
			}
		}
		/* --------------------------------------- */
		if (!$ERROR) {
			parent::ExecuteAfterUpdate($id);
		}
		return $ERROR_MSG;
	}		
	/* ------------------------------------------------------------------------------------- */
	public function ExecuteAfterInsert(){
		$ERROR     = false;
		$ERROR_MSG = '';
		global $oDB;
		$id_user = $this->user_id;
		$inserted_id = 0;
		$query = "SELECT MAX(id) AS last_id FROM $oDB->activitati WHERE add_by=$id_user";
		$result = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$inserted_id = $result_line['last_id'];
		} else {
			$ERROR_MSG = 'Eroare determinare ID inserat';
		}
		if (!$ERROR) {
			/* --------------- determina numarul dosarului caruia ii apartine activitatea si trimite motificare avocatilor responsabili */			
			$query = "
			SELECT $oDB->activitati.id, $oDB->activitati.name, $oDB->activitati.date_mod, $oDB->activitati.send_notification, $oDB->cases.id AS id_dosar, $oDB->cases.nr_dosar 
			FROM $oDB->activitati 
			LEFT JOIN $oDB->cases ON $oDB->cases.id = $oDB->activitati.idma 
			WHERE $oDB->activitati.id=$inserted_id";
			$result = $oDB->db_query($query);			
			if ($result_line = $oDB->db_fetch_array($result)) {
				$id = $result_line['id'];
				$this->createProperty('last_update', $result_line['date_mod']);
				$this->createProperty('activity_name', $result_line['name']);
				$this->createProperty('nr_dosar', $result_line['nr_dosar']);
				$this->createProperty('id_dosar', $result_line['id_dosar']);				
				if ($result_line['send_notification']) {
					$id_dosar_enc = el_encript_info($this->id_dosar);
					$link_to_dosare           = __ADMINURL__.'?pn=2&archtype=dosare';
					$link_to_activitati_dosar = __ADMINURL__.'?pn=3&archtype=dosare&id='.$id_dosar_enc.'&tab=4&redirect='.urlencode($link_to_dosare);
					$link_to_activity   = __ADMINURL__.'?pn=3&archtype=activitati&id='.el_encript_info($id).'&idma='.$id_dosar_enc.'&redirect='.urlencode($link_to_activitati_dosar);
					$msg                = 'Primiti acest mesaj intrucat a fost adaugata activitatea <a href="'.$link_to_activity.'">'.$this->activity_name.'</a> la dosarul: '.$this->nr_dosar.'<br /><br />';
					$this->send_notification_to_lawyers($id, $msg, 'Activitate noua la dosarul '.$this->nr_dosar);
				}				
			} else {
				$ERROR     = true; $ERROR_MSG = 'Eroare determinare data ultim update';
			}		
			/* --------------- trimite email de notificare avocatilor responsabili */
		}
		if (!$ERROR) {
			parent::ExecuteAfterInsert();
		}
		return $ERROR_MSG;		
	}
	/* ------------------------------------------------------------------------------------- */
	/* trimite notificare avocatilor responsabili de activitate, ca s-au actualizat datele activitatii curente */
	public function send_notification_to_lawyers($id_activitate, $msg, $subject='') {
		$ERROR     = false;
		$ERROR_MSG = '';
		global $oDB;
		/* --- DETERMINA PARAMETRI TRIMITERE E-MAIL ------------- */
		$query = "SELECT * FROM $oDB->app_settings WHERE id=1";
		$result  = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$COMPANY_NAME     			   = $result_line['company_name'];
			$MAILER_TYPE        		   = $result_line['mail_type'];
			$MAILER_FROM_EMAIL		   	   = $result_line['mail_email'];
			$MAILER_HOST      		   	   = $result_line['mail_server'];
			$MAILER_PORT 		   		   = $result_line['mail_server_port'];
			$MAILER_USERNAME    		   = $result_line['mail_username'];
			$MAILER_PASSWORD    		   = el_decript_info($result_line['mail_password']);
			$MAILER_REQUIRE_AUTHENTICATION = $result_line['mail_server_require_authentication'];
			$ADMINISTRATOR_NAME    		   = $result_line['admin_name'];
			$ADMINISTRATOR_EMAIL   		   = $result_line['admin_contact_email'];			
		} else {
			$ERROR = true; $ERROR_MSG = 'Eroare determinare paramenrti trimitere e-mail';
		}
		if (!$ERROR) {
				/* --- determina avocatii responsabili de activitate ---- */
				$query ="
					SELECT $oDB->users.id, $oDB->users.name, $oDB->users.email 
					FROM $oDB->multiselect_options 
					LEFT JOIN $oDB->users ON $oDB->users.id = $oDB->multiselect_options.id_options 
					WHERE $oDB->multiselect_options.id_archive=200 AND $oDB->multiselect_options.id_main_item=$id_activitate";
				$result = $oDB->db_query($query);
				$arr_avocati_responsabili = array();
				$i=0;
				while ($result_line = $oDB->db_fetch_array($result)) {			
					$arr_avocati_responsabili[$i]['name']  = $result_line['name'];
					$arr_avocati_responsabili[$i]['email'] = $result_line['email'];
					$i++;
				}		
				/* ------------------------------------------------------ */
				/* --- trimite e-mail tuturor avocatilor responsabili --- */
				$content            = adm_return_email_message_content($COMPANY_NAME, $msg);
				$content_alternativ = adm_return_email_message_content_alternative($content);
				if (!function_exists('PHPMailerAutoload')) {
					require_once __ADMINAPPPATH__.'PHPMailer-master'.DIRECTORY_SEPARATOR.'PHPMailerAutoload.php';
				}											
				$mail = new PHPMailer;
				$mail->setLanguage("ro");
				if ($MAILER_TYPE==1) {
					/* send mail by SMTP */
					$mail->CharSet = 'UTF-8';
					$mail->isSMTP(); 
					$mail->SMTPDebug   = 0;
					$mail->Debugoutput = 'html'; 
					$mail->Host        = $MAILER_HOST; 
					$mail->Port        = $MAILER_PORT; 
					$mail->SMTPAuth    = ($MAILER_REQUIRE_AUTHENTICATION ? true : false); 
					$mail->Username    = $MAILER_USERNAME; 
					$mail->Password    = $MAILER_PASSWORD; 
				}

				$mail->setFrom($MAILER_FROM_EMAIL, $COMPANY_NAME); 
				$mail->addReplyTo($MAILER_FROM_EMAIL, $COMPANY_NAME); 
				foreach ($arr_avocati_responsabili as $id_avocat => $avocat) {
					$mail->addAddress($avocat['email'], $avocat['name']);
				}
				$mail->msgHTML($content, dirname(__FILE__));		
				$mail->AltBody = $content_alternativ;
				$mail->Subject = $subject;
				if (!$mail->send()) {
					$ERROR=true;  $ERR_MSG = $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}				
				/* ------------------------------------------------------ */
		}
		return $ERROR_MSG;
	}
	/* ------------------------------------------------------------------------------------- */
	public function lawyer_can_access_activity($id) {
		$id_decript = el_decript_info($id);
		$can_access = true;
		if (!$this->user_rights_by_admin['administrator']) {
			global $oDB;
			$rights_dosare = $this->GetArchiveUserRightsByAdmin('dosare');
			if ($rights_dosare['permission_view_neassociated_cases']==0) {
						$can_access = false;
						if (isset($_REQUEST['idma'])) {
							$id_dosar =  el_decript_info($_REQUEST['idma']);
							/* --- */
							$query ="SELECT id_options FROM $oDB->multiselect_options WHERE id_archive=20 AND id_main_item=$id_dosar";							
							$result = $oDB->db_query($query);			
							while ($result_line = $oDB->db_fetch_array($result)) {
								if ($result_line['id_options']==$this->user_id){
									$can_access = true;
									break;
								}			
							}
							/* --- */
							if ($can_access) {
								if ($id_decript>0) {
									/* verifica daca id-ul partii corespunde dosarului */
									$query = "SELECT COUNT(*) AS no FROM $oDB->activitati WHERE id=$id_decript AND idma=$id_dosar";
									$result = $oDB->db_query($query);
									if ($result_line = $oDB->db_fetch_array($result)) {
										if ($result_line['no']!=1){
											$can_access = false;
										}										
									}
								}				
							}
							/* --- */
						}
			}
		}
		return $can_access;
	}				
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_activitate($result_line, $link_to_edit){
		return '<a href="'.$link_to_edit.'">'.$result_line['name'].'</a>';
	}	
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_efectuare($result_line, $link_to_edit){
		return ($result_line['data_efectuarii']=='0000-00-00' ? '' : $result_line['data_efectuarii']);
	}		
	/* ------------------------------------------------------------------------------------- */
	public function lf_return_status($result_line, $link_to_edit){
		return ($result_line['id_status']==2 ? '<i class="fa fa-check" aria-hidden="true"></i>' : '');
	}	
	/* ------------------------------------------------------------------------------------- */
}