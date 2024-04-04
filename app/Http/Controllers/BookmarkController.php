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
        // ブックマーク一覧取得（ソート）
        $sortBy = $request->input('sort', 'newest');
        
        // ログインユーザーのブックマーク一覧取得クエリ
        $items = auth()->user()->bookmark_items()->with('seasons');
    
        // ソートに応じて並び替え
        switch ($sortBy) {
            case 'oldest':
                $items->orderBy('created_at', 'asc');
                break;
            case 'most_stock':
                $items->orderBy('total_stock', 'desc');
                break;
            case 'least_stock':
                $items->orderBy('total_stock', 'asc');
                break;
            case 'newest':
            default:
                $items->orderBy('created_at', 'desc');
                break;
        }
    
        // ページネーションを適用してビューに渡す
        $items = $items->paginate(20);
    
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