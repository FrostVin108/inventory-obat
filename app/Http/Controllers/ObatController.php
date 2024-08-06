<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\UOM;
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
        return view('edituom', compact('edituom') );
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
        $uom = uom::get();
        //render view with post
        return view('edititem',compact('uom'), compact('edititem') );
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
            'item_code' => 'required|numeric|min:14',
            'unit_of_measurement_id'=> 'required',
        ]);

        //get post by ID
        $post = Item::findOrFail($id);
        $post->update([
            'description' => $request->description,
            'item_code' => $request->item_code,
            'unit_of_measurement_id'=> $request->unit_of_measurement_id,
        ]);
        return redirect()->route('wh.iteminv');
    }

    public function itemstockin(Request $request){

        $this->validate($request,[
            'item_id'=> 'required',
            'qty'=> 'required|numeric|min:1',
        ]);


        Stock::create([
            
            'item_id' => $request->item_id,
            'qty'=> $request->qty,
            // 'transaction_type' =>'IN',
            
        ]);
        // dd(Stock::all());
        return redirect()->route('ob.home')->with('success','berhasil membuat');
    }

    public function updatestock(Request $request, $id):RedirectResponse{
    
        //validate form
        $this->validate($request, [
            'item_id' => 'required',
            'qty'=> 'required|numeric|min:1',
        ]);

        //get post by ID
        $post = Stock::create();
        $post->update([
            'item_id' => $request->item_code,
            'qty'=> $request->qty,
        ]);
        return redirect()->route('ob.home');
    }

}
