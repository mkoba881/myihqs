<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下の1行を追記することで、Format Modelが扱えるようになる
use App\Models\Format;

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
        $format = new Format;
        $form = $request->all();
        
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        // データベースに保存する、Formatモデルを使用する。
        $format->fill($form);
        $format->save();

        //return view('fs/make');        
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
