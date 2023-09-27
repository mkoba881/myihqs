
// カウント数の変更時に質問部分を動的に表示する
const questionCountInput = document.querySelector('input[name="questionCount"]');
const questionsContainer = document.getElementById('questions');
const duplicateMessage = document.getElementById('duplicateMessage');


const oldQuestionNames = JSON.parse(questionsContainer.getAttribute('data-old-question-names'));
const oldQuestions = JSON.parse(questionsContainer.getAttribute('data-old-questions'));
const oldOptions = JSON.parse(questionsContainer.getAttribute('data-old-options'));
const oldPriorities = JSON.parse(questionsContainer.getAttribute('data-old-priorities'));
const oldReferenceLinks = JSON.parse(questionsContainer.getAttribute('data-old-reference-links'));
const oldSortOrders = JSON.parse(questionsContainer.getAttribute('data-old-sort-orders'));


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
                            <span class="error-message-question_name${questionIndex}" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">質問文</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="question${questionIndex}" id="question${questionIndex}" value="${oldQuestions[questionIndex] || ''}">
                            <span class="error-message-question${questionIndex}" style="color: red;"></span>
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


function handleImageChange(questionIndex, inputElement) {
    console.log(`handleImageChange called for questionIndex: ${questionIndex}`);
    const selectedFile = inputElement.files[0];

    if (selectedFile) {
        const allowedExtensions = ['.jpeg', '.jpg', '.png']; // 許容する拡張子のリスト
        const fileExtension = selectedFile.name.toLowerCase().slice((selectedFile.name.lastIndexOf(".") - 1 >>> 0) + 2);

        // ファイルの拡張子が許容されていない場合
        if (!allowedExtensions.includes('.' + fileExtension)) {
            alert('JPEGまたはPNGフォーマットの画像ファイルを選択してください。');
            inputElement.value = ''; // ファイル選択をクリア
            return;
        }

        // ファイルサイズが5MBを超える場合
        if (selectedFile.size > 5 * 1024 * 1024) {
            alert('ファイルサイズが5MBを超えています。5MB以下のファイルを選択してください。');
            inputElement.value = ''; // ファイル選択をクリア
            return;
        }

        // 画像を選択したら sessionStorage に保存
        console.log(`Selected file for questionIndex: ${questionIndex}`, selectedFile);

        const reader = new FileReader();
        reader.onload = function(event) {
            // ファイルデータを Blob として保存
            sessionStorage.setItem(`selectedImage_${questionIndex}`, event.target.result);
            console.log(`Saved selectedImage_${questionIndex} to sessionStorage`);
        };
        reader.readAsArrayBuffer(selectedFile);
    } else {
        // ファイルが選択解除された場合は sessionStorage から削除
        console.log(`No file selected for questionIndex: ${questionIndex}`);
        sessionStorage.removeItem(`selectedImage_${questionIndex}`);
    }
}

// 画像選択フォームの要素を取得し、イベントリスナーを追加
const editImageInputs2 = document.querySelectorAll('.edit-question-image-input'); // 変数名を変更
editImageInputs2.forEach((inputElement, index) => {
    inputElement.addEventListener('change', () => {
        checkEditedQuestionImage(inputElement, index);
    });
});


function checkEditedQuestionImage(inputElement, questionIndex) {
    const selectedFile = inputElement.files[0];

    if (selectedFile) {
        const allowedExtensions = ['.jpeg', '.jpg', '.png']; // 許容する拡張子のリスト
        const fileExtension = selectedFile.name.toLowerCase().slice((selectedFile.name.lastIndexOf(".") - 1 >>> 0) + 2);

        // ファイルの拡張子が許容されていない場合
        if (!allowedExtensions.includes('.' + fileExtension)) {
            alert('JPEGまたはPNGフォーマットの画像ファイルを選択してください。');
            inputElement.value = ''; // ファイル選択をクリア
            return;
        }

        // ファイルサイズが5MBを超える場合
        if (selectedFile.size > 5 * 1024 * 1024) {
            alert('ファイルサイズが5MBを超えています。5MB以下のファイルを選択してください。');
            inputElement.value = ''; // ファイル選択をクリア
            return;
        }

        // 画像を選択したら何らかのアクションを実行
        console.log(`Selected file for questionIndex: ${questionIndex}`, selectedFile);

        // ここで編集に関する追加のロジックを実行できます
    }
}

// 画像選択フォームの要素を取得し、イベントリスナーを追加
const editImageInputs = document.querySelectorAll('.edit-question-image-input');
editImageInputs.forEach((inputElement, index) => {
    inputElement.addEventListener('change', () => {
        checkEditedQuestionImage(inputElement, index);
    });
});



