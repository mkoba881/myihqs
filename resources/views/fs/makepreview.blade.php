{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="container white-second-transparent-box">
                    <h2>アンケート作成プレビュー画面</h2>
                    <h2>アンケート名:{{$format -> name}}</h2>
                </div>
                
                {{-- 繰り返し処理で質問の詳細情報を表示 --}}
                @foreach ($items as $index => $item)
                    <div class="container white-second-transparent-box">
                        <h5><span style="color: red;">●質問No.{{$item->sortorder}} . {{$item->name}} </span></h5>
                        <h5>質問文 . {{$details[$index]->question}}</h5>
                        <h5>・回答の選択肢</h5>
                            @if ($details[$index]->option1)
                                <h5>①{{$details[$index]->option1}}</h5>
                            @endif
                            @if ($details[$index]->option2)
                                <h5>②{{$details[$index]->option2}}</h5>
                            @endif
                            @if ($details[$index]->option3)
                                <h5>③{{$details[$index]->option3}}</h5>
                            @endif
                            @if ($details[$index]->option4)
                                <h5>④{{$details[$index]->option4}}</h5>
                            @endif
                            @if ($details[$index]->option5)
                                <h5>⑤{{$details[$index]->option5}}</h5>
                            @endif
                        <!-- その他のコード -->
                        
                        <!-- 街頭の番号の非表示 -->
                        @if ($details[$index]->option1 || $details[$index]->option2 || $details[$index]->option3 || $details[$index]->option4 || $details[$index]->option5)
                            <form>
                                <div class="form-group row">
                                    <select class="form-control">
                                        @if ($details[$index]->option1)
                                            <option>①</option>
                                        @endif
                                        @if ($details[$index]->option2)
                                            <option>②</option>
                                        @endif
                                        @if ($details[$index]->option3)
                                            <option>③</option>
                                        @endif
                                        @if ($details[$index]->option4)
                                            <option>④</option>
                                        @endif
                                        @if ($details[$index]->option5)
                                            <option>⑤</option>
                                        @endif
                                    </select>
                                </div>
                            </form>
                        @endif
                        
                        <h5>・優先度</h5>
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
                        <h5>・参考リンク</h5>
                        <a href={{$details[$index] -> rf_url}} target="_blank">{{$details[$index] -> rf_url}}</a>
                        <h5>・参考画像</h5>
                        <div class="image">
                            @if ($details[$index] ->rf_image)
                                    <img src="{{ secure_asset('uploads/' . $details[$index]->rf_image) }}">
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="container white-second-transparent-box">
                    <div class="card-contents text-center">
                        <a href="{{ route('fs.management')}}" class="btn btn-primary">作成完了</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 