<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.Display.php";
require __DIR__."/assets/lib/class.Booking.php";
require __DIR__."/assets/lib/class.Event.php";
require __DIR__."/assets/inc/authenticate.php";
?>

<div class="main">
<div class="headline">
<a href='showAll.php?key=guest'><text>Arrangementer jeg deltar på (trykk for å vise alle)</text></a>
</div>

<?php
    $user = $_SESSION['USER_ID'];
    
    $bookings = new Booking();
    $results = $bookings->getBookings(5, $user, true);

    $display = new Display();
    $display->displayCards($results);
?>

<br>
<div class="headline">
    <a href='showAll.php?key=host'><text>Arrangementer jeg er vert for (trykk for å vise alle)</text></a>
</div>

<?php
    $user = $_SESSION['USER_ID'];
    
    $event = new Event();
    $results = $event->eventsByHost($user, 5, true);

    $display = new Display();
    $display->displayCards($results);
?>
</div>