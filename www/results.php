<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.Event.php";
require __DIR__."/assets/lib/class.Display.php";
require __DIR__."/assets/inc/authenticate.php";
?>
<div class="main">
<div class="headline">
    <text>Søkeresultater</text>
</div>

<?php
    $query = $_GET['query'];

    $events = new Event();
    $results = $events->searchEvents($query);

    $display = new Display();
    $display->displayCards($results);
?>
</div>