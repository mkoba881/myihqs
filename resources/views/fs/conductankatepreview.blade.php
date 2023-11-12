{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート実施プレビュー画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="container white-second-transparent-box">
                    <h2>アンケート実施プレビュー画面</h2>
                    <h5>■取得対象のメールアドレス</h5>
                    <div class="list-news col-md-12 mx-auto">
                        @if (empty($csv_array))
                            <p style="color: red;">CSVがアップロードされていません。</p>
                        @else
                            <table class="table table-dark table-bordered border-light"> 
                              <thead>
                                <tr>
                                  <th>名前</th>
                                  <th>メールアドレス</th>
                                </tr>
                              </thead>
                                <tbody class="table table-light table-bordered border-dark">
                                    @foreach($csv_array as $array)
                                        @if($array[0] != "name" and $array[1] != "mailaddress")
                                            <tr>
                                              <td>{{ $array[0]}}</td>
                                              <td>{{ $array[1]}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <!--<h2>取得している変数、暫定表示後程削除</h2>-->
                <!--<p>{{var_dump($csv_array)}}</p>-->
                <div class="container white-second-transparent-box">
                    <h5>■アンケート回答メールフォーマット（ユーザー向け）</h5>
                        <p>{!!nl2br(e($form["user_mailformat"]))!!}</p>
                </div>
                <div class="container white-second-transparent-box">
                    <h5>■アンケート回答メールフォーマット（ユーザー向け催促用）</h5>
                        <p>{!! nl2br(e($form["remind_mailformat"])) !!}</p>
                </div>
                <div class="container white-second-transparent-box">
                    <h5>■アンケート回答メールフォーマット（管理者用）</h5>
                        <p>{!! nl2br(e($form["admin_mailformat"])) !!}</p>
                </div>
                <div class="container white-second-transparent-box">
                    <h5>■開始日</h5>
                        <p>{{$form["start"]}}</p>
                    <h5>■終了日</h5>
                        <p>{{$form["end"]}}</p>
                </div>
                <div class="container white-second-transparent-box">
                    <form action="{{ route('mail.save') }}" method="get">
                        <!--<input type="hidden" name="form" value="{{ json_encode($form) }}">-->
                        <input type="hidden" name="user_mailformat" value="<?=$form['user_mailformat']?>">
                        <input type="hidden" name="remind_mailformat" value="<?=$form['remind_mailformat']?>">
                        <input type="hidden" name="admin_mailformat" value="<?=$form['admin_mailformat']?>">
                        <input type="hidden" name="start" value="<?=$form['start']?>">
                        <input type="hidden" name="end" value="<?=$form['end']?>">
                        <input type="hidden" name="id" value="<?=$form['id']?>">
                        <!--@csrf-->
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary mx-auto" value="メール内容を確定する">
                        </div>
                    </form>
                    @php
                        session(['csv_array' => $csv_array]);
                    @endphp
                    <!--メール送信箇所        -->
                    <form action="{{ route('mail.testmail')}}" method="get">
                        <input type="hidden" name="user_mailformat" value="<?=$form['user_mailformat']?>">
                        <input type="hidden" name="remind_mailformat" value="<?=$form['remind_mailformat']?>">
                        <input type="hidden" name="admin_mailformat" value="<?=$form['admin_mailformat']?>">
                        <input type="hidden" name="start" value="<?=$form['start']?>">
                        <input type="hidden" name="end" value="<?=$form['end']?>">
                        <input type="hidden" name="id" value="<?=$form['id']?>">
                        <div class="text-center">
                            <input type="submit" value="送信" class="btn btn-primary mx-auto">
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 