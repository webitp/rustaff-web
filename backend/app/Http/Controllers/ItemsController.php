<?php

namespace App\Http\Controllers;

use Config;
use App\Items;
use App\Categories;
use Illuminate\Http\Request;

class ItemsController extends Controller
{

    public function list(Request $request)
    {
        $items = Items::orderBy('price', 'DESC')->get();
        return response()->json($items, 200);
    }

    public function create(Request $request)
    {
        if ($request->name) {
            Items::create([
                'category' => $request->category,
                'name' => $request->name,
                'game_name' => $request->game_name,
                'price' => $request->price,
                'count' => $request->count,
                'image' => $request->image,
                'type' => 0
            ]);
            $category = Categories::where('id', '=', $request->category)->first();
            $category->count += 1;
            $category->save();
            return response()->json('', 204);
        }
        return response()->json('', 400);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $item = Items::where('id', '=', $id);

            $category = Categories::where('id', '=', $item->first()->category)->first();
            $category->count -= 1;
            $category->save();

            $item->delete();

            return response()->json('', 204);
        }
        return response()->json('', 400);
    }

    public function payment(Request $request)
    {
        $shop = Config::get('payment.shop');
        $secret = Config::get('payment.secret');

        $sum = $request->sum;
        $account = $request->steamid;

        $signature = $this->getFormSignature($shop, $sum, $secret, $account);
        $url = 'https://www.free-kassa.ru/merchant/cash.php?m=' . $shop . '&oa=' . $sum . '&o=' . $account . '&s=' . $signature;
        
        return response()->json([
            'url' => $url
        ], 200);
    }

    private function getFormSignature($shop, $sum, $secret, $order) 
    {
        return md5($shop . ':' . $sum . ':' . $secret . ':' . $order);
    }
}
