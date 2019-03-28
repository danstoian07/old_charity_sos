<?php
    require('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
    
	$ERROR=false;
    $ERROR_MSG='';
	
    if(isset($_REQUEST['table']))            {$table            = $_REQUEST['table'];} else { $ERROR=true; $ERROR_MSG .='1;';}                /* numele tabelei in care se face interogarea */
    if(isset($_REQUEST['ida']))              {$ida              = $_REQUEST['ida'];} else   { $ERROR=true; $ERROR_MSG .='2;';}                /* id archive */
    if(isset($_REQUEST['filter_field']))     {$filter_field     = $_REQUEST['filter_field'];} else { $ERROR=true; $ERROR_MSG .='3;';}         /* campul dupa care se face filtrarea */ 
    if(isset($_REQUEST['value']))            {$value            = $_REQUEST['value'];} else { $ERROR=true; $ERROR_MSG .='4;';}                /* valoarea de filtrare */
    if(isset($_REQUEST['field_for_value']))  {$field_for_value  = $_REQUEST['field_for_value'];} else { $ERROR=true; $ERROR_MSG .='5;';}      /* campul de interogare pentru valoarea din <option value ="xxx"></option>*/
    if(isset($_REQUEST['field_for_title']))  {$field_for_title  = $_REQUEST['field_for_title'];} else { $ERROR=true; $ERROR_MSG .='6;';}      /* campul de interogare pentru descrierea din <option >YYY</option>*/
    if(isset($_REQUEST['order_value']))      {$order_value      = urldecode($_REQUEST['order_value']);} else { $ERROR=true; $ERROR_MSG .='7;';}          /* valoarea care defineste ordinea de afisare */
    if(isset($_REQUEST['first_title']))      {$first_title      = urldecode($_REQUEST['first_title']);} else { $ERROR=true; $ERROR_MSG .='8;';}          /* denumirea primei inregistrari din combo */
    
    
    
    if (!$ERROR) {
		$table_name = $table;
		$eval_str = "\$table_name = \$oDB->$table;";
		eval($eval_str);
		
		$query   = "SELECT $field_for_value AS id, $field_for_title AS title FROM $table_name WHERE $filter_field=$value AND id_archive=$ida AND visible!=0 ORDER BY ".$order_value;
        $result  = $oDB->db_query($query);	
        echo '<option value="">'.$first_title.'</option>'."\n";
		while ($result_line = $oDB->db_fetch_array($result)) {
            echo '<option value="'.$result_line['id'].'">'.$result_line['title'].'</option>'."\n";
        }
    } else {
        echo '<option value="1">Eroare: '.$ERROR_MSG.'</option>';
    }
    
?>
