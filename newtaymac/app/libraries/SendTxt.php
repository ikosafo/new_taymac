<?php
class SendTxt {

    public static $key = 'BgTkONJeP5d4pyIU6uvVCC8PR';
    public static $sender= 'AHPC GH';
    public $message;
    public $phone;
    private $datatime;


public static function sendSMS($phone,$message)
{

   $url = "http://bulk.mnotify.net/smsapi?key=" . self::$key . "&to=" . $phone . "&msg=" . ($message) . "&sender_id=" . self::$sender;
  return $response = file_get_contents($url);
}

public static function sendSMSnew($phone,$message){

   $endPoint = 'https://api.mnotify.com/api/sms/quick';
   $apiKey = 'YOUR_API_KEY';
   $url = $endPoint . '?key=' . self::$key;
   $data = [
      'recipient' => $phone,
      'sender' => ''.self::$sender.'',
      'message' => ''.$message.'',
      'is_schedule' => 'false',
      'schedule_date' => ''
   ];

   $ch = curl_init();
   $headers = array();
   $headers[] = "Content-Type: application/json";
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
   $result = curl_exec($ch);
   $result = json_decode($result, TRUE);
   curl_close($ch);
   return $result;
}
}
