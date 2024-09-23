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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function users(){
        $users = User::all();
        return view('user', compact('users'));
    }

    public function create()
    {
        

        return view('usercreate');
    }

    public function createAdd(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
        ]);
        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);
        return redirect()->route('users')->with('success','berhasil membuat');
    }

    public function destroyuser($id)
    {
        $usersdes = User::findOrFail($id);
    
        $usersdes->delete();
    
        return redirect()->route('users');
    }

    public function edit(Request $request, $id)
    {

        // get post by ID
        $edituom = User::findOrFail($id);
        // dd ($obat);

        //render view with post
        return view('uom/edituom', compact('edituom'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */

    public function update(Request $request, $id): RedirectResponse
    {

        //validate form
        $this->validate($request, [
            'unit_of_measurement' => 'required',
        ]);

        //get post by ID
        $post = User::findOrFail($id);
        $post->update([
            'unit_of_measurement' => $request->unit_of_measurement,
        ]);
        // dd($request);
        return redirect()->route('wh.uominv');
    }

}
