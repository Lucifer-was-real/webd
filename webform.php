<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './mailer/PHPMailer.php';
require './mailer/Exception.php';
require './mailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];
    $uploadedFiles = $_FILES["upload"];

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yourgmail@gmail.com';
        $mail->Password   = 'your 16 digit app password';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('udaypspp@gmail.com', 'UdayPS');
        $mail->addAddress('bkicksreship@gmail.com');
        $mail->addAddress('infoscholarscribe@gmail.com');

        //Attachments
        for ($i=0; $i < count($uploadedFiles['name']); $i++) {
            $mail->addAttachment($uploadedFiles['tmp_name'][$i], $uploadedFiles['name'][$i]);
        }

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Information query';
        $mail->Body    = "Name: $name <br> Email: $email <br> Phone: $phone <br> Message: $message";

        $mail->send();
        echo 'FORM SUBMITTED';
        exit;
    } catch (Exception $e) {
        echo "ERROR : {$mail->ErrorInfo}";
    }
} else {
    echo "No form submitted.";
}
?>
