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