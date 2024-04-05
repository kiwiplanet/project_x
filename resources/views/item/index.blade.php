@extends('adminlte::page')

@section('title', '食器一覧')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center input-group-append ">
        <h1>食器一覧</h1>
        <div class="pull-right">
            <a href="{{ url('items/add') }}" class="btn btn-primary">新規登録</a>
            <div class="mt-3">
                <select id="sortOptions">
                    <option value="newest">新しい順</option>
                    <option value="oldest">古い順</option>
                    <option value="mostStock">在庫多い順</option>
                    <option value="leastStock">在庫少ない順</option>
                </select>
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
                    <!-- ブックマーク追加フォーム -->
                    @if (!Auth::user()->is_bookmark($item->id))
                    <form action="{{ route('bookmark.store', $item) }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-bookmark-star"></i></button>
                    </form>
                    @else
                    <!-- ブックマーク削除フォーム -->
                    <form action="{{ route('bookmark.destroy', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-bookmark-star-fill"></i></button>
                    </form>
                    @endif
                    <img src="{{ asset($item->img_path) }}" class="card-img-top" alt="{{ $item->name }}">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">食器名：{{ $item->name }}</li>
                            <li class="list-group-item">定数：{{ $item->regular_stock }}</li>
                            <!-- 三項演算子を用いて下回った時に黄色になる -->
                            <li class="list-group-item {{ $item->total_stock < $item->regular_stock ? 'yellow-background' : '' }}">
                                総在庫数：{{ $item->total_stock }}</li>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/custom.css">
@stop

@section('js')
    <script src="{{ asset('js/sort_items.js') }}"></script>
@stop