// 質問数の変更時にイベントを発火
questionCountInput.addEventListener('input', updateQuestions);


//重複確認処理ここから
// 質問の重複を検知する関数
function detectDuplicateQuestionNames() {
    const questionCount = parseInt(questionCountInput.value);
    const questionNames = new Set();

    for (let i = 1; i <= questionCount; i++) {
        const questionNameInput = document.querySelector(`input[name="question_name${i}"]`);
        if (questionNameInput) {
            const questionName = questionNameInput.value.trim();
            if (questionName !== '') { // 空白でない場合のみセットに追加
                if (questionNames.has(questionName)) {
                    return true;
                }
                questionNames.add(questionName);
            }
        }
    }

    return false;
}

function detectDuplicateQuestions() {
    const questionCount = parseInt(questionCountInput.value);
    const questions = new Set();

    for (let i = 1; i <= questionCount; i++) {
        const questionInput = document.querySelector(`input[name="question${i}"]`);
        if (questionInput) {
            const question = questionInput.value.trim(); // 値をトリムして空白を削除
            if (question !== '') { // 空白でない場合のみセットに追加
                if (questions.has(question)) {
                    return true;
                }
                questions.add(question);
            }
        }
    }

    return false;
}

function detectDuplicateQuestionNameIds() {
    const questionCount = parseInt(questionCountInput.value);
    const questionIds = new Set();

    for (let i = 1; i <= questionCount; i++) {
        const questionIdInput = document.querySelector(`input[name="question_name${i}"]`);
        if (questionIdInput) {
            const questionId = questionIdInput.value.trim();
            if (questionId !== '') { // 空白でない場合のみセットに追加
                if (questionIds.has(questionId)) {
                    return true;
                }
                questionIds.add(questionId);
            }
        }
    }

    return false;
}


function detectDuplicateQuestionIds() {
    const questionCount = parseInt(questionCountInput.value);
    const questionIds = new Set();

    for (let i = 1; i <= questionCount; i++) {
        const questionIdInput = document.querySelector(`input[name="question${i}"]`);
        if (questionIdInput) {
            const questionId = questionIdInput.value.trim();
            if (questionId !== '') { // 空白でない場合のみセットに追加
                if (questionIds.has(questionId)) {
                    return true;
                }
                questionIds.add(questionId);
            }
        }
    }

    return false;
}


function blurEventListenerFunctionForQuestionNames() {
    const hasDuplicateQuestionNames = detectDuplicateQuestionNames();
    const hasDuplicateQuestionNameIds = detectDuplicateQuestionNameIds();
    const nextButton = document.getElementById('nextButton');
    
    const questionCount = parseInt(questionCountInput.value);
    let allFieldsValid = true;

    for (let i = 1; i <= questionCount; i++) {
        const questionNameInput = document.querySelector(`input[name="question_name${i}"]`);
        if (questionNameInput) {
            const questionName = questionNameInput.value.trim();
            if (questionName === '') {
                allFieldsValid = false;
                break; // 質問名が空の場合、チェックを中断
            }
            
            const errorMessageElement = document.querySelector(`.error-message-question_name${i}`);
            if (errorMessageElement) {
                if (hasDuplicateQuestionNames) {
                    errorMessageElement.textContent = '質問名が重複しているため解消してください。';
                } else {
                    errorMessageElement.textContent = '';
                }
            }
            
        }
    }
    
    if (hasDuplicateQuestionNames || hasDuplicateQuestionNameIds || !allFieldsValid) {
        nextButton.disabled = true;
        console.log("bb");
        //duplicateMessage.textContent = '重複している項目を解消してください。';
    } else {
        console.log("bba");
        nextButton.disabled = false;
        //duplicateMessage.textContent = '';
    }
}

function blurEventListenerFunctionForQuestions() {
    const hasDuplicateQuestions = detectDuplicateQuestions();
    const hasDuplicateQuestionIds = detectDuplicateQuestionIds();
    const nextButton = document.getElementById('nextButton');

    const questionCount = parseInt(questionCountInput.value);
    let allFieldsValid = true;

    for (let i = 1; i <= questionCount; i++) {
        const questionInput = document.querySelector(`input[name="question${i}"]`);
        if (questionInput) {
            const question = questionInput.value.trim();
            if (question === '') {
                allFieldsValid = false;
                break; // 質問が空の場合、チェックを中断
            }
        
            const errorMessageElement = document.querySelector(`.error-message-question${i}`);
            if (errorMessageElement) {
                if (hasDuplicateQuestions) {
                    errorMessageElement.textContent = '質問文が重複しているため解消してください。';
                } else {
                    errorMessageElement.textContent = '';
                }
            }
        }    
    }
    
    
    if (hasDuplicateQuestions || hasDuplicateQuestionIds || !allFieldsValid) {
        nextButton.disabled = true;
        console.log("cc");
    } else {
        console.log("dd");
        if (document.querySelector('input[name^="question"]')) {
            nextButton.disabled = false;
        } else {
            nextButton.disabled = true;
        }
    }
}



