
// カウント数の変更時に質問部分を動的に表示する
const questionCountInput = document.querySelector('input[name="questionCount"]');
const questionsContainer = document.getElementById('questions');

const oldQuestionNames = JSON.parse(questionsContainer.getAttribute('data-old-question-names'));
const oldQuestions = JSON.parse(questionsContainer.getAttribute('data-old-questions'));
const oldOptions = JSON.parse(questionsContainer.getAttribute('data-old-options'));
const oldPriorities = JSON.parse(questionsContainer.getAttribute('data-old-priorities'));
const oldReferenceLinks = JSON.parse(questionsContainer.getAttribute('data-old-reference-links'));
const oldSortOrders = JSON.parse(questionsContainer.getAttribute('data-old-sort-orders'));

// function handleImageChange(questionIndex, inputElement) {
//     console.log(`handleImageChange called for questionIndex: ${questionIndex}`);
//     const selectedFile = inputElement.files[0];

//     if (selectedFile) {
//         // 画像を選択したら sessionStorage に保存
//         console.log(`Selected file for questionIndex: ${questionIndex}`, selectedFile);

//         const reader = new FileReader();
//         reader.onload = function(event) {
//             // ファイルデータを Blob として保存
//             sessionStorage.setItem(`selectedImage_${questionIndex}`, event.target.result);
//             console.log(`Saved selectedImage_${questionIndex} to sessionStorage`);
//         };
//         reader.readAsArrayBuffer(selectedFile);
//     } else {
//         // ファイルが選択解除された場合は sessionStorage から削除
//         console.log(`No file selected for questionIndex: ${questionIndex}`);
//         sessionStorage.removeItem(`selectedImage_${questionIndex}`);
//     }
// }

// function restoreImageSelections() {
//     const imageUploadFields = document.querySelectorAll('input[type="file"]');
    
//     imageUploadFields.forEach((inputElement, questionIndex) => {
//         console.log(`restoreImageSelections called for questionIndex: ${questionIndex}`);
//         const index = questionIndex + 1;
//         const fileData = sessionStorage.getItem(`selectedImage_${index}`);

//         if (fileData) {
//             console.log(`File data found in sessionStorage for questionIndex: ${index}`);
            
//             // ファイルデータを Blob オブジェクトに変換
//             const blob = new Blob([fileData], { type: 'image/jpeg' }); // 画像の MIME タイプに合わせて修正

//             // Blob オブジェクトから File オブジェクトを作成
//             const fileName = `selectedImage_${index}.jpg`; // ファイル名は適切に修正
//             const file = new File([blob], fileName, { type: 'image/jpeg' }); // 画像の MIME タイプに合わせて修正

//             // DataTransfer オブジェクトを作成し、ファイルを追加
//             const dataTransfer = new DataTransfer();
//             dataTransfer.items.add(file);

//             // フォームの input 要素に DataTransfer オブジェクトを設定
//             inputElement.files = dataTransfer.files;
            
//             console.log(`Restored selectedImage_${index} for questionIndex: ${index}`);
//         }
//     });
// }



// バリデーションエラー時にフォームを再表示する場合、以下のように呼び出して画像を設定
// restoreImageSelections();

