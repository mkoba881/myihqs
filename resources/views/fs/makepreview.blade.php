{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート作成プレビュー画面</h2>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.make')}}">作成画面に戻る</a>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.management')}}">作成完了</a>
            </div>
        </div>
    </div>
@endsection 