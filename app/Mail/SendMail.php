<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $value;
    protected $key;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $key)
    {
        $this->value = $data;
        $this->key = $key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->key == 'reset_token') {
            return $this->view('mail.resetToken', [
                'data' => $this->value,
            ]);
        }
    }
}
