<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PageController;
use App\Models\uom;
use App\Models\stock;
use App\Models\item;
use App\Models\transaction;
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

Route::get('/', function () {
    return view('home');
})->name('ob.home');


Route::get('/stockin', function () {
    $item = item::get();
    return view('stockin', compact('item'));
})->name('ob.stockin');

Route::post('/stockin',[ObatController::class, 'itemstockin'])->name('ob.cstockin');


Route::get('/stockout', function () {
    $item = item::get();
    return view('stockout', compact('item'));
})->name('ob.stockout');

Route::post('/stockout', [ObatController::class, 'itemstockout'])->name('ob.cstockout');


Route::post('home', [PageController::class, 'createitem','createstock'])->name('ob.create');


Route::get('/citem', function () {
    $uom = uom::get(); 
    return view('citem', compact('uom'));
})->name('create.item');

Route::post('/citem', [PageController::class, 'createitem'])->name('ob.citem');

Route::get('/uom', function () {
    return view('uom');
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
// Route::get('/itemupdate/{id}', function(){
//     return view('edititem');
// })->name('ob.edititem');

Route::put('/itemupdate/{id}', [ObatController::class, 'updateitem'])->name('ob.updateitem');

Route::get('/tes', function () {
    return view('tes');
});

Route::get('/htu', function () {
    return view('htu');
});




Route::get('/getSuppliesQty', [InventoryController::class, 'getSuppliesQty'])->name('supliesqty');