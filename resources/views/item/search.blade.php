@extends('adminlte::page')

@section('title', '検索画面')

@section('content_header')
    <h1>検索</h1>
@stop

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="search-body">
        <form action="{{ route('items.result') }}" method="GET">
        @csrf
            <div class="keyword-serch">
                <label class="search-title">キーワード検索</label>
                <div class="input-group keyword-group">
                    <input type="search" class="form-control rounded form-keyword " name="keyword" placeholder="キーワードを入力" aria-label="Search" aria-describedby="search-addon" />
                    <button type="submit" class="btn btn-outline-primary" data-mdb-ripple-init>検索</button>
                </div>
            </div>
            <div class="category-serch mt-3"><label class="search-title">利用時期から探す（複数選択可）</label>
                <div class="input-group category-group">
                    <div class="form-check form-check-inline checkbox-search">
                        <input class="form-check-input" type="checkbox" value="1" id="allYearCheckbox" name="seasons[]">
                        <label class="form-check-label" for="allYearCheckbox">通年</label>
                    </div>
                    <div class="form-check form-check-inline checkbox-search">
                        <input class="form-check-input" type="checkbox" value="2" id="springCheckbox" name="seasons[]">
                        <label class="form-check-label" for="springCheckbox">春</label>
                    </div>
                    <div class="form-check form-check-inline checkbox-search">
                        <input class="form-check-input" type="checkbox" value="3" id="summerCheckbox" name="seasons[]">
                        <label class="form-check-label" for="summerCheckbox">夏</label>
                    </div>
                    <div class="form-check form-check-inline checkbox-search">
                        <input class="form-check-input" type="checkbox" value="4" id="autumnCheckbox" name="seasons[]">
                        <label class="form-check-label" for="autumnCheckbox">秋</label>
                    </div>
                    <div class="form-check form-check-inline checkbox-search">
                        <input class="form-check-input" type="checkbox" value="5" id="winterCheckbox" name="seasons[]">
                        <label class="form-check-label" for="winterCheckbox">冬</label>
                    </div>
                </div>
            </div>
            <div class="form-footer mt-5">
                <button type="submit" class="btn btn-outline-primary w-50">この条件で検索</button>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/custom.css">
@stop

@section('js')
@stop
