@extends('layouts.admin')

@section('title', 'アンケート管理画面')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート管理画面</h2>
            </div>
        </div>
        <div class="card-contents">
            <a class="button" href="{{ route('fs.make')}}">アンケートフォームを作成</a>
        </div>
            <h3>アンケート一覧</h3>
            <form action="{{ route('fs.deleteankate') }}" method="POST" id="deleteForm">
                @csrf
                <div class="row">
                    <div class="list-news col-md-12 mx-auto">
                        <table class="table table-dark table-bordered border-light">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>アンケート名</th>
                                    <th>前回実施日</th>
                                    <th>作成日</th>
                                    <th>更新日</th>
                                    <th>開始日</th>
                                    <th>終了日</th>
                                    <!--<th>ステータス（仮表示後程削除）</th>-->
                                    <th>実施内容</th>
                                </tr>
                            </thead>
                            <tbody class="table table-light table-bordered border-dark">
                                @foreach($formats as $ankate)
                                    @if ($ankate->status === 1 || $ankate->status === 2)
                                        <tr>
                                            <td><input type="checkbox" name="ankate_ids[]" value="{{ $ankate->id }}"></td>
                                            <td>{{ $ankate->id }}</td>
                                            <td>{{ $ankate->name }}</td>
                                            <td>{{ $ankate->previous_at }}</td>
                                            <td>{{ $ankate->created_at }}</td>
                                            <td>{{ $ankate->updated_at }}</td>
                                            <td>{{ $ankate->start }}</td>
                                            <td>{{ $ankate->end }}</td>
                                            <!--<td>{{ $ankate->status }}</td>-->
                                            <td>
                                                @if ($ankate->status === 2)
                                                    <div>
                                                        <a href="{{ route('fs.conductankate', ['id' => $ankate->id]) }}" class="btn btn-primary">アンケート実施</a>
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('fs.edit', ['id' => $ankate->id]) }}" class="btn btn-primary">編集</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-danger deleteButton">選択したアンケートを削除</button>
                    </div>
                </div>
            </form>
            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            <!--<p>{{$formats}}</p>-->
        </div>
    </div>
    

    <script>
        // 「選択したアンケートを削除」ボタンがクリックされた時の処理
        const deleteButtons = document.getElementsByClassName('deleteButton');
        for (const button of deleteButtons) {
            button.addEventListener('click', function(event) {
                // ボタンのデフォルトの動作（フォームの送信）をキャンセル
                event.preventDefault();
                
                // 確認用のポップアップを表示
                if (confirm('選択したアンケートを削除しますか？')) {
                    // 「はい」が選択された場合、フォームを送信
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>

@endsection
