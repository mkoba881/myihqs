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
                
                <p>{{$format}}</p>
                <p>{{$items}}</p>
                @foreach ($details as $detail)
                    <p>{{ $detail }}</p>
                @endforeach

                
                <form action="{{ route('fs.create') }}" method="post" enctype="multipart/form-data">
                     <!-- 既存のフォーマットIDを隠しフィールドとして追加 -->
                    <input type="hidden" name="format_id" value="{{ $format->id }}">
                    
                    @if (count($errors) > 0)
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
                
                    <div id="questions">
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
                                            <!--<img src="{{ secure_asset('uploads/' . $details[$index]->rf_image) }}">-->
                                            <input type="file" class="form-control-file" name="rf_image{{ $index + 1 }}">
                                            <span class="selected">選択済み</span>
                                        @else
                                            <input type="file" class="form-control-file" name="rf_image{{ $index + 1 }}">
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
                    <input type="submit" class="btn btn-primary" value="次へ進む">
                    <script>
                        // カウント数の変更時に質問部分を動的に表示する
                        const questionCountInput = document.querySelector('input[name="questionCount"]');
                        const questionsContainer = document.getElementById('questions');
                
                        questionCountInput.addEventListener('input', () => {
                            const questionCount = parseInt(questionCountInput.value);
                
                            // 現在の質問数を取得
                            const currentQuestionCount = questionsContainer.querySelectorAll('.question').length;
                
                            if (questionCount < 1) {
                                    questionsContainer.innerHTML = ''; // 質問部分を削除
                            } else if (questionCount > currentQuestionCount) {
                                // 新しく追加する質問部分の数を計算
                                const newQuestionCount = questionCount - currentQuestionCount;
                
                                // 質問部分を動的に追加
                                for (let i = 0; i < newQuestionCount; i++) {
                                    const questionIndex = currentQuestionCount + i + 1;
                
                                    const questionTemplate = `
                                        <div class="question">
                                            <label class="col-md-2" for="question_name${questionIndex}"><b><span style="color: red;">質問${questionIndex}の項目</span></b></label>
                                            <div class="form-group row">
                                                <label class="col-md-2"><b>質問No、項目名</b></label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="question_name${questionIndex}" id="question_name${questionIndex}" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2">質問文</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="question${questionIndex}" id="question${questionIndex}" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2">選択肢</label>
                                                <div class="col-md-10">
                                                    <label class="col-md-2">①</label>
                                                    <input type="text" class="form-control" name="option${questionIndex}_1" value="">
                                                    <label class="col-md-2">②</label>
                                                    <input type="text" class="form-control" name="option${questionIndex}_2" value="">
                                                    <label class="col-md-2">③</label>
                                                    <input type="text" class="form-control" name="option${questionIndex}_3" value="">
                                                    <label class="col-md-2">④</label>
                                                    <input type="text" class="form-control" name="option${questionIndex}_4" value="">
                                                    <label class="col-md-2">⑤</label>
                                                    <input type="text" class="form-control" name="option${questionIndex}_5" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2">優先度</label>
                                                <select class="form-control" name="priority${questionIndex}" value="">
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
                                                    <input type="text" class="form-control" name="rf_url${questionIndex}" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2">参考画像</label>
                                                <div class="col-md-5">
                                                    <input type="file" class="form-control-file" name="rf_image${questionIndex}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2">並び順</label>
                                                <div class="col-md-10">
                                                    <input type="number" class="form-control" name="sortorder${questionIndex}" value="">
                                                </div>
                                            </div>
                                        </div>
                                    `;
                
                                    questionsContainer.innerHTML += questionTemplate;
                                }
                            } else if (questionCount < currentQuestionCount) {
                                // 不要な質問部分を削除
                                const questionElements = questionsContainer.querySelectorAll('.question');
                                
                                for (let i = questionCount; i < currentQuestionCount; i++) {
                                    questionElements[i].remove();
                                }
                            }
                        });
                    </script>
                        
                </form>
            </div>
        </div>
    </div>
@endsection
