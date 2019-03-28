<?php

$newline="\n";
//$ADMIN_URL=__ROOT__.'/admin';
/* ========================================================================================================================= */
  function autoload_frontend_classes($class){
      if(!file_exists(__MAINCLASSESPATH__.'class.'.$class.'.php') )
          return false;
      require_once(__MAINCLASSESPATH__.'class.'.$class.'.php');
      return true;
  }  
/* ========================================================================================================================= */
  function autoload_backend_classes($class){
      if(!file_exists(__CLASSESPATH__.'class.'.$class.'.php') )
          return false;
      require_once(__CLASSESPATH__.'class.'.$class.'.php');
      return true;
  }  
/* ========================================================================================================================= */
function el_sanitize_url($url){
    return filter_var($url, FILTER_SANITIZE_URL);
}
/* ========================================================================================================================= */
function el_redirect($url, $permanent = false)
{
    if (headers_sent() === false) {
        header('Location: ' . el_sanitize_url($url), true, ($permanent === true) ? 301 : 302);
    }
    exit();
}
/* ========================================================================================================================= */
/* update field json_parameters in settings table */
function el_update_json_settings($oDB, $WHERE, $json){
    //$query  = "SELECT json_parameters FROM $oDB->settings WHERE $WHERE";
	$query  = "SELECT json_parameters FROM $oDB->users WHERE $WHERE";
    $result = $oDB->db_query($query);    
    if ($result_line = $oDB->db_fetch_array($result)) {
        $data_db = json_decode($result_line['json_parameters'], true);
        if (!is_null($data_db)) {
            $data_new = json_decode($json, true);            
            if (!is_null($data_new)) {                
                foreach ($data_new as $key => $value) {
                    $data_db["$key"] = $value;
                }
                $jsontext = json_encode($data_db);                
                if($jsontext === false || is_null($jsontext)){
                    //throw new Exception('Could not encode JSON');
                } else {
                    //$query    = "UPDATE $oDB->settings SET json_parameters='$jsontext' WHERE $WHERE";
					$query    = "UPDATE $oDB->users SET json_parameters='$jsontext' WHERE $WHERE";
                    $result   = $oDB->db_query($query);                    
                }
            }
        }
    }
}
/* ========================================================================================================================= */
function el_user_logged($sessionID) {
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
	//if ((isset($_SESSION["$sessionID"]["user"]["id"])) && (isset($_SESSION["$sessionID"]["user"]["logged"])) && ($_SESSION["$sessionID"]["user"]["logged"]==1) ) {
		return true;
	}
	return false;
}
/* ========================================================================================================================= */
function el_getHtml($url, $post = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    if(!empty($post)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    } 
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
/* ========================================================================================================================= */
function el_get_string_between($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);   
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

/* ========================================================================================================================= */
function el_encript_info($text){
    $encrypt_method = "AES-128-CBC";
    $secret_key     = AUTH_KEY;
    $secret_iv      = AUTH_KEY;
	$key            = hash('sha256', $secret_key);
    $iv             = substr(hash('sha256', $secret_iv), 0, 16);
    $output         = base64_encode(openssl_encrypt($text, $encrypt_method, $key, 0, $iv));
    return $output;
}
/* ========================================================================================================================= */
function el_decript_info($encripted_text){
    $encrypt_method = "AES-128-CBC";
    $secret_key     = AUTH_KEY;
    $secret_iv      = AUTH_KEY;
	$key            = hash('sha256', $secret_key);
    $iv             = substr(hash('sha256', $secret_iv), 0, 16);    
	$output = openssl_decrypt(base64_decode($encripted_text), $encrypt_method, $key, 0, $iv);
	return $output;
}
/* ========================================================================================================================= */
function el_valid_json($string) {
	if (is_string($string)) {
		@json_decode($string);
		return (json_last_error() === JSON_ERROR_NONE);
	}
	return false;
}
/* ========================================================================================================================= */
/* remove variable from url */
function el_remove_url_param($url, $varname) {
    return rtrim(rtrim(preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url),'&'),'?');
}

