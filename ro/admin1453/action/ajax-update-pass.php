<?php
	$ERROR       = false;
	$ERR_MESSAGE = 'ok';
    	
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
			
			$pass1    = addslashes(trim($_POST['pass1']));
			$pass2    = addslashes(trim($_POST['pass2']));
			$test1    = addslashes(trim($_POST['person']));
			$test2    = addslashes(trim($_POST['phone']));
			$test3    = addslashes(trim($_POST['user']));
		}
    }    
    if (!$ERROR) { if (!empty($test1)) { $ERROR=true;  $ERR_MESSAGE='Posibil actiune roboti !'; }}
	if (!$ERROR) { if (!empty($test2)) { $ERROR=true;  $ERR_MESSAGE='Posibil actiune roboti !'; }}
	if (!$ERROR) { if (!empty($test3)) { $ERROR=true;  $ERR_MESSAGE='Posibil actiune roboti !'; }}
	
    if (!$ERROR) { if (empty($pass1))  { $ERROR=true;  $ERR_MESSAGE='Completeaza parola !'; }}
	if (!$ERROR) { if (empty($pass2))  { $ERROR=true;  $ERR_MESSAGE='Repeta parola in a doua boxa !'; }}
	if (!$ERROR) { if ($pass1!=$pass2) { $ERROR=true;  $ERR_MESSAGE='Parolele nu sunt identice !'; }}
	
	if (!$ERROR) {
		$url_referer   = $_SERVER["HTTP_REFERER"];
		$arr_url_param = el_UrlStringWithParametersToArray($url_referer);
		if ($arr_url_param != false) {
			if (isset($arr_url_param['recover'])) { $RECOVER_UUID = $arr_url_param['recover']; }
		} else {
			$ERROR=true;  $ERR_MESSAGE='Eroare URL referrer !'; 
		}
	}
	if (!$ERROR) {
		$query = "SELECT name, email, recover_uuid, recover_valid_until, NOW() AS curent_date FROM $oDB->users WHERE recover_uuid='$RECOVER_UUID'";
		$result  = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {
			$RECOVER_VALID_UNTIL = $result_line['recover_valid_until'];
			$USER_NAME           = $result_line['name'];
			$EMAIL               = $result_line['email'];
			if ((empty($result_line['recover_uuid'])) || ($result_line['recover_valid_until']<$result_line['curent_date'])) {
				$ERROR=true;  $ERR_MESSAGE='String recuperare parola invalid !';
			} 
		} else {
			$ERROR=true;  $ERR_MESSAGE='Adresa de e-mail <strong>'.$email.'</strong> nu exista in Baza de Date !';
		}
	}
	if (!$ERROR) {
		$password = md5($pass1);
		$query = "UPDATE $oDB->users SET password='$password' WHERE email='$EMAIL'";
		$result  = $oDB->db_query($query);
		if (!$oDB->db_affected_rows($result)) {
			//$ERROR=true;  $ERR_MESSAGE='Parola a fost deja updatata !';
		} 		
	}
	echo $ERR_MESSAGE;
	
?>