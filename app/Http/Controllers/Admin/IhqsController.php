<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('fs.analysis');
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
        $existingRecord = Answer::where('user_id', $user_id)
                                ->where('detail_id', $answer['detail_id'])
                                ->first();
    
        if ($existingRecord) {
            // 既存のレコードが存在する場合、更新する
            $existingRecord->update([
                'answer_result' => '1',
                'priority' => '1',
            ]);
        } else {
            // 既存のレコードが存在しない場合、新規作成する
            Answer::create([
                'user_id' => $user_id,
                'detail_id' => $answer['detail_id'],
                'answer_result' => '1',
                'priority' => '1',
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
        $this->validate($request, Format::$rules);
        $this->validate($request, Item::$rules);
        $this->validate($request, Detail::$rules);
        //$format = new Format;
        //$detail = new Detail;
        
        
        
        $form = $request->all();//フォームの中身を全部とってきている
        
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        //dd($form);    
        $format_form=array(
            'name'=>$form['ankate_name'],'start'=>$form['start'],'end'=>$form['end'],'status'=>$form['status']
            );  
        //$format_formにcreated_atを追加すればよい。
        //dd($format_form);    
        // $array = array(
        // 'name' => $value,
        // );
        $format_id = \DB::table('formats')->insertGetId($format_form);
        //dd($format_id);
        // $format->fill($form);
        // $format->save();
        $item_form=array(
            'name'=>$form['question_name'],'format_id'=>$format_id,'sortorder'=>$form['sortorder']
            );
        $item_id = \DB::table('items')->insertGetId($item_form);
        //dd($item_id);
        $detail_form=array(
            'item_id'=>$item_id,'question'=>$form['question'],'option1'=>$form['option1'],'option2'=>$form['option2'],'option3'=>$form['option3'],'option4'=>$form['option4'],'option5'=>$form['option5'],'priority'=>$form['priority'],'rf_url'=>$form['rf_url']
            );
        
        // dd($detail_form);

        //$file =  $request->rf_image;
        $file =  $request->file('rf_image');
        // dd($file);
        // 画像のアップロード
        if($file){
            // ランダムなファイル名作成
            $image = \Auth::user()->name . time() . hash_file('sha1', $file) . '.' . $file->getClientOriginalExtension();
            $target_path = public_path('uploads');
            //dd($target_path);
            // アップロード処理
            $path=$file->storeAs('',$image,'image');

        }else{
            // 画像が選択されていなければ空文字をセット
            $image = '';
        }
        
        $detail_form['rf_image']=$image;
        
        //dd($detail_form);
        \DB::table('details')->insert($detail_form);
        
        $format = Format::find($format_id);
        $item= Item::find($item_id);
        $detail= Detail::where('item_id', $item_id)->orderBy('item_id','desc')->get()->first();//getとfirtstの意味を後程確認
        //dd($detail);
        return view('fs.makepreview',['format'=> $format,'item'=> $item,'detail'=> $detail]);
    }

    public function deleteankate()  
    {
        return view('fs.deleteankate');
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

        // $form=array(
        //     "user_mailformat" => $conduct_form['user_mailformat'],'remind_mailformat' => $conduct_form['remind_mailformat'],
        //     'admin_mailformat' => $conduct_form['admin_mailformat'],'start'=>$conduct_form['start'],'end'=>$conduct_form['end'],
        //     );
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
            
        //\DB::table('mails')->insert($mail_form);
        //\DB::table('formats')->insert($format_form);
        
        $formats = Format::all();//管理画面に戻る際に再度アンケートの一覧を取得

        return view('fs.conductankatepreview',['form' => $form,'csv_array' => $csv_array]);
    }

}
