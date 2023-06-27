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
                <form action="{{ route('fs.conductankatepreview') }}" method="post" enctype="multipart/form-data">
                   @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif    
                    <div class="form-group row">
                        <div class="col-md-10"> 
                            <label name="csvFile">取得対象のメールアドレスのcsvファイル</label>
                            <input type="file" name="csvFile" class="csvFile"/>
                            <!--<input type="submit"></input>-->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">アンケート回答メールフォーマット（ユーザー向け）</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="user_mailformat" rows="20">{{ old('user_mailformat') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">アンケート回答メールフォーマット（ユーザー向け催促用）</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="remind_mailformat" rows="20">{{ old('remind_mailformat') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">アンケート回答メールフォーマット（管理者用）</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="admin_mailformat" rows="20">{{ old('admin_mailformat') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">開始日</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="start" value="{{ old('start') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">終了日</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="end" value="{{ old('end') }}">
                        </div>
                    </div>
                    <!--<div class="form-group row">-->
                    <!--    <label class="col-md-2">何日ごとに催促するか</label>-->
                    <!--    <div class="col-md-10">-->
                    <!--        <input type="text" class="form-control" name="remind_day" value="{{ old('remind_day') }}">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <a href="{{ route('fs.management')}}" class="btn btn-primary">前に戻る</a>
                    @csrf
                    <input type="submit" class="btn btn-primary" value="次へ進む">
                </form>
                <div class="inner">
                </div>
            </div>
        </div>
    </div>
@endsection 