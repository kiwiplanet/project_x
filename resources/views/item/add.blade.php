@extends('adminlte::page')

@section('title', '新規登録')

@section('content_header')
    <h1>新規登録</h1>
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
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前<span class="badge badge-danger">必須</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
                            @error('name')
                            <span style="color:red;">名前の入力は必須です。（100文字以内）</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="buyer">購入先<span class="badge badge-danger">必須</span></label>
                            <input type="text" class="form-control" id="buyer" name="buyer" placeholder="購入先">
                            @error('buyer')
                            <span style="color:red;">購入先の入力は必須です。（411文字以内）</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit_price">単価<span class="badge badge-danger">必須</span></label>
                            <input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="単価">
                            @error('unit_price')
                            <span style="color:red;">単価の入力は必須です。価格を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="regular_stock">定数<span class="badge badge-danger">必須</span></label>
                            <input type="number" class="form-control" id="regular_stock" name="regular_stock" placeholder="定数">
                            @error('regular_stock')
                            <span style="color:red;">定数の入力は必須です。数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="total_stock">総在庫数<span class="badge badge-danger">必須</span></label>
                            <input type="number" class="form-control" id="total_stock" name="total_stock" placeholder="総在庫数">
                            @error('total_stock')
                            <span style="color:red;">総在庫数の入力は必須です。数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kitchen_stock">調理場在庫数</label>
                            <input type="number" class="form-control" id="kitchen_stock" name="kitchen_stock" placeholder="調理場在庫数">
                            @error('kitchen_stock')
                            <span style="color:red;">数値を入力してください。</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="second_stock">2階倉庫在庫数</label>
                            <input type="number" class="form-control" id="second_stock" name="second_stock" placeholder="2階倉庫在庫数">
                            @error('second_stock')
                            <span style="color:red;">数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="smach_stock">破損数</label>
                            <input type="number" class="form-control" id="smach_stock" name="smach_stock" placeholder="破損数">
                            @error('smach_stock')
                            <span style="color:red;">数値を入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="detail">メモ</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
                            @error('detail')
                            <span style="color:red;">500文字以内で入力してください。</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="img_path">画像<span class="badge badge-danger">必須</span></label>
                            <input type="file" class="btn btn-light" id="img_path" name="img_path">
                            @error('img_path')
                            <span style="color:red;">画像の入力は必須です。</span>
                            @enderror
                        </div>

                        <div>
                            <label>利用時期（複数選択可）：</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="1" id="allYearCheckbox" name="seasons[]">
                                <label class="form-check-label" for="allYearCheckbox">通年</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="2" id="springCheckbox" name="seasons[]">
                                <label class="form-check-label" for="springCheckbox">春</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="3" id="summerCheckbox" name="seasons[]">
                                <label class="form-check-label" for="summerCheckbox">夏</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="4" id="autumnCheckbox" name="seasons[]">
                                <label class="form-check-label" for="autumnCheckbox">秋</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="5" id="winterCheckbox" name="seasons[]">
                                <label class="form-check-label" for="winterCheckbox">冬</label>
                            </div>
                        </div>
                    </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
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
        