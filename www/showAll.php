<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/inc/authenticate.php";
require __DIR__."/assets/lib/class.Display.php";
require __DIR__."/assets/lib/class.Booking.php";
require __DIR__."/assets/lib/class.Event.php";

echo "<div class='main'>";

$user = $_SESSION['USER_ID'];

if($_REQUEST['key'] == 'guest'){
    echo "<div class='headline'>
    <text>Arrangementer jeg deltar på</text>
    </div>";
    
    $bookings = new Booking();
    $results = $bookings->getBookings(null, $user, true);

    $display = new Display();
    $display->displayCards($results);

    echo "<div class='headline'>
    <text>Fullførte arrangementer</text>
    </div>";
    
    $bookings = new Booking();
    $results = $bookings->getBookings(null, $user, false);

    $display = new Display();
    $display->displayCards($results);
}
elseif($_REQUEST['key'] == 'host'){
    echo "<div class='headline'>
    <text>Arrangementer jeg er vert for</text>
    </div>";

    $event = new Event();
    $results = $event->eventsByHost($user, null, true);

    $display = new Display();
    $display->displayCards($results);

    echo "<div class='headline'>
    <text>Fullførte arrangementer</text>
    </div>";

    $event = new Event();
    $results = $event->eventsByHost($user, null, false);

    $display = new Display();
    $display->displayCards($results);
}