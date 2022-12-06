<?php

require_once "./assets/inc/PHPMailer.php";
require_once "./assets/lib/class.Booking.php";
require_once "./assets/lib/class.Event.php";

$eventID = 3;

$bookings = new Booking();
$results = $bookings->guestList($eventID);

$event = new Event();
$eventInfo = $event->singleEvent($eventID);
$thisEvent = $eventInfo->fetch_object();

$title = "Et arrangement som du er påmeldt har blitt endret";
$content = "Kjære Arr!-bruker!<br><br>
            Arrangementet du er påmeldt, $thisEvent->title, har blitt endret.<br><br>
            <a href='http://localhost/eventhaandteringssystem/www/event.php?event_id=$eventID' target='_blank'>Klikk her</a> for å se endringene.<br><br>
            Mvh Arr-teamet!";

while($row = $results->fetch_assoc()) {
    sendMail($row['email'], $title, $content);
}