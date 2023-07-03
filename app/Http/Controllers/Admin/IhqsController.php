<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下の1行を追記することで、Format Modelが扱えるようになる
use App\Models\Format;
use App\Models\Item;
use App\Models\Detail;
use App\Models\Mail;
use App\Models\User;

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

    public function answerend()
    {
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
        
        $conduct_form = $request->all();//フォームの中身を全部とってきている
        unset($conduct_form['_token']);
        //dd($conduct_form);
        //dd($conduct_form['id']);
        
        $format_form=array(
        'start'=>$conduct_form['start'],'end'=>$conduct_form['end'],
            );
            
        //dd($format_form);
        
        $mail_form=array(
            'format_id'=>$conduct_form['id'],'user_mailformat'=>$conduct_form['user_mailformat'],'remind_mailformat'=>$conduct_form['remind_mailformat'],
            'admin_mailformat'=>$conduct_form['admin_mailformat'],
            );
        
        dd($mail_form);

            
        
        \DB::table('mails')->insert($mail_form);
        
        $formats = Format::all();//管理画面に戻る際に再度アンケートの一覧を取得
        
        return view('fs.management',['formats' => $formats]);
    }

}
