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
        $obatitem = Item::with("UOM");

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











    private function getStockIn()
    {
        $today = Carbon::today();
    
        return Transaction::where('transaction_type', 'IN')
            ->whereDate('created_at', $today)
            ->sum('qty');
    }
    
    private function getStockOut()
    {
        $today = Carbon::today();
    
        return Transaction::where('transaction_type', 'OUT')
            ->whereDate('created_at', $today)
            ->sum('qty');
    }
    
    private function getBalance()
    {
        $stockIn = $this->getStockIn();
        $stockOut = $this->getStockOut();
    
        return $stockIn - $stockOut;
    }

    private function getTransactionLabels()
    {
        $transactions = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d');
            });
    
        $labels = [];
        foreach ($transactions as $date => $transactionsForDate) {
            $labels[] = $date;
        }
    
        return $labels;
    }

    private function getInQuantities()
    {
        $transactions = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d');
            });
    
        $inQuantities = [];
        foreach ($transactions as $date => $transactionsForDate) {
            $inQuantities[] = $transactionsForDate->where('transaction_type', 'IN')->sum('qty');
        }
    
        return $inQuantities;
    }
    
    private function getOutQuantities()
    {
        $transactions = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d');
            });
    
        $outQuantities = [];
        foreach ($transactions as $date => $transactionsForDate) {
            $outQuantities[] = $transactionsForDate->where('transaction_type', 'OUT')->sum('qty');
        }
    
        return $outQuantities;
    }

    private function todaysdata()
    {
        $today = Carbon::today();

        $todaytransactions = Transaction::whereDate('created_at', $today)
        ->get();

        foreach ($todaytransactions as $trans) {
            $trans->item = Item::where('id', $trans->item_id)->first();
        }

        foreach ($todaytransactions as $trans) {
            $trans->order = Order::where('id', $trans->order_id)->first();
        }

        return $todaytransactions;

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
        $total = Stock::sum('qty');

        $balance = $this->getBalance();
        $labels = $this->getTransactionLabels();
        $inQuantities = $this->getInQuantities();
        $outQuantities = $this->getOutQuantities();
        $todaytransactions = $this->todaysdata();

        return view('home', compact('totalin', 'totalout', 'total', 'balance', 'labels', 'inQuantities', 'outQuantities','todaytransactions'));
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



    public function userin(Request $request, $month)
    {
        session(['month' => $month]);

        $transactions = Transaction::whereMonth('created_at', $month)
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