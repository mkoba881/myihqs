<?php

namespace App\Http\Controllers;
//namespace App\Mail;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Format;
use App\Models\User;
use App\Models\SurveyParticipant;
use App\Models\Mail as MailModel; // Mailモデルのクラスに別名をつける
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
//use Illuminate\Support\Facades\Route;


//use App\Mail\TestMail;//メール送信用
use App\Mail\SampleMail;//メール送信用


class MailSendController extends Controller
{
    public function saveMailData(Request $request, array $csv_array)
    {
        $form = $request->all();
        unset($form['_token']);
    
        // CSVデータからメールアドレスの配列を作成
        $recipients = [];
        foreach ($csv_array as $index => $data) {
            if ($index === 0) {
                continue; // ヘッダー行をスキップします
            }
            if (isset($data[1])) {
                $recipients[] = $data[1]; // メールアドレスの値を配列に追加します
            }
        }
    
        // $recipientsループ内でユーザーIDを取得し、survey_participantsテーブルに保存
        foreach ($recipients as $recipient) {
            // ユーザーIDを取得するために、usersテーブルからメールアドレスを検索
            $user = User::where('email', $recipient)->first();
            //dd($recipient);
    
            // ユーザーIDが取得できた場合の処理
            if ($user) {
                $userId = $user->id;
            } else {
                // 新しいユーザーを作成
                //dd($recipient);
                $newUser = new User();
                //dd($newUser);
                $newUser->name = $csv_array[$index][0]; // CSVデータの該当する行の名前をユーザー名に設定
                $newUser->email = $recipient; // メールアドレスをUserテーブルのemail属性に設定
                $newUser->password = bcrypt('Password123!'); // 固定の初期パスワードを設定
                $newUser->save();
    
                // 新しいユーザーのIDを取得
                $userId = $newUser->id;
            }
            
             // 既存の組み合わせを検索
            $existingParticipant = SurveyParticipant::where('user_id', $userId)
                                                   ->where('format_id', $form['id'])
                                                   ->where('email', $recipient)
                                                   ->first();
            
            // 既存の組み合わせが存在しない場合のみ、survey_participantsテーブルに保存
            if (!$existingParticipant) {
                $surveyParticipant = new SurveyParticipant();
                $surveyParticipant->user_id = $userId;
                $surveyParticipant->format_id = $form['id'];
                $surveyParticipant->email = $recipient;
                $surveyParticipant->save();
            }
        }
        // 初期パスワードを設定するメソッドを呼び出す
        // $this->setPasswordForNewUsers();
    
        // Formatテーブルのデータ保存
        $existingData = Format::where('id', $form['id'])->first();
        if ($existingData) {
            // 条件に合致するデータが存在する場合は更新
            $existingData->start = $form['start'];
            $existingData->end = $form['end'];
            $existingData->save();
        } else {
            // 条件に合致するデータが存在しない場合は新規作成
            $newData = new Format;
            $newData->id = $form['id'];
            $newData->start = $form['start'];
            $newData->end = $form['end'];
            $newData->save();
        }
    
        // MailModelテーブルのデータ保存
        $existingData_mail = MailModel::where('format_id', $form['id'])->first();
        if ($existingData_mail) {
            // 条件に合致するデータが存在する場合は更新
            $existingData_mail->format_id = $form['id'];
            $existingData_mail->user_mailformat = $form['user_mailformat'];
            $existingData_mail->remind_mailformat = $form['remind_mailformat'];
            $existingData_mail->admin_mailformat = $form['admin_mailformat'];
            $existingData_mail->save();
        } else {
            // 条件に合致するデータが存在しない場合は新規作成
            $newData_mail = new MailModel;
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
        
        //dd($form);
        //dd($request);
        //dd($recipients);
        // メールデータの保存処理を呼び出す
        $this->saveMailData($request, $csv_array);
        
        
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
