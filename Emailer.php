<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function Send_Email_to($recv, $content,$subject)
{


    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();  //Send using SMTP
        // $mail->Mailer = "smtp";                                          
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Port       = '465';
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "ilisi.store2021@gmail.com";
        $mail->Password   = "admin2021";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->IsHTML(true);
        $mail->AddAddress($recv);
        $mail->SetFrom("ilisi.store2021@gmail.com", "RW");
        $mail->addReplyTo("ilisi.store2021@gmail.com", "RW");
        //$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
        $mail->Subject = $subject;
        $mail->msgHTML($content);
        $mail->send();
        echo 'Message has been sent';
    } 
    catch (Exception $e) 
    {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function Send_Login_to($recv,$login)
{
    $body="votre compte a ete activer dans RWstore voici votre login:<b>$login<b>";
    $subject="RWstore compte";
    Send_Email_to($recv,$body,$subject);
}
?>
