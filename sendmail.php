<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage("en", 'phpmailer/language/');
$mail->isHTML(true);

$mail->setFrom('admin.cms@ukr.net', 'Yevgeniy Storozhenko');
$mail->addAddress('admin.cms@ukr.net', 'User');

$mail->Subject = 'Hi! This is Yevgeniy Storozhenko';
$mail->Body = '<h1>This is the HTML message body <b>in bold!</h1></b>';

if (trim(!empty($_POST['firstname']))) {
    $body.='<p><strong>First Name:</strong> '.$_POST['firstname'].'</p>';
}
if (trim(!empty($_POST['lastname']))) {
    $body.='<p><strong>Last Name:</strong> '.$_POST['lastname'].'</p>';
}
if (trim(!empty($_POST['email']))) {
    $body.='<p><strong>Email:</strong> '.$_POST['email'].'</p>';
}
if (trim(!empty($_POST['message']))) {
    $body.='<p><strong>Message:</strong> '.$_POST['message'].'</p>';
}

if (!empty($_FILES['image']['tmp_name'])) {
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    if (copy($_FILES['image']['tmp_name'], $filePath)) {
        $fileAttach = $filePath;
        $body.='<p><strong>This is photo insert</strong></p>';
        $email->addAttachment($fileAttach);
    }
}
    $mail->Body = $body;

    if (!$mail->send()) {
    $message = 'Error';
    } else {
    $message = 'Data send';
    }
    
    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);

    ?>