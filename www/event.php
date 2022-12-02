<?php 
require dirname(__DIR__)."/www/assets/inc/header.php";
require dirname(__DIR__)."/www/assets/lib/class.Event.php";
require dirname(__DIR__)."/www/assets/lib/class.Display.php";
require __DIR__."/assets/inc/authenticate.php";
?>

<?php
$event_id = $_REQUEST['event_id'];

$event = new Event();
$result = $event->singleEvent($event_id);
$thisEvent = $result->fetch_object();

$dateFormat = new Display();
$datetimeStart = new DateTimeImmutable($thisEvent->time);
$formattedStart = $dateFormat->formatDatetime($datetimeStart);

if($thisEvent->endtime == null) $dateTimeEnd = "";
else {
    $datetimeEnd = new DateTimeImmutable($thisEvent->endtime);
    $formattedEnd = $dateFormat->formatDatetime($datetimeEnd);
}

if(file_exists("assets/img/event" . $thisEvent->event_id . ".jpg")) $img = "assets/img/event" . $thisEvent->event_id . ".jpg";
else $img = "assets/img/stock.png";

echo 
"<div class='event-page main'>
    <div class='event-page-title'>
        <h1>" . $thisEvent->title . "</h1>
    </div>
    <div class='event-page-content-middle'>
        <div class='event-page-img'>
            <img src='" . $img . "' alt='Arrangementsbilde'>
        </div>
        <div class='event-page-content-right'>
            <strong>Vert:<br></strong> $thisEvent->first_name $thisEvent->last_name<br><br>
            <strong>Informasjon:<br></strong> $thisEvent->info<br><br>
            <strong>Sted:<br></strong> $thisEvent->location<br><br>
            <strong>Tid:<br></strong> $formattedStart<br><br>
            <strong>Kategori:<br></strong> $thisEvent->name<br><br>
            <strong>Sluttid:<br></strong> $formattedEnd<br><br>
            <strong>Pris:<br></strong> $thisEvent->ticketprice<br><br>
            <strong>Nettside:<br></strong> <a href='$thisEvent->website'>$thisEvent->website</a><br><br>
            <form action=''>
                <input type='submit' value='Meld på!' />
            </form>
        </div>
    </div>
    <div class='event-page-content-bottom'>
    
    
    </div>
</div>";
?>