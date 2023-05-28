{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート管理画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート管理画面</h2>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.make')}}">アンケートフォームを作成する</a>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.make')}}">アンケートフォームを編集する</a>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.deleteqn')}}">アンケートフォームを削除する</a>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.conductqn')}}">アンケートを実施する</a>
            </div>
        </div>
    </div>
@endsection 