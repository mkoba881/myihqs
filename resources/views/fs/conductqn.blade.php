{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート実施画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート実施画面</h2>
            </div>
            <div class="content">
                <div class="inner">
                    <a href="{{ route('fs.management')}}" class="btn btn-primary">前に戻る</a>
                    <a href="{{ route('fs.conductqnpreview')}}" class="btn btn-primary">次へ進む</a>
                </div>
            </div>

            
        </div>
    </div>
@endsection 