<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\UOM;
use App\Models\Order;
use App\Models\User;

class ObatController extends Controller
{
    public function destroyuom($id)
    {
       $obatuom = UOM::findOrFail($id);
        // dd($obatuom);
       $obatuom->delete();

       return redirect()->route('wh.uominv');
    }

    public function edituom(Request $request, $id){
        
        // get post by ID
        $edituom = UOM::findOrFail($id);
        // dd ($obat);
    
        //render view with post
        return view('uom/edituom', compact('edituom') );
        }

            /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */

        public function updateuom(Request $request, $id):RedirectResponse{
    
        //validate form
        $this->validate($request, [
            'unit_of_measurement'   => 'required',
        ]);
        
        //get post by ID
        $post = UOM::findOrFail($id);
        $post->update([
            'unit_of_measurement'   => $request->unit_of_measurement,
        ]);
        // dd($request);
        return redirect()->route('wh.uominv');
    }


    public function destroyitem($id)
    {
        Stock::where('item_id', $id)->delete();  
        $obatitem = Item::findOrFail($id);
        // dd($obatuom);
        $obatitem->delete();

        return redirect()->route('wh.iteminv');
    }

    public function edititem(Request $request, $id){
        
        // get post by ID
        $edititem = Item::findOrFail($id);
        // dd ($obat);

        $uom = UOM::where('id', $edititem->unit_of_measurement_id )->firstOrFail();

        $uom = UOM::get();
        //render view with post
        
        
        $stock = Stock::where('item_id',$edititem->id )->firstOrFail();
        

        return view('obitem/edititem' ,compact('uom','edititem','stock'));
    }
    
            /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */

        public function updateitem(Request $request, $id):RedirectResponse{
    
        //validate form
        $this->validate($request, [
            'description'=> 'required',
            'item_code' => 'required|min:14',
            'unit_of_measurement_id'=> 'required',
            'qty' => 'required|numeric|min:1'
        ]);

        //get post by ID
        $post = Item::findOrFail($id);
        $post->update([
            'description' => $request->description,
            'item_code' => $request->item_code,
            'unit_of_measurement_id'=> $request->unit_of_measurement_id,
            
        ]);

        $post = Stock::findOrFail($id);
        $post->update([
            'qty' => $request->qty,
        ]);

        return redirect()->route('wh.iteminv');
    }

    public function itemstockin(Request $request){
        // logic stock in
        $item = item::find($request->item_id);
        $order = Order::find($request->order_id);
        $stock = stock::where('item_id', $item->id)->first();
        if ($stock) {
            $stock->qty += $request->qty;
            $stock->save();

            $this->validate($request, [
                'item_id'=> 'required',
                'order_id' => 'required',
                'transaction_type' => 'required',
                'qty'=> 'required|numeric|min:1',
            
            ]);
        
            Transaction::create([
                'item_id' =>  $item->id,
                'order_id' =>  $order->id,
                'transaction_type' => $request->transaction_type,
                'qty'=> $request->qty,
                // $item ->qty = Stock::find('qty'),
        
            ]);
            
            return redirect()->route('ob.home')->with('success', 'Stock in berhasil');

        } else {
            stock::create([
                'item_id' => $item->id,
                'qty' => $request->qty,
                'transaction_type'=> "IN",
            ]);
        }



 
    }

    public function itemstockout(Request $request){
    
    // logic stock out
    $order = Order::find($request->order_id);
    $item = item::find($request->item_id);
    $stock = stock::where('item_id', $item->id)->first();
    if ($stock) {
        if ($stock->qty >= $request->qty) {
                    $stock->qty -= $request->qty;
                    $stock->save();

                    $this->validate($request, [
                        'item_id'=> 'required',
                        'transaction_type' => 'required',
                        'order_id' => 'required',
                        'qty'=> 'required|numeric|min:1',
                       
                    ]);
                
                    Transaction::create([
                        'item_id' =>  $item->id,
                        'order_id' => $order->id,
                        'transaction_type' => $request->transaction_type,
                        'qty'=> $request->qty,
                        // $item ->qty = Stock::find('qty'),
                
                    ]);
                    
                    return redirect()->route('ob.home')->with('success', 'Stock out berhasil');
        } else {

            \Session::flash('error', "Maaf Item Yang Anda Coba Hilangkan Sedang Terpakai Oleh Salah Satu Data Yang Ada");
            return redirect()->route('ob.stockout')->with('error', 'Stock tidak cukup');
           
                }
    } else {
        stock::create([
            'item_id' => $item->id,
            'qty' => $request->qty,
            'transaction_type'=> "out",
        ]);
    }

    // return redirect()->route('ob.home')->with('success', 'Stock in berhasil');
    }



}