<?php

namespace App\Mail;

use App\Models\Pro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSubscriptionMessage extends Mailable
{
    use Queueable, SerializesModels;

    protected $pro;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pro $pro)
    {
        $this->pro = $pro;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.subscription', ['pro' => $this->pro]);
    }
}
