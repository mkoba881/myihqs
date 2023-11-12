{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート実施画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('fs.conductankatepreview') }}" method="post" enctype="multipart/form-data">
                   @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>    
                    @endif
                    <div class="container white-second-transparent-box">
                        <div class="form-group row">
                            <h2>アンケート実施画面</h2>
                            <label name="csvFile">取得対象のメールアドレスのcsvファイル</label>
                            <input type="file" name="csvFile" class="csvFile"/>
                        </div>
                    </div>
                    <div class="container white-second-transparent-box">
                        <div class="form-group row">
                            <label class="col-md-2">アンケート回答メールフォーマット（ユーザー向け）</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="user_mailformat" rows="20">@empty(old('user_mailformat', $user_mailformat))@include('mailformats.user_mail_default')@else{{ old('user_mailformat', $user_mailformat) }}@endempty</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="container white-second-transparent-box">
                        <div class="form-group row">
                            <label class="col-md-2">アンケート回答メールフォーマット（ユーザー向け催促用）</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="remind_mailformat" rows="20">@empty(old('remind_mailformat', $remind_mailformat))@include('mailformats.remind_mail_default')@else{{ old('remind_mailformat', $remind_mailformat) }}@endempty</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="container white-second-transparent-box">
                        <div class="form-group row">
                            <label class="col-md-2">アンケート回答メールフォーマット（管理者用）</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="admin_mailformat" rows="20">@empty(old('admin_mailformat', $admin_mailformat))@include('mailformats.admin_mail_default')@else{{ old('admin_mailformat', $admin_mailformat) }}@endempty</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="container white-second-transparent-box">
                        <div class="form-group row">
                            <label class="col-md-2">開始日</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="start" value="{{ old('start', $start) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">終了日</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="end" value="{{ old('end', $end) }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="container white-second-transparent-box">
                        <div class="text-center">
                            <input type="hidden" name="id" value="<?=$id?>">
                            <a href="{{ route('fs.management')}}" class="btn btn-primary">前に戻る</a>
                            @csrf
                            <input type="submit" class="btn btn-primary" value="次へ進む">
                        </div>
                    </div>
                </form>
                <div class="inner">
                </div>
            </div>
        </div>
    </div>
@endsection 