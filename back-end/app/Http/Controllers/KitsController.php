<?php

namespace App\Http\Controllers;

use App\Kits;
use Illuminate\Http\Request;

class KitsController extends Controller
{
    public function getAll(Request $request)
    {
        $kits = Kits::all();
        return response()->json($kits, 200);
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
