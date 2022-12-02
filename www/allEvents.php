<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.Event.php";
require __DIR__."/assets/lib/class.Display.php";
require __DIR__."/assets/inc/authenticate.php";
?>
<div class="main">
<div class="headline">
    <text>Alle arrangementer</text>
</div>

<?php
    $events = new Event();
    $results = $events->getEvents(null, true);

    $display = new Display();
    $display->displayCards($results);
?>
</div>