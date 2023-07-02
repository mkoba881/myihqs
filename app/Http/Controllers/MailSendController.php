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
    
        //$recipient = 'mkoba881@gmail.com';
        $recipients = ['mkoba881@gmail.com', 'mkoba8814@gmail.com'];
        //Mail::to($recipients)->send(new SampleMail());
        
        foreach ($recipients as $recipient) {
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