/* ========================================================================================================================= */
/* Returneaza adreasa (URL-ul) paginii curente */
function el_curent_url() {
   return "http".((array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") ? "s" : "")."://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

/* ========================================================================================================================= */
function el_between($int,$min,$max){
    return ($min<=$int && $int<=$max);
}
/* ========================================================================================================================= */
function el_string_contain_substring($string, $substring) {
	 //return strpos($string, $substring);
	 if ($string==$substring) { return 1; } else { return strpos($string, $substring);}
}
/* ========================================================================================================================= */
function el_replace_quote_with_code($string) {
	 $string = str_replace('"', '&#34;', $string);
	 $string = str_replace('"', '&#39;', $string);
	 return $string;
}

/* ========================================================================================================================= */
function el_UrlStringWithParametersToArray($qry){
	$result = array();
	//string must contain at least one = and cannot be in first position
	if(strpos($qry,'=')) {

	 if(strpos($qry,'?')!==false) {
	   $q = parse_url($qry);
	   $qry = $q['query'];
	  }
	}else {
			return false;
	}

	foreach (explode('&', $qry) as $couple) {
			list ($key, $val) = explode('=', $couple);
			$result[$key] = $val;
	}

	return empty($result) ? false : $result;
}
/* ========================================================================================================================= */
function el_TableNameWithPrefix($TableNameWithoutPrefix){
	/*
	global $oDB;
	$table_name = '';
	$eval_str = "\$table_name = \$oDB->$TableNameWithoutPrefix;";
	eval($eval_str);
	*/
	$table_name = APP_TABLES_PREFIX.$TableNameWithoutPrefix;
	return $table_name;
}
/* ========================================================================================================================= */
function el_get_curent_day_number() {
	/* returneaza 0 pt duminica: pt fullcalendar */
	$day_no = date('N');
	return ($day_no!=7 ? $day_no : 0);
}
/* ========================================================================================================================= */
function el_MysqlDate_To_RomanianDate($Mysql_Date) {
	if ($Mysql_Date!='0000-00-00') {
		return date("d-m-Y", strtotime($Mysql_Date));
	} else {
		return '';
	}
}
/* ========================================================================================================================= */
function el_RomanianDate_To_MysqlDate($RO_Date) {
    return date("Y-m-d", strtotime($RO_Date));
}
/* ========================================================================================================================= */
function el_MysqlDateTime_To_RomanianDateTime($Mysql_DateTime) {
    //return date("d-m-Y H:i:s", strtotime($Mysql_DateTime));
	return date("d-m-Y H:i", strtotime($Mysql_DateTime));
}
/* ========================================================================================================================= */
function el_MysqlDateTime_To_Date($Mysql_DateTime) {
	return date("Y-m-d", strtotime($Mysql_DateTime));
}
/* ========================================================================================================================= */
function el_MysqlDateTime_To_Time($Mysql_DateTime) {
	return date("H:i:s", strtotime($Mysql_DateTime));
}
/* ========================================================================================================================= */
function el_RomanianDateTime_To_MysqlDateTime($RO_DateTime) {
    return date("Y-m-d H:i:s", strtotime($RO_DateTime));
}
/* ========================================================================================================================= */
    function el_MysqlDateTime_To_RomanianDate_Literal($Mysql_Date) {
        $ro_date=date("d-m-Y-H:i", strtotime($Mysql_Date));
        $day   = substr($ro_date,0,2);
        $month = intval(substr($ro_date,3,2));
        $year  = substr($ro_date,6,4);
        $time  = substr($ro_date,11,5);
        switch ($month) {
            case  1: $mo="Ianuarie"; break;
            case  2: $mo="Februarie"; break;
            case  3: $mo="Martie"; break;
            case  4: $mo="Aprilie"; break;
            case  5: $mo="Mai"; break;
            case  6: $mo="Iunie"; break;
            case  7: $mo="Iulie"; break;
            case  8: $mo="August"; break;
            case  9: $mo="Septembrie"; break;
            case 10: $mo="Octombrie"; break;
            case 11: $mo="Noiembrie"; break;
            case 12: $mo="Decembrie"; break;            
        }
        return $day.' '.$mo.' '.$year.', '.$time;
    }
/* ========================================================================================================================= */
    function el_MysqlDateTime_To_RomanianShortDate_Literal($Mysql_Date) {
		if ($Mysql_Date != '0000-00-00 00:00:00') {
			$ro_date=date("d-m-Y-H:i", strtotime($Mysql_Date));
			$day   = substr($ro_date,0,2);
			$month = intval(substr($ro_date,3,2));
			$year  = substr($ro_date,6,4);
			$time  = substr($ro_date,11,5);
			switch ($month) {
				case  1: $mo="Ian"; break;
				case  2: $mo="Feb"; break;
				case  3: $mo="Mar"; break;
				case  4: $mo="Apr"; break;
				case  5: $mo="Mai"; break;
				case  6: $mo="Iun"; break;
				case  7: $mo="Iul"; break;
				case  8: $mo="Aug"; break;
				case  9: $mo="Sep"; break;
				case 10: $mo="Oct"; break;
				case 11: $mo="Noi"; break;
				case 12: $mo="Dec"; break;
			}
			return $day.' '.$mo.' '.$year.', '.$time;
		}
		else {
			return '';
		}
    }
/* ========================================================================================================================= */
    function el_MysqlDateTime_To_ShortRomanianDate_Literal($Mysql_Date) {
        $ro_date=date("d-m-Y-H:i", strtotime($Mysql_Date));
        $day   = substr($ro_date,0,2);
        $month = intval(substr($ro_date,3,2));
        $year  = substr($ro_date,6,4);
        $time  = substr($ro_date,11,5);
        switch ($month) {
            case  1: $mo="Ian"; break;
            case  2: $mo="Feb"; break;
            case  3: $mo="Mar"; break;
            case  4: $mo="Apr"; break;
            case  5: $mo="Mai"; break;
            case  6: $mo="Iun"; break;
            case  7: $mo="Iul"; break;
            case  8: $mo="Aug"; break;
            case  9: $mo="Sep"; break;
            case 10: $mo="Oct"; break;
            case 11: $mo="Noi"; break;
            case 12: $mo="Dec"; break;            
        }
        return $day.' '.$mo.', '.$year;
    }

/* ========================================================================================================================= */
function el_RomanianMonthName($month_no) {
	$mo = '';
	switch ($month_no) {
		case  1: $mo="Ianuarie"; break;
		case  2: $mo="Februarie"; break;
		case  3: $mo="Martie"; break;
		case  4: $mo="Aprilie"; break;
		case  5: $mo="Mai"; break;
		case  6: $mo="Iunie"; break;
		case  7: $mo="Iulie"; break;
		case  8: $mo="August"; break;
		case  9: $mo="Septembrie"; break;
		case 10: $mo="Octombrie"; break;
		case 11: $mo="Noiembrie"; break;
		case 12: $mo="Decembrie"; break;            
	}
	return $mo;
}
/* ========================================================================================================================= */
function el_CorectDateTimeInterval($DateTime1, $DateTime2){
   $interval   = round((strtotime($DateTime2) - strtotime($DateTime1))/ 60); //interval in minutes
   return ($interval>0 ? true : false);
}
/* ========================================================================================================================= */
/* the function will return "true" if 2 datetime intervals overlap, otherwise "false"*/
function el_DateTimeIntervalIntersect($from, $to, $from_compare, $to_compare){
    $from         = strtotime($from);
    $to           = strtotime($to);
    $from_compare = strtotime($from_compare);
    $to_compare   = strtotime($to_compare);
    
    $intersect = min($to, $to_compare) - max($from, $from_compare);
    if ( $intersect < 0 ) $intersect = 0;
    $overlap = $intersect / 3600;
    
    if ( $overlap <= 0 ):
        return false;
    else:
        return true;
    endif;   
}
/* ========================================================================================================================= */
 // dd-mm-yyyy
 function el_ValidRomanianDate($RO_Date){
	$valid = true;
	$arr_date = explode("-", $RO_Date);
	if (count($arr_date)!=3) { $valid = false;}
	
	if ($valid) {
		$valid = checkdate($arr_date[1], $arr_date[0], $arr_date[2]);
	}
	return $valid;
}
/* ========================================================================================================================= */
// yyyy-mm-dd
 function el_ValidEnglishDate($EN_Date){
	$valid = true;
	$arr_date = explode("-", $EN_Date);
	if (count($arr_date)!=3) { $valid = false;}
	
	if ($valid) {
		$valid = checkdate($arr_date[1], $arr_date[2], $arr_date[0]);
	}
	return $valid;
}
/* ========================================================================================================================= */
 // dd-mm-yyyy hh:ii
function el_ValidRomanianDateTime($RO_DateTime){
	$valid = true;
	$arr_date_time = explode(" ", $RO_DateTime);
	if (count($arr_date_time)!=2) { $valid = false;}
	if ($valid) {
		$valid = el_ValidRomanianDate($arr_date_time[0]);
	}
	if ($valid) {
		if (!preg_match('/^\d{2}:\d{2}$/', $arr_date_time[1])) {
			$valid=false;
		}
	}
	if ($valid) {
		if (!preg_match("/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $arr_date_time[1])) {
			$valid = false;
		}		
	}
	return $valid;
}

 /* ========================================================================================================================= */
 function el_orthodox_easter_date($y) {
	 return date("d-m-Y",mktime(0,0,0,floor(($b=($a=(19*($y%19)+15)%30)+(2*($y%4)+4*$y%7-$a+34)%7+114)/31),($b%31)+14,$y));
 }
 /* ========================================================================================================================= */
 function el_SarbatoriLegaleRomania($RO_Date) {
	
	$ret  = 'Zi lucratoare';
	$flag = 0; /* 0 - normal, 1 - weekend, 2 - sarbatoare legala */
	
	$year  = date("Y", strtotime($RO_Date));
	$month = date("m", strtotime($RO_Date));
	$day   = date("d", strtotime($RO_Date));
	
	$EN_Date = "$year-$month-$day";
	
	if (date('N', strtotime($EN_Date)) >= 6) {
		$ret  = 'Weekend'; $flag = 1;
	}
		
	$sarbatori = array
	  (
		array( 1, 1, "Anul nou !"),
		array( 2, 1, "Anul nou !"),
		array(24, 1, "Ziua Unirii Principatelor Romane"),
		array( 1, 5, "Ziua Muncii"),
		array(15, 8, "Adormirea Maicii Domnului"),
		array(30,11, "Sfantul Apostol Andrei"),		
		array( 1,12, "Ziua Nationala a Romaniei"),
		array(25,12, "Prima zi de Craciun"),
		array(26,12, "A doua zi de Craciun")		
	  );
	
	$ret_sl = '';
	foreach ($sarbatori as $key => $value) {		
		if (($value[0]==$day) && ($value[1]==$month)) {
			$ret_sl  = (!empty($ret_sl) ? ' | ' : ''). $value[2];
		}				
	}
	
	$easter_first_day_date  = el_orthodox_easter_date($year);	  	
	$date1 = date("Y", strtotime($easter_first_day_date)).'-'.date("m", strtotime($easter_first_day_date)).'-'.date("d", strtotime($easter_first_day_date));
	$easter_second_day_date = date('d-m-Y',strtotime($date1 . "+1 days"));
	$rusalii_date = date('d-m-Y',strtotime($date1 . "+49 days"));

	$month_easter_1 = date("m", strtotime($easter_first_day_date));
	$day_easter_1   = date("d", strtotime($easter_first_day_date));
	if (($day==$day_easter_1) && ($month==$month_easter_1)) {
		$ret_sl  .= (!empty($ret_sl) ? ' | ' : '').'Prima zi de Pasti Ortodox';
	}				
	$month_easter_2 = date("m", strtotime($easter_second_day_date));
	$day_easter_2   = date("d", strtotime($easter_second_day_date));
	if (($day==$day_easter_2) && ($month==$month_easter_2)) {
		$ret_sl  .= (!empty($ret_sl) ? ' | ' : '').'A doua zi de Pasti Ortodox';
	}	

	$month_rusalii = date("m", strtotime($rusalii_date));
	$day_rusalii   = date("d", strtotime($rusalii_date));
	if (($day==$day_rusalii) && ($month==$month_rusalii)) {
		$ret_sl  .= (!empty($ret_sl) ? ' | ' : '').'Rusalii';
	}	
	
	if (!empty($ret_sl)) {
		$ret = $ret_sl; $flag = 2;
	}		
	
	$records         = array();
    $records["info"] = $ret;
    $records["flag"] = $flag;
	  
	return json_encode($records);
	  
 }
 /* ========================================================================================================================= */
	/* returneaza un json cu ratele de schimb BNR din data $ro_date, pentru toate valutele */
	function el_get_currency_rate($ro_date) {		
		/* 	script valabil pentru 
			Valute: AED, AUD, BGN, BRL, CAD, CHF, CNY, CZK, DKK, EGP, EUR, GBP, HRK, INR, MDL, MXN, NOK, NZD, PLN, RSD, RUB, SEK, THB, TRY, UAH, USD, XAU, XDR, ZAR
			Pentru: HUF, JPY, KRW -> exista un multiplicator
			Mai jos este o secventa demo din fisierel BNR
			<Rate currency="AED">1.0669</Rate><Rate currency="AUD">2.9705</Rate><Rate currency="BGN">2.3736</Rate><Rate currency="BRL">1.2196</Rate><Rate currency="CAD">3.0518</Rate><Rate currency="CHF">3.9808</Rate><Rate currency="CNY">0.5937</Rate><Rate currency="CZK">0.1822</Rate><Rate currency="DKK">0.6238</Rate><Rate currency="EGP">0.2210</Rate><Rate currency="EUR">4.6422</Rate><Rate currency="GBP">5.2528</Rate><Rate currency="HRK">0.6152</Rate><Rate currency="HUF" multiplier="100">1.4912</Rate><Rate currency="INR">0.0609</Rate><Rate currency="JPY" multiplier="100">3.5138</Rate><Rate currency="KRW" multiplier="100">0.3643</Rate><Rate currency="MDL">0.2268</Rate><Rate currency="MXN">0.2111</Rate><Rate currency="NOK">0.4755</Rate><Rate currency="NZD">2.7090</Rate><Rate currency="PLN">1.1057</Rate><Rate currency="RSD">0.0388</Rate><Rate currency="RUB">0.0672</Rate><Rate currency="SEK">0.4684</Rate><Rate currency="THB">0.1205</Rate><Rate currency="TRY">0.9902</Rate><Rate currency="UAH">0.1449</Rate><Rate currency="USD">3.9188</Rate><Rate currency="XAU">163.0953</Rate><Rate currency="XDR">5.5516</Rate><Rate currency="ZAR">0.2861</Rate>
		*/
		try {
				$ERROR_MSG = '';
				$valute    = array('AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'EGP', 'EUR', 'GBP', 'HRK', 'INR', 'MDL', 'MXN', 'NOK', 'NZD', 'PLN', 'RSD', 'RUB', 'SEK', 'THB', 'TRY', 'UAH', 'USD', 'XAU', 'XDR', 'ZAR', 'HUF', 'JPY', 'KRW');
							
				$exist_date_in_xml = false;
				while (!$exist_date_in_xml) {
					/* --------------------- */
					$day          = substr($ro_date,0,2);
					$month        = intval(substr($ro_date,3,2));
					$year         = substr($ro_date,6,4);
					$bnr_xml_file = APP_EXCHANGE_URL."nbrfxrates".$year.".xml";
					
					$ch = curl_init();
					curl_setopt ($ch, CURLOPT_URL, $bnr_xml_file);
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					$xml_content = curl_exec($ch);
					curl_close($ch);
					
					$start = "<Cube date=\"$year-$month-$day\">";
					$end   = '</Cube>';
					$raspuns = el_get_string_between($xml_content, $start, $end);
					$exist_date_in_xml = (!empty($raspuns) ? true : false );
					if (!$exist_date_in_xml) {
						$eng_date = el_RomanianDate_To_MysqlDate($ro_date);
						$date = new DateTime($eng_date);
						$date->modify('-1 day');
						$ro_date = $date->format('d-m-Y');				
					}
					/* --------------------- */			
				}
				$info = array();
				foreach ($valute as $key => $currency) {
					$info["$currency"]['symbol'] = $currency;
					$multiplier = el_get_string_between($raspuns, '<Rate currency="'.$currency.'" multiplier="', '">');
					if (empty($multiplier)) {
						$info["$currency"]['multiplier'] = 1;
						$info["$currency"]['exchange']   = el_get_string_between($raspuns, '<Rate currency="'.$currency.'">', '</Rate>');
					} else {
						$info["$currency"]['multiplier'] = $multiplier;
						$info["$currency"]['exchange']   = el_get_string_between($raspuns, '<Rate currency="'.$currency.'" multiplier="'.$multiplier.'">', '</Rate>');
					}
					$info["$currency"]['flag'] = 'http://www.bnr.ro/img/valute/'.strtolower($currency).'.gif';
					
				}
			}	
				catch(Exception $e) {
					$ERROR_MSG  = $e->getMessage();
			}
		
		$ret_arr = array();
		$ret_arr['ERROR']            = $ERROR_MSG;
		$ret_arr['ro_date_exchange'] = $ro_date; /* Data la care */
		$ret_arr['array']            = $info;
		return json_encode($ret_arr);
	}
 
 /* ========================================================================================================================= */
 function el_ReturnIconClassFromFileType($filextension){
	$filextension = strtoupper(trim($filextension));	
	$icon_class= 'fa-file-o';
	
	switch ($filextension) {
		case "PDF":	
					$icon_class= 'fa-file-pdf-o'; break;
		case "DOC" :	
		case "DOCX":	
					$icon_class= 'fa-file-word-o'; break;
		case "XLS" :	
		case "XLSX":	
					$icon_class= 'fa-file-excel-o'; break;
		case "PPT" :	
		case "PPTX":	
					$icon_class= 'fa-file-powerpoint-o'; break;
		case "TXT" :	
					$icon_class= 'fa-file-text-o'; break;
		case "ZIP" :	
		case "RAR" :			
		case "7Z"  :	
		case "TAR" :	
		case "ARJ" :	
		case "ACE" :	
		case "GZIP":	
		case "LZIP":	
					$icon_class= 'fa-file-archive-o'; break;
		case "JPG" :	
		case "JPEG":
		case "GIF" :
		case "BMP" :
		case "TIFF":
		case "PNG" :
					$icon_class= 'fa-file-image-o'; break;
		case "MP3" :
		case "WAV" :
		case "WMA" :
					$icon_class= 'fa-file-audio-o'; break;
					
		case "MP4" :
		case "AVI" :
		case "MPG" :
		case "MPEG":
					$icon_class= 'fa-file-video-o'; break;
					
		
	}	 
	return $icon_class;
 }
 /* ========================================================================================================================= */
 function el_AdminReturnPhotoFromFileType($filextension){
	$filextension = strtoupper(trim($filextension));	
	$photo = 'file.png';
	
	switch ($filextension) {
		case "PDF" :	
					$photo= 'pdf.png'; break;
		case "DOC" :	
		case "DOCX":	
					$photo= 'doc.png'; break;
		case "XLS" :	
		case "XLSX":	
					$photo= 'xls.png'; break;
		case "PPT" :	
		case "PPTX":	
					$photo= 'ppt.png'; break;
		case "TXT" :	
					$photo= 'txt.png'; break;
		case "ZIP" :	
		case "RAR" :			
		case "7Z"  :	
		case "TAR" :	
		case "ARJ" :	
		case "ACE" :	
		case "GZIP":	
		case "LZIP":	
					$photo= 'arh.png'; break;
		case "JPG" :	
		case "JPEG":
		case "GIF" :
		case "BMP" :
		case "TIFF":
		case "PNG" :
					$photo= 'picture.png'; break;
		case "MP3" :
		case "WAV" :
		case "WMA" :
					$photo= 'audio.png'; break;
					
		case "MP4" :
		case "AVI" :
		case "MPG" :
		case "MPEG":
					$photo= 'video.png'; break;							
	}	 
	return __ADMINURL__.'resources/img/'.$photo;
 }
 
 /* ========================================================================================================================= */
	function el_IsImage($filename) {    
		$imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif", "bmp","ico", "jp2");    
		$urlExt = pathinfo($filename, PATHINFO_EXTENSION);
		if (in_array(strtolower($urlExt), $imgExts)) {
			return true;
		} else {return false;}
	}
 /* ========================================================================================================================= */
    function el_AdminCropImage($img, $w=0, $h=0){ 
    $q=100; /* calitate 0-100 */
    $src =__ADMINURL__.'app/tt/tt.php?src='.$img.($w>0 ? "&w=$w" : "").($h>0 ? "&h=$h" : "")."&q=$q";    
    return $src;
    }
 /* ========================================================================================================================= */
	function el_TruncateString($string, $max_string_size) {
		$truncated_string=$string;
		if (mb_strlen($truncated_string)>$max_string_size) {
			$truncated_string=mb_substr($truncated_string,0,$max_string_size)."...";
		}
		return $truncated_string;
	}
 /* ========================================================================================================================= */
 /* get constant name from  value */
 function el_ConstantName($val) {
    $constant_set = get_defined_constants(true);
    $consts = $constant_set['user'];
    $ret = '';
    foreach ($consts as $id => $cVal) {
        if ($cVal === $val) {
            $ret = $id;
			break;
        }
    }
    return $ret;
}
 
 /* ========================================================================================================================= */
	function el_PermalinkFromString($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}   
 /* ========================================================================================================================= */ 
    function el_ret_safety_email($email, $name='', $class='header_email'){
        $ar=explode("@",$email);
        if (!empty($name)) {
            $ret="<script type=\"text/javascript\">emailE=('".$ar[0]."@' + '".$ar[1]."'); document.write('<a class=\"$class\" href=\"mailto:' + emailE + '\">$name</a>'); </script>";
        } else {
            $ret="<script type=\"text/javascript\">emailE=('".$ar[0]."@' + '".$ar[1]."'); document.write('<a class=\"$class\" href=\"mailto:' + emailE + '\">' + emailE + '</a>'); </script>";
        }
        return $ret;
    }
/* ========================================================================================================================= */
	/* inlocuieste in string e-mail-urile cu script */
	function el_replace_emails_in_string_with_script($string){
		$new_string="";
		$pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
		preg_match_all($pattern, $string,  $matches);
		$arr_emails=$matches[0];
		$len=count($arr_emails);
		for ($i = 0; $i < $len; $i++) {
			$ar=explode("@",$arr_emails[$i]);
			$replace_with = "<script type=\"text/javascript\">emailE$i=('".$ar[0]."@' + '".$ar[1]."'); document.write('<a href=\"mailto:' + emailE$i + '\">' + emailE$i + '</a>'); </script>";
			$string = str_replace($arr_emails[$i], $replace_with,$string);
		}
		return	$string;
	}
 /* ========================================================================================================================= */
	function el_getIp()
	{if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip_address=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}

	if (!isset($ip_address)){
			if (isset($_SERVER['REMOTE_ADDR']))    
			$ip_address=$_SERVER['REMOTE_ADDR'];
	}
	if (!isset($ip_address)){
		$ip_address = '';
	}
	return $ip_address;
	} 
  /* ======================================================================================================================== */
	function el_addHttp($url, $scheme = 'http://')
	{
	  return parse_url($url, PHP_URL_SCHEME) === null ?
		$scheme . $url : $url;
	}  
 /* ========================================================================================================================= */
  /* ========================================================================================================================= */
    //http://www.youtube.com/watch?v=Ow0y4hYDZTI
    function el_return_media_type_from_url ($url){
        $type=0; /* no media */
        if ($type==0) {
            //if (el_valid_image_link($url)) {$type=1;/* image link */}
        }
        if ($type==0) {
            if (el_valid_youtube_link($url)) {$type=2;/* youtube link */}
        }
        if ($type==0) {
            if (el_valid_internal_videolink($url)) {$type=3;/* internal video link */}
        }		
        return $type;
    }
    /* =================================================================================== */
      function el_valid_internal_videolink($url){
        $valid= FALSE;
        if (strpos($url, __URL__) > 0) {
            $path_info = pathinfo($url);
			$extension = strtolower($path_info['extension']);
			if (($extension=='mp4') || ($extension=='avi')) {
				$valid= TRUE;
			}
        } 
        return $valid;
    } 
	/* =================================================================================== */
     function el_valid_youtube_link($youtube_url){
        $valid= FALSE;
        if (strpos($youtube_url, 'youtube.com/watch?v=') > 0) {
            $valid= TRUE;
        } 
        return $valid;
    } 
    /* =================================================================================== */
     function el_valid_image_link($img_url){
        $valid= FALSE;
        //$img_url = "http://www.example.com/image.jpg";
        $img_formats = array("png", "jpg", "jpeg", "gif", "tiff");//Etc. . . 
        $path_info = pathinfo($img_url);

        if (in_array(strtolower($path_info['extension']), $img_formats)) {
           $valid= TRUE;
        }
        return $valid;
    } 
    /* =================================================================================== */
     function el_return_youtube_link_with_wmode($videolink) {
        $url= "";
        $ytarray=explode("/", $videolink);
        $ytendstring=end($ytarray);
        $ytendarray=explode("?v=", $ytendstring);
        $ytendstring=end($ytendarray);
        $ytendarray=explode("&", $ytendstring);
        $ytcode=$ytendarray[0];
        //$url = "http://www.youtube.com/embed/$ytcode?wmode=transparent";
		$url = "http://www.youtube.com/embed/$ytcode";
        return $url;
    } 
    /* =================================================================================== */
     function el_return_youtube_id($videolink) {
        $ytcode= "";
        $ytarray=explode("/", $videolink);
        $ytendstring=end($ytarray);
        $ytendarray=explode("?v=", $ytendstring);
        $ytendstring=end($ytendarray);
        $ytendarray=explode("&", $ytendstring);
        $ytcode=$ytendarray[0];
        return $ytcode;
    }
 
    /* =================================================================================== */
	function el_return_youtube_link_from_id($id_YouTube) {
		return "http://www.youtube.com/embed/$id_YouTube?rel=0&autoplay=1&amp;wmode=transparent";
	}
	/* =================================================================================== */

 function return_array_from_nestedmenu_string($menu_string) {
	 $arrmenu = array();
	 $arrmenu = json_decode($menu_string, true);	 
	 return $arrmenu;
 }
 /* ========================================================================================================================= */
 
function Year_From_RomanianDate($RO_Date) {
    return date("Y", strtotime($RO_Date));
}
/* ========================================================================================================================= */
function Month_From_RomanianDate($RO_Date) {
    return date("m", strtotime($RO_Date));
}
/* ========================================================================================================================= */
function Day_From_RomanianDate($RO_Date) {
    return date("d", strtotime($RO_Date));
}
/* ========================================================================================================================= */
function Valid_RomanianDate($RO_Date) {
    $valid=true;
    if ($RO_Date!='01-01-1970') {
        $new_date=date("d-m-Y", strtotime($RO_Date));
        if ($new_date=='01-01-1970') {
            $valid=false;
        }
    }    
    return $valid;
}
/* ========================================================================================================================= */
/* ========================================================================================================================= */
function ret_safety_email($email, $name=''){
    $ar=split("@",$email);
    if (!empty($name)) {
        $ret="<script type=\"text/javascript\">emailE=('".$ar[0]."@' + '".$ar[1]."'); document.write('<a class=\"contact-email\" href=\"mailto:' + emailE + '\">$name</a>'); </script>";
    } else {
        $ret="<script type=\"text/javascript\">emailE=('".$ar[0]."@' + '".$ar[1]."'); document.write('<a class=\"contact-email\" href=\"mailto:' + emailE + '\">' + emailE + '</a>'); </script>";
    }
    return $ret;
}
/* ========================================================================================================================= */
/* conversie url relativ in url absolut */
function url_remove_dot_segments( $path ) {
  // multi-byte character explode
  $inSegs  = preg_split( '!/!u', $path );
  $outSegs = array( );
  foreach ( $inSegs as $seg )
  {
    if ( $seg == '' || $seg == '.')
      continue;
    if ( $seg == '..' )
      array_pop( $outSegs );
    else
      array_push( $outSegs, $seg );
  }
  $outPath = implode( '/', $outSegs );
  if ( $path[0] == '/' )
    $outPath = '/' . $outPath;
  // compare last multi-byte character against '/'
  if ( $outPath != '/' &&
    (mb_strlen($path)-1) == mb_strrpos( $path, '/', 'UTF-8' ) )
    $outPath .= '/';
  return $outPath;
}

/* ========================================================================================================================= */

?>