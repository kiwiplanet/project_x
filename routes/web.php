<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    // 食器一覧画面の表示
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    // 新規登録画面の表示と登録処理
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    // 食器の詳細画面の表示
    Route::get('/show/{id}', [App\Http\Controllers\ItemController::class, 'show']);
    // 編集画面の表示と更新処理
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit']);
    Route::put('/update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('items.update');
    // 削除処理
    Route::delete('/delete/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);
});
