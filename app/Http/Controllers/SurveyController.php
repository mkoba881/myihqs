<?php

namespace App\Http\Controllers;

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
        dd($id);
        //$hash="eyJpdiI6ImI3ZzFQR2NWMHBsVUVkSFd0Qll1R2c9PSIsInZhbHVlIjoiemM5NkorOUN6dzdrUUtXQ2dWaTRjQT09IiwibWFjIjoiNWUxNjNhOTk4NjBiY2Q4M2ZmYmE1YTIwOWJlNzQ0MjJhODk1MjIzYmNiNmNmMmYyMzU5ODIwY2ZlMWYzOWVkMiIsInRhZyI6IiJ9";
        //dd($hash);
        //$id = Crypt::decryptString($hash); // IDを複合化
        //dd($id);
        //$id = Hash::decrypt($hash); // ハッシュを復号化してIDを取得する
        //$decodedHash = urldecode($hash);
        //dd($decodedHash);
        // $id を使用してデータベースからアンケートを取得する処理
        return view('fs.answer', compact('id'));
    }
}
