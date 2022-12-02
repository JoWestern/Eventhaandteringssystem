<?php 
require __DIR__"/www/assets/inc/header.php";
require __DIR__."/assets/lib/class.Display.php";
require __DIR__."/assets/lib/class.Booking.php";
require __DIR__."/assets/inc/authenticate.php";
?>

<div class="main">
<div class="headline">
    <text>Arrangementer jeg deltar på</text>
</div>

<?php
    $bookings = new Booking();
    $results = $bookings->getBookings(5,2);

    $display = new Display();
    $display->displayCards($results);

?>
</div>