<?php

namespace App\Http\Controllers;

use App\Items;
use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function list(Request $request)
    {
        $categories = Categories::all();
        return response()->json($categories, 200);
    }

    public function create(Request $request)
    {
        if ($request->name) {
            Categories::create([
                'name' => $request->name
            ]);
            return response()->json('', 204);
        }
        return response()->json('', 400);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        if ($id) {
            Categories::where('id', '=', $id)->delete();
            Items::where('category', '=', $id)->delete();
            return response()->json('', 204);
        }
        return response()->json('', 400);
    }
}
