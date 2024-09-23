<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Datatables;
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
            $item->stock = optional(Stock::where('item_id', $item->id)->first())->qty ?? 0;
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




    public function totalIn()
    {
        $today = Carbon::today();
        $totalIn = Transaction::where('transaction_type', 'IN')
            ->whereDate('created_at', $today)
            ->sum('qty');
        $totalOut = Transaction::where('transaction_type', 'OUT')
            ->whereDate('created_at', $today)
            ->sum('qty');
        $total = Stock::sum('qty');
        $balance = $this->getBalance();
        $labels = $this->getTransactionLabels();
        $inQuantities = $this->getInQuantities();
        $outQuantities = $this->getOutQuantities();
        $todayTransactions = $this->todaysData();
        return view('home', compact('totalIn', 'totalOut', 'total', 'balance', 'labels', 'inQuantities', 'outQuantities', 'todayTransactions'));
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

    private function todaysData()
    {
        $today = Carbon::today();
        $todayTransactions = Transaction::whereDate('created_at', $today)
            ->get();
        foreach ($todayTransactions as $trans) {
            $trans->item = Item::where('id', $trans->item_id)->first();
        }
        foreach ($todayTransactions as $trans) {
            $trans->order = Order::where('id', $trans->order_id)->first();
        }
        return $todayTransactions;
    }







//$transactions->first()->item->name,
}