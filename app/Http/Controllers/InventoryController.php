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


    public function monthlyreport()
    {
        $transactions = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
        ->get()
        ->groupBy(function ($transaction) {
            return $transaction->created_at->format('Y-m-d');
        });

        $inQuantities = [];
        $outQuantities = [];
        $labels = [];

        foreach ($transactions as $date => $transactionsForDate) {
            $inQuantity = $transactionsForDate->where('transaction_type', 'IN')->sum('qty');
            $outQuantity = $transactionsForDate->where('transaction_type', 'OUT')->sum('qty');
    
            $inQuantities[] = $inQuantity;
            $outQuantities[] = $outQuantity;
            $labels[] = $date;
        }
        // dd($inQuantities,  $outQuantities, $labels);

        return view('report/report', compact('labels', 'inQuantities', 'outQuantities'));
        }


        public function all_item(){
            $transactions = Transaction::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();
        
            $items = $transactions->groupBy('item_id');
        
            $data = [];
            foreach($items as $item_id => $transactions)
            {
                if($transactions->first()->item !== null){

                    $item = Item::find($item_id);
                    $data[] = [
                    'item' => $transactions->first()->item->description, // access the name attribute of the item
                    'in' => $transactions->where('transaction_type', 'IN')->sum('qty'),
                    'out' => $transactions->where('transaction_type', 'OUT')->sum('qty'),
                    'balance' => $transactions->where('transaction_type', 'IN')->sum('qty') - $transactions->where('transaction_type', 'OUT')->sum('qty')
                    ];
                }
            }


            $transactions = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d');
            });

            $inQuantities = [];
            $outQuantities = [];
            $labels = [];

            foreach ($transactions as $date => $transactionsForDate) {
                $inQuantity = $transactionsForDate->where('transaction_type', 'IN')->sum('qty');
                $outQuantity = $transactionsForDate->where('transaction_type', 'OUT')->sum('qty');
        
                $inQuantities[] = $inQuantity;
                $outQuantities[] = $outQuantity;
                $labels[] = $date;
            }


            $startOfMonth = date('Y-m-01');
            $endOfMonth = date('Y-m-t');

            $stockIn = Transaction::where('transaction_type', 'IN')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('qty');

            $stockOut = Transaction::where('transaction_type', 'OUT')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('qty');

            $balance = $stockIn - $stockOut;


            
            return view('report/report', compact('data', 'labels', 'inQuantities', 'outQuantities', 'stockIn', 'stockOut', 'balance'));
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