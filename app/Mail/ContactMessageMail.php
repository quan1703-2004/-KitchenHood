<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        // Tiêu đề mail phản ánh dịch vụ + người gửi
        $subject = 'Liên hệ mới: ' . ($this->data['service'] ?? 'Khách hàng') . ' - ' . ($this->data['firstName'] ?? '');

        return $this->subject($subject)
            ->view('emails.contact-message')
            ->with(['data' => $this->data]);
    }
}


