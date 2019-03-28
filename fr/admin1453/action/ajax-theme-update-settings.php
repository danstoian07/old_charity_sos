<?php
	session_start();

	require('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if( isset($_REQUEST['settings']) )   { $settings         = $_REQUEST['settings']; }         /* string cu parametri tema */
		if ( strlen(trim($settings))!=17 )   { $settings ='0,0,0,0,0,0,0,0,0'; }

	    $arr_prop        = explode(',',$settings);	    	    
	    
	    // tip - means "Theme Interface Parameters"
	    $data['tip1'] = ( (el_between($arr_prop[0],0,5)) ? $arr_prop[0] : 0 );
	    $data['tip2'] = ( (el_between($arr_prop[1],0,1)) ? $arr_prop[1] : 0 );
	    $data['tip3'] = ( (el_between($arr_prop[2],0,1)) ? $arr_prop[2] : 0 );
	    $data['tip4'] = ( (el_between($arr_prop[3],0,1)) ? $arr_prop[3] : 0 );
	    $data['tip5'] = ( (el_between($arr_prop[4],0,1)) ? $arr_prop[4] : 0 );
	    $data['tip6'] = ( (el_between($arr_prop[5],0,1)) ? $arr_prop[5] : 0 );
	    $data['tip7'] = ( (el_between($arr_prop[6],0,1)) ? $arr_prop[6] : 0 );
	    $data['tip8'] = ( (el_between($arr_prop[7],0,1)) ? $arr_prop[7] : 0 );
	    $data['tip9'] = ( (el_between($arr_prop[8],0,1)) ? $arr_prop[8] : 0 );	    
	    
	    $json     = json_encode($data);
	    $WHERE    ="id= '".el_decript_info($_SESSION[APP_ID]["user"]["id"])."' AND id_archive=10";
	    el_update_json_settings($oDB, $WHERE, $json);
	} else {
		//echo 'Failed';
	}
	
?>