function updateQuestions() {
    const questionCount = parseInt(questionCountInput.value);
   // コンソールに oldPriorities 配列を出力
   //console.log("oldPriorities:", oldPriorities);
   //console.log("プロパティ 2 の値:", oldPriorities[2]);
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
            
            // 質問に関連する oldOptions 配列が存在するか確認
            const options = oldOptions[questionIndex] || ['', '', '', '', ''];

          // 画像プレビューを初期化
            const imagePreview = '';

            const questionTemplate = `
                <div class="question">
                    <label class="col-md-2" for="question_name${questionIndex}"><b><span style="color: red;">質問${questionIndex}の項目</span></b></label>
                    <div class="form-group row">
                        <label class="col-md-2"><b>質問No、項目名</b></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="question_name${questionIndex}" id="question_name${questionIndex}" value="${oldQuestionNames[questionIndex] || ''}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">質問文</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="question${questionIndex}" id="question${questionIndex}" value="${oldQuestions[questionIndex] || ''}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">選択肢</label>
                        <div class="col-md-10">
                            <label class="col-md-2">①</label>
                            <input type="text" class="form-control" name="option${questionIndex}_1" value="${options[0] || ''}">
                            <label class="col-md-2">②</label>
                            <input type="text" class="form-control" name="option${questionIndex}_2" value="${options[1] || ''}">
                            <label class="col-md-2">③</label>
                            <input type="text" class="form-control" name="option${questionIndex}_3" value="${options[2] || ''}">
                            <label class="col-md-2">④</label>
                            <input type="text" class="form-control" name="option${questionIndex}_4" value="${options[3] || ''}">
                            <label class="col-md-2">⑤</label>
                            <input type="text" class="form-control" name="option${questionIndex}_5" value="${options[4] || ''}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">優先度</label>
                        <select class="form-control" name="priority${questionIndex}">
                            <option ${oldPriorities[questionIndex] === '1' ? 'selected' : ''}>1</option>
                            <option ${oldPriorities[questionIndex] === '2' ? 'selected' : ''}>2</option>
                            <option ${oldPriorities[questionIndex] === '3' ? 'selected' : ''}>3</option>
                            <option ${oldPriorities[questionIndex] === '4' ? 'selected' : ''}>4</option>
                            <option ${oldPriorities[questionIndex] === '5' ? 'selected' : ''}>5</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">参考リンク</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="rf_url${questionIndex}" value="${oldReferenceLinks[questionIndex] || ''}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">参考画像</label>
                        <div class="col-md-5">
                            <input type="file" class="form-control-file" name="rf_image${questionIndex}" onchange="handleImageChange(${questionIndex}, this)" data-selected-image="">
                            <div class="image-preview">${imagePreview}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">並び順</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" name="sortorder${questionIndex}" value="${oldSortOrders[questionIndex] || ''}">
                        </div>
                    </div>
                </div>
            `;
            questionsContainer.innerHTML += questionTemplate;
        }
        
        // //画像 ページ読み込み時に選択済みの画像を設定
        // restoreImageSelections();


        // const fileInput = document.querySelector('input[type="file"]');
        
        // fileInput.addEventListener('change', (event) => {
        //     const selectedFile = event.target.files[0]; // 選択されたファイル（最初のファイル）を取得
        
        //     if (selectedFile) {
        //         console.log('選択されたファイル名:', selectedFile);
        //         console.log('ファイルのタイプ:', selectedFile.type);
        //         console.log('ファイルのサイズ（バイト）:', selectedFile.size);
        
        //         // ここで選択されたファイルに対する追加の処理を行うことができます
        //     } else {
        //         console.log('ファイルが選択されていません。');
        //     }
        // });

        
        for (let i = 1; i <= questionCount; i++) {
            const questionIndex = currentQuestionCount + i;
            const selectElement = document.querySelector(`select[name="priority${questionIndex}"]`);
            if (selectElement) {
                // 選択ボックスの選択状態を設定
                const selectedPriority = oldPriorities[questionIndex] || ''; // 選択されるべき優先度を取得
                selectElement.value = selectedPriority;
                
                // セレクトボックスの値をコンソールに出力
                //console.log("セレクトボックスの値:", selectElement.value);
                
            }
        }
        
    } else if (questionCount < currentQuestionCount) {
        // 不要な質問部分を削除
        const questionElements = questionsContainer.querySelectorAll('.question');
        
        for (let i = questionCount; i < currentQuestionCount; i++) {
            questionElements[i].remove();
        }
    }
}    



// 質問数の変更時にイベントを発火
questionCountInput.addEventListener('input', updateQuestions);

// 初回表示時に質問を表示
updateQuestions();
    