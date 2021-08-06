<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// TODO: Route::get('/inventories/create', [InventoryController::class, 'create']);
// TODO: Route::get('inventories/{inventory}', [InventoryController::class, 'show']);
// TODO: Route::get('/inventories/{inventory}/edit', [InventoryController::class, 'edit']);
Route::post('/inventories', [InventoryController::class, 'store']);
Route::patch('/inventories/{inventory}', [InventoryController::class, 'update']);
Route::delete('/inventories/{inventory}', [InventoryController::class, 'delete']);
Route::post('/inventory/{inventory}/items', [ItemController::class, 'store']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
