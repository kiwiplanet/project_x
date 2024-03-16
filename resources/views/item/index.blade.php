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
    <div class="row">
        <div class="col-12">
            @foreach ($items as $item)
                <div class="card" style="width: 18rem;">    
                    <img src="{{ asset($item->img_path) }}" class="card-img-top" alt="{{ $item->name }}">
                    <ul class="list-group list-group-flush">
                            <li class="list-group-item">食器名：{{ $item->name }}</li>
                            <li class="list-group-item">定数：{{ $item->regular_stock }}</li>
                            <li class="list-group-item">総在庫数：{{ $item->total_stock }}</li>
                            <li class="list-group-item">利用時期：中間テーブル</li>
                    </ul>
                    <div class="card-body">
                        <a href="{{ url('items/detail') }}" class="card-link btn btn-default">詳細</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
