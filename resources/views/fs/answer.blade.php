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
                    <h2>アンケート名: {{ $format[0]["name"] }}</h2>
                    
                    @foreach ($items as $index => $item)
                        <h2>{{ $item["name"] }}. {{ $details[$index]["question"] }}</h2>
                        <h2>・回答の選択肢</h2>
                        <h3>①{{ $details[$index]["option1"] }}</h3>
                        <h3>②{{ $details[$index]["option2"] }}</h3>
                        <h3>③{{ $details[$index]["option3"] }}</h3>
                        <h3>④{{ $details[$index]["option4"] }}</h3>
                        <h3>⑤{{ $details[$index]["option5"] }}</h3>
                        
                        <div class="form-group row" style="margin-bottom: 30px;">
                            <select class="form-control" name="answer_result[{{ $index }}]">
                                <option value="1" {{ $answers[$index]->answer_result === 1 ? 'selected' : '' }}>①</option>
                                <option value="2" {{ $answers[$index]->answer_result === 2 ? 'selected' : '' }}>②</option>
                                <option value="3" {{ $answers[$index]->answer_result === 3 ? 'selected' : '' }}>③</option>
                                <option value="4" {{ $answers[$index]->answer_result === 4 ? 'selected' : '' }}>④</option>
                                <option value="5" {{ $answers[$index]->answer_result === 5 ? 'selected' : '' }}>⑤</option>
                            </select>
                        </div>
                        
                        <h2>・優先度</h2>
                        <div class="form-group row" style="margin-bottom: 30px;">
                            <select class="form-control" name="priority[{{ $index }}]">
                                <option value="1" {{ $answers[$index]->priority === 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $answers[$index]->priority === 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $answers[$index]->priority === 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ $answers[$index]->priority === 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ $answers[$index]->priority === 5 ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                        
                        <h2>・参考リンク</h2>
                        <div style="margin-bottom: 30px;">
                            <a href="{{ $details[$index]["rf_url"] }}" target="_blank" >{{ $details[$index]["rf_url"] }}</a>
                        </div>
                        <div style="margin-bottom: 30px;">
                            <h2>・参考画像</h2>
                            @if ($details[$index]["rf_image"])
                                <img src="{{ secure_asset('uploads/' . $details[$index]["rf_image"]) }}">
                            @endif
                        </div>
                        
                        <input type="hidden" name="format_id" value="{{ $format[0]["id"] }}">
                        <input type="hidden" name="item_id[{{ $index }}][]" value="{{ $item["id"] }}">
                        <input type="hidden" name="detail_id[{{ $index }}][]" value="{{ $details[$index]["id"] }}">

                        
                        <!--<input type="hidden" name="format_id" value="{{ $format[0]["id"] }}">-->
                        <!--<input type="hidden" name="item_id[{{ $index }}]" value="{{ $item["id"] }}">-->
                        <!--<input type="hidden" name="detail_id[{{ $index }}]" value="{{ $details[$index]["id"] }}">-->
                    @endforeach
                    @csrf
                    <input type="submit" class="btn btn-primary" value="アンケートを終了する" style="margin-bottom: 30px;">
                </form>

                <h2>以下は後程削除</h2>
                <p>{{$format}}</p>
                <p>{{$items}}</p>
                <p>{{$details}}</p>
            </div>
        </div>
    </div>
@endsection