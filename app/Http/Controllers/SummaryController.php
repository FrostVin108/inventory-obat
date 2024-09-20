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
use DateTime;
use Barryvdh\DomPDF\Facade\PDF;

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

    private function userInDataPrint(Request $request, $month)
    {
        session(['month' => $month]);
        $currentMonthTransactions = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', date('Y'))
            ->where('transaction_type', 'OUT')
            ->get();

            $date = new DateTime();
            $date->setDate(date('Y'), $month, 1);
            $date->modify('first day of previous month');
            $previousMonth = $date->format('m');
            $previousYear = $date->format('Y');

        $previousMonthTransactions = Transaction::whereMonth('created_at', $previousMonth)
        ->whereYear('created_at', $previousYear)
        ->where('transaction_type', 'OUT')
        ->get();


        $transactionsByOrderId = $currentMonthTransactions->merge($previousMonthTransactions)->groupBy('order_id');

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

    return $data;
}

    public function userPrint( $month)
        {
    // Get the data for the selected month
    $data = $this->userInDataPrint(request(), $month);

    // Create a new PDF instance
    $pdf = PDF::loadView('/report/reportuserprint', compact('data', 'month'));
    
    // Return the PDF response
    return $pdf->stream('report-' . $month . '.pdf');

        }
    





    public function userIn(Request $request, $month)
    {
        session(['month' => $month]);
        $currentMonthTransactions = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', date('Y'))
            ->where('transaction_type', 'OUT')
            ->get();
    
        $date = new DateTime();
        $date->setDate(date('Y'), $month, 1);
        $date->modify('first day of previous month');
        $previousMonth = $date->format('m');
        $previousYear = $date->format('Y');
    
        $previousMonthTransactions = Transaction::whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->where('transaction_type', 'OUT')
            ->get();
    
        $currentMonthData = [];
        $previousMonthData = [];
    
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
    
        foreach ($previousMonthTransactions as $transaction) {
            $item = Item::find($transaction->item_id);
            $previousMonthData[] = [
                'item_id' => $transaction->item_id,
                'item_description' => $item->description,
                'qty' => $transaction->qty,
                'created_at' => $transaction->created_at,
                'transaction_type' => $transaction->transaction_type,
            ];
        }
    
        return view('report/reportuser', compact('currentMonthData', 'previousMonthData', 'data'));
    }
}
}