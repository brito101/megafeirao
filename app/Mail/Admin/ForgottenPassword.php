<?php

namespace LaraCar\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgottenPassword extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data) {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->replyTo($this->data['reply_email'], $this->data['reply_name'])
                        ->to($this->data['reply_email'], env('MAIL_FROM_NAME'))
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                        ->subject('Redefinição de senha: ' . $this->data['reply_name'])
                        ->markdown('emails.forgotten', [
                            'name' => $this->data['reply_name'],
                            'email' => $this->data['reply_email'],
                            'message' => $this->data['message']
        ]);
    }

}
