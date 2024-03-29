{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '機能選択画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container welcome-container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>機能選択画面</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            @if (Auth::user()->isAdmin())
                <div class="card-contents mb-4 text-center">
                    <a class="button" href="{{ route('fs.management')}}">アンケートフォームを確認・作成・編集する</a>
                </div>
                <div class="card-contents mb-4 text-center">
                    <a class="button" href="{{ route('fs.analysis')}}">アンケートを集計する</a>
                </div>
                {{-- ここに管理者専用のリンクを追加 --}}
                <div class="card-contents mb-4 text-center">
                    <a class="button" href="{{ route('admin.assign_role_form')}}">管理者権限を付与する</a>
                </div>
            @endif
            <div class="card-contents text-center">
                <a class="button" href="{{ route('fs.selectanswer')}}">アンケートに回答する</a>
            </div>
        </div>
    </div>
    

    
@endsection