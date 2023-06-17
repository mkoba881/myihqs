<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下の1行を追記することで、Format Modelが扱えるようになる
use App\Models\Format;
use App\Models\Item;
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
        $this->validate($request, Item::$rules);
        $this->validate($request, Detail::$rules);
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
        // //後ほど確認
        // if (isset($form['rf_image'])) {
        //     $path = $request->file('rf_image')->store('public/image');
        //     $detail_form->rf_image = basename($path);
        // } else {
        //     $detail_form->rf_image = null;
        // }    
        
         $file =  $request->rf_image;
        // dd($file);
        // 画像のアップロード
        if($file){
            // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名作成
            $image = time() . $file->getClientOriginalName();
            //dd($image);
            // アップロードするフォルダ名取得
            //$target_path = public_path('uploads/myihqs');
            $target_path = public_path('uploads/');
            //dd($target_path);
            // アップロード処理
            $file->move($target_path, $image);
        }else{
            // 画像が選択されていなければ空文字をセット
            $image = '';
        }

        $detail_form['rf_image']=$image;
    
        //dd($detail_form);
        \DB::table('details')->insert($detail_form);
        
        // $result = \DB::table('detail')->insert($detail_form);
        // dd($result);
        // // $detail->fill($detail_form);
        // $detail->save();
        $format = Format::find($format_id);
        $item= Item::find($item_id);
        $detail= Detail::where('item_id', $item_id)->get()->first();//getとfirtstの意味を後程確認
        //dd($detail);
        return view('fs.makepreview',['format'=> $format,'item'=> $item,'detail'=> $detail]);
        // return redirect()->route("fs.makepreview",['format_id'=> 1]);
        // return redirect('/fs/makepreview')->with(compact('format_id'));
    }

    public function makepreview(Request $request)
    {
        //  $posts_format = Format::all();
        //  $posts_item = Item::all();
        //  $posts_detail = Detail::all();
        // dd($request);
        // // dd($format_id);
        $format = \App\Models\Format::find($format_id);
        dd($format);
         
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
