{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>アンケート作成プレビュー画面</h1>
                <h2>アンケート名:{{$format -> name}}</h2>
                <h2>{{$item -> name}} .{{$detail -> question}}</h2>
                <h2>・回答の選択肢</h2>
                <h3>①{{$detail -> option1}}</h3>
                <h3>②{{$detail -> option2}}</h3>
                <h3>③{{$detail -> option3}}</h3>
                <h3>④{{$detail -> option4}}</h3>
                <h3>⑤{{$detail -> option5}}</h3>
                <form>
                    <div class="form-group row">
                        <select class="form-control">
                            <option>①</option>
                            <option>②</option>
                            <option>③</option>
                            <option>④</option>
                            <option>⑤</option>
                        </select>
                    </div>
                </form>
                <h2>・優先度</h2>
                <form>
                    <div class="form-group row">
                        <select class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </form>
                <h2>・参考リンク</h2>
                <h3>{{$detail -> rf_url}}</h3>
                <h2>・参考画像</h2>
                <!--<img src={{$detail->rf_image}}>-->
                <div class="image">
                    @if ($detail ->rf_image)
                            <img src="{{ secure_asset('uploads/' . $detail->rf_image) }}">
                            <!--<img src="{{ asset('uploads')}}/{{$detail->rf_image}}" alt="{{ $detail->rf_image }}">-->
                    @endif
                </div>
            </div>
            <p>{{$format -> id}}</p>
            <p>{{$format}}</p>
            <p>{{$item}}</p>
            <p>{{$detail}}</p>
            <div class="card-contents">
                <a href="{{ route('fs.make')}}" class="btn btn-primary">作成画面に戻る</a>
                <a href="{{ route('fs.management')}}" class="btn btn-primary">作成完了</a>
            </div>
        </div>
    </div>
@endsection 