<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下の1行を追記することで、Format Modelが扱えるようになる
use App\Models\Format;
use App\Models\Detail;

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
        return view('fs.management');
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
        //$format = new Format;
        //$detail = new Detail;
        
        
        
        $form = $request->all();//フォームの中身を全部とってきている
        
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        //dd($form);    
        $format_form=array(
            'name'=>$form['ankate_name'],'start'=>$form['start'],'end'=>$form['end']
            );
        // $array = array(
        // 'name' => $value,
        // );
        $format_id = \DB::table('format')->insertGetId($format_form);
        //dd($format_id);

        // $format->fill($form);
        // $format->save();
        $item_form=array(
            'name'=>$form['question_name'],'format_id'=>$format_id,'sortorder'=>$form['sortorder']
            );
        $item_id = \DB::table('item')->insertGetId($item_form);
        //dd($item_id);
        $detail_form=array(
            'item_id'=>$item_id,'question'=>$form['question'],'option1'=>$form['option1'],'option2'=>$form['option2'],'option3'=>$form['option3'],'option4'=>$form['option4'],'option5'=>$form['option5'],'priority'=>$form['priority'],'rf_url'=>$form['rf_url'],'rf_image'=>$form['rf_image']
            );
        //dd($detail_form);
        \DB::table('detail')->insert($detail_form);
        
        // $detail->fill($detail_form);
        // $detail->save();
        
        
        return redirect('/fs/makepreview');
    }

    public function makepreview()
    {

    //  //ここの場所ってそもそも正しいのか確認する
    //     $this->validate($request, Format::$rules);
    //     $format = new Format;
    //     $form = $request->all();
    //     // フォームから送信されてきた_tokenを削除する
    //     unset($form['_token']);
    //     // データベースに保存する
    //     $format->fill($form);
    //     $format->save();
        return view('fs.makepreview');
    }
    public function deleteqn()  
    {
        return view('fs.deleteqn');
    }
    public function conductqn()
    {
        return view('fs.conductqn');
    }
    public function conductqnpreview()
    {
        return view('fs.conductqnpreview');
    }

}
