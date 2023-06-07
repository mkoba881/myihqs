{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート作成画面</h2>
                <form action="{{ route('fs.create') }}" method="post" enctype="multipart/form-data"><!--フォームの作成 -->
                    
                    @if (count($errors) > 0)<!-- `$errors` は `validate` で弾かれた内容を記憶する配列 -->
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    
                    <div class="form-group row">
                        <div class="form-group row">
                            <label class="col-md-2"><b>アンケート名</b></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <!--<div  class="example">-->
                        <div  class="example">
                            <!--<h2 class="col-md-1">Q1</h2>-->
                            <div class="form-group row">
                                <label class="col-md-2">Q1</label>
                                <label class="col-md-2">質問文</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="question" value="{{ old('question') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">選択肢</label>
                                <div class="col-md-10">
                                    <label class="col-md-2">①</label>
                                    <input type="text" class="form-control" name="option1" value="{{ old('option1') }}">
                                    <label class="col-md-2">②</label>
                                    <input type="text" class="form-control" name="option2" value="{{ old('option2') }}">
                                    <label class="col-md-2">③</label>
                                    <input type="text" class="form-control" nam e="option3" value="{{ old('option3') }}">
                                    <label class="col-md-2">④</label>
                                    <input type="text" class="form-control" name="option4" value="{{ old('option4') }}">
                                    <label class="col-md-2">⑤</label>
                                    <input type="text" class="form-control" name="option5" value="{{ old('option5') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">優先度</label>
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">参考リンク</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="rf_url" value="{{ old('rf_url') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">画像</label>
                                <div class="col-md-5">
                                    <input type="file" class="form-control-file" name="image">
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <input type="submit" class="btn btn-primary" value="次へ進む">
                </form>
            </div>
            <!--<div class="card-contents">-->
            <!--    <a href="{{ route('fs.makepreview')}}" class="btn btn-primary">次へ進む</a>-->
            <!--</div>-->
        </div>
    </div>
@endsection 