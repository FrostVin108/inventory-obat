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
        if (!Auth::user()->role === 'ADMIN') {
            return redirect()->route('home');
        }


        return view('usercreate');
    }

    public function createAdd(Request $request)
    {
        if (!Auth::user()->role === 'ADMIN') {
            return redirect()->route('home');
        }



        $this->validate($request, [
            'name'=> 'required',
            'role' => 'required',
            'email'=> 'required',
            'password'=> 'required',
        ]);
        User::create([
            'name'=> $request->name,
            'role'=> $request->role,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);
        return redirect()->route('users')->with('success','berhasil membuat');
    }

    public function destroyuser($id)
    {
        if (!Auth::user()->role === 'ADMIN') {
            return redirect()->route('home');
        }


        $usersdes = User::findOrFail($id);
    
        $usersdes->delete();
    
        return redirect()->route('users');
    }

    public function edit(Request $request, $id)
    {
        if (!Auth::user()->role === 'ADMIN') {
            return redirect()->route('home');
        }



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
        if (!Auth::user()->role === 'ADMIN') {
            return redirect()->route('home');
        }


         //validate form
         $this->validate($request, [
             'name'=> 'required',
             'role'=> 'required',
             'email'=> 'required',
         ]);
     
         //get post by ID
         $post = User::findOrFail($id);
     
         $post->update([
             'name'=> $request->name,
             'role'=> $request->role,
             'email'=> $request->email,
         ]);
     
        //  if ($request->filled('password')) {
        //      $post->password = bcrypt($request->input('password'));
        //      $post->save();
        //  }
     
         return redirect()->route('users');
     }


// In your controller
public function usersdata()
{
    if (!Auth::user()->role === 'ADMIN') {
        return redirect()->route('home');
    }


    $users = User::get();

    $data = Datatables::of($users)
        ->addColumn('DT_RowIndex', function ($user) {
            return '';
        })
        ->addColumn('action', function ($user) {
            $editRoute = route('user.edit', $user->id);
            $deleteRoute = route('user.destroy', $user->id);
            $resetpassword = route('user.reset.password', $user->id);
            return '
            <div class="btn-group" >
            <a href="'.$editRoute.'" class="btn  btn-primary"><i class="far fa-edit"></i> Edit</a>
            <form action="'. $resetpassword .'" method="post" onsubmit="return confirm(\'Are you sure?\');">
            '.csrf_field().'
            <button type="submit" class="btn btn-warning"><i class="	fas fa-redo"></i> Reset Password</button>
            </form>
            <form action="'.$deleteRoute.'" method="post" onsubmit="return confirm(\'Apakah Anda Yakin?\');">
                '.csrf_field().'
                '. method_field('DELETE') .'
                <button type="submit" class="btn  btn-danger"><i class="fas fa-trash"></i> Delete</button>
            </form>
            </div>
            ';
                    
        })
        ->make(true);

    return $data;
}

public function resetPassword($id)
{
    if (!Auth::user()->role === 'ADMIN') {
        return redirect()->route('home');
    }

    $user = User::findOrFail($id);
    $user->password = bcrypt('123456789');
    $user->save();

    return redirect()->route('users')->with('success', 'Password reset successfully!');
}

     public function users(){
        if (!Auth::user()->role === 'ADMIN') {
            return redirect()->route('home');
        }


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
