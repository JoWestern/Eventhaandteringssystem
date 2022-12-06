<?php
require_once "../inc/PHPMailer.php";
require_once "../lib/class.Booking.php";
require_once "../lib/class.Event.php";

class Communicator{
    function editedUpdate($eventID){
        $bookings = new Booking();
        $results = $bookings->guestList($eventID);

        $event = new Event();
        $eventInfo = $event->singleEvent($eventID);
        $thisEvent = $eventInfo->fetch_object();

        $title = "Et arrangement som du er påmeldt har blitt endret";
        $content = "Kjære Arr!-bruker!<br><br>
                    Arrangementet du er påmeldt, $thisEvent->title, har blitt endret.<br><br>
                    <a href='http://localhost/eventhaandteringssystem/www/event.php?event_id=$eventID'>Klikk her</a> for å se endringene.<br><br>
                    Mvh Arr-teamet!";

        while($row = $results->fetch_assoc()) {
            sendMail($row['email'], $title, $content);
        }
    }
}