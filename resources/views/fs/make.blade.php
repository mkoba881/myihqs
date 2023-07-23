{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>アンケート作成画面</h1>
                
                <form action="{{ route('fs.create') }}" method="post" enctype="multipart/form-data">
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
                
                    @if ($errors->has('questionCount'))
                        <div class="alert alert-danger">{{ $errors->first('questionCount') }}</div>
                    @endif
                
                    <!--@php-->
                        //$questionCount = old('questionCount');
                    <!--@endphp-->
                
                    <div id="questions"></div> <!-- 追加 -->
                
                
                    
                    <div class="form-group row">
                        <label class="col-md-2">作成ステータス</label>
                        <select class="form-control" name="status" value="{{ old('status') }}">-->
                            <option value=1>作成中（一時保存）</option>
                            <option value=2>実施前（完成）</option>
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
            <!--<div class="card-contents">-->
            <!--    <a href="{{ route('fs.makepreview')}}" class="btn btn-primary">次へ進む</a>-->
            <!--</div>-->
        </div>
    </div>
@endsection 