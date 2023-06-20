{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')
            

{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート管理画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート管理画面</h2>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.make')}}">アンケートフォームを作成する</a>
            </div>
            <h3>アンケート一覧</h3>
            <div class="row">
                <div class="list-news col-md-12 mx-auto">
                    <table class="table table-dark table-bordered border-light"> 
                    <!--<table class="table table-dark table-bordered border-dark"> -->
                      <thead>
                        <tr>
                          <th>アンケートID</th>
                          <th>アンケート名</th>
                          <th>前回実施日</th>
                          <th>作成日</th>
                          <th>更新日</th>
                        </tr>
                      </thead>
                        <tbody class="table table-light table-bordered border-dark">
                            @foreach($formats as $ankate)
                                <tr>
                                  <th>{{ $ankate->id}}</th>
                                  <th>{{ $ankate->name}}</th>
                                  <th>{{ $ankate->previous_at}}</th>
                                  <th>{{ $ankate->created_at}}</th>
                                  <th>{{ $ankate->updated_at}}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <p>{{$formats}}</p>
            <div class="card-contents">
                <a href="{{ route('fs.conductqn')}}">アンケートを実施する</a>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.make')}}">アンケートフォームを編集する</a>
            </div>
            <div class="card-contents">
                <a href="{{ route('fs.deleteankate')}}">アンケートフォームを削除する</a>
            </div>
        </div>
    </div>
@endsection 