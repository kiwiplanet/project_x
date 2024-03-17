@extends('adminlte::page')

@section('title', '食器一覧')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>食器一覧</h1>
        <div class="input-group-append ">
            <a href="{{ url('items/add') }}" class="btn btn-default">新規登録</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
        @foreach ($items as $item)
            <div class="col mb-4">
                <div class="card card-sm" style="width: 85%;">    
                    <img src="{{ asset($item->img_path) }}" class="card-img-top" alt="{{ $item->name }}">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">食器名：{{ $item->name }}</li>
                            <li class="list-group-item">定数：{{ $item->regular_stock }}</li>
                            <li class="list-group-item">総在庫数：{{ $item->total_stock }}</li>
                            <li class="list-group-item">利用時期：
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
                            </li>
                        </ul>
                        <a href="{{ url('items/detail') }}" class="card-link btn btn-default">詳細</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- ページネーション onEachSideで表示されるページ番号の数を制御-->
    {!! $items->onEachSide(1)->links('pagination::bootstrap-5') !!}
@stop

@section('css')
@stop

@section('js')
@stop
