<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TemporaryPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agent;
    public $tempPassword;
    public $resetToken;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Aps  $aps
     * @param  string  $tempPassword
     * @param  string  $resetToken
     * @return void
     */
    public function __construct($agent, $tempPassword, $resetToken)
    {
        $this->agent = $agent;
        $this->tempPassword = $tempPassword;
        $this->resetToken = $resetToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Temporary Password & Password Reset Link')
                    ->markdown('emails.Password')
                    ->with([
                        'agent' => $this->agent,
                        'tempPassword' => $this->tempPassword,
                        'resetToken' => $this->resetToken,
                    ]);
    }
}
