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

// 以下のルーティングはログイン必須
Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::prefix('items')->group(function () {
        // 食器一覧画面の表示
        Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);

        // 新規登録画面の表示・登録
        Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
        Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);

        // 食器詳細画面の表示
        Route::get('/show/{id}', [App\Http\Controllers\ItemController::class, 'show']);

        // 編集画面の表示・更新・削除
        Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit']);
        Route::put('/update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('items.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);

        //ブックマークの登録・解除・表示・全て解除
        Route::post('/{itemId}/bookmark', [App\Http\Controllers\BookmarkController::class, 'store'])->name('bookmark.store');
        Route::delete('/{itemId}/bookmark', [App\Http\Controllers\BookmarkController::class, 'destroy'])->name('bookmark.destroy');
        Route::get('/bookmark', [App\Http\Controllers\ItemController::class, 'bookmark_items'])->name('bookmark');
        Route::post('remove_all_bookmarks', [App\Http\Controllers\BookmarkController::class, 'removeAllBookmarks'])->name('remove_all_bookmarks');

        //検索画面の表示・検索
        Route::get('/search', [App\Http\Controllers\SearchController::class, 'search_form']);
        Route::get('/result', [App\Http\Controllers\SearchController::class, 'search'])->name('items.result');
    });
});
