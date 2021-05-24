<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $emailView;
    private $params;
    private $user;

    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $view
     * @param $user
     * @param $params
     */
    public function __construct($subject, $view, $user, $params)
    {
        $this->subject = $subject;
        $this->view = $view;
        $this->user = $user;
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->subject);
        $this->to($this->user->email, $this->user->name);

        return $this->markdown($this->view, ['params' => $this->params]);
    }
}
