<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

// ✅ Make these routes public
Route::get('/products', [ProductController::class, 'index']);
// Route::post('/upload', [ProductController::class, 'upload']);

Route::options('/upload', function (Request $request) {
    return response()->json([], 204)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});
Route::post('/upload', [ProductImportController::class, 'import']);



