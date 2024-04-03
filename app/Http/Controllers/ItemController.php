<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Season;
use App\Models\SeasonItem;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * 食器一覧
     */
    public function index(Request $request)
    {
        // 食器一覧取得（ソート）
        $sortBy = $request->input('sort', 'newest');

        switch ($sortBy) {
            case 'oldest':        //古い順
                $items = Item::with('seasons')->orderBy('created_at', 'asc')->paginate(20);
                break;
            case 'most_stock':    //多い順
                $items = Item::with('seasons')->orderBy('total_stock', 'desc')->paginate(20);
                break;
            case 'least_stock':   //少ない順
                $items = Item::with('seasons')->orderBy('total_stock', 'asc')->paginate(20);
                break;
            case 'newest':        //新しい順
            default:
                $items = Item::with('seasons')->orderBy('created_at', 'desc')->paginate(20);
                break;
        }
        return view('item.index', compact('items'));
    }

    /**
     * 新規登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'buyer' => 'required|max:100',
                'unit_price' => 'required|numeric',
                'regular_stock' => 'required|integer',
                'total_stock' => 'required|integer',
                'kitchen_stock' => 'nullable|integer',
                'second_stock' => 'nullable|integer',
                'smach_stock' => 'nullable|integer',
                'detail' => 'nullable|max:500',
                'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // 画像のアップロードと保存
            if ($request->hasFile('img_path')) {
                $imagePath = $request->file('img_path')->store('public/items');
                $imagePath = str_replace('public/', 'storage/', $imagePath);
            } else {
                // 画像がアップロードされていない場合、$imagePathをnullに設定
                $imagePath = null;
            }

            // 新規登録
            $item = Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'img_path' => $imagePath, // 保存した画像のパスを使用
                'buyer' => $request->buyer,
                'unit_price' => $request->unit_price,
                'regular_stock' => $request->regular_stock,
                'total_stock' => $request->total_stock,
                'kitchen_stock' => $request->kitchen_stock,
                'second_stock' => $request->second_stock,
                'smach_stock' => $request->smach_stock,
                'detail' => $request->detail,
            ]);

            // 中間テーブルへのデータ保存処理
            if ($request->has('seasons')) {
                $seasonIds = $request->input('seasons');
                foreach ($seasonIds as $seasonId) {
                    SeasonItem::create([
                        'season_id' => $seasonId,
                        'item_id' => $item->id,
                    ]);
                }
            }
            return redirect('/items')->with('success', '登録が完了しました');
        }

        return view('item.add');
    }

    /**
     * 詳細画面の表示
     * @param int $id
     * @return view
     */
    public function show($id)
    {
        $item = Item::Find($id);

        return view('item.show', compact('item'));
    }

    /**
     * 編集画面の表示
     *
     * @param int $id
     * @return view
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        // 既存の利用時期のIDを取得する
        $selectedSeasons = $item->seasons->pluck('id')->toArray();

        return view('item.edit', compact('item', 'selectedSeasons'));
    }

    /**
     * 更新処理
     *
     * @return view
     */
    public function update(Request $request, $id)
    {
        // PUTリクエストのとき
        if ($request->isMethod('put')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'buyer' => 'required|max:100',
                'unit_price' => 'required|numeric',
                'regular_stock' => 'required|integer',
                'total_stock' => 'required|integer',
                'kitchen_stock' => 'nullable|integer',
                'second_stock' => 'nullable|integer',
                'smach_stock' => 'nullable|integer',
                'detail' => 'nullable|max:500',
                // 画像のバリデーションを更新
                'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // 更新対象のアイテムを取得
            $item = Item::findOrFail($id);

            // 画像がアップロードされた場合の処理
            if ($request->hasFile('img_path')) {
                // 古い画像パス＆ファイルを削除
                $imagePath = $item->img_path;
                Storage::disk('public')->delete('items/' . basename($imagePath));

                // 新しい画像をアップロード
                $imagePath = $request->file('img_path')->store('public/items');
                $imagePath = str_replace('public/', 'storage/', $imagePath);
                // 画像パスを更新
                $item->img_path = $imagePath;
            }

            // フォームからの入力を取得し、アップデート
            $item->name = $request->input('name');
            $item->buyer = $request->input('buyer');
            $item->unit_price = $request->input('unit_price');
            $item->regular_stock = $request->input('regular_stock');
            $item->total_stock = $request->input('total_stock');
            $item->kitchen_stock = $request->input('kitchen_stock');
            $item->second_stock = $request->input('second_stock');
            $item->smach_stock = $request->input('smach_stock');
            $item->detail = $request->input('detail');
            $item->save();

            // 中間テーブルのモデルを取得
            $seasonItems = SeasonItem::where('item_id', $item->id)->get();
            // 中間テーブルのデータを削除
            foreach ($seasonItems as $seasonItem) {
                $seasonItem->delete();
            }
            // 新しい関連付けられたデータを追加
            if ($request->has('seasons')) {
                $seasonIds = $request->input('seasons');
                foreach ($seasonIds as $seasonId) {
                    SeasonItem::create([
                        'season_id' => $seasonId,
                        'item_id' => $item->id,
                    ]);
                }
            }

            return redirect('/items')->with('success', '更新が完了しました');
        }
    }

    /**
     * 削除処理
     *
     * @param int $id
     * @return view
     */
    public function destroy($id)
    {
    $item = Item::findOrFail($id);

    // 画像パス＆ファイルを削除
    $imagePath = $item->img_path;
    Storage::disk('public')->delete('items/' . basename($imagePath));
    
    // アイテムを削除
    $item->delete();
    
    return redirect('/items')->with('success', '完全に削除されました');
    }

    /**
     * ブックマーク一覧
     */
    public function bookmark_items(Request $request)
    {
        // ブックマーク一覧取得（ソート）
        $sortBy = $request->input('sort', 'newest');
        
        switch ($sortBy) {
            case 'oldest':        //古い順
                $items = Item::whereHas('bookmarks')->with('seasons')->orderBy('created_at', 'asc')->paginate(20);
                break;
            case 'most_stock':    //多い順
                $items = Item::whereHas('bookmarks')->with('seasons')->orderBy('total_stock', 'desc')->paginate(20);
                break;
            case 'least_stock':   //少ない順
                $items = Item::whereHas('bookmarks')->with('seasons')->orderBy('total_stock', 'asc')->paginate(20);
                break;
            case 'newest':        //新しい順
            default:
                $items = Item::whereHas('bookmarks')->with('seasons')->orderBy('created_at', 'desc')->paginate(20);
                break;
        }
        return view('item.bookmark', compact('items'));
    }
}
