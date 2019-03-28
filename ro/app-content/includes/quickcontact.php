<?php

require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-config.php');
require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-functions.php');
//require_once('..'.DIRECTORY_SEPARATOR.'recaptcha-php-1.11/recaptchalib.php');	
	
spl_autoload_register("autoload_frontend_classes");


require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

global $oDB;
$ERROR=false;
$ERR_MESSAGE='';

$message = "";
$status = "false";

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( $_POST['form_name'] !='' AND $_POST['form_email'] != '' AND $_POST['form_subject'] != '' AND $_POST['form_phone'] != '' AND $_POST['form_message'] != '' ) {
		
		$test1    = addslashes(trim($_POST['form_region']));
		$test2    = addslashes(trim($_POST['form_city']));
		$test3    = addslashes(trim($_POST['form_address']));		
		
		$ip=el_getIp();
		$host = gethostbyaddr($ip); 
		$user_agent = $_SERVER["HTTP_USER_AGENT"]; 
		
		
		if (!$ERROR) { if (!empty($test1)) { $ERROR=true;  $ERR_MESSAGE='Posibil trimitere prin roboti 1 !'; }}
		if (!$ERROR) { if (!empty($test2)) { $ERROR=true;  $ERR_MESSAGE='Posibil trimitere prin roboti 2 !'; }}
		if (!$ERROR) { if (!empty($test3)) { $ERROR=true;  $ERR_MESSAGE='Posibil trimitere prin roboti 3 !'; }}
		
		if (!$ERROR) {
			$query="SELECT admin_contact_email FROM el_app_settings WHERE id = 1";
			$result = $oDB->db_query($query);
			if ($result_line = $oDB->db_fetch_array($result)) {
				$CONTACT_EMAIL = $result_line['admin_contact_email'];
			} else {
				$ERROR=true;  $ERR_MESSAGE='Eroare determinare setari !!!';
			}
			if (!$ERROR) {
				if (empty($CONTACT_EMAIL)) { $ERROR=true;  $ERR_MESSAGE='Eroare email administrator !!!'; }
			}
		}
		if (!$ERROR) { 
			if (!empty($_POST['form_email'])) {
				$email_pattern = "/^[a-zA-Z0-9][a-zA-Z0-9\.-_]+\@([a-zA-Z0-9_-]+\.)+[a-zA-Z]+$/";
				if(!preg_match($email_pattern, $_POST['form_email'])) { $ERROR=true;  $ERR_MESSAGE='<span class="text-theme-colored2"><strong>ATENTIE!</strong> Adresa de e-mail incorecta !</span>'; }
			}
		}		

			$mail = new PHPMailer();
			//$mail->SMTPDebug = 3;                               // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = MAILER_HOST;  				  		  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = MAILER_USERNAME;    				  // SMTP username
			$mail->Password = MAILER_PASSWORD;                    // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = MAILER_PORT;                            // TCP port to connect to
			$mail->CharSet = 'UTF-8';
		
			$name    = $_POST['form_name'];
			$email   = $_POST['form_email'];
			$message = $_POST['form_message'];

			$subject = isset($subject) ? $subject : 'Mesaj rapid | Formular contact';

			$botcheck = $_POST['form_botcheck'];

			$toemail = $CONTACT_EMAIL; // Your Email Address
			$toname  = APP_NAME; 	   // Your Name

        if (( $botcheck == '' ) && (!$ERROR)) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $email = isset($email) ? "Email: $email<br><br>" : '';
			$phone = isset($_POST['form_phone']) ? "Tel: ".$_POST['form_phone']."<br><br>" : '';
            $message = isset($message) ? "Mesaj: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>Mesajul a fost trimis din pagina: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$email $phone $message $referrer";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                $message = '<strong>Am primit mesajul tau!</strong> Vom reveni cu un raspuns in cel mai scurt timp posibil.';
                $status = "true";
            else:
                $message = '<span class="text-theme-colored2">Mesajul <strong>nu a fost trimis</strong> din cauza unei Erori Neasteptate. Te rugam incearca mai tarziu.<br /><br /><strong>Cauza:</strong><br />' . $mail->ErrorInfo . '</span>';
                $status = "false";
            endif;
        } else {
            $message = 'Spam <strong>Detectat</strong>.! Clean yourself Botster.!';
            $status = "false";
			if ($ERROR) {
				$message = $ERR_MESSAGE;
				$status = "false";				
			}
        }
    } else {
        $message = '<span class="text-theme-colored2">Te rugam <strong>Completeaza</strong> toare campurile si incearca din nou.</span>';
        $status = "false";
    }
} else {
    $message = '<span class="text-theme-colored2">A aparut o <strong>eroare neasteptata</strong>. Te rugam sa incerci mai tarziu.</span>';
    $status = "false";
}

$status_array = array( 'message' => $message, 'status' => $status);
echo json_encode($status_array);
?>