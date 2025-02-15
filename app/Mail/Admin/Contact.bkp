<?php

namespace LaraCar\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->data['reply_email'], $this->data['reply_name'])
            ->to(env('MAIL_TO_ADDRESS'), env('MAIL_TO_NAME'))
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Fale Conosco: ' . $this->data['reply_name'])
            ->markdown('emails.admin', [
                'name' => $this->data['reply_name'],
                'email' => $this->data['reply_email'],
                'cell' => $this->data['cell'],
                'message' => $this->data['message']
            ])->attachFromStorage($this->data['file']);
    }
}
