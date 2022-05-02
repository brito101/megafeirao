<?php

namespace LaraCar\Mail\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
            ->to($this->data['company'] ? $this->data['company'] : env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
            ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
            ->subject('Novo contato: ' . $this->data['reply_name'])
            ->markdown('emails.contact', [
                'name' => $this->data['reply_name'],
                'email' => $this->data['reply_email'],
                'cell' => $this->data['cell'],
                'message' => $this->data['message']
            ]);
    }
}
