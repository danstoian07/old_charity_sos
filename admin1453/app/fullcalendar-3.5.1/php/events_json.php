<?php
	session_start();
	require_once '../../../../app-top.php';
	require_once('../../../config.php');
		

	
	$ERROR     = false;
	$ERROR_MSG = '';
	if( isset($_REQUEST['id_user']) ) { $id_user_cript = $_REQUEST['id_user']; }  else { $ERROR     = true; $ERROR_MSG = 'Id User incorect'; }
	if( isset($_REQUEST['cc']) )      { $cc = $_REQUEST['cc']; }  else { $cc = '';}  /* calendar colors (url_encoded(json))  */
	if( isset($_REQUEST['ct']) )      { $ct = $_REQUEST['ct']; }  else { $ct = 0;}  /* calendar type: 0- vede dosare proprii, 1 - vede toate dosarele firmei */
		
	
	if (!$ERROR) {
		$bg_terms       = '#1BA39C';
		$color_terms    = '#FFFFFF';
		$bg_activity    = '#c5bf66';
		$color_activity = '#FFFFFF';
		
		if (!empty($cc)) {
			$arr_calendar_colors = json_decode(el_decript_info($cc), true);
			//print_r($arr_calendar_colors);die('');
			$bg_terms       = $arr_calendar_colors['universal_f1'];
			$color_terms    = $arr_calendar_colors['universal_f2'];
			$bg_activity    = $arr_calendar_colors['universal_f3'];
			$color_activity = $arr_calendar_colors['universal_f4'];
		}
		
		$id_user   = el_decript_info($id_user_cript);
		$year      = date("Y");
		$year_prev = $year - 1;
		$year_next = $year + 1;
		
		$WHERE_QUERY1 = (($ct==0) ? "$oDB->multiselect_options.id_archive=20 AND $oDB->multiselect_options.id_options = $id_user AND YEAR($oDB->termene.data_termen)>=$year_prev AND YEAR(data_termen)<=$year_next" : "$oDB->multiselect_options.id_archive=20 AND YEAR(data_termen)>=$year_prev AND YEAR(data_termen)<=$year_next");
		$WHERE_QUERY2 = (($ct==0) ? "$oDB->multiselect_options.id_archive=200 AND $oDB->multiselect_options.id_options = $id_user AND YEAR(data_scadenta)>=$year_prev AND YEAR(data_scadenta)<=$year_next" : "$oDB->multiselect_options.id_archive=200 AND YEAR(data_scadenta)>=$year_prev AND YEAR(data_scadenta)<=$year_next");
		
		$query = 'SET group_concat_max_len=8192';
		$result = $oDB->db_query($query);
		$query1 = "
			SELECT 
			1 AS type, $oDB->termene.id AS f1, $oDB->termene.data_termen AS f2, $oDB->termene.tip_solutie AS f3, $oDB->termene.complet AS f4, $oDB->termene.ora AS f5, 
			$oDB->cases.nr_dosar AS f6, $oDB->cases.obiect AS f7, $oDB->cases.materie_juridica AS f8, $oDB->cases.stadiu_procesual AS f9, $oDB->cases.instanta AS f10, $oDB->cases.sectie AS f11, $oDB->cases.id AS f12 
			FROM $oDB->termene 
			LEFT JOIN $oDB->multiselect_options ON $oDB->multiselect_options.id_main_item = $oDB->termene.idma 
			LEFT JOIN $oDB->cases ON $oDB->multiselect_options.id_main_item = $oDB->cases.id 
			WHERE $WHERE_QUERY1 
			LIMIT 100000000
			";
		$query2 = "
			SELECT 
			2 AS type, $oDB->activitati.id AS f1, DATE($oDB->activitati.data_scadenta) AS f2, $oDB->activitati.name AS f3, $oDB->activitati.descriere AS f4, '' AS f5, 
			$oDB->cases.nr_dosar AS f6, $oDB->cases.obiect AS f7, $oDB->cases.materie_juridica AS f8, $oDB->cases.stadiu_procesual AS f9, $oDB->cases.instanta AS f10, $oDB->cases.sectie AS f11, $oDB->cases.id AS f12  
			FROM $oDB->activitati 
			LEFT JOIN $oDB->multiselect_options ON $oDB->multiselect_options.id_main_item = $oDB->activitati.id 
			LEFT JOIN $oDB->cases ON $oDB->activitati.idma = $oDB->cases.id 
			WHERE $WHERE_QUERY2 
			LIMIT 100000000
			";
		
		$query = "($query1) UNION ($query2)";
		//$query = "SELECT * FROM (($query1) UNION ($query2)) a ORDER BY type ASC, f2 ASC, f5 ASC LIMIT 100000";
		$result = $oDB->db_query($query);
		$arr_info = array();
		$one_elem = array();
		$arr_cases_id = array();
		$i=0;
		while ($result_line = $oDB->db_fetch_array($result)) {			
			switch ($result_line['type']) {
				case 1:
					$encoded_id  = el_encript_info($result_line['f12']);
					$link_redirect = __ADMINURL__."?pn=4"; 
					$link_dosar = __ADMINURL__."?pn=3&archtype=dosare&id=$encoded_id&redirect=".urlencode($link_redirect)."&tab=3";
					$one_elem['id']              = $result_line['f1'];
					$one_elem['id_dosar']        = $result_line['f12'];
					$one_elem['type']            = $result_line['type'];
					$one_elem['title']           = 'Termen dosar '.$result_line['f6'].', '.addslashes($result_line['f10']).', Ora '.$result_line['f5'];
					//$one_elem['title']           = $result_line['f5'].', Termen dosar '.$result_line['f6'].', '.addslashes($result_line['f10']);
					$one_elem['description']     = addslashes($result_line['f7']).'<br /><br />Materie juridica: <strong>'.addslashes($result_line['f8']).'</strong><br>Stadiu procesual: <strong>'.addslashes($result_line['f9']).'</strong>';
					$one_elem['start']           = $result_line['f2'];
					$one_elem['end']             = $result_line['f2'];
					$one_elem['url']             = $link_dosar;
					$one_elem['backgroundColor'] = $bg_terms;
					$one_elem['textColor']       = $color_terms;
					$one_elem['hrs']       		 = trim($result_line['f5']); /* adaugat custom pentru sortare in calendar */
					array_push($arr_info, $one_elem);
					if (!empty($result_line['f12'])) {
						if (!in_array($result_line['f12'], $arr_cases_id))
						{
							$arr_cases_id[] = $result_line['f12']; 
						}
					}
					$i++;
					break;
				case 2:
					$encoded_id  = el_encript_info($result_line['f12']);
					$link_redirect = __ADMINURL__."?pn=4"; 
					$link_dosar = __ADMINURL__."?pn=3&archtype=dosare&id=$encoded_id&redirect=".urlencode($link_redirect)."&tab=4";
					$one_elem['id']              = $result_line['f1'];
					$one_elem['id_dosar']        = $result_line['f12'];
					$one_elem['type']            = $result_line['type'];
					$one_elem['title']           = $result_line['f3'].', dosar '.$result_line['f6'];
					$one_elem['description']     = $result_line['f4'];
					$one_elem['start']           = $result_line['f2'];
					$one_elem['end']             = $result_line['f2'];
					$one_elem['url']             = $link_dosar;
					$one_elem['backgroundColor'] = $bg_activity;
					$one_elem['textColor']       = $color_activity;
					$one_elem['hrs']       		 = trim($result_line['f5']); /* adaugat custom pentru sortare in calendar */
					array_push($arr_info, $one_elem);					
					break;
			}			
		}
		if (!empty($arr_cases_id)) {
			$cases_ids = implode(",",$arr_cases_id);
			$query2 = "SELECT idma, GROUP_CONCAT(CONCAT('<li><strong>',name,'</strong> - [',calitate,']','</li>') SEPARATOR '') AS parti FROM el_parts WHERE idma IN ($cases_ids) GROUP BY idma";
			$result = $oDB->db_query($query2);
			$arr_pers = array();
			while ($result_line = $oDB->db_fetch_array($result)) {
				$id = $result_line['idma'];
				$arr_pers["$id"] = '<br /><br />PARTI IN DOSAR<br /><ul>'.$result_line['parti'].'</ul>';
			}
			foreach ($arr_info as $key => $one_elem) {
				$id_dosar = $one_elem['id_dosar'];
				if (isset($arr_pers["$id_dosar"])) {
					$arr_info[$key]['description'] = $arr_info[$key]['description'].$arr_pers["$id_dosar"];
				}
			}
		}
	}
		
	
	if (!$ERROR) {
		echo json_encode($arr_info);
	} else {
		echo $ERROR_MSG;
	}

	
?>