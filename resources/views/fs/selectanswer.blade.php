{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')

{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'アンケート選択回答画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container welcome-container">
        <div class="row">
            <div class="col-12 mx-auto">
                <h1>アンケート選択回答画面</h1>
                <!-- アンケート選択セレクトボックス -->
                <select id="surveySelect">
                    @foreach ($surveys as $survey)
                        <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                    @endforeach
                </select>
                <button id="selectButton">アンケートを選択</button>
                
                <!-- 選択されたアンケートの詳細を表示する部分 -->
                <div id="answerSection" style="display: none;">
                    <!-- ここに回答画面の内容が表示されます -->
                </div>
            </div>
            <div class="card-contents">
                <a class="button" href="{{ route('admin.ihqs.selection')}}">機能選択画面に戻る</a>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const surveySelect = document.getElementById('surveySelect');
            const selectButton = document.getElementById('selectButton');
            const answerSection = document.getElementById('answerSection');
            let selectedFormatId; // selectedFormatIdを関数外で宣言
    
            selectButton.addEventListener('click', function() {
                selectedFormatId = surveySelect.value;
    
                // 選択されたアンケートの詳細を取得するAPI呼び出し
                //fetch(`/api/get_survey_details/${selectedFormatId}`)
                fetch('{{ route("get.survey", ["formatId" => "__PLACEHOLDER__"]) }}'.replace('__PLACEHOLDER__', selectedFormatId))
                    .then(response => response.json())
                    .then(data => {
                        // 取得したデータを使って回答画面のコンテンツを作成
                        const answerContent = createAnswerContent(data);
                        answerSection.innerHTML = answerContent;
    
                        // 回答画面を表示
                        answerSection.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        console.error('Error fetching survey details:', error);
                        });
                });

            
    
            function createAnswerContent(data) {
                const userId = data.userId;
                const answers = data.answers;
                const items = data.items;
                const detailsByItem = data.detailsByItem;
                
                const baseUrl = 'https://myapp.server-on.net/myihqs/uploads/'; // 固定のベースURL

                console.log('userId:', userId);
                console.log('answers:', answers);
                console.log('Items:', items); // 全アイテムのデータをコンソールに表示
    　　          console.log('DetailsByItem:', detailsByItem); // 全詳細のデータをコンソールに表示

    
                let content = `
                    <h2>アンケート名: ${surveySelect.options[surveySelect.selectedIndex].text}</h2>
                    <form action="{{ route('fs.selectanswerend') }}" method="post" enctype="multipart/form-data">
                `;
    
                items.forEach((item, itemIndex) => {
                    const itemDetails = detailsByItem[item.id];
                    itemDetails.forEach(detail => {
                
                　　      const imagePath = detail.rf_image ? baseUrl + detail.rf_image : '';
                        const referenceImageId = `referenceImage_${item.id}_${detail.id}`;
                
                        <!--const imagePath = detail.rf_image ? '/uploads/' + detail.rf_image : '';-->

                        content += `
                            <h2>■${item.name}. ${detail.question}</h2>
                            <h2>・回答の選択肢</h2>
                            <!-- 選択肢を表示 -->
                            
                            <div class="form-group row" style="margin-bottom: 30px;">
                                <select class="form-control" name="answer_result[${itemIndex}]">
                                    <option value="1" ${answers[itemIndex]?.answer_result === 1 ? 'selected' : ''}>①</option>
                                    <option value="2" ${answers[itemIndex]?.answer_result === 2 ? 'selected' : ''}>②</option>
                                    <option value="3" ${answers[itemIndex]?.answer_result === 3 ? 'selected' : ''}>③</option>
                                    <option value="4" ${answers[itemIndex]?.answer_result === 4 ? 'selected' : ''}>④</option>
                                    <option value="5" ${answers[itemIndex]?.answer_result === 5 ? 'selected' : ''}>⑤</option>
                                </select>
                            </div>
                            
                            <h2>・優先度</h2>
                            <!-- 優先度の選択肢を表示 -->

                            <div class="form-group row" style="margin-bottom: 30px;">
                                <select class="form-control" name="priority[${itemIndex}]">
                                    <option value="1" ${answers[itemIndex]?.priority === 1 ? 'selected' : ''}>1</option>
                                    <option value="2" ${answers[itemIndex]?.priority === 2 ? 'selected' : ''}>2</option>
                                    <option value="3" ${answers[itemIndex]?.priority === 3 ? 'selected' : ''}>3</option>
                                    <option value="4" ${answers[itemIndex]?.priority === 4 ? 'selected' : ''}>4</option>
                                    <option value="5" ${answers[itemIndex]?.priority === 5 ? 'selected' : ''}>5</option>
                                </select>
                            </div>
                            
                            <h2>・参考リンク</h2>
                            <div style="margin-bottom: 30px;">
                                <a href="${detail.rf_url}" target="_blank">${detail.rf_url}</a>
                            </div>
                            <h2>・参考画像</h2>
                            <div style="margin-bottom: 30px;">
                                <img src="${imagePath}" id="${referenceImageId}" style="max-width: 100%;">
                            </div>
                            
                            <input type="hidden" name="format_id" value="${selectedFormatId}">
                            <input type="hidden" name="item_id[${itemIndex}][]" value="${item.id}">
                            <input type="hidden" name="detail_id[${itemIndex}][]" value="${detail.id}">
                        `;
                    });
                });
    
                content += `
                    @csrf
                    <input type="submit" class="btn btn-primary" value="回答結果を送信する" style="margin-bottom: 30px;">
                </form>
                `;
    
                return content;
            }
        });
    </script>
@endsection