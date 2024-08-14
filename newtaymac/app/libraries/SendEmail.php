<?php

use PHPMailer\PHPMailer\PHPMailer;

class SendEmail {

    public static $key = 'YOUR_SMS_API_KEY';
    public static $sender = 'AHPC GH';

    public static function firemail($senderemail, $receiveremail, $subject, $message, $customer, $atttach = true)
    {
        $error = 'Error';
        $success = 'Success';

        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;

        // Uncomment and configure the following lines as needed
        // $mail->SMTPSecure = 'tls';
        // $mail->Host = 'smtp.office365.com'; // or another SMTP host
        // $mail->Port = 587;
        // $mail->Username = 'YOUR_EMAIL_ADDRESS';
        // $mail->Password = 'YOUR_EMAIL_PASSWORD';

        $mail->SMTPSecure = 'tls'; 
        $mail->Host = 'smtp.office365.com'; 
        $mail->Port = 587;
        $mail->Username = 'no-reply@ahpc.gov.gh';
        $mail->Password = 'YOUR_EMAIL_PASSWORD'; 

        $mail->From = $senderemail;
        $mail->FromName = $customer;
        $mail->Sender = $senderemail;

        $mail->AddAddress($receiveremail);
        $mail->Subject = $subject;

        $mail->IsHTML(true);
        $mail->Body = $message;

        if (!$mail->Send()) {
            return $mail->ErrorInfo;
        } else {
            return $success;
        }
    }

    public static function compose($email, $subject, $message)
    {
        $customer = 'Allied Health Professions Council (AHPC)';
        return self::firemail('no-reply@ahpc.gov.gh', $email, $subject, $message, $customer, false);
    }

    public static function sendSMS($phone, $message)
    {
        $url = "http://bulk.mnotify.net/smsapi?key=" . self::$key . "&to=" . $phone . "&msg=" . urlencode($message) . "&sender_id=" . self::$sender;
        return $response = file_get_contents($url);
    }
}
