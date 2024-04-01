@extends('adminlte::page')

@section('title', '詳細画面')

@section('content_header')
    <h1>詳細画面</h1>
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
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">食器名：</label>{{ $item->name }}
                        </div>

                        <div class="form-group">
                            <label for="buyer">購入先：</label>{{ $item->buyer }}
                        </div>

                        <div class="form-group">
                            <!-- 小数点以下を表示させない PHPのnumber_format()関数 -->
                            <label for="unit_price">単価：</label>{{ number_format($item->unit_price) }}円
                        </div>

                        <div class="form-group">
                            <label for="regular_stock">定数：</label>{{ $item->regular_stock }}
                        </div>

                        <div class="form-group">
                            <label for="total_stock">総在庫数：</label>{{ $item->total_stock }}
                        </div>

                        <div class="form-group">
                            <label for="kitchen_stock">調理場在庫数：</label>{{ $item->kitchen_stock }}
                        </div>
                        
                        <div class="form-group">
                            <label for="second_stock">2階倉庫在庫数：</label>{{ $item->second_stock }}
                        </div>

                        <div class="form-group">
                            <label for="smach_stock">破損数：</label>{{ $item->smach_stock }}
                        </div>

                        <div class="form-group">
                            <label for="detail">メモ：</label>{{ $item->detail }}
                        </div>

                        <div class="form-group" style="max-width: 300px;">
                            <label for="img_path">画像：</label>
                            @if ($item->img_path)
                                <img src="{{ asset($item->img_path) }}" class="card-img-top" alt="食器画像">
                            @else
                                <p>画像はありません</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>利用時期：</label>
                                @if ($item->seasons)
                                    @foreach ($item->seasons as $season)
                                        {{ $season->name }}
                                        @if (!$loop->last)
                                            ・
                                        @endif
                                    @endforeach
                                @else
                                    設定がありません
                                @endif
                        </div>
                    </div>

                    </div>

                    <div class="card-footer">
                    <a href="{{ url('items/edit/' . $item->id) }}" class="btn btn-primary">編集</a>
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
        