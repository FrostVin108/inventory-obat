<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\Datatables;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\UOM;
use App\Models\User;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function invobat()
    {
        $obatitem = Item::with("UOM")
        ->get();

        // $posts = Post::paginate(10); // Paginate by 10 items per page
    
        foreach ($obatitem as $item) {
            $item->stock = Stock::where('item_id', $item->id)->first();
        }
        // dd($stock);
        return view('obitem/iteminv', compact('obatitem'));

        

    }

    public function invuom()
    {
        $obatuom= UOM::all();
        // dd($obatuom);
        return view('uom/uominv', compact('obatuom'));
    }

    public function transactionlist()
    {
        $translist = Transaction::get(); // Execute the query to fetch the data
        
        foreach ($translist as $trans) {
            $trans->item = Item::where('id', $trans->item_id)->first();
        }
    
        foreach ($translist as $trans) {
            $trans->order = Order::where('id', $trans->order_id)->first();
        }
    
        return DataTables::of($translist)
            ->addColumn('action', function ($row) use ($translist) {
                return view('transaction/transactionlist', compact('translist'));
            })
            ->make(true);
        // dd($trans);

                // return view('transaction/transactionlist', compact('translist'));
    }

    public function transactionlistview()
    {
        $translist = Transaction::get(); // Execute the query to fetch the data
        // dd($translist);
        return view('transaction/transactionlist', compact('translist'));
    }











//$transactions->first()->item->name,
}