{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート編集画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>アンケート編集画面</h1>
                
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
                    <div class="alert alert-danger">開始日に入力が必要です。</div>
                    @php
                        $surveyInfoError = true; // 開始日のエラーがある場合にフラグを設定
                    @endphp
                @enderror
                
                {{-- 終了日のエラーメッセージ --}}
                @error('end')
                    <div class="alert alert-danger">終了日に入力が必要です。</div>
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
                        <div class="alert alert-danger">質問No、項目名に入力が必要です。</div>
                        @php
                            $imageError = true; // 質問名のエラーがある場合にフラグを設定
                        @endphp
                    @enderror
                    @error("sortorder{$i}")
                        <div class="alert alert-danger">並び順に入力が必要です。</div>
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
                {{ json_encode($oldPriorities) }}

                
                <form action="{{ route('fs.create') }}" method="post" enctype="multipart/form-data">
                     <!-- 既存のフォーマットIDを隠しフィールドとして追加 -->
                    <input type="hidden" name="format_id" value="{{ $format->id }}">
                    
                    @if ($errors->has('ankate_name') || $errors->has('start') || $errors->has('end') || $errors->has('questionCount'))
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    
                    <div class="form-group row">
                        <label class="col-md-2"><b>アンケート名</b></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="ankate_name" value="{{ old('ankate_name', $format->name) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">開始日</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="start" value="{{ old('start', $format->start) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">終了日</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="end" value="{{ old('end', $format->end) }}">
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-md-2">質問数</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" name="questionCount" value="{{ old('questionCount', count($items)) }}">
                        </div>
                    </div>
                
                    @if ($errors->has('questionCount'))
                        <div class="alert alert-danger">{{ $errors->first('questionCount') }}</div>
                    @endif
                
                    <div id="questions"
                         data-old-question-names="{{ json_encode($oldQuestionNames) }}"
                         data-old-questions="{{ json_encode($oldQuestions) }}"
                         data-old-options="{{ json_encode($oldOptions) }}"
                         data-old-priorities="{{ json_encode($oldPriorities) }}"
                         data-old-reference-links="{{ json_encode($oldReferenceLinks) }}"
                         data-old-sort-orders="{{ json_encode($oldSortOrders) }}">

                        @foreach($items as $index => $item)
                            <div class="question">
                                <label class="col-md-2" for="question_name{{ $index + 1 }}"><b><span style="color: red;">質問{{ $index + 1 }}の項目</span></b></label>
                                <div class="form-group row">
                                    <label class="col-md-2"><b>質問No、項目名</b></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="question_name{{ $index + 1 }}" id="question_name{{ $index + 1 }}" value="{{ old('question_name' . ($index + 1), $item->name) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2">質問文</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="question{{ $index + 1 }}" id="question{{ $index + 1 }}" value="{{ old('question' . ($index + 1), $details[$index]->question) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2">選択肢</label>
                                    <div class="col-md-10">
                                        <label class="col-md-2">①</label>
                                        <input type="text" class="form-control" name="option{{ $index + 1 }}_1" value="{{ old('option' . ($index + 1) . '_1', $details[$index]->option1) }}">
                                        <label class="col-md-2">②</label>
                                        <input type="text" class="form-control" name="option{{ $index + 1 }}_2" value="{{ old('option' . ($index + 1) . '_2', $details[$index]->option2) }}">
                                        <label class="col-md-2">③</label>
                                        <input type="text" class="form-control" name="option{{ $index + 1 }}_3" value="{{ old('option' . ($index + 1) . '_3', $details[$index]->option3) }}">
                                        <label class="col-md-2">④</label>
                                        <input type="text" class="form-control" name="option{{ $index + 1 }}_4" value="{{ old('option' . ($index + 1) . '_4', $details[$index]->option4) }}">
                                        <label class="col-md-2">⑤</label>
                                        <input type="text" class="form-control" name="option{{ $index + 1 }}_5" value="{{ old('option' . ($index + 1) . '_5', $details[$index]->option5) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2">優先度</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="priority{{ $index + 1 }}" value="{{ old('priority' . ($index + 1), $details[$index]->priority) }}">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2">参考リンク</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="rf_url{{ $index + 1 }}" value="{{ old('rf_url' . ($index + 1), $details[$index]->rf_url) }}">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-2">参考画像</label>
                                    <div class="col-md-5">
                                        @if ($details[$index]->has_reference_image)
                                            <input type="file" class="form-control-file edit-question-image-input" name="rf_image{{ $index + 1 }}">
                                            <span class="selected">選択済み</span>
                                        @else
                                            <input type="file" class="form-control-file edit-question-image-input" name="rf_image{{ $index + 1 }}">
                                            <span class="not-selected">未選択</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-2">並び順</label>
                                    <div class="col-md-10">
                                        <input type="number" class="form-control" name="sortorder{{ $index + 1 }}" value="{{ old('sortorder' . ($index + 1), $item->sortorder) }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        

                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">作成ステータス</label>
                        <select class="form-control" name="status">
                            <option value="1" @if ($format->status == 1) selected @endif>作成中（一時保存）</option>
                            <option value="2" @if ($format->status == 2) selected @endif>実施前（完成）</option>
                        </select>
                    </div>
                
                    @csrf
                    <input type="submit" class="button" value="次へ進む">
                    
                    <div class="card-contents">
                        <a class="button" href="{{ route('fs.management')}}">アンケート管理画面に戻る</a>
                    </div>
                    
                </form>
                
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/questionAdd.js') }}"></script>
@endsection
