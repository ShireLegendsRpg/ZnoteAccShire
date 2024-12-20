<?php require_once '../../module.php';

// Configure module version number
$response['version']['module'] = 1;

// Fetch events without limit
$events = mysql_select_multi("SELECT * FROM `events` ");

$response['data']['events'] = $events;

// Send response
SendResponse($response);
?>
