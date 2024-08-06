<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\UOM;
use App\Models\User;

class PageController extends Controller
{

    public function createuom(Request $request)
    {
        $this->validate($request, [
            'unit_of_measurement'=> 'required',
        ]);
        UOM::create([
            'unit_of_measurement'=> $request->unit_of_measurement,
        ]);
        return redirect()->route('wh.uominv')->with('success','berhasil membuat');
    }

    public function createitem(Request $request)
    {
        $this->validate($request, [
            'description'=> 'required',
            'item_code' => 'required|min:14',
            'unit_of_measurement_id'=> 'required',
            'qty'=> 'required|numeric|min:1',
           
        ]);

        $item = Item::create([
            'description' => $request->description,
            'item_code' => $request->item_code,
            'unit_of_measurement_id'=> $request->unit_of_measurement_id,
            // $item ->qty = Stock::find('qty'),

        ]);

        Stock::create([
            'item_id'=> $item->id,
            'qty' => $request->qty,
        ]);
        //  dd(Item::all());
        return redirect()->route('wh.iteminv')->with('success','berhasil membuat');
    }

   
}
