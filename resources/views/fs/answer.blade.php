{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート回答画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート回答画面</h2>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.answerend')}}">アンケートフォームを終了する</a>
            </div>
        </div>
    </div>
@endsection