<?php 
require dirname(__DIR__)."/www/assets/inc/header.php";
require dirname(__DIR__)."/www/assets/lib/class.Event.php";
?>

<?php
$event_id = $_REQUEST['event_id'];

$event = new Event();
$result = $event->singleEvent($event_id);
$thisEvent = $result->fetch_object();

echo "<h1>" . $thisEvent->title . "</h1>";
?>