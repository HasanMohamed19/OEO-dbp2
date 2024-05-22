<?php
    // temp file to test sending
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include 'debugging.php';
include 'header.php';

include './helpers/emailController.php';

EmailController::sendForgotPasswordEmail('oeobhr@gmail.com', 'abbas', '7564321');

include './template/footer.html';
?>