<?php
	session_start();    
	$ERROR     = false;
	$ERROR_MSG = '';
	$dosar     = '';
	$idma      = 0;
	
	$JS_INSTANTA         = '';
	$JS_SECTIE           = '';
	$JS_OBIECT           = '';
	$JS_STADIU_PROCESUAL = '';
	$JS_MATERIE          = '';
	$JS_RO_DATA          = '';
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
    	//require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'config.php');
    	require_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    	spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = _('Eroare: Utilizator Nelogat');
	}	
	
	if (!$ERROR) {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			$ERROR = true; $ERROR_MSG = 'Eroare POST';
		}
	}
	if (!$ERROR) {
		if (!isset($_SERVER["HTTP_REFERER"])) {
			$ERROR = true; $ERROR_MSG = _('Eroare HTTP_REFERER');
		} else {
				$url_referer   = $_SERVER["HTTP_REFERER"];
				$arr_url_param = el_UrlStringWithParametersToArray($url_referer);
				if ($arr_url_param == false) {
					$ERROR = true; $ERROR_MSG = _('Eroare la determinarea parametrilor din URL referer');
				} else {
					if ((!isset($arr_url_param['pn'])) || ($arr_url_param['pn']!=3)) { $ERROR = true; $ERROR_MSG = _('Eroare parametru "pn" !'); }
					if (!$ERROR) {
						if (!isset($arr_url_param['archtype'])) { $ERROR = true; $ERROR_MSG = _('Eroare parametru "archtype" !'); } else { $archtype = $arr_url_param['archtype']; }
					}
					if (!$ERROR) {
						if (!isset($arr_url_param['id'])) { $ERROR = true; $ERROR_MSG = _('Eroare parametru "id" !'); } else { $idma = el_decript_info($arr_url_param['id']); }
					}
					
				}			
		}
    }	
	
	if (!$ERROR) {
		if ( isset($_REQUEST['dosar']) )    { $dosar    = urldecode($_REQUEST['dosar']); }		
		/* ----------------------------------------------------------------------------- */
							global $oDB;
							$info_dosar    = '';
							$str_cale_atac = '';
							$str_parti     = '';
							$str_sedinte   = '';
							
							if (!empty($dosar)) {									

									$requestul = '<?xml version="1.0" encoding="utf-8"?>
									<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
									  <soap:Body>
											<CautareDosare xmlns="portalquery.just.ro">
											  <numarDosar>'.$dosar.'</numarDosar>
											</CautareDosare>
									  </soap:Body>
									</soap:Envelope>';

									$client = new SoapClient(null, array( 'location' => 'http://portalquery.just.ro/Query.asmx', 'uri' => 'http://portalquery.just.ro/Query', 'encoding' => 'utf-8', 'trace' => 1,));
									$raspuns = $client->__doRequest ( $requestul ,'http://portalquery.just.ro/Query.asmx' , 'portalquery.just.ro/CautareDosare', 1, 0 );
									$raspuns = str_replace("portalquery.just.ro", "http://portalquery.just.ro", $raspuns);
									$doc = new DOMDocument();
									$doc->loadXML($raspuns);							
									/* ------------------------------------------------- */
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
										$ERROR = true; $ERROR_MSG = _('Eroare import date din ECRIS! Posibil dosar inexistent !');
									}
									if (!$ERROR) {
										$JS_INSTANTA         = $general[0]['institutie'];
										$JS_SECTIE           = $general[0]['departament'];
										$JS_OBIECT           = $general[0]['obiect'];
										$JS_STADIU_PROCESUAL = $general[0]['stadiuProcesual'];
										$JS_MATERIE          = $general[0]['categorieCaz'];
										$JS_RO_DATA          = el_MysqlDate_To_RomanianDate(substr($general[0]['data'],0,10));
										$JS_RASPUNS          = $raspuns;
													
										/* ------------------------------------------------- */
										/* Determina partile din dosare*/
										$elements = $doc->getElementsByTagName('DosarParte');
										$parti = array();
										$i=0;		
										
										$query = " DELETE FROM el_parts WHERE idma = $idma";
										$result = $oDB->db_query($query);									
										
										$str_insert = '';
										$tmp_parti = array();
										foreach($elements as $node){
											foreach($node->childNodes as $child) {
												$parti[$i]["$child->nodeName"] = $child->nodeValue;
											}
											$tmp_nume_parte = $parti[$i]['nume'].' '.$parti[$i]['calitateParte'];
											if (!in_array($tmp_nume_parte, $tmp_parti)) {
												array_push($tmp_parti, $tmp_nume_parte);
												$str_insert .= "INSERT INTO el_parts SET id_archive=10, idma=$idma, name='".addslashes( stripslashes($parti[$i]['nume']))."', calitate='".addslashes( stripslashes($parti[$i]['calitateParte']))."'; ".PHP_EOL;
											}
											$i++;
										}
																			
										/* ------------------------------------------------- */									
										/* Determina sedintele */
											$elements = $doc->getElementsByTagName('DosarSedinta');
											$sedinte = array();
											$i=0;
											$query = " DELETE FROM el_termene WHERE idma = $idma";
											$result = $oDB->db_query($query);									
											
											foreach($elements as $node){
												foreach($node->childNodes as $child) {
													$sedinte[$i]["$child->nodeName"] = $child->nodeValue;
												}									
												
												$sedinta_data = el_RomanianDate_To_MysqlDate(substr($sedinte[$i]['data'],0,10));
												$solutie      = $sedinte[$i]['solutie'].PHP_EOL.$sedinte[$i]['solutieSumar'];
												$str_insert .= "INSERT INTO el_termene SET id_archive=10, idma=$idma, data_termen='$sedinta_data', ora='".$sedinte[$i]['ora']."', complet='".$sedinte[$i]['complet']."', solutie='".$solutie."', tip_solutie='".$sedinte[$i]['solutie']."';".PHP_EOL;
												$i++;
											}							
										/* ------------------------------------------------- */
										$result = $oDB->db_multiquery($str_insert);
										$oDB->db_next_result();									
										/* ------------------------------------------------- */
									}
							}
		
		/* ----------------------------------------------------------------------------- */
	}
	$records = array();
    $records["error"]      = $ERROR_MSG;
	if (!$ERROR) {
		if ($idma!=0) {
			$str_insert = '';
		}		
		$records["instanta"]    = $JS_INSTANTA;
		$records["sectie"]      = $JS_SECTIE; 
		$records["obiect"]      = $JS_OBIECT; 
		$records["stadiu"]      = $JS_STADIU_PROCESUAL; 
		$records["materie"]     = $JS_MATERIE; 
		$records["data"]        = $JS_RO_DATA;
		$records["must_update"] = $str_insert;
		$records["raspuns"]     = $JS_RASPUNS;
		
	}	
	
	echo json_encode($records);					
	
?>