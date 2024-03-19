<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Season;
use App\Models\SeasonItem;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
                'img_path' => 'required',
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

            return redirect('/items');
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
}
