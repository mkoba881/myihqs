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
    
    //アンケート詳細テーブル用関数
    private function savedetail(Request $request)
    {

        // Validationを行う
        $this->validate($request, Detail::$rules);
        $detail = new Detail;
        $form_detail = $request->all();
        
        // フォームから送信されてきた_tokenを削除する
        unset($form_detail['_token']);
        
        // データベースに保存する、Formatモデルを使用する。
        $detail->fill($form_detail);
        $detail->save();
        
    }
    
    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Format::$rules);
        //$format = new Format;
        
        
        
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
        dd($item_id);
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
