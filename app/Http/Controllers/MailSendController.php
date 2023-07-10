<?php

namespace App\Http\Controllers;
//namespace App\Mail;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Format;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


//use App\Mail\TestMail;//メール送信用
use App\Mail\SampleMail;//メール送信用


class MailSendController extends Controller
{
    public function send(Request $request)
    {
        $form = $request->all();
        unset($form['_token']); 
        //dd($form);
        $csv_array = session('csv_array');
        //dd($csv_array);
        $id=$form['id'];
        //$hash = Crypt::encrypt($id);
        //$hash = Crypt::decryptString($hash);
        //dd($hash);
        //$hash = urlencode($hash); // URLエンコード
        //dd($hash);
        //$hash = urldecode($hash); // URLエンコード
        //dd($hash);
        //$hash = Crypt::decryptString($hash);
        
        //dd($hash);
        
        $hash = urlencode(Crypt::encryptString($id));
        //$hash = Str::random(50);
        //dd($hash);
        $url_link = route('survey.answer', $hash);
        //dd($link);
        // $dd_array=[$hash,$link];
        // dd($dd_array);
        
        $recipients = [];
        //dd($recipients);

        //CSVからメールアドレスの配列を作成
        foreach ($csv_array as $index => $data) {
            //dd($index);
            //dd($data);
            if ($index === 0) {
                continue; // ヘッダー行をスキップします
            }
        
            if (isset($data[1])) {
                $recipients[] = $data[1]; // メールアドレスの値を配列に追加します
            }
        }
        
        //dd($link);
        foreach ($recipients as $recipient) {
        //dd($recipient);
            Mail::to($recipient)->send(new SampleMail($form['user_mailformat'],$url_link));
        }

        
        $formats = Format::all();//管理画面に戻る際に再度アンケートの一覧を取得
        return view('fs.management',['formats' => $formats]);
    }

}
