<?php

namespace App\Http\Controllers;

use App\User;
use App\Payments;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function make(Request $request)
    {
        $sum = $request->AMOUNT;
        $steamid = $request->MERCHANT_ORDER_ID;

        $user = User::where('steamid', '=', $steamid)->first();
        if ($user)
        {
            $user->money += $sum;
            $user->save();

            Payments::create([
                'steamid' => $steamid,
                'amount' => $sum
            ]);

            return $this->sendResponse(true);
        }
        return $this->sendResponse(false);
    }

    public function get(Request $request)
    {
        $steamid = $request->steamid;
        $payments = Payments::where('steamid', '=', $steamid)->orderBy('created_at', 'DESC')->get();
        return response()->json($payments, 200);
    }

    private function sendResponse($status)
    {
        return response()->json([
            'status' => $status
        ], 200);
    }
}
