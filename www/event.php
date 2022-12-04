<?php 
require dirname(__DIR__)."/www/assets/inc/header.php";
require dirname(__DIR__)."/www/assets/lib/class.Event.php";
require dirname(__DIR__)."/www/assets/lib/class.Booking.php";
require dirname(__DIR__)."/www/assets/lib/class.Display.php";
require __DIR__."/assets/inc/authenticate.php";
?>

<?php
$eventID = $_REQUEST['event_id'];
$userID = $_SESSION['USER_ID'];

$event = new Event();
$result = $event->singleEvent($eventID);
$thisEvent = $result->fetch_object();

$booking = new Booking();

$dateFormat = new Display();
$datetimeStart = new DateTimeImmutable($thisEvent->time);
$formattedStart = $dateFormat->formatDatetime($datetimeStart);

if($thisEvent->endtime == null) $dateTimeEnd = "";
else {
    $datetimeEnd = new DateTimeImmutable($thisEvent->endtime);
    $formattedEnd = $dateFormat->formatDatetime($datetimeEnd);
}

if(file_exists($thisEvent->img_path)) $img = $thisEvent->img_path;
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
            <strong>Nettside:<br></strong> <a href='$thisEvent->website' target='_blank'>$thisEvent->website</a><br><br>";
            
            if($thisEvent->host == $_SESSION['USER_ID']){
                echo 
                "<form method='post' action='editevent.php'>
                <input type='hidden' name='eventID' value='$eventID'>
                    <input type='submit' value='Rediger' />
                </form>
                <form method='post'>
                <input type='hidden' name='eventID' value='$eventID'>
                    <input type='submit' name='delete' value='Slett' />
                </form>";
            }
            elseif($booking->checkBooking($userID, $eventID)){
                echo 
                "<form method='post' action='booking.php'>
                    <input type='hidden' name='action' value='unregister'>
                    <input type='hidden' name='user' value='$userID'>
                    <input type='hidden' name='event' value='$eventID'>
                    <input type='submit' value='Meld av!' />
                </form>";
            }
            else echo
                "<form method='post' action='booking.php'>
                    <input type='hidden' name='action' value='register'>
                    <input type='hidden' name='user' value='$userID'>
                    <input type='hidden' name='event' value='$eventID'>
                    <input type='submit' value='Meld på!' />
                </form>";
            
            if (isset($_POST["delete"])) {
                echo "Arrangementet ble slettet";
            }
        
        echo
        "</div>
    </div>
    <div class='event-page-content-bottom'>
    
    
    </div>
</div>";

?>