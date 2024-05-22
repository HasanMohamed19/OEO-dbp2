<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of emailController
 *
 * @author Hassan
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailController {

    private static function createMailer(): PHPMailer {
        $mailer = new PHPMailer(true);

        $mailer->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mailer->isSMTP();                                            //Send using SMTP
        $mailer->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mailer->SMTPAuth = true;                                   //Enable SMTP authentication
        $mailer->Username = 'oeobhr@gmail.com';                     //SMTP username
        $mailer->Password = 'btvd buph qyow lppi';                               //SMTP password
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mailer->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


        $mailer->setFrom('oeobhr@gmail.com', 'OEO Bahrain');
        
        $mailer->isHTML(true);

        return $mailer;
    }

    public static function sendForgotPasswordEmail($recipient, $username, $verifyCode) {
        
        $mailer = EmailController::createMailer();
        $mailer->addAddress($recipient);     //Add a recipient
        
        $body = file_get_contents("./template/forgetPassword.html");
        $body = str_replace('{{username}}', $username, $body);
        $body = str_replace('{{verifyCode}}', $verifyCode, $body);
        
        $mailer->Subject = 'Forget Password';
        $mailer->Body    = $body;
        $mailer->send();
        echo 'Message has been sent';
        $mailer->clearAddresses();
    }
    
    public static function sendBookingReservationEmail($recipient, $username, $resId, $eventName, $startDate, $endDate, $startTime, $endTime, $audiences, $hallName, $totalPrice) {
        
        $mailer = EmailController::createMailer();
        $mailer->addAddress($recipient);     //Add a recipient
        
        $body = file_get_contents("./template/reservationEmail.html");
        $body = str_replace('{{username}}', $username, $body);
        $body = str_replace('{{resId}}', $resId, $body);
        $body = str_replace('{{eventName}}', $eventName, $body);
        $body = str_replace('{{startDate}}', $startDate, $body);
        $body = str_replace('{{endDate}}', $endDate, $body);
        $body = str_replace('{{startTime}}', $startTime, $body);
        $body = str_replace('{{endTime}}', $endTime, $body);
        $body = str_replace('{{audiences}}', $audiences, $body);
        $body = str_replace('{{hallName}}', $hallName, $body);
        $body = str_replace('{{totalPrice}}', $totalPrice, $body);
        
        $mailer->Subject = 'Successfull reservation';
        $mailer->Body    = $body;
        echo $body;
        $mailer->send();
        echo 'Message has been sent';
        $mailer->clearAddresses();
    }

}
