<?php

namespace App\Http\Controllers;
//namespace App\Mail;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Format;
use App\Models\Mail as MailModel; // Mailモデルのクラスに別名をつける
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
//use Illuminate\Support\Facades\Route;


//use App\Mail\TestMail;//メール送信用
use App\Mail\SampleMail;//メール送信用


class MailSendController extends Controller
{
    public function saveMailData(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);
        //dd($form);
        $existingData = Format::where('id', $form['id'])->first();
        //$existingData_mail = Mail::where('format_id', $form['id'])->first();
        $existingData_mail = MailModel::where('format_id', $form['id'])->first();


        
        if ($existingData) {
            // 条件に合致するデータが存在する場合は更新
            $existingData->start = $form['start'];
            $existingData->end = $form['end'];
            $existingData->save();
        } else {
            // 条件に合致するデータが存在しない場合は新規作成
            $newData = new format;
            $newData->id = $form['id'];
            $newData->start = $form['start'];
            $newData->end = $form['end'];
            $newData->save();
        }
        
        
        if ($existingData_mail) {
            // 条件に合致するデータが存在する場合は更新
            $existingData_mail->format_id = $form['id'];
            $existingData_mail->user_mailformat = $form['user_mailformat'];
            $existingData_mail->remind_mailformat = $form['remind_mailformat'];
            $existingData_mail->admin_mailformat = $form['admin_mailformat'];
            $existingData_mail->save();
        } else {
            // 条件に合致するデータが存在しない場合は新規作成
            $newData_mail = new MailModel;//暫定の名前
            $newData_mail->format_id = $form['id'];
            $newData_mail->user_mailformat = $form['user_mailformat'];
            $newData_mail->remind_mailformat = $form['remind_mailformat'];
            $newData_mail->admin_mailformat = $form['admin_mailformat'];
            $newData_mail->save();
        }
    }

    
    public function send(Request $request)
    {
        $form = $request->all();
        unset($form['_token']); 
        //dd($form);
        $csv_array = session('csv_array');
        //dd($csv_array);
        $id=$form['id'];
        
        $hash = urlencode(Crypt::encryptString($id));
        //dd($hash);
        $url_link = route('survey.answer', $hash);//URLの生成
        //dd($url_link);
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
        
        
        // メールデータの保存処理を呼び出す
        $this->saveMailData($request);

        
        $formats = Format::all();//管理画面に戻る際に再度アンケートの一覧を取得
        return view('fs.management',['formats' => $formats]);
    }
    
    public function cronMail($recipients, $userMailFormats, $formatId)
    {
        //dd($formatId);
        //dd($userMailFormats);
        //dd($recipients);
        // 送信先が存在する場合にメール送信
    
        
        $hostUrl = env('HOST_URL');
        //dd($awsConsoleUrl);
        $hash = urlencode(Crypt::encryptString($formatId));
        $url_link = $hostUrl . '/fs/answer/' . $hash;
        //$url_link = route('survey.answer', $hash);//URLの生成
        //dd($url_link);
    
       
        if (!empty($recipients)) {
            foreach ($recipients as $recipient) {
        
                Mail::to($recipient)->send(new SampleMail($userMailFormats, $url_link));

                echo 'Custom email sent successfully to: ' . $recipient . PHP_EOL;

            }
        } else {
            echo 'No emails to send.' . PHP_EOL;
            //$this->info('No emails to send.');
        }
    }
        
}
