<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.Event.php";
require __DIR__."/assets/lib/class.Display.php";
?>
<div class="headline">
    <text>Førstkommende arrangementer</text>
</div>

<?php
    $events = new Event();
    $results = $events->getEvents(10);

    $display = new Display();
    $display->displayCards($results);
?>