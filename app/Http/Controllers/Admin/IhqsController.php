<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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


class IhqsController extends Controller
{
    public function add()
    {
        return view('admin.ihqs.selection');
    }

    public function analysis()
    {
        $formats = Format::pluck('name', 'id');
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
        $user_id = Auth::id(); // ログインユーザーの user_id を取得
        //dd($user_id);
        $answer = $request->all();//フォームの中身を全部とってきている
        unset($answer['_token']);
        //dd($answer);
        
        // 既存のレコードを更新するか新規作成するかを判断する
        $existingRecord = Answer::where('format_id', $answer['format_id'])
                                ->where('item_id', $answer['item_id'])
                                ->where('detail_id', $answer['detail_id'])
                                ->where('user_id', $user_id)
                                ->first();
    
        if ($existingRecord) {
            // 既存のレコードが存在する場合、更新する
            $existingRecord->update([
                'answer_result' => $answer['answer_result'],
                'priority' => $answer['priority'],
            ]);
        } else {
            // 既存のレコードが存在しない場合、新規作成する
            Answer::create([
                'format_id' => $answer['format_id'],
                'item_id' => $answer['item_id'],
                'detail_id' => $answer['detail_id'],
                'user_id' => $user_id,
                'answer_result' => $answer['answer_result'],
                'priority' => $answer['priority'],
            ]);
        }
        
        return view('fs.answerend');
    }

    public function make()
    {
        return view('fs.make');
    }
    

    public function create(Request $request)
    {
        // Validationを行う
        $request->validate(Format::getValidationRules($request->input('questionCount')));
    
        $form = $request->all();
        unset($form['_token']);
    
        $format_form = [
            'name' => $form['ankate_name'],
            'start' => $form['start'],
            'end' => $form['end'],
            'status' => $form['status']
        ];
    
        // フォーマットがすでに存在するかチェック
        $existingFormat = Format::where('name', $form['ankate_name'])
            ->where('start', $form['start'])
            ->where('end', $form['end'])
            ->first();
    
        if ($existingFormat) {
            // すでに同じフォーマットが存在する場合は更新
            $existingFormat->update($format_form);
            $format_id = $existingFormat->id;
        } else {
            // 新しいフォーマットを追加
            $format_id = DB::table('formats')->insertGetId($format_form);
        }
    
        $questionCount = $request->input('questionCount');
    
        for ($i = 1; $i <= $questionCount; $i++) {
            $item_form = [
                'name' => $form['question_name' . $i],
                'format_id' => $format_id,
                'sortorder' => $form['sortorder' . $i]
            ];
    
            // 質問項目がすでに存在するかチェック
            $existingItem = Item::where('format_id', $format_id)
                ->where('name', $form['question_name' . $i])
                ->first();
    
            if ($existingItem) {
                // すでに同じ質問項目が存在する場合は更新
                $existingItem->update($item_form);
                $item_id = $existingItem->id;
            } else {
                // 新しい質問項目を追加
                $item_id = DB::table('items')->insertGetId($item_form);
            }
    
            $detail_form = [
                'item_id' => $item_id,
                'question' => $form['question' . $i],
                'option1' => $form['option' . $i . '_1'],
                'option2' => $form['option' . $i . '_2'],
                'option3' => $form['option' . $i . '_3'],
                'option4' => $form['option' . $i . '_4'],
                'option5' => $form['option' . $i . '_5'],
                'priority' => $form['priority' . $i],
                'rf_url' => $form['rf_url' . $i]
            ];
    
            // 質問項目の詳細情報がすでに存在するかチェック
            $existingDetail = Detail::where('item_id', $item_id)
                ->orderBy('item_id', 'desc')
                ->first();
    
            if ($existingDetail) {
                // すでに同じ質問項目の詳細情報が存在する場合は更新
                $existingDetail->update($detail_form);
            } else {
                // 新しい質問項目の詳細情報を追加
                $file = $request->file('rf_image' . $i);
                if ($file) {
                    // ランダムなファイル名作成
                    $image = \Auth::user()->name . time() . hash_file('sha1', $file) . '.' . $file->getClientOriginalExtension();
                    $target_path = public_path('uploads');
                    $path = $file->storeAs('', $image, 'image');
                    $detail_form['rf_image'] = $image;
                } else {
                    $detail_form['rf_image'] = '';
                }
    
                DB::table('details')->insert($detail_form);
            }
        }
    
        $format = Format::find($format_id);
        $items = Item::where('format_id', $format_id)->get();
    
        // 質問の詳細情報を取得して配列に格納
        $details = [];
        foreach ($items as $item) {
            $detail = Detail::where('item_id', $item->id)->orderBy('item_id', 'desc')->first();
            $details[] = $detail;
        }
        //dd($details);
    
        return view('fs.makepreview', ['format' => $format, 'items' => $items, 'details' => $details]);
    }

    public function deleteankate(Request $request)  
    {
    
    $ankateIds = $request->input('ankate_ids');
    
    //dd($ankateIds);
    if (!empty($ankateIds)) {
        // チェックボックスで選択されたアンケートを取得し、statusを3に更新
        Format::whereIn('id', $ankateIds)->update(['status' => 3]);
    }    
        
        
    return redirect()->route('fs.management')->with('success', '選択したアンケートが削除されました。');
    }
    
    public function conductankate(Request $request)
    {
        $form = $request->all();//フォームの中身を全部とってきている
        $id = $form['id'];
        //dd($id);
        return view('fs.conductankate',compact('id'));
    }
    public function conductankatepreview(Request $request)
    {

        // Validationを行う
        $this->validate($request, Mail::$rules);
     
        $form = $request->all();//フォームの中身を全部とってきている
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        //dd($form);
        //dd($form["csvFile"]);
        
        $fileName = empty($argv[1]) ? $form["csvFile"] : $argv[1];
        //dd($fileName);
        
        $command = "file -i " . $fileName;
        $output = [];
        $status = "";
        exec($command, $output, $status);
        //dd($output);
        preg_match("/charset=(.*)/", $output[0], $charset);
        //dd($charset);

        $fp = fopen($form["csvFile"], 'r');
        //dd($fp);
        
        $csv_array = array();
        
        //配列へ格納
        while($line = fgetcsv($fp)){
          $csv_array[] = $line;
          //dd($line);
        }
        
        //変換処理
        if ($charset[1]=="utf-8") { }
        else{
            mb_convert_variables("UTF-8", "SJIS", $csv_array); 
        }
     
        fclose($fp);
        //dd($csv_array);
        return view('fs.conductankatepreview',compact('form','csv_array'));
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
