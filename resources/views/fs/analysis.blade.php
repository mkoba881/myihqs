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
    <script src="{{ asset('myihqs/js/app.js') }}"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->
    <!-- 最新バージョンのChart.jsを読み込む -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>



    <script>
    document.getElementById('formatId').addEventListener('change', handleFormSubmit);
    
    function handleFormSubmit(event) {
        event.preventDefault();
        
        var formatId = document.getElementById('formatId').value;
    
        // データを取得してグラフを描画する処理を実行する
        fetch('{{ route('data.get') }}?format_id=' + formatId)
            .then(response => response.json())
            .then(data => {
                console.log(data); // これが切り分けコマンド
                drawGraph(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    // グラフを描画する関数を定義
    function drawGraph(data) {
        const ctx = document.getElementById('myChart').getContext('2d');
        
        // グローバルスコープにmyChartを宣言
        let myChart;
        
        // すでにチャートが存在している場合は破棄する
        if (myChart) {
            myChart.destroy();
        }
        
        var labels = [];

        
        //console.log(data[0]['data'][1]); 
        //console.log(data[0]['data'][2]); 
        
                
        //var datasets = [];
        
    for (let i = 0; i < data.length; i++) {
        //   let currentData = data[i]['data'];
        //   let datasetArray = [];
        
        //   for (let priority = 1; priority <= 5; priority++) {
        //       datasetArray.push({
        //           label: '優先度' + priority,
        //           data: currentData[priority] || 0,
        //           backgroundColor: getBackgroundColor(priority)
        //       });
        //   }
          
        //   datasets.push(...datasetArray);
           labels.push(data[i]['label']);
            
      }
        
        var datasets= [{
                label: '優先度１',
                data: [10, 2,3],
                backgroundColor: 'rgba(255, 100, 100, 1)'
            },
            {
                label: '優先度２',
                data: [1, 10,4],
                backgroundColor: 'rgba(100, 100, 255, 1)'
            },
                
            {
                label: '優先度３',
                data: [0, 8,5],
                backgroundColor: 'rgba(100, 100, 30, 1)'
            },
            {
                label: '優先度４',
                data: [3, 6,6],
                backgroundColor: 'rgba(100, 100, 50, 1)'
            },
            {
                label: '優先度５',
                data: [2, 4,7],
                backgroundColor: 'rgba(100, 100, 150, 1)'
            },
    
            ]

        // console.log(data[0]['label']);
        // console.log(data[1]['label']);

        labels.push("質問３");//仮の項目
        console.log(datasets); 
        console.log(labels); 
        
        
        var options = {
            scales: {
                x:{
                    display: true,
                    title:{
                        display: true,
                        text: '質問名'
                    }
                },
                y:{
                    display: true,
                    min: 300,
                    title:{
                        display: true,
                        text: '人数'
                    },
                    ticks: {
                        callback: function(value, index, ticks) {
                            return value + '台';
                        }
                    }
                },
            },
            plugins: {
                title: {
                    display: true,
                    text: 'アンケート項目に対する人数'
                }
            }
        };
        
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // ここで質問のラベルを指定
                datasets: datasets,
                },
            options: options
        });
    }
    
    function getBackgroundColor(index) {
        const colors = [
            'rgba(219,39,91,0.5)',
            'rgba(130,201,169,0.5)',
            'rgba(255,183,76,0.5)',
            'rgba(255,100,76,0.5)',
            'rgba(255,50,76,0.5)'
        ];
        
        return colors[index % colors.length];
    }

    </script>

@endsection