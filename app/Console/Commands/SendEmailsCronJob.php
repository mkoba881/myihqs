<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
    public function handle()
    {
    $userMailFormat = 'mkoba881@gamil.com'; // 例として固定の値を代入
    $url_link = 'https://example.com'; // 例として固定の値を代入

    $mailController = new MailSendController();
    $mailController->cronMail($userMailFormat, $url_link); // 新しいメソッドを呼び出す

    $this->info('Custom emails sent successfully.');
    
    }
}
