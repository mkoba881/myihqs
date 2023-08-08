<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\SurveyParticipant;
use App\Models\Format;
use App\Models\Mail;
use App\Http\Controllers\MailSendController; // メールコントローラーの名前に応じて修正
use Illuminate\Support\Facades\Crypt;

class SendEmailsCronJob extends Command
{
    protected $signature = 'send_emails';
    protected $description = 'Send emails using the MailSendController'; // メールコントローラーの名前に応じて修正
    /**
     * Execute the console command.
     *
     * @return int
     */
     
    public function handle()
    {
        // 本日の日付を取得
        $currentDate = now()->toDateString();
        
        $validFormatIds = Format::where('status', 2)
                        ->whereDate('start', '<=', $currentDate)
                        ->whereDate('end', '>=', $currentDate)
                        ->pluck('id');

        // メール送信先のメールアドレスを格納する配列
        $recipients = ['mkoba881@gmail.com', 'mkoba8814@gmail.com']; // 送信先メールアドレスをここで設定
        //dd($validFormatIds);
        // Mailモデルを使用して$userMailFormatsを取得する
        $userMailFormats = Mail::whereIn('format_id', $validFormatIds)->pluck('user_mailformat', 'format_id')->toArray();
        
        // フォーマットごとにメール送信を行う
        foreach ($validFormatIds as $formatId) {
            $userMailFormat = $userMailFormats[$formatId] ?? null;
            if ($userMailFormat) {
                $this->sendMailToRecipients($userMailFormat, $recipients, $formatId);
            }
        }
    }
    
    private function sendMailToRecipients($userMailFormat, $recipients, $formatId)
    {
        
        $recipients = SurveyParticipant::where('format_id', $formatId)
            ->orderBy('email') // メールアドレスでソート
            ->pluck('email');
        //dd($recipients);
        
        // 送信先が存在する場合にメール送信
        if (!empty($recipients)) {
            $mailController = new MailSendController();
            $mailController->cronMail($recipients, $userMailFormat, $formatId);
            $this->info('Custom emails sent successfully.');
        } else {
            $this->info('No emails to send.');
        }
    }
    
}
