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

class SummaryController extends Controller
{
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



    public function userIn(Request $request, $month)
    {
        session(['month' => $month]);
        // dd(session('month'));
        $currentMonthTransactions = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', date('Y'))
            ->where('transaction_type', 'OUT')
            ->get();
        $previousMonthTransactions = Transaction::whereMonth('created_at', date($month, strtotime('-1 month')))
            ->whereYear('created_at', date('Y'))
            ->where('transaction_type', 'OUT')
            ->get();
            $transactionsByOrderId = $currentMonthTransactions->merge($previousMonthTransactions)->groupBy('order_id');
            
            // $transactionsByOrderId = $currentMonthTransactions->groupBy('order_id');        

        $data = [];
        foreach ($transactionsByOrderId as $orderId => $transactions) {
            $order = Order::find($orderId);
            $outTransactions = [];
            foreach ($transactions as $transaction) {
                $item = Item::find($transaction->item_id);
                $outTransactions[] = [
                    'item_id' => $transaction->item_id,
                    'item_description' => $item->description,
                    'qty' => $transaction->qty,
                    'created_at' => $transaction->created_at,
                    'transaction_type' => $transaction->transaction_type,
                ];
            }
            $data[] = [
                'department' => $order->department,
                'out_transactions' => $outTransactions,
            ];
        }
        return view('report/reportuser', compact('data'));
    }
}
