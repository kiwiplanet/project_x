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

        $results = Item::query();

        // キーワード検索
        if (!empty($keyword)) {
            $results->where(function ($results) use ($keyword) {
            // 曖昧検索
            $results->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('buyer', 'like', '%' . $keyword . '%')
                // メモ欄：数は完全一致検索、文字は曖昧検索
                ->orWhere(function ($results) use ($keyword) {
                    if (is_numeric($keyword)) {
                        $results->where('detail', '=', $keyword);
                    } else {
                        $results->where('detail', 'like', '%' . $keyword . '%');
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
            $results->whereHas('seasons', function ($q) use ($seasons) {
                $q->whereIn('season_id', $seasons);
            });
        }
        // 並び替えを行う
        if ($request->has('sort')) {
            $sortColumn = $request->input('sort');
    
            // 並び替えの条件を変更する
            if ($sortColumn === 'mostStock') {
                $results->orderBy('total_stock', 'desc');
            } elseif ($sortColumn === 'leastStock') {
                $results->orderBy('total_stock', 'asc');
            } elseif ($sortColumn === 'newest') {
                $results->orderBy('created_at', 'desc');
            } elseif ($sortColumn === 'oldest') {
                $results->orderBy('created_at', 'asc');
            }
        } else {
            // デフォルトは作成日時の新しい順
            $results->orderBy('created_at', 'desc');
        }
        
        // 検索結果を取得し、ページネーションを適用してビューに渡す
        $results = $results->paginate(20);
        
        // 検索結果をビューに渡して表示
        return view('item.result', ['results' => $results]);
    }
}  
