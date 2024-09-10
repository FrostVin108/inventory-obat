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
    // public function all_item()
    // {


    //     $data = $this->getItemsData();
    //     $labels = $this->getTransactionLabels();
    //     $inQuantities = $this->getInQuantities();
    //     $outQuantities = $this->getOutQuantities();
    //     $stockIn = $this->getStockIn();
    //     $stockOut = $this->getStockOut();
    //     $balance = $this->getBalance();
    //     $transactions = $this->getTransactions();


    //     return view('report/report', compact('data', 'labels', 'inQuantities', 'outQuantities', 'stockIn', 'stockOut', 'balance', 'transactions'));
    // }

    public function getmonthly($month)
    {
        $year = date('Y');
        $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, $month, 1, $year));
        $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));

        $year = date('Y');
        $startOfMonth = $year . '-' . $month . '-01';
        $endOfMonth = $year . '-' . $month . '-' . date('t', strtotime($startOfMonth));

        $data = $this->getItemsData($startOfMonth, $endOfMonth);
        $labels = $this->getTransactionLabels($startOfMonth, $endOfMonth);
        $inQuantities = $this->getInQuantities($startOfMonth, $endOfMonth);
        $outQuantities = $this->getOutQuantities($startOfMonth, $endOfMonth);
        $stockin = $this->getStockIn($startOfMonth, $endOfMonth);
        $stockout = $this->getStockOut($startOfMonth, $endOfMonth);
        $balance = $this->getBalance($startOfMonth, $endOfMonth);
        $transactions = $this->getTransactions($startOfMonth, $endOfMonth);
        $inuom = $this->getInMonthuom($startOfMonth, $endOfMonth);

        return view('report/report', compact('data', 'labels', 'inQuantities', 'outQuantities', 'stockin', 'stockout', 'balance', 'transactions', 'firstDayOfMonth', 'lastDayOfMonth', 'inuom'));
    }


    private function getItemsData($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy('item_id');

        $data = [];
        foreach ($transactions as $item_id => $transactions) {
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

    private function getTransactionLabels($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
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

    private function getInQuantities($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
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

    private function getOutQuantities($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
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


    private function getStockIn($startOfMonth, $endOfMonth)
    {
        $stockin = Transaction::where('transaction_type', 'IN')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('qty');

        return $stockin;
    }

    private function getStockOut($startOfMonth, $endOfMonth)
    {
        $stockout = Transaction::where('transaction_type', 'OUT')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('qty');

        return $stockout;
    }

    private function getBalance($startOfMonth, $endOfMonth)
    {
        $balances = [];
        $items = Item::all();
        foreach ($items as $item) {
            $stockIn = $this->getStockIn($startOfMonth, $endOfMonth);
            $stockOut = $this->getStockOut($startOfMonth, $endOfMonth);
            $balance = $stockIn - $stockOut;
            $balances[] = [
                'item' => $item->description,
                'balance' => $balance
            ];
        }
        return $balances;
    }

    private function getTransactions($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::with('item') // Eager load the related "items"
            ->with('order')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d');
            });

        return $transactions;
    }

    private function getInMonthuom($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy('item_id');

        $inuom = [];
        foreach ($transactions as $item_id => $transactions) {
            $item = Item::find($item_id);
            $uom = $item->uom; // assuming you have a uom relationship defined in the Item model
            $inuom[] = [
                'description' => $item->description,
                'uom' => $uom->unit_of_measurement, // assuming you have a name column in the UOM table
                'in' => $transactions->where('transaction_type', 'IN')->sum('qty'),
                'out' => $transactions->where('transaction_type', 'OUT')->sum('qty'),
                'created_at' => $transactions->max('created_at'), // add this line
            ];
        }

        return $inuom;
    }

}
