<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SummaryController;
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

Route::get('/', [InventoryController::class, 'totalin'])->name('ob.home');


Route::get('/stockin', function () {
    $item = Item::get();
    $order = Order::get();
    return view('transaction/stockin', compact('item', 'order'));
})->name('ob.stockin');

Route::post('/stockin',[ObatController::class, 'itemstockin'])->name('ob.cstockin');


Route::get('/stockout', function () {
    $item = Item::get();
    $order = Order::get();
    return view('transaction/stockout', compact('item', 'order'));
})->name('ob.stockout');

Route::post('/stockout', [ObatController::class, 'itemstockout'])->name('ob.cstockout');


Route::post('home', [PageController::class, 'createitem','createstock'])->name('ob.create');


Route::get('/citem', function () {
    $uom = UOM::get(); 
    return view('obitem/citem', compact('uom'));
})->name('create.item');

Route::post('/citem', [PageController::class, 'createitem'])->name('ob.citem');

Route::get('/uom', function () {
    return view('uom/uom');
})->name('create.uom');

Route::post('/uominv', [PageController::class, 'createuom'])->name('ob.cuom');


//Wareghouse / wh
Route::get('/iteminv', [InventoryController::class, 'invobat'])->name('wh.iteminv');

Route::get('/uominv', [InventoryController::class,'invuom'])->name('wh.uominv');


//Update, Edit, Delete : UOM
Route::delete('uomdestroy/{id}', [ObatController::class, 'destroyuom'])->name('ob.uomdel');

Route::get('/uomedit/{id}', [ObatController::class, 'edituom'])->name('ob.edituom');

Route::post('/uomupdate/{id}', [ObatController::class, 'updateuom'])->name('ob.updateuom');


//Update, Edit, Delete : item
Route::delete('itemdestroy/{id}', [ObatController::class, 'destroyitem'])->name('ob.itemdel');

Route::get('/itemedit/{id}', [ObatController::class, 'edititem'])->name('ob.edititem');

Route::put('/itemupdate/{id}', [ObatController::class, 'updateitem'])->name('ob.updateitem');

Route::get('/tes', function () {
    return view('tes');
});

Route::get('/htu', function () {
    return view('htu');
});

Route::get('/translist', [InventoryController::class, 'transactionlistview'])->name('trans.list');
Route::get('/translist2', [InventoryController::class, 'transactionlist'])->name('trans.list.data');


Route::get('/getSuppliesQty', [InventoryController::class, 'getSuppliesQty'])->name('supliesqty');


Route::get('/report', [InventoryController::class, 'reportmonth'])->name('report');

Route::get('/department', function(){
    return view('department/department');
})->name('department');



Route::get('/department', [DepartmentController::class, 'list'])->name('department.list');

Route::get('/createdepartment', function(){
    return view('department/departcreate');
})->name('depart.create');

Route::post('/departpost', [DepartmentController::class, 'createdepartment'])->name('depart.post');

Route::get('/editdepart/{id}', [DepartmentController::class, 'editdepart'])->name('depart.edit');

Route::put('/updatedepart/{id}', [DepartmentController::class, 'updatedepart'])->name('depart.update');

Route::delete('/destroydepart/{id}', [DepartmentController::class, 'detroydepart'])->name('depart.delete');



// Route::get('/report/monthlydata/{month}', [ReportController::class, 'getItemsData' ])->name('reportitem.overview.data');

Route::get('report/monthly/{month}', [ReportController::class, 'getmonthly'])->name('report.monthly');

Route::get('/report/userin/{month}', [SummaryController::class, 'userin'])->name('report.user.in');

Route::get('/report/print', [SummaryController::class, 'print'])->name('print.report');