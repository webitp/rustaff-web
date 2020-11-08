<?php

namespace App\Http\Controllers;

use Config;
use App\User;
use App\Payments;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function make(Request $request)
    {
        $shop = Config::get('payment.shop');
        $secret = Config::get('payment.secret');

        $sum = $request->AMOUNT;
        $steamid = $request->MERCHANT_ORDER_ID;
        $signature = $request->SIGN;

        $user = User::where('steamid', '=', $steamid)->first();
        if ($user)
        {
            $user->money += $sum;
            $user->save();

            Payments::create([
                'steamid' => $steamid,
                'amount' => $sum
            ]);

            return $this->sendResponse('YES');
        }
        return $this->sendResponse('NO');
    }

    public function get(Request $request)
    {
        $steamid = $request->steamid;
        $payments = Payments::where('steamid', '=', $steamid)->orderBy('created_at', 'DESC')->get();
        return response()->json($payments, 200);
    }

    private function sendResponse($status)
    {
        return response()->json($status, 200);
    }

    private function getFormSignature($shop, $sum, $secret, $order) 
    {
        return md5($shop . ':' . $sum . ':' . $secret . ':' . $order);
    }
}
