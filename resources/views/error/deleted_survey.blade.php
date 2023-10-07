{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '削除されたアンケート回答画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>Error</h1>
                <p>アンケートが削除されてます。</p>
                <!-- 他のコンテンツやリンクをここに追加できます -->
            </div>
        </div>
    </div>
</body>
@endsection 