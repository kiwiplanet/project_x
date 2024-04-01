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
        // フォームから送られてきた検索キーワードと季節の値を取得
        $keyword = $request->input('keyword');
        $seasons = $request->input('seasons');


        // 検索キーワードが空の場合は何も返さない
        if (empty($keyword) && empty($seasons)) {
            return redirect()->back()->with('error', '入力がありませんでした。');
        }

        $query = Item::query();

        // キーワード検索
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
            // 曖昧検索
            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('buyer', 'like', '%' . $keyword . '%')
                // メモ欄：数は完全一致検索、文字は曖昧検索
                ->orWhere(function ($query) use ($keyword) {
                    if (is_numeric($keyword)) {
                        $query->where('detail', '=', $keyword);
                    } else {
                        $query->where('detail', 'like', '%' . $keyword . '%');
                    }
                })
                // 完全一致検索
                ->orWhere('unit_price', '=', $keyword)
                ->orWhere('regular_stock', '=', $keyword)
                ->orWhere('total_stock', '=', $keyword)
                ->orWhere('kitchen_stock', '=', $keyword)
                ->orWhere('second_stock', '=', $keyword)
                ->orWhere('smach_stock', '=', $keyword);
            });
        }

        // チェックボックス検索
        if (!empty($seasons)) {
            $query->whereHas('seasons', function ($q) use ($seasons) {
                $q->whereIn('season_id', $seasons);
            });
        }
        
        // 検索結果を取得し、ページネーションを適用してビューに渡す
        $results = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // 検索結果をビューに渡して表示
        return view('item.result', ['results' => $results]);
    }
}  
