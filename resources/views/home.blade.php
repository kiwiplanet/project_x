@extends('adminlte::page')

@section('title', 'ホーム画面')

@section('content_header')
@stop

@section('content')
    <div class="content-home">
        <p>日本料理</p>
        <h1>四季彩亭</h1>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zhi+Mang+Xing&display=swap" rel="stylesheet">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
