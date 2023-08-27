function handleFormSubmit(event) {
    event.preventDefault();
    console.log('aaa');
    
    var formatId = document.getElementById('formatId').value;

    // データを取得してグラフを描画する処理を実行する
    fetch(dataGetRoute + '?format_id=' + formatId)
        .then(response => response.json())
        .then(data => {
            drawGraph(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

var myChart;//これをグローバルに宣言していないとデストロイが動かない。


// グラフを描画する関数を定義
function drawGraph(data) {
    console.log('bbb');
    
    // グローバルスコープにmyChartを宣言
    
    // すでにチャートが存在している場合は破棄する
    
    var labels = [];
    console.log(data); 

    var datasets = [];

    
    
     // 優先度ごとのデータを格納する配列を作成
    var priorityDataArray = [];
    for (let priority = 1; priority <= 5; priority++) {
        priorityDataArray.push([]);
    }
    
    console.log(priorityDataArray);
    
    for (let questionIndex = 0; questionIndex < data.length; questionIndex++) {
        const questionData = data[questionIndex]['data'];

        for (let priority = 1; priority <= 5; priority++) {
            const priorityData = questionData[priority] || 0;
            priorityDataArray[priority - 1].push(priorityData);
        }

        labels.push(data[questionIndex]['label']); // 質問ラベルを追加
    }
    
        // 優先度ごとのデータをdatasetsに追加
    for (let priority = 1; priority <= 5; priority++) {
        datasets.push({
            label: '優先度' + priority,
            data: priorityDataArray[priority - 1],
            backgroundColor: getBackgroundColor(priority - 1)
        });
    }


    
    //console.log(data[0]['data'][1]); 
    //console.log(data[0]['data'][2]); 
    
    
    
    
    // var datasets= [{
    //         label: '優先度１',
    //         data: [10, 2,3],
    //         backgroundColor: 'rgba(255, 100, 100, 1)'
    //     },
    //     {
    //         label: '優先度２',
    //         data: [1, 10,4],
    //         backgroundColor: 'rgba(100, 100, 255, 1)'
    //     },
            
    //     {
    //         label: '優先度３',
    //         data: [0, 8,5],
    //         backgroundColor: 'rgba(100, 100, 30, 1)'
    //     },
    //     {
    //         label: '優先度４',
    //         data: [3, 6,6],
    //         backgroundColor: 'rgba(100, 100, 50, 1)'
    //     },
    //     {
    //         label: '優先度５',
    //         data: [2, 4,7],
    //         backgroundColor: 'rgba(100, 100, 150, 1)'
    //     },

    // ]
    
   //labels.push("質問３");//仮の項目
    console.log(datasets); 
    console.log(labels); 
    
    
    var options = {
        scales: {
            xAxes:[{
                scaleLabel:{
                    display: true,
                    labelString: '質問名'
                }
            }],
            yAxes:[{
                display: true,
                min: 300,
                
                scaleLabel:{
                    display: true,
                    labelString: '質問名'
                },
                // title:{
                //     display: true,
                //     text: '人数'
                // },
                ticks: {
                    callback: function(value, index, ticks) {
                        return value + '人数';
                    }
                }
            }],
        },
        title: {
            display: true, // タイトルを表示する
            text: 'アンケート項目に対する人数' // タイトルのテキスト
        }
            // plugins: {
        //     title: {
        //         display: true,
        //         text: 'アンケート項目に対する人数'
        //     }
        // }
    };

    const ctx = document.getElementById('myChart').getContext('2d');

    if (myChart) {
        console.log('CCC');
        myChart.destroy();
    }
    
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

document.addEventListener('DOMContentLoaded', function() {
document.getElementById('formatId').addEventListener('change', handleFormSubmit);
//document.getElementById('formatId').addEventListener('change', handleFormSubmit);

});