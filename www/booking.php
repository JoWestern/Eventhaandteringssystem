<?php 
require dirname(__DIR__)."/www/assets/inc/header.php";
require __DIR__."/assets/inc/authenticate.php";
require __DIR__."/assets/lib/class.Booking.php";
require __DIR__."/assets/lib/class.Event.php";
require __DIR__."/assets/lib/class.Display.php";
?>

<div class='main'>
<?php
$booking = new Booking();
$event = new Event();
$display = new Display();

if($_POST['action'] == 'register'){
    $booking->addBooking($_POST['user'], $_POST['event']);
    
    $result = $event->singleEvent($_POST['event']);
    $thisEvent = $result->fetch_object();
    
    echo "Du er nå påmeldt dette arrangementet!<br><br>";

    $datetime = new DateTimeImmutable($thisEvent->time);
    $datetimeFormatted = $display->formatDatetime($datetime);

    echo
    "$thisEvent->title<br>
    $datetimeFormatted
    ";
}
elseif($_POST['action'] == 'unregister'){
    $booking->cancelBooking($_POST['user'], $_POST['event']);
    
    $result = $event->singleEvent($_POST['event']);
    $thisEvent = $result->fetch_object();
    
    echo "Du er nå meldt av dette arrangementet!<br><br>";

    $datetime = new DateTimeImmutable($thisEvent->time);
    $datetimeFormatted = $display->formatDatetime($datetime);

    echo
    "$thisEvent->title<br>
    $datetimeFormatted
    ";
}
?>
</div>