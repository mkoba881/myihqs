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
    <script src="{{ mix('js/app.js') }}"></script> <!-- Laravel MixでビルドされたJavaScriptファイル -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        document.getElementById('formatId').addEventListener('change', handleFormSubmit);

        function handleFormSubmit(event) {
            event.preventDefault();
            
            var formatId = document.getElementById('formatId').value;
        
            // データを取得してグラフを描画する処理を実行する
            fetch('{{ route('data.get') }}?format_id=' + formatId)
                .then(response => response.json())
                .then(data => {
                    console.log(data);//これが切り分けコマンド
                    drawGraph(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }
    
        
        // ページロード時に初期のグラフを描画する
        window.addEventListener('DOMContentLoaded', function() {
        handleFormSubmit(new Event('change'));
        });
        
        // グローバルスコープにmyChartを宣言
        let myChart;


        function drawGraph(data) {
            const ctx = document.getElementById('myChart').getContext('2d');
           
            if (typeof myChart !== 'undefined') {
                myChart.destroy();
            }
    
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'アンケート項目の優先度について',
                        data: data.values,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }


    </script>

@endsection