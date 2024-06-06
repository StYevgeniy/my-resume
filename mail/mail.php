<?php 

require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';

$lastname = $_POST['user_lastname'];
$firstname = $_POST['user_firstname'];
$phone = $_POST['user_phone'];
$email = $_POST['user_email'];
$message = $_POST['user_message'];

$mail->SMTPDebug = 2;                               // Enable verbose debug output

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'styevgen@gmail.com';
$mail->Password = 'qezvsqailbfxzhsh';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('styevgen@gmail.com');
$mail->addAddress('styevgen@gmail.com');

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Application from the site https://portfolio.cms.biz.ua';
$mail->Body    = '<p><strong>First Name:</strong> ' .$firstname . '<p><strong>Last Name:</strong> ' .$lastname. '<p><strong>Email:</strong> ' .$email. '<p><strong>Phone:</strong> ' .$phone. '<p><strong>Message:</strong> ' .$message;
$mail->AltBody = '';

if(!$mail->send()) {
    echo 'Error';
} else {
    header('location: thank-you.html');
}
?>