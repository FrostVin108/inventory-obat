<?php

namespace App\Exports; 
use App\Models\Transaction;
use App\Models\User;
use App\Models\Order; 

use Maatwebsite\Excel\Concerns\FromCollection;



class ExportUser implements FromCollection { 
    /**
     * @return \Illuminate\Support\Collection
     */ 
    public function headings(): array {
        return [
            'Department',
            'No',
            'Item Description',
            'Transaction Type',
            'Quantity',
            'Date',
        ];
    } 

    public function collection()
    {
        $departments = Order::all();
    
        $data = [];
    
        foreach ($departments as $department) {
            $transactions = Transaction::with('order', 'item')
                                        ->where('transaction_type', 'out')
                                        ->whereHas('order', function ($query) use ($department) {
                                            $query->where('id', $department->id);
                                        })
                                        ->get();
    
            if ($transactions->count() > 0) {
                $totalQuantity = $transactions->sum('qty');
                $totalItems = $transactions->count();
    
                $data[] = [' ' , ' ', $department->department]; // add department header
                $data[] = [' ' ,'No', 'Item Description', 'Transaction Type', 'Quantity', 'Date']; // add column headers

                $rowNum = 1;
                foreach ($transactions as $transaction) {
                    $data[] = [
                        '',
                        $rowNum,
                        $transaction->item->description,
                        $transaction->transaction_type,
                        $transaction->qty,
                        $transaction->created_at,
                    ];
                }
    
                $data[] = ['', '', '', 'Total', $totalQuantity, '']; // add total row
                $data[] = ['', '', '', 'Total Items', $totalItems, '']; // add total items row
                $data[] = ['']; // add empty row for spacing
                $data[] = ['']; // add empty row for spacing
            }
        }
    
        return collect($data);
    }


}
