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
        //dd($currentDate);
        
        $validFormatIds = Format::where('status', 2)
                        ->whereDate('start', '<=', $currentDate)
                        ->whereDate('end', '>=', $currentDate)
                        ->pluck('id');

        // メール送信先のメールアドレスを格納する配列
        // Mailモデルを使用して$userMailFormatsを取得する
        $userMailFormats = Mail::whereIn('format_id', $validFormatIds)->pluck('user_mailformat', 'format_id')->toArray();
        
        // フォーマットごとにメール送信を行う
        // foreach ($validFormatIds as $formatId) {
        //     $userMailFormat = $userMailFormats[$formatId] ?? null;
        //     if ($userMailFormat) {
        //         $this->sendMailToRecipients($userMailFormat, $formatId);
        //     }
        // }
        
        //フォーマットごとに分岐してメール送信を行う
        foreach ($validFormatIds as $formatId) {
            $format = Format::find($formatId);
            //dd($format);
            $userMailFormat = $userMailFormats[$formatId] ?? null;
            
            // $format->start と $format->end を Carbon インスタンスに変換
            $formatStartDate = \Carbon\Carbon::parse($format->start)->format('Y-m-d');
            $formatEndDate = \Carbon\Carbon::parse($format->end)->format('Y-m-d');
            //dd($formatStartDate);
        
            // 本日の日付が開始日ならメールを送信
            if ($formatStartDate == $currentDate) {
                //dd($formatStartDate == $currentDate);
                $this->sendMailToRecipients($userMailFormat, $formatId);

            }
        
            // 本日の日付が終了日の一週間前ならメールを送信
            $oneWeekBeforeEndDate = now()->subWeek()->format('Y-m-d'); // 今日の日付から1週間前の日付を取得
            if ($currentDate == $oneWeekBeforeEndDate && $formatEndDate->diffInDays($formatStartDate) >= 7) {
                $this->sendMailToRecipients($userMailFormat, $formatId);

            }
        
            // 本日の日付が終了日の3日前ならメールを送信
            $threeDaysBeforeEndDate = now()->subDays(3)->format('Y-m-d'); // 今日の日付から3日前の日付を取得
            if ($currentDate == $threeDaysBeforeEndDate && $formatEndDate->diffInDays($formatStartDate) >= 3) {
                $this->sendMailToRecipients($userMailFormat, $formatId);

            }
        
            // 本日の日付が終了日の1日前ならメールを送信
            $oneDayBeforeEndDate = now()->subDay()->format('Y-m-d'); // 今日の日付から1日前の日付を取得
            if ($currentDate == $oneDayBeforeEndDate && $formatEndDate->diffInDays($formatStartDate) >= 1) {
                $this->sendMailToRecipients($userMailFormat, $formatId);

            }
        }

            //dd($oneWeekBeforeEndDate);
            //dd($threeDaysBeforeEndDate);
            //dd($oneDayBeforeEndDate);
            
        
        
    }
    
    private function sendMailToRecipients($userMailFormat, $formatId)
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
