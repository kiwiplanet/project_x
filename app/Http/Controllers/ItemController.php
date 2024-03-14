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
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::all();

        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'buyer' => 'required|max:411',
                'unit_price' => 'required|numeric',
                'regular_stock' => 'required|integer',
                'total_stock' => 'required|integer',
                'kitchen_stock' => 'nullable|integer',
                'second_stock' => 'nullable|integer',
                'smach_stock' => 'nullable|integer',
                'detail' => 'nullable|max:500',
                'img_path' => 'required',
            ]);

            // 商品登録
            $item = Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'img_path' => $request->img_path,
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
}
