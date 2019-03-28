<?php
	$ERROR       = false;
	$ERR_MESSAGE = 'ok';
	$EXPIRE_RESET_PASSWORD_LINK_AFTER = 24; /* numarul de ore dupa care va expira lin-ul de resetare parola */
    	
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		$ERROR=true;  $ERR_MESSAGE='Ups !';
	} else {
		require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
		if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
			$ERROR = true; $ERR_MESSAGE = 'Eroare: Utilizator deja logat !';
		} else {							
			require_once('..'.DIRECTORY_SEPARATOR.'config.php');
			require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
			spl_autoload_register("autoload_backend_classes");
			
			$email   = addslashes(trim($_POST['emailrec']));
			$test1    = addslashes(trim($_POST['person']));
			$test2    = addslashes(trim($_POST['phone']));
			$test3    = addslashes(trim($_POST['user']));
		}
    }    
    if (!$ERROR) { if (!empty($test1)) { $ERROR=true;  $ERR_MESSAGE='Posibil actiune roboti !'; }}
	if (!$ERROR) { if (!empty($test2)) { $ERROR=true;  $ERR_MESSAGE='Posibil actiune roboti !'; }}
	if (!$ERROR) { if (!empty($test3)) { $ERROR=true;  $ERR_MESSAGE='Posibil actiune roboti !'; }}
	
    if (!$ERROR) { if (empty($email)) { $ERROR=true;  $ERR_MESSAGE='Please enter a valid e-mail adress.'; }}
	    
    if (!$ERROR) {
		if (!empty($email)) {
			$email_pattern = "/^[a-zA-Z0-9][a-zA-Z0-9\.-_]+\@([a-zA-Z0-9_-]+\.)+[a-zA-Z]+$/";
			if(!preg_match($email_pattern, $email)) { $ERROR=true;  $ERR_MESSAGE='Please enter a valid e-mail adress.'; }
		}
	}
	if (!$ERROR) {
		$query = "SELECT name, recover_uuid, recover_valid_until, NOW() AS curent_date FROM $oDB->users WHERE email='$email'";
		$result  = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$RECOVER_UUID        = $result_line['recover_uuid'];
			$RECOVER_VALID_UNTIL = $result_line['recover_valid_until'];
			$USER_NAME           = $result_line['name'];
			if ((empty($result_line['recover_uuid'])) || ($result_line['recover_valid_until']<$result_line['curent_date'])) {
				/* genereaza un nou uuid pentru recuperare date */
				$expire_date = date('Y-m-d H:i:s', strtotime($result_line['curent_date']) + 3600*$EXPIRE_RESET_PASSWORD_LINK_AFTER);
				$RECOVER_UUID = uniqid().uniqid();
				$query = "UPDATE $oDB->users SET recover_uuid='$RECOVER_UUID', recover_valid_until='$expire_date' WHERE email='$email'";
				$result  = $oDB->db_query($query);
				if (!$oDB->db_affected_rows($result)) {
					$ERROR=true;  $ERR_MESSAGE='Error Updare recouver password ID!';
				} else {
					$RECOVER_VALID_UNTIL = $expire_date;
				}
			} 
		} else {
			$ERROR=true;  $ERR_MESSAGE='Oops! We can\'t find a profile registered with that e-mail.';
		}
	}
	if (!$ERROR) {
		$query = "SELECT company_name, mail_type, mail_server, mail_server_port, mail_server_require_authentication, mail_email, mail_username, mail_password FROM $oDB->app_settings WHERE id=1";
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
		} else {
			$ERROR=true;  $ERR_MESSAGE='Sorry! We can\'t get your company details.';
		}
	}
	if (!$ERROR) {
		$ip              = el_getIp();
		//$host            = gethostbyaddr($ip); 
		//$user_agent      = $_SERVER["HTTP_USER_AGENT"];
		$LINK_TO_RECOVER = __ADMINURL__."?recover=$RECOVER_UUID";
		$LINK_TO_RECOVER = '<a href="'.$LINK_TO_RECOVER.'">'.$LINK_TO_RECOVER.'</a>';
		
		$content         = 
		'Buna ziua '.$USER_NAME.',<br /><br />
		
		'.APP_ADM_NAME.' a primit o cerere de resetare a parolei de acces<br />
		in sistemul '.$COMPANY_NAME.' pentru userul inregistrat<br />
		cu adresa de e-mail '.$email.'.<br /><br />

		Pentru resetarea parolei accesati link-ul de mai jos:<br /><br />

		'.$LINK_TO_RECOVER.'<br /><br />

		Acest link este valabil pana la '.$RECOVER_VALID_UNTIL.'.<br /><br />

		Detinatorul contului este singura persoana autorizata pentru a efectua procedura <br />
		de resetare a parolei de acces, si este raspunzator de modul cum <br />
		este folosita parola.<br /><br />

		In cazul in care recuperarea parolei nu a fost solicitata de dvs., va<br />
		rugam sa neglijati acest mesaj.<br /><br />

		---------------------------------------------------------<br />
		Resetarea parolei a fost solicitata de la:<br /><br />

		IP: '.$ip.'<br />
		Data: '.date('d-m-Y H:i:s').'<br />
		---------------------------------------------------------<br /><br />

		Multumim,<br />
		Administrator<br />
		'.APP_ADM_NAME.'<br /><br />
		
		'.$COMPANY_NAME.'<br /><br />

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
		$mail->addAddress($email, $USER_NAME); /* Set who the message is to be sent to */		
		$mail->Subject = 'Cerere resetare parola acces';	/* Set the subject line */
		
		//$mail->isHTML(true);
		//$mail->Body    = $content;
		$mail->msgHTML($content, dirname(__FILE__));		
		$mail->AltBody = $content_alternativ;
		if (!$mail->send()) {
			$ERROR=true;  $ERR_MESSAGE = $mail->ErrorInfo;
		} else {
			//echo "Message sent!";
		}		
		/* -------------------------------------  */
	}
	echo $ERR_MESSAGE;
	
?>