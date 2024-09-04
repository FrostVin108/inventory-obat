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
        $obatitem = Item::with("UOM")->paginate(10);

        // $posts = Post::paginate(10); // Paginate by 10 items per page
    
        foreach ($obatitem as $item) {
            $item->stock = Stock::where('item_id', $item->id)->first();
        }
        // dd($stock);
        return view('iteminv', compact('obatitem'));

    }

    public function invuom()
    {
        $obatuom= UOM::all();
        // dd($obatuom);
        return view('uominv', compact('obatuom'));
    }

    public function transactionlist()
    {
        $translist = Transaction::get();

        foreach ($translist as $trans) {
            $trans->item = Item::where('id', $trans->item_id)->first();
        }
        // dd($trans);
        return view('transactionlist', compact('translist'));
    }


    
    public function getSuppliesQty()
    {
        $stocks = Stock::with('item')->get();
        $data = [];
        foreach ($stocks as $stock) {
            $data[] = [
                'label' => $stock->item->description,
                'qty' => $stock->qty
            ];
        }
        return response()->json($data);
    }

}
