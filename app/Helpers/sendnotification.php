<?php
if (!function_exists('sendNotification')) {


function sendNotification($data) {
    $notifications = new App\Notification;
    $notifications->sender_id = $data['sender_id'];
    $notifications->message = $data['message'];
    $notifications->receiver_id = $data['receiver_id'];
    $notifications->save();
    return "success";    
 }
}
