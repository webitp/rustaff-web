<?php

namespace App\Http\Controllers;

use App\User;
use App\Items;
use App\Purchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function create(Request $request)
    {
        $steamid = $request->steamid;
        $item_id = $request->item;
        $count = $request->count;

        Purchases::create([
            'steamid' => $steamid,
            'item' => $item_id,
            'count' => $count,
            'used' => false
        ]);

        $item = Items::where('id', '=', $item_id)->first();

        $user = User::where('steamid', '=', $steamid)->first();
        $user->money -= $item->price * $count;
        $user->save();

        return response('', 204);
    }

    public function list(Request $request)
    {
        $steamid = $request->steamid;
        $purchases = DB::select($this->getPlayerPurchasesQuery($steamid) . ' ORDER BY `created_at` DESC', [$steamid]);
        return response()->json($purchases, 200);
    }

    public function inventory(Request $request)
    {
        $steamid = $request->steamid;
        $purchases = DB::select($this->getPlayerPurchasesQuery($steamid) . ' AND t1.used = 0 ORDER BY `created_at` DESC', [$steamid]);
        return response()->json($purchases, 200);
    }

    private function getPlayerPurchasesQuery($steamid) {
        return 'SELECT t1.steamid, t1.item, t1.count, t1.used, t1.created_at, t2.name, t2.game_name, t2.price, t2.type FROM purchases AS t1 LEFT JOIN items as t2 ON t1.item = t2.id WHERE t1.steamid = ?';
    }
}
