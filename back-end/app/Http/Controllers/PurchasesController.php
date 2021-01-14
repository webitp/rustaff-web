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
            'used' => false,
            'type' => 0
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
        $purchases = DB::select($this->getPlayerPurchasesQuery($steamid) . ' AND t1.hidden = 0 ORDER BY `created_at` DESC', [$steamid]);
        return response()->json($purchases, 200);
    }

    public function inventory(Request $request)
    {
        $steamid = $request->steamid;
        $purchases = DB::select($this->getPlayerPurchasesQuery($steamid) . ' AND (t1.used = 0 OR t1.hidden = 1) ORDER BY `created_at` DESC', [$steamid]);
        return response()->json($purchases, 200);
    }

    private function getPlayerPurchasesQuery($steamid) {
        return 'SELECT t1.steamid, t1.item, t1.count, t1.used, t1.created_at, t1.type as purchase_type, t2.name, t2.game_name, t2.price, t2.type, t2.image, t2.count as item_count FROM purchases AS t1 LEFT JOIN items as t2 ON t1.item = t2.id WHERE t1.steamid = ?';
    }
}
