{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート実施プレビュー画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>アンケート実施プレビュー画面</h1>
                <h2>取得対象のメールアドレス</h2>
                <p>{{$form["csvFile"]}}</p>
                <h2>アンケート回答メールフォーマット（ユーザー向け）</h2>
                <p>{{$form["user_mailformat"]}}</p>
                <h2>アンケート回答メールフォーマット（ユーザー向け催促用）</h2>
                <p>{{$form["remind_mailformat"]}}</p>
                <h2>アンケート回答メールフォーマット（管理者用）</h2>
                <p>{{$form["admin_mailformat"]}}</p>
            </div>
            <p>以下は暫定表示後程削除</p>
            <textarea class="hight-adjust">{{var_dump($form)}}</textarea>
            <p>{{$form["user_mailformat"]}}</p>
            
            <form action="{{ route('fs.conductankatepreview') }}" method="post" enctype="multipart/form-data">
            </form>
            <div class="card-contents">
                <a href="{{ route('fs.conductankate')}}" class="btn btn-primary">前に戻る</a>
                <a href="{{ route('fs.management')}}" class="btn btn-primary">完了</a>
            </div>
        </div>
    </div>
@endsection 