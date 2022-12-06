<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

require_once('assets/inc/pdf/fpdf/fpdf.php');
require_once('assets/inc/pdf/FPDI/src/autoload.php');
require_once __DIR__."/assets/lib/class.Booking.php";
require_once __DIR__."/assets/lib/class.Event.php";
require_once __DIR__."/assets/lib/class.User.php";

$eventID = $_POST["eventID"];
$bookings = new Booking();
$results = $bookings->guestList($eventID);

$events = new Event();
$thisEvent = $events->singleEvent($eventID);
$eventInfo = $thisEvent->fetch_assoc();

$users = new User();


$offset = 0;

$pdf = new Fpdi();
$source = ('assets/gjesteliste.pdf');

$pdf->AddPage();
$pdf->setSourceFile($source);

//importerer en side 
$tplIdx = $pdf->importPage(1);

//den importerte siden blir brukt som mal for ny pdf
$pdf->useTemplate($tplIdx);

//spesifisere font verdier
$pdf->SetFont('Arial','',10);

while($row = $results->fetch_assoc()) {
    $firstname = $row['first_name'];
    $lastname = $row['last_name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $title = $eventInfo['title'];
    $host = $eventInfo['host'];
    $location = $eventInfo['location'];
    $startdate = $eventInfo['time'];
    $enddate = $eventInfo['endtime'];

    $hostUser = $users->getUserInfo($host);
    $eventHost = $hostUser->fetch_assoc();
    $vert = $eventHost['first_name'] . " " . $eventHost['last_name'];

//title
$pdf->SetXY(75, 25);
$pdf->Write(0, $title);

//vert
$pdf->SetXY(40, 30);
$pdf->MultiCell(0, 6, "\n $vert \n $location \n $startdate - $enddate");

//fornavn
$pdf->SetXY(30, (96 + $offset));
$pdf->Write(0, $firstname);

//etternavn
$pdf->SetXY(70, (96 + $offset));
$pdf->Write(0, $lastname);

//epost
$pdf->SetXY(112, (96 + $offset));
$pdf->Write(0, $email);

//mobilnummer
$pdf->SetXY(155, (96 + $offset));
$pdf->write(0, $phone);

$offset += 12;
}
$pdf->Output();

?>