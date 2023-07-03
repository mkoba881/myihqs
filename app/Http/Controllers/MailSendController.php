<?php

namespace App\Http\Controllers;
//namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Format;


//use App\Mail\TestMail;//メール送信用
use App\Mail\SampleMail;//メール送信用


class MailSendController extends Controller
{
    public function send(Request $request)
    {
        // $name = 'テスト ユーザー';
        // $email =  'mkoba881@gmail.com';
        $csv_array = session('csv_array');
        //dd($csv_array);
        
        //$recipients = ['mkoba881@gmail.com', 'mkoba8814@gmail.com'];
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
        
        //dd($recipients);
        //Mail::to($recipients)->send(new SampleMail());
        
        foreach ($recipients as $recipient) {
        //dd($recipient);
            Mail::to($recipient)->send(new SampleMail($recipient));
        }

        //Mail::send(new TestMail($name, $email));
        //ひとまず送信できたやつ
        // Mail::send('mail.testmail', [
        //     'name' => $name,
        // ], function ($message) use ($email) {
        //     $message->to($email)
        //         ->subject('テストタイトル');
        // });
        $formats = Format::all();//管理画面に戻る際に再度アンケートの一覧を取得
        return view('fs.management',['formats' => $formats]);
    }

}
