<?php
$to_email = "jtiagoviana@ipvc.pt";
$subject = "Test email to send from XAMPP";
$body = "Hi, This is test mail to check how to send mail from Localhost Using Gmail ";
$headers = "sirtp_dev@sapo.pt";

if (mail($to_email, $subject, $body, $headers))

{
    echo "Email successfully sent to $to_email...";
}

else

{
    echo "Email sending failed!";
}