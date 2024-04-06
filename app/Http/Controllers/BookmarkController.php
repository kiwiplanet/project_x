<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    /**
     * ブックマークの登録処理
     *
     * @param int $itemId
     * @return redirect
     */
    public function store($itemId) {
        $user = \Auth::user();
        if (!$user->is_bookmark($itemId)) {
            $user->bookmark_items()->attach($itemId);
        }
        return back();
    }
    
    /**
     * ブックマークの解除処理
     *
      * @param int $itemId
     * @return redirect
     */
    public function destroy($itemId) {
        $user = \Auth::user();
        if ($user->is_bookmark($itemId)) {
            $user->bookmark_items()->detach($itemId);
        }
        return back();
    }

    /**
     * ブックマーク一覧
     */
    public function bookmark_items(Request $request)
    {
        // クエリビルダーを初期化
        $query = Item::query();
        
        // ブックマークされたアイテムのみを取得するクエリを追加
        $query->whereHas('bookmarks', function ($query) {
            $userId = auth()->id();
            $query->where('user_id', $userId);
        });
    
        // 並び替えを行う
        if ($request->has('sort')) {
            $sortColumn = $request->input('sort');
    
            // 並び替えの条件を設定する
            if ($sortColumn === 'mostStock') {
                $query->orderBy('total_stock', 'desc');
            } elseif ($sortColumn === 'leastStock') {
                $query->orderBy('total_stock', 'asc');
            } elseif ($sortColumn === 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sortColumn === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            // デフォルトは作成日時の新しい順
            $query->orderBy('created_at', 'desc');
        }
    
        // ページネーションを適用してビューに渡す
        $items = $query->paginate(20)->onEachSide(1);
    
        return view('item.bookmark', compact('items'));
    }
    
    /**
     * 全てのブックマークの解除処理
     *
     * @return redirect
     */
    public function removeAllBookmarks()
    {
        Bookmark::where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', '全てのブックマークが解除されました');
    }
}