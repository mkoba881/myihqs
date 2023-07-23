<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Format;
use App\Models\Mail;
use App\Http\Controllers\MailSendController; // メールコントローラーの名前に応じて修正


class SendEmailsCronJob extends Command
{
    protected $signature = 'send_emails';
    protected $description = 'Send emails using the MailSendController'; // メールコントローラーの名前に応じて修正

    /**
     * Execute the console command.
     *
     * @return int
     */
    
    // public function handle()
    // {
    //     // 本日の日付を取得
    //     $currentDate = now()->toDateString();

    //     // 有効なフォーマットIDとメールアドレスを取得
    //     $validFormats = Format::where('status', 2)
    //                           ->whereDate('start', '<=', $currentDate)
    //                           ->whereDate('end', '>=', $currentDate)
    //                           ->get();

    //     // メール送信先のメールアドレスを格納する配列
    //     $recipients = ['mkoba881@gmail.com', 'mkoba8814@gmail.com']; // 送信先メールアドレスをここで設定
    //     dd($validFormats);

    //     // メール本文の内容（$userMailFormat）はMailテーブルから取得する
    //     $userMailFormats = Mail::whereIn('format_id', $validFormats->pluck('id'))->pluck('user_mailformat', 'format_id');
        
    //     dd($userMailFormats);

    //     // 送信先が存在する場合にメール送信
    //     if (!empty($recipients)) {
    //         $mailController = new MailSendController();
    //         $mailController->cronMail($recipients, $userMailFormats); // MailSendControllerのcronMailメソッドに送信先メールアドレスとメール本文の配列を渡す

    //         $this->info('Custom emails sent successfully.');
    //     } else {
    //         $this->info('No emails to send.');
    //     }
    // }
    
    public function handle()
    {
    $userMailFormat = 'mkoba881@gmail.com'; // 例として固定の値を代入
    $url_link = 'https://example.com'; // 例として固定の値を代入
    //dd($userMailFormat);

    $mailController = new MailSendController();
    $mailController->cronMail($userMailFormat, $url_link); // 新しいメソッドを呼び出す

    $this->info('Custom emails sent successfully.');
    
    }
}
