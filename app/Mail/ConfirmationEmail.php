<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->logo = storage_path("app/public/images/logo-placeholder.png");
    }

    public function build()
    {
        $address = 'BigBoatPeople@gmail.com';
        $subject = 'Your recent purchase';
        $name = 'The Big Boat People';

        return $this->view('emails.confirmation-email')
                    ->from($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->attach($this->logo, [
                        'as' => 'logo-placeholder.png',
                        'mime' => 'image/png',
                    ])
                    ->withPrice($this->data['price'])
                    ->withTransaction($this->data['transaction_id']);
    }
}