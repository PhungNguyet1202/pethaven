<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @param array $details
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Liên hệ mới từ website')
            ->html("
                <h2>Thông tin liên hệ:</h2>
                <p><strong>Tên:</strong> {$this->details['name']}</p>
                <p><strong>Email:</strong> {$this->details['email']}</p>
                <p><strong>Nội dung:</strong></p>
                <p>{$this->details['message']}</p>
            ");
    }
}
