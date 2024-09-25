<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\HomeController;
use App\Models\UOM;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();


Route::get('/home', [InventoryController::class, 'totalin'])->name('ob.home')->middleware('auth');


Route::get('/stockin', function () {
    $item = Item::get();
    $order = Order::get();
    return view('transaction/stockin', compact('item', 'order'));
})->name('ob.stockin')->middleware('auth');

Route::post('/stockin',[ObatController::class, 'itemstockin'])->name('ob.cstockin')->middleware('auth');


Route::get('/stockout', function () {
    $item = Item::get();
    $order = Order::get();
    return view('transaction/stockout', compact('item', 'order'));
})->name('ob.stockout')->middleware('auth');

Route::post('/stockout', [ObatController::class, 'itemstockout'])->name('ob.cstockout')->middleware('auth');


Route::post('home', [PageController::class, 'createitem','createstock'])->name('ob.create')->middleware('auth');


Route::get('/citem', function () {
    $uom = UOM::get(); 
    return view('obitem/citem', compact('uom'));
})->name('create.item')->middleware('auth');

Route::post('/citem', [PageController::class, 'createitem'])->name('ob.citem')->middleware('auth');

Route::get('/uom', function () {
    return view('uom/uom')->middleware('auth');
})->name('create.uom')->middleware('auth');

Route::post('/uominv', [PageController::class, 'createuom'])->name('ob.cuom')->middleware('auth');


//Wareghouse / wh
Route::get('/iteminv', [InventoryController::class, 'invobat'])->name('wh.iteminv')->middleware('auth');

Route::get('/uominv', [InventoryController::class,'invuom'])
    ->name('wh.uominv')
    ->middleware('auth')->middleware('auth');

//Update, Edit, Delete : UOM
Route::delete('uomdestroy/{id}', [ObatController::class, 'destroyuom'])->name('ob.uomdel')->middleware('auth');

Route::get('/uomedit/{id}', [ObatController::class, 'edituom'])->name('ob.edituom')->middleware('auth');

Route::post('/uomupdate/{id}', [ObatController::class, 'updateuom'])->name('ob.updateuom')->middleware('auth');



//Update, Edit, Delete : item
Route::delete('itemdestroy/{id}', [ObatController::class, 'destroyitem'])->name('ob.itemdel')->middleware('auth');

Route::get('/itemedit/{id}', [ObatController::class, 'edititem'])->name('ob.edititem')->middleware('auth');

Route::put('/itemupdate/{id}', [ObatController::class, 'updateitem'])->name('ob.updateitem')->middleware('auth');




Route::get('/tes', function () {
    return view('tes')->middleware('auth');
});

Route::get('/htu', function () {
    return view('htu')->middleware('auth');
});

Route::get('/translist', [InventoryController::class, 'transactionlistview'])->name('trans.list')->middleware('auth');
Route::get('/translist2', [InventoryController::class, 'transactionlist'])->name('trans.list.data') ;


Route::get('/getSuppliesQty', [InventoryController::class, 'getSuppliesQty'])->name('supliesqty')->middleware('auth');


Route::get('/report', [InventoryController::class, 'reportmonth'])->name('report')->middleware('auth');

Route::get('/department', function(){
    return view('department/department')->middleware('auth');
})->name('department')->middleware('auth');



Route::get('/department', [DepartmentController::class, 'list'])->name('department.list')->middleware('auth');

Route::get('/createdepartment', function(){
    return view('department/departcreate')->middleware('auth');
})->name('depart.create')->middleware('auth');

Route::post('/departpost', [DepartmentController::class, 'createdepartment'])->name('depart.post')->middleware('auth');

Route::get('/editdepart/{id}', [DepartmentController::class, 'editdepart'])->name('depart.edit')->middleware('auth');

Route::put('/updatedepart/{id}', [DepartmentController::class, 'updatedepart'])->name('depart.update')->middleware('auth');

Route::delete('/destroydepart/{id}', [DepartmentController::class, 'detroydepart'])->name('depart.delete')->middleware('auth');



// Route::get('/report/monthlydata/{month}', [ReportController::class, 'getItemsData' ])->name('reportitem.overview.data')->middleware('auth');

Route::get('report/monthly/{month}', [ReportController::class, 'getmonthly'])->name('report.monthly')->middleware('auth');

Route::get('/report/userin/{month}', [SummaryController::class, 'userin'])->name('report.user.in')->middleware('auth');

Route::get('/report/pdf/{month}', [SummaryController::class, 'userPrint'])->name('user.report.print')->middleware('auth');




Route::group(['middleware' => 'admin'], function(){
    Route::get('/users', [HomeController::class, 'users'])->name('users')->middleware('auth');
    Route::get('/usersdata', [HomeController::class, 'usersdata'])->name('users.data')->middleware('auth');

    Route::get('/add/user', [HomeController::class, 'create'])->name('user.add')->middleware('auth');

    Route::post('/add/create/user', [HomeController::class, 'createAdd'])->name('user.create.add')->middleware('auth');

    Route::delete('/user/destroy/{id}', [HomeController::class, 'destroyuser'])->name('user.destroy')->middleware('auth');

    Route::get('/add/user/edit/{id}', [HomeController::class, 'edit'])->name('user.edit')->middleware('auth');

    Route::put('/user/update/{id}', [HomeController::class, 'update'])->name('user.update')->middleware('auth');

    Route::post('/users/reset-password/{id}', [HomeController::class, 'resetPassword'])->name('user.reset.password')->middleware('auth');

});



Route::get('profile/{id}', [HomeController::class, 'profile'])->middleware('auth')->name('profile');

Route::put('profile/update/{id}', [HomeController::class, 'profileupdate'])->name('profile.change');

Route::get('/', function () {
    return redirect()->route('home');
})->name('root')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
