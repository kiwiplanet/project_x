<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // 検索画面を表示するメソッド
    public function search_form()
    {
        // 検索画面のビューを返す
        return view('item.search');
    }

    public function search(Request $request)
    {
        // フォームから送られてきた検索キーワードを取得
        $keyword = $request->input('keyword');

        // 検索条件に基づいてアイテムを検索
        $results = Item::where('name', 'like', '%' . $keyword . '%')->paginate(20);;

        // 検索結果をビューに渡して表示
        return view('item.result', ['results' => $results]);
    }
}
