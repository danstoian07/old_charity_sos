<?php

	/* ======================================================================================================================== */ 
	/* ======================================================================================================================== */ 
	/* ======================================================================================================================== */ 
	/* ======================================================================================================================== */ 
	/* global function for admin */
    /* ======================================================================================================================== */ 
    function return_link_to_LOGOUT(){
        return __ADMINURL__.action.DIRECTORY_SEPARATOR.'s-logout.php';
    }
    /* ======================================================================================================================== */ 
    function adm_thumb_image($img, $w=0, $h=0) {
        $q=100; /* calitate 0-100 */
        $src =__THUMBURL__.'tt.php?src='.$img.($w>0 ? "&w=$w" : "").($h>0 ? "&h=$h" : "")."&q=$q";    
        return $src;
    }
    /* ======================================================================================================================== */ 
	function adm_AddTrackingInfo($string_info){
		if (TRACK_USERS_ACTIVITY) {
			if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
				if (!empty($string_info)) {
					date_default_timezone_set('Europe/Athens');
					$date_time = date('d-m-Y h:i:s', time());
					if (isset($_SESSION[APP_ID]["user"]["track"]["info"])) {
						if ($_SESSION[APP_ID]["user"]["track"]["last-operation"]!=$string_info) {
							$_SESSION[APP_ID]["user"]["track"]["last-operation"] = $string_info;
							$_SESSION[APP_ID]["user"]["track"]["info"] .= $date_time.' '.$string_info.PHP_EOL;
						}
					} else {
						$_SESSION[APP_ID]["user"]["track"]["last-operation"] = $string_info;
						$_SESSION[APP_ID]["user"]["track"]["info"] = $date_time.' '.$string_info.PHP_EOL;
					}
				}
			}
		}
	}
	/* ======================================================================================================================== */ 
	function adm_ClearTrackingInfo(){
		unset($_SESSION[APP_ID]["user"]["track"]);
	}
	/* ======================================================================================================================== */ 	
	function adm_StoreTrackingInfoToBD(){
		if (TRACK_USERS_ACTIVITY) {
			if ((isset($_SESSION[APP_ID]["user"]["track"]["info"])) && (!empty($_SESSION[APP_ID]["user"]["track"]["info"]))) {
				global $oDB;
				$year   = date("Y"); $month = date("n");
				$query  ="UPDATE $oDB->users_track SET activity= CONCAT(activity, '".addslashes(stripslashes($_SESSION[APP_ID]["user"]["track"]["info"]))."') WHERE idma=".el_decript_info($_SESSION[APP_ID]["user"]["id"])." AND year=$year AND month=$month";
				$result = $oDB->db_query($query);
				$_SESSION[APP_ID]["user"]["track"]["info"]           = '';
				$_SESSION[APP_ID]["user"]["track"]["last-operation"] = '';				
			}
		}
	}
	/* ======================================================================================================================== */ 
	
	
	/* ======================================================================================================================== */ 	
	/* ======================================================================================================================== */ 	
	/* ======================================================================================================================== */ 	
	/* ======================================================================================================================== */ 	
	function adm_return_email_message_content($COMPANY_NAME, $msg){
			$content         = 
			'Buna ziua,<br /><br />
			
			Acesta este un mesaj automat generat de aplicatia '.APP_ADM_NAME.' a societatii<br />
			'.$COMPANY_NAME.', <br /><br />
			'.$msg.'<br /><br />

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
		
		return $content;
	}
	/* ======================================================================================================================== */ 	
	/* returneaza textul alternativ pentru mesajele cu continut html */
	function adm_return_email_message_content_alternative($content){
		$content_alternativ = str_replace("<br /><br />", "\r\n", $content); /* pentru continut text */
		$content_alternativ = str_replace("<br />", "", $content_alternativ);
		$content_alternativ = strip_tags($content_alternativ);		
		return $content_alternativ;
	}
	/* ======================================================================================================================== */ 	
	/* function for app */
	function adm_tip_colaborare($type){
		switch ($type) {
			case 0: return "Avocat asociat"; break;
			case 1: return "Avocat colaborator"; break;
			case 2: return "Avocat coordonator"; break;
			case 3: return "Office manager/secretar"; break;
			default: return ""; break;
		}		
	}
	/* ======================================================================================================================== */ 
	function return_SearchContent_cases_InstantaCivil($nr_dosar, $client, $contract, $contract_data, $obiect, $stadiu_procesual) {
		return $nr_dosar.' '.$client.' (CTR.'.$contract.'/'.$contract_data.') '.$obiect.' '.$stadiu_procesual; 
	}
	/* ======================================================================================================================== */ 
	function return_SearchContent_cases_Arbitraj($nr_dosar, $client, $contract, $contract_data, $obiect) {
		return $nr_dosar.' '.$client.' (CTR.'.$contract.'/'.$contract_data.') '.$obiect; 
	}	
	/* ======================================================================================================================== */ 
	
?>