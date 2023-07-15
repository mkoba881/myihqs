{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート回答画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('fs.answerend') }}" method="post" enctype="multipart/form-data">
                    <h1>アンケート回答画面</h1>
                    <h2>アンケート名:{{$format[0]["name"]}}</h2>
                    <h2>{{$item[0]["name"]}} .{{$detail[0]["question"]}}</h2>
                    <h2>・回答の選択肢</h2>
                    <h3>①{{$detail[0]["option1"]}}</h3>
                    <h3>②{{$detail[0]["option2"]}}</h3>
                    <h3>③{{$detail[0]["option3"]}}</h3>
                    <h3>④{{$detail[0]["option4"]}}</h3>
                    <h3>⑤{{$detail[0]["option5"]}}</h3>
                    
                    <div class="form-group row" style="margin-bottom: 30px;">
                        <select class="form-control" name="answer_result">
                            <option value="1">①</option>
                            <option value="2">②</option>
                            <option value="3">③</option>
                            <option value="4">④</option>
                            <option value="5">⑤</option>
                        </select>
                    </div>
                    <h2>・優先度</h2>
                    <div class="form-group row" style="margin-bottom: 30px;">
                        <select class="form-control" name="priority">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    
                    <h2>・参考リンク</h2>
                    <h2 style="margin-bottom: 30px;">{{$detail[0]["rf_url"]}}</h2>
                    <div  style="margin-bottom: 30px;">
                        <h2>参考画像</h2>
                        @if ($detail[0]["rf_image"])
                            <img src="{{ secure_asset('uploads/' . $detail[0]["rf_image"]) }}">
                        @endif
                        <!--<a href="$detail[0]["rf_url"]" target="_blank">{{$detail[0]["rf_url"]}}</a>-->
                    </div>
                    <input type="hidden" name="detail_id" value="<?=$detail[0]["id"]?>">
                    
                    
                    @csrf
                   <input type="submit" class="btn btn-primary" value="アンケートを終了する" style="margin-bottom: 30px;">
                </form>
                
                <h2>以下は後程削除</h2>
                <p>{{$format}}</p>
                <p>{{$item}}</p>
                <p>{{$detail}}</p>
            </div>
        </div>
    </div>
@endsection