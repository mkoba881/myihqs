<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnkateCreateRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


// 以下の1行を追記することで、Format Modelが扱えるようになる
use App\Models\Format;
use App\Models\Item;
use App\Models\Detail;
use App\Models\Mail;
use App\Models\User;
use App\Models\Answer;
use App\Models\SurveyParticipant;


class IhqsController extends Controller
{
    public function selection()
    {
        //dd($surveys);
        return view('admin.ihqs.selection');
    }

    public function selectanswer()
    {
        $userId = Auth::user()->id;
        // ユーザーに紐づく有効なフォーマットIDを取得
        $formatIds = SurveyParticipant::where('user_id', $userId)->pluck('format_id')->toArray();
        // フォーマットIDに基づいてアンケート情報を取得
        $surveys = Format::whereIn('id', $formatIds)->get(['id', 'name']);
        //dd($surveys);

        return view('fs.selectanswer', ['surveys' => $surveys]);
    }
    
    public function analysis()
    {
        $formats = Format::where('status', '<>', 3)->pluck('name', 'id');
        //dd($formats);
        return view('fs.analysis')->with('formats', $formats);
    }

    public function answer()
    {
        return view('fs.answer');
    }

    public function management()
    {
    $formats = Format::all();
    //dd($formats);
        //return view('fs.makepreview',['format'=> $format,'item'=> $item,'detail'=> $detail]);
        return view('fs.management',['formats' => $formats]);
    }

    public function answerend(Request $request)
    {
     
        $user_id = Auth::id();
        $answers = $request->all();
        unset($answers['_token']);
        
        //dd($answers['answer_result']);
        //dd($answers['priority']);
        //dd($answers);
        
        foreach ($answers['answer_result'] as $index => $answerResult) {
            $format_id = $answers['format_id'];
            $item_id = $answers['item_id'][$index][0];//多次元配列のため[0]がないと「Array to string conversion」のエラーがでる。
            $detail_id = $answers['detail_id'][$index][0];
            $priority = $answers['priority'][$index];
            //dd($priority);
            // 既存のレコードを更新するか新規作成するかを判断する
            $existingRecord = Answer::where('format_id', $format_id)
                                    ->where('item_id', $item_id)
                                    ->where('detail_id', $detail_id)
                                    ->where('user_id', $user_id)
                                    ->first();
    
            if ($existingRecord) {
                // 既存のレコードが存在する場合、更新する
                $existingRecord->update([
                    'answer_result' => $answerResult,
                    'priority' => $priority,
                ]);
            } else {
                // 既存のレコードが存在しない場合、新規作成する
                Answer::create([
                    'format_id' => $format_id,
                    'item_id' => $item_id,
                    'detail_id' => $detail_id,
                    'user_id' => $user_id,
                    'answer_result' => $answerResult,
                    'priority' => $priority,
                ]);
            }
        } 
        return view('fs.answerend');
    }

    public function selectanswerend(Request $request)
    {
     
        $user_id = Auth::id();
        //dd($user_id);
        $answers = $request->all();
        unset($answers['_token']);
        
        //dd($answers['answer_result']);
        //dd($answers['priority']);
        //dd($answers);
        
        foreach ($answers['answer_result'] as $index => $answerResult) {
            $format_id = $answers['format_id'];
            $item_id = $answers['item_id'][$index][0];//多次元配列のため[0]がないと「Array to string conversion」のエラーがでる。
            $detail_id = $answers['detail_id'][$index][0];
            $priority = $answers['priority'][$index];
            //dd($priority);
            // 既存のレコードを更新するか新規作成するかを判断する
            $existingRecord = Answer::where('format_id', $format_id)
                                    ->where('item_id', $item_id)
                                    ->where('detail_id', $detail_id)
                                    ->where('user_id', $user_id)
                                    ->first();
    
            if ($existingRecord) {
                // 既存のレコードが存在する場合、更新する
                $existingRecord->update([
                    'answer_result' => $answerResult,
                    'priority' => $priority,
                ]);
            } else {
                // 既存のレコードが存在しない場合、新規作成する
                Answer::create([
                    'format_id' => $format_id,
                    'item_id' => $item_id,
                    'detail_id' => $detail_id,
                    'user_id' => $user_id,
                    'answer_result' => $answerResult,
                    'priority' => $priority,
                ]);
            }
        } 
        
        // ユーザーに紐づく有効なフォーマットIDを取得
        $formatIds = SurveyParticipant::where('user_id', $user_id)->pluck('format_id')->toArray();
        // フォーマットIDに基づいてアンケート情報を取得
        $surveys = Format::whereIn('id', $formatIds)->get(['id', 'name']);
        //dd($surveys);

        return view('fs.selectanswer', ['surveys' => $surveys]);

    }


