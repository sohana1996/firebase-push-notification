<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\FcmToken;
use Illuminate\Support\Facades\Auth;

class FirebaseController extends Controller
{
    protected $FIREBASE_API_KEY = 'AIzaSyCHjUBC1wzeGqPXpuNpsFHa3jJK10EgXlw';
    protected $FIREBASE_SERVER_KEY = 'AAAAY6kDyp8:APA91bGdaZl-jZdJlOFPQ2WIR8Vy3q3r68qj9P8VYrZEm6kGgHXyciCYxpxad_hdSM-uOtQXHlcSnKBbL2dfRt2XBSDTeVew0LKsQE0XJEP09Rk1RT21qfzEogENMfJN4UO8Z74BQ3zx';

    public function send($registration_ids, $message)
    {
        $fields = array(
            //'to' => $registration_ids,
            'registration_ids' => $registration_ids, // array send to registration_ids . fcm token
            'notification' => $message,
        );
        return $this->sendPushNotification($fields);

    }

    public function sendPushNotification($post)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $headers = [
            'Authorization:key=' . $this->FIREBASE_SERVER_KEY,
            'Content-Type:application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        }

    public function AddFcmToken(Request $request)
    {
        $userId = Auth::user()->id;
        $fcm_token = $request->fcm_token;
        $check = FcmToken::where('user_id', $userId)->first();
        if ($check) {
            FcmToken::where('user_id', $userId)->update(['user_id' => $userId, 'fcm_token' => $fcm_token]);
        } else {
            FcmToken::create(['user_id' => $userId, 'fcm_token' => $fcm_token]);
        }
        $tokens = FcmToken::all()->pluck('fcm_token')->toArray();

        $tokens = [$fcm_token];
        $data = [
            "title" => "FCM Register Successful",
            "body" => 'Test Notification',

        ];
        $this->send($tokens, $data);

        return response()->json(['status' => 'success']);
    }

}
