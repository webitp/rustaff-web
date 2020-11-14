<?php

namespace App\Http\Controllers;

use App\Bans;
use Illuminate\Http\Request;

class BansController extends Controller
{
    public function get(Request $request)
    {
        $bans = Bans::all();
        return response()->json($bans, 200);
    }
}
