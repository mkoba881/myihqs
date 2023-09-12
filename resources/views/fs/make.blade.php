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
                
                @for ($i = 1; $i <= old('questionCount', 0); $i++)
                    @error("question{$i}")
                        <div class="alert alert-danger">質問 {{ $i }} に入力が必要です。</div>
                    @enderror
                    @error("question_name{$i}")
                        <div class="alert alert-danger">質問No、項目名に入力が必要です。</div>
                    @enderror
                    @error("sortorder{$i}")
                        <div class="alert alert-danger">並び順に入力が必要です。</div>
                    @enderror
                @endfor 
 

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
                
                
                    <div id="questions" 
                         data-old-question-names="{{ json_encode($oldQuestionNames) }}"
                         data-old-questions="{{ json_encode($oldQuestions) }}"
                         data-old-options="{{ json_encode($oldOptions) }}"
                         data-old-priorities="{{ json_encode($oldPriorities) }}"
                         data-old-reference-links="{{ json_encode($oldReferenceLinks) }}"
                         data-old-sort-orders="{{ json_encode($oldSortOrders) }}">
                    </div>
                    
             
                
                    
                    <div class="form-group row">
                        <label class="col-md-2">作成ステータス</label>
                        <select class="form-control" name="status" value="{{ old('status') }}">-->
                            <option value=1>作成中（一時保存）</option>
                            <option value=2>実施前（完成）</option>
                        </select>
                    </div>

                    
                    @csrf
                    <input type="submit" class="btn btn-primary" value="次へ進む">
                

                </form>
                
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/questionAdd.js') }}"></script>

@endsection 