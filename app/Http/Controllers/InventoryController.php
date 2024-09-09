<?php

namespace App\Http\Controllers;

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
        $obatitem = Item::with("UOM")->paginate(10);

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
        $translist = Transaction::get();

        foreach ($translist as $trans) {
            $trans->item = Item::where('id', $trans->item_id)->first();
        }

        foreach ($translist as $trans) {
            $trans->order = Order::where('id', $trans->order_id)->first();
        }
        // dd($trans);
        return view('transaction/transactionlist', compact('translist'));
    }

    public function totalin()
    {
        $today = Carbon::today();

        $totalin = Transaction::where('transaction_type', 'in')
        ->whereDate('created_at', $today)
        ->sum('qty');
        $totalout = Transaction::where('transaction_type', 'out')
        ->whereDate('created_at', $today)
        ->sum('qty');
        

        return view('home', compact('totalin', 'totalout'));
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






    public function userin(){
        $transactions = Transaction::whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get();
    
        $transactionsByOrderId = $transactions->groupBy('order_id');
    
        $data = [];
    
        foreach ($transactionsByOrderId as $orderId => $transactions) {
            $order = Order::find($orderId);
    
            $inTransactions = [];
            $outTransactions = [];
    
            foreach ($transactions as $transaction) {
                $item = Item::find($transaction->item_id);
    
                if ($transaction->transaction_type == 'IN') {
                    $inTransactions[] = [
                        'item_description' => $item->description, // Retrieve item description from Item model
                        'qty' => $transaction->qty,
                        'created_at' => $transaction->created_at,
                    ];
                } elseif ($transaction->transaction_type == 'OUT') {
                    $outTransactions[] = [
                        'item_description' => $item->description, // Retrieve item description from Item model
                        'qty' => $transaction->qty,
                        'created_at' => $transaction->created_at,
                    ];
                }
            }
    
            $data[] = [
                'department' => $order->department,
                'in_transactions' => $inTransactions,
                'out_transactions' => $outTransactions,
            ];
        }

    return view('report/reportuser', compact('data'));
    }

//$transactions->first()->item->name,
}