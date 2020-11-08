<?php

namespace App\Http\Controllers;

use App\KitsItems;
use Illuminate\Http\Request;

class KitsItemsController extends Controller
{
    public function get(Request $request)
    {
        $kit = $request->kit;
        $items = KitsItems::where('kit', '=', $kit)->get();
        return response()->json($items, 200);
    }

    public function create(Request $request)
    {
        $kit = $request->kit;
        $game_name = $request->game_name;
        $count = $request->count;

        KitsItems::create([
            'kit' => $kit,
            'game_name' => $game_name,
            'count' => $count
        ]);

        return response()->json('', 200);
    }
}
