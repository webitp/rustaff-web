<?php

namespace App\Http\Controllers;

use App\User;
use App\Items;
use App\Purchases;
use App\RulletItems;
use App\RulletAccesses;
use Illuminate\Http\Request;

class RulletController extends Controller
{
    public function items(Request $request)
    {
        return response()->json(RulletItems::all(), 200);
    }

    public function add(Request $request)
    {
        $name = $request->name;
        $constant = $request->constant;
        $type = $request->type;
        $image = $request->image;

        RulletItems::create([
            'name' => $name,
            'is_constant' => $constant,
            'type' => $type,
            'image' => $image
        ]);

        return response()->json('', 200);
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $item = RulletItems::where('id', '=', $id);
        $item->delete();

        return response()->json('', 200);
    }

    public function predict(Request $request)
    {
        $items = $request->items;
        $len = count($items);

        $value = rand(0, 100);
        $item = 0;
        $other = 0;

        if ($value == 0)
            $item = $items[0];
        else if ($value > 0 && $value < 20)
        {
            $item = $items[1];
            $other = rand(0, 1);
        }
        else
        {
            $indexItem = rand(2, $len - 3);
            if ($indexItem == 2)
                $other = rand(30, 300);
            $item = $items[$indexItem];
        }

        return response()->json([
            'item' => $item,
            'other' => $other
        ], 200);
    }

    public function access(Request $request)
    {
        $steamid = $request->steamid;
        $access = RulletAccesses::where([['steamid', '=', $steamid], ['used', '=', 0]])->first();
        if ($access)
            return response()->json($access, 200);
        return response()->json(false, 200);
    }

    public function givePrize(Request $request)
    {
        $steamid = $request->steamid;
        $type = $request->type;
        $name = $request->name;

        if ($type == 1) 
        {
            $item = Items::where('game_name', '=', $name)->first();
            Purchases::create([
                'steamid' => $steamid,
                'item' => $item->id,
                'count' => 1,
                'type' => 2,
                'used' => false
            ]);
        }
        if ($type == 2) 
        {
            Purchases::create([
                'steamid' => $steamid,
                'item' => 0,
                'count' => 1,
                'type' => 2,
                'hidden' => 1,
                'used' => false
            ]);
        }
        if ($type == 3) 
        {
            $privilegies = Items::where('type', '=', 1)->get();
            $privilege = $privilegies[$request->param];
            Purchases::create([
                'steamid' => $steamid,
                'item' => $privilege->id,
                'count' => 1,
                'type' => 2,
                'used' => false
            ]);
        }
        if ($type == 4) 
        {
            $user = User::where('steamid', '=', $steamid)->first();
            $user->money += $request->param;
            $user->save();
        }

        return response()->json('OK', 200);
    }

    public function setSkinState(Request $request)
    {
        $purchase = Purchases::where('steamid', '=', $request->steamid)->orderBy('id', 'DESC')->first();
        $purchase->used = $request->state;
        $purchase->save();
    }

    public function use(Request $request)
    {
        $steamid = $request->steamid;
        $access = RulletAccesses::where('steamid', '=', $steamid)->update(['used' => true]);
        return response()->json($access, 200);
    }
}
