<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendMail($address, $title, $content){
    $mail = new PHPMailer(true);

    try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'uiaphp2022@gmail.com';                     //SMTP username
    $mail->Password   = 'rukvqxvnfuqhynoi';                               //SMTP password
    $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
    $mail->Port       = "587";                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('uiaphp2022@gmail.com', 'Arr!');
    $mail->addAddress($address);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $title;
    $mail->Body    = $content;
    $mail->AltBody = $content;

    $mail->send();
    // echo 'Melding sendt';
} catch (Exception $e) {
    echo "Melding kunne ikke bli sendt. Mailer Error: {$mail->ErrorInfo}";
}
}