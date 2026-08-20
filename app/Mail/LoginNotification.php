<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $device;

    public function __construct($email, $device)
    {
        $this->email = $email;
        $this->device = $device;
    }

    public function build()
    {
        return $this
            ->subject('Ultrasonic System Login Notification')
            ->view('emails.login_notification');
    }
}