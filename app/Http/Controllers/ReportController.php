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
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{






    public function getmonthly($month, Request $request)
    {
        // Calculate the start and end of the month
        $year = date('Y');
        $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, $month, 1, $year));
        $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));

        $startOfMonth = $year . '-' . $month . '-01';
        $endOfMonth = $year . '-' . $month . '-' . date('t', strtotime($startOfMonth));

        // Get search query from request
        $search = $request->input('search');

        // Retrieve data and apply search
        $inuomData = $this->getInMonthuom($startOfMonth, $endOfMonth);
        $inuom = $inuomData['inuom'];
        $totalIn = $inuomData['totalIn'];
        $totalOut = $inuomData['totalOut'];

        session()->put('month', $month);

        // $data = $this->getItemsData($startOfMonth, $endOfMonth);
        $labels = $this->getTransactionLabels($startOfMonth, $endOfMonth);
        $inQuantities = $this->getInQuantities($startOfMonth, $endOfMonth);
        $outQuantities = $this->getOutQuantities($startOfMonth, $endOfMonth);
        $stockin = $this->getStockIn($startOfMonth, $endOfMonth);
        $stockout = $this->getStockOut($startOfMonth, $endOfMonth);
        $balance = $this->getBalance($startOfMonth, $endOfMonth);
        $data = $this->getItemsData($startOfMonth, $endOfMonth);

        // Apply search to transactions
        $transactions = $this->getTransactions($startOfMonth, $endOfMonth, $search);

        return view('report/report', compact(
            'labels',
            'inQuantities',
            'outQuantities',
            'stockin',
            'stockout',
            'balance',
            'transactions',
            'firstDayOfMonth',
            'data',
            'lastDayOfMonth',
            'inuom',
            'totalIn',
            'totalOut',
            'search',
            'month'
        ));
    }

    private function getItemsData($startOfMonth, $endOfMonth)
    {
        $data = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->select('item_id')
            ->selectRaw('SUM(CASE WHEN transaction_type = "IN" THEN qty ELSE 0 END) as total_in')
            ->selectRaw('SUM(CASE WHEN transaction_type = "OUT" THEN qty ELSE 0 END) as total_out')
            ->selectRaw('(SUM(CASE WHEN transaction_type = "IN" THEN qty ELSE 0 END) - SUM(CASE WHEN transaction_type = "OUT" THEN qty ELSE 0 END)) as balance')
            ->groupBy('item_id')
            ->paginate(10);

        $data->transform(function ($item) {
            $item->item = Item::find($item->item_id)->description;
            return $item;
        });

        return $data;
    }
    private function getTransactionLabels($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->sortBy("created_at" )
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

    private function getTransactions($startOfMonth, $endOfMonth, $search = null)
{
    // Build query
    $query = Transaction::with('item', 'order')
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);

    if ($search) {
        if (preg_match('/(\d{4}-\d{2}-\d{2})/', $search, $matches)) {
            $date = Carbon::parse($matches[1]);
            $query->whereDate('created_at', $date);
        } elseif (preg_match('/(\d{2}-\d{2})/', $search, $matches)) {
            list($month, $day) = explode('-', $matches[1]);
            $query->whereMonth('created_at', $month)
                ->whereDay('created_at', $day);
        } elseif (preg_match('/(\d{2})/', $search, $matches)) {
            $day = $matches[1];
            $query->whereDay('created_at', $day);
        } else {
            // Keep the existing search logic for other search queries
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', function ($q) use ($search) {
                    $q->where('description', 'like', "%$search%");
                })
                ->orWhereHas('order', function ($q) use ($search) {
                    $q->where('department', 'like', "%$search%");
                });
            });
        }
    }

    // Get paginated results
    $paginatedTransactions = $query->orderBy('created_at')
        ->paginate(8);

    // Group by date for the current page items
    $groupedTransactions = $paginatedTransactions->getCollection()->groupBy(function ($transaction) {
        return $transaction->created_at->format('Y-m-d');
    });

    // Add the grouped transactions back to the paginator
    $paginatedTransactions->setCollection(collect($groupedTransactions));

    return $paginatedTransactions;
}

    private function getInMonthuom($startOfMonth, $endOfMonth)
    {
        $transactions = Transaction::whereBetween('transactions.created_at', [$startOfMonth, $endOfMonth])
            // ->join('order', 'transactions.order_id', '=', 'order.id')
            ->get()
            ->groupBy('item_id');

        $inuom = [];
        $totalIn = 0;
        $totalOut = 0;
        foreach ($transactions as $item_id => $transactions) {
            $item = Item::find($item_id);
            $order = $transactions->first()->order;
            $uom = $item->uom; // assuming you have a uom relationship defined in the Item model
            $in = $transactions->where('transaction_type', 'IN')->sum('qty');
            $out = $transactions->where('transaction_type', 'OUT')->sum('qty');

            if ($in > 0 || $out > 0) {
                $inuom[] = [
                    'description' => $item->description,
                    'department' => $order->department,
                    'uom' => $uom->unit_of_measurement, // assuming you have a name column in the UOM table
                    'in' => $in,
                    'out' => $out,
                    'created_at' => $transactions->max('created_at'), // add this line
                ];
                $totalIn += $in;
                $totalOut += $out;
            }
        }

        return compact('inuom', 'totalIn', 'totalOut');
    }

}
