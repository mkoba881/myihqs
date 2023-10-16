@extends('layouts.admin')

@section('title', '管理者権限付与')

@section('content')
    <div class="container welcome-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">管理者権限付与</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.assign_role') }}">
                            @csrf

                            <div class="form-group">
                                <label for="user_id">ユーザー選択</label>
                                <select name="user_id" class="form-control" required>
                                    <option value="" selected disabled>ユーザーを選択してください</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">管理者権限を付与</button>
                        </form>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <a href="{{ route('admin.ihqs.selection') }}" class="btn btn-secondary">機能選択画面に戻る</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
