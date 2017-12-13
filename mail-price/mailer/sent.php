<?php

require_once 'Exception.php';
require_once 'OAuth.php';
require_once 'PHPMailer.php';
require_once 'POP3.php';
require_once 'SMTP.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'meshkova.natalia7';
$mail->Password = '09091995N';
$mail->Host = 'tls://smtp.gmail.com:587';
$mail->setFrom('meshkova.natalia7@gmail.com');
$mail->addAddress('mieshkova.nataliia@itruck.com.ua');
$mail->addAddress('meshkovanatalia00@gmail.com');


$mail->isHTML(true);
$mail->Subject = 'Заголовок';
$mail->Body = 'Текст письма';

if(!$mail->send()) {
echo 'Message could not be sent.';
echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
echo 'ok';
}