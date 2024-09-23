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

class DepartmentController extends Controller
{
    public function list()
    {
        $users = Order::all();
        // dd($obatuom);
        return view('department/department', compact('users'));
    }
    
    public function createdepartment(Request $request)
    {
        $this->validate($request, [
            'department'=> 'required',
        ]);
        
        Order::create([
            'department'=> $request->department,
        ]);
        
        return redirect()->route('department.list')->with('success','berhasil membuat');
    }

    public function detroydepart($id)
    {
        $users = Order::findOrFail($id);
    
        if (Transaction::whereHas('item', function ($query) use ($id) {
            $query->where('order_id', $id);
        })->count() > 0) {
            return redirect()->route('department.list')->with('error', 'Sorry You cant delete The Order ,It Is under Use for Other Data!');
        }
    
        $users->delete();
    
        return redirect()->route('department.list');
    }

    public function editdepart(Request $request, $id){
        
        // get post by ID
        $editdepart = Order::findOrFail($id);
        // dd ($obat);
    
        //render view with post
        return view('department/departedit', compact('editdepart') );
        }

            /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */

        public function updatedepart(Request $request, $id):RedirectResponse{
    
        //validate form
        $this->validate($request, [
            'department'   => 'required',
        ]);
        
        //get post by ID
        $post = Order::findOrFail($id);
        $post->update([
            'department'   => $request->department,
        ]);
        // dd($request);
        return redirect()->route('department.list');
    }

}
