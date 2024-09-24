<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Datatables;
use App\Http\Controllers\InventoryController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\UOM;
use App\Models\Order;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    private $InventoryController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InventoryController $InventoryController)
    {
        $this->InventoryController = $InventoryController;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data = $this->InventoryController->totalIn();
        return view('home', $data);
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
        $useredit = User::findOrFail($id);
        // dd ($obat);

        //render view with post
        return view('useredit', compact('useredit'));
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
             'name'=> 'required',
             'email'=> 'required',
         ]);
     
         //get post by ID
         $post = User::findOrFail($id);
     
         $post->update([
             'name'=> $request->name,
             'email'=> $request->email,
         ]);
     
         if ($request->filled('password')) {
             $post->password = bcrypt($request->input('password'));
             $post->save();
         }
     
         return redirect()->route('users');
     }


// In your controller
public function usersdata()
{
    $users = User::get();

    $data = Datatables::of($users)
        ->addColumn('action', function ($user) {
            $editRoute = route('user.edit', $user->id);
            $deleteRoute = route('user.destroy', $user->id);
            
        })
        ->make(true);

    return $data;
}

     public function users(){
        $users = User::get();
        return view('user', compact('users'));
    }

    public function profile(Request $request, $id)
    {
        $profile = User::findOrFail($id); 

        return view('profile', compact('profile'));
    }

    public function profileupdate(Request $request, $id)
    {
        $user = Auth::user();
    
        $request->validate([
            'password_old' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
    
        if (!Hash::check($request->input('password_old'), $user->password)) {
            return back()->withErrors(['password_old' => 'The Old Password Is not The same!']);
        }
    
        if ($request->input('password') !== $request->input('password_confirmation')) {
            return back()->withErrors(['password' => 'The new password and confirmation do not match.']);
        }
    
        $user->password = bcrypt($request->input('password'));
        $user->save();
    
        return back()->with('success', 'Password changed successfully!');
    }
}
