{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート分析画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>アンケート分析画面</h2>
            </div>
            <select class="form-control" id="formatId" name="format_id">
                <option>－－－－</option>
                @foreach($formats as $formatId => $formatName)
                    <option value="{{ $formatId }}">{{ $formatName }}</option>
                @endforeach
            </select>
            
            <canvas id="myChart"></canvas> <!-- グラフを描画するためのキャンバス要素 -->

            <div class="card-contents">
                <a href="{{ route('admin.ihqs.selection')}}" class="btn btn-primary">前の画面に戻る</a>
            </div>
        </div>
    </div>
    {{-- Chart.jsのスクリプトを読み込む --}}
    <script src="{{ asset('myihqs/js/app.js') }}"></script>
    <!-- 最新バージョンのChart.jsを読み込む -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('/js/myChart.js') }}"></script>
    <!-- Bladeテンプレート内 -->
    <script>
        var dataGetRoute = '{{ route('data.get') }}';
    </script>

@endsection