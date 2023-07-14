<?php

use App\Http\Controllers\Api\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//On fait des actions quand on est connecté, donc on va tout mettre dans un groupe, on va tout englober dans le middleware avec auth:sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('products/increase/{id}', [CartController::class, 'increase'])->name('quantity.increase');
    Route::get('products/decrease/{id}', [CartController::class, 'decrease'])->name('quantity.decrease');

    Route::get('products/count', [CartController::class, 'count'])->name('products.count');
    Route::apiResource('products', CartController::class);

});



//Ce qui était là par defaut
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
