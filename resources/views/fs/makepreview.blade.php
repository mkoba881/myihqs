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
                
                {{-- 繰り返し処理で質問の詳細情報を表示 --}}
                @foreach ($items as $index => $item)
                    <h2><b><span style="color: red;">●質問No.{{$item->sortorder}} . {{$item->name}} </span></b></h2>
                    <h2>質問文 . {{$details[$index]->question}}</h2>
                    <h2>・回答の選択肢</h2>
                    <h3>①{{$details[$index]->option1}}</h3>
                    <h3>②{{$details[$index]->option2}}</h3>
                    <h3>③{{$details[$index]->option3}}</h3>
                    <h3>④{{$details[$index]->option4}}</h3>
                    <h3>⑤{{$details[$index]->option5}}</h3>
                    <!-- その他のコード -->
                
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
                    <h3>{{$details[$index] -> rf_url}}</h3>
                    <h2>・参考画像</h2>
                    <div class="image">
                        @if ($details[$index] ->rf_image)
                                <img src="{{ secure_asset('uploads/' . $details[$index]->rf_image) }}">
                        @endif
                    </div>
                    
                @endforeach
            </div>
            <!--<p>{{$format -> id}}</p>-->
            <!--<p>{{$format}}</p>-->
            <!--<p>{{$item}}</p>-->
            <!--<p>{{var_dump($details)}}</p>-->
            <div class="card-contents">
                <a href="{{ route('fs.management')}}" class="btn btn-primary">作成完了</a>
            </div>
        </div>
    </div>
@endsection 