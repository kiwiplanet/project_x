@extends('adminlte::page')

@section('title', '検索結果')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center input-group-append ">
        <h1>検索結果</h1>
        <div class="pull-right">
            <a href="{{ url('items/search/') }}" class="btn btn-primary">検索画面に戻る</a>
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
    @if ($results->isEmpty())
        <p>検索結果が見つかりませんでした。</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
            @foreach ($results as $result)
                <div class="col mb-4">
                    <div class="card card-sm" style="width: 85%;">
                        <!-- ブックマーク追加フォーム -->
                        @if (!Auth::user()->is_bookmark($result->id))
                        <form action="{{ route('bookmark.store', $result->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $result->id }}">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-bookmark-star"></i></button>
                        </form>
                        @else
                        <!-- ブックマーク削除フォーム -->
                        <form action="{{ route('bookmark.destroy', $result->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-bookmark-star-fill"></i></button>
                        </form>
                        @endif
                            <img src="{{ asset($result->img_path) }}" class="card-img-top" alt="{{ $result->name }}">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">食器名：{{ $result->name }}</li>
                                        <li class="list-group-item">定数：{{ $result->regular_stock }}</li>
                                        <li class="list-group-item">総在庫数：{{ $result->total_stock }}</li>
                                        <li class="list-group-item">利用時期：
                                            @if ($result->seasons)
                                                @foreach ($result->seasons as $season)
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
                                    <a href="{{ url('items/show/' . $result->id) }}" class="card-link btn btn-default">詳細</a>
                                </div>
                    </div>
                </div>
            @endforeach
        </div>
    <!-- ページネーション onEachSideで表示されるページ番号の数を制御-->
    {!! $results->onEachSide(1)->links('pagination::bootstrap-5') !!}
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@stop

@section('js')
    <script src="{{ asset('js/sort_items.js') }}"></script>
@stop