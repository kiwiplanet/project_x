@extends('adminlte::page')

@section('title', '食器一覧')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center input-group-append ">
        <h1>食器一覧</h1>
        <div class="pull-right">
            <a href="{{ url('items/add') }}" class="btn btn-primary">新規登録</a>
            <div class="mt-3">
                <form id="sortForm" action="{{ url('items') }}" method="get">
                    <select id="sortSelect" class="form-select" aria-label="Default select example" name="sort">
                        <option value="newest">新しい順</option>
                        <option value="oldest">古い順</option>
                        <option value="most_stock">在庫多い順</option>
                        <option value="least_stock">在庫少ない順</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
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
                            <a href="{{ url('items/show/' . $item->id) }}" class="card-link btn btn-default">詳細</a>
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
    <script src="{{ asset('js/sort_items.js') }}"></script>
@stop
