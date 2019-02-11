<?php

if(!isset($_POST['name'])||!isset($_POST['email'])||!isset($_POST['message'])){
    echo "FATAL";
    exit;
}

#Submit button press check
if (isset($_POST['submit']))
{
    #PHPMailer initialization
    include_once('../PHPMailer/class.phpmailer.php');
    require_once('../PHPMailer/class.smtp.php');


    #Aquiring User's Credentials   
    $name = ($_POST['name']);
    $email =  ($_POST['email']);
    $msg =  ($_POST['message']);

    #Php mail setup
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host       = "ssl://smtp.gmail.com"; // SMTP server          
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
    $mail->SMTPSecure = 'ssl';
    $mail->Username   = "park.reportbug@gmail.com"; // SMTP account username 
    $mail->Password   = "tmbpark2019";        // SMTP account password 
    $mail->From = $email;
    $mail->FromName = "no-reply@park.com";
    $mail->AddAddress($email); 
    $mail->IsHTML(true);
    $mail->Subject = 'Park Bug Report';
    $mail->Body    =  'Dear '.$name.',<br>Your message:"<b> '.$msg.' </b>" has been sent to one of our administrators and is currently waiting to be reviewed! Thank you for making Park better.';


    #Error Message Display Info
    if(!$mail->Send())
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    exit;

}
