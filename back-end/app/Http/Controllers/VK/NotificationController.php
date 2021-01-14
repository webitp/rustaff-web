<?php

namespace App\Http\Controllers\VK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    private static $ACCESS_TOKEN = '40823a63bfe8bf13c3cbb5a24eb7792e70cbe3d250cf697964a4bdad5b8df5e09418ace25dc472e4ea97b';

    public function send(Request $request)
    {
        $chat_id = $request->chat_id;
        $message = $request->message;

        $message = str_replace(' ', '+', $message);

        return response()->json(self::query("messages.send", "chat_id=" . $chat_id . "&message=" . $message . "&random_id=" . rand(0, 1000)), 200);
    }

    private static function query($method, $params = '')
    {
        $path = "https://api.vk.com/method/" . $method . "?v=5.126&access_token=" . self::$ACCESS_TOKEN . "&" . $params;
        $curl = curl_init('https://api.vk.com/method/' . $method . '?v=5.126&access_token=' . self::$ACCESS_TOKEN . '&' . $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $path;
    }
}
