<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    
    public function build()
    {
        return $this->to($this->email)
            ->subject('テストタイトル')
            //->view('welcome')
            ->view('mail.testmail')
            ->with([
                'name' => $this->name,
            ]);
            
            
        // return $this->from('mkoba881@gmail.com','Test')
        //             ->subject('This is a test mail')
        //             ->view('mail.testmail');
}
    
    public function envelope()
    {
        return new Envelope(
            subject: 'Test Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }

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