// blur イベントリスナーを追加


function addBlurEventListenersForQuestionNames() {
    const questionCount = parseInt(questionCountInput.value);

    for (let i = 1; i <= questionCount; i++) {
        const questionNameInput = document.querySelector(`input[name="question_name${i}"]`);
        if (questionNameInput) {
            const blurEventListenerFunctionForQuestionNames = () => {
                const hasDuplicateQuestionNames = detectDuplicateQuestionNames();
                const nextButton = document.getElementById('nextButton');

                if (hasDuplicateQuestionNames) {
                    nextButton.disabled = true;
                    console.log("aaa");
                    alert('質問名が重複しています。重複を解消してください。');
                } else {
                    nextButton.disabled = false;
                    console.log("bbc");

                }
            };

            questionNameInput.addEventListener('blur', blurEventListenerFunctionForQuestionNames);

            // removeEventListener の引数としてリスナー関数を指定
            questionNameInput.removeEventListener('blur', blurEventListenerFunctionForQuestionNames);
        }
    }
}


function addBlurEventListenersForQuestions() {
    const questionCount = parseInt(questionCountInput.value);

    for (let i = 1; i <= questionCount; i++) {
        const questionInput = document.querySelector(`input[name="question${i}"]`);
        if (questionInput) {
            const blurEventListenerFunctionForQuestions = () => {
                const hasDuplicateQuestions = detectDuplicateQuestions();
                const nextButton = document.getElementById('nextButton');

                if (hasDuplicateQuestions) {
                    nextButton.disabled = true;
                    alert('質問が重複しています。重複を解消してください。');
                } else {
                    nextButton.disabled = false;
                    console.log("bbd");
                }
            };

            questionInput.addEventListener('blur', blurEventListenerFunctionForQuestions);

            // removeEventListener の引数としてリスナー関数を指定
            questionInput.removeEventListener('blur', blurEventListenerFunctionForQuestions);
        }
    }
}


function addBlurEventListenerToQuestionName(questionIndex) {
    const questionNameInput = document.querySelector(`input[name="question_name${questionIndex}"]`);
    if (questionNameInput) {
        questionNameInput.addEventListener('blur', blurEventListenerFunctionForQuestionNames);
    }
}

//質問数の変更時に blur イベントリスナーを再設定
questionCountInput.addEventListener('input', () => {
    // 質問名の入力フィールドが変更されたため blur イベントリスナーを一旦削除
    const questionNameInputs = document.querySelectorAll('input[name^="question_name"]');
    questionNameInputs.forEach(input => {
        input.removeEventListener('blur', blurEventListenerFunctionForQuestionNames);
    });

    // 質問名の入力フィールドが再生成されたので再度 blur イベントリスナーを追加
    addBlurEventListenersForQuestionNames();

    // 質問の表示を更新
    updateQuestions();

    // 新しく生成された質問名の入力フィールドに blur イベントリスナーを追加
    const newQuestionCount = parseInt(questionCountInput.value);
    for (let i = 1; i <= newQuestionCount; i++) {
        addBlurEventListenerToQuestionName(i);
    }
});



function addBlurEventListenerToQuestion(questionIndex) {
    const questionInput = document.querySelector(`input[name="question${questionIndex}"]`);
    if (questionInput) {
        questionInput.addEventListener('blur', blurEventListenerFunctionForQuestions);
    }
}

// 質問数の変更時に blur イベントリスナーを再設定
questionCountInput.addEventListener('input', () => {
    // 質問の入力フィールドが変更されたため blur イベントリスナーを一旦削除
    const questionInputs = document.querySelectorAll('input[name^="question"]');
    questionInputs.forEach(input => {
        input.removeEventListener('blur', blurEventListenerFunctionForQuestions);
    });

    // 質問の入力フィールドが再生成されたので再度 blur イベントリスナーを追加
    addBlurEventListenersForQuestions();

    // 質問の表示を更新
    updateQuestions();

    // 新しく生成された質問の入力フィールドに blur イベントリスナーを追加
    const newQuestionCount = parseInt(questionCountInput.value);
    for (let i = 1; i <= newQuestionCount; i++) {
        addBlurEventListenerToQuestion(i);
    }
});



// 初回に blur イベントリスナーを追加
addBlurEventListenersForQuestionNames();

addBlurEventListenerToQuestion();

//重複確認処理ここまで

// 初回表示時に質問を表示
updateQuestions();