<?php
session_start();
require_once '../../../../app-top.php';
require_once('../../../config.php');

$ERROR     = false;
$ERROR_MSG = '';

if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
} else {
	$ERROR = true; $ERROR_MSG = 'Eroare: Utilizator Nelogat';
}	
if (!$ERROR) {
	if( isset($_REQUEST['id_user']) ) { $id_user_cript = $_REQUEST['id_user']; }  else { $id_user_cript = el_encript_info('0'); }	
	if( isset($_REQUEST['cc']) ) { $cc = $_REQUEST['cc']; }  else { $cc = '';} /* calendar colors (url_encoded(json))  */
	if( isset($_REQUEST['ct']) ) { $ct = $_REQUEST['ct']; }  else { $ct = 0;}  /* calendar type: 0 - dosare proprii, 1 - dosare firma  */
	
	
	//--------------------------------------------------------------------------------------------------
	// This script reads event data from a JSON file and outputs those events which are within the range
	// supplied by the "start" and "end" GET parameters.
	//
	// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
	//
	// Requires PHP 5.2.0 or higher.
	//--------------------------------------------------------------------------------------------------

	// Require our Event class and datetime utilities
	require dirname(__FILE__) . '/utils.php';

	// Short-circuit if the client did not give us a date range.
	if (!isset($_GET['start']) || !isset($_GET['end'])) {
		die("Please provide a date range.");
	}

	// Parse the start/end parameters.
	// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
	// Since no timezone will be present, they will parsed as UTC.
	$range_start = parseDateTime($_GET['start']);
	$range_end = parseDateTime($_GET['end']);	
	// Parse the timezone parameter if it is present.
	$timezone = null;
	if (isset($_GET['timezone'])) {
		$timezone = new DateTimeZone($_GET['timezone']);
	}

	// Read and parse our events JSON file into an array of event data arrays.
	//$json = file_get_contents(dirname(__FILE__) . '/events.json');
	$json = file_get_contents(__CALENDARURL__.'php/events_json.php?id_user='.$id_user_cript.'&cc='.$cc.'&ct='.$ct);
	$input_arrays = json_decode($json, true);
	//echo $json; die('');
	// Accumulate an output array of event data arrays.
	$output_arrays = array();
	foreach ($input_arrays as $array) {

		// Convert the input array into a useful Event object
		$event = new Event($array, $timezone);

		// If the event is in-bounds, add it to the output
		if ($event->isWithinDayRange($range_start, $range_end)) {
			$output_arrays[] = $event->toArray();
		}
	}

	// Send JSON to the client.
	echo json_encode($output_arrays);
} else {
	echo $ERROR_MSG;
}