    public function make()
    {
        return view('fs.make');
    }
    
    public function edit($id)
    {
        //$form = Format::find($id);
        //dd($id);
        //dd($form);
        // 必要な追加のチェックやデータ処理を行います

        //$questionCount = $request->input('questionCount');
        $questionCount = Item::where('format_id', $id)->count();
        //dd($questionCount);
        $format = Format::find($id);
        //dd($format);
        $items = Item::where('format_id', $id)->get();
        //dd($items);
    
        // 質問の詳細情報を取得して配列に格納
        $details = [];
        foreach ($items as $item) {
            $detail = Detail::where('item_id', $item->id)->orderBy('item_id', 'desc')->first();
            //dd($detail);
            if ($detail && !empty($detail->rf_image)) {
                // 参考画像が存在する場合はフラグをtrueに設定
                $detail->has_reference_image = true;
            } else {
                // 参考画像が存在しない場合はフラグをfalseに設定
                $detail->has_reference_image = false;
            }

                
            $details[] = $detail;
            //dd($details);
        }
        //dd($details);
        //dd($format);
    
        return view('fs.edit', ['questionCount' => $questionCount,'format' => $format, 'items' => $items, 'details' => $details]);
        //return view('edit', compact('ankate'));
    }
    

    public function create(AnkateCreateRequest $request)
    {
        
    $request->validate(Format::getValidationRules($request->input('questionCount')));

    $format_id = $this->saveOrUpdateFormat($request);

    $questionCount = $request->input('questionCount');

    for ($i = 1; $i <= $questionCount; $i++) {
        $item_id = $this->saveOrUpdateItem($request, $format_id, $i);
        $this->saveOrUpdateDetail($request, $item_id, $i);
    }

    $format = Format::find($format_id);
    // $items = Item::where('format_id', $format_id)->get();
    $items = Item::where('format_id', $format_id)
             ->orderBy('sortorder', 'asc') // sortorderカラムを昇順に並べ替え
             ->get();
    //dd($items);
    
    $details = $this->getQuestionDetails($items);

    return view('fs.makepreview', ['format' => $format, 'items' => $items, 'details' => $details]);
        
    }
    
    private function saveOrUpdateFormat(Request $request)
    {
        $format_id = $request->input('format_id', null);
    
        $formatData = [
            'name' => $request->input('ankate_name'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'status' => $request->input('status')
        ];
    
        if ($format_id) {
            $format = Format::find($format_id);
            $format->update($formatData);
        } else {
            $format = Format::create($formatData);
            $format_id = $format->id;
        }
    
        return $format_id;
    }
    
    private function saveOrUpdateItem(Request $request, $format_id, $index)
    {
        $itemData = [
            'name' => $request->input('question_name' . $index),
            'format_id' => $format_id,
            'sortorder' => $request->input('sortorder' . $index)
        ];
    
        $existingItem = Item::where('format_id', $format_id)
            ->where('name', $request->input('question_name' . $index))
            ->first();
    
        if ($existingItem) {
            $existingItem->update($itemData);
            $item_id = $existingItem->id;
        } else {
            $item = Item::create($itemData);
            $item_id = $item->id;
        }
    
        return $item_id;
    }
    
    private function saveOrUpdateDetail(Request $request, $item_id, $index)
    {
        // detailのデータを作成
        $detail_form = [
            'item_id' => $item_id,
            'question' => $request->input('question' . $index),
            'option1' => $request->input('option' . $index . '_1'),
            'option2' => $request->input('option' . $index . '_2'),
            'option3' => $request->input('option' . $index . '_3'),
            'option4' => $request->input('option' . $index . '_4'),
            'option5' => $request->input('option' . $index . '_5'),
            'priority' => $request->input('priority' . $index),
            'rf_url' => $request->input('rf_url' . $index),
            //'rf_image' => $request->input('rf_image' . $index),
        ];
    
        // 画像処理のコード
        $file = $request->file('rf_image' . $index);
        if ($file) {
            $image = \Auth::user()->name . time() . hash_file('sha1', $file) . '.' . $file->getClientOriginalExtension();
            $target_path = public_path('uploads/');
            if (!is_dir($target_path)) {
                mkdir($target_path, 0755, true);
            }
    
            $file->move($target_path, $image);
            $detail_form['rf_image'] = $image;
        } else {
            // 画像が選択されていなければ空文字をセット
            $existingDetail = Detail::where('item_id', $item_id)->first();
            $detail_form['rf_image'] = $existingDetail ? $existingDetail->rf_image : '';
        }
    
        // 更新処理 or 新規追加処理
        $existingDetail = Detail::where('item_id', $item_id)->first();
        if ($existingDetail) {
            // すでに同じ質問項目の詳細情報が存在する場合は更新
            $existingDetail->update($detail_form);
        } else {
            // 新しい質問項目の詳細情報を追加
            \DB::table('details')->insert($detail_form);
        }
    }
    
    private function getQuestionDetails($items)
    {
        $details = [];
    
        foreach ($items as $item) {
            $detail = Detail::where('item_id', $item->id)->orderBy('id', 'desc')->first();
            $details[] = $detail;
        }
    
        return $details;
    }
    //createメソッド終わり
    

    public function deleteankate(Request $request)  
    {
    
    $ankateIds = $request->input('ankate_ids');
    
    //dd($ankateIds);
    if (!empty($ankateIds)) {
        // チェックボックスで選択�����れたアンケートを取得し、statusを3に更新
        Format::whereIn('id', $ankateIds)->update(['status' => 3]);
    }    
        
        
    return redirect()->route('fs.management')->with('success', '選択したアンケートが削除されました。');
    }
    
    public function conductankate(Request $request)
    {
        $form = $request->all();//フォームの中身を全部とってきている
        if (isset($form['id'])) {
                $id = $form['id'];
        //dd($id);
        // idを使ってmailテーブルからデータを抜き出す
        $mailData = Mail::where('id', $id)->first();
        $formatData = Format::where('id', $id)->first();
        //dd($mailData);
    
            if ($mailData) {
                $user_mailformat = $mailData->user_mailformat;
                $remind_mailformat = $mailData->remind_mailformat;
                $admin_mailformat = $mailData->admin_mailformat;
                $start = $formatData->start;
                $end = $formatData->end;
    
                // メールフォーマットをビューに渡す
                return view('fs.conductankate', compact('id', 'user_mailformat', 'remind_mailformat', 'admin_mailformat', 'start', 'end'));
            } else {
                // データが存在しない場合の処理を追加
                $user_mailformat = "";
                $remind_mailformat = "";
                $admin_mailformat = "";
                $start = $formatData->start;
                $end = $formatData->end;
                return view('fs.conductankate', compact('id', 'user_mailformat', 'remind_mailformat', 'admin_mailformat', 'start', 'end'));
            }
        } else {
            // $id が存在しない場合の処理を追加
            // 例えば、エラーメッセージを表示する等
        }
        
        
        return view('fs.conductankate',compact('id'));
    }
    
    
    public function conductankatepreview(Request $request)
    {
        // Validationを行う
        $this->validate($request, Mail::$rules);
    
        $form = $request->all();
    
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
    
        $fileName = empty($form["csvFile"]) ? 'default.csv' : $form["csvFile"];
    
        if (file_exists($fileName)) {
            // ファイルが存在する場合の処理
            $command = "file -i " . $fileName;
            $output = [];
            $status = "";
            exec($command, $output, $status);
            preg_match("/charset=(.*)/", $output[0], $charset);
    
            $fp = fopen($fileName, 'r');
            $csv_array = array();
    
            // 配列へ格納
            while ($line = fgetcsv($fp)) {
                $csv_array[] = $line;
            }
    
            fclose($fp);
    
            // 変換処理
            if ($charset[1] != "utf-8") {
                mb_convert_variables("UTF-8", "SJIS", $csv_array);
            }
            //ddd($csv_array);
    
        } else {
            
            // ファイルが存在しない場合の処理
            $csv_array = array();
            //dd($csv_array);
        
            // 既存のテーブルからデータを取得してcsv_arrayに追加する処理
            $participants = SurveyParticipant::where('format_id', $form["id"])->get();
            
            foreach ($participants as $participant) {
                $row = array();
                
                // メールアドレスを元にUserテーブルから名前を取得
                $user = User::where('email', $participant->email)->first();
                
                if ($user) {
                    // ユーザーの名前を追加
                    $row[] = $user->name;
                } else {
                    // もしUserテーブルに対応するユーザーが見つからない場合の処理
                    $row[] = '';
                }
                
                // メールアドレスを取得するカラムに合わせて修正
                $row[] = $participant->email;
                
                $csv_array[] = $row;
            }
            
            //dd($csv_array);
                    
        }
        
        return view('fs.conductankatepreview', compact('form', 'csv_array'));
        
    }

    public function saveconductankate(Request $request)  
    {
        
        //$form = $request->all();//フォームの中身を全部とってきている
        $form = $request->input('form');
        //dd($form);
        $csv_array = session('csv_array');
        
        // $form が JSON エンコードされている場合、デコードする
        if (is_string($form) && json_decode($form)) {
            $form = json_decode($form, true);
        }
        //dd($form);

        $existingData = format::where('id', $form['id'])->first();
        $existingData_mail = mail::where('format_id', $form['id'])->first();

        //dd($existingData);
        
        if ($existingData) {
            // 条件に合致するデータが存在する場合は更新
            $existingData->start = $form['start'];
            $existingData->end = $form['end'];
            $existingData->save();
        } else {
            // 条件に合致するデータが存在しない場合は新規作成
            $newData = new format;
            $newData->id = $form['id'];
            $newData->start = $form['start'];
            $newData->end = $form['end'];
            $newData->save();
        }

        if ($existingData_mail) {
            // 条件に合致するデータが存在する場合は更新
            $existingData_mail->format_id = $form['id'];
            $existingData_mail->user_mailformat = $form['user_mailformat'];
            $existingData_mail->remind_mailformat = $form['remind_mailformat'];
            $existingData_mail->admin_mailformat = $form['admin_mailformat'];
            $existingData_mail->save();
        } else {
            // 条件に合致するデータが存在しない場合は新規作成
            $newData_mail = new mail;
            $newData_mail->format_id = $form['id'];
            $newData_mail->user_mailformat = $form['user_mailformat'];
            $newData_mail->remind_mailformat = $form['remind_mailformat'];
            $newData_mail->admin_mailformat = $form['admin_mailformat'];
            $newData_mail->save();
        }
            
        $formats = Format::all();//管理画面に戻る際に再度アンケートの一覧を取得

        return view('fs.conductankatepreview',['form' => $form,'csv_array' => $csv_array]);
    }

}
