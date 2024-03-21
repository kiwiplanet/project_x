@extends('adminlte::page')

@section('title', '編集画面')

@section('content_header')
    <h1>編集画面</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data" action="{{ route('items.update', $item->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                    <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="form-group">
                            <label for="name">名前<span class="badge badge-danger">必須</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="例）〇〇焼 花型平皿" value="{{ $item->name }}">
                            @error('name')
                            <span style="color:red;">名前の入力は必須です。（100文字以内）</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="buyer">購入先<span class="badge badge-danger">必須</span></label>
                            <input type="text" class="form-control" id="buyer" name="buyer" placeholder="例）株式会社〇〇" value="{{ $item->buyer }}">
                            @error('buyer')
                            <span style="color:red;">購入先の入力は必須です。（100文字以内）</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit_price">単価<span class="badge badge-danger">必須</span></label>
                            <input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="例）100円→100 ※セットの場合も1コ当たりで入力" value="{{ number_format($item->unit_price) }}">
                            @error('unit_price')
                            <span style="color:red;">単価の入力は必須です。価格を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="regular_stock">定数<span class="badge badge-danger">必須</span></label>
                            <input type="number" class="form-control" id="regular_stock" name="regular_stock" placeholder="例）100個→100" value="{{ $item->regular_stock }}">
                            @error('regular_stock')
                            <span style="color:red;">定数の入力は必須です。数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="total_stock">総在庫数<span class="badge badge-danger">必須</span></label>
                            <input type="number" class="form-control" id="total_stock" name="total_stock" placeholder="例）100個→100" value="{{ $item->total_stock }}">
                            @error('total_stock')
                            <span style="color:red;">総在庫数の入力は必須です。数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kitchen_stock">調理場在庫数</label>
                            <input type="number" class="form-control" id="kitchen_stock" name="kitchen_stock" placeholder="例）50個→50" value="{{ $item->kitchen_stock }}">
                            @error('kitchen_stock')
                            <span style="color:red;">数値を入力してください。</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="second_stock">2階倉庫在庫数</label>
                            <input type="number" class="form-control" id="second_stock" name="second_stock" placeholder="例）50個→50" value="{{ $item->second_stock }}">
                            @error('second_stock')
                            <span style="color:red;">数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="smach_stock">破損数</label>
                            <input type="number" class="form-control" id="smach_stock" name="smach_stock" placeholder="例）100個→100" value="{{ $item->smach_stock }}">
                            @error('smach_stock')
                            <span style="color:red;">数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="detail">メモ</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3" placeholder="例）〇月〇日〇個発注→〇月〇日到着予定／ヤマダ">{{ $item->detail }}</textarea>
                            @error('detail')
                            <span style="color:red;">500文字以内で入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group" style="max-width: 300px;">
                            <label for="img_path">画像<span class="badge badge-danger">必須</span></label>
                            @if ($item->img_path)
                                <img src="{{ asset($item->img_path) }}" class="card-img-top" alt="食器画像">
                            @else
                                <p>画像はありません</p>
                            @endif
                            <input type="file" class="btn btn-light" id="img_path" name="img_path">
                            @error('img_path')
                                <span style="color:red;">画像の入力は必須です。</span>
                            @enderror
                        </div>


                        <div>
                            <label>利用時期（複数選択可）：</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="1" id="allYearCheckbox" name="seasons[]" {{ in_array(1, $selectedSeasons) ? 'checked' : '' }}>
                                <label class="form-check-label" for="allYearCheckbox">通年</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="2" id="springCheckbox" name="seasons[]" {{ in_array(2, $selectedSeasons) ? 'checked' : '' }}>
                                <label class="form-check-label" for="springCheckbox">春</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="3" id="summerCheckbox" name="seasons[]" {{ in_array(3, $selectedSeasons) ? 'checked' : '' }}>
                                <label class="form-check-label" for="summerCheckbox">夏</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="4" id="autumnCheckbox" name="seasons[]" {{ in_array(4, $selectedSeasons) ? 'checked' : '' }}>
                                <label class="form-check-label" for="autumnCheckbox">秋</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="5" id="winterCheckbox" name="seasons[]" {{ in_array(5, $selectedSeasons) ? 'checked' : '' }}>
                                <label class="form-check-label" for="winterCheckbox">冬</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">更新</button>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('items/show/' . $item->id) }}" class="btn btn-primary">戻る</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
        