<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
	
	public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
        $this->callbacks[] = function ($m) {
            $m->getHeaders()->addTextHeader('Content-type', 'Html');
        };
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

            // echo '<pre>';
            // print_r($this->details['body']);
            // exit();
        return $this->subject($this->details['subject'])
                    ->from($this->details['from'], $this->details['from'])
                    ->replyTo($this->details['Reply-To'], $this->details['Reply-To'])
                    ->view('sendmail')
                    ->with('details', $this->details['body']);
    }
}
