<?php
$to_email = "jtiagoviana@ipvc.pt";
$subject = "Test email to send from XAMPP";
$body = "Hi, This is test mail to check how to send mail from Localhost Using Gmail ";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";

if (mail($to_email, $subject, $body, $headers))

{
    echo "Email successfully sent to $to_email...";
}

else

{
    echo "Email sending failed!";
}