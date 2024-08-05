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
        // dd($obatitem);
        return view('iteminv', compact('obatitem'));

    }

    public function invuom()
    {
        $obatuom= UOM::all();
        // dd($obatuom);
        return view('uominv', compact('obatuom'));
    }

    // public function invstock()
    // {
    //     // with("item")->get(); 
    //     $obatstock = Stock::get();
    //     return view('iteminv', compact('obatstock'));
    // }
}
