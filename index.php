<?php
    
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include './helpers/emailController.php';
include 'debugging.php';
EmailController::sendBookingReservationEmail('oeobhr@gmail.com', 'a', '1221', 'Light Weaver Lunch', '10/10/10', '20/20/20', '10:10', '20:20', 100, 'asasa', 100);
//$mail = new PHPMailer(true);
//
//try {
//    //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//    $mail->isSMTP();                                            //Send using SMTP
//    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
//    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//    $mail->Username   = 'oeobhr@gmail.com';                     //SMTP username
//    $mail->Password   = 'btvd buph qyow lppi';                               //SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
//
//    //Recipients
//    $mail->setFrom('oeobhr@gmail.com', 'Mailer');
//    $mail->addAddress('hzs2003@live.com');     //Add a recipient
////    $mail->addAddress('ellen@example.com');               //Name is optional
////    $mail->addReplyTo('info@example.com', 'Information');
////    $mail->addCC('cc@example.com');
////    $mail->addBCC('bcc@example.com');
//
//    //Attachments
////    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
////    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
//
//    //Content
//    $mail->isHTML(true);                                  //Set email format to HTML
//    $mail->Subject = 'Here is the subject';
//    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//    $mail->send();
//    echo 'Message has been sent';
//} catch (Exception $e) {
//    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//}
//
////session_start();
////setcookie('userId', '1', time() + 60 * 60 * 24 * 7, '/');
//
////echo 'This is cookie: '.$_COOKIE['userId'];
////echo 'This is session: '.$_SESSION['userId'];
    
include './template/header.html';
    
    echo '<div class="main"> </div>';

include './template/footer.html';
?>
