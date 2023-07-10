<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SampleMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $userMailFormat;
    public $url_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userMailFormat,$url_link)
    {
        $this->userMailFormat = $userMailFormat;
        $this->url_link = $url_link;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
     
     public function build()
    {

        return $this->view('mail.testmail')
                    ->subject('Test Email')
                    ->with([
                        'name' => 'masato',
                        'message' => 'This is a sample email.',
                        'userMailFormat' => $this->userMailFormat,
                        'link' => $this->url_link,]);
    }
     
    public function envelope()
    {
        return new Envelope(
            subject: 'Sample Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'mail.testmail',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
