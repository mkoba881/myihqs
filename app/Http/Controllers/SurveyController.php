<?php

namespace App\Http\Controllers;
use App\Models\Format;
use App\Models\Item;
use App\Models\Detail;

//use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SurveyController extends Controller
{
    public function show(Request $hash)
    {
    
        //dd($hash);
        $path = $hash->getPathInfo();//$hashの中からパス情報を抜き出す。
        $path = str_replace('/fs/answer/', '', $path);
        
        $id = Crypt::decryptString(urldecode($path));//URLでコードしてから復号化処理を実施する。
        //dd($id);
        // $id を使用してデータベースからアンケートを取得する処理
        //$format = Format::find($id); // IDを使用してFormatテーブルを取得
        $format = Format::where('id', $id)->get();
        //dd($format[0]['id']);
        $item = Item::where('format_id', $id)->get();
        //dd($item[0]['name']);
        $detail = Detail::where('item_id', $item[0]["id"])->get();
        //dd($detail);
        return view('fs.answer', compact('format','item','detail'));
    }
}
