<?php
	/* trimite avocatilor responsabili o informare privind scadenta in viitorul apropiat a unei activitati */
	/* se va seta un cron intre 30...50 min */
	$ERROR     = false;
    $ERROR_MSG = '';		
	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
	spl_autoload_register("autoload_backend_classes");		
	
	global $oDB;
	
	/* la instalarea pe hosting client de verificat ce returneaza php_sapi_name() in caz de executie cron job pentru a fi trecut in if-ul de mai jos */	
	
	if(php_sapi_name() !== 'cgi-fcgi'){
		$ip         = el_getIp();
		$host       = (!empty($ip) ? gethostbyaddr($ip) : ''); 
		$user_agent = (isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : ''); 
		$ERROR      = true; 
		$ERROR_MSG  = "Incercare executie manuala script REMINDER ACTIVITATI<br />IP: $ip<br />HOST: $host<br />USER AGENT: $user_agent";
	}		
	
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
		try {
			/* ============================================================================================ */			
			if (!function_exists('PHPMailerAutoload')) {
				require_once __ADMINAPPPATH__.'PHPMailer-master'.DIRECTORY_SEPARATOR.'PHPMailerAutoload.php';
			}
			
			$query = "
				SELECT el_cases.nr_dosar, el_activitati.id, el_activitati.idma, el_activitati.name, el_activitati.descriere, el_activitati.data_scadenta, TIMESTAMPDIFF(MINUTE,NOW(), el_activitati.data_scadenta) AS minute_ramase, (CASE WHEN el_activitati.reminder_days_before >= 1 AND el_activitati.reminder_days_before <=10 THEN el_activitati.reminder_days_before*60 WHEN el_activitati.reminder_days_before >= 11 AND el_activitati.reminder_days_before <=20  THEN el_activitati.reminder_days_before*24*60 END) AS minute_alert_before 
				FROM el_activitati 
				LEFT JOIN el_cases ON el_cases.id = el_activitati.idma 
				WHERE el_activitati.reminder_sended=0 AND el_cases.nr_dosar IS NOT NULL HAVING minute_ramase>=0 AND minute_alert_before IS NOT NULL AND minute_ramase<=minute_alert_before";
			$result  = $oDB->db_query($query);
			$arr_activitati_de_alertat = array();
			$list_activities_ids = '';
			$i=0;
			while ($result_line = $oDB->db_fetch_array($result)) {			
				$id = $result_line['id'];
				$arr_activitati_de_alertat["$id"]['id_activitate'] = $result_line['id'];
				$arr_activitati_de_alertat["$id"]['id_dosar']      = $result_line['idma'];
				$arr_activitati_de_alertat["$id"]['name']          = $result_line['name'];
				$arr_activitati_de_alertat["$id"]['nr_dosar']      = $result_line['nr_dosar'];
				$arr_activitati_de_alertat["$id"]['descriere']     = $result_line['descriere'];
				$arr_activitati_de_alertat["$id"]['data_scadenta'] = $result_line['data_scadenta'];
				$list_activities_ids .= ($i!=0 ? ',' : '').$result_line['id'];
				$i++;
			}
			if (!empty($list_activities_ids)) {
				$query ="
					SELECT $oDB->users.id, $oDB->users.name, $oDB->users.email, $oDB->multiselect_options.id_main_item AS id_activitate 
					FROM $oDB->multiselect_options 
					LEFT JOIN $oDB->users ON $oDB->users.id = $oDB->multiselect_options.id_options 
					WHERE $oDB->multiselect_options.id_archive=200 AND $oDB->multiselect_options.id_main_item IN ($list_activities_ids)";				
				$result = $oDB->db_query($query);
				$arr_avocati_responsabili = array();
				$i = 0;
				while ($result_line = $oDB->db_fetch_array($result)) {
					$arr_avocati_responsabili[$i]['id']    		   = $result_line['id'];
					$arr_avocati_responsabili[$i]['name']  		   = $result_line['name'];
					$arr_avocati_responsabili[$i]['email']         = $result_line['email'];
					$arr_avocati_responsabili[$i]['id_activitate'] = $result_line['id_activitate'];
					$i++;
				}
				$multiple_query = '';
				foreach ($arr_activitati_de_alertat as $id_activitate => $activitate) {
					
						unset($mail);
						$id_dosar_enc             = el_encript_info($activitate['id_dosar']);
						$link_to_dosare           = __ADMINURL__.'?pn=2&archtype=dosare';
						$link_to_activitati_dosar = __ADMINURL__.'?pn=3&archtype=dosare&id='.$id_dosar_enc.'&tab=4&redirect='.urlencode($link_to_dosare);
						$link_to_activity         = __ADMINURL__.'?pn=3&archtype=activitati&id='.el_encript_info($activitate['id_activitate']).'&idma='.$id_dosar_enc.'&redirect='.urlencode($link_to_activitati_dosar);					
						$content                  = 'Primiti acest mesaj intrucat activitatea <a href="'.$link_to_activity.'">'.$activitate['name'].'</a> din dosarul '.$activitate['nr_dosar'].' va ajunge la scadenta<br />in '.el_MysqlDateTime_To_RomanianDate_Literal($activitate['data_scadenta']).'<br />Descriere activitate:<br />'.$activitate['descriere'].'<br /><br />';
						$content                  = adm_return_email_message_content($COMPANY_NAME, $content);
						$content_alternativ       = adm_return_email_message_content_alternative($content);
						
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
						
						$mail->setFrom($MAILER_FROM_EMAIL, $COMPANY_NAME); /* Set who the message is to be sent from */
						$mail->addReplyTo($MAILER_FROM_EMAIL, $COMPANY_NAME); /* Set an alternative reply-to address */		
						//$mail->addAddress($ADMINISTRATOR_EMAIL, $ADMINISTRATOR_NAME); /* Set who the message is to be sent to */
						$mail->Subject = 'Reminder activitate, '.$activitate['name'].', dosar '.$activitate['nr_dosar'];	/* Set the subject line */
						foreach ($arr_avocati_responsabili as $key => $avocat_responsabil) {
							if ($avocat_responsabil['id_activitate']==$id_activitate) {
								$mail->addAddress($avocat_responsabil['email'], $avocat_responsabil['name']);
							}
						}

						$mail->msgHTML($content, dirname(__FILE__));		
						$mail->AltBody = $content_alternativ;
						if (!$mail->send()) {
							$ERROR=true;  $ERROR_MSG = $mail->ErrorInfo;
							break;
						} else {
							//echo "Message sent!";
						}
						if (!$ERROR) {
							$multiple_query .= "UPDATE el_activitati SET reminder_sended =1 WHERE id=$id_activitate;";
						}
					
				}
				if (!$ERROR) {
					if (!empty($multiple_query)) {
						$result = $oDB->db_multiquery($multiple_query);
						$oDB->db_next_result();					
					}
				}	
			}				
			/* ============================================================================================ */
		}
		catch(Exception $e) {
			$ERROR      = true; 
			$ERROR_MSG  = $e->getMessage();
		}		
	} 	
	
	if ($ERROR) {
		$ERR     = false;
		$ERR_MSG = '';				
		/* trimite administratorului e-mail de informare in caz de eroare */
		if (!$ERR) {
			/* --- trimite e-mail tuturor avocatilor responsabili --- */
			$content            = adm_return_email_message_content($COMPANY_NAME, $ERROR_MSG);
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
			
			$mail->setFrom($MAILER_FROM_EMAIL, $COMPANY_NAME); /* Set who the message is to be sent from */
			$mail->addReplyTo($MAILER_FROM_EMAIL, $COMPANY_NAME); /* Set an alternative reply-to address */		
			$mail->addAddress($ADMINISTRATOR_EMAIL, $ADMINISTRATOR_NAME); /* Set who the message is to be sent to */
			$mail->Subject = 'Avertisment aplicatie '.APP_ADM_NAME;	/* Set the subject line */
			

			$mail->msgHTML($content, dirname(__FILE__));		
			$mail->AltBody = $content_alternativ;
			if (!$mail->send()) {
				$ERR=true;  $ERR_MSG = $mail->ErrorInfo;
			} else {
				//echo "Message sent!";
			}
		}
	}
?>