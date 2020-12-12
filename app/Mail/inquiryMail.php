<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class inquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;
    public $name;
    public $relations;
    public $content;
    
    
    public function __construct(array $data)
    {
        //
        foreach( $data as $key => $value ){
            $this->{$key} = $value;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->name . 'さんにお知らせがあります')->text('emails.inquiry');
        //subject()は件名を作成
    }
}
