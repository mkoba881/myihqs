{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                
                @php
                    $imageError = false; // 画像エラーのフラグを初期化
                    $surveyInfoError = false; // アンケート情報のエラーフラグを初期化
                @endphp
                
                {{-- アンケート名のエラーメッセージ --}}
                @error('ankate_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @php
                        $surveyInfoError = true; // アンケート名のエラーがある場合にフラグを設定
                    @endphp
                @enderror
                
                {{-- 開始日のエラーメッセージ --}}
                @error('start')
                    <div class="alert alert-danger">開始日が空欄または正しくない値のため、開始日に入力が必要です。</div>
                    @php
                        $surveyInfoError = true; // 開始日のエラーがある場合にフラグを設定
                    @endphp
                @enderror
                
                {{-- 終了日のエラーメッセージ --}}
                @error('end')
                    <div class="alert alert-danger">終了日が空欄または正しくない値のため、終了日に入力が必要です。</div>
                    @php
                        $surveyInfoError = true; // 終了日のエラーがある場合にフラグを設定
                    @endphp
                @enderror
                
                {{-- 質問数のエラーメッセージ --}}
                @error('questionCount')
                    <div class="alert alert-danger">質問数に入力が必要です。</div>
                    @php
                        $surveyInfoError = true; // 質問数のエラーがある場合にフラグを設定
                    @endphp
                @enderror
                
                {{-- 質問と並び順のエラーメッセージ --}}
                @for ($i = 1; $i <= old('questionCount', 0); $i++)
                
                    @error("question{$i}")
                        <div class="alert alert-danger">質問 {{ $i }} に入力が必要です。</div>
                        @php
                            $imageError = true; // 質問のエラーがある場合にフラグを設定
                        @endphp
                    @enderror
                    @error("question_name{$i}")
                        <div class="alert alert-danger">質問 {{ $i }}の質問No、項目名に入力が必要です。</div>
                        @php
                            $imageError = true; // 質問名のエラーがある場合にフラグを設定
                        @endphp
                    @enderror
                    @error("sortorder{$i}")
                        <div class="alert alert-danger">質問 {{ $i }}の並び順に入力が必要です。</div>
                        @php
                            $imageError = true; // 並び順のエラーがある場合にフラグを設定
                        @endphp
                    @enderror
                @endfor
                
                {{-- 画像またはアンケート情報のエラーメッセージ --}}
                @if ($imageError || $surveyInfoError)
                    <div class="alert alert-danger">参考画像が必要な場合お手数ですが再度設定してください。</div>
                @endif
                
                @php
                    $oldQuestionNames = [];
                    $oldQuestions = [];
                    $oldOptions = [];
                    $oldPriorities = [];
                    $oldReferenceLinks = [];
                    $oldSortOrders = [];
                    
                    for ($i = 1; $i <= old('questionCount', 0); $i++) {
                        $oldQuestionNames[$i] = old("question_name{$i}", '');
                        $oldQuestions[$i] = old("question{$i}", '');
                        $oldOptions[$i] = [];
                        for ($j = 1; $j <= 5; $j++) {
                            $oldOptions[$i][] = old("option{$i}_{$j}", '');
                        }
                        $oldPriorities[$i] = old("priority{$i}", '');
                        $oldReferenceLinks[$i] = old("rf_url{$i}", '');
                        $oldSortOrders[$i] = old("sortorder{$i}", '');
                    }
                @endphp
                

                <form action="{{ route('fs.create') }}" method="post" enctype="multipart/form-data">
                    
                    <div class="container white-second-transparent-box">
                        <h1>アンケート作成画面</h1>
                        <div class="form-group row">
                            <label class="col-md-2"><b>アンケート名</b></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="ankate_name" value="{{ old('ankate_name') }}">
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
                    
                        <div class="form-group row">
                            <label class="col-md-2">質問数</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="questionCount" value="{{ old('questionCount') }}">
                            </div>
                        </div>
                    </div>
                
                    <div id="questions" 
                         data-old-question-names="{{ json_encode($oldQuestionNames) }}"
                         data-old-questions="{{ json_encode($oldQuestions) }}"
                         data-old-options="{{ json_encode($oldOptions) }}"
                         data-old-priorities="{{ json_encode($oldPriorities) }}"
                         data-old-reference-links="{{ json_encode($oldReferenceLinks) }}"
                         data-old-sort-orders="{{ json_encode($oldSortOrders) }}">
                    </div>
                    
                    <div class="container  white-second-transparent-box">
                        <div class="form-group row">
                            <label class="col-md-2">作成ステータス</label>
                            <select class="form-control" name="status" value="{{ old('status') }}">-->
                                <option value=1>作成中（一時保存）</option>
                                <option value=2>実施前（完成）</option>
                            </select>
                        </div>
                        @csrf
                        <div class="text-center">
                            <input type="submit" class="button" id="nextButton" value="次へ進む">
                        </div>
                        <div id="duplicateMessage" style="color: red;"></div>
    
                        
                        <div class="card-contents text-center">
                            <a class="button" href="{{ route('fs.management')}}">アンケート管理画面に戻る</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/questionAdd.js') }}"></script>

@endsection 