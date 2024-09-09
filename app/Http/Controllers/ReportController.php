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

class ReportController extends Controller
{
    public function all_item()
    {
        $data = $this->getItemsData();
        $labels = $this->getTransactionLabels();
        $inQuantities = $this->getInQuantities();
        $outQuantities = $this->getOutQuantities();
        $stockIn = $this->getStockIn();
        $stockOut = $this->getStockOut();
        $balance = $this->getBalance();
        $transactions = $this->getTransactions();
    
        return view('report/report', compact('data', 'labels', 'inQuantities', 'outQuantities', 'stockIn', 'stockOut', 'balance', 'transactions'));
    }
    
    private function getItemsData()
    {
        $transactions = Transaction::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();
    
        $items = $transactions->groupBy('item_id');
    
        $data = [];
        foreach ($items as $item_id => $transactions) {
            if ($transactions->first()->item !== null) {
                $item = Item::find($item_id);
                $data[] = [
                    'item' => $transactions->first()->item->description,
                    'in' => $transactions->where('transaction_type', 'IN')->sum('qty'),
                    'out' => $transactions->where('transaction_type', 'OUT')->sum('qty'),
                    'balance' => $transactions->where('transaction_type', 'IN')->sum('qty') - $transactions->where('transaction_type', 'OUT')->sum('qty')
                ];
            }
        }
    
        return $data;
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
    
    private function getStockIn()
    {
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
    
        return Transaction::where('transaction_type', 'IN')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('qty');
    }
    
    private function getStockOut()
    {
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
    
        return Transaction::where('transaction_type', 'OUT')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('qty');
    }
    
    private function getBalance()
    {
        $stockIn = $this->getStockIn();
        $stockOut = $this->getStockOut();
    
        return $stockIn - $stockOut;
    }

    private function getTransactions()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
    
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d');
            });

        return $transactions;
    }
}
