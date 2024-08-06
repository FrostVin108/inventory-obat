<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\UOM;
use App\Models\User;

class InventoryController extends Controller
{
    public function invobat()
    {
        $obatitem = Item::with("UOM")->get();

        $stock = [];
        foreach ($obatitem as $item) {
            $stock[] = Stock::where('item_id', $item->id)->first();
        }
        // dd($stock);
        return view('iteminv', compact('obatitem', 'stock'));

    }

    public function invuom()
    {
        $obatuom= UOM::all();
        // dd($obatuom);
        return view('uominv', compact('obatuom'));
    }
}
