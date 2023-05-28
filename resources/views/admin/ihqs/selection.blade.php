{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '機能選択画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>機能選択画面</h2>
            </div>
        </div>
        <div class="card-contents">
            <a href="{{ route('fs.management')}}">アンケートフォームを確認・作成・編集する</a>
        </div>
        <div class="card-contents">
            <a href="{{ route('fs.analysis')}}">アンケートを集計する</a>
        </div>
        <div class="card-contents">
            <a href="{{ route('fs.answer')}}">アンケートに回答する</a>
        </div>

    </div>
    <!--　ルーティング検討コード<form action="{{ route('fs.analysis') }}" method="get">
    <form action="{{ route('fs.answer') }}" method="get">
    <form action="{{ route('fs.management') }}" method="get">-->
@endsection