<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Agent;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agent;
    public $securityKey;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
        $this->securityKey = $agent->securitykey;
        $this->loginUrl = url('/');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your KSG Agent Training Portal Security Key')
                    ->markdown('emails.agent_welcome')
                    ->with([
                        'agent' => $this->agent,
                        'securityKey' => $this->securityKey,
                        'loginUrl' => $this->loginUrl,
                    ]);
    }
}
