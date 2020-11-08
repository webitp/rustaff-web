<?php

namespace App\Http\Controllers;

use App\Statistic;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function statistic(Request $request)
    {
        $steamid = $request->steamid;
        $data = Statistic::where('steamid', '=', $steamid)->first();

        return response()->json($data, 200);
    }
}
