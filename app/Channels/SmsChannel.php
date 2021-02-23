<?php
namespace App\Channels;

use App\Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toSms($notifiable);
        $mobile_number=$data['mobile_number'];
        $message=$data['message'];
        $api = new \App\Ghasedak\GhasedakApi(env('SMS_API_KEY' , ''));
        try {
            $result=$api->SendSimple($mobile_number, $message, env('SMS_API_LINE' , ''));
        } catch (\Exception $e) {
        }
    }
}
