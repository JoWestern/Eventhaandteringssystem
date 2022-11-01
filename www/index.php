<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.Event.php";
require __DIR__."/assets/lib/class.Display.php";
?>
<div class="headline">
    Velkommen til Arr!
</div>

<?php
    $events = new Event();
    $results = $events->getAllEvents();

    $display = new Display();
    $display->displayCards($results);
?>