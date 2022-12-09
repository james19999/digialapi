<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;
     public $subject;
     public $msg;
     public $username;
     public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$subject,$msg,$username)
    {
        $this->subject = $subject;
        $this->msg = $msg;
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '',
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
            view: 'emails.contact',
            with:[
                 'email' =>$this->email,
                 'username' =>$this->username,
                 'subject' =>$this->subject,
                 'msg' =>$this->msg,
            ]
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