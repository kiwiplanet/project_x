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
}