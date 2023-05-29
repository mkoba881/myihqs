{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート削除画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート削除画面</h2>
            </div>
            <div class="col-md-8 mx-auto">
                <h3>本当に削除していいですか？</h3>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.management')}}" class="btn btn-primary">いいえ</a>
                <a href="{{ route('fs.management')}}" class="btn btn-primary">はい</a>
            </div>
        </div>
    </div>
@endsection 