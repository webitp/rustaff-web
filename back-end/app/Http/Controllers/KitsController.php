<?php

namespace App\Http\Controllers;

use App\Kits;
use App\KitsItems;
use Illuminate\Http\Request;

class KitsController extends Controller
{
    public function getAll(Request $request)
    {
        $kits = Kits::all();

        $res = [];
        foreach ($kits as $kit) 
        {
            array_push($res, [
                'id' => $kit->id,
                'name' => $kit->name,
                'cooldown' => $kit->cooldown,
                'category' => $kit->category,
                'items' => KitsItems::where('kit', '=', $kit->id)->get()
            ]);
        }

        return response()->json($res, 200);
    }

    public function create(Request $request)
    {
        $name = $request->name;
        $category = $request->category;
        $cooldown = $request->cooldown;

        Kits::create([
            'name' => $name,
            'category' => $category,
            'cooldown' => $cooldown
        ]);

        return response()->json('', 200);
    }
}
