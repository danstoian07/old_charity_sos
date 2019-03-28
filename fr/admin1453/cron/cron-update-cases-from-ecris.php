<?php
	$ERROR     = false;
    $ERROR_MSG = '';	
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
	spl_autoload_register("autoload_backend_classes");		
	
	/* la instalarea pe hosting client de verificat ce returneaza php_sapi_name() in caz de executie cron job pentru a fi trecut in if-ul de mai jos */
	
	if(php_sapi_name() !== 'cgi-fcgi'){
		$ip         = el_getIp();
		$host       = (!empty($ip) ? gethostbyaddr($ip) : ''); 
		$user_agent = (isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : ''); 
		$ERROR      = true; 
		$ERROR_MSG  = "Incercare executie sincronizare manuala cu sistemul ECRIS<br />IP: $ip<br />HOST: $host<br />USER AGENT: $user_agent";
	}
	
	if (!$ERROR) {
		/* ================================================================================================================================= */
		/* ================================================================================================================================= */
		/* ================================================================================================================================= */
		/* ================================================================================================================================= */
		/* SINCRONIZARE CU SISTEM ECRIS */
		$query = "SELECT * FROM $oDB->app_settings WHERE id=1";
		$result  = $oDB->db_query($query);
		$CAN_SEND_EMAIL       = false;
		$ECRIS_IMPORT_AUTOMAT = 0;
		$arr_supp_emails2     = array();
		$arr_supp_emails3     = array();
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
			
			$ECRIS_IMPORT_AUTOMAT          = $result_line['ecris_import_automat'];
			$ECRIS_SEND_MAIL               = $result_line['ecris_send_mail']; /*0 - nu trimite mail informare, 1- doar la avocatii responsabili, 2 - la avocatii responsabili si la adresele din json_email_2, 3 - doar la adresele din json_emails_3 */
			$CAN_SEND_EMAIL                = ($ECRIS_SEND_MAIL!=0 ? true :  false);
			$arr_supp_emails2              = json_decode($result_line['json_emails_2'], true);
			$arr_supp_emails3              = json_decode($result_line['json_emails_3'], true);
		}		
		
		if ($ECRIS_IMPORT_AUTOMAT) {
					try {
							if (!function_exists('PHPMailerAutoload')) {
								require_once __ADMINAPPPATH__.'PHPMailer-master'.DIRECTORY_SEPARATOR.'PHPMailerAutoload.php';
							}											
							
							
							$query = "SELECT id, name, email FROM $oDB->users WHERE active=1";
							$result    = $oDB->db_query($query);
							$arr_avocati = array();
							while ($result_line = $oDB->db_fetch_array($result)) {
								$id_avocat  = $result_line['id'];
								$arr_avocati["$id_avocat"]['name']  = $result_line['name'];
								$arr_avocati["$id_avocat"]['email'] = $result_line['email'];
							}
							
							//$query = "SELECT id, nr_dosar, json_responsabili, last_soap_response FROM $oDB->cases WHERE type=0 AND status!=2 AND synchronized=0 AND id=1819";
							$query = "SELECT id, nr_dosar, json_responsabili, last_soap_response FROM $oDB->cases WHERE type=0 AND status!=2 AND synchronized=0 LIMIT ".NO_CASES_TO_SYNCHRONIZE_IN_ONE_CRON_FLOW;
							$result                   = $oDB->db_query($query);
							$item_to_synchronize      = 0;
							$arr_soap_server_response = array();
							$arr_avocati_responsabili = array();
							$dosare_ids_list          = '';				
							$multiple_query           = '';
							while ($result_line = $oDB->db_fetch_array($result)) {
								$MODIFICARE_PARTI    = false;
								$MODIFICARE_TERMENE  = false;								
								$dosare_ids_list          .= ($item_to_synchronize!=0 ? ',' : '').$result_line['id'];
								$dosar     = trim($result_line['nr_dosar']);
								$requestul = '<?xml version="1.0" encoding="utf-8"?>
								<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
								  <soap:Body>
										<CautareDosare xmlns="portalquery.just.ro">
										  <numarDosar>'.$dosar.'</numarDosar>
										</CautareDosare>
								  </soap:Body>
								</soap:Envelope>';

								$client  = new SoapClient(null, array( 'location' => 'http://portalquery.just.ro/Query.asmx', 'uri' => 'http://portalquery.just.ro/Query', 'encoding' => 'utf-8', 'trace' => 1,));
								$raspuns = $client->__doRequest ( $requestul ,'http://portalquery.just.ro/Query.asmx' , 'portalquery.just.ro/CautareDosare', 1, 0 );
								$raspuns = str_replace("portalquery.just.ro", "http://portalquery.just.ro", $raspuns);
								
								$id_dosar                                          = $result_line['id'];
								$arr_soap_server_response["$id_dosar"]['id']       = $id_dosar;
								$arr_soap_server_response["$id_dosar"]['nr_dosar'] = $result_line['nr_dosar'];
								$arr_soap_server_response["$id_dosar"]['response'] = $raspuns;
								$arr_avocati_responsabili_dosar                    = json_decode($result_line['json_responsabili'], true);
								foreach ($arr_avocati_responsabili_dosar as $id_avocat => $avocat) {
									$arr_soap_server_response["$id_dosar"]['responsabili']["$id_avocat"]['name']  = $avocat;
									$arr_soap_server_response["$id_dosar"]['responsabili']["$id_avocat"]['email'] = $arr_avocati["$id_avocat"]['email'];
								}
								
								$arr_soap_server_response["$id_dosar"]['have_update'] = false;
								if (!empty($raspuns)) {
									if ($result_line['last_soap_response']!==$raspuns) { $arr_soap_server_response["$id_dosar"]['have_update'] = true; }
								} else {
										$ERROR     = true;
										$ERROR_MSG .= 'Eroare sincronizare ECRIS pentru dosar '.$dosar.'; Posibil lipsa raspuns server.<br />';
								}
													
								if ($arr_soap_server_response["$id_dosar"]['have_update']) {
									/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
									$ERR = false;
									if (!empty($result_line['last_soap_response'])) {
										unset($last_doc);
										$MODIFICARE_PARTI    = false;
										$MODIFICARE_TERMENE  = false;									
										$last_doc            = new DOMDocument();
										try {
										$last_doc->loadXML($result_line['last_soap_response']);
										}
										catch (Exception $e) {
											$ERR = true; $ERR_MSG = 'Exceptie la dosar '.$arr_soap_server_response["$id_dosar"]['nr_dosar'].': '.$e->getMessage();
										}										
										$last_parts_elements = $last_doc->getElementsByTagName('DosarParte');
										$last_terms_elements = $last_doc->getElementsByTagName('DosarSedinta');
										$count_update        = 0;
									}
									/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
									if (!$ERR) {
										$idma = $id_dosar;
										unset($doc, $elements, $general);
										$doc = new DOMDocument();
										$doc->loadXML($raspuns);
										/* determina date dosar */									
										$elements = $doc->getElementsByTagName('Dosar');
										$general = array();
										$i=0;
										
										foreach($elements as $node){
											foreach($node->childNodes as $child) {
												$general[$i]["$child->nodeName"] = $child->nodeValue;
											}
											$i++;
										}
										if (empty($general)) {
											$ERR = true; $ERR_MSG = 'Eroare import date din ECRIS, dosar '.$arr_soap_server_response["$id_dosar"]['nr_dosar'] .'! Posibil dosar inexistent !';
											// aici un break; daca se doreste intreruperea sincronizarii daca nu exista in ECRIS date despre un dosar
										}
									}
									if (!$ERR) {
										$JS_INSTANTA         = $general[0]['institutie'];
										$JS_SECTIE           = $general[0]['departament'];
										$JS_OBIECT           = $general[0]['obiect'];
										$JS_STADIU_PROCESUAL = $general[0]['stadiuProcesual'];
										$JS_MATERIE          = $general[0]['categorieCaz'];
										//$JS_RO_DATA          = el_MysqlDate_To_RomanianDate(substr($general[0]['data'],0,10));
										$JS_EN_DATA          = substr($general[0]['data'],0,10);
													
										/* ------------------------------------------------- */
										/* Determina partile din dosare*/
										$elements = $doc->getElementsByTagName('DosarParte');
										if ((!empty($result_line['last_soap_response'])) && ($elements!==$last_parts_elements)) {
											$MODIFICARE_PARTI = true;
											$count_update++;
										}
										$parti = array();
										$i=0;		
										
										$multiple_query .= " DELETE FROM el_parts WHERE idma = $idma;";							
										$tmp_parti = array();
										$parti_for_message = 'PARTI IN DOSAR<br /><br /><ul>';
										foreach($elements as $node){
											foreach($node->childNodes as $child) {
												$parti[$i]["$child->nodeName"] = $child->nodeValue;
											}
											$tmp_nume_parte = $parti[$i]['nume'].' '.$parti[$i]['calitateParte'];
											if (!in_array($tmp_nume_parte, $tmp_parti)) {
												array_push($tmp_parti, $tmp_nume_parte);
												$parti_for_message .= '<li><strong>'.$parti[$i]['nume'].'</strong> ['.$parti[$i]['calitateParte'].']</li>';
												$multiple_query .= "INSERT INTO el_parts SET id_archive=10, idma=$idma, name='".addslashes( stripslashes($parti[$i]['nume']))."', calitate='".addslashes( stripslashes($parti[$i]['calitateParte']))."'; ".PHP_EOL;
											}
											$i++;
										}
										$parti_for_message .= '</ul>';
																			
										/* ------------------------------------------------- */									
										/* Determina sedintele */
											$elements = $doc->getElementsByTagName('DosarSedinta');
											if ((!empty($result_line['last_soap_response'])) && ($elements!==$last_terms_elements)) {
												$MODIFICARE_TERMENE = true;
												$count_update++;
											}											
											$sedinte = array();
											$i=0;
											$multiple_query .= " DELETE FROM el_termene WHERE idma = $idma;";								
											foreach($elements as $node){
												foreach($node->childNodes as $child) {
													$sedinte[$i]["$child->nodeName"] = $child->nodeValue;
												}									
												
												$sedinta_data = el_RomanianDate_To_MysqlDate(substr($sedinte[$i]['data'],0,10));
												$solutie      = $sedinte[$i]['solutie'].PHP_EOL.$sedinte[$i]['solutieSumar'];
												$multiple_query .= "INSERT INTO el_termene SET id_archive=10, idma=$idma, data_termen='$sedinta_data', ora='".$sedinte[$i]['ora']."', complet='".$sedinte[$i]['complet']."', solutie='".$solutie."', tip_solutie='".$sedinte[$i]['solutie']."';".PHP_EOL;
												$i++;
											}
									}
									$response_for_update = addslashes($raspuns);
									$multiple_query .= "
										UPDATE $oDB->cases SET 
										synchronized=1, 
										instanta ='".addslashes($JS_INSTANTA)."',
										sectie ='".addslashes($JS_SECTIE)."',
										obiect ='".addslashes($JS_OBIECT)."',
										stadiu_procesual ='".addslashes($JS_STADIU_PROCESUAL)."',
										materie_juridica ='".addslashes($JS_MATERIE)."',
										date_reg_tribunal='".$JS_EN_DATA."',
										last_soap_response ='$response_for_update' 
										WHERE id= $id_dosar;";
									/* ------------------------------------------------------------------------------------------------------- */
									/* trimite avocatilor responsabil e-mail de informare */
									if ($CAN_SEND_EMAIL) {
											$encoded_id   = el_encript_info($id_dosar);
											$link_dosare  = __ADMINURL__."?pn=2&archtype=dosare";
											$link_dosar   = __ADMINURL__."?pn=3&archtype=dosare&id=$encoded_id&redirect=".urlencode($link_dosare);
											
											$text_sections = "";
											if ($count_update==1)    { $text_sections .= " in sectiunea "; }
											if ($count_update==2)    { $text_sections .= " in sectiunile ";}											
											if ($MODIFICARE_TERMENE) { $text_sections .= "<strong>TERMENE</strong>";}
											if ($MODIFICARE_PARTI)   { $text_sections .= ($MODIFICARE_TERMENE ? '/<strong>PARTI</strong>' : '<strong>PARTI</strong>');}
											
											$content         = 
											'Buna ziua,<br /><br />
											
											Acesta este un mesaj automat generat de aplicatia '.APP_ADM_NAME.' a societatii<br />
											'.$COMPANY_NAME.', <br /><br />								

											Primiti acest mesaj intrucat a aparut un update'.$text_sections.' la dosarul:<br /><br />

											<a href="'.$link_dosar.'"><strong>'.$arr_soap_server_response["$id_dosar"]['nr_dosar'].'</strong></a><br /><br />
											'.$parti_for_message.'<br /><br />
											Multumim,<br />
											Sistem automat de informare<br />
											'.APP_ADM_NAME.'<br /><br />

											==============================================================<br />
											Prezentul mesaj constituie o Informatie confidentiala si este proprietatea <br />
											exclusiva a '.$COMPANY_NAME.'.<br />
											Mesajul se adreseaza numai persoanei fizice mentionata ca <br />
											destinatara. In cazul in care nu sunteti destinatarul mentionat,<br />
											va aducem la cunostinta ca dezvaluirea, copierea, distribuirea <br />
											sau initierea unor actiuni pe baza prezentei informatii sunt strict <br />
											interzise si atrag raspunderea civila si/sau penala dupa caz. <br />
											Daca ati primit acest mesaj dintr-o eroare, va rugam sa ne anuntati imediat, <br />
											ca raspuns la mesajul de fata, si sa-l stergeti apoi din sistemul dumneavoastra.<br />';		
											
											//$content_alternativ = str_replace("<br />", "\r\n", $content); /* pentru continut text */
											$content_alternativ = str_replace("<br /><br />", "\r\n", $content); /* pentru continut text */
											$content_alternativ = str_replace("<br />", "", $content_alternativ);
											$content_alternativ = strip_tags($content_alternativ);
											/* ---------- send e-mail --------------  */
											unset($mail);
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
											if (($ECRIS_SEND_MAIL==1) || ($ECRIS_SEND_MAIL==2)) {
												foreach ($arr_avocati_responsabili_dosar as $id_avocat => $avocat) {
													$mail->addAddress($arr_avocati["$id_avocat"]['email'], $avocat);
												}
											}
											if ($ECRIS_SEND_MAIL==2) {
												/* trimite suplimentar si la adresele din json_emails_2 */
												foreach ($arr_supp_emails2 as $key => $item) {
													$mail->addAddress($item['value'], APP_ADM_NAME);
												}												
											}
											if ($ECRIS_SEND_MAIL==3) {
												/* trimite suplimentar si la adresele din json_emails_2 */
												foreach ($arr_supp_emails3 as $key => $item) {
													$mail->addAddress($item['value'], APP_ADM_NAME);
												}												
											}											
											//$mail->addAddress('office@webdesign-braila.ro', 'Grigore Valentin');
											$mail->Subject = 'Instiintare ECRIS modificare date la dosar '.$arr_soap_server_response["$id_dosar"]['nr_dosar'];	
											
											//$mail->isHTML(true);
											//$mail->Body    = $content;
											$mail->msgHTML($content, dirname(__FILE__));		
											$mail->AltBody = $content_alternativ;
											if (!$mail->send()) {
												$ERR=true;  $ERR_MSG = $mail->ErrorInfo;
											} else {
												//echo "Message sent!";
											}					
										
									}
									/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
									/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
								}					
								$item_to_synchronize++;
							}
							if ($item_to_synchronize==0) {
								/* nu mai exista dosare de sincronizat => resetam campul de sincronizare */
								$query  = "UPDATE $oDB->cases SET synchronized=0 WHERE type=0";
								$result = $oDB->db_query($query);
							} else {
								if (!empty($dosare_ids_list)) {
									$multiple_query .= "UPDATE $oDB->cases SET synchronized=1 WHERE id IN ($dosare_ids_list);";
								}
								if (!empty($multiple_query)) {
									$result = $oDB->db_multiquery($multiple_query);
									$oDB->db_next_result();
								}
							}
					
					}	
					catch(Exception $e) {
						$ERROR      = true; 
						$ERROR_MSG  = $e->getMessage();
					}
					
		}
		/* END SINCRONIZARE CU SISTEM ECRIS */
		/* ================================================================================================================================= */
		/* ================================================================================================================================= */
		/* ================================================================================================================================= */
		/* ================================================================================================================================= */		
	}
	
	if ($ERROR) {
		/* send mail to admin if $ERROR */
		/* ----------------------------------- */
		$ERR = false;
		$query = "SELECT company_name, mail_type, mail_server, mail_server_port, mail_server_require_authentication, mail_email, mail_username, mail_password, admin_name, admin_contact_email FROM $oDB->app_settings WHERE id=1";
		$result  = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$COMPANY_NAME     			   = $result_line['company_name'];
			$MAILER_TYPE        		   = $result_line['mail_type'];
			$MAILER_FROM_EMAIL		   	   = $result_line['mail_email'];
			$MAILER_HOST      		   	   = $result_line['mail_server'];
			$MAILER_PORT 		   		   = $result_line['mail_server_port'];
			$MAILER_USERNAME    		   = $result_line['mail_username'];
			$MAILER_PASSWORD    		   = el_decript_info($result_line['mail_password']);
			$MAILER_REQUIRE_AUTHENTICATION = $result_line['mail_password'];
			$ADMINISTRATOR_NAME    		   = $result_line['admin_name'];
			$ADMINISTRATOR_EMAIL   		   = $result_line['admin_contact_email'];
		} else {
			$ERR=true;  $ERR_MSG='Nu pot determina parametri trimitere mesaj e-mail!';
		}
		if (!$ERR) {
			$content         = 
			'Buna ziua '.$ADMINISTRATOR_NAME.',<br /><br />
			
			A aparut un avertisment pentru aplicatia '.APP_ADM_NAME.' a societatii<br />
			'.$COMPANY_NAME.'. <br />
			instalata la adresa '.__ADMINURL__.'.<br /><br />

			AVERTISMENT:<br /><br />

			'.$ERROR_MSG.'<br /><br />


			Multumim,<br />
			Sistem automat de avertizare<br />
			'.APP_ADM_NAME.'<br /><br />

			==============================================================<br />
			Prezentul mesaj constituie o Informatie confidentiala si este proprietatea <br />
			exclusiva a '.$COMPANY_NAME.'.<br />
			Mesajul se adreseaza numai persoanei fizice mentionata ca <br />
			administrator de sistem. In cazul in care nu sunteti destinatarul mentionat,<br />
			va aducem la cunostinta ca dezvaluirea, copierea, distribuirea <br />
			sau initierea unor actiuni pe baza prezentei informatii sunt strict <br />
			interzise si atrag raspunderea civila si/sau penala dupa caz. <br />
			Daca ati primit acest mesaj dintr-o eroare, va rugam sa ne anuntati imediat, <br />
			ca raspuns la mesajul de fata, si sa-l stergeti apoi din sistemul dumneavoastra.<br />';		
			
			//$content_alternativ = str_replace("<br />", "\r\n", $content); /* pentru continut text */
			$content_alternativ = str_replace("<br /><br />", "\r\n", $content); /* pentru continut text */
			$content_alternativ = str_replace("<br />", "", $content_alternativ);
			$content_alternativ = strip_tags($content_alternativ);
			/* ---------- send e-mail --------------  */
			require __ADMINAPPPATH__.'PHPMailer-master'.DIRECTORY_SEPARATOR.'PHPMailerAutoload.php';
			
			$mail = new PHPMailer;
			$mail->setLanguage("ro");
			if ($MAILER_TYPE==1) {
				/* send mail by SMTP */
				$mail->isSMTP(); 
				$mail->SMTPDebug   = 0; /* Enable SMTP debugging:  0 = off (for production use),  1 = client messages,  2 = client and server messages */			
				$mail->Debugoutput = 'html'; /*Ask for HTML-friendly debug output */			
				$mail->Host        = $MAILER_HOST; /*Set the hostname of the mail server */			
				$mail->Port        = $MAILER_PORT; /*Set the SMTP port number - likely to be 25,26, 465 or 587*/			
				$mail->SMTPAuth    = ($MAILER_REQUIRE_AUTHENTICATION ? true : false); /* Whether to use SMTP authentication */			
				$mail->Username    = $MAILER_USERNAME; /* Username to use for SMTP authentication */
				$mail->Password    = $MAILER_PASSWORD; /*Password to use for SMTP authentication*/
			}

			$mail->setFrom($MAILER_FROM_EMAIL, $COMPANY_NAME); /* Set who the message is to be sent from */
			$mail->addReplyTo($MAILER_FROM_EMAIL, $COMPANY_NAME); /* Set an alternative reply-to address */		
			$mail->addAddress($ADMINISTRATOR_EMAIL, $ADMINISTRATOR_NAME); /* Set who the message is to be sent to */
			$mail->Subject = 'Avertisment aplicatie '.APP_ADM_NAME;	/* Set the subject line */
			
			//$mail->isHTML(true);
			//$mail->Body    = $content;
			$mail->msgHTML($content, dirname(__FILE__));		
			$mail->AltBody = $content_alternativ;
			if (!$mail->send()) {
				$ERR=true;  $ERR_MSG = $mail->ErrorInfo;
			} else {
				//echo "Message sent!";
			}					
		}
		/* ----------------------------------- */
	} 

